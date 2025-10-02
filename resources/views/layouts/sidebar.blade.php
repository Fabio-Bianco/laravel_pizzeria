{{-- Sidebar moderna per backoffice --}}
<div class="sidebar-wrapper">
  <div class="sidebar bg-white shadow-sm border-end">
    {{-- Logo e brand --}}
    <div class="sidebar-header p-3 border-bottom">
      <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
        <div class="brand-icon me-2">
          <svg viewBox="0 0 40 40" width="32" height="32">
            <circle cx="20" cy="20" r="18" fill="#FF6B35" />
            <path d="M20 2 A18 18 0 0 1 38 20 L20 20 Z" fill="#FFE66D"/>
            <circle cx="15" cy="15" r="2" fill="#C44536"/>
            <circle cx="25" cy="14" r="2" fill="#C44536"/>
            <circle cx="22" cy="22" r="2" fill="#C44536"/>
          </svg>
        </div>
        <div class="brand-text">
          <div class="fw-bold text-dark">Pizzeria</div>
          <div class="small text-muted">Admin Panel</div>
        </div>
      </a>
    </div>

    {{-- Navigation principale --}}
    <nav class="sidebar-nav p-2">
      {{-- Sezione Menu --}}
      <div class="nav-section">
        <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase">
          📋 Gestione Menu
        </div>
        
        <a href="{{ route('admin.pizzas.index') }}" 
           class="nav-link {{ request()->routeIs('admin.pizzas.*') ? 'active' : '' }}">
          <span class="nav-icon">🍕</span>
          <span class="nav-text">Pizze</span>
          @if(isset($countPizzas))
            <span class="nav-badge">{{ $countPizzas }}</span>
          @endif
        </a>

        <a href="{{ route('admin.appetizers.index') }}" 
           class="nav-link {{ request()->routeIs('admin.appetizers.*') ? 'active' : '' }}">
          <span class="nav-icon">🥗</span>
          <span class="nav-text">Antipasti</span>
          @if(isset($countAppetizers))
            <span class="nav-badge">{{ $countAppetizers }}</span>
          @endif
        </a>

        <a href="{{ route('admin.beverages.index') }}" 
           class="nav-link {{ request()->routeIs('admin.beverages.*') ? 'active' : '' }}">
          <span class="nav-icon">🥤</span>
          <span class="nav-text">Bevande</span>
          @if(isset($countBeverages))
            <span class="nav-badge">{{ $countBeverages }}</span>
          @endif
        </a>
      </div>

      {{-- Sezione Configurazione --}}
      <div class="nav-section">
        <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase">
          ⚙️ Configurazione
        </div>
        
        <a href="{{ route('admin.ingredients.index') }}" 
           class="nav-link {{ request()->routeIs('admin.ingredients.*') ? 'active' : '' }}">
          <span class="nav-icon">🥬</span>
          <span class="nav-text">Ingredienti</span>
          @if(isset($countIngredients))
            <span class="nav-badge">{{ $countIngredients }}</span>
          @endif
        </a>

        <a href="{{ route('admin.allergens.index') }}" 
           class="nav-link {{ request()->routeIs('admin.allergens.*') ? 'active' : '' }}">
          <span class="nav-icon">⚠️</span>
          <span class="nav-text">Allergeni</span>
          @if(isset($countAllergens))
            <span class="nav-badge">{{ $countAllergens }}</span>
          @endif
        </a>

        <a href="{{ route('admin.categories.index') }}" 
           class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
          <span class="nav-icon">📂</span>
          <span class="nav-text">Categorie</span>
          @if(isset($countCategories))
            <span class="nav-badge">{{ $countCategories }}</span>
          @endif
        </a>
      </div>

      {{-- Quick Actions --}}
      <div class="nav-section">
        <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase">
          ⚡ Azioni Rapide
        </div>
        
        <a href="{{ route('admin.pizzas.create') }}" class="nav-link nav-link-action">
          <span class="nav-icon">➕</span>
          <span class="nav-text">Nuova Pizza</span>
        </a>

        <a href="{{ route('admin.appetizers.create') }}" class="nav-link nav-link-action">
          <span class="nav-icon">➕</span>
          <span class="nav-text">Nuovo Antipasto</span>
        </a>
      </div>
    </nav>

    {{-- User info e logout --}}
    <div class="sidebar-footer p-3 border-top mt-auto">
      <div class="d-flex align-items-center">
        <div class="user-avatar me-2">
          <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
          </div>
        </div>
        <div class="flex-grow-1">
          <div class="small fw-semibold">{{ auth()->user()->name ?? 'Utente' }}</div>
          <div class="tiny text-muted">{{ auth()->user()->email ?? '' }}</div>
        </div>
        <div class="dropdown">
          <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="fas fa-cog"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profilo</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item text-danger">Logout</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- CSS per sidebar --}}
<style>
.sidebar-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 280px;
  z-index: 1000;
}

.sidebar {
  height: 100%;
  display: flex;
  flex-direction: column;
  overflow-y: auto;
}

.sidebar-nav {
  flex: 1;
}

.nav-section {
  margin-bottom: 1rem;
}

.nav-section:last-child {
  margin-bottom: 0;
}

.nav-link {
  display: flex;
  align-items: center;
  padding: 0.75rem 1rem;
  margin: 0.125rem 0;
  border-radius: 0.5rem;
  text-decoration: none;
  color: #6B7280;
  transition: all 0.2s ease;
  position: relative;
}

.nav-link:hover {
  background-color: #F3F4F6;
  color: #374151;
  text-decoration: none;
}

.nav-link.active {
  background-color: #FF6B35;
  color: white;
  font-weight: 500;
}

.nav-link-action {
  background-color: #F0FDF4;
  color: #059669;
  border: 1px solid #D1FAE5;
}

.nav-link-action:hover {
  background-color: #DCFCE7;
  color: #047857;
}

.nav-icon {
  font-size: 1.1rem;
  margin-right: 0.75rem;
  min-width: 20px;
}

.nav-text {
  flex: 1;
}

.nav-badge {
  background-color: #E5E7EB;
  color: #6B7280;
  font-size: 0.75rem;
  padding: 0.125rem 0.5rem;
  border-radius: 1rem;
  min-width: 1.5rem;
  text-align: center;
}

.nav-link.active .nav-badge {
  background-color: rgba(255, 255, 255, 0.2);
  color: white;
}

.tiny {
  font-size: 0.6875rem;
}

@media (max-width: 768px) {
  .sidebar-wrapper {
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  }
  
  .sidebar-wrapper.show {
    transform: translateX(0);
  }
}
</style>