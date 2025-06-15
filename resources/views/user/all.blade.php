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
                        <div class="shadow-lg page-title flex-wrap d-none d-xl-block">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div>
                                    <u><a class="text-primary fw-bold fs-5" href="{{route('dashboard')}}">Tableau de
                                            bord</a></u>
                                    <i class="bi bi-caret-right-fill"></i>
                                    @if (Auth::user()->role == "superadmin")
                                        <u>
                                            <a href="{{route('all-factorie')}}" class="text-primary fw-bold fs-5">
                                                Nos Usines
                                            </a>
                                        </u>
                                        <i class="bi bi-caret-right-fill"></i>
                                    @endif
                                    
                                </div>
                            </div>

                            <div class="shadow-lg page-title d-xl-none text-center py-2">

                                <u><a href="/workshop/all-workshop" class="text-primary fw-bold fs-5"><i
                                            class="bi bi-caret-right-fill"></i>
                                        Nos Ateliers
                                    </a></u>
                            </div>
                        </div>

                        <div id="alertContainer"></div>
                            
                            
                        </div>
                        <livewire:user-list />
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
    <script>
        window.addEventListener('entityAddedSuccess', event => {
            let detail = event.detail;

            // Tenter d'accéder aux données de différentes manières
            let type = (detail[0].type) || undefined;
            let message = (detail[0].message) || undefined;

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
            const modalEl = document.getElementById('deleteModal');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);

            // Délai pour s'assurer que le focus quitte l'input avant que le modal soit caché
            setTimeout(() => {
                modal.hide();

                // Déplacer le focus ailleurs (par ex. sur un bouton de la page)
                document.activeElement.blur();
            }, 100);
        });

        window.addEventListener('open-delete-modal', () => {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            console.log('modal delete')
            modal.show();
        });
    </script>

    <script src="{{asset('vendor/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/global/global.min.js')}}"></script>
    <script src="{{asset('js/custom.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    {{--
    <script src="{{asset('vendor/apexchart/apexchart.js')}}"></script> --}}
    <script src="{{asset('vendor/peity/jquery.peity.min.js')}}"></script>
    <script src="{{asset('vendor/jquery-nice-select/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('vendor/swiper/js/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/plugins-init/datatables.init.js')}}"></script>
    {{--
    <script src="{{asset('js/dashboard/dashboard-1.js')}}"></script> --}}
    <script src="{{asset('vendor/wow-master/dist/wow.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-datetimepicker/js/moment.js')}}"></script>
    <script src="{{asset('vendor/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-select-country/js/bootstrap-select-country.min.js')}}"></script>
    <script src="{{asset('js/dlabnav-init.js')}}"></script>
    {{--
    <script src="{{asset('js/demo.js')}}"></script> --}}
    <script src="{{asset('js/all.js')}}"></script>
</body>

</html>