<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Mixins\RegistrationPackage\UserPackage;
use App\Models\Product;
use App\Models\Subscribe;
use App\Models\Comment;
use App\Models\Gift;
use App\Models\Meeting;
use App\Models\ReserveMeeting;
use App\Models\Sale;
use App\Models\Support;
use App\Models\UserAssignedTopics;
use App\Models\Webinar;
use App\Models\ParentsOrders;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();



        $nextBadge = $user->getBadges(true, true);
        if (auth()->user()->isTeacher()) {
            return redirect('/admin');
        }

        $data = [
            'pageTitle' => trans('panel.dashboard'),
            'nextBadge' => $nextBadge
        ];

        if (!$user->isUser()) {

            $meetingIds = Meeting::where('creator_id', $user->id)->pluck('id')->toArray();
            $pendingAppointments = ReserveMeeting::whereIn('meeting_id', $meetingIds)
                ->whereHas('sale')
                ->where('status', ReserveMeeting::$pending)
                ->count();

            $userWebinarsIds = $user->webinars->pluck('id')->toArray();
            $supports = Support::whereIn('webinar_id', $userWebinarsIds)->where('status', 'open')->get();

            $comments = Comment::whereIn('webinar_id', $userWebinarsIds)
                ->where('status', 'active')
                ->whereNull('viewed_at')
                ->get();

            $time = time();
            $firstDayMonth = strtotime(date('Y-m-01', $time));// First day of the month.
            $lastDayMonth = strtotime(date('Y-m-t', $time));// Last day of the month.

            $monthlySales = Sale::where('seller_id', $user->id)
                ->whereNull('refund_at')
                ->whereBetween('created_at', [
                    $firstDayMonth,
                    $lastDayMonth
                ])
                ->get();

            $data['pendingAppointments'] = $pendingAppointments;
            $data['supportsCount'] = count($supports);
            $data['commentsCount'] = count($comments);
            $data['monthlySalesCount'] = count($monthlySales) ? $monthlySales->sum('total_amount') : 0;
            $data['monthlyChart'] = $this->getMonthlySalesOrPurchase($user);
        } else {
            $trending_toys = Product::where('status', 'active')->where('is_trending', 1)->orderByDesc('trending_at')->limit(10)->get();
            $shortlisted_products = isset( $user->shortlisted_products )? json_decode($user->shortlisted_products) : array();
            $shortlisted_products = is_array($shortlisted_products)? $shortlisted_products : (array) $shortlisted_products;
            $shortlisted_toys = Product::where('status', 'active')->whereIN('id', $shortlisted_products)->orderByDesc('trending_at')->limit(10)->get();
            $entitled_toys = Product::where('status', 'active')->where('point', '<=', $user->getRewardPoints())->orderByDesc('id')->limit(10)->get();


            $assignmentsArray = UserAssignedTopics::where('assigned_to_id', $user->id)
                ->where('status', 'active')
                ->where('start_at', '<=', time())
                ->where('deadline_date', '>=', time())
                ->with([
                    'StudentAssignmentData',
                ])
                ->get();

            //pre($user->id);


            $webinarsIds = $user->getPurchasedCoursesIds();

            $webinars = Webinar::whereIn('id', $webinarsIds)
                ->where('status', 'active')
                ->get();

            $reserveMeetings = ReserveMeeting::where('user_id', $user->id)
                ->whereHas('sale', function ($query) {
                    $query->whereNull('refund_at');
                })
                ->where('status', ReserveMeeting::$open)
                ->get();

            $supports = Support::where('user_id', $user->id)
                ->whereNotNull('webinar_id')
                ->where('status', 'open')
                ->get();

            $comments = Comment::where('user_id', $user->id)
                ->whereNotNull('webinar_id')
                ->where('status', 'active')
                ->get();

            $data['webinarsCount'] = count($webinars);
            $data['supportsCount'] = count($supports);
            $data['commentsCount'] = count($comments);
            $data['reserveMeetingsCount'] = count($reserveMeetings);
            $data['monthlyChart'] = $this->getMonthlySalesOrPurchase($user);
            $data['assignmentsArray'] = $assignmentsArray;
            $data['trending_toys'] = $trending_toys;
            $data['shortlisted_toys'] = $shortlisted_toys;
            $data['entitled_toys'] = $entitled_toys;
            $data['shortlisted_products'] = $shortlisted_products;

        }

        $data['giftModal'] = $this->showGiftModal($user);
        $data['userObj'] = $user;

        if (auth()->user()->isParent()) {


            $childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->with([
                    'userSubscriptions' => function ($query) {
                        $query->with(['subscribe']);
                    }
                ])
                ->get();

            $Sales = Sale::where('buyer_id', $user->id)->whereIn('type', array(
                'subscribe',
                'plan_expiry_update',
                'plan_update'
            ))->get();


            $ParentsOrders = ParentsOrders::where('user_id', $user->id)
                ->where('status', 'active')
                ->first();


            $time_zones = User::$timeZones;
            $frequencyArray = ParentsOrders::$frequencyArray;

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


            $subscribes = Subscribe::all();
            $data['subscribes'] = $subscribes ?? [];

            //return view(getTemplate() . '.panel.parent.dashboard', $data);
            return view(getTemplate() . '.panel.dashboard.index', $data);
            //return view(getTemplate() . '.panel.dashboard.index', $data);
        } else {
            return view(getTemplate() . '.panel.dashboard.index', $data);
        }
    }

    public function get_user_assignments(Request $request)
    {
        $user = auth()->user();
        $fetch_type = $request->get('fetch_type');

        $assignmentsQuery = UserAssignedTopics::where('assigned_to_id', $user->id);

        if ($fetch_type == 'upcoming') {
            $assignmentsQuery->where('status', 'active');
            $assignmentsQuery->where('start_at', '>', strtotime(date('Y-m-d')));
            $assignmentsQuery->where('deadline_date', '>', time());
        }
        if ($fetch_type == 'current') {
            $assignmentsQuery->where('status', 'active');
            $assignmentsQuery->where('start_at', '<=', time());
            $assignmentsQuery->where('deadline_date', '>=', time());
        }
        if ($fetch_type == 'previous') {
            $assignmentsQuery->where('status', 'completeds');
            //$assignmentsQuery->where('start_at', '<', strtotime(date('Y-m-d')));
            //$assignmentsQuery->where('deadline_date', '>=', time());
        }

        $assignmentsQuery->with([
                'StudentAssignmentData',
            ]);
        $assignmentsResults = $assignmentsQuery->get();

        $response = '';
        if ($assignmentsResults->count() > 0) {
            foreach ($assignmentsResults as $assignmentObj) {
                $assignmentTitle = $assignmentObj->StudentAssignmentData->title;
                $assignmentLink = '/assignment/'.$assignmentObj->id;
                $assignmentTitle .= '<span>'.dateTimeFormat($assignmentObj->deadline_date, 'd F Y').'</span>';
                $response .= '<li>
                                <div class="checkbox-field">
                                    <input type="checkbox" id="book">
                                    <label for="book">
                                        <a href="'.$assignmentLink.'">'.$assignmentTitle.'</a>
                                        <span>'. $assignmentObj->topic_type .'</span>
                                    </label>
                                </div>
                                <div class="assignment-controls">
                                    <span class="status-label success">'. $assignmentObj->status .'</span>
                                    <div class="controls-holder">
                                        
                                    </div>
                                </div>
                            </li>';
            }
        }else{
            $response .= '<li>No assigned assignments at the moment</li>';
        }

        echo $response;
        exit;
    }

    private function showGiftModal($user)
    {
        $gift = Gift::query()->where('email', $user->email)
            ->where('status', 'active')
            ->where('viewed', false)
            ->where(function ($query) {
                $query->whereNull('date');
                $query->orWhere('date', '<', time());
            })
            ->whereHas('sale')
            ->first();

        if (!empty($gift)) {
            $gift->update([
                'viewed' => true
            ]);

            $data = [
                'gift' => $gift
            ];

            $result = (string)view()->make('web.default.panel.dashboard.gift_modal', $data);
            $result = str_replace(array(
                "\r\n",
                "\n",
                "  "
            ), '', $result);

            return $result;
        }

        return null;
    }

    private function getMonthlySalesOrPurchase($user)
    {
        $months = [];
        $data = [];

        // all 12 months
        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create(date('Y'), $month);

            $start_date = $date->timestamp;
            $end_date = $date->copy()->endOfMonth()->timestamp;

            $months[] = trans('panel.month_' . $month);

            if (!$user->isUser()) {
                $monthlySales = Sale::where('seller_id', $user->id)
                    ->whereNull('refund_at')
                    ->whereBetween('created_at', [
                        $start_date,
                        $end_date
                    ])
                    ->sum('total_amount');

                $data[] = round($monthlySales, 2);
            } else {
                $monthlyPurchase = Sale::where('buyer_id', $user->id)
                    ->whereNull('refund_at')
                    ->whereBetween('created_at', [
                        $start_date,
                        $end_date
                    ])
                    ->count();

                $data[] = $monthlyPurchase;
            }
        }

        return [
            'months' => $months,
            'data'   => $data
        ];
    }
}
