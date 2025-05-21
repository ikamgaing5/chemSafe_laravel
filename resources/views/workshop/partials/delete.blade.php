<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supp{{$keys->id}}">
    Supprimer
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="supp{{$keys->id}}" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <form action="{{route('workshop.delete', $keys->id)}}" method="POST">
        @csrf
        @method('patch')
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression de l'Atelier
              <strong>{{$keys->nomatelier}}</strong> </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Voulez-vous réellement supprimer l'Atelier <strong>{{$keys->nomatelier}}</strong> ?
            <input type="hidden" name="id" value="{{$keys->id}}">
            <input type="hidden" name="active" value="false">
            <input type="hidden" name="usine" value="{{$idusine ?? $keys->id}}">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Supprimer</button>
          </div>
        </div>
      </form>
    </div>
  </div>