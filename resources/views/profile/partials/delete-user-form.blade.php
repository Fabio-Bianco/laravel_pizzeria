<section>
    <header class="mb-3">
        <h2 class="h5 mb-1">Elimina account</h2>
        <p class="text-muted small mb-0">L'eliminazione è permanente. Scarica eventuali dati prima di procedere.</p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn btn-danger"
    >Elimina account</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="h5">Sei sicuro di voler eliminare il tuo account?</h2>

            <p class="text-muted small mt-1">Una volta eliminato, tutti i dati saranno persi. Inserisci la password per confermare.</p>

            <div class="mt-3">
                <x-input-label for="password" value="Password" class="visually-hidden" />
                <x-text-input id="password" name="password" type="password" class="form-control w-75" placeholder="Password" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-danger" />
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <x-secondary-button class="btn btn-outline-secondary" x-on:click="$dispatch('close')">Annulla</x-secondary-button>
                <x-danger-button class="btn btn-danger ms-2">Elimina account</x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
