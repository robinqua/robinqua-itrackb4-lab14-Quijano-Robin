<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark" aria-label="Main navigation">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Quijano Library</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation"
                aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavigation">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('home') }}"
                       class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       @if (request()->routeIs('home')) aria-current="page" @endif>
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('books.index') }}"
                       class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}"
                       @if (request()->routeIs('books.*')) aria-current="page" @endif>
                        Books
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('books.featured') }}"
                       class="nav-link {{ request()->routeIs('books.featured') ? 'active' : '' }}"
                       @if (request()->routeIs('books.featured')) aria-current="page" @endif>
                        Featured Book
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <span class="navbar-text me-3">{{ Auth::user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link">Log out</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
