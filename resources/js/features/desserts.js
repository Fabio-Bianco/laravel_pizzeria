// Layout Toggle per Vista Desserts (Card/List)
document.addEventListener('DOMContentLoaded', () => {
  const cardViewToggle = document.getElementById('dessertsCardView');
  const listViewToggle = document.getElementById('dessertsListView');
  const cardContainer = document.getElementById('desserts-card-view');
  const listContainer = document.getElementById('desserts-list-view');

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
    localStorage.setItem('dessertsViewMode', viewMode);
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
  const savedViewMode = localStorage.getItem('dessertsViewMode') || 'list';
  if (savedViewMode === 'card') {
    cardViewToggle.checked = true;
    switchView('card');
  } else {
    listViewToggle.checked = true;
    switchView('list');
  }
});