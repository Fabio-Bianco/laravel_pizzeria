@props(['homeHref' => route('dashboard'), 'backHref' => null])

@php
    $back = $backHref ?: url()->previous();
@endphp

<div class="x-fab-group" aria-label="Navigazione rapida">
    <a href="{{ $homeHref }}" class="btn btn-outline-secondary btn-sm" aria-label="Vai alla Home">
        <span aria-hidden="true">🏠</span>
        <span class="ms-1">Home</span>
    </a>
    <a href="{{ $back }}" class="btn btn-outline-secondary btn-sm" aria-label="Torna indietro">
        <span aria-hidden="true">‹</span>
        <span class="ms-1">Indietro</span>
    </a>
</div>
