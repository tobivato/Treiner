<!-- Map Modal -->
<div class="modal fade" id="map" tabindex="-1" role="dialog" aria-labelledby="map-help" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header d-block border-0">
				<h5 class="modal-title h3 futura-bold text-center">Locations</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body" style="padding:0;">
				<div style="height:100%;" id="map-goog"></div>
			</div>
		</div>
		<script>
        		  function initMap() {
			        map = new google.maps.Map(document.getElementById('map-goog'), {
                    center: {lat: {{$locations->avg('latitude')}}, lng: {{$locations->avg('longitude')}}},
                    zoom: 10,
                    minZoom: 8,
                    mapTypeControl: false,
                    streetViewControl: false,
                    scaleControl: true,
                    fullscreenControl: false,
                    rotateControl: false,
                    styles: [
                                {
                                    "featureType": "administrative",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                    {
                                        "color": "#224442"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "administrative.land_parcel",
                                    "elementType": "labels",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "landscape",
                                    "stylers": [
                                    {
                                        "color": "#d3e7d7"
                                    },
                                    {
                                        "visibility": "on"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "landscape.man_made",
                                    "stylers": [
                                    {
                                        "visibility": "on"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "poi",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "poi",
                                    "elementType": "labels.text",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "poi.business",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road",
                                    "stylers": [
                                    {
                                        "saturation": -100
                                    },
                                    {
                                        "lightness": 45
                                    },
                                    {
                                        "visibility": "on"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road",
                                    "elementType": "labels.icon",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road.arterial",
                                    "elementType": "labels",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road.arterial",
                                    "elementType": "labels.icon",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road.highway",
                                    "stylers": [
                                    {
                                        "visibility": "simplified"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road.highway",
                                    "elementType": "labels",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road.local",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road.local",
                                    "elementType": "labels",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "transit",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "water",
                                    "stylers": [
                                    {
                                        "color": "#769c7e"
                                    },
                                    {
                                        "visibility": "on"
                                    }
                                    ]
                                }
                            ]
            });

            @foreach($locations as $location)
            var marker = new google.maps.Marker({
                position: {lat: {{$location->latitude}}, lng: {{$location->longitude}}},
                map: map,
                icon: '{{asset('img/marker.svg')}}'
            });
            @endforeach

        document.addEventListener("load", function() {
		  var map;
			$('#map').on('shown', function(){
				initMap();
			});
        });
        }
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key={{config('treiner.google.maps-api-key')}}&callback=initMap"
			async defer></script>				
	</div>
</div>