<?php

namespace App\Http\Controllers\Web;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\QuestionsAttemptController;
use App\Http\Controllers\Web\TimestablesController;
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

class CommonWebController extends Controller
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

        $QuestionsAttemptController = new QuestionsAttemptController();
        $question_layout .= $QuestionsAttemptController->get_example_question_layout($question_id);

        $question_layout_response = '<div class="example_question_'.$question_id.'" data-question_title="'.$questionObj->question_title.'">'.$question_layout.'</div>';
        //pre($questionObj);

        echo $question_layout_response;

        exit;
    }

    /*
     * Get Example Question
     */
    public function get_group_questions(Request $request)
    {
        $user = auth()->user();
        $question_ids = $request->get('question_ids', null);
        $question_layout_response = '';

        if( !empty( $question_ids ) ){
            foreach( $question_ids as $question_id){
               $questionObj = QuizzesQuestion::find($question_id);
               $question_layout = isset( $questionObj->question_layout )? $questionObj->question_layout : '';
               $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));
               $question_layout_response .= '<div class="example_question_'.$question_id.'" data-question_title="'.$questionObj->question_title.'">'.$question_layout.'</div>';
            }
        }



        //$question_layout = str_replace('editor-field', 'example-editor-field', $question_layout);

        //$question_layout_response = '<div class="example_question_'.$question_id.'" data-question_title="'.$questionObj->question_title.'">'.$question_layout.'</div>';
        //pre($questionObj);

        echo $question_layout_response;

        exit;
    }

    /*
     * Get Example Question
     */
    public function get_group_questions_options(Request $request)
    {
        $user = auth()->user();
        $question_ids = $request->get('question_ids', null);
        $question_ids = explode(',', $question_ids);
        $question_layout_response = '';

        if( !empty( $question_ids ) ){
            foreach( $question_ids as $question_id){
               $questionObj = QuizzesQuestion::find($question_id);
               $question_layout_response .= '<option value="'.$questionObj->id.'" selected>'.$questionObj->question_title.'</option>';
            }
        }

        echo $question_layout_response;

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
                    $response .= '<option value="' . $userObj->id . '" ' . $selected . '>' . $userObj->get_full_name() . '</option>';
                }
                if ($return_type == 'list') {
                    $response .= '<li data-user_id="' . $userObj->id . '"><a href="javascript:;" data-user_id="' . $userObj->id . '">' . $userObj->get_full_name() . '</a></li>';
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
                    $response .= '<option value="' . $userObj->id . '" ' . $selected . '>' . $userObj->get_full_name() . '</option>';
                }
                if ($return_type == 'list') {
                    $response .= '<li data-user_id="' . $userObj->id . '"><a href="javascript:;" data-user_id="' . $userObj->id . '">' . $userObj->get_full_name() . '</a></li>';
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

        $response = '<option value="">Select a Subject</option>';
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
        $is_frontend = $request->get('is_frontend', null);
        $response = '';


        if ($quiz_type == 'practice') {
			
			$response = '<div class="form-section mb-20 text-left">
							<h2 class="section-title font-18 font-weight-bold">Select Subject</h2>
						</div>';

            $response .= $this->get_subjects_by_year($year_id);
        } else {
            $resultsQuery = Quiz::where('quiz_type', $quiz_type)->where('status', 'active');

            if ($year_id > 0) {
                $resultsQuery = $resultsQuery->where('year_id', $year_id);
            }

            $results = $resultsQuery->get();

            if( $quiz_type == 'vocabulary'){
				
				$countQuery = clone $resultsQuery;
				$countQuery2 = clone $resultsQuery;
				$spellingBeeCount = $countQuery2->where('quiz_category', 'Spelling Bee')->count();
				$wordListsCount = $countQuery->where('quiz_category', 'Word Lists')->count();
                $response .= '<div class="listing-search lms-jobs-form mb-20">';
				if( $is_frontend != 'yes'){
					$response .= '<a href="#." class="filter-mobile-btn">Filters Dropdown</a>';
				}
					$response .= '<ul class="inline-filters vocabulary-ul">
						<li class="active"><a href="javascript:;" data-category="all"><span class="icon-box"><img src="/assets/default/svgs/filter-all.svg"></span>All Word Lists ('.$results->count().')</a></li>
						<li class=""><a href="javascript:;" data-category="Word Lists"><span class="icon-box"><img src="/assets/default/svgs/filter-letters.svg"></span>Word Lists ('.$wordListsCount.')</a></li>
						<li class=""><a href="javascript:;" data-category="Spelling Bee"><span class="icon-box"><img src="/assets/default/svgs/filter-words.svg"></span>Spelling Bee ('.$spellingBeeCount.')</a></li>
					</ul>
				</div>';
				$response .= '<div class="form-section mb-20 text-left">
					<h2 class="section-title font-18 font-weight-bold">Select List Item</h2>
				</div>';
            }


            if( $is_frontend == 'yes'){

                if( $results->count() > 0){
                $response .= '<div class="sats-listing-card medium">';
				if( $quiz_type == 'sats') {
					$response .= '<h4 class="total-tests has-border font-22 mt-20">Total Lists: '.$results->count().'</h4>';
				}
				
				$response .= '<table class="simple-table">
                                    <tbody> ';
                        if( $quiz_type != 'vocabulary') {
                            $response .= '<input type="radio" data-total_questions="0"  name="ajax[new][topic_ids]" class="rurera-hide topic_selection topic_select_radio" value="0">';

                        }else{
                            //$response .='<h4 class="total-tests has-border font-22 mt-20">Total Lists: '.$results->count().'</h4>';
                        }
                        if (!empty($results)) {
                            foreach ($results as $rowObj) {
                                $quiz_image = ($rowObj->quiz_image != '')? $rowObj->quiz_image : '/assets/default/img/assignment-logo/'.$rowObj->quiz_type.'.png';
                                $count_questions = isset($rowObj->quizQuestionsList) ? count($rowObj->quizQuestionsList) : 0;
                                $assign_btn_class = 'mock-test-assign-btn';
                                if( $quiz_type == 'vocabulary') {
                                    $response .= '<input type="checkbox" data-total_questions="'.$count_questions.'"  name="ajax[new][topic_ids][]" class="rurera-hide vocabulary-topic-selection topic_selection topic_select_radio" value="'.$rowObj->id.'">';
                                    $assign_btn_class = 'vocabulary-assign-btn';
                                }

                                    $response .= '<tr>
                                                    <td>
                                                        <img src="'.$quiz_image.'" alt="">
                                                        <h4 class="font-19 font-weight-bold"><a href="/sats/'.$rowObj->quiz_slug.'" class="">' . $rowObj->getTitleAttribute() . '</a>
                                                            <br> <span class="sub_label">'.$count_questions.' Question(s),</span> <span class="sub_label">Time:'.getTimeWithText(($rowObj->time*60), false).' ,</span> <span class="sub_label">'.getQuizTypeTitle($rowObj->quiz_type).'</span>
                                                
                                                        </h4>
                                                    </td>
                                                    <td class="text-right">
                                                     <a href="javascript:;" data-id="'.$rowObj->id.'" data-total_time="' . $rowObj->time . '" data-total_questions="' . $count_questions . '" data-tag_title="'.$rowObj->getTitleAttribute().'" class="rurera-list-btn '.$assign_btn_class.'  " data-next_step="4">Assign Test</a></td>
                                                </tr>';
                            }
                        }

                $response .= '</tbody></table></div>';
                        }
            }else {

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
        }

        echo $response;

        exit;
    }

    public function topics_subtopics_by_subject(Request $request)
    {
        $user = auth()->user();
        $subject_id = $request->get('subject_id', null);
        $chapter_type = $request->get('chapter_type', null);
        $courseObj = Webinar::find($subject_id);
        if ($chapter_type == 'Mock Exams' || $chapter_type == 'Both') {
            $chapters = $courseObj->chapters->whereIN('chapter_type', array('Mock Exams', 'Both'));
        } else{
            $chapters = $courseObj->chapters;
        }

        $response = '<div class="form-section mb-20 text-left">
                                <h2 class="section-title font-18 font-weight-bold">Select Topics</h2>
                            </div><div class="row">';
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
                                ' . $subChapterObj->sub_chapter_title . ' ('.$count_questions.')
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

    public function mock_topics_subtopics_by_subject(Request $request)
    {
        $user = auth()->user();
        $subject_id = $request->get('subject_id', null);
        $chapter_type = $request->get('chapter_type', null);
        $courseObj = Webinar::find($subject_id);
        if ($chapter_type == 'Mock Exams' || $chapter_type == 'Both') {
            $chapters = $courseObj->chapters->whereIN('chapter_type', array('Mock Exams', 'Both'));
        } else{
            $chapters = $courseObj->chapters;
        }

        $response = '<div class="row">';
        if (!empty($chapters)) {
            foreach ($chapters as $chapterObj) {
                $subChapters = $chapterObj->subChapters;
                $sub_chapters_response = '';

                if (!empty($subChapters)) {
                    foreach ($subChapters as $subChapterObj) {
                        $count_questions = $subChapterObj->questions_list->count();

                        $sub_chapters_response .= '<div class="form-check mt-1">
                            <input type="checkbox" data-title="' . $subChapterObj->sub_chapter_title . '" name="ajax[new][topic_ids][]" data-total_questions="' . $count_questions . '" id="topic_ids_' . $chapterObj->id . '_' . $subChapterObj->id . '" value="' . $subChapterObj->id . '" class="form-check-input section-child topics_multi_selection">
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
        $courses = Webinar::WhereJsonContains('category_id', (string) $year_id)->where('status','active')->with('chapters.subChapters')->get();

        $subjects_response = '';
        $counter = 0;
        if (!empty($courses)) {
            foreach ($courses as $courseObj) {
                $counter++;
                $active_class = ($counter == 1)? 'active-subject' : '';
                $is_checked = ($counter == 1)? 'checked' : '';
                $subjects_response .= '
                                        <label class="card-radio '.$active_class.'">
                                            <input type="radio" name="ajax[new][subject]"
                                                   class="assignment_subject_check" data-tag_title="' . $courseObj->getTitleAttribute() . '" value="' . $courseObj->id . '" '.$is_checked.'>
                                            <span class="radio-btn"><i class="las la-check"></i>
                                                        <div class="card-icon">
                                                            <h3>' . $courseObj->getTitleAttribute() . '</h3>
                                                       </div>

                                                  </span>
                                        </label>';
            }
        }
        $response = '<div class="form-group">
                <div class="input-group">
                    <div class="radio-buttons">
                        ' . $subjects_response . '
                    </div>
                </div>
            </div>';
        return $response;
    }

    public function get_mock_subjects_by_year(Request $request)
    {
        $user = auth()->user();
        $year_id = $request->get('year_id', null);
        $field_name = $request->get('field_name', '');
        $field_name = ($field_name != '')? $field_name : 'ajax[new][subject]';

        $courses = Webinar::WhereJsonContains('category_id', (string) $year_id)->whereIN('webinar_type', array('Mock Exams', 'Both'))->with('chapters.subChapters')->get();

        $subjects_response = '';
        if (!empty($courses)) {
            foreach ($courses as $courseObj) {
                $subjects_response .= '
                                        <label class="card-radio">
                                            <input type="radio" name="'.$field_name.'"
                                                   class="mock_exams_subject_check" value="' . $courseObj->id . '">
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
        echo $response;

        exit;
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

    /*
    * Heatmap
    */
    public function user_heatmap(Request $request)
    {
        $user_id = $request->get('user_id', null);
		$TimestablesController = new TimestablesController();
	   
		$times_tables_data = $TimestablesController->user_times_tables_data_single_user($user_id, 'x');
        $average_time = isset($times_tables_data['average_time']) ? $times_tables_data['average_time'] : array();
        $first_date = isset($times_tables_data['first_date']) ? $times_tables_data['first_date'] : '';
        $times_tables_data = isset($times_tables_data['tables_array']) ? $times_tables_data['tables_array'] : array();

        if( empty( $times_tables_data )) {
            $times_tables_data['is_empty'] = 'yes';
        }
		$first_date = isset($times_tables_data['first_date']) ? $times_tables_data['first_date'] : '';
		
		$rendered_view = view('web.default.timestables.average', ['times_tables_data' => $times_tables_data, 'average_time' => $average_time])->render();
        echo $rendered_view;
        exit;
    }

	

}
