
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="#" class="logo">
                            <h4 style="color:black;font-weight: bold;margin-top: -10px;">
                                <img src="{{ url('/') }}/assets/images/bi.png" width="50" class="mr-2" alt="Softy Pinko" />
                                <span>Ko-Ko Kolom Komentar</span>
                            </h4>
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="{{ route('home') }}" {{ Route::currentRouteName() == "home"? 'class=active' : "" }}>Beranda</a></li>
                            <li><a href="{{ route('tranding') }}" {{ Route::currentRouteName() == "tranding"? 'class=active' : "" }}>Trending</a></li>
                            <li><a href="{{ route('group') }}" {{ Route::currentRouteName() == "group"? 'class=active' : "" }}>Grup</a></li>
                            @auth
                                <li><a href="{{ route('user') }}" {{ Route::currentRouteName() == "user"? 'class=active' : "" }}>Pengguna</a></li>

                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();$('#logoutForm').submit();">Logout</a></li>
                            @endauth
                            @guest
                                <li><a href="{{ route('login') }}">Login</a></li>
                            @endguest
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <form method="POST" id="logoutForm" action="{{ route('logout') }}">
        @csrf
    </form>
