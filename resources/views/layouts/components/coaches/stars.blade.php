@php $stars = round($coach->averageReview / 20); @endphp
        
@for ($i=0; $i < $stars; $i++)
    <i class="fas fa-star"></i>
@endfor
@for ($i=0; $i < 5 - $stars; $i++)
    <i class="far fa-star"></i>
@endfor