<?php

declare(strict_types=1);

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

/**
 * Treiner\Report
 *
 */
class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'complainant_id', 
        'complainant_type', 
        'defendant_id', 
        'defendant_type', 
        'content', 
        'session_id', 
        'resolved',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'resolved' => 'boolean',
    ];

    /**
     * Returns the complainant of this report.
     */
    public function complainant()
    {
        return $this->morphTo(null, 'complainant_type', 'complainant_id');
    }

    /**
     * Returns the defendant of this report.
     */
    public function defendant()
    {
        return $this->morphTo(null, 'defendant_type', 'defendant_id');
    }

    /**
     * Returns the session that was reported.
     */
    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
