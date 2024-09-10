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
		$hide_subjects = json_decode($user->hide_subjects);
		$hide_subjects = is_array($hide_subjects)? $hide_subjects : array();
		

        $categoryObj = Category::where('id', $user->year_id)->first();
        $courses_list = Webinar::whereJsonContains('category_id', (string) $categoryObj->id);
		$courses_list = $courses_list->whereNotIn('id', $hide_subjects);
		$courses_list = $courses_list->where('status', 'active')->get();
		
		//pre($courses_list);
		
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
