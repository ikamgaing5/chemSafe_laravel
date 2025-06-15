<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Liste des produits</h4>
        <input type="text" wire:model.live="search" class="form-control w-50" placeholder="Rechercher un produit par nom, type d'emballage, nature ou utilisation...">
    </div>

    <div class="container-fluid pt-0 ps-0 pe-0">
        <div class="shadow-lg card" id="accordion-one">
            <div class="card-header flex-wrap px-3">
                <div>
                    <h6 class="card-title">Produits / Liste des Produits</h6>
                    <p class="m-0 subtitle">Ici vous pouvez voir tous les produits enregistrés dans
                        l'atelier <strong>{{$atelier->nomatelier}}</strong></p>
                </div>
                <div class="d-flex">
                    <ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <div class="d-flex">
                                @include('product.partials.add')
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="Preview" role="tabpanel" aria-labelledby="home-tab">
                    <div class="shadow-lg card-body p-0">
                        <div class="table-responsive">
                            <table id="basic-btn" class="display table table-striped" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Nom du produit</th>
                                        <th>Type d'emballage</th>
                                        <th>Info FDS</th>
                                        <th>Photo</th>
                                        <th>FDS</th>
                                        @if (Auth::user()->role != 'user')
                                        <th class="text-end">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produits as $prod)
                                    <tr>
                                        <td>
                                            <div class="trans-list">
                                                <h4>{{$prod->nomprod}}</h4>
                                            </div>
                                        </td>
                                        <td><span class="text-primary font-w600">{{$prod->type_emballage}}</span></td>
                                        <td>
                                            <a href="{{route('product.one', [$IdEncryptor::encode($prod->id)])}}"
                                                class="btn btn-secondary shadow btn-xs sharp me-1">
                                                <i class="bi bi-info-circle-fill"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @include('product.partials.photo')
                                        </td>
                                        <td>
                                            @include('product.partials.fds')
                                        </td>
                                        @if (Auth::user()->role != 'user')
                                        <td>
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-danger shadow btn-xs sharp me-1" wire:click="$dispatch('openDeleteModal', { 
                                                                            entityType: 'produit',
                                                                            nom: '{{ $prod->nomprod }}', 
                                                                            entityId: {{ $prod->id }}, 
                                                                            entitySecond: {{$atelier->id}}
                                                                            })">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="{{ Auth::user()->role != 'user' ? '6' : '5' }}"
                                            class="text-center">
                                            @if($search)
                                            Aucun produit trouvé pour "{{ $search }}"
                                            @else
                                            Aucun produit enregistré.
                                            @endif
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $produits->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>