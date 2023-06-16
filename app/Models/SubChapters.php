<?php

namespace App\Models;

use App\Models\Traits\SequenceContent;
use Illuminate\Database\Eloquent\Model;

class SubChapters extends Model
{
    use SequenceContent;

    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    public $timestamps = false;
    protected $table = 'webinar_sub_chapters';
    protected $guarded = ['id'];

    /*public function quizzesItems()
    {
        return $this->hasMany($this , 'parent_id' , 'id')->orderBy('order' , 'asc');
    }*/

    public function quizzesItems()
    {
        return $this->hasMany('App\Models\WebinarChapterItem' , 'parent_id' , 'id');
    }
}
