<div>
    <div class="col-xl-12">
        <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <div>
                    <u><a class="text-primary fw-bold fs-5" href="{{route('dashboard')}}">Tableau de
                            bord</a></u>
                    @if (Auth::user()->role == 'superadmin')
                    <span class="fs-4"><i class="bi bi-caret-right-fill"></i></span>
                    <u><a class="text-primary fw-bold fs-5" href="/factory/all-factory">Nos
                            Usines</a></u>
                    @endif

                    <span class="fs-4"><i class="bi bi-caret-right-fill"></i></span>
                    <span class="card-title fw-bold fs-5">{{$usine->nomusine}}</span>
                </div>
                <div class="fs-5">
                    Nombre d'ateliers : <strong class="card-title fw-bold fs-5">{{$workshops->count()}}</strong>
                </div>
            </div>
        </div>

        <div class="shadow-lg page-title d-xl-none text-center py-2">
            <u><a href="/dashboard" class="text-primary fw-bold fs-5"><i class="bi bi-caret-right-fill"></i>
                    Tableau de bord
                </a></u>
            <div class="fs-5">
                Nombre d'ateliers : <strong class="card-title fw-bold fs-5">{{$workshops->count() }}</strong>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <!-- Row -->
                <div class="main">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4>Liste des ateliers</h4>
                        <input type="text" wire:model.live="search" class="form-control w-25"
                            placeholder="Rechercher un atelier...">
                    </div>

                    <div class="scrollable-row">
                        @foreach($workshop as $keys)
                        <div class="col-xl-3 col-lg-4 col-sm-6 px-3">
                            <div class="card contact_list text-center">
                                <div class="card-body">
                                    <div class="user-content">
                                        <div class="user-info">
                                            <div class="user-details">
                                                <p style="font-weight: 700;">Atelier nommé</p>
                                                <h4 class="user-name mb-0">{{ $keys->nomatelier }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contact-icon">
                                        <label style="font-weight: 700;">Nombre de produit:</label>
                                        <span class="badge badge-success light">{{ $keys->contenir->count() }}</span>
                                        <br>
                                        <label style="font-weight: 700;">Produit sans fds: </label>
                                        <span
                                            class="badge badge-danger light">{{ $keys->produitSansFds()->count() }}</span>
                                    </div>
                                    <div class="d-flex mb-3 justify-content-center align-items-center">
                                        @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role ==
                                        'superadmin'))
                                        <center>
                                            <button type="button" class="btn btn-primary mx-2"
                                                wire:click="$dispatch('openEditModal', { entityType: 'atelier',  entityId: {{ $keys->id }} }); ">
                                                Editer
                                            </button>

                                            <button type="button" class="btn btn-danger mx-2"
                                                wire:click="$dispatch('openDeleteModal', { 
                                                    entityType: 'atelier',
                                                    nom: '{{ $keys->nomatelier }}', 
                                                    entityId: {{ $keys->id }}, 
                                                    entitySecond: null
                                                     })">
                                                Supprimer
                                            </button>
                                        </center>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{route('product.forworkshop', $IdEncryptor::encode($keys->id))}}"
                                            class="btn btn-secondary btn-sm w-100 me-2">Voir les produits</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $workshop->links() }}
                    </div>

                    <div class="scroll-indicator">
                        <div class="scroll-indicator-text">Faites défiler pour voir plus</div>
                        <div class="scroll-indicator-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>