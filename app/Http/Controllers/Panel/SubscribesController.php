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
use App\Models\UserSubscriptions;
use App\User;
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
        $subscribe_for = $request->input('subscribe_for');
        $student_names = $request->input('student_name');
        $package_id = $request->input('package_id');
        $paymentChannels = PaymentChannel::where('status', 'active')->get();
        $expiry_date = strtotime('+' . $subscribe_for . ' month', time());

        $full_data['subscribe_for'] = $subscribe_for;
        $full_data['students'] = $student_names;
        $full_data['package_id'] = $package_id;
        $full_data['expiry_date'] = $expiry_date;

        $subscribeArr = Subscribe::whereIn('id', $package_id)->get();

        $discounts_array = array(
            1  => 0,
            3  => 5,
            6  => 10,
            12 => 20,
        );



        if (empty($subscribeArr)) {
            $toastData = [
                'msg'    => trans('site.subscribe_not_valid'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }

        $packages_amount = 0;
        foreach ($subscribeArr as $subscribeObj) {
            $packages_amount += $subscribeObj->price;
        }
        $discount_percentage = isset($discounts_array[$subscribe_for]) ? $discounts_array[$subscribe_for] : 0;
        $discount_amount = ($packages_amount * $discount_percentage) / 100;
        $packages_amount = ($packages_amount - $discount_amount);

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

        //$amount = $subscribe->getPrice();


        $amount = $packages_amount;
        $full_data['amount'] = $amount;
        $full_data['tax'] = $tax;

        $taxPrice = $tax ? $amount * $tax / 100 : 0;

        $order = Order::create([
            "user_id"      => $user->id,
            "status"       => Order::$pending,
            'tax'          => $taxPrice,
            'commission'   => 0,
            "amount"       => $amount,
            "total_amount" => $amount + $taxPrice,
            'payment_data' => json_encode($full_data),
            "created_at"   => time(),
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
                $package = isset($package_id[$index_no]) ? $package_id[$index_no] : 0;
                $subscribeData = Subscribe::find($package);
                $userObj = User::create([
                    'full_name'   => $student_name,
                    'role_name'   => 'user',
                    'role_id'     => 1,
                    'email'       => 'test' . $rand_id . '@test.com',
                    'password'    => User::generatePassword('123456'),
                    'status'      => 'active',
                    'verified'    => true,
                    'created_at'  => time(),
                    'parent_type' => 'parent',
                    'parent_id'   => $user->id,
                ]);

                $UserSubscriptions = UserSubscriptions::create([
                    "buyer_id"       => $user->id,
                    "user_id"        => $userObj->id,
                    'order_id'       => $order->id,
                    'order_item_id'  => $orderItem->id,
                    'subscribe_id'   => $package,
                    'is_courses'     => $subscribeData->is_courses,
                    'is_timestables' => $subscribeData->is_timestables,
                    'is_bookshelf'   => $subscribeData->is_bookshelf,
                    'is_sats'        => $subscribeData->is_sats,
                    'is_elevenplus'  => $subscribeData->is_elevenplus,
                    "status"         => 'inactive',
                    "created_at"     => time(),
                    "expiry_at"      => $expiry_date,
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
        Sale::createSales($orderItem, Sale::$credit);

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
        Sale::createSales($orderItem, Sale::$credit);

        $toastData = [
            'title'  => 'public.request_success',
            'msg'    => trans('update.success_pay_msg_for_free_subscribe'),
            'status' => 'success'
        ];
        return back()->with(['toast' => $toastData]);
    }
}
