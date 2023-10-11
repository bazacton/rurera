<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentsQuestions extends Model
{
    protected $table = 'assignments_questions';
    public $timestamps = false;
    protected $guarded = ['id'];

    static $multiple = 'multiple';
    static $descriptive = 'descriptive';

}
