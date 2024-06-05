<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Books extends Model
{
    use Sluggable;

    protected $table = 'books';
    public $timestamps = false;

    protected $fillable = [
        'book_title',
        'book_slug',
        'book_pdf',
        'book_pages',
        'written_by',
        'illustrated_by',
        'publication_date',
        'cover_image',
        'words_bank',
        'reading_level',
        'reading_color',
        'age_group',
        'interest_area',
        'skill_set',
        'no_of_pages',
        'reading_points',
        'book_category',
        'created_by',
        'created_at',
        'seo_title',
        'seo_description',
        'seo_robot_access',
        'include_xml',
        'book_type',
        'year_id',
        'subject_id',
    ];

    static $book_categories = array(
        'Board Books'   => 'Board Books',
        'Picture Books' => 'Picture Books',
        'Junior Books'  => 'Junior Books',
        'Middle Grade'  => 'Middle Grade',
    );

    static $reading_level = array(
        'level 1' => 'level 1',
        'level 2' => 'level 2',
        'level 3' => 'level 3',
    );

    static $age_group = array(
        '0-3'  => '0-3',
        '3-6'  => '3-6',
        '6-9'  => '6-9',
        '9-12' => '9-12',
    );

    static $interest_area = array(
        'Sport'     => 'Sport',
        'Real-life' => 'Real-life',
        'Fiction'   => 'Fiction',
    );

    static $skill_set = array(
        'Paying Attention'        => 'Paying Attention',
        'Understanding Sentences' => 'Understanding Sentences',
        'Vocabulary'              => 'Vocabulary',
    );

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'book_slug' => [
                'source' => 'book_title'
            ]
        ];
    }

    public static function makeSlug($title)
    {
        return SlugService::createSlug(self::class, 'book_slug', $title);
    }

    public function bookPages()
    {
        return $this->hasMany('App\Models\BooksPages', 'book_id', 'id')->orderBy('sort_order')->where('status', 'active');
    }

    public function bookFinalQuiz()
    {
        return $this->hasMany('App\Models\BooksPagesQuestions', 'book_id', 'id')->orderBy('sort_order')->where('quiz_type', 'final')->where('status', 'active');
    }

    public function bookPageInfoLinks()
    {
        return $this->hasMany('App\Models\BooksPagesInfoLinks', 'book_id', 'id')->orderBy('page_id');
    }

    public function bookUserActivities()
    {
        return $this->hasMany('App\Models\BooksUserPagesInfoLinks', 'book_id', 'id');
    }

    public function BooksUserReadings()
    {
        return $this->hasMany('App\Models\BooksUserReading', 'book_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
