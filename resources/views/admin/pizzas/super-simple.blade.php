<!DOCTYPE html>
<html>
<head>
    <title>PIZZE - SUPER SIMPLE</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .pizza { border: 1px solid #ccc; margin: 10px; padding: 15px; }
    </style>
</head>
<body>
    <h1>🍕 TEST SUPER SIMPLE PIZZE</h1>
    
    <p><strong>Controller funziona:</strong> ✅</p>
    <p><strong>View caricata:</strong> ✅</p>
    
    @if(isset($pizzas) && $pizzas->count() > 0)
        <p><strong>Pizze trovate:</strong> {{ $pizzas->count() }} ✅</p>
        
        @foreach($pizzas as $pizza)
            <div class="pizza">
                <h3>{{ $pizza->name }}</h3>
                <p>Prezzo: €{{ $pizza->price }}</p>
                @if($pizza->description)
                    <p>{{ $pizza->description }}</p>
                @endif
            </div>
        @endforeach
    @else
        <p><strong>❌ NESSUNA PIZZA TROVATA</strong></p>
    @endif
    
    <hr>
    <p>Se vedi questo, il problema NON è nel controller o routing!</p>
</body>
</html>