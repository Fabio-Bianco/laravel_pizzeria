<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
  <div class="container">
  <a class="navbar-brand fw-semibold me-2" href="{{ route('dashboard') }}" aria-label="Home Pannello di controllo">Pizzeria</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="mainNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
        @auth
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Profilo personale</a></li>
        @endauth

        @auth
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Pannello di controllo</a></li>
        @endauth

        @guest
          <li class="nav-item"><a class="btn btn-outline-primary ms-lg-2" href="{{ route('login') }}" aria-current="{{ request()->routeIs('login') ? 'page' : false }}">Login</a></li>
        @endguest

        @auth
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-outline-danger ms-lg-2">Logout</button>
            </form>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
