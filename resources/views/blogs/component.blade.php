<div class="card card-body p-3 job-list-item" style="margin-bottom:10px;">
    <a href="{{route('blogs.show', ['blog' => $blog, 'slug' => $blog->slug])}}">
        <div class="row">
            <img src="{{Cloudder::secureShow($blog->image_id, ['width' => '1000', 'height' => '500'])}}"
                width="100%" class="webkit-stretch-fix" alt="{{$blog->title}}">
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h2 class="h3 futura-medium">{{$blog->coach ? $blog->coach->user->name : 'Treiner'}}</h2>
                <div class="text-lg">
                    <h3 class="futura-bold">{{$blog->title}}</h3>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="py-1 small ellipsis-overflow"><i class="fas fa-clock mr-2"></i> {{$blog->time}} minute read</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="py-1 small ellipsis-overflow text-right" title="{{$blog->created_at}}"><i class="far fa-calendar-alt mr-2"></i> {{$blog->created_at->diffForHumans()}}</div>
                    </div>
                </div>
                    <div class="py-1 small ellipsis-overflow"><i class="fas fa-paragraph mr-2"></i> {{$blog->excerpt}}</div>
            </div>
        </div>
    </a>
</div>
    