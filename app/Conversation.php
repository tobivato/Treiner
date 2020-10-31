<?php

namespace Treiner;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Conversation extends Model
{
    protected $fillable = ['from_id', 'to_id', 'subject'];

    public function from()
    {
        return $this->belongsTo('Treiner\User', 'from_id');
    }

    public function to()
    {
        return $this->belongsTo('Treiner\User', 'to_id');
    }

    /**
     * Returns the person that the conversation is with from the perspective of the user
     *
     * @return \Treiner\User
     */
    public function fromPerspective()
    {
        if ($this->to_id != Auth::id()) {
            return $this->to()->first();
        }
        else {
            return $this->from()->first();
        }
    }
}
