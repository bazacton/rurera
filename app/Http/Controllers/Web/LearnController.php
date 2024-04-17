<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Category;
use App\Models\Page;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\UserAssignedTopics;
use App\Models\Webinar;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Mail;
use thiagoalessio\TesseractOCR\TesseractOCR;

class LearnController extends Controller
{

    public function index()
    {

        $user = getUser();
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->user()->isUser()) {
            return redirect('/'.panelRoute());
        }
        $allowedUsers = getAllowedUsers();

        $categoryObj = Category::where('id', 616)->first();
        $courses_list = Webinar::where('category_id', $categoryObj->id)->where('status', 'active')->get();

        $page = Page::where('link', '/learn')->where('status', 'publish')->first();
        if (!empty($courses_list)) {

            $data = [
                'pageTitle'       => isset( $page->title )? $page->title : '',
                'pageDescription' => isset( $page->seo_description )? $page->seo_description : '',
                'pageRobot'       => isset( $page->robot ) ? 'index, follow, all' : 'NOODP, nofollow, noindex',
                'courses_list'    => $courses_list,
                'categoryObj' => $categoryObj,
            ];
            return view('web.default.learn.index', $data);
        }

        abort(404);
    }


}
