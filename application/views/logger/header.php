
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Data Logger User Inteface">
    <meta name="author" content="">
    
    <title>Data Logger | <?= $title;?></title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= base_url()?>assets/global/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/css/bootstrap-extend.min.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/css/site.min.css">
    
    <!-- Plugins -->
    <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/animsition/animsition.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/asscrollable/asScrollable.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/switchery/switchery.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/intro-js/introjs.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/slidepanel/slidePanel.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/flag-icon-css/flag-icon.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/waves/waves.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/icheck/icheck.css">

        <!-- Select -->
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/select2/select2.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/bootstrap-select/bootstrap-select.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/examples/css/forms/advanced.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/examples/css/charts/chartjs.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/chartist/chartist.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/jvectormap/jquery-jvectormap.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/examples/css/dashboard/v1.css">

        <!-- Toatsr -->
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/toastr/toastr.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/examples/css/advanced/toastr.css">

        <!-- Data Table -->
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/examples/css/tables/datatable.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/bootstrap-table/bootstrap-table.css">


        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/clockpicker/clockpicker.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/examples/css/uikit/progress-bars.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="<?= base_url()?>assets/global/fonts/web-icons/web-icons.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/fonts/material-design/material-design.min.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/fonts/brand-icons/brand-icons.min.css">
    
    
    <!-- Scripts -->
    <script src="<?= base_url()?>assets/global/vendor/breakpoints/breakpoints.js"></script>
    <script>
      Breakpoints();
    </script>
    <style type="text/css">
      .dataTables_wrapper [aria-live="polite"]{
        position: relative;
      }
      .fixed-table-body .card-view .title{
        min-width: 50%;  
      }
    </style>
  </head>
  <body class="animsition dashboard">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega bg-orange-600" role="navigation">
    
      <div class="navbar-header">
        <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
          data-toggle="menubar">
          <span class="sr-only">Toggle navigation</span>
          <span class="hamburger-bar"></span>
        </button>
        <!-- <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
          data-toggle="collapse">
          <i class="icon md-more" aria-hidden="true"></i>
        </button> -->
        <div class="navbar-brand navbar-brand-center">
          <span class="navbar-brand-text">DATA LOGGER</span>
        </div>
      </div>
    
      
    </nav>    
    <div class="site-menubar">
      <div class="site-menubar-body">
        <div>
          	<div>
	            <ul class="site-menu" data-plugin="menu">
	              	<li class="site-menu-item active">
	                    <a class="animsition-link" href="<?= base_url()?>logger/home">
	                        <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
	                        <span class="site-menu-title">Home</span>
	                    </a>
	              	</li>
	              	<li class="site-menu-item has-sub">
	                    <a class="animsition-link" href="<?= base_url()?>logger/experiment">
	                        <i class="site-menu-icon md-lamp" aria-hidden="true"></i>
	                        <span class="site-menu-title">Experiment</span>
	                    </a>
	              	</li>
	             	<li class="site-menu-item has-sub">
	                    <a class="animsition-link" href="<?= base_url()?>logger/configuration">
	                        <i class="site-menu-icon md-settings" aria-hidden="true"></i>
	                        <span class="site-menu-title">Configuration</span>
	                    </a>
	              	</li>
                </ul>	              	     
            </div>
        </div>
      </div>          
    </div>    

    <!-- Page -->
    <div class="page">