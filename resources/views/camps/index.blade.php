@extends('layouts.app', ['background' => 'coach-background'])
@section('title', 'Camps')
@section('content')
    @if (count($camps) > 0)
    <div class="row">
    @foreach ($camps as $camp)
        <div class="col-lg-4">
        @include('camps.component')
        </div>
    @endforeach
    </div>
    {{ $camps->links() }}        
    @else
    <p>There are no camps.</p>
    @endif
@endsection
