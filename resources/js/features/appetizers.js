/**
 * Gestione toggle vista antipasti con accessibilità WCAG 2.1 AAA
 */
document.addEventListener('DOMContentLoaded', () => {
  const cardViewToggle = document.getElementById('appetizersCardView');
  const listViewToggle = document.getElementById('appetizersListView');
  const cardContainer = document.getElementById('appetizers-card-view');
  const listContainer = document.getElementById('appetizers-list-view');
  const announcer = document.getElementById('view-change-announce');

  if (!cardViewToggle || !listViewToggle || !cardContainer || !listContainer) {
    console.log('⚠️ Elementi toggle antipasti non trovati');
    return;
  }

  // Gestione cambio visualizzazione con accessibilità
  function switchView(viewMode, shouldAnnounce = true) {
    const isListView = viewMode === 'list';
    
    // Aggiorna radio buttons
    listViewToggle.checked = isListView;
    cardViewToggle.checked = !isListView;
    
    // Aggiorna aria-pressed sui label
    listViewToggle.nextElementSibling.setAttribute('aria-pressed', isListView);
    cardViewToggle.nextElementSibling.setAttribute('aria-pressed', !isListView);
    
    if (isListView) {
      cardContainer.style.display = 'none';
      listContainer.style.display = 'block';
      cardContainer.setAttribute('aria-hidden', 'true');
      listContainer.setAttribute('aria-hidden', 'false');
    } else {
      cardContainer.style.display = 'block';
      listContainer.style.display = 'none';
      cardContainer.setAttribute('aria-hidden', 'false');
      listContainer.setAttribute('aria-hidden', 'true');
    }
    
    // Annuncia il cambio agli screen reader
    if (shouldAnnounce && announcer) {
      const viewName = isListView ? 'elenco dettagliato' : 'griglia con card';
      announcer.textContent = `Vista antipasti cambiata in: ${viewName}`;
      
      setTimeout(() => {
        announcer.textContent = '';
      }, 3000);
    }
    
    // Salva preferenza nel localStorage
    localStorage.setItem('appetizersViewMode', viewMode);
    console.log(`🥗 Vista antipasti cambiata in: ${viewMode}`);
  }

  // Event listeners per i toggle
  cardViewToggle.addEventListener('change', (e) => {
    if (e.target.checked) {
      switchView('card', true);
    }
  });

  listViewToggle.addEventListener('change', (e) => {
    if (e.target.checked) {
      switchView('list', true);
    }
  });

  // Ripristina preferenza salvata (default è "list")
  const savedViewMode = localStorage.getItem('appetizersViewMode') || 'list';
  switchView(savedViewMode, false); // false = non annunciare al caricamento
});