<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Category;
use App\Models\Page;
use App\Models\Subscribe;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use GPAY\GooglePay;

class PricingController extends Controller
{

    public function index(Request $request)
    {

        $page = Page::where('link', '/pricing')->where('status', 'publish')->first();
        $subscribes = Subscribe::all();
        $data = [
            'pageTitle'                  => isset( $page->title )? $page->title : '',
            'pageDescription'            => isset( $page->seo_description )? $page->seo_description : '',
            'pageRobot'                  => isset( $page->robot ) ? 'index, follow, all' : 'NOODP, nofollow, noindex',
            'subscribes'                  => $subscribes ?? [],
        ];
        return view('web.default.pricing.index', $data);

        abort(404);
    }

}
