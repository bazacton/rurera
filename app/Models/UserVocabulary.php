<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVocabulary extends Model
{

    protected $table = 'user_vocabulary';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'mastered_words',
        'in_progress_words',
        'non_mastered_words',
        'status',
        'created_by',
        'created_at',
        'updated_at',
    ];


}
