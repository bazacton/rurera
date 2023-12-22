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

        $no_of_questions = 0;


        $quiz = Quiz::where('id', $id)->with([
            'quizQuestionsList' => function ($query) {
                $query->where('status', 'active');
            },
        ])->first();

        if( auth()->guest()) {
            $total_attempted_questions = QuizzResultQuestions::where('quiz_result_type', $quiz->quiz_type)->where('status', '!=', 'waiting')->where('user_id', 0)->where('user_ip', getUserIP())->count();
            $total_questions_allowed = getGuestLimit($quiz->quiz_type);
            $no_of_questions = ($total_questions_allowed - $total_attempted_questions);
            if( $no_of_questions < 1){
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


        $questions_list = array();
        if (!empty($quiz->quizQuestionsList)) {
            foreach ($quiz->quizQuestionsList as $questionlistData) {
                $question_id = ($quiz->quiz_type == 'assignment') ? $questionlistData->reference_question_id : $questionlistData->question_id;
                $questions_list[] = $question_id;
            }
        }
        if( $no_of_questions > 0) {
            $questions_list = array_slice($questions_list, 0, $no_of_questions);
        }

        if ($quiz->quiz_type == 'practice') {
            $quiz_settings = json_decode($quiz->quiz_settings);

            $questions_limit = array();
            $questions_limit['emerging'] = isset($quiz_settings->Emerging->questions) ? $quiz_settings->Emerging->questions : 0;
            $questions_limit['expected'] = isset($quiz_settings->Expected->questions) ? $quiz_settings->Expected->questions : 0;
            $questions_limit['exceeding'] = isset($quiz_settings->Exceeding->questions) ? $quiz_settings->Exceeding->questions : 0;


            $difficulty_level_array = [
                'emerging'  => 'Emerging',
                'expected'  => 'Expected',
                'exceeding' => 'Exceeding',
            ];
            if ($quiz->quiz_type == 'practice') {
                $questions_list_ids = $questions_list;
                $questions_list = array();
                if (!empty($difficulty_level_array)) {
                    foreach ($difficulty_level_array as $difficulty_level_key => $difficulty_level_label) {
                        $breakdown_array = (array)$quiz_settings->{$difficulty_level_label}->breakdown;

                        if (!empty($breakdown_array)) {
                            foreach ($breakdown_array as $question_type => $questions_count) {
                                //$questions_list[$difficulty_level_key][$question_type] = QuizzesQuestion::whereIn('id', $questions_list_ids)->where('question_type', $question_type)->where('question_difficulty_level', $difficulty_level_label)->limit($questions_count)->pluck('id')->toArray();
                                $questions_array = QuizzesQuestion::whereIn('id', $questions_list_ids)->where('question_type', $question_type)->where('question_difficulty_level', $difficulty_level_label)->limit($questions_count)->pluck('id')->toArray();
                                if (!empty($questions_array)) {
                                    foreach ($questions_array as $questionID) {
                                        $questions_list[] = $questionID;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $attempted_questions = array();
            if (isset($newQuizStart->id)) {
                $attempted_questions = QuizzResultQuestions::where('user_id', $user->id)
                    ->where('quiz_result_id', $newQuizStart->id);

                if (auth()->guest()) {
                    $attempted_questions->where('user_ip', getUserIP());
                }
                $attempted_questions->pluck('question_id')->toArray();
            }
        }


        if ($quiz) {

            $show_all_questions = $quiz->show_all_questions;
            $show_all_questions = true;

            $QuestionsAttemptController = new QuestionsAttemptController();
            $resultLogObj = $QuestionsAttemptController->createResultLog([
                'parent_type_id'   => $quiz->id,
                'quiz_result_type' => $quiz->quiz_type,
                'questions_list'   => $questions_list,
                'no_of_attempts'   => $quiz->attempt
            ]);

            $prev_active_question_id = isset( $resultLogObj->active_question_id )? $resultLogObj->active_question_id : 0;

            if( $prev_active_question_id > 0){
                $prevActiveQuestionObj = QuizzResultQuestions::find($prev_active_question_id);
                $prev_active_question_id = isset( $prevActiveQuestionObj->question_id )? $prevActiveQuestionObj->question_id : 0;
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


            if (!empty($questions_list)) {
                $questions_counter = 0;
                foreach ($questions_list as $question_no_index => $question_id) {
                    $question_no = $question_no_index;
                    $prev_question = isset($questions_list[$question_no_index - 2]) ? $questions_list[$question_no_index - 2] : 0;
                    $next_question = isset($questions_list[$question_no_index + 1]) ? $questions_list[$question_no_index + 1] : 0;

                    $nextQuestionArray = $QuestionsAttemptController->nextQuestion($attemptLogObj, $exclude_array, 0, true, $questions_list, $resultLogObj, $question_id, $question_no_index);

                    $questionObj = isset($nextQuestionArray['questionObj']) ? $nextQuestionArray['questionObj'] : array();

                    $newQuestionResult = isset($nextQuestionArray['newQuestionResult']) ? $nextQuestionArray['newQuestionResult'] : array();

                    if( $question_id == $prev_active_question_id){
                        $active_question_id = $newQuestionResult->id;
                    }

                    if (isset($questionObj->id)) {
                        $questions_array[] = $newQuestionResult;
                        $exclude_array[] = $newQuestionResult->id;
                        if ($resultLogObj->quiz_result_type == 'practice') {
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

                            $correct_answer = $audio_file = $audio_text = $audio_sentense = $field_id = '';
                            if (!empty($layout_elements)) {
                                foreach ($layout_elements as $elementData) {
                                    $element_type = isset($elementData->type) ? $elementData->type : '';
                                    $content = isset($elementData->content) ? $elementData->content : '';
                                    $correct_answer = isset($elementData->correct_answer) ? $elementData->correct_answer : $correct_answer;
                                    $audio_text = isset($elementData->audio_text) ? $elementData->audio_text : $audio_text;
                                    $audio_sentense = isset($elementData->audio_sentense) ? $elementData->audio_sentense : $audio_sentense;
                                    $audio_defination = isset($elementData->audio_defination) ? $elementData->audio_defination : $audio_defination;
                                    if ($element_type == 'audio_file') {
                                        $audio_file = $content;
                                        $audio_text = $audio_text;
                                        $audio_sentense = $audio_sentense;
                                    }
                                    if ($element_type == 'textfield_quiz') {
                                        $correct_answer = $correct_answer;
                                        $field_id = isset($elementData->field_id) ? $elementData->field_id : '';
                                    }
                                }
                            }
                            $word_data = array(
                                'audio_text'       => $audio_text,
                                'audio_sentense'   => $audio_sentense,
                                'audio_defination' => $audio_defination,
                                'audio_file'       => $audio_file,
                                'field_id'         => $field_id,
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
                        }


                    }
                    $questions_counter++;

                }
            }

            if (!empty($results_questions_array)) {
                $questions_list = array_keys($results_questions_array);
                $resultLogObj->update([
                    'questions_list' => json_encode($questions_list),
                ]);
                $attemptLogObj->update([
                    'questions_list' => json_encode($questions_list),
                ]);
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
                        $question_response_layout = view('web.default.panel.questions.spell_question_layout', $resultsQuestionsData)->render();
                    }else {
                        $question_response_layout = view('web.default.panel.questions.question_layout', $resultsQuestionsData)->render();
                    }
                    $questions_layout[$resultQuestionID] = rurera_encode(stripslashes($question_response_layout));
                }
            }


            $question = $questions_array;


            $question = rurera_encode($question);


            $questions_status_array = $QuestionsAttemptController->questions_status_array($resultLogObj, $questions_list);

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
                'active_question_id'     => $active_question_id,
            ];

            if ($resultLogObj->quiz_result_type == 'practice') {
                return view(getTemplate() . '.panel.quizzes.practice_start', $data);
            } else {
                return view(getTemplate() . '.panel.quizzes.start', $data);
            }
        }
        abort(404);
    }


    /*
     * Check Answers
     */
    public function check_answers(Request $request, $result_id)
    {

        $QuestionsAttemptController = new QuestionsAttemptController();
        $QuizzesResult = QuizzesResult::find($result_id);
        $quiz = Quiz::find($QuizzesResult->parent_type_id);

        $QuizzResultQuestions = QuizzResultQuestions::where('quiz_result_id', $result_id)->where('status', '!=', 'waiting')->get();
        $quizAttempt = QuizzAttempts::where('quiz_result_id', $result_id)->first();

        $questions_layout = $questions_list = array();
        $first_question_id = 0;
        $count = 1;
        if (!empty($QuizzResultQuestions)) {
            foreach ($QuizzResultQuestions as $QuizzResultQuestionObj) {
                if ($count == 1) {
                    $first_question_id = $QuizzResultQuestionObj->question_id;
                }

                $questionObj = QuizzesQuestion::find($QuizzResultQuestionObj->question_id);
                $question_response_layout = '';
                $question_response_layout = '<div class="question-result-layout question-status-' . $QuizzResultQuestionObj->status . '">';
                if ($QuizzResultQuestionObj->status == 'correct') {
                    $question_response_layout .= '<div class="earn-coins-icon">
                        <img src="/assets/default/img/reward.png" alt="">
                    </div>';
                }
                if ($QuizzesResult->quiz_result_type != 'vocabulary') {

                    $question_response_layout .= view('web.default.panel.questions.question_layout', [
                        'question'          => $questionObj,
                        'prev_question'     => 0,
                        'next_question'     => 0,
                        'quizAttempt'       => $quizAttempt,
                        'newQuestionResult' => $QuizzResultQuestionObj,
                        'question_no'       => $count,
                        'quizResultObj'     => $QuizzesResult,
                        'disable_submit'    => 'true',
                        'disable_finish'    => 'true',
                        'disable_prev'      => 'true',
                        'disable_next'      => 'true',
                        'class'             => 'disable-div',
                        'layout_type'       => 'results',
                    ])->render();
                }


                $question_response_layout .= $QuestionsAttemptController->get_question_result_layout($QuizzResultQuestionObj->id);

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
            'first_question_id'      => $first_question_id,
            'questions_status_array' => $questions_status_array,
            'questions_layout'       => $questions_layout,
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
                            '[student.name]' => $user->full_name,
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
