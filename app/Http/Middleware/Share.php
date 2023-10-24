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
                $query->with('chapters.subChapters');
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
                                    $course_navigation[$categoryObj->slug]['chapters'][$webinarObj->id]['topics'][$chapterObj->id]['title'] = $topic_title;
                                    $course_navigation[$categoryObj->slug]['chapters'][$webinarObj->id]['topics'][$chapterObj->id]['custom_link'] = $chapterObj->custom_link;


                                    $course_navigation[$categoryObj->slug]['chapters'][$webinarObj->id]['topics'][$chapterObj->id]['sub_chapters'] = array();
                                    if( isset( $chapterObj->subChapters ) && !empty($chapterObj->subChapters)){
                                        foreach( $chapterObj->subChapters as $subChapterObj){
                                            $course_navigation[$categoryObj->slug]['chapters'][$webinarObj->id]['topics'][$chapterObj->id]['sub_chapters'][] = array(
                                                'sub_chapter_title' => $subChapterObj->sub_chapter_title,
                                                'sub_chapter_slug' => $subChapterObj->sub_chapter_slug,
                                                'sub_chapter_image' => $subChapterObj->sub_chapter_image,
                                            );

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        //pre('test');

        //pre($course_navigation);

        if( isset( $_GET['sitemap'] ) && $_GET['sitemap'] = 'generate'){
            foreach( $course_navigation as $navigation_slug => $courseObj){
                if( !empty( $courseObj['chapters'] ) ){
                    foreach( $courseObj['chapters'] as $courseSUbjectObj){
                        $requestData = array(
                            'getPathInfo' => '/'.$navigation_slug.'/'.$courseSUbjectObj['chapter_slug'],
                            'fullUrl' => url('/').'/'.$navigation_slug.'/'.$courseSUbjectObj['chapter_slug'],
                        );
                        //putSitemap($requestData);
                        $chapters = isset( $courseSUbjectObj['topics'] )? $courseSUbjectObj['topics'] : array();
                        if( !empty( $chapters)){
                            foreach( $chapters as $chapter_slug => $chapterObj){
                                $sub_chapters = isset( $chapterObj['sub_chapters'] )? $chapterObj['sub_chapters'] : array();
                                if( !empty( $sub_chapters )){
                                    foreach( $sub_chapters as $subChapterObj){
                                        $requestData = array(
                                            'getPathInfo' => '/'.$navigation_slug.'/'.$courseSUbjectObj['chapter_slug'].'/'.$subChapterObj['sub_chapter_slug'],
                                            'fullUrl' => url('/').'/'.$navigation_slug.'/'.$courseSUbjectObj['chapter_slug'].'/'.$subChapterObj['sub_chapter_slug'],
                                        );
                                        $requestImages = [];
                                        if( isset( $subChapterObj['sub_chapter_image']) && $subChapterObj['sub_chapter_image'] != ''){
                                            $requestImages = [
                                                [
                                                    'loc' => $subChapterObj['sub_chapter_image'],
                                                    'title' => $subChapterObj['sub_chapter_title'].' ('.$courseObj['title'].' '.$courseSUbjectObj['chapter_title'].' practice)',
                                                    'caption' => "Fun maths practice! Improve your skills with free problems in '".$subChapterObj['sub_chapter_title']."' and thousands of other practice lessons.",
                                                ]
                                            ];
                                            //pre($requestImages);
                                        }
                                        putSitemap($requestData, $requestImages);
                                        //pre($requestData, false);
                                    }
                                }
                            }
                        }
                    }
                }
                //pre($courseObj);
            }
            pre('test');
        }

        //pre($course_navigation);


        //$courses_list = Webinar::where('category_id', $course->category->id)->get();


        view()->share('categories', \App\Models\Category::getCategories());
        $navData = array();
        $navData['navbarPages'] = getNavbarLinks();
        $navData['profile_navs'] = array();
		$navData['is_parent'] = false;
        if (auth()->check()) {
            if( $user->is_from_parent > 0){
                $parent = User::where('id', $user->parent_id)->get();
                $navData['profile_navs'] = $parent;
				$navData['is_parent'] = true;
            }
            if (auth()->user()->isParent()) {
				$navData['is_parent'] = false;
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
		
		//pre($navData);
        //pre($course_navigation);


        view()->share('navData', $navData);
        view()->share('course_navigation', $course_navigation);


        $floatingBar = FloatingBar::getFloatingBar($request);
        view()->share('floatingBar', $floatingBar);

        return $next($request);
    }
}
