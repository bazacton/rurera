<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Page;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\UserAssignedTopics;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Mail;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Session;

class TestsController extends Controller
{

    public function index()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        if (!auth()->user()->isUser()) {
            return redirect('/'.panelRoute());
        }
        $user = getUser();
		
        $switchUserObj = (object) array();
        if( $user->selected_user > 0) {
            $switchUserObj = User::find($user->selected_user);
        }

        $QuestionsAttemptController = new QuestionsAttemptController();

        $summary_type = 'sats';

        $graphs_array = array();

        $start_date = strtotime('2023-09-20');
        $end_date = strtotime('2023-09-26');

        $custom_dates = array(
            'start' => $start_date,
            'end'   => $end_date,
        );


        $query = Quiz::where('status', Quiz::ACTIVE)->whereIn('quiz_type', ['sats', '11plus', 'cat4', 'iseb', 'independence_exams'])->with('quizQuestionsList');
		if (auth()->check() && auth()->user()->isUser()) {
			$query->where(function ($subQuery) use ($user) {
				$subQuery->whereIn('quiz_type', array('sats', '11plus'))->orWhere('year_id', $user->year_id);	
			});
		}
		$sats = $query->paginate(100);
		
		
		
		$response_layout_array = array();
        $response_layout = '';
        if (!empty($sats)) {
			$counter = 0;
            foreach ($sats as $rowObj) {
                $view_file = 'single_item';
				
				$resultData = $QuestionsAttemptController->get_result_data($rowObj->id);
				$in_progress = isset( $resultData->in_progress )? $resultData->in_progress : false;
				$response_layout_array[]	= array(
					'is_resumed' => $in_progress,
					'response_layout' => view('web.default.tests.'.$view_file, [
						'rowObj'                     => $rowObj,
						'QuestionsAttemptController' => $QuestionsAttemptController,
						'counter'                    => $counter
					])->render(),
				);
            }
        }
		
		
		usort($response_layout_array, function($a, $b) {
			if ($a['is_resumed'] == $b['is_resumed']) {
				return 0;
			} elseif ($a['is_resumed'] == 1) {
				return -1; // $a should come before $b
			} else {
				return 1; // $a should come after $b
			}
		});
		
		if( !empty( $response_layout_array )){
			foreach( $response_layout_array as $response_layout_data){
				$response_layout	.= isset( $response_layout_data['response_layout'] )? $response_layout_data['response_layout'] : '';
			}
		}
        $parent_assignedArray = UserAssignedTopics::where('assigned_by_id', $user->id)->where('status', 'active')->select('id', 'assigned_by_id', 'topic_id', 'assigned_to_id', 'deadline_date')->get()->toArray();
        $parent_assigned_list = array();
        if (!empty($parent_assignedArray)) {
            foreach ($parent_assignedArray as $parent_assignedObj) {
                $topic_id = isset($parent_assignedObj['topic_id']) ? $parent_assignedObj['topic_id'] : 0;
                $assigned_to_id = isset($parent_assignedObj['assigned_to_id']) ? $parent_assignedObj['assigned_to_id'] : 0;
                $deadline_date = isset($parent_assignedObj['deadline_date']) ? $parent_assignedObj['deadline_date'] : 0;
                $parent_assigned_list[$topic_id][$assigned_to_id] = $parent_assignedObj;
                $parent_assigned_list[$topic_id]['deadline_date'] = $deadline_date;
            }
        }

        $childs = array();
        
        if (auth()->check() && auth()->user()->isParent()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }
        
        if (auth()->check() && auth()->user()->isTeacher()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'teacher')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }

        $QuestionsAttemptController = new QuestionsAttemptController();

        if (!empty($sats)) {
            $data = [
                'pageTitle'                  => 'Tests',
                'sats'                       => $sats,
                'QuestionsAttemptController' => $QuestionsAttemptController,
                'childs'                     => $childs,
				'response_layout' 		     => $response_layout,
                'switchUserObj'              => $switchUserObj,
                'parent_assigned_list'       => $parent_assigned_list,
                'summary_type'               => $summary_type,
                'custom_dates'               => $custom_dates,
            ];
            return view('web.default.tests.index', $data);
        }

        abort(404);
    }


    public function search_tests(Request $request)
    {
        $user = getUser();
        $QuestionsAttemptController = new QuestionsAttemptController();
        $counter = 0;
        $search_keyword = $request->get('search_keyword', '');
        $quiz_type = $request->get('quiz_type', '');
        $is_assignment = $request->get('is_assignment', '');
        $year_id = $request->get('year_id', '');

        $switch_user = $user->selected_user;


        $query = Quiz::where('status', Quiz::ACTIVE);
        if ($quiz_type != '' && $quiz_type != 'all' && $quiz_type != 'mock_test') {
            $query->where('quiz_type', $quiz_type);
        }else{
			if($quiz_type == 'mock_test'){
				$query-> whereIn('quiz_type', array('11plus','cat4','iseb','independence_exams'));
			}else{
				$query-> whereIn('quiz_type', array('sats','11plus','cat4','iseb','independence_exams'));
			}
        }
        $query->with('quizQuestionsList');
        if ($search_keyword != '') {
            $query->whereTranslationLike('title', '%' . $search_keyword . '%')->orWhere('quiz_type', 'like', "%$search_keyword%");
        }

		if( $quiz_type != 'sats' && $quiz_type != '11plus'){
			if( $is_assignment == 'yes'){
				$query->where('year_id', $year_id);
			}else {
				if ($switch_user > 0) {
					$switchUserObj = User::find($switch_user);
					$query->where('year_id', $switchUserObj->year_id);
				}
				if (auth()->check() && auth()->user()->isUser()) {
					$query->where('year_id', $user->year_id);
				}
			}
		}


        $tests = $query->paginate(100);
		

		$response_layout_array = array();
        $response_layout = '';
        if (!empty($tests)) {
            foreach ($tests as $rowObj) {
                $view_file = ( $is_assignment == 'yes')? 'single_item_assignment' : 'single_item';
				
				$resultData = $QuestionsAttemptController->get_result_data($rowObj->id);
				$in_progress = isset( $resultData->in_progress )? $resultData->in_progress : false;
				$response_layout_array[]	= array(
					'is_resumed' => $in_progress,
					'response_layout' => view('web.default.tests.'.$view_file, [
						'rowObj'                     => $rowObj,
						'QuestionsAttemptController' => $QuestionsAttemptController,
						'counter'                    => $counter
					])->render(),
				);
            }
        }
		
		usort($response_layout_array, function($a, $b) {
			if ($a['is_resumed'] == $b['is_resumed']) {
				return 0;
			} elseif ($a['is_resumed'] == 1) {
				return -1; // $a should come before $b
			} else {
				return 1; // $a should come after $b
			}
		});
		
		if( !empty( $response_layout_array )){
			foreach( $response_layout_array as $response_layout_data){
				$response_layout	.= isset( $response_layout_data['response_layout'] )? $response_layout_data['response_layout'] : '';
			}
		}

        $response_layout .= '<script>$(".total-tests").html("Total Tests: '.$tests->count().'")</script>';
        echo $response_layout;
        exit;

    }

    public function switch_user(Request $request)
    {
        $user = getUser();
        $switch_user = $request->get('switch_user', '');
        $user->update(['selected_user' => $switch_user]);
        exit;

    }


    public function custom_html(Request $request)
    {
        $data = [
            'pageTitle'                  => 'Custom HTML',
        ];
        return view('web.default.custom_html.index', $data);

    }


}
