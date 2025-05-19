<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addatelier">
    + Ajouter un Atelier
</button>

<!-- Modal -->
<div class="modal fade" id="addatelier" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('workshop.add')}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajout d'un l'atelier </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label text-secondary">Nom de l'atelier: </label>
                    <input type="hidden" value="{{$idusine}}" name="usine_id">
                    <input type="text" class="form-control" name="nomatelier" id="" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>