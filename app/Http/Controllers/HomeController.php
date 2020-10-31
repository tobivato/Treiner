<?php

declare(strict_types=1);

namespace Treiner\Http\Controllers;

use Arr;
use Auth;
use Cloudder;
use DB;
use Exception;
use Gahlawat\Slack\Facade\Slack;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Log;
use Mail;
use Treiner\Coach;
use Propaganistas\LaravelPhone\PhoneNumber;
use Treiner\Mail\AccountDeleted;
use Treiner\Mail\Contact;
use Treiner\Mail\Support;
use Treiner\NewsletterSubscription;
use Treiner\Player;

/**
 * Used for handling miscellaneous functionality from the dashboard and contact
 */
class HomeController extends Controller
{
    public function update(Request $request)
    {
        $conditions = [
            'user_type' => ['nullable', 'in:player,coach'],
            'firstName' => ['nullable', 'string', 'max:255'],
            'lastName' => ['nullable', 'string', 'max:255'],
            'dob' => ['nullable', 'date', 'before:-16 years', 'after:-122 years'],
            'gender' => ['nullable', 'in:male,female'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'terms' => ['nullable'],
            'phone_country_code' => ['required_with:phone', 'bail', 'string', Rule::in(array_keys(config('treiner.countries')))],
            'newsletter' => ['nullable'],
        ];

        if ($request->input('user_type') === 'coach') {
            $conditions = array_merge($conditions, [
                'is_company' => ['nullable', 'boolean'],
                'club' => ['nullable', 'string', 'max:255'],
                'abn' => ['nullable', 'string', 'max:64'],
                'years_coaching' => ['nullable', 'integer', 'max:60', 'min:0'],
                'age_groups_coached' => ['nullable', 'array'],
                'session_types' => ['nullable', 'array'],
                'qualification' => ['nullable', 'string', Rule::in(config('treiner.qualifications'))],
                'profile_summary' => ['nullable', 'string', 'max:2047'],
                'profile_philosophy' => ['nullable', 'string', 'max:2047'],
                'profile_playing' => ['nullable', 'string', 'max:2047'],
                'profile_session' => ['nullable', 'string', 'max:2047'],
                'profile' => ['nullable', 'string', 'max:2047'],
                'phone' => ['nullable', 'phone:' . config('treiner.countries.' . $request->input('phone_country_code') . '.iso_2_letter')],
            ]);
        }
        else {
            throw new Exception("Error Processing Request", 1);
        }

        $request->validate($conditions);

        if (Auth::user()->role instanceof Coach) {
            Auth::user()->coach->update($request->all());
        }
        else {
            Auth::user()->player->update($request->all());
        }

        Auth::user()->update($request->all());
        
        return redirect(route('home'));
    }

    public function signupComplete()
    {
        return view('dashboard.signup-complete');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            return redirect(route('admin.dashboard'));
        }

        if (Auth::user()->role instanceof Coach) {
            return view('dashboard.coach.dashboard');
        }
        else {
            return redirect(route('settings.show'));
        }
    }

    public function settings()
    {
        $shortPhone = '';
        $newsletterSubscribed = false;
        if (NewsletterSubscription::where('email',Auth::user()->email)->first()) {
            $newsletterSubscribed = true;
        }

        if (Auth::user()->phone != null) {
            try {
                $shortPhone = PhoneNumber::make(Auth::user()->phone);
            } catch (\Throwable $th) {
                $shortPhone = '';
            }
        }
        
        return view('dashboard.settings', ['newsletter' => $newsletterSubscribed, 'phone' => $shortPhone]);
    }

    public function saveSettings(Request $request)
    {
        $user = Auth::user();

        $validation = [
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'country' => ['required_with:phone', 'bail', 'string', Rule::in(array_keys(config('treiner.countries')))],
            'phone' => ['required', 'phone:' . config('treiner.countries.' . $request['country'] . '.iso_2_letter')],
            'newsletter' => ['nullable'],
        ];

        if ($user->role instanceof Coach) {
            $validation = array_merge($validation, [
                'business_registration_number' => ['nullable', 'string', 'max:64'],
            ]);
        }

        $request->validate($validation);

        DB::transaction(function() use ($request, &$user){
            $fields = array_filter($request->all()); //removes null values

            $user->update($fields);
            if (Arr::has($fields, 'phone')) {
                $user->phone = (string) PhoneNumber::make($fields['phone'])->ofCountry(config('treiner.countries.' . $fields['country'] . '.iso_2_letter'));
                if (Arr::has($fields, 'profile')) {
                    $user->image_id = Cloudder::upload($fields['profile'])->getPublicId();
                }
            }
            if (Arr::has($fields, 'password')) {
                $user->password = Hash::make($fields['password']);
            }
            $user->save();

            $subscription = NewsletterSubscription::where('email', $user->email)->first();
            
            if (Arr::has($fields, 'newsletter')) {
                if ($subscription == null) {
                    NewsletterSubscription::create([
                        'email' => $fields['email'],
                        'unsub_token' => md5($fields['email']),
                    ]);
                }
            }
            else {
                if ($subscription) {
                    $subscription->delete();
                }
            }
        });

        return redirect(route('settings.show'))->with('message', 'Your profile has been updated.');
    }

    public function destroy()
    {
        $user = Auth::user();
        $isPlayer = (Auth::user()->role instanceof Player);
        $email = Auth::user()->email;
        $name = Auth::user()->name;

        if ($user->isAdmin()) {
            return redirect(route('settings.show'))->withErrors('You cannot delete an admin account.');
        }
        DB::transaction(function () use (&$user) {
            if (config('app.env') == 'production') {
                Slack::send('A ' . ($user->role instanceof Coach ? 'coach' : 'player') . ', ' . $user->name . ', has deleted their account.');
            }
            if ($user->role instanceof Coach) {
                $user->coach->unsearchable();
            }
            $user->role->delete();
            $user->delete();

            Auth::logout();
        });

        if ($isPlayer) {
            Mail::to($email)->queue(new AccountDeleted($name, $email));
        }
        
        return redirect(route('welcome'))->with('message', 'Your account has been successfully deleted.');
    }

    public function support(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'severity' => 'required|in:low,medium,high,extreme',
            'type' => 'required|in:bug,help,finance,other',
            'comments' => 'required|string|max:10000',
        ]);

        $title = $request->input('title');
        $severity = $request->input('severity');
        $type = $request->input('type');
        $comments = $request->input('comments');

        Mail::to('contact@treiner.co')->queue(new Support($title, $severity, $type, $comments, Auth::user()));

        return redirect(route('support'))->with('message', 'Your message has been sent successfully.');
    }

    public function contact(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:50',
            'lname' => 'required|string|max:50',
            'email' => 'required|email|max:200',
            'content' => 'required|string|max:10000',
        ]);
        $name = $request->input('fname') . ' ' . $request->input('lname');
        $email = $request->input('email');
        $content = $request->input('content');

        if (!$request->exists('faxonly')) {
            Mail::to('contact@treiner.co')
                ->queue(new Contact($name, $email, $content));
        }

        return redirect(route('contact'))->with('message', 'Your message has been sent successfully.');
    }

    public function lang($locale) {
        if (in_array($locale, \Config::get('app.locales'))) {
            session(['locale' => $locale]);
        }
        return redirect()->back();    
    }

    public function terms() {
        return view('static.terms');
    }

    public function about() {
        return view('static.about');
    }

    public function showContactForm() {
        return view('static.contact');
    }

    public function showSupportForm() {
        return view('static.support');
    }

    public function privacy() {
        return view('static.privacy-policy');
    }

    public function virtual() {
        return view('static.virtual-training');
    }

    public function scholarships() {
        return view('static.scholarships');
    }

    public function faq() {
        return view('static.faq');
    }

    /**
     * Show the welcome page.
     */
    public function welcome(): \Illuminate\Contracts\Support\Renderable
    {
        return view('welcome');
    }
}
