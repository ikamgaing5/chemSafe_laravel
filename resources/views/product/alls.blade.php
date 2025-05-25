@php
use App\Helpers\IdEncryptor;

// dd($all);
@endphp 

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/images/favicon.png" />

    <!-- Pour Apple (optionnel mais recommandé) -->
    <link rel="apple-touch-icon" href="/images/favion.png">

    <!-- Pour navigateur Microsoft (optionnel) -->
    <meta name="msapplication-TileImage" content="/images/favicon.png">
    <link href="/vendor/wow-master/css/libs/animate.css" rel="stylesheet">
    <link href="/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/bootstrap-select-country/css/bootstrap-select-country.min.css">
    <link rel="stylesheet" href="/vendor/jquery-nice-select/css/nice-select.css">
    <link href="/vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" />

    <link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/vendor/swiper/css/swiper-bundle.min.css">

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/all-product.css">
    <link rel="stylesheet" href="/css/all.css">
    <script src="/js/all.js"></script>

    <style>
    /* Styles pour le graphique et la légende */
    .chart-container {
        position: relative;
        height: 400px;
        width: 100%;
    }

    .custom-legend {
        padding: 15px;
        border-radius: 5px;
        background-color: #f8f9fa;
    }

    .legend-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        cursor: pointer;
        padding: 5px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }

    .legend-item:hover {
        background-color: #e9ecef;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        margin-right: 10px;
    }

    .legend-text {
        font-size: 0.9rem;
        color: #495057;
    }

    /* Styles responsifs */
    @media (max-width: 768px) {
        .chart-container {
            height: 300px;
        }

        .legend-container-mobile {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .legend-item {
            flex: 0 0 calc(50% - 8px);
            margin-bottom: 8px;
        }

        .legend-text {
            font-size: 0.8rem;
        }
    }

    /* Styles pour le tableau des dangers */
    .has-tooltip {
        cursor: help;
    }

    #dangersList .table th {
        background-color: #f8f9fa;
    }

    #dangersList .table td {
        vertical-align: middle;
    }
    </style>

</head>

<body>
    <div id="preloader">
        <div class="loader">
            <div class="dots">
                <div class="dot mainDot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </div>

    <div id="main-wrapper">
        @include('layouts.navbar')
        @include('layouts.sidebar')

        <div class="content-body">
            <!-- container starts -->
            <div class="container-fluid">

                @if (session('deletesuccess'))
                    {!!session('deletesuccess')!!}
                @endif


                <div class="demo-view">
                    <div class="col-xl-12">
                        <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div>
                                    <u><a class="text-primary fw-bold fs-5" href="{{route('dashboard')}}">Tableau de bord</a></u>
                                    <i class="bi bi-caret-right-fill"></i>
                                    
                                    
                                </div>
                            </div>

                            <div class="shadow-lg page-title d-xl-none text-center py-2">

                                <u><a href="{{route('dashboard')}}" class="text-primary fw-bold fs-5"><i
                                            class="bi bi-caret-right-fill"></i>
                                        Tableau de bord
                                    </a></u>
                            </div>
                        </div>

                        <div class="container-fluid pt-0 ps-0  pe-0">
                            <div class="shadow-lg card" id="accordion-one">
                                <div class="card-header flex-wrap px-3">
                                    <div>
                                        <h6 class="card-title">Produits / Liste des Produits</h6>
                                        <p class="m-0 subtitle">Ici vous pouvez voir tous les produits enregistrés dans
                                            l'atelier <strong></strong></p>
                                    </div>
                                    <div class="d-flex">
                                        <ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">
                                            
                                            <li class="nav-item " role="presentation">

                                                <div class="d-flex">
                                                    <button type="submit" name="supprimeretudiant"
                                                        class="btn btn-danger" value="tout supprimer">tout supprimer
                                                    </button>
                                                     
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!--tab-content-->
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="Preview" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        <div class="shadow-lg card-body p-0">
                                            <div class="table-responsive">
                                                <table id="basic-btn" class="display table table-striped"
                                                    style="min-width: 845px">
                                                    <thead>
                                                        <tr>
                                                            <th>Nom du produit</th>
                                                            <th>Type d'emballage</th>
                                                            <th>Vol/Poids</th>
                                                            <th>Plus d'info</th>
                                                            <th>Médias</th>
                                                            @if (Auth::user()->role != 'user')
                                                                <th class="text-end">Action</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($all->count() <= 0) 
                                                            <tr>
                                                                <td colspan='6'>Aucun produit enregistré. </td>
                                                            </tr>
                                                        @else
                                                            @foreach ($all as $prod)
                                                                <tr>
                                                                    <td>
                                                                        <div class="trans-list">
                                                                            <h4>{{$prod->nomprod}}</h4>
                                                                        </div>
                                                                    </td>
                                                                    <td><span
                                                                            class="text-primary font-w600">{{$prod->type_emballage}}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <div class="mb-0">{{$prod->poids}}</div>
                                                                    </td>
                                                                    <td><a href="{{route('product.one', IdEncryptor::encode($prod->id))}}"
                                                                            class="btn btn-secondary shadow btn-xs sharp me-1"><i
                                                                                class="bi bi-info-circle-fill"></i></a></td>
                                                                    <td>
                                                                        <div class="d-flex">
                                                                            @include('product.partials.photo')
                                                                            @include('product.partials.fds')
                                                                        </div>
                                                                    </td>
                                                                    @if (Auth::user()->role != 'user')
                                                                        <td>
                                                                            <div class="d-flex">

                                                                                {{-- @include('product.partials.delete') --}}
                                                                            </div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let produit = document.getElementById('produit');
        let submitBtn = document.getElementById('submitBtn');
        let messageProduit = document.getElementById('messageProduit');


        function validateSelection() {
            const selectedProduit = Array.from(produit.selectedOptions).map(option => option.value);
            const isValidProduit = selectedProduit.length > 0 && !selectedProduit.includes("none");

            if (isValidProduit) {
                submitBtn.disabled = false;
                messageProduit.style.display = 'none';
            } else {
                submitBtn.disabled = true;
                messageProduit.style.display = 'block';
                messageProduit.textContent = 'Veuillez sélectionner au moins un produit.';
            }
        }

        // Écouteur d'événement
        produit.addEventListener('change', validateSelection);

        // Validation initiale au chargement
        validateSelection();
    });
    </script>
    <script src="{{asset('vendor/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/global/global.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('vendor/apexchart/apexchart.js')}}"></script>
    <script src="{{asset('vendor/peity/jquery.peity.min.js')}}"></script>
    <script src="{{asset('vendor/jquery-nice-select/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('vendor/swiper/js/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('js/dashboard/dashboard-1.js')}}"></script>
    <script src="{{asset('vendor/wow-master/dist/wow.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-datetimepicker/js/moment.js')}}"></script>
    <script src="{{asset('vendor/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-select-country/js/bootstrap-select-country.min.js')}}"></script>
    <script src="{{asset('js/dlabnav-init.js')}}"></script>
    <script src="{{asset('js/custom.min.js')}}"></script>
    <script src="{{asset('js/demo.js')}}"></script>
    <script src="{{asset('js/all.js')}}"></script>
    {{-- @include('product.partials.graphe') --}}
</body>

</html>