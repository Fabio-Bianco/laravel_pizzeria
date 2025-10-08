/**
 * Gestione toggle vista bevande con accessibilità WCAG 2.1 AAA
 */
document.addEventListener('DOMContentLoaded', () => {
  const cardViewToggle = document.getElementById('beveragesCardView');
  const listViewToggle = document.getElementById('beveragesListView');
  const cardContainer = document.getElementById('beverages-card-view');
  const listContainer = document.getElementById('beverages-list-view');
  const announcer = document.getElementById('view-change-announce');

  if (!cardViewToggle || !listViewToggle || !cardContainer || !listContainer) {
    console.log('⚠️ Elementi toggle bevande non trovati');
    return;
  }

  function switchView(viewMode, shouldAnnounce = true) {
    const isListView = viewMode === 'list';
    
    listViewToggle.checked = isListView;
    cardViewToggle.checked = !isListView;
    
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
    
    if (shouldAnnounce && announcer) {
      const viewName = isListView ? 'elenco dettagliato' : 'griglia con card';
      announcer.textContent = `Vista bevande cambiata in: ${viewName}`;
      setTimeout(() => announcer.textContent = '', 3000);
    }
    
    localStorage.setItem('beveragesViewMode', viewMode);
    console.log(`🥤 Vista bevande cambiata in: ${viewMode}`);
  }

  cardViewToggle.addEventListener('change', (e) => {
    if (e.target.checked) switchView('card', true);
  });

  listViewToggle.addEventListener('change', (e) => {
    if (e.target.checked) switchView('list', true);
  });

  const savedViewMode = localStorage.getItem('beveragesViewMode') || 'list';
  switchView(savedViewMode, false);
});