<ul>
    @auth
    <li>
        <div class="media">
            <img src="{{Cloudder::secureShow(Auth::user()->image_id)}}" width="62" class="mr-3 circle-bordered-img rounded-circle" alt="{{Auth::user()->name}}">
            <div class="media-body">
                <div class="form-group text-right position-relative">
                @include('layouts.components.errors')
                <form action="{{route('comments.store')}}" method="post">
                @csrf
                    <input type="hidden" name="commentable_type" value="{{get_class($instance)}}">
                    <input type="hidden" name="commentable_id" value="{{$instance->id}}">
                    <textarea name="content" data-length-indicator="length-indicator" maxlength="1500" class="form-control rounded-lg" rows="4" placeholder="Submit a comment for this {{$commentableType}}."></textarea>
                    <div class="input-buttons">
                        <button type="submit" class="btn-link bg-transparent border-0">Send</button>
                    </div>
                </form>
                <small class="text-muted d-block pt-2"><span id="length-indicator">1500</span> characters left</small>
                </div>
            </div>
        </div>
    </li>
    @endauth
    @foreach($instance->comments->sortByDesc('created_at') as $comment)
    <li>
        <div class="media">
            <img src="{{Cloudder::secureShow($comment->user->image_id)}}" width="62" class="mr-3 circle-bordered-img rounded-circle" alt="{{$comment->user->name}}">
            <div class="media-body">
                <div class="row">
                    <div class="col-sm-7">
                        <p class="text-muted mb-2" title="{{$comment->created_at}}">{{$comment->user->name . ', ' . $comment->created_at->diffForHumans()}}</p>
                    </div>
                    <div class="col-sm-5">
                        @if(Auth::check() && $comment->user->id == Auth::user()->id)
                        <div class="text-right">
                            <a href="{{route('comments.edit', $comment)}}">Edit</a>
                            <form style="display:inline" action="{{route('comments.destroy', $comment)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete">
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                <p class="mb-0">{{$comment->content}}</p>
            </div>
        </div>
    </li>
    <br>
    @endforeach
</ul>