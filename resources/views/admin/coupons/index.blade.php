@extends('admin.layouts.layout')
@section('title', 'All Coupons')
@section('content')
@include('layouts.components.errors')
@include('layouts.components.messages')
<table class="table table-hover">
    <thead class="thead-dark">
        <tr>
                <th>Code</th>
                <th>Currency</th>
                <th>Percent off</th>
                <th>Amount off</th>
                <th>Times redeemable (per person)</th>
                <th>Times redeemable (total)</th>
                <th>Times redeemed</th>
                <th>Coach ID</th>
                <th>Redeem by</th>
                <th><div class="dropdown open">
                    <button class=" dropdown-toggle" type="button" id="dropdowntrigger" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                                Actions
                            </button>
                    <div class="dropdown-menu" aria-labelledby="dropdowntrigger">
                        <a class="dropdown-item" href="{{route('coupons.create')}}">Add a new coupon</a>
                    </div>
                </div></th>
            </tr>
        </thead>
        <tbody>
            @foreach($coupons as $coupon)
            <tr>
                <td scope="row">{{$coupon->code}}</td>
                <td>{{$coupon->currency}}</td>
                <td>{{$coupon->percent_off}}</td>
                <td>{{$coupon->amount_off}}</td>
                <td>{{$coupon->times_redeemable_per_person}}</td>
                <td>{{$coupon->times_redeemable_total}}</td>
                <td>{{DB::table('coupon_players')->where('coupon_id', $coupon->code)->count()}}</td>
                <td>{{$coupon->coach_id}}</td>
                <td>{{$coupon->redeem_by}}</td>
                <td>
                    <a href="{{route('coupons.edit', $coupon->code)}}">Edit</a>
                    <form action="{{route('coupons.destroy', $coupon->code)}}" onsubmit="return confirm('Are you sure you want to delete this code?')" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Destroy</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$coupons->links()}}
@endsection