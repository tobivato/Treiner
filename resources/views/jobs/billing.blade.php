@extends('layouts.app')
@section('title', 'Finalise your job placement')
@section('content')
<div>
    <div class="row">
        <div class="col-lg-4 order-lg-2 mb-4">
            @include('layouts.components.job-cart', ['jobPost' => $jobOffer->jobPost, 'jobOffer' => $jobOffer])
        </div>
        <div class="col-lg-8 order-lg-1">
            @push('scripts')
                <script>
                    var cartInfo = {
                        currency: "{{Auth::user()->currency}}",
                        id: "{{'JO' . $jobOffer->id}}",
                        total: "{{$jobOffer->fee / 100}}",
                        name: "{{__('coaches.'.$jobOffer->jobPost->type) . ' with ' . $jobOffer->coach->user->name}}",
                        category: "{{$jobOffer->jobPost->type}}",
                        quantity: 1,
                        price: {{$jobOffer->fee / 100}}
                    };
                </script>
                <script src="https://js.stripe.com/v3/"></script>
            @endpush

            <form id="payment-form" method="POST" action="{{route('offers.complete', $jobOffer)}}">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Player's age</label>
                        <input type="number" min="0" max="120" class="form-control" name="players-age[]" value=""
                            required="">
                    </div>
                    <div class="col-md-12 mb3">
                        <div class="form-group">
                            <label>Medical Information</label> <small class="text-muted">Failure to disclose this
                                information may result in liability being removed from the provider.</small>
                            <textarea class="form-control" name="players-medical[]" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="players-name[]" value="{{Auth::user()->name}}">
                @include('layouts.components.errors')
                @csrf
                <input type="hidden" name="payment-method" id="payment-method" value="card">
                <h4 class="mb-3">Billing address</h4>
                @include('layouts.components.billing')
                <h4 class="mb-3">Payment</h4>
                <hr class="mb-4">
                <div class="form-group">
                    <label for="card-element">Credit or debit card</label>
                    <div class="text-right" style="margin-bottom:10px;">
                        <img src="{{asset('img/powered_by_stripe.svg')}}" alt="Powered by Stripe">
                    </div>

                    <div class="form-control">
                        <div id="card-element">

                        </div>
                    </div>

                    <small id="card-errors" role="alert" class="form-text text-muted"
                        style="padding-bottom:40px;"></small>
                    <button type="submit" class="btn btn-primary btn-block">Submit Booking</button>
                </div>
            </form>
        </div>
    </div>
    @endsection
