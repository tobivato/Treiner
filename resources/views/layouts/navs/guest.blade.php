@include('layouts.navs.post-job')
<li class="nav-item {{ Route::currentRouteNamed('coaches.show-cities') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('coaches.show-cities') }}">Browse Coaches</a>
</li>
<li class="nav-item {{ Route::currentRouteNamed('camps.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('camps.index')}}">Camps</a>
</li>
<li class="nav-item {{ Route::currentRouteNamed('about') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('about')}}">About Us</a>
</li>
@include('layouts.navs.help')
<li class="nav-item {{ Route::currentRouteNamed('login') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('login')}}">Sign In</a>
</li>
<li class="nav-item {{ Route::currentRouteNamed('register') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('register')}}">Register</a>
</li>
@include('layouts.navs.language')
