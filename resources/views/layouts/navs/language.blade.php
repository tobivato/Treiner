<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        @if (session('locale'))
            <img width="25" alt="{{session('locale')}}" class="img-fluid" src="{{asset('img/flag/' . session('locale') . '.svg')}}">
            {{strtoupper(session('locale'))}}  
        @else
            <img width="25" class="img-fluid" src="{{asset('img/flag/en.svg')}}" alt="English"> EN
        @endif
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{--route('lang', 'en')--}}#"><img width="25" class="img-fluid" src="{{asset('img/flag/en.svg')}}" alt="English"> English</a>
        {{--<a class="dropdown-item" target="_blank" rel="noopener" href="https://malaysia.treiner.co"><img width="25" class="img-fluid" src="{{asset('img/flag/ms.svg')}}" alt="Melayu"> Melayu</a>--}}
    </div>
</li>