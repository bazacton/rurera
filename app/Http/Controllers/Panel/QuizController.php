<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\QuestionsAttemptController;
use App\Models\AssignmentsQuestions;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\Translation\QuizTranslation;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\Models\QuizzResultQuestions;
use App\Models\AssignedAssignments;
use App\User;
use App\Models\Webinar;
use App\Models\QuizzesResult;
use App\Models\QuizzAttempts;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesQuestionsAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $allQuizzesLists = Quiz::select('id', 'webinar_id')->where('creator_id', $user->id)->where('status', 'active')->get();


        $query = Quiz::where('creator_id', $user->id);

        $quizzesCount = deepClone($query)->count();

        $quizFilters = $this->filters($request, $query);

        $quizzes = $quizFilters->with([
            'webinar',
            'quizQuestions',
            'quizResults',
        ])->orderBy('created_at', 'desc')->orderBy('updated_at', 'desc')->paginate(10);

        $userSuccessRate = [];
        $questionsCount = 0;
        $userCount = 0;

        foreach ($quizzes as $quiz) {

            $countSuccess = $quiz->quizResults->where('status', \App\Models\QuizzesResult::$passed)->pluck('user_id')->count();

            $rate = 0;
            if ($countSuccess) {
                $rate = round($countSuccess / $quiz->quizResults->count() * 100);
            }

            $quiz->userSuccessRate = $rate;

            $questionsCount += $quiz->quizQuestions->count();
            $userCount += $quiz->quizResults->pluck('user_id')->count();
        }

        $data = [
            'pageTitle'       => trans('quiz.quizzes_list_page_title'),
            'quizzes'         => $quizzes,
            'userSuccessRate' => $userSuccessRate,
            'questionsCount'  => $questionsCount,
            'quizzesCount'    => $quizzesCount,
            'userCount'       => $userCount,
            'allQuizzesLists' => $allQuizzesLists
        ];

        return view(getTemplate() . '.panel.quizzes.lists', $data);
    }

    public function filters(Request $request, $query)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $quiz_id = $request->get('quiz_id');
        $total_mark = $request->get('total_mark');
        $status = $request->get('status');
        $active_quizzes = $request->get('active_quizzes');


        $query = fromAndToDateFilter($from, $to, $query, 'created_at');

        if (!empty($quiz_id) and $quiz_id != 'all') {
            $query->where('id', $quiz_id);
        }

        if ($status and $status !== 'all') {
            $query->where('status', strtolower($status));
        }

        if (!empty($active_quizzes)) {
            $query->where('status', 'active');
        }

        if ($total_mark) {
            $query->where('total_mark', '>=', $total_mark);
        }

        return $query;
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $webinars = Webinar::where(function ($query) use ($user) {
            $query->where('teacher_id', $user->id)->orWhere('creator_id', $user->id);
        })->get();

        $locale = $request->get('locale', app()->getLocale());

        $data = [
            'pageTitle'     => trans('quiz.new_quiz_page_title'),
            'webinars'      => $webinars,
            'userLanguages' => getUserLanguagesLists(),
            'locale'        => mb_strtolower($locale),
            'defaultLocale' => getDefaultLocale(),
        ];

        return view(getTemplate() . '.panel.quizzes.create', $data);
    }

    public function store(Request $request)
    {
        $data = $request->get('ajax')['new'];
        $locale = $data['locale'] ?? getDefaultLocale();

        $rules = [
            'title'      => 'required|max:255',
            'webinar_id' => 'nullable',
            'pass_mark'  => 'required',
        ];

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'code'   => 422,
                'errors' => $validate->errors()
            ], 422);
        }

        $user = auth()->user();

        $webinar = null;
        $chapter = null;
        if (!empty($data['webinar_id'])) {
            $webinar = Webinar::where('id', $data['webinar_id'])->where(function ($query) use ($user) {
                $query->where('teacher_id', $user->id)->orWhere('creator_id', $user->id);
            })->first();

            if (!empty($webinar) and !empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id', $data['chapter_id'])->where('webinar_id', $webinar->id)->first();
            }
        }

        $quiz = Quiz::create([
            'webinar_id'                 => !empty($webinar) ? $webinar->id : null,
            'chapter_id'                 => !empty($chapter) ? $chapter->id : null,
            'creator_id'                 => $user->id,
            'attempt'                    => $data['attempt'] ?? null,
            'pass_mark'                  => $data['pass_mark'],
            'time'                       => $data['time'] ?? null,
            'status'                     => (!empty($data['status']) and $data['status'] == 'on') ? Quiz::ACTIVE : Quiz::INACTIVE,
            'certificate'                => (!empty($data['certificate']) and $data['certificate'] == 'on'),
            'display_questions_randomly' => (!empty($data['display_questions_randomly']) and $data['display_questions_randomly'] == 'on'),
            'expiry_days'                => (!empty($data['expiry_days']) and $data['expiry_days'] > 0) ? $data['expiry_days'] : null,
            'created_at'                 => time(),
        ]);

        if (!empty($quiz)) {
            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id,
                'locale'  => mb_strtolower($locale),
            ], ['title' => $data['title'],]);

            if (!empty($quiz->chapter_id)) {
                WebinarChapterItem::makeItem($user->id, $quiz->chapter_id, $quiz->id, WebinarChapterItem::$chapterQuiz);
            }
        }

        // Send Notification To All Students
        if (!empty($webinar)) {
            $webinar->sendNotificationToAllStudentsForNewQuizPublished($quiz);
        }

        if ($request->ajax()) {

            $redirectUrl = '';

            if (empty($data['is_webinar_page'])) {
                $redirectUrl = '/panel/quizzes/' . $quiz->id . '/edit';
            }

            return response()->json([
                'code'         => 200,
                'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('panel_edit_quiz', ['id' => $quiz->id]);
        }
    }

    public function edit(Request $request, $id)
    {
        $user = auth()->user();
        $webinars = Webinar::where(function ($query) use ($user) {
            $query->where('teacher_id', $user->id)->orWhere('creator_id', $user->id);
        })->get();

        $webinarIds = $webinars->pluck('id')->toArray();

        $quiz = Quiz::where('id', $id)->where('creator_id', $user->id)->where(function ($query) use ($user, $webinarIds) {
            $query->where('creator_id', $user->id);
            $query->orWhereIn('webinar_id', $webinarIds);
        })->with([
            'quizQuestions' => function ($query) {
                $query->orderBy('order', 'asc');
                $query->with('quizzesQuestionsAnswers');
            },
        ])->first();

        if (!empty($quiz)) {
            $chapters = collect();

            if (!empty($quiz->webinar)) {
                $chapters = $quiz->webinar->chapters;
            }

            $locale = $request->get('locale', app()->getLocale());

            $data = [
                'pageTitle'     => trans('public.edit') . ' ' . $quiz->title,
                'webinars'      => $webinars,
                'quiz'          => $quiz,
                'quizQuestions' => $quiz->quizQuestions,
                'chapters'      => $chapters,
                'userLanguages' => getUserLanguagesLists(),
                'locale'        => mb_strtolower($locale),
                'defaultLocale' => getDefaultLocale(),
            ];

            return view(getTemplate() . '.panel.quizzes.create', $data);
        }

        abort(404);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $webinar = null;
        if (!empty($data['webinar_id'])) {
            $webinar = Webinar::where('id', $data['webinar_id'])->where(function ($query) use ($user) {
                $query->where('teacher_id', $user->id)->orWhere('creator_id', $user->id);
            })->first();
        }


        $quiz = Quiz::query()->where('id', $id)->where(function ($query) use ($user, $webinar) {
            $query->where('creator_id', $user->id);

            if (!empty($webinar)) {
                $query->orWhere('webinar_id', $webinar->id);
            }
        })->first();

        if (!empty($quiz)) {
            $quizQuestionsCount = $quiz->quizQuestions->count();

            $data = $request->get('ajax')[$id];
            $locale = $data['locale'] ?? getDefaultLocale();

            $rules = [
                'title'                       => 'required|max:255',
                'webinar_id'                  => 'nullable',
                'pass_mark'                   => 'required',
                'display_number_of_questions' => 'required_if:display_limited_questions,on|nullable|between:1,' . $quizQuestionsCount
            ];

            $validate = Validator::make($data, $rules);

            if ($validate->fails()) {
                return response()->json([
                    'code'   => 422,
                    'errors' => $validate->errors()
                ], 422);
            }


            if (!empty($webinar) and !empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id', $data['chapter_id'])->where('webinar_id', $webinar->id)->first();
            }

            $quiz->update([
                'webinar_id'                  => !empty($webinar) ? $webinar->id : null,
                'chapter_id'                  => !empty($chapter) ? $chapter->id : null,
                'attempt'                     => $data['attempt'] ?? null,
                'pass_mark'                   => $data['pass_mark'],
                'time'                        => $data['time'] ?? null,
                'status'                      => (!empty($data['status']) and $data['status'] == 'on') ? Quiz::ACTIVE : Quiz::INACTIVE,
                'certificate'                 => (!empty($data['certificate']) and $data['certificate'] == 'on'),
                'display_limited_questions'   => (!empty($data['display_limited_questions']) and $data['display_limited_questions'] == 'on'),
                'display_number_of_questions' => (!empty($data['display_limited_questions']) and $data['display_limited_questions'] == 'on' and !empty($data['display_number_of_questions'])) ? $data['display_number_of_questions'] : null,
                'display_questions_randomly'  => (!empty($data['display_questions_randomly']) and $data['display_questions_randomly'] == 'on'),
                'expiry_days'                 => (!empty($data['expiry_days']) and $data['expiry_days'] > 0) ? $data['expiry_days'] : null,
                'updated_at'                  => time(),
            ]);


            $checkChapterItem = WebinarChapterItem::where('user_id', $user->id)->where('item_id', $quiz->id)->where('type', WebinarChapterItem::$chapterQuiz)->first();

            if (!empty($quiz->chapter_id)) {
                if (empty($checkChapterItem)) {
                    WebinarChapterItem::makeItem($user->id, $quiz->chapter_id, $quiz->id, WebinarChapterItem::$chapterQuiz);
                } elseif ($checkChapterItem->chapter_id != $quiz->chapter_id) {
                    $checkChapterItem->delete(); // remove quiz from old chapter and assign it to new chapter

                    WebinarChapterItem::makeItem($user->id, $quiz->chapter_id, $quiz->id, WebinarChapterItem::$chapterQuiz);
                }
            } else if (!empty($checkChapterItem)) {
                $checkChapterItem->delete();
            }

            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id,
                'locale'  => mb_strtolower($data['locale']),
            ], ['title' => $data['title'],]);

            if ($request->ajax()) {
                return response()->json(['code' => 200]);
            } else {
                return redirect('panel/quizzes');
            }
        }

        abort(404);
    }

    public function destroy(Request $request, $id)
    {
        $user = auth()->user();
        $quiz = Quiz::where('id', $id)->first();

        if (!empty($quiz)) {

            $webinar = null;
            if (!empty($quiz->webinar_id)) {
                $webinar = Webinar::query()->find($quiz->webinar_id);
            }

            if ($quiz->creator_id == $user->id or (!empty($webinar) and $webinar->canAccess($user))) {
                if ($quiz->delete()) {
                    $checkChapterItem = WebinarChapterItem::where('user_id', $user->id)->where('item_id', $id)->where('type', WebinarChapterItem::$chapterQuiz)->first();

                    if (!empty($checkChapterItem)) {
                        $checkChapterItem->delete();
                    }

                    return response()->json(['code' => 200], 200);
                }
            }
        }

        return response()->json([], 422);
    }

    public function start(Request $request, $id)
    {
        //$user = auth()->user();
        $user = getUser();

        $quiz_level = $request->get('quiz_level', 'easy');
        $learning_journey = $request->get('learning_journey', 'no');
        $journey_item_id = $request->get('journey_item_id', 'no');
		$test_type = $request->get('test_type', '');
		$test_type_file = get_test_type_file($test_type);
		

        $no_of_questions = 0;


        $quiz = Quiz::where('id', $id)->with([
            'quizQuestionsList' => function ($query) {
                $query->where('status', 'active');
            },
        ])->first();

        $QuestionsAttemptController = new QuestionsAttemptController();

        $questions_list_data_array = $QuestionsAttemptController->getQuizQuestionsList($quiz, $quiz_level, $learning_journey);
		
		
        $questions_list = isset($questions_list_data_array['questions_list']) ? $questions_list_data_array['questions_list'] : array();
        $other_data = isset($questions_list_data_array['other_data']) ? $questions_list_data_array['other_data'] : '';
        $quiz_breakdown = isset($questions_list_data_array['quiz_breakdown']) ? $questions_list_data_array['quiz_breakdown'] : '';
        $QuizzesResultID = isset($questions_list_data_array['QuizzesResultID']) ? $questions_list_data_array['QuizzesResultID'] : 0;

        if (auth()->guest()) {
            $total_attempted_questions = QuizzResultQuestions::where('quiz_result_type', $quiz->quiz_type)->where('status', '!=', 'waiting')->where('user_id', 0)->where('user_ip', getUserIP())->count();
            $total_questions_allowed = getGuestLimit($quiz->quiz_type);
            $no_of_questions = ($total_questions_allowed - $total_attempted_questions);
            if ($no_of_questions < 1) {
                return view('web.default.quizzes.limit_reached');
            }
        }


        if ($quiz->quiz_type == 'assignment') {

            $AssignedAssignments = AssignedAssignments::where('assignment_id', $quiz->id)->whereJsonContains('user_ids', ["$user->id"])->where('status', 'active')->first();
            $total_attempted = QuizzesResult::where('parent_type_id', $quiz->id)->where('user_id', $user->id)->where('status', '!=', 'waiting')->count();
            if ($total_attempted >= $AssignedAssignments->no_of_attempts) {
                $toastData = [
                    'title'  => '',
                    'msg'    => 'You are not authorized to attempt this assignment',
                    'status' => 'error'
                ];
                return back()->with(['toast' => $toastData]);
            }

        }

        $newQuizStart = QuizzesResult::where('parent_type_id', $quiz->id)->where('user_id', $user->id)->where('status', 'waiting');
        if (auth()->guest()) {
            $newQuizStart->where('user_ip', getUserIP());
        }
        $newQuizStart = $newQuizStart->first();


        if ($no_of_questions > 0) {
            $questions_list = array_slice($questions_list, 0, $no_of_questions);
        }
		
		//pre($questions_list);


        if ($quiz) {
            $show_all_questions = $quiz->show_all_questions;
            $show_all_questions = true;


            if( $QuizzesResultID > 0){
                $resultLogObj = QuizzesResult::find($QuizzesResultID);
                $prev_active_question_id = $resultLogObj->active_question_id;
            }else {
				$quiz_result_type = ($learning_journey == 'yes')? 'learning_journey' : $quiz->quiz_type;
                $resultLogObj = $QuestionsAttemptController->createResultLog([
                    'parent_type_id'   => $quiz->id,
                    'quiz_result_type' => $quiz_result_type,
                    'questions_list'   => $questions_list,
                    'no_of_attempts'   => $quiz->attempt,
                    'other_data'       => $other_data,
                    'quiz_breakdown'   => $quiz_breakdown,
                    'quiz_level'       => $quiz_level,
					'journey_item_id' => $journey_item_id,
                ]);

                $prev_active_question_id = isset($resultLogObj->active_question_id) ? $resultLogObj->active_question_id : 0;

                if ($prev_active_question_id > 0) {
                    $prevActiveQuestionObj = QuizzResultQuestions::find($prev_active_question_id);
                    $prev_active_question_id = isset($prevActiveQuestionObj->question_id) ? $prevActiveQuestionObj->question_id : 0;
                }
            }


            $attemptLogObj = $QuestionsAttemptController->createAttemptLog($resultLogObj);
            //$attempt_log_id = createAttemptLog($attemptLogObj->id, 'Session Started', 'started');

            $question_points = isset($question->question_score) ? $question->question_score : 0;


            if ($quiz->quiz_type == 'practice') {
                $quiz_settings = json_decode($quiz->quiz_settings);
                $difficulty_level = isset($question->question_difficulty_level) ? $question->question_difficulty_level : '';
                //$question_points = isset($quiz_settings->$difficulty_level->points) ? $quiz_settings->$difficulty_level->points : 0;
            }


            $questions_array = $exclude_array = array();
            //$exclude_array[] = $questionObj->id;
            //$questions_array[] = $questionObj;
            $questions_layout = $results_questions_array = array();
            $active_question_id = $first_question_id = 0;
            $actual_question_ids = array();


            //Stores the question id of questions results table with the index of actual question ID
            $questions_result_reference_array = array();
			$elementsData = array();
			
			//pre($questions_list, false);

            if (!empty($questions_list)) {
                $questions_counter = 0;
                foreach ($questions_list as $question_no_index => $question_id) {
					
                    $question_no = $question_no_index;
                    $prev_question = isset($questions_list[$question_no_index - 2]) ? $questions_list[$question_no_index - 2] : 0;
                    $next_question = isset($questions_list[$question_no_index + 1]) ? $questions_list[$question_no_index + 1] : 0;
					$failed_check = ($learning_journey == 'yes')? true : false;
					if ($quiz->quiz_type == 'vocabulary') {
						$failed_check = true;
					}

                    $nextQuestionArray = $QuestionsAttemptController->nextQuestion($attemptLogObj, $exclude_array, 0, true, $questions_list, $resultLogObj, $question_id, $question_no_index, $failed_check);

                    $questionObj = isset($nextQuestionArray['questionObj']) ? $nextQuestionArray['questionObj'] : array();

                    $newQuestionResult = isset($nextQuestionArray['newQuestionResult']) ? $nextQuestionArray['newQuestionResult'] : array();

                    if ($question_id == $prev_active_question_id) {
                        $active_question_id = $newQuestionResult->id;
                    }

                    if (isset($questionObj->id)) {
                        $questions_array[] = $newQuestionResult;
                        $exclude_array[] = $newQuestionResult->id;
                        if (in_array($resultLogObj->quiz_result_type, array('practice','learning_journey'))) {
                            $question_no_index = $questions_counter;
                        }

                        $question_no = $question_no_index + 1;
                        if ($question_no_index == 0) {
                            $first_question_id = $newQuestionResult->id;
                        }
                        //pre($quiz->quiz_type);

                        $question_response_layout = '';

                        if ($quiz->quiz_type == 'vocabulary') {

                            $layout_elements = isset($questionObj->layout_elements) ? json_decode($questionObj->layout_elements) : array();

                            $correct_answer = $audio_file = $word_audio = $audio_text = $audio_sentense = $field_id = $words_options = '';
							$exam_sentenses = array();
                            if (!empty($layout_elements)) {
                                foreach ($layout_elements as $elementData) {
                                    $element_type = isset($elementData->type) ? $elementData->type : '';
                                    $content = isset($elementData->content) ? $elementData->content : '';
                                    $correct_answer = isset($elementData->correct_answer) ? $elementData->correct_answer : $correct_answer;
                                    $audio_text = isset($elementData->audio_text) ? $elementData->audio_text : $audio_text;
                                    $audio_sentense = isset($elementData->audio_sentense) ? $elementData->audio_sentense : $audio_sentense;
									
                                    $audio_defination = isset($elementData->audio_defination) ? $elementData->audio_defination : $audio_defination;
									$words_options = isset($elementData->words_options) ? $elementData->words_options : $words_options;
                                    if ($element_type == 'audio_file') {
                                        $audio_file = $content;
                                        $word_audio = isset($elementData->word_audio) ? $elementData->word_audio : $word_audio;
										$options = isset($elementData->options) ? $elementData->options : array();
                                        $audio_text = $audio_text;
                                        $audio_sentense = $audio_sentense;
										if( !empty( $options ) ){
											foreach( $options as $optionData){
												$exam_sentenses[] = $optionData->label;
											}
										}
                                    }
                                    if ($element_type == 'textfield_quiz') {
                                        $correct_answer = $correct_answer;
                                        $field_id = isset($elementData->field_id) ? $elementData->field_id : '';
                                    }
									$elementsData[] = $elementData;
                                }
                            }

                            $audio_file = ($quiz_level == 'hard')? $word_audio : $audio_file;
							$words_options = explode(',', $words_options);
							$words_options = is_array( $words_options )? $words_options : array();
							$words_options[] = $correct_answer;
							shuffle($words_options);
                            $word_data = array(
                                'audio_text'       => $audio_text,
                                'audio_sentense'   => $audio_sentense,
                                'audio_defination' => $audio_defination,
                                'audio_file'       => $audio_file,
                                'field_id'         => $field_id,
                                'word_audio'       => $word_audio,
                                'exam_sentenses'     => $exam_sentenses,
                                'words_options' => $words_options,
                            );

                            $total_questions_count = is_array(json_decode($attemptLogObj->questions_list)) ? json_decode($attemptLogObj->questions_list) : array();
                            $total_questions_count = count($total_questions_count);
                            $RewardAccountingObj = RewardAccounting::where('user_id', $user->id)->where('type', 'coins')->where('parent_type', $resultLogObj->quiz_result_type)->first();

                            $results_questions_array[$newQuestionResult->id] = [
                                'question'              => $questionObj,
                                'prev_question'         => $prev_question,
                                'next_question'         => $next_question,
                                'quizAttempt'           => $attemptLogObj,
                                'questionsData'         => rurera_encode($questionObj),
                                'newQuestionResult'     => $newQuestionResult,
                                'question_no'           => $question_no,
                                'quizResultObj'         => $resultLogObj,
                                'word_data'             => $word_data,
                                'total_questions_count' => $total_questions_count,
                                'field_id'              => $field_id,
                                'correct_answer'        => $correct_answer,
                                'disable_next'          => 'true',
                                'disable_prev'          => 'true',
                                'total_points'          => isset($RewardAccountingObj->score) ? $RewardAccountingObj->score : 0,
                            ];
							$actual_question_ids[$newQuestionResult->id] = $questionObj->id;
                        } else {
                            $results_questions_array[$newQuestionResult->id] = [
                                'question'          => $questionObj,
                                'prev_question'     => $prev_question,
                                'next_question'     => $next_question,
                                'quizAttempt'       => $attemptLogObj,
                                'questionsData'     => rurera_encode($questionObj),
                                'newQuestionResult' => $newQuestionResult,
                                'question_no'       => $question_no,
                                'quizResultObj'     => $resultLogObj,
                                'disable_next'      => 'true',
                                'disable_prev'      => 'true',
                            ];
                            $actual_question_ids[$newQuestionResult->id] = $questionObj->id;
                        }

                        $questions_result_reference_array[$question_id] = $newQuestionResult->id;


                    }
                    $questions_counter++;

                }
            } else {
                return view(getTemplate() . '.quizzes.unauthorized');
            }
			
			

            if (!empty($results_questions_array)) {
                $questions_list = array_keys($results_questions_array);
                if ($other_data != '') {
                    if (!empty($questions_result_reference_array)) {
                        foreach ($questions_result_reference_array as $reference_question_id => $reference_result_question_id) {
                            $other_data = str_replace($reference_question_id, $reference_result_question_id, $other_data);
                        }
                    }
                }
                $resultLogObj->update([
                    'questions_list' => json_encode($questions_list),
                    'other_data'     => $other_data,
                ]);
                $attemptLogObj->update([
                    'questions_list' => json_encode($questions_list),
                ]);
                $questionDisplayCounter = 1;
                foreach ($results_questions_array as $resultQuestionID => $resultsQuestionsData) {

                    $resultsQuestionsData['prev_question'] = 0;
                    $resultsQuestionsData['next_question'] = 0;
                    $currentIndex = array_search($resultQuestionID, $questions_list);


                    if ($currentIndex !== false) {
                        // Get the previous index
                        $previousIndex = ($currentIndex > 0) ? $questions_list[$currentIndex - 1] : 0;
                        // Get the next index
                        $nextIndex = ($currentIndex < count($questions_list) - 1) ? $questions_list[$currentIndex + 1] : 0;
                        $resultsQuestionsData['prev_question'] = $previousIndex;
                        $resultsQuestionsData['next_question'] = $nextIndex;
                    }


                    if ($quiz->quiz_type == 'vocabulary') {
						
						
                        //$quiz_level = 'medium';
                        //$quiz_level = 'hard';
                        $time_interval = 25;
                        $duration_type = 'per_question';
                        $correct_answer = isset( $resultsQuestionsData['correct_answer'] )? $resultsQuestionsData['correct_answer'] : '';
                        $word_characters = strlen($correct_answer);
                        if( $quiz_level == 'hard') {
                            $time_interval = 10;
                            if ($word_characters >= 7) {
                                $time_interval = 15;
                            }
                        }
                        if( $quiz_level == 'easy'){
                            $duration_type = 'no_time_limit';
                        }
                        $resultsQuestionsData['quiz_level'] = $quiz_level;
                        $resultsQuestionsData['time_limit'] = $time_interval;
                        $resultsQuestionsData['time_interval'] = $time_interval;
                        $resultsQuestionsData['duration_type'] = $duration_type;
                        $resultsQuestionsData['exam_sentenses'] = $resultsQuestionsData['word_data']['exam_sentenses'];
                        $resultsQuestionsData['words_options'] = $resultsQuestionsData['word_data']['words_options'];
						
						//print
						//pre($resultsQuestionsData['word_data']['exam_sentenses']);

                        $question_response_layout = view('web.default.panel.questions.spell_'.$test_type_file.'_question_layout', $resultsQuestionsData)->render();
						
                        //$question_response_layout = view('web.default.panel.questions.spell_question_layout', $resultsQuestionsData)->render();
                    } else {
                        $questionObjData = $resultsQuestionsData['question'];
                        $resultParentQuestionObj = $resultsQuestionsData['newQuestionResult'];

                        $elements_data = json_decode($questionObjData->elements_data);
                        $group_questions_layout = '';
                        $found_resonse = isKeyValueFoundInMultiArray((array)$elements_data, 'type', 'questions_group');

                        if ($found_resonse['is_found'] == true) {
                            $questions_group = isset($found_resonse['foundArray']) ? $found_resonse['foundArray'] : array();
                            $no_of_display_questions = isset($questions_group['no_of_display_questions']) ? $questions_group['no_of_display_questions'] : 1;
                            $questions_ids = isset($questions_group['question_ids']) ? $questions_group['question_ids'] : array();

                            $questions_ids_attempted = QuizzResultQuestions::whereIn('question_id', $questions_ids)->where('parent_question_id', '>', 0)->where('parent_type_id', $resultLogObj->parent_type_id)->where('status', '!=', 'waiting')->where('user_id', $user->id)->pluck('question_id')->toArray();

                            $questions_ids = array_diff($questions_ids, $questions_ids_attempted);

                            $no_of_display_questions = (count($questions_ids) > $no_of_display_questions) ? $no_of_display_questions : count($questions_ids);
                            $questions_ids_random = array_rand($questions_ids, $no_of_display_questions);
                            if (!is_array($questions_ids_random)) {
                                $questions_ids_random = array($questions_ids_random);
                            }

                            // Initialize an empty array to store the selected questions
                            $selected_questions = array();

                            // Populate the selected questions array using the random keys
                            foreach ($questions_ids_random as $key) {
                                $selected_questions[] = $questions_ids[$key];
                            }


                            if (!empty($selected_questions)) {
                                foreach ($selected_questions as $group_question_id) {
                                    $groupQuestionObj = QuizzesQuestion::find($group_question_id);


                                    $correct_answers = $QuestionsAttemptController->get_question_correct_answers($groupQuestionObj);
                                    $resultQuestionObj = QuizzResultQuestions::create([
                                        'question_id'        => $groupQuestionObj->id,
                                        'quiz_result_id'     => $attemptLogObj->quiz_result_id,
                                        'quiz_attempt_id'    => $attemptLogObj->id,
                                        'user_id'            => $user->id,
                                        'correct_answer'     => json_encode($correct_answers),
                                        'user_answer'        => '',
                                        'quiz_layout'        => $groupQuestionObj->question_layout,
                                        'quiz_grade'         => 1,
                                        'average_time'       => $groupQuestionObj->question_average_time,
                                        'time_consumed'      => 0,
                                        'difficulty_level'   => $groupQuestionObj->question_difficulty_level,
                                        'status'             => 'waiting',
                                        'created_at'         => time(),
                                        'parent_type_id'     => $attemptLogObj->parent_type_id,
                                        'quiz_result_type'   => $attemptLogObj->attempt_type,
                                        'review_required'    => $questionObj->review_required,
                                        'is_active'          => 0,
                                        'user_ip'            => getUserIP(),
                                        'parent_question_id' => $resultParentQuestionObj->id
                                    ]);
                                    $actual_question_ids[$resultQuestionObj->id] = $groupQuestionObj->id;
                                    $group_questions_layout .= html_entity_decode(json_decode(base64_decode(trim(stripslashes($groupQuestionObj->question_layout)))));
                                }
                            }

                        }
                        //pre($group_questions_layout);
                        $resultsQuestionsData['group_questions_layout'] = $group_questions_layout;
                        $question_layout_file = get_quiz_question_layout_file($quiz);
                        $resultsQuestionsData['disable_finish'] = true;
                        $question_response_layout = view('web.default.panel.questions.'.$question_layout_file, $resultsQuestionsData)->render();

                    }
					
					$questionObjData = isset( $resultsQuestionsData['question'] )? $resultsQuestionsData['question'] : array();
					$newQuestionResult = isset( $resultsQuestionsData['newQuestionResult'] )? $resultsQuestionsData['newQuestionResult'] : array();
					
					$question_id = isset( $questionObjData->id )? $questionObjData->id : 0;
					
					if( $newQuestionResult->status != 'waiting' && $quiz->quiz_type != 'vocabulary'){
						$question_response_layout .= $QuestionsAttemptController->get_question_result_layout($resultQuestionID, false);
					}
                    $questions_layout[$resultQuestionID] = rurera_encode(stripslashes($question_response_layout));
                    $questionDisplayCounter++;
                }
            }


            $question = $questions_array;


            $question = rurera_encode($question);


            $questions_status_array = $QuestionsAttemptController->questions_status_array($resultLogObj, $questions_list);
			
			//pre($questions_status_array, false);
			//pre($actual_question_ids, false);
			//pre($questions_list);
			

            $data = [
                'pageTitle'              => trans('quiz.quiz_start'),
                'questions_list'         => $questions_list,
                'quiz'                   => $quiz,
                'quizQuestions'          => $quiz->quizQuestions,
                'attempt_count'          => $resultLogObj->count() + 1,
                'newQuizStart'           => $resultLogObj,
                'quizAttempt'            => $attemptLogObj,
                'question'               => $question,
                'questions_layout'       => $questions_layout,
                'first_question_id'      => $first_question_id,
                'question_no'            => $question_no,
                'prev_question'          => $prev_question,
                'next_question'          => $next_question,
                'question_points'        => $question_points,
                'newQuestionResult'      => $newQuestionResult,
                'questions_status_array' => $questions_status_array,
                'active_question_id'     => $resultLogObj->active_question_id,
                'actual_question_ids'   => $actual_question_ids,
				'total_time_consumed' => isset( $resultLogObj->total_time_consumed )? $resultLogObj->total_time_consumed : 0,
            ];
			
			//pre($data);

            if ($quiz->quiz_type == 'sats') {
                $data['duration_type'] = 'total_practice';
                $data['practice_time'] = $quiz->time;
                $data['time_interval'] = 0;
            }
			
			if ($quiz->quiz_type == '11plus') {
                $data['duration_type'] = 'total_practice';
                $data['practice_time'] = $quiz->time;
                $data['time_interval'] = 0;
            }

            if ($quiz->quiz_type == 'vocabulary' && $quiz_level != 'easy') {	
                $data['duration_type'] = isset( $duration_type)? $duration_type : '';
                $data['practice_time'] = isset( $time_interval )? $time_interval : '';
                $data['time_interval'] = isset( $time_interval )? $time_interval : '';
            }

            $start_layout_file = get_quiz_start_layout_file($quiz);
			
            return view(getTemplate() . '.panel.quizzes.'.$start_layout_file, $data);
            /*if ($resultLogObj->quiz_result_type == 'practice') {
                return view(getTemplate() . '.panel.quizzes.practice_start', $data);
            } else {
                return view(getTemplate() . '.panel.quizzes.start', $data);
            }*/
        }
        abort(404);
    }


    /*
     * Check Answers
     */
    public function check_answers(Request $request, $result_id)
    {

        if (!auth()->check()) {
            return redirect('/login');
        }
        $QuestionsAttemptController = new QuestionsAttemptController();
        //$correct_answer = $QuestionsAttemptController->get_question_correct_answers(QuizzesQuestion::find(9136));
        $QuizzesResult = QuizzesResult::find($result_id);
        $quiz = Quiz::find($QuizzesResult->parent_type_id);

        $QuizzResultQuestions = QuizzResultQuestions::where('quiz_result_id', $result_id)->where('status', '!=', 'waiting')->where('parent_question_id', 0)->get();
        $quizAttempt = QuizzAttempts::where('quiz_result_id', $result_id)->first();

        $attempt_questions_list = isset($QuizzesResult->questions_list) ? json_decode($QuizzesResult->questions_list) : array();
		
		$attempt_questions_list = $QuizzesResult->quizz_result_questions_list->whereIn('status', array('correct','incorrect'));
		$not_attempted_count = $QuizzesResult->quizz_result_questions_list->whereIn('status', array('not_attempted'))->count();
		
        $time_consumed = $QuizzResultQuestions->sum('time_consumed');
        $coins_earned = $QuizzResultQuestions->where('status','correct')->sum('quiz_grade');
        $questions_layout = $questions_list = array();
        $first_question_id = $incorrect_count = 0;
        $count = 1;
        if (!empty($QuizzResultQuestions)) {
            foreach ($QuizzResultQuestions as $QuizzResultQuestionObj) {
                if( $QuizzResultQuestionObj->id != 25884){
                    //continue;
                }
                if ($count == 1) {
                    $first_question_id = $QuizzResultQuestionObj->question_id;
                }

                $questionObj = QuizzesQuestion::find($QuizzResultQuestionObj->question_id);
                $question_response_layout = '';
                $question_response_layout = '<div class="question-result-layout question-status-' . $QuizzResultQuestionObj->status . '">';
                if ($QuizzResultQuestionObj->status == 'incorrect') {
                    $incorrect_count++;
                }
                if ($QuizzResultQuestionObj->status == 'correct') {
                    $question_response_layout .= '<div class="earn-coins-icon">
                        <img src="/assets/default/img/reward.png" alt="">
                    </div>';
                }
                if ($QuizzesResult->quiz_result_type != 'vocabulary') {

                    $child_questions = $QuizzResultQuestionObj->get_child_questions;
                    $group_questions_layout = '';

                    if (!empty($child_questions)) {
                        foreach ($child_questions as $childQuestionObj) {
                            $group_questions_layout .= html_entity_decode(json_decode(base64_decode(trim(stripslashes($childQuestionObj->quiz_layout)))));
                            $group_questions_layout .= $QuestionsAttemptController->get_question_result_layout($childQuestionObj->id);
                        }
                    }



                    $question_response_layout .= view('web.default.panel.questions.question_layout', [
                        'question'               => $questionObj,
                        'prev_question'          => 0,
                        'next_question'          => 0,
                        'quizAttempt'            => $quizAttempt,
                        'newQuestionResult'      => $QuizzResultQuestionObj,
                        'question_no'            => $count,
                        'quizResultObj'          => $QuizzesResult,
                        'disable_submit'         => 'true',
                        'disable_finish'         => 'true',
                        'disable_prev'           => 'true',
                        'disable_next'           => 'true',
                        'class'                  => 'disable-div',
                        'layout_type'            => 'results',
                        'group_questions_layout' => $group_questions_layout,
                    ])->render();
                }

                if ($QuizzesResult->quiz_result_type == 'vocabulary') {
                    $group_questions_layout = $QuestionsAttemptController->get_question_result_layout($QuizzResultQuestionObj->id);

                    $question_response_layout .= view('web.default.panel.questions.question_layout', [
                        'question'               => $questionObj,
                        'prev_question'          => 0,
                        'next_question'          => 0,
                        'quizAttempt'            => $quizAttempt,
                        'newQuestionResult'      => $QuizzResultQuestionObj,
                        'question_no'            => $count,
                        'quizResultObj'          => $QuizzesResult,
                        'disable_submit'         => 'true',
                        'disable_finish'         => 'true',
                        'disable_prev'           => 'true',
                        'disable_next'           => 'true',
                        //'class'                  => 'disable-div',
                        'layout_type'            => 'results',
                        'group_questions_layout' => $group_questions_layout,
                    ])->render();
                }


                //pre($QuizzResultQuestionObj);
                if (!isset( $child_questions ) || $child_questions->count() == 0) {
                    $question_response_layout .= $QuestionsAttemptController->get_question_result_layout($QuizzResultQuestionObj->id);
                }

                $question_response_layout .= '</div>';
                //$questions_layout[$QuizzResultQuestionObj->question_id] = rurera_encode(stripslashes($question_response_layout));
                $questions_layout[$QuizzResultQuestionObj->id] = $question_response_layout;
                $questions_list[] = $QuizzResultQuestionObj->id;
                $count++;
            }
        }
        $questions_status_array = $QuestionsAttemptController->questions_status_array($QuizzesResult, $questions_list);

        $data = [
            'pageTitle' => 'Answers',
            'quiz'                   => $quiz,
            'question'               => array(),
            'questions_list'         => $questions_list,
            'attempt_questions_list' => $attempt_questions_list,
            'first_question_id'      => $first_question_id,
            'questions_status_array' => $questions_status_array,
            'questions_layout'       => $questions_layout,
            'QuizzesResult'          => $QuizzesResult,
            'time_consumed'          => $time_consumed,
            'coins_earned'          => $coins_earned,
            'incorrect_count' => $incorrect_count,
            'not_attempted_count' => $not_attempted_count,
        ];
        return view(getTemplate() . '.panel.quizzes.check_answers', $data);
    }

    public function quizzesStoreResult(Request $request, $id)
    {
        $user = auth()->user();
        $quiz = Quiz::where('id', $id)->first();

        if ($quiz) {
            $results = $request->get('question');
            $quizResultId = $request->get('quiz_result_id');

            if (!empty($quizResultId)) {

                $quizResult = QuizzesResult::where('id', $quizResultId)->where('user_id', $user->id)->first();

                if (!empty($quizResult)) {

                    $passMark = $quiz->pass_mark;
                    $totalMark = 0;
                    $status = '';

                    if (!empty($results)) {
                        foreach ($results as $questionId => $result) {

                            if (!is_array($result)) {
                                unset($results[$questionId]);

                            } else {

                                $question = QuizzesQuestion::where('id', $questionId)->where('quiz_id', $quiz->id)->first();

                                if ($question and !empty($result['answer'])) {
                                    $answer = QuizzesQuestionsAnswer::where('id', $result['answer'])->where('question_id', $question->id)->where('creator_id', $quiz->creator_id)->first();

                                    $results[$questionId]['status'] = false;
                                    $results[$questionId]['grade'] = $question->grade;

                                    if ($answer and $answer->correct) {
                                        $results[$questionId]['status'] = true;
                                        $totalMark += (int)$question->grade;
                                    }

                                    if ($question->type == 'descriptive') {
                                        $status = 'waiting';
                                    }
                                }
                            }
                        }
                    }

                    if (empty($status)) {
                        $status = ($totalMark >= $passMark) ? QuizzesResult::$passed : QuizzesResult::$failed;
                    }

                    $results["attempt_number"] = $request->get('attempt_number');

                    $quizResult->update([
                        'results'    => json_encode($results),
                        'user_grade' => $totalMark,
                        'status'     => $status,
                        'created_at' => time()
                    ]);

                    if ($quizResult->status == QuizzesResult::$waiting) {
                        $notifyOptions = [
                            '[c.title]'      => $quiz->webinar ? $quiz->webinar->title : '-',
                            '[student.name]' => $user->get_full_name(),
                            '[q.title]'      => $quiz->title,
                        ];
                        sendNotification('waiting_quiz', $notifyOptions, $quiz->creator_id);
                    }

                    if ($quizResult->status == QuizzesResult::$passed) {
                        $passTheQuizReward = RewardAccounting::calculateScore(Reward::PASS_THE_QUIZ);
                        RewardAccounting::makeRewardAccounting($quizResult->user_id, $passTheQuizReward, Reward::PASS_THE_QUIZ, $quiz->id, true);

                        if ($quiz->certificate) {
                            $certificateReward = RewardAccounting::calculateScore(Reward::CERTIFICATE);
                            RewardAccounting::makeRewardAccounting($quizResult->user_id, $certificateReward, Reward::CERTIFICATE, $quiz->id, true);
                        }
                    }

                    return redirect()->route('quiz_status', ['quizResultId' => $quizResult]);
                }
            }
        }
        abort(404);
    }

    public function status($quizResultId)
    {
        $user = auth()->user();

        $quizResult = QuizzesResult::where('id', $quizResultId)->where('user_id', $user->id)->with([
            'quiz' => function ($query) {
                $query->with(['quizQuestions']);
            }
        ])->first();

        if ($quizResult) {
            $quiz = $quizResult->quiz;
            $attemptCount = $quiz->attempt;

            $userQuizDone = QuizzesResult::where('quiz_id', $quiz->id)->where('user_id', $user->id)->count();

            $canTryAgain = false;
            if ($userQuizDone < $attemptCount) {
                $canTryAgain = true;
            }

            $quizQuestions = $quizResult->getQuestions();
            $totalQuestionsCount = $quizQuestions->count();

            $data = [
                'pageTitle'           => trans('quiz.quiz_status'),
                'quizResult'          => $quizResult,
                'quiz'                => $quiz,
                'quizQuestions'       => $quizQuestions,
                'attempt_count'       => $userQuizDone,
                'canTryAgain'         => $canTryAgain,
                'totalQuestionsCount' => $totalQuestionsCount
            ];

            return view(getTemplate() . '.panel.quizzes.status', $data);
        }
        abort(404);
    }

    public function myResults(Request $request)
    {
        $query = QuizzesResult::where('user_id', auth()->user()->id);

        $quizResultsCount = deepClone($query)->count();
        $passedCount = deepClone($query)->where('status', \App\Models\QuizzesResult::$passed)->count();
        $failedCount = deepClone($query)->where('status', \App\Models\QuizzesResult::$failed)->count();
        $waitingCount = deepClone($query)->where('status', \App\Models\QuizzesResult::$waiting)->count();

        $query = $this->resultFilters($request, deepClone($query));

        $quizResults = $query->with([
            'quiz' => function ($query) {
                $query->with([
                    'quizQuestions',
                    'creator',
                    'webinar'
                ]);
            }
        ])->orderBy('created_at', 'desc')->paginate(10);

        foreach ($quizResults->groupBy('quiz_id') as $quiz_id => $quizResult) {
            $canTryAgainQuiz = false;

            $result = $quizResult->first();
            $quiz = $result->quiz;

            if (!isset($quiz->attempt) or (count($quizResult) < $quiz->attempt and $result->status !== 'passed')) {
                $canTryAgainQuiz = true;
            }

            foreach ($quizResult as $item) {
                $item->can_try = $canTryAgainQuiz;
                if ($canTryAgainQuiz and isset($quiz->attempt)) {
                    $item->count_can_try = $quiz->attempt - count($quizResult);
                }
            }
        }

        $data = [
            'pageTitle'           => trans('quiz.my_results'),
            'quizzesResults'      => $quizResults,
            'quizzesResultsCount' => $quizResultsCount,
            'passedCount'         => $passedCount,
            'failedCount'         => $failedCount,
            'waitingCount'        => $waitingCount
        ];

        return view(getTemplate() . '.panel.quizzes.my_results', $data);
    }

    public function opens(Request $request)
    {
        $user = auth()->user();

        $webinarIds = $user->getPurchasedCoursesIds();

        $query = Quiz::whereIn('webinar_id', $webinarIds)->where('status', 'active')->whereDoesntHave('quizResults', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });

        $query = $this->resultFilters($request, deepClone($query));

        $quizzes = $query->orderBy('created_at', 'desc')->paginate(10);

        $data = [
            'pageTitle' => trans('quiz.open_quizzes'),
            'quizzes'   => $quizzes
        ];

        return view(getTemplate() . '.panel.quizzes.opens', $data);
    }

    public function results(Request $request)
    {
        $user = auth()->user();

        if (!$user->isUser()) {
            $quizzes = Quiz::where('creator_id', $user->id)->where('status', 'active')->get();

            $quizzesIds = $quizzes->pluck('id')->toArray();

            $query = QuizzesResult::whereIn('quiz_id', $quizzesIds);

            $studentsIds = $query->pluck('user_id')->toArray();
            $allStudents = User::select('id', 'full_name')->whereIn('id', $studentsIds)->get();

            $quizResultsCount = $query->count();
            $quizAvgGrad = round($query->avg('user_grade'), 2);
            $waitingCount = deepClone($query)->where('status', \App\Models\QuizzesResult::$waiting)->count();
            $passedCount = deepClone($query)->where('status', \App\Models\QuizzesResult::$passed)->count();
            $successRate = ($quizResultsCount > 0) ? round($passedCount / $quizResultsCount * 100) : 0;

            $query = $this->resultFilters($request, deepClone($query));

            $quizzesResults = $query->with([
                'quiz' => function ($query) {
                    $query->with([
                        'quizQuestions',
                        'creator',
                        'webinar'
                    ]);
                },
                'user'
            ])->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'pageTitle'        => trans('quiz.results'),
                'quizzesResults'   => $quizzesResults,
                'quizResultsCount' => $quizResultsCount,
                'successRate'      => $successRate,
                'quizAvgGrad'      => $quizAvgGrad,
                'waitingCount'     => $waitingCount,
                'quizzes'          => $quizzes,
                'allStudents'      => $allStudents
            ];

            return view(getTemplate() . '.panel.quizzes.results', $data);
        }

        abort(404);
    }

    public function resultFilters(Request $request, $query)
    {
        $from = $request->get('from', null);
        $to = $request->get('to', null);
        $quiz_id = $request->get('quiz_id', null);
        $total_mark = $request->get('total_mark', null);
        $status = $request->get('status', null);
        $user_id = $request->get('user_id', null);
        $instructor = $request->get('instructor', null);
        $open_results = $request->get('open_results', null);

        $query = fromAndToDateFilter($from, $to, $query, 'created_at');

        if (!empty($quiz_id) and $quiz_id != 'all') {
            $query->where('quiz_id', $quiz_id);
        }

        if ($total_mark) {
            $query->where('total_mark', $total_mark);
        }

        if (!empty($user_id) and $user_id != 'all') {
            $query->where('user_id', $user_id);
        }

        if ($instructor) {
            $userIds = User::whereIn('role_name', [
                Role::$teacher,
                Role::$organization
            ])->where('full_name', 'like', '%' . $instructor . '%')->pluck('id')->toArray();

            $query->whereIn('creator_id', $userIds);
        }

        if ($status and $status != 'all') {
            $query->where('status', strtolower($status));
        }

        if (!empty($open_results)) {
            $query->where('status', 'waiting');
        }

        return $query;
    }

    public function showResult($quizResultId)
    {
        $user = auth()->user();

        $quizzesIds = Quiz::where('creator_id', $user->id)->pluck('id')->toArray();


        //DB::enableQueryLog();
        $quizResultQuestions = QuizzResultQuestions::where('quiz_result_id', $quizResultId)->where(function ($query) use ($user, $quizzesIds) {
            $query->where('user_id', $user->id)->orWhereIn('quiz_id', $quizzesIds);
        })->with([/*'quiz' => function ($query) {
                        $query->with(['quizQuestions', 'webinar']);
                },*/
                  //'quizz_result_questions'
        ])->get();
        //pre(DB::getQueryLog());
        //DB::disableQueryLog();


        $quizResult = QuizzesResult::where('id', $quizResultId)->where(function ($query) use ($user, $quizzesIds) {
            $query->where('user_id', $user->id)->orWhereIn('quiz_id', $quizzesIds);
        })->with([/*'quiz' => function ($query) {
                            $query->with(['quizQuestions', 'webinar']);
                },*/
                  'quizz_result_questions'
        ])->first();

        if (!empty($quizResult)) {
            /*$numberOfAttempt = QuizzesResult::where('quiz_id' , $quizResult->quiz->id)
                ->where('user_id' , $quizResult->user_id)
                ->count();*/

            //$quizQuestions = $quizResult->getQuestions();


            $data = [
                'pageTitle'           => trans('quiz.result'),
                'quizResult'          => $quizResult,
                'quizResultQuestions' => $quizResultQuestions,
                'userAnswers'         => json_decode($quizResult->results, true),
                'numberOfAttempt'     => 0,
                'questionsSumGrade'   => 0,
                //'quizQuestions'       => $quizQuestions ,
            ];

            return view(getTemplate() . '.panel.quizzes.quiz_result', $data);
        }

        abort(404);
    }

    public function destroyQuizResult($quizResultId)
    {
        $user = auth()->user();

        $quizzesIds = Quiz::where('creator_id', $user->id)->pluck('id')->toArray();

        $quizResult = QuizzesResult::where('id', $quizResultId)->whereIn('quiz_id', $quizzesIds)->first();

        if (!empty($quizResult)) {
            $quizResult->delete();

            return response()->json(['code' => 200], 200);
        }

        return response()->json([], 422);
    }

    public function editResult($quizResultId)
    {
        $user = auth()->user();

        $quizzesIds = Quiz::where('creator_id', $user->id)->pluck('id')->toArray();

        $quizResult = QuizzesResult::where('id', $quizResultId)->whereIn('quiz_id', $quizzesIds)->with([
            'quiz' => function ($query) {
                $query->with([
                    'quizQuestions' => function ($query) {
                        $query->orderBy('type', 'desc');
                    },
                    'webinar'
                ]);
            }
        ])->first();

        if (!empty($quizResult)) {
            $numberOfAttempt = QuizzesResult::where('quiz_id', $quizResult->quiz->id)->where('user_id', $quizResult->user_id)->count();

            $quiz = $quizResult->quiz;
            $quizQuestions = $quizResult->getQuestions();

            $data = [
                'pageTitle'         => trans('quiz.result'),
                'teacherReviews'    => true,
                'quiz'              => $quiz,
                'quizResult'        => $quizResult,
                'newQuizStart'      => $quizResult,
                'userAnswers'       => json_decode($quizResult->results, true),
                'numberOfAttempt'   => $numberOfAttempt,
                'questionsSumGrade' => $quizQuestions->sum('grade'),
                'quizQuestions'     => $quizQuestions
            ];

            return view(getTemplate() . '.panel.quizzes.quiz_result', $data);
        }

        abort(404);
    }

    public function updateResult(Request $request, $id)
    {
        $user = auth()->user();
        $quiz = Quiz::where('id', $id)->where('creator_id', $user->id)->first();

        if (!empty($quiz)) {
            $reviews = $request->get('question');
            $quizResultId = $request->get('quiz_result_id');

            if (!empty($quizResultId)) {

                $quizResult = QuizzesResult::where('id', $quizResultId)->where('quiz_id', $quiz->id)->first();

                if (!empty($quizResult)) {

                    $oldResults = json_decode($quizResult->results, true);
                    $totalMark = 0;
                    $status = '';
                    $user_grade = $quizResult->user_grade;

                    if (!empty($oldResults) and count($oldResults)) {
                        foreach ($oldResults as $question_id => $result) {
                            foreach ($reviews as $question_id2 => $review) {
                                if ($question_id2 == $question_id) {
                                    $question = QuizzesQuestion::where('id', $question_id)->where('creator_id', $user->id)->first();

                                    if ($question->type == 'descriptive') {
                                        if (!empty($result['status']) and $result['status']) {
                                            $user_grade = $user_grade - (isset($result['grade']) ? (int)$result['grade'] : 0);
                                            $user_grade = $user_grade + (isset($review['grade']) ? (int)$review['grade'] : (int)$question->grade);
                                        } else if (isset($result['status']) and !$result['status']) {
                                            $user_grade = $user_grade + (isset($review['grade']) ? (int)$review['grade'] : (int)$question->grade);
                                            $oldResults[$question_id]['grade'] = isset($review['grade']) ? $review['grade'] : $question->grade;
                                        }

                                        $oldResults[$question_id]['status'] = true;
                                    }
                                }
                            }
                        }
                    } elseif (!empty($reviews) and count($reviews)) {
                        foreach ($reviews as $questionId => $review) {

                            if (!is_array($review)) {
                                unset($reviews[$questionId]);
                            } else {
                                $question = QuizzesQuestion::where('id', $questionId)->where('quiz_id', $quiz->id)->first();

                                if ($question and $question->type == 'descriptive') {
                                    $user_grade += (isset($review['grade']) ? (int)$review['grade'] : 0);
                                }
                            }
                        }

                        $oldResults = $reviews;
                    }

                    $quizResult->user_grade = $user_grade;
                    $passMark = $quiz->pass_mark;

                    if ($quizResult->user_grade >= $passMark) {
                        $quizResult->status = QuizzesResult::$passed;
                    } else {
                        $quizResult->status = QuizzesResult::$failed;
                    }

                    $quizResult->results = json_encode($oldResults);

                    $quizResult->save();

                    $notifyOptions = [
                        '[c.title]'  => $quiz->webinar ? $quiz->webinar->title : '-',
                        '[q.title]'  => $quiz->title,
                        '[q.result]' => $quizResult->status,
                    ];
                    sendNotification('waiting_quiz_result', $notifyOptions, $quizResult->user_id);

                    if ($quizResult->status == QuizzesResult::$passed) {
                        $passTheQuizReward = RewardAccounting::calculateScore(Reward::PASS_THE_QUIZ);
                        RewardAccounting::makeRewardAccounting($quizResult->user_id, $passTheQuizReward, Reward::PASS_THE_QUIZ, $quizResult->id, true);

                        if ($quiz->certificate) {
                            $certificateReward = RewardAccounting::calculateScore(Reward::CERTIFICATE);
                            RewardAccounting::makeRewardAccounting($quizResult->user_id, $certificateReward, Reward::CERTIFICATE, $quiz->id, true);
                        }
                    }

                    return redirect('panel/quizzes/results');
                }
            }
        }

        abort(404);
    }

    public function orderItems(Request $request, $quizId)
    {
        $user = auth()->user();
        $data = $request->all();

        $validator = Validator::make($data, [
            'items' => 'required',
            'table' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'code'   => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $quiz = Quiz::query()->where('id', $quizId)->where('creator_id', $user->id)->first();

        if (!empty($quiz)) {
            $tableName = $data['table'];
            $itemIds = explode(',', $data['items']);

            if (!is_array($itemIds) and !empty($itemIds)) {
                $itemIds = [$itemIds];
            }

            if (!empty($itemIds) and is_array($itemIds) and count($itemIds)) {
                switch ($tableName) {
                    case 'quizzes_questions':
                        foreach ($itemIds as $order => $id) {
                            QuizzesQuestion::where('id', $id)->where('quiz_id', $quiz->id)->update(['order' => ($order + 1)]);
                        }
                        break;
                }
            }
        }

        return response()->json([
            'title' => trans('public.request_success'),
            'msg'   => trans('update.items_sorted_successful')
        ]);
    }

}
