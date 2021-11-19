<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Devices Groups Data</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device">Devices</a></li>
    <li class="breadcrumb-item active">Data</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-6">
      <div class="pricing-list text-left">
        <div class="pricing-header bg-blue-600">
          <div class="pricing-title">Device Info</div>
          <div class="pricing-price" style="padding-top:0px; padding-bottom: 0px;font-size: 2.858rem;">
            <span class="pricing-currency"><i class="icon wb-memory" aria-hidden="true"></i></span>
            <span class="pricing-amount"><?= $data->name; ?></span>            
          </div>
          <p class="px-30 font-size-16" ><strong>Device Code</strong>: <i><?= $data->device_code; ?></i></p>
        </div>
        <ul class="pricing-features font-size-16" style="background-color: #fff;" >
          <li>
            <strong>Location :</strong> <?= $data->information->location; ?></li>
          <li>
            <strong>Purpose :</strong> <?= $data->information->purpose; ?></li>
          <li>
            <strong>Devices Group :</strong> <?= $group->name; ?></li>
          <li>
            <strong>Detail Infomation :</strong> <?= $data->information->detail; ?></li>
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel-bordered panel-success">
      <div class="panel-heading">
          <h3 class="panel-title"><i class="icon wb-info" aria-hidden="true"></i> &nbsp;Last Data</h3>
          <!-- <h3 class="panel-title"> &nbsp;Last Data</h3> -->
          <div class="panel-actions" style="text-align: right;">
            <form method="GET">
              <div class="btn-group dropdown">
                <button type="button" class="btn btn-success dropdown-toggle" id="BulletDropdown2"
                  data-toggle="dropdown" aria-expanded="false">
                  <i class="icon wb-time" aria-hidden="true"></i> Search
                </button>
                <div class="dropdown-menu bullet dropdown-menu-right" aria-labelledby="BulletDropdown2"
                  role="menu">
                  <div class="dropdown-item-form">
                      <label for="lastData">Search From:</label> 
                      <div class="form-group">
                          <div class="input-group input-group-icon">
                            <input type="text" class="form-control search-date" name="start" value="<?= $date_str?>" <?= (empty($search))?"disabled":""; ?> >
                            <span class="input-group-addon">
                              <span class="icon md-calendar" aria-hidden="true"></span>
                            </span>
                          </div>
                      </div> 
                      <label for="lastData">To:</label> 
                      <div class="form-group">
                          <div class="input-group input-group-icon">
                            <input type="text" class="form-control search-date" name="end" value="<?= $date_end?>" <?= (empty($search))?"disabled":""; ?> >
                            <span class="input-group-addon">
                              <span class="icon md-calendar" aria-hidden="true"></span>
                            </span>
                          </div>
                      </div> 
                  </div>
                  <div class="dropdown-divider"></div>
                  <div id="checkbox-search" class="dropdown-item-form" >
                    <input type="checkbox" class="icheckbox-primary" id="searchState" name="search"
                              data-plugin="iCheck" data-checkbox-class="icheckbox_flat-blue" <?= (empty($search))?"":"checked"; ?>/>
                      <label for="lastData">Search Active</label>
                      <button type="button" id="ceks" class="btn btn-sm btn-primary waves-effect waves-classic waves-effect waves-classic" style="float:right;margin-top: -5px;">Apply</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <ul class="list-group list-group-bordered mb-0" style="font-size:15px;">
            <?php foreach($extract as $d){ ?>
            <li class="list-group-item">
              <span class="badge badge-pill badge-success" id="last-<?= $d ?>" style="padding:5px 10px;">-</span>
              <?= strtoupper( str_replace("_", " ", str_replace("-"," - ",$d)) ); ?>
            </li>
            <?php } ?>
            <li class="list-group-item">
              <span class="badge badge-pill badge-success" id="last-date" style="padding:5px 10px;">-</span>
              DATA DATE TIME
            </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row row-lg mt-20">
    <?php 
      $listfield = array(); 
      foreach($data->field as $d){         
        $listfield[] = $d;
    ?>
    <div class="col-md-6">
      <div class="panel panel-primary panel-line">
        <div class="panel-heading">
          <h3 class="panel-title"><?= strtoupper( str_replace("_", " ", str_replace("-"," - ",$d)) ); ?></h3>
        </div>
        <div class="panel-body">
          <div id="chart_<?= $d ?>" ></div>
        </div>
      </div>
    </div>
    <?php } ?>

  </div>
  <?php
        ///Convert
        $sensor_data = array();
        foreach($listfield as $d){
          $sensor_data[$d] = array();
        }
        foreach($sensor as $d){
          $itemdata = (array)$d;
            if(!empty($itemdata)){
            foreach($listfield as $fd){           
              $sensor_data[$fd][] = [$itemdata['date_add_server_unix'],(isset($itemdata[$fd]))?$itemdata[$fd]:''];            
            }
          }
          $lastdata = (array)$d;
        } 
    ?>
</div>

<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/global/vendor/moment/moment.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/highstock.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/exporting.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/export-data.js"></script>
<script src="<?= base_url()?>assets/js/mqttws31.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/icheck/icheck.min.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/icheck.js"></script>

<script>
  var myLine = [], lineChart = []; 
  var mychart = [];
  var listfield = <?php echo json_encode($listfield); ?>;
  $( document ).ready(function() {
    $(".dropdown-menu-right").click(function(e){
      e.stopPropagation();
    })
    // $("#searchState").click(function(e){
    //   if(this.checked){
    //     $(".search-date").removeAttr('disabled');
    //   } else {
    //     $(".search-date").attr('disabled','disabled');
    //   }
    // });
    $("#checkbox-search").change(function(e){
      console.log('changed');
    });
    // Create the chart
    <?php foreach($listfield as $d){ ?>
      Highcharts.stockChart('chart_<?= $d ?>', {
        chart: {
          events: {
            load: function () {
              var series = this.series[0];
              mychart['<?= $d ?>'] = series; 
            }
          }
        },

        time: {
          useUTC: false
        },

        rangeSelector: {
          buttons: [{
            count: 10,
            type: 'minute',
            text: '5M'
          }, {
            count: 1,
            type: 'hours',
            text: '1H'
          }, {
            count: 1,
            type: 'days',
            text: '1D'
          },
          {
            type: 'all',
            text: 'All'
          }],
          inputEnabled: false,
          selected: 0
        },

        title: {
          text: '<?= strtoupper( str_replace("_", " ", str_replace("-"," - ",$d)) ); ?> DATA'
        },

        exporting: {
          enabled: false
        },

        series: [{
          name: '<?= str_replace("_", " ", str_replace("-"," - ",$d)) ; ?>',
          data: <?php echo json_encode($sensor_data[$d]); ?>
        }]
      });
    <?php } ?>

    //--------------------------------------------///
    //////MQTT SETTING/////
    var mqtt;
    var reconnectTimeout = 2000, host = '<?= $this->config->item('host_mqtt')?>', port = <?= $this->config->item('port_mqtt')?>,topic = 'mqtt/output/group-<?= $group->code_name; ?>';

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
      console.log("subscribe topic: "+topic);
    }

    function onConnectionLost(response) {
      setTimeout(MQTTconnect, reconnectTimeout);
      console.log("connection lost: " + response.errorMessage + ". Reconnecting");
    };

    function onMessageArrived(message) {
      var msg = JSON.parse(message.payloadString);
      if(msg.device_code){
        if(msg.device_code == '<?= $data->device_code?>'){
          addValue(msg);
        }
      }
    };

    MQTTconnect();
    //--------------------------------------------///  
  });
  
  function addValue(data){
    for( let i=0; i<listfield.length; i++ ){
      var itemfield = listfield[i];
      var values = '';         
      if( itemfield in data){
        values = data[itemfield];         
      }
      var data_time = data['date_add_server_unix'] 
      mychart[itemfield].addPoint([data_time,values],true,true);
    }
    lastdata(data);
  }

  function lastdata(data){
    console.log(data);
    if(data){
      for( let i=0; i<listfield.length; i++ ){
        var itemfield = listfield[i];
        var values = '';         
        if( itemfield in data){
          values = data[itemfield];         
        }
        $("#last-"+itemfield).html(values);
      }
      var timestamp = moment.unix(data['date_add_server_unix']/1000);
      $("#last-date").html(timestamp.format("YYYY-MM-DD HH:mm:ss")); 
    }
  }
  lastdata(JSON.parse('<?= (!empty($lastdata))?json_encode($lastdata):''; ?>'));
</script>