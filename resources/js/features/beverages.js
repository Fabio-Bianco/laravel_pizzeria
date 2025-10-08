// Layout Toggle per Vista Bevande (Card/List)
document.addEventListener('DOMContentLoaded', () => {
  const cardViewToggle = document.getElementById('beveragesCardView');
  const listViewToggle = document.getElementById('beveragesListView');
  const cardContainer = document.getElementById('beverages-card-view');
  const listContainer = document.getElementById('beverages-list-view');

  if (!cardViewToggle || !listViewToggle || !cardContainer || !listContainer) return;

  // Gestione cambio visualizzazione
  function switchView(viewMode) {
    if (viewMode === 'card') {
      cardContainer.style.display = 'block';
      listContainer.style.display = 'none';
      cardContainer.setAttribute('aria-hidden', 'false');
      listContainer.setAttribute('aria-hidden', 'true');
    } else if (viewMode === 'list') {
      cardContainer.style.display = 'none';
      listContainer.style.display = 'block';
      cardContainer.setAttribute('aria-hidden', 'true');
      listContainer.setAttribute('aria-hidden', 'false');
    }
    
    // Salva preferenza nel localStorage
    localStorage.setItem('beveragesViewMode', viewMode);
  }

  // Event listeners per i toggle
  cardViewToggle.addEventListener('change', (e) => {
    if (e.target.checked) {
      switchView('card');
    }
  });

  listViewToggle.addEventListener('change', (e) => {
    if (e.target.checked) {
      switchView('list');
    }
  });

  // Ripristina preferenza salvata (default ora è "list")
  const savedViewMode = localStorage.getItem('beveragesViewMode') || 'list';
  if (savedViewMode === 'card') {
    cardViewToggle.checked = true;
    switchView('card');
  } else {
    listViewToggle.checked = true;
    switchView('list');
  }
});