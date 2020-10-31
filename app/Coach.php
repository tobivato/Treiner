<?php

declare(strict_types=1);

namespace Treiner;

use Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Log;
use Mail;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Str;
use Treiner\Mail\CoachRequiresVerification;
use Treiner\Payment\PaymentAccountHandler;

/**
 * This is the coach model. It's scoped so that only verified coaches can be found.
 *
 */
class Coach extends Model
{
    use SoftDeletes;
    use Searchable;
    use HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'club',
        'is_company',
        'business_registration_number',
        'qualification',
        'currency',
        'years_coaching',
        'age_groups_coached',
        'session_types',
        'profile_summary',
        'profile_philosophy',
        'profile_playing',
        'profile_session',
        'location_id',
        'fee'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
        'is_company' => 'boolean',
        'age_groups_coached' => 'array',
        'session_types' => 'array',
    ];

    protected $dates = [
        'updated_at',
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            Mail::to('sales@treiner.co')->queue(new CoachRequiresVerification($model));
        });
    }

    /**
     * Converts the model to an array that can be searched through (automatically called by Laravel Scout)
     */
    public function toSearchableArray()
    {
        $geoloc = [];
        foreach ($this->availabilities as $session) {
            $geoRecord = [
                'lat' => $session->location->latitude,
                'lng' => $session->location->longitude,
            ];
            array_push($geoloc, $geoRecord);
        }

        if ($geoloc == []) {
            array_push($geoloc, [
                'lat' => $this->location->latitude,
                'lng' => $this->location->longitude,
            ]);
        }

        $array = [
            'id' => $this->id,
            'name' => $this->user->name,
            'club' => $this->club,
            'locations' => $this->availabilities->pluck('location.locality'),
            'qualification' => $this->qualification,
            'age_groups_coached' => ($this->age_groups_coached),
            'session_types' => ($this->session_types),
            'profile_summary' => $this->profile_summary,
            'years_coaching' => $this->years_coaching,
            'popularity' => $this->calculateBadge()['score'],
            'fee' => $this->fee ? $this->fee : 0,
            'avg_price' => $this->sessions->count() > 0 ? round($this->sessions->sum('feePerPerson') / $this->sessions->count()) : null,
            '_geoloc' => $geoloc,
        ];

        return $this->transform($array);
    }

    /**
     * Only coaches that are verified and have availabilities can be searchable
     */
    public function shouldBeSearchable()
    {
        return $this->verified;
    }

    public function getLocationsAttribute()
    {
        if ($this->availabilities->count() > 0) {
            return $this->availabilities->pluck('location');
        }
        return collect([$this->location]);
    }

    public function jobOffers()
    {
        return $this->hasMany('Treiner\JobOffer');
    }

    /**
     * Returns the user which owns this coach.
     */
    public function user()
    {
        return $this->morphOne(User::class, 'role');
    }

    /**
     * Checks that the coach has been manually verified, their Stripe account is set up, their phone has been verified and their email has been verified
     */
    public function getVerifiedAttribute(): bool
    {
        return $this->verification_status == 'verified' && $this->stripe_token && $this->user->email_verified_at;
    }

    public function getSlugAttribute(): string
    {
        if ($this->user) {
            return Str::slug($this->user->name);
        }
        return '';
    }

    /**
     * Returns the reports in which this coach is a defendant.
     */
    public function defendantReports()
    {
        return $this->morphMany(Report::class, 'defendant');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function jobInvitations()
    {
        return $this->hasMany(JobInvitation::class);
    }

    /**
     * Returns the reports in which this coach is a complainant.
     */
    public function complainantreports()
    {
        return $this->morphMany(Report::class, 'complainant');
    }

    /**
     * Returns the sessions of the coach.
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function camps()
    {
        return $this->hasManyThrough(Camp::class, Session::class);
    }

    /**
     * Returns the blog posts which this coach has made.
     */
    public function blogposts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function verifications()
    {
        return $this->hasMany(VerificationData::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews()
    {
        return $this->hasManyDeep(Review::class, [Session::class, SessionPlayer::class]);
    }

    public function campInvitations()
    {
        return $this->hasMany(CoachCamp::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getPriceRangeAttribute()
    {
        if (count($this->availabilities) == 0) {
            return '';
        }
        $availabilities = $this->availabilities->sortBy('fee');
        if ($availabilities->first()->formattedFee == $availabilities->last()->formattedFee) {
            return $availabilities->first()->formattedFee;
        }
        return $availabilities->first()->formattedFee . ' - ' . $availabilities->last()->formattedFee;
    }

    public function getFormattedLocationsAttribute()
    {
        $result = implode(', ', $this->availabilities->pluck('location.locality')->unique()->toArray());

        if (!$result) {
            $result = $this->location->locality;
        }

        return $result;
    }

    public function getFormattedSessionTypesAttribute()
    {
        $types = ($this->session_types);
        $newTypes = [];
        foreach ($types as $type) {
            array_push($newTypes, __('coaches.' . $type));
        }

        return implode(', ', $newTypes);
    }

    public function getFormattedAgeGroupsCoachedAttribute()
    {
        $types = ($this->age_groups_coached);
        $newTypes = [];
        foreach ($types as $type) {
            array_push($newTypes, __('coaches.' . $type));
        }

        return implode(', ', $newTypes);
    }

    public function getFormattedQualificationsAttribute()
    {
        return __('coaches.' . $this->qualification);
    }

    public function calculateBadge()
    {
        $score = 0;
        $explanation = '';

        $score += $this->years_coaching * 10;
        $explanation .= 'Coaching experience: ' . $this->years_coaching * 10 . "
        ";

        switch ($this->qualification) {
            case 'Grassroots':
                $score += 50;
                $explanation .= "Qualification level: 50
                ";
                break;
            case 'Community':
                $score += 75;
                $explanation .= "Qualification level: 75
                ";
                break;
            case 'CLicence':
                $score += 100;
                $explanation .= "Qualification level: 100
                ";
                break;
            case 'BLicence':
                $score += 150;
                $explanation .= "Qualification level: 150
                ";
                break;
            case 'ALicence':
                $score += 400;
                $explanation .= "Qualification level: 400
                ";
                break;
            case 'ProLicence':
                $score += 900;
                $explanation .= "Qualification level: 900
                ";
                break;
            default:
                $score += 0;
                break;
        }

        $reviewSum = 5 * ($this->reviews->sum('rating') / 20) - (3.8 * count($this->reviews));
        $explanation .= 'Reviews: ' . $reviewSum . "
        ";

        $result = [
            'explanation' => $explanation,
            'score' => $score,
        ];

        switch ($score) {
            case $score >= 50 && $score < 200:
                $result['name'] = 'bronze';
                break;

            case $score >= 200 && $score < 500:
                $result['name'] = 'silver';
                break;

            case $score >= 500 && $score < 1000:
                $result['name'] = 'gold';
                break;

            case $score >= 1000:
                $result['name'] = 'platinum';
                break;

            default:
                $result['name'] = 'bronze';
                break;
        }
        return ($result);
    }

    public function getAvailabilitiesAttribute()
    {
        $now = \Carbon\Carbon::now();

        $availabilities = Session::where('coach_id', $this->id)->where('type', '!=', 'Camp')->whereDate('starts', '>', $now)->orderBy('starts')->get();

        foreach ($availabilities as $key => $session) {
            if ($session->full) {
                $availabilities->forget($key);
            }
        }

        return $availabilities;
    }

    public function getAverageReviewAttribute()
    {
        return round($this->reviews->avg('rating'));
    }

    public function getStripeLinkAttribute()
    {
        if ($this->stripe_token) {
            return route('payments.dashboard');
        }

        return PaymentAccountHandler::generateStripeAuthLink($this);
    }
}
