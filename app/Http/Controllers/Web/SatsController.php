<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\QuizController;
use App\Models\Page;
use App\Models\Quiz;
use App\Models\UserAssignedTopics;
use App\User;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class SatsController extends Controller
{

    public function sats_landing()
    {

        if( isset( $_GET['tts'] ) ) {
            $text = $_GET['tts'];
            $TextToSpeechController = new TextToSpeechController();
            $text_audio_path = $TextToSpeechController->getSpeechAudioFilePath($text);

            echo '<audio controls>
              <source src="'.url('/speech-audio/' . $text_audio_path).'" type="audio/mpeg">
            </audio>';
            exit;

            pre(url('/speech-audio/' . $text_audio_path));
            pre($text_audio_path);
        }

        $page = Page::where('link', '/sats-preparation')->where('status', 'publish')->first();

        $data = [
            'pageTitle'       => $page->title,
            'pageDescription' => $page->seo_description,
            'pageRobot'       => $page->robot ? 'index, follow, all' : 'NOODP, nofollow, noindex',
            //'pageTitle'       => 'KS1, KS2 SATs practice papers, assessments & Tests | Rurera',
            //'pageDescription' => 'Prepare for your SATs exam with comprehensive SATs practice resources, assessments, tests, and quizzes. Get ready to excel on your SATs  and got  a chance to win rewards.',
            //'pageRobot'       => 'index',
        ];
        return view('web.default.sats.sats_landing', $data);

        abort(404);
    }

    public function index()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        $user = auth()->user();

        $QuestionsAttemptController = new QuestionsAttemptController();
        $summary_type = 'sats';
        $QuizzResultQuestionsObj = $QuestionsAttemptController->prepare_graph_data($summary_type);

        $graphs_array = array();

        $start_date = strtotime('2023-09-20');
        $end_date = strtotime('2023-09-26');

        $custom_dates = array(
            'start' => $start_date,
            'end' => $end_date,
        );

        $graphs_array['Custom'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'custom', $start_date, $end_date);

        $graphs_array['Year'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'yearly');
        $graphs_array['Month'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'monthly');
        $graphs_array['Week'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'weekly');
        $graphs_array['Day'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'daily');
        $graphs_array['Hour'] = $QuestionsAttemptController->user_graph_data($QuizzResultQuestionsObj, 'hourly');

        $query = Quiz::where('status', Quiz::ACTIVE)->where('quiz_type', 'sats');
        $sats = $query->paginate(100);

        $parent_assignedArray = UserAssignedTopics::where('parent_id', $user->id)->where('status', 'active')->select('id', 'parent_id', 'topic_id', 'assigned_to_id', 'deadline_date')->get()->toArray();
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
        if (auth()->user()->isParent()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'parent')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }
        if (auth()->user()->isTeacher()) {
            $childs = User::where('role_id', 1)
                ->where('parent_type', 'teacher')
                ->where('parent_id', $user->id)
                ->where('status', 'active')
                ->get();
        }

        $QuestionsAttemptController = new QuestionsAttemptController();

        if (!empty($sats)) {
            $data = [
                'pageTitle'                  => 'SATs',
                'sats'                       => $sats,
                'QuestionsAttemptController' => $QuestionsAttemptController,
                'childs'                     => $childs,
                'parent_assigned_list'       => $parent_assigned_list,
                'graphs_array'  => $graphs_array,
                'summary_type'  => $summary_type,
                'custom_dates' => $custom_dates,
            ];
            return view('web.default.sats.index', $data);
        }

        abort(404);
    }

    /*
     * Start SAT Quiz
     */
    public function start(Request $request, $quiz_slug)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        //$quiz = Quiz::find($id);
        $quiz = Quiz::where('quiz_slug', $quiz_slug)->first();
        $id = $quiz->id;
        if (!auth()->subscription('sats') && !auth()->assginment('sats', $id)) {
            return view('web.default.quizzes.not_subscribed');
        }

        $QuestionsAttemptController = new QuestionsAttemptController();
        $started_already = $QuestionsAttemptController->started_already($id);

        //$started_already = false;
        if ($started_already == true) {
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
            ];
            return view('web.default.quizzes.auto_load', $data);
            //$QuizController = new QuizController();
            //return $QuizController->start($request, $id);
        } else {
            $resultData = $QuestionsAttemptController->get_result_data($id);
            $resultData = $QuestionsAttemptController->prepare_result_array($resultData);
            $is_passed = isset($resultData->is_passed) ? $resultData->is_passed : false;
            $in_progress = isset($resultData->in_progress) ? $resultData->in_progress : false;
            $current_status = isset($resultData->current_status) ? $resultData->current_status : '';
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
                'resultData' => $resultData
            ];
            return view('web.default.quizzes.start', $data);
        }
    }


}
