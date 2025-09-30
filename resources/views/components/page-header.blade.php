@props([
    'title' => null,
    'items' => [], // es: [['label' => 'Pizze', 'url' => route('admin.pizzas.index')], ['label' => $pizza->name]]
    'backUrl' => null,
])

<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            @if($title)
                <h1 class="h4 mb-1">{{ $title }}</h1>
            @endif
            @if(!empty($items))
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        @foreach($items as $index => $crumb)
                            @php($isLast = $index === count($items) - 1)
                            @if(!$isLast && !empty($crumb['url']))
                                <li class="breadcrumb-item"><a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a></li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">{{ $crumb['label'] }}</li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            @endif
        </div>

        @if($backUrl)
            <a href="{{ $backUrl }}" class="btn btn-outline-secondary">Indietro</a>
        @endif
    </div>
</div>
