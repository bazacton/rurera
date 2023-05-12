<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesResult;
use App\Models\Translation\QuizTranslation;
use App\Models\Webinar;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Translation\QuizzesQuestionTranslation;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin_quizzes_list');

        removeContentLocale();

        $query = Quiz::query();

        $totalQuizzes = deepClone($query)->count();
        $totalActiveQuizzes = deepClone($query)->where('status', 'active')->count();
        $totalStudents = QuizzesResult::groupBy('user_id')->count();
        $totalPassedStudents = QuizzesResult::where('status', 'passed')->groupBy('user_id')->count();

        $query = $this->filters($query, $request);

        $quizzes = $query->with([
            'webinar',
            'teacher',
            'quizQuestions',
            'quizResults',
        ])->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/quiz.admin_quizzes_list'),
            'quizzes' => $quizzes,
            'totalQuizzes' => $totalQuizzes,
            'totalActiveQuizzes' => $totalActiveQuizzes,
            'totalStudents' => $totalStudents,
            'totalPassedStudents' => $totalPassedStudents,
        ];

        $teacher_ids = $request->get('teacher_ids');
        $webinar_ids = $request->get('webinar_ids');

        if (!empty($teacher_ids)) {
            $data['teachers'] = User::select('id', 'full_name')
                ->whereIn('id', $teacher_ids)->get();
        }

        if (!empty($webinar_ids)) {
            $data['webinars'] = Webinar::select('id')
                ->whereIn('id', $webinar_ids)->get();
        }

        return view('admin.quizzes.lists', $data);
    }

    private function filters($query, $request)
    {
        $from = $request->get('from', null);
        $to = $request->get('to', null);
        $title = $request->get('title', null);
        $sort = $request->get('sort', null);
        $teacher_ids = $request->get('teacher_ids', null);
        $webinar_ids = $request->get('webinar_ids', null);
        $status = $request->get('status', null);

        $query = fromAndToDateFilter($from, $to, $query, 'created_at');

        if (!empty($title)) {
            $query->whereTranslationLike('title', '%' . $title . '%');
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'have_certificate':
                    $query->where('certificate', true);
                    break;
                case 'students_count_asc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'asc');
                    break;

                case 'students_count_desc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'desc');
                    break;
                case 'passed_count_asc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status', 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'asc');
                    break;

                case 'passed_count_desc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status', 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count', 'desc');
                    break;

                case 'grade_avg_asc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', 'quizzes_results.user_grade', DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg', 'asc');
                    break;

                case 'grade_avg_desc':
                    $query->join('quizzes_results', 'quizzes_results.quiz_id', '=', 'quizzes.id')
                        ->select('quizzes.*', 'quizzes_results.quiz_id', 'quizzes_results.user_grade', DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg', 'desc');
                    break;

                case 'created_at_asc':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if (!empty($teacher_ids)) {
            $query->whereIn('creator_id', $teacher_ids);
        }

        if (!empty($webinar_ids)) {
            $query->whereIn('webinar_id', $webinar_ids);
        }

        if (!empty($status) and $status !== 'all') {
            $query->where('status', strtolower($status));
        }

        return $query;
    }

    public function create()
    {
        $this->authorize('admin_quizzes_create');

        $data = [
            'pageTitle' => trans('quiz.new_quiz'),
        ];
        
        $query = Webinar::query();

        $webinars = DB::table('webinars')
                ->join('webinar_translations', 'webinar_translations.webinar_id', '=', 'webinars.id')
                ->join('webinar_chapters', 'webinar_chapters.webinar_id', '=', 'webinars.id')
                ->join('webinar_chapter_translations', 'webinar_chapter_translations.webinar_chapter_id', '=', 'webinar_chapters.id')
                ->select('webinars.id', 'webinar_translations.title', 'webinar_chapters.id as chapter_id', 'webinar_chapter_translations.title as chapter_title')
                ->get();

        $chapters_list = array();
        if (!empty($webinars)) {
            foreach ($webinars as $webinarData) {
                $webinar_id = isset($webinarData->id) ? $webinarData->id : '';
                $webinar_title = isset($webinarData->title) ? $webinarData->title : '';
                $chapter_id = isset($webinarData->chapter_id) ? $webinarData->chapter_id : '';
                $chapter_title = isset($webinarData->chapter_title) ? $webinarData->chapter_title : '';
                $chapters_list[$webinar_id]['title'] = $webinar_title;
                $chapters_list[$webinar_id]['chapters'][$chapter_id] = $chapter_title;
            }
        }
        $data['chapters'] = $chapters_list;

        return view('admin.quizzes.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('admin_quizzes_create');

        $data = $request->get('ajax')['new'];
        $locale = $data['locale'] ?? getDefaultLocale();

        $rules = [
            //'title' => 'required|max:255',
            //'webinar_id' => 'required|exists:webinars,id',
            //'pass_mark' => 'required',
        ];

         if ($request->ajax()) {

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


        $webinar = Webinar::where('id', $data['webinar_id'])
            ->first();

        if (!empty($webinar)) {
            $chapter = null;

            if (!empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id', $data['chapter_id'])
                    ->where('webinar_id', $webinar->id)
                    ->first();
            }
            
            $mastery_points = isset($data['mastery_points']) ? $data['mastery_points'] : 0;


            $Below_points = isset($data['Below_points']) ? $data['Below_points'] : 0;
            $Emerging_points = isset($data['Emerging_points']) ? $data['Emerging_points'] : 0;
            $Expected_points = isset($data['Expected_points']) ? $data['Expected_points'] : 0;
            $Exceeding_points = isset($data['Exceeding_points']) ? $data['Exceeding_points'] : 0;
            $Challenge_points = isset($data['Challenge_points']) ? $data['Challenge_points'] : 0;

            $Below_questions = isset($data['Below']) ? $data['Below'] : 0;
            $Emerging_questions = isset($data['Emerging']) ? $data['Emerging'] : 0;
            $Expected_questions = isset($data['Expected']) ? $data['Expected'] : 0;
            $Exceeding_questions = isset($data['Exceeding']) ? $data['Exceeding'] : 0;
            $Challenge_questions = isset($data['Challenge']) ? $data['Challenge'] : 0;

            $quiz_settings = array(
                'Below' => array(
                    'questions' => isset($data['Below']) ? $data['Below'] : '',
                    'points_percentage' => isset($data['Below_points']) ? $data['Below_points'] : '',
                    'points' => (round(($Below_points * $mastery_points) / 100) / $Below_questions),
                ),
                'Emerging' => array(
                    'questions' => isset($data['Emerging']) ? $data['Emerging'] : '',
                    'points_percentage' => isset($data['Emerging_points']) ? $data['Emerging_points'] : '',
                    'points' => (round(($Emerging_points * $mastery_points) / 100) / $Emerging_questions),
                ),
                'Expected' => array(
                    'questions' => isset($data['Expected']) ? $data['Expected'] : '',
                    'points_percentage' => isset($data['Expected_points']) ? $data['Expected_points'] : '',
                    'points' => (round(($Expected_points * $mastery_points) / 100) / $Expected_questions),
                ),
                'Exceeding' => array(
                    'questions' => isset($data['Exceeding']) ? $data['Exceeding'] : '',
                    'points_percentage' => isset($data['Exceeding_points']) ? $data['Exceeding_points'] : '',
                    'points' => (round(($Exceeding_points * $mastery_points) / 100) / $Exceeding_questions),
                ),
                'Challenge' => array(
                    'questions' => isset($data['Challenge']) ? $data['Challenge'] : '',
                    'points_percentage' => isset($data['Challenge_points']) ? $data['Challenge_points'] : '',
                    'points' => (round(($Challenge_points * $mastery_points) / 100) / $Challenge_questions),
                )
            );

            $quiz = Quiz::create([
                        'webinar_id' => $webinar->id,
                        'chapter_id' => !empty($chapter) ? $chapter->id : null,
                        'creator_id' => $webinar->creator_id,
                        'webinar_title' => $webinar->title,
                        'attempt' => 100,
                        'quiz_type' => isset($data['quiz_type']) ? $data['quiz_type'] : '',
                        'sub_chapter_id' => isset($data['sub_chapter_id']) ? $data['sub_chapter_id'] : 0,
                        'pass_mark' => 1,
                        'time' => 100,
                        'status' => (!empty($data['status']) and $data['status'] == 'on') ? Quiz::ACTIVE : Quiz::INACTIVE,
                        'certificate' => 1,
                        'created_at' => time(),
                        'quiz_settings' => json_encode($quiz_settings),
                        'mastery_points' => isset($data['mastery_points']) ? $data['mastery_points'] : 0,
            ]);

            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id,
                'locale' => mb_strtolower($locale),
            ], [
                'title' => $data['title'],
            ]);

            if (!empty($quiz->chapter_id)) {
                WebinarChapterItem::makeItem($webinar->creator_id, $quiz->chapter_id, $quiz->id, WebinarChapterItem::$chapterQuiz);
            }

            // Send Notification To All Students
            $webinar->sendNotificationToAllStudentsForNewQuizPublished($quiz);

            if ($request->ajax()) {

                $redirectUrl = '';

                if (empty($data['is_webinar_page'])) {
                    $redirectUrl = getAdminPanelUrl('/quizzes/' . $quiz->id . '/edit');
                }

                return response()->json([
                    'code' => 200,
                    'redirect_url' => $redirectUrl
                ]);
            } else {
                return redirect()->route('adminEditQuiz', ['id' => $quiz->id]);
            }
        } else {
            return back()->withErrors([
                'webinar_id' => trans('validation.exists', ['attribute' => trans('admin/main.course')])
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_quizzes_edit');

        $quiz = Quiz::query()->where('id', $id)
            ->with([
                'quizQuestions' => function ($query) {
                    $query->orderBy('order', 'asc');
                    $query->with('quizzesQuestionsAnswers');
                },
            ])
            ->first();

        if (empty($quiz)) {
            abort(404);
        }

        $creator = $quiz->creator;

        $webinars = Webinar::where('status', 'active')
            ->where(function ($query) use ($creator) {
                $query->where('teacher_id', $creator->id)
                    ->orWhere('creator_id', $creator->id);
            })->get();

        $locale = $request->get('locale', app()->getLocale());
        if (empty($locale)) {
            $locale = app()->getLocale();
        }
        storeContentLocale($locale, $quiz->getTable(), $quiz->id);

        $quiz->title = $quiz->getTitleAttribute();
        $quiz->locale = mb_strtoupper($locale);

        $chapters = collect();

        if (!empty($quiz->webinar)) {
            $chapters = $quiz->webinar->chapters;
        }

        $data = [
            'pageTitle' => trans('public.edit') . ' ' . $quiz->title,
            'webinars' => $webinars,
            'quiz' => $quiz,
            'quizQuestions' => $quiz->quizQuestions,
            'creator' => $creator,
            'chapters' => $chapters,
            'locale' => mb_strtolower($locale),
            'defaultLocale' => getDefaultLocale(),
        ];
        
        $query = Webinar::query();

        $webinars = DB::table('webinars')
                ->join('webinar_translations', 'webinar_translations.webinar_id', '=', 'webinars.id')
                ->join('webinar_chapters', 'webinar_chapters.webinar_id', '=', 'webinars.id')
                ->join('webinar_chapter_translations', 'webinar_chapter_translations.webinar_chapter_id', '=', 'webinar_chapters.id')
                ->select('webinars.id', 'webinar_translations.title', 'webinar_chapters.id as chapter_id', 'webinar_chapter_translations.title as chapter_title')
                ->get();

        $chapters_list = array();
        if (!empty($webinars)) {
            foreach ($webinars as $webinarData) {
                $webinar_id = isset($webinarData->id) ? $webinarData->id : '';
                $webinar_title = isset($webinarData->title) ? $webinarData->title : '';
                $chapter_id = isset($webinarData->chapter_id) ? $webinarData->chapter_id : '';
                $chapter_title = isset($webinarData->chapter_title) ? $webinarData->chapter_title : '';
                $chapters_list[$webinar_id]['title'] = $webinar_title;
                $chapters_list[$webinar_id]['chapters'][$chapter_id] = $chapter_title;
            }
        }
        $data['chapters'] = $chapters_list;

        return view('admin.quizzes.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::query()->findOrFail($id);
        $user = $quiz->creator;
        $quizQuestionsCount = $quiz->quizQuestions->count();

        $data = $request->get('ajax')[$id];
        $locale = $data['locale'] ?? getDefaultLocale();

        $rules = [
            'title' => 'required|max:255',
            'webinar_id' => 'required|exists:webinars,id',
            //'pass_mark' => 'required',
            //'display_number_of_questions' => 'required_if:display_limited_questions,on|nullable|between:1,' . $quizQuestionsCount
        ];

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'code' => 422,
                'errors' => $validate->errors()
            ], 422);
        }

        $user = $quiz->creator;
        $webinar = null;
        $chapter = null;

        if (!empty($data['webinar_id'])) {
            $webinar = Webinar::where('id', $data['webinar_id'])->first();

            if (!empty($webinar) and !empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id', $data['chapter_id'])
                    ->where('webinar_id', $webinar->id)
                    ->first();
            }
        }
        
        $mastery_points = isset($data['mastery_points']) ? $data['mastery_points'] : 0;

        $Below_points = isset($data['Below_points']) ? $data['Below_points'] : 0;
        $Emerging_points = isset($data['Emerging_points']) ? $data['Emerging_points'] : 0;
        $Expected_points = isset($data['Expected_points']) ? $data['Expected_points'] : 0;
        $Exceeding_points = isset($data['Exceeding_points']) ? $data['Exceeding_points'] : 0;
        $Challenge_points = isset($data['Challenge_points']) ? $data['Challenge_points'] : 0;
        
        $Below_questions = isset($data['Below']) ? $data['Below'] : 0;
        $Emerging_questions = isset($data['Emerging']) ? $data['Emerging'] : 0;
        $Expected_questions = isset($data['Expected']) ? $data['Expected'] : 0;
        $Exceeding_questions = isset($data['Exceeding']) ? $data['Exceeding'] : 0;
        $Challenge_questions = isset($data['Challenge']) ? $data['Challenge'] : 0;

        $quiz_settings = array(
            'Below' => array(
                'questions' => isset($data['Below']) ? $data['Below'] : '',
                'points_percentage' => isset($data['Below_points']) ? $data['Below_points'] : '',
                'points' => (round(($Below_points * $mastery_points) / 100) / $Below_questions),
            ),
            'Emerging' => array(
                'questions' => isset($data['Emerging']) ? $data['Emerging'] : '',
                'points_percentage' => isset($data['Emerging_points']) ? $data['Emerging_points'] : '',
                'points' => (round(($Emerging_points * $mastery_points) / 100) / $Emerging_questions),
            ),
            'Expected' => array(
                'questions' => isset($data['Expected']) ? $data['Expected'] : '',
                'points_percentage' => isset($data['Expected_points']) ? $data['Expected_points'] : '',
                'points' => (round(($Expected_points * $mastery_points) / 100) / $Expected_questions),
            ),
            'Exceeding' => array(
                'questions' => isset($data['Exceeding']) ? $data['Exceeding'] : '',
                'points_percentage' => isset($data['Exceeding_points']) ? $data['Exceeding_points'] : '',
                'points' => (round(($Exceeding_points * $mastery_points) / 100) / $Exceeding_questions),
            ),
            'Challenge' => array(
                'questions' => isset($data['Challenge']) ? $data['Challenge'] : '',
                'points_percentage' => isset($data['Challenge_points']) ? $data['Challenge_points'] : '',
                'points' => (round(($Challenge_points * $mastery_points) / 100) / $Challenge_questions),
            )
        );

        $quiz->update([
            //'webinar_id' => !empty($webinar) ? $webinar->id : null,
            //'chapter_id' => !empty($chapter) ? $chapter->id : null,
            'webinar_id' => isset($data['webinar_id']) ? $data['webinar_id'] : 0,
            'chapter_id' => isset($data['chapter_id']) ? $data['chapter_id'] : 0,
            'webinar_title' => !empty($webinar) ? $webinar->title : null,
            'attempt' => 100,
            'pass_mark' => isset($data['pass_mark']) ? $data['pass_mark'] : 1,
            'sub_chapter_id' => isset($data['sub_chapter_id']) ? $data['sub_chapter_id'] : 0,
            'time' => 20,
            'quiz_type' => isset($data['quiz_type']) ? $data['quiz_type'] : '',
            'status' => (!empty($data['status']) and $data['status'] == 'on') ? Quiz::ACTIVE : Quiz::INACTIVE,
            'certificate' => (!empty($data['certificate']) and $data['certificate'] == 'on') ? true : false,
            'updated_at' => time(),
            'quiz_settings' => json_encode($quiz_settings),
            'mastery_points' => $mastery_points,
        ]);

        if (!empty($quiz)) {
            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id,
                'locale' => mb_strtolower($locale),
            ], [
                'title' => $data['title'],
            ]);

            $checkChapterItem = WebinarChapterItem::where('user_id', $user->id)
                ->where('item_id', $quiz->id)
                ->where('type', WebinarChapterItem::$chapterQuiz)
                ->first();

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
        }

        removeContentLocale();

        if ($request->ajax()) {
            return response()->json([
                'code' => 200
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function delete(Request $request, $id)
    {
        $this->authorize('admin_quizzes_delete');

        $quiz = Quiz::findOrFail($id);

        $quiz->delete();

        $checkChapterItem = WebinarChapterItem::where('item_id', $id)
            ->where('type', WebinarChapterItem::$chapterQuiz)
            ->first();

        if (!empty($checkChapterItem)) {
            $checkChapterItem->delete();
        }

        if ($request->ajax()) {
            return response()->json([
                'code' => 200
            ], 200);
        }

        return redirect()->back();
    }

    public function results($id)
    {
        $this->authorize('admin_quizzes_results');

        $quizzesResults = QuizzesResult::where('quiz_id', $id)
            ->with([
                'quiz' => function ($query) {
                    $query->with(['teacher']);
                },
                'user'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/quizResults.quiz_result_list_page_title'),
            'quizzesResults' => $quizzesResults,
            'quiz_id' => $id
        ];

        return view('admin.quizzes.results', $data);
    }

    public function resultsExportExcel($id)
    {
        $this->authorize('admin_quiz_result_export_excel');

        $quizzesResults = QuizzesResult::where('quiz_id', $id)
            ->with([
                'quiz' => function ($query) {
                    $query->with(['teacher']);
                },
                'user'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $export = new QuizResultsExport($quizzesResults);

        return Excel::download($export, 'quiz_result.xlsx');
    }

    public function resultDelete($result_id)
    {
        $this->authorize('admin_quizzes_results_delete');

        $quizzesResults = QuizzesResult::where('id', $result_id)->first();

        if (!empty($quizzesResults)) {
            $quizzesResults->delete();
        }

        return redirect()->back();
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('admin_quizzes_lists_excel');

        $query = Quiz::query();

        $query = $this->filters($query, $request);

        $quizzes = $query->with([
            'webinar',
            'teacher',
            'quizQuestions',
            'quizResults',
        ])->get();

        return Excel::download(new QuizzesAdminExport($quizzes), trans('quiz.quizzes') . '.xlsx');
    }

    public function orderItems(Request $request, $quizId)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'items' => 'required',
            'table' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $quiz = Quiz::query()->where('id', $quizId)->first();

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
                            QuizzesQuestion::where('id', $id)
                                ->where('quiz_id', $quiz->id)
                                ->update(['order' => ($order + 1)]);
                        }
                        break;
                }
            }
        }

        return response()->json([
            'title' => trans('public.request_success'),
            'msg' => trans('update.items_sorted_successful')
        ]);
    }
}
