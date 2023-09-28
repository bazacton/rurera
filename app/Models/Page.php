<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CountryLocationScope;

class Page extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'pages';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];

    public $translatedAttributes = [
        'title',
        'seo_description',
        'content'
    ];

    protected static function boot()
    {
        parent::boot();
        // Apply the CountryLocationScope to the model
        static::addGlobalScope(new CountryLocationScope());
    }

    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this, 'title');
    }

    public function getSeoDescriptionAttribute()
    {
        return getTranslateAttributeValue($this, 'seo_description');
    }

    public function getContentAttribute()
    {
        return getTranslateAttributeValue($this, 'content');
    }
}
