<div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form wire:submit="update">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Modification d'un {{ $entityType === 'atelier' ? 'atelier' : 'usine' }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label text-secondary">Nom :</label>
                    <input type="text" class="form-control" wire:model="nom" placeholder="{{ $entityType === 'usine' ? 'Ex: Usine de XXX' : ' ' }}">
                    @error('nom') <span class="text-danger">{{ $message }}</span> @enderror

                    @if($entityType === 'atelier')
                        <input type="hidden" class="form-control" wire:model="usine_id" disabled>
                        @error('usine_id') <span class="text-danger"></span> @enderror
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading wire:target="update">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                        Modifier
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

