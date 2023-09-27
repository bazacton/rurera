<?php

namespace App\Models;

use App\Models\Traits\SequenceContent;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class SubChapters extends Model
{
    use SequenceContent;
    use Sluggable;

    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    public $timestamps = false;
    protected $table = 'webinar_sub_chapters';
    protected $guarded = ['id'];

    /*public function quizzesItems()
    {
        return $this->hasMany($this , 'parent_id' , 'id')->orderBy('order' , 'asc');
    }*/

    public function quizzesItems()
    {
        return $this->hasMany('App\Models\WebinarChapterItem' , 'parent_id' , 'id');
    }

        /**
         * Return the sluggable configuration array for this model.
         *
         * @return array
         */

        public function sluggable()
        {
            return [
                'sub_chapter_slug' => [
                    'source' => 'sub_chapter_title'
                ]
            ];
        }

        public static function makeSlug($title)
        {
            return strtolower(SlugService::createSlug(self::class, 'sub_chapter_slug', $title));
        }
}
