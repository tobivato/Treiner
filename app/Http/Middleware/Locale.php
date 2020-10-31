<?php

declare(strict_types=1);

namespace Treiner\Http\Middleware;

use App;
use Closure;
use Config;
use Session;

class Locale
{
    /**
     * Handle an incoming request.
     */
    public function handle(\Illuminate\Http\Request $request, Closure $next)
    {
        //$raw_locale = Session::get('locale');
        $raw_locale = $request->session()->get('locale');
        if (in_array($raw_locale, Config::get('app.locales'), true)) {
            $locale = $raw_locale;
        } else {
            $locale = Config::get('app.locale');
        }
        App::setLocale($locale);

        return $next($request);
    }
}
