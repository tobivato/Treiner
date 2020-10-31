<?php

namespace Treiner;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Camp extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'session_id', 'image_id', 'title', 'description', 'tos', 'ages', 'start_time', 'end_time', 'days'
    ];

    protected $dates = [
        'created_at', 
        'updated_at',
    ];

    protected $casts = [
        'ages' => 'array',
    ];

    public function getFormattedAgesAttribute()
    {
        $types = ($this->ages);
        $newTypes = [];
        foreach ($types as $type) {
            array_push($newTypes, __('coaches.' . $type));
        }

        return implode(', ', $newTypes);
    }

    public function session() {
        return $this->belongsTo(Session::class);
    }

    public function invitations()
    {
        return $this->hasMany(CoachCamp::class);
    }
}
