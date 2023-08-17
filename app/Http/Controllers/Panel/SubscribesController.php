<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\traits\InstallmentsTrait;
use App\Mixins\Installment\InstallmentPlans;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentChannel;
use App\Models\Sale;
use App\Models\Setting;
use App\Models\Subscribe;
use App\Models\ParentsOrders;
use App\Models\UserSubscriptions;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SubscribesController extends Controller
{
    use InstallmentsTrait;

    public function index()
    {
        $user = auth()->user();
        $subscribes = Subscribe::all();

        $installmentPlans = new InstallmentPlans($user);
        foreach ($subscribes as $subscribe) {
            if (getInstallmentsSettings('status') and $user->enable_installments and $subscribe->price > 0) {
                $installments = $installmentPlans->getPlans('subscription_packages', $subscribe->id);

                $subscribe->has_installment = (!empty($installments) and count($installments));
            }
        }

        $data = [
            'pageTitle'       => trans('financial.subscribes'),
            'subscribes'      => $subscribes,
            'activeSubscribe' => Subscribe::getActiveSubscribe($user->id),
            'dayOfUse'        => Subscribe::getDayOfUse($user->id),
        ];

        return view(getTemplate() . '.panel.financial.subscribes', $data);
    }

    public function pay(Request $request)
    {
        $user = auth()->user();
        $subscribe_for = $request->input('subscribe_for');
        $subscribe_for = ($subscribe_for > 0) ? $subscribe_for : 0;
        $student_names = $request->input('student_name');
        $package_ids = $request->input('package_id');
        $paymentChannels = PaymentChannel::where('status', 'active')->get();
        $expiry_date = strtotime('+' . $subscribe_for . ' month', time());

        $full_data['subscribe_for'] = $subscribe_for;
        $full_data['students'] = $student_names;
        $full_data['package_id'] = $package_ids;
        $full_data['expiry_date'] = $expiry_date;

        //$subscribeArr = Subscribe::whereIn('id', $package_ids)->get();
        $ParentsOrders = ParentsOrders::where('user_id', $user->id)->where('status', '!=', 'inactive')->first();

        $total_discount = 0;

        $discounts_array = array(
            1  => 0,
            3  => 5,
            6  => 10,
            12 => 20,
        );


        /*if (empty($subscribeArr)) {
            $toastData = [
                'msg'    => trans('site.subscribe_not_valid'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }*/

        $packages_amount = $child_count = 0;
        $child_count = (isset($ParentsOrders->id)) ? 1 : $child_count;
        $childs_discounts = $charged_amounts_array = array();

        if (!empty($package_ids)) {
            foreach ($package_ids as $package_key => $package_id) {
                $child_count++;
                $subscribeObj = Subscribe::find($package_id);
                $discount_percentage = 0;
                if ($child_count > 1) {
                    $discount_percentage = 5;
                }
                $discount_amount = ($discount_percentage * $subscribeObj->price) / 100;
                $packages_amount += ($subscribeObj->price - $discount_amount);
                $total_discount += $discount_amount;
                $childs_discounts[$package_key] = $discount_amount;
                $charged_amounts_array[$package_key] = ($subscribeObj->price - $discount_amount);
            }
        }

        $discount_percentage = isset($discounts_array[$subscribe_for]) ? $discounts_array[$subscribe_for] : 0;
        $discount_amount = ($packages_amount * $discount_percentage) / 100;
        $packages_amount = ($packages_amount - $discount_amount);
        $total_discount += $discount_amount;
        $packages_amount = ($packages_amount * $subscribe_for);
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

            //$per_day_amount = ($packages_amount / $package_total_days);
            $packages_amount = ($remaining_days * $per_day_amount);
        }

        $packages_amount = round($packages_amount, 2);

        $activeSubscribe = Subscribe::getActiveSubscribe($user->id);


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

        if (!empty($student_names)) {
            foreach ($student_names as $index_no => $student_name) {
                $rand_id = rand(0, 99999);
                $package = isset($package_ids[$index_no]) ? $package_ids[$index_no] : 0;
                $child_discount = isset($childs_discounts[$index_no]) ? $childs_discounts[$index_no] : 0;
                $charged_amount = isset($charged_amounts_array[$index_no]) ? $charged_amounts_array[$index_no] : 0;
                $subscribeData = Subscribe::find($package);
                $userObj = User::create([
                    'full_name'   => $student_name,
                    'role_name'   => 'user',
                    'role_id'     => 1,
                    'email'       => 'test' . $rand_id . '@rurera.com',
                    'password'    => User::generatePassword('123456'),
                    'status'      => 'active',
                    'verified'    => true,
                    'created_at'  => time(),
                    'parent_type' => 'parent',
                    'parent_id'   => $user->id,
                ]);

                $UserSubscriptions = UserSubscriptions::create([
                    "buyer_id"        => $user->id,
                    "user_id"         => $userObj->id,
                    'order_id'        => $order->id,
                    'order_parent_id' => $ParentsOrders->id,
                    'order_item_id'   => $orderItem->id,
                    'subscribe_id'    => $package,
                    'is_courses'      => $subscribeData->is_courses,
                    'is_timestables'  => $subscribeData->is_timestables,
                    'is_bookshelf'    => $subscribeData->is_bookshelf,
                    'is_sats'         => $subscribeData->is_sats,
                    'is_elevenplus'   => $subscribeData->is_elevenplus,
                    "status"          => 'inactive',
                    "created_at"      => time(),
                    "expiry_at"       => $expiry_date,
                    "child_discount"  => $child_discount,
                    "charged_amount"  => $charged_amount,
                ]);

            }
        }

        if ($amount > 0) {

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

            return view(getTemplate() . '.cart.payment', $data);
        }

        // Handle Free
        Sale::createSales($orderItem, Sale::$credit, 'subscribe');

        $toastData = [
            'title'  => 'public.request_success',
            'msg'    => trans('update.success_pay_msg_for_free_subscribe'),
            'status' => 'success'
        ];
        return back()->with(['toast' => $toastData]);
    }

    /*
     * Update Subscribe Plan
     */

    public function updateSubscribePlan(Request $request)
    {
        $user = auth()->user();
        $subscribe_for = $request->input('subscribe_for_package');
        $user->update([
            'payment_frequency' => $subscribe_for
        ]);

        $toastData = [
            'title'  => '',
            'msg'    => 'Updated Successfully',
            'status' => 'success'
        ];
        return back()->with(['toast' => $toastData]);
    }

    public function updateSubscribePlan_bk(Request $request)
    {
        $user = auth()->user();
        $subscribe_for = $request->input('subscribe_for');
        $subscribe_for = ($subscribe_for > 0) ? $subscribe_for : 0;


        $ParentsOrders = ParentsOrders::where('user_id', $user->id)->where('status', '!=', 'inactive')
            ->with([
                'userSubscribed' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->first();
        $userSubscribed = $ParentsOrders->userSubscribed;


        $payment_data = isset($ParentsOrders->payment_data) ? (array)json_decode($ParentsOrders->payment_data) : array();
        $package_ids = isset($payment_data['package_id']) ? $payment_data['package_id'] : array();
        $package_created = $ParentsOrders->created_at;
        $package_expiry = $ParentsOrders->expiry_at;

        $packages_amount = $child_count = $total_discount = 0;


        if (!empty($userSubscribed)) {
            foreach ($userSubscribed as $userSubscribedObj) {
                $child_count++;
                $subscribeObj = Subscribe::find($userSubscribedObj->subscribe_id);
                $discount_percentage = 0;
                if ($child_count > 1) {
                    $discount_percentage = 5;
                }
                $discount_amount = ($discount_percentage * $subscribeObj->price) / 100;
                $packages_amount += ($subscribeObj->price - $discount_amount);
                $total_discount += $discount_amount;
            }
        }

        $paymentChannels = PaymentChannel::where('status', 'active')->get();
        $expiry_date = strtotime('+' . $subscribe_for . ' month', $package_expiry);

        $discounts_array = array(
            1  => 0,
            3  => 5,
            6  => 10,
            12 => 20,
        );

        $discount_percentage = isset($discounts_array[$subscribe_for]) ? $discounts_array[$subscribe_for] : 0;
        $packages_amount = ($packages_amount * $subscribe_for);
        $discount_amount = ($packages_amount * $discount_percentage) / 100;
        $packages_amount = ($packages_amount - $discount_amount);
        $total_discount += $discount_amount;

        $packages_amount = round($packages_amount, 2);

        $financialSettings = getFinancialSettings();
        $tax = $financialSettings['tax'] ?? 0;


        $amount = $packages_amount;

        $taxPrice = $tax ? $amount * $tax / 100 : 0;


        $payment_data = isset($ParentsOrders->payment_data) ? (array)json_decode($ParentsOrders->payment_data) : array();
        $payment_data['subscribe_for'] = $subscribe_for;
        $payment_data['expiry_date'] = $expiry_date;
        $payment_data['amount'] = $amount;
        $parentOrdersData = [
            'order_amount'       => $amount,
            'order_tax'          => $taxPrice,
            'transaction_amount' => round($amount + $taxPrice, 2),
            'payment_data'       => json_encode($payment_data),
            'payment_frequency'  => $subscribe_for,
            'expiry_at'          => $expiry_date,
        ];

        $action_data = array(
            array(
                'type'        => 'updateSubscribePlan',
                'package_id'  => $ParentsOrders->id,
                'action_data' => $parentOrdersData
            )
        );

        $action_data = json_encode($action_data);

        $order = Order::create([
            "user_id"        => $user->id,
            "status"         => Order::$pending,
            'tax'            => $taxPrice,
            'total_discount' => $total_discount,
            'commission'     => 0,
            "amount"         => $amount,
            "total_amount"   => $amount + $taxPrice,
            'payment_data'   => '',
            "created_at"     => time(),
            "parent_id"      => $ParentsOrders->id,
            "action_data"    => $action_data,
            'order_type'     => 'plan_expiry_update',
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


        if ($amount > 0) {

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

            return view(getTemplate() . '.cart.payment', $data);
        }

        // Handle Free
        Sale::createSales($orderItem, Sale::$credit, 'plan_expiry_update');

        $toastData = [
            'title'  => 'public.request_success',
            'msg'    => trans('update.success_pay_msg_for_free_subscribe'),
            'status' => 'success'
        ];
        return back()->with(['toast' => $toastData]);
    }

    /*
     * Update Plan for a child
     */
    /*
         * Update Subscribe Plan
         */
    public function updatePlan(Request $request)
    {
        $user = auth()->user();
        $package_id = $request->input('package');
        $child_id = $request->input('child_id');
        $subscribeObj = Subscribe::find($package_id);
        $ParentsOrders = ParentsOrders::where('user_id', $user->id)->where('status', '!=', 'inactive')
            ->with([
                'userSubscribed' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->first();
        $child_subscribed = UserSubscriptions::where('user_id', $child_id)->where('buyer_id', $user->id)->where('status', 'active')->first();
        $user_current_package = $child_subscribed->subscribe_id;
        if ($package_id <= $user_current_package) {

            $UserSubscriptions = $child_subscribed->replicate();
            $UserSubscriptions->subscribe_id = $package_id;
            $UserSubscriptions->is_courses = $subscribeObj->is_courses;
            $UserSubscriptions->is_timestables = $subscribeObj->is_timestables;
            $UserSubscriptions->is_bookshelf = $subscribeObj->is_bookshelf;
            $UserSubscriptions->is_sats = $subscribeObj->is_sats;
            $UserSubscriptions->is_elevenplus = $subscribeObj->is_elevenplus;
            $UserSubscriptions->status = 'active';
            $UserSubscriptions->child_discount = 0;
            $UserSubscriptions->charged_amount = 0;
            $UserSubscriptions->created_at = time();
            $UserSubscriptions->save();

            $child_subscribed->update([
                "status" => 'inactive',
            ]);
            $toastData = [
                'title'  => 'public.request_success',
                'msg'    => trans('update.success_pay_msg_for_free_subscribe'),
                'status' => 'success'
            ];
            return back()->with(['toast' => $toastData]);

        } else {
            $child_count = $ParentsOrders->userSubscribed->count();
            $payment_data = isset($ParentsOrders->payment_data) ? (array)json_decode($ParentsOrders->payment_data) : array();
            $package_created = $ParentsOrders->created_at;
            $subscribe_for = $ParentsOrders->payment_frequency;
            $package_expiry = $ParentsOrders->expiry_at;
            $packages_amount = $total_discount = 0;

            $discount_percentage = 0;
            if ($child_count > 1) {
                $discount_percentage = 5;
            }
            $discount_amount = ($discount_percentage * $subscribeObj->price) / 100;
            $packages_amount += ($subscribeObj->price - $discount_amount);
            $total_discount += $discount_amount;

            $paymentChannels = PaymentChannel::where('status', 'active')->get();

            $discounts_array = array(
                1  => 0,
                3  => 5,
                6  => 10,
                12 => 20,
            );

            $discount_percentage = isset($discounts_array[$subscribe_for]) ? $discounts_array[$subscribe_for] : 0;
            $packages_amount = ($packages_amount * $subscribe_for);
            $discount_amount = ($packages_amount * $discount_percentage) / 100;
            $packages_amount = ($packages_amount - $discount_amount);
            $total_discount += $discount_amount;


            $current_date = time();
            $package_total_days = ($package_expiry - $package_created);
            $package_total_days = round($package_total_days / (60 * 60 * 24));
            $remaining_days = ($package_expiry - $current_date);
            $remaining_days = round($remaining_days / (60 * 60 * 24));
            $per_day_amount = ($packages_amount / $package_total_days);
            $packages_amount = ($remaining_days * $per_day_amount);

            $packages_amount = round($packages_amount, 2);


            $financialSettings = getFinancialSettings();
            $tax = $financialSettings['tax'] ?? 0;


            $amount = $packages_amount;

            $taxPrice = $tax ? $amount * $tax / 100 : 0;

            $action_data = array(
                array(
                    'type'            => 'updatePlan',
                    'child_id'        => $child_id,
                    'package_id'      => $package_id,
                    'total_discount'  => $total_discount,
                    'packages_amount' => $packages_amount,
                    'package_expiry'  => $package_expiry,
                    'subscribeObj'    => $subscribeObj,
                    'action_data'     => array()
                )
            );

            $action_data = json_encode($action_data);


            $order = Order::create([
                "user_id"        => $user->id,
                "status"         => Order::$pending,
                'tax'            => $taxPrice,
                'total_discount' => $total_discount,
                'commission'     => 0,
                "amount"         => $amount,
                "total_amount"   => $amount + $taxPrice,
                'payment_data'   => '',
                "created_at"     => time(),
                "parent_id"      => $ParentsOrders->id,
                'action_data'    => $action_data,
                'order_type'     => 'plan_update',
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


            /*
            $UserSubscriptions = $child_subscribed->replicate();
            $UserSubscriptions->order_id = $order->id;
            $UserSubscriptions->order_item_id = $orderItem->id;
            $UserSubscriptions->subscribe_id = $package_id;
            $UserSubscriptions->is_courses = $subscribeObj->is_courses;
            $UserSubscriptions->is_timestables = $subscribeObj->is_timestables;
            $UserSubscriptions->is_bookshelf = $subscribeObj->is_bookshelf;
            $UserSubscriptions->is_sats = $subscribeObj->is_sats;
            $UserSubscriptions->is_elevenplus = $subscribeObj->is_elevenplus;
            $UserSubscriptions->status = 'pending';
            $UserSubscriptions->child_discount = $total_discount;
            $UserSubscriptions->charged_amount = $packages_amount;
            $UserSubscriptions->created_at = time();
            $UserSubscriptions->expiry_at = $package_expiry;

            $UserSubscriptions->save();

            $child_subscribed->update([
                "status" => 'inactive',
            ]);
            */


            if ($amount > 0) {

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

                return view(getTemplate() . '.cart.payment', $data);
            }

            // Handle Free
            Sale::createSales($orderItem, Sale::$credit, 'plan_update');
        }

        $toastData = [
            'title'  => 'public.request_success',
            'msg'    => trans('update.success_pay_msg_for_free_subscribe'),
            'status' => 'success'
        ];
        return back()->with(['toast' => $toastData]);
    }

    public function pay_old(Request $request)
    {
        $subscribe_for = $request->input('subscribe_for');
        $student_name = $request->input('student_name');
        $package_id = $request->input('package_id');
        pre($student_name, false);
        pre($package_id);
        $paymentChannels = PaymentChannel::where('status', 'active')->get();

        $subscribe = Subscribe::where('id', $request->input('id'))->first();
        $expiry_date = strtotime('+1 month', time());

        if (empty($subscribe)) {
            $toastData = [
                'msg'    => trans('site.subscribe_not_valid'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }

        $user = auth()->user();
        $activeSubscribe = Subscribe::getActiveSubscribe($user->id);

        if ($activeSubscribe) {
            $toastData = [
                'title'  => trans('public.request_failed'),
                'msg'    => trans('site.you_have_active_subscribe'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }

        $financialSettings = getFinancialSettings();
        $tax = $financialSettings['tax'] ?? 0;

        $amount = $subscribe->getPrice();
        $amount = $amount > 0 ? $amount : 0;

        $taxPrice = $tax ? $amount * $tax / 100 : 0;

        $order = Order::create([
            "user_id"      => $user->id,
            "status"       => Order::$pending,
            'tax'          => $taxPrice,
            'commission'   => 0,
            "amount"       => $amount,
            "total_amount" => $amount + $taxPrice,
            "created_at"   => time(),
        ]);

        $orderItem = OrderItem::updateOrCreate([
            'user_id'      => $user->id,
            'order_id'     => $order->id,
            'subscribe_id' => $subscribe->id,
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
            "buyer_id"      => $user->id,
            "user_id"       => $user->id,
            'order_item_id' => $orderItem->id,
            'subscribe_id'  => $subscribe->id,
            "status"        => 'active',
            "created_at"    => time(),
            "expiry_at"     => $expiry_date,
        ]);


        if ($amount > 0) {

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

            return view(getTemplate() . '.cart.payment', $data);
        }

        // Handle Free
        Sale::createSales($orderItem, Sale::$credit, $order->order_type);

        $toastData = [
            'title'  => 'public.request_success',
            'msg'    => trans('update.success_pay_msg_for_free_subscribe'),
            'status' => 'success'
        ];
        return back()->with(['toast' => $toastData]);
    }
}
