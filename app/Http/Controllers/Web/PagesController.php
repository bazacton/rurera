<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mixins\Installment\InstallmentPlans;
use App\Models\Page;
use App\Models\Quiz;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use DB;

class PagesController extends Controller
{
    public function index($link)
    {
        $firstCharacter = substr($link, 0, 1);
        if ($firstCharacter !== '/') {
            $link = '/' . $link;
        }

        //DB::enableQueryLog();
        $page = Page::where('link', $link)->where('status', 'publish')->first();

        //$query = DB::getQueryLog();
        //pre($query);

        if (!empty($page)) {
            $data = [
                'pageTitle'       => $page->title,
                'pageDescription' => $page->seo_description,
                'pageRobot'       => $page->robot ? 'index, follow, all' : 'NOODP, nofollow, noindex',
                'page'            => $page
            ];

            if ($page->id == 26) {
                return view('web.default.pages.job_signup', $data);
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
                return view('web.default.pages.contact2', $data);
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
                    'pageDescription'            => $page->seo_description,
                    'sats'                       => $sats,
                    'QuestionsAttemptController' => $QuestionsAttemptController
                ];
                return view('web.default.pages.11plus', $data);

            } elseif ($page->id == 11) {
                $testimonials = Testimonial::where('status', 'active')->orderBy('testimonial_date', 'asc')->get();
                $data['testimonials'] = $testimonials;
                return view('web.default.pages.testimonials', $data);
            } else {
                if ($page->subheader == 0) {
                    return view('web.default.pages.nosubheader', $data);
                }
                return view('web.default.pages.other_pages', $data);
            }
        }

        abort(404);
    }
}
