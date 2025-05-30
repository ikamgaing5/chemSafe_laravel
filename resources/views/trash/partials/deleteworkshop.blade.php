<a class="btn btn-danger shadow btn-xs sharp me-1" href="#supp{{$IdEncryptor::encode($keys->atelier->id)}}"
    data-bs-toggle="modal" data-bs-target="#supp{{$IdEncryptor::encode($keys->atelier->id)}}">
    <i class="bi bi-trash"></i>
</a>
<div class="modal fade" id="supp{{$IdEncryptor::encode($keys->atelier->id)}}" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel{{$IdEncryptor::encode($keys->atelier->id)}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel{{$IdEncryptor::encode($keys->atelier->id)}}">Voulez-vous définitivement supprimer l'atelier <br><strong>{{$keys->atelier->nomatelier}}</strong> ?</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form" method="POST" action="{{route('workshop.erase', ['idatelier' => $keys->id])}}">
                @csrf
                @method('delete')
                <div class="modal-footer">
                    <input type="hidden" name="nomatelier" value="{{$keys->atelier->nomatelier}}">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
                    <input type="submit" class="btn btn-danger" value="Supprimer">
                </div>
            </form>
        </div>
    </div>
</div>