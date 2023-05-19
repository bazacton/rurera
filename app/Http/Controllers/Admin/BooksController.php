<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Books;
use App\Models\BooksPages;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\PdfToImage\Pdf;

class BooksController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();
        $this->authorize('admin_books');


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


        $book_pdf = ltrim($book_pdf , '/');
        //$pdf        = new Pdf($book_pdf);
        //$book_pages = $pdf->getNumberOfPages();

        $book_pages = 14;


        if ($id != '' && $id > 0) {
            $this->authorize('admin_books_edit');
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

            $page_count = 1;
            while ($page_count <= $book_pages) {
                BooksPages::create([
                    'book_id'    => $book->id ,
                    'page_no'    => $page_count ,
                    'page_path'  => 'store/1/books/' . $book->id . '/' . $page_count ,
                    'created_by' => $user->id ,
                    'created_at' => time() ,
                ]);
                $page_count++;
            }
        }


        if ($request->ajax()) {
            $redirectUrl = '';
            $redirectUrl = '/admin/books/' . $book->id . '/edit';
            return response()->json([
                'code'         => 200 ,
                'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('adminEditGlossary' , ['id' => $book->id]);
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

        pre($data);


        $book_pdf = isset($data['book_pdf']) ? $data['book_pdf'] : '';


        $book_pdf = ltrim($book_pdf , '/');
        //$pdf        = new Pdf($book_pdf);
        //$book_pages = $pdf->getNumberOfPages();

        $book_pages = 14;


        if ($id != '' && $id > 0) {
            $this->authorize('admin_books_edit');
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

            $page_count = 1;
            while ($page_count <= $book_pages) {
                BooksPages::create([
                    'book_id'    => $book->id ,
                    'page_no'    => $page_count ,
                    'page_path'  => 'store/1/books/' . $book->id . '/' . $page_count ,
                    'created_by' => $user->id ,
                    'created_at' => time() ,
                ]);
                $page_count++;
            }
        }


        if ($request->ajax()) {
            $redirectUrl = '';
            $redirectUrl = '/admin/books/' . $book->id . '/edit';
            return response()->json([
                'code'         => 200 ,
                'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('adminEditGlossary' , ['id' => $book->id]);
        }
    }


}
