<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <button type="button" class="btn btn-danger shadow btn-xs sharp me-1" wire:click="openModal">
        <i class="bi bi-trash"></i>
    </button>
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit="delete">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Suppression d'un produit </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body" style="word-break: break-word;">
                        Voulez-vous réellement supprimer {{ $nomprod }} de l'atelier {{$nomatelier}} ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading wire:target="delete">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>
                            Supprimer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>