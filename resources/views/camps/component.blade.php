<div class="card card-body p-3 job-list-item" style="margin-bottom:10px;">
    <a href="{{route('camps.show', $camp)}}">
        <div class="row">
            <img src="{{Cloudder::secureShow($camp->image_id, ['width' => '1000', 'height' => '500'])}}"
                width="100%" class="webkit-stretch-fix" alt="{{$camp->title}}">
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="text-lg">
                    <h3 class="futura-bold ellipsis-overflow" title="{{$camp->title}}">{{$camp->title}}</h3>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="text-lg">
                            <div class="py-1 ellipsis-overflow" title="{{$camp->session->starts}}"><i class="far fa-calendar-alt mr-2"></i>{{$camp->session->starts->format('jS F')}} - {{$camp->session->starts->addDays($camp->days)->format('jS F')}}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-lg">
                            <h4 class="text-right">{{$camp->session->formattedFeePerPerson}}</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="py-1 small ellipsis-overflow">
                            <i class="fa fa-map-marker-alt mr-2"></i>{{$camp->session->location->address}}
                        </div>
                        <div class="py-1 small ellipsis-overflow">
                            <i class="fas fa-clock mr-2"></i>{{\Carbon\Carbon::createFromFormat('H:i:s', $camp->start_time)->format('h:i a') . ' - ' . \Carbon\Carbon::createFromFormat('H:i:s', $camp->end_time)->format('h:i a')}}
                        </div>
                    </div>
                    <div class="col-sm-4">
                            <div class="py-1 text-right">
                                <h4>
                                    <i class="fas fa-user-friends mr-2"></i>{{count($camp->session->sessionPlayers)}} / {{$camp->session->group_max}}
                                </h4>
                            </div>
                    </div>
                </div>
                <div class="py-1 small ellipsis-overflow"><i class="fas fa-paragraph mr-2"></i> {{Str::limit($camp->description, 100)}}</div>
            </div>
        </div>
    </a>
</div>
    