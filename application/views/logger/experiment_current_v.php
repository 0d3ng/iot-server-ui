<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Experiment</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>logger/home">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>logger/experiment">Experiment</a></li>
    <li class="breadcrumb-item active">Current</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>

<div class="page-content">
    <div class="row row-lg">
        <div class="col-md-6">
            <div class="pricing-list text-left">
                <div class="pricing-header bg-blue-600">
                    <div class="pricing-title">Experiment Info</div>
                    <div class="pricing-price" style="padding-top:0px; padding-bottom: 0px;font-size: 2.858rem;">
                        <span class="pricing-currency"><i class="icon md-collection-text" aria-hidden="true"></i></span>
                        <span class="pricing-amount" id="status"><strong>Code</strong>: <i><?= $data->experiment_code ?></span>            
                    </div>
                </div>
                <ul class="pricing-features font-size-16" style="background-color: #fff;">
                <li><strong>Temperature Target :</strong> <?= $data->temperature_target ?> <span>&#176;</span>C</i></li>
                <li><strong>Email Target :</strong> <?= $data->email_target ?>   </li>
                <li><strong>Timer :</strong> <?= $data->timer ?> </li>
                <li><strong>Number of Email Notifications :</strong> <?= $data->reminder ?> Times </li>
                </ul>
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
      toastr.success('<?= $success; ?>', 'Success, Experiment is Starting', {timeOut: 3000});          
    <?php }  
    if($error){ ?>
        toastr.error('<?= $error; ?>', 'Failed', {timeOut: 3000});    
    <?php } ?>
    
    //--------------------------------------------///
    //////MQTT SETTING/////
    var mqtt;
    send = false;
    var reconnectTimeout = 2000, host = '<?= $this->config->item('host_mqtt')?>', port = <?= $this->config->item('port_mqtt')?>, topic = 'logger/update';

    function MQTTconnect() {
        mqtt = new Paho.MQTT.Client(
            host,
            port,
            "web_" + parseInt(Math.random() * 100, 10)
        );
        var options = {
            timeout: 3,
            onSuccess: onConnect,
            onFailure: function (message) {
                console.log("Connection failed: " + message.errorMessage + "Retrying");
                setTimeout(MQTTconnect, reconnectTimeout);
            }
        };
        mqtt.onConnectionLost = onConnectionLost;
        mqtt.onMessageArrived = onMessageArrived;        
        console.log("Host="+ host + ", port=" + port);
        mqtt.connect(options);
    }

    function onConnect() {
      mqtt.subscribe(topic, {qos: 0});      
      if(send == false){
        message = new Paho.MQTT.Message('{"experiment_code":"<?= $data->experiment_code ?>"}');
        message.destinationName = "logger/start2";
        mqtt.send(message);
        send = true;
      }

      console.log("subscribe topic: "+topic);
    }

    function onConnectionLost(response) {
      setTimeout(MQTTconnect, reconnectTimeout);
      console.log("connection lost: " + response.errorMessage + ". Reconnecting");
    };

    function onMessageArrived(message) {
      console.log(message)
    };

    MQTTconnect();
    
    
    //--------------------------------------------///  

  });
</script>