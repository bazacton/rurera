<?php

namespace App\Http\Controllers\Web;

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

        if (!auth()->check()) {
            $response_layout = view('web.default.subscriptions.login_signup', [])->render();
        }
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
                $response_layout .= '<span data-label="' . $username_suggestion . '">' . $username_suggestion . '</span><br>';
            }
        }
        $response_layout .= '';
        if ($autogenerate == 'yes') {
            $response_layout = isset($usernameSuggestions[0]) ? $usernameSuggestions[0] : '';
        }

        echo $response_layout;
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
            'parent_id'       => isset($user->id) ? $user->id : 0,
            'year_id'         => $year_id,
            'class_id'        => 0,
            'section_id'      => 0,
            'user_life_lines' => 5,
            'first_name'      => $first_name,
            'last_name'       => $last_name,
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
        $selected_package = $request->get('selected_package', null);
        $subscribed_for = $request->get('subscribed_for', null);
        $subscribed_for = ($subscribed_for == true)? 12 : 1;
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
                    'payment_amount'   => $payment_amount
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



    public function pay(Request $request)
    {
        $user = auth()->user();
        $subscribe_for = $request->input('subscribe_for');
        $subscribe_for = ($subscribe_for > 0) ? $subscribe_for : 0;

        if( $subscribe_for == 0){
            $ParentsOrders = ParentsOrders::where('user_id', $user->id)
               ->where('status', 'active')
               ->first();
            $subscribe_for = isset($ParentsOrders->payment_frequency)? $ParentsOrders->payment_frequency : 1;
        }
        $user_id = $request->input('user_id');
        $package_id = $request->input('selectedPackage');
        $childObj = User::find($user_id);
        $userPackageObj = $childObj->userSubscriptions;

        $ParentsOrders = ParentsOrders::where('user_id', $user->id)->where('status', '!=', 'inactive')->first();
        $order = Order::where('user_id', $user->id)->where('status', 'pending')->where('package_id', $package_id)->where('student_id', $user_id)->where('order_type', 'subscribe')->orderBy('id', 'DESC')->first();
        $paymentChannels = PaymentChannel::where('status', 'active')->get();
        if( !isset( $order->id ) ) {



            $expiry_date = strtotime('+' . $subscribe_for . ' month', time());
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
            $discount_percentage = 0;
            if ($child_count > 1) {
                $discount_percentage = 5;
            }
            $discount_amount = ($discount_percentage * $subscribeObj->price) / 100;
            $packages_amount += ($subscribeObj->price - $discount_amount);
            $total_discount += $discount_amount;
            $child_discount = $discount_amount;
            $charged_amount = ($subscribeObj->price - $discount_amount);

            if (isset($ParentsOrders->id)) {
                $package_created = $ParentsOrders->created_at;
                $package_expiry = $ParentsOrders->expiry_at;
                $current_date = time();
                $package_total_days = ($package_expiry - $package_created);
                $package_total_days = round($package_total_days / (60 * 60 * 24));
                $remaining_days = ($package_expiry - $current_date);
                $remaining_days = round($remaining_days / (60 * 60 * 24));

                $expiry_total_days = ($expiry_date - $current_date);
                $expiry_total_days = round($expiry_total_days / (60 * 60 * 24));
                $per_day_amount = ($packages_amount / $expiry_total_days);
                //pre('Package total Days = '.$package_total_days, false);
                //pre('Remaining Days = '.$remaining_days, false);
                //pre('Per Day Amount = '.$per_day_amount, false);

                //$per_day_amount = ($packages_amount / $package_total_days);
                $packages_amount = ($remaining_days * $per_day_amount);
            }
            $packages_amount = round($packages_amount, 2);

            $activeSubscribe = Subscribe::getActiveSubscribe($user->id);


            $full_data['package_id'][] = $package_id;
            $full_data['expiry_date'] = $expiry_date;


            $financialSettings = getFinancialSettings();
            $tax = $financialSettings['tax'] ?? 0;


            $amount = $packages_amount;
            $full_data['amount'] = $amount;
            $full_data['tax'] = $tax;

            $taxPrice = $tax ? $amount * $tax / 100 : 0;


            if (!isset($ParentsOrders->id)) {
                $ParentsOrders = ParentsOrders::create([
                    "user_id"            => $user->id,
                    'order_amount'       => $amount,
                    'order_tax'          => $taxPrice,
                    'transaction_amount' => round($amount + $taxPrice, 2),
                    'payment_data'       => json_encode($full_data),
                    'payment_frequency'  => $subscribe_for,
                    "created_at"         => time(),
                    'expiry_at'          => $expiry_date,
                ]);
            } else {
                $expiry_date = $ParentsOrders->expiry_at;
                $full_data['expiry_date'] = $expiry_date;
                $payment_data = isset($ParentsOrders->payment_data) ? (array)json_decode($ParentsOrders->payment_data) : array();
                $payment_data['students'] = array_merge($payment_data['students'], $full_data['students']);
                $payment_data['package_id'] = array_merge($payment_data['package_id'], $full_data['package_id']);
                $payment_data['amount'] += $amount;
                $parentOrdersData = [
                    'order_amount'       => $ParentsOrders->order_amount + $amount,
                    'order_tax'          => $ParentsOrders->order_tax + $taxPrice,
                    'transaction_amount' => $ParentsOrders->transaction_amount + round($amount + $taxPrice, 2),
                    'payment_data'       => json_encode($payment_data),
                ];
                $ParentsOrders->update($parentOrdersData);
            }

            $subscribeData = Subscribe::find($package_id);


            $user->update([
                'payment_frequency' => $ParentsOrders->payment_frequency
            ]);

            if (isset($userPackageObj->id)) {

                $userPackageObj->update([
                    'status' => 'inactive'
                ]);
            }


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
            "expiry_at"       => $expiry_date,
            "child_discount"  => $child_discount,
            "charged_amount"  => $charged_amount,
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
