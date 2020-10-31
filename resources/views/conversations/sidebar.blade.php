<div class="jobs-sidebar d-none d-md-block">
    @foreach (Auth::user()->conversations() as $conversation)
    <div class="card card-body p-3 job-list-item @if(route('conversations.show', $conversation->id) == url()->current()) active @endif">
        <a href="{{route('conversations.show', $conversation->id)}}">
        <div class="media">
            <div class="media-left mr-3 position-relative">
                <img src="{{Cloudder::secureShow($conversation->fromPerspective()->image_id)}}" width="62" class="circle-bordered-img rounded-circle" alt="{{$conversation->fromPerspective()->name}}">
            </div>
            <div class="media-body">
                <h2 class="h3 futura-medium">{{$conversation->fromPerspective()->name}}</h2>
                <p class="mb-0 d-none d-lg-block">{{$conversation->subject}}</p>
            </div>
        </div>
    </a>
    </div>
    @endforeach
</div>