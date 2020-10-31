<?php

namespace Treiner;

use Illuminate\Database\Eloquent\Model;
use Treiner\User;

class Message extends Model
{
    protected $fillable = ['to_id', 'from_id', 'content', 'conversation_id', 'seen'];
    protected $casts = ['seen' => 'boolean'];

    protected $dates = ['created_at', 'updated_at'];

    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}
