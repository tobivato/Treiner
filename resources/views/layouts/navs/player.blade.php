@include('layouts.navs.post-job')
<li class="nav-item {{ Route::currentRouteNamed('jobs.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('jobs.index') }}">My Job Posts</a>
</li>
<li class="nav-item {{ Route::currentRouteNamed('coaches.show-cities') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('coaches.show-cities') }}">Browse Coaches</a>
</li>
<li class="nav-item {{ Route::currentRouteNamed('conversations.index') ? 'active' : '' }}"  @if(count(Auth::user()->conversations()) == 0) title="You don't have any conversations to view. Create a job or book a session to create a conversation with that coach." @endif>
    <a class="nav-link @if(count(Auth::user()->conversations()) == 0) disabled @endif" href="{{ route('conversations.index') }}">Messages</a>
</li>
<li class="nav-item {{ Route::currentRouteNamed('camps.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('camps.index')}}">Camps</a>
</li>
@include('layouts.navs.help')
@include('layouts.navs.profile')
