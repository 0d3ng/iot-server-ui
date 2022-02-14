
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap material admin template">
    <meta name="author" content="">
    
    <title>Dashboard | <?= $title;?></title>
    
    <link rel="apple-touch-icon" href="<?= base_url()?>assets/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="<?= base_url()?>assets/images/favicon.ico">
    
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
    <link rel="stylesheet" href="<?= base_url()?>assets/examples/css/uikit/dropdowns.css">
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

        <!-- Tree View -->
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/bootstrap-treeview/bootstrap-treeview.css">

        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/clockpicker/clockpicker.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/examples/css/uikit/progress-bars.css">

    
    <!-- Fonts -->
    <link rel="stylesheet" href="<?= base_url()?>assets/global/fonts/web-icons/web-icons.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/fonts/material-design/material-design.min.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/global/fonts/brand-icons/brand-icons.min.css">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    
    <!--[if lt IE 9]>
    <script src="<?= base_url()?>assets/global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    
    <!--[if lt IE 10]>
    <script src="<?= base_url()?>assets/global/vendor/media-match/media.match.min.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/respond/respond.min.js"></script>
    <![endif]-->
    
    <!-- Scripts -->
    <script src="<?= base_url()?>assets/global/vendor/breakpoints/breakpoints.js"></script>
    <script>
      Breakpoints();
    </script>
    <style type="text/css">
      .dataTables_wrapper [aria-live="polite"]{
        position: relative;
      }
    </style>
  </head>
  <body class="animsition dashboard">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">
    
      <div class="navbar-header">
        <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
          data-toggle="menubar">
          <span class="sr-only">Toggle navigation</span>
          <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
          data-toggle="collapse">
          <i class="icon md-more" aria-hidden="true"></i>
        </button>
        <div class="navbar-brand navbar-brand-center">
          <img class="navbar-brand-logo" src="<?= base_url()?>assets/images/logo-2-clean.png" title="-">
          <span class="navbar-brand-text hidden-xs-down">SEMAR DASHBOARD</span>
        </div>
      </div>
    
      <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
          <!-- Navbar Toolbar -->
          <ul class="nav navbar-toolbar">
            <li class="nav-item hidden-float" id="toggleMenubar">
              <a class="nav-link" data-toggle="menubar" href="#" role="button">
                <i class="icon hamburger hamburger-arrow-left">
                  <span class="sr-only">Toggle menubar</span>
                  <span class="hamburger-bar"></span>
                </i>
              </a>
            </li>
          </ul>
          <!-- End Navbar Toolbar -->
    
          <!-- Navbar Toolbar Right -->
          <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
            <li class="nav-item dropdown">
              <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                data-animation="scale-up" role="button">
                <span class="avatar avatar-online">
                  <img src="<?= base_url()?>assets/global/portraits/admin.png" alt="...">
                  <i></i>
                </span>
              </a>
              <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="<?= base_url();?>user/profile" role="menuitem"><i class="icon md-account" aria-hidden="true"></i> Profile</a>
                <a class="dropdown-item" href="<?= base_url();?>user/setting" role="menuitem"><i class="icon md-lock" aria-hidden="true"></i> Password Settings</a>
                <div class="dropdown-divider" role="presentation"></div>
                <a class="dropdown-item" href="<?= base_url();?>auth/logout" role="menuitem"><i class="icon md-power" aria-hidden="true"></i> Logout</a>
              </div>
            </li>
            
          </ul>
          <!-- End Navbar Toolbar Right -->
        </div>
        <!-- End Navbar Collapse -->
    
        <!-- Site Navbar Seach -->
        <div class="collapse navbar-search-overlap" id="site-navbar-search">
          <form role="search">
            <div class="form-group">
              <div class="input-search">
                <i class="input-search-icon md-search" aria-hidden="true"></i>
                <input type="text" class="form-control" name="site-search" placeholder="Search...">
                <button type="button" class="input-search-close icon md-close" data-target="#site-navbar-search"
                  data-toggle="collapse" aria-label="Close"></button>
              </div>
            </div>
          </form>
        </div>
        <!-- End Site Navbar Seach -->
      </div>
    </nav>    
    <div class="site-menubar">
      <div class="site-menubar-body">
        <div>
          	<div>
	            <ul class="site-menu" data-plugin="menu">
	              	<li class="site-menu-item active">
	                <a class="animsition-link" href="<?= base_url()?>">
	                        <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
	                        <span class="site-menu-title">Home</span>
	                    </a>
	              	</li>
	              	<li class="site-menu-item has-sub">
	                <a class="animsition-link" href="<?= base_url()?>groups">
	                        <i class="site-menu-icon md-group-work" aria-hidden="true"></i>
	                        <span class="site-menu-title">Group</span>
	                    </a>
	              	</li>
	             	<li class="site-menu-item has-sub">
	                <a class="animsition-link" href="<?= base_url()?>devicegroups">
	                        <i class="site-menu-icon md-device-hub" aria-hidden="true"></i>
	                        <span class="site-menu-title">Devices Group</span>
	                    </a>
	              	</li>
	              	<li class="site-menu-item has-sub">
	                	<a class="animsition-link" href="<?= base_url()?>device">
	                        <i class="site-menu-icon md-memory" aria-hidden="true"></i>
	                        <span class="site-menu-title">Devices</span>
	                    </a>
	              	</li>
                  <li class="site-menu-item has-sub">
	                	<a class="animsition-link" href="<?= base_url()?>schema">
	                        <i class="site-menu-icon md-collection-text" aria-hidden="true"></i>
	                        <span class="site-menu-title">Schema</span>
	                    </a>
	              	</li>
                  <li class="site-menu-item has-sub">
	                	<a class="animsition-link" href="<?= base_url()?>datasync">
	                        <i class="site-menu-icon md-refresh-sync" aria-hidden="true"></i>
	                        <span class="site-menu-title">Data Synchronization</span>
	                    </a>
	              	</li>
	              	<!-- <li class="site-menu-item has-sub">
	                	<a class="animsition-link" href="<?= base_url()?>communication">
	                        <i class="site-menu-icon md-cloud-outline" aria-hidden="true"></i>
	                        <span class="site-menu-title">Communication</span>
	                    </a>
	              	</li> -->

	              <!-- <li class="site-menu-item has-sub">
	                <a href="javascript:void(0)">
	                        <i class="site-menu-icon md-format-color-fill" aria-hidden="true"></i>
	                        <span class="site-menu-title">Advanced UI</span>
	                                <span class="site-menu-arrow"></span>
	                    </a>
	                <ul class="site-menu-sub">
	                  <li class="site-menu-item hidden-sm-down site-tour-trigger">
	                    <a href="javascript:void(0)">
	                      <span class="site-menu-title">Tour</span>
	                    </a>
	                  </li>
	                  <li class="site-menu-item">
	                    <a class="animsition-link" href="advanced/animation.html">
	                      <span class="site-menu-title">Animation</span>
	                    </a>
	                  </li>
	                </ul>
	              </li> -->
	            </ul>
	            <!-- <div class="site-menubar-section">
	              <h5>
	                Milestone
	                <span class="float-right">30%</span>
	              </h5>
	              <div class="progress progress-xs">
	                <div class="progress-bar active" style="width: 30%;" role="progressbar"></div>
	              </div>
	              <h5>
	                Release
	                <span class="float-right">60%</span>
	              </h5>
	              <div class="progress progress-xs">
	                <div class="progress-bar progress-bar-warning" style="width: 60%;" role="progressbar"></div>
	              </div>
	            </div> -->      
            </div>
        </div>
      </div>
    
      <div class="site-menubar-footer">
        <a href="<?= base_url();?>user/profile" class="fold-show" data-placement="top" data-toggle="tooltip"
          data-original-title="Profile">
          <span class="icon md-account" aria-hidden="true"></span>
        </a>
        <a href="<?= base_url();?>user/setting" data-placement="top" data-toggle="tooltip" data-original-title="Password Settings">
          <span class="icon md-lock" aria-hidden="true"></span>
        </a>
        <a href="<?= base_url();?>auth/logout" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
          <span class="icon md-power" aria-hidden="true"></span>
        </a>
      </div>
    </div>    

    <!-- Page -->
    <div class="page">