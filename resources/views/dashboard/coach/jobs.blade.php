@extends('dashboard.layouts.layout')
@section('title', 'Job Applications')
@section('content')
@section('sub-navbar')
  @include('dashboard.layouts.navbar')
@endsection
@include('layouts.components.messages')
<div class="alert alert-info">
    <div class="row">
        <div class="col-sm-10">
            <h3><i class="fas fa-question-circle fa-lg"></i> Job Applications</h3>
            <hr>
            <p>Treiner lets players post their own jobs, which as a coach you can submit offers for.
                The difference between sessions you create and jobs you apply for is that players put their
                own recommended location and price on their jobs, and often have their own specifications 
                for how they want the job to work out.
                You can use this page to view, edit and delete your job applications.
            </p>
            @if(count($jobOffers) == 0)
            <p>You haven't applied to any jobs yet.</p>
            @endif
        </div>
    </div>
  </div>
<div class="table-responsive">
<table class="table">
        <thead>
            <tr>
                <th>Job</th>
                <th>Offered Price</th>
                <th>Job Budget</th>
                <th>Starts at</th>
                <th>Length</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($jobOffers as $jobOffer)
                <tr>
                    <td><a href="{{route('jobs.show', $jobOffer->jobPost->id)}}">{{$jobOffer->jobPost->title}}</a></td>
                    <td>{{$jobOffer->formattedFee}}</td>
                    <td>{{$jobOffer->jobPost->formattedFee}}</td>
                    <td>{{$jobOffer->jobPost->starts}}</td>
                    <td>{{$jobOffer->jobPost->length}}</td>
                    <td>
                        <form action="{{route('offers.destroy', $jobOffer->id)}}" onsubmit="return confirm('Are you sure you want to delete this job offer?')" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn-block">Delete</button>
                        </form>
                    </td>
                    <td><a class="" href="{{route('offers.edit', $jobOffer->id)}}" role="button">Edit</a></td>
                </tr>
                <tr>
                    <td colspan="7">{{$jobOffer->content}}</td>
                </tr>
                @endforeach
            </tbody>
</table>
</div>
@endsection