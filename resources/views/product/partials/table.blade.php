{{-- resources/views/products/partials/table.blade.php --}}
<div class="container-fluid pt-0 ps-0 pe-0 mb-4">
    <div class="shadow-lg card" id="accordion-one">
        <div class="card-header flex-wrap">
            <div>
                <h6 class="card-title">Produits / Liste des Produits</h6>
                <p class="m-0 subtitle">{{ $subtitle }}</p>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="Preview" role="tabpanel">
                <div class="shadow-lg card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Nom du produit</th>
                                    <th>Type d'emballage</th>
                                    <th>Info FDS</th>
                                    <th>Photo</th>
                                    <th>FDS</th>
                                    <th>Ateliers</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produits as $prod)
                                    <tr>
                                        <td>
                                            <div class="trans-list">
                                                <h4>{{ $prod->nomprod }}</h4>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-primary font-w600">
                                                {{ $prod->type_emballage }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{route('product.one', [$IdEncryptor::encode($prod->id)])}}"  class="btn btn-secondary shadow btn-xs sharp me-1"><i class="bi bi-info-circle-fill"></i></a>
                                        </td>
                                        <td>
                                            @include('product.partials.photo')
                                        </td>
                                        <td>
                                            @include('product.partials.fds')                                                
                                        </td>
                                        <td>
                                            <span class="text-primary font-w600">
                                                {{ $prod->atelier }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
