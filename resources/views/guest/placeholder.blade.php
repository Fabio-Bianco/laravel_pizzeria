<x-app-layout>
  <x-slot name="header">
    <div class="d-flex align-items-center justify-content-between">
      <h1 class="h4 mb-0">{{ $title ?? 'Vetrina' }}</h1>
      <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">Indietro</a>
    </div>
  </x-slot>

  <div class="alert alert-info">Questa è una rotta pubblica placeholder per la futura vetrina (guest). Da implementare.</div>
</x-app-layout>
