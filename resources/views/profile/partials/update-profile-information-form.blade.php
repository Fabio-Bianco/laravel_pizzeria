<section>
    <header class="mb-3">
        <h2 class="h5 mb-1">Informazioni profilo</h2>
        <p class="text-muted small mb-0">Aggiorna i dati del tuo profilo e l'indirizzo email.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <x-input-label for="name" value="Nome" />
            <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-danger" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="small mt-2">
                        Il tuo indirizzo email non è verificato.

                        <button form="send-verification" class="btn btn-link p-0 align-baseline">
                            Clicca qui per inviare nuovamente l'email di verifica.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success small">
                            Un nuovo link di verifica è stato inviato al tuo indirizzo email.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="mb-3">
            <x-input-label for="phone" value="Numero di telefono" />
            <x-text-input id="phone" name="phone" type="text" class="form-control" :value="old('phone', $user->phone)" autocomplete="tel" />
            <x-input-error class="mt-2 text-danger" :messages="$errors->get('phone')" />
        </div>

        <div class="d-flex align-items-center gap-3">
            <x-primary-button class="btn btn-primary">Salva</x-primary-button>

            @if (session('status') === 'profile-updated')
                <span
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-muted small"
                >Salvato.</span>
            @endif
        </div>
    </form>
</section>
