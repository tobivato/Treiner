<?php

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

class VerificationData extends Model
{
    protected $fillable = ['coach_id', 'verification_type', 'verification_number'];

    public function coach()
    {
        return $this->belongsTo('Treiner\Coach');
    }
}
