<a class="btn btn-danger shadow btn-xs sharp me-1" href="#supp{{$prod->id}}"
    data-bs-toggle="modal" data-bs-target="#supp{{$prod->id}}">
    <i class="bi bi-trash"></i>
</a>
<div class="modal fade " id="supp{{$prod->id}}" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel{{$prod->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel{{$prod->id}}">Voulez-vous
                    supprimer <strong>{{$prod->nomprod}}</strong><br> de l'atelier
                    {{$atelier->nomatelier}} ?</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form" method="POST" action="{{route('product.deleteWorkshop', ['idproduit' => $prod->id, 'idatelier' => $atelier->id])}}">
                @csrf
                @method('delete')
                <div class="modal-footer">
                    <input type="hidden" name="nomprod" value="{{$prod->nomprod}}">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
                    <input type="submit" name="Envoyez" class="btn btn-danger" value="Supprimer">
                </div>
            </form>
        </div>
    </div>
</div>