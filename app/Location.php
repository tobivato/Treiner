<?php

declare(strict_types=1);

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

/**
 * Treiner\Location
 *
 */
class Location extends Model
{
    protected $fillable = [
        'latitude', 'longitude', 'street_address', 'locality', 'country', 'timezone',
    ];
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function getAddressAttribute()
    {
        return $this->street_address . ' ' . $this->locality . ' ' . $this->country;
    }
}
