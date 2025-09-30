@props(['href' => null, 'label' => 'Indietro', 'fixed' => false])

@php
    $url = $href ?: url()->previous();
@endphp

@php
    $classes = 'btn btn-outline-secondary btn-sm';
    if ($fixed) {
        $classes .= ' x-back-fixed';
    }
@endphp

<a href="{{ $url }}" class="{{ $classes }}">
    <span class="me-1" aria-hidden="true">‹</span>
    {{ $label }}
    <span class="visually-hidden">torna alla pagina precedente</span>
</a>

 
