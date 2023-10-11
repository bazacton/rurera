<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesResult;
use App\Models\QuizzesQuestionsList;
use App\Models\Translation\QuizTranslation;
use App\Models\Webinar;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\Models\AssignedAssignments;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Translation\QuizzesQuestionTranslation;

class AssignedAssignmentsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin_assignments');

        removeContentLocale();
        //DB::enableQueryLog();

        $query = AssignedAssignments::query()->where('status', '!=', 'inactive');

        if (auth()->user()->isTeacher()) {
            $query = $query->where('created_by', auth()->user()->id);
        }
        $totalAssignedAssignments = deepClone($query)->count();

        $query = $this->filters($query, $request);


        $assignedAssignments = $query->with([
            'assignment'
        ])->paginate(100);

        //pre($assignedAssignments);

        //pre($quizzes);

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();

        $data = [
            'pageTitle'                => 'Assigned Assignments',
            'assignedAssignments'      => $assignedAssignments,
            'totalAssignedAssignments' => $totalAssignedAssignments,
        ];

        return view('admin.assigned_assignments.lists', $data);
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
        $year_group = $request->get('year_group', null);
        $subject = $request->get('subject', null);
        $examp_board = $request->get('examp_board', null);

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

        if (!empty($year_group) and $year_group !== 'All') {
            $query->where('year_group', $year_group);
        }

        if (!empty($subject) and $subject !== 'All') {
            $query->where('subject', $subject);
        }

        if (!empty($examp_board) and $examp_board !== 'All') {
            $query->where('examp_board', $examp_board);
        }

        return $query;
    }


    public function store(Request $request)
    {
        $user = auth()->user();
        $this->authorize('admin_quizzes_create');
        $assignment_deadline = $request->get('assignment_deadline', date('Y-m-d'));
        $assignment_deadline = strtotime($assignment_deadline);
        $assignment_id = $request->get('assignment_id', null);
        $no_of_attempts = $request->get('no_of_attempts', 1);

        $user_ids = $request->get('user_ids', array());


        $rules = [
            //'title' => 'required|max:255',
            //'webinar_id' => 'required|exists:webinars,id',
            //'pass_mark' => 'required',
        ];

        //$this->validate($request, $rules);


        $AssignedAssignment = AssignedAssignments::create([
            'assignment_id'       => $assignment_id,
            'user_ids'            => json_encode($user_ids),
            'assignment_deadline' => $assignment_deadline,
            'status'              => 'active',
            'created_by'          => $user->id,
            'created_at'          => time(),
            'no_of_attempts'          => $no_of_attempts,
        ]);

        //return redirect()->route('adminEditAssignedAssignment', ['id' => $AssignedAssignment->id]);
        return redirect()->route('adminListAssignedAssignment');

    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_quizzes_edit');
        exit;

        $quiz = Quiz::query()->where('id', $id)
            ->with([
                'quizQuestions'     => function ($query) {
                    $query->orderBy('order', 'asc');
                    $query->with('quizzesQuestionsAnswers');
                },
                'quizQuestionsList' => function ($query) {
                    $query->where('status', 'active');
                    $query->orderBy('sort_order', 'asc');
                    $query->with('QuestionData');
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

        $categories = Category::where('parent_id', null)
            ->with('subCategories')->orderBy('order', 'asc')
            ->get();


        $data = [
            'pageTitle'     => trans('public.edit') . ' ' . $quiz->title,
            'webinars'      => $webinars,
            'assignment'    => $quiz,
            'quizQuestions' => $quiz->quizQuestions,
            'creator'       => $creator,
            'chapters'      => $chapters,
            'categories'    => $categories,
            'locale'        => mb_strtolower($locale),
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

        return view('admin.assignments.create', $data);
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::query()->findOrFail($id);
        $user = $quiz->creator;

        $quizQuestionsCount = $quiz->quizQuestions->count();
        $quizQuestionsListArray = $quiz->quizQuestionsList->pluck('question_id')->toArray();


        //QuizzesQuestionsList::whereNotIn('id' , $quizQuestionsListArray)->update(array('status' => 'inactive'));


        $data = $request->get('ajax')[$id];
        $locale = $data['locale'] ?? getDefaultLocale();


        $rules = [
            'title' => 'required|max:255',
            //'webinar_id' => 'required|exists:webinars,id' ,
            //'pass_mark' => 'required',
            //'display_number_of_questions' => 'required_if:display_limited_questions,on|nullable|between:1,' . $quizQuestionsCount
        ];

        $validate = Validator::make($data, $rules);

        $question_list_ids = isset($data['question_list_ids']) ? $data['question_list_ids'] : array();


        if ($validate->fails()) {
            return response()->json([
                'code'   => 422,
                'errors' => $validate->errors()
            ], 422);
        }

        $user = $quiz->creator;
        $webinar = null;
        $chapter = null;


        $quiz->update([
            //'webinar_id' => !empty($webinar) ? $webinar->id : null,
            //'chapter_id' => !empty($chapter) ? $chapter->id : null,
            //'webinar_id'     => isset($data['webinar_id']) ? $data['webinar_id'] : 0 ,
            'quiz_slug'          => (isset($data['quiz_slug']) && $data['quiz_slug'] != '') ? $data['quiz_slug'] : Quiz::makeSlug($data['title']),
            'attempt'            => 100,
            'pass_mark'          => 1,
            'time'               => 20,
            'quiz_type'          => 'assignment',
            'status'             => Quiz::ACTIVE,
            'certificate'        => (!empty($data['certificate']) and $data['certificate'] == 'on') ? true : false,
            'updated_at'         => time(),
            'quiz_settings'      => json_encode(array()),
            'mastery_points'     => 0,
            'show_all_questions' => 0,
            'sub_title'          => '',
            'quiz_image'         => '',
            'quiz_pdf'           => '',
            'quiz_instructions'  => '',
            'year_group'         => '',
            'subject'            => '',
            'year_id'            => (isset($data['year_id']) && $data['year_id'] > 0) ? $data['year_id'] : 100,
            'subject_id'         => (isset($data['subject_id']) && $data['subject_id'] > 0) ? $data['subject_id'] : 100,
        ]);

        if (!empty($quiz)) {


            $quiz_question_ids = array();
            if (!empty($question_list_ids)) {
                foreach ($question_list_ids as $sort_order => $question_id) {
                    $quiz_question_ids[] = $question_id;
                    if (in_array($question_id, $quizQuestionsListArray)) {
                        $questionListObj = QuizzesQuestionsList::query()->where('quiz_id', $id)->where('question_id',
                            $question_id)->update([
                            'sort_order' => $sort_order,
                        ]);
                    } else {
                        QuizzesQuestionsList::create([
                            'quiz_id'     => $quiz->id,
                            'question_id' => $question_id,
                            'status'      => 'active',
                            'sort_order'  => $sort_order,
                            'created_by'  => $user->id,
                            'created_at'  => time()
                        ]);
                    }
                }
            }
            QuizzesQuestionsList::where('quiz_id', $id)->whereNotIn('question_id', $quiz_question_ids)->update(array('status' => 'inactive'));

            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id,
                'locale'  => mb_strtolower($locale),
            ], [
                'title' => $data['title'],
            ]);
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


}
