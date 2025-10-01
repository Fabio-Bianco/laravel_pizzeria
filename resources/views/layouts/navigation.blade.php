<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
  <div class="container">
  <a class="navbar-brand d-inline-flex align-items-center me-2" href="{{ route('dashboard') }}" aria-label="Home Pannello di controllo">
      <span class="brand-logo" aria-hidden="true">
        <!-- Logo pizza (stesso del login) -->
        <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <circle cx="32" cy="32" r="30" fill="#fcd34d" stroke="#b45309" stroke-width="2"/>
            <path d="M32 2 A30 30 0 0 1 62 32 L32 32 Z" fill="#ef4444"/>
            <circle cx="24" cy="24" r="3" fill="#991b1b"/>
            <circle cx="40" cy="22" r="3" fill="#991b1b"/>
            <circle cx="36" cy="36" r="3" fill="#991b1b"/>
        </svg>
      </span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="mainNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
        @auth
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.pizzas.*') ? 'active' : '' }}" href="{{ route('admin.pizzas.index') }}">Pizze</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.ingredients.*') ? 'active' : '' }}" href="{{ route('admin.ingredients.index') }}">Ingredienti</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.allergens.*') ? 'active' : '' }}" href="{{ route('admin.allergens.index') }}">Allergeni</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Categorie</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.beverages.*') ? 'active' : '' }}" href="{{ route('admin.beverages.index') }}">Bevande</a></li>
        @endauth

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
