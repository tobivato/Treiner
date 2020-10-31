<div class="row">
    <div class="col-md-6 mb-3">
        <label for="firstName">First name</label>
        <input type="text" class="form-control" id="firstName" name="firstName" value="" autocomplete="given-name" required value="{{old('firstName')}}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="lastName">Last name</label>
        <input type="text" class="form-control" id="lastName" name="lastName" value="" autocomplete="family-name" required value="{{old('lastName')}}">
    </div>
</div>

<div class="mb-3">
    <label for="address">Address</label>
    <input type="text" class="form-control" autocomplete="street-address" name="streetAddress" id="address" autocomplete="street-address" required value="{{old('streetAddress')}}">
</div>

<div class="mb-3">
    <label for="locality">Town or suburb</label>
    <input type="text" class="form-control" id="locality" name="locality" autocomplete="address-level2" required value="{{old('locality')}}">
</div>

<div class="row">
    <div class="col-md-5 mb-3">
        <label for="country">Country</label>
        <select class="form-control custom-select d-block w-100" autocomplete="country" name="country" id="country" required onchange="setCountry()">
            @foreach (config('treiner.countries') as $key => $country)
            @if (old('country') == $key)
                <option selected value="{{$key}}">{{$country["name"]}}</option>
            @else
                <option value="{{$key}}">{{$country["name"]}}</option>
            @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label for="state">State/Province</label>
        <input type="text" class="form-control" id="state" autocomplete="address-level1" name="state" value="{{old('state')}}" required>
    </div>
    <div class="col-md-3 mb-3">
        <label for="zip">Postcode</label>
        <input type="text" class="form-control" id="postcode" autocomplete="postal-code" name="postcode" value="{{old('postcode')}}" required>
    </div>
</div>