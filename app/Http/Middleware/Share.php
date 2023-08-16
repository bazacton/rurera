<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Web\CartManagerController;
use App\Mixins\Financial\MultiCurrency;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Currency;
use App\Models\FloatingBar;
use App\Models\Webinar;
use App\User;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Share
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (auth()->check()) {
            $user = auth()->user();
            view()->share('authUser', $user);

            if (!$user->isAdmin()) {

                $unReadNotifications = $user->getUnReadNotifications();

                view()->share('unReadNotifications', $unReadNotifications);
            }
        }

        $cartManagerController = new CartManagerController();
        $carts = $cartManagerController->getCarts();
        $totalCartsPrice = Cart::getCartsTotalPrice($carts);

        view()->share('userCarts', $carts);
        view()->share('totalCartsPrice', $totalCartsPrice);

        $generalSettings = getGeneralSettings();
        view()->share('generalSettings', $generalSettings);


        $currency = currencySign();
        view()->share('currency', $currency);

        if (getFinancialCurrencySettings('multi_currency')) {
            $multiCurrency = new MultiCurrency();
            $currencies = $multiCurrency->getCurrencies();

            if ($currencies->isNotEmpty()) {
                view()->share('currencies', $currencies);
            }
        }


        // locale config
        if (!Session::has('locale')) {
            Session::put('locale', mb_strtolower(getDefaultLocale()));
        }
        App::setLocale(session('locale'));


        $categoryQuery = Category::query();
        $course_navigation_data = $categoryQuery->with([
            'webinars' => function ($query) {
                $query->with('chapters');
            }
        ])->where('parent_id', '>', 0)->orderBy('order', 'ASC')->get();


        $category_colors = array(
            'ks1'    => '#015da5',
            'ks2'    => '#015da5',
            'year-2' => '#ad382b',
            'year-1' => '#9f1dbe',
            'year-5' => '#2bae68',
            'year-3' => '#ad382b',
            'year-4' => '#333333',
            'year-6' => '#9f1dbe',
        );
        $course_navigation = array();
        if (!empty($course_navigation_data)) {
            foreach ($course_navigation_data as $categoryObj) {
                if ($categoryObj->slug != '') {
                    $category_colors[$categoryObj->slug] = $categoryObj->color;
                    $category_name = $categoryObj->getTitleAttribute();
                    $course_navigation[$categoryObj->slug]['title'] = $category_name;
                    $course_navigation[$categoryObj->slug]['color'] = $category_colors[$categoryObj->slug];
                    if ($categoryObj->menu_data != '') {
                        $course_navigation[$categoryObj->slug]['menu_data'] = $categoryObj->menu_data;
                    }
                    if (!empty($categoryObj->webinars)) {
                        foreach ($categoryObj->webinars as $webinarObj) {
                            $chapter_title = $webinarObj->getTitleAttribute();
                            $course_navigation[$categoryObj->slug]['chapters'][$webinarObj->id]['chapter_title'] = $chapter_title;
                            $course_navigation[$categoryObj->slug]['chapters'][$webinarObj->id]['chapter_slug'] = $webinarObj->slug;
                            if (!empty($webinarObj->chapters)) {
                                foreach ($webinarObj->chapters as $chapterObj) {
                                    $topic_title = $chapterObj->getTitleAttribute();
                                    $course_navigation[$categoryObj->slug]['chapters'][$webinarObj->id]['topics'][$chapterObj->id] = $topic_title;
                                }
                            }
                        }
                    }
                }
            }
        }

        //pre($course_navigation);


        //$courses_list = Webinar::where('category_id', $course->category->id)->get();


        view()->share('categories', \App\Models\Category::getCategories());
        $navData = array();
        $navData['navbarPages'] = getNavbarLinks();
        $navData['profile_navs'] = array();

        if (auth()->check()) {
            if( $user->is_from_parent > 0){
                $parent = User::where('id', $user->parent_id)->get();
                $navData['profile_navs'] = $parent;
            }
            if (auth()->user()->isParent()) {
                $childs = User::where('role_id', 1)
                    ->where('parent_type', 'parent')
                    ->where('parent_id', $user->id)
                    ->with([
                        'userSubscriptions' => function ($query) {
                            $query->with(['subscribe']);
                        }
                    ]);


                $childs = $childs->get();

                $navData['profile_navs'] = $childs;


            }
        }


        view()->share('navData', $navData);
        view()->share('course_navigation', $course_navigation);


        $floatingBar = FloatingBar::getFloatingBar($request);
        view()->share('floatingBar', $floatingBar);

        return $next($request);
    }
}
