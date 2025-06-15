<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Liste des Utilisateurs</h4>
        <input type="text" wire:model.live="search" class="form-control w-50" placeholder="Rechercher un utilisateur par nom ou nom d'utilisateur...">
    </div>

    @forelse ($usine as $keys)
    <div class="container-fluid pt-0 ps-0 pe-0 mb-4">
        <div class="shadow-lg card" id="accordion-{{ $loop->index }}">
            <div class="card-header flex-wrap px-3">
                <div>
                    <h6 class="card-title">Utilisateur / Liste des Utilisateurs</h6>
                    <p class="m-0 subtitle">Ici vous pouvez voir tous les utilisateurs de l'{{$keys->nomusine}}.</p>
                </div>
                <div class="d-flex">
                    <ul class="nav nav-tabs dzm-tabs" id="myTab-{{ $loop->index }}" role="tablist">
                        <li class="nav-item" role="presentation">
                            <div class="d-flex">
                                {{-- @include('user.partials.add') --}}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" id="myTabContent-{{ $loop->index }}">
                <div class="tab-pane fade show active" id="Preview-{{ $loop->index }}" role="tabpanel" aria-labelledby="home-tab-{{ $loop->index }}">
                    <div class="shadow-lg card-body p-0">
                        <div class="table-responsive">
                            <table class="display table table-striped" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Nom et Prénom</th>
                                        <th>Nom d'utilisateur</th>
                                        <th>Rôle</th>
                                        @if (Auth::user()->role != 'user')
                                        <th class="text-end">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($keys->users as $user)
                                        <tr>
                                            <td>
                                                <div class="trans-list">
                                                    <h4>{{$user->name}}</h4>
                                                </div>
                                            </td>
                                            <td><span class="text-primary font-w600">{{$user->username}}</span></td>
                                            <td><span class="text-primary font-w600">{{$user->role}}</span></td>
                                            @if (Auth::user()->role != 'user')
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-primary mx-1 btn-sm">
                                                        Modifier
                                                    </button>
                                                    <button type="button" class="btn btn-danger mx-1 btn-sm"
                                                        wire:click="$dispatch('openDeleteModal', { 
                                                            entityType: 'utilisateur',
                                                            nom: '{{ $user->name }}', 
                                                            entityId: {{ $user->id }}, 
                                                            entitySecond: {{ $keys->id }}
                                                            })">
                                                        Supprimer
                                                    </button>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ Auth::user()->role != 'user' ? '3' : '2' }}" class="text-center">
                                                {{-- @if($search)
                                                    Aucun utilisateur trouvé pour "{{ $search }}"
                                                @else
                                                    Aucun utilisateur enregistré dans cette usine.
                                                @endif --}}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{-- {{ $users->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
        <div class="container-fluid pt-0 ps-0 pe-0">
            <div class="shadow-lg card">
                <div class="card-body text-center">
                    <p class="mb-0">Aucune usine disponible.</p>
                </div>
            </div>
        </div>
    @endforelse
</div>