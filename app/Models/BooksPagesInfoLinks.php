<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BooksPagesInfoLinks extends Model
{

    protected $table = 'books_pages_info_links';
    public $timestamps = false;

    protected $fillable = ['book_id' , 'page_id' , 'info_title' , 'info_type' , 'info_style' , 'created_by' , 'created_at'];

}
