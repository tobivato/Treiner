<div class="sub-navbar py-3">
    @include('layouts.components.errors')
    <div class="container">
        <form action="{{route('jobs.search')}}">
            <div class="row">
                <div class="col-md-5">
                    <div class="algolia-search-bar d-flex align-items-center">
                        <div class="form-inline mr-3">
                            <select class="form-control" required name="distance">
                                @foreach (['5', '10', '20', '30', '40', '50', '100', '150', '200'] as $rad)
                                    @if(isset($distance))
                                        @if ($distance == $rad)               
                                            <option selected="selected" value="{{$rad}}">{{$rad}} km</option>
                                        @else
                                            <option value="{{$rad}}">{{$rad}} km</option>
                                        @endif
                                    @else
                                        <option value="{{$rad}}">{{$rad}} km</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <input type="text" class="form-control" required name="location" autocorrect="off" maxlength=100 placeholder="Location" id="location" autocomplete="off" required 
                            @isset($location)
                                value="{{$location}}"
                            @endisset>
                        <input type="hidden" id="lat" name="lat"
                            @isset($lat)
                                value="{{$lat}}"
                            @endisset>
                        <input type="hidden" id="lng" name="lng"
                            @isset($lng)
                                value="{{$lng}}"
                            @endisset>
                    </div>
                </div>
                <div class="col-md-7 pl-md-0 mt-3 mt-md-0">
                    <div class="row">
                        <div class="col-sm-3">
                            <select class="form-control" name="price" id="price">
                                @foreach (['any' => 'Any Price', 
                                            '0-20' => '< $20',
                                            '20-30' => '$20 - $30',
                                            '30-40' => '$30 - $40',
                                            '40-50' => '$40 - $50',
                                            '50-60' => '$50 - $60',
                                            '60-70' => '$60 - $70',
                                            '70-5000' => '> $70'] as $key => $value)
                                    @if (isset($price) && $key == $price)
                                        <option selected value="{{$key}}">{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>  
                        </div>
                        <div class="col-sm-8 pl-sm-0 mt-3 mt-sm-0">
                            <div class="search-box position-relative">
                                <select name="search" id="search" class="form-control tr-search-input" placeholder="Search coaches">
                                    <option value="">All session types</option>
                                    @foreach (config('treiner.sessions') as $session)
                                    @if (old('search') == $session || (isset($query) && $query == $session))
                                        <option selected value="{{$session}}">@lang('coaches.'.$session)</option>
                                    @else
                                        <option value="{{$session}}">@lang('coaches.'.$session)</option>
                                    @endif    
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-1 pl-sm-0 mt-3 mt-sm-0">
                            <button class="bg-transparent border-0 search-icon">
                                <i class="fas fa-search fa-lg text-primary"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>