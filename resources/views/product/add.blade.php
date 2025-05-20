<?php
// dd($usine);

$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($current_page == 'product/new-product') {
    $message = 'Ajouter un nouveau produit.';
}
// $message = 'Ajouter un nouveau produit.';
if (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "doublonPhoto") {
    $photo = $_SESSION['insert']['insert'];
    $nomproduit = $produit->getNameByPhoto($conn, $photo);
}

if (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "doublonsFDS") {
    $fds = $_SESSION['insert']['insert'];
    $nomproduitFDS = $produit->getNameByFDS($conn, $fds);
}

if (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "insertok") {
    if (isset($_SESSION['insert']['info']) && $_SESSION['insert']['info']['DispoFDS'] == 'oui') {
        $id = $_SESSION['insert']['id'];
    }


}
// die();
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
        
        <form action="{{route('product.addPost')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="content-body">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        if (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "insertfalse") {
                            $message = "Problème lors de l'insertion";
                            echo $package->message($message, "danger");
                        } elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "insertok") {
                            $message = "Le produit a été ajoutée, n'oubliez pas d'enregistrer sa FDS dès que possible";
                            echo $package->message($message, "success");
                        } elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "doublonProduit") {
                            $message = "Ce Produit existe déjà ";
                            echo $package->message($message, "danger");
                            // 
                            // echo $package -> message($message,$type);
                        } elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "erreur uploadphoto") {
                            $message = "Problème lors de l'envoie de la photo";
                            echo $package->message($message, "danger");
                        } elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "volumineux") {
                            $message = "Fichier trop volumineux";
                            echo $package->message($message, "danger");
                        } elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "doublonPhoto") {
                            $message = "Cette photo est déjà associée au produit <strong>$nomproduit</strong>";
                            echo $package->message($message, "danger");
                        } elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "erreur upload fds") {
                            $message = "Erreur lors de la sauvegarde de la FDS";
                            echo $package->message($message, "danger");
                        } elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "extensionFDS") {
                            $message = "Veuillez choisir un fichier d'extendion <strong>.pdf</strong>";
                            echo $package->message($message, "danger");
                        } elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == "doublonsFDS") {
                            $message = "Cette FDS est déjà associée au produit <strong>$nomproduitFDS</strong>";
                            echo $package->message($message, "danger");
                        }
                        ?>

                        <div class="col-xl-12">
                            <div class="shadow-lg card">
                                <div class="card-header">
                                    <h5 class="mb-0">Details du produit</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-4">
                                            <label style="font-weight: 700;" class="form-label text-primary">Photo<span
                                                    class="required">*</span></label>
                                            <div class="avatar-upload">
                                                <div class="avatar-preview">
                                                    <div id="imagePreview"
                                                        style="background-image: url(images/no-img-avatar.png);">
                                                    </div>
                                                </div>


                                                <input type="file" required name="photo"
                                                    class="form-control d-none" accept="image/*" id="photo">
                                                <label style="font-weight: 700;" for="photo"
                                                    class="btn btn-primary mt-2 btn-sm">Choisir la photo</label>
                                                <a href="javascript:void"
                                                    class="btn btn-danger light remove-img ms-2 btn-sm">Retirer</a>

                                            </div>
                                        </div>
                                        <div class="col-xl-9 col-lg-8">
                                            <div class="row">
                                                <div class="col-xl-6 col-sm-6">
                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="exampleFormControlInput1"
                                                            class="form-label text-primary">Nom du produit<span
                                                                class="required">*</span></label>
                                                        <input type="text" class="form-control" name="nomprod" id="nom"
                                                            placeholder="Le nom du produit" value="<?php if (isset($_SESSION['insert']['info'])) {
                                                                echo $_SESSION['insert']['info']['nom'];
                                                            } ?>">
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
                                                                    placeholder="Type d'Emballage" id="emballage" value="<?php if (isset($_SESSION['insert']['info'])) {
                                                                        echo $_SESSION['insert']['info']['emballage'];
                                                                    } ?>">
                                                                <span class="fw-bold text-danger" id="messageEmballage"
                                                                    style="display: none;"></span>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control w-50 ms-3"
                                                                    name="poids" id="vol" value="<?php if (isset($_SESSION['insert']['info'])) {
                                                                        echo $_SESSION['insert']['info']['vol'];
                                                                    } ?>" placeholder="Vol/Poids">
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
                                                            <select multiple
                                                                class="default-select form-control wide form-control-sm"
                                                                name="danger[]" id="danger">
                                                                <option value="none">Faites votre choix</option>
                                                                @foreach ($danger as $dangers)
                                                                    <option value="{{ $dangers->id }}">{{ $dangers->nomdanger }}</option>
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
                                                        <label style="font-weight: 700;" for="exampleFormControlInput1"
                                                            class="form-label text-primary">Atelier d'utilisation<span
                                                                class="required">*</span></label>
                                                        <div class="mb-3">
                                                            <select multiple
                                                                class="default-select form-control wide form-control-sm"
                                                                name="atelier[]" id="atelier">
                                                                <option value="none">Faites votre choix</option>
                                                                @foreach ($ateliers as $atelier)
                                                                    <option value="{{ $atelier->id }}">{{ $atelier->nomatelier }} de l'{{$atelier->usine->nomusine}}</option>
                                                                @endforeach

                                                            </select>
                                                            <span id="messageAtelier" class="text-danger fw-bold"
                                                                style="display:none;"></span>
                                                        </div>

                                                    </div>


                                                    <div class="mb-3">
                                                        <label style="font-weight: 700;" for="risque"
                                                            class="form-label text-primary">Risque<span
                                                                class="required">*</span></label>
                                                        <textarea class="form-control" name="risque" id="risque"
                                                            rows="6"> <?php if (isset($_SESSION['insert']['info'])) {
                                                                echo $_SESSION['insert']['info']['risque'];
                                                            } ?></textarea>
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
                                                                    id="fabriquant" value="<?php if (isset($_SESSION['insert']['info'])) {
                                                                        echo $_SESSION['insert']['info']['fabriquant'];
                                                                    } ?>">
                                                                <span class="fw-bold text-danger" id="messageFabriquant"
                                                                    style="display: none;"></span>
                                                            </div>

                                                            <div class="d-flex flex-column">
                                                                <input type="text" class="form-control w-50 ms-3"
                                                                    name="nature" id="nature" placeholder="Nature"
                                                                    value="<?php if (isset($_SESSION['insert']['info'])) {
                                                                        echo $_SESSION['insert']['info']['nature'];
                                                                    } ?>">
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
                                                            id="utilisation" rows="6"><?php if (isset($_SESSION['insert']['info'])) {
                                                                echo $_SESSION['insert']['info']['utilisation'];
                                                            } ?></textarea>
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
                                                            <div class="pdf-preview mt-2" id="pdfPreview"
                                                                style="display: none;">
                                                                <iframe id="pdfViewer" src="" width="100%"
                                                                    height="400px"
                                                                    style="border: 1px solid #ccc;"></iframe>
                                                            </div>

                                                            <input type="file" name="fds"
                                                                class="form-control d-none" accept="application/pdf"
                                                                id="fds">
                                                            <span id="messageFDS" class="text-danger fw-bold"
                                                                style="display:none;"></span>
                                                            <label style="font-weight: 700;" for="fds"
                                                                class="btn btn-primary mt-2 btn-sm">Choisir le
                                                                PDF</label>
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-danger light remove-pdf ms-2 btn-sm">Retirer</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-end ">
                                        <button type="submit" id="submitBtn" class="btn btn-primary"
                                            disabled>Soumettre</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <?php unset($_SESSION['photo'], $_SESSION['insert']) ?>



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
    <script src="{{asset('js/new-product.js')}}"></script>


    <?php
    if (isset($_SESSION['photo']['photo'])) {
        echo $photo = $_SESSION['photo']['photo'];
    }


    ?>