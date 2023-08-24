<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BooksPages extends Model
{

    protected $table = 'books_pages';
    public $timestamps = false;

    protected $fillable = ['book_id' , 'page_no' , 'page_title', 'page_path' , 'created_by' , 'created_at', 'sort_order'];

    public function PageInfoLinks()
    {
        return $this->hasMany('App\Models\BooksPagesInfoLinks' , 'page_id' , 'id');
    }

    public function BooksPageUserReadings()
    {
        return $this->hasOne('App\Models\BooksUserReading', 'page_id', 'id');
    }

}
