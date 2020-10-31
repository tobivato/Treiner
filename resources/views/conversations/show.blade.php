@extends('layouts.app')
@section('title', 'Messages')
@section('content')
	<div class="container">
		<div class="row no-gutters">
			<div class="col-md-4">
				@include('conversations.sidebar')
			</div>
			<div class="col-md-8">
				<div class="mt-sm-4 mt-md-0 pl-2 pr-4">
					<div class="card">
						<div class="card card-body shadow-sm px-4 py-3">
							<div class="row">
								<div class="col-xl-8">
									<div class="media">
										<div class="media-left mr-3">
											<img src="{{Cloudder::secureShow($conversation->fromPerspective()->image_id)}}" width="62" class="circle-bordered-img rounded-circle" alt="{{$conversation->fromPerspective()->name}}">
										</div>
										<div class="media-body">
											<div class="row align-items-center">
												<div class="col-lg-8">
													<h2 class="futura-bold mb-1">{{$conversation->fromPerspective()->name}}</h2>
													<p class="text-primary mb-0">{{$conversation->subject}}</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-4 mt-3">
									<div class="form-group mb-0 search-box position-relative">
										<input type="text" id="search-conversation" class="form-control" placeholder="Search in conversation">
										<button class="bg-transparent border-0 search-icon">
											<i class="fas fa-search fa-lg "></i>
										</button>
									</div>
								</div>
							</div>
						</div>
						<div id="messages-scrollbox" class="card-body chat-box d-flex align-items-end">
							<div class="chat-panel flex-grow-1">
								<ul id="messages-list">
								</ul>
							</div>
						</div>
						<div class="chat-message-box p-3 position-relative border-top mt-3">
							<form id="messages-form" action="{{route('messages.send', $conversation->id)}}" method="post">
								<input type="hidden" id="to-user" name="to-user" value="{{$conversation->fromPerspective()->id}}">
								<textarea id="message-input" class="form-control" rows="3"></textarea>
								<button class="message-send-button border-0 bg-transparent">
									<i class="fa fa-arrow-circle-right text-primary fa-4x"></i>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script>
	let messagesList = document.querySelector('#messages-list');
	let base = '';	

	window.addEventListener('load', function() {	
		base = window.baseUrl + 'home/messages/' + {{$conversation->id}} + '/';
		fetch(base + 'all', { headers: { "Content-Type": "application/json; charset=utf-8" }})
			.then(res => res.json())
			.then(response => {
				template = jsonToMessages(response);
				messagesList.innerHTML = template;
				scrollToBottom();
			})
		.catch(err => {
			console.error(err);
		});
	});

    function jsonToMessages(response) {
        let template = ``;
            response.data.forEach(message => {  
                if (message.is_from_current_user) {
                    template += 
                            `<li id="${'message-' + message.id}" class="message-pill outgoing-message text-white">
                                ${message.content}
                            </li>`
                }
                else {
                    template += 
                        `<li class="message-pill incoming-message">
                            <div class="media">
                                <div class="media-left mr-3">
                                    <img src="${message.image}" width="62" class="circle-bordered-img rounded-circle" alt="Profile picture">
                                </div>
                                <div id="${'message-' + message.id}" class="media-body incoming-message-cloud">
                                    ${message.content}
                                </div>
                            </div>
                        </li>`
                }
            });
        return template;
    }

	function scrollToBottom()
	{
		document.getElementById('messages-scrollbox').scrollTop = 100000;
	}

	document.querySelector('#messages-form').onsubmit = function() {
		event.preventDefault();
		let content = document.querySelector('#message-input').value;
		document.querySelector('#message-input').value = null;
		fetch(base + 'send', {
			headers: { 
				"Content-Type": "application/json; charset=utf-8",
				"X-Requested-With": "XMLHttpRequest",
				"X-CSRF-TOKEN": document.head.querySelector("meta[name=csrf\-token]").content
			 },
			method: 'POST',
			body: JSON.stringify({
				content: content,
				to_id: document.querySelector('#to-user').value
			})
		})
		.then(res => res.json())
		.then(response => {
			messagesList.innerHTML += jsonToMessages(response);
			scrollToBottom();
		})
		.catch(err => {
			alert('Your message couldn\'t be sent. Please check your internet connection and try again');
        	console.error(err);
    	});
	};

	let searchBox = document.querySelector('#search-conversation');

	searchBox.oninput = function() {
		let messages = document.getElementsByClassName('message-pill');
		let input = searchBox.value.toLowerCase();
		Array.from(messages).forEach(message => {
			message.style.display = 'none';
			if (message.classList.contains('incoming-message')) {
				let lowerMessage = message.children[0].children[1].innerHTML.toLowerCase();
				if (lowerMessage.match(input) ) {
					message.style.display = 'block';
				}
			}
			if (message.classList.contains('outgoing-message')) {
				let lowerMessage = message.innerHTML.toLowerCase();

				if (lowerMessage.match(input) ) {
					message.style.display = 'block';
				}
			}
		});
	}

	const checkUnread = setInterval(function() {
	    fetch(base + 'unread', { headers: { "Content-Type": "application/json; charset=utf-8" }})
        .then(res => res.json())
        .then(response => {
            template = jsonToMessages(response);			
			if (response.data.length > 0) {
            	messagesList.innerHTML += template;
				scrollToBottom();
			}
        })
		.catch(err => {
			console.error(err);
		});
 	}, 5000);
</script>
@endsection