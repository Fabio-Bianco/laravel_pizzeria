/**
 * features/pizzas.js
 *
 * Gestisce la UI delle pagine Pizza (create/edit):
 * - Inizializzazione del modal "Nuovo ingrediente"
 * - Creazione rapida ingrediente via fetch API
 * - Aggiornamento della select multipla (Choices.js) selezionando l'ingrediente creato
 *
 * Dipendenze: Bootstrap (modal), Choices.js (per select avanzate)
 */

// Inizializza la funzionalità solo se trova gli elementi attesi nel DOM
export function initPizzaIngredientQuickCreate() {
  // Selezori principali
  const modalEl = document.getElementById('newIngredientModal');
  const saveBtn = document.getElementById('ni_save');
  const nameInput = document.getElementById('ni_name');
  const select = document.getElementById('ingredients');

  // Se non siamo in una pagina pizza con questi elementi, esci senza errori
  if (!modalEl || !saveBtn || !nameInput || !select) return;

  // Ricava l'endpoint di store dal data-attribute nel select
  const storeUrl = select.getAttribute('data-store-url');
  if (!storeUrl) return;

  // Helper: leggi token CSRF
  function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
  }

  // Click handler del bottone "Crea"
  saveBtn.addEventListener('click', async () => {
    const name = nameInput.value.trim();
    if (!name) {
      nameInput.focus();
      return;
    }

    try {
      // Invio richiesta al controller per creare un nuovo ingrediente
      const res = await fetch(storeUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken(),
          'Accept': 'application/json',
        },
        body: JSON.stringify({ name }),
      });

      if (!res.ok) {
        throw new Error('Risposta non valida dal server');
      }

      const data = await res.json();

      // Aggiorna la select: se esiste Choices attivo, usa la sua API
      // altrimenti aggiungi un <option> standard e selezionalo
      // eslint-disable-next-line no-underscore-dangle
      const choicesInstance = select._choices;
      if (choicesInstance) {
        choicesInstance.setChoices([
          { value: data.id, label: data.name, selected: true },
        ], 'value', 'label', true);
      } else {
        const opt = new Option(data.name, data.id, true, true);
        select.add(opt);
      }

      // Chiudi il modal e ripulisci l'input
      const bsModal = window.bootstrap?.Modal.getInstance(modalEl) || new window.bootstrap.Modal(modalEl);
      bsModal.hide();
      nameInput.value = '';
    } catch (err) {
      // Notifica semplice: in produzione potresti usare un alert Bootstrap
      // o messaggi inline nella form
      // eslint-disable-next-line no-alert
      alert('Impossibile creare ingrediente.');
    }
  });
}
