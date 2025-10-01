@props([
    'search' => true,
    'searchName' => 'search',
    'searchValue' => request('search'),
    'searchPlaceholder' => 'Cerca…',
    // Array di select: [['name' => 'category', 'placeholder' => 'Tutte le categorie', 'options' => [id=>label]]]
    'selects' => [],
    // Opzioni ordinamento: ['' => 'Più recenti', 'name_asc' => 'Nome A→Z', ...]
    'sortOptions' => [],
    'sortValue' => request('sort'),
    'resetUrl' => url()->current(),
])

<form method="GET" class="card mb-3">
  <div class="card-body">
    <div class="row g-2">
      @if($search)
        <div class="col-12 col-md-4">
          <input name="{{ $searchName }}" type="search" value="{{ $searchValue }}" class="form-control" placeholder="{{ $searchPlaceholder }}">
        </div>
      @endif

      @foreach($selects as $select)
        <div class="col-6 col-md-3">
          <select name="{{ $select['name'] }}" class="form-select" data-choices>
            <option value="">{{ $select['placeholder'] ?? 'Tutti' }}</option>
            @foreach(($select['options'] ?? []) as $value => $label)
              <option value="{{ $value }}" @selected((string)$value === (string)request($select['name']))>{{ $label }}</option>
            @endforeach
          </select>
        </div>
      @endforeach

      @if(!empty($sortOptions))
        <div class="col-6 col-md-2">
          <select name="sort" class="form-select" data-choices>
            @foreach($sortOptions as $value => $label)
              <option value="{{ $value }}" @selected((string)$value === (string)$sortValue)>{{ $label }}</option>
            @endforeach
          </select>
        </div>
      @endif
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-outline-primary" type="submit">Filtra</button>
      <a class="btn btn-outline-secondary" href="{{ $resetUrl }}">Reset</a>
    </div>
  </div>
</form>
