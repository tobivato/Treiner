<?php

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'percent_off',
        'amount_off',
        'times_redeemable_per_person',
        'times_redeemable_total',
        'coach_id',
        'redeem_by',
        'currency',
    ];

    protected $dates = [
        'redeem_by',
    ];

    public function description()
    {
        if ($this->percent_off != 0) {
            return $this->percent_off . '% off up to ' . money($this->amount_off, $this->currency);
        }
        return money($this->amount_off, $this->currency) . ' off';
    }

    public function couponPlayers()
    {
        return $this->hasMany(CouponPlayer::class, 'coupon_id', 'code');
    }

    public function calculateDiscount(int $fee)
    {
        if ($this->percent_off != 0) {
            $discount = $fee * ($this->percent_off / 100);
            if (intval($discount) <= $this->amount_off) {
                return intval($discount);
            }
            else {
                return $this->amount_off;
            }
        }
        if ($this->amount_off <= $fee) {
            return $this->amount_off;
        }
        return $fee;
    }
}
