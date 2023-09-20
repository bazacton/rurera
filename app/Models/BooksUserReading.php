<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BooksUserReading extends Model
{

    protected $table = 'books_user_reading';
    public $timestamps = false;

    protected $fillable = ['user_id', 'book_id' , 'page_id' , 'read_time' , 'status' , 'created_at', 'updated_at'];

    public function BooksPages()
    {
        return $this->hasOne('App\Models\BooksPages', 'id', 'page_id');
    }
}
