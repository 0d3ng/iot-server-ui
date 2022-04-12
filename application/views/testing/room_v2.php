
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">
    
    <title>FILS15.4 - Find My Location</title>
    
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
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/select2/select2.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/global/vendor/bootstrap-select/bootstrap-select.css">

    
    
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
          <div class="panel-head">
            <div class="brand">
              <h2 class="brand-text"style="padding-top: 20px;">FILS15.4 <br/> Find My Room</h2>
            </div>
          </div>
          <div class="panel-body">            
              <div class="form-group form-material floating" >
                <div class="example-wrap">
                  <h4 class="example-title font-size-18">Select Transmiter ID</h4>
                  <div class="example">
                    <select data-plugin="selectpicker" id="trans">
                      <?php foreach($id as $d){ ?>
                      <option value="<?= $d?>">Transmitter ID : <?= $d ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <button id="src" type="button" name="save" value="save" class="btn btn-primary btn-block btn-lg mt-10">Search</button>
                </div>
              </div>
              <div class="alert dark alert-icon alert-info alert-dismissible" role="alert" id="myloc" style="display:none;">
                <i class="icon md-info-outline" aria-hidden="true"></i> 
                <span class="font-size-18">YOUR LOCATION IN <br/> <bold style="font-weight: 600;" id="room"></bold></span><br/>
                <span id="time">[time]</span>
              </div>              
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
    <script src="<?= base_url()?>assets/global/vendor/select2/select2.full.min.js"></script>
    <script src="<?= base_url()?>assets/global/vendor/bootstrap-select/bootstrap-select.js"></script>
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

    <!-- Form -->
        <script src="<?= base_url()?>assets/global/js/Plugin/select2.js"></script>
        <script src="<?= base_url()?>assets/global/js/Plugin/bootstrap-select.js"></script>
    
    <script>
      var myTimeout;
      (function(document, window, $){
        'use strict';
    
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);

      function getupdate(){   
        var id=$("#trans").val();         
          $.ajax({
              type: 'post',
              url: '<?= base_url()?>testing/demo/getroom/',
              data: {"id":id},
              success: function (result){
                  if(result){
                      $("#myloc").css('display','block');
                      room = result["room"];
                      lastdate = result["lastdate"];
                      $("#room").html(room);
                      $("#time").html(lastdate);
                  }                                       
                  myTimeout = setTimeout(() => {
                      getupdate()
                  }, 30000);
              }
          });
      }

      jQuery(function($){
        $("#src").click(function(){
            if(myTimeout){
              clearTimeout(myTimeout);
            }
            getupdate();
        });      
      });

    </script>
  </body>
</html>
