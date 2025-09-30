// Bootstrap base e inizializzazioni front-end del progetto
import './bootstrap';

// Alpine.js (se in uso per piccoli comportamenti reattivi)
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Esponi Bootstrap JS globalmente (per gestire modali, dropdown, ecc.)
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Inizializza Choices.js per i select con ricerca
import Choices from 'choices.js';

document.addEventListener('DOMContentLoaded', () => {
	// Attiva Choices.js per ogni select con data-choices
	document.querySelectorAll('select[data-choices]')?.forEach((el) => {
		const isMultiple = el.multiple;
		// eslint-disable-next-line no-new
		const instance = new Choices(el, {
			removeItemButton: isMultiple, // mostra la X per rimuovere elementi quando multiplo
			searchEnabled: true,          // abilita la ricerca
			shouldSort: false,            // preserva l'ordine dati
			itemSelectText: '',           // niente testo "Premi per selezionare"
			position: 'bottom',           // dropdown sotto l'input
			placeholder: true,
			placeholderValue: el.getAttribute('placeholder') || '',
		});
		// Salva l'istanza su un campo privato per riuso (es. aggiunte dinamiche)
		// eslint-disable-next-line no-underscore-dangle
		el._choices = instance;
	});

		// Intercetta i form che richiedono conferma (data-confirm)
		document.querySelectorAll('form[data-confirm]')?.forEach((form) => {
			form.addEventListener('submit', (e) => {
				const msg = form.getAttribute('data-confirm') || 'Sei sicuro?';
				// eslint-disable-next-line no-alert
				if (!window.confirm(msg)) {
					e.preventDefault();
				}
			});
		});
});

// Moduli specifici delle feature
// Gestione pagina Pizza: modal "Nuovo ingrediente" + aggiornamento select ingredienti
import { initPizzaIngredientQuickCreate } from './features/pizzas';
document.addEventListener('DOMContentLoaded', () => {
	initPizzaIngredientQuickCreate();
});
