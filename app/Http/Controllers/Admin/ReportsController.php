<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use App\Models\Setting;
use App\Models\Translation\SettingTranslation;
use App\Models\WebinarReport;
use Illuminate\Http\Request;

use App\User;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesQuestionsList;
use App\Models\Category;
use App\Models\Permission;
use App\Models\TopicParts;


class ReportsController extends Controller
{
	
	
	/*
	* Topics / Sub topics questions summary
	*/
	public function topics_questions(Request $request)
    {
        $this->authorize('admin_reports_topics_questions');

		$user = auth()->user();
		
		$category_id = get_filter_request('category_id', 'topics_questions_report_search'); 
        $course_id = get_filter_request('subject_id', 'topics_questions_report_search'); 
		
		$category_id = ($category_id == '')? 615 : $category_id;
		$subject_id = ($course_id == '')? 2065 : $course_id;
		
		$chapters_list = get_chapters_list(false , $subject_id);
		
		$TopicParts = TopicParts::where('category_id', $category_id)->where('subject_id', $subject_id)->get();
		
		
		$sub_topic_parts = array();
		if( $TopicParts->count() > 0){
			foreach( $TopicParts as $TopicPartObj){
				//pre($TopicPartObj);
				$topic_part_data = isset( $TopicPartObj->topic_part_data )? (array) json_decode($TopicPartObj->topic_part_data) : array();
				$prev_count = isset( $sub_topic_parts[$TopicPartObj->sub_chapter_id]['topics_parts_count'] )? $sub_topic_parts[$TopicPartObj->sub_chapter_id]['topics_parts_count'] : 0;
				$sub_topic_parts[$TopicPartObj->sub_chapter_id]['topics_parts'][] = $TopicPartObj->topic_part_data;
				$sub_topic_parts[$TopicPartObj->sub_chapter_id]['topics_parts_count'] = $prev_count+count($topic_part_data);
			}
		}
		//pre($sub_topic_parts);
		
		$chapters = $sub_chapters = array();
		
		
		$roles_array = Permission::where('section_id', 2034)->where('allow', 1)->pluck('role_id')->toArray();
		$authors_list = User::where('status', 'active')->whereIn('role_id', $roles_array)->get();
		$sub_chapter_ids = [];
		foreach ($chapters_list as $chapter_data) {
			foreach ($chapter_data['chapters'] as $sub_chapter_id => $sub_chapter_title) {
				$sub_chapter_ids[] = $sub_chapter_id;
			}
		}
		$toolbar_tools = toolbar_tools();
		$questions_types = array();
		foreach( $toolbar_tools as $element_slug => $toolObj){
			$element_type = isset( $toolObj['element_type'] )? $toolObj['element_type'] : '';
			if( $element_type == 'main'){
				$questions_types[$element_slug] = isset( $toolObj['title'] )? $toolObj['title'] : '';
			}
		}
		
		$difficulty_levels = array('Emerging', 'Expected', 'Exceeding');

		$selectRawQuery = "
			chapter_id, sub_chapter_id,
			SUM(CASE WHEN hide_question = '1' THEN 1 ELSE 0 END) as hide_question_count,
			SUM(CASE WHEN developer_review_required = '1' THEN 1 ELSE 0 END) as developer_review_required_count,
			SUM(CASE WHEN review_required = '1' THEN 1 ELSE 0 END) as review_required_count,			
			SUM(CASE WHEN with_media = '1' THEN 1 ELSE 0 END) as with_media_count,				
			SUM(CASE WHEN with_media = '0' THEN 1 ELSE 0 END) as without_media_count,				
			SUM(CASE WHEN hide_question IN(0,1) THEN 1 ELSE 0 END) as total_questions_count,	
			COUNT(*) as total_questions
		";
		
		
		
		foreach ($authors_list as $authorObj) {
			if( !isset( $authorObj->id)){
				continue;
			}
			$author_name = $authorObj->get_full_name();
			$author_name = str_replace(' ', '', $author_name);
			$author_id = $authorObj->id;
			$author_key = $author_name . '_count';
			$selectRawQuery .= ",
			SUM(CASE WHEN creator_id = '$author_id' THEN 1 ELSE 0 END) as $author_key";
		}
		
		
		foreach ($questions_types as $question_type => $question_type_title) {
			$type_key = $question_type . '_count';
			$selectRawQuery .= ",
			SUM(CASE WHEN question_type = '$question_type' THEN 1 ELSE 0 END) as $type_key";
		}

		
		foreach ($difficulty_levels as $level) {
			$level_key = $level . '_count'; // e.g. 'emerging_count', 'expected_count'
			$selectRawQuery .= ",
			SUM(CASE WHEN question_difficulty_level = '$level' THEN 1 ELSE 0 END) as $level_key";
		}
		
		$query = QuizzesQuestion::query();

		$query->selectRaw($selectRawQuery);

		$query = $this->topics_questions_filters($query , $request, $category_id, $subject_id);
		
		$query = $query->whereIn('sub_chapter_id', $sub_chapter_ids)
			->where('question_status', '!=', 'Deleted')->groupBy('sub_chapter_id')
			->get();
		
        $categories = Category::where('parent_id' , null)
            ->with('subCategories')
            ->get();


        $data = [
            'pageTitle'           => 'Questions List' ,
            'categories'          => $categories,
            'user'                => $user,
            'report_data'          => $query,
			'authors_list' => $authors_list,
			'difficulty_levels' => $difficulty_levels,
			'questions_types' => $questions_types,
			'sub_topic_parts' => $sub_topic_parts,
        ];
        return view('admin.reports.topics_questions', $data);
    }
	
	
	private function topics_questions_filters($query , $request, $default_category_id, $default_subject_id)
    {
        $from = get_filter_request('from', 'topics_questions_report_search'); 
        $to = get_filter_request('to', 'topics_questions_report_search'); 
        $category_id = get_filter_request('category_id', 'topics_questions_report_search'); 
        $course_id = get_filter_request('subject_id', 'topics_questions_report_search'); 
        $chapter_id = get_filter_request('chapter_id', 'topics_questions_report_search'); 
        $sub_chapter_id = get_filter_request('sub_chapter_id', 'topics_questions_report_search'); 
		$user_id = get_filter_request('user_id', 'topics_questions_report_search'); 
		
		$category_id = ($category_id == '')? $default_category_id : $category_id;
		$course_id = ($course_id == '')? $default_subject_id : $course_id;


        $query = fromAndToDateFilter($from , $to , $query , 'quizzes_questions.created_at');


        if ($course_id != '') {
            $query->where('quizzes_questions.course_id' , $course_id);
        }
		
        if ($category_id != '') {
            $query->WhereJsonContains('quizzes_questions.category_id' , (string) $category_id);
        }
		if ($user_id != '') {
            $query->where('quizzes_questions.creator_id' , $user_id);
        }

        if ($chapter_id != '') {
            $query->where('quizzes_questions.chapter_id' , $chapter_id);
        }
		
        if ($sub_chapter_id != '') {
            $query->where('quizzes_questions.sub_chapter_id' , $sub_chapter_id);
        }
		


        return $query;
    }
	
	
	
	
	
	
	
    public function reasons(Request $request)
    {
        $this->authorize('admin_report_reasons');

        $value = [];

        $settings = Setting::where('name', 'report_reasons')->first();

        $locale = $request->get('locale', getDefaultLocale());
        storeContentLocale($locale, $settings->getTable(), $settings->id);

        if (!empty($settings) and !empty($settings->value)) {
            $value = json_decode($settings->value, true);
        }


        $data = [
            'pageTitle' => trans('admin/pages/setting.report_reasons'),
            'value' => $value,
        ];


        return view('admin.reports.reasons', $data);
    }

    public function storeReasons(Request $request)
    {
        $this->authorize('admin_report_reasons');

        $name = 'report_reasons';

        $values = $request->get('value', null);

        if (!empty($values)) {
            $locale = $request->get('locale', getDefaultLocale());

            $values = array_filter($values, function ($val) {
                if (is_array($val)) {
                    return array_filter($val);
                } else {
                    return !empty($val);
                }
            });

            $values = json_encode($values);
            $values = str_replace('record', rand(1, 600), $values);

            $settings = Setting::updateOrCreate(
                ['name' => $name],
                [
                    'updated_at' => time(),
                ]
            );

            SettingTranslation::updateOrCreate(
                [
                    'setting_id' => $settings->id,
                    'locale' => mb_strtolower($locale)
                ],
                [
                    'value' => $values,
                ]
            );

            cache()->forget('settings.' . $name);
        }

        removeContentLocale();

        return back();
    }

    public function webinarsReports()
    {
        $this->authorize('admin_webinar_reports');

        $reports = WebinarReport::with(['user' => function ($query) {
            $query->select('id', 'full_name');
        }, 'webinar' => function ($query) {
            $query->select('id', 'slug');
        }])->orderBy('created_at', 'desc')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/comments.classes_reports'),
            'reports' => $reports
        ];

        return view('admin.webinars.reports', $data);
    }

    public function delete($id)
    {
        $this->authorize('admin_webinar_reports_delete');

        $report = WebinarReport::findOrFail($id);

        $report->delete();

        return redirect()->back();
    }
}
