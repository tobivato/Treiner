<?php

declare(strict_types=1);

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

/**
 * Treiner\Review
 *
 */
class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'session_player_id', 'rating', 'content', 'created_at',
    ];

    protected $dates = ['created_at'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Returns the session/player that this review is reviewing.
     */
    public function sessionPlayer()
    {
        return $this->belongsTo(SessionPlayer::class);
    }

    public function session()
    {
        return $this->hasOneThrough(Session::class, SessionPlayer::class);
    }

    public function player()
    {
        return $this->hasOneThrough(Session::class, SessionPlayer::class);
    }


    public function starRating()
    {
        $stars = round($this->rating / 20);
        
        $result = '';
        for ($i=0; $i < $stars; $i++) { 
            $result .= '<i class="fas fa-star"></i>';
        }

        for ($i=0; $i < 5 - $stars; $i++) { 
            $result .= '<i class="far fa-star"></i>';
        }
        
        return $result;
    }
}
