<div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form wire:submit="save">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Ajout d'un {{ $entityType }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label text-secondary">Nom :</label>
                    <input type="text" class="form-control" wire:model="nom"> 
                    
                    @error('nom') <span class="text-danger">{{ $message }}</span> @enderror

                    @if($entityType === 'atelier')
                        <input type="hidden" wire:model="usine_id" value="{{ $usine_id }}">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                        Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal', () => {
            const modal = new bootstrap.Modal(document.getElementById('addModal'));
            modal.hide();
        });
    </script>
@endpush