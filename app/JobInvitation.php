<?php

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

class JobInvitation extends Model
{
    protected $fillable = ['job_post_id', 'coach_id'];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}
