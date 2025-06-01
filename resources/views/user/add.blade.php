<?php
// une vérfication du role doit être faite pour pouvoir choisir le type d'utilisateur à créer, si le role est admin alors il y'aura une liste déroulante pour soit un rh soit un membre de la sécurité et si le role est rh alors le type d'utilisateur sera figé sur user on va utiliser un if

?>

<?php
$current_page = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($current_page == 'user/new-user') {
    $message = 'Ajouter un nouvel utilisateur.';
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


        <form onsubmit="return validForm()" action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="content-body">
                <div class="container-fluid">
                    @if (session('createSuccess'))
                    {!!session('createSuccess')!!}
                    @endif
                    <?php
$nomuser = "";
if (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == 1) {
    $message = "L'utilisateur <strong>" . $_SESSION['insert']['info']['nom'] . "</strong> a été ajouté avec succès";
    echo $package->message($message, "success");
} elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == 0) {
    $message = "L'utilisateur <strong>" . $_SESSION['insert']['info']['nom'] . "</strong> existe déjà";
    $nomuser = $_SESSION['insert']['info']['nom'];
    echo $package->message($message, "danger");
} elseif (isset($_SESSION['insert']['type']) && $_SESSION['insert']['type'] == -1) {
    $message = "Problème lors de l'insertion";
    $nomuser = $_SESSION['insert']['info']['nom'];
    echo $package->message($message, "danger");
}
                    ?>
                    <div class="col-xl-12">
                        <div class="shadow-lg card">
                            <div class="card-header">
                                <h5 class="mb-0">Details de l'Utilisateur</h5>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-xl-6 col-sm-6">
                                        <div class="mb-3">
                                            <label style="font-weight: 700;" for="exampleFormControlInput8"
                                                class="form-label text-primary">Nom d'utilisateur<span
                                                    class="required">*</span></label>
                                            <input :value="old('username')" type="text" class="form-control"
                                                id="nomuser" name="username" placeholder="Entrez le nom d'utilisateur">
                                            <span id="messageNom" class="fw-bold text-danger"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label style="font-weight: 700;" for="exampleFormControlInput1"
                                                class="form-label text-primary">Role<span
                                                    class="required">*</span></label>
                                            <select class="default-select form-control wide " name="role" id="role">
                                                <option value="none">Faites un choix</option>
                                                <option value="admin">Administrateur</option>
                                                <option value="user">Utilisateur</option>
                                            </select>
                                            <span id="messageRole" class="fw-bold text-danger"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label style="font-weight: 700;" for="exampleFormControlInput1"
                                                class="form-label text-primary">Usine<span
                                                    class="required">*</span></label>
                                            <select class="default-select form-control wide " name="usine" id="usine">
                                                <option value="none">Faites un choix</option>
                                                @foreach ($usine as $key)
                                                <option value="{{$key->id}}">{{$key->nomusine}}</option>
                                                @endforeach
                                            </select>
                                            <span id="messageUsine" class="fw-bold text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-sm-6">
                                        <div class="mb-3">
                                            <label style="font-weight: 700;" for="exampleFormControlInput8"
                                                class="form-label text-primary">Votre Nom ou Prénom<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Entrez le nom ou le prénom">
                                            <span id="messageMdp" class="fw-bold text-danger"></span>
                                        </div>


                                        <div class="mb-3">
                                            <label style="font-weight: 700;" for="exampleFormControlInput8"
                                                class="form-label text-primary">Mot de passe<span
                                                    class="required">*</span></label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                autocomplete="new-password" placeholder="Entrez le mot de passe">
                                            <span id="messageMdp" class="fw-bold text-danger"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label style="font-weight: 700;" for="exampleFormControlInput8"
                                                class="form-label text-primary">Confirmez le mot de passe<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="password"
                                                name="password_confirmation" autocomplete="new-password"
                                                placeholder="Confirmez le mot de passe">
                                            <span id="messageMail" class="fw-bold text-danger"></span>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="text-end ">
                                    <button type="submit" id="submitBtn" class="btn btn-primary">Soumettre</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="{{asset('js/new-user.js')}}"></script>
    <script src="{{asset('vendor/global/global.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('vendor/jquery-nice-select/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('vendor/swiper/js/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('js/dashboard/dashboard-1.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-select-country/js/bootstrap-select-country.min.js')}}"></script>
    <script src="{{asset('js/dlabnav-init.js')}}"></script>
    <script src="{{asset('js/custom.min.js')}}"></script>
    <script src="{{asset('js/demo.js')}}"></script>
    <script src="{{asset('js/all.js')}}"></script>