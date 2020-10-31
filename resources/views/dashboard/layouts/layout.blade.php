<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')
<body>
    @include('layouts.header')
    <div class="main-sec">
        <div class="container">    
        @yield('content')
        </div>
    </div>
    @include('layouts.footer')
    @stack('scripts')
</body>
</html>
