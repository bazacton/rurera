<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mixins\RegistrationBonus\RegistrationBonusAccounting;
use App\Models\Accounting;
use App\Models\Affiliate;
use App\Models\AffiliateCode;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\UserMeta;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $seoSettings = getSeoMetas('register');
        $pageTitle = !empty($seoSettings['title']) ? $seoSettings['title'] : trans('site.register_page_title');
        $pageDescription = !empty($seoSettings['description']) ? $seoSettings['description'] : trans('site.register_page_title');
        $pageRobot = getPageRobot('register');

        $referralSettings = getReferralSettings();

        $referralCode = Cookie::get('referral_code');

        $data = [
            'pageTitle' => $pageTitle,
            'page_title' => $pageTitle,
            'pageDescription' => $pageDescription,
            'pageRobot' => $pageRobot,
            'referralCode' => $referralCode,
            'referralSettings' => $referralSettings,
        ];

        return view(getTemplate() . '.auth.register', $data);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $customMessages = array())
    {
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
        $registerMethod = 'email';

        /*if (!empty($data['mobile']) and !empty($data['country_code'])) {
            $data['mobile'] = ltrim($data['country_code'], '+') . ltrim($data['mobile'], '0');
        }*/

        $rules = [
            //'country_code' => ($registerMethod == 'mobile') ? 'required' : 'nullable',
            //'mobile' => (($registerMethod == 'mobile') ? 'required' : 'nullable') . '|numeric|unique:users',
            'email' => (($registerMethod == 'email') ? 'required' : 'nullable') . '|email|max:255|unique:users',
            //'term' => 'required',
            //'full_name' => 'required|string|min:3',
            'password' => 'required|string|min:6',
            //'password_confirmation' => 'required|same:password',
            //'referral_code' => 'nullable|exists:affiliates_codes,code'
        ];

        if (!empty(getGeneralSecuritySettings('captcha_for_register'))) {
            $rules['captcha'] = 'required|captcha';
        }

        return Validator::make($data, $rules, $customMessages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return
     */
    protected function create(array $data)
    {
        if (!empty($data['mobile']) and !empty($data['country_code'])) {
            $data['mobile'] = ltrim($data['country_code'], '+') . ltrim($data['mobile'], '0');
        }

        $referralSettings = getReferralSettings();
        $usersAffiliateStatus = (!empty($referralSettings) and !empty($referralSettings['users_affiliate_status']));

        if (empty($data['timezone'])) {
            $data['timezone'] = getGeneralSettings('default_time_zone') ?? null;
        }

        $disableViewContentAfterUserRegister = getFeaturesSettings('disable_view_content_after_user_register');
        $accessContent = !((!empty($disableViewContentAfterUserRegister) and $disableViewContentAfterUserRegister));

        $roleName = Role::$user;
        $roleId = Role::getUserRoleId();

        if (!empty($data['account_type'])) {
            if ($data['account_type'] == Role::$teacher) {
                $roleName = Role::$teacher;
                $roleId = Role::getTeacherRoleId();
            } else if ($data['account_type'] == Role::$organization) {
                $roleName = Role::$organization;
                $roleId = Role::getOrganizationRoleId();
            }
        }

        $roleName = 'parent';
        $roleId = 9;

        $user = User::create([
            'role_name' => $roleName,
            'role_id' => $roleId,
            'mobile' => $data['mobile'] ?? null,
            'email' => $data['email'] ?? null,
            'full_name' => $data['full_name'],
            //'status' => User::$pending,
            'status' => 'active',
            'access_content' => $accessContent,
            'password' => Hash::make($data['password']),
            'affiliate' => $usersAffiliateStatus,
            'timezone' => $data['timezone'] ?? null,
            'created_at' => time()
        ]);

        if (!empty($data['certificate_additional'])) {
            UserMeta::updateOrCreate([
                'user_id' => $user->id,
                'name' => 'certificate_additional'
            ], [
                'value' => $data['certificate_additional']
            ]);
        }

        return $user;
    }


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        $notifyOptions = [
            '[u.name]' => $user->get_full_name(),
            '[u.role]' => trans("update.role_{$user->role_name}"),
            '[time.date]' => dateTimeFormat($user->created_at, 'j M Y H:i'),
        ];
        sendNotification("new_registration", $notifyOptions, 1);

        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';

        $value = $request->get($registerMethod);
        if ($registerMethod == 'mobile') {
            $value = $request->get('country_code') . ltrim($request->get('mobile'), '0');
        }

        $referralCode = $request->get('referral_code', null);
        if (!empty($referralCode)) {
            session()->put('referralCode', $referralCode);
        }

        $verificationController = new VerificationController();
        $checkConfirmed = $verificationController->checkConfirmed($user, $registerMethod, $value);

        $referralCode = $request->get('referral_code', null);

        if ($checkConfirmed['status'] == 'send') {

            if (!empty($referralCode)) {
                session()->put('referralCode', $referralCode);
            }

            return redirect('/verification');
        } elseif ($checkConfirmed['status'] == 'verified') {
            $this->guard()->login($user);

            $enableRegistrationBonus = false;
            $registrationBonusAmount = null;
            $registrationBonusSettings = getRegistrationBonusSettings();
            if (!empty($registrationBonusSettings['status']) and !empty($registrationBonusSettings['registration_bonus_amount'])) {
                $enableRegistrationBonus = true;
                $registrationBonusAmount = $registrationBonusSettings['registration_bonus_amount'];
            }


            $user->update([
                'status' => User::$active,
                'enable_registration_bonus' => $enableRegistrationBonus,
                'registration_bonus_amount' => $registrationBonusAmount,
            ]);

            $registerReward = RewardAccounting::calculateScore(Reward::REGISTER);
            RewardAccounting::makeRewardAccounting($user->id, $registerReward, Reward::REGISTER, $user->id, true);

            if (!empty($referralCode)) {
                Affiliate::storeReferral($user, $referralCode);
            }

            $registrationBonusAccounting = new RegistrationBonusAccounting();
            $registrationBonusAccounting->storeRegistrationBonusInstantly($user);

            if ($response = $this->registered($request, $user)) {
                return $response;
            }

            return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect($this->redirectPath());
        }
    }

    public function signupSubmit(Request $request)
    {
        $first_name = $request->get('first_name', null);
        $last_name = $request->get('last_name', null);
        $email = $request->get('email', null);
        $password = $request->get('password', null);
        $validator = $this->validator($request->all());
        $customMessages = [
            'email.unique' => 'You already have an account with us. Please <a href="/login">Login</a> to access.',
        ];
        $this->validator($request->all(), $customMessages)->validate();
        /*if (!$validator->passes()) {
            // Validation failed
            $errors = $validator->errors();
            if ($errors->has('email') && $errors->first('email') === 'The email has already been taken.') {
                return redirect('/login?email=true');
            }
            //return redirect()->back()->withErrors($errors)->withInput();
        }*/

        $roleName = 'parent';
        $roleId = 9;

        $disableViewContentAfterUserRegister = getFeaturesSettings('disable_view_content_after_user_register');
        $accessContent = !((!empty($disableViewContentAfterUserRegister) and $disableViewContentAfterUserRegister));

        $referralSettings = getReferralSettings();
        $usersAffiliateStatus = (!empty($referralSettings) and !empty($referralSettings['users_affiliate_status']));

        $user = User::create([
            'role_name'      => $roleName,
            'role_id'        => $roleId,
            'email'          => $email ?? null,
            'full_name'      => $first_name . ' ' . $last_name,
            'status'         => 'active',
            'access_content' => $accessContent,
            'password'       => Hash::make($password),
            'affiliate'      => $usersAffiliateStatus,
            'timezone'       => 'Asia/Karachi',
            'created_at'     => time()
        ]);

        $enableRegistrationBonus = true;
        $registrationBonusAmount = null;
        $user->update([
            'status' => User::$active,
            'enable_registration_bonus' => $enableRegistrationBonus,
            'registration_bonus_amount' => $registrationBonusAmount,
        ]);

        $user = User::find($user->id);

        $this->guard()->login($user);
        Auth::loginUsingId($user->id, true);

        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        $this->guard()->attempt($credentials, true);
        return redirect('/parent/students');
        pre($credentials);



        /*if ($response = $this->registered($request, $user)) {
            return $response;
        }*/

        //$csrf_token = csrf_token();
        //$response_layout = view('web.default.subscriptions.tenure_selection', ['csrf_token'=>$csrf_token])->render();
        echo 'parent/';
        exit;
    }
}
