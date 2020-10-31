<?php

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

/**
 * Treiner\JobOffer
 *
 */
class JobOffer extends Model
{
    protected $fillable = ['coach_id', 'job_post_id', 'location_id', 'content', 'fee'];

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function location() 
    {
        return $this->belongsTo(Location::class);
    }

    public function getFormattedFeeAttribute()
    {
        return money($this->fee, $this->coach->user->currency);
    }
}
