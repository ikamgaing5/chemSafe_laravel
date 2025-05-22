<?php
// dd( $prod->infofds);
// die();
// $idprod = IdEncryptor::decode($id);
// $nomproduit = $produit->getNameById($conn, $idprod);
// $infoFDS = $fds->getInfoByProd($conn, $idprod);

$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if (strpos($current_page, 'product/more-detail') === 0) {
    $message = "Informations du produit $prod->nomprod.";
}
// $_SESSION['idatelier'] = IdEncryptor::encode($idatelier);

if (isset($_SESSION['idatelier'])) {
    // $idatelier = IdEncryptor::decode($_SESSION['idatelier']);
    $nomatelier = $atelier->getName($conn, $idatelier);
    $infoAtelierss = $atelier->getAtelierById($conn, $idatelier);
    $idusinebyatlier = $infoAtelierss['idusine'];
}

$nomdanger = "";

foreach ($prod->danger as $key) {
    $nomdanger .= $key->nomdanger . ", ";
}
// die();
// var_dump($prod);
// var_dump(IdEncryptor::encode($idusinebyatlier));
// die();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="shortcut icon" type="image/png" href="images/favicon.png" > -->
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
    <link rel="stylesheet" href="/css/all.css">
    <script src="/js/all.js"></script>


</head>

<body>
    <div>
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
                    @if (session('updateInfoFDS'))
                    {!!session('updateInfoFDS')!!}
                @endif
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
                                <!-- Ajout des classes de visibilité -->
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                    <div>
                                        <u><a class="text-primary fw-bold fs-5" href="/dashboard">Tableau de
                                                bord</a></u>
                                        <i class="bi bi-caret-right-fill"></i>
                                        <u><a href="/workshop/all-workshop/{{$atelier->usine->id}}"
                                                class="text-primary fw-bold fs-5">{{$atelier->usine->nomusine}}</a></u>

                                        <i class="bi bi-caret-right-fill"></i>
                                        <u><a class="text-primary fw-bold fs-5"
                                                href="{{route('product.forworkshop',$atelier->id)}}">
                                                {{$atelier->nomatelier}}
                                            </a>
                                        </u>

                                        <span class="fs-4"><i class="bi bi-caret-right-fill"></i></span>
                                        <span class="card-title fw-bold fs-5">Plus d'informations</span>
                                    </div>
                                </div>
                            </div>

                            <div class="shadow-lg page-title d-xl-none text-center py-2">

                                <u><a href="/all-products/{{$atelier->id}}" class="text-primary fw-bold fs-5"><i
                                            class="bi bi-caret-right-fill"></i>
                                        {{$atelier->nomatelier}}
                                    </a></u>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow-lg">
                                <div class="card-header flex-wrap px-3">
                                    <div>
                                        <h6 class="card-title">Détail du produit</h6>
                                        <p class="m-0 subtitle">Ici vous pouvez voir toutes les informations du produit <strong>{{$prod->nomprod}}</strong></p>
                                    </div>
                                    <div class="d-flex">
                                        <ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">
                                            <li class="nav-item " role="presentation">
                                                <div class="d-flex">
                                                    <a href="{{route('product.edit', $prod->id)}}" class="btn btn-primary">Modifier le produit</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-7">
                                            <img src="{{ asset('storage/' . $prod->photo) }}" alt="photo produit"
                                                class="img-fluid rounded shadow">
                                        </div>

                                        <div class="col-md-5">
                                            <h3 class="mt-4">{{$prod->nomprod}}</h3>
                                            <div class="mb-3">
                                                <h6>Danger : </h6>
                                                @php
                                                if (trim($nomdanger) == "AUCUN DANGER,") {
                                                $color = "success";
                                                }else{
                                                $color = "danger";
                                                }
                                                @endphp
                                                <span class="text-{{$color}} fw-bold">{{$nomdanger}}</span>
                                            </div>
                                            <p class="mb-3">
                                                <strong>Nature : </strong><span
                                                    class="fw-bold text-primary">{{$prod['nature']}}</span>
                                            </p>

                                            <p class="mb-3">
                                                <strong>Fabricant : </strong><span
                                                    class="fw-bold text-primary">{{$prod['fabricant']}}</span>
                                            </p>

                                            <p class="mb-3">
                                                <strong>Risque : </strong><span
                                                    class="fw-bold text-primary">{{$prod['risque']}}</span>
                                            </p>

                                            <div class="mb-3">
                                                <h6>Utilisation : </h6>
                                                <span class="text-primary fw-bold">{{$prod['utilisation']}}</span>
                                            </div>

                                            <p><strong>Type d'emballage : </strong><span
                                                    class="fw-bold text-primary">{{$prod['type_emballage']}}</span></p>


                                            <p><strong>Vol/Poids : </strong><span
                                                    class="fw-bold text-primary">{{$prod['poids']}}</span></p>
                                            @php
                                                if($prod['fds'] != NULL){
                                                    $temoin = true;
                                                    $color = "success";
                                                    $message = "✔ Disponible";
                                                }else{
                                                    $temoin = false;
                                                    $color = "danger";
                                                    $message = "Pas Disponible";
                                                }
                                            @endphp
                                            <div class="mb-3">
                                                <h6>FDS : </h6>
                                                <div class="d-flex align-items-center">
                                                    <strong class="text-{{$color}} me-2">{{$message}}</strong>
                                                    @include('product.partials.fds')
                                                </div>
                                            </div>

                                            <div class="d-flex">
                                                <?php 
                                                    if ($prod->infofds == null && $temoin == true) {
                                                         ?>
                                                <a href="/info-fds/new-info-fds/{{$prod->id}}"
                                                    class="btn btn-outline-dark me-2">Ajouter les informations de la
                                                    FDS</a>
                                                <?php
                                             } 
                                             ?>
                                                <button class="btn btn-primary">Add to Favorites</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid mt-0">
                    <div class="row justify-content-center">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow-lg">
                                <div class="card-header flex-wrap py-2 px-3">
                                    <div>
                                        <h6 class="card-title">Détail du produit</h6>
                                    </div>
                                    <div class="d-flex">
                                        <ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">
                                            <li class="nav-item " role="presentation">
                                                <?php if ($prod->infofds != null && $temoin == true) { ?>
                                                <div class="d-flex">
                                                    <a href="{{route('infofds.edit', ['idproduit' => $prod->infofds->id, 'idatelier' => $atelier->id])}}" class="btn btn-warning">Modifier les informations</a>
                                                </div>
                                                <?php } ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if ($prod->infofds == null && $temoin == true) { ?>
                                    <h2 class="text-center text-danger">Vous n'avez pas ajouté les informations de la
                                        FDS de ce produit.</strong></span></h2>
                                    <?php } else { ?>
                                    <?php if ($temoin) { ?>
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-6">
                                            <div class="mb-3">
                                                <h6 class="text-primary">Risque Physique : </h6>
                                                <span
                                                    class="text-danger fw-bold"><?=$prod->infofds['physique'] ?></span>
                                            </div>

                                            <div class="mb-3">
                                                <h6 class="text-primary">Danger pour la santé : </h6>
                                                <span class="text-danger fw-bold"><?=$prod->infofds['sante'] ?></span>
                                            </div>

                                            <!-- <div class="mb-3">
                                                    <h6 class="text-primary">Danger pour la santé : </h6>
                                                    <span class="text-danger fw-bold"><?= $nomdanger ?></span>
                                                </div> -->

                                            <div class="mb-3">
                                                <h6 class="text-primary">Caractéristiques des PPT chimiques: </h6>
                                                <span class="text-danger fw-bold"><?=$prod->infofds['ppt'] ?></span>
                                            </div>


                                            <div class="mb-3">
                                                <h6 class="text-primary">Stabilité: </h6>
                                                <span
                                                    class="text-danger fw-bold"><?=$prod->infofds['stabilite'] ?></span>
                                            </div>

                                            <div class="mb-3">
                                                <h6 class="text-primary">Conditions à éviter: </h6>
                                                <span class="text-danger fw-bold"><?=$prod->infofds['eviter'] ?></span>
                                            </div>

                                        </div>
                                        <div class="col-xl-6 col-sm-6">
                                            <div class="mb-3">
                                                <h6 class="text-primary">Matériaux incompatibles: </h6>
                                                <span
                                                    class="text-danger fw-bold"><?=$prod->infofds['incompatible'] ?></span>
                                            </div>

                                            <div class="mb-3">
                                                <h6 class="text-primary">Réactivité : </h6>
                                                <span
                                                    class="text-danger fw-bold"><?=$prod->infofds['reactivite'] ?></span>
                                            </div>

                                            <div class="mb-3">
                                                <h6 class="text-primary">Manipulation Stockage : </h6>
                                                <span
                                                    class="text-danger fw-bold"><?=$prod->infofds['stockage'] ?></span>
                                            </div>

                                            <div class="mb-3">
                                                <h6 class="text-primary">Premiers secours : </h6>
                                                <span class="text-danger fw-bold"><?=$prod->infofds['secours'] ?></span>
                                            </div>

                                            <div class="mb-3">
                                                <h6 class="text-primary">EPI : </h6>
                                                <span class="text-danger fw-bold"><?=$prod->infofds['epi'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                    <h2 class="text-center text-danger">Ajouter la FDS pour avoir ses
                                        informations.</strong></span></h2>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
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
    <script src="{{asset('vendor/bootstrap-select-country/js/bootstrap-select-country.min.js')}}"></script>
    <script src="{{asset('js/dlabnav-init.js')}}"></script>
    <script src="{{asset('js/custom.min.js')}}"></script>
    <script src="{{asset('js/demo.js')}}"></script>
    <script src="{{asset('js/all.js')}}"></script>
</body>