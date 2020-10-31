<?php

declare(strict_types=1);

namespace Treiner;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;

/**
 * Treiner\Session
 *
 */
class Session extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coach_id',
        'location_id', 
        'fee', 
        'length', 
        'starts', 
        'type', 
        'group_min', 
        'group_max', 
        'status', 
        'zoom_number',
        'supports_cash_payments',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'starts', 'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'length' => 'integer',
        'supports_cash_payments' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->camps()->delete();
            $model->coach->save();
        });
    }

    /**
     * Returns the session/player models which connect the sessions and players.
     */
    public function sessionPlayers()
    {
        return $this->hasMany(SessionPlayer::class);
    }

    /**
     * Returns the players which attended this session.
     */
    public function players()
    {
        return $this->hasManyThrough(Player::class, SessionPlayer::class);
    }

    /**
     * Returns the session's location model.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Returns the payments which have been made for this session.
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, SessionPlayer::class);
    }

    /**
     * Returns this session's reviews.
     */
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, SessionPlayer::class);
    }

    public function camps()
    {
        return $this->hasMany(Camp::class);
    }

    /**
     * Returns the cost for sessions formatted to the coach's currency code.
     */
    public function getFormattedFeeAttribute()
    {
        return money($this->fee, $this->coach->user->currency);
    }

    /**
     * Returns the formatted total fee for this session
     */
    public function getFormattedTotalFeeAttribute()
    {
        return money($this->totalFee, $this->coach->user->currency);
    }

    /**
     * Returns the total fee for this session
     */
    public function getTotalFeeAttribute()
    {
        return ((int) (($this->fee / 60) * $this->length * (count($this->sessionPlayers) * $this->sessionPlayers->sum('players'))));
    }

    /**
     * Returns the total fee per person for this session
     */
    public function getFeePerPersonAttribute()
    {
        return (int) (($this->fee / 60) * $this->length);
    }

    public function getFormattedFeePerPersonAttribute()
    {
        return money($this->feePerPerson, $this->coach->user->currency);
    }

    public function getPlayersCountAttribute()
    {
        return $this->sessionPlayers->sum('players');
    }

    /**
     * Returns the length of time of the session readably
     */
    public function getReadableLengthAttribute(): string
    {
        $time = $this->length;
        if ($time < 1) {
            return '';
        }
        $hours = floor($time / 60);
        $minutes = $time % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    public function getFullAttribute()
    {
        return count($this->sessionPlayers) >= $this->group_max;
    }

    /**
     * Returns the coach which created the session.
     */
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
