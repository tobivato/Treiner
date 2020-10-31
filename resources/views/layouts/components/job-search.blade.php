<div class="card card-body p-3 job-list-item" style="margin-bottom:10px;">
    <a href="{{route('jobs.show', $jobPost->id)}}">
        <div class="row">
            <div class="col-sm-8">
                <h2 class="h3 futura-medium">{{$jobPost->title}}</h2>
                <div class="text-lg">
                    <h3 class="futura-bold">{{$jobPost->formattedFee}}</h3>
                </div>
                <ul class="list-unstyled">
                    <li class="py-1 small ellipsis-overflow"><i class="fas fa-map-marker-alt mr-2"></i> {{$jobPost->location->locality . ', ' . $jobPost->location->country}}</li>
                    <li class="py-1 small ellipsis-overflow" title="{{$jobPost->starts}}"><i class="far fa-calendar-alt mr-2"></i> {{$jobPost->starts->format('D, jS F Y')}}</li>
                </ul>
            </div>
            <div class="col-sm-4">
                <img src="{{Cloudder::secureShow($jobPost->player->user->image_id)}}"
                    width="100%" class="circle-bordered-img rounded-circle" alt="{{$jobPost->player->user->name}}">
            </div>
        </div>
    </a>
</div>

