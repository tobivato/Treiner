$(document).ready(function e() {


    if (document.querySelector('#location')) {
        (function () {
          var locationContainer = document.querySelector('#location');
          var placesLat = document.querySelector('#lat');
          var placesLng = document.querySelector('#lng');

          function checkValidity() {
            if (placesLat.value != '' || placesLng.value != '') {
              locationContainer.setCustomValidity('');
            } else {
              locationContainer.setCustomValidity('You must choose a location from the list');
            }
          }

          var placesAutocomplete = places({
            appId: 'plX2RRT8OCW8',
            apiKey: 'c72d462e77bb408272bc43c7a68f9356',
            container: locationContainer
          }).configure({
            postcodeSearch: true,
            type: 'city',
            countries: ['au', 'nz', 'my', 'sg', 'us', 'ca', 'hk']
          });
          checkValidity();
          placesAutocomplete.on('change', function resultSelected(e) {
            placesLat.value = e.suggestion.latlng.lat || '';
            placesLng.value = e.suggestion.latlng.lng || '';
            checkValidity();
          });
        })();
      }

      if (document.querySelector('#coach-location')) {
        (function () {
          var locationContainer = document.querySelector('#coach-location');
          var placesLat = document.querySelector('#lat');
          var placesLng = document.querySelector('#lng');
          var placesCountry = document.querySelector('#country');
          var placesLocality = document.querySelector('#locality');

          function checkValidity() {
            if (placesLat.value != '' && placesCountry.value != '' && placesLocality.value != '' && placesLng.value != '') {
              locationContainer.setCustomValidity('');
            } else {
              locationContainer.setCustomValidity('You must choose a location from the list');
            }
          }

          var placesAutocomplete = places({
            appId: 'plX2RRT8OCW8',
            apiKey: 'c72d462e77bb408272bc43c7a68f9356',
            container: locationContainer,
            templates: {
              value: function value(suggestion) {
                return suggestion.name;
              }
            }
          }).configure({
            countries: ['au', 'nz', 'my', 'sg', 'us', 'ca', 'hk']
          });
          checkValidity();
          placesAutocomplete.on('change', function resultSelected(e) {
            placesLat.value = e.suggestion.latlng.lat || '';
            placesLng.value = e.suggestion.latlng.lng || '';
            placesCountry.value = e.suggestion.country || '';
            placesLocality.value = e.suggestion.name || '';
            checkValidity();
          });
        })();
      }

      if (document.querySelector('#coach-location-modal')) {
        (function () {
            var placesAutocomplete = places({
                appId: 'plX2RRT8OCW8',
                apiKey: 'c72d462e77bb408272bc43c7a68f9356',
                container: document.querySelector('#coach-location-modal'),
                templates: {
                  value: function value(suggestion) {
                    return suggestion.name;
                  }
                }
              }).configure({
                countries: ['au']
              });
        })();
      }

      if (document.querySelector('#coach-location-search')) {
        (function () {
            var placesAutocomplete = places({
                appId: 'plX2RRT8OCW8',
                apiKey: 'c72d462e77bb408272bc43c7a68f9356',
                container: document.querySelector('#coach-location-search'),
                templates: {
                  value: function value(suggestion) {
                    return suggestion.name;
                  }
                }
              }).configure({
                countries: ['au']
              });
        })();
      }

});
