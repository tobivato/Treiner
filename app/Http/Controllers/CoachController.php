<?php

declare(strict_types=1);

namespace Treiner\Http\Controllers;

use Arr;
use Illuminate\Http\Request;
use Stripe;
use Auth;
use DB;
use Illuminate\Validation\Rule;
use Log;
use Str;
use Treiner\Coach;
use Treiner\Payment\PaymentAccountHandler;
use Treiner\Notifications\SessionRequest;
use Treiner\Schedule\CityCacher;

class CoachController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Coach Controller
    |--------------------------------------------------------------------------
    |
    | This controller is used for showing individual coach pages.
    |
    */

    public function __construct()
    {
        $this->authorizeResource(Coach::class, 'coach');
    }

    public function showSearchForm()
    {
        return redirect(route('coaches.show-cities'));
        //return view('coach.search-welcome');
    }

    public function showCoachProfilePage()
    {
        return view('dashboard.coach.profile', ['coach' => Auth::user()->coach]);
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'club' => ['nullable', 'string', 'max:255'],
            'years_coaching' => ['nullable', 'integer', 'max:60', 'min:0'],
            'age_groups_coached' => ['nullable', 'array'],
            'session_types' => ['nullable', 'array'],
            'qualification' => ['nullable', 'string', Rule::in(config('treiner.qualifications'))],
            'profile_summary' => ['nullable', 'string', 'max:2047'],
            'profile_philosophy' => ['nullable', 'string', 'max:2047'],
            'profile_playing' => ['nullable', 'string', 'max:2047'],
            'profile_session' => ['nullable', 'string', 'max:2047'],
            'lat' => 'nullable|numeric|min:-90|max:90',
            'lng' => 'nullable|numeric|min:-180|max:180',
            'locality' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $fields = array_filter($request->all());

        DB::transaction(function() use ($fields) {
            Auth::user()->coach->location->update($fields);
            Auth::user()->coach->update($fields);
            Auth::user()->coach->save();
        });

        return redirect(route('home.profile'))->with('message', 'Your profile has been successfully updated');
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'lat' => 'required|numeric|min:-90|max:90',
            'lng' => 'required|numeric|min:-180|max:180',
            'distance' => 'required|integer|min:5|max:200',
            'location' => 'required|string|max:512',
            'price' => 'required',
        ]);
        $query = $request->input('search');
        $lat = floatval($request->input('lat'));
        $lng = floatval($request->input('lng'));
        $radius = intval($request->input('distance') * 1000);
        $location = $request->input('location');
        $price = $request->input('price');
        $lowPrice = 0;
        $highPrice = 50000;

        if ($price != 'any') {
            $lowPrice = intval(explode('-', $price, 2)[0]) * 100;
            $highPrice = intval(explode('-', $price, 2)[1]) * 100;
        }

        $coaches = Coach::search($query)
            ->whereBetween('avg_price', [$lowPrice, $highPrice])
            ->aroundLatLng($lat, $lng)
            ->with(['aroundRadius' => $radius])
            ->paginate(24);

        foreach ($coaches as $key => $coach) {
            if (count($coach->availabilities) == 0) {
                $coaches->forget($key);
            }
        }

        return view('coach.search', [
            'coaches' => $coaches,
            'query' => $query,
            'lat' => $lat,
            'lng' => $lng,
            'price' => $price,
            'distance' => $request->input('distance'),
            'location' => $location,
        ]);
    }

    public function showCities()
    {
        if (!cache('coaches.cities')) {
            CityCacher::create();
        }
        return view('coach.cities', ['cities' => cache('coaches.cities')]);
    }

    public function showCoachesByCity($city, Request $request) {
        //to sent form data back to search field, it is inialized if $request not null
        $data = null;

        if (array_key_exists($city, config('treiner.cities'))) {
            $cityData = config('treiner.cities.'.$city);

                if(count($request->all()) > 0) {
                    $request->validate([
                        'name' => 'nullable|string|max:255',
                        'location' => 'nullable|string|max:512',
                        'price' => 'nullable',
                        'qualification' => 'nullable',
                        'experience' => 'nullable',
                        'session' => 'nullable'
                    ]);

                    $name = $request->input('name');
                    $location = $request->input('location');
                    $price = $request->input('price');
                    $qualification = $request->input('qualification');
                    $experience = ($request->input('experience')!= null ? $request->input('experience') : 0) ;
                    $session = ($request->input('session')!= null ? $request->input('session') : "") ;
                    $lowPrice = 0;
                    $highPrice = 50000;

                    $data = array(
                        'name'=> $name,
                        'location' => $location,
                        'price' =>$price,
                        'qualification' => $qualification,
                        'experience' => $experience,
                        'session' => $session
                    );

                    if ($price != null) {
                        $lowPrice = intval(explode('-', $price, 2)[0]);
                        $highPrice = intval(explode('-', $price, 2)[1]);
                        $highPrice = ($highPrice == 0) ? 50000 : $highPrice;

                    }
                    //->whereBetween('fee',[$lowPrice ,$highPrice])
                    $coaches = Coach::search($name)
                    ->where('years_coaching', '>=', $experience)
                    ->orderBy('popularity', 'desc')
                    ->aroundLatLng($cityData['latitude'], $cityData['longitude'])
                    ->with(['aroundRadius' => 50000,
                    'facetFilters' => ["session_types:".$session,
                                        "qualification:".$qualification,
                                        "locations:".$location]
                                        ])
                    ->paginate(24);

                    }

                else{

                    $coaches = Coach::search()
                        ->orderBy('popularity', 'desc')
                        ->aroundLatLng($cityData['latitude'], $cityData['longitude'])
                        ->with(['aroundRadius' => 50000])
                        ->paginate(24);

                    if (count($coaches) == 0) {
                        abort(404);
                    }
                }

                return view('coach.city',[
                    'coaches' => $coaches,
                    'cityName' => $cityData['name'],
                    'city'=>$city,
                    'data' => $data
                ]);
            }

            else {
                abort(404);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Coach $coach, string $slug = null)
    {
        if ($slug != $coach->slug) {
            return redirect()
                ->route('coaches.show', ['coach' => $coach, 'slug' => $coach->slug]);
        }

        return view('coach.show', [
            'coach' => $coach,
            'link' => route('coaches.show', $coach->id),
            'source' => 'LinkedIn',
            'title' => 'Book coaching sessions from ' . $coach->user->name . ' on Treiner',
        ]);
    }

    public function setupPayment(Request $request)
    {
        return PaymentAccountHandler::connectStripeApi(Auth::user()->coach, $request->input('code'));
    }

    public function paymentDashboard()
    {
        Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        return redirect(Stripe\Account::createLoginLink(Auth::user()->coach->stripe_token)->url);
    }
}
