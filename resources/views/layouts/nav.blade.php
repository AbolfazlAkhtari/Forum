<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                Browse
            </a>
            <ul class="dropdown-menu">
                <li class="dropdown-item">
                    <a class="nav-link" href="{{ route('threads.index') }}">All Threads</a>
                </li>
                @if(auth()->check())
                    <li class="dropdown-item"><a class="nav-link"
                                                 href="{{ route('threads.index') }}?by={{ auth()->user()->name }}">My Threads</a>
                    </li>
                @endif
                <li class="dropdown-item">
                    <a class="nav-link" href="{{ route('threads.index') }}?popular=1">Popular All Time</a>
                </li>
                <li class="dropdown-item">
                    <a class="nav-link" href="{{ route('threads.index') }}?unanswered=1">Unanswered threads</a>
                </li>
            </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('threads.create') }}">New Thread</a>
        </li>
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                Channels
            </a>
            <ul class="dropdown-menu">
                @foreach($channels as $channel)
                    <li class="dropdown-item"><a
                            href="{{ route('threads.channel', $channel) }}">{{ $channel->name }}</a></li>
                @endforeach
            </ul>
        </li>
    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('userProfile.show', Auth::user()) }}">
                        {{ __('Profile') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</div>
