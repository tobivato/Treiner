<?php

declare(strict_types=1);

namespace Treiner;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Treiner\SessionPlayer
 *
 */
class SessionPlayer extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id', 'session_id', 'payment_id', 'review_email_sent', 'player_info', 'reviewed', 'players',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'review_email_sent' => 'boolean',
        'player_info' => 'array',
    ];
    
    /**
     * Returns player which this model belongs to.
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getReviewedAttribute()
    {
        if ($this->review) {
            return true;
        }
        return false;
    }

    /**
     * Returns the session which this model belongs to.
     */
    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    /**
     * Returns the payment made for this session.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
