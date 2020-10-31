    <!-- Modal -->
    <div class="modal fade" id="review-modal" tabindex="-1" role="dialog" aria-labelledby="review-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add a review for your last session</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('reviews.store')}}" method="post">
                        @csrf
                        @include('layouts.components.messages')    
                        @include('layouts.components.errors')
                        <div class="form-group">
                            <label for="">Session</label>
                            <select class="form-control" name="session_player_id" required>
                                @foreach (Auth::user()->player->sessionPlayers->where('session.status', 'completed')->where('reviewed', false) as $sessionplayer)
                                <option value="{{$sessionplayer->id}}">{{$sessionplayer->session->coach->user->name}},
                                    {{$sessionplayer->session->starts->format('d/m/Y, h:ia')}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Rating</label>
                            <input type="number" class="form-control" max="100" min="0" step="1" name="rating" value="{{old('content')}}" required>
                            <small class="form-text text-muted">Rating (out of 100)</small>
                        </div>
                        <div class="form-group">
                            <label for="review">Review</label>
                            <textarea class="form-control" data-length-indicator="length-indicator" maxlength="5000" name="content" id="review" rows="3">{{old('content')}}</textarea>
                            <small class="form-text text-right mt-2 text-muted"><span id="length-indicator">5000</span> characters remaining</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>  