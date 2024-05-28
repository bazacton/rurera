<?php

namespace App\Http\Controllers\Panel;

use App\Bitwise\UserLevelOfTraining;
use App\Http\Controllers\Controller;
use App\Mixins\RegistrationPackage\UserPackage;
use App\Models\Category;
use App\Models\DeleteAccountRequest;
use App\Models\Meeting;
use App\Models\Newsletter;
use App\Models\Region;
use App\Models\ReserveMeeting;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\UserBank;
use App\Models\UserMeta;
use App\Models\UserOccupation;
use App\Models\UserSelectedBank;
use App\Models\UserSelectedBankSpecification;
use App\Models\UserZoomApi;
use App\Models\StudentLinkRequests;
use App\Models\UserParentLink;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Classes;
use App\Models\Schools;
use App\Models\JoinRequests;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Intervention\Image\Facades\Image;
use App\Models\Accounting;

class UserController extends Controller
{
    public function setting($step = 1)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();

        if( isset( $_GET['qrcode'] ) ) {
            // Generate QR code
            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new ImagickImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qrCode = $writer->writeString('Your QR code data here');

            // Add logo to the QR code
            $qrCodeImage = Image::make($qrCode);
            $logo = Image::make('path_to_your_logo.png');

            // Calculate position for the logo in the center
            $logoWidth = $logo->width();
            $logoHeight = $logo->height();
            $qrCodeImage->insert($logo, 'center');

            // Save or output the final QR code image
            $qrCodeImage->save('path_to_save_final_qr_code.png');
        }


        if (!empty($user->location)) {
            $user->location = \Geo::getST_AsTextFromBinary($user->location);

            $user->location = \Geo::get_geo_array($user->location);
        }

        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();



        $schools = Schools::where('status', 'active')->get();

        $userMetas = $user->userMetas;

        if (!empty($userMetas)) {
            foreach ($userMetas as $meta) {
                $user->{$meta->name} = $meta->value;
            }
        }

        $occupations = $user->occupations->pluck('category_id')->toArray();


        $userLanguages = getGeneralSettings('user_languages');
        if (!empty($userLanguages) and is_array($userLanguages)) {
            $userLanguages = getLanguages($userLanguages);
        } else {
            $userLanguages = [];
        }

        $countries = null;
        $provinces = null;
        $cities = null;
        $districts = null;
        if ($step == 9) {
            $countries = Region::select(DB::raw('*, ST_AsText(geo_center) as geo_center'))
                ->where('type', Region::$country)
                ->get();

            if (!empty($user->country_id)) {
                $provinces = Region::select(DB::raw('*, ST_AsText(geo_center) as geo_center'))
                    ->where('type', Region::$province)
                    ->where('country_id', $user->country_id)
                    ->get();
            }

            if (!empty($user->province_id)) {
                $cities = Region::select(DB::raw('*, ST_AsText(geo_center) as geo_center'))
                    ->where('type', Region::$city)
                    ->where('province_id', $user->province_id)
                    ->get();
            }

            if (!empty($user->city_id)) {
                $districts = Region::select(DB::raw('*, ST_AsText(geo_center) as geo_center'))
                    ->where('type', Region::$district)
                    ->where('city_id', $user->city_id)
                    ->get();
            }
        }

        $userBanks = UserBank::query()
            ->with([
                'specifications'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
			
			
		$accountings = Accounting::where('user_id', $user->id)
		->where('system', false)
		->where('tax', false)
		->where('type', 'deduction')
		->with([
			'subscribe',
		])
		->orderBy('created_at', 'desc')
		->orderBy('id', 'desc')
		->paginate(500);

        $data = [
            'pageTitle'     => trans('panel.settings'),
            'user'          => $user,
            'categories'    => $categories,
            'educations'    => $userMetas->where('name', 'education'),
            'experiences'   => $userMetas->where('name', 'experience'),
            'occupations'   => $occupations,
            'userLanguages' => $userLanguages,
            'currentStep'   => $step,
            'countries'     => $countries,
            'provinces'     => $provinces,
            'cities'        => $cities,
            'districts'     => $districts,
            'userBanks'     => $userBanks,
            'schools'     => $schools,
            'accountings'     => $accountings,

        ];

        return view(getTemplate() . '.panel.setting.index', $data);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();

        $step = $data['step'] ?? 1;;
        $rules = [
            'identity_scan' => 'required_with:account_type',
            'bio'           => 'nullable|string|min:3|max:48',
        ];

        if ($step == 1) {
            $registerMethod = getGeneralSettings('register_method') ?? 'mobile';

            $rules = array_merge($rules, [
                'full_name' => 'required|string',
                'email'     => (($registerMethod == 'email') ? 'required' : 'nullable') . '|email|max:255|unique:users,email,' . $user->id,
                'mobile'    => (($registerMethod == 'mobile') ? 'required' : 'nullable') . '|numeric|unique:users,mobile,' . $user->id,
            ]);
        }

        //$this->validate($request, $rules);


        if (!empty($user)) {

            $updateData = [];
            if (!empty($data['profile_image'])) {
                $profileImage = $this->createImage($user, $data['profile_image']);
                $updateData['avatar'] = $profileImage;
            }
			
			

            //Temporary
            $updateData['user_life_lines'] = 5;

            if (!empty($updateData)) {
                $user->update($updateData);
            }

            if (!empty($data['secret_word'])) {
                $user->update([
                    'secret_word' => User::generatePassword($data['secret_word']),
                    //Temporary
                    'user_timetables_levels' => ''
                ]);
            }
            $user->update([
                'school_preference_1' => isset( $data['school_preference_1'] )? $data['school_preference_1'] : 0,
                'school_preference_2' => isset( $data['school_preference_2'] )? $data['school_preference_2'] : 0,
                'school_preference_3' => isset( $data['school_preference_3'] )? $data['school_preference_3'] : 0,
                //'first_name' => isset( $data['first_name'] )? $data['first_name'] : '',
                //'last_name' => isset( $data['last_name'] )? $data['last_name'] : '',
                //'full_name' => isset( $data['first_name'] )? $data['first_name'].' '.$data['last_name'] : '',
				'display_name' => isset( $data['display_name'] )? $data['display_name'] : $user->first_name.' '.$$user->last_name,
                'gold_member' => isset( $data['gold_member'] )? $data['gold_member'] : 0,
            ]);

			
			$userUpdateData = array();
			
			if (isset( $data['first_name'] ) && $data['first_name'] != '') {
				$userUpdateData['first_name'] = $data['first_name'];
            }
			if (isset( $data['last_name'] ) && $data['last_name'] != '') {
				$userUpdateData['last_name'] = $data['last_name'];
            }
			
			if (isset( $data['weekly_summary_emails'] ) && $data['weekly_summary_emails'] != '') {
				$userUpdateData['weekly_summary_emails'] = $data['weekly_summary_emails'];
            }
			
			if (isset( $data['user_preference'] ) && $data['user_preference'] != '') {
				$userUpdateData['user_preference'] = $data['user_preference'];
            }
			
			if (!empty($userUpdateData)) {
                $user->update($userUpdateData);
            }

            $url = '/panel/setting';

            $toastData = [
                'title'  => trans('public.request_success'),
                'msg'    => trans('panel.user_setting_success'),
                'status' => 'success'
            ];
            return redirect($url)->with(['toast' => $toastData]);
        }
        abort(404);
    }

    public function update_avatar(Request $request)
    {
        $user = auth()->user();

        $avatarSettings = isset( $_POST['avatarSettings'] )? $_POST['avatarSettings'] : '';
        $avatarColorsSettings = isset( $_POST['avatarColorsSettings'] )? $_POST['avatarColorsSettings'] : '';
        $user_avatar_settings = array(
            'avatar_settings' => $avatarSettings,
            'avatar_color_settings' => $avatarColorsSettings
        );
        $file = svgAvatars_validate_filename( $_POST['filename'] );
        $data =  svgAvatars_validate_imagedata( $_POST['imgdata'], $file['type'] );

        if ( $file['type'] === 'png' ) {
            $data = base64_decode( $data );
            $file_name = $file['name'] . '.png';
        } elseif ( $file['type'] === 'svg' ) {
            $data = stripcslashes( $data );
            $file_name = $file['name'] . '.svg';

            //file_put_contents( $uploads_dir . $file_name, $data );
            //file_put_contents('avatar/'.$file_name, $data);
        }
        file_put_contents('avatar/'.$file_name, $data);
        $user->update([
           'avatar' => '/avatar/'.$file_name,
           'user_avatar_settings' => json_encode($user_avatar_settings)
       ]);

    }

    public function generateEmoji(Request $request)
    {
        $emojisList = emojisList();

        $UsedEmojisList = User::where('role_id', '=', 1)->where('status', 'active')->where('login_emoji', '!=', '')->pluck('login_emoji')->toArray();

        do {
            // Shuffle the emojis list
            shuffle($emojisList);

            // Take the first 6 emojis as random indexes
            $random_offset = rand(0,60);
            $generatedIndexes = array_slice($emojisList, $random_offset, 6);

            // Create a string by concatenating the randomly selected emojis
            $generatedString = implode('', $generatedIndexes);

        } while (in_array($generatedString, $UsedEmojisList));

        $user_id = $request->input('user_id');
        if( $user_id > 0) {
            $user = User::find($user_id);
        }else{
            $user = auth()->user();
        }
        $user->update([
            'login_emoji' => $generatedString
        ]);
        $response = '<h3 class="mb-30">Please Store this Emojis Somewhere to use for login!</h3><div class="emoji-icons" style="min-height:auto;">';
            if( !empty( $generatedIndexes )  ){
                foreach( $generatedIndexes as $emojiIndex){
                    $response .= '<a id="icon1" href="javascript:;" class="emoji-icon"><img src="/assets/default/svgs/emojis/'.$emojiIndex.'.svg"></a>';
                }
            }
        $response .= '</div>';

        echo $response;exit;

    }

    public function generatePin(Request $request)
    {
        $loginList = array(0,1,2,3,4,5,6,7,8,9);

        $UsedLoginList = User::where('role_id', '=', 1)->where('status', 'active')->where('login_pin', '!=', '')->pluck('login_pin')->toArray();

        do {
            // Shuffle the emojis list
            shuffle($loginList);

            // Take the first 6 emojis as random indexes
            $random_offset = rand(0,5);
            $generatedIndexes = array_slice($loginList, $random_offset, 6);

            // Create a string by concatenating the randomly selected emojis
            $generatedString = implode('', $generatedIndexes);

        } while (in_array($generatedString, $UsedLoginList));

        $user_id = $request->input('user_id');
        if( $user_id > 0) {
            $user = User::find($user_id);
        }else{
            $user = auth()->user();
        }
        $user->update([
            'login_pin' => $generatedString
        ]);
        $response = '<h3 class="mb-30">Please Store this Pin Somewhere to use for login!</h3>';
        $response .= '<br><strong>'.$generatedString.'</strong>';

        echo $response;exit;

    }



    private function handleNewsletter($email, $user_id, $joinNewsletter)
    {
        $check = Newsletter::where('email', $email)->first();

        if ($joinNewsletter) {
            if (empty($check)) {
                Newsletter::create([
                    'user_id'    => $user_id,
                    'email'      => $email,
                    'created_at' => time()
                ]);
            } else {
                $check->update([
                    'user_id' => $user_id,
                ]);
            }

            $newsletterReward = RewardAccounting::calculateScore(Reward::NEWSLETTERS);
            RewardAccounting::makeRewardAccounting($user_id, $newsletterReward, Reward::NEWSLETTERS, $user_id, true);
        } elseif (!empty($check)) {
            $reward = RewardAccounting::where('user_id', $user_id)
                ->where('item_id', $user_id)
                ->where('type', Reward::NEWSLETTERS)
                ->where('status', RewardAccounting::ADDICTION)
                ->first();

            if (!empty($reward)) {
                $reward->delete();
            }

            $check->delete();
        }
    }

    public function createImage($user, $img)
    {
        $folderPath = "/" . $user->id . '/avatar/';

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = uniqid() . '.' . $image_type;

        Storage::disk('public')->put($folderPath . $file, $image_base64);

        return Storage::disk('public')->url($folderPath . $file);
    }

    public function storeMetas(Request $request)
    {
        $data = $request->all();

        if (!empty($data['name']) and !empty($data['value'])) {

            if (!empty($data['user_id'])) {
                $organization = auth()->user();
                $user = User::where('id', $data['user_id'])
                    ->where('organ_id', $organization->id)
                    ->first();
            } else {
                $user = auth()->user();
            }

            UserMeta::create([
                'user_id' => $user->id,
                'name'    => $data['name'],
                'value'   => $data['value'],
            ]);

            return response()->json([
                'code' => 200
            ], 200);
        }

        return response()->json([], 422);
    }

    public function updateMeta(Request $request, $meta_id)
    {
        $data = $request->all();
        $user = auth()->user();

        if (!empty($data['user_id'])) {
            $checkUser = User::find($data['user_id']);

            if ((!empty($checkUser) and ($data['user_id'] == $user->id) or $checkUser->organ_id == $user->id)) {
                $meta = UserMeta::where('id', $meta_id)
                    ->where('user_id', $data['user_id'])
                    ->where('name', $data['name'])
                    ->first();

                if (!empty($meta)) {
                    $meta->update([
                        'value' => $data['value']
                    ]);

                    return response()->json([
                        'code' => 200
                    ], 200);
                }

                return response()->json([
                    'code' => 403
                ], 200);
            }
        }

        return response()->json([], 422);
    }

    public function deleteMeta(Request $request, $meta_id)
    {
        $data = $request->all();
        $user = auth()->user();

        if (!empty($data['user_id'])) {
            $checkUser = User::find($data['user_id']);

            if (!empty($checkUser) and ($data['user_id'] == $user->id or $checkUser->organ_id == $user->id)) {
                $meta = UserMeta::where('id', $meta_id)
                    ->where('user_id', $data['user_id'])
                    ->first();

                $meta->delete();

                return response()->json([
                    'code' => 200
                ], 200);
            }
        }

        return response()->json([], 422);
    }

    public function manageUsers(Request $request, $user_type)
    {
        $valid_type = [
            'instructors',
            'students'
        ];
        $organization = auth()->user();

        if ($organization->isOrganization() and in_array($user_type, $valid_type)) {
            if ($user_type == 'instructors') {
                $query = $organization->getOrganizationTeachers();
            } else {
                $query = $organization->getOrganizationStudents();
            }

            $activeCount = deepClone($query)->where('status', 'active')->count();
            $verifiedCount = deepClone($query)->where('verified', true)->count();
            $inActiveCount = deepClone($query)->where('status', 'inactive')->count();

            $from = $request->get('from', null);
            $to = $request->get('to', null);
            $name = $request->get('name', null);
            $email = $request->get('email', null);
            $type = request()->get('type', null);

            if (!empty($from) and !empty($to)) {
                $from = strtotime($from);
                $to = strtotime($to);

                $query->whereBetween('created_at', [
                    $from,
                    $to
                ]);
            } else {
                if (!empty($from)) {
                    $from = strtotime($from);

                    $query->where('created_at', '>=', $from);
                }

                if (!empty($to)) {
                    $to = strtotime($to);

                    $query->where('created_at', '<', $to);
                }
            }

            if (!empty($name)) {
                $query->where('full_name', 'like', "%$name%");
            }

            if (!empty($email)) {
                $query->where('email', $email);
            }

            if (!empty($type)) {
                if (in_array($type, [
                    'active',
                    'inactive'
                ])) {
                    $query->where('status', $type);
                } elseif ($type == 'verified') {
                    $query->where('verified', true);
                }
            }

            $users = $query->orderBy('created_at', 'desc')
                ->paginate(10);

            $data = [
                'pageTitle'     => trans('public.' . $user_type),
                'user_type'     => $user_type,
                'organization'  => $organization,
                'users'         => $users,
                'activeCount'   => $activeCount,
                'inActiveCount' => $inActiveCount,
                'verifiedCount' => $verifiedCount,
            ];

            return view(getTemplate() . '.panel.manage.' . $user_type, $data);
        }

        abort(404);
    }

    public function createUser($user_type)
    {
        $valid_type = [
            'instructors',
            'students'
        ];
        $organization = auth()->user();

        if ($organization->isOrganization() and in_array($user_type, $valid_type)) {

            $packageType = $user_type == 'instructors' ? 'instructors_count' : 'students_count';
            $userPackage = new UserPackage();
            $userAccountLimited = $userPackage->checkPackageLimit($packageType);

            if ($userAccountLimited) {
                session()->put('registration_package_limited', $userAccountLimited);

                return redirect()->back();
            }

            $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();

            $userLanguages = getGeneralSettings('user_languages');
            if (!empty($userLanguages) and is_array($userLanguages)) {
                $userLanguages = getLanguages($userLanguages);
            }

            $data = [
                'pageTitle'       => trans('public.new') . ' ' . trans('quiz.' . $user_type),
                'new_user'        => true,
                'user_type'       => $user_type,
                'user'            => $organization,
                'categories'      => $categories,
                'organization_id' => $organization->id,
                'userLanguages'   => $userLanguages,
                'currentStep'     => 1,
            ];

            return view(getTemplate() . '.panel.setting.index', $data);
        }

        abort(404);
    }

    public function storeUser(Request $request, $user_type)
    {
        $valid_type = [
            'instructors',
            'students'
        ];
        $organization = auth()->user();

        if ($organization->isOrganization() and in_array($user_type, $valid_type)) {
            $this->validate($request, [
                'email'     => 'required|string|email|max:255|unique:users',
                'full_name' => 'required|string',
                'mobile'    => 'required|numeric|unique:users',
                'password'  => 'required|confirmed|min:6',
            ]);

            $data = $request->all();
            $role_name = ($user_type == 'instructors') ? Role::$teacher : Role::$user;
            $role_id = ($user_type == 'instructors') ? Role::getTeacherRoleId() : Role::getUserRoleId();

            $referralSettings = getReferralSettings();
            $usersAffiliateStatus = (!empty($referralSettings) and !empty($referralSettings['users_affiliate_status']));

            $user = User::create([
                'role_name'      => $role_name,
                'role_id'        => $role_id,
                'email'          => $data['email'],
                'organ_id'       => $organization->id,
                'password'       => Hash::make($data['password']),
                'full_name'      => $data['full_name'],
                'mobile'         => $data['mobile'],
                'language'       => $data['language'],
                'timezone'       => $data['timezone'],
                'currency'       => $data['currency'] ?? null,
                'affiliate'      => $usersAffiliateStatus,
                'newsletter'     => (!empty($data['join_newsletter']) and $data['join_newsletter'] == 'on'),
                'public_message' => (!empty($data['public_messages']) and $data['public_messages'] == 'on'),
                'created_at'     => time()
            ]);


            $notifyOptions = [
                '[organization.name]' => $organization->get_full_name(),
                '[u.name]'            => $user->get_full_name(),
                '[u.role]'            => trans("update.role_{$user->role_name}"),
            ];
            sendNotification('new_user_item_rating', $notifyOptions, 1);


            return redirect('/panel/manage/' . $user_type . '/' . $user->id . '/edit');
        }

        abort(404);
    }

    public function editUser($user_type, $user_id, $step = 1)
    {
        $valid_type = [
            'instructors',
            'students'
        ];
        $organization = auth()->user();

        if ($organization->isOrganization() and in_array($user_type, $valid_type)) {
            $user = User::where('id', $user_id)
                ->where('organ_id', $organization->id)
                ->first();

            if (!empty($user)) {
                $categories = Category::where('parent_id', null)
                    ->with('subCategories')
                    ->get();
                $userMetas = $user->userMetas;

                $occupations = $user->occupations->pluck('category_id')->toArray();

                $userLanguages = getGeneralSettings('user_languages');
                if (!empty($userLanguages) and is_array($userLanguages)) {
                    $userLanguages = getLanguages($userLanguages);
                }

                $data = [
                    'organization_id' => $organization->id,
                    'edit_new_user'   => true,
                    'user'            => $user,
                    'user_type'       => $user_type,
                    'categories'      => $categories,
                    'educations'      => $userMetas->where('name', 'education'),
                    'experiences'     => $userMetas->where('name', 'experience'),
                    'pageTitle'       => trans('panel.settings'),
                    'occupations'     => $occupations,
                    'userLanguages'   => $userLanguages,
                    'currentStep'     => $step,
                ];

                return view(getTemplate() . '.panel.setting.index', $data);
            }
        }

        abort(404);
    }

    public function deleteUser($user_type, $user_id)
    {
        $valid_type = [
            'instructors',
            'students'
        ];
        $organization = auth()->user();

        if ($organization->isOrganization() and in_array($user_type, $valid_type)) {
            $user = User::where('id', $user_id)
                ->where('organ_id', $organization->id)
                ->first();

            if (!empty($user)) {
                $user->update([
                    'organ_id' => null
                ]);

                return response()->json([
                    'code' => 200
                ]);
            }
        }

        return response()->json([], 422);
    }

    public function search(Request $request)
    {
        $term = $request->get('term');
        $option = $request->get('option', null);
        $user = auth()->user();

        if (!empty($term)) {
            $query = User::select('id', 'full_name')
                ->where(function ($query) use ($term) {
                    $query->where('full_name', 'like', '%' . $term . '%');
                    $query->orWhere('email', 'like', '%' . $term . '%');
                    $query->orWhere('mobile', 'like', '%' . $term . '%');
                })
                ->where('id', '<>', $user->id)
                ->whereNotIn('role_name', ['admin']);

            if (!empty($option) and $option == 'just_teachers') {
                $query->where('role_name', 'teacher');
            }

            if ($option == "just_student_role") {
                $query->where('role_name', Role::$user);
            }

            $users = $query->get();

            return response()->json($users, 200);
        }

        return response('', 422);
    }

    public function contactInfo(Request $request)
    {
        $this->validate($request, [
            'user_id'   => 'required',
            'user_type' => 'required|in:student,instructor',
        ]);

        $user = User::find($request->get('user_id'));

        if (!empty($user)) {
            $itemId = $request->get('item_id');
            $userType = $request->get('user_type');
            $description = null;
            $location = null;

            if (!empty($itemId)) {
                $reserve = ReserveMeeting::where('id', $itemId)
                    ->where(function ($query) use ($user) {
                        $query->where('user_id', $user->id);

                        if (!empty($user->meeting)) {
                            $query->orWhere('meeting_id', $user->meeting->id);
                        }
                    })->first();

                if (!empty($reserve)) {
                    if ($userType == 'student') {
                        $description = $reserve->description;
                    } elseif (!empty($reserve->meetingTime)) {
                        $description = $reserve->meetingTime->description;
                    }

                    if ($reserve->meeting_type == 'in_person') {
                        $userMetas = $user->userMetas;

                        if (!empty($userMetas)) {
                            foreach ($userMetas as $meta) {
                                if ($meta->name == 'address') {
                                    $location = $meta->value;
                                }
                            }
                        }
                    }
                }
            }

            return response()->json([
                'code'        => 200,
                'avatar'      => $user->getAvatar(),
                'name'        => $user->get_full_name(),
                'email'       => !empty($user->email) ? $user->email : '-',
                'phone'       => !empty($user->mobile) ? $user->mobile : '-',
                'description' => $description,
                'location'    => $location,
            ], 200);
        }

        return response()->json([], 422);
    }

    public function offlineToggle(Request $request)
    {
        $user = auth()->user();

        $message = $request->get('message');
        $toggle = $request->get('toggle');
        $toggle = (!empty($toggle) and $toggle == 'true');

        $user->offline = $toggle;
        $user->offline_message = $message;

        $user->save();

        return response()->json([
            'code' => 200
        ], 200);
    }

    public function deleteAccount(Request $request)
    {
        $user = auth()->user();

        if (!empty($user)) {
            DeleteAccountRequest::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'created_at' => time()
            ]);

            return response()->json([
                'code'        => 200,
                'title'       => trans('public.request_success'),
                'text'        => trans('update.delete_account_request_stored_msg'),
                'dont_reload' => true
            ]);
        }

        abort(403);
    }

    public function getUserInfo($id)
    {
        $user = User::query()->select('id', 'full_name', 'avatar')
            ->where('id', $id)
            ->first();

        if (!empty($user)) {
            $user->avatar = $user->getAvatar(40);

            return response()->json([
                'user' => $user
            ]);
        }

        return response()->json([], 422);
    }

    /*
     * Update User Details
     */
    public function updateUser(Request $request)
    {
        $user = auth()->user();
        $full_name = $request->input('full_name');
        $email = $request->input('email');
        $country_label = $request->input('country_label');
        $postal_code = $request->input('postal_code');
        $time_zone = $request->input('time_zone');
        $complete_address = $request->input('complete_address');
        $userObj = User::find($user->id);

        $userObj->update([
            'full_name'     => $full_name,
            'email'         => $email,
            'country_label' => $country_label,
            'postal_code'   => $postal_code,
            'time_zone'     => $time_zone,
            'address'       => $complete_address,
        ]);

        $toastData = [
            'title'  => '',
            'msg'    => 'Updated Successfully',
            'status' => 'success'
        ];
        return back()->with(['toast' => $toastData]);

    }

    /*
     * Update User Password
     */
    public function updateUserPassword(Request $request)
    {
        $user = auth()->user();
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');
        $new_re_password = $request->input('new_re_password');
        $userObj = User::find($user->id);
        if (!Hash::check($old_password, $userObj->password)) {
            $toastData = [
                'title'  => '',
                'msg'    => 'Password Incorrect',
                'status' => 'error'
            ];
        } else if ($new_password != $new_re_password) {
            $toastData = [
                'title'  => '',
                'msg'    => 'Password does not match!',
                'status' => 'error'
            ];
        } else {

            $userObj->update([
                'password' => User::generatePassword($new_password),
            ]);
            $toastData = [
                'title'  => '',
                'msg'    => 'Updated Successfully',
                'status' => 'success'
            ];
        }


        return back()->with(['toast' => $toastData]);

    }

    /*
     * Update User Class
     */
    public function connectUserClass(Request $request)
    {
        $user = auth()->user();
        $connect_user_id = $request->input('user_id');
        $class_code = $request->input('class_code');
        $userObj = User::find($connect_user_id);
        $classObj = Classes::where('class_code', $class_code)->first();
        if( isset( $classObj->id ) ) {
            $parentClassObj = Classes::where('id', $classObj->parent_id)->first();

            JoinRequests::create([
                'user_id'    => $connect_user_id,
                'section_id'    => $classObj->id,
                'status'      => 'active',
                'action_by'      => 0,
                'created_at' => time()
            ]);
            /*$userObj->update([
                'year_id'    => $classObj->category_id,
                'class_id'   => $classObj->parent_id,
                'section_id' => $classObj->id,
                'timestables_no' => $parentClassObj->timestables_no,
            ]);
            $userObj->update([
                'year_id'    => $classObj->category_id,
                'class_id'   => $classObj->parent_id,
                'section_id' => $classObj->id,
                'timestables_no' => $parentClassObj->timestables_no,
            ]);*/
            $toastData = [
                'title'  => '',
                'msg'    => 'Join Request Successfully Sent',
                'status' => 'success'
            ];
        }else{
            $toastData = [
                'title'  => '',
                'msg'    => 'Incorrect Class Code',
                'status' => 'error'
            ];
        }
        echo json_encode($toastData);exit;

    }
	
	/*
     * Connect Student
     */
    public function connectStudent(Request $request)
    {
        $user = auth()->user();
        $username = $request->input('username');
        $userObj = User::where('username', $username)->first();
        if( isset( $userObj->id ) ) {
            StudentLinkRequests::create([
                'student_id'    => $userObj->id,
                'request_to'    => $userObj->parent_id,
                'status'      => 'active',
                'created_by'      => $user->id,
                'created_at' => time()
            ]);
            $toastData = [
                'title'  => '',
                'msg'    => 'Student Link Request Successfully Sent',
                'status' => 'success'
            ];
        }else{
            $toastData = [
                'title'  => '',
                'msg'    => 'No student found!',
                'status' => 'error'
            ];
        }
        echo json_encode($toastData);exit;

    }
	/*
     * Student Request Action
     */
    public function requestAction(Request $request)
    {
        $user = auth()->user();
        $request_type = $request->input('request_type');
        $request_id = $request->input('request_id');
		
		$requestObj = StudentLinkRequests::find($request_id);
		$requestObj->update(['status' => $request_type, 'updated_at' => time()]);
		$toastData = [
			'title'  => '',
			'msg'    => 'Request has been rejected!',
			'status' => 'error'
		];
		
		if( $request_type == 'approved'){
			
			UserParentLink::create([
				'user_id' => $requestObj->student_id,
				'parent_id' => $requestObj->created_by,
				'parent_type' => 'parent',
				'status' => 'active',
				'created_by' => $user->id,
				'created_at' => time(),
			]);
			$toastData = [
				'title'  => '',
				'msg'    => 'Request successfully approved!',
				'status' => 'success'
			];
			
		}
        echo json_encode($toastData);exit;

    }

    /*
     * Update User Class
     */
    public function userSettings(Request $request)
    {
        $user = auth()->user();
        $user_preference = $request->input('user_preference');
        $male_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"0","chinshadow":"0","facehighlight":"0","humanbody":"0","clothes":"0","hair":"1","ears":"0","eyebrows":"0","eyesback":"0","eyesiris":"0","eyesfront":"0","glasses":"0","mouth":"0","mustache":"0","beard":"0","nose":"0"},"avatar_color_settings":{"backs":"#000000","humanbody":"#f0c7b1","clothes":"#386e77","hair":"#2a232b","ears":"#f0c7b1","faceshape":"#f0c7b1","chinshadow":"#f0c7b1","facehighlight":"#f0c7b1","eyebrows":"#2a232b","eyesback":"#000000","eyesfront":"#000000","eyesiris":"#4e60a3","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#da7c87","nose":"#f0c7b1"}}';
        $female_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"0","chinshadow":"0","facehighlight":"0","humanbody":"0","clothes":"0","hair":"10","ears":"0","eyebrows":"0","eyesback":"0","eyesiris":"0","eyesfront":"0","glasses":"0","mouth":"2","nose":"0"},"avatar_color_settings":{"backs":"#ecf0f1","humanbody":"#f3d4cf","clothes":"#09aac5","hair":"#2a232b","ears":"#f3d4cf","faceshape":"#f3d4cf","chinshadow":"#f3d4cf","facehighlight":"#f3d4cf","eyebrows":"#2a232b","eyesback":"#000000","eyesfront":"#000000","eyesiris":"#4e60a3","glasses":"#26120B","mouth":"#ed2153","nose":"#f3d4cf"}}';

        $user_avatar_settings = ($user_preference == 'female' )? $female_default_avatar : $male_default_avatar;
        $avatar = ($user_preference == 'female' )? '/avatar/female-default.png' : '/avatar/male-default.png';
        $user->update([
            'avatar'                => $avatar,
            'user_avatar_settings' => $user_avatar_settings,
            'user_preference' => $user_preference,
            'updated_at'   => time(),
        ]);
        return redirect('/panel/setting');
    }


}
