<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NationalCurriculumItems extends Model
{

    protected $table = 'national_curriculum_items';
    public $timestamps = false;

    protected $fillable = [
        'national_curriculum_id',
        'title',
        'sub_title',
        'status',
        'sort_order',
        'created_at',
    ];

    public function NationalCurriculumChapters()
    {
        return $this->hasMany('App\Models\NationalCurriculumChapters', 'national_curriculum_item_id', 'id')->orderBy('sort_order');
    }

}
