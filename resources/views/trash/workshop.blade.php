<?php

// dd($allWorkshops)

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/vendor/wow-master/css/libs/animate.css" rel="stylesheet">
        <link href="/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/vendor/bootstrap-select-country/css/bootstrap-select-country.min.css">
        <link rel="stylesheet" href="/vendor/jquery-nice-select/css/nice-select.css">
        <link href="/vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" />
        
        <link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="/vendor/swiper/css/swiper-bundle.min.css">

        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/all-product.css">
        <link rel="stylesheet" href="/css/all.css">
        <script src="/js/all.js"></script>

            
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
                    <div class="demo-view">
                    
                        <div class="col-xl-12">
                            <div class="container-fluid pt-0 ps-0  pe-0">		
                                <div class="shadow-lg card" id="accordion-one">
                                    <div class="card-header flex-wrap px-3">
                                        <div>
                                            <h6 class="card-title">Corbeille / Corbeille d'atelier</h6>
                                            <p class="m-0 subtitle">Ici vous pouvez voir toutes les suppresions d'atelier des 30 derniers jours.</p>
                                        </div>
                                    </div>
                                    <!--tab-content-->
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="Preview" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="shadow-lg card-body p-0">
                                                <div class="table-responsive">
                                                    <table id="basic-btn"  class="display table table-striped" style="min-width: 845px">
                                                        <thead>
                                                            <tr>
                                                                <th>Supprimé par</th>
                                                                <th>Date et heure</th>
                                                                <th>Nom de l'atelier</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($allWorkshops->count() <= 0)
                                                                <td colspan="4">Aucun élément dans la corbeille des ateliers</td>
                                                            @else
                                                                @foreach ($allWorkshops as $keys)
                                                                <tr>
                                                                    <td>
                                                                        <div class="trans-list">
                                                                            <h4>
                                                                                {{$keys->userr->name}}
                                                                            </h4>
                                                                        </div>
                                                                    </td>
                                                                    <td><span class="text-primary font-w600">{{($keys->created_at)}}</span></td>
                                                                    
                                                                    <td><span class="text-primary font-w600">{{$keys->atelier->nomatelier}}</span></td>
                                                                    <div class="d-flex">
                                                                        <td>
                                                                            <div class="mb-0">récupérer</div>
                                                                            @include('trash.partials.deleteworkshop')
                                                                        </td>
                                                                    </div>
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
    </body>
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