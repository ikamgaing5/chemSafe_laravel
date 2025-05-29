<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS principaux -->
    <link href="/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.css">

    <!-- Librairies nécessaires UNIQUEMENT -->
    <link href="/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/jquery-nice-select/css/nice-select.css">


    <!-- jQuery d'abord ! -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        @if (session('successEdit'))
            {!!session('successEdit')!!}
        @endif

        <form action="{{route('product.editPost', $infoproduit->id)}}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PATCH')
            <div class="content-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="shadow-lg card">
                                <div class="card-header">
                                    <h5 class="mb-0">Details du produit</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-4">
                                            <?php
                                                $photoPath = "{{ asset('storage/' . $infoproduit->photo) }}";
                                                $pdfPath = "{{ asset('storage/' . $infoproduit->photo) }}";
                                            ?>
                                            <label style="font-weight: 700;" class="form-label text-primary">Photo<span
                                                    class="required">*</span></label>
                                            <div class="avatar-upload">
                                                <div class="avatar-preview">
                                                    <div id="imagePreview"
                                                        style="background-image: url('{{ asset('storage/' . $infoproduit->photo) }}');">
                                                    </div>
                                                </div>
                                                <input type="file" name="photo" class="form-control d-none"
                                                    accept="image/*" id="imageUpload">
                                                <label style="font-weight: 700;" for="imageUpload"
                                                    class="btn btn-primary mt-2 btn-sm">Choisir la photo</label>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-danger light remove-img ms-2 btn-sm">Retirer</a>
                                            </div>
                                            <span class="fw-bold text-danger" id="messagePhoto"
                                                style="display: none;"></span>
                                        </div>
                                        <div class="col-xl-9 col-lg-8">
                                            <div class="row">
                                                <div class="col-xl-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="exampleFormControlInput1"
                                                            class="form-label text-primary">Nom du produit<span
                                                                class="required">*</span></label>
                                                        <input type="text" class="form-control" name="nomprod" id="nom"
                                                            placeholder="Le nom du produit"
                                                            value="{{$infoproduit->nomprod}}">
                                                        <span class="fw-bold text-danger" id="messageNom"
                                                            style="display: none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;"
                                                            class="form-label text-primary">Emballage et Poids/Volume du
                                                            produit<span class="required">*</span></label>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control"
                                                                    name="type_emballage" placeholder="Type d'Emballage"
                                                                    id="emballage"
                                                                    value="{{$infoproduit->type_emballage}}">
                                                                <span class="fw-bold text-danger" id="messageEmballage"
                                                                    style="display: none;"></span>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control w-50 ms-3"
                                                                    name="poids" id="vol"
                                                                    value="{{$infoproduit->poids}}"
                                                                    placeholder="Vol/Poids">
                                                                <span class="fw-bold text-danger" id="messageVol"
                                                                    style="display: none;"></span>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="exampleFormControlInput1"
                                                            class="form-label text-primary">Danger<span
                                                                class="required">*</span></label>
                                                        <div class="mb-3">
                                                            <select multiple name="danger[]" class="form-control">
                                                                    @foreach ($allDangers as $danger):
                                                                   @if (in_array($danger->id, $selectedIds)):
                                                                
                                                                <option value="{{$danger->id}}" selected>
                                                                    {{$danger->nomdanger}}
                                                                </option>
                                                                @else
                                                                <option value="{{$danger->id}}">
                                                                    {{$danger->nomdanger}}
                                                                </option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                            <span id="messageDanger" class="text-danger fw-bold"
                                                                style="display:none;"></span>
                                                            <span id="message-conflit-danger"
                                                                class="text-danger fw-bold"
                                                                style="display:none;"></span>
                                                        </div>
                                                        <!-- <span class="fw-bold text-danger" id="messageDanger" style="display: none;"></span> -->
                                                    </div>


                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="risque"
                                                            class="form-label text-primary">Risque<span
                                                                class="required">*</span></label>
                                                        <textarea class="form-control" name="risque" id="risque"
                                                            rows="6">{{$infoproduit->risque}}</textarea>
                                                        <span class="fw-bold text-danger" id="messageRisque"
                                                            style="display: none;"></span>
                                                    </div>

                                                </div>
                                                <div class="col-xl-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;"
                                                            class="form-label text-primary">Fabircant et Nature du
                                                            produit<span class="required">*</span></label>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control" name="fabricant"
                                                                    placeholder="Fabricant" id="fabriquant"
                                                                    value="{{$infoproduit->fabricant}}">
                                                                <span class="fw-bold text-danger" id="messageFabriquant"
                                                                    style="display: none;"></span>
                                                            </div>

                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control w-50 ms-3"
                                                                    name="nature" id="nature" placeholder="Nature"
                                                                    value="{{$infoproduit->nature}}">
                                                                <span class="fw-bold text-danger" id="messageNature"
                                                                    style="display: none;"></span>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="utilisation"
                                                            class="form-label text-primary">Utilisation<span
                                                                class="required">*</span></label>
                                                        <textarea class="form-control" name="utilisation"
                                                            id="utilisation"
                                                            rows="6">{{$infoproduit->utilisation}}</textarea>
                                                        <span class="fw-bold text-danger" id="messageUtilisation"
                                                            style="display: none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="DispoFDS"
                                                            class="form-label text-primary">Disponibilité FDS<span
                                                                class="required">*</span></label>
                                                        <div class="mb-3">
                                                            <select
                                                                class="default-select form-control wide form-control-sm"
                                                                name="DispoFDS" id="DispoFDS">
                                                                <option value="oui">OUI</option>
                                                                <option value="non">NON</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3" id="FDSDisplay">

                                                        <label style="font-weight: 700;" class="form-label text-primary">Fichier PDF <span class="required">*</span></label>
                                                        <div class="pdf-upload">
                                                            <div class="pdf-preview mt-2" id="pdfPreview">
                                                                @if (!empty($infoproduit->fds)):
                                                                    <div class="mt-3">
                                                                        <object id="pdfViewer"
                                                                            data="{{ asset('storage/' . $infoproduit->fds) }}"
                                                                            type="application/pdf" width="100%"
                                                                            height="400px" style="border: 1px solid #ccc;">
                                                                        </object>
                                                                    </div>
                                                                @else:
                                                                    <p class="text-danger">Aucun fichier PDF disponible</p>
                                                                @endif
                                                            </div>

                                                            <input type="file" name="fds" class="form-control d-none"
                                                                accept="application/pdf" id="pdfUpload">
                                                            <label style="font-weight: 700;" for="pdfUpload"
                                                                class="btn btn-primary mt-2 btn-sm">Choisir le
                                                                PDF</label>
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-danger light remove-pdf ms-2 btn-sm">Retirer</a>
                                                        </div>
                                                        <span class="fw-bold text-danger" id="messageFDS"
                                                            style="display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    <script>
    $(document).ready(function() {
        // Constantes pour les tailles maximales (en octets)
        const MAX_PHOTO_SIZE = 5 * 1024 * 1024; // 5 Mo
        const MAX_PDF_SIZE = 10 * 1024 * 1024; // 10 Mo

        // Fonction pour formater la taille en Mo
        function formatFileSize(bytes) {
            return (bytes / (1024 * 1024)).toFixed(2) + ' Mo';
        }

        // Gestion dynamique de l'affichage du PDF
        const pdfUrl = "{{ asset('storage/' . $infoproduit->fds) }}";
        if (pdfUrl) {
            $.ajax({
                url: pdfUrl,
                type: 'HEAD',
                success: function() {
                    console.log("PDF accessible.");
                },
                error: function(xhr, status, error) {
                    $('#pdfPreview').html(`
                        <div class="alert alert-danger">
                            <p>Le PDF n'est pas accessible. Erreur : ${error}</p>
                            <p>URL : ${pdfUrl}</p>
                        </div>
                    `);
                }
            });
        }

        // Variables pour suivre l'état des médias
        let hasPhoto = "{{ $infoproduit->photo }}" ? true : false;
        let hasPDF = "{{ $infoproduit->fds }}" ? true : false;
        let photoSizeError = false;
        let pdfSizeError = false;

        // Fonction pour réinitialiser l'aperçu de l'image
        function resetImagePreview() {
            $('#imageUpload').val('');
            $('#imagePreview').css('background-image', 'none');
            $('#messagePhoto').hide();
            hasPhoto = false;
            photoSizeError = false;
            validateForm();
        }

        // Fonction pour réinitialiser l'aperçu du PDF
        function resetPdfPreview() {
            $('#pdfUpload').val('');
            $('#pdfPreview').html('<p class="text-danger">Aucun fichier PDF disponible</p>');
            $('#messageFDS').hide();
            hasPDF = false;
            pdfSizeError = false;
            validateForm();
        }

        // Gestionnaire pour le changement de photo
        $('#imageUpload').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (allowedTypes.includes(file.type)) {
                    if (file.size <= MAX_PHOTO_SIZE) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#imagePreview').css('background-image', `url(${e.target.result})`);
                            $('#messagePhoto').hide();
                            hasPhoto = true;
                            photoSizeError = false;
                            validateForm();
                        };
                        reader.readAsDataURL(file);
                    } else {
                        photoSizeError = true;
                        $('#messagePhoto').show().text(
                            `La taille de l'image ne doit pas dépasser 5 Mo. Taille actuelle : ${formatFileSize(file.size)}`
                        );
                        resetImagePreview();
                    }
                } else {
                    photoSizeError = false;
                    $('#messagePhoto').show().text(
                        'Format d\'image non valide. Utilisez JPG, PNG ou GIF');
                    resetImagePreview();
                }
            } else {
                hasPhoto = false;
                photoSizeError = false;
                validateForm();
            }
        });

        // Gestionnaire pour le changement de PDF
        $('#pdfUpload').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.type === 'application/pdf') {
                    if (file.size <= MAX_PDF_SIZE) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#pdfPreview').html(`
                                <div class="mt-3">
                                    <object data="${e.target.result}" type="application/pdf" width="100%" height="400px" style="border: 1px solid #ccc;">
                                    </object>
                                </div>
                            `);
                            $('#messageFDS').hide();
                            hasPDF = true;
                            pdfSizeError = false;
                            validateForm();
                        };
                        reader.readAsDataURL(file);
                    } else {
                        pdfSizeError = true;
                        $('#messageFDS').show().text(
                            `La taille du PDF ne doit pas dépasser 10 Mo. Taille actuelle : ${formatFileSize(file.size)}`
                        );
                        resetPdfPreview();
                    }
                } else {
                    pdfSizeError = false;
                    $('#messageFDS').show().text('Format de fichier non valide. Utilisez PDF');
                    resetPdfPreview();
                }
            } else {
                hasPDF = false;
                pdfSizeError = false;
                validateForm();
            }
        });

        // Bouton "Retirer" pour l'image
        $('.remove-img').on('click', function(e) {
            e.preventDefault();
            resetImagePreview();
        });

        // Bouton "Retirer" pour le PDF
        $('.remove-pdf').on('click', function(e) {
            e.preventDefault();
            resetPdfPreview();
        });

        // Validation en temps réel des champs
        function validateField(field, messageId, message) {
            const value = $(field).val().trim();
            const isValid = value !== '';
            $(messageId).toggle(!isValid).text(message);
            return isValid;
        }

        // Fonction de validation complète du formulaire
        function validateForm() {
            let isValid = true;

            // Validation des champs obligatoires
            isValid = validateField('#nom', '#messageNom', 'Le nom du produit est requis') && isValid;
            isValid = validateField('#emballage', '#messageEmballage', 'Le type d\'emballage est requis') &&
                isValid;
            isValid = validateField('#vol', '#messageVol', 'Le volume/poids est requis') && isValid;
            isValid = validateField('#fabriquant', '#messageFabriquant', 'Le fabricant est requis') && isValid;
            isValid = validateField('#nature', '#messageNature', 'La nature du produit est requise') && isValid;
            isValid = validateField('#risque', '#messageRisque', 'Le risque est requis') && isValid;
            isValid = validateField('#utilisation', '#messageUtilisation', 'L\'utilisation est requise') &&
                isValid;

            // Validation des dangers
            const dangers = $('select[name="danger[]"]').val();
            $('#messageDanger').toggle(!dangers || dangers.length === 0).text(
                'Veuillez sélectionner au moins un danger');
            isValid = isValid && dangers && dangers.length > 0;

            // Validation de la photo
            if (photoSizeError) {
                // Si erreur de taille, on garde le message d'erreur de taille
                isValid = false;
            } else if (!hasPhoto) {
                $('#messagePhoto').show().text('La photo est requise');
                isValid = false;
            } else {
                $('#messagePhoto').hide();
            }

            // Validation du PDF si requis
            const pdfRequired = $('#DispoFDS').val() === 'oui';
            if (pdfRequired) {
                if (pdfSizeError) {
                    // Si erreur de taille, on garde le message d'erreur de taille
                    isValid = false;
                } else if (!hasPDF) {
                    $('#messageFDS').show().text('Le PDF est requis');
                    isValid = false;
                } else {
                    $('#messageFDS').hide();
                }
            }

            // Désactiver/Activer le bouton de soumission
            $('#submitBtn').prop('disabled', !isValid);

            return isValid;
        }

        // Validation avant envoi du formulaire
        $('form').on('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $(".card-body").offset().top - 100
                }, 400);
            }
        });

        // Validation en temps réel des champs
        $('input, textarea, select').on('input change', function() {
            validateForm();
        });

        // Validation initiale
        validateForm();
    });
    </script>