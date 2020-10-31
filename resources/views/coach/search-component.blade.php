<div class="card card-body p-3 job-list-item" style="margin-bottom:10px;">
    <a href="{{route('coaches.show', ['coach' => $coach->id, 'slug' => $coach->slug])}}">
        <div class="row">
            <div class="col-sm-8">
                <h2 class="h3 futura-medium">{{$coach->user ? $coach->user->name : ''}} @include('layouts.components.coaches.badge')</h2>
                <div class="text-lg">
                    <h3 class="futura-bold">{{$coach->fee ? "$".$coach->fee." per hour": ""}}</h3>
                </div>
                <ul class="list-unstyled">
                    <li class="py-1 small ellipsis-overflow"><i class="fas fa-map-marker-alt mr-2"></i> {{$coach->formattedLocations}}</li>
                    <li class="py-1 small ellipsis-overflow"><i class="far fa-calendar-alt mr-2"></i> {{$coach->formattedSessionTypes}}</li>
                    <li class="py-1 small ellipsis-overflow" title="{{$coach->averageRating}}"><i class="far fa-smile mr-2"></i> @include('layouts.components.coaches.stars')</li>
                </ul>
            </div>
            <div class="col-sm-4">
                <img src="{{$coach->user ? Cloudder::secureShow($coach->user->image_id) : ''}}"
                    width="100%" class="circle-bordered-img rounded-circle" alt="{{$coach->user ? $coach->user->name : ''}}">
            </div>
        </div>
    </a>
</div>
