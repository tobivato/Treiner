<footer class="footer">
    <div class="container pt-5">
        <div class="row justify-content-between">
            <div class="col-lg-4 mb-3">
                <a href="{{route('welcome')}}"><img width="100" src="{{asset('img/vertical_lockup.svg')}}"
                        alt="The Treiner logo in white"></a>
                <p class="pt-4">Treiner is a premier worldwide soccer coaching marketplace service providing players
                    of all skill levels the opportunity to increase their abilities, learn new skills and become better
                    players both on and off the field.</p>
            </div>

            <div class="col-lg-8">
                <div class="row justify-content-between mr-0">

                    <div class="col-4 p-0 mb-3">
                        <h5 class="mb-4 futura-medium">Information & Legal</h5>
                        <ul class="list-group">
                            <li class="list-group-item bg-transparent border-0 p-0 mb-2"><a
                                    href="{{route('about')}}">About Treiner</a></li>
                            <li class="list-group-item bg-transparent border-0 p-0 mb-2"><a
                                    href="{{route('blogs.index')}}">Blogs</a></li>
                            <li class="list-group-item bg-transparent border-0 p-0 mb-2"><a
                                    href="{{route('privacy')}}"></i>Privacy Policy</a></li>
                            <li class="list-group-item bg-transparent border-0 p-0 mb-2"><a
                                    href="{{route('terms')}}"></i>Terms and Conditions</a></li>
                        </ul>
                    </div>

                    <div class="col-4 mb-3 p-0">
                        <h5 class="mb-4 futura-medium">Help & Support</h5>
                        <ul class="list-group">
                            <li class="list-group-item bg-transparent border-0 p-0 mb-2"><a href="{{route('faq')}}"></i>FAQ</a>
                            </li>
                            <li class="list-group-item bg-transparent border-0 p-0 mb-2"><a
                                    href="{{route('contact')}}"></i>Contact Treiner</a></li>
                            @auth<li class="list-group-item bg-transparent border-0 p-0 mb-2"><a
                                    href="{{route('support')}}"></i>Support</a></li>@endauth
                        </ul>
                    </div>

                    <div class="col-md-auto mb-3 p-0">
                        <h5 class="mb-4 futura-medium">Join Treiner</h5>
                        <ul class="list-group">
                            {{--<li class="list-group-item bg-transparent border-0 p-0 mb-2"><a
                                    href="{{route('coaches.welcome')}}"></i>Browse Coaches</a></li>--}}
                            <li class="list-group-item bg-transparent border-0 p-0 mb-2 post-job"><a
                                    href="#"></i>Request a coaching session</a></li>
                            @guest
                            <li class="list-group-item bg-transparent border-0 p-0 mb-2"><a
                                    href="{{route('register')}}"></i>Sign Up</a></li>
                            <li class="list-group-item bg-transparent border-0 p-0 mb-2"><a
                                    href="{{route('login')}}"></i>Login</a></li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="copyright-sec">
        <div class="container ">
            <div class="row">
                <div class="col-5 d-flex align-items-center">

                    Copyright © 2020. All Rights Reserved

                </div>
                <div class="col-7 text-right">
                    <ul class="list-inline py-3 mb-0 social-list">
                        <li class="list-inline-item bg-transparent border-0 p-0 mb-2">
                            <a title="Facebook" aria-label="Facebook"
                                href="https://www.facebook.com/treiner.co" rel="noopener"
                                target="_blank"><i class="fab fa-facebook mr-1"></i></a>
                        </li>
                        <li class="list-inline-item bg-transparent border-0 p-0 mb-2">
                            <a title="LinkedIn" aria-label="LinkedIn" href="https://www.linkedin.com/company/treiner"
                                rel="noopener" target="_blank"><i class="fab fa-linkedin mr-1"></i></a>
                        </li>
                        <li class="list-inline-item bg-transparent border-0 p-0 mb-2">
                            <a title="Twitter" aria-label="Twitter" href="https://twitter.com/treinerco"
                                rel="noopener" target="_blank"><i class="fab fa-twitter mr-1"></i></a>
                        </li>

                        <li class="list-inline-item bg-transparent border-0 p-0 mb-2">
                            <a title="Instagram" aria-label="Instagram" href="https://www.instagram.com/treiner.co"
                                rel="noopener" target="_blank"><i class="fab fa-instagram mr-1"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
