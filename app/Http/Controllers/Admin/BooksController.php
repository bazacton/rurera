<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Books;
use App\Models\BooksPages;
use App\Models\BooksPagesInfoLinks;
use App\Models\BooksPagesQuestions;
use App\Models\QuizzesQuestion;
use App\Models\Webinar;
use App\Models\WebinarChapter;
use App\Models\SubChapters;
use App\Models\BooksPagesObjects;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\PdfToImage\Pdf;
use Elasticsearch;
use File;

class BooksController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();
        $this->authorize('admin_books');

        /*$query = QuizzesQuestion::query();

        $questions = $query->with([
                    'course' ,
                    'category' ,
                    'subChapter' ,
                ])->select('*')->paginate(100);


        foreach ($questions as $questionObj) {
            try {
                Elasticsearch::index([
                    'id' => $questionObj->id,
                    'index' => 'questions',
                    'body' => [
                        'id' => $questionObj->id,
                        'title' => $questionObj->question_title,
                        'difficulty_level' => $questionObj->question_difficulty_level,
                        'class' => isset( $questionObj->category->id)? $questionObj->category->getTitleAttribute() : '',
                        'course' => isset( $questionObj->course->id)? $questionObj->course->getTitleAttribute() : '',
                        'topic' => isset( $questionObj->subChapter->id)? $questionObj->subChapter->sub_chapter_title : '',
                    ]
                ]);
            } catch (Exception $e) {
                $this->info($e->getMessage());
            }
        }

        pre('done');
        */


        removeContentLocale();
        //DB::enableQueryLog();

        $query = Books::query();
        $totalBooks = deepClone($query)->count();


        //$query = $this->filters($query , $request);

        $books = $query->paginate(50);


        //DB::enableQueryLog();
        //pre(DB::getQueryLog());
        //DB::disableQueryLog();


        $data = [
            'pageTitle'  => 'Books',
            'books'      => $books,
            'totalBooks' => $totalBooks,
        ];

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();


        return view('admin.books.lists', $data);
    }


    /**
     * Create Book
     */
    public function create()
    {
        $this->authorize('admin_books_create');

        $reading_level = Books::$reading_level;
        $age_group = Books::$age_group;
        $interest_area = Books::$interest_area;
        $skill_set = Books::$skill_set;
        $book_categories = Books::$book_categories;
		
		$categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();

        $data = [
            'pageTitle'       => 'Books',
            'reading_level'   => $reading_level,
            'age_group'       => $age_group,
            'interest_area'   => $interest_area,
            'book_categories' => $book_categories,
            'skill_set'       => $skill_set,
            'categories'       => $categories,
        ];

        return view('admin.books.create', $data);
    }

    /**
     * Edit Book
     */
    public function edit(Request $request, $id)
    {
        $this->authorize('admin_books_edit');

        /*$data = array(
            'infobox_title' => 'Info Title 1',
            'infobox_value' => 'PHA+dGVzdDwvcD4=',
        );

        $data = (object) $data;
        echo json_encode($data);
        exit;*/


        $reading_level = Books::$reading_level;
        $age_group = Books::$age_group;
        $interest_area = Books::$interest_area;
        $skill_set = Books::$skill_set;
        $book_categories = Books::$book_categories;
		
		$categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();


        $book = Books::where('id', $id)->with([
            'bookFinalQuiz.QuestionData',
            'bookPages.PageInfoLinks'
        ])->first();
		
		
		$chapter_id = 195;
		
		$subject_id = $book->subject_id;
		$courseObj = Webinar::find($subject_id);
		$chapters = isset( $courseObj->chapters )? $courseObj->chapters : array();
	
		$response = '';
		if (!empty($chapters)) {
            foreach ($chapters as $chapterObj) {
                $subChapters = $chapterObj->subChapters;
                $sub_chapters_response = '';

                if (!empty($subChapters)) {
                    foreach ($subChapters as $subChapterObj) {
                        $quizData = $subChapterObj->quizData;
                        $quiz_id = isset($quizData->item_id) ? $quizData->item_id : 0;
                        $quizData = isset($subChapterObj->quizData->quiz) ? $subChapterObj->quizData->quiz : array();
                        $count_questions = isset($quizData->quizQuestionsList) ? count($quizData->quizQuestionsList) : 0;

						
						$sub_chapters_response .= '<div class="form-check mt-1">
                            <input type="radio" data-topic_title="' . $subChapterObj->sub_chapter_title . '" name="topic_id" id="topic_ids_'.$subChapterObj->id.'" value="'.$subChapterObj->id.'" class="form-check-input section-child trigger_field" data-field_type="topic_checkbox" data-id="'.$subChapterObj->id.'" data-field_id="topic_title">
                            <label class="form-check-label cursor-pointer mt-0" for="topic_ids_'.$subChapterObj->id.'">
                                ' . $subChapterObj->sub_chapter_title . '
                            </label>
                        </div>';
                    }
                }
                $response .= '<div class="col-lg-12 col-md-12 col-sm-12 col-12"><div class="card card-primary section-box">
                        <div class="card-header">
                            <label class="form-check-label font-16 font-weight-bold cursor-pointer" for="chapter_ids_' . $chapterObj->id . '">
                                ' . $chapterObj->getTitleAttribute() . '
                            </label>
                        </div>

                        <div class="card-body">
                            ' . $sub_chapters_response . '
                        </div>
                </div></div>';
            }
        }
		
		$chapterObj = WebinarChapter::find($chapter_id);
		$subChapters = $chapterObj->subChapters;
		


        $data = [
            'pageTitle'       => 'Edit Book',
            'book'            => $book,
            'rand_id'         => rand(99, 9999),
            'reading_level'   => $reading_level,
            'age_group'       => $age_group,
            'interest_area'   => $interest_area,
            'book_categories' => $book_categories,
            'skill_set'       => $skill_set,
            'subChapters'       => $subChapters,
			'categories' => $categories,
			'chapters_response' => $response,
        ];

        return view('admin.books.edit', $data);
    }

    /**
     * Store Book
     */
    public function store(Request $request, $id = '')
    {
        $user = auth()->user();


        $data = $request->all();
        $locale = $request->get('locale', getDefaultLocale());
		


        $rules = [
            'book_title' => 'required|max:255',
        ];

        if ($request->ajax()) {
            $data = $request->get('ajax');

            $validate = Validator::make($data, $rules);

            if ($validate->fails()) {
                return response()->json([
                    'code'   => 422,
                    'errors' => $validate->errors()
                ], 422);
            }
        } else {
            $this->validate($request, $rules);
        }


        $book_pdf = isset($data['book_pdf']) ? $data['book_pdf'] : '';
		
		$book_type = isset($data['book_type']) ? $data['book_type'] : 'Book';
		$year_id = isset($data['year_id']) ? $data['year_id'] : 0;
		$subject_id = isset($data['subject_id']) ? $data['subject_id'] : 0;

        $book = ($id > 0) ? Books::findOrFail($id) : array();


        $book_slug = (isset($data['book_slug']) && $data['book_slug'] != '') ? $data['book_slug'] : Books::makeSlug($data['book_title']);

        $interest_area = isset($data['interest_area']) ? implode(',', $data['interest_area']) : '';

        if (isset( $book->id)) {
            $book->update([
                'book_slug'        => $book_slug,
                'written_by'       => isset($data['written_by']) ? $data['written_by'] : '',
                'illustrated_by'   => isset($data['illustrated_by']) ? $data['illustrated_by'] : '',
                'publication_date' => isset($data['publication_date']) ? strtotime($data['publication_date']) : time(),
                'cover_image'      => isset($data['cover_image']) ? $data['cover_image'] : '',
                'words_bank'       => isset($data['words_bank']) ? $data['words_bank'] : '',
                'reading_level'    => isset($data['reading_level']) ? $data['reading_level'] : '',
                'reading_color'    => isset($data['reading_color']) ? $data['reading_color'] : '',
                'age_group'        => isset($data['age_group']) ? $data['age_group'] : '',
                'interest_area'    => $interest_area,
                'skill_set'        => isset($data['skill_set']) ? $data['skill_set'] : '',
                'no_of_pages'      => isset($data['no_of_pages']) ? $data['no_of_pages'] : 0,
                'reading_points'   => isset($data['reading_points']) ? $data['reading_points'] : 0,
                'book_category'    => isset($data['book_category']) ? $data['book_category'] : '',
                'seo_title'    => isset($data['seo_title']) ? $data['seo_title'] : '',
                'seo_description'    => isset($data['seo_description']) ? $data['seo_description'] : '',
                'seo_robot_access'    => isset($data['seo_robot_access']) ? $data['seo_robot_access'] : 0,
                'include_xml'    => isset($data['include_xml']) ? $data['include_xml'] : 0,
                'book_type'    => $book_type,
                'year_id'    => $year_id,
                'subject_id'    => $subject_id,
            ]);


            $final_questions = isset($data['question_list_ids']) ? $data['question_list_ids'] : array();

            $final_questions_list = array();
            if (!empty($final_questions)) {
                foreach ($final_questions as $sort_order => $question_id) {

                    $questionObj = BooksPagesQuestions::where('book_id', $book->id)->where('quiz_type', 'final')->where('question_id', $question_id)->first();
                    $final_questions_list[] = $question_id;

                    if (isset($questionObj->id)) {
                        $questionObj->update([
                            'sort_order' => $sort_order,
                        ]);
                    } else {
                        $BooksPagesQuestions = BooksPagesQuestions::create([
                            'book_id'             => $book->id,
                            'page_id'             => 0,
                            'books_info_links_id' => 0,
                            'question_id'         => $question_id,
                            'sort_order'          => $sort_order,
                            'quiz_type'           => 'final',
                            'created_by'          => $user->id,
                            'created_at'          => time(),
                        ]);
                    }
                }
            }
            BooksPagesQuestions::whereNotIn('question_id', $final_questions_list)->where('book_id', $book->id)->where('quiz_type', 'final')->update([
                'status' => 'inactive'
            ]);
        }


        if (!empty($book_pdf)) {
            $book_pdf = ltrim($book_pdf, '/');
            $pdf = new Pdf($book_pdf);
            $book_pages = $pdf->getNumberOfPages();

            if ($id != '' && $id > 0) {
                $book = ($id > 0) ? Books::findOrFail($id) : array();
            } else {
                $this->authorize('admin_books_create');

                $book = Books::create([
                    'book_title'       => isset($data['book_title']) ? $data['book_title'] : '',
                    'book_slug'        => $book_slug,
                    'book_pdf'         => $book_pdf,
                    'book_pages'       => $book_pages,
                    'written_by'       => isset($data['written_by']) ? $data['written_by'] : '',
                    'illustrated_by'   => isset($data['illustrated_by']) ? $data['illustrated_by'] : '',
                    'publication_date' => isset($data['publication_date']) ? strtotime($data['publication_date']) : time(),
                    'cover_image'      => isset($data['cover_image']) ? $data['cover_image'] : '',
                    'words_bank'       => isset($data['words_bank']) ? $data['words_bank'] : '',
                    'reading_level'    => isset($data['reading_level']) ? $data['reading_level'] : '',
                    'reading_color'    => isset($data['reading_color']) ? $data['reading_color'] : '',
                    'age_group'        => isset($data['age_group']) ? $data['age_group'] : '',
                    'interest_area'    => $interest_area,
                    'skill_set'        => isset($data['skill_set']) ? $data['skill_set'] : '',
                    'no_of_pages'      => isset($data['no_of_pages']) ? $data['no_of_pages'] : 0,
                    'reading_points'   => isset($data['reading_points']) ? $data['reading_points'] : 0,
                    'book_category'    => isset($data['book_category']) ? $data['book_category'] : '',
                    'created_by'       => $user->id,
                    'created_at'       => time(),
                    'seo_title'    => isset($data['seo_title']) ? $data['seo_title'] : '',
                    'seo_description'    => isset($data['seo_description']) ? $data['seo_description'] : '',
                    'seo_robot_access'    => isset($data['seo_robot_access']) ? $data['seo_robot_access'] : 0,
                    'include_xml'    => isset($data['include_xml']) ? $data['include_xml'] : 0,
					'book_type'    => $book_type,
					'year_id'    => $year_id,
					'subject_id'    => $subject_id
                ]);

                File::isDirectory('store/1/books/' . $book->id . '/') or File::makeDirectory('store/1/books/' . $book->id . '/', 0777, true, true);
                $page_count = 1;
                while ($page_count <= $book_pages) {
                    $pdf->setPage($page_count)->saveImage('store/1/books/' . $book->id . '/' . $page_count . '.jpg');
                    BooksPages::create([
                        'book_id'    => $book->id,
                        'page_no'    => $page_count,
                        'page_title' => $page_count,
                        'page_path'  => 'store/1/books/' . $book->id . '/' . $page_count . '.jpg',
                        'created_by' => $user->id,
                        'created_at' => time(),
                        'sort_order' => $page_count,
                    ]);
                    $page_count++;
                }
            }
        } else {
            $book_pages = isset($data['book_pages']) ? $data['book_pages'] : array();
            $book_pages_titles = isset($data['book_pages_titles']) ? $data['book_pages_titles'] : array();
            $book_pages_ids = array();
            if (!empty($book_pages)) {
                foreach ($book_pages as $page_index => $page_id) {
                    $book_pages_ids[] = $page_id;
                    $page_title = isset($book_pages_titles[$page_index]) ? $book_pages_titles[$page_index] : '';
                    $pageObj = BooksPages::findOrFail($page_id);
                    $pageObj->update([
                        'page_title' => $page_title,
                        'sort_order' => $page_index
                    ]);
                }
            }

            BooksPages::whereNotIn('id', $book_pages_ids)->where('book_id', $book->id)->update([
                'status' => 'inactive'
            ]);
        }


        if ($request->ajax()) {
            $redirectUrl = '';
            $redirectUrl = '/admin/books/' . $book->id . '/edit';
            return response()->json([
                'code'         => 200,
                'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('adminEditBook', ['id' => $book->id]);
        }
    }

    /**
     * Store Page
     */
    public function store_page(Request $request, $id = '')
    {
        $user = auth()->user();

        $data = $request->all();
        $locale = $request->get('locale', getDefaultLocale());
        $book_page_id = $id;
		$pageObj = BooksPages::findOrFail($book_page_id);

        $rules = [
            'book_title' => 'required|max:255',
        ];

        $field_ids_array = $questions_ids_array = $objects_array = array();

		$sort_order_item = 0;
        if (!empty($data)) {
            foreach ($data as $field_id => $objectData) {
				
				$objectData = (object) $objectData;
				
				$is_new = $objectData->is_new;
				if( $is_new == 'yes'){
					$BooksPagesObjects = BooksPagesObjects::create([
						'book_id'	=> $pageObj->book_id,
						'page_id'	=> $pageObj->id,
						'item_type' 		=> $objectData->field_type,
						'item_slug' 		=> $objectData->item_type,
						'item_title' 		=> isset( $objectData->item_title )? $objectData->item_title : '',
						'item_path' 		=> $objectData->item_path,
						'field_style' 		=> $objectData->field_style,
						'data_values' 		=> isset( $objectData->data_values )? json_encode($objectData->data_values) : '',
						'status'			=> 'active',
						'sort_order' 		=> $sort_order_item,
						'created_by'		=> $user->id,
						'created_at'		=> time(),
					]);
					$objects_array[] = $BooksPagesObjects->id;
				}else{
					$objects_array[] = $objectData->unique_id;
					$BooksPagesObjects = BooksPagesObjects::find($objectData->unique_id)->update([
						'book_id'	=> $pageObj->book_id,
						'page_id'	=> $pageObj->id,
						'item_type' 		=> $objectData->field_type,
						'item_slug' 		=> $objectData->item_type,
						'item_title' 		=> isset( $objectData->item_title )? $objectData->item_title : '',
						'item_path' 		=> $objectData->item_path,
						'field_style' 		=> $objectData->field_style,
						'data_values' 		=> isset( $objectData->data_values )? json_encode($objectData->data_values) : '',
						'status'			=> 'active',
						'sort_order' 		=> $sort_order_item,
						'created_by'		=> $user->id,
						'created_at'		=> time(),
					]);
				}

                /*if ($field_type == 'quiz') {

                    $data_values = json_decode($data_values);
                    $question_ids = isset($data_values->questions_ids) ? explode(',', $data_values->questions_ids) : array();
                    if (!empty($question_ids)) {
                        foreach ($question_ids as $question_id) {
                            $BooksPagesQuestions = BooksPagesQuestions::where('books_info_links_id', $fieldObj->id)
                                ->where('question_id', $question_id)->first();
                            if (!isset($BooksPagesQuestions->id)) {
                                $BooksPagesQuestions = BooksPagesQuestions::create([
                                    'book_id'             => $bookPage->book_id,
                                    'page_id'             => $fieldObj->page_id,
                                    'books_info_links_id' => $fieldObj->id,
                                    'question_id'         => $question_id,
                                    'sort_order'          => 1,
                                    'created_by'          => $user->id,
                                    'created_at'          => time(),
                                ]);
                            }
                            $questions_ids_array[] = $BooksPagesQuestions->id;
                        }
                    }
                }*/
				
				$sort_order_item++;
            }
        }
		
		BooksPagesObjects::where('book_id', $pageObj->book_id)->where('page_id', $pageObj->id)->whereNotIn('id', $objects_array)->update(['status' => 'archived']);

        //$field_ids_array
        return response()->json([
            'code' => 200,
        ]);
    }


    /**
     * Search Book Page Infobox
     */
    public function searchinfobox(Request $request, $page_id)
    {
        $term = $request->get('term');
        $page_infoboxes = BooksPagesInfoLinks::select('id', 'info_title as title')
            ->where(function ($query) use ($term) {
                $query->where('info_title', 'like', '%' . $term . '%');
            })->where('page_id', $page_id)->whereIn('info_type',
                array(
                    'check_it_makes_sense',
                    'picture_in_your_mind',
                    'picture_in_your_mind',
                    'picture_in_your_mind',
                    'picture_in_your_mind',
                    'facts',
                    'tips',
                    'try_do_it_yourself'
                )
            );

        return response()->json($page_infoboxes->get(), 200);
    }

    /*
     * Get Titles of the infoboxes
     */

    public function get_infobox_by_ids(Request $request)
    {
        $infobox_ids = $request->get('infobox_ids');

        $infobox_ids = ($infobox_ids != '') ? explode(',', $infobox_ids) : array();


        $infoboxes = BooksPagesInfoLinks::select('id', 'info_title as text')->whereIn('id', $infobox_ids);

        return response()->json($infoboxes->get(), 200);
    }




}
