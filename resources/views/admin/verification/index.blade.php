@extends('admin.layouts.layout')
@section('title', 'Coach Verification')
@section('content')
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Coach Name</th>
                <th>Coach ID</th>
                <th>Verifications</th>
                <th>Profile Picture</th>
                <th>Deny Reason</th>
                <th><div class="dropdown open">
                    <button class=" dropdown-toggle" type="button" id="dropdowntrigger" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                                Actions
                            </button>
                    <div class="dropdown-menu" aria-labelledby="dropdowntrigger">
                        <a class="dropdown-item @if(count($coaches) == 0) disabled @endif" href="{{route('verifications.csv')}}">Export as CSV</a>
                    </div>
                </div></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coaches as $coach)              
            <tr>
                <td scope="row"><a href="{{route('coaches.show', $coach)}}"></a>{{$coach->user->name}}</td>
                <td>{{$coach->id}}</td>    
                <td>
                    @foreach ($coach->verifications as $verification)
                        <p>{{$verification->verification_type}}: {{$verification->verification_number}}</p>
                    @endforeach
                </td>
                <td>
                    <img src="{{Cloudder::secureShow($coach->user->image_id)}}" width="200" alt="">
                </td>
                <td>
                    <form action="{{route('verifications.deny')}}" method="post">
                    <input type="text"
                    class="form-control" name="deny_reason" required placeholder="Use if denying coach">
                </td>
                <td>
                            @csrf
                            <input type="hidden" name="coach_id" value="{{$coach->id}}">
                            <button type="submit" onclick="return confirm('Are you sure you want to deny this coach?')" class="btn btn-block btn-danger">Deny</button>
                        </form>
                        <br>
                        <form action="{{route('verifications.accept')}}" method="post">
                            @csrf
                            <input type="hidden" name="coach_id" value="{{$coach->id}}">
                            <button type="submit" onclick="return confirm('Are you sure you want to accept this coach?')" class="btn btn-block btn-success">Accept</button>
                        </form>
                </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    {{ $coaches->links() }}              
@endsection