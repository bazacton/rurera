<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Books;
use App\Models\BooksPages;
use App\Models\BooksPagesInfoLinks;
use App\Models\BooksUserPagesInfoLinks;
use App\Models\BooksUserReading;
use App\Models\BooksPagesObjects;
use App\Models\Blog;
use App\Models\HomeSection;
use App\Models\QuizzResultQuestions;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{

    public function index(Request $request)
    {

        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->user()->isUser()) {
            return redirect('/'.panelRoute());
        }
		
		
		$book_type = isset( $_GET['type'] )? $_GET['type'] : 'Book';
		$book_type = ($book_type == 'PDF')? 'PDF' : 'Book';
        $books_data = Books::where('id', '>', 0)->where('book_type', $book_type);
        $search_keyword = $request->get('search', '');

        if( $search_keyword != '') {
            $books_data = $books_data->where('book_title', 'like', "%$search_keyword%")
                ->orWhere('written_by', 'like', "%$search_keyword%")
                ->orWhere('skill_set', 'like', "%$search_keyword%")
                ->orWhere('interest_area', 'like', "%$search_keyword%")
                ->orWhere('book_category', 'like', "%$search_keyword%")
                ->orWhere('words_bank', 'like', "%$search_keyword%");
        }

        $books_data = $books_data->get();
        $books = array();

        if (!empty($books_data)) {
            foreach ($books_data as $bookObj) {
                if (isset($bookObj->book_category) && $bookObj->book_category != '') {
                    $books[$bookObj->book_category][] = $bookObj;
                }
            }
        }

        //putSitemap($request);

        if (!empty($books)) {
            $data = [
                'pageTitle' => 'Books',
                'books'     => $books,
            ];
            return view('web.default.pages.books', $data);
        }

        abort(404);
    }

    public function books_shelf(Request $request)
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

            putSitemap($request);
			
			$page = Page::where('link', '/books-shelf')->where('status', 'publish')->first();
			
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

            if (!empty($books)) {
                $data = [
                    'pageTitle'                  => isset( $page->title )? $page->title : '',
					'page_title'                  => isset( $page->page_title )? $page->page_title : '',
					'pageDescription'            => isset( $page->seo_description )? $page->seo_description : '',
					'pageRobot'                  => isset( $page->robot ) ? 'index, follow, all' : 'NOODP, nofollow, noindex',
                    'books'     => $books,
                    'homeSections'     => $homeSections,
					'blog' => $blog ?? [],
                ];
                return view('web.default.landing.books_landing', $data);
            }

            abort(404);
        }

    public function book($book_slug)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->subscription('bookshelf')) {
            return view('web.default.quizzes.not_subscribed');
        }
        $user = getUser();


        $bookObj = Books::where('book_slug', $book_slug)->with([
            'bookFinalQuiz.QuestionData',
            'bookPages.PageInfoLinks',
            'bookPages.BooksPageUserReadings' => function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('status', 'active');
            },
        ])->first();
        //pre($bookObj);

        $pagesLimit = getGuestLimit('books');
        $page_content = array();
        $info_type = array();
        $pages_count = 0;
        if (!empty($bookObj->bookPages)) {
            foreach ($bookObj->bookPages as $page_data) {
                $pages_count++;
				
				$page_path = $page_data->page_path;
				
				$rendered_width	= 803;
				
				
				$image_size = getimagesize($page_path);
				$rendered_height = 0;
				if ($image_size) {
					$original_width = $image_size[0];
					$original_height = $image_size[1];

					// Calculate the rendered height while keeping the aspect ratio
					$rendered_height = ($rendered_width / $original_width) * $original_height;
					$rendered_height = round($rendered_height, 2);
				}
				


                $info_link_html = '';
				
				
				if (!empty($page_data->pageObjects->where('status', 'active'))) {
                    foreach ($page_data->pageObjects->where('status', 'active') as $pageInfoLinks) {
						
						
						$item_type = isset( $pageInfoLinks->item_type )? $pageInfoLinks->item_type : '';
						$item_path_folder = '';
						$item_path_folder = ($item_type == 'infolink' )? 'infolinks' : $item_path_folder;
						$item_path_folder = ($item_type == 'stage_objects' )? 'objects' : $item_path_folder;
						$item_path_folder = ($item_type == 'misc' )? 'misc' : $item_path_folder;
						$item_path_folder = ($item_type == 'topic' )? 'topics' : $item_path_folder;

                        $data_values = isset($pageInfoLinks->data_values) ? json_decode($pageInfoLinks->data_values) : array();
						
						
						$fill_color = isset( $data_values->fill_color )? $data_values->fill_color : '';
						$style_parameter = '';
						$field_style = isset( $pageInfoLinks->field_style ) ?  $pageInfoLinks->field_style : '';
						$field_style_old = $field_style;
						$item_path = isset( $pageInfoLinks->item_path ) ?  $pageInfoLinks->item_path : '';
						$item_path = 'assets/books-editor/'.$item_path_folder.'/'.$item_path;
						$item_path_img = '/assets/books-editor/'.$item_path_folder.'/default/'.$pageInfoLinks->item_slug.'.svg';
						$svgCode = getFileContent($item_path);
						$svgCode = updateSvgDimensions($svgCode, '100%', '100%');
						//pre($svgCode);
						
						
						
						//pre($field_style, false);

						
						$info_link_html .= '<style>';
						if( $fill_color != ''){
							$info_link_html .= '.book_page_object_' . $pageInfoLinks->id . ' svg rect {
								fill: ' . $fill_color . ' !important;
							}';
						}
						$info_link_html .= '</style>';
						
						
						
						$info_link_html .= '<div class="info_link_div book_page_object_' . $pageInfoLinks->id . ' info_link_' . $pageInfoLinks->item_slug . '" style="width: max-content;position:absolute;' . $field_style . '">';

						
						
						
                        switch ($item_type) {
                            case "text":
                                $info_link_html .= '<span style="' . $data_values->text_color . '">';
                                $info_link_html .= isset($data_values->text_html) ? $data_values->text_html : '';
                                $info_link_html .= '</span>';
                                break;
								
								
							case "topic":
                                $info_link_html .= '<span>';
                                $info_link_html .= isset($data_values->topic_title) ? $data_values->topic_title : '';
                                $info_link_html .= '</span>';
                                break;	
								
							case "map":
                               $info_link_html .= '<span class="book-info-link" data-id="' . $pageInfoLinks['id'] . '" data-type="' . $pageInfoLinks['info_type'] . '"><img src="/assets/default/img/book-icons/' . $pageInfoLinks['info_type'] . '.svg" style="width: 800px !important;height: auto !important;"></span>';
                                break;

                            case "highlighter":
                                $highlighter_size = isset( $data_values->highlighter_size )? $data_values->highlighter_size : 0;
                                $info_link_html .= '<span style="position: absolute;opacity: 0.7;' . $highlighter_size . '; ' . $data_values->highlighter_background . '">';
                                $info_link_html .= '</span>';
                                break;

                            default:
							
								//$svgCode = '<img src="'.$item_path_img.'" style="width: -webkit-fill-available;">';
                                $info_link_html .= '<span class="book-info-link" data-id="' . $pageInfoLinks->id . '" data-type="' . $pageInfoLinks->item_slug . '">'.$svgCode.'</span>';
                                break;
                        }

                        $info_link_html .= '</div>';
						//pre($info_link_html, false);
                    }
                }
                $page_content[$page_data->id] = $info_link_html;
            }
        }

        if (!empty($bookObj)) {
            $data = [
                'pageTitle'    => $bookObj->book_title,
                'book'         => $bookObj,
                'page_content' => $page_content,
                'pagesLimit'   => $pagesLimit,
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

        $book_opened = isset($bookObj->BooksUserReadings->first()->created_at) ? $bookObj->BooksUserReadings->first()->created_at : 0;

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
                'book_opened'        => $book_opened,
            ];
            return view('web.default.books.activity', $data);
        }

        abort(404);
    }

    public function info_detail($info_id)
    {
        $user = getUser();

        $infoLinkData = BooksPagesObjects::where('id', $info_id)->first();
        $info_type = isset($infoLinkData->item_slug) ? $infoLinkData->item_slug : '';
        $response = '';


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
                //pre($all_infolinks_checked);
                //$all_infolinks_checked = true;
                $questions_layout = $results_questions_array = array();
                $questions_array = $exclude_array = array();
                $active_question_id = $first_question_id = 0;

                if ($all_infolinks_checked == true) {

                    $QuestionsAttemptController = new QuestionsAttemptController();

                    $resultLogObj = $QuestionsAttemptController->createResultLog([
                        'parent_type_id'   => $infoLinkData->id,
                        'quiz_result_type' => 'book_page',
                        'questions_list'   => $questions_ids,
                        'no_of_attempts'   => $no_of_attempts,
                    ]);
                    $prev_active_question_id = isset($resultLogObj->active_question_id) ? $resultLogObj->active_question_id : 0;

                    if ($prev_active_question_id > 0) {
                        $prevActiveQuestionObj = QuizzResultQuestions::find($prev_active_question_id);
                        $prev_active_question_id = isset($prevActiveQuestionObj->question_id) ? $prevActiveQuestionObj->question_id : 0;
                    }

                    $questions_list = $questions_ids;

                    $attemptLogObj = $QuestionsAttemptController->createAttemptLog($resultLogObj);
                    $attempt_log_id = createAttemptLog($attemptLogObj->id, 'Session Started', 'started');
                    //$nextQuestionArray = $QuestionsAttemptController->nextQuestion($attemptLogObj, $exclude_array, 0, true, $questions_list, $resultLogObj, $question_id, $question_no_index);



                    //$exclude_array[] = $questionObj->id;
                    //$questions_array[] = $questionObj;




                    if (!empty($questions_list)) {
                        $questions_counter = 0;
                        foreach ($questions_list as $question_no_index => $question_id) {
                            $question_no = $question_no_index;
                            $prev_question = isset($questions_list[$question_no_index - 2]) ? $questions_list[$question_no_index - 2] : 0;
                            $next_question = isset($questions_list[$question_no_index + 1]) ? $questions_list[$question_no_index + 1] : 0;

                            $nextQuestionArray = $QuestionsAttemptController->nextQuestion($attemptLogObj, $exclude_array, 0, true, $questions_list, $resultLogObj, $question_id, $question_no_index);

                            $questionObj = isset($nextQuestionArray['questionObj']) ? $nextQuestionArray['questionObj'] : array();

                            $newQuestionResult = isset($nextQuestionArray['newQuestionResult']) ? $nextQuestionArray['newQuestionResult'] : array();

                            if ($question_id == $prev_active_question_id) {
                                $active_question_id = $newQuestionResult->id;
                            }

                            if (isset($questionObj->id)) {
                                $questions_array[] = $newQuestionResult;
                                $exclude_array[] = $newQuestionResult->id;

                                $question_no = $question_no_index + 1;
                                if ($question_no_index == 0) {
                                    $first_question_id = $newQuestionResult->id;
                                }

                                $question_response_layout = '';


                                $results_questions_array[$newQuestionResult->id] = [
                                    'question'          => $questionObj,
                                    'prev_question'     => $prev_question,
                                    'next_question'     => $next_question,
                                    'quizAttempt'       => $attemptLogObj,
                                    'questionsData'     => rurera_encode($questionObj),
                                    'newQuestionResult' => $newQuestionResult,
                                    'question_no'       => $question_no,
                                    'quizResultObj'     => $resultLogObj
                                ];


                            }
                            $questions_counter++;

                        }
                    }

                    if (!empty($results_questions_array)) {
                        $questions_list = array_keys($results_questions_array);
                        $resultLogObj->update([
                            'questions_list' => json_encode($questions_list),
                        ]);
                        $attemptLogObj->update([
                            'questions_list' => json_encode($questions_list),
                        ]);
                        foreach ($results_questions_array as $resultQuestionID => $resultsQuestionsData) {

                            $resultsQuestionsData['prev_question'] = 0;
                            $resultsQuestionsData['next_question'] = 0;
                            $currentIndex = array_search($resultQuestionID, $questions_list);


                            if ($currentIndex !== false) {
                                // Get the previous index
                                $previousIndex = ($currentIndex > 0) ? $questions_list[$currentIndex - 1] : 0;
                                // Get the next index
                                $nextIndex = ($currentIndex < count($questions_list) - 1) ? $questions_list[$currentIndex + 1] : 0;
                                $resultsQuestionsData['prev_question'] = $previousIndex;
                                $resultsQuestionsData['next_question'] = $nextIndex;

                            }

                            $question_response_layout = view('web.default.panel.questions.question_layout', $resultsQuestionsData)->render();
                            $questions_layout[$resultQuestionID] = rurera_encode(stripslashes($question_response_layout));
                        }
                    }

                }
                $question = $questions_array;
               $question = rurera_encode($question);


                $response = view("web.default.books.includes." . $info_type, [
                    "pageInfoLink"          => $infoLinkData,
                    "QuizzesResult"         => isset($QuizzesResult) ? $QuizzesResult : array(),
                    "all_infolinks_checked" => $all_infolinks_checked,
                    "question"              => isset($questionObj) ? $questionObj : array(),
                    "quizAttempt"           => isset($attemptLogObj) ? $attemptLogObj : array(),
                    "newQuestionResult"     => isset($newQuestionResult) ? $newQuestionResult : array(),
                    'questions_layout'      => $questions_layout,
                    'question'               => $question,
                    "question_no"           => isset($question_no) ? $question_no : 0,
                    "first_question_id" => $first_question_id,
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
