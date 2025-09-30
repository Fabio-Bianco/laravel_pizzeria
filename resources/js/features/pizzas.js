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
