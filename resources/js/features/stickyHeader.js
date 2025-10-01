export function initStickyHeaderSearch() {
	const form = document.querySelector('form[role="search"]');
	if (!form) return;

	form.addEventListener('submit', (e) => {
		e.preventDefault();
		const input = document.getElementById('globalSearchInput');
		const term = (input?.value || '').trim();
		const indexUrl = form.getAttribute('data-index-url') || window.location.href;
		const url = new URL(indexUrl, window.location.origin);
		const params = new URLSearchParams(window.location.search);
		if (term) params.set('search', term); else params.delete('search');
		url.search = params.toString();
		window.location.assign(url.toString());
	});
}
