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

class GamesController extends Controller
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

        $data = [
            'pageTitle'       => 'Games',
            'pageDescription' => isset( $page->seo_description )? $page->seo_description : '',
            'pageRobot'       => isset( $page->robot ) ? 'index, follow, all' : 'NOODP, nofollow, noindex',
        ];
        return view('web.default.games.index', $data);

        abort(404);
    }

    public function WordScramble()
    {

        $user = getUser();
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->user()->isUser()) {
            return redirect('/'.panelRoute());
        }

        if( $user->game_time > 0) {

            $data = [
                'pageTitle'       => 'Word Scramble',
                'pageDescription' => isset($page->seo_description) ? $page->seo_description : '',
                'pageRobot'       => isset($page->robot) ? 'index, follow, all' : 'NOODP, nofollow, noindex',
            ];
            return view('web.default.games.word_scramble', $data);
        }else{
            return view('web.default.games.no_game_time', []);
        }

        abort(404);
    }


}
