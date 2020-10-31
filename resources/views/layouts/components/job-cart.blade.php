 <ul class="list-group mb-3">
     <li class="list-group-item d-flex justify-content-between lh-condensed">
        <p>{{$jobPost->type}} session with {{$jobOffer->coach->user->name}}</p>
        <p><span class="text-muted">At: </span>{{$jobPost->location->address}}</p>
        <p><span class="text-muted">Starts: </span>{{$jobPost->starts}}</p>
        <p><span class="text-muted">Length: </span>{{$jobPost->length}}</p>
    </li>
     <li class="list-group-item d-flex justify-content-between">
         <span>Total</span>
         <strong>{{$jobOffer->formattedFee}}</strong>
     </li>
 </ul>
