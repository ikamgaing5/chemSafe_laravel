<!DOCTYPE html>
<html lang="en" class="h-100">

<head>

	<meta charset="utf-8">



	<meta name="viewport" content="width=device-width, initial-scale=1">


	<title>ChemSafe</title>


	<link rel="shortcut icon" type="image/png" href="images/favicon.png" >
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    
</head>

<body class="vh-100">
    <div class="authincation h-100" style="background-image: url(images/student-bg.jpg); background-repeat:no-repeat; background-size:cover;">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-7 col-sm-12">
                    <div class="form-input-content  error-page">
						<h2 class="text-primary" style="font-size: 75px;">ChemSafe</h2>
						<h4>Une erreur est survenue.</h4>
						<p style="font-weight: 700; color: #000;">Revenez en arrière et actualiser (Ctrl + r)</p>

                        <a class="btn btn-primary" href="#" onclick="history.back()">Retourner en arrière</a>
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