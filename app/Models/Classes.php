<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{

    protected $table = 'classes';
    public $timestamps = false;
    protected $fillable = [
        'parent_id',
        'category_id',
        'title',
        'status',
        'created_by',
        'created_at',
        'class_code'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function sectionClass()
    {
        return $this->belongsTo('App\Models\Classes', 'parent_id', 'id');
    }

    public function sections()
    {
        return $this->hasMany('App\Models\Classes', 'parent_id', 'id');
    }

    public function teachers()
    {
        return $this->hasMany('App\Models\ClassTeachers', 'class_id', 'id');
    }

    public function users()
    {
        return $this->hasMany('App\User', 'section_id', 'id');
    }
}
