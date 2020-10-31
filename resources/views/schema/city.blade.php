@php
   $index = 1; 
@endphp
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "ItemList",
        "itemListElement": [
            @foreach($coaches as $coach)
            {
                "@type": "ListItem",
                "url": "{{route('coaches.show', $coach)}}",
                "position": "{{$index}}"
                @php
                    $index++;
                @endphp
            }@if(!$loop->last),
            @endif
            @endforeach
        ]
    }
</script>