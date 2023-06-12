<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BooksPagesQuestions extends Model
{

    protected $table = 'books_pages_questions';
    public $timestamps = false;

    protected $fillable = [
        'book_id' , 'page_id' , 'books_info_links_id' , 'question_id' , 'sort_order', 'quiz_type', 'status' , 'created_by' , 'created_at'
    ];


    public function QuestionData()
    {
        return $this->hasMany('App\Models\QuizzesQuestion' , 'id' , 'question_id');
    }

}
