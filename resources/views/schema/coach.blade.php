<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Person",
      "image": "{{Cloudder::secureShow($coach->user->image_id)}}",
      "name": "{{$coach->user->name}}",
      "url": "{{url()->current()}}",
      "affiliation": {
          "@type": "Organization",
          "name": "{{$coach->club}}"
      },
      "birthDate": "{{$coach->user->dob}}",
      "gender": "{{$coach->user->gender}}",
      "owns": [
          @foreach($coach->availabilities as $availability)
          {
              "@type": "Product",
              "name": "{{__('coaches.' . $availability->type)}}",
              "description": "A {{__('coaches.' . $availability->type)}} session with {{$coach->user->name}}.",
              "productionDate": "{{$availability->created_at->format('c')}}",
              @if(count($coach->reviews) > 0)"aggregateRating": {
                  "@type": "AggregateRating",
                  "ratingValue": {{$coach->averageReview}},
                  "reviewCount": {{$coach->reviews->count()}},
                  "bestRating": 100,
                  "worstRating": 0
              },@endif
              "offers": {
                "@type": "Offer",
                "url": "{{url()->current()}}",
                "availability": "InStock",
                "priceValidUntil": "{{$availability->starts->format('c')}}",
                "areaServed": {
                    "@type": "GeoCircle",
                    "geoMidpoint": {
                        "@type": "GeoCoordinates",
                        "latitude": {{$availability->location->latitude}},
                        "longitude": {{$availability->location->longitude}}
                    },
                    "geoRadius": 10000,
                    "address": "{{$availability->location->locality}}",
                    "addressCountry": "{{$availability->location->country}}"
                },
                "price": "{{$availability->feePerPerson / 100}}",
                "priceCurrency": "{{$coach->user->currency}}"
                }
          }@if(!$loop->last),@endif
          @endforeach
      ],
      "hasOccupation": {
        "@type": "Occupation",
        "name": "Football Coach",
        "estimatedSalary": {
          "@type": "MonetaryAmountDistribution",  
          "currency": "AUD",
          "name": "base",
          "duration": "P1Y",
          "percentile10": 20000,
          "percentile25": 40000,
          "median": 52520,
          "percentile75": 82000,
          "percentile90": 120000
        },
        "occupationLocation": {
          "@type": "City",
          "name": "{{$coach->location->locality}}"
        }
    }
    }
</script>