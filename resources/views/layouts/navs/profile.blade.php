<li class="nav-item nav-profile dropdown no-arrow pr-0">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <img class="img-profile rounded-circle" alt="{{Auth::user()->name}}" src="{{Cloudder::secureShow(Auth::user()->image_id)}}">
        <span class="mr-2 d-lg-none">{{Auth::user()->name}}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        @if (Auth::user()->isAdmin())
        <a class="dropdown-item" href="{{route('admin.dashboard')}}">
            <i class="fas fa-toolbox fa-sm fa-fw mr-2 text-gray-400"></i>
            Admin Dashboard
        </a>  
        @else
        <a class="dropdown-item" href="{{route('home')}}">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Dashboard
        </a>
        @if(Auth::user()->role instanceof Treiner\Coach)
        <a class="dropdown-item" href="{{route('settings.show')}}">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
        </a>
        @endif
        @endif
        <div class="dropdown-divider"></div>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</li>