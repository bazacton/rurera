<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentsOrders extends Model
{

    protected $table = 'parents_orders';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'payment_data',
        'order_amount',
        'order_tax',
        'transaction_amount',
        'payment_frequency',
        'status',
        'created_at',
        'expiry_at',
    ];

    static $frequencyArray = array(
        '1' => 'Monthly',
        '3' => '3 Months',
        '6' => '6 Months',
        '12' => 'Yearly',
    );

    public function userSubscribed()
    {
        return $this->hasMany('App\Models\UserSubscriptions', 'order_parent_id', 'id');
    }

}
