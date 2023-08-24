<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BooksPagesInfoLinks extends Model
{

    protected $table = 'books_pages_info_links';
    public $timestamps = false;

    protected $fillable = ['book_id' , 'page_id' , 'info_title' , 'info_type' , 'data_values', 'info_style' ,
'created_by' , 'created_at'];


    public function BooksInfoLinkPage()
    {
        return $this->hasOne('App\Models\BooksPages', 'id', 'page_id');
    }

}
