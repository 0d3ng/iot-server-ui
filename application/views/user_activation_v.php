
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">
    
    <title>User Activation</title>
    
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
        <link rel="stylesheet" href="<?= base_url()?>assets/examples/css/pages/login-v3.css">
    
    
    <!-- Fonts -->
    <link rel="stylesheet" href="<?= base_url()?>assets/global/fonts/web-icons/web-icons.min.css">
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
  </head>
  <body class="animsition page-login-v3 layout-full">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


    <!-- Page -->
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
      <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
        <div class="panel">
          <div class="panel-body">
            <div class="brand">
              <img class="brand-img" src="<?= base_url()?>assets//images/logo-2.png" style="max-width:90px;">
              <h2 class="brand-text font-size-18">USER ACTIVATION SEMAR IOT PLATFORM</h2>
            </div>
            <form method="post" action="" id="formSubmit">
                <?php if($error){ ?>
                    <div class="alert dark alert-alt alert-danger alert-dismissible text-left" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        Warning!<br/><span class="alert-link"><?= $error?></span>.
                    </div>
                <?php } ?>
            </form>
            <p>Have account already? Please go to <a href="<?= base_url()?>auth/login">Sign In</a></p>
            <p>Still no account? Please go to <a href="<?= base_url()?>auth/register">Sign up</a></p>
          </div>
        </div>

        
      </div>
    </div>
    <!-- End Page -->


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
    
    <!-- Plugins -->
    <script src="<?= base_url()?>assets/global/vendor/switchery/switchery.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/intro-js/intro.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/screenfull/screenfull.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/slidepanel/jquery-slidePanel.js"></script>
        <script src="<?= base_url()?>assets/global/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    
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
    <script>Config.set('assets', '<?= base_url()?>assets');</script>
    
    <!-- Page -->
    <script src="<?= base_url()?>assets/js/Site.js"></script>
    <script src="<?= base_url()?>assets/global/js/Plugin/asscrollable.js"></script>
    <script src="<?= base_url()?>assets/global/js/Plugin/slidepanel.js"></script>
    <script src="<?= base_url()?>assets/global/js/Plugin/switchery.js"></script>
        <script src="<?= base_url()?>assets/global/js/Plugin/jquery-placeholder.js"></script>
        <script src="<?= base_url()?>assets/global/js/Plugin/material.js"></script>
    
    <script>
      (function(document, window, $){
        'use strict';
    
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);
    </script>
  </body>
</html>
