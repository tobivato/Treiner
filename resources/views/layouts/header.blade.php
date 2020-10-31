<nav class="position-sticky navbar-custom p-0">
	<div class="navbar navbar-expand-lg p-0">
		<div class="container">
			<a class="navbar-brand" href="{{route('welcome')}}"><img src="{{asset('img/horizontal_lockup.svg')}}" height="50px" alt="The Treiner logo"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fas fa-bars"></i>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="nav navbar-nav ml-auto">
                    @guest
                        @include('layouts.navs.guest')
                    @else
                        @if(Auth::user()->role instanceof Treiner\Coach)
                            @include('layouts.navs.coach')
                        @else
                            @include('layouts.navs.player')
                        @endif
                    @endguest
                </ul>
			</div>
		</div>
    </div>
    @yield('sub-navbar')
</nav>
