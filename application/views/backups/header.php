<?php
	if( strtolower($user_now->user_role) == 'administrator'){
		$role_user = 'admin';
	}
	if( strtolower($user_now->user_role) == 'driver'){
		$role_user = 'driver';
	}
	if( strtolower($user_now->user_role) == 'customer'){
		$role_user = 'user';
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?= $title?>  -  Easy Bensin Business Dashboard</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?= base_url()?>assets/img/icon.png" type="image/png"/>

	<!-- Fonts and icons -->
	<script src="<?= base_url();?>assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['<?= base_url();?>assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="<?= base_url();?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url();?>assets/css/atlantis2.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="<?= base_url();?>assets/css/demo.css">

	<link rel="stylesheet" href="<?= base_url();?>assets/css/theme-red-ember.css">
	<?php if($title == 'Business Page'){ ?>
	<link type="text/css" rel="stylesheet" href="https://pubnub.github.io/eon/v/eon/1.1.0/eon.css"/>
	<?php } ?>
</head>
<body>
	<div class="wrapper horizontal-layout-2">
		
		<div class="main-header" >
			<div class="nav-top">
				<div class="container d-flex flex-row">
					<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon">
							<i class="icon-menu"></i>
						</span>
					</button>
					<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
					<!-- Logo Header -->
					<a href="<?= base_url(); ?>" class="logo">
						<img src="<?= base_url()?>assets/img/logo-white.svg" alt="navbar brand" class="navbar-brand" style="max-width:170px;">
					</a>
					<!-- End Logo Header -->

					<!-- Navbar Header -->
					<nav class="navbar navbar-header navbar-expand-lg p-0">

						<div class="container-fluid p-0">							
							<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
								<li class="nav-item dropdown hidden-caret">
									<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
										<div class="avatar-sm">
											<img src="<?= base_url()?>assets/img/admin.png" alt="..." class="avatar-img rounded-circle">
										</div>
									</a>
									<ul class="dropdown-menu dropdown-user animated fadeIn">
										<div class="dropdown-user-scroll scrollbar-outer">
											<li>
												<div class="user-box">
													<div class="avatar-lg"><img src="<?= base_url()?>assets/img/admin.png" alt="image profile" class="avatar-img rounded"></div>
													<div class="u-text">
														<h4><?= $user_now->name?></h4>
														<p class="text-muted"><?= $user_now->email?></p><a href="<?= base_url().$role_user;?>/myprofile" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
													</div>
												</div>
											</li>
											<li>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" href="<?= base_url().$role_user;?>/myprofile">My Profile</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" href="<?= base_url().$role_user;?>/setting">Password Setting</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" href="<?= base_url(); ?><?= ($role_user=='user')?'authuser':'auth' ?>/logout">Sign Out</a>
											</li>
										</div>
									</ul>
								</li>
							</ul>
						</div>
					</nav>
					<!-- End Navbar -->
				</div>
			</div>
			<div class="nav-bottom">
				<div class="container">
					<h3 class="title-menu d-flex d-lg-none"> 
						Menu 
						<div class="close-menu"> <i class="flaticon-cross"></i></div>
					</h3>
					<ul class="nav page-navigation page-navigation-info bg-white">
						
						<li class="nav-item nav-top-item <?php if($title == "Business Page"){ echo 'active'; } ?>">
							<a class="nav-link" href="<?= base_url()?>">
								<i class="link-icon icon-wallet"></i>
								<span class="menu-title">Business</span>
							</a>
						</li>
						<li class="nav-item nav-top-item <?php if( ($title == "Operational Page") ){ echo 'active'; }  ?> ">
							<a class="nav-link" href="<?= base_url()?>operational">
								<i class="link-icon icon-settings"></i>
								<span class="menu-title">Operational</span>
							</a>
						</li>
						<li class="nav-item nav-top-item <?php if( ($title == "Administration Page") || (isset($administration_page)) ){ echo 'active'; }  ?> ">
							<a class="nav-link" href="<?= base_url()?>administration">
								<i class="link-icon icon-grid"></i>
								<span class="menu-title">Administration</span>
							</a>
						</li>
						<li class="nav-item nav-top-item <?php if($title == "Statistic"){ echo 'active'; }  ?>">
							<a class="nav-link" href="<?= base_url()?>statistic">
								<i class="link-icon icon-chart"></i>
								<span class="menu-title">Statistic</span>
							</a>
						</li>

					</ul>
				</div>
			</div>
		</div>

		<div class="main-panel">
			<div class="container">
			


