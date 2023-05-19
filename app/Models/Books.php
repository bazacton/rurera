<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{

    protected $table = 'books';
    public $timestamps = false;

    protected $fillable = ['book_title' , 'book_pdf' , 'book_pages' , 'created_by' , 'created_at'];

    public function bookPages()
    {
        return $this->hasMany('App\Models\BooksPages' , 'book_id' , 'id');
    }

    public function bookPageInfoLinks()
    {
        return $this->hasMany('App\Models\BooksPagesInfoLinks' , 'book_id' , 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User' , 'created_by' , 'id');
    }
}
