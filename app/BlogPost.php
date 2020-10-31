<?php

declare(strict_types=1);

namespace Treiner;

use Illuminate\Database\Eloquent\Model;
use Str;

/**
 * Represents a blog post that coaches can make
 *
 */
class BlogPost extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_id', 'coach_id', 'title', 'excerpt', 'content',
    ];

    /**
     * Returns the coach which made this post.
     */
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->title);
    }

    /**
     * Returns the length of time to read the post.
     * Gets the count of the content, divides it by 200 (average WPM) and
     * rounds it to the nearest whole number.
     */
    public function getTimeAttribute()
    {
        return round((str_word_count($this->content) / 200));
    }
}
