<?php
use Illuminate\Support\Facades\Auth;
use App\Helpers\IdEncryptor;

$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($current_page == 'workshop/all-workshop' && Auth::user()->role == 'superadmin') {
    $message = 'Liste des Ateliers de toutes les Usines.';
} elseif (strpos($current_page, 'workshop/all-workshop/') === 0) {
    $message = "Liste des Ateliers de l'$usine->nomusine.";
}
// dd($usine);
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="/vendor/wow-master/css/libs/animate.css" rel="stylesheet">
    <link href="/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/bootstrap-select-country/css/bootstrap-select-country.min.css">
    <link rel="stylesheet" href="/vendor/jquery-nice-select/css/nice-select.css">
    <link href="/vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" />

    <link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/vendor/swiper/css/swiper-bundle.min.css">


    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/all-workshop.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.css">
    <script src="/js/all.js"></script>
    <script>
    document.title = "ChemSafe";
    </script>

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
                @if (
                (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin') && strpos(
                $current_page,
                'workshop/all-workshop/'
                ) === 0 && isset($idusine)
                )
                @include('workshop.partials.new-workshop')
                @endif
                <!-- Row -->
                <div class="row">
                    <?php
// echo $message_succes;
if (isset($_SESSION['error']['inbd']) && $_SESSION['error']['inbd'] == true) {
    $message = "L'atelier <strong> " . $_SESSION['error']['data']['nom'] . "</strong>  existe déjà";
    $type = "danger";
    echo $package->message($message, $type);
    unset($_SESSION['error']);
} elseif (isset($_SESSION['error']['success']) && $_SESSION['error']['success'] == true) {
    $message = "L'atelier " . $_SESSION['error']['data']['oldvalue'] . " a été remplacé par  <strong>" . $_SESSION['error']['data']['nom'] . "</strong> ";
    echo $package->message($message, "success");
    unset($_SESSION['error']);
} elseif (isset($_SESSION['error']['errorInsert']) && $_SESSION['error']['errorInsert'] == true) {
    $message = "L'atelier " . $_SESSION['error']['data']['oldvalue'] . " a été remplacé par  <strong>" . $_SESSION['error']['data']['nom'] . "</strong> ";
    echo $package->message($message, "success");
    unset($_SESSION['error']);
} elseif (isset($_SESSION['delete']['errorDelete'])) {
    $message = "L'atelier <strong>" . $_SESSION['delete']['data']['nom'] . "</strong> contient au moins un produit et ne peut être suprrimé ";
    echo $package->message($message, "danger");
    unset($_SESSION['delete']);
} elseif (isset($_SESSION['delete']['deleteok'])) {
    $message = "L'atelier <strong>" . $_SESSION['delete']['data']['nom'] . "</strong> a bien été suprrimé ";
    echo $package->message($message, "success");
    unset($_SESSION['delete']);
} elseif (isset($_SESSION['insertok'])) {
    $message = "L'atelier <strong>" . mb_strtoupper($_SESSION['insertok']['data']['nom']) . "</strong> a été bien ajouté ";
    echo $package->message($message, "success");
    unset($_SESSION['insertok']);
}

					?>
                    <div class="col-xl-12">
                        <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
                            <!-- Ajout des classes de visibilité -->
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div>
                                    <u><a class="text-primary fw-bold fs-5" href="{{route('dashboard')}}">Tableau de bord</a></u>
                                    @if (Auth::user()->role == 'superadmin')
                                    <span class="fs-4"><i class="bi bi-caret-right-fill"></i></span>
                                    <u><a class="text-primary fw-bold fs-5" href="/factory/all-factory">Nos
                                            Usines</a></u>
                                    @endif

                                    <span class="fs-4"><i class="bi bi-caret-right-fill"></i></span>
                                    <span class="card-title fw-bold fs-5">Nos Ateliers</span>
                                </div>
                            </div>
                        </div>

                        <div class="shadow-lg page-title d-xl-none text-center py-2">
                            <u><a href="/dashboard" class="text-primary fw-bold fs-5"><i
                                        class="bi bi-caret-right-fill"></i>
                                    Tableau de bord
                                </a></u>
                            <div class="fs-5">
                                Nombre d'ateliers : <strong class="card-title fw-bold fs-5">{{ $nbreAtelier ?? '' }}</strong>
                            </div>
                        </div>
                    </div>

                    
                @foreach ($AllUsine as $key) 
                    <div class="col-xl-12">
                        <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
                            <!-- Ajout des classes de visibilité -->
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div>
                                    <div class="fs-5">Atelier de
                                        l'{{$key->nomusine ?? ''}}
                                    </div>
                                </div>
                                <div class="fs-5">
                                    Nombre d'ateliers : <strong
                                        class="card-title fw-bold fs-5">{{$key->ateliers->where('active', 'true')->count()}}</strong>
                                </div>

                            </div>
                        </div>

                        <div class="shadow-lg page-title d-xl-none text-center py-2">
                            <u>
                                <div class="fs-5">Atelier de l'{{ $key->nomusine ?? ''}}
                                </div>
                            </u>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <!-- Row -->
                        <div class="row">
                            <div class="col-xl-12">
                                <!-- Row -->
                                <div class="main">
                                    @if ($key->ateliers->where('active', 'true')->count())
                                    <div class="scrollable-row ">
                                        
                                        @foreach ($key->ateliers->where('active', 'true')->sortBy('nomatelier') as $keys)
                                        <div class="col-xl-3 col-lg-4 col-sm-6 px-3">
                                            <div class=" card contact_list text-center">
                                                <div class="card-body">
                                                    <div class="user-content">
                                                        <div class="user-info">
                                                            <div class="user-details">
                                                                <p style="font-weight: 700;">Atelier nommé</p>
                                                                <h4 class="user-name mb-0">{{ $keys->nomatelier }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="contact-icon">
                                                        <label style="font-weight: 700;"
                                                            style="font-weight: 600; font-size: 11px;padding: 0px 10px;">Nombre
                                                            de produit:</label><span
                                                            class="badge badge-success light">{{ $keys->contenir->count() }}</span>

                                                        <br>
                                                        <label style="font-weight: 700;"
                                                            style="font-weight: 600; font-size: 11px;padding: 0px 10px;">Produit
                                                            sans fds: </label><span
                                                            class="badge badge-danger light">{{ $keys->produitSansFds()->count() }}</span>
                                                    </div>
                                                    <div class="d-flex mb-3 justify-content-center align-items-center">
                                                        @if (Auth::user()->role != 'user')
                                                        <center>
                                                            @include('workshop.partials.edit')
                                                            @include('workshop.partials.delete')
                                                        </center>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <a href="{{route('product.forworkshop',IdEncryptor::encode($keys->id))}}"
                                                            class="btn btn-secondary btn-sm w-100 me-2">Voir les
                                                            produits</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        
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
                                    @else
                                        <div class="text-muted my-3">Aucun atelier pour cette usine.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>


        <script src="{{ asset('vendor/global/global.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('js/dlabnav-init.js') }}"></script>
        <script src="{{ asset('js/all-workshop.js') }}"></script>
        <script src="{{ asset('js/custom.min.js') }}"></script>









</body>


</html>