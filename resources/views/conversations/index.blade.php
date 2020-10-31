@extends('layouts.app')
@section('title', 'Messages')
@section('content')
<div class="main-sec">
	<div class="container">
		<div class="row no-gutters">
			<div class="col-md-4">
				@include('conversations.sidebar')
			</div>
			<div class="col-md-8">
				<div class="scroll-sec mt-sm-4 mt-md-0 pl-2 pr-4">

				</div>
			</div>
		</div>
	</div>
</div>
@endsection