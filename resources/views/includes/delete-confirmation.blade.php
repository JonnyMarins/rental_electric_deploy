<!-- Modal per conferma eliminazione -->
<div id="{{ $id }}" class="hidden overlay modal overlay-open:opacity-100 modal-middle" role="dialog"
    tabindex="-1">
    <div
        class="mt-12 transition-all ease-out overlay-animation-target modal-dialog overlay-open:mt-4 overlay-open:opacity-100 overlay-open:duration-500">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ $title }}</h3>
                <button type="button" class="absolute btn btn-text btn-circle btn-sm end-3 top-3" aria-label="Chiudi"
                    data-overlay="#{{ $id }}">
                    <span class="icon-[tabler--x] size-4"></span>
                </button>
            </div>
            <div class="modal-body">
                {{ $message }}
                <p class="mt-2 text-sm text-gray-500">Questa azione non può essere annullata.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-soft btn-secondary" data-overlay="#{{ $id }}">
                    Annulla
                </button>
                <form action="{{ $route }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-error btn-gradient">
                        <x-lucide-trash class="size-4" />Elimina
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
