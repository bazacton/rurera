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


class ReportsController extends Controller
{
	
	
	/*
	* Topics / Sub topics questions summary
	*/
	public function topics_questions(Request $request)
    {
        $this->authorize('admin_reports_topics_questions');

		$user = auth()->user();
		
		$category_id = 615;
		$subject_id = 2065;
		
		$chapters_list = get_chapters_list(false , $subject_id);
		
		$chapters = $sub_chapters = array();
		
		$authors_list = User::where('status', 'active')->where('role_id', 12)->pluck('id', 'display_name')->toArray();
		
		$sub_chapter_ids = [];
		foreach ($chapters_list as $chapter_data) {
			foreach ($chapter_data['chapters'] as $sub_chapter_id => $sub_chapter_title) {
				$sub_chapter_ids[] = $sub_chapter_id;
			}
		}
		
		$difficulty_levels = array('Emerging', 'Expected', 'Exceeding');
		
		$questions_types = array('dropdown', 'true_false', 'matching', 'sorting', 'single_select', 'text_field', 'multi_select', 'short_answer');

		$selectRawQuery = "
			chapter_id, sub_chapter_id,
			SUM(CASE WHEN hide_question = '1' THEN 1 ELSE 0 END) as hide_question_count,
			SUM(CASE WHEN developer_review_required = '1' THEN 1 ELSE 0 END) as developer_review_required_count,
			SUM(CASE WHEN review_required = '1' THEN 1 ELSE 0 END) as review_required_count,			
			COUNT(*) as total_questions
		";
		
		$authors_list['Admin'] = 1;
		
		
		foreach ($authors_list as $author_name => $author_id) {
			$author_key = $author_name . '_count';
			$selectRawQuery .= ",
			SUM(CASE WHEN creator_id = '$author_id' THEN 1 ELSE 0 END) as $author_key";
		}
		
		
		foreach ($questions_types as $question_type) {
			$type_key = $question_type . '_count';
			$selectRawQuery .= ",
			SUM(CASE WHEN question_type = '$question_type' THEN 1 ELSE 0 END) as $type_key";
		}

		
		foreach ($difficulty_levels as $level) {
			$level_key = $level . '_count'; // e.g. 'emerging_count', 'expected_count'
			$selectRawQuery .= ",
			SUM(CASE WHEN question_difficulty_level = '$level' THEN 1 ELSE 0 END) as $level_key";
		}

		$query = QuizzesQuestion::selectRaw($selectRawQuery)
			->WhereJsonContains('category_id', (string) $category_id)
			->whereIn('sub_chapter_id', $sub_chapter_ids)
			->where('question_status', '!=', 'Deleted')
			->groupBy('sub_chapter_id')
			->get();

		
		
		pre($query);

        $query = QuizzesQuestion::WhereJsonContains('category_id' , (string) $category_id)->where('course_id', $subject_id);

        $query->where('quizzes_questions.question_status' , '!=' , 'Deleted');


		$query = $this->topics_questions_filters($query , $request);
		
        $questions = $query->select('*')->paginate(50);
		
		pre($questions);

        $categories = Category::where('parent_id' , null)
            ->with('subCategories')
            ->get();

		$users_list = User::where('status' , 'active')->get();

        $data = [
            'pageTitle'           => 'Questions List' ,
            'questions'           => $questions,
            'categories'          => $categories,
            'user'                => $user,
            'users_list'          => $users_list,
        ];
        return view('admin.reports.topics_questions', $data);
    }
	
	
	private function topics_questions_filters($query , $request)
    {
        $from = get_filter_request('from', 'questions_search'); 
        $to = get_filter_request('to', 'questions_search'); 
        $title = get_filter_request('title', 'questions_search');
        $sort = get_filter_request('sort', 'questions_search'); 
        $teacher_ids = get_filter_request('teacher_ids', 'questions_search');
        $webinar_ids = get_filter_request('webinar_ids', 'questions_search');
        $question_status = get_filter_request('question_status', 'questions_search');
        $difficulty_level = get_filter_request('difficulty_level', 'questions_search'); 
        $review_required = get_filter_request('review_required', 'questions_search'); 
        $question_id = get_filter_request('question_id', 'questions_search'); 
        $category_id = get_filter_request('category_id', 'questions_search'); 
        $course_id = get_filter_request('subject_id', 'questions_search'); 
        $chapter_id = get_filter_request('chapter_id', 'questions_search'); 
        $sub_chapter_id = get_filter_request('sub_chapter_id', 'questions_search'); 
		$user_id = get_filter_request('user_id', 'glossary_search'); 


        $query = fromAndToDateFilter($from , $to , $query , 'quizzes_questions.created_at');

        if (!empty($title)) {
            $query->whereTranslationLike('title' , '%' . $title . '%')->orWhere('search_tags', 'LIKE' , '%' . $title . '%');
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'have_certificate':
                    $query->where('certificate' , true);
                    break;
                case 'students_count_asc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'asc');
                    break;

                case 'students_count_desc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'desc');
                    break;
                case 'passed_count_asc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status' , 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'asc');
                    break;

                case 'passed_count_desc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status' , 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'desc');
                    break;

                case 'grade_avg_asc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , 'quizzes_results.user_grade' , DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg' , 'asc');
                    break;

                case 'grade_avg_desc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , 'quizzes_results.user_grade' , DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg' , 'desc');
                    break;

                case 'created_at_asc':
                    $query->orderBy('created_at' , 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at' , 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at' , 'desc');
        }

        if (!empty($teacher_ids)) {
            $query->whereIn('creator_id' , $teacher_ids);
        }

        if (!empty($question_id)) {
            $query->where('id' , $question_id);
        }



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

        if ($review_required != '') {
            $query->where('quizzes_questions.review_required' , $review_required);
        }

        if (!empty($question_status) and $question_status !== 'all') {
            $query->where('quizzes_questions.question_status' , $question_status);
        }

        if (!empty($difficulty_level) and $difficulty_level !== 'all') {
            $query->where('quizzes_questions.question_difficulty_level' , $difficulty_level);
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
