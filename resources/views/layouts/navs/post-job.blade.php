@auth
<li class="nav-item">
    <a class="btn btn-primary post-job" href="#">Post a job</a>
</li>
@else
<li class="nav-item">
    <a class="btn btn-primary" id="" href="{{route('login')}}">Post a job</a>
</li>
@endauth