<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head', ['notrack' => true])
<body>
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
                <div class="list-group">
                    <a href="{{route('admin.dashboard')}}" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="{{route('reports.index')}}" class="list-group-item list-group-item-action">Reports <span class="badge badge-secondary badge-pill">{{$reportsCount}}</span></a>
                    <a href="{{route('verifications.index')}}" class="list-group-item list-group-item-action">Coach Verification <span class="badge badge-secondary badge-pill">{{$verificationsCount}}</span></a>
                    <a href="{{route('admins.index')}}" class="list-group-item list-group-item-action">Admins <span class="badge badge-secondary badge-pill">{{$adminsCount}}</span></a>
                    <a href="{{route('admin.players.search')}}" class="list-group-item list-group-item-action">Players <span class="badge badge-secondary badge-pill">{{$playersCount}}</span></a>
                    <a href="{{route('admin.coaches.search')}}" class="list-group-item list-group-item-action">Coaches <span class="badge badge-secondary badge-pill">{{$coachesCount}}</span></a>
                    <a href="{{route('admin.sessions.search')}}" class="list-group-item list-group-item-action">Sessions <span class="badge badge-secondary badge-pill">{{$sessionsCount}}</span></a>
                    <a href="{{route('admin.jobs.index')}}" class="list-group-item list-group-item-action">Jobs <span class="badge badge-secondary badge-pill">{{$jobPostCount}}</span></a>
                    <a href="{{route('coupons.index')}}" class="list-group-item list-group-item-action">Coupons <span class="badge badge-secondary badge-pill">{{$couponsCount}}</span></a>
                    <a href="{{route('admin.blogs.index')}}" class="list-group-item list-group-item-action">Blogs</a>
                </div>
            </div>
        <div class="col-md-10">
                @yield('content')
            </div>
        </div>
    </div>
    @include('layouts.footer')
    @stack('scripts')
</body>
</html>
