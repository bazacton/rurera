<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class AssignmentsQuestions extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'assignments_questions';
    public $timestamps = false;
    protected $guarded = ['id'];

    static $multiple = 'multiple';
    static $descriptive = 'descriptive';

    public $translatedAttributes = ['title' , 'correct'];

    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this , 'title');
    }
}
