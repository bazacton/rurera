<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\User;
use App\Models\Books;
use App\Models\Webinar;


use App\Models\SubChapters;
use App\Models\WebinarChapterItem;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class BooksController extends Controller
{
    public function index(Request $request)
    {
		
		$books_data = Books::where('id', '>', 0)->where('book_type', 'Book')->get();
		
		$books = array();

        if (!empty($books_data)) {
            foreach ($books_data as $bookObj) {
                if (isset($bookObj->book_category) && $bookObj->book_category != '') {
                    $books[$bookObj->book_category][] = $bookObj;
                }
            }
        }
		
		$section_id = 0;
			
		if(!empty( $books )){	
			foreach($books as $category_title => $books_array){
				
				$data_array[$section_id] = array(
					'section_id' => $section_id,
					'section_title' => $category_title,
					'section_data' => array(),
				);	
				
				if( !empty( $books_array )){
					foreach( $books_array as $bookObj){
						$data_array[$section_id]['section_data'][] = array(
							'title' => $bookObj->book_title,
							'description' => '',
							'icon' => $bookObj->cover_image,
							'icon_position' => '',
							'background' => '',
							'reading_level' => $bookObj->reading_level,
							'interest_area' => $bookObj->interest_area,
							'no_of_pages' => $bookObj->no_of_pages,
							'reading_points' => $bookObj->reading_points,
							'pageTitle' => $bookObj->book_title,
							'target_api' => '/panel/books/'.$bookObj->book_slug,
							'target_layout' => 'book',
						);
					}
				}
				
				$section_id++;
			}
		}
		
		
		$response = array(
			'listData' => $data_array,
			'searchFilters' => [],
		);
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
}









