<div>
    <div class="col-xl-12">
        <!-- Row -->
        <div class="row">
            <!--column-->

            <div class="col-xl-12">
                <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
                    <!-- Ajout des classes de visibilité -->
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <div>
                            <u><a class="text-primary fw-bold fs-5" href="{{route('dashboard')}}">Tableau de
                                    bord</a></u>
                            <span class="fs-4"><i class="bi bi-caret-right-fill"></i></span>
                            <span class="card-title fw-bold fs-5">Nos Usines</span>
                        </div>
                        <div class="fs-5">
                            Nombre d'Usine : <strong
                                class="card-title fw-bold fs-5">{{$AllUsine->count()}}</strong>
                        </div>
                    </div>
                </div>

                <div class="shadow-lg page-title d-xl-none text-center py-2">

                    <u><a href="/dashboard" class="text-primary fw-bold fs-5"><i
                                class="bi bi-caret-right-fill"></i>
                            Tableau de bord
                        </a></u>
                    <div class="fs-5">
                        Nombre d'Usine : <strong
                            class="card-title fw-bold fs-5">{{$AllUsine->count()}}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <!-- Row -->
                <div class="main">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4>Liste des usines</h4>
                        <input type="text" wire:model.live="search" class="form-control w-25"
                            placeholder="Rechercher une usine...">
                    </div>
                    <div class="scrollable-row ">
                        @foreach ($AllUsine as $keys)

                        <div class="col-xl-3 col-lg-4 col-sm-6 px-3">
                            <div class=" card contact_list text-center">
                                <div class="card-body">
                                    <div class="user-content">
                                        <div class="user-info">
                                            <div class="user-details">
                                                <p style="font-weight: 700;">Usine nommé</p>
                                                <h4 class="user-name mb-0">{{$keys->nomusine}}</h4>
                                                <br>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="contact-icon">
                                        <label style="font-weight: 700;"
                                            style="font-weight: 600; font-size: 11px;padding: 0px 10px;">Nombre
                                            d'atelier :</label><span
                                            class="badge badge-success light">{{$keys->ateliers()->where('active', 'true')->count()}}</span>

                                        <br>
                                        
                                    </div>
                                    <div class="d-flex mb-3 justify-content-center align-items-center">
                                        <center>
                                            <button type="button" class="btn btn-primary mx-2"
                                                wire:click="$dispatch('openEditModal', { entityType: 'usine', entityId: {{ $keys->id }} }); ">
                                                Editer
                                            </button>

                                            <button type="button" class="btn btn-danger mx-2"
                                                wire:click="$dispatch('openDeleteModal', { 
                                                    entityType: 'usine',
                                                    entitySecond: null,
                                                    nom: '{{ $keys->nomusine }}', 
                                                    entityId: {{ $keys->id }}, 
                                                     })">
                                                Supprimer
                                            </button>
                                        </center>

                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{route('oneworkshop', ($IdEncryptor::encode($keys->id)))}}"
                                            class="btn btn-secondary btn-sm w-100 me-2">Voir les
                                            ateliers</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $AllUsine->links() }}
                    </div>
                    <div class="scroll-indicator">
                        <div class="scroll-indicator-text">Faites défiler pour voir plus</div>
                        <div class="scroll-indicator-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
