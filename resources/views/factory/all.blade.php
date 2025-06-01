<?php
// dd($IdEncryptor);
$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($current_page == 'factory/all-factory') {
	$message = 'Liste des Usines.';
}
// dd($AllUsine->ateliers);
// die();

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

                <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addModal">
                    + Ajouter une Usine
                </button>
                <livewire:add-entity-modal :entity-type="'usine'" />
                <!-- Row -->
                <div class="row">
                    <div id="alertContainer"></div>
                    @if (session('error'))
                    {!! session('error') !!}
                    @endif
                    @if (session('okay'))
                    {!! session('okay') !!}
                    @elseif (session('samename'))
                    {!! session('samename') !!}
                    @elseif (session('updateokay'))
                    {!! session('updateokay') !!}
                    @elseif (session('successadd'))
                    {!!session('successadd')!!}
                    @elseif (session('erroradd'))
                    {!! session('erroradd') !!}
                    @endif

                    <livewire:usine-list :IdEncryptor="$IdEncryptor" />

                    <livewire:edit-entity-modal />
                    <livewire:delete-entity-modal />
                </div>
            </div>
        </div>

    </div>



    <script>
        window.addEventListener('close-modal', () => {
            const modalEl = document.getElementById('addModal');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);

            // Délai pour s'assurer que le focus quitte l'input avant que le modal soit caché
            setTimeout(() => {
                modal.hide();

                // Déplacer le focus ailleurs (par ex. sur un bouton de la page)
                document.activeElement.blur();
            }, 100);
        });

        window.addEventListener('entityAddedSuccess', event => {
            let detail = event.detail;

            // Tenter d'accéder aux données de différentes manières
            let type = (detail[0].type) || undefined;
            let message = (detail[0].message) || undefined;

            console.log(detail)
            if (type === undefined || message === undefined) {
                console.error('Could not extract type or message from event.detail');
                return; // Ne pas continuer si les données manquent
            }

            const icon = type === 'success' ?
                `<svg viewBox='0 0 24 24' width='24' height='24' stroke='currentColor' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round' class='me-2'><polyline points='9 11 12 14 22 4'></polyline><path d='M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11'></path></svg>` :
                `<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>`;

            const alertHTML = `
            <div class='mx-1'>
                <div class='alert alert-${type} solid alert-dismissible fade show'>
                    ${icon} <strong>${type === 'success' ? 'Succès' : 'Échec'} !</strong> ${message} !
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='btn-close'></button>
                </div>
            </div>`;

            const container = document.createElement('div');
            container.innerHTML = alertHTML;

            // Insérer l'alerte dans le conteneur dédié
            const alertContainer = document.getElementById('alertContainer');
            if (alertContainer) {
                alertContainer.innerHTML = ''; // Nettoyer le conteneur
                alertContainer.appendChild(container);
            } else {
                document.body.prepend(container);
            }

            // Supprimer l'alerte après 10 secondes
            setTimeout(() => {
                container.remove();
            }, 10000);
        });

        window.addEventListener('close-modal', () => {
            const modalEl = document.getElementById('editModal');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);

            // Délai pour s'assurer que le focus quitte l'input avant que le modal soit caché
            setTimeout(() => {
                modal.hide();

                // Déplacer le focus ailleurs (par ex. sur un bouton de la page)
                document.activeElement.blur();
            }, 100);
        });

        window.addEventListener('close-modal', () => {
            const modalEl = document.getElementById('deleteModal');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);

            // Délai pour s'assurer que le focus quitte l'input avant que le modal soit caché
            setTimeout(() => {
                modal.hide();

                // Déplacer le focus ailleurs (par ex. sur un bouton de la page)
                document.activeElement.blur();
            }, 100);
        });
    
        window.addEventListener('open-edit-modal', () => {
            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        });

        window.addEventListener('open-delete-modal', () => {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            console.log('modal delete')
            modal.show();
        });
    </script>

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


</html>