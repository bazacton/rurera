<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Glossary extends Model
{

    protected $table = 'glossary';
    public $timestamps = false;
    protected $fillable = ['category_id', 'title', 'description', 'status', 'created_at','question_id','created_by'];
    
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }
    
     public function user()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
