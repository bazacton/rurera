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
        'order_item_id',
        'subscribe_id',
        'status',
        'created_at',
        'expiry_at',
    ];

}
