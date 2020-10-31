<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')
<body class="{{ Request::segment(1) }} {{ Request::segment(2) }}">
    @if((!isset($noHeader)))
        @include('layouts.header')
    @endif
    @if((!isset($plain)))
    <div class="main-sec @if(isset($background)) {{$background}} @endif">
        <div class="container">    
        @yield('content')
        </div>
    </div>
    @else
        @yield('content')
    @endif
    @include('layouts.footer')
    @yield('schema')
</body>
</html>
