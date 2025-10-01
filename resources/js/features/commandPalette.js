export function initCommandPalette() {
	const modalEl = document.getElementById('commandPalette');
	if (!modalEl || !window.bootstrap) return;
	const modal = new window.bootstrap.Modal(modalEl);

	const routes = {
		pizzas: {
			index: modalEl.dataset.pizzasIndex || '',
			create: modalEl.dataset.pizzasCreate || '',
		},
		ingredients: {
			index: modalEl.dataset.ingredientsIndex || '',
			create: modalEl.dataset.ingredientsCreate || '',
		},
		categories: {
			index: modalEl.dataset.categoriesIndex || '',
			create: modalEl.dataset.categoriesCreate || '',
		},
		beverages: {
			index: modalEl.dataset.beveragesIndex || '',
			create: modalEl.dataset.beveragesCreate || '',
		},
	};

	const items = [
		{ label: 'Crea Pizza', action: () => routes.pizzas.create && window.location.assign(routes.pizzas.create) },
		{ label: 'Vai a Pizze', action: () => routes.pizzas.index && window.location.assign(routes.pizzas.index) },
		{ label: 'Vai a Ingredienti', action: () => routes.ingredients.index && window.location.assign(routes.ingredients.index) },
		{ label: 'Vai a Categorie', action: () => routes.categories.index && window.location.assign(routes.categories.index) },
		{ label: 'Vai a Bevande', action: () => routes.beverages.index && window.location.assign(routes.beverages.index) },
		{ label: 'Filtra per categoria…', action: () => {
				const term = window.prompt('Inserisci nome categoria:');
				if (!term) return;
				const url = new URL(routes.pizzas.index || window.location.href, window.location.origin);
				url.searchParams.set('search', term);
				window.location.assign(url.toString());
			}
		}
	];

	const input = document.getElementById('cmdInput');
	const results = document.getElementById('cmdResults');
	if (!input || !results) return;

	function render(list) {
		results.innerHTML = '';
		list.forEach((it) => {
			const li = document.createElement('li');
			li.className = 'list-group-item list-group-item-action';
			li.textContent = it.label;
			li.setAttribute('role', 'option');
			li.tabIndex = 0;
			li.addEventListener('click', () => { modal.hide(); it.action(); });
			li.addEventListener('keydown', (e) => { if (e.key === 'Enter') { modal.hide(); it.action(); }});
			results.appendChild(li);
		});
	}

	function openPalette(){
		render(items);
		modal.show();
		setTimeout(() => input.focus(), 100);
	}

	document.addEventListener('keydown', (e) => {
		const metaK = (e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'k');
		if (metaK) { e.preventDefault(); openPalette(); }
	});
	input.addEventListener('input', (e) => {
		const q = e.target.value.toLowerCase();
		const filtered = items.filter(it => it.label.toLowerCase().includes(q));
		render(filtered);
	});
}
