export function initPizzaIngredientQuickCreate() {
  const modal = document.getElementById('newIngredientModal');
  if (!modal) return;

  const input = modal.querySelector('#ni_name');
  const saveBtn = modal.querySelector('#ni_save');
  const select = document.getElementById('ingredients');

  const getChoices = () => select && select._choices ? select._choices : null;

  const close = () => {
    const bsModal = window.bootstrap.Modal.getInstance(modal) || new window.bootstrap.Modal(modal);
    bsModal.hide();
  };

  saveBtn.addEventListener('click', async () => {
    const name = (input.value || '').trim();
    if (!name) {
      alert('Inserisci un nome ingrediente');
      input.focus();
      return;
    }

    const url = select.getAttribute('data-store-url');
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    try {
      const res = await fetch(url, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name, allergens: [] }),
      });

      if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.message || 'Errore creazione ingrediente');
      }

      const ing = await res.json(); // { id, name }
      const choices = getChoices();
      if (choices) {
        choices.setChoices([{ value: String(ing.id), label: ing.name, selected: true }], 'value', 'label', true);
      } else {
        // fallback senza Choices
        const opt = new Option(ing.name, ing.id, true, true);
        select.add(opt);
      }

      input.value = '';
      close();
    } catch (e) {
      alert(e.message);
    }
  });

  modal.addEventListener('shown.bs.modal', () => input?.focus());
}

// Client rule: disable Pomodoro ingredient when a white category is selected
document.addEventListener('DOMContentLoaded', () => {
  const categorySelect = document.getElementById('category_id');
  const ingredientsSelect = document.getElementById('ingredients');
  if (!categorySelect || !ingredientsSelect) return;

  // Prefer data-is-tomato attribute (fallback to label)
  const findTomatoOption = () => {
    const byAttr = Array.from(ingredientsSelect.options).find((opt) => opt.getAttribute('data-is-tomato') === '1');
    if (byAttr) return byAttr;
    return Array.from(ingredientsSelect.options).find((opt) => (opt.text || '').trim().toLowerCase() === 'pomodoro');
  };

  const updateDisabled = () => {
  // Detect "white" by data attribute reliably
  const selectedOption = categorySelect.options[categorySelect.selectedIndex];
  const isWhite = selectedOption && selectedOption.getAttribute('data-is-white') === '1';
    const tomatoOpt = findTomatoOption();
    if (!tomatoOpt) return;

    const help = document.getElementById('whiteHelp');
    if (isWhite) {
      tomatoOpt.disabled = true;
      // If currently selected, unselect it
      if (Array.from(ingredientsSelect.selectedOptions).some((o) => o.value === tomatoOpt.value)) {
        tomatoOpt.selected = false;
      }
      if (help) help.classList.remove('d-none');
    } else {
      tomatoOpt.disabled = false;
      if (help) help.classList.add('d-none');
    }

    // Sync with Choices.js if present
    const choices = ingredientsSelect._choices;
    if (choices) {
      choices.setChoices(
        Array.from(ingredientsSelect.options).map((o) => ({ value: o.value, label: o.text, selected: o.selected, disabled: o.disabled })),
        'value',
        'label',
        true,
      );
    }
  };

  categorySelect.addEventListener('change', updateDisabled);
  updateDisabled();
});

// Layout Toggle per Vista Pizze (Card/List)
document.addEventListener('DOMContentLoaded', () => {
  const cardViewToggle = document.getElementById('cardView');
  const listViewToggle = document.getElementById('listView');
  const cardContainer = document.getElementById('card-view');
  const listContainer = document.getElementById('list-view');

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
    localStorage.setItem('pizzasViewMode', viewMode);
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
  const savedViewMode = localStorage.getItem('pizzasViewMode') || 'list';
  if (savedViewMode === 'card') {
    cardViewToggle.checked = true;
    switchView('card');
  } else {
    listViewToggle.checked = true;
    switchView('list');
  }
});
