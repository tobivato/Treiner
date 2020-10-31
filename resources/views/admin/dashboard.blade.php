@extends('admin.layouts.layout')
@section('title', 'Admin Dashboard')
@section('content')
<ul class="list-group">
    <a href="{{route('reports.index')}}" class="list-group-item d-flex list-group-item-action justify-content-between align-items-center">
        Unresolved Reports
        <span class="badge badge-secondary badge-pill">{{$reports}}</span>
    </a>
    <a href="{{route('verifications.index')}}" class="list-group-item d-flex list-group-item-action justify-content-between align-items-center">
        Waiting Coach Verifications
        <span class="badge badge-secondary badge-pill">{{$verifications}}</span>
    </a>
    <div class="row">
        <div class="col-md-4">
            <h1>{{$playerCount}} <small class="text-muted">{{sprintf("%+d", $playerCount - $playerCountLastMonth)}}</small></h1>
            <p class="text-muted">Total players</p>
            <h1>{{$jobPostCount}} <small class="text-muted">{{sprintf("%+d", $jobPostCount - $jobPostCountLastMonth)}}</small></h1>
            <p class="text-muted">Job posts this month</p>
            <hr>
            <h1>{{$sessionCount}} <small class="text-muted">{{sprintf("%+d", $sessionCount - $sessionCountLastMonth)}}</small></h1>
            <p class="text-muted">Sessions this month</p>
            <h1>{{$bookedSessions}} <small class="text-muted">{{sprintf("%+d", $bookedSessions - $bookedSessionsLastMonth)}}</small></h1>
            <p class="text-muted">Total bookings made by players this month</p>
            <hr>
            <h1>{{$coachCount}} <small class="text-muted">{{sprintf("%+d", $coachCount - $coachCountLastMonth)}}</small></h1>
            <p class="text-muted">Total coaches</p>
            <h1>{{round($sessionsPerCoach, 2)}}</h1>
            <p class="text-muted">Sessions per coach</p>
            <h1>{{round($averageReview, 2)}} <small class="text-muted">{{sprintf("%+d", $averageReview - $averageReviewLastMonth)}}% ({{$reviewCount}})</small></h1>
            <p class="text-muted">Average coach review % this month</p>
            <hr>
            <h1>{{$audTotal}}</h1>
            <p class="text-muted">Rough total income this month, converted to AUD based on 2020 values</p>
            @foreach ($payments as $key => $payment)
            <h1>{{$payment['current']}} <small class="text-muted">{{$payment['diff']}}</small></h1>
            <p class="text-muted">{{$key}} income this month</p>
            @endforeach
        </div>

        <script type="text/javascript" src="{{asset('js/charts.js')}}"></script>

        <div class="col-md-8">
                <canvas id="sessions" width="400" height="150"></canvas>
                <canvas id="jobPosts" width="400" height="150"></canvas>
                <canvas id="players" width="400" height="150"></canvas>
                <canvas id="coaches" width="400" height="150"></canvas>
                <div class="row">
                    <div class="col-sm-6">
                        <canvas id="coaches-bookings" width="200" height="200"></canvas>
                        <p class="text-muted">Number of sessions per coach</p>
                    </div>
                    <div class="col-sm-6">
                        <canvas id="players-bookings" width="200" height="200"></canvas>
                        <p class="text-muted">Number of sessions booked per player</p>
                    </div>
                </div>
                <script>

                const sessionsData = {!!json_encode(array_values($graphData['sessions']))!!};
                const jobPostsData = {!!json_encode(array_values($graphData['jobPosts']))!!};
                const playersData = {!!json_encode(array_values($graphData['players']))!!};
                const coachesData = {!!json_encode(array_values($graphData['coaches']))!!};
                const coachBookingsData = {!!json_encode(array_values($sessionCoachCount))!!};
                const playerBookingData = {!!json_encode(array_values($sessionPlayersCount))!!};
                
                new Chart(document.getElementById('sessions').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: {!!json_encode(array_keys($graphData['sessions']))!!},
                        datasets: [{
                            label: 'Number of bookings made by players',
                            data: sessionsData,
                        }]
                    },
                });

                new Chart(document.getElementById('jobPosts').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: {!!json_encode(array_keys($graphData['jobPosts']))!!},
                        datasets: [{
                            label: 'Number of job posts',
                            data: jobPostsData,
                        }]
                    },
                });
                
                new Chart(document.getElementById('players').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: {!!json_encode(array_keys($graphData['players']))!!},
                        datasets: [{
                            label: 'Number of players added to the platform',
                            data: playersData,
                        }]
                    },
                });

                new Chart(document.getElementById('coaches').getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: {!!json_encode(array_keys($graphData['coaches']))!!},
                        datasets: [{
                            label: 'Number of coaches added to the platform',
                            data: coachesData,
                        }]
                    },
                });

                new Chart(document.getElementById('coaches-bookings').getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: {!!json_encode(array_keys($sessionCoachCount))!!},
                        datasets: [{
                            label: 'Number of coaches added to the platform',
                            data: coachBookingsData,
                        }]
                    },
                });

                new Chart(document.getElementById('players-bookings').getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: {!!json_encode(($sessionPlayersCount))!!},
                        datasets: [{
                            label: 'Number of coaches added to the platform',
                            data: playerBookingData,
                        }]
                    },
                });
                </script>                
        </div>
    </div>
</ul>
@endsection