<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NationalCurriculumChapters extends Model
{

    protected $table = 'national_curriculum_chapters';
    public $timestamps = false;

    protected $fillable = [
        'national_curriculum_id',
        'national_curriculum_item_id',
        'title',
        'status',
        'sort_order',
        'created_at',
    ];

    public function NationalCurriculumTopics()
    {
        return $this->hasMany('App\Models\NationalCurriculumTopics', 'national_curriculum_chapter_id', 'id')->orderBy('sort_order');
    }

}
