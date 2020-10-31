<?php

declare(strict_types=1);

namespace Treiner\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Log;
use Cloudder;
use DB;
use Propaganistas\LaravelPhone\PhoneNumber;
use Treiner\Coach;
use Treiner\Http\Controllers\Controller;
use Treiner\NewsletterSubscription;
use Treiner\Player;
use Treiner\User;
use Exception;
use Gahlawat\Slack\Facade\Slack;
use Treiner\Location;
use Treiner\Notifications\AccountCreated;
use Treiner\VerificationData;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/signup-complete';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showCoachRegistrationForm()
    {
        return view('auth.coach');
    }

    public function showPlayerRegistrationForm()
    {
        return view('auth.player');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $conditions = [
            'user_type' => ['required', 'in:player,coach'],
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before:-16 years', 'after:-122 years'],
            'gender' => ['required', 'in:male,female'],
            'email' => ['required', 'string', 'email:strict,dns,spoof,filter', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required'],
            'phone_country_code' => ['required_with:phone', 'bail', 'string', Rule::in(array_keys(config('treiner.countries')))],
            'newsletter' => ['nullable'],
            'phone' => ['required', 'phone:' . config('treiner.countries.' . $data['phone_country_code'] . '.iso_2_letter')],
        ];

        if ($data['user_type'] === 'coach') {
            $conditions = array_merge($conditions, [
                'verification_type' => ['required', 'string', 'max:255'],
                'verification' => ['required', 'string', 'max:255'],
                'business_type' => ['required', 'in:individual,company'],
                'club' => ['required', 'string', 'max:255'],
                'abn' => ['required', 'string', 'max:64'],
                'years_coaching' => ['required', 'integer', 'max:60', 'min:0'],
                'age_groups_coached' => ['required', 'array'],
                'session_types' => ['required', 'array'],
                'qualification' => ['required', 'string', Rule::in(config('treiner.qualifications'))],
                'profile_summary' => ['required', 'string', 'max:2047'],
                'profile_philosophy' => ['required', 'string', 'max:2047'],
                'profile_playing' => ['required', 'string', 'max:2047'],
                'profile_session' => ['required', 'string', 'max:2047'],
                'profile' => ['required', 'image', 'max:8191'],
                'lat' => 'required|numeric|min:-90|max:90',
                'lng' => 'required|numeric|min:-180|max:180',
                'locality' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'phone' => ['nullable', 'phone:' . config('treiner.countries.' . $data['phone_country_code'] . '.iso_2_letter')],
                'fee' => ['integer', 'min:0'],
            ]);
        }
        else if ($data['user_type'] === 'player') {
            $conditions = array_merge($conditions, [
                'profile' => ['nullable', 'image', 'max:8191'],
            ]);
        }
        else if($data['user_type'] !== 'player') {
            throw new Exception("Error Processing Request", 1);
        }

        return Validator::make($data, $conditions);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        $user = null;
        DB::transaction(function() use($data, &$user) {
            if ($data['user_type'] === 'coach') {
                $location = Location::create([
                    'latitude' => $data['lat'],
                    'longitude' => $data['lng'],
                    'locality' => $data['locality'],
                    'country' => $data['country'],
                ]);

                $usertype = Coach::create([
                    'club' => $data['club'],
                    'is_company' => $data['business_type'] == 'company' ? true: false,
                    'business_registration_number' => $data['abn'],
                    'qualification' => $data['qualification'],
                    'years_coaching' => $data['years_coaching'],
                    'age_groups_coached' => ($data['age_groups_coached']),
                    'session_types' => ($data['session_types']),
                    'profile_summary' => $data['profile_summary'],
                    'profile_philosophy' => $data['profile_philosophy'],
                    'profile_session' => $data['profile_session'],
                    'profile_playing' => $data['profile_playing'],
                    'location_id' => $location->id,
                    // 'fee' => $data['fee'],
                ]);

                VerificationData::create([
                    'coach_id' => $usertype->id,
                    'verification_type' => $data['verification_type'],
                    'verification_number' => $data['verification'],
                ]);
                $usertype->save(); //updates search index
            } elseif($data['user_type'] === 'player') {
                $usertype = Player::create();
            }
            else {
                throw new Exception("Error Processing Request: User type not coach or player", 1);
            }

            if (array_key_exists('newsletter', $data)) {
                try {
                    NewsletterSubscription::create([
                        'email' => $data['email'],
                        'unsub_token' => md5($data['email']),
                    ]);
                } catch (\Throwable $e) {
                    Log::warning('Error creating newsletter subscription: ' . $e);
                }
            }

            $user = new User;

            $user->fill([
                'first_name' => ucfirst($data['firstName']),
                'last_name' => ucfirst($data['lastName']),
                'dob' => $data['dob'],
                'email' => $data['email'],
                'currency' => config('treiner.countries.' . $data['phone_country_code'] . '.currency'),
                'gender' => $data['gender'],
                'password' => Hash::make($data['password']),
                'image_id' => isset($data['profile']) ? Cloudder::upload($data['profile'])->getPublicId() : 'profile-none'
            ]);

            $user->phone = (string) PhoneNumber::make($data['phone'])->ofCountry(config('treiner.countries.' . $data['phone_country_code'] . '.iso_2_letter'));

            $user->email = $data['email'];
            $user->role_id = $usertype->id;
            $user->role_type = get_class($usertype);

            $user->save();
            Slack::send('A new ' . $data['user_type'] . ', ' . $user->name . ' has signed up to the platform.');
            $user->notify(new AccountCreated());
        });


        return $user;
    }
}
