@extends('layouts.app')
@section('title', 'Cart')
@section('content')
<div class="row">
    <div class="col-md-8">
        @push('scripts')
            <script>
                var cartInfo = {
                    currency: "{{Auth::user()->currency}}",
                    id: "{{'SB' . $cartitem->session->id}}",
                    total: "{{$cartitem->calculatePrice() / 100}}",
                    name: "{{__('coaches.'.$cartitem->session->type) . ' with ' . $cartitem->session->coach->user->name}}",
                    category: "{{$cartitem->session->type}}",
                    quantity: {{$cartitem->players}},
                    price: {{$cartitem->session->fee / 100}}
                };
            </script>
            <script src="https://js.stripe.com/v3/"></script>
        @endpush


        <form id="payment-form" method="POST" action="{{route('cart.complete')}}">
            @include('layouts.components.errors')
            @include('layouts.components.messages')
            @csrf
            <h4 class="mb-3">Player information</h4>
            <div class="row" id="players">
                @for ($i = 0; $i < $cartitem->players; $i++)
                    <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="players-name[]" autocomplete="no" value=""
                            required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Age</label>
                        <input type="number" min="0" max="120" class="form-control" name="players-age[]" value=""
                            required="">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="player_level">Player Level</label>
                        <select class="form-control" name="player_level[]" id="player_level" required>
                            @foreach (config('treiner.player_levels') as $player_level)
                                <option value="{{$player_level}}">@lang($player_level)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="player_preference">Session Preference</label>
                        <select class="form-control" name="player_preference[]" id="player_preference" required>
                            @foreach (config('treiner.session_preference') as $player_preference)
                                <option value="{{$player_preference}}">@lang($player_preference)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb3">
                        <div class="form-group">
                            <label>Medical Information</label> <small class="text-muted">Failure to disclose this
                                information may result in liability being removed from the provider.</small>
                            <textarea class="form-control" name="players-medical[]" rows="3"></textarea>
                        </div>
                    </div>
                    @endfor
            </div>

            <h4 class="mb-3">Billing address</h4>
            <input type="hidden" name="payment-method" id="payment-method" value="card">
            @include('layouts.components.billing')
            <h4 class="mb-3">Payment</h4>
            <hr class="mb-4">
            <nav class="nav nav-tabs nav-stacked">
                <a class="nav-link active" data-toggle="tab" onclick="$('#payment-method').val('card')" href="#card">Credit or debit card</a>
                @if($cartitem->session->supports_cash_payments)
                <a class="nav-link" data-toggle="tab" onclick="$('#payment-method').val('cash')" href="#cash">Cash</a>
                @endif
            </nav>
            <div class="tab-content">
                <div class="tab-pane active" id="card">
                    <div class="form-group">
                        <div class="text-right" style="margin-bottom:10px;">
                            <img src="{{asset('img/powered_by_stripe.svg')}}" alt="Powered by Stripe">
                        </div>

                        <div class="form-control">
                            <div id="card-element">

                            </div>
                        </div>

                        <small id="card-errors" role="alert" class="form-text text-muted" style="padding-bottom:40px;"></small>
                        <button type="submit" class="btn btn-primary btn-block">Submit Booking</button>
                    </div>
                </div>
                @if($cartitem->session->supports_cash_payments)
                <div class="tab-pane" id="cash">
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-sm-10">
                                <h3><i class="fas fa-question-circle fa-lg"></i> Cash Payments</h3>
                                <hr>
                                <p>Please note that when paying sessions by cash Treiner is unable to offer refunds directly and they must be negotiated with the coach.</p>
                            </div>
                        </div>
                      </div>
                    <p>For cash payments you will simply have to pay the coach on the day of your session.</p>
                    <button type="submit" class="btn btn-primary btn-block">Submit Booking</button>
                </div>
                @endif
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('coaches.' . $cartitem->session->type)</h4>
            </div>
            <form action="{{route('cart.coupon.add', $cartitem)}}" method="post" style="padding-top:1em;">
                @csrf
                <div class="form-group row">
                    <label for="coupon" class="col-md-4 col-form-label text-md-right">
                    {{ __('Coupon code ') }}</label>

                    <div class="col-md-7">
                        <input id="coupon" type="text" class="form-control" required name="code">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-11 text-right">
                        <button type="submit" class="btn btn-primary">Add coupon code</button>
                    </div>
                </div>
            </form>

            @if($cartitem->couponPlayer)
            <ul class="list-group list-group-flush">
                <div class="text-muted">
                    @php
                        $coupon = $cartitem->couponPlayer->coupon;
                    @endphp
                <li class="list-group-item"><i class="fa fa-code" aria-hidden="true"></i>{{$coupon->code . ' - ' . $coupon->description()}}</li>
                </div>
            </ul>
            @endif

            <ul class="list-group list-group-flush">
                <div class="text-muted">
                <li class="list-group-item"><i class="fas fa-user"></i> {{$cartitem->session->coach->user->name}}</li>
                <li class="list-group-item"><i class="fas fa-map-marker-alt"></i> {{$cartitem->session->location->address}}</li>
                <li class="list-group-item" title="{{$cartitem->session->starts}}"><i class="fas fa-clock"></i> {{$cartitem->session->starts->format('l jS F, g:i a')}}</li>
                <li class="list-group-item"><i class="fas fa-hourglass-end"></i> {{$cartitem->session->length}} minutes</li>
            </div>
            <li class="list-group-item d-flex justify-content-between">
                <span>Total ({{$cartitem->currency}}):</span>
                @if ($cartitem->couponPlayer)
                <strong><del>{{money($cartitem->calculatePrice(), $cartitem->currency)}}</del>{{money($cartitem->calculatePriceMinusDiscount(), $cartitem->currency)}}</strong>
                @else
                <strong>{{money($cartitem->calculatePrice(), $cartitem->currency)}}</strong>
                @endif
            </li>
            </ul>
        </div>
    </div>
</div>
@endsection
