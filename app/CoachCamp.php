<?php

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

class CoachCamp extends Model
{
    protected $fillable = ['accepted_at', 'coach_id', 'camp_id'];

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
