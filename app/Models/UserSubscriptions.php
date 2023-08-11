<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptions extends Model
{

    protected $table = 'user_subscriptions';
    public $timestamps = false;

    protected $fillable = [
        'buyer_id',
        'user_id',
        'order_id',
        'order_item_id',
        'subscribe_id',
        'is_courses',
        'is_timestables',
        'is_bookshelf',
        'is_sats',
        'is_elevenplus',
        'status',
        'created_at',
        'expiry_at',
    ];

    public function subscribe()
    {
        return $this->hasOne('App\Models\Subscribe', 'id', 'subscribe_id');
    }

}
