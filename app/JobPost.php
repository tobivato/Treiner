<?php

namespace Treiner;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Treiner\JobPost
 *
 */
class JobPost extends Model
{
    use Searchable;
    use SoftDeletes;
    
    protected $fillable = ['title', 'player_id', 'location_id', 'starts', 'length', 'details', 'fee', 'type'];

    protected $dates = ['starts', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->idempotency_key = Uuid::uuid4()->toString();
        });
    }

    public function toSearchableArray()
    {
        $geoloc = [
                'lat' => $this->location->latitude,
                'lng' => $this->location->longitude,
        ];

        $array = [
            'id' => $this->id,
            'title' => $this->title,
            'player_name' => $this->player->user->name,
            'starts' => $this->starts,
            'type' => $this->type,
            'fee' => $this->fee,
            'currency' => $this->player->user->currency,
            'details' => $this->details,
            '_geoloc' => $geoloc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        return $this->transform($array);
    }

    public function getFormattedFeeAttribute()
    {
        return money($this->fee, $this->player->user->currency);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function invitations()
    {
        return $this->hasMany(JobInvitation::class);
    }

    public function jobOffers()
    {
        return $this->hasMany(JobOffer::class);
    }

    public function pendingJobOffers() {
        return $this->jobOffers()->where('status', 'pending')->get();
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
