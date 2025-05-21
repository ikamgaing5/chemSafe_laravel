<button type="button" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#edit<?= $keys['id'] ?>">
    Editer
</button>

<!-- Modal -->
<div class="modal fade" id="edit<?= $keys['id'] ?>" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/workshop/edit" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modification de l'atelier
                        <strong><?= $keys['nom'] ?></strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label text-secondary">Nom de l'atelier: </label>
                    <input type="hidden" name="id" value="<?= $keys['id'] ?>">
                    <input type="text" class="form-control" name="nom" id="" value="{{$keys['nomatelier']}}">
                    <input type="hidden" name="oldvalue" value="{{$keys['nomatelier']}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </div>
        </form>
    </div>
</div>