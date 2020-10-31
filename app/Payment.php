<?php

declare(strict_types=1);

namespace Treiner;

use Illuminate\Database\Eloquent\Model;

/**
 * Treiner\Payment
 *
 */
class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'currency', 'charge_id', 'player_id', 'coach_id', 'billing_address_id', 'player_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'integer',
    ];
    
    /**
     * Returns all Session Player models which use this payment.
     */
    public function sessionPlayers()
    {
        return $this->hasMany(SessionPlayer::class);
    }

    /**
     * Returns the amount formatted to the stated currency code.
     */
    public function getFormattedFeeAttribute()
    {
        return money($this->amount, $this->currency);
    }

    public function billingAddress()
    {
        return $this->belongsTo(BillingAddress::class);
    }

    public function coach()
    {
        return $this->belongsTo('Treiner\Coach');
    }

    public function player()
    {
        return $this->belongsTo('Treiner\Player');
    }
}
