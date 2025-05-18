<?php
$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($current_page == 'dashboards') {
    $message = 'Tableau de bord.';
}?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignLab">
    <meta name="robots" content="">
    <meta name="keywords"
        content="school, school admin, education, academy, admin dashboard, college, college management, education management, institute, school management, school management system, student management, teacher management, university, university management">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" type="image/png" href="/images/favicon.png" />

    <!-- Pour Apple (optionnel mais recommandé) -->
    <link rel="apple-touch-icon" href="/images/favion.png">

    <!-- Pour navigateur Microsoft (optionnel) -->
    <meta name="msapplication-TileImage" content="/images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <script src="{{asset('js/chart.umd.js')}}"></script>
    <script src="{{asset("js/jsquery.min.js")}}"></script>
    <link href="{{asset('vendor/wow-master/css/libs/animate.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-select-country/css/bootstrap-select-country.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/jquery-nice-select/css/nice-select.css')}}">
    <link href="{{asset('vendor/datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" /> -->

    <link href="{{asset('vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/swiper/css/swiper-bundle.min.css')}}">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/dashboard.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">

    <!-- <link href="/../css/style.css" rel="stylesheet"> -->


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

    <div id="main-wrapper" class="wallet-open active">
        @include('layouts.navbar');
        @include('layouts.sidebar');

        <div class="wallet-bar-close"></div>

        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    if (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "insertok") {
                        echo $package->message("Le produit a été ajoutée, pensez à ajouter sa FDS dès que possible", "success");
                    } elseif (isset($_SESSION['insertinfoFDS']) && $_SESSION['insertinfoFDS'] == true) {
                        echo $package->message("Le produit et sa FDS ont été ajouté", "success");
                    }
                    unset($_SESSION['insertinfoFDS'], $_SESSION['insert'])
                        ?>

                    <?php
                    //  require_once __DIR__ . '/../layouts/info.php'
                     ?>
                    <div class="col-xl-12">
                        <div class="shadow-lg page-titles">
                            <div class="d-flex align-items-center flex-wrap ">
                                <h2 class="heading">Bienvenue dans ChemSafe! <span style="color: red;">
                                        {{Auth::user()->name}} </span>.</h2>
                                <input type="hidden" id="id_usine" value="{{Auth::user()->usine_id}}>">
                            </div>
                        </div>
                    </div>

                    <!-- Calendrier -->
                    <div class="d-flex flex-column flex-lg-row">
                        <div class="col-12 col-lg-3 mb-3 mb-lg-0 wow fadeInUp" style="margin-right: 15px;"
                            data-wow-delay="1.5s">
                            <div class="shadow-lg card">
                                <div class="card-header pb-0 border-0 flex-wrap">
                                    <div>
                                        <div class="mb-0">
                                            <h2 class="heading mb-0">Calendrier de ChemSafe</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-center event-calender py-0 px-1">
                                    <input type='text' class="form-control d-none" id='datetimepicker1'>
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