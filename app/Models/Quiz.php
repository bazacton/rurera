<?php

namespace App\Models;

use App\Http\Controllers\Web\QuestionsAttemptController;
use App\Models\Traits\SequenceContent;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Quiz extends Model implements TranslatableContract
{
    use Translatable;
    use SequenceContent;
    use Sluggable;

    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    public $timestamps = false;
    protected $table = 'quizzes';
    protected $guarded = ['id'];

    public $translatedAttributes = ['title'];

    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this , 'title');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return ['quiz_slug' => ['source' => 'title']];
    }

    public static function makeSlug($title, $id = 0)
    {
        $slug = strtolower(SlugService::createSlug(self::class, 'quiz_slug', $title));
        return $slug;
    }
    public static function makeSlug_bk($title, $id = 0)
    {
        $slug = strtolower(SlugService::createSlug(self::class, 'quiz_slug', $title));
        $count = Quiz::where('quiz_slug', $slug);
        if( $id > 0){
            $count = $count->where('id', '!=', $id ?? 0);
        }
        $count = $count->count();
        if ($count > 0) {
            $slug = $slug . '-' . uniqid();
        }
        return $slug;
    }

    public function quizQuestionsList()
    {

        return $this->hasMany('App\Models\QuizzesQuestionsList' , 'quiz_id' , 'id')->where('status', 'active')->orderBy('sort_order', 'ASC');
    }

    public function quizYear()
    {
        return $this->belongsTo('App\Models\Category' , 'year_id' , 'id');
    }

    public function quizQuestions()
    {
        return $this->hasMany('App\Models\QuizzesQuestion' , 'quiz_id' , 'id');
    }

    public function quizResults()
    {
        return $this->hasMany('App\Models\QuizzesResult' , 'quiz_id' , 'id');
    }

    public function parentResults()
    {
        return $this->hasMany('App\Models\QuizzesResult' , 'parent_type_id' , 'id');
    }

    public function parentResultsQuestions()
    {
        return $this->hasMany('App\Models\QuizzResultQuestions', 'parent_type_id', 'id')
            ->where('status', 'correct');
    }

    public function creator()
    {
        return $this->belongsTo('App\User' , 'creator_id' , 'id');
    }

    public function webinar()
    {
        return $this->belongsTo('App\Models\Webinar' , 'webinar_id' , 'id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\User' , 'creator_id' , 'id');
    }

    public function vocabulary_achieved_levels()
    {
        return $this->hasOne('App\Models\UsersAchievedLevels', 'parent_id', 'id')->where('parent_type', 'vocabulary');
    }


    public function certificates()
    {
        return $this->hasMany('App\Models\Certificate' , 'quiz_id' , 'id');
    }

    public function chapter()
    {
        return $this->belongsTo('App\Models\WebinarChapter' , 'chapter_id' , 'id');
    }

    public function topic()
    {
        return $this->belongsTo('App\Models\WebinarChapter' , 'topic_id' , 'id');
    }


    public function increaseTotalMark($grade)
    {
        $total_mark = $this->total_mark + $grade;
        return $this->update(['total_mark' => $total_mark]);
    }

    public function decreaseTotalMark($grade)
    {
        $total_mark = $this->total_mark - $grade;
        return $this->update(['total_mark' => $total_mark]);
    }

    public function getUserCertificate($user , $quiz_result)
    {
        if (!empty($user) and !empty($quiz_result)) {
            return Certificate::where('quiz_id' , $this->id)->where('student_id' , $user->id)->where('quiz_result_id' , $quiz_result->id)->first();
        }

        return null;
    }
	
	public function vocabulary_words()
    {
		
		$words_list = $words_response = array();
		if (!empty($this->quizQuestionsList)) {
            foreach ($this->quizQuestionsList as $questionsListData) {
				$SingleQuestionData = $questionsListData->SingleQuestionData;
				$layout_elements = isset($SingleQuestionData->layout_elements) ? json_decode($SingleQuestionData->layout_elements) : array();
				$correct_answer = $audio_file = $word_audio_file = $audio_text = $audio_sentense = $audio_defination = '';
				
				if (!empty($layout_elements)) {
                    foreach ($layout_elements as $elementData) {
						$element_type = isset($elementData->type) ? $elementData->type : '';
                        $correct_answer = isset($elementData->correct_answer) ? $elementData->correct_answer : $correct_answer;
						$content = isset($elementData->content) ? $elementData->content : '';
                        $word_audio = isset($elementData->word_audio) ? $elementData->word_audio : '';
                        $audio_text = isset($elementData->audio_text) ? $elementData->audio_text : $audio_text;
                        $audio_sentense = isset($elementData->audio_sentense) ? $elementData->audio_sentense : $audio_sentense;
                        $audio_defination = isset($elementData->audio_defination) ? $elementData->audio_defination : $audio_defination;
						if ($element_type == 'audio_file') {
                            $audio_file = $content;
                            $word_audio_file = $word_audio;
                            $audio_text = $audio_text;
                            $audio_sentense = $audio_sentense;
                            $audio_defination = $audio_defination;
                        }
						if ($element_type == 'textfield_quiz') {
                            $correct_answer = $correct_answer;
                        }
						$words_list[$SingleQuestionData->id] = $correct_answer;
                    }
                }
				
				$audio_sentense = str_replace($audio_text, '<strong>' . $audio_text . '</strong>', $audio_sentense);
                $audio_sentense = str_replace(strtolower($audio_text), '<strong>' . strtolower($audio_text) . '</strong>', $audio_sentense);
				$phonics_text = $phonics_sounds = '';
                $phonics_array = get_words_phonics($audio_text);
                $phonics_counter = 1;
                if( !empty( $phonics_array ) ){
                    foreach( $phonics_array as $phonic_data){
						
						$phonics_text .= '<div class="word-char">';
						$phonics_text .= '<span class="pronounce-letter">';
                        $phonics_text .= isset( $phonic_data['letter'] )? $phonic_data['letter']: '';
						$phonics_text .= '</span><span class="pronounce-word">';
                        $phonics_text .= isset( $phonic_data['word'] )? '/'.$phonic_data['word'].'/': '';
						$phonics_text .= '</span><span class="pronounce-audio">';
                        $phonicSound = isset( $phonic_data['sound'] )? $phonic_data['sound'] : '';
						$phonics_text .= '<a href="javascript:;" class="play-btn" data-id="player-phonics-' . $SingleQuestionData->id . '-'.$phonics_counter.'">
						   <img class="play-icon" src="/assets/default/svgs/play-circle.svg" alt="" height="20" width="20">
						   <img class="pause-icon" src="/assets/default/svgs/pause-circle.svg" alt="" height="20" width="20">
						   <div class="player-box">
						   <audio class="player-box-audio" id="player-phonics-' . $SingleQuestionData->id . '-'.$phonics_counter.'" src="/phonics/'.$phonicSound.'"></audio>
						   </div>
					   </a></span>';
						$phonics_text .= '</div>';
                        $phonics_counter++;
                    }
                }
				
				$words_response[$SingleQuestionData->id] = '<tr>
                   <td>
                   <strong>Word:</strong> <a href="javascript:;" class="play-btn" data-id="player-' . $SingleQuestionData->id . '">
                       <img class="play-icon" src="/assets/default/svgs/play-circle.svg" alt="" height="20" width="20">
                       <img class="pause-icon" src="/assets/default/svgs/pause-circle.svg" alt="" height="20" width="20">
                   <div class="player-box">
                   <audio class="player-box-audio" id="player-' . $SingleQuestionData->id . '" src="' . $word_audio_file . '"> </audio>
                   </div>
                   </a>
                   </td>
                   <td>' . $audio_text . '<br>
                   '.$phonics_text.'</td>
                   <td>
                  <p><strong>Definition:</strong> ' . $audio_defination . '</p>
                  </td>
                   <td>
                   <p><strong>Sentence:</strong> ' . $audio_sentense . '</p>
                   </td>
               </tr>';
				
				
			}
		}
		return array('words_list' => $words_list, 'words_response' => $words_response);
	}

    static function getQuizPercentage($SubChapterID, $all_data = false)
    {
        $user = auth()->user();
        $chapterItem = WebinarChapterItem::where('type', 'quiz')
            ->where('parent_id', $SubChapterID)
            ->first();

        $id = isset($chapterItem->item_id) ? $chapterItem->item_id : 0;

        $quizObj = Quiz::find($id);

        $quiz_settings = isset( $quizObj->quiz_settings)? json_decode($quizObj->quiz_settings) : array();
        $quiz_total_questions = 0;

        $quiz_total_questions += isset($quiz_settings->Emerging->questions) ? $quiz_settings->Emerging->questions : 0;
        $quiz_total_questions += isset($quiz_settings->Expected->questions) ? $quiz_settings->Expected->questions : 0;
        $quiz_total_questions += isset($quiz_settings->Exceeding->questions) ? $quiz_settings->Exceeding->questions : 0;


        $quizResults = isset( $quizObj->parentResults )? $quizObj->parentResults->where('user_id',$user->id)->last() : array();
        $completion_count = isset( $quizObj->parentResults )? $quizObj->parentResults->where('user_id',$user->id)->where('is_completed',1)->count() : 0;
        //pre($completion_count);
        $resultObj = $quizResults;
        $quiz_percentage = 0;
        $total_questions_count = $total_correct_questions = 0;

        if( isset( $resultObj->id ) ){
            $total_questions = count(json_decode($resultObj->questions_list));
            $correct_questions = $resultObj->quizz_result_questions_list->where('status','correct')->where('user_id',$user->id)->count();
            $total_questions_count += $total_questions;
            $total_correct_questions += $correct_questions;
            $percentage = ($correct_questions * 100)/$quiz_total_questions;
            $quiz_percentage = ($quiz_percentage <= $percentage)? round($percentage) : $quiz_percentage;
            $quiz_percentage = ($quiz_percentage > 100)? 100 : $quiz_percentage;
            $quiz_percentage = ($quiz_percentage < 0)? 0 : $quiz_percentage;
            if( $quiz_percentage == 100){
                $resultObj->update(['is_completed' => 1]);
            }
        }
        //pre($total_questions_count, false);
        //pre($total_correct_questions);
        if( $all_data == true){
            return array(
                'topic_percentage' => $quiz_percentage,
                'total_questions_count' => $quiz_total_questions,
                'total_correct_questions' => $total_correct_questions,
                'completion_count' => $completion_count,
            );
        }else {
            return $quiz_percentage;
        }
    }
}
