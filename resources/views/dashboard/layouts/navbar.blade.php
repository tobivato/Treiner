<nav class="sub-navbar py-1">
    <div class="navbar navbar-expand-lg p-0">
		<div class="container">
            <a class="navbar-brand"><img class="img-thumbnail rounded-circle" src="{{Cloudder::secureShow(Auth::user()->image_id)}}" height="50px" width="50px" alt="{{Auth::user()->name}}"></a>
            <h4>{{Auth::user()->name}}</h4>
            <h6 class="text-muted" style="padding-left: 10px; padding-top: 4px;">@lang('users.'.Auth::user()->role_type)</h6>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#dashboardNav" aria-controls="dashboardNav" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fas fa-bars"></i>
			</button>
			<div class="collapse navbar-collapse" id="dashboardNav">
				<ul class="nav navbar-nav ml-auto">
                    <li class="nav-item {{ Route::currentRouteNamed('home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                    </li>
                    @if(Auth::user()->role instanceof \Treiner\Coach)
                    <li class="nav-item {{ Route::currentRouteNamed('settings.show') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('settings.show') }}"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteNamed('home.profile') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('home.profile')}}"><i class="fa fa-user"></i> Profile</a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteNamed('blogs.dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('blogs.dashboard')}}"><i class="fa fa-blog"></i> Blogs</a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteNamed('camps.dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('camps.dashboard')}}"><i class="fas fa-campground"></i> Camps</a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteNamed('invitations.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('invitations.index')}}"><i class="fas fa-sign-in-alt"></i> Invitations</a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteNamed('live.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('live.index')}}"><i class="fas fa-video" aria-hidden="true"></i> Live Sessions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" rel="noopener" href="{{Auth::user()->coach->stripeLink}}"><i class="fa fa-money-bill" aria-hidden="true"></i> Payment Details <i class="fas fa-external-link-alt"></i></a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteNamed('offers.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('offers.index')}}"><i class="fa fa-list" aria-hidden="true"></i> Job Applications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="{{route('coaches.show', Auth::user()->coach->id)}}"><i class="fa fa-eye" aria-hidden="true"></i> Preview <i class="fas fa-external-link-alt"></i></a>
                    </li>
                    @else
                    <li class="nav-item {{ Route::currentRouteNamed('jobs.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('jobs.index')}}"><i class="fa fa-list" aria-hidden="true"></i> Jobs</a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteNamed('sessions.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('sessions.index')}}"><i class="fa fa-book" aria-hidden="true"></i> Sessions</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                </ul>
			</div>
		</div>
    </div>
</nav>