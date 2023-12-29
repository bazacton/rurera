<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\TextToSpeechController;
use App\Models\Category;
use App\Models\Classes;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesResult;
use App\Models\QuizzesQuestionsList;
use App\Models\Role;
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

class CommonController extends Controller
{

    /*
     * Get Classes added by Year / Category
     * @incase of Teacher it will be restricted to teacher added classes only
     */
    public function classes_by_year(Request $request)
    {
        $user = auth()->user();
        $year_id = $request->get('year_id', null);
        $class_id = $request->get('class_id', null);
        $classes_query = Classes::where('category_id', $year_id)->where('status', 'active')->where('parent_id', 0);

        if (auth()->user()->isTeacher()) {
            //$classes_query = $classes_query->where('created_by', $user->id);
        }

        $classes = $classes_query->get();

        $response = '<option value="">Select Class</option>';
        if (!empty($classes)) {
            foreach ($classes as $classObj) {
                $selected = ($class_id == $classObj->id) ? 'selected' : '';
                $response .= '<option value="' . $classObj->id . '" ' . $selected . '>' . $classObj->title . '</option>';
            }
        }

        echo $response;

        exit;
    }

    /*
     * Get Example Question
     */
    public function get_example_question(Request $request)
    {
        $user = auth()->user();
        $question_id = $request->get('question_id', null);
        $response = '';
        $questionObj = QuizzesQuestion::find($question_id);
        $question_layout = isset( $questionObj->question_layout )? $questionObj->question_layout : '';
        $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));
        $question_layout = str_replace('editor-field', 'example-editor-field', $question_layout);

        //pre($questionObj);

        echo $question_layout;

        exit;
    }


    /*
     * Get Classes added by Year / Category
     * @incase of Teacher it will be restricted to teacher added classes only
     */
    public function sections_by_class(Request $request)
    {
        $user = auth()->user();
        $class_id = $request->get('class_id', null);
        $section_id = $request->get('section_id', null);
        $sections_query = Classes::where('parent_id', $class_id)->where('status', 'active');

        if (auth()->user()->isTeacher()) {
            //$sections_query = $sections_query->where('created_by', $user->id);
        }

        $sections = $sections_query->get();

        $response = '<option value="">Select Section</option>';
        if (!empty($sections)) {
            foreach ($sections as $sectionObj) {
                $selected = ($section_id == $sectionObj->id) ? 'selected' : '';
                $response .= '<option value="' . $sectionObj->id . '" ' . $selected . '>' . $sectionObj->title . '</option>';
            }
        }

        echo $response;

        exit;
    }

    public function questions_by_keyword(Request $request)
    {
        $user = auth()->user();
        $keyword = $request->get('keyword', null);
        $year_id = $request->get('year_id', null);
        $subject_id = $request->get('subject_id', null);

        $questionIds = QuizzesQuestion::where(function ($query) use ($keyword) {
            $query->where('question_title', 'like', '%' . $keyword . '%')->orWhere('search_tags', 'like', '%' . $keyword . '%')->orWhere('question_difficulty_level', 'like', '%' . $keyword . '%');
        })->where('creator_id', $user->id)->where('category_id', $year_id)->where('course_id', $subject_id)->get();

        $questions_array = array();
        if (!empty($questionIds)) {
            foreach ($questionIds as $questionObj) {
                echo '<li data-question_id="' . $questionObj->id . '"><a href="javascript:;">' . $questionObj->id . ' | ' . $questionObj->question_title . ' | ' . $questionObj->question_difficulty_level . '</a></li>';
            }
        }
        exit;

    }


    /*
    * Get Users added by Class
    * @incase of Teacher it will be restricted to teacher added classes only
    */
    public function users_by_class(Request $request)
    {
        $user = auth()->user();
        $class_id = $request->get('class_id', null);
        $return_type = $request->get('return_type', 'option');
        $user_id = $request->get('user_id', null);
        $users_query = User::where('role_name', Role::$user)->where('class_id', $class_id)->where('status', 'active');

        if (auth()->user()->isTeacher()) {
            $users_query = $users_query->where('parent_id', $user->id)->where('parent_type', 'teacher');
        }

        $users = $users_query->get();

        $response = '';
        if ($return_type == 'option') {
            $response = '<option value="">Select User</option>';
        }
        if (!empty($users)) {
            foreach ($users as $userObj) {
                if ($return_type == 'option') {
                    $selected = ($user_id == $userObj->id) ? 'selected' : '';
                    $response .= '<option value="' . $userObj->id . '" ' . $selected . '>' . $userObj->full_name . '</option>';
                }
                if ($return_type == 'list') {
                    $response .= '<li data-user_id="' . $userObj->id . '"><a href="javascript:;" data-user_id="' . $userObj->id . '">' . $userObj->full_name . '</a></li>';
                }
            }
        }

        echo $response;

        exit;
    }

    /*
    * Get Users added by Sections
    * @incase of Teacher it will be restricted to teacher added classes only
    */
    public function users_by_section(Request $request)
    {
        $user = auth()->user();
        $section_id = $request->get('section_id', null);
        $return_type = $request->get('return_type', 'option');
        $user_id = $request->get('user_id', null);
        $users_query = User::where('role_name', Role::$user)->where('section_id', $section_id)->where('status', 'active');

        if (auth()->user()->isTeacher()) {
            $users_query = $users_query->where('parent_id', $user->id)->where('parent_type', 'teacher');
        }

        $users = $users_query->get();

        $response = '';
        if ($return_type == 'option') {
            $response = '<option value="">Select User</option>';
        }
        if (!empty($users)) {
            foreach ($users as $userObj) {
                if ($return_type == 'option') {
                    $selected = ($user_id == $userObj->id) ? 'selected' : '';
                    $response .= '<option value="' . $userObj->id . '" ' . $selected . '>' . $userObj->full_name . '</option>';
                }
                if ($return_type == 'list') {
                    $response .= '<li data-user_id="' . $userObj->id . '"><a href="javascript:;" data-user_id="' . $userObj->id . '">' . $userObj->full_name . '</a></li>';
                }
            }
        }

        echo $response;

        exit;
    }

    /*
    * Get Users added by Sections
    * @incase of Teacher it will be restricted to teacher added classes only
    */
    public function subjects_by_year(Request $request)
    {
        $user = auth()->user();
        $year_id = $request->get('year_id', null);
        $subject_id = $request->get('subject_id', null);
        $subjects_query = Webinar::where('category_id', $year_id)->where('type', 'course')->where('status', 'active');

        $subjects = $subjects_query->get();

        $response = '<option value="">Select Subject</option>';
        if (!empty($subjects)) {
            foreach ($subjects as $subjectObj) {
                $selected = ($subject_id == $subjectObj->id) ? 'selected' : '';
                $response .= '<option value="' . $subjectObj->id . '" ' . $selected . '>' . $subjectObj->getTitleAttribute() . '</option>';
            }
        }

        echo $response;

        exit;
    }

    public function types_quiz_by_year(Request $request)
    {
        $user = auth()->user();
        $year_id = $request->get('year_id', null);
        $quiz_type = $request->get('quiz_type', null);

        if ($quiz_type == 'practice') {

            $response = $this->get_subjects_by_year($year_id);
        } else {
            $resultsQuery = Quiz::where('quiz_type', $quiz_type)->where('status', 'active');

            if ($year_id > 0) {
                $resultsQuery = $resultsQuery->where('year_id', $year_id);
            }

            $results = $resultsQuery->get();


            $response = '<div class="form-group">
                        <label class="input-label">Select Topic</label>
                        <div class="input-group">
                            <select name="ajax[new][topic_id]"
                                    class="form-control select2 topic_selection">';

            $response .= '<option value="">Select Topic</option>';
            if (!empty($results)) {
                foreach ($results as $rowObj) {
                    $count_questions = isset($rowObj->quizQuestionsList) ? count($rowObj->quizQuestionsList) : 0;
                    $selected = '';
                    $response .= '<option data-total_questions="' . $count_questions . '" value="' . $rowObj->id . '" ' . $selected . '>' . $rowObj->getTitleAttribute() . '</option>';
                }
            }
            $response .= '</select></div></div>';
        }

        echo $response;

        exit;
    }

    public function topics_subtopics_by_subject(Request $request)
    {
        $user = auth()->user();
        $subject_id = $request->get('subject_id', null);
        $courseObj = Webinar::find($subject_id);
        $chapters = $courseObj->chapters;
        $response = '<div class="row">';
        if (!empty($chapters)) {
            foreach ($chapters as $chapterObj) {
                $subChapters = $chapterObj->subChapters;
                $sub_chapters_response = '';

                if (!empty($subChapters)) {
                    foreach ($subChapters as $subChapterObj) {
                        $quizData = $subChapterObj->quizData;
                        $quiz_id = isset($quizData->item_id) ? $quizData->item_id : 0;
                        $quizData = isset($subChapterObj->quizData->quiz) ? $subChapterObj->quizData->quiz : array();
                        $count_questions = isset($quizData->quizQuestionsList) ? count($quizData->quizQuestionsList) : 0;

                        $sub_chapters_response .= '<div class="form-check mt-1">
                            <input type="checkbox" name="ajax[new][topic_ids][]" data-total_questions="' . $count_questions . '" id="topic_ids_' . $chapterObj->id . '_' . $subChapterObj->id . '" value="' . $quiz_id . '" class="form-check-input section-child topics_multi_selection">
                            <label class="form-check-label cursor-pointer mt-0" for="topic_ids_' . $chapterObj->id . '_' . $subChapterObj->id . '">
                                ' . $subChapterObj->sub_chapter_title . '
                            </label>
                        </div>';
                    }
                }
                $response .= '<div class="col-lg-4 col-md-4 col-sm-12 col-4"><div class="card card-primary section-box">
                        <div class="card-header">
                            <input type="checkbox" name="chapter_ids[]" id="chapter_ids_' . $chapterObj->id . '" value="1" class="form-check-input mt-0 topic-section-parent">
                            <label class="form-check-label font-16 font-weight-bold cursor-pointer" for="chapter_ids_' . $chapterObj->id . '">
                                ' . $chapterObj->getTitleAttribute() . '
                            </label>
                        </div>

                        <div class="card-body">
                            ' . $sub_chapters_response . '
                        </div>
                </div></div>';
            }
        }

        $response .= '</div>';
        echo $response;

        exit;
    }

    public function get_subjects_by_year($year_id)
    {
        $courses = Webinar::where('category_id', $year_id)->with('chapters.subChapters')->get();

        $subjects_response = '';
        if (!empty($courses)) {
            foreach ($courses as $courseObj) {
                $subjects_response .= '
                                        <label class="card-radio">
                                            <input type="radio" name="ajax[new][subject]"
                                                   class="assignment_subject_check" value="' . $courseObj->id . '">
                                            <span class="radio-btn"><i class="las la-check"></i>
                                                        <div class="card-icon">
                                                            ' . $courseObj->icon_code . '
                                                            <h3>' . $courseObj->getTitleAttribute() . '</h3>
                                                       </div>

                                                  </span>
                                        </label>';
            }
        }
        $response = '<div class="form-group">
                <label class="input-label">Subject</label>
                <div class="input-group">
                    <div class="radio-buttons">
                        ' . $subjects_response . '
                    </div>
                </div>
            </div>';
        return $response;
    }

    public function types_quiz_by_year_group(Request $request)
    {
        $user = auth()->user();
        $year_group = $request->get('year_group', null);
        $quiz_type = $request->get('quiz_type', null);
        $resultsQuery = Quiz::where('quiz_type', $quiz_type)->where('status', 'active');

        if ($year_group != 'All') {
            $resultsQuery = $resultsQuery->where('year_group', $year_group);
        }

        $results = $resultsQuery->get();


        $response = '<div class="form-group">
                        <label class="input-label">Select Topic</label>
                        <div class="input-group">
                            <select name="ajax[new][topic_id]"
                                    class="form-control select2 topic_selection">';

        $response .= '<option value="">Select Topic</option>';
        if (!empty($results)) {
            foreach ($results as $rowObj) {
                $count_questions = isset($rowObj->quizQuestionsList) ? count($rowObj->quizQuestionsList) : 0;
                $selected = '';
                $response .= '<option data-total_questions="' . $count_questions . '" value="' . $rowObj->id . '" ' . $selected . '>' . $rowObj->getTitleAttribute() . '</option>';
            }
        }
        $response .= '</select></div></div>';

        echo $response;

        exit;
    }


    /*
    * Generate Audio File by Text
    */
    public function generate_audio(Request $request)
    {
        $user = auth()->user();
        $audio_text = $request->get('audio_text', null);
        $word_audio = $audio_text;
        $word_audio = '<speak>' . $word_audio . '</speak>';
        $audio_sentense = $request->get('audio_sentense', null);
        $audio_text = '<speak>' . $audio_text . ' [P-1] as in ' . $audio_sentense . ' </speak>';
        $audio_text = str_replace('[P-', '<break time="', $audio_text);
        $audio_text = str_replace(']', 's"/>', $audio_text);

        $TextToSpeechController = new TextToSpeechController();
        $text_audio_path = $TextToSpeechController->getSpeechAudioFilePath($audio_text);

        $text_word_audio_path = $TextToSpeechController->getSpeechAudioFilePath($word_audio);

        return array(
            'audio_file'      => '/speech-audio/' . $text_audio_path,
            'word_audio_file' => '/speech-audio/' . $text_word_audio_path,
        );

        exit;
    }


}
