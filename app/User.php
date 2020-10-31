<?php

declare(strict_types=1);

namespace Treiner;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Treiner\Message;

/**
 * Treiner\User
 *
 */

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender', 
        'password', 
        'currency',
        'phone', 
        'dob', 
        'notification_preference', 
        'image_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $dates = [
        'dob', 
        'email_verified_at', 
        'phone_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Returns the role belonging to this user.
     */
    public function role()
    {
        return $this->morphTo(null, 'role_type', 'role_id');
    }

    /**
     * Returns the messages where this user is the recipient.
     * 
     */
    public function messagesTo()
    {
        return $this->hasMany(Message::class, 'to_id');
    }

    /**
     * Returns the messages that this user has sent
     *
     */
    public function messagesFrom()
    {
        return $this->hasMany(Message::class, 'from_id');
    }

    public function messages()
    {
        $messagesTo = $this->messagesTo()->get();
        $messagesFrom = $this->messagesFrom()->get();
        return $messagesTo->merge($messagesFrom);   
    }

    private function conversationsFrom()
    {
        return $this->hasMany(Conversation::class, 'from_id');
    }

    private function conversationsTo()
    {
        return $this->hasMany(Conversation::class, 'to_id');
    }   

    public function conversations()
    {
        $conversationsFrom = $this->conversationsFrom()->get();
        $conversationsTo = $this->conversationsTo()->get();
        return $conversationsFrom->merge($conversationsTo);
    }
    /**
     * Returns the phone number to call for Twilio
     */
    public function routeNotificationForTwilio()
    {
        return $this->phone;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isAdmin()
    {
        return $this->permissions === 'admin' || $this->permissions === 'super_admin';
    }

    public function isSuperAdmin()
    {
        return $this->permissions === 'super_admin';
    }

    /**
     * Returns the user's full name.
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Gets the user's coach model if it exists, otherwise throws exception if
     * not a coach
     */
    public function getCoachAttribute() : Coach
    {
        if ($this->role instanceof Coach) {
            return $this->role;
        }
        throw new Exception('Invalid role type - expecting Coach.');
    }

    /**
     * Gets the user's player model if it exists, otherwise throws exception if
     * not a player
     */
    public function getPlayerAttribute() : Player
    {
        if ($this->role instanceof Player) {
            return $this->role;
        }
        throw new Exception('Invalid role type - expecting Player.');
    }

    public function scopeNameLike($query, $fullName)
    {
        return $query->whereRaw('CONCAT(first_name, " ", last_name) LIKE "%?%"', [$fullName]);
    }    

    /**
     * Checks to see if the user has completed their signup
     */
    public function getHasCompletedSignupAttribute() : bool
    {
        if ((count($this->players) > 0) || (count($this->coaches) > 0)) {
            return true;
        }

        return false;
    }
}
