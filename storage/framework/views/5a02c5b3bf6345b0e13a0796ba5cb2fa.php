
<div class="sidebar-wrapper">
  <!-- Mobile overlay -->
  <div class="mobile-overlay" onclick="closeSidebar()"></div>
  
  <div class="sidebar bg-white shadow-sm border-end">
    
    <div class="sidebar-header p-3 border-bottom">
      <div class="d-flex align-items-center">
        <div class="user-avatar me-3">
          <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 1.2rem;">
            <?php echo e(strtoupper(substr(auth()->user()->name ?? 'U', 0, 1))); ?>

          </div>
        </div>
        <div class="flex-grow-1">
          <div class="fw-semibold text-dark"><?php echo e(auth()->user()->name ?? 'Utente'); ?></div>
          <div class="small text-muted"><?php echo e(auth()->user()->email ?? 'admin@pizzeria.com'); ?></div>
        </div>
        <div class="dropdown">
          <button class="btn btn-sm btn-outline-secondary dropdown-toggle border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('profile.edit')); ?>">
                <i class="fas fa-user-edit me-2 text-muted"></i>
                Profilo
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="<?php echo e(route('logout')); ?>" class="m-0">
                <?php echo csrf_field(); ?>
                <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                  <i class="fas fa-sign-out-alt me-2"></i>
                  Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>

    
    <nav class="sidebar-nav p-2">
      
      <div class="nav-section mb-2">
        <a href="<?php echo e(route('dashboard')); ?>" 
           class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>"
           style="background: linear-gradient(135deg, #9ceeafff 0%, #75ff93ff 100%); color: white; border-radius: 8px; margin: 0 8px;">
          <span class="nav-icon"><i class="fas fa-home"></i></span>
          <span class="nav-text fw-semibold">GESTISCI IL MENU</span>
          <i class="fas fa-home ms-auto"></i>
        </a>
      </div>

      
      <div class="nav-section">
        <div class="nav-section-header" data-bs-target="#menuSection" aria-expanded="<?php echo e(request()->routeIs('admin.pizzas.*', 'admin.appetizers.*', 'admin.beverages.*', 'admin.desserts.*') ? 'true' : 'false'); ?>">
          <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase d-flex justify-content-between align-items-center">
            <span>🍽️ Il Tuo Menu</span>
            <i class="fas fa-chevron-down transition-icon"></i>
          </div>
        </div>
        
        <div id="menuSection" class="collapse nav-section-content <?php echo e(request()->routeIs('admin.pizzas.*', 'admin.appetizers.*', 'admin.beverages.*', 'admin.desserts.*') ? 'show' : ''); ?>">
          <a href="<?php echo e(route('admin.pizzas.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.pizzas.*') ? 'active' : ''); ?>"
             title="🍕 <?php echo e($countPizzas ?? 0); ?> pizze nel menu">
            <span class="nav-icon">🍕</span>
            <span class="nav-text">Pizze</span>
            <?php if(isset($countPizzas)): ?>
              <span class="nav-badge nav-badge-primary"><?php echo e($countPizzas); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.appetizers.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.appetizers.*') ? 'active' : ''); ?>"
             title="🥗 <?php echo e($countAppetizers ?? 0); ?> antipasti disponibili">
            <span class="nav-icon">🥗</span>
            <span class="nav-text">Antipasti</span>
            <?php if(isset($countAppetizers)): ?>
              <span class="nav-badge nav-badge-success"><?php echo e($countAppetizers); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.beverages.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.beverages.*') ? 'active' : ''); ?>"
             title="🥤 <?php echo e($countBeverages ?? 0); ?> bevande in carta">
            <span class="nav-icon">🥤</span>
            <span class="nav-text">Bevande</span>
            <?php if(isset($countBeverages)): ?>
              <span class="nav-badge nav-badge-info"><?php echo e($countBeverages); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.desserts.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.desserts.*') ? 'active' : ''); ?>"
             title="🍰 <?php echo e($countDesserts ?? 0); ?> dessert disponibili">
            <span class="nav-icon">🍰</span>
            <span class="nav-text">Dessert</span>
            <?php if(isset($countDesserts)): ?>
              <span class="nav-badge nav-badge-secondary"><?php echo e($countDesserts); ?></span>
            <?php endif; ?>
          </a>
        </div>
      </div>

      
      <div class="nav-section">
        <div class="nav-section-header" data-bs-target="#configSection" aria-expanded="<?php echo e(request()->routeIs('admin.ingredients.*', 'admin.allergens.*', 'admin.categories.*') ? 'true' : 'false'); ?>">
          <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase d-flex justify-content-between align-items-center">
            <span>🔧 Impostazioni Base</span>
            <i class="fas fa-chevron-down transition-icon"></i>
          </div>
        </div>
        
        <div id="configSection" class="collapse nav-section-content <?php echo e(request()->routeIs('admin.ingredients.*', 'admin.allergens.*', 'admin.categories.*') ? 'show' : ''); ?>">
          <a href="<?php echo e(route('admin.ingredients.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.ingredients.*') ? 'active' : ''); ?>"
             title="🥬 <?php echo e($countIngredients ?? 0); ?> ingredienti catalogati">
            <span class="nav-icon">🥬</span>
            <span class="nav-text">Ingredienti</span>
            <?php if(isset($countIngredients)): ?>
              <span class="nav-badge nav-badge-warning"><?php echo e($countIngredients); ?></span>
            <?php endif; ?>
          </a>

          <a href="<?php echo e(route('admin.allergens.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.allergens.*') ? 'active' : ''); ?>"
             title="⚠️ <?php echo e($countAllergens ?? 0); ?> allergeni configurati - Sistema attivo">
            <span class="nav-icon">⚠️</span>
            <span class="nav-text">Allergeni</span>
            <div class="nav-stats">
              <?php if(isset($countAllergens)): ?>
                <span class="nav-badge nav-badge-danger"><?php echo e($countAllergens); ?></span>
              <?php endif; ?>
              <div class="nav-status nav-status-active"></div>
            </div>
          </a>

          <a href="<?php echo e(route('admin.categories.index')); ?>" 
             class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>"
             title="📂 <?php echo e($countCategories ?? 0); ?> categorie per organizzare il menu">
            <span class="nav-icon">📂</span>
            <span class="nav-text">Categorie</span>
            <?php if(isset($countCategories)): ?>
              <span class="nav-badge nav-badge-secondary"><?php echo e($countCategories); ?></span>
            <?php endif; ?>
          </a>
        </div>
      </div>

      
      <div class="nav-section">
        <div class="nav-section-header" data-bs-target="#actionsSection" aria-expanded="false">
          <div class="nav-section-title px-3 py-2 small text-muted fw-semibold text-uppercase d-flex justify-content-between align-items-center">
            <span>⚡ Azioni Rapide</span>
            <i class="fas fa-chevron-down transition-icon"></i>
          </div>
        </div>
        
        <div id="actionsSection" class="collapse nav-section-content">
          <a href="<?php echo e(route('admin.pizzas.create')); ?>" class="nav-link nav-link-action">
            <span class="nav-icon">➕</span>
            <span class="nav-text">Nuova Pizza</span>
          </a>

          <a href="<?php echo e(route('admin.appetizers.create')); ?>" class="nav-link nav-link-action">
            <span class="nav-icon">➕</span>
            <span class="nav-text">Nuovo Antipasto</span>
          </a>

          <a href="<?php echo e(route('admin.beverages.create')); ?>" class="nav-link nav-link-action">
            <span class="nav-icon">➕</span>
            <span class="nav-text">Nuova Bevanda</span>
          </a>

          <a href="<?php echo e(route('admin.desserts.create')); ?>" class="nav-link nav-link-action">
            <span class="nav-icon">➕</span>
            <span class="nav-text">Nuovo Dessert</span>
          </a>
        </div>
      </div>
    </nav>
  </div>
</div>


<style>
.sidebar-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 280px;
  z-index: 1000;
}

.mobile-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 999;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.sidebar {
  height: 100%;
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  position: relative;
  z-index: 1001;
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
  background-color: #28a745;
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
  font-weight: 500;
}

/* Badge colors */
.nav-badge-primary { background-color: #28a745; color: white; }
.nav-badge-success { background-color: #10B981; color: white; }
.nav-badge-info { background-color: #3B82F6; color: white; }
.nav-badge-warning { background-color: #F59E0B; color: white; }
.nav-badge-danger { background-color: #EF4444; color: white; }
.nav-badge-secondary { background-color: #8B5CF6; color: white; }

.nav-link.active .nav-badge {
  background-color: rgba(255, 255, 255, 0.2);
  color: white;
}

/* Advanced nav stats */
.nav-stats {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 0.125rem;
}

.nav-latest {
  font-size: 0.6875rem;
  color: #9CA3AF;
  font-weight: 400;
  max-width: 80px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.nav-link.active .nav-latest {
  color: rgba(255, 255, 255, 0.7);
}

.nav-detail {
  font-size: 0.6875rem;
  color: #9CA3AF;
  font-weight: 400;
}

.nav-link.active .nav-detail {
  color: rgba(255, 255, 255, 0.7);
}

/* Status indicators */
.nav-status {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background-color: #9CA3AF;
}

.nav-status-active {
  background-color: #10B981;
  box-shadow: 0 0 6px rgba(16, 185, 129, 0.5);
}

/* Info-only nav links */
.nav-link-info {
  cursor: default;
  background-color: #F9FAFB;
  border: 1px solid #E5E7EB;
  margin: 0.25rem 0;
}

.nav-link-info:hover {
  background-color: #F3F4F6;
}

/* Transition effects */
.nav-link {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.nav-badge, .nav-status {
  transition: all 0.2s ease;
}

.nav-link:hover .nav-badge {
  transform: scale(1.05);
}

.nav-link:hover .nav-status-active {
  box-shadow: 0 0 10px rgba(16, 185, 129, 0.7);
}

.tiny {
  font-size: 0.6875rem;
}

/* Improved mobile responsiveness */
@media (max-width: 768px) {
  .sidebar-wrapper {
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  }
  
  .sidebar-wrapper.show {
    transform: translateX(0);
  }
  
  .sidebar-wrapper.show .mobile-overlay {
    display: block;
    opacity: 1;
  }
  
  .mobile-overlay {
    display: block;
  }
}

/* Smooth scrolling for sidebar nav */
.sidebar-nav {
  scrollbar-width: thin;
  scrollbar-color: #D1D5DB #F9FAFB;
}

.sidebar-nav::-webkit-scrollbar {
  width: 6px;
}

.sidebar-nav::-webkit-scrollbar-track {
  background: #F9FAFB;
}

.sidebar-nav::-webkit-scrollbar-thumb {
  background-color: #D1D5DB;
  border-radius: 3px;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
  background-color: #9CA3AF;
}

/* Navigation section styling */
.nav-section-header {
  cursor: pointer;
  transition: background-color 0.2s ease;
  border-radius: 0.5rem;
  margin: 0.125rem 0;
}

.nav-section-header:hover {
  background-color: #F3F4F6;
}

.transition-icon {
  transition: transform 0.3s ease;
  font-size: 0.75rem;
}

.nav-section-header[aria-expanded="true"] .transition-icon {
  transform: rotate(180deg);
}

/* Collapse animations personalizzate */
.collapse {
  overflow: hidden;
  transition: all 0.3s ease;
}

.collapse:not(.show) {
  max-height: 0;
  opacity: 0;
  padding: 0;
}

.collapse.show {
  max-height: 500px;
  opacity: 1;
  padding: 0.5rem 0;
}

.nav-section-content {
  border-left: 2px solid #E5E7EB;
  margin-left: 1rem;
}

.nav-section-content .nav-link {
  padding-left: 1.5rem;
  font-size: 0.9rem;
</style><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>