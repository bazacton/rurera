<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BooksUserPagesInfoLinks extends Model
{

    protected $table = 'books_user_pages_info_links';
    public $timestamps = false;

    protected $fillable = ['user_id' , 'book_info_link_id' , 'status' , 'created_by' , 'created_at'];

}
