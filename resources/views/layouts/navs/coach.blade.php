<li class="nav-item {{ Route::currentRouteNamed('jobs.show') ? 'active' : '' }}" @cannot('viewAny', 'Treiner\JobPost') title="Please wait until your account has been verified before you search for jobs." @endcannot>
    <a class="nav-link @cannot('viewAny', 'Treiner\JobPost') disabled @endcannot" href="{{ route('jobs.welcome') }}">Browse Jobs</a>
</li>
<li class="nav-item {{ Route::currentRouteNamed('jobs.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('offers.index') }}">My Job Applications</a>
</li>
<li class="nav-item {{ Route::currentRouteNamed('conversations.index') ? 'active' : '' }}" @if(count(Auth::user()->conversations()) == 0) title="You don't have any conversations to view. Apply for a job or create sessions for players to book." @endif>
    <a class="nav-link @if(count(Auth::user()->conversations()) == 0) disabled @endif" href="{{ route('conversations.index') }}">Messages</a>
</li>
<li class="nav-item {{ Route::currentRouteNamed('sessions.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('home') }}">My Sessions</a>
</li>
@include('layouts.navs.help')
@include('layouts.navs.profile')
