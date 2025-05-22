<?php
$linkedDangers = $infoproduit->danger;

// On extrait les IDs avec pluck
$selectedIds = $linkedDangers->pluck('id')->toArray();

$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if (strpos($current_page, 'product/edit') === 0) {
    $message = "<span class='fs-4'> Modificaion du Produit " . $infoproduit->nomprod . "</span>";
}

// die();
?>


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


        <form action="{{route('product.editPost', $infoproduit->id)}}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PATCH')
            <div class="content-body">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                            if (isset($_SESSION['insert']['type'])) {
                                switch ($_SESSION['insert']['type']) {
                                    case "insertfalse":
                                        echo $package->message("Problème lors de l'insertion", "danger");
                                        break;
                                    case "updateok":
                                        echo $package->message("Le produit a été modifié avec succès", "success");
                                        break;
                                    case "updatefailed":
                                        echo $package->message("Problème lors de la modification", "danger");
                                        break;
                                    case "extension":
                                        echo $package->message("L'extension de l'image n'est pas valide", "danger");
                                        break;
                                    case "doublonProduit":
                                        echo $package->message("Ce produit existe déjà", "danger");
                                        break;
                                    case "erreur uploadphoto":
                                        echo $package->message("Problème lors de l'envoi de la photo", "danger");
                                        break;
                                    case "volumineux":
                                        echo $package->message("Fichier trop volumineux", "danger");
                                        break;
                                    case "doublonPhoto":
                                        $nomproduit = isset($_SESSION['insert']['insert']) ? $_SESSION['insert']['insert'] : '';
                                        echo $package->message("Cette photo est déjà associée au produit <strong>$nomproduit</strong>", "danger");
                                        break;
                                    case "erreur upload fds":
                                        echo $package->message("Erreur lors de la sauvegarde de la FDS", "danger");
                                        break;
                                    case "extensionFDS":
                                        echo $package->message("Veuillez choisir un fichier d'extension <strong>.pdf</strong>", "danger");
                                        break;
                                    case "doublonsFDS":
                                        $nomproduitFDS = isset($_SESSION['insert']['insert']) ? $_SESSION['insert']['insert'] : '';
                                        echo $package->message("Cette FDS est déjà associée au produit <strong>$nomproduitFDS</strong>", "danger");
                                        break;
                                }
                            }
                            unset($_SESSION['insert']);
                        ?>
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
                                                    <div id="imagePreview" style="background-image: url('{{ asset('storage/' . $infoproduit->photo) }}');"></div>
                                                </div>
                                                <input type="file" name="photo" class="form-control d-none"
                                                    accept="image/*" id="imageUpload">
                                                <label style="font-weight: 700;" for="imageUpload"
                                                    class="btn btn-primary mt-2 btn-sm">Choisir la photo</label>
                                                <a href="javascript:void" class="btn btn-danger light remove-img ms-2 btn-sm">Retirer</a>
                                            </div>
                                            <span class="fw-bold text-danger" id="messagePhoto" style="display: none;"></span>
                                        </div>
                                        <div class="col-xl-9 col-lg-8">
                                            <div class="row">
                                                <div class="col-xl-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="exampleFormControlInput1"
                                                            class="form-label text-primary">Nom du produit<span
                                                                class="required">*</span></label>
                                                        <input type="text" class="form-control" name="nomprod" id="nom"
                                                            placeholder="Le nom du produit" value="{{$infoproduit->nomprod}}">
                                                        <span class="fw-bold text-danger" id="messageNom"
                                                            style="display: none;"></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;"
                                                            class="form-label text-primary">Emballage et Poids/Volume du
                                                            produit<span class="required">*</span></label>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control" name="type_emballage"
                                                                    placeholder="Type d'Emballage" id="emballage" value="{{$infoproduit->type_emballage}}">
                                                                <span class="fw-bold text-danger" id="messageEmballage"
                                                                    style="display: none;"></span>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control w-50 ms-3"
                                                                    name="poids" id="vol" value="{{$infoproduit->poids}}" placeholder="Vol/Poids">
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
                                                                <?php foreach ($allDangers as $danger): ?>
                                                                <?php if (in_array($danger['id'], $selectedIds)) { ?>
                                                                <option value="<?= $danger['id'] ?>" selected>
                                                                    <?= htmlspecialchars($danger['nomdanger']) ?>
                                                                </option>
                                                                <?php } else { ?>
                                                                <option value="<?= $danger['id'] ?>">
                                                                    <?= htmlspecialchars($danger['nomdanger']) ?>
                                                                </option>
                                                                <?php } ?>
                                                                <?php endforeach; ?>
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
                                                                <input type="text" class="form-control"
                                                                    name="fabricant" placeholder="Fabricant"
                                                                    id="fabriquant" value="{{$infoproduit->fabricant}}">
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
                                                            id="utilisation" rows="6">{{$infoproduit->utilisation}}</textarea>
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

                                                        <label style="font-weight: 700;"
                                                            class="form-label text-primary">Fichier PDF <span
                                                                class="required">*</span></label>
                                                        <div class="pdf-upload">
                                                            <div class="pdf-preview mt-2" id="pdfPreview">
                                                                <?php if (!empty($infoproduit['fds'])): ?>

                                                                <div class="mt-3">
                                                                    <object id="pdfViewer" data="{{ asset('storage/' . $infoproduit->fds) }}"
                                                                        type="application/pdf" width="100%"
                                                                        height="400px" style="border: 1px solid #ccc;">
                                                                    </object>
                                                                </div>
                                                                <?php else: ?>
                                                                <p class="text-danger">Aucun fichier PDF disponible</p>
                                                                <?php endif; ?>
                                                            </div>

                                                            <input type="file" name="fds"
                                                                class="form-control d-none" accept="application/pdf"
                                                                id="pdfUpload">
                                                            <span id="messageFDS" class="text-danger fw-bold"
                                                                style="display:none;"></span>
                                                            <label style="font-weight: 700;" for="pdfUpload"
                                                                class="btn btn-primary mt-2 btn-sm">Choisir le
                                                                PDF</label>
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-danger light remove-pdf ms-2 btn-sm">Retirer</a>
                                                        </div>
                                                        <span class="fw-bold text-danger" id="messageFDS" style="display: none;"></span>
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
    $(document).ready(function () {
        // Gestion dynamique de l'affichage du PDF
        const pdfUrl = "{{ asset('storage/' . $infoproduit->fds) }}";
        if (pdfUrl) {
            $.ajax({
                url: pdfUrl,
                type: 'HEAD',
                success: function () {
                    console.log("PDF accessible.");
                },
                error: function (xhr, status, error) {
                    $('#pdfPreview').html(`
                        <div class="alert alert-danger">
                            <p>Le PDF n'est pas accessible. Erreur : ${error}</p>
                            <p>URL : ${pdfUrl}</p>
                        </div>
                    `);
                }
            });
        }
    
        // Validation avant envoi du formulaire
        $('form').on('submit', function (e) {
            let isValid = true;
    
            // Nom du produit
            const nom = $('#nom').val().trim();
            $('#messageNom').toggle(nom === '').text('Le nom du produit est requis');
            isValid = isValid && nom !== '';
    
            // Type d'emballage
            const emballage = $('#emballage').val().trim();
            $('#messageEmballage').toggle(emballage === '').text('Le type d\'emballage est requis');
            isValid = isValid && emballage !== '';
    
            // Volume/Poids
            const vol = $('#vol').val().trim();
            $('#messageVol').toggle(vol === '').text('Le volume/poids est requis');
            isValid = isValid && vol !== '';
    
            // Dangers
            const dangers = $('select[name="danger[]"]').val();
            $('#messageDanger').toggle(!dangers || dangers.length === 0).text('Veuillez sélectionner au moins un danger');
            isValid = isValid && dangers && dangers.length > 0;
    
            // Risque
            const risque = $('#risque').val().trim();
            $('#messageRisque').toggle(risque === '').text('Le risque est requis');
            isValid = isValid && risque !== '';
    
            // Fabricant
            const fabriquant = $('#fabriquant').val().trim();
            $('#messageFabriquant').toggle(fabriquant === '').text('Le fabricant est requis');
            isValid = isValid && fabriquant !== '';
    
            // Nature
            const nature = $('#nature').val().trim();
            $('#messageNature').toggle(nature === '').text('La nature du produit est requise');
            isValid = isValid && nature !== '';
    
            // Utilisation
            const utilisation = $('#utilisation').val().trim();
            $('#messageUtilisation').toggle(utilisation === '').text('L\'utilisation est requise');
            isValid = isValid && utilisation !== '';
    
            // Photo - format de fichier
            const photoInput = $('#imageUpload')[0];
            if (photoInput.files.length > 0) {
                const file = photoInput.files[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const isImageValid = allowedTypes.includes(file.type);
                $('#messagePhoto').toggle(!isImageValid).text('Format d\'image non valide. Utilisez JPG, PNG ou GIF');
                isValid = isValid && isImageValid;
            }
    
            // PDF - s'il est requis et nouveau fichier choisi
            const pdfRequired = $('#DispoFDS').val() === 'oui';
            const pdfInput = $('#pdfUpload')[0];
            if (pdfRequired && pdfInput.files.length > 0) {
                const file = pdfInput.files[0];
                const isPdfValid = file.type === 'application/pdf';
                $('#messageFDS').toggle(!isPdfValid).text('Format de fichier non valide. Utilisez PDF');
                isValid = isValid && isPdfValid;
            }
    
            // Si invalides, empêcher l'envoi
            if (!isValid) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $(".card-body").offset().top - 100
                }, 400);
            }
        });
    
        // Bouton "Retirer" pour l'image
        $('.remove-img').on('click', function () {
            $('#imageUpload').val('');
            $('#imagePreview').css('background-image', 'none');
        });
    
        // Bouton "Retirer" pour le PDF
        $('.remove-pdf').on('click', function () {
            $('#pdfUpload').val('');
            $('#pdfPreview').html('<p class="text-danger">Aucun fichier PDF sélectionné</p>');
        });
    });
    </script>
    
 