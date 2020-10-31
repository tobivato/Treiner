@extends('admin.layouts.layout')
@section('title', 'Create coupon')
@section('content')
@include('layouts.components.errors')
@include('layouts.components.messages')
    <form action="{{route('coupons.store')}}" method="post">
        @csrf
        <div class="form-group">
          <label for="code">Code</label>
          <input type="text"
            class="form-control" name="code" id="code" placeholder="XYZ123">
        </div>
        <div class="form-group">
          <label for="percent-off">Percent Off</label>
          <input type="number"
            class="form-control" name="percent-off" min="0" max="100" value="0" id="percent-off">
            <small class="text-muted">You will need to add an amount off when you add a percent off,
                which will cap the amount of money a player can save with a coupon. 
                Otherwise a player could do something like use a 70% off discount on a $700 order.</small>
        </div>
        <div class="form-group">
          <label for="amount-off">Amount off (In smallest currency denomination)</label>
          <input type="number"
            class="form-control" name="amount-off" value="0" id="amount-off">
            <small class="text-muted">If you don't want to add a percentage, just set it to 0. This
                needs to be in the smallest denomination because of currencies which aren't broken up into smaller 
                parts (e.g. yen).
            </small>
        </div>
        <div class="form-group">
          <label for="times-redeemable">Times Redeemable Per Person</label>
          <input type="number"
            class="form-control" name="times-redeemable-per-person" value="1" max="10" min="1" id="times-redeemable">
            <small class="text-muted">You will need to enter a number of times that the coupon is 
                redeemable for each person. Usually this should be 1 but if you want to make it so someone can 
                enter the coupon more than one time then put that.</small>
        </div>
        <div class="form-group">
          <label for="times-redeemable-total">Times Redeemable Total</label>
          <input type="number"
            class="form-control" name="times-redeemable-total" id="times-redeemable-total">
          <small class="text-muted">This is for setting a number of times that this code can be redeemed in total. For
            example, you only want one person to be able to redeem it or only x number of people are budgeted for. It's
            important to set this to a reasonable number so that you don't end up with e.g. 10,000 people using a 50% off code.
          </small>
        </div>
        <div class="form-group">
          <label for="coach-id">Coach ID (Not required)</label>
          <input type="number" min="0"
            class="form-control" name="coach-id" id="coach-id">
            <small class="text-muted">You can use the coach ID to limit a coupon to a specific coach. Don't enter anything if you
                want the coupon to be available to anybody.
            </small>
        </div>
        <div class="form-group">
          <label for="redeem-by">Redeem By</label>
          <input type="datetime-local"
            class="form-control" name="redeem-by" id="redeem-by">
            <small class="text-muted">The redeem by field is used to provide an expiry date for the
                coupon, this is useful because it limits the time the coupon can be used.</small>
        </div>
        <div class="form-group">
          <label for="currency">Currency</label>
          <select class="form-control" name="currency" id="currency">
            @foreach (config('treiner.countries') as $country)
                <option value="{{$country['currency']}}">{{$country['currency'] . ', ' . $country['name']}}</option>
            @endforeach
          </select>
          <small class="text-muted">The currency will also limit the country the coupon can be used in,
              but it's important since otherwise a coupon for a low-value currency could be used for a
              higher value one.</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection