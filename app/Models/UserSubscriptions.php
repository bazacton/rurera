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
        'order_parent_id',
        'order_item_id',
        'subscribe_id',
        'is_courses',
        'is_timestables',
        'is_bookshelf',
        'is_sats',
        'is_elevenplus',
        'is_vocabulary',
        'status',
        'created_at',
        'expiry_at',
        'child_discount',
        'charged_amount',
        'previous_packages',
        'is_cancelled',
        'cancelled_by',
        'cancelled_at',
        'next_package',
    ];

    public function subscribe()
    {
        return $this->hasOne('App\Models\Subscribe', 'id', 'subscribe_id');
    }

}
