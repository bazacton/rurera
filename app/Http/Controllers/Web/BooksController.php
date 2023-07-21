<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\BooksPagesInfoLinks;
use App\Models\BooksUserPagesInfoLinks;
use Illuminate\Http\Request;
use App\Models\Testimonial;

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

        $bookObj = Books::where('book_slug', $book_slug)->with([
            'bookFinalQuiz.QuestionData',
            'bookPages.PageInfoLinks'
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
        //pre('test');

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
                    "QuizzesResult"         => $QuizzesResult,
                    "all_infolinks_checked" => $all_infolinks_checked,
                    "question"              => $questionObj,
                    "quizAttempt"           => $attemptLogObj,
                    "newQuestionResult"     => $newQuestionResult,
                    "question_no"           => $question_no,
                ]);
                break;

            default:

                BooksUserPagesInfoLinks::create([
                    'user_id'           => $user->id,
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


}
