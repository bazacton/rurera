<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\BooksPages;
use App\Models\BooksPagesInfoLinks;
use App\Models\BooksUserPagesInfoLinks;
use App\Models\BooksUserReading;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{

    public function index()
    {

        $books_data = Books::get();

        $books = array();

        if (!empty($books_data)) {
            foreach ($books_data as $bookObj) {
                if (isset($bookObj->book_category) && $bookObj->book_category != '') {
                    $books[$bookObj->book_category][] = $bookObj;
                }
            }
        }
        if (!empty($books)) {
            $data = [
                'pageTitle' => 'Books',
                'books'     => $books,
            ];
            return view('web.default.pages.books', $data);
        }

        abort(404);
    }

    public function book($book_slug)
    {
        if (!auth()->subscription('bookshelf')) {
            return view('web.default.quizzes.not_subscribed');
        }
        $user = auth()->user();


        $bookObj = Books::where('book_slug', $book_slug)->with([
            'bookFinalQuiz.QuestionData',
            'bookPages.PageInfoLinks',
            'bookPages.BooksPageUserReadings' => function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('status', 'active');
            } ,
        ])->first();

        $page_content = array();
        $info_type = array();
        if (!empty($bookObj->bookPages)) {
            foreach ($bookObj->bookPages as $page_data) {

                $info_link_html = '';
                if (!empty($page_data->PageInfoLinks)) {
                    foreach ($page_data->PageInfoLinks as $pageInfoLinks) {

                        $data_values = isset($pageInfoLinks['data_values']) ? json_decode($pageInfoLinks['data_values']) : array();
                        $info_link_html .= '<div class="info_link_div info_link_' . $pageInfoLinks['info_type'] . '" style="width: max-content;position:absolute;' . $pageInfoLinks['info_style'] . '">';
                        switch ($pageInfoLinks['info_type']) {
                            case "text":
                                $info_link_html .= '<span style="' . $data_values->text_color . '">';
                                $info_link_html .= isset($data_values->text_html) ? $data_values->text_html : '';
                                $info_link_html .= '</span>';
                                break;

                            case "highlighter":
                                $info_link_html .= '<span style="position: absolute;opacity: 0.7;' . $data_values->highlighter_size . '; ' . $data_values->highlighter_background . '">';
                                $info_link_html .= '</span>';
                                break;

                            default:
                                $info_link_html .= '<span class="book-info-link" data-id="' . $pageInfoLinks['id'] . '" data-type="' . $pageInfoLinks['info_type'] . '"><img src="/assets/default/img/book-icons/' . $pageInfoLinks['info_type'] . '.png" style="width: 42px;height: auto;"></span>';
                                break;
                        }

                        $info_link_html .= '</div>';
                    }
                }
                $page_content[$page_data->id] = $info_link_html;
            }
        }
        //pre($bookObj);

        if (!empty($bookObj)) {
            $data = [
                'pageTitle'    => $bookObj->book_title,
                'book'         => $bookObj,
                'page_content' => $page_content,
            ];
            return view('web.default.pages.book', $data);
        }

        abort(404);
    }

    /*
     * Book Activity
     */

    public function bookActivity($book_slug)
    {


        if (!auth()->subscription('bookshelf')) {
            return view('web.default.quizzes.not_subscribed');
        }

        $bookObj = Books::where('book_slug', $book_slug)->with([
            'bookUserActivities.bookInfoLinkDetail.BooksInfoLinkPage',
            'bookPageInfoLinks.BooksInfoLinkPage',
            'BooksUserReadings'
        ])->first();


        $bookPageInfoLinks = $bookObj->bookPageInfoLinks;

        $bookUserActivities = $bookObj->bookUserActivities;

        $bookUserActivities = $bookUserActivities->groupBy(function ($bookUserActivitiesQuery) {
            return date('d F Y', $bookUserActivitiesQuery->created_at);
        });

        $bookPageInfoLinks = $bookPageInfoLinks->groupBy(function ($bookPageInfoLinks) {
            return $bookPageInfoLinks->BooksInfoLinkPage->page_no;
        });

        //pre($bookPageInfoLinks);

        //pre($bookUserActivities);

        if (!empty($bookObj)) {
            $data = [
                'pageTitle'          => $bookObj->book_title,
                'book'               => $bookObj,
                'bookUserActivities' => $bookUserActivities,
                'bookPageInfoLinks'  => $bookPageInfoLinks,
            ];
            return view('web.default.books.activity', $data);
        }

        abort(404);
    }

    public function info_detail($info_id)
    {
        $user = auth()->user();

        $infoLinkData = BooksPagesInfoLinks::where('id', $info_id)->first();
        $info_type = isset($infoLinkData->info_type) ? $infoLinkData->info_type : '';
        $response = '';

        /*BooksUserPagesInfoLinks::create([
            'user_id'             => $user->id ,
            'book_info_link_id'   => $info_id ,
            'status'              => 'active',
            'created_by'          => $user->id ,
            'created_at'          => time() ,
        ]);*/

        switch ($info_type) {

            case "quiz":

                BooksUserPagesInfoLinks::create([
                    'user_id'           => $user->id,
                    'book_id'           => $infoLinkData->book_id,
                    'book_info_link_id' => $info_id,
                    'status'            => 'active',
                    'created_by'        => $user->id,
                    'created_at'        => time(),
                ]);

                $user_info_links_ids = BooksUserPagesInfoLinks::where('user_id', $user->id)->pluck('book_info_link_id')->toArray();


                $data_values = json_decode($infoLinkData->data_values);
                $questions_ids = (isset($data_values->questions_ids) && $data_values->questions_ids != '') ? explode(',', $data_values->questions_ids) : array();
                $dependent_info = isset($data_values->dependent_info) ? explode(',', $data_values->dependent_info) : array();
                $no_of_attempts = (isset($data_values->no_of_attempts) && $data_values->no_of_attempts != '') ? $data_values->no_of_attempts : 0;
                $all_infolinks_checked = (count(array_intersect($dependent_info, $user_info_links_ids))) ? true : false;
                $all_infolinks_checked = true;

                if ($all_infolinks_checked == true) {

                    $QuestionsAttemptController = new QuestionsAttemptController();

                    $resultLogObj = $QuestionsAttemptController->createResultLog([
                        'parent_type_id'   => $infoLinkData->id,
                        'quiz_result_type' => 'book_page',
                        'questions_list'   => $questions_ids,
                        'no_of_attempts'   => $no_of_attempts,
                    ]);

                    $attemptLogObj = $QuestionsAttemptController->createAttemptLog($resultLogObj);
                    $attempt_log_id = createAttemptLog($attemptLogObj->id, 'Session Started', 'started');
                    $nextQuestionArray = $QuestionsAttemptController->nextQuestion($attemptLogObj);
                    $questionObj = isset($nextQuestionArray['questionObj']) ? $nextQuestionArray['questionObj'] : array();
                    $question_no = isset($nextQuestionArray['question_no']) ? $nextQuestionArray['question_no'] : 0;
                    $newQuestionResult = isset($nextQuestionArray['newQuestionResult']) ? $nextQuestionArray['newQuestionResult'] : array();
                    $QuizzesResult = isset($nextQuestionArray['QuizzesResult']) ? $nextQuestionArray['QuizzesResult'] : (object)array();
                    //pre($newQuestionResult);

                }

                $response = view("web.default.books.includes." . $info_type, [
                    "pageInfoLink"          => $infoLinkData,
                    "QuizzesResult"         => isset($QuizzesResult) ? $QuizzesResult : array(),
                    "all_infolinks_checked" => $all_infolinks_checked,
                    "question"              => isset($questionObj) ? $questionObj : array(),
                    "quizAttempt"           => isset($attemptLogObj) ? $attemptLogObj : array(),
                    "newQuestionResult"     => isset($newQuestionResult) ? $newQuestionResult : array(),
                    "question_no"           => isset($question_no) ? $question_no : 0,
                ]);
                break;

            default:

                BooksUserPagesInfoLinks::create([
                    'user_id'           => $user->id,
                    'book_id'           => $infoLinkData->book_id,
                    'book_info_link_id' => $info_id,
                    'status'            => 'active',
                    'created_by'        => $user->id,
                    'created_at'        => time(),
                ]);
                $response = view("web.default.books.includes." . $info_type, ["pageInfoLink" => $infoLinkData]);
                break;
        }

        echo $response;
        exit;

    }

    /*
     * Update Reading of Pages for Book
     */
    public function update_reading(Request $request)
    {
        $user = auth()->user();
        $page_ids = $request->get('page_ids');
        $time_lapsed = $request->get('time_lapsed');
        //pre('test');
        if (!empty($page_ids)) {
            foreach ($page_ids as $page_id) {
                $bookPage = BooksPages::find($page_id);
                $bookUserReadingObj = BooksUserReading::where('page_id', $page_id)->where('user_id', $user->id)->where('status', 'active')->first();
                if (isset($bookUserReadingObj->id)) {
                    $bookUserReadingObj->update([
                        'page_id'    => $page_id,
                        'read_time'  => $time_lapsed,
                        'updated_at' => time(),
                    ]);

                } else {
                    BooksUserReading::create([
                        'user_id'    => $user->id,
                        'book_id'    => $bookPage->book_id,
                        'page_id'    => $page_id,
                        'read_time'  => $time_lapsed,
                        'status'     => 'active',
                        'created_at' => time(),
                        'updated_at' => time(),
                    ]);
                }
            }
        }
        pre($page_ids);
    }


}
