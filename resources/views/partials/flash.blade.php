@if (session('status'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Correggi gli errori:</strong>
    <ul class="mb-0 mt-1">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
