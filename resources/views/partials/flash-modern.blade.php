{{-- Flash messages moderni con toast-style --}}
@if (session('status') || session('success'))
    <div class="alert alert-success d-flex align-items-center slide-up" data-auto-dismiss="true" role="alert">
        <div class="me-2">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Successo!</strong>
            {{ session('status') ?? session('success') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error') || session('danger'))
    <div class="alert alert-danger d-flex align-items-center slide-up" data-auto-dismiss="true" role="alert">
        <div class="me-2">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Errore!</strong>
            {{ session('error') ?? session('danger') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning d-flex align-items-center slide-up" data-auto-dismiss="true" role="alert">
        <div class="me-2">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Attenzione!</strong>
            {{ session('warning') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info d-flex align-items-center slide-up" data-auto-dismiss="true" role="alert">
        <div class="me-2">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="flex-grow-1">
            <strong>Info:</strong>
            {{ session('info') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Validation errors summary --}}
@if ($errors->any())
    <div class="alert alert-danger slide-up" role="alert">
        <div class="d-flex align-items-start">
            <div class="me-2 mt-1">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="flex-grow-1">
                <strong>Correggi i seguenti errori:</strong>
                <ul class="mb-0 mt-2 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<style>
.alert {
    border-radius: 1rem;
    border: none;
    margin-bottom: 1.5rem;
    padding: 1rem 1.25rem;
    position: relative;
    overflow: hidden;
}

.alert::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: currentColor;
    opacity: 0.5;
}

.alert-success {
    background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
    color: #047857;
    border-left: 4px solid #10B981;
}

.alert-danger {
    background: linear-gradient(135deg, #FEF2F2 0%, #FEE2E2 100%);
    color: #DC2626;
    border-left: 4px solid #EF4444;
}

.alert-warning {
    background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
    color: #D97706;
    border-left: 4px solid #F59E0B;
}

.alert-info {
    background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);
    color: #1D4ED8;
    border-left: 4px solid #3B82F6;
}

.btn-close {
    --bs-btn-close-bg: none;
    background: transparent;
    border: none;
    font-size: 1.1rem;
    opacity: 0.5;
    transition: opacity 0.2s ease;
}

.btn-close:hover {
    opacity: 1;
}

@media (max-width: 768px) {
    .alert {
        margin-left: 0;
        margin-right: 0;
        border-radius: 0.75rem;
    }
}
</style>