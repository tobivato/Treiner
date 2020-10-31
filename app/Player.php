<?php

declare(strict_types=1);

namespace Treiner;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Treiner\Player
 *
 */
class Player extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'updated_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->reviews()->delete();
            $model->couponPlayers()->delete();
            $model->cartitems()->delete();
            $model->jobPosts()->forceDelete();
        });
    }

    public function clearCart()
    {
        $couponPlayers = $this->cartitems()->pluck('coupon_player_id');
        
        $this->cartitems()->delete();
        
        foreach ($couponPlayers as $couponId) {
            if ($couponId) {
                $coupon = CouponPlayer::find($couponId);
                $coupon->delete();
            }
        }
    }

    /**
     * Returns the player's user.
     */
    public function user()
    {
        return $this->morphOne(User::class, 'role');
    }

    /**
     * Returns the session/player models which have this player.
     */
    public function sessionPlayers()
    {
        return $this->hasMany(SessionPlayer::class);
    }

    /**
     * Returns the reviews that this player has made.
     */
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, SessionPlayer::class);
    }

    public function coupons()
    {
        return $this->hasManyThrough(Coupon::class, CouponPlayer::class);
    }

    public function couponPlayers()
    {
        return $this->hasMany(CouponPlayer::class);
    }

    /**
     * Returns all of the player's cart items.
     */
    public function cartitems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Returns the reports in which this player is a defendant.
     */
    public function defendantReports()
    {
        return $this->morphMany(Report::class, 'defendant');
    }

    /**
     * Returns the reports in which this player is a complainant.
     */
    public function complainantreports()
    {
        return $this->morphMany(Report::class, 'complainant');
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
