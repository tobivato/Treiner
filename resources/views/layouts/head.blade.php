<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'Find qualified & vetted pro soccer coaches to help you start training & boost your soccer skills on Treiner. Find and book a coaching session in minutes.')">
    @if(View::hasSection('title'))
        <title>@yield('title') | {{__('Treiner')}}</title>
    @else
        <title>{{__('Treiner: Soccer training - any time, anywhere')}}</title>
    @endif
    @if(config('app.env') == 'production' && (!(isset($notrack))))@include('layouts.tracking')@endif
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('safari-pinned-tab.svg')}}" color="#5bbad5">
    <link rel="canonical" href="{{URL::current()}}">
    <meta name="apple-mobile-web-app-title" content="Treiner">
    <meta name="application-name" content="Treiner">
    <meta name="msapplication-TileColor" content="#006942">
    <meta name="theme-color" content="#006942">    
    <meta name="twitter:card" content="summary"></meta>
    <meta name="twitter:site" content="@treinerco"></meta>
    <meta name="twitter:image" content="@yield('og-image', asset('og-image.png'))">  
    <meta name="twitter:title" content="@yield('title', 'Treiner: Soccer training - any time, anywhere')">
    <meta name="twitter:description" content="@yield('description', 'Book your soccer training session today with Treiner.')">  
    <meta property="og:image" content="@yield('og-image', asset('og-image.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Treiner: Soccer training - any time, anywhere')">
    <meta property="og:description" content="@yield('description', 'Book your soccer training session today with Treiner.')">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:site_name" content="Treiner">
    <meta property="fb:app_id" content="158063692018409">
    <script defer src="{{ mix('js/app.js')}}"></script>
    <link rel="stylesheet" href="{{ mix('css/app.css')}}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{ mix('css/app.css') }}"></noscript>
    @stack('scripts')
</head>