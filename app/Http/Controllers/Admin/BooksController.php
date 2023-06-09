<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Books;
use App\Models\BooksPages;
use App\Models\BooksPagesInfoLinks;
use App\Models\BooksPagesQuestions;
use App\Models\QuizzesQuestion;
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
            'pageTitle'  => 'Books' ,
            'books'      => $books ,
            'totalBooks' => $totalBooks ,
        ];

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();


        return view('admin.books.lists' , $data);
    }


    /**
     * Create Book
     */
    public function create()
    {
        $this->authorize('admin_books_create');

        $data = [
            'pageTitle' => 'Books' ,
        ];

        return view('admin.books.create' , $data);
    }

    /**
     * Edit Book
     */
    public function edit(Request $request , $id)
    {
        $this->authorize('admin_books_edit');

        /*$data = array(
            'infobox_title' => 'Info Title 1',
            'infobox_value' => 'PHA+dGVzdDwvcD4=',
        );

        $data = (object) $data;
        echo json_encode($data);
        exit;*/


        $book = Books::where('id' , $id)->with('bookPages.PageInfoLinks')->first();

        $data = [
            'pageTitle' => 'Edit Book' ,
            'book'      => $book ,
            'rand_id'   => rand(99 , 9999) ,
        ];

        return view('admin.books.edit' , $data);
    }

    /**
     * Store Book
     */
    public function store(Request $request , $id = '')
    {
        $user = auth()->user();


        $data = $request->all();
        $locale = $request->get('locale' , getDefaultLocale());


        $rules = [
            'book_title' => 'required|max:255' ,
        ];

        if ($request->ajax()) {
            $data = $request->get('ajax');

            $validate = Validator::make($data , $rules);

            if ($validate->fails()) {
                return response()->json([
                    'code'   => 422 ,
                    'errors' => $validate->errors()
                ] , 422);
            }
        } else {
            $this->validate($request , $rules);
        }


        $book_pdf = isset($data['book_pdf']) ? $data['book_pdf'] : '';

        $book = ($id > 0)? Books::findOrFail($id) : array();


        if( !empty( $book_pdf ) ) {
            $book_pdf = ltrim($book_pdf , '/');
            $pdf = new Pdf($book_pdf);
            $book_pages = $pdf->getNumberOfPages();

            if ($id != '' && $id > 0) {
                $book = ($id > 0)? Books::findOrFail($id) : array();
                /*$glossary = Glossary::findOrFail($id);
                $glossary->update([
                    'category_id' => isset($data['category_id']) ? $data['category_id'] : '' ,
                    'title'       => isset($data['title']) ? $data['title'] : '' ,
                    'description' => isset($data['description']) ? $data['description'] : '' ,
                    'created_at'  => time() ,
                ]);*/
            } else {
                $this->authorize('admin_books_create');

                $book = Books::create([
                    'book_title' => isset($data['book_title']) ? $data['book_title'] : '' ,
                    'book_pdf'   => $book_pdf ,
                    'book_pages' => $book_pages ,
                    'created_by' => $user->id ,
                    'created_at' => time() ,
                ]);

                File::isDirectory('store/1/books/' . $book->id . '/') or File::makeDirectory('store/1/books/' . $book->id . '/' , 0777 , true , true);
                $page_count = 1;
                while ($page_count <= $book_pages) {
                    $pdf->setPage($page_count)->saveImage('store/1/books/' . $book->id . '/' . $page_count . '.jpg');
                    BooksPages::create([
                        'book_id'    => $book->id ,
                        'page_no'    => $page_count ,
                        'page_title'    => $page_count ,
                        'page_path'  => 'store/1/books/' . $book->id . '/' . $page_count . '.jpg' ,
                        'created_by' => $user->id ,
                        'created_at' => time() ,
                        'sort_order' => $page_count,
                    ]);
                    $page_count++;
                }
            }
        }else{
            $book_pages = isset( $data['book_pages'] )? $data['book_pages'] : array();
            $book_pages_titles = isset( $data['book_pages_titles'] )? $data['book_pages_titles'] : array();
            $book_pages_ids = array();
            if( !empty( $book_pages )){
                foreach( $book_pages as $page_index => $page_id){
                    $book_pages_ids[]   = $page_id;
                    $page_title = isset( $book_pages_titles[$page_index] )? $book_pages_titles[$page_index] : '';
                    $pageObj = BooksPages::findOrFail($page_id);
                    $pageObj->update([
                        'page_title' => $page_title,
                        'sort_order' => $page_index
                    ]);
                }
            }

            BooksPages::whereNotIn('id' , $book_pages_ids)->where('book_id', $book->id)->update([
                'status' => 'inactive'
            ]);
        }


        if ($request->ajax()) {
            $redirectUrl = '';
            $redirectUrl = '/admin/books/' . $book->id . '/edit';
            return response()->json([
                'code'         => 200 ,
                'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('adminEditBook' , ['id' => $book->id]);
        }
    }

    /**
     * Store Page
     */
    public function store_page(Request $request , $id = '')
    {
        $user = auth()->user();

        $data = $request->all();
        $locale = $request->get('locale' , getDefaultLocale());

        $rules = [
            'book_title' => 'required|max:255' ,
        ];

        $field_ids_array = $questions_ids_array = array();

        if (!empty($data)) {
            foreach ($data as $field_id => $dataObj) {
                $field_ids_array[] = $field_id;

                $book_page_id = isset($dataObj['book_page_id']) ? $dataObj['book_page_id'] : '';
                $field_type = isset($dataObj['field_type']) ? $dataObj['field_type'] : '';
                $data_value = isset($dataObj['data_values']) ? $dataObj['data_values'] : array();
                $bookPage = BooksPages::findOrFail($book_page_id);
                $is_new = isset($dataObj['is_new']) ? $dataObj['is_new'] : 'yes';
                $data_values = isset($dataObj['data_values']) ? stripslashes(json_encode($data_value ,
                    JSON_UNESCAPED_SLASHES)) : '';


                $data_values = str_replace('""' , '"' , $data_values);

                $update_array = array(
                    'book_id'     => $bookPage->book_id ,
                    'page_id'     => isset($dataObj['book_page_id']) ? $dataObj['book_page_id'] : '' ,
                    'info_title'  => isset($data_value['infobox_title']) ? $data_value['infobox_title'] : '' ,
                    'info_type'   => isset($dataObj['field_type']) ? $dataObj['field_type'] : '' ,
                    'data_values' => json_encode($data_value) ,
                    'info_style'  => isset($dataObj['field_style']) ? $dataObj['field_style'] : '' ,
                    'created_by'  => $user->id ,
                    'created_at'  => time() ,
                );


                if ($is_new == 'yes') {
                    $fieldObj = BooksPagesInfoLinks::create($update_array);
                    $field_ids_array[] = $fieldObj->id;
                } else {
                    $fieldObj = BooksPagesInfoLinks::findOrFail($field_id);
                    $fieldObj->update($update_array);
                }

                if ($field_type == 'quiz') {

                    $data_values = json_decode($data_values);
                    $question_ids = isset($data_values->questions_ids) ? explode(',' , $data_values->questions_ids) : array();
                    if (!empty($question_ids)) {
                        foreach ($question_ids as $question_id) {
                            $BooksPagesQuestions = BooksPagesQuestions::where('books_info_links_id' , $fieldObj->id)
                                ->where('question_id' , $question_id)->first();
                            if (!isset($BooksPagesQuestions->id)) {
                                $BooksPagesQuestions = BooksPagesQuestions::create([
                                    'book_id'             => $bookPage->book_id ,
                                    'page_id'             => $fieldObj->page_id ,
                                    'books_info_links_id' => $fieldObj->id ,
                                    'question_id'         => $question_id ,
                                    'sort_order'          => 1 ,
                                    'created_by'          => $user->id ,
                                    'created_at'          => time() ,
                                ]);
                            }
                            $questions_ids_array[] = $BooksPagesQuestions->id;
                        }
                    }
                }
            }
        }

        $book = BooksPagesInfoLinks::whereNotIn('id' , $field_ids_array)->where('page_id' , $book_page_id)->delete();
        $book = BooksPagesQuestions::whereNotIn('id' , $questions_ids_array)->where('page_id' , $book_page_id)->delete();

        //$field_ids_array
        return response()->json([
            'code' => 200 ,
        ]);
    }


    /**
     * Search Book Page Infobox
     */
    public function searchinfobox(Request $request , $page_id)
    {
        $term = $request->get('term');
        $page_infoboxes = BooksPagesInfoLinks::select('id' , 'info_title as title')
            ->where(function ($query) use ($term) {
                $query->where('info_title' , 'like' , '%' . $term . '%');
            })->where('page_id' , $page_id)->whereIn('info_type' ,
                array(
                    'check_it_makes_sense' , 'picture_in_your_mind' , 'picture_in_your_mind' , 'picture_in_your_mind' , 'picture_in_your_mind' , 'facts' , 'tips' , 'try_do_it_yourself'
                )
            );

        return response()->json($page_infoboxes->get() , 200);
    }

    /*
     * Get Titles of the infoboxes
     */

    public function get_infobox_by_ids(Request $request)
    {
        $infobox_ids = $request->get('infobox_ids');

        $infobox_ids = ($infobox_ids != '') ? explode(',' , $infobox_ids) : array();


        $infoboxes = BooksPagesInfoLinks::select('id' , 'info_title as text')->whereIn('id' , $infobox_ids);

        return response()->json($infoboxes->get() , 200);
    }


}
