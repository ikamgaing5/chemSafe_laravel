<!DOCTYPE html>
<html lang="en" class="h-100">



<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignLab" >
	<meta name="robots" content="" >
	<meta name="keywords" content="school, school admin, education, academy, admin dashboard, college, college management, education management, institute, school management, school management system, student management, teacher management, university, university management" >
	<meta name="description" content="Discover Akademi - the ultimate admin dashboard and Bootstrap 5 template. Specially designed for professionals, and for business. Akademi provides advanced features and an easy-to-use interface for creating a top-quality website with School and Education Dashboard" >
	<meta property="og:title" content="Akademi : School and Education Management Admin Dashboard Template" >
	<meta property="og:description" content="Akademi - the ultimate admin dashboard and Bootstrap 5 template. Specially designed for professionals, and for business. Akademi provides advanced features and an easy-to-use interface for creating a top-quality website with School and Education Dashboard">
	<meta property="og:image" content="social-image.html" >
	<meta name="format-detection" content="telephone=no">


	<meta name="viewport" content="width=device-width, initial-scale=1">


	<title></title>


	<link rel="shortcut icon" type="image/png" href="images/favicon.png" >
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    
</head>

<body class="vh-100">
    <div class="authincation h-100" style="background-image: url(images/student-bg.jpg); background-repeat:no-repeat; background-size:cover;">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-input-content  error-page">
						<h2 class="text-primary" style="font-size: 75px;">NoteWise</h2>
						<h4> Aucune reponse</h4>
						<p style="font-weight: 700; color: #000;">Aucun relevé disponible pour le moment! les notes n'ont pas toutes été enregistrées</p><?php $matricule = $_GET['matricule'];  ?>
                        <a class="btn btn-primary" href="dashboard.php?matricule=<?php echo $matricule ?>">Retourner au tableau de bord</a>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
					<img  class="w-100 move1" src="images/svg/student.svg" alt="">
				</div>
            </div>
        </div>
    </div>

	<script src="{{asset('vendor/global/global.min.js')}}"></script>
	<script src="{{asset('js/dlabnav-init.js')}}"></script>
	<script src="{{asset('js/custom.min.js')}}"></script>

</body>


</html>