<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mixins\Installment\InstallmentPlans;
use App\Models\Books;
use App\Models\Page;
use App\Models\Product;
use App\Models\Blog;
use App\Models\HomeSection;
use App\Models\Quiz;
use App\Models\Subscribe;
use App\Models\Webinar;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use DB;

class PagesController extends Controller
{
    public function index(Request $request, $link)
    {

        $redirect_url = redirectCheck();
        if( $redirect_url != ''){
            return redirect($redirect_url);
        }
        $firstCharacter = substr($link, 0, 1);
        if ($firstCharacter !== '/') {
            $link = '/' . $link;
        }

        //DB::enableQueryLog();
        $page = Page::where('link', $link)->where('status', 'publish')->first();
        if( isset( $_GET['sitemap'] ) && $_GET['sitemap'] = 'generate'){
            $all_pages = Page::where('status', 'publish')->where('include_xml', 1)->get();
            if( !empty( $all_pages )){
                foreach( $all_pages as $pageData){

                    $requestData = array(
                        'getPathInfo' => $pageData->link,
                        'fullUrl' => url('/').$pageData->link,
                    );
                    putSitemap($requestData);
                }
            }
            pre('Done');
        }


        if( isset( $_GET['sitemap_products'] ) && $_GET['sitemap_products'] = 'generate'){
            $requestData = array(
                'getPathInfo' => '/products',
                'fullUrl' => url('/').'/products',
            );
            putSitemap($requestData);
            $all_products = Product::where('products.status', Product::$active)->get();
            if( !empty( $all_products )){
                foreach( $all_products as $productData){

                    $requestData = array(
                        'getPathInfo' => '/products/'.$productData->slug,
                        'fullUrl' => url('/').'/products/'.$productData->slug,
                    );
                    $requestImages = [];

                    if( !empty( $productData->getThumbnailAttribute() ) ){
                        $requestImages[]  = [
                            'loc' => $productData->getThumbnailAttribute(),
                            'title' => $productData->getTitleAttribute(),
                            'caption' => "Redeem your reward points to claim the '".$productData->getTitleAttribute()."', an eco-friendly and educational toy for children.",
                        ];
                    }
                    putSitemap($requestData, $requestImages);
                }
            }
            pre('Done');
        }

        if( isset( $_GET['sitemap_blog'] ) && $_GET['sitemap_blog'] = 'generate'){

            $requestData = array(
                'getPathInfo' => '/blog',
                'fullUrl' => url('/').'/blog',
            );
            putSitemap($requestData);
            $all_posts = Blog::where('status', 'publish')->get();
            if( !empty( $all_posts )){
                foreach( $all_posts as $postData){

                    $requestData = array(
                        'getPathInfo' => '/blog/'.$postData->slug,
                        'fullUrl' => url('/').'/blog/'.$postData->slug,
                    );
                    $requestImages = [];

                    if( isset( $postData->image) &&  !empty( $postData->image ) ){
                        $requestImages[]  = [
                            'loc' => $postData->image,
                            'title' => $postData->getTitleAttribute(),
                            'caption' => $postData->getTitleAttribute(),
                        ];
                    }
                    putSitemap($requestData, $requestImages);
                }
            }
            pre('Done');
        }

        //pre($request->fullUrl());
        //putSitemap($request);


        //$query = DB::getQueryLog();
        //pre($query);

        if (!empty($page)) {
            $data = [
                'pageTitle'       => $page->title,
                'pageDescription' => $page->seo_description,
                'page_title'       => $page->page_title,
                'pageRobot'       => $page->robot ? 'index, follow, all' : 'NOODP, nofollow, noindex',
                'page'            => $page
            ];

            if ($page->id == 26) {
                return view('web.default.landing.job_signup', $data);
            } elseif ($page->id == 36) {
                return view('web.default.pages.books', $data);
            } elseif ($page->id == 35) {
                return view('web.default.pages.stats', $data);
            } elseif ($page->id == 78) {
                return view('web.default.pages.stats1', $data);
            } elseif ($page->id == 9) {
                return view('web.default.pages.contact', $data);
            } elseif ($page->id == 17) {
                return view('web.default.pages.faqs', $data);
            } elseif ($page->id == 77) {
				
				$homeSections = HomeSection::orderBy('order', 'asc')->get();
				$selectedSectionsName = $homeSections->pluck('name')->toArray();
				
				if (in_array(HomeSection::$blog, $selectedSectionsName)) {
				$blog = Blog::where('status', 'publish')
						->with(['category', 'author' => function ($query) {
							$query->select('id', 'full_name');
						}])->orderBy('updated_at', 'desc')
						->withCount('comments')
						->orderBy('created_at', 'desc')
						->limit(3)
						->get();
				}
				$data['homeSections'] = $homeSections;
				$data['blog'] = $blog ?? [];
                return view('web.default.pages.contact2', $data);
            }elseif ($page->id == 133) {


                $all_pages = Page::where('status', 'publish')->get();

                $all_courses = array();//Webinar::where('status', 'active')->get();


                $all_books = array();//Books::get();
                $all_products = array();//Product::where('products.status', Product::$active)->get();
                $all_blog_posts = Blog::where('status', 'publish')->get();


                //$all_links = [];
                //$all_links = $this->crawl_page("https://rurera.chimpstudio.co.uk",2, false, $all_links);

                $data['all_pages'] = $all_pages;
                $data['all_courses'] = $all_courses;
                $data['all_books'] = $all_books;
                $data['all_products'] = $all_products;
                $data['all_blog_posts'] = $all_blog_posts;
                return view('web.default.pages.meta_detail', $data);
            } elseif ($page->id == 44) {
                return view('web.default.pages.quizpage', $data);
            } elseif ($page->id == 119) {

                $subscribes = Subscribe::all();
                $data['subscribes'] = $subscribes ?? [];


                return view('web.default.pages.packages', $data);
            } elseif ($page->id == 95) {

                $query = Quiz::where('status', Quiz::ACTIVE)->where('quiz_type', 'sats');
                $sats = $query->paginate(30);
                $QuestionsAttemptController = new QuestionsAttemptController();
                $data = [
                    'pageTitle'                  => $page->title,
					'page_title'       				=> $page->page_title,
                    'pageDescription'            => $page->seo_description,
                    'sats'                       => $sats,
                    'QuestionsAttemptController' => $QuestionsAttemptController
                ];
                return view('web.default.landing.11plus_landing', $data);

            } elseif ($page->id == 94) {

                $data = [
                    'pageTitle'                  => $page->title,
					'page_title'       => $page->page_title,
                    'pageDescription'            => $page->seo_description,
                ];
                return view('web.default.landing.rewards_landing', $data);

            } elseif ($page->id == 11) {
                $testimonials = Testimonial::where('status', 'active')->orderBy('testimonial_date', 'asc')->get();
                $data['testimonials'] = $testimonials;
                return view('web.default.landing.testimonials', $data);
            } else {
                if ($page->subheader == 0) {
                    return view('web.default.pages.nosubheader', $data);
                }
                return view('web.default.pages.other_pages', $data);
            }
        }

        abort(404);
    }

    public function crawl_page($url, $depth = 5, $is_child = false, $all_links){
    $seen = array();
    if(($depth == 0) or (in_array($url, $seen))){
        return;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec ($ch);
    curl_close ($ch);
    if( $result ){
        $stripped_file = strip_tags($result, "<a>");

        preg_match_all("/<a[\s]+[^>]*?href[\s]?=[\s\"\']+"."(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/", $stripped_file, $matches, PREG_SET_ORDER );
        foreach($matches as $match){
            $href = '';
            $href = $match[1];

                if (0 == strpos($href, 'http')) {
                    $path = '';
                    if ($is_child == true) {
                        $path .= '---';
                    }
                    $path .= ltrim($href, '/');
                    if ($is_child == true) {
                        $all_links[$url][] = $path;
                    }else{
                        $all_links[$url] = $path;
                    }


                    pre($path, false);
                    /*if (extension_loaded('http')) {
                        $href = http_build_url($href , array('path' => $path));
                    } else {
                        $parts = parse_url($href);
                        //$href = 'https://';
                        if (isset($parts['user']) && isset($parts['pass'])) {
                            $href .= $parts['user'] . ':' . $parts['pass'] . '@';
                        }
                        //pre($parts);
                        //$href .= 'rurera.chimpstudio.co.uk';
                        if (isset($parts['port'])) {
                            $href .= ':' . $parts['port'];
                        }
                        $href .= $path;
                        pre($href);
                        //pre($href);
                    }*/
                }
                $this->crawl_page($href, $depth - 1, true, $all_links);

            }
    }

    return $all_links;
    //echo "Crawled {$href}";
    }
}
