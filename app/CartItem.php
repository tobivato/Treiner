<?php

declare(strict_types=1);

namespace Treiner;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Represents a session that's been selected but not yet booked
 *
 */
class CartItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id', 'session_id', 'players'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->idempotency_key = Uuid::uuid4()->toString();
        });
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function couponPlayer()
    {
        return $this->belongsTo(CouponPlayer::class);
    }

    public function calculatePrice()
    {
        return $this->session->feePerPerson * $this->players;
    }

    public function getCurrencyAttribute()
    {
        return $this->session->coach->user->currency;
    }

    public function calculatePriceMinusDiscount()
    {
        return $this->calculatePrice() - $this->couponPlayer->coupon->calculateDiscount($this->calculatePrice());
    }
}
