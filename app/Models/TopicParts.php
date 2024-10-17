<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicParts extends Model
{

    public $timestamps = false;

    protected $guarded = ['id'];
	
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
