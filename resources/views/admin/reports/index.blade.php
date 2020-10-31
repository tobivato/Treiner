@extends('admin.layouts.layout')
@section('title', 'Reports')
@section('content')
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Complainant</th>
                <th>Defendant</th>
                <th>Session ID</th>
                <th>Created at</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $key => $report)              
            <tr>
                <td scope="row">@if($report->complainant)<a href="{{$report->complainant instanceof \Treiner\Coach ? route('admin.coaches.show', $report->complainant->id) : route('admin.players.show', $report->complainant->id)}}">{{$report->complainant->user->name}}</a>@endif</td>
                <td>@if($report->defendant)<a href="{{$report->complainant instanceof \Treiner\Player ? route('admin.coaches.show', $report->defendant->id) : route('admin.players.show', $report->defendant->id)}}">{{$report->defendant->user->name}}</a>@endif</td>    
                <td>{{$report->session_id}}</td>
                <td>{{$report->created_at}}</td>
                <td>{{$report->content}}</td>
                <td>
                    @if(!$report->resolved)
                    <a class="btn btn-success" href="{{route('reports.toggle', $report->id)}}" role="button">Resolve</a>
                    @else
                    <a class="btn btn-danger" href="{{route('reports.toggle', $report->id)}}" role="button">Reopen</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    {{ $reports->links() }}              
@endsection