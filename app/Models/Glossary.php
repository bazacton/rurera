<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Glossary extends Model
{

    protected $table = 'glossary';
    public $timestamps = false;
    protected $fillable = ['category_id', 'title', 'description', 'status', 'created_at','question_id','created_by', 'subject_id', 'chapter_id', 'sub_chapter_id'];
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }
	
	public function subject()
    {
        return $this->belongsTo('App\Models\Webinar' , 'subject_id' , 'id');
    }
	
	public function chapter()
    {
        return $this->belongsTo('App\Models\WebinarChapter' , 'chapter_id' , 'id');
    }

    public function subChapter()
    {
        return $this->belongsTo('App\Models\SubChapters' , 'sub_chapter_id' , 'id');
    }
    
     public function user()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
