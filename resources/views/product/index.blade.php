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
    <div class="container-fluid">
        
        {{-- Messages de succès/erreur --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="col-xl-12">
            <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <div>
                        <u><a class="text-primary fw-bold fs-5" href="{{ route('dashboard') }}">Tableau de bord</a></u>
                        <i class="bi bi-caret-right-fill"></i>
                        <span class="card-title fw-bold fs-5">Liste des produits</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Barre de recherche --}}
        <div class="container-fluid pt-0 ps-0 pe-0">
            <div class="shadow-lg card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}" class="row g-3 align-items-center">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search"
                                       placeholder="Rechercher un produit par nom, type d'emballage, nature ou utilisation..."
                                       value="{{ $search }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i> Rechercher
                                </button>
                            </div>
                        </div>
                        @if(!empty($search))
                            <div class="col-md-4">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Effacer la recherche
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- Résultats de recherche --}}
        @if(!empty($search))
            <div class="alert alert-primary">
                <i class="bi bi-info-circle"></i> Résultats de la recherche pour "{{ $search }}"
                ({{ $produits->total() }} produit(s) trouvé(s))
            </div>
        @endif

        {{-- Breadcrumb --}}
        <div class="demo-view">
            

            {{-- Affichage selon le rôle --}}
            @if($user->isSuperAdmin())
                {{-- Vue SuperAdmin : groupé par usine --}}
                @foreach($produitsParUsine as $usine => $produitsUsine)
                    @include('product.partials.table', [
                        'title' => "Produits de l'usine $usine",
                        'subtitle' => "Produits de l'usine $usine",
                        'produits' => $produitsUsine,
                        'showUsine' => false,
                        'IdEncryptor' => $IdEncryptor
                    ])
                @endforeach
            @else
                {{-- Vue Admin : séparé par atelier --}}
                @if(count($communs) > 0)
                    @include('product.partials.table', [
                        'title' => 'Produits communs à plusieurs ateliers',
                        'subtitle' => 'Ici vous pouvez voir tous les produits enregistrés dans plusieurs ateliers',
                        'produits' => $communs,
                        'showUsine' => false
                    ])
                @endif

                @foreach($parAtelier as $atelier => $liste)
                    @include('product.partials.table', [
                        'title' => "Produits de l'atelier $atelier", 
                        'subtitle' => "Ici vous pouvez voir tous les produits enregistrés dans l'atelier $atelier",
                        'produits' => $liste,
                        'showUsine' => false
                    ])
                @endforeach
            @endif
        </div>

    </div>
</div>


<div class="d-flex justify-content-center mt-4">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            {{-- Lien précédent --}}
            @if ($produits->onFirstPage() == false)
                <li class="page-item">
                    <a class="page-link" href="{{ $produits->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif

            {{-- Liens de pages --}}
            @for ($i = 1; $i <= $produits->lastPage(); $i++)
                <li class="page-item {{ $i == $produits->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $produits->url($i) }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Lien suivant --}}
            @if ($produits->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $produits->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>


<script src="{{asset('vendor/global/global.min.js')}}"></script>
<script src="{{asset('vendor/chart.js/Chart.bundle.min.js')}}"></script>
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
<script src="{{asset('vendor/bootstrap-select-country/js/bootstrap-select-country.min.js')}}">
</script>
<script src="{{asset('js/dlabnav-init.js')}}"></script>
<script src="{{asset('js/custom.min.js')}}"></script>
<script src="{{asset('js/demo.js')}}"></script>
<script src="{{asset('js/all.js')}}"></script>
