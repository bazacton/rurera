<?php

namespace App\Http\Controllers\Web;
use App\PaymentChannels\Drivers\Stripe\Channel;
use App\Http\Controllers\Controller;
use App\Models\Accounting;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ParentsOrders;
use App\Models\PaymentChannel;
use App\Models\Sale;
use App\Models\Subscribe;
use App\Models\SubscribeUse;
use App\Models\UserSubscriptions;
use App\Models\Webinar;
use App\Models\UserParentLink;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{

    use RegistersUsers;

    public function apply(Request $request, $webinarSlug)
    {
        $webinar = Webinar::where('slug', $webinarSlug)
            ->where('status', 'active')
            ->where('subscribe', true)
            ->first();

        if (!empty($webinar)) {
            return $this->handleSale($webinar, 'webinar_id');
        }

        abort(404);
    }

    public function bundleApply($bundleSlug)
    {
        $bundle = Bundle::where('slug', $bundleSlug)
            ->where('subscribe', true)
            ->first();

        if (!empty($bundle)) {
            return $this->handleSale($bundle, 'bundle_id');
        }

        abort(404);
    }

    private function handleSale($item, $itemName = 'webinar_id')
    {
        if (auth()->check()) {
            $user = auth()->user();

            $subscribe = Subscribe::getActiveSubscribe($user->id);

            if (!$subscribe) {
                $toastData = [
                    'title'  => trans('public.request_failed'),
                    'msg'    => trans('site.you_dont_have_active_subscribe'),
                    'status' => 'error'
                ];
                return back()->with(['toast' => $toastData]);
            }

            $checkCourseForSale = checkCourseForSale($item, $user);

            if ($checkCourseForSale != 'ok') {
                return $checkCourseForSale;
            }

            $sale = Sale::create([
                'buyer_id'       => $user->id,
                'seller_id'      => $item->creator_id,
                $itemName        => $item->id,
                'subscribe_id'   => $subscribe->id,
                'type'           => $itemName == 'webinar_id' ? Sale::$webinar : Sale::$bundle,
                'payment_method' => Sale::$subscribe,
                'amount'         => 0,
                'total_amount'   => 0,
                'created_at'     => time(),
            ]);

            Accounting::createAccountingForSaleWithSubscribe($item, $subscribe, $itemName);

            SubscribeUse::create([
                'user_id'              => $user->id,
                'subscribe_id'         => $subscribe->id,
                $itemName              => $item->id,
                'sale_id'              => $sale->id,
                'installment_order_id' => $subscribe->installment_order_id ?? null,
            ]);

            $toastData = [
                'title'  => trans('cart.success_pay_title'),
                'msg'    => trans('cart.success_pay_msg_subscribe'),
                'status' => 'success'
            ];
            return back()->with(['toast' => $toastData]);
        } else {
            return redirect('/login');
        }
    }

    public function applySubscription(Request $request)
    {
        $action_type = $request->get('action_type', null);
        $action_id = $request->get('action_id', null);
        $action_reason = $request->get('action_reason', '');

        if (!auth()->check()) {
            $response_layout = view('web.default.subscriptions.login_signup', [])->render();
        }
        else{
        $user = auth()->user();

        $ParentsOrders = ParentsOrders::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if ($action_type == 'child_register') {

            $categories = Category::where('parent_id', null)
                ->with('subCategories')->orderBy('order', 'asc')
                ->get();
            $response_layout = view('web.default.subscriptions.childs', [
                'categories'    => $categories,
                'ParentsOrders' => $ParentsOrders
            ])->render();
        }
        if ($action_type == 'child_payment') {
            $childObj = User::find($action_id);
            $subscribes = Subscribe::all();
            $selected_package = 0;

            $response_layout = view('web.default.subscriptions.packages', [
                'childObj'         => $childObj,
                'subscribes'       => $subscribes,
                'selected_package' => $selected_package,
                'ParentsOrders' => $ParentsOrders
            ])->render();
        }

        if ($action_type == 'update_package') {
            $childObj = User::find($action_id);
            $subscribes = Subscribe::all();
            $selected_package = isset( $childObj->userSubscriptions->subscribe_id )? $childObj->userSubscriptions->subscribe_id :0;

            $response_layout = view('web.default.subscriptions.packages', [
                'childObj'         => $childObj,
                'subscribes'       => $subscribes,
                'selected_package' => $selected_package,
                'ParentsOrders' => $ParentsOrders
            ])->render();
        }

        if ($action_type == 'update_package_confirm') {
            $childObj = User::find($action_id);
            $subscribes = Subscribe::all();
            $selected_package = isset( $childObj->userSubscriptions->subscribe_id )? $childObj->userSubscriptions->subscribe_id :0;

            $response_layout = view('web.default.subscriptions.packages', [
                'update_package_confirm' => true,
                'childObj'         => $childObj,
                'subscribes'       => $subscribes,
                'selected_package' => $selected_package,
                'ParentsOrders' => $ParentsOrders,
                'action_reason' => $action_reason
            ])->render();
        }
        }


        echo $response_layout;
        exit;
    }

    protected function validator(array $data)
    {
        $rules = [
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
        if (!empty(getGeneralSecuritySettings('captcha_for_register'))) {
            $rules['captcha'] = 'required|captcha';
        }
        return Validator::make($data, $rules);
    }


    public function tenureSubmit(Request $request)
    {
        $subscribe_for = $request->get('subscribe_for', null);
        $categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();
        $response_layout = view('web.default.subscriptions.childs', ['categories' => $categories])->render();
        echo $response_layout;
        exit;
    }

    public function autoGenerateUsername(Request $request)
    {
        $first_name = $request->get('first_name', null);
        $last_name = $request->get('last_name', null);
        $autogenerate = $request->get('autogenerate', null);


        $UsedLoginList = User::where('role_id', '=', 1)->where('status', 'active')->where('username', '!=', '')->pluck('username')->toArray();


        $usernameSuggestions = [
            strtolower($first_name . $last_name),
            // First suggestion: firstname.lastname
            strtolower($first_name[0] . $last_name),
            // Second suggestion: first_character.lastname
        ];
        if ($autogenerate == 'yes') {
            $usernameSuggestions = array();
        }

        // Add third suggestion: firstname.lastname.<number>
        $index = 1;
        do {
            $suggestedUsername = strtolower($first_name . $last_name . ($index > 1 ? '' . $index : rand(1234, 9999)));
            $index++;
        } while (in_array($suggestedUsername, $UsedLoginList));

        $usernameSuggestions[] = $suggestedUsername;
        $response_layout = '';

        if (!empty($usernameSuggestions)) {
            foreach ($usernameSuggestions as $username_suggestion) {
                $response_layout .= '<span data-label="' . $username_suggestion . '"><a href="javascript:;">' . $username_suggestion . '</a></span><br>';
            }
        }
        $response_layout .= '';
        if ($autogenerate == 'yes') {
            $response_layout = isset($usernameSuggestions[0]) ? $usernameSuggestions[0] : '';
        }

        echo $response_layout;
        exit;
    }

    public function editChild(Request $request)
    {
       $first_name = $request->get('first_name', null);
       $last_name = $request->get('last_name', null);
       $user_id = $request->get('user_id', null);
       $year_id = $request->get('year_id', null);
       $test_prep_school = $request->get('test_prep_school', null);
       $studentUser = User::find($user_id);
       if (auth()->check() && auth()->user()->isParent()) {
           $studentUser->update([
               'first_name_parent' => $first_name,
               'last_name_parent' => $last_name,
               'full_name_parent' => $first_name.' '.$last_name,
               'year_id' => $year_id,
               'prep_school' => $test_prep_school,
           ]);
       }
       exit;
    }
    public function registerChild(Request $request)
    {
        $user = auth()->user();
        $first_name = $request->get('first_name', null);
        $last_name = $request->get('last_name', null);
        $year_id = $request->get('year_id', null);
        $username = $request->get('username', null);
        $password = $request->get('password', null);
        $selected_package = $request->get('selected_package', null);
        $test_prep_school = $request->get('test_prep_school', null);


        $childObj = User::create([
            'full_name'       => $first_name . ' ' . $last_name,
            //$data['full_name'],
            'role_name'       => 'user',
            'role_id'         => 1,
            'username'        => $username,
            'email'           => '',
            'password'        => User::generatePassword($password),
            'status'          => 'active',
            'affiliate'       => 0,
            'verified'        => true,
            'created_at'      => time(),
            'parent_type'     => 'parent',
            'parent_id'       => 0,
            'year_id'         => $year_id,
            'class_id'        => 0,
            'section_id'      => 0,
            'user_life_lines' => 5,
            'first_name'      => $first_name,
            'last_name'       => $last_name,
            'prep_school'       => $test_prep_school,
        ]);

        UserParentLink::create([
            'user_id'         => $childObj->id,
            'parent_id'       => isset($user->id) ? $user->id : 0,
            'parent_type'     => 'parent',
            'status'          => 'active',
            'created_by'      => isset($user->id) ? $user->id : 0,
            'created_at'      => time(),
        ]);
        //$childObj = User::find(1204);
        $subscribes = Subscribe::all();

        $response_layout = view('web.default.subscriptions.packages', [
            'childObj'         => $childObj,
            'subscribes'       => $subscribes,
            'selected_package' => $selected_package
        ])->render();
        echo $response_layout;
        exit;
    }

    public function paymentForm(Request $request)
    {
        $user = getUser();
        $subscribed_childs = $user->parentChilds->where('status', 'active')->sum(function ($child) {
            return isset( $child->user->userSubscriptions->id) ? 1 : 0;
        });
        $selected_package = $request->get('selected_package', null);
        $subscribed_for = $request->get('subscribed_for', null);
        $subscribed_for = ($subscribed_for > 0) ? $subscribed_for : 0;
        $subscribed_for = ($subscribed_for == 12) ? $subscribed_for : 1;
        $user_id = $request->get('user_id', null);
        $childObj = User::find($user_id);

        $packageObj = Subscribe::find($selected_package);
        $payment_amount = $packageObj->price * $subscribed_for;
        $already_packaged = isset( $childObj->userSubscriptions->subscribe->price )? $childObj->userSubscriptions->subscribe->price : -1;
        if( $packageObj->price < $already_packaged ){
            $response_layout = view('web.default.subscriptions.finish', [
                'selected_package' => $selected_package,
                'subscribed_for'   => $subscribed_for,
                'user_id'          => $user_id,
                'packageObj'       => $packageObj,
                'payment_amount'   => $payment_amount,
                'custom_text'       => 'You will have continued access to the current package until its expiration. Upon renewal, you will be billed for the "'.$packageObj->title.'" package.',
            ])->render();
        }else {
            if ($payment_amount > 0) {
                $response_layout = view('web.default.subscriptions.payment_form', [
                    'selected_package' => $selected_package,
                    'subscribed_for'   => $subscribed_for,
                    'user_id'          => $user_id,
                    'packageObj'       => $packageObj,
                    'payment_amount'   => $payment_amount,
                    'subscribed_childs' => $subscribed_childs,
                ])->render();
            } else {
                $response_layout = view('web.default.subscriptions.finish', [
                    'selected_package' => $selected_package,
                    'subscribed_for'   => $subscribed_for,
                    'user_id'          => $user_id,
                    'packageObj'       => $packageObj,
                    'payment_amount'   => $payment_amount
                ])->render();
            }
        }
        echo $response_layout;
        exit;
    }

    public function packagesList(Request $request)
    {
        $user_id = $request->get('user_id', null);
        $childObj = User::find($user_id);
        $subscribes = Subscribe::all();

        $response_layout = view('web.default.subscriptions.packages', [
            'childObj'         => $childObj,
            'subscribes'       => $subscribes,
            'selected_package' => 0
        ])->render();
        echo $response_layout;
        exit;
    }
    
    public function cancelSubscription(Request $request)
    {
        $user = auth()->user();
        $child_id = $request->input('child_id');
        $childObj = User::find($child_id);
        $userSubscriptions = $childObj->userSubscriptions;

        $userSubscriptions->update([
           'is_cancelled' => 1,
           'cancelled_by' => $user->id,
           'cancelled_at' => time(),
        ]);
        exit;
    }

    public function unlinkUser(Request $request)
    {
        $user = auth()->user();
        $child_id = $request->input('child_id');
        $userLinkObj = UserParentLink::where('user_id', $child_id)->where('parent_id', $user->id)->first();

        $userLinkObj->update([
           'status' => 'unlinked',
           'last_updated' => time(),
        ]);
        exit;
    }

    public function paymentIntent_bk(Request $request)
    {

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => 1400,
            'currency' => 'cad',
        ]);
        $output = [
           'clientSecret' => $paymentIntent->client_secret,
       ];

       echo json_encode($output);
       exit;
    }

    public function paymentIntent(Request $request)
    {
        $paymentChannel = new PaymentChannel();
        $StripeChannel = new Channel($paymentChannel);

        $orderObj = Order::find(440);
        $paymentIntentObj = $StripeChannel->orderPaymentRequest($orderObj);
        echo json_encode($paymentIntentObj);
        exit;

        $user = auth()->user();
        $subscribe_for = $request->input('subscribe_for');
        $subscribe_for = ($subscribe_for > 0) ? $subscribe_for : 0;
        $subscribe_for = ($subscribe_for == 12) ? $subscribe_for : 1;

        /*if( $subscribe_for == 0){
            $ParentsOrders = ParentsOrders::where('user_id', $user->id)
               ->where('status', 'active')
               ->first();
            $subscribe_for = isset($ParentsOrders->payment_frequency)? $ParentsOrders->payment_frequency : 1;
        }*/
        $user_id = $request->input('user_id');
        $package_id = $request->input('selectedPackage');
        $childObj = User::find($user_id);
        $userPackageObj = $childObj->userSubscriptions;
        $userSubsribedPackageObj = (object) array();
        $packageDiscountAmount = 0;
        $discount_amount = 0;
        $discount_label = '';
        if( isset( $childObj->userSubscriptions->id)) {
            $subscribedPackageCreated = $childObj->userSubscriptions->created_at;
            $subscribedPackageExpiry = $childObj->userSubscriptions->expiry_at;
            $userSubsribedPackageObj = $childObj->userSubscriptions->subscribe;
            $packageTotalDays   =  ($subscribedPackageExpiry - $subscribedPackageCreated);
            $packageTotalDays = round($packageTotalDays / (60 * 60 * 24));
            $packageRemainingDays =  ($subscribedPackageExpiry - time());
            $packageRemainingDays = round($packageRemainingDays / (60 * 60 * 24));
            $packagePrice = $userSubsribedPackageObj->price;
            $packagePerDayPrice = $packagePrice / $packageTotalDays;
            $packageDiscountAmount = ($packagePerDayPrice * $packageRemainingDays);
            $packageDiscountAmount = round($packageDiscountAmount, 2);
            $discount_label = 'Package Upgrade';
            $full_data['discount_label'] = $discount_label;
            $full_data['discount_amount'] = $packageDiscountAmount;
        }

        $ParentsOrders = ParentsOrders::where('user_id', $user->id)->where('status', '!=', 'inactive')->first();
        $order = Order::where('user_id', $user->id)->where('status', 'pending')->where('package_id', $package_id)->where('student_id', $user_id)->where('order_type', 'subscribe')->orderBy('id', 'DESC')->first();
        $paymentChannels = PaymentChannel::where('status', 'active')->get();
        if( !isset( $order->id ) ) {



            $expiry_date = strtotime('+' . $subscribe_for . ' month', time());
            $expiry_date_final = strtotime(date('Y-m-d', $expiry_date));
            $full_data['subscribe_for'] = $subscribe_for;
            $full_data['students'][] = $user_id;

            //$subscribeArr = Subscribe::whereIn('id', $package_ids)->get();


            $total_discount = 0;

            /*$discounts_array = array(
                1  => 0,
                3  => 5,
                6  => 10,
                12 => 20,
            );*/

            $discounts_array = array(
                1  => 0,
                3  => 0,
                6  => 0,
                12 => 0,
            );

            $packages_amount = $child_count = 0;
            $child_count = 1;
            $childs_discounts = $charged_amounts_array = array();

            $subscribeObj = Subscribe::find($package_id);
            $package_total_amount = $subscribeObj->price*$subscribe_for;
            $discount_percentage = 0;
            if ($child_count > 1) {
                $discount_percentage = 5;
            }
            $discount_amount = ($discount_percentage * $package_total_amount) / 100;
            $packages_amount += ($package_total_amount - $discount_amount);
            $total_discount += $discount_amount;
            $child_discount = $discount_amount;
            $charged_amount = ($package_total_amount - $discount_amount);
            $remaining_days = 30;


            /*if (isset($ParentsOrders->id)) {
                $package_created = $ParentsOrders->created_at;
                $package_expiry = $ParentsOrders->expiry_at;

                $expiry_date_date = date('d', $expiry_date);
                $expiry_date_month = date('m', $expiry_date);
                $expiry_date_year = date('Y', $expiry_date);
                $previous_month_expiry = $expiry_date_year.'-'.str_pad(($expiry_date_month-1), 2, '0', STR_PAD_LEFT).'-'.$expiry_date_year;

                $package_expiry_date = date('d', $package_expiry);
                $expiry_date_final = date('Y-m', $expiry_date);
                $expiry_date_final = $expiry_date_final.'-'.$package_expiry_date;
                $expiry_date_final = strtotime($expiry_date_final);
                $expiry_date_final = ($expiry_date_final > $expiry_date)? strtotime('-1 month', $expiry_date_final) : $expiry_date_final;
                $current_date = time();
                $remaining_days = ($expiry_date_final - $current_date);
                $remaining_days = round($remaining_days / (60 * 60 * 24));
                $expiry_total_days = ($expiry_date - $current_date);
                $expiry_total_days = round($expiry_total_days / (60 * 60 * 24));
                $per_day_amount = ($packages_amount / $expiry_total_days);
                $packages_amount = ($remaining_days * $per_day_amount);
            }*/

            $packages_amount = round($packages_amount, 2);

            $activeSubscribe = Subscribe::getActiveSubscribe($user->id);

            $subscribed_childs = $user->parentChilds->where('status', 'active')->sum(function ($child) {
                return isset( $child->user->userSubscriptions->id) ? 1 : 0;
            });

            if( $subscribed_childs == 0) {
                $expiry_date_final = strtotime('+7 days', $expiry_date_final);
            }


            $full_data['package_id'][] = $package_id;
            $full_data['expiry_date'] = $expiry_date_final;
            $full_data['remaining_days'] = $remaining_days;


            $financialSettings = getFinancialSettings();
            $tax = $financialSettings['tax'] ?? 0;


            $amount = $packages_amount;
            $transaction_amount = $amount - $packageDiscountAmount;
            $full_data['amount'] = $amount;
            $full_data['transaction_amount'] = $transaction_amount;
            $full_data['tax'] = $tax;

            $taxPrice = $tax ? $transaction_amount * $tax / 100 : 0;


            if (!isset($ParentsOrders->id)) {
                $ParentsOrders = ParentsOrders::create([
                    "user_id"            => $user->id,
                    'order_amount'       => $amount,
                    'order_tax'          => $taxPrice,
                    'transaction_amount' => round($transaction_amount + $taxPrice, 2),
                    'payment_data'       => json_encode($full_data),
                    'payment_frequency'  => $subscribe_for,
                    "created_at"         => time(),
                    'expiry_at'          => $expiry_date_final,
                ]);
            } else {
                $expiry_date = $expiry_date_final;
                $full_data['expiry_date'] = $expiry_date_final;
                $payment_data = isset($ParentsOrders->payment_data) ? (array)json_decode($ParentsOrders->payment_data) : array();
                $payment_data['students'] = array_merge($payment_data['students'], $full_data['students']);
                $payment_data['package_id'] = array_merge($payment_data['package_id'], $full_data['package_id']);
                $payment_data['amount'] += $amount;
                $payment_data['transaction_amount'] = isset( $payment_data['transaction_amount'] )? $payment_data['transaction_amount'] : 0;
                $payment_data['transaction_amount'] += $transaction_amount;
                $parentOrdersData = [
                    'order_amount'       => $ParentsOrders->order_amount + $amount,
                    'order_tax'          => $ParentsOrders->order_tax + $taxPrice,
                    'transaction_amount' => $ParentsOrders->transaction_amount + round($transaction_amount + $taxPrice, 2),
                    'payment_data'       => json_encode($payment_data),
                    'expiry_at'          => $expiry_date_final,
                ];
                $ParentsOrders->update($parentOrdersData);
            }

            $subscribeData = Subscribe::find($package_id);


            $user->update([
                'payment_frequency' => $ParentsOrders->payment_frequency
            ]);


            if ($activeSubscribe) {
                $toastData = [
                    'title'  => trans('public.request_failed'),
                    'msg'    => trans('site.you_have_active_subscribe'),
                    'status' => 'error'
                ];
                return back()->with(['toast' => $toastData]);
            }
            //pre('Package Actual Amount = '.$subscribeObj->price, false);
            //pre('Package Charge amount = '.$packages_amount, false);
            /*pre([
                "user_id"        => $user->id,
                "status"         => Order::$pending,
                'tax'            => $taxPrice,
                'total_discount' => $total_discount,
                'commission'     => 0,
                "amount"         => $amount,
                "total_amount"   => $amount + $taxPrice,
                'payment_data'   => json_encode($full_data),
                "created_at"     => time(),
                "parent_id"      => $ParentsOrders->id,
                'order_type'     => 'subscribe',
            ]);*/

        $order = Order::create([
            "user_id"        => $user->id,
            "status"         => Order::$pending,
            'tax'            => $taxPrice,
            'total_discount' => $total_discount,
            'commission'     => 0,
            "amount"         => $amount,
            "total_amount"   => $amount + $taxPrice,
            'payment_data'   => json_encode($full_data),
            "created_at"     => time(),
            "parent_id"      => $ParentsOrders->id,
            'order_type'     => 'subscribe',
            'package_id'     => $package_id,
            'student_id'     => $user_id,
        ]);

        $orderItem = OrderItem::updateOrCreate([
            'user_id'      => $user->id,
            'order_id'     => $order->id,
            'subscribe_id' => 0,
        ], [
            'amount'           => $order->amount,
            'total_amount'     => $amount + $taxPrice,
            'tax'              => $tax,
            'tax_price'        => $taxPrice,
            'commission'       => 0,
            'commission_price' => 0,
            'created_at'       => time(),
        ]);
        $UserSubscriptions = UserSubscriptions::create([
            "buyer_id"        => $user->id,
            "user_id"         => $user_id,
            'order_id'        => $order->id,
            'order_parent_id' => $ParentsOrders->id,
            'order_item_id'   => $orderItem->id,
            'subscribe_id'    => $package_id,
            'is_courses'      => $subscribeData->is_courses,
            'is_timestables'  => $subscribeData->is_timestables,
            'is_bookshelf'    => $subscribeData->is_bookshelf,
            'is_sats'         => $subscribeData->is_sats,
            'is_elevenplus'   => $subscribeData->is_elevenplus,
            'is_vocabulary'   => $subscribeData->is_vocabulary,
            "status"          => 'inactive',
            "created_at"      => time(),
            "expiry_at"       => $expiry_date_final,
            "child_discount"  => $child_discount,
            "charged_amount"  => $charged_amount,
            "subscribe_for"  => $subscribe_for,
        ]);

        }





        $paymentIntent = PaymentIntent::retrieve($checkout->payment_intent);


        if ($order->amount > 0) {

            $razorpay = false;
            foreach ($paymentChannels as $paymentChannel) {
                if ($paymentChannel->class_name == 'Razorpay') {
                    $razorpay = true;
                }
            }

            $data = [
                'pageTitle'       => trans('public.checkout_page_title'),
                'paymentChannels' => $paymentChannels,
                'total'           => $order->total_amount,
                'order'           => $order,
                'count'           => 1,
                'discount_label' => $discount_label,
                'discount_amount' => $discount_amount,
                'userCharge'      => $user->getAccountingCharge(),
                'razorpay'        => $razorpay
            ];

            //return view(getTemplate() . '.cart.payment', $data);

            //$response_layout = view(getTemplate() . '.cart.payment', $data)->render();
            $response_layout = view(getTemplate() . '.cart.payment_form', $data)->render();

        }else {

            // Handle Free
            Sale::createSales($orderItem, Sale::$credit, 'subscribe');

            $response_layout = 'public.request_success';
        }
        echo $response_layout;
        exit;
    }



    public function pay(Request $request)
    {
        $user = auth()->user();
        $subscribe_for = $request->input('subscribe_for');
        $subscribe_for = ($subscribe_for > 0) ? $subscribe_for : 0;
        $subscribe_for = ($subscribe_for == 12) ? $subscribe_for : 1;

        /*if( $subscribe_for == 0){
            $ParentsOrders = ParentsOrders::where('user_id', $user->id)
               ->where('status', 'active')
               ->first();
            $subscribe_for = isset($ParentsOrders->payment_frequency)? $ParentsOrders->payment_frequency : 1;
        }*/
        $user_id = $request->input('user_id');
        $package_id = $request->input('selectedPackage');
        $childObj = User::find($user_id);
        $userPackageObj = $childObj->userSubscriptions;
        $userSubsribedPackageObj = (object) array();
        $packageDiscountAmount = 0;
        $discount_amount = 0;
        $discount_label = '';
        if( isset( $childObj->userSubscriptions->id)) {
            $subscribedPackageCreated = $childObj->userSubscriptions->created_at;
            $subscribedPackageExpiry = $childObj->userSubscriptions->expiry_at;
            $userSubsribedPackageObj = $childObj->userSubscriptions->subscribe;
            $packageTotalDays   =  ($subscribedPackageExpiry - $subscribedPackageCreated);
            $packageTotalDays = round($packageTotalDays / (60 * 60 * 24));
            $packageRemainingDays =  ($subscribedPackageExpiry - time());
            $packageRemainingDays = round($packageRemainingDays / (60 * 60 * 24));
            $packagePrice = $userSubsribedPackageObj->price;
            $packagePerDayPrice = $packagePrice / $packageTotalDays;
            $packageDiscountAmount = ($packagePerDayPrice * $packageRemainingDays);
            $packageDiscountAmount = round($packageDiscountAmount, 2);
            $discount_label = 'Package Upgrade';
            $full_data['discount_label'] = $discount_label;
            $full_data['discount_amount'] = $packageDiscountAmount;
        }

        $ParentsOrders = ParentsOrders::where('user_id', $user->id)->where('status', '!=', 'inactive')->first();
        $order = Order::where('user_id', $user->id)->where('status', 'pending')->where('package_id', $package_id)->where('student_id', $user_id)->where('order_type', 'subscribe')->orderBy('id', 'DESC')->first();
        $paymentChannels = PaymentChannel::where('status', 'active')->get();
        if( !isset( $order->id ) ) {



            $expiry_date = strtotime('+' . $subscribe_for . ' month', time());
            $expiry_date_final = strtotime(date('Y-m-d', $expiry_date));
            $full_data['subscribe_for'] = $subscribe_for;
            $full_data['students'][] = $user_id;

            //$subscribeArr = Subscribe::whereIn('id', $package_ids)->get();


            $total_discount = 0;

            /*$discounts_array = array(
                1  => 0,
                3  => 5,
                6  => 10,
                12 => 20,
            );*/

            $discounts_array = array(
                1  => 0,
                3  => 0,
                6  => 0,
                12 => 0,
            );

            $packages_amount = $child_count = 0;
            $child_count = 1;
            $childs_discounts = $charged_amounts_array = array();

            $subscribeObj = Subscribe::find($package_id);
            $package_total_amount = $subscribeObj->price*$subscribe_for;
            $discount_percentage = 0;
            if ($child_count > 1) {
                $discount_percentage = 5;
            }
            $discount_amount = ($discount_percentage * $package_total_amount) / 100;
            $packages_amount += ($package_total_amount - $discount_amount);
            $total_discount += $discount_amount;
            $child_discount = $discount_amount;
            $charged_amount = ($package_total_amount - $discount_amount);
            $remaining_days = 30;


            /*if (isset($ParentsOrders->id)) {
                $package_created = $ParentsOrders->created_at;
                $package_expiry = $ParentsOrders->expiry_at;

                $expiry_date_date = date('d', $expiry_date);
                $expiry_date_month = date('m', $expiry_date);
                $expiry_date_year = date('Y', $expiry_date);
                $previous_month_expiry = $expiry_date_year.'-'.str_pad(($expiry_date_month-1), 2, '0', STR_PAD_LEFT).'-'.$expiry_date_year;

                $package_expiry_date = date('d', $package_expiry);
                $expiry_date_final = date('Y-m', $expiry_date);
                $expiry_date_final = $expiry_date_final.'-'.$package_expiry_date;
                $expiry_date_final = strtotime($expiry_date_final);
                $expiry_date_final = ($expiry_date_final > $expiry_date)? strtotime('-1 month', $expiry_date_final) : $expiry_date_final;
                $current_date = time();
                $remaining_days = ($expiry_date_final - $current_date);
                $remaining_days = round($remaining_days / (60 * 60 * 24));
                $expiry_total_days = ($expiry_date - $current_date);
                $expiry_total_days = round($expiry_total_days / (60 * 60 * 24));
                $per_day_amount = ($packages_amount / $expiry_total_days);
                $packages_amount = ($remaining_days * $per_day_amount);
            }*/

            $packages_amount = round($packages_amount, 2);

            $activeSubscribe = Subscribe::getActiveSubscribe($user->id);

            $subscribed_childs = $user->parentChilds->where('status', 'active')->sum(function ($child) {
                return isset( $child->user->userSubscriptions->id) ? 1 : 0;
            });

            if( $subscribed_childs == 0) {
                $expiry_date_final = strtotime('+7 days', $expiry_date_final);
            }


            $full_data['package_id'][] = $package_id;
            $full_data['expiry_date'] = $expiry_date_final;
            $full_data['remaining_days'] = $remaining_days;


            $financialSettings = getFinancialSettings();
            $tax = $financialSettings['tax'] ?? 0;


            $amount = $packages_amount;
            $transaction_amount = $amount - $packageDiscountAmount;
            $full_data['amount'] = $amount;
            $full_data['transaction_amount'] = $transaction_amount;
            $full_data['tax'] = $tax;

            $taxPrice = $tax ? $transaction_amount * $tax / 100 : 0;


            if (!isset($ParentsOrders->id)) {
                $ParentsOrders = ParentsOrders::create([
                    "user_id"            => $user->id,
                    'order_amount'       => $amount,
                    'order_tax'          => $taxPrice,
                    'transaction_amount' => round($transaction_amount + $taxPrice, 2),
                    'payment_data'       => json_encode($full_data),
                    'payment_frequency'  => $subscribe_for,
                    "created_at"         => time(),
                    'expiry_at'          => $expiry_date_final,
                ]);
            } else {
                $expiry_date = $expiry_date_final;
                $full_data['expiry_date'] = $expiry_date_final;
                $payment_data = isset($ParentsOrders->payment_data) ? (array)json_decode($ParentsOrders->payment_data) : array();
                $payment_data['students'] = array_merge($payment_data['students'], $full_data['students']);
                $payment_data['package_id'] = array_merge($payment_data['package_id'], $full_data['package_id']);
                $payment_data['amount'] += $amount;
                $payment_data['transaction_amount'] = isset( $payment_data['transaction_amount'] )? $payment_data['transaction_amount'] : 0;
                $payment_data['transaction_amount'] += $transaction_amount;
                $parentOrdersData = [
                    'order_amount'       => $ParentsOrders->order_amount + $amount,
                    'order_tax'          => $ParentsOrders->order_tax + $taxPrice,
                    'transaction_amount' => $ParentsOrders->transaction_amount + round($transaction_amount + $taxPrice, 2),
                    'payment_data'       => json_encode($payment_data),
                    'expiry_at'          => $expiry_date_final,
                ];
                $ParentsOrders->update($parentOrdersData);
            }

            $subscribeData = Subscribe::find($package_id);


            $user->update([
                'payment_frequency' => $ParentsOrders->payment_frequency
            ]);


            if ($activeSubscribe) {
                $toastData = [
                    'title'  => trans('public.request_failed'),
                    'msg'    => trans('site.you_have_active_subscribe'),
                    'status' => 'error'
                ];
                return back()->with(['toast' => $toastData]);
            }
            //pre('Package Actual Amount = '.$subscribeObj->price, false);
            //pre('Package Charge amount = '.$packages_amount, false);
            /*pre([
                "user_id"        => $user->id,
                "status"         => Order::$pending,
                'tax'            => $taxPrice,
                'total_discount' => $total_discount,
                'commission'     => 0,
                "amount"         => $amount,
                "total_amount"   => $amount + $taxPrice,
                'payment_data'   => json_encode($full_data),
                "created_at"     => time(),
                "parent_id"      => $ParentsOrders->id,
                'order_type'     => 'subscribe',
            ]);*/

        $order = Order::create([
            "user_id"        => $user->id,
            "status"         => Order::$pending,
            'tax'            => $taxPrice,
            'total_discount' => $total_discount,
            'commission'     => 0,
            "amount"         => $amount,
            "total_amount"   => $amount + $taxPrice,
            'payment_data'   => json_encode($full_data),
            "created_at"     => time(),
            "parent_id"      => $ParentsOrders->id,
            'order_type'     => 'subscribe',
            'package_id'     => $package_id,
            'student_id'     => $user_id,
        ]);

        $orderItem = OrderItem::updateOrCreate([
            'user_id'      => $user->id,
            'order_id'     => $order->id,
            'subscribe_id' => 0,
        ], [
            'amount'           => $order->amount,
            'total_amount'     => $amount + $taxPrice,
            'tax'              => $tax,
            'tax_price'        => $taxPrice,
            'commission'       => 0,
            'commission_price' => 0,
            'created_at'       => time(),
        ]);
        $UserSubscriptions = UserSubscriptions::create([
            "buyer_id"        => $user->id,
            "user_id"         => $user_id,
            'order_id'        => $order->id,
            'order_parent_id' => $ParentsOrders->id,
            'order_item_id'   => $orderItem->id,
            'subscribe_id'    => $package_id,
            'is_courses'      => $subscribeData->is_courses,
            'is_timestables'  => $subscribeData->is_timestables,
            'is_bookshelf'    => $subscribeData->is_bookshelf,
            'is_sats'         => $subscribeData->is_sats,
            'is_elevenplus'   => $subscribeData->is_elevenplus,
            'is_vocabulary'   => $subscribeData->is_vocabulary,
            "status"          => 'inactive',
            "created_at"      => time(),
            "expiry_at"       => $expiry_date_final,
            "child_discount"  => $child_discount,
            "charged_amount"  => $charged_amount,
            "subscribe_for"  => $subscribe_for,
        ]);

        }


        if ($order->amount > 0) {

            $razorpay = false;
            foreach ($paymentChannels as $paymentChannel) {
                if ($paymentChannel->class_name == 'Razorpay') {
                    $razorpay = true;
                }
            }

            $data = [
                'pageTitle'       => trans('public.checkout_page_title'),
                'paymentChannels' => $paymentChannels,
                'total'           => $order->total_amount,
                'order'           => $order,
                'count'           => 1,
                'discount_label' => $discount_label,
                'discount_amount' => $discount_amount,
                'userCharge'      => $user->getAccountingCharge(),
                'razorpay'        => $razorpay
            ];

            //return view(getTemplate() . '.cart.payment', $data);

            //$response_layout = view(getTemplate() . '.cart.payment', $data)->render();
            $response_layout = view(getTemplate() . '.cart.payment_form', $data)->render();

        }else {

            // Handle Free
            Sale::createSales($orderItem, Sale::$credit, 'subscribe');

            $response_layout = 'public.request_success';
        }
        echo $response_layout;
        exit;
    }


}
