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
							'icon' => ($bookObj->cover_image != '')? url('/').$bookObj->cover_image : '',
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
	
	/*
	* Book Data
	*/
	public function book_data(Request $request, $book_slug)
    {
		$user = apiAuth();
		$bookObj = Books::where('book_slug', $book_slug)->with([
            'bookFinalQuiz.QuestionData',
            'bookPages.PageInfoLinks',
            'bookPages.BooksPageUserReadings' => function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('status', 'active');
            },
        ])->first();
		
		
		$pages = array();
		$page_serial = 1;
		
		if (!empty($bookObj->bookPages)) {
            foreach ($bookObj->bookPages as $page_data) {
				$page_info_links = array();
				$page_path = $page_data->page_path;
				if (!empty($page_data->pageObjects->where('status', 'active'))) {
                    foreach ($page_data->pageObjects->where('status', 'active') as $pageInfoLinks) {
						$content = '';
						$info_style = isset( $pageInfoLinks->field_style )? $pageInfoLinks->field_style : '';
						$coordinates = array('x' => 0, 'y' => 0);
						preg_match('/(?:left:\s*([\d\.]+)%;)?(?:.*top:\s*([\d\.]+)%;)?(?:.*width:\s*([\d\.]+)%;)?(?:.*height:\s*([\d\.]+)%;)?/', $info_style, $matches);

						$left   = isset($matches[1]) ? $matches[1] : null;
						$top    = isset($matches[2]) ? $matches[2] : null;
						$width  = isset($matches[3]) ? $matches[3] : null;
						$height = isset($matches[4]) ? $matches[4] : null;


						$info_link_data = array(
							'info_id' => isset( $pageInfoLinks->id )? $pageInfoLinks->id : 0,
							'info_type' => isset( $pageInfoLinks->item_slug )? $pageInfoLinks->item_slug : '',
							'x' => $left,
							'y' => $top,
							'height' => $height,
							'width' => $width,
						);
						
						$data_values = isset($pageInfoLinks->data_values) ? json_decode($pageInfoLinks->data_values) : array();
						$item_type = isset( $pageInfoLinks->item_type )? $pageInfoLinks->item_type : '';
						
						$item_path_folder = '';
						$item_path_folder = ($item_type == 'infolink' )? 'infolinks' : $item_path_folder;
						$item_path_folder = ($item_type == 'stage_objects' )? 'objects' : $item_path_folder;
						$item_path_folder = ($item_type == 'misc' )? 'misc' : $item_path_folder;
						$item_path = isset( $pageInfoLinks->item_path ) ?  $pageInfoLinks->item_path : '';
						$item_path = 'assets/books-editor/'.$item_path_folder.'/'.$item_path;
						$item_path_img = '/assets/books-editor/'.$item_path_folder.'/default/'.$pageInfoLinks->item_slug.'.svg';
						$info_link_data['info_icon'] = url('/').'/'.$item_path;
						
						switch ($pageInfoLinks->item_slug) {
                            case "highlighter":
								$highlighter_background = isset( $data_values->fill_color )? $data_values->fill_color : '';
								$info_link_data['background_color'] = $highlighter_background;
								
                                //$content = isset($data_values->infobox_value)? base64_decode(trim(stripslashes($data_values->infobox_value))) : '';
                                break;

                            default:
								$content = isset($data_values->info_content)? $data_values->info_content : '';
								
								$info_link_data['info_data'] = array(
									'title' => isset( $pageInfoLinks->item_title )? $pageInfoLinks->item_title : '',
									'content' => $content,
								);
                                //$content = '';
                                break;
                        }
						
						$page_info_links[] = $info_link_data;
					}
				}
				$pages[] = array(
					'page_id' => $page_data->id,
					'page_no' => $page_serial,//$page_data->page_no,
					'content' => '',
					'read_time' => isset( $page_data->BooksPageUserReadings->read_time )? $page_data->BooksPageUserReadings->read_time : 0,
					'page_path' => url('/').'/'.$page_data->page_path,
					'page_info_links' => $page_info_links,
					'info_read_api' => 'panel/books/update_info_reading',
					'read_api_method' => 'POST',
				);
				$page_serial++;
			}
		}
		
		$book_data = array(
			'title' => isset( $bookObj->book_title )? $bookObj->book_title : '',
			'cover_image' => isset( $bookObj->cover_image )? url('/').$bookObj->cover_image : '',
			'written_by' => isset( $bookObj->written_by )? $bookObj->written_by : '',
			'illustrated_by' => isset( $bookObj->illustrated_by )? $bookObj->illustrated_by : '',
			'publication_date' => isset( $bookObj->publication_date )? $bookObj->publication_date : '',
			'no_of_pages' => isset( $bookObj->no_of_pages )? $bookObj->no_of_pages : '',
			'age_group' => isset( $bookObj->age_group )? $bookObj->age_group : '',
			'interest_area_array' => isset( $book->interest_area )? explode(',', $book->interest_area) : '',
			'skill_set' => isset( $bookObj->skill_set )? $bookObj->skill_set : '',
			'words_bank' => isset( $bookObj->words_bank )? $bookObj->words_bank : '',
			'reading_level' => isset( $bookObj->reading_level )? $bookObj->reading_level : '',
			'read_api' => 'panel/books/update_reading',
			'read_api_method' => 'POST',
			'pages' => $pages,
		);
		
		$response = array(
			'bookData' => $book_data,
			'searchFilters' => [],
		);
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
	/*
     * Update Reading of Pages for Book
     */
    public function update_reading(Request $request)
    {
        $user = apiAuth();
        $page_ids = $request->get('page_ids');
        $page_id = $request->get('page_id');
        $reading_time = $request->get('reading_time');
		$page_ids = array($page_id);
        //pre('test');
        if (!empty($page_ids)) {
            foreach ($page_ids as $page_id) {
                $bookPage = BooksPages::find($page_id);
                $bookUserReadingObj = BooksUserReading::where('page_id', $page_id)->where('user_id', $user->id)->where('status', 'active')->first();
                if (isset($bookUserReadingObj->id)) {
                    $bookUserReadingObj->update([
                        'page_id'    => $page_id,
                        'read_time'  => $reading_time,
                        'updated_at' => time(),
                    ]);

                } else {
                    BooksUserReading::create([
                        'user_id'    => $user->id,
                        'book_id'    => $bookPage->book_id,
                        'page_id'    => $page_id,
                        'read_time'  => $reading_time,
                        'status'     => 'active',
                        'created_at' => time(),
                        'updated_at' => time(),
                    ]);
                }
            }
        }
        $response = array(
			'listData' => [],
		);
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
	/*
     * Update infolink Read
     */
    public function update_info_reading(Request $request)
    {
        $user = apiAuth();
        $info_id = $request->get('info_id');
		$infoLinkData = BooksPagesInfoLinks::where('id', $info_id)->first();
		$info_type = isset($infoLinkData->info_type) ? $infoLinkData->info_type : '';
		BooksUserPagesInfoLinks::create([
			'user_id'           => $user->id,
			'book_id'           => $infoLinkData->book_id,
			'book_info_link_id' => $info_id,
			'status'            => 'active',
			'created_by'        => $user->id,
			'created_at'        => time(),
		]);
		
		
        $response = array(
			'listData' => [],
		);
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }
	
}









