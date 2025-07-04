
<link rel="icon" type="image/png" href={{asset('images/favicon.png')}} />

<!-- Pour Apple (optionnel mais recommandé) -->
<link rel="apple-touch-icon" href={{asset('images/favicon.png')}}>

<!-- Pour navigateur Microsoft (optionnel) -->
<meta name="msapplication-TileImage" content={{asset('images/favicon.png')}}>
<title>ChemSafe</title>
<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=experiment" /> -->
<link rel="stylesheet"
	href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=experiment" />
<div class="nav-header">
	<a href="/dashboard" class="brand-logo">
		<svg class="logo-abbr" width="40" height="40" viewBox="0 0 48 54" fill="none"
			xmlns="http://www.w3.org/2000/svg">
			<rect y="3" width="48" height="48" rx="16" fill="#FB7D5B" />
			<path
				d="M32 36C30 38 27.5 39 24.5 39C18.5 39 14 34.5 14 27C14 19.5 18.5 15 24.5 15C27.5 15 30 16 32 18V22.5C30.2 20.5 28 19.5 25.5 19.5C21.5 19.5 19 22.5 19 27C19 31.5 21.5 34.5 25.5 34.5C28 34.5 30.2 33.5 32 31.5V36Z"
				fill="white" />
		</svg>
		<div class="brand-title">
			<h3 style="color: #fff;">ChemSafe</h3>
		</div>
	</a>


	<div class="nav-control">
		<div class="hamburger">
			<span class="line"></span><span class="line"></span><span class="line"></span>
			<svg width="26" height="26" viewBox="0 0 26 26" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg">
				<rect x="22" y="11" width="4" height="4" rx="2" fill="#FFFFFF" />
				<rect x="11" width="4" height="4" rx="2" fill="#FFFFFF" />
				<rect x="22" width="4" height="4" rx="2" fill="#FFFFFF" />
				<rect x="11" y="11" width="4" height="4" rx="2" fill="#FFFFFF" />
				<rect x="11" y="22" width="4" height="4" rx="2" fill="#FFFFFF" />
				<rect width="4" height="4" rx="2" fill="#FFFFFF" />
				<rect y="11" width="4" height="4" rx="2" fill="#FFFFFF" />
				<rect x="22" y="22" width="4" height="4" rx="2" fill="#FFFFFF" />
				<rect y="22" width="4" height="4" rx="2" fill="#FFFFFF" />
			</svg>
		</div>
	</div>
</div>






<div class="header" style="background-color: rgb(55, 68, 146);">
	<div class="header-content">
		<nav class="navbar navbar-expand">
			<div class="collapse navbar-collapse justify-content-between">
				<div class="header-left">
					<div class="dashboard_bar" style="color: #fff;">
						<?= $message ?>
					</div>
				</div>
				<ul class="navbar-nav header-right">
					{{-- <li class="nav-item dropdown notification_dropdown all">
						<a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
							<svg height="24" class="svg-main-icon" viewBox="0 0 32 32" width="24"
								xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								<clipPath id="clip_1">
									<path id="artboard_1" clip-rule="evenodd" d="m0 0h32v32h-32z" />
								</clipPath>
								<g id="select" clip-path="url(#clip_1)">
									<path id="Vector"
										d="m4.70222 7.16834-.12871-.2574c-.0593-.11861-.13904-.22136-.23922-.30824-.10018-.08689-.21317-.1513-.33898-.19323-.1258-.04194-.25484-.0582-.38711-.0488-.13228.0094-.25772.04375-.37633.10306-.24699.12349-.41414.31622-.50147.5782-.08732.26197-.06923.51645.05426.76344l1.32093 2.64183c.0593.1186.13904.2214.23922.3083.10018.0868.21317.1512.33898.1932.1258.0419.25484.0582.38711.0488.13228-.0094.25772-.0438.37633-.1031.01854-.0092.03678-.0191.05471-.0295s.03552-.0214.05277-.0329l5.99999-3.99995c.1104-.07356.2024-.16543.2762-.27561s.1237-.23029.1497-.36032c.026-.13004.0261-.2601.0004-.39019-.0257-.13008-.0754-.25029-.1489-.36063-.1532-.22977-.3652-.37173-.636-.42588-.2707-.05416-.521-.00465-.7508.14853l-1.94316 1.29545-3.1143 2.07619zm11.29778-1.16834c-.2761 0-.5118.09763-.7071.29289s-.2929.43097-.2929.70711.0976.51184.2929.70711c.1953.19526.431.29289.7071.29289h14c.2761 0 .5118-.09763.7071-.29289.1953-.19527.2929-.43097.2929-.70711s-.0976-.51185-.2929-.70711-.431-.29289-.7071-.29289zm-11.27691 9.1683-.12871-.2574c-.12349-.2469-.31622-.4141-.5782-.5014-.26197-.0874-.51645-.0693-.76344.0542-.11861.0593-.22135.1391-.30824.2393-.08688.1001-.15129.2131-.19323.3389-.04193.1258-.0582.2549-.0488.3871.0094.1323.04376.2578.10306.3764l1.32092 2.6418c.1235.247.31623.4142.5782.5015.26198.0873.51646.0692.76345-.0543.01854-.0092.03678-.0191.05471-.0295s.03552-.0214.05277-.0329l6.00002-3.9999c.2298-.1532.3717-.3652.4259-.636.0541-.2708.0046-.521-.1486-.7508-.1531-.2298-.3651-.3717-.6359-.4259-.2708-.0541-.521-.0046-.7508.1485l-5.05749 3.3717zm11.27691-.1683c-.2761 0-.5118.0976-.7071.2929s-.2929.431-.2929.7071.0976.5118.2929.7071.431.2929.7071.2929h14c.2761 0 .5118-.0976.7071-.2929s.2929-.431.2929-.7071-.0976-.5118-.2929-.7071-.431-.2929-.7071-.2929zm-11.27691 8.1683-.12871-.2574c-.12349-.247-.31622-.4141-.5782-.5014-.26197-.0874-.51645-.0693-.76344.0542-.11861.0593-.22135.1391-.30824.2393-.08688.1001-.15129.2131-.19323.3389-.04193.1258-.0582.2549-.0488.3871.0094.1323.04376.2578.10306.3764l1.32092 2.6418c.1235.247.31623.4142.5782.5015.26198.0873.51646.0692.76345-.0543.01854-.0092.03678-.0191.05471-.0295s.03552-.0214.05277-.0329l6.00002-4c.1103-.0735.2024-.1654.2762-.2756.0738-.1101.1237-.2303.1497-.3603s.0261-.2601.0004-.3902c-.0258-.1301-.0754-.2503-.149-.3606-.1531-.2298-.3651-.3717-.6359-.4259-.2708-.0541-.521-.0046-.7508.1485l-1.94319 1.2955-3.1143 2.0762zm11.27691.8317c-.2761 0-.5118.0976-.7071.2929s-.2929.431-.2929.7071.0976.5118.2929.7071.431.2929.7071.2929h14c.2761 0 .5118-.0976.7071-.2929s.2929-.431.2929-.7071-.0976-.5118-.2929-.7071-.431-.2929-.7071-.2929z"
										fill-rule="evenodd" />
								</g>
							</svg>
						</a>

					</li> --}}
{{-- 
					<li class="nav-item dropdown notification_dropdown">
						<a class="nav-link bell dz-theme-mode" href="javascript:void(0);">
							<i id="icon-light-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
									viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
									stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun">
									<circle cx="12" cy="12" r="5"></circle>
									<line x1="12" y1="1" x2="12" y2="3"></line>
									<line x1="12" y1="21" x2="12" y2="23"></line>
									<line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
									<line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
									<line x1="1" y1="12" x2="3" y2="12"></line>
									<line x1="21" y1="12" x2="23" y2="12"></line>
									<line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
									<line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
								</svg></i>
							<i id="icon-dark-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
									viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
									stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon">
									<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
								</svg></i>
						</a>
					</li>

					<li class="nav-item dropdown notification_dropdown">
						<a class="nav-link bell dz-fullscreen" href="javascript:void(0);">
							<svg id="icon-full-1" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor"
								stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
								class="css-i6dzq1">
								<path
									d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"
									style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path>
							</svg>
							<svg id="icon-minimize-1" width="20" height="20" viewBox="0 0 24 24" fill="none"
								stroke="A098AE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
								class="feather feather-minimize">
								<path
									d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"
									style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path>
							</svg>
						</a>
					</li> --}}

					<li class="nav-item">
						<div class="dropdown header-profile2">
							<a class="nav-link ms-0" href="javascript:void(0);" role="button" data-bs-toggle="dropdown"
								aria-expanded="false">
								<div class="header-info2 d-flex align-items-center">
									<div class="d-flex align-items-center sidebar-info">

									</div>
									<img src={{asset('images/user.jpg')}} alt="">
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-end pb-0">
								<div class="card mb-0">
									<div class="card-header p-3">
										<ul class="d-flex align-items-center">
											<li>
												<!-- <img src="./upload/"  alt=''> -->
												<img src={{asset('images/user.jpg')}} alt="">
											</li>
											<li class="ms-2">
												<h4 class="mb-0">{{Auth::user()->name}}</h4>
											</li>
										</ul>

									</div>
									<div class="card-body p-3">
										<a href="app-profile.html" class="dropdown-item ai-icon ">
											<svg xmlns="http://www.w3.org/2000/svg"
												xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
												viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24" />
													<path
														d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
														fill="#000000" fill-rule="nonzero" opacity="0.3" />
													<path
														d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
														fill="var(--primary)" fill-rule="nonzero" />
												</g>
											</svg>
											<span class="ms-2">Profile </span>
										</a>


										<a href="parametres?matricule=" class="dropdown-item ai-icon ">
											<svg xmlns="http://www.w3.org/2000/svg"
												xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
												viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path
														d="M18.6225,9.75 L18.75,9.75 C19.9926407,9.75 21,10.7573593 21,12 C21,13.2426407 19.9926407,14.25 18.75,14.25 L18.6854912,14.249994 C18.4911876,14.250769 18.3158978,14.366855 18.2393549,14.5454486 C18.1556809,14.7351461 18.1942911,14.948087 18.3278301,15.0846699 L18.372535,15.129375 C18.7950334,15.5514036 19.03243,16.1240792 19.03243,16.72125 C19.03243,17.3184208 18.7950334,17.8910964 18.373125,18.312535 C17.9510964,18.7350334 17.3784208,18.97243 16.78125,18.97243 C16.1840792,18.97243 15.6114036,18.7350334 15.1896699,18.3128301 L15.1505513,18.2736469 C15.008087,18.1342911 14.7951461,18.0956809 14.6054486,18.1793549 C14.426855,18.2558978 14.310769,18.4311876 14.31,18.6225 L14.31,18.75 C14.31,19.9926407 13.3026407,21 12.06,21 C10.8173593,21 9.81,19.9926407 9.81,18.75 C9.80552409,18.4999185 9.67898539,18.3229986 9.44717599,18.2361469 C9.26485393,18.1556809 9.05191298,18.1942911 8.91533009,18.3278301 L8.870625,18.372535 C8.44859642,18.7950334 7.87592081,19.03243 7.27875,19.03243 C6.68157919,19.03243 6.10890358,18.7950334 5.68746499,18.373125 C5.26496665,17.9510964 5.02757002,17.3784208 5.02757002,16.78125 C5.02757002,16.1840792 5.26496665,15.6114036 5.68716991,15.1896699 L5.72635306,15.1505513 C5.86570889,15.008087 5.90431906,14.7951461 5.82064513,14.6054486 C5.74410223,14.426855 5.56881236,14.310769 5.3775,14.31 L5.25,14.31 C4.00735931,14.31 3,13.3026407 3,12.06 C3,10.8173593 4.00735931,9.81 5.25,9.81 C5.50008154,9.80552409 5.67700139,9.67898539 5.76385306,9.44717599 C5.84431906,9.26485393 5.80570889,9.05191298 5.67216991,8.91533009 L5.62746499,8.870625 C5.20496665,8.44859642 4.96757002,7.87592081 4.96757002,7.27875 C4.96757002,6.68157919 5.20496665,6.10890358 5.626875,5.68746499 C6.04890358,5.26496665 6.62157919,5.02757002 7.21875,5.02757002 C7.81592081,5.02757002 8.38859642,5.26496665 8.81033009,5.68716991 L8.84944872,5.72635306 C8.99191298,5.86570889 9.20485393,5.90431906 9.38717599,5.82385306 L9.49484664,5.80114977 C9.65041313,5.71688974 9.7492905,5.55401473 9.75,5.3775 L9.75,5.25 C9.75,4.00735931 10.7573593,3 12,3 C13.2426407,3 14.25,4.00735931 14.25,5.25 L14.249994,5.31450877 C14.250769,5.50881236 14.366855,5.68410223 14.552824,5.76385306 C14.7351461,5.84431906 14.948087,5.80570889 15.0846699,5.67216991 L15.129375,5.62746499 C15.5514036,5.20496665 16.1240792,4.96757002 16.72125,4.96757002 C17.3184208,4.96757002 17.8910964,5.20496665 18.312535,5.626875 C18.7350334,6.04890358 18.97243,6.62157919 18.97243,7.21875 C18.97243,7.81592081 18.7350334,8.38859642 18.3128301,8.81033009 L18.2736469,8.84944872 C18.1342911,8.99191298 18.0956809,9.20485393 18.1761469,9.38717599 L18.1988502,9.49484664 C18.2831103,9.65041313 18.4459853,9.7492905 18.6225,9.75 Z"
														fill="#000000" fill-rule="nonzero" opacity="0.3" />
													<path
														d="M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
														fill="#000000" />
												</g>
											</svg>
											<span class="ms-2">Paramètres</span>
										</a>

									</div>
									<form method="POST" action="{{ route('logout') }}">
										@csrf
										<div class="card-footer text-center p-3">

											<input type="submit" name="deconnecter"
												class="dropdown-item ai-icon btn btn-primary light"
												value="Se deconnecter">

										</div>
									</form>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</div>

</div>