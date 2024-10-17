<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\TopicParts;
use App\Models\Category;
use App\Models\QuizzesQuestion;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class TopicsParts extends Controller {

    public function index(Request $request) {
        $user = auth()->user();
        $this->authorize('admin_topic_parts');

        removeContentLocale();
        //DB::enableQueryLog();

        $query = TopicParts::query();

        $TotalTopicParts = deepClone($query)->count();

        $query = $this->filters($query, $request);




        $TopicParts = $query->paginate(50);



        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();

        //DB::enableQueryLog();
        //pre(DB::getQueryLog());
        //DB::disableQueryLog();

		$users_list = User::where('status' , 'active')->get();
        $data = [
            'pageTitle' => 'Topics Parts',
            'TopicParts' => $TopicParts,
            'TotalTopicParts' => $TotalTopicParts,
            'categories' => $categories,
            'users_list' => $users_list,
            'user' => $user,
        ];

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();



        return view('admin.topics_parts.lists', $data);
    }

    /*
     * Create Glossary
     */

    public function create() {
        $this->authorize('admin_topic_parts_create');
        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();
        $data = [
            'pageTitle' => 'Topics Parts',
            'categories' => $categories,
        ];

        return view('admin.topics_parts.create', $data);
    }

    public function edit(Request $request, $id) {
        $this->authorize('admin_topic_parts_edit');
        $user = auth()->user();

        $TopicParts = TopicParts::findOrFail($id);
		
		
		$topic_part_data = isset( $TopicParts->topic_part_data )? json_decode($TopicParts->topic_part_data) :array();
		$unique_ids = $sumClauses = array();
    	$unique_ids_counts = [];
		if( !empty($topic_part_data)){
			foreach( $topic_part_data as $unique_id => $part_data){
					$unique_ids[] = $unique_id;
				$alias = "`{$unique_id}_count`";
				$sumClauses[] = "SUM(JSON_CONTAINS(topics_parts, '\"$unique_id\"')) AS $alias";
			}
		}
		if( !empty( $sumClauses ) ){
    		$sumQuery = implode(', ', $sumClauses);
    		
    		$query = QuizzesQuestion::selectRaw($sumQuery)
    		->where('hide_question', 0)
    		->first();
    		
    		foreach ($unique_ids as $id) {
    			$unique_ids_counts[$id] = $query->{$id . '_count'};
    		}
		}
		
        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();
            $data = [
            'pageTitle' => 'Edit Topic Parts',
            'categories' => $categories,
            'TopicParts' => $TopicParts,
            'unique_ids_counts' => $unique_ids_counts,
        ];

        return view('admin.topics_parts.create', $data);
    }
	
	public function store_question_parts(Request $request, $id = '') {
        $user = auth()->user();
        $this->authorize('admin_topic_parts');

        $data = $request->all();
        $locale = $request->get('locale', getDefaultLocale());

		if( !isset( $data['paragraph'] ) || $data['paragraph'] == ''){
			exit;
		}
		$TopicPartObj = TopicParts::create([
			'category_id' => isset($data['category_id']) ? $data['category_id'] : 0,
			'subject_id' => isset($data['subject_id']) ? $data['subject_id'] : 0,
			'chapter_id' => isset($data['chapter_id']) ? $data['chapter_id'] : 0,
			'sub_chapter_id' => isset($data['sub_chapter_id']) ? $data['sub_chapter_id'] : 0,
			'paragraph' => isset($data['paragraph']) ? $data['paragraph'] : '',
			'topic_part_data' => isset($data['topic_part']) ? json_encode($data['topic_part']) : '',
			'created_by' => $user->id,
			'created_at' => time(),
		]);


		$response = '';
        if ($request->ajax()) {
			
			
			$topic_part_data = isset( $TopicPartObj->topic_part_data )? json_decode($TopicPartObj->topic_part_data) : array();
				if( !empty( $topic_part_data) ){
					foreach( $topic_part_data as $topic_unique_id => $topicpartData){
						$checked = '';
						$response .= '<div class="form-field rureraform-cr-container-medium">
											<input class="rureraform-checkbox-medium" type="checkbox" name="topics_parts[]" id="topics_parts-'.$topic_unique_id.'" value="'.$topic_unique_id.'" '.$checked.'><label for="topics_parts-'.$topic_unique_id.'">'.$topicpartData.'</label>
										</div>';
					}
				}
			
            return response()->json([
                'code' => 200,
                'response' => $response,
                'redirect_url' => ''
            ]);


        }
    }


    private function filters($query, $request) {
		
        $category_id = get_filter_request('category_id', 'topics_search');
        $subject_id = get_filter_request('subject_id', 'topics_search'); 
        $chapter_id = get_filter_request('chapter_id', 'topics_search'); 
        $sub_chapter_id = get_filter_request('sub_chapter_id', 'topics_search');
        $user_id = get_filter_request('user_id', 'topics_search'); 
		
        if ($category_id != '') {
            $query->where('topic_parts.category_id', $category_id);
        }

        if ($subject_id != '') {
            $query->where('topic_parts.subject_id', $subject_id);
        }

        if ($chapter_id != '') {
            $query->where('topic_parts.chapter_id', $chapter_id);
        }

        if ($sub_chapter_id != '') {
            $query->where('topic_parts.sub_chapter_id', $sub_chapter_id);
        }

        if ($user_id != '') {
            $query->where('topic_parts.created_by', $user_id);
        }

        return $query;
    }

    public function store(Request $request, $id = '') {
        $user = auth()->user();


        $data = $request->all();
        $locale = $request->get('locale', getDefaultLocale());
		$rules = [];
		if( $id == ''){
			$rules = [
				'title' => 'required',
				'category_id' => 'required',
				'subject_id' => 'required',
				'chapter_id' => 'required',
				'sub_chapter_id' => 'required',
			];
		}

        if ($request->ajax()) {
            $data = $request->get('ajax');

            $validate = Validator::make($data, $rules);

            if ($validate->fails()) {
                return response()->json([
                            'code' => 422,
                            'errors' => $validate->errors()
                                ], 422);
            }
        } else {
            $this->validate($request, $rules);
        }

        if ($id != '' && $id > 0) {
            $this->authorize('admin_topic_parts_edit');
            $TopicParts = TopicParts::findOrFail($id);
            $TopicParts->update([
                'title' => isset($data['title']) ? $data['title'] : '',
                'paragraph' => isset($data['paragraph']) ? $data['paragraph'] : '',
                'topic_part_data' => isset($data['topic_part']) ? json_encode($data['topic_part']) : '',
                'created_by' => $user->id,
                'created_at' => time(),
            ]);
        } else {
            $this->authorize('admin_topic_parts_create');

            $TopicParts = TopicParts::create([
                'title' => isset($data['title']) ? $data['title'] : '',
                'category_id' => isset($data['category_id']) ? $data['category_id'] : 0,
                'subject_id' => isset($data['subject_id']) ? $data['subject_id'] : 0,
                'chapter_id' => isset($data['chapter_id']) ? $data['chapter_id'] : 0,
                'sub_chapter_id' => isset($data['sub_chapter_id']) ? $data['sub_chapter_id'] : 0,
                'paragraph' => isset($data['paragraph']) ? $data['paragraph'] : '',
                'topic_part_data' => isset($data['topic_part']) ? json_encode($data['topic_part']) : '',
                'created_by' => $user->id,
                'created_at' => time(),
            ]);
        }


        if ($request->ajax()) {
            $redirectUrl = '';
            $redirectUrl = '/admin/topics_parts/' . $TopicParts->id . '/edit';
            return response()->json([
                        'code' => 200,
                        'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('adminEditTopicPart', ['id' => $TopicParts->id]);
        }
    }

    public function destroy(Request $request, $id) {

        $this->authorize('admin_topic_parts_delete');

        TopicParts::find($id)->delete();

        removeContentLocale();

        return redirect('/admin/topics_parts');
    }

}
