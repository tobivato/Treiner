<?php

declare(strict_types=1);

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

/**
 * Represents an object of the billing address to store with a payment
 *
 */
class BillingAddress extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['first_name', 'last_name', 'street_address', 'locality', 'country', 'state', 'postcode'];
}
