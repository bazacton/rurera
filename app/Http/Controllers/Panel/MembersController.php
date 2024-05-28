<?php
namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Mixins\RegistrationPackage\UserPackage;
use App\Http\Controllers\Web\CronJobsController;
use App\Models\Category;
use Stripe\Stripe;
use App\Models\Subscribe;
use App\Models\Comment;
use App\Models\Gift;
use App\Models\Meeting;
use App\Models\ReserveMeeting;
use App\Models\Sale;
use App\Models\Support;
use App\Models\UserAssignedTopics;
use App\Models\Webinar;
use App\Models\Schools;
use App\Models\StudentLinkRequests;
use App\Models\ParentsOrders;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class MembersController extends Controller
{

    public function index()
    {

        $user = getUser();
        $male_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"0","chinshadow":"0","facehighlight":"0","humanbody":"0","clothes":"0","hair":"1","ears":"0","eyebrows":"0","eyesback":"0","eyesiris":"0","eyesfront":"0","glasses":"0","mouth":"0","mustache":"0","beard":"0","nose":"0"},"avatar_color_settings":{"backs":"#000000","humanbody":"#f0c7b1","clothes":"#386e77","hair":"#2a232b","ears":"#f0c7b1","faceshape":"#f0c7b1","chinshadow":"#f0c7b1","facehighlight":"#f0c7b1","eyebrows":"#2a232b","eyesback":"#000000","eyesfront":"#000000","eyesiris":"#4e60a3","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#da7c87","nose":"#f0c7b1"}}';
        $female_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"8","chinshadow":"8","facehighlight":"0","humanbody":"0","clothes":"8","hair":"7","ears":"3","eyebrows":"2","eyesback":"2","eyesiris":"2","eyesfront":"2","glasses":"0","mouth":"2","nose":"5"},"avatar_color_settings":{"backs":"#40c0cb","humanbody":"#ecc4b8","clothes":"#152c5e","hair":"#4e4341","ears":"#ecc4b8","faceshape":"#ecc4b8","chinshadow":"#ecc4b8","facehighlight":"#ecc4b8","eyebrows":"#4e4341","eyesback":"#000000","eyesfront":"#0f190c","eyesiris":"#4d3623","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#c90433","nose":"#ecc4b8"}}';

		$CronJobsController = new CronJobsController();
		$CronJobsController->update_subscriptions_status();



        if( isset( $_GET['spells'])){
            pre(get_words_phonics('hummer'));
        }

        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->user()->isParent()) {
            return redirect('/'.panelRoute());
        }
        if (auth()->user()->isParent()) {

            /*$childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->with([
                    'userSubscriptions' => function ($query) {
                        $query->with(['subscribe']);
                    }
                ])
                ->get();*/

            //$childs = $user->parentChilds->where('status', 'active');

            $childs = $user->parentChilds->where('status', 'active')->sortBy(function ($child) {
                if( isset( $child->user->userSubscriptions->id )){
                    return 0;
                }else{
                    return 1;
                }
                //return $child->user->userSubscriptions->count();
            });


            $Sales = Sale::where('buyer_id', $user->id)->whereIn('type', array(
                'subscribe',
                'plan_expiry_update',
                'plan_update'
            ))->get();
			
			$studentsRequests = StudentLinkRequests::where('request_to', $user->id)->where('status', 'active')->get();
			$data['studentsRequests'] = $studentsRequests;

            $ParentsOrders = ParentsOrders::where('user_id', $user->id)
                ->where('status', 'active')
                ->first();


            $time_zones = User::$timeZones;
            $frequencyArray = ParentsOrders::$frequencyArray;

            $data['userObj'] = $user;

            $data['childs'] = $childs;
            $data['time_zones'] = $time_zones;
            $data['countries_list'] = User::$countriesList;

            $data['ParentsOrders'] = $ParentsOrders;
            $data['frequencyArray'] = $frequencyArray;
            $data['Sales'] = $Sales;
            $frequency_discounts = array(
                1 => 0,
                3 => 5,
                6 => 10,
                12 => 20,
            );
            $data['frequency_discounts'] = $frequency_discounts;


            $categories = Category::where('parent_id' , null)
                       ->with('subCategories')
                       ->get();
            $subscribes = Subscribe::all();
            $data['subscribes'] = $subscribes ?? [];
            $data['pageTitle'] = 'Students';
            $data['categories'] = $categories;
            //pre($categories);

            return view(getTemplate() . '.panel.parent.dashboard', $data);
            //return view(getTemplate() . '.panel.dashboard.index', $data);
        }
    }

    public function billing()
    {

        $user = getUser();
        $male_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"0","chinshadow":"0","facehighlight":"0","humanbody":"0","clothes":"0","hair":"1","ears":"0","eyebrows":"0","eyesback":"0","eyesiris":"0","eyesfront":"0","glasses":"0","mouth":"0","mustache":"0","beard":"0","nose":"0"},"avatar_color_settings":{"backs":"#000000","humanbody":"#f0c7b1","clothes":"#386e77","hair":"#2a232b","ears":"#f0c7b1","faceshape":"#f0c7b1","chinshadow":"#f0c7b1","facehighlight":"#f0c7b1","eyebrows":"#2a232b","eyesback":"#000000","eyesfront":"#000000","eyesiris":"#4e60a3","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#da7c87","nose":"#f0c7b1"}}';
        $female_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"8","chinshadow":"8","facehighlight":"0","humanbody":"0","clothes":"8","hair":"7","ears":"3","eyebrows":"2","eyesback":"2","eyesiris":"2","eyesfront":"2","glasses":"0","mouth":"2","nose":"5"},"avatar_color_settings":{"backs":"#40c0cb","humanbody":"#ecc4b8","clothes":"#152c5e","hair":"#4e4341","ears":"#ecc4b8","faceshape":"#ecc4b8","chinshadow":"#ecc4b8","facehighlight":"#ecc4b8","eyebrows":"#4e4341","eyesback":"#000000","eyesfront":"#0f190c","eyesiris":"#4d3623","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#c90433","nose":"#ecc4b8"}}';

        if (auth()->user()->isParent()) {

            $Sales = Sale::where('buyer_id', $user->id)->whereIn('type', array(
                            'subscribe',
                            'plan_expiry_update',
                            'plan_update'
                        ))->get();
            $data['Sales'] = $Sales;
            $data['pageTitle'] = 'Billing';
            return view(getTemplate() . '.panel.parent.billing', $data);
        }
    }

    public function change_password()
    {

        $user = getUser();
        $male_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"0","chinshadow":"0","facehighlight":"0","humanbody":"0","clothes":"0","hair":"1","ears":"0","eyebrows":"0","eyesback":"0","eyesiris":"0","eyesfront":"0","glasses":"0","mouth":"0","mustache":"0","beard":"0","nose":"0"},"avatar_color_settings":{"backs":"#000000","humanbody":"#f0c7b1","clothes":"#386e77","hair":"#2a232b","ears":"#f0c7b1","faceshape":"#f0c7b1","chinshadow":"#f0c7b1","facehighlight":"#f0c7b1","eyebrows":"#2a232b","eyesback":"#000000","eyesfront":"#000000","eyesiris":"#4e60a3","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#da7c87","nose":"#f0c7b1"}}';
        $female_default_avatar = '{"avatar_settings":{"backs":"1","faceshape":"8","chinshadow":"8","facehighlight":"0","humanbody":"0","clothes":"8","hair":"7","ears":"3","eyebrows":"2","eyesback":"2","eyesiris":"2","eyesfront":"2","glasses":"0","mouth":"2","nose":"5"},"avatar_color_settings":{"backs":"#40c0cb","humanbody":"#ecc4b8","clothes":"#152c5e","hair":"#4e4341","ears":"#ecc4b8","faceshape":"#ecc4b8","chinshadow":"#ecc4b8","facehighlight":"#ecc4b8","eyebrows":"#4e4341","eyesback":"#000000","eyesfront":"#0f190c","eyesiris":"#4d3623","glasses":"#26120B","mustache":"#2a232b","beard":"#2a232b","mouth":"#c90433","nose":"#ecc4b8"}}';

        if (auth()->user()->isParent()) {

           $data['pageTitle'] = 'Change Password';
           return view(getTemplate() . '.panel.parent.change_password', $data);

        }
    }



    public function printCard(Request $request, $user_id)
    {
        $userObj = auth()->user();

        $users = array();

        $childs = $userObj->parentChilds->where('status', 'active')->pluck('user_id')->toArray();
        if( !in_array($user_id, $childs)){
            exit;
        }
        $users = User::where('id', $user_id);
        $users = $users->get();
        if( !empty( $users ) ){
            foreach( $users as $studentObj){
                if( $studentObj->login_emoji == ''){
                    $studentObj = $this->generateEmoji($studentObj);
                }
                if( $studentObj->login_pin == ''){
                    $studentObj = $this->generatePin($studentObj);
                }
            }
        }
        $data = [
            'pageTitle' => 'Students',
            'users' => $users,
        ];

        return view('web.default.user.print_students', $data);
    }
	
	


    public function studentProfile(Request $request, $username)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $userObj = auth()->user();
		
		$user = User::where('username', '=', $username)->where('status', 'active')->first();
		
		
		if( !isset( $user->card_brand ) || $user->card_brand == ''){
    		$stripeCustomer = $user->createOrGetStripeCustomer();
    		$paymentMethods = $user->paymentMethods();
    		
    		
    		
    		$paymentMethod = $user->defaultPaymentMethod();
    		if( $paymentMethod == '' || empty( $paymentMethod )){
    			$paymentMethodUsed = $paymentMethods->first();
    			if(isset( $paymentMethodUsed->id ) && $paymentMethodUsed->id != ''){
    				$user->updateDefaultPaymentMethod($paymentMethodUsed->id);
    			}
    		}
		}
		
		$categoryObj = Category::where('id', $user->year_id)->first();
        $courses_list = Webinar::where('category_id', $categoryObj->id)->where('status', 'active')->get();

		$childs = $userObj->parentChilds->where('status', 'active')->sortBy(function ($child) {
                if( isset( $child->user->userSubscriptions->id )){
                    return 0;
                }else{
                    return 1;
                }
                //return $child->user->userSubscriptions->count();
            });
		$schools = Schools::where('status', 'active')->get();
		$data = array(
			'childs' => $childs,
			'user' => $user,
			'courses_list' => $courses_list,
			'schools' => $schools,
		);

        return view('web.default.panel.parent.student', $data);
    }


    public function generateEmoji($user)
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

        $user->update([
            'login_emoji' => $generatedString
        ]);
        return $user;
    }

    public function generatePin($user)
    {
        $loginList = array(0,1,2,3,4,5,6,7,8,9);

        $UsedLoginList = User::where('role_id', '=', 1)->where('status', 'active')->where('login_pin', '!=', '')->pluck('login_pin')->toArray();

        do {
            // Shuffle the emojis list
            shuffle($loginList);

            // Take the first 6 emojis as random indexes
            $random_offset = rand(1,6);
            $generatedIndexes = array_slice($loginList, $random_offset, 6);

            // Create a string by concatenating the randomly selected emojis
            $generatedString = implode('', $generatedIndexes);

        } while (in_array($generatedString, $UsedLoginList) || strlen($generatedString) < 6);

        $user->update([
            'login_pin' => $generatedString
        ]);
        return $user;

    }


}
