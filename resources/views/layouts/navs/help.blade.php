<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Help
    </a>
    <div class="dropdown-menu">
        {{--<a class="dropdown-item" href="{{route('faq')}}">FAQ</a>--}}
        <a class="dropdown-item" href="{{route('contact')}}">Contact Us</a>
        <a class="dropdown-item" href="{{route('privacy')}}">Privacy Policy</a>
        @auth
        <a class="dropdown-item" href="{{route('support')}}">Submit a Support Ticket</a>
        @endauth
    </div>
</li>