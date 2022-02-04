
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
  <body class="animsition dashboard" style="padding-top: 0px;">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Page -->
    <div class="page" style="margin-left: 0px;">
        <div class="page-header">
            <h1 class="page-title">IoT Application Demo</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Get room data from IoT Server for each Transmiter </li>
            </ol>            
        </div>
        <div class="page-content">
            <div class="row row-lg">
                <?php foreach($id as $d){ ?>
                    <div class="col-md-3">
                        <div class="card p-30 flex-row justify-content-between">
                                <div class="white">
                                    <i class="icon icon-circle icon-2x md-pin bg-blue-600" aria-hidden="true"></i>
                                </div>
                                <div class="counter counter-md counter text-right">
                                    
                                    <div class="counter-number-group" style="font-size: 20px;">
                                        <span class="counter-number font-size-16">Transmiter ID: </span>
                                        <span class="counter-number-related text-capitalize font-size-20"><?= $d ?></span>
                                    </div>
                                    <div class="counter-number-group"  style="font-size: 20px;">
                                        <span class="counter-number font-size-16">Position:</span>
                                        <span class="counter-number-related text-capitalize font-size-20" id="room_<?= $d ?>">-</span>
                                    </div>
                                    <div class="counter-label text-capitalize font-size-14"><mark id="time_<?= $d ?>">-</mark></div>
                                </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- End Page -->


    <!-- Footer -->
    <footer class="site-footer">
      <div class="site-footer-legal">&copy; 2021</div>
      <div class="site-footer-right">
        
      </div>
    </footer>
    <!-- Core  -->
    <script src="<?= base_url()?>assets/global/vendor/babel-external-helpers/babel-external-helpers.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/jquery/jquery.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/popper-js/umd/popper.min.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/bootstrap/bootstrap.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/animsition/animsition.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/mousewheel/jquery.mousewheel.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/asscrollable/jquery-asScrollable.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/waves/waves.js"></script>
    
    <!-- Plugins -->
    <script src="<?= base_url()?>assets/global/vendor/switchery/switchery.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/intro-js/intro.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/screenfull/screenfull.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/slidepanel/jquery-slidePanel.js"></script>
        <!-- <script src="<?= base_url()?>assets/global/vendor/chartist/chartist.min.js"></script> -->
        <!-- <script src="<?= base_url()?>assets/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.js"></script> -->
        <script src="<?= base_url()?>assets/global/vendor/jvectormap/jquery-jvectormap.min.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/jvectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/matchheight/jquery.matchHeight-min.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/peity/jquery.peity.min.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/toastr/toastr.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/alertify/alertify.js"></script>
        <!-- Form -->
        <script src="<?= base_url()?>assets/global/vendor/select2/select2.full.min.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/bootstrap-select/bootstrap-select.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/icheck/icheck.min.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/switchery/switchery.js"></script>
        
        <!-- Data Table -->
        <script src="<?= base_url()?>assets/global/vendor/datatables.net/jquery.dataTables.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-scroller/dataTables.scroller.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-responsive/dataTables.responsive.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-buttons/dataTables.buttons.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-buttons/buttons.html5.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-buttons/buttons.flash.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-buttons/buttons.print.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-buttons/buttons.colVis.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/asrange/jquery-asRange.min.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/bootbox/bootbox.js"></script>

        <!-- Tree View -->
        <script src="<?= base_url()?>assets/global/vendor/toastr/toastr.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/bootstrap-treeview/bootstrap-treeview.min.js"></script>

    
    <!-- Scripts -->
    <script src="<?= base_url()?>assets/global/js/Component.js"></script>
    <script src="<?= base_url()?>assets/global/js/Plugin.js"></script>
    <script src="<?= base_url()?>assets/global/js/Base.js"></script>
    <script src="<?= base_url()?>assets/global/js/Config.js"></script>
    
    <script src="<?= base_url()?>assets/js/Section/Menubar.js"></script>
    <script src="<?= base_url()?>assets/js/Section/GridMenu.js"></script>
    <script src="<?= base_url()?>assets/js/Section/Sidebar.js"></script>
    <script src="<?= base_url()?>assets/js/Section/PageAside.js"></script>
    <script src="<?= base_url()?>assets/js/Plugin/menu.js"></script>
    
    <script src="<?= base_url()?>assets/global/js/config/colors.js"></script>
    <script src="<?= base_url()?>assets/js/config/tour.js"></script>
    <script>Config.set('assets', '../assets');</script>
    
    <!-- Page -->
    <script src="<?= base_url()?>assets/js/Site.js"></script>
    <script src="<?= base_url()?>assets/global/js/Plugin/asscrollable.js"></script>
    <script src="<?= base_url()?>assets/global/js/Plugin/slidepanel.js"></script>
    <script src="<?= base_url()?>assets/global/js/Plugin/switchery.js"></script>
        <script src="<?= base_url()?>assets/global/js/Plugin/panel.js"></script>
        <script src="<?= base_url()?>assets/global/js/Plugin/matchheight.js"></script>
        <script src="<?= base_url()?>assets/global/js/Plugin/jvectormap.js"></script>
        <script src="<?= base_url()?>assets/global/js/Plugin/peity.js"></script>
        <script src="<?= base_url()?>assets/global/js/Plugin/bootstrap-treeview.js"></script>
        
        <script src="<?= base_url()?>assets/examples/js/dashboard/v1.js"></script>
    <script type="text/javascript">
        jQuery(function($){
            
        });
        
        function getupdate(id){            
            $.ajax({
                type: 'post',
                url: '<?= base_url()?>testing/room/getroom/',
                data: {"id":id},
                success: function (result){
                    if(result){
                        room = result["room"];
                        lastdate = result["lastdate"];
                        $("#room_"+id).html(room);
                        $("#time_"+id).html(lastdate);
                    }                                        
                    setTimeout(() => {
                        getupdate(id)
                    }, 30000);
                }
            });
        }
        <?php foreach($id as $d){ ?>
            getupdate("<?= $d ?>");
        <?php } ?>

    </script>
  </body>
</html>
