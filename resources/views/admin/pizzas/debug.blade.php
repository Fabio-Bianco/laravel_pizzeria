@extends('layouts.app-modern')

@section('title', 'Test Pizze')

@section('header')
<div class="text-center py-4">
  <h1>TEST PIZZE - DEBUG</h1>
</div>
@endsection

@section('content')
<div class="container">
  <h2>Debug Info:</h2>
  <p>Variabile pizzas: {{ isset($pizzas) ? 'ESISTE' : 'NON ESISTE' }}</p>
  
  @if(isset($pizzas))
    <p>Tipo: {{ gettype($pizzas) }}</p>
    <p>Count: {{ method_exists($pizzas, 'count') ? $pizzas->count() : 'NO COUNT METHOD' }}</p>
    
    @if($pizzas->count() > 0)
      <h3>Pizze trovate:</h3>
      @foreach($pizzas as $pizza)
        <div class="card mb-2">
          <div class="card-body">
            <h5>{{ $pizza->name ?? 'NO NAME' }}</h5>
            <p>Prezzo: €{{ $pizza->price ?? 'NO PRICE' }}</p>
          </div>
        </div>
      @endforeach
    @else
      <p>NESSUNA PIZZA TROVATA</p>
    @endif
  @endif
</div>
@endsection