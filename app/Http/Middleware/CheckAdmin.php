<?php

namespace Treiner\Http\Middleware;

use Closure;
use Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::check()){
            abort(404);
        }
        
        if(!(Auth::user()->isAdmin()) ){
            abort(404);
        }
        return $next($request);
    }
}
