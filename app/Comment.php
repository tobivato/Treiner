<?php

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

/**
 * Treiner\Comment
 *
 */
class Comment extends Model
{
    protected $fillable = ['commentable_type', 'commentable_id', 'user_id', 'content'];

    public function commentable()
    {
        return $this->morphTo(null, 'commentable_type', 'commentable_id');
    }

    public function user()
    {
        return $this->belongsTo('Treiner\User');
    }
}
