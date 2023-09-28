<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;

class CountryLocationScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check() and auth()->user()->isAdmin()) {
            return;
        }
        $domain = request()->getHost();
        $countryCode = isset( config('countrycodes')[$domain] )? config('countrycodes')[$domain] : 'uk';
        //$countryCode = config('app.country_code');
        //$countryCode = 'uk';
        //$countryCode = 'us';
        $builder->whereJsonContains('country_location', $countryCode)->orwhereJsonContains('country_location', 'all');
    }
}