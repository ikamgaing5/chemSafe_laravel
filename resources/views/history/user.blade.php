<?php 

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
                    <?php  
                        foreach ($all as $key) {
                    ?>
                        <div class="col-xl-12">
                            <div class="container-fluid pt-0 ps-0  pe-0">		
                                <div class="shadow-lg card" id="accordion-one">
                                    <div class="card-header flex-wrap px-3">
                                        <div>
                                            <h6 class="card-title">Historique / Historique d'accès à ChemSafe</h6>
                                            <p class="m-0 subtitle">Ici vous pouvez voir toutes les connexions à ChemSafe</p>
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
                                                                <th>Nom de l'utilisateur</th>
                                                                <th>Date</th>
                                                                <th>Heure</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($key->historique_acces as $keys)
                                                            <tr>
                                                                <td>
                                                                    <div class="trans-list">
                                                                        <h4>{{$key->name}}</h4>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="text-primary font-w600">
                                                                        {{$AlertHelper->afficheDate($keys->created_at)}}
                                                                    </span>
                                                                </td>
                                                                
                                                                <td><span class="text-primary font-w600">{{date('H\hi', strtotime($keys->time))}}</span></td>
                                                                <td>
                                                                    <div class="mb-0">{{$keys->action}}</div>
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
                        </div>	
                    <?php } ?>
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