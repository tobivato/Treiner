<?php

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

class CouponPlayer extends Model
{
    protected $fillable = [
        'player_id',
        'coupon_id',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'code');
    }
}
