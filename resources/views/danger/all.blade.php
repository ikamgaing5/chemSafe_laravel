<?php 

// dd($danger->produit);
// die();

Use App\Helpers\IdEncryptor;

?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignLab">
    <meta name="robots" content="">
    <meta name="keywords"
        content="school, school admin, education, academy, admin dashboard, college, college management, education management, institute, school management, school management system, student management, teacher management, university, university management">
    <meta name="format-detection" content="telephone=no">


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
                <div class="demo-view">
                    <div class="col-xl-12">
                        <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
                            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div>
                                    <u><a class="text-primary fw-bold fs-5" href="{{route('dashboard')}}">Tableau de bord</a></u>
                                    <i class="bi bi-caret-right-fill"></i>
                                </div>
                            </div>

                            <div class="shadow-lg page-title d-xl-none text-center py-2">
                                <u>
                                    <a href="{{route('dashboard')}}" class="text-primary fw-bold fs-5">
                                        <i class="bi bi-caret-right-fill"></i>
                                        Tableau de Bord
                                    </a>
                                </u>
                            </div>
                        </div>

                        <div class="container-fluid pt-0 ps-0  pe-0">
                            <div class="shadow-lg card" id="accordion-one">
                                <div class="card-header flex-wrap px-3">
                                    <div>
                                        <h6 class="card-title">Dangers / Liste des {{$danger->nomdanger}}</h6>
                                        <p class="m-0 subtitle">Ici vous pouvez voir tous les <strong>{{$danger->nomdanger}}</strong> </p>
                                    </div>
                                    <div class="d-flex">
                                        <ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">
                                            
                                            <li class="nav-item " role="presentation">

                                                <div class="d-flex">
                                                    
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
                                                            <th>Info FDS</th>
                                                            <th>Médias</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($danger->produit->count() <= 0) 
                                                            <tr>
                                                                <td colspan='3'>Aucun {{$danger->nomdanger}}. </td>
                                                            </tr>
                                                        @else
                                                            @foreach ($danger->produit as $prod)
                                                                <tr>
                                                                    <td>
                                                                        <div class="trans-list">
                                                                            <h4>{{$prod->nomprod}}</h4>
                                                                        </div>
                                                                    </td>
                                                                    <td><a href="{{route('product.one', [IdEncryptor::encode($prod->id)])}}"
                                                                            class="btn btn-secondary shadow btn-xs sharp me-1"><i
                                                                                class="bi bi-info-circle-fill"></i></a></td>
                                                                    <td>
                                                                        <div class="d-flex">
                                                                            @include('product.partials.photo')
                                                                            @include('product.partials.fds')
                                                                        </div>
                                                                    </td>
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