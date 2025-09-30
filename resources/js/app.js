import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Bootstrap JS
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Choices.js for searchable multi-selects
import Choices from 'choices.js';

document.addEventListener('DOMContentLoaded', () => {
		document.querySelectorAll('select[data-choices]')?.forEach((el) => {
		const isMultiple = el.multiple;
			// eslint-disable-next-line no-new
			const instance = new Choices(el, {
			removeItemButton: isMultiple,
			searchEnabled: true,
			shouldSort: false,
			itemSelectText: '',
			position: 'bottom',
			placeholder: true,
			placeholderValue: el.getAttribute('placeholder') || '',
		});
			// attach instance for later use
			// eslint-disable-next-line no-underscore-dangle
			el._choices = instance;
	});
});
