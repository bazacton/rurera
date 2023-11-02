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
            $classes_query = $classes_query->where('created_by', $user->id);
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
            $sections_query = $sections_query->where('created_by', $user->id);
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

    /*
    * Generate Audio File by Text
    */
    public function generate_audio(Request $request)
    {
        $user = auth()->user();
        $audio_text = $request->get('audio_text', null);
        $word_audio = $audio_text;
        $word_audio = '<speak>'.$word_audio.'</speak>';
        $audio_sentense = $request->get('audio_sentense', null);
        $audio_text = '<speak>'.$audio_text.' [P-1] as in '. $audio_sentense .' </speak>';
        $audio_text = str_replace('[P-', '<break time="', $audio_text);
        $audio_text = str_replace(']', 's"/>', $audio_text);

        $TextToSpeechController = new TextToSpeechController();
        $text_audio_path = $TextToSpeechController->getSpeechAudioFilePath($audio_text);

        $text_word_audio_path = $TextToSpeechController->getSpeechAudioFilePath($word_audio);

        return array(
            'audio_file' => '/speech-audio/' . $text_audio_path,
            'word_audio_file' => '/speech-audio/' . $text_word_audio_path,
        );

        exit;
    }



}
