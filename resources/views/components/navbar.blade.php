<nav class="navbar navbar-expand navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'GetOrganizedAI') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

                @if(auth()->user())
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                    <input type="submit" value="Log Out">
                </form>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else


                    <div x-data="{ open: false }">
                        <a class="nav-link" @click="open = !open">
                            {{ Auth::user()->name }}
                        </a>
                        <div x-show="open" @click.away=" open = false " class="nav-dropdown shadow-sm">
                        
                        @if (Route::currentRouteName() == 'index')
                            <div class="mobile-only">
                                @include('components.side-nav')
                            </div>
                        @endif
                            <ul>
                                <li class="nav-link">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>                                
                                @if (auth()->user() && !optional(auth()->user())->hasActiveSubscription())
                                <li class="nav-link">
                                    <a href="{{ route('subscribe.show')}}">Subscribe</a>
                                </li>
                                @endif
                                <li class="nav-link">
                                <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                 {{ __('Logout') }}
                                 </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endguest
            </ul>
        </div>
    </div>

</nav>