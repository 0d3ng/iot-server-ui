<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Experiment</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>logger/home">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>logger/experiment">Experiment</a></li>
    <li class="breadcrumb-item active">Add</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>

<div class="page-content">
    <div class="row row-lg">
        <div class="col-md-12 col-lg-8">
            <div class="panel">
                <div class="panel-body container-fluid">
                <!-- Example Basic Form (Form grid) -->
                <div class="example-wrap">
                    <h4 class="example-title">Form - Add Experiment Data</h4>
                    <div class="example">
                    <form method="post" autocomplete="off">
                        <div class="form-group form-material ">
                            <label class="form-control-label" for="inputString-config">Configuration</label>
                            <select class="form-control " id="inputSelectConfig" name="config">
                                <option value="" selected>Select Configuration Template</option>
                                <?php
                                $config = array();
                                foreach ($configration as $d) { ?>
                                <option value="<?= $d->template_code?>" >[<?= $d->template_code?>] <?= $d->configuration_name?></option>
                                <?php 
                                $config[$d->template_code] = $d;
                                if( isset($config[$d->template_code]->template_code) )
                                    unset($config[$d->template_code]->template_code);
                                if( isset($config[$d->template_code]->_id) )
                                    unset($config[$d->template_code]->_id);

                                } ?>
                            </select>

                        </div>
                        <div class="form-group form-material ">
                            <label class="form-control-label" for="inputString-experiment_code">Code</label>
                            <input type="text" class="form-control" id="inputString-experiment_code" name="experiment_code" value="<?= $code; ?>" autocomplete="off">
                        </div>
                        <div class="form-group form-material ">
                            <label class="form-control-label" for="inputString-email">Email Target</label>
                            <input type="text" class="form-control" id="inputEmail" name="email_target" value="" autocomplete="off">
                        </div>
                        <div class="form-group form-material ">
                            <label class="form-control-label" for="inputInt-temperature">Temperature Target (<span>&#176;</span>C)</label>
                            <input type="number" class="form-control" id="inputTemperature" name="temperature_target" value="" autocomplete="off">
                        </div>
                        <div class="form-group form-material ">
                            <label class="form-control-label" for="inputDate-timer">Timer</label>
                            <input type="text" class="form-control" data-plugin="clockpicker" data-autoclose="true" id="inputTimer" name="timer" autocomplete="off">
                        </div>
                        <div class="form-group form-material ">
                            <label class="form-control-label" for="inputInt-reminder">Number of Email Notifications</label>
                            <input type="number" class="form-control" id="inputReminder" name="reminder" value="" autocomplete="off">
                        </div>
                        <div class="form-group form-material">
                        <button type="submit" name="save" value="save" class="btn btn-primary">Start New Experiment</button>&nbsp; &nbsp; 
                        <a href="<?= base_url();?>logger/experiment">
                            <button type="button" class="btn btn-default">Cancel</button>
                        </a>
                        </div>
                    </form>
                    </div>
                </div>
                <!-- End Example Basic Form -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php") ?>
<!--   -->

<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/tableExport.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/jspdf.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/moment/moment.js"></script>
<script src="<?= base_url()?>assets/js/mqttws31.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/bootstrap-table.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/extensions/export/bootstrap-table-export.js"></script>
<script src="<?= base_url()?>assets/global/vendor/clockpicker/bootstrap-clockpicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/clockpicker.js"></script>
<!-- <script src="<?= base_url()?>assets/examples/js/tables/bootstrap.js"></script> -->
<script>
  
  var config = JSON.parse('<?php echo json_encode($config); ?>');
  
  $( document ).ready(function() {
    $('input').on('ifChecked', function(event){
      $(".search-time").removeAttr('disabled');
    });
    $('input').on('ifUnchecked', function(event){
      $(".search-time").attr('disabled','disabled');
    });

    // Override global options
    toastr.options = {
      positionClass: 'toast-top-center'
    };
    <?php if($success){ ?>
      toastr.success('<?= $success; ?>', 'Success, Experiment is Running', {timeOut: 3000});          
    <?php }  
    if($error){ ?>
        toastr.error('<?= $error; ?>', 'Failed', {timeOut: 3000});    
    <?php } ?>
    
    $("#inputSelectConfig").change(function(){
        var code = $("#inputSelectConfig").val();
        if( code in  config){
            item = config[code];
            $("#inputEmail").val(item["email_target"]);
            $("#inputTemperature").val(item["temperature_target"]);
            $("#inputTimer").val(item["timer"]);
            $("#inputReminder").val(item["reminder_count"]);
        }
    });

  });
</script>