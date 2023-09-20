<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NationalCurriculumTopics extends Model
{

    protected $table = 'national_curriculum_topics';
    public $timestamps = false;

    protected $fillable = [
        'national_curriculum_id',
        'national_curriculum_item_id',
        'national_curriculum_chapter_id',
        'topic_id',
        'status',
        'sort_order',
        'created_at',
    ];

    public function NationalCurriculumTopicData()
    {
        return $this->belongsTo('App\Models\SubChapters', 'topic_id', 'id');
    }

}
