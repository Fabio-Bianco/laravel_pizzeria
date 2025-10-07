<!DOCTYPE html>
<html>
<head>
    <title>DEBUG PIZZE</title>
</head>
<body>
    <h1>DEBUG PIZZE - TEST MINIMO</h1>
    
    @if(isset($pizzas))
        <p>✅ Variabile pizzas ESISTE</p>
        <p>Tipo: {{ gettype($pizzas) }}</p>
        
        @if(method_exists($pizzas, 'count'))
            <p>Count: {{ $pizzas->count() }}</p>
            
            @if($pizzas->count() > 0)
                <h2>PIZZE TROVATE:</h2>
                @foreach($pizzas as $pizza)
                    <div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
                        <h3>{{ $pizza->name ?? 'NOME NON TROVATO' }}</h3>
                        <p>Prezzo: €{{ $pizza->price ?? 'PREZZO NON TROVATO' }}</p>
                        <p>ID: {{ $pizza->id ?? 'ID NON TROVATO' }}</p>
                    </div>
                @endforeach
            @else
                <p>❌ NESSUNA PIZZA NEL DATABASE</p>
            @endif
        @else
            <p>❌ PIZZAS NON HA METODO COUNT</p>
        @endif
    @else
        <p>❌ Variabile pizzas NON ESISTE</p>
    @endif
    
    <hr>
    <h2>DEBUG INFO:</h2>
    <p>PHP Version: {{ phpversion() }}</p>
    <p>Laravel Version: {{ app()->version() }}</p>
    
</body>
</html>