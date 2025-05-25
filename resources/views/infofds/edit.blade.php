<?php

$nom = "";
$nom = $fds->produit->nomprod;

$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if (strpos($current_page, 'info-fds/edit') === 0) {
    $message = "Modification des informations de la FDS du produit $nom.";
}

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

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" />

    <link href="/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/vendor/swiper/css/swiper-bundle.min.css">


    <link href="/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.css">
    <script src="/js/all.js"></script>
    <style>
        @font-face {
            font-family: 'Material Icons';
            font-style: normal;
            font-weight: 400;
            src: url(flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2) format('woff2');
        }

        .material-icons {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
        }

        html,
        body {
            height: auto !important;
            overflow-y: auto !important;
        }

        * {
            overflow: visible;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>

</head>
<script>
    window.addEventListener('load', () => {
        document.body.style.overflowY = 'auto';
        document.documentElement.style.overflow = 'auto';
        document.querySelectorAll('*').forEach(el => {
            const style = getComputedStyle(el);
            if (style.overflow === 'hidden' || style.overflowY === 'hidden') {
                el.style.overflow = 'visible';
                el.style.overflowY = 'auto';
            }
        });
    });
</script>

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

        @if (session('updateSuccess'))
            {{session('updateSuccess')}}
        @endif
        
        <form action="{{route('infofds.editPost', $fds->id)}}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PATCH')
            <div class="content-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="shadow-lg card">
                                <div class="card-header">
                                    <h5 class="mb-0">Informations de la FDS du produit </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row gx-5">
                                        <div class="col-12">
                                            <div class="row">

                                                <!-- Colonne gauche -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        {{-- <input type="hidden" name="idatelier" value="{{$idatelier}}"> --}}
                                                        <label class="form-label text-primary fw-bold">Danger Physique
                                                            <span class="required">*</span></label>
                                                        <textarea class="form-control" id="physique" name="physique"
                                                         rows="6">{{$fds->physique}}</textarea>
                                                        <span class="fw-bold text-danger" id="messageNom"
                                                            style="display: none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-primary fw-bold">Danger pour la santé <span class="required">*</span></label>
                                                        <textarea class="form-control" id="sante" name="sante"  rows="6">{{$fds->sante}}</textarea>
                                                        <span class="fw-bold text-danger" id="messageUtilisation"
                                                            style="display: none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-primary fw-bold">Caractéristiques
                                                            des PPT chimiques <span class="required">*</span></label>
                                                        <textarea class="form-control" id="ppt" name="ppt" rows="6">{{$fds->ppt}}</textarea>
                                                        <span id="messageDanger" class="text-danger fw-bold"
                                                            style="display:none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-primary fw-bold">Stabilité <span class="required">*</span></label>
                                                        <textarea class="form-control" id="stabilite" name="stabilite" rows="6">{{$fds->stabilite}}</textarea>
                                                        <span id="messageAtelier" class="text-danger fw-bold"
                                                            style="display:none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-primary fw-bold">Conditions à
                                                            éviter<span class="required">*</span></label>
                                                        <textarea class="form-control" name="eviter" id="eviter" rows="6">{{$fds->eviter}}</textarea>
                                                        <span class="fw-bold text-danger" id="messageRisque"
                                                            style="display: none;"></span>
                                                    </div>
                                                </div>

                                                <!-- Colonne droite -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label text-primary fw-bold">Matériaux
                                                            incompatibles <span class="required">*</span></label>
                                                        <textarea class="form-control" id="incompatible" name="incompatible" rows="4">{{$fds->incompatible}}</textarea>
                                                        <span class="fw-bold text-danger" id="messageUtilisation"
                                                            style="display: none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-primary fw-bold">Réactivité <span class="required">*</span></label>
                                                        <textarea class="form-control" id="reactivite" name="reactivite" rows="4">{{$fds->reactivite}}</textarea>
                                                        <span class="fw-bold text-danger" id="messageUtilisation"  style="display: none;"></span>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label class="form-label text-primary fw-bold">Manipulation /
                                                            Stockage<span class="required">*</span></label>
                                                        <textarea class="form-control" id="manipulation" name="stockage" rows="6">{{$fds->stockage}}</textarea>
                                                        <span class="fw-bold text-danger" id="messageUtilisation"
                                                            style="display: none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-primary fw-bold">Premiers
                                                            secours<span class="required">*</span></label>
                                                        <textarea class="form-control" id="secours" name="secours" rows="6">{{$fds->secours}}</textarea>
                                                        <span class="fw-bold text-danger" id="messageUtilisation"
                                                            style="display: none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-primary fw-bold">EPI<span  class="required">*</span></label>
                                                        <textarea class="form-control" id="epi" name="epi"  rows="6">{{$fds->epi}}</textarea>
                                                        <span class="fw-bold text-danger" id="messageUtilisation"
                                                            style="display: none;"></span>
                                                    </div>
                                                </div>

                                            </div> <!-- Fin .row interne -->
                                        </div> <!-- Fin col-12 -->
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        <button type="submit" id="submitBtn" class="btn btn-primary">Soumettre</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

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