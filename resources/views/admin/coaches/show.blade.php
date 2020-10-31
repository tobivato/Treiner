@extends('admin.layouts.layout')
@section('title', 'View Coach')
@section('content')
<nav class="nav nav-tabs nav-stacked">
    <a class="nav-link active" data-toggle="tab" href="#info">{{$coach->user->name}}</a>
    <a class="nav-link" data-toggle="tab" href="#sessions">Sessions <span class="badge badge-secondary badge-pill">{{$coach->sessions->count()}}</span></a>
    <a class="nav-link" data-toggle="tab" href="#payments">Received Payments <span class="badge badge-secondary badge-pill">{{$coach->payments->count()}}</span></a>
    <a class="nav-link" data-toggle="tab" href="#offers">Job Applications <span class="badge badge-secondary badge-pill">{{$coach->jobOffers->count()}}</span></a>
</nav>

@include('layouts.components.messages')
@include('layouts.components.errors')

<div class="tab-content">
    <div id="info" class="tab-pane active">
        <a class="btn btn-danger" href="{{route('admins.destroy', $coach->user)}}" role="button">Ban {{$coach->user->name}}</a>
        <table class="table table-striped">
            <tr>
                <td>ID</td>
                <td>{{$coach->id}}</td>
            </tr>
            <tr>
                <td>User ID</td>
                <td>{{$coach->user->id}}</td>
            </tr>
            <tr>
                <td>Verified</td>
                <td>
                    <form action="{{route('admin.coaches.updateverified', $coach)}}" method="post">
                    <select name="verification_status" id="verification-status">
                        @if($coach->verification_status == 'verified')
                        <option value="verified" selected>Yes</option>
                        <option value="denied">No</option>
                        @elseif($coach->verification_status == 'denied')
                        <option value="verified">Yes</option>
                        <option value="denied" selected>No</option>
                        @else
                        <option disabled value="disabled">Pending</option>
                        @endif
                    </select>
                    <button type="submit" class="">Submit</button>
                    <form>
                </td>
            </tr>
            <tr>
                <td>Coach Page</td>
                <td><a href="{{route('coaches.show', $coach->id)}}">View</a></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td>{{$coach->user->first_name}}</td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td>{{$coach->user->last_name}}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{$coach->user->email}}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>{{$coach->user->phone}}</td>
            </tr>
            <tr>
                <td>Currency</td>
                <td>{{$coach->user->currency}}</td>
            </tr>
            <tr>
                <td>Treiner Fee</td>
                <td>
                    <form action="{{route('admin.coaches.updatefee', $coach)}}" method="post">
                        @csrf
                        <input type="number" name="fee" value="{{$coach->treiner_fee}}" min="0" max="100">%
                        <button type="submit" class="">Submit</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>Qualification</td>
                <td>{{$coach->qualification}}</td>
            </tr>
            <tr>
                <td>Business Registration Number</td>
                <td>{{$coach->business_registration_number}}</td>
            </tr>
            <tr>
                <td>Average Rating</td>
                <td>{{$coach->averageReview}}</td>
            </tr>
            <tr>
                <td>Session Types</td>
                <td>{{$coach->formattedSessionTypes}}</td>
            </tr>
            <tr>
                <td>Years Coaching</td>
                <td>{{$coach->years_coaching}}</td>
            </tr>
            <tr>
                <td>Age Groups Coached</td>
                <td>{{$coach->formattedAgeGroupsCoached}}</td>
            </tr>
        </table>
    </div>

    <div id="sessions" class="tab-pane">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Location</th>
                    <th>Starts</th>
                    <th>Length</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coach->sessions as $session)
                <tr>
                    <td><a href="{{route('admin.sessions.show', $session->id)}}">{{$session->id}}</a></td>
                    <td scope="row">{{$session->location->address}}</td>
                    <td>{{$session->starts}}</td>
                    <td>{{$session->length}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="offers" class="tab-pane">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Offer ID</th>
                    <th>Job ID</th>
                    <th>Offer Content</th>
                    <th>Offered Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coach->jobOffers as $jobOffer)
                    <tr>
                        <td>{{$jobOffer->id}}</td>
                        <td>{{$jobOffer->jobPost->id}}</td>
                        <td>{{$jobOffer->content}}</td>
                        <td>{{$jobOffer->formattedFee}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="payments" class="tab-pane">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Player ID</th>
                    <th>Currency</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coach->payments as $payment)   
                <tr>
                    <td scope="row">{{$payment->id}}</td>
                    <td>{{$payment->player_id}}</td>
                    <td>{{$payment->currency}}</td>
                    <td>{{$payment->formattedFee}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<h5>Coach Summary</h5>
<p>{{$coach->profile_summary}}</p>
<h5>Coaching/Playing Career</h5>
<p>{{$coach->profile_playing}}</p>
<h5>Coaching Philosophy</h5>
<p>{{$coach->profile_philosophy}}</p>
<h5>Average Session</h5>
<p>{{$coach->profile_session}}</p>
@endsection