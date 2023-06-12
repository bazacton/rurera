<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class PagesController extends Controller
{
    public function index($link)
    {
        $firstCharacter = substr($link , 0 , 1);
        if ($firstCharacter !== '/') {
            $link = '/' . $link;
        }

        $page = Page::where('link' , $link)
            ->where('status' , 'publish')
            ->first();

        if (!empty($page)) {
            $data = [
                'pageTitle'       => $page->title ,
                'pageDescription' => $page->seo_description ,
                'pageRobot'       => $page->robot ? 'index, follow, all' : 'NOODP, nofollow, noindex' ,
                'page'            => $page
            ];

            if ($page->id == 26) {
                return view('web.default.pages.job_signup' , $data);
            } elseif ($page->id == 36) {
                return view('web.default.pages.books' , $data);
            } elseif ($page->id == 35) {
                return view('web.default.pages.stats' , $data);
            } elseif ($page->id == 9) {
                return view('web.default.pages.contact' , $data);
            } elseif ($page->id == 17) {
                return view('web.default.pages.faqs' , $data);
            } elseif ($page->id == 77) {
                return view('web.default.pages.contact2' , $data);
            } elseif ($page->id == 11) {
                $testimonials = Testimonial::where('status' , 'active')->orderBy('testimonial_date' , 'asc')->get();
                $data['testimonials'] = $testimonials;
                return view('web.default.pages.testimonials' , $data);
            } else {
                if ($page->subheader == 0) {
                    return view('web.default.pages.nosubheader' , $data);
                }
                return view('web.default.pages.other_pages' , $data);
            }
        }

        abort(404);
    }
}
