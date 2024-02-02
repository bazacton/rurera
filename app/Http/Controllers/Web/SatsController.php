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

class SatsController extends Controller
{

    public function sats_landing()
    {

        if( isset( $_GET['image_to_text'] ) ) {
            $imagePath = 'assets/13.jpg';

            $image_text = (new TesseractOCR($imagePath))->hocr()
                ->run();
            $text = (new TesseractOCR($imagePath))->run();
            //pre($image_text);

            //preg_match_all('/title="bbox (\d+) (\d+) (\d+) (\d+)"/', $image_text, $matches, PREG_SET_ORDER|PREG_OFFSET_CAPTURE);


            echo '<img src="'.$imagePath.'">';
            //pre($image_text);







            //preg_match_all('/<span class="ocrx_word" id="word_([^"]+)" title="bbox (\d+) (\d+) (\d+) (\d+)">([^<]+)<\/span>/', $image_text, $matches, PREG_SET_ORDER);

            //pre($image_text);
            //preg_match_all('/<span class="ocrx_word" id="word_(\d+_\d+)" title="bbox (\d+) (\d+) (\d+) (\d+);[^"]*">([^<]+)<\/span>/', $image_text, $matches, PREG_SET_ORDER);
            //preg_match_all('/<span class="ocrx_word" id="word_(\d+_\d+)" title="bbox (\d+) (\d+) (\d+) (\d+)[^"]*">([^<]+)<\/span>/', $image_text, $matches, PREG_SET_ORDER);
            //preg_match_all('/<span class="ocrx_word" id="word_\d+_\d+" title="bbox \d+ \d+ \d+ \d+;[^"]*">[^<]+<\/span>/', $image_text, $matches);

            $span_explode = explode('<span', $image_text);
            $boxes = [];
            if( !empty( $span_explode ) ){
                $count = 0;
                foreach( $span_explode as $explodeData){
                    $count++;
                    if ($count == 1) {
                        continue;
                    }
                    if(!str_contains($explodeData, 'ocrx_word')){
                        continue;
                    }
                    $explodeData = explode('ocrx_word', $explodeData);
                    $explodeData = isset( $explodeData[1])? $explodeData[1] : '';
                    $explodeData = explode("title='bbox ", $explodeData);
                    $positionsString = explode(";", $explodeData[1]);
                    $positionsString = isset( $positionsString[0] )? $positionsString[0] : '';
                    $explodeDataText = explode(">", $explodeData[1]);
                    $explodeDataText = explode("<", $explodeDataText[1]);
                    $text_string = isset( $explodeDataText[0])? $explodeDataText[0] : '';
                    $positionsArray = explode(' ', $positionsString);

                    $x1 = isset( $positionsArray[0] )? preg_replace('/[^A-Za-z0-9\-]/', '', $positionsArray[0]) : 0;
                    $y1 = isset( $positionsArray[1] )? preg_replace('/[^A-Za-z0-9\-]/', '', $positionsArray[1]) : 0;
                    $x2 = isset( $positionsArray[2] )? preg_replace('/[^A-Za-z0-9\-]/', '', $positionsArray[2]) : 0;
                    $y2 = isset( $positionsArray[3] )? preg_replace('/[^A-Za-z0-9\-]/', '', $positionsArray[3]) : 0;

                    $boxes[] = [
                        'text' => preg_replace('/[^A-Za-z0-9\-]/', '', $text_string),
                        'position' => [
                            'x1' => $x1+8,
                            'y1' => $y1,
                            'x2' => $x2,
                            'y2' => $y2,
                        ],
                    ];
                }
            }

            if( !empty( $boxes ) ){
                foreach( $boxes as $boxData){
                    $textCount = strlen($boxData['text']);

                    echo '<span style="position: absolute;
                        z-index: 9999;
                        left: '.$boxData['position']['x1'].'px;
                        top: '.$boxData['position']['y1'].'px;
                        font-size: 33px;
                        background: #f5ff58;
                        opacity: 0.5;
                        color: transparent;
                        font-family: cursive;">'.$boxData['text'].'</span>';
                }
            }
            pre('done');







            pre($matches);
            $boxes = [];
            foreach ($matches as $match) {
                pre($match, false);
                // Coordinates from hOCR
                $x1 = intval($match[1]);
                $y1 = intval($match[2]);
                $x2 = intval($match[3]);
                $y2 = intval($match[4]);

                // Convert coordinates to absolute positions
                $x1_abs = $x1;
                $y1_abs = $y1;
                $x2_abs = $x2;
                $y2_abs = $y2;

                $boxes[] = [
                    'text' => $text,
                    'position' => [
                        'x1' => $x1_abs,
                        'y1' => $y1_abs,
                        'x2' => $x2_abs,
                        'y2' => $y2_abs,
                    ],
                ];
            }
            pre('test');


            $tesseract = new TesseractOCR();
            $tesseract->setImage('image.jpg');
            $text = $tesseract->getText();
            pre($text);
            $image_text = (new TesseractOCR($imagePath))->run();
            pre($image_text);

        }
        if( isset( $_GET['email_test'] ) ) {
                $email = 'baz.chimpstudio@gmail.com';
                $message = 'Testing Email Message';
                Mail::send(getTemplate().'.emails.test', [
                    'name' => 'Baz Acton',
                    'email' => 'info@rurera.com',
                ], function ($message) use ($email) {
                    $message->to($email);
                    $message->subject('Welcome to Laravel!');
                });
                pre('test');
        }
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

    public function printTextNTimes($text, $times) {
        $response = '';
        for ($i = 0; $i < $times; $i++) {
            $response .= $text;
        }
        return $response;
    }

    public function index()
    {
        if (!auth()->check()) {
            //return redirect('/login');
        }
        $user = getUser();

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

        $query = Quiz::where('status', Quiz::ACTIVE)->where('quiz_type', 'sats')->with('quizQuestionsList');
        $sats = $query->paginate(100);

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
            //return redirect('/login');
        }

        //$quiz = Quiz::find($id);
        $quiz = Quiz::where('quiz_slug', $quiz_slug)->first();
        $id = $quiz->id;
        /*if (!auth()->subscription('sats') && !auth()->assginment('sats', $id)) {
            return view('web.default.quizzes.not_subscribed');
        }*/

        $QuestionsAttemptController = new QuestionsAttemptController();
        //$started_already = $QuestionsAttemptController->started_already($id);

        $started_already = false;
        if ($started_already == true) {
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
            ];
            return view('web.default.quizzes.auto_load', $data);
            //$QuizController = new QuizController();
            //return $QuizController->start($request, $id);
        } else {
            //$resultData = $QuestionsAttemptController->get_result_data($id);
            //$resultData = $QuestionsAttemptController->prepare_result_array($resultData);
            //$is_passed = isset($resultData->is_passed) ? $resultData->is_passed : false;
            //$in_progress = isset($resultData->in_progress) ? $resultData->in_progress : false;
            //$current_status = isset($resultData->current_status) ? $resultData->current_status : '';
            $resultData = array();
            $data = [
                'pageTitle'  => 'Start',
                'quiz'       => $quiz,
                'resultData' => $resultData
            ];
            return view('web.default.quizzes.start', $data);
        }
    }


}
