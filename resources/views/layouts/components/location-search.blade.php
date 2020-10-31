<div class="form-group">
  <label for="">Location</label>
  <input id="searchBox" class="form-control" placeholder="Enter address" onFocus="geolocate()" type="text" required/>

  <small id="helpId" class="form-text text-muted">The location for this session to take place</small>
  <input type="hidden" value="{{old('latitude')}}" id="latitude" name="latitude">
  <input type="hidden" value="{{old('longitude')}}" id="longitude" name="longitude">
  <input type="hidden" value="{{old('street_address')}}" id="street_address" name="street_address">
  <input type="hidden" value="{{old('locality')}}" id="locality" name="locality">
  <input type="hidden" value="{{old('country')}}" id="country" name="country">
</div>


<script>
  var searchBox;


  var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
  };

  function initSearchBox() {
    // Create the searchBox object, restricting the search predictions to
    // geographical location types.
    searchBox = new google.maps.places.SearchBox(
      document.getElementById('searchBox'), {
        types: ['address']
      });          

    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      };

      var address = new Object();

      for (var i = 0; i < places[0].address_components.length; i++) {
        var addressType = places[0].address_components[i].types[0];
        if (componentForm[addressType]) {
          var val = places[0].address_components[i][componentForm[addressType]];
          address[addressType] = val;
        }
      }      

      let streetAddressComponents = ['street_number', 'route'];
      let streetAddress = '';
      ['street_number', 'route'].forEach((component) => {
        if (address[component]) {
          streetAddress += (' ' + address[component]);
        }
      })      

      if (!streetAddress) {
        streetAddress = places[0].name;
      }

      $('#country').val(address.country);
      $('#locality').val(address.locality);
      $('#street_address').val(streetAddress);
      $('#latitude').val(places[0].geometry.location.lat);
      $('#longitude').val(places[0].geometry.location.lng);
    });
  }

  // Bias the searchBox object to the user's geographical location,
  // as supplied by the browser's 'navigator.geolocation' object.
  function geolocate() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var geolocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        var circle = new google.maps.Circle({
          center: geolocation,
          radius: position.coords.accuracy
        });
        searchBox.setBounds(circle.getBounds());
      });
    }
  }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{config('treiner.google.maps-api-key')}}&libraries=places&callback=initSearchBox" async defer></script>