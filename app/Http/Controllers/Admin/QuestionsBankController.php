<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\TextToSpeechController;
use App\Models\Quiz;
use App\Models\Glossary;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesQuestionsList;
use App\Models\Translation\QuizzesQuestionTranslation;
use App\Models\Category;
use App\Models\QuizzesResult;
use App\Models\Translation\QuizTranslation;
use App\Models\Translation\WebinarChapterTranslation;
use App\Models\Webinar;
use App\Models\WebinarChapter;
use App\Models\SubChapters;
use App\Models\WebinarChapterItem;
use App\Models\QuestionLogs;
use App\Models\QuestionAuthorPoints;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Elasticsearch;
use UniSharp\LaravelFilemanager\Middlewares\CreateDefaultFolder;
use Illuminate\Support\Facades\Cache;

class QuestionsBankController extends Controller
{

    public $replace_able_text = array();
    public static $mediaFolder = '';
    function getDirContents($dir, &$results = array()) {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if (in_array($ext, array('html','htaccess'))) {
                    unlink($path);
                    $results[] = $path;
                }
            } else if ($value != "." && $value != "..") {
                $this->getDirContents($path, $results);
                //$results[] = $path;
            }
        }

        return $results;
    }

    public function index(Request $request)
    {

        $user = auth()->user();
        if( isset( $_GET['import'])){
            $quiz_ids = array(251,252,253);
            $questionsList = QuizzesQuestionsList::where('quiz_id', 250)->pluck('question_id')->toArray();
            if( !empty( $quiz_ids ) ){
                foreach( $quiz_ids as $quizID){
                    if( !empty( $questionsList ) ){
                        foreach( $questionsList as $questionID){
                            QuizzesQuestionsList::create([
                               'quiz_id'     => $quizID,
                               'question_id' => $questionID,
                               'status'      => 'active',
                               'sort_order'  => 0,
                               'created_by'  => $user->id,
                               'created_at'  => time()
                           ]);
                        }
                    }
                }
            }

            pre('Done');
        }
        //pre($this->getDirContents('New folder/store/'));


        $this->authorize('admin_questions_bank');

        removeContentLocale();

        $query = QuizzesQuestion::query();
        if(!auth()->user()->isAdminRole()){
            //$query = $query->where('creator_id', auth()->user()->id);
        }


        $query->where('quizzes_questions.question_status' , '!=' , 'Deleted');

        if (auth()->user()->isReviewer()) {
            $query->where('quizzes_questions.question_status' , '!=' , 'Draft');
            //$query->where('quizzes_questions.question_status', 'Submit for review');
        }

        if (auth()->user()->isAuthor()) {
            //$query->where('quizzes_questions.creator_id' , $user->id);
        }


        $totalQuestions = deepClone($query)->count();

        $in_review = clone $query;
        $approved = clone $query;
        $improvement = clone $query;
        $hold_reject = clone $query;

        $in_review->where('quizzes_questions.question_status' , 'Submit for review');
        $totalInReview = deepClone($in_review)->count();

        $approved->whereIn('quizzes_questions.question_status' , array('Offline' , 'Accepted' , 'Published'));
        $totalApproved = deepClone($approved)->count();

        $improvement->where('quizzes_questions.question_status' , 'Improvement required');
        $totalImprovement = deepClone($improvement)->count();

        $hold_reject->whereIn('quizzes_questions.question_status' , array('On hold' , 'Hard reject'));
        $totalHoldReject = deepClone($hold_reject)->count();

        $query = $this->filters($query , $request);


        $questions = $query->with([
            'course' ,
            'category' ,
            'subChapter' ,
        ])->select('*')->paginate(50);

        $foundRecords = deepClone($query)->count();


        $categories = Category::where('parent_id' , null)
            ->with('subCategories')
            ->get();

        $chapters_list = get_chapters_list();

        $data = [
            'pageTitle'           => 'Questions List' ,
            'questions'           => $questions ,
            'totalQuestions'      => $totalQuestions ,
            'totalInReview'       => $totalInReview ,
            'totalApproved'       => $totalApproved ,
            'totalImprovement'    => $totalImprovement ,
            'totalHoldReject'     => $totalHoldReject ,
            'foundRecords'        => $foundRecords ,
            'totalActiveQuizzes'  => 0 ,
            'totalStudents'       => 0 ,
            'categories'          => $categories ,
            'totalPassedStudents' => 0 ,
            'user'                => $user ,
        ];

        $data['chapters'] = $chapters_list;

        return view('admin.questions_bank.lists' , $data);
    }

    /*
     * Create Question
     */

    public function create()
    {
        $user = auth()->user();
        $this->authorize('admin_questions_bank_create');







        $quizQuestion = QuizzesQuestion::create([
            'quiz_id'                   => 0,
            'creator_id'                => $user->id,
            'grade'                     => '',
            'question_year'             => 0,
            'question_score'            => 0,
            'question_average_time'     => 0,
            'question_difficulty_level' => 'Emerging',
            'question_template_type'    => '',
            'chapter_id'                => 0,
            'question_title'            => '',
            'question_layout'           => '',
            'question_solve'            => '',
            'glossary_ids'              => '',
            'elements_data'             => '',
            'layout_elements'           => '',
            'category_id'               => 0,
            'course_id'                 => 0,
            'sub_chapter_id'            => 0,
            'type'                      => 'descriptive',
            'created_at'                => time(),
            'question_status'           => 'Draft',
            'comments_for_reviewer'     => '',
            'search_tags'               => '',
            'review_required'           => 0,
            'question_example'          => '',
            'question_type'             => '',
        ]);

        QuizzesQuestionTranslation::updateOrCreate([
            'quizzes_question_id' => $quizQuestion->id,
            'locale'              => 'en',
        ], [
            'title'   => 'DRAFT',
            'correct' => '',
        ]);
        return redirect()->route('adminEditQuestion' , ['id' => $quizQuestion->id]);
    }

    /*
     * Import Spells
     */
    public function import_spells()
    {
        $user = auth()->user();

        $audio_text = 'Translate texts & full document files instantly. Accurate translations for individuals and Teams. Millions translate with DeepL every day';
        $TextToSpeechController = new TextToSpeechController();
            $text_audio_path = $TextToSpeechController->getSpeechAudioFilePath($audio_text);
            pre($text_audio_path);

        //$excel = 'grade-5-uk-vocabulary/word-tious-and-ious.xlsx';
        //$other_slug = 'word-tious-and-ious';

        //$excel = 'grade-5-uk-vocabulary/words-silent-first-letters.xlsx';
        //$other_slug = 'words-silent-first-letters';

        //$excel = 'grade-5-uk-vocabulary/words-ough-makes-an-or-sound.xlsx';
        //$other_slug = 'words-ough-makes-an-or-sound';

        //$excel = 'grade-5-uk-vocabulary/words-near-homophones.xlsx';
        //$other_slug = 'words-near-homophones';

        $file_name = 'adverbs-synonymous-ending-in-ly';
        //$file_name = 'adverbs-synonymous-ending-in-ly';
        //$file_name = 'words-ending-in-er-or-and-ar';
        //$file_name = 'words-with-a-soft-c-spelled-ce';
        //$file_name = 'words-with-cial-shul-after-vowel';
        //$file_name = 'words-with-long-vowel';
        //$file_name = 'words-with-prefixes-dis-un-over-and-im';
        //$file_name = 'words-with-short-vowel';
        //$file_name = 'words-with-suffix-ably';
        //$file_name = 'words-with-suffixes-ent-and-ence';
        //$file_name = 'words-with-suffix-ful';
        //$file_name = 'words-with-suffix-ible';
        //$file_name = 'words-with-suffix-ibly';
        //$file_name = 'Words-with-the-f-sound-spelled-ph';
        //$file_name = 'words-with-the-prefix-over';
        //$file_name = 'words-with-tial-shul';
        //$file_name = 'words-with-unstressed-vowel-sounds';
        //$file_name = 'words-with-unstressed-vowel-sounds';
        $other_slug = $file_name;


        //Year 4
        $files_array = array(
            //'words-containing-phon-and-sign',
            //'words-containing-sol-and-real',
            //'words-ending-in-cian',
            //'words-ending-in-ious-and-eous',
            //'words-ending-in-lly',
            //'words-ending-in-ous',
            //'words-ending-in-ous-ge',
            //'words-ending-in-sion',
            //'words-ending-in-ssion',
            //'words-ending-in-tion',
            //'words-that-plurals-possessive-apostrophes',
            //'words-where-au-makes-an-or-sound',
            //'words-where-ch-makes-a-sh-sound',
            //'words-where-suffix-words-ending-in-y',
            //'words-with-c-before-i-and-e',
            //'words-with-prefix-bi-meaning-two',
            //'words-with-prefixes-il-im-and-ir',
            //'words-with-prefixes-super-anti-and-auto',
            //'words-with-prefix-in-meaning-not',
            //'words-with-prefix-inter-among',
            //'words-with-prefix-sub-meaning-below-or',
            //'words-with-suffix-ation',
            'words-with-suffix-ly',
        );

        //Year 3
        $files_array = array(
           //'words-ending-in-al',
           //'words-ending-in-gue-and-que',
           //'words-ending-in-le',
           //'words-ending-in-ly-exceptions',
           //'words-ending-in-sion',
           //'words-ending-in-ture',
           //'words-ending-ly-base-word-ends-in-ic',
           //'words-ending-ly-base-word-ends-le',
           //'words-ending-sure',
           //'words-ending-with-suffix-er',
           //'words-that-are-homophones',
           //'words-where-digraph-ey-makes-an-ai-sound',
           //'words-where-digraph-ou-makes-ow-sound',
           //'words-where-digraph-sc-makes-s-sound',
           //'words-where-ing-er-ed-added-multisyllabic-words',
           //'words-where-the-digraph-ch-makes-a-k-sound',
           //'words-where-y-makes-i-sound',
           //'words-with-digraph-ei-and-tetragraph-eigh',
           'words-with-the-prefix-dis',
           'words-with-the-prefix-mis',
           'words-with-the-prefix-re',
           'words-with-the-suffix-ly',
       );

        //Year 2
        $files_array = array(
           //'words-ending-in-al',
           //'words-ending-in-el',
           //'words-ending-in-ful-and-less',
           //'words-ending-in-il',
           //'words-ending-in-le',
           //'words-ending-in-ment-and-ness',
           //'words-ending-in-tion',
           //'words-that-are-homophones',
           //'words-that-are-near-homophones',
           //'words-where-a-makes-an-or-sound',
           //'words-where-c-makes-s-sound',
           //'words-where-dge-makes-j-sound',
           //'words-where-ed-added-to-single-syllable',
           //'words-where-ed-added-to-words-ending-y',
           //'words-where-er-and-est-are-added-words-ending-y',
           //'words-where-er-est-and-ed-words-ending-e',
           //'words-where-es-added-to-words-ending-y',
           //'words-where-ge-makes-j-sound',
           //'words-where-g-makes-j-sound',
           //'words-where-ing-added-single-syllable-words',
           //'words-where-ing-added-words-ending-e',
           //'words-where-kn-and-gn-make-n',
           //'words-where-o-makes-an-u-sound',
           //'words-where-si-and-s-make-zh-sound',
           //'words-where-the-er-and-or-sounds',
           //'words-where-wr-makes-r-sound',
           //'words-where-y-makes-igh-sound',
           'words-with-apostrophes-for-contraction',
           'words-with-apostrophes-for-possession',
        );

        $grade = 'Year 2';
        $spells_type = 'Spellbee';

        foreach( $files_array as $file_name){
            $excel = 'year2-spellbee/' . $file_name . '.xlsx';
            echo '<hr><br><br>';
            echo $file_name.'<br>';
            $other_slug = $file_name;

            $rows = Excel::toArray(null, $excel);
            $words_array = array();
            if (!empty($rows)) {
                foreach ($rows as $rowArray) {
                    if (!empty($rowArray)) {
                        foreach ($rowArray as $key => $rowData) {
                            if ($key == 0) {
                                continue;
                            }
                            $new_word = isset($rowData[0]) ? $rowData[0] : '';
                            if (isset($words_array[$new_word])) {
                                continue;
                            }
                            $words_array[$new_word] = $new_word;
                            $sentence = isset($rowData[2]) ? $rowData[2] : '';
                            $defination = isset($rowData[1]) ? $rowData[1] : '';
                            if ($new_word == '' || $sentence == '') {
                                continue;
                            }
                            $random_id = rand(1111, 9999);
                            $word_to_voice = $new_word . ' [P-1] as in [P-0.5] ' . $sentence;
                            //$audio_text = '<speak>'.$new_word.'<break time="1s"/> as in <prosody pitch="x-high">'.$sentence.'</prosody></speak>';
                            $audio_text = '<speak>' . $word_to_voice . '</speak>';
                            $audio_text = str_replace('[P-', '<break time="', $audio_text);
                            $audio_text = str_replace(']', 's"/>', $audio_text);
                            $first_character = substr($new_word, 0, 1);
                            $new_tag = 'letter ' . $first_character;
                            $new_title = $new_tag . '-' . $new_word . '-' . $other_slug . '-' . $spells_type . '-' . $grade . '-Audio Question';

                            $TextToSpeechController = new TextToSpeechController();
                            $text_audio_path = $TextToSpeechController->getSpeechAudioFilePath($audio_text);
                            $word_audio = '<speak>' . $new_word . '</speak>';
                            $audio_word_path = $TextToSpeechController->getSpeechAudioFilePath($word_audio);
                            $audio_path = $text_audio_path;
                            $question_layout = 'IjxzdHlsZT48L3N0eWxlPjxkaXYgaWQ9XCJsZWZvcm0tZWxlbWVudC0xXCIgY2xhc3M9XCJsZWZvcm0tZWxlbWVudC0xIGxlZm9ybS1lbGVtZW50IHF1aXotZ3JvdXAgbGVmb3JtLWVsZW1lbnQtaHRtbFwiIGRhdGEtdHlwZT1cInF1ZXN0aW9uX2xhYmVsXCI+PGRpdiBjbGFzcz1cInF1ZXN0aW9uLWxhYmVsXCI+PHNwYW4+TGlzdGVuIHRvIHRoZSBhdWRpbyBhbmQgd3JpdGUgdGhlIGNvcnJlY3Qgc3BlbGxpbmdzLjwvc3Bhbj48L2Rpdj48L2Rpdj48ZGl2IGlkPVwibGVmb3JtLWVsZW1lbnQtMFwiIGNsYXNzPVwibGVmb3JtLWVsZW1lbnQtMCBsZWZvcm0tZWxlbWVudCBxdWl6LWdyb3VwIGxlZm9ybS1lbGVtZW50LWh0bWxcIiBkYXRhLXR5cGU9XCJhdWRpb19maWxlXCI+PGF1ZGlvIGNvbnRyb2xzPVwiXCI+XG4gIDxzb3VyY2Ugc3JjPVwiL3NwZWVjaC1hdWRpby9wcm9wZXJ0aWVzLm1wM1wiIHR5cGU9XCJhdWRpby9vZ2dcIj5cbiAgPHNvdXJjZSBzcmM9XCIvc3BlZWNoLWF1ZGlvL3Byb3BlcnRpZXMubXAzXCIgdHlwZT1cImF1ZGlvL21wZWdcIj5cbllvdXIgYnJvd3NlciBkb2VzIG5vdCBzdXBwb3J0IHRoZSBhdWRpbyBlbGVtZW50LlxuPC9hdWRpbz48L2Rpdj48ZGl2IGlkPVwibGVmb3JtLWVsZW1lbnQtMlwiIGNsYXNzPVwibGVmb3JtLWVsZW1lbnQtMiBsZWZvcm0tZWxlbWVudCBxdWl6LWdyb3VwIGxlZm9ybS1lbGVtZW50LWh0bWxcIiBkYXRhLXR5cGU9XCJ0ZXh0ZmllbGRfcXVpelwiPjxzcGFuIGNsYXNzPVwiaW5wdXQtaG9sZGVyIGlucHV0X2JveFwiPjxpbnB1dCB0eXBlPVwidGV4dFwiIHBsYWNlaG9sZGVyPVwiXCIgY2xhc3M9XCJlZGl0b3ItZmllbGQgaW5wdXQtc2ltcGxlICBpbnB1dF9ib3hcIiBpZD1cImZpZWxkLTY2OTc0XCI+PC9zcGFuPjxkaXYgY2xhc3M9XCJsZWZvcm0tZWxlbWVudC1jb3ZlclwiPjwvZGl2PjwvZGl2PiI=';
                            $element_data = '{"":{"basic":"basic","content":"Listen to the audio and write the correct spellings.","elements_data":"W3t9XQ==","type":"question_label","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":0,"id":3},"66974":{"basic":"basic","placeholder":"","label_before":"","label_after":"","style_format":"input_box","text_format":"text","maxlength":"","correct_answer":"Properties","score":"5","elements_data":"W3t9XQ==","field_id":66974,"type":"textfield_quiz","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":2,"id":6}}';
                            $layout_elements = '[{"basic":"basic","audio_text":"Properties","audio_sentense":"Sentense goes here","audio_defination":"defination goes here","word_audio":"\/speech-audio\/properties_word.mp3","content":"\/speech-audio\/properties.mp3","elements_data":"W3t9XQ==","type":"audio_file","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":1,"id":2},{"basic":"basic","content":"Listen to the audio and write the correct spellings.","elements_data":"W3t9XQ==","type":"question_label","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":0,"id":3},{"basic":"basic","placeholder":"","label_before":"","label_after":"","style_format":"input_box","text_format":"text","maxlength":"","correct_answer":"Properties","score":"5","elements_data":"W3t9XQ==","field_id":66974,"type":"textfield_quiz","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":2,"id":6}]';

                            $element_data = str_replace('66974', $random_id, $element_data);
                            $element_data = str_replace('"correct_answer":"Properties"', '"correct_answer":"' . $new_word . '"', $element_data);

                            $layout_elements = str_replace('"correct_answer":"Properties"', '"correct_answer":"' . $new_word . '"', $layout_elements);
                            $layout_elements = str_replace('Properties', $new_word, $layout_elements);
                            $layout_elements = str_replace('properties.mp3', $audio_path, $layout_elements);
                            $layout_elements = str_replace('properties_word.mp3', $audio_word_path, $layout_elements);
                            $layout_elements = str_replace('66974', $random_id, $layout_elements);
                            $layout_elements = str_replace('Sentense goes here', $sentence, $layout_elements);
                            $layout_elements = str_replace('defination goes here', $defination, $layout_elements);


                            $question_layout = str_replace('66974', $random_id, $question_layout);
                            $question_layout = str_replace('properties.mp3', $audio_path, $question_layout);
                            $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));

                            $quizQuestion = QuizzesQuestion::create([
                                'quiz_id'                   => 0,
                                'creator_id'                => $user->id,
                                'grade'                     => '',
                                'question_year'             => 0,
                                'question_score'            => 5,
                                'question_average_time'     => 2,
                                'question_difficulty_level' => 'Below',
                                'question_template_type'    => 'sum_quiz',
                                //isset( $questionData['type'] )? $questionData['type'] : '',
                                'chapter_id'                => (isset($questionData['chapter_id']) && $questionData['chapter_id'] != '') ? $questionData['chapter_id'] : 0,
                                'question_title'            => $new_title,
                                'question_layout'           => $question_layout,
                                'question_solve'            => '<p>test</p>',
                                'glossary_ids'              => '["1"]',
                                'elements_data'             => $element_data,
                                'layout_elements'           => $layout_elements,
                                'category_id'               => 607,
                                'course_id'                 => 2066,
                                'sub_chapter_id'            => 0,
                                'type'                      => 'descriptive',
                                'created_at'                => time(),
                                'question_status'           => 'Submit for review',
                                'comments_for_reviewer'     => '',
                                'search_tags'               => $new_tag . ' | ' . $new_word . ' | ' . $grade . ' | ' . $spells_type . ' | ' . $other_slug,
                                'review_required'           => 0,
                                'question_example'          => '<p>test</p>',
                            ]);

                            QuizzesQuestionTranslation::updateOrCreate([
                                'quizzes_question_id' => $quizQuestion->id,
                                'locale'              => 'en',
                            ], [
                                'title'   => $new_title,
                                'correct' => '',
                            ]);
                            pre($quizQuestion->id, false);
                        }
                    }
                }
            }
        }



        pre('Completed!!!!');
    }

    public function import_true_false_spells_correct(){
        $query = QuizzesQuestion::query();
        $term_data = 'TRUEFALSE';
        $query->where('search_tags', 'like', '%'.$term_data.'%');

        $questions = $query->get();
        if( !empty( $questions ) ){
            foreach( $questions as $questionObj){

                $elements_data = json_decode($questionObj->elements_data);
                $keys = array_keys((array) $elements_data);
                $dynamic_id = $keys[0];
                $new_label = $elements_data->{'1'}->content;
                $question_layout = $questionObj->question_layout;
                $question_layout = $questionObj->question_layout;

                $question_layout = 'IjxzdHlsZT48L3N0eWxlPjxkaXYgaWQ9XCJsZWZvcm0tZWxlbWVudC0xXCIgY2xhc3M9XCJsZWZvcm0tZWxlbWVudC0xIGxlZm9ybS1lbGVtZW50IHF1aXotZ3JvdXAgbGVmb3JtLWVsZW1lbnQtaHRtbFwiIGRhdGEtdHlwZT1cInF1ZXN0aW9uX2xhYmVsXCI+PGRpdiBjbGFzcz1cInF1ZXN0aW9uLWxhYmVsXCI+PHNwYW4+VHJ1ZS9GYWxzZVE8L3NwYW4+PC9kaXY+PC9kaXY+PGRpdiBpZD1cImxlZm9ybS1lbGVtZW50LTBcIiBjbGFzcz1cImxlZm9ybS1lbGVtZW50LTAgbGVmb3JtLWVsZW1lbnQgcXVpei1ncm91cCBsZWZvcm0tZWxlbWVudC1odG1sXCIgZGF0YS10eXBlPVwidHJ1ZWZhbHNlX3F1aXpcIj48c3BhbiBjbGFzcz1cInRydWVmYWxzZV9xdWl6IGxlZm9ybS1pbnB1dCBsZWZvcm0tY3ItbGF5b3V0LXVuZGVmaW5lZCBsZWZvcm0tY3ItbGF5b3V0LXVuZGVmaW5lZFwiPlxuPGRpdiBjbGFzcz1cImZvcm0tYm94IHJ1cmVyYS1pbi1yb3cgdW5kZWZpbmVkIGltYWdlLXJpZ2h0IG5vbmVcIj5cbjxkaXYgY2xhc3M9XCJsbXMtcmFkaW8tc2VsZWN0IHJ1cmVyYS1pbi1yb3cgdW5kZWZpbmVkIGltYWdlLXJpZ2h0IG5vbmVcIj5cbjxkaXYgY2xhc3M9XCJmaWVsZC1ob2xkZXIgbGVmb3JtLWNyLWNvbnRhaW5lci1tZWRpdW0gbGVmb3JtLWNyLWNvbnRhaW5lci11bmRlZmluZWRcIj5cbjxpbnB1dCBjbGFzcz1cImVkaXRvci1maWVsZFwiIHR5cGU9XCJyYWRpb1wiIG5hbWU9XCJmaWVsZC0zNzM4MlwiIGlkPVwiZmllbGQtMzczODItMFwiIHZhbHVlPVwiVHJ1ZVwiPlxuPGxhYmVsIGZvcj1cImZpZWxkLTM3MzgyLTBcIj5UcnVlPC9sYWJlbD5cbjwvZGl2PlxuPGRpdiBjbGFzcz1cImZpZWxkLWhvbGRlciBsZWZvcm0tY3ItY29udGFpbmVyLW1lZGl1bSBsZWZvcm0tY3ItY29udGFpbmVyLXVuZGVmaW5lZFwiPlxuPGlucHV0IGNsYXNzPVwiZWRpdG9yLWZpZWxkXCIgdHlwZT1cInJhZGlvXCIgbmFtZT1cImZpZWxkLTM3MzgyXCIgaWQ9XCJmaWVsZC0zNzM4Mi0xXCIgdmFsdWU9XCJGYWxzZVwiPlxuPGxhYmVsIGZvcj1cImZpZWxkLTM3MzgyLTFcIj5GYWxzZTwvbGFiZWw+XG48L2Rpdj5cbjwvZGl2PlxuPC9kaXY+PC9zcGFuPjxkaXYgY2xhc3M9XCJsZWZvcm0tZWxlbWVudC1jb3ZlclwiPjwvZGl2PjwvZGl2PiI=';
                $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));


                $question_layout = '<div id="rureraform-element-1" class="rureraform-element-1 rureraform-element quiz-group rureraform-element-html" data-type="question_label"><div class="question-label"><span>'.$new_label.'</span></div></div>';
                $question_layout .= '<div id="rureraform-element-0" class="rureraform-element-0 rureraform-element quiz-group rureraform-element-html" data-type="truefalse_quiz"><span class="truefalse_quiz rureraform-input rureraform-cr-layout-undefined rureraform-cr-layout-undefined">
                <div class="form-box rurera-in-row undefined image-right none">
                <div class="lms-radio-select rurera-in-row undefined image-right none">
                <div class="field-holder rureraform-cr-container-medium rureraform-cr-container-undefined">
                <input class="editor-field" type="radio" name="field-37382" id="field-37382-0" value="True">
                <label for="field-37382-0">True</label>
                </div>
                <div class="field-holder rureraform-cr-container-medium rureraform-cr-container-undefined">
                <input class="editor-field" type="radio" name="field-37382" id="field-37382-1" value="False">
                <label for="field-37382-1">False</label>
                </div>
                </div>
                </div></span><div class="rureraform-element-cover"></div></div>';

                $question_layout = str_replace('37382', $dynamic_id, $question_layout);

                $question_layout = htmlentities(base64_encode(json_encode($question_layout)));

                $questionObj->update([
                    'question_layout' => $question_layout,
                ]);
                pre($questionObj->id, false);
            }
        }
        pre('Done');
    }

    /*
     * Import TRUE / FALSE Questions
     */
    public function import_true_false_questions()
    {
        $user = auth()->user();

        $difficulty_level = 'Emerging';
        $question_type = 'true_false';
        $quiz_id = 250;
        $example_question_id = 9012;
        $year_id = 616;
        $subject_id = 2082;
        $chapter_id = 195;
        $sub_chapter = 88;
        $exampleQuestionObj = QuizzesQuestion::find($example_question_id);
        $quizObj = Quiz::find($quiz_id);

        $import_date = '22-12-2023';

        $file_path = 'import/'.$import_date.'/true-false.xlsx';
        $required_options = "*True*False*Don't Know";

        $excelFile = Excel::toArray(null, $file_path);

        $excel_columns = array('Keywords','Type','Reference','Image','Label','Text-AL','Answer','Explanation');

        $questions_counter = 1;
        if( !empty( $excelFile ) ) {
            foreach ($excelFile as $sheetName => $sheetsArray) {
                if( !empty( $sheetsArray )){
                    foreach( $sheetsArray as $key => $sheetData){
                        if ($key == 0) {
                            continue;
                        }
                        if( !isset( $sheetData[0] ) || empty( $sheetData[0] ) || $sheetData[0] == '' ){
                            continue;
                        }
                        $random_id = rand(1111, 9999);

                        // Sheet Data

                        $sheet_image = isset( $sheetData[3] )? $sheetData[3] : '';

                        $correct_answer = isset( $sheetData[6] )? $sheetData[6] : '';
                        $correct_answer = ($correct_answer == 1)? 1 : 2;
                        $question_label = isset( $sheetData[4] )? $sheetData[4] : '';
                        $question_after_label = isset( $sheetData[5] )? $sheetData[5] : '';
                        $question_reference = isset( $sheetData[2] )? $sheetData[2] : '';
                        $keywords = str_replace(',', ' | ', $sheetData[0]);
                        $question_solve = isset( $sheetData[7] )? ucfirst($sheetData[7]) : '';
                        $question_reference = str_replace('[Text-AL]', $question_after_label, $question_reference);

                        $updated_array  = array(
                            'correct_answer' => $correct_answer,
                            'question_label' => $question_label,
                            'question_after_label' => $question_after_label,
                            'question_reference' => $question_reference,
                            'keywords' => $keywords,
                            'question_solve' => $question_solve,
                            'required_options' => $required_options,
                            'sheet_image' => $sheet_image,
                        );
                        $replace_keys = array();


                        $question_layout = $exampleQuestionObj->question_layout;
                        $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));

                        /*
                         * Elements Data Starts
                         */
                        $element_data = $exampleQuestionObj->elements_data;
                        $element_data_decoded = json_decode($element_data);
                        $element_data_decoded_new = $element_data_decoded;

                        if( !empty( $element_data_decoded ) ){
                            foreach( $element_data_decoded as $key => $element_data_value){
                                $prev_key = $key;
                                if( isset($element_data_value->field_id) ){
                                    $replace_keys[$key] = $random_id;
                                    $key = $random_id;
                                    $element_data_decoded_new = (array) $element_data_decoded_new;
                                    unset( $element_data_decoded_new[$prev_key]);
                                    $element_data_decoded_new = (object) $element_data_decoded_new;

                                }
                                $element_data_decoded_new->{$key} = $this->get_question_updated_element_data($element_data_value, $updated_array, $random_id, $question_type);
                            }
                        }
                        $element_data = json_encode($element_data_decoded_new);

                        /*
                         * Elements Data Ends
                         */

                        /*
                         * Layout Data Starts
                         */

                        $layout_elements = $exampleQuestionObj->layout_elements;
                        $layout_elements_decoded = json_decode($layout_elements);
                        $layout_data_decoded_new = $layout_elements_decoded;
                        if( !empty( $layout_elements_decoded ) ){
                            foreach( $layout_elements_decoded as $key => $layout_elements_value){

                                $prev_key = $key;
                                if( isset($layout_elements_value->field_id) ){
                                    //unset( $layout_data_decoded_new[$prev_key]);

                                }
                                $layout_data_decoded_new[$key] = $this->get_question_updated_layout_data($layout_elements_value, $updated_array, $random_id, $question_type);
                            }
                        }
                        $layout_elements = json_encode($layout_data_decoded_new);

                        /*
                        * Layout Data Ends
                        */

                        $question_layout = $this->get_question_updated_layout($question_layout, $replace_keys, $updated_array, $random_id, $question_type);

                        $question_layout = htmlentities(base64_encode(json_encode($question_layout)));

                        $quizQuestion = QuizzesQuestion::create([
                            'quiz_id'                   => 0,
                            'creator_id'                => $user->id,
                            'grade'                     => '',
                            'question_year'             => 0,
                            'question_score'            => 1,
                            'question_average_time'     => 2,
                            'question_difficulty_level' => $difficulty_level,
                            'question_template_type'    => 'sum_quiz',
                            'chapter_id'                => $chapter_id,
                            'question_title'            => $question_reference,
                            'question_layout'           => $question_layout,
                            'question_solve'            => $question_solve,
                            'glossary_ids'              => '',
                            'elements_data'             => $element_data,
                            'layout_elements'           => $layout_elements,
                            'category_id'               => $year_id,
                            'course_id'                 => $subject_id,
                            'sub_chapter_id'            => $sub_chapter,
                            'type'                      => 'descriptive',
                            'created_at'                => time(),
                            'question_status'           => 'Submit for review',
                            'comments_for_reviewer'     => '',
                            'search_tags'               => $keywords,
                            'review_required'           => 0,
                            'question_example'          => '<p>test</p>',
                            'question_type'             => $question_type,
                        ]);

                        QuizzesQuestionTranslation::updateOrCreate([
                            'quizzes_question_id' => $quizQuestion->id,
                            'locale'              => 'en',
                        ], [
                            'title'   => $question_reference,
                            'correct' => '',
                        ]);

                        QuizzesQuestionsList::create([
                            'quiz_id'     => $quizObj->id,
                            'question_id' => $quizQuestion->id,
                            'status'      => 'active',
                            'sort_order'  => 0,
                            'created_by'  => $user->id,
                            'created_at'  => time()
                        ]);
                        //pre($quizQuestion->id);
                        pre($questions_counter.') '.$quizQuestion->id, false);
                        $questions_counter++;
                    }
                }
            }
        }


        pre($file_path, false);

        pre('Completed!!!!');
    }


    /*
     * Import MCQs Single Response Questions
     */
    public function import_single_response_questions()
    {
        $user = auth()->user();
        $this->replace_able_text    = array();

        $difficulty_level = 'Expected';
        $question_type = 'single_select';
        $quiz_id = 250;
        $example_question_id = 9213;
        $year_id = 616;
        $subject_id = 2082;
        $chapter_id = 195;
        $sub_chapter = 88;
        $exampleQuestionObj = QuizzesQuestion::find($example_question_id);
        $quizObj = Quiz::find($quiz_id);

        $import_date = '22-12-2023';

        $file_path = 'import/'.$import_date.'/single-response.xlsx';
        $required_options = "*True*False*Don't Know";

        $excelFile = Excel::toArray(null, $file_path);

        $excel_columns = array('Keywords','Type','Reference','Image','Label','Text-BL','options','Answer','Explanation');

        $questions_counter = 1;
        if( !empty( $excelFile ) ) {
            foreach ($excelFile as $sheetName => $sheetsArray) {
                if( !empty( $sheetsArray )){
                    foreach( $sheetsArray as $key => $sheetData){
                        if ($key == 0) {
                            continue;
                        }
                        if( !isset( $sheetData[0] ) || empty( $sheetData[0] ) || $sheetData[0] == '' ){
                            continue;
                        }
                        $this->replace_able_text    = array();
                        $random_id = rand(1111, 9999);

                        // Sheet Data

                        $keywords = str_replace(',', ' | ', $sheetData[0]);
                        $question_reference = isset( $sheetData[2] )? $sheetData[2] : '';
                        $sheet_image = isset( $sheetData[3] )? $sheetData[3] : '';
                        $question_label = isset( $sheetData[4] )? $sheetData[4] : '';
                        $question_before_label = isset( $sheetData[5] )? $sheetData[5] : '';
                        $required_options = isset( $sheetData[6] )? $sheetData[6] : '';
                        $correct_answer = isset( $sheetData[7] )? $sheetData[7] : '';
                        $correct_answer = ($correct_answer == 1)? 1 : 2;
                        $question_solve = isset( $sheetData[8] )? ucfirst($sheetData[8]) : '';


                        $question_reference = str_replace('[Text-BL]', $question_before_label, $question_reference);

                        $updated_array  = array(
                            'correct_answer' => $correct_answer,
                            'question_label' => $question_label,
                            'question_before_label' => $question_before_label,
                            'question_reference' => $question_reference,
                            'keywords' => $keywords,
                            'question_solve' => $question_solve,
                            'required_options' => $required_options,
                            'sheet_image' => $sheet_image,
                        );
                        $replace_keys = array();


                        $question_layout = $exampleQuestionObj->question_layout;
                        $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));

                        /*
                         * Elements Data Starts
                         */
                        $element_data = $exampleQuestionObj->elements_data;
                        $element_data_decoded = json_decode($element_data);
                        $element_data_decoded_new = $element_data_decoded;

                        if( !empty( $element_data_decoded ) ){
                            foreach( $element_data_decoded as $key => $element_data_value){
                                $prev_key = $key;
                                if( isset($element_data_value->field_id) ){
                                    $replace_keys[$key] = $random_id;
                                    $key = $random_id;
                                    $element_data_decoded_new = (array) $element_data_decoded_new;
                                    unset( $element_data_decoded_new[$prev_key]);
                                    $element_data_decoded_new = (object) $element_data_decoded_new;

                                }
                                $element_data_decoded_new->{$key} = $this->get_question_updated_element_data($element_data_value, $updated_array, $random_id, $question_type);
                            }
                        }
                        //pre($element_data_decoded_new);
                        $element_data = json_encode($element_data_decoded_new);

                        /*
                         * Elements Data Ends
                         */

                        /*
                         * Layout Data Starts
                         */

                        $layout_elements = $exampleQuestionObj->layout_elements;
                        $layout_elements_decoded = json_decode($layout_elements);
                        $layout_data_decoded_new = $layout_elements_decoded;
                        if( !empty( $layout_elements_decoded ) ){
                            foreach( $layout_elements_decoded as $key => $layout_elements_value){

                                $prev_key = $key;
                                if( isset($layout_elements_value->field_id) ){
                                    //unset( $layout_data_decoded_new[$prev_key]);

                                }
                                $layout_data_decoded_new[$key] = $this->get_question_updated_layout_data($layout_elements_value, $updated_array, $random_id, $question_type);
                            }
                        }
                        $layout_elements = json_encode($layout_data_decoded_new);

                        /*
                        * Layout Data Ends
                        */

                        $question_layout = $this->get_question_updated_layout($question_layout, $replace_keys, $updated_array, $random_id, $question_type);


                        $question_layout = htmlentities(base64_encode(json_encode($question_layout)));


                        $quizQuestion = QuizzesQuestion::create([
                            'quiz_id'                   => 0,
                            'creator_id'                => $user->id,
                            'grade'                     => '',
                            'question_year'             => 0,
                            'question_score'            => 1,
                            'question_average_time'     => 2,
                            'question_difficulty_level' => $difficulty_level,
                            'question_template_type'    => 'sum_quiz',
                            'chapter_id'                => $chapter_id,
                            'question_title'            => $question_reference,
                            'question_layout'           => $question_layout,
                            'question_solve'            => $question_solve,
                            'glossary_ids'              => '',
                            'elements_data'             => $element_data,
                            'layout_elements'           => $layout_elements,
                            'category_id'               => $year_id,
                            'course_id'                 => $subject_id,
                            'sub_chapter_id'            => $sub_chapter,
                            'type'                      => 'descriptive',
                            'created_at'                => time(),
                            'question_status'           => 'Submit for review',
                            'comments_for_reviewer'     => '',
                            'search_tags'               => $keywords,
                            'review_required'           => 0,
                            'question_example'          => '<p>test</p>',
                            'question_type'             => $question_type,
                        ]);

                        QuizzesQuestionTranslation::updateOrCreate([
                            'quizzes_question_id' => $quizQuestion->id,
                            'locale'              => 'en',
                        ], [
                            'title'   => $question_reference,
                            'correct' => '',
                        ]);

                        QuizzesQuestionsList::create([
                            'quiz_id'     => $quizObj->id,
                            'question_id' => $quizQuestion->id,
                            'status'      => 'active',
                            'sort_order'  => 0,
                            'created_by'  => $user->id,
                            'created_at'  => time()
                        ]);
                        //pre($quizQuestion->id);
                        pre($questions_counter.') '.$quizQuestion->id, false);
                        $questions_counter++;
                    }
                }
            }
        }


        pre($file_path, false);

        pre('Completed!!!!');
    }

    /*
     * Import dropdown  Questions
     */
    public function import_text_dropdown_questions()
    {
        $user = auth()->user();
        $this->replace_able_text    = array();

        $difficulty_level = 'Emerging';
        $question_type = 'dropdown';
        $quiz_id = 250;
        $example_question_id = 8614;
        $year_id = 616;
        $subject_id = 2082;
        $chapter_id = 195;
        $sub_chapter = 88;
        $exampleQuestionObj = QuizzesQuestion::find($example_question_id);
        $quizObj = Quiz::find($quiz_id);

        $import_date = '22-12-2023';

        $file_path = 'import/'.$import_date.'/drop-down.xlsx';
        $required_options = "*True*False*Don't Know";

        $excelFile = Excel::toArray(null, $file_path);

        $excel_columns = array('Keywords','Type','Reference','Image','Label','Text-AL','Answer','Explanation');

        $questions_counter = 1;
        if( !empty( $excelFile ) ) {
            foreach ($excelFile as $sheetName => $sheetsArray) {
                if( !empty( $sheetsArray )){
                    foreach( $sheetsArray as $key => $sheetData){
                        if ($key == 0) {
                            continue;
                        }
                        if( !isset( $sheetData[0] ) || empty( $sheetData[0] ) || $sheetData[0] == '' ){
                            continue;
                        }
                        $this->replace_able_text    = array();
                        $random_id = rand(1111, 9999);

                        // Sheet Data

                        $keywords = str_replace(',', ' | ', $sheetData[0]);
                        $question_reference = isset( $sheetData[2] )? $sheetData[2] : '';
                        $sheet_image = isset( $sheetData[3] )? $sheetData[3] : '';
                        $question_label = isset( $sheetData[4] )? $sheetData[4] : '';
                        $question_after_label = isset( $sheetData[5] )? $sheetData[5] : '';
                        $correct_answer = isset( $sheetData[6] )? $sheetData[6] : '';
                        $question_solve = isset( $sheetData[7] )? ucfirst($sheetData[7]) : '';


                        $question_reference = str_replace('[Text-AL]', $question_after_label, $question_reference);
                        $question_reference = str_replace('[Blank]', '', $question_reference);

                        $updated_array  = array(
                            'correct_answer' => $correct_answer,
                            'question_label' => $question_label,
                            'question_after_label' => $question_after_label,
                            'question_reference' => $question_reference,
                            'keywords' => $keywords,
                            'question_solve' => $question_solve,
                            'sheet_image' => $sheet_image,
                        );
                        $replace_keys = array();


                        $question_layout = $exampleQuestionObj->question_layout;
                        $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));

                        /*
                         * Elements Data Starts
                         */
                        $element_data = $exampleQuestionObj->elements_data;
                        $element_data_decoded = json_decode($element_data);
                        $element_data_decoded_new = $element_data_decoded;

                        if( !empty( $element_data_decoded ) ){
                            foreach( $element_data_decoded as $key => $element_data_value){
                                $prev_key = $key;
                                if( isset($element_data_value->field_id) || isset( $element_data_value->{'data-id'}) ){
                                    $replace_keys[$key] = $random_id;
                                    $key = $random_id;
                                    $element_data_decoded_new = (array) $element_data_decoded_new;
                                    unset( $element_data_decoded_new[$prev_key]);
                                    $element_data_decoded_new = (object) $element_data_decoded_new;

                                }
                                $element_data_decoded_new->{$key} = $this->get_question_updated_element_data($element_data_value, $updated_array, $random_id, $question_type);
                            }
                        }


                        //pre(json_decode($element_data));
                        $element_data = json_encode($element_data_decoded_new);

                        /*
                         * Elements Data Ends
                         */

                        /*
                         * Layout Data Starts
                         */

                        $layout_elements = $exampleQuestionObj->layout_elements;
                        $layout_elements_decoded = json_decode($layout_elements);
                        $layout_data_decoded_new = $layout_elements_decoded;
                        if( !empty( $layout_elements_decoded ) ){
                            foreach( $layout_elements_decoded as $key => $layout_elements_value){

                                $prev_key = $key;
                                if( isset($layout_elements_value->field_id) ){
                                    //unset( $layout_data_decoded_new[$prev_key]);

                                }
                                $layout_data_decoded_new[$key] = $this->get_question_updated_layout_data($layout_elements_value, $updated_array, $random_id, $question_type);
                            }
                        }
                        $layout_elements = json_encode($layout_data_decoded_new);

                        /*
                        * Layout Data Ends
                        */

                        $question_layout = $this->get_question_updated_layout($question_layout, $replace_keys, $updated_array, $random_id, $question_type);
                        //pre($layout_elements, false);


                        $question_layout = htmlentities(base64_encode(json_encode($question_layout)));


                        $quizQuestion = QuizzesQuestion::create([
                            'quiz_id'                   => 0,
                            'creator_id'                => $user->id,
                            'grade'                     => '',
                            'question_year'             => 0,
                            'question_score'            => 1,
                            'question_average_time'     => 2,
                            'question_difficulty_level' => $difficulty_level,
                            'question_template_type'    => 'sum_quiz',
                            'chapter_id'                => $chapter_id,
                            'question_title'            => $question_reference,
                            'question_layout'           => $question_layout,
                            'question_solve'            => $question_solve,
                            'glossary_ids'              => '',
                            'elements_data'             => $element_data,
                            'layout_elements'           => $layout_elements,
                            'category_id'               => $year_id,
                            'course_id'                 => $subject_id,
                            'sub_chapter_id'            => $sub_chapter,
                            'type'                      => 'descriptive',
                            'created_at'                => time(),
                            'question_status'           => 'Submit for review',
                            'comments_for_reviewer'     => '',
                            'search_tags'               => $keywords,
                            'review_required'           => 0,
                            'question_example'          => '<p>test</p>',
                            'question_type'             => $question_type,
                        ]);

                        QuizzesQuestionTranslation::updateOrCreate([
                            'quizzes_question_id' => $quizQuestion->id,
                            'locale'              => 'en',
                        ], [
                            'title'   => $question_reference,
                            'correct' => '',
                        ]);

                        QuizzesQuestionsList::create([
                            'quiz_id'     => $quizObj->id,
                            'question_id' => $quizQuestion->id,
                            'status'      => 'active',
                            'sort_order'  => 0,
                            'created_by'  => $user->id,
                            'created_at'  => time()
                        ]);
                        //pre($quizQuestion->id);
                        pre($questions_counter.') '.$quizQuestion->id, false);
                        $questions_counter++;
                    }
                }
            }
        }


        pre($file_path, false);

        pre('Completed!!!!');
    }

    /*
     * Import dropdown  Questions
     */
    public function import_text_blank_questions()
    {
        $user = auth()->user();
        $this->replace_able_text    = array();

        $difficulty_level = 'Exceeding';
        $question_type = 'text_field';
        $quiz_id = 250;
        $example_question_id = 9254;
        $year_id = 616;
        $subject_id = 2082;
        $chapter_id = 195;
        $sub_chapter = 88;
        $exampleQuestionObj = QuizzesQuestion::find($example_question_id);
        $quizObj = Quiz::find($quiz_id);

        $import_date = '22-12-2023';

        $file_path = 'import/'.$import_date.'/fill-in the-blank.xlsx';
        $required_options = "*True*False*Don't Know";

        $excelFile = Excel::toArray(null, $file_path);

        $excel_columns = array('Keywords','Type','Reference','Image','Label','Text-AL','Answer','Explanation');

        $questions_counter = 1;
        if( !empty( $excelFile ) ) {
            foreach ($excelFile as $sheetName => $sheetsArray) {
                if( !empty( $sheetsArray )){
                    foreach( $sheetsArray as $key => $sheetData){
                        if ($key == 0) {
                            continue;
                        }
                        if( !isset( $sheetData[0] ) || empty( $sheetData[0] ) || $sheetData[0] == '' ){
                            continue;
                        }
                        $this->replace_able_text    = array();
                        $random_id = rand(1111, 9999);

                        // Sheet Data

                        $keywords = str_replace(',', ' | ', $sheetData[0]);
                        $question_reference = isset( $sheetData[2] )? $sheetData[2] : '';
                        $sheet_image = isset( $sheetData[3] )? $sheetData[3] : '';
                        $question_label = isset( $sheetData[4] )? $sheetData[4] : '';
                        $question_after_label = isset( $sheetData[5] )? $sheetData[5] : '';
                        $correct_answer = isset( $sheetData[6] )? $sheetData[6] : '';
                        $question_solve = isset( $sheetData[7] )? ucfirst($sheetData[7]) : '';


                        $question_reference = str_replace('[Text-AL]', $question_after_label, $question_reference);
                        $question_reference = str_replace('[Blank]', '', $question_reference);

                        $updated_array  = array(
                            'correct_answer' => $correct_answer,
                            'question_label' => $question_label,
                            'question_after_label' => $question_after_label,
                            'question_reference' => $question_reference,
                            'keywords' => $keywords,
                            'question_solve' => $question_solve,
                            'sheet_image' => $sheet_image,
                        );
                        $replace_keys = array();


                        $question_layout = $exampleQuestionObj->question_layout;
                        $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));

                        /*
                         * Elements Data Starts
                         */
                        $element_data = $exampleQuestionObj->elements_data;
                        $element_data_decoded = json_decode($element_data);
                        $element_data_decoded_new = $element_data_decoded;

                        if( !empty( $element_data_decoded ) ){
                            foreach( $element_data_decoded as $key => $element_data_value){
                                $prev_key = $key;
                                if( isset($element_data_value->field_id) || isset( $element_data_value->{'data-id'}) ){
                                    $replace_keys[$key] = $random_id;
                                    $key = $random_id;
                                    $element_data_decoded_new = (array) $element_data_decoded_new;
                                    unset( $element_data_decoded_new[$prev_key]);
                                    $element_data_decoded_new = (object) $element_data_decoded_new;

                                }
                                $element_data_decoded_new->{$key} = $this->get_question_updated_element_data($element_data_value, $updated_array, $random_id, $question_type);
                            }
                        }
                        $element_data = json_encode($element_data_decoded_new);

                        /*
                         * Elements Data Ends
                         */

                        /*
                         * Layout Data Starts
                         */

                        $layout_elements = $exampleQuestionObj->layout_elements;
                        $layout_elements_decoded = json_decode($layout_elements);
                        $layout_data_decoded_new = $layout_elements_decoded;
                        if( !empty( $layout_elements_decoded ) ){
                            foreach( $layout_elements_decoded as $key => $layout_elements_value){

                                $prev_key = $key;
                                if( isset($layout_elements_value->field_id) ){
                                    //unset( $layout_data_decoded_new[$prev_key]);

                                }
                                $layout_data_decoded_new[$key] = $this->get_question_updated_layout_data($layout_elements_value, $updated_array, $random_id, $question_type);
                            }
                        }
                        $layout_elements = json_encode($layout_data_decoded_new);

                        /*
                        * Layout Data Ends
                        */

                        $question_layout = $this->get_question_updated_layout($question_layout, $replace_keys, $updated_array, $random_id, $question_type);
                        //pre($layout_elements, false);


                        $question_layout = htmlentities(base64_encode(json_encode($question_layout)));

                        $quizQuestion = QuizzesQuestion::create([
                            'quiz_id'                   => 0,
                            'creator_id'                => $user->id,
                            'grade'                     => '',
                            'question_year'             => 0,
                            'question_score'            => 1,
                            'question_average_time'     => 2,
                            'question_difficulty_level' => $difficulty_level,
                            'question_template_type'    => 'sum_quiz',
                            'chapter_id'                => $chapter_id,
                            'question_title'            => $question_reference,
                            'question_layout'           => $question_layout,
                            'question_solve'            => $question_solve,
                            'glossary_ids'              => '',
                            'elements_data'             => $element_data,
                            'layout_elements'           => $layout_elements,
                            'category_id'               => $year_id,
                            'course_id'                 => $subject_id,
                            'sub_chapter_id'            => $sub_chapter,
                            'type'                      => 'descriptive',
                            'created_at'                => time(),
                            'question_status'           => 'Submit for review',
                            'comments_for_reviewer'     => '',
                            'search_tags'               => $keywords,
                            'review_required'           => 0,
                            'question_example'          => '<p>test</p>',
                            'question_type'             => $question_type,
                        ]);

                        QuizzesQuestionTranslation::updateOrCreate([
                            'quizzes_question_id' => $quizQuestion->id,
                            'locale'              => 'en',
                        ], [
                            'title'   => $question_reference,
                            'correct' => '',
                        ]);

                        QuizzesQuestionsList::create([
                            'quiz_id'     => $quizObj->id,
                            'question_id' => $quizQuestion->id,
                            'status'      => 'active',
                            'sort_order'  => 0,
                            'created_by'  => $user->id,
                            'created_at'  => time()
                        ]);
                        pre($questions_counter.') '.$quizQuestion->id, false);
                        $questions_counter++;
                    }
                }
            }
        }


        pre($file_path, false);

        pre('Completed!!!!');
    }

    public function get_question_updated_element_data($element_data_value, $updated_array, $random_id, $question_type = ''){
        $current_type = isset( $element_data_value->type )? $element_data_value->type : '';
        $field_id = isset( $element_data_value->field_id )? $element_data_value->field_id : '';
        $current_options = isset( $element_data_value->options )? $element_data_value->options : array();
        $template_style = isset( $element_data_value->template_style )? $element_data_value->template_style : '';
        $required_options = isset( $updated_array['required_options'] )? explode('*', $updated_array['required_options']) : array();
        $required_image = isset( $updated_array['sheet_image'] )? $updated_array['sheet_image'] : '';
        $correct_answer = isset( $updated_array['correct_answer'] )? $updated_array['correct_answer'] : '';

        $current_array = $element_data_value;
        $current_encoded_string = json_encode($current_array);
        $new_encoded_string = str_replace('PH-Text-AL', isset( $updated_array['question_after_label'])? $updated_array['question_after_label'] : '', $current_encoded_string);
        $new_encoded_string = str_replace('PH-Label', isset( $updated_array['question_label'])? $updated_array['question_label'] : '', $current_encoded_string);
        $new_encoded_string = str_replace('PH-Text-BL', isset( $updated_array['question_before_label'])? $updated_array['question_before_label'] : '', $current_encoded_string);


        $element_data_value_new = json_decode($new_encoded_string);

        if( isset($element_data_value->field_id) ){
            $element_data_value_new->field_id = $random_id;
        }



        if( $current_type == 'radio'){
            $long_text = false;
            $new_options = array();
            if( !empty($required_options )){
                $option_count = 1;

                foreach( $required_options as $option_value){
                    if( $option_value == ''){ continue; }

                    if( strlen($option_value) > 13){
                        $long_text = true;
                        $this->replace_able_text['rurera-in-row'] = 'rurera-in-cols';
                    }
                    $new_options[]  = (object) array(
                        'default' => ($option_count == $correct_answer)? 'on' : 'off',
                        'label' => $option_value,
                        'value' => $option_value,
                        'image' => $required_image,
                    );

                    $option_count++;
                }
            }
            $element_data_value_new->options = $new_options;

            if( $long_text == true){
               $element_data_value_new->template_style = 'rurera-in-cols';
            }
        }

        if( $current_type == 'html'){

            if( $question_type == 'dropdown'){

                $previous_dropdown_response = '<select class="editor-field small" data-id="46747" data-options="WyJvcHRpb24xIiwib3B0aW9uMiIsIm9wdGlvbjMiXQ==" data-field_type="select" id="field-46747" data-correct="WyJvcHRpb24yIl0=" data-field_size="small" data-select_option="option2" data-score="1" score="1"><option value="option1">option1</option><option value="option2">option2</option><option value="option3">option3</option></select>';
                //$previous_dropdown_response = '<select class="editor-field" data-id="6323" data-options="WyJvcHRpb24xIiwib3B0aW9uMiIsIm9wdGlvbjMiXQ==" data-field_type="select" id="field-6323" data-correct="WyJvcHRpb24yIl0=" data-select_option="option3"><option value="option1">option1</option></select>';
                $question_after_label = isset( $updated_array['question_after_label'] ) ? $updated_array['question_after_label'] : '';
                $explode_content = explode('[', $question_after_label);
                $question_before_text = isset( $explode_content[0] )? $explode_content[0] : '';
                $dropdown_options = explode(']', $explode_content[1]);
                $question_after_text = isset( $dropdown_options[1] )? $dropdown_options[1] : '';
                $dropdown_options = isset( $dropdown_options[0] )? explode('/', $dropdown_options[0]) : array();

                $dropdown_response = '';
                $correct_answer_array = array($correct_answer);
                if( !empty( $dropdown_options ) ){
                    $dropdown_response .= '<option value="">Select Option</option>';
                    foreach( $dropdown_options as $dropdown_item){
                        $dropdown_response .= '<option value="'.$dropdown_item.'">'.$dropdown_item.'</option>';
                    }
                }
                $dropdown_options_str = htmlentities(base64_encode(json_encode($dropdown_options)));
                $correct_answer_str = htmlentities(base64_encode(json_encode($correct_answer_array)));

                $updated_dropdown_response = str_replace($previous_dropdown_response,'<select class="editor-field" data-id="'.$random_id.'" data-options="'.$dropdown_options_str.'" data-field_type="select" id="field-'.$random_id.'" data-correct="'.$correct_answer_str.'" data-select_option="'.$correct_answer.'">'.$dropdown_response.'</select>', $previous_dropdown_response);
                $updated_dropdown_response = $question_before_text.' '.$updated_dropdown_response.' '.$question_after_text;

                $element_data_value_new->content = $updated_dropdown_response;
            }

            if( $question_type == 'text_field'){

                $previous_text_response = '<span class="input-holder input_line"><span class="input-label" contenteditable="false"></span><input type="text" class="editor-field input-simple medium input_line" id="field-68450" size="" score="1" placeholder=""> </span>';
                $question_after_label = isset( $updated_array['question_after_label'] ) ? $updated_array['question_after_label'] : '';
                $explode_content = explode('[Blank]', $question_after_label);
                $question_before_text = isset( $explode_content[0] )? $explode_content[0] : '';
                $question_after_text = isset( $explode_content[1] )? $explode_content[1] : '';

                $updated_text_response = str_replace($previous_text_response,'<span class="input-holder input_line"><span class="input-label left" contenteditable="false"></span><input data-field_type="text" class="editor-field input-simple input_line medium" data-id="'.$random_id.'" id="field-'.$random_id.'" data-score="1" score="1" data-placeholder="" placeholder="" data-label="" data-label_position="left" data-size="" size="" data-style_field="input_line" data-field_size="medium" data-type="text" type="text" data-correct_answere="'.$correct_answer.'" correct_answere="'.$correct_answer.'"> </span>', $previous_text_response);
                $updated_text_response = $question_before_text.' '.$updated_text_response.' '.$question_after_text;

                $element_data_value_new->content = $updated_text_response;
            }



            $new_options = array();
            if( !empty($required_options )){
                $option_count = 1;

                foreach( $required_options as $option_value){
                    if( $option_value == ''){ continue; }
                    $new_options[]  = (object) array(
                        'default' => ($option_count == $correct_answer)? 'on' : 'off',
                        'label' => $option_value,
                        'value' => $option_value,
                        'image' => $required_image,
                    );

                    $option_count++;
                }
            }
            $element_data_value_new->options = $new_options;

        }
        if( $question_type == 'dropdown'){
            if( isset( $element_data_value_new->{'data-field_type'} ) && $element_data_value_new->{'data-field_type'} == 'select'){
                $question_after_label = isset( $updated_array['question_after_label'] ) ? $updated_array['question_after_label'] : '';
                $explode_content = explode('[', $question_after_label);
                $question_before_text = isset( $explode_content[0] )? $explode_content[0] : '';
                $dropdown_options = explode(']', $explode_content[1]);
                $question_after_text = isset( $dropdown_options[1] )? $dropdown_options[1] : '';
                $dropdown_options = isset( $dropdown_options[0] )? explode('/', $dropdown_options[0]) : array();

                $dropdown_response = '';
                $correct_answer_array = array($correct_answer);
                if( !empty( $dropdown_options ) ){
                    $dropdown_response .= '<option value="">Select Option</option>';
                    foreach( $dropdown_options as $dropdown_item){
                        $dropdown_response .= '<option value="'.$dropdown_item.'">'.$dropdown_item.'</option>';
                    }
                }
                $dropdown_options_str = htmlentities(base64_encode(json_encode($dropdown_options)));
                $correct_answer_str = htmlentities(base64_encode(json_encode($correct_answer_array)));

                $element_data_value_new->{'data-options'} = $dropdown_options_str;
                $element_data_value_new->{'data-correct'} = $correct_answer_str;//json_encode($correct_answer_array);
                $element_data_value_new->{'data-select_option'} = $correct_answer;//json_encode($correct_answer_array);
                $element_data_value_new->{'data-id'} = $random_id;
                $element_data_value_new->{'id'} = 'field-'.$random_id;
                //$options_temp = html_entity_decode(base64_decode(trim(stripslashes($options))));
            }
        }
        if( $question_type == 'text_field'){
            if( isset( $element_data_value_new->{'data-field_type'} ) && $element_data_value_new->{'data-field_type'} == 'text'){

                $element_data_value_new->{'data-correct_answere'} = $correct_answer;
                $element_data_value_new->{'correct_answere'} = $correct_answer;
                $element_data_value_new->{'data-id'} = $random_id;
                $element_data_value_new->{'id'} = 'field-'.$random_id;
            }
        }

        //pre($element_data_value_new);

        return $element_data_value_new;
    }

    public function get_question_updated_layout_data($element_data_value, $updated_array, $random_id, $question_type = ''){
        $current_type = isset( $element_data_value->type )? $element_data_value->type : '';
        $field_id = isset( $element_data_value->field_id )? $element_data_value->field_id : '';
        $current_options = isset( $element_data_value->options )? $element_data_value->options : array();
        $required_options = isset( $updated_array['required_options'] )? explode('*', $updated_array['required_options']) : array();
        $required_image = isset( $updated_array['sheet_image'] )? $updated_array['sheet_image'] : '';
        $correct_answer = isset( $updated_array['correct_answer'] )? $updated_array['correct_answer'] : '';

        $current_array = $element_data_value;
        $current_encoded_string = json_encode($current_array);
        $new_encoded_string = str_replace('PH-Text-AL', isset( $updated_array['question_after_label'])? $updated_array['question_after_label'] : '', $current_encoded_string);
        $new_encoded_string = str_replace('PH-Label', isset( $updated_array['question_label'])? $updated_array['question_label'] : '', $new_encoded_string);
        $new_encoded_string = str_replace('PH-Text-BL', isset( $updated_array['question_before_label'])? $updated_array['question_before_label'] : '', $new_encoded_string);
        $element_data_value_new = json_decode($new_encoded_string);

        if( isset($element_data_value->field_id) ){
            $element_data_value_new->field_id = $random_id;
        }



        if( $current_type == 'radio'){
            $long_text = false;
            $new_options = array();
            if( !empty($required_options )){
                $option_count = 1;
                foreach( $required_options as $option_value){
                    if( $option_value == ''){ continue; }

                    if( strlen($option_value) > 13){
                        $long_text = true;
                        $this->replace_able_text['rurera-in-row'] = 'rurera-in-cols';
                    }

                    $new_options[]  = (object) array(
                        'default' => ($option_count == $correct_answer)? 'on' : 'off',
                        'label' => $option_value,
                        'value' => $option_value,
                        'image' => $required_image,
                    );

                    $option_count++;
                }
            }
            $element_data_value_new->options = $new_options;
            if( $long_text == true){
               $element_data_value_new->template_style = 'rurera-in-cols';
            }

        }


        if( $current_type == 'html'){

            if( $question_type == 'dropdown'){

                //$previous_dropdown_response = '<select class="editor-field" data-id="6323" data-options="WyJvcHRpb24xIiwib3B0aW9uMiIsIm9wdGlvbjMiXQ==" data-field_type="select" id="field-6323" data-correct="WyJvcHRpb24yIl0=" data-select_option="option3"><option value="option1">option1</option></select>';
                $previous_dropdown_response = '<select class="editor-field small" data-id="46747" data-options="WyJvcHRpb24xIiwib3B0aW9uMiIsIm9wdGlvbjMiXQ==" data-field_type="select" id="field-46747" data-correct="WyJvcHRpb24yIl0=" data-field_size="small" data-select_option="option2" data-score="1" score="1"><option value="option1">option1</option><option value="option2">option2</option><option value="option3">option3</option></select>';
                $question_after_label = isset( $updated_array['question_after_label'] ) ? $updated_array['question_after_label'] : '';
                $explode_content = explode('[', $question_after_label);
                $question_before_text = isset( $explode_content[0] )? $explode_content[0] : '';
                $dropdown_options = explode(']', $explode_content[1]);
                $question_after_text = isset( $dropdown_options[1] )? $dropdown_options[1] : '';
                $dropdown_options = isset( $dropdown_options[0] )? explode('/', $dropdown_options[0]) : array();

                $dropdown_response = '';
                $correct_answer_array = array($correct_answer);
                if( !empty( $dropdown_options ) ){
                    $dropdown_response .= '<option value="">Select Option</option>';
                    foreach( $dropdown_options as $dropdown_item){
                        $dropdown_response .= '<option value="'.$dropdown_item.'">'.$dropdown_item.'</option>';
                    }
                }
                $dropdown_options_str = htmlentities(base64_encode(json_encode($dropdown_options)));
                $correct_answer_str = htmlentities(base64_encode(json_encode($correct_answer_array)));

                $updated_dropdown_response = str_replace($previous_dropdown_response,'<select class="editor-field" data-id="'.$random_id.'" data-options="'.$dropdown_options_str.'" data-field_type="select" id="field-'.$random_id.'" data-correct="'.$correct_answer_str.'" data-select_option="'.$correct_answer.'">'.$dropdown_response.'</select>', $previous_dropdown_response);
                $updated_dropdown_response = $question_before_text.' <span class="select-box quiz-input-group">'.$updated_dropdown_response.'</span> '.$question_after_text;

                $element_data_value_new->content = $updated_dropdown_response;
            }

            if( $question_type == 'text_field'){

                $previous_text_response = '<span class="input-holder input_line"><span class="input-label left" contenteditable="false"></span><input data-field_type="text" class="editor-field input-simple input_line medium" data-id="68322" id="field-68322" data-score="1" score="1" data-placeholder="" placeholder="" data-label="" data-label_position="left" data-size="" size="" data-style_field="input_line" data-field_size="medium" data-type="text" type="text" data-correct_answere="correctAnswer" correct_answere="correctAnswer"> </span>';
                $question_after_label = isset( $updated_array['question_after_label'] ) ? $updated_array['question_after_label'] : '';
                $explode_content = explode('[Blank]', $question_after_label);
                $question_before_text = isset( $explode_content[0] )? $explode_content[0] : '';
                $question_after_text = isset( $explode_content[1] )? $explode_content[1] : '';

                $updated_text_response = str_replace($previous_text_response,'<span class="input-holder input_line"><span class="input-label left" contenteditable="false"></span><input data-field_type="text" class="editor-field input-simple input_line medium" data-id="'.$random_id.'" id="field-'.$random_id.'" data-score="1" score="1" data-placeholder="" placeholder="" data-label="" data-label_position="left" data-size="" size="" data-style_field="input_line" data-field_size="medium" data-type="text" type="text" data-correct_answere="'.$correct_answer.'" correct_answere="'.$correct_answer.'"> </span>', $previous_text_response);
                $updated_text_response = $question_before_text.' '.$updated_text_response.' '.$question_after_text;

                $element_data_value_new->content = $updated_text_response;
            }

            $new_options = array();
            if( !empty($required_options )){
                $option_count = 1;

                foreach( $required_options as $option_value){
                    if( $option_value == ''){ continue; }
                    $new_options[]  = (object) array(
                        'default' => ($option_count == $correct_answer)? 'on' : 'off',
                        'label' => $option_value,
                        'value' => $option_value,
                        'image' => $required_image,
                    );

                    $option_count++;
                }
            }

        }

        return $element_data_value_new;
    }

    public function get_question_updated_layout($question_layout, $replace_keys, $updated_array, $random_id, $question_type){
        $current_type = isset( $element_data_value->type )? $element_data_value->type : '';
        $field_id = isset( $element_data_value->field_id )? $element_data_value->field_id : '';
        $current_options = isset( $element_data_value->options )? $element_data_value->options : array();
        $required_options = isset( $updated_array['required_options'] )? explode('*', $updated_array['required_options']) : array();
        $required_image = isset( $updated_array['sheet_image'] )? $updated_array['sheet_image'] : '';
        $correct_answer = isset( $updated_array['correct_answer'] )? $updated_array['correct_answer'] : '';

        if( !empty( $replace_keys)){
            foreach( $replace_keys as $replace_key => $replace_value){
                $question_layout = str_replace($replace_key, $replace_value, $question_layout);
            }
        }
        $question_layout = str_replace('PH-Text-AL', isset( $updated_array['question_after_label'])? $updated_array['question_after_label'] : '', $question_layout);
        $question_layout = str_replace('PH-Label', isset( $updated_array['question_label'])? $updated_array['question_label'] : '', $question_layout);
        $question_layout = str_replace('PH-Text-BL', isset( $updated_array['question_before_label'])? $updated_array['question_before_label'] : '', $question_layout);

        $radio_layout_response = '';
        if( $question_type == 'single_select' || $question_type == 'true_false') {
            if (!empty($required_options)) {
                $option_index = 0;
                foreach ($required_options as $option_value) {
                    if ($option_value == '') {
                        continue;
                    }
                    $radio_layout_response .= '<div class="field-holder rureraform-cr-container-medium rureraform-cr-container-undefined"><input class="editor-field" type="radio" name="field-' . $random_id . '" id="field-' . $random_id . '-' . $option_index . '" value="' . $option_value . '"><label for="field-' . $random_id . '-' . $option_index . '">' . $option_value . '</label></div>';
                    $option_index++;
                }

                $question_layout = str_replace("Don't know", 'Dont know', $question_layout);

                $replaceable = '<div class="lms-radio-select rurera-in-row undefined "><div class="field-holder rureraform-cr-container-medium rureraform-cr-container-undefined"><input class="editor-field" type="radio" name="field-' . $random_id . '" id="field-' . $random_id . '-0" value="Option 1"><label for="field-' . $random_id . '-0"><span class="inner-label">True</span></label></div><div class="field-holder rureraform-cr-container-medium rureraform-cr-container-undefined"><input class="editor-field" type="radio" name="field-' . $random_id . '" id="field-' . $random_id . '-1" value="Option 2"><label for="field-' . $random_id . '-1"><span class="inner-label">False</span></label></div><div class="field-holder rureraform-cr-container-medium rureraform-cr-container-undefined"><input class="editor-field" type="radio" name="field-' . $random_id . '" id="field-' . $random_id . '-2" value="Option 3"><label for="field-' . $random_id . '-2"><span class="inner-label">Dont know</span></label></div></div>';

                if ($question_type == 'single_select') {
                    $replaceable = '<div class="lms-radio-select rurera-in-row undefined "><div class="field-holder rureraform-cr-container-medium rureraform-cr-container-undefined"><input class="editor-field" type="radio" name="field-' . $random_id . '" id="field-' . $random_id . '-0" value="Option 1"><label for="field-' . $random_id . '-0"><span class="inner-label">Option 1</span></label></div></div>';

                }

                $question_layout = str_replace($replaceable, '<div class="lms-radio-select rurera-in-row undefined ">' . $radio_layout_response . '</div>', $question_layout);

            }
        }
        if( $question_type == 'dropdown') {
            //$previous_dropdown_response = '<select class="editor-field" data-id="6323" data-options="WyJvcHRpb24xIiwib3B0aW9uMiIsIm9wdGlvbjMiXQ==" data-field_type="select" id="field-6323" data-correct="WyJvcHRpb24yIl0=" data-select_option="option3"><option value="option1">option1</option></select>';
            $previous_dropdown_response = '<select class="editor-field small" data-id="46747" data-options="WyJvcHRpb24xIiwib3B0aW9uMiIsIm9wdGlvbjMiXQ==" data-field_type="select" id="field-46747" data-correct="WyJvcHRpb24yIl0=" data-field_size="small" data-select_option="option2" data-score="1" score="1"><option value="option1">option1</option><option value="option2">option2</option><option value="option3">option3</option></select>';
            $question_after_label = isset( $updated_array['question_after_label'] ) ? $updated_array['question_after_label'] : '';
            $explode_content = explode('[', $question_after_label);
            $question_before_text = isset( $explode_content[0] )? $explode_content[0] : '';
            $dropdown_options = explode(']', $explode_content[1]);
            $question_after_text = isset( $dropdown_options[1] )? $dropdown_options[1] : '';
            $dropdown_options = isset( $dropdown_options[0] )? explode('/', $dropdown_options[0]) : array();

            $dropdown_response = '';
            $correct_answer_array = array($correct_answer);
            if( !empty( $dropdown_options ) ){
                $dropdown_response .= '<option value="">Select Option</option>';
                foreach( $dropdown_options as $dropdown_item){
                    $dropdown_response .= '<option value="'.$dropdown_item.'">'.$dropdown_item.'</option>';
                }
            }
            $dropdown_options_str = htmlentities(base64_encode(json_encode($dropdown_options)));
            $correct_answer_str = htmlentities(base64_encode(json_encode($correct_answer_array)));

            $updated_dropdown_response = str_replace($previous_dropdown_response,'<select class="editor-field" data-id="'.$random_id.'" data-options="'.$dropdown_options_str.'" data-field_type="select" id="field-'.$random_id.'" data-correct="'.$correct_answer_str.'" data-select_option="'.$correct_answer.'">'.$dropdown_response.'</select>', $previous_dropdown_response);
            $updated_dropdown_response = $question_before_text.' <span class="select-box quiz-input-group">'.$updated_dropdown_response.'</span> '.$question_after_text;


            $replaceable = 'TEXT-REPLACE';
            $question_layout = str_replace($replaceable, $updated_dropdown_response, $question_layout);
            //$question_layout = $updated_dropdown_response;
        }
        if( $question_type == 'text_field') {

            $previous_text_response = '<span class="input-holder input_line"><span class="input-label left" contenteditable="false"></span><input data-field_type="text" class="editor-field input-simple input_line medium" data-id="68322" id="field-68322" data-score="1" score="1" data-placeholder="" placeholder="" data-label="" data-label_position="left" data-size="" size="" data-style_field="input_line" data-field_size="medium" data-type="text" type="text" data-correct_answere="correctAnswer" correct_answere="correctAnswer"> </span>';
            $question_after_label = isset( $updated_array['question_after_label'] ) ? $updated_array['question_after_label'] : '';
            $explode_content = explode('[Blank]', $question_after_label);
            $question_before_text = isset( $explode_content[0] )? $explode_content[0] : '';
            $question_after_text = isset( $explode_content[1] )? $explode_content[1] : '';

            $updated_text_response = str_replace($previous_text_response,'<span class="input-holder input_line"><span class="input-label left" contenteditable="false"></span><input data-field_type="text" class="editor-field input-simple input_line medium" data-id="'.$random_id.'" id="field-'.$random_id.'" data-score="1" score="1" data-placeholder="" placeholder="" data-label="" data-label_position="left" data-size="" size="" data-style_field="input_line" data-field_size="medium" data-type="text" type="text" data-correct_answere="'.$correct_answer.'" correct_answere="'.$correct_answer.'"> </span>', $previous_text_response);
            $updated_text_response = $question_before_text.' '.$updated_text_response.' '.$question_after_text;

            $replaceable = 'TEXT-REPLACE';
            $question_layout = str_replace($replaceable, $updated_text_response, $question_layout);
        }
        if( !empty( $this->replace_able_text ) ){
            foreach( $this->replace_able_text as $replace_index => $replace_value){
                $question_layout = str_replace($replace_index, $replace_value, $question_layout);
            }
        }

        return $question_layout;
    }

    public function import_mcqs_questions_correct(){
        $query = QuizzesQuestion::query();
        $term_data = 'MCQs';
        $query->where('search_tags', 'like', '%'.$term_data.'%');

        $questions = $query->get();
        if( !empty( $questions ) ){
            foreach( $questions as $questionObj){

                $elements_data = json_decode($questionObj->elements_data);
                $keys = array_keys((array) $elements_data);
                $dynamic_id = $keys[0];
                $new_question_text = $elements_data->{'0'}->content;
                $new_label = $elements_data->{'1'}->content;
                $question_layout = $questionObj->question_layout;
                $question_layout = $questionObj->question_layout;
                $options_array = $elements_data->$dynamic_id->options;

                $options_text = '';
                $option_count = 0;
                if( !empty( $options_array ) ){
                    foreach( $options_array as $optionObj){
                        $options_text .= '<div class="field-holder rureraform-cr-container-medium rureraform-cr-container-undefined"><input class="editor-field" type="radio" name="field-75400" id="field-75400-'.$option_count.'" value="'.$optionObj->value.'"><label for="field-75400-'.$option_count.'">'.$optionObj->value.'</label></div>';
                        $option_count++;
                    }
                }

                $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));




               $question_layout = '<div id="rureraform-element-1" class="rureraform-element-1 rureraform-element quiz-group rureraform-element-html ui-sortable-handle" data-type="paragraph_quiz">'.$new_question_text.'<div class="rureraform-element-cover"></div></div>';
               $question_layout .= '<div id="rureraform-element-2" class="rureraform-element-2 rureraform-element quiz-group rureraform-element-html ui-sortable-handle" data-type="question_label"><div class="question-label"><span>'.$new_label.'</span></div></div>';
               $question_layout .= '<div id="rureraform-element-0" class="quiz-group draggable3 rureraform-element-0 rureraform-element rureraform-element-label-undefined ui-sortable-handle" data-type="radio"><div class="rureraform-column-label"><label class="rureraform-label rureraform-ta-undefined"></label></div><div class="rureraform-column-input"><div class="rureraform-input rureraform-cr-layout-undefined rureraform-cr-layout-undefined"><div class="form-box rurera-in-row undefined image-right  image_small "><div class="lms-radio-select rurera-in-row undefined image-right  image_small">'.$options_text.'</div></div></div><label class="rureraform-description"></label></div><div class="rureraform-element-cover"></div></div>';

                $question_layout = str_replace('75400', $dynamic_id, $question_layout);

                $question_layout = htmlentities(base64_encode(json_encode($question_layout)));

                $questionObj->update([
                    'question_layout' => $question_layout,
                ]);
                pre($questionObj->id, false);
            }
        }
        pre('Done');
    }

    /*
     * Import MCQs Questions
     */
    public function import_mcqs_questions()
    {
        $user = auth()->user();


        //Year 7
        $files_array = array(
            'mcq-qiestions-unit 01',
            'mcq-qiestions-unit 01-part2',
            'mcq-qiestions-unit 01-part3',
            'mcq-qiestions-unit 01-part4',
            'mcq-qiestions-unit 01-part5',
        );
        $grade = 'Year 7';

        foreach( $files_array as $file_name){
            $excel = 'grade-7-mcqs/'.$file_name.'.xlsx';
            echo '<hr><br><br>';
            echo $file_name.'<br>';
            $other_slug = $file_name;

            $rows = Excel::toArray(null, $excel);
            if (!empty($rows)) {
                foreach ($rows as $rowArray) {
                    if (!empty($rowArray)) {
                        foreach ($rowArray as $key => $rowData) {
                            if ($key == 0) {
                                continue;
                            }
                            $random_id = rand(1111, 9999);
                            $question_layout = 'IjxzdHlsZT4jbGVmb3JtLWVsZW1lbnQtMCBkaXYubGVmb3JtLWlucHV0e2hlaWdodDphdXRvO2xpbmUtaGVpZ2h0OjE7fTwvc3R5bGU+PGRpdiBpZD1cImxlZm9ybS1lbGVtZW50LTFcIiBjbGFzcz1cImxlZm9ybS1lbGVtZW50LTEgbGVmb3JtLWVsZW1lbnQgcXVpei1ncm91cCBsZWZvcm0tZWxlbWVudC1odG1sXCIgZGF0YS10eXBlPVwicXVlc3Rpb25fbGFiZWxcIj48ZGl2IGNsYXNzPVwicXVlc3Rpb24tbGFiZWxcIj48c3Bhbj5NQ1FTIExhYmVsPC9zcGFuPjwvZGl2PjwvZGl2PjxkaXYgaWQ9XCJsZWZvcm0tZWxlbWVudC0wXCIgY2xhc3M9XCJxdWl6LWdyb3VwIGRyYWdnYWJsZTMgbGVmb3JtLWVsZW1lbnQtMCBsZWZvcm0tZWxlbWVudCBsZWZvcm0tZWxlbWVudC1sYWJlbC11bmRlZmluZWRcIiBkYXRhLXR5cGU9XCJyYWRpb1wiPjxkaXYgY2xhc3M9XCJsZWZvcm0tY29sdW1uLWxhYmVsXCI+PGxhYmVsIGNsYXNzPVwibGVmb3JtLWxhYmVsIGxlZm9ybS10YS11bmRlZmluZWRcIj48L2xhYmVsPjwvZGl2PjxkaXYgY2xhc3M9XCJsZWZvcm0tY29sdW1uLWlucHV0XCI+PGRpdiBjbGFzcz1cImxlZm9ybS1pbnB1dCBsZWZvcm0tY3ItbGF5b3V0LXVuZGVmaW5lZCBsZWZvcm0tY3ItbGF5b3V0LXVuZGVmaW5lZFwiPjxkaXYgY2xhc3M9XCJmb3JtLWJveCBydXJlcmEtaW4tcm93IHVuZGVmaW5lZCBpbWFnZS1yaWdodCAgaW1hZ2Vfc21hbGwgXCI+PGRpdiBjbGFzcz1cImxtcy1yYWRpby1zZWxlY3QgcnVyZXJhLWluLXJvdyB1bmRlZmluZWQgaW1hZ2UtcmlnaHQgIGltYWdlX3NtYWxsXCI+PGRpdiBjbGFzcz1cImZpZWxkLWhvbGRlciBsZWZvcm0tY3ItY29udGFpbmVyLW1lZGl1bSBsZWZvcm0tY3ItY29udGFpbmVyLXVuZGVmaW5lZFwiPjxpbnB1dCBjbGFzcz1cImVkaXRvci1maWVsZFwiIHR5cGU9XCJyYWRpb1wiIG5hbWU9XCJmaWVsZC01NTIwNVwiIGlkPVwiZmllbGQtNTUyMDUtMFwiIHZhbHVlPVwiT3B0aW9uIDFcIj48bGFiZWwgZm9yPVwiZmllbGQtNTUyMDUtMFwiPk9wdGlvbiAxPC9sYWJlbD48L2Rpdj48L2Rpdj48L2Rpdj48L2Rpdj48bGFiZWwgY2xhc3M9XCJsZWZvcm0tZGVzY3JpcHRpb25cIj48L2xhYmVsPjwvZGl2PjxkaXYgY2xhc3M9XCJsZWZvcm0tZWxlbWVudC1jb3ZlclwiPjwvZGl2PjwvZGl2PiI=';
                            $element_data = '{"55205":{"type":"radio","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":3,"id":3,"basic":"basic","score":"","label":"","options":[{"default":"on","label":"Option 1","value":"Option 1","image":""}],"description":"","style":"style","image_size":"image_small","template_style":"rurera-in-row","template_alignment":"image-right","list_style":"","description-style-position":"","description-style-align":"","elements_data":"W3t9XQ==","field_id":55205},
                            "0":{"type":"paragraph_quiz","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":1,"id":1,"basic":"basic","content":"question details","elements_data":"W3t9XQ=="},
                            "1":{"type":"question_label","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":2,"id":2,"basic":"basic","content":"MCQS Label","elements_data":"W3t9XQ=="}}';
                            $layout_elements = '[
                            {"type":"radio","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":3,"id":3,"basic":"basic","score":"","label":"","options":[{"default":"on","label":"Option 1","value":"Option 1","image":""}],"description":"","style":"style","image_size":"image_small","template_style":"rurera-in-row","template_alignment":"image-right","list_style":"","description-style-position":"","description-style-align":"","elements_data":"W3t9XQ==","field_id":55205},
                            {"type":"paragraph_quiz","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":1,"id":1,"basic":"basic","content":"question details","elements_data":"W3t9XQ=="},
                            {"type":"question_label","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":2,"id":2,"basic":"basic","content":"MCQS Label","elements_data":"W3t9XQ=="}]';


                            $mcqs_options = isset( $rowData[3] )? $rowData[3] : '';
                            $mcqs_options = explode('*', $mcqs_options);
                            $questionLabel = isset( $rowData[1] )? $rowData[1] : '';
                            $questionLabel = 'Select One Correct Answer';
                            $new_title = isset( $rowData[2] )? $rowData[2] : '';
                            $new_tags = str_replace(',', ' | ', $rowData[0]);
                            $question_solve = isset( $rowData[5] )? $rowData[5] : '';

                            $correct_answer = isset( $rowData[4] )? $rowData[4] : 1;
                            $element_data = str_replace('55205', $random_id, $element_data);
                            $layout_elements = str_replace('55205', $random_id, $layout_elements);

                            $element_data = json_decode($element_data);
                            $layout_elements = json_decode($layout_elements);
                            $layout_count = 0;
                            $element_data->$random_id->options = array();
                            $layout_elements[0]->options = array();
                            $option_count = 1;
                            if( !empty( $mcqs_options )){
                                foreach( $mcqs_options as $option_value){
                                    if( $option_value == ''){
                                        continue;
                                    }
                                    $element_data->$random_id->options[] = (object) array(
                                        'default' => ($option_count == $correct_answer)? 'on' : 'off',
                                        'label' => $option_value,
                                        'value' => $option_value,
                                        'image' => '',
                                    );
                                    $layout_elements[0]->options[] = (object) array(
                                        'default' => ($option_count == $correct_answer)? 'on' : 'off',
                                        'label' => $option_value,
                                        'value' => $option_value,
                                        'image' => '',
                                    );
                                    $option_count++;
                                }
                            }
                            $element_data = json_encode($element_data);
                            $layout_elements = json_encode($layout_elements);


                            $element_data = str_replace('MCQS Label', $questionLabel, $element_data);
                            $element_data = str_replace('question details', $new_title, $element_data);
                            $layout_elements = str_replace('MCQS Label', $questionLabel, $layout_elements);
                            $layout_elements = str_replace('question details', $new_title, $layout_elements);


                            $question_layout = str_replace('55205', $random_id, $question_layout);
                            $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));

                            $quizQuestion = QuizzesQuestion::create([
                                'quiz_id'                   => 0,
                                'creator_id'                => $user->id,
                                'grade'                     => '',
                                'question_year'             => 0,
                                'question_score'            => 1,
                                'question_average_time'     => 2,
                                'question_difficulty_level' => 'Below',
                                'question_template_type'    => 'sum_quiz',
                                //isset( $questionData['type'] )? $questionData['type'] : '',
                                'chapter_id'                => 195,
                                'question_title'            => $new_title,
                                'question_layout'           => $question_layout,
                                'question_solve'            => $question_solve,
                                'glossary_ids'              => '["1"]',
                                'elements_data'             => $element_data,
                                'layout_elements'           => $layout_elements,
                                'category_id'               => 616,
                                'course_id'                 => 2082,
                                'sub_chapter_id'            => 0,
                                'type'                      => 'descriptive',
                                'created_at'                => time(),
                                'question_status'           => 'Submit for review',
                                'comments_for_reviewer'     => '',
                                'search_tags'               => $new_tags.' | '.$grade.' | MCQs',
                                'review_required'           => 0,
                                'question_example'          => '<p>test</p>',
                            ]);

                            QuizzesQuestionTranslation::updateOrCreate([
                                'quizzes_question_id' => $quizQuestion->id,
                                'locale'              => 'en',
                            ], [
                                'title'   => $new_title,
                                'correct' => '',
                            ]);
                            //pre($quizQuestion->id);
                            pre($quizQuestion->id, false);
                        }
                    }
                }
            }
        }



        pre('Completed!!!!');
    }

    /*
     * Import dropdown Questions
     */
    public function import_dropdown_questions()
    {
        $user = auth()->user();


        //Year 7
        $files_array = array(
            'unit1-dropdown-list-1',
            'unit1-dropdown-list-2',
            'unit1-dropdown-list-3',
            'unit1-dropdown-list-4',
            'unit1-dropdown-list-5',
        );
        $grade = 'Year 7';

        foreach( $files_array as $file_name){
            $excel = 'grade-7-dropdown/'.$file_name.'.xlsx';
            echo '<hr><br><br>';
            echo $file_name.'<br>';
            $other_slug = $file_name;

            $rows = Excel::toArray(null, $excel);
            //pre($rows);
            if (!empty($rows)) {
                foreach ($rows as $rowArray) {
                    if (!empty($rowArray)) {
                        foreach ($rowArray as $key => $rowData) {
                            if ($key == 0) {
                                continue;
                            }
                            $random_id = rand(1111, 9999);
                            $question_layout = 'IjxzdHlsZT48L3N0eWxlPjxkaXYgaWQ9XCJsZWZvcm0tZWxlbWVudC0wXCIgY2xhc3M9XCJsZWZvcm0tZWxlbWVudC0wIGxlZm9ybS1lbGVtZW50IHF1aXotZ3JvdXAgbGVmb3JtLWVsZW1lbnQtaHRtbFwiIGRhdGEtdHlwZT1cInF1ZXN0aW9uX2xhYmVsXCI+PGRpdiBjbGFzcz1cInF1ZXN0aW9uLWxhYmVsXCI+PHNwYW4+RHJvcGRvd24gTGFiZWw8L3NwYW4+PC9kaXY+PC9kaXY+PGRpdiBpZD1cImxlZm9ybS1lbGVtZW50LTFcIiBjbGFzcz1cImxlZm9ybS1lbGVtZW50LTEgbGVmb3JtLWVsZW1lbnQgcXVlc3Rpb24tdGV4dGFyZWEgcXVpei1ncm91cCBsZWZvcm0tZWxlbWVudC1odG1sXCIgZGF0YS10eXBlPVwiaHRtbFwiPmRyb3Bkb3duIGhlcmUmbmJzcDs8c3BhbiBjbGFzcz1cInNlbGVjdC1ib3ggcXVpei1pbnB1dC1ncm91cFwiPlxuICAgICAgICA8c2VsZWN0IGNsYXNzPVwiZWRpdG9yLWZpZWxkIG1lZGl1bVwiIGlkPVwiZmllbGQtNzg0NjJcIiBzY29yZT1cIjFcIj48b3B0aW9uIHZhbHVlPVwiT3B0aW9uIDFcIj5PcHRpb24gMTwvb3B0aW9uPjxvcHRpb24gdmFsdWU9XCJPcHRpb24gMlwiPk9wdGlvbiAyPC9vcHRpb24+PC9zZWxlY3Q+XG48L3NwYW4+PGRpdiBjbGFzcz1cImxlZm9ybS1lbGVtZW50LWNvdmVyXCI+PC9kaXY+PC9kaXY+Ig==';
                            $element_data = '{"0":{"type":"html","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":1,"id":3,"basic":"basic","score":"","content":"dropdown here&nbsp;<span class=\"select-box quiz-input-group\">\n        <select class=\"editor-field medium\" data-id=\"78462\" data-options=\"WyJPcHRpb24gMSIsIk9wdGlvbiAyIl0=\" data-field_type=\"select\" id=\"field-78462\" data-correct=\"[&quot;Option 1&quot;,&quot;Option 2&quot;]\" data-field_size=\"medium\" data-score=\"1\" score=\"1\" data-select_option=\"Option 2\"><option value=\"Option 1\">Option 1<\/option><option value=\"Option 2\">Option 2<\/option><\/select>\n<\/span>","elements_data":"W3siNzg0NjIiOnsiZmllbGRfdHlwZSI6InNlbGVjdCIsImxlZnQiOiJzZWxlY3QiLCJ0b3AiOiJzZWxlY3QiLCJzY29yZSI6IjEiLCJmaWVsZF9zaXplIjoibWVkaXVtIiwic2VsZWN0X29wdGlvbiI6WyJPcHRpb24gMSIsIk9wdGlvbiAyIl0sImNvcnJlY3RfYW5zd2VyIjoiT3B0aW9uIDIifX1d"},"78462":{"class":"editor-field medium","data-id":"78462","data-options":"WyJPcHRpb24gMSIsIk9wdGlvbiAyIl0=","data-field_type":"select","id":"field-78462","data-correct":"[\"Option 1\",\"Option 2\"]","data-field_size":"medium","data-score":"1","score":"1","data-select_option":"Option 2"}}';
                            $layout_elements = '[{"type":"question_label","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":0,"id":2,"basic":"basic","content":"Dropdown Label","elements_data":"W3t9XQ=="},{"type":"html","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":1,"id":3,"basic":"basic","score":"","content":"dropdown here&nbsp;<span class=\"select-box quiz-input-group\">\n        <select class=\"editor-field medium\" data-id=\"78462\" data-options=\"WyJPcHRpb24gMSIsIk9wdGlvbiAyIl0=\" data-field_type=\"select\" id=\"field-78462\" data-correct=\'[\"Option 1\"]\' data-field_size=\"medium\" data-score=\"1\" score=\"1\" data-select_option=\"Option 2\"><option value=\"Option 1\">Option 1<\/option><\/select>\n<\/span>","elements_data":"W3siNzg0NjIiOnsiZmllbGRfdHlwZSI6InNlbGVjdCIsImxlZnQiOiJzZWxlY3QiLCJ0b3AiOiJzZWxlY3QiLCJzY29yZSI6IjEiLCJmaWVsZF9zaXplIjoibWVkaXVtIiwic2VsZWN0X29wdGlvbiI6WyJPcHRpb24gMSIsIk9wdGlvbiAyIl0sImNvcnJlY3RfYW5zd2VyIjoiT3B0aW9uIDIifX1d"}]';


                            $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));

                            $questionLabel = isset( $rowData[1] )? $rowData[1] : '';
                            $questionLabel = 'Select One Correct Answer';
                            $new_title = isset( $rowData[2] )? $rowData[2] : '';
                            $new_tags = str_replace(',', ' | ', $rowData[0]);
                            $question_solve = isset( $rowData[5] )? $rowData[5] : '';

                            $correct_answer = isset( $rowData[3] )? $rowData[3] : 1;
                            $element_data = str_replace('78462', $random_id, $element_data);
                            $layout_elements = str_replace('78462', $random_id, $layout_elements);

                            $element_data = json_decode($element_data);
                            $layout_elements = json_decode($layout_elements);
                            $content_data = isset( $layout_elements[1] )? $layout_elements[1] : '';
                            $content_data = isset( $content_data->content )? $content_data->content : '';
                            $reference_start = explode('[', $new_title);
                            $new_title_before = isset( $reference_start[0] )? $reference_start[0] : '';
                            $reference_end = explode(']', $reference_start[1]);
                            $new_title_end = explode(']', $new_title);
                            $new_title_after = isset( $new_title_end[1] )? $new_title_end[1] : '';

                            $options_string = isset( $reference_end[0] )? $reference_end[0] : '';
                            $options_array = explode('/', $options_string);

                            $question_reference = $new_title_before.' DROPDOWN '. $new_title_after;



                            $content_data = str_replace('<span class="select-box', $new_title_before.' <span class="select-box', $content_data);
                            $content_data = str_replace('</span>', '</span> '.$new_title_after, $content_data);
                            $content_data = str_replace('</span>', '</span> '.$new_title_after, $content_data);






                            $options_data = '<option value="">Select</option>';
                            $options_new_array = array();


                            $correct_count = $correct_answer;
                            $option_count = 1;
                            if( !empty( $options_array )){
                                foreach( $options_array as $option_value){
                                    if( $option_value == ''){
                                        continue;
                                    }
                                    $options_data .= '<option value="'.$option_value.'">'.$option_value.'</option>';
                                    $options_new_array[] = $option_value;
                                    //$correct_answer = ($option_count == $correct_count)? $option_value : $correct_answer;
                                    $option_count++;
                                }
                            }
                            $content_data = str_replace('["Option 1"]', '["'.$correct_answer.'"]', $content_data);


                            $content_data = str_replace('dropdown here', '', $content_data);
                            $content_data = str_replace('<option value="Option 1">Option 1</option>', htmlspecialchars_decode($options_data), $content_data);
                            $layout_count = 0;
                            //pre($content_data);
                            $layout_elements[1]->content  = $content_data;
                            $element_data->$layout_count->content  = $content_data;
                            $element_data->$random_id->{'data-correct'} = json_encode($options_new_array);
                            $element_data->$random_id->{'data-select_option'} = $correct_answer;
                            //pre($layout_elements);
                            //pre($element_data);

                            $element_data = json_encode($element_data);
                            $layout_elements = json_encode($layout_elements);
                            //pre($layout_elements);

                            $content_data = str_replace('. .', '.', $content_data);
                            $question_layout = '';
                            $question_layout .= '<div id="rureraform-element-0" class="rureraform-element-0 rureraform-element quiz-group rureraform-element-html" data-type="question_label"><div class="question-label"><span>'.$questionLabel.'</span></div></div>';
                            $question_layout .= '<div id="rureraform-element-1" class="rureraform-element-1 rureraform-element question-textarea quiz-group rureraform-element-html" data-type="html">'.$content_data.'<div class="rureraform-element-cover"></div></div>';


                            $element_data = str_replace('Dropdown Label', $questionLabel, $element_data);
                            $element_data = str_replace('WyJPcHRpb24gMSIsIk9wdGlvbiAyIl0=', base64_encode(json_encode($options_new_array)), $element_data);
                            $element_data = str_replace('. .', '.', $element_data);
                            $layout_elements = str_replace('Dropdown Label', $questionLabel, $layout_elements);
                            $layout_elements = str_replace('WyJPcHRpb24gMSIsIk9wdGlvbiAyIl0=', base64_encode(json_encode($options_new_array)), $layout_elements);
                            $layout_elements = str_replace('. .', '.', $layout_elements);


                            $question_layout = str_replace('78462', $random_id, $question_layout);
                            $question_layout = htmlentities(base64_encode(json_encode($question_layout)));

                            $quizQuestion = QuizzesQuestion::create([
                                'quiz_id'                   => 0,
                                'creator_id'                => $user->id,
                                'grade'                     => '',
                                'question_year'             => 0,
                                'question_score'            => 1,
                                'question_average_time'     => 2,
                                'question_difficulty_level' => 'Below',
                                'question_template_type'    => 'sum_quiz',
                                //isset( $questionData['type'] )? $questionData['type'] : '',
                                'chapter_id'                => 195,
                                'question_title'            => $question_reference,
                                'question_layout'           => $question_layout,
                                'question_solve'            => $question_solve,
                                'glossary_ids'              => '["1"]',
                                'elements_data'             => $element_data,
                                'layout_elements'           => $layout_elements,
                                'category_id'               => 616,
                                'course_id'                 => 2082,
                                'sub_chapter_id'            => 0,
                                'type'                      => 'descriptive',
                                'created_at'                => time(),
                                'question_status'           => 'Submit for review',
                                'comments_for_reviewer'     => '',
                                'search_tags'               => $new_tags.' | '.$grade.' | Dropdown',
                                'review_required'           => 0,
                                'question_example'          => '<p>test</p>',
                            ]);

                            QuizzesQuestionTranslation::updateOrCreate([
                                'quizzes_question_id' => $quizQuestion->id,
                                'locale'              => 'en',
                            ], [
                                'title'   => $question_reference,
                                'correct' => '',
                            ]);
                            //pre($quizQuestion->id);
                            pre($quizQuestion->id, false);
                        }
                    }
                }
            }
        }



        pre('Completed!!!!');
    }

    /*
     * Import dropdown Questions
     */
    public function import_short_questions()
    {
        $user = auth()->user();


        //Year 7
        $files_array = array(
            'short-answer-p1',
            'short-answer-p2',
            'short-answer-p3',
            'short-answer-p4',
        );
        $grade = 'Year 7';

        foreach( $files_array as $file_name){
            $excel = 'grade-7-short/'.$file_name.'.xlsx';
            echo '<hr><br><br>';
            echo $file_name.'<br>';
            $other_slug = $file_name;

            $rows = Excel::toArray(null, $excel);
            //pre($rows);
            if (!empty($rows)) {
                foreach ($rows as $rowArray) {
                    if (!empty($rowArray)) {
                        foreach ($rowArray as $key => $rowData) {
                            if ($key == 0) {
                                continue;
                            }
                            $random_id = rand(1111, 9999);
                            $question_layout = 'IjxzdHlsZT48L3N0eWxlPjxkaXYgaWQ9XCJsZWZvcm0tZWxlbWVudC0zXCIgY2xhc3M9XCJsZWZvcm0tZWxlbWVudC0zIGxlZm9ybS1lbGVtZW50IHF1aXotZ3JvdXAgbGVmb3JtLWVsZW1lbnQtaHRtbFwiIGRhdGEtdHlwZT1cInF1ZXN0aW9uX2xhYmVsXCI+PGRpdiBjbGFzcz1cInF1ZXN0aW9uLWxhYmVsXCI+PHNwYW4+Z2l2ZSBhIHNob3J0IGFuc3dlciBmb3IgZm9sbG93aW5nIHF1ZXN0aW9uPC9zcGFuPjwvZGl2PjwvZGl2PjxkaXYgaWQ9XCJsZWZvcm0tZWxlbWVudC0yXCIgY2xhc3M9XCJsZWZvcm0tZWxlbWVudC0yIGxlZm9ybS1lbGVtZW50IHF1aXotZ3JvdXAgbGVmb3JtLWVsZW1lbnQtaHRtbFwiIGRhdGEtdHlwZT1cInBhcmFncmFwaF9xdWl6XCI+PHA+UXVlc3Rpb24gVGV4dCBoZXJlPC9wPjxkaXYgY2xhc3M9XCJsZWZvcm0tZWxlbWVudC1jb3ZlclwiPjwvZGl2PjwvZGl2PjxkaXYgaWQ9XCJsZWZvcm0tZWxlbWVudC00XCIgY2xhc3M9XCJsZWZvcm0tZWxlbWVudC00IGxlZm9ybS1lbGVtZW50IHF1aXotZ3JvdXAgbGVmb3JtLWVsZW1lbnQtaHRtbFwiIGRhdGEtdHlwZT1cInRleHRhcmVhZmllbGRfcXVpelwiPjxzcGFuIGNsYXNzPVwiaW5wdXQtaG9sZGVyICB0ZXh0YXJlYV9wbGFpbiBmaWVsZF9sYXJnZVwiPjxzcGFuIGNsYXNzPVwiaW5wdXQtbGFiZWxcIiBjb250ZW50ZWRpdGFibGU9XCJmYWxzZVwiPjwvc3Bhbj48dGV4dGFyZWEgcGxhY2Vob2xkZXI9XCJcIiByb3dzPVwiNFwiIG1heGxlbmdodGg9XCIyNTVcIiBjbGFzcz1cImVkaXRvci1maWVsZCBpbnB1dC1zaW1wbGVcIiBpZD1cImZpZWxkLTY3OTcwXCI+PC90ZXh0YXJlYT48L3NwYW4+PGRpdiBjbGFzcz1cImxlZm9ybS1lbGVtZW50LWNvdmVyXCI+PC9kaXY+PC9kaXY+Ig==';
                            $element_data = '{"0":{"type":"question_label","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":0,"id":5,"basic":"basic","content":"give a short answer for following question","elements_data":"W3t9XQ=="},"67970":{"type":"textareafield_quiz","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":2,"id":6,"basic":"basic","placeholder":"","field_size":"field_large","style_format":"textarea_plain","maxlength":"255","rows":"4","correct_answer":"this is correct answer","score":"1","elements_data":"W3t9XQ==","field_id":67970}}';
                            $layout_elements = '[{"type":"paragraph_quiz","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":1,"id":4,"basic":"basic","content":"Question Text here","elements_data":"W3t9XQ=="},{"type":"question_label","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":0,"id":5,"basic":"basic","content":"give a short answer for following question","elements_data":"W3t9XQ=="},{"type":"textareafield_quiz","resize":"both","height":"auto","_parent":"1","_parent-col":"0","_seq":2,"id":6,"basic":"basic","placeholder":"","field_size":"field_large","style_format":"textarea_plain","maxlength":"255","rows":"4","correct_answer":"this is correct answer","score":"1","elements_data":"W3t9XQ==","field_id":67970}]';


                            $question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question_layout)))));


                            $questionLabel = 'Select One Correct Answer';
                            $questionText = isset( $rowData[1] )? $rowData[1] : '';
                            $question_reference = $questionText;
                            $new_tags = str_replace(',', ' | ', $rowData[0]);
                            $question_solve = '';

                            $correct_answer = isset( $rowData[2] )? $rowData[2] : '';
                            $element_data = str_replace('67970', $random_id, $element_data);
                            $layout_elements = str_replace('67970', $random_id, $layout_elements);

                            $element_data = str_replace('this is correct answer', $correct_answer, $element_data);
                            $layout_elements = str_replace('this is correct answer', $correct_answer, $layout_elements);
                            $layout_elements = str_replace('Question Text here', $questionText, $layout_elements);


                            $element_data = json_decode($element_data);
                            $layout_elements = json_decode($layout_elements);

                            $element_data = json_encode($element_data);
                            $layout_elements = json_encode($layout_elements);
                            $question_layout = str_replace('Question Text here', $questionText, $question_layout);

                            $question_layout = str_replace('67970', $random_id, $question_layout);

                            $question_layout = htmlentities(base64_encode(json_encode($question_layout)));

                            $quizQuestion = QuizzesQuestion::create([
                                'quiz_id'                   => 0,
                                'creator_id'                => $user->id,
                                'grade'                     => '',
                                'question_year'             => 0,
                                'question_score'            => 1,
                                'question_average_time'     => 2,
                                'question_difficulty_level' => 'Below',
                                'question_template_type'    => 'sum_quiz',
                                //isset( $questionData['type'] )? $questionData['type'] : '',
                                'chapter_id'                => 195,
                                'question_title'            => $question_reference,
                                'question_layout'           => $question_layout,
                                'question_solve'            => $question_solve,
                                'glossary_ids'              => '["1"]',
                                'elements_data'             => $element_data,
                                'layout_elements'           => $layout_elements,
                                'category_id'               => 616,
                                'course_id'                 => 2082,
                                'sub_chapter_id'            => 0,
                                'type'                      => 'descriptive',
                                'created_at'                => time(),
                                'question_status'           => 'Submit for review',
                                'comments_for_reviewer'     => '',
                                'search_tags'               => $new_tags.' | '.$grade.' | SA',
                                'review_required'           => 1,
                                'question_example'          => '<p>test</p>',
                            ]);

                            QuizzesQuestionTranslation::updateOrCreate([
                                'quizzes_question_id' => $quizQuestion->id,
                                'locale'              => 'en',
                            ], [
                                'title'   => $question_reference,
                                'correct' => '',
                            ]);
                            //pre($quizQuestion->id);
                            pre($quizQuestion->id, false);
                        }
                    }
                }
            }
        }



        pre('Completed!!!!');
    }

    public function create_sub_chapters_auto(Request $request , $success = '')
    {
        $this->authorize('admin_questions_bank_create');

        $data = [
            'pageTitle' => 'Sub Chapters Auto' ,
        ];

        $lessons = \Illuminate\Support\Facades\DB::table('webinar_chapters')
            ->join('webinar_chapter_translations' , 'webinar_chapter_translations.webinar_chapter_id' , '=' , 'webinar_chapters.id')
            ->select('webinar_chapters.webinar_id' , 'webinar_chapters.id' , 'webinar_chapter_translations.title');

        $lessons = $lessons->get();


        $webinars = Webinar::where('status', 'active');

        $webinars = $webinars->get();
        

        $data['webinars'] = $webinars;

        $glossary = Glossary::where('status' , 'active')
            ->get();

        $chapters_list = get_chapters_list();
        $data['chapters'] = $chapters_list;
        $data['glossary'] = $glossary;
        $data['lessons'] = $lessons;
        $data['success'] = isset($_GET['success']) ? $_GET['success'] : '';

        return view('admin.questions_bank.create_sub_chapters_auto' , $data);
    }

    public function store_sub_chapters_auto()
    {
        $quiz_list = explode("\n" , $_POST['quiz_list']);
        $chapter_id = isset($_POST['category_id']) ? $_POST['category_id'] : 0;
        $WebinarChapter = WebinarChapter::find($chapter_id);
        $webinar_id = $WebinarChapter->webinar_id;
        $chapter_settings = '{\"Below\":{\"questions\":\"10\",\"points\":\"10\"},\"Emerging\":{\"questions\":\"20\",\"points\":\"20\"},\"Expected\":{\"questions\":\"30\",\"points\":\"30\"},\"Exceeding\":{\"questions\":\"15\",\"points\":\"20\"},\"Challenge\":{\"questions\":\"10\",\"points\":\"10\"}}';

        if (!empty($quiz_list)) {
            foreach ($quiz_list as $quiz_title) {
                $quiz_title = trim($quiz_title);
                if ($quiz_title != '') {
                    $SubChapterObj = SubChapters::create([
                        'webinar_id'        => $webinar_id ,
                        'chapter_id'        => $chapter_id ,
                        'sub_chapter_title' => $quiz_title ,
                        'chapter_settings'  => $chapter_settings ,
                        'status'            => 'active' ,
                        'created_at'        => time()
                    ]);

                    $WebinarChapterItemObj = WebinarChapterItem::create([
                        'user_id'    => 929 ,
                        'chapter_id' => $chapter_id ,
                        'item_id'    => $SubChapterObj->id ,
                        'type'       => 'sub_chapter' ,
                        'order'      => 1 ,
                        'created_at' => time()
                    ]);

                    /*$quizObj = Quiz::create([
                        'webinar_id'     => $webinar_id ,
                        'creator_id'     => 929 ,
                        'chapter_id'     => $chapter_id ,
                        'webinar_title'  => 'Maths' ,
                        'time'           => 100 ,
                        'attempt'        => 100 ,
                        'pass_mark'      => 100 ,
                        'certificate'    => 0 ,
                        'status'         => 'active' ,
                        'total_mark'     => 100 ,
                        'created_at'     => time() ,
                        'updated_at'     => time() ,
                        'quiz_type'      => 'auto_builder' ,
                        'sub_chapter_id' => $SubChapterObj->id ,
                        'created_at'     => time()
                    ]);

                    QuizTranslation::updateOrCreate([
                        'quiz_id' => $quizObj->id ,
                        'locale'  => 'en' ,
                    ] , [
                        'title' => $quiz_title ,
                    ]);*/
                }
            }
        }
        return redirect()->route('adminCreateSubChapteAuto' , ['success' => 'yes']);
    }

    public function create_sections_auto(Request $request , $success = '')
    {
        $this->authorize('admin_quizzes_create');

        $data = [
            'pageTitle' => 'Sections Auto' ,
        ];

        $webinars = \Illuminate\Support\Facades\DB::table('webinars')
            ->join('webinar_translations' , 'webinar_translations.webinar_id' , '=' , 'webinars.id')
            ->join('category_translations' , 'category_translations.category_id' , '=' , 'webinars.category_id')
            ->select('webinars.id' , 'webinar_translations.title', 'category_translations.title as category_title');

        $webinars = $webinars->get();

        $data['webinars'] = $webinars;
        $data['success'] = isset($_GET['success']) ? $_GET['success'] : '';

        return view('admin.questions_bank.create_sections_auto' , $data);
    }

    public function store_sections_auto()
    {
        $chapters_list = explode("\n" , $_POST['chapters_list']);
        $webinar_id = isset($_POST['webinar_id']) ? $_POST['webinar_id'] : 0;
        if (!empty($chapters_list)) {
            foreach ($chapters_list as $chapter_title) {
                $chapter_title = trim($chapter_title);
                if ($chapter_title != '') {
                    $WebinarChapterObj = WebinarChapter::create([
                        'user_id'                 => 929 ,
                        'webinar_id'              => $webinar_id ,
                        'check_all_contents_pass' => 0 ,
                        'status'                  => 'active' ,
                        'created_at'              => time()
                    ]);

                    WebinarChapterTranslation::updateOrCreate([
                        'webinar_chapter_id' => $WebinarChapterObj->id ,
                        'locale'             => 'en' ,
                        'title'              => $chapter_title ,
                    ]);
                }
            }
        }
        return redirect()->route('adminCreateSectionsAuto' , ['success' => 'yes']);
    }

    private function filters($query , $request)
    {
        $from = $request->get('from' , null);
        $to = $request->get('to' , null);
        $title = $request->get('title' , null);
        $sort = $request->get('sort' , null);
        $teacher_ids = $request->get('teacher_ids' , null);
        $webinar_ids = $request->get('webinar_ids' , null);
        $question_status = $request->get('question_status' , null);
        $difficulty_level = $request->get('difficulty_level' , null);
        $review_required = $request->get('review_required' , null);
        $question_id = $request->get('question_id' , null);



        $category_id = $request->get('category_id' , '');
        $course_id = $request->get('course_id' , '');
        $chapter_id = $request->get('chapter_id' , '');


        $query = fromAndToDateFilter($from , $to , $query , 'quizzes_questions.created_at');

        if (!empty($title)) {
            $query->whereTranslationLike('title' , '%' . $title . '%')->orWhere('search_tags', 'LIKE' , '%' . $title . '%');
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'have_certificate':
                    $query->where('certificate' , true);
                    break;
                case 'students_count_asc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'asc');
                    break;

                case 'students_count_desc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'desc');
                    break;
                case 'passed_count_asc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status' , 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'asc');
                    break;

                case 'passed_count_desc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , DB::raw('count(quizzes_results.quiz_id) as result_count'))
                        ->where('quizzes_results.status' , 'passed')
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('result_count' , 'desc');
                    break;

                case 'grade_avg_asc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , 'quizzes_results.user_grade' , DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg' , 'asc');
                    break;

                case 'grade_avg_desc':
                    $query->join('quizzes_results' , 'quizzes_results.quiz_id' , '=' , 'quizzes.id')
                        ->select('quizzes.*' , 'quizzes_results.quiz_id' , 'quizzes_results.user_grade' , DB::raw('avg(quizzes_results.user_grade) as grade_avg'))
                        ->groupBy('quizzes_results.quiz_id')
                        ->orderBy('grade_avg' , 'desc');
                    break;

                case 'created_at_asc':
                    $query->orderBy('created_at' , 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at' , 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at' , 'desc');
        }

        if (!empty($teacher_ids)) {
            $query->whereIn('creator_id' , $teacher_ids);
        }

        if (!empty($question_id)) {
            $query->where('id' , $question_id);
        }



        if ($course_id != '') {
            $query->where('quizzes.webinar_id' , $course_id);
        }

        if ($chapter_id != '') {
            $query->where('quizzes_questions.chapter_id' , $chapter_id);
        }

        if ($review_required != '') {
            $query->where('quizzes_questions.review_required' , $review_required);
        }

        if (!empty($question_status) and $question_status !== 'all') {
            $query->where('quizzes_questions.question_status' , $question_status);
        }

        if (!empty($difficulty_level) and $difficulty_level !== 'all') {
            $query->where('quizzes_questions.question_difficulty_level' , $difficulty_level);
        }


        return $query;
    }

    public function store_question()
    {

        $user = auth()->user();
        $this->authorize('admin_questions_bank_create');

        $query = Webinar::query();
		

        $chapters_list = get_chapters_list();

        $questions_array = $columns_array = $form_pages = $elements_data = $elements_array = array();
        if (array_key_exists('form-elements' , $_POST) && is_array($_POST['form-elements'])) {
            foreach ($_POST['form-elements'] as $encoded_element) {
                $element_options = json_decode(base64_decode(trim(stripslashes($encoded_element))) , true);
                $elements_array[] = json_decode(base64_decode(trim(stripslashes($encoded_element))));
                if (is_array($element_options) && array_key_exists('type' , $element_options)) {

                    if ($element_options['type'] != 'columns') {
                        if ($element_options['type'] == 'signature')
                            $form_options['cross-domain'] = 'off';

                        $parent_id = $element_options['_parent'];
                        $current_id = isset($element_options['id']) ? $element_options['id'] : '';

                        $default_element_options = default_form_options($element_options['type']);

                        $field_type = isset($element_options['type']) ? $element_options['type'] : '';

                        $field_id = isset($element_options['field_id']) ? $element_options['field_id'] : '';
                        $fields_data[$field_id] = $element_options;
                        $elements_data[$field_id] = $element_options;
                        if ($field_type != 'textfield_quiz' && $field_type != 'checkbox' && $field_type != 'radio' && $field_type != 'sortable_quiz') {

                            $element_options['elements_data'] = array();

                            $element_options = array_merge($default_element_options , $element_options);

                            $element_content = isset($element_options['content']) ? $element_options['content'] : '';
                            $attrib_arr = ( $element_content != '')? lmsParseTag($element_content , 'editor-field') : array();

                            $fields_data = array();
                            if (!empty($attrib_arr)) {
                                foreach ($attrib_arr as $attribData) {
                                    $id = isset($attribData['data-id']) ? $attribData['data-id'] : '';
                                    if ($id != '') {
                                        $fields_data[$id] = $attribData;
                                        $elements_data[$id] = $attribData;
                                    }
                                }
                            }
                        }
                        $element_options['elements_data'] = $fields_data;


                        $questions_array[$parent_id][] = $element_options;
                    } else {
                        $col_id = isset($element_options['id']) ? $element_options['id'] : '';
                        $columns_array[$col_id] = $element_options;
                    }
                }
            }
        }

        $layout_elements_layout = json_encode($elements_array);
        $form_pages = array();
        $default_page_options = default_form_options("page" , $chapters_list);
        $default_page_confirmation_options = default_form_options("page-confirmation" , $chapters_list);


        $questionData = $_POST;
        $search_tags = (isset( $questionData['search_tags'] ) && $questionData['search_tags'] != '')? explode(',',
            $questionData['search_tags']) : array();
        $search_tags[] = isset($questionData['question_title']) ? $questionData['question_title'] : '';
        $search_tags[] = isset($questionData['difficulty_level']) ? $questionData['difficulty_level'] : '';
        $search_tags = implode(' | ', $search_tags);
        $quiz_id = isset($questionData['chapter_id']) ? $questionData['chapter_id'] : 0;
        $new_glossaries = isset($questionData['new_glossaries']) ? $questionData['new_glossaries'] : array();

        $quiz_id = ($quiz_id > 0) ? $quiz_id : 0;
        $quiz = Quiz::find($quiz_id);
		
		
		$sub_chapter_id = (isset($questionData['sub_chapter_id']) && $questionData['sub_chapter_id'] != '') ? $questionData['sub_chapter_id'] : 0;
		$subChapterObj = SubChapters::find($sub_chapter_id);
		$sub_chapter_quiz_id = isset( $subChapterObj->quizData->item_id )? $subChapterObj->quizData->item_id : 0;
		$difficulty_level = isset($questionData['difficulty_level']) ? $questionData['difficulty_level'] : '';
		$category_id = isset( $questionData['category_id'] )? $questionData['category_id'] : array();
		$category_id = is_array( $category_id )? $category_id : array( $category_id );
		$question_levels = get_question_levels($category_id, $difficulty_level);
		$category_id = json_encode($category_id);
		
        $quizQuestion = QuizzesQuestion::create([
            'quiz_id'                   => $quiz_id ,
            'creator_id'                => $user->id ,
            'grade'                     => '' ,
            'question_year'             => 0 ,
            'question_score'            => (isset($questionData['question_score']) && $questionData['question_score'] != '') ? $questionData['question_score'] : 1 ,
            'question_average_time'     => (isset($questionData['question_average_time']) && $questionData['question_average_time'] != '') ? $questionData['question_average_time'] : 1 ,
            'question_difficulty_level' => isset($questionData['difficulty_level']) ? $questionData['difficulty_level'] : '' ,
            'question_template_type'    => 'sum_quiz' , //isset( $questionData['type'] )? $questionData['type'] : '',
            'chapter_id'                => (isset($questionData['chapter_id']) && $questionData['chapter_id'] != '') ? $questionData['chapter_id'] : 0 ,
            'question_title'            => isset($questionData['question_title']) ? $questionData['question_title'] : '' ,
            'question_layout'           => isset($_POST['question_layout']) ? $_POST['question_layout'] : '' , //isset( $questionData['content'] )? $questionData['content'] : '',
            'question_solve'            => isset($_POST['question_solve']) ? $_POST['question_solve'] : '' ,
            'glossary_ids'              => isset($_POST['glossary_ids']) ? json_encode($_POST['glossary_ids']) : '' ,
            'elements_data'             => json_encode($elements_data) ,
            'layout_elements'           => $layout_elements_layout ,
            'category_id'               => $category_id,
            'course_id'                 => (isset($questionData['course_id']) && $questionData['course_id'] != '') ? $questionData['course_id'] : 0 ,
            'sub_chapter_id'            => (isset($questionData['sub_chapter_id']) && $questionData['sub_chapter_id'] != '') ? $questionData['sub_chapter_id'] : 0 ,
            'type'                      => 'descriptive' ,
            'created_at'                => time() ,
            'question_status'           => (isset($questionData['question_status']) && $questionData['question_status'] != '') ? $questionData['question_status'] : 'Draft' ,
            'comments_for_reviewer'     => (isset($questionData['comments_for_reviewer']) && $questionData['comments_for_reviewer'] != '') ? $questionData['comments_for_reviewer'] : '',
            'search_tags'              	=> $search_tags,
            'review_required'           => isset($questionData['review_required']) ? $questionData['review_required'] : 0 ,
            'question_example'          => isset($_POST['question_example']) ? $_POST['question_example'] : '' ,
            'question_type'            	=> isset($_POST['question_type']) ? $_POST['question_type'] : '' ,
            'example_question'          => isset($_POST['example_question']) && !empty($_POST['example_question']) ? $_POST['example_question'] : 0,
            'reference_type'            => isset($_POST['reference_type']) && !empty($_POST['reference_type']) ? $_POST['reference_type'] : 'Course',
			'question_levels' 			=> json_encode($question_levels),
            'developer_review_required'           => isset($questionData['developer_review_required']) ? $questionData['developer_review_required'] : 0 ,
            'hide_question'           => isset($questionData['hide_question']) ? $questionData['hide_question'] : 0 ,

        ]);
		
		if( $sub_chapter_quiz_id > 0){
			QuizzesQuestionsList::create([
				'quiz_id'     => $sub_chapter_quiz_id,
				'question_id' => $quizQuestion->id,
				'status'      => 'active',
				'sort_order'  => 0,
				'created_by'  => $user->id,
				'created_at'  => time()
			]);
		}
		
		
		

        if (!empty($quizQuestion)) {
            if (!empty($new_glossaries)) {
                foreach ($new_glossaries as $glossary_id) {
                    $glossary = Glossary::findOrFail($glossary_id);
                    $glossary->update([
                        'question_id' => $quizQuestion->id ,
                    ]);
                }
            }

            QuizzesQuestionTranslation::updateOrCreate([
                'quizzes_question_id' => $quizQuestion->id ,
                'locale'              => 'en' ,
            ] , [
                'title'   => isset($questionData['question_title']) ? $questionData['question_title'] : '' ,
                'correct' => '' ,
            ]);

            QuestionLogs::create([
                'question_id' => $quizQuestion->id ,
                'action_type' => $quizQuestion->question_status ,
                'action_role' => $user->role_name ,
                'log_data'    => (isset($questionData['comments_for_reviewer']) && $questionData['comments_for_reviewer'] != '') ? $questionData['comments_for_reviewer'] : '' ,
                'action_by'   => $user->id ,
                'action_at'   => time()
            ]);
        }
        $redirectUrl = '/admin/questions_bank';
        return response()->json([
            'code'         => 200 ,
            'redirect_url' => $redirectUrl
        ]);
    }

    public function update_question($question_id)
    {

        $user = auth()->user();

        $this->authorize('admin_questions_bank_create');

        $quistionObj = QuizzesQuestion::find($question_id);
        $query = Webinar::query();

        $chapters_list = get_chapters_list();


        $questions_array = $columns_array = $form_pages = $elements_data = $elements_array = array();
        if (array_key_exists('form-elements' , $_POST) && is_array($_POST['form-elements'])) {
            foreach ($_POST['form-elements'] as $encoded_element) {
                $element_options = json_decode(base64_decode(trim(stripslashes($encoded_element))) , true);
                $elements_array[] = json_decode(base64_decode(trim(stripslashes($encoded_element))));
                if (is_array($element_options) && array_key_exists('type' , $element_options)) {

                    if ($element_options['type'] != 'columns') {
                        if ($element_options['type'] == 'signature')
                            $form_options['cross-domain'] = 'off';

                        $parent_id = $element_options['_parent'];
                        $current_id = isset($element_options['id']) ? $element_options['id'] : '';

                        $default_element_options = default_form_options($element_options['type']);

                        $field_type = isset($element_options['type']) ? $element_options['type'] : '';


                        $field_id = isset($element_options['field_id']) ? $element_options['field_id'] : '';
                        $fields_data[$field_id] = $element_options;
                        $elements_data[$field_id] = $element_options;

                        if ($field_type != 'checkbox' && $field_type != 'radio' && $field_type != 'sortable_quiz') {

                            $element_options['elements_data'] = array();

                            $element_options = array_merge($default_element_options , $element_options);

                            $element_content = isset($element_options['content']) ? $element_options['content'] : '';
                            //pre($element_content, false);
                            $attrib_arr = ( $element_content != '')? lmsParseTag($element_content , 'editor-field') : array();



                            $fields_data = array();
                            if (!empty($attrib_arr)) {
                                foreach ($attrib_arr as $attribData) {
                                    if( $field_type == 'html') {
                                        if( isset( $attribData['data-field_type'] ) && $attribData['data-field_type'] == 'select'){
                                            $data_correct = isset( $attribData['data-correct'] )? $attribData['data-correct'] : '';
                                            //$data_correct = base64_decode(trim(stripslashes($data_correct)));
                                            $attribData['data-correct'] = $data_correct;
                                        }
                                    }
                                    $id = isset($attribData['data-id']) ? $attribData['data-id'] : '';
                                    if ($id != '') {
                                        $fields_data[$id] = $attribData;
                                        $elements_data[$id] = $attribData;
                                    }
                                }
                            }
                        }

                        $element_options['elements_data'] = $fields_data;


                        $questions_array[$parent_id][] = $element_options;
                    } else {
                        $col_id = isset($element_options['id']) ? $element_options['id'] : '';
                        $columns_array[$col_id] = $element_options;
                    }
                }
            }
            //pre('test');
        }

        $layout_elements_layout = json_encode($elements_array);
        $form_pages = array();
        $default_page_options = default_form_options("page" , $chapters_list);
        $default_page_confirmation_options = default_form_options("page-confirmation" , $chapters_list);


        $questionData = $_POST;
        $search_tags = (isset( $questionData['search_tags'] ) && $questionData['search_tags'] != '')? explode(',',$questionData['search_tags']) : array();
        $search_tags = implode(' | ', $search_tags);
        $quiz_id = isset($questionData['chapter_id']) ? $questionData['chapter_id'] : 0;
        $new_glossaries = isset($questionData['new_glossaries']) ? $questionData['new_glossaries'] : array();

        if (!empty($new_glossaries)) {
            foreach ($new_glossaries as $glossary_id) {
                $glossary = Glossary::findOrFail($glossary_id);
                $glossary->update([
                    'question_id' => $quistionObj->id ,
                ]);
            }
        }

        $quiz_id = ($quiz_id > 0) ? $quiz_id : 0;

        //pre($elements_data);

		$difficulty_level = isset($questionData['difficulty_level']) ? $questionData['difficulty_level'] : '';
		$category_id = isset( $questionData['category_id'] )? $questionData['category_id'] : array();
		$question_levels = get_question_levels($category_id, $difficulty_level);
		$category_id = json_encode($category_id);

		
        $quiz = Quiz::find($quiz_id);
        $quizQuestion = $quistionObj->update([
            'quiz_id'                   => $quiz_id ,
            'grade'                     => '' ,
            'question_year'             => 0 ,
            'question_score'            => (isset($questionData['question_score']) && $questionData['question_score'] != '') ? $questionData['question_score'] : 1 ,
            'question_average_time'     => (isset($questionData['question_average_time']) && $questionData['question_average_time'] != '') ? $questionData['question_average_time'] : 1 ,
            'question_difficulty_level' => isset($questionData['difficulty_level']) ? $questionData['difficulty_level'] : '' ,
            'question_template_type'    => 'sum_quiz' , //isset( $questionData['type'] )? $questionData['type'] : '',
            'chapter_id'                => (isset($questionData['chapter_id']) && $questionData['chapter_id'] != '') ? $questionData['chapter_id'] : 0 ,
            'question_title'            => isset($questionData['question_title']) ? $questionData['question_title'] : '' ,
            'question_layout'           => isset($_POST['question_layout']) ? $_POST['question_layout'] : '' , //isset( $questionData['content'] )? $questionData['content'] : '',
            'question_solve'            => isset($questionData['question_solve']) ? $questionData['question_solve'] : '' ,
            'glossary_ids'              => isset($_POST['glossary_ids']) ? json_encode($_POST['glossary_ids']) : '' ,
            'elements_data'             => json_encode($elements_data) ,
            'layout_elements'           => $layout_elements_layout ,
            'category_id'               => $category_id,
            'course_id'                 => (isset($questionData['course_id']) && $questionData['course_id'] != '') ? $questionData['course_id'] : 0 ,
            'sub_chapter_id'            => (isset($questionData['sub_chapter_id']) && $questionData['sub_chapter_id'] != '') ? $questionData['sub_chapter_id'] : 0 ,
            'type'                      => 'descriptive' ,
            'updated_at'                => time() ,
            'question_status'           => (isset($questionData['question_status']) && $questionData['question_status'] != '') ? $questionData['question_status'] : 'Draft' ,
            'comments_for_reviewer'     => (isset($questionData['comments_for_reviewer']) && $questionData['comments_for_reviewer'] != '') ? $questionData['comments_for_reviewer'] : '',
            'search_tags'              => $search_tags,
            'review_required'              => isset($questionData['review_required']) ? $questionData['review_required'] : 0 ,
            'question_example'            => isset($questionData['question_example']) ? $questionData['question_example'] : '' ,
            'question_type'            => isset($questionData['question_type']) ? $questionData['question_type'] : '' ,
            'example_question'            => isset($questionData['example_question']) && !empty($questionData['example_question']) ? $questionData['example_question'] : 0,
            'reference_type'            => isset($questionData['reference_type']) && !empty($questionData['reference_type']) ? $questionData['reference_type'] : 'Course',
            'question_levels'            => $question_levels,
            'developer_review_required'           => isset($questionData['developer_review_required']) ? $questionData['developer_review_required'] : 0 ,
            'hide_question'           => isset($questionData['hide_question']) ? $questionData['hide_question'] : 0 ,
        ]);

        if (!empty($quizQuestion)) {
            QuizzesQuestionTranslation::updateOrCreate([
                'quizzes_question_id' => $question_id ,
                'locale'              => 'en' ,
            ] , [
                'title'   => isset($questionData['question_title']) ? $questionData['question_title'] : '' ,
                'correct' => '' ,
            ]);

            QuestionLogs::create([
                'question_id' => $quistionObj->id ,
                'action_type' => 'Updated = ' . $quistionObj->question_status ,
                'action_role' => $user->role_name ,
                'log_data'    => (isset($questionData['comments_for_reviewer']) && $questionData['comments_for_reviewer'] != '') ? $questionData['comments_for_reviewer'] : '' ,
                'action_by'   => $user->id ,
                'action_at'   => time()
            ]);
        }
		
		$subChapterObj = SubChapters::find($quistionObj->sub_chapter_id);
		$sub_chapter_quiz_id = isset( $subChapterObj->quizData->item_id )? $subChapterObj->quizData->item_id : 0;
		
		if( $sub_chapter_quiz_id > 0){
			
			$list_counts = QuizzesQuestionsList::where('question_id', $quistionObj->id)->where('quiz_id',$sub_chapter_quiz_id)->count();
			if( $list_counts == 0){
				QuizzesQuestionsList::create([
					'quiz_id'     => $sub_chapter_quiz_id,
					'question_id' => $quistionObj->id,
					'status'      => 'active',
					'sort_order'  => 0,
					'created_by'  => $user->id,
					'created_at'  => time()
				]);
			}
		}
		
		
        $redirectUrl = '/admin/questions_bank/' . $question_id . '/edit';
        //$redirectUrl = '/admin/questions_bank/';
        return response()->json([
            'code'         => 200 ,
            'redirect_url' => $redirectUrl
        ]);
    }

    public function question_file_upload(Request $request)
    {
        pre($_FILES);
    }

    public function store(Request $request)
    {
        $this->authorize('admin_questions_bank_create');

        $data = $request->all();
        $locale = $request->get('locale' , getDefaultLocale());

        $rules = [
            'title'      => 'required|max:255' ,
            'webinar_id' => 'required|exists:webinars,id' ,
            'pass_mark'  => 'required' ,
        ];

        if ($request->ajax()) {
            $data = $request->get('ajax');

            $validate = Validator::make($data , $rules);

            if ($validate->fails()) {
                return response()->json([
                    'code'   => 422 ,
                    'errors' => $validate->errors()
                ] , 422);
            }
        } else {
            $this->validate($request , $rules);
        }




        $webinar = Webinar::where('id' , $data['webinar_id'])
            ->first();

        if (!empty($webinar)) {
            $chapter = null;

            if (!empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id' , $data['chapter_id'])
                    ->where('webinar_id' , $webinar->id)
                    ->first();
            }

            $quiz = Quiz::create([
                'webinar_id'    => $webinar->id ,
                'chapter_id'    => !empty($chapter) ? $chapter->id : null ,
                'creator_id'    => $webinar->creator_id ,
                'webinar_title' => $webinar->title ,
                'attempt'       => $data['attempt'] ?? null ,
                'pass_mark'     => $data['pass_mark'] ,
                'time'          => $data['time'] ?? null ,
                'status'        => (!empty($data['status']) and $data['status'] == 'on') ? Quiz::ACTIVE : Quiz::INACTIVE ,
                'certificate'   => (!empty($data['certificate']) and $data['certificate'] == 'on') ,
                'created_at'    => time() ,
            ]);

            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id ,
                'locale'  => mb_strtolower($locale) ,
            ] , [
                'title' => $data['title'] ,
            ]);

            if (!empty($quiz->chapter_id)) {
                WebinarChapterItem::makeItem($webinar->creator_id , $quiz->chapter_id , $quiz->id , WebinarChapterItem::$chapterQuiz);
            }

            if ($request->ajax()) {

                $redirectUrl = '';

                if (empty($data['is_webinar_page'])) {
                    $redirectUrl = '/admin/quizzes/' . $quiz->id . '/edit';
                }

                return response()->json([
                    'code'         => 200 ,
                    'redirect_url' => $redirectUrl
                ]);
            } else {
                return redirect()->route('adminEditQuiz' , ['id' => $quiz->id]);
            }
        } else {
            return back()->withErrors([
                'webinar_id' => trans('validation.exists' , ['attribute' => trans('admin/main.course')])
            ]);
        }
    }

    public function edit(Request $request , $id)
    {
        $user = auth()->user();
        $this->authorize('admin_questions_bank_edit');
        Cache::put('mediaFolder', $id);


        $question = QuizzesQuestion::findOrFail($id);

        $questionLogs = QuestionLogs::where('question_id' , $id)->orderBy('id' , 'desc')->with('user')
            ->get();

        $created_at = $question->created_at;

        $time_passed = TimeDifference($created_at , time() , 'minutes');


        /*if (($question->question_status != 'Draft' && $question->question_status != 'Improvement required') && auth()->user()->isAuthor()) {
            if ($user->id != $question->creator_id || $time_passed > 20 || in_array($question->question_status , array('Submit for review' , 'Improvement required')) == false) {
                $toastData = [
                    'title'  => 'Request not completed' ,
                    'msg'    => 'You dont have permissions to perform this action.' ,
                    'status' => 'error'
                ];
                return redirect()->back()->with(['toast' => $toastData]);
            }
        }*/

        $query = Webinar::query();

        $chapters_list = get_chapters_list();


        $form_elements = json_decode($question->layout_elements , true);
        if (is_array($form_elements)) {
            foreach ($form_elements as $key => $form_element_raw) {
                //pre($form_element_raw);
                $element_options = $form_element_raw; //json_decode($form_element_raw, true);

                if (is_array($element_options) && array_key_exists('type' , $element_options)) {
                    $default_element_options = default_form_options($element_options['type']);
                    $element_options = array_merge($default_element_options , $element_options);
                    $form_elements[$key] = json_encode($element_options);
                } else
                    unset($form_elements[$key]);
            }
            $form_elements = array_values($form_elements);
        } else
            $form_elements = array();

        if (auth()->user()->isAuthor()) {
            $glossary = Glossary::where('status' , 'active')->orWhere('created_by' , $user->id)
                ->get();
        } else {
            $glossary = Glossary::whereIn('status' , array('active' , 'draft'))
                ->get();
        }

        $glossary_ids = is_array($question->glossary_ids) ? $question->glossary_ids : json_decode($question->glossary_ids);
        $glossary_ids = is_array($glossary_ids) ? $glossary_ids : array($glossary_ids);

        $categories = Category::where('parent_id' , null)
            ->with('subCategories')
            ->get();

        $data = [
            'pageTitle'                 => trans('public.edit') . ' ' . $question->title ,
            'question_difficulty_level' => $question->question_difficulty_level ,
            'question_type' => $question->question_type ,
            'question_score'            => $question->question_score ,
            'chapter_db_id'             => $question->chapter_id ,
            'question_title'            => $question->question_title ,
            'question_average_time'     => $question->question_average_time ,
            'question_layout'           => $question->question_layout ,
            'elements_data'             => $question->elements_data ,
            'layout_elements'           => $form_elements ,
            'question_solve'            => $question->question_solve ,
            'question_example'            => $question->question_example ,
            'reference_type'            => $question->reference_type ,
            'glossary_ids'              => $glossary_ids ,
            'chapters'                  => $chapters_list ,
            'categories'                => $categories ,
            'questionObj'               => $question ,
            'questionLogs'              => $questionLogs ,
            'user'                      => $user ,
        ];
        $data['glossary'] = $glossary;

        return view('admin.questions_bank.create_question' , $data);
    }

    public function log(Request $request , $id)
    {
        $user = auth()->user();
        $this->authorize('admin_questions_bank_edit');

        $questionObj = QuizzesQuestion::findOrFail($id);

        $questionLogs = QuestionLogs::where('question_id' , $id)->orderBy('id' , 'desc')->with('user')
            ->get();


        $data = [
            'pageTitle'    => 'Logs for ' . $questionObj->title ,
            'questionObj'  => $questionObj ,
            'questionLogs' => $questionLogs ,
            'user'         => $user ,
        ];

        return view('admin.questions_bank.log' , $data);
    }

    public function update(Request $request , $id)
    {
        $rules = [
            'title'      => 'required|max:255' ,
            'webinar_id' => 'required|exists:webinars,id' ,
            'pass_mark'  => 'required' ,
        ];

        $data = $request->all();
        $locale = $request->get('locale' , getDefaultLocale());

        if ($request->ajax()) {
            $data = $request->get('ajax');

            $validate = Validator::make($data , $rules);

            if ($validate->fails()) {
                return response()->json([
                    'code'   => 422 ,
                    'errors' => $validate->errors()
                ] , 422);
            }
        } else {
            $this->validate($request , $rules);
        }

        $quiz = Quiz::find($id);
        $user = $quiz->creator;

        $webinar = null;
        $chapter = null;
        if (!empty($data['webinar_id'])) {
            $webinar = Webinar::where('id' , $data['webinar_id'])
                ->where(function ($query) use ($user) {
                    $query->where('teacher_id' , $user->id)
                        ->orWhere('creator_id' , $user->id);
                })->where('status' , 'active')
                ->first();

            if (!empty($webinar) and !empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id' , $data['chapter_id'])
                    ->where('webinar_id' , $webinar->id)
                    ->first();
            }
        }

        $quiz->update([
            'webinar_id'    => !empty($webinar) ? $webinar->id : null ,
            'chapter_id'    => !empty($chapter) ? $chapter->id : null ,
            'webinar_title' => !empty($webinar) ? $webinar->title : null ,
            'attempt'       => $data['attempt'] ?? null ,
            'pass_mark'     => $data['pass_mark'] ,
            'time'          => $data['time'] ?? null ,
            'status'        => (!empty($data['status']) and $data['status'] == 'on') ? Quiz::ACTIVE : Quiz::INACTIVE ,
            'certificate'   => (!empty($data['certificate']) and $data['certificate'] == 'on') ? true : false ,
            'updated_at'    => time() ,
        ]);

        if (!empty($quiz)) {
            QuizTranslation::updateOrCreate([
                'quiz_id' => $quiz->id ,
                'locale'  => mb_strtolower($locale) ,
            ] , [
                'title' => $data['title'] ,
            ]);

            $checkChapterItem = WebinarChapterItem::where('user_id' , $user->id)
                ->where('item_id' , $quiz->id)
                ->where('type' , WebinarChapterItem::$chapterQuiz)
                ->first();

            if (!empty($quiz->chapter_id)) {
                if (empty($checkChapterItem)) {
                    WebinarChapterItem::makeItem($user->id , $quiz->chapter_id , $quiz->id , WebinarChapterItem::$chapterQuiz);
                } elseif ($checkChapterItem->chapter_id != $quiz->chapter_id) {
                    $checkChapterItem->delete(); // remove quiz from old chapter and assign it to new chapter

                    WebinarChapterItem::makeItem($user->id , $quiz->chapter_id , $quiz->id , WebinarChapterItem::$chapterQuiz);
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

    public function delete(Request $request , $id)
    {
        $user = auth()->user();
        //$this->authorize('admin_questions_bank_delete');

        $questionObj = QuizzesQuestion::findOrFail($id);
        $created_at = $questionObj->created_at;

        $time_passed = TimeDifference($created_at , time() , 'minutes');

        if ($user->id != $questionObj->creator_id || $time_passed > 20) {

            $toastData = [
                'title'  => 'Request not completed' ,
                'msg'    => 'You dont have permissions to perform this action.' ,
                'status' => 'error'
            ];
            return redirect()->back()->with(['toast' => $toastData]);
        } else {
            QuestionLogs::create([
                'question_id' => $id ,
                'action_type' => 'Deleted' ,
                'action_role' => $user->role_name ,
                'action_by'   => $user->id ,
                'action_at'   => time()
            ]);
            $questionObj->update([
                'question_status' => 'Deleted'
            ]);
            return redirect()->back();
        }
    }

    public function question_status_submit(Request $request)
    {
        $user = auth()->user();
        $points_details = array();
        $points = 0;
        $question_id = $request->input('question_id');
        $questionObj = QuizzesQuestion::find($question_id);
        $question_status = $request->input('question_status');
        $publish_question = $request->input('publish_question');
        $status_details = $request->input('status_details');
        $log_storred_data = $status_details;
        $log_data = $status_details;

        $glossary = Glossary::where('question_id' , $question_id)->where('status' , 'draft')->get();


        switch ($request->input('question_status')) {

            case    "Accepted":

                $image_question_points = ($request->input('image_question') == 1) ? 5 : 0;
                $word_problem_points = ($request->input('word_problem') == 1) ? 5 : 0;

                $glossary_points = ($request->input('new_glossary') == 1) ? 5 : 0;
                $glossary_points = ($request->input('glossary_with_illustration') == 1) ? 10 : $glossary_points;

                $solution = $request->input('solution');
                $solution_points = ($solution == 'Appropriate') ? 5 : 0;
                $solution_points = ($solution == 'Aspirational') ? 10 : $solution_points;

                $difficulty_level = $request->input('difficulty_level');
                $difficulty_level_points = ($difficulty_level == 'Medium') ? 5 : 0;
                $difficulty_level_points = ($difficulty_level == 'Expert') ? 10 : $difficulty_level_points;

                $points_details = array(
                    'Image Question'         => $image_question_points ,
                    'Word Problem'           => $word_problem_points ,
                    'New Glossary'           => $glossary_points ,
                    'Solution'               => $solution_points ,
                    'Difficulty Level'       => $difficulty_level_points ,
                    'Solution Label'         => $solution ,
                    'Difficulty Level Label' => $difficulty_level ,
                    'status_details'         => $status_details ,
                );

                $points = 20 + $image_question_points + $word_problem_points + $glossary_points + $solution_points + $difficulty_level_points;
                $log_storred_data = json_encode($points_details);

                QuestionAuthorPoints::create([
                    'question_id'    => $questionObj->id ,
                    'author_id'      => $questionObj->creator_id ,
                    'points_details' => json_encode($points_details) ,
                    'points'         => $points ,
                    'created_by'     => $user->id ,
                    'created_at'     => time()
                ]);

                $userObj = User::find($questionObj->creator_id);
                $userObj->update([
                    'author_points' => $userObj->author_points + $points
                ]);

                $question_status = 'Offline';
                if ($publish_question == 1) {
                    $question_status = 'Published';
                }

                if (!empty($glossary)) {
                    foreach ($glossary as $glossaryObj) {
                        $glossaryObj->update([
                            'status' => 'active'
                        ]);
                    }
                }

                break;
        }

        $questionObj->update([
            'question_status' => $question_status
        ]);


        QuestionLogs::create([
            'question_id'      => $questionObj->id ,
            'action_type'      => 'Status Updated - ' . $question_status ,
            'action_role'      => $user->role_name ,
            'log_data'         => $log_data ,
            'log_storred_data' => $log_storred_data ,
            'action_by'        => $user->id ,
            'action_at'        => time()
        ]);

        $redirectUrl = '/admin/questions_bank';
        return response()->json([
            'code'        => 200 ,
            'redirect_to' => $redirectUrl ,
        ]);
    }

    public function question_status_update(Request $request)
    {
        $user = auth()->user();
        $question_id = $request->input('question_id');
        $question_status = $request->input('question_status');
        $questionObj = QuizzesQuestion::find($question_id);

        $questionObj->update([
            'question_status' => $question_status
        ]);

        QuestionLogs::create([
            'question_id'      => $questionObj->id ,
            'action_type'      => 'Status Updated - ' . $question_status ,
            'action_role'      => $user->role_name ,
            'log_data'         => '' ,
            'log_storred_data' => '' ,
            'action_by'        => $user->id ,
            'action_at'        => time()
        ]);
        return response()->json([
            'code' => 200 ,
        ]);
    }

    public function duplicate(Request $request , $id)
    {
		$user = auth()->user();
        $question = QuizzesQuestion::findOrFail($id);
        $question_title_new = $question->question_title . ' - Duplicate';
        $question->load('listQuestions');
        $new_question = $question->replicate();
        $new_question->created_at = time();
        $new_question->push();

        foreach ($question->getRelations() as $relation => $items) {
            foreach ($items as $item) {
                unset($item->id);
                $new_question->{$relation}()->create($item->toArray());
            }
        }

        $new_question->update([
            'question_title' => $question_title_new ,
        ]);
        if (!empty($new_question)) {
            QuizzesQuestionTranslation::updateOrCreate([
                'quizzes_question_id' => $new_question->id ,
                'locale'              => 'en' ,
            ] , [
                'title'   => $question_title_new ,
                'correct' => '' ,
            ]);
        }
		
		$subChapterObj = SubChapters::find($new_question->sub_chapter_id);
		$sub_chapter_quiz_id = isset( $subChapterObj->quizData->item_id )? $subChapterObj->quizData->item_id : 0;
		
		if( $sub_chapter_quiz_id > 0){
			QuizzesQuestionsList::create([
				'quiz_id'     => $sub_chapter_quiz_id,
				'question_id' => $new_question->id,
				'status'      => 'active',
				'sort_order'  => 0,
				'created_by'  => $user->id,
				'created_at'  => time()
			]);
		}
		
		
        //pre($new_question);
        return redirect()->back();
    }

    public function search_bk(Request $request)
    {
        $term = $request->get('term');

        $response = Elasticsearch::search([
           'index' => 'questions',
           'body'  => [
               "size" => 100,
               'query' => [
                   'query_string' => [
                       'query' => $term.'*',
                       'fields' => [
                           'title','difficulty_level','class','course','topic'
                       ]
                   ]
               ]
           ]
       ]);
       $questionIds = array_column($response['hits']['hits'], '_source', '_id');
        //pre($questionIds);
       return response()->json($questionIds , 200);
    }

    public function search(Request $request)
    {
        $term = $request->get('term');

        $term_array = explode(',', $term);

        //DB::enableQueryLog();
        $questionIds = QuizzesQuestion::where('question_status', '!=', '');
        if( !empty( $term_array ) ){
            foreach( $term_array as $term_data){
                $questionIds->where('question_title', 'like', '%'.$term_data.'%')->orWhere('search_tags', 'like', '%'.$term_data.'%');
                //$questionIds->where('search_tags', 'like', '%'.$term_data.'%');
            }
        }
        $questionIds    = $questionIds->get();
        //pre(DB::getQueryLog());
        //DB::disableQueryLog();
        $questions_array = array();
        if( !empty( $questionIds ) ){
            foreach( $questionIds as $questionObj){

                $search_tags = ( isset( $questionObj->search_tags ) && $questionObj->search_tags != '')? explode( ' | ', $questionObj->search_tags) : array();
                $search_keywords = '';
                if( !empty( $search_tags ) ){
                    foreach( $search_tags as $tag_value){
                        $search_keywords .= '<li>'. $tag_value .'</li>';
                    }
                }


                $questions_array[$questionObj->id]  = array(
                    'id' => $questionObj->id,
                    'title' => $questionObj->question_title,
                    'question_difficulty_level' => $questionObj->question_difficulty_level,
                    'question_type' => $questionObj->question_type,
                    'search_tags' => $search_keywords,
                );
            }
        }


       return response()->json($questions_array , 200);
    }

    public function get_questions_by_ids(Request $request)
    {
        $questions_ids = $request->get('questions_ids');

        $questions_ids = ($questions_ids != '') ? explode(',' , $questions_ids) : array();


        $questions = QuizzesQuestion::select('id' , 'question_title as text')->whereIn('id' , $questions_ids);

        return response()->json($questions->get() , 200);
    }

    public function results($id)
    {
        $this->authorize('admin_quizzes_results');

        $quizzesResults = QuizzesResult::where('quiz_id' , $id)
            ->with([
                'quiz' => function ($query) {
                    $query->with(['teacher']);
                } ,
                'user'
            ])
            ->orderBy('created_at' , 'desc')
            ->paginate(10);

        $data = [
            'pageTitle'      => trans('admin/pages/quizResults.quiz_result_list_page_title') ,
            'quizzesResults' => $quizzesResults ,
            'quiz_id'        => $id
        ];

        return view('admin.quizzes.results' , $data);
    }

    public function resultsExportExcel($id)
    {
        $this->authorize('admin_quiz_result_export_excel');

        $quizzesResults = QuizzesResult::where('quiz_id' , $id)
            ->with([
                'quiz' => function ($query) {
                    $query->with(['teacher']);
                } ,
                'user'
            ])
            ->orderBy('created_at' , 'desc')
            ->get();

        $export = new QuizResultsExport($quizzesResults);

        return Excel::download($export , 'quiz_result.xlsx');
    }

    public function resultDelete($result_id)
    {
        $this->authorize('admin_quizzes_results_delete');

        $quizzesResults = QuizzesResult::where('id' , $result_id)->first();

        if (!empty($quizzesResults)) {
            $quizzesResults->delete();
        }

        return redirect()->back();
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('admin_quizzes_lists_excel');

        $query = Quiz::query();

        $query = $this->filters($query , $request);

        $quizzes = $query->with([
            'webinar' ,
            'teacher' ,
            'quizQuestions' ,
            'quizResults' ,
        ])->get();

        return Excel::download(new QuizzesAdminExport($quizzes) , trans('quiz.quizzes') . '.xlsx');
    }

    public function sub_chapters_create_cron()
    {
        $query = Quiz::query();

        $quizzes = $query->with([
            'webinar' ,
        ])
            ->join('quiz_translations' , 'quiz_translations.quiz_id' , '=' , 'quizzes.id')
            ->select('quizzes.*' , 'quiz_translations.title')
            ->paginate(200);


        if (!empty($quizzes)) {
            foreach ($quizzes as $quizzData) {
                $quizObj = Quiz::find($quizzData->id);
                $question_title = $quizzData->title;
                $webinar_id = $quizzData->webinar_id;
                $chapter_id = $quizzData->chapter_id;
                $chapter_settings = '{\"Below\":{\"questions\":\"10\",\"points\":\"10\"},\"Emerging\":{\"questions\":\"20\",\"points\":\"20\"},\"Expected\":{\"questions\":\"30\",\"points\":\"30\"},\"Exceeding\":{\"questions\":\"15\",\"points\":\"20\"},\"Challenge\":{\"questions\":\"10\",\"points\":\"10\"}}';

                $SubChapterObj = SubChapters::create([
                    'webinar_id'        => $webinar_id ,
                    'chapter_id'        => $chapter_id ,
                    'sub_chapter_title' => $question_title ,
                    'chapter_settings'  => $chapter_settings ,
                    'status'            => 'active' ,
                    'created_at'        => time()
                ]);

                $WebinarChapterItemObj = WebinarChapterItem::create([
                    'user_id'    => 929 ,
                    'chapter_id' => $chapter_id ,
                    'item_id'    => $SubChapterObj->id ,
                    'type'       => 'sub_chapter' ,
                    'order'      => 1 ,
                    'created_at' => time()
                ]);

                $quizObjNew = $quizObj->update([
                    'sub_chapter_id' => $SubChapterObj->id ,
                ]);
            }
        }
        pre('all done');
    }

}
