<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Devices Data</h1>
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
          <?php if(!empty($group)){ ?>
          <li>
            <strong>Devices Group :</strong> <?= $group->name; ?></li>
          <?php } ?>
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
                    <div class="input-daterange" data-plugin="datepicker">
                      <label for="lastData">Search From:</label> 
                      <div class="form-group">
                          <div class="input-group input-group-icon" style=" width: 100%; float: none; ">
                            <input type="text" class="form-control search-date" name="start" value="<?= $date_str?>" <?= (empty($search))?"disabled":""; ?> >
                            <span class="input-group-addon">
                              <span class="icon md-calendar" aria-hidden="true"></span>
                            </span>
                          </div>
                      </div> 
                      <label for="lastData">To:</label> 
                      <div class="form-group">
                          <div class="input-group input-group-icon" style=" width: 100%; float: none; ">
                            <input type="text" class="form-control search-date" name="end" value="<?= $date_end?>" <?= (empty($search))?"disabled":""; ?>>
                            <span class="input-group-addon">
                              <span class="icon md-calendar" aria-hidden="true"></span>
                            </span>
                          </div>
                      </div> 
                    </div>
                  </div>
                  <div class="dropdown-divider"></div>
                  <div id="checkbox-search" class="dropdown-item-form" >
                    <input type="checkbox" class="icheckbox-primary" id="searchState" name="search"
                              data-plugin="iCheck" data-checkbox-class="icheckbox_flat-blue" <?= (empty($search))?"":"checked"; ?>/>
                      <label for="lastData">Search By Date</label>
                      <button type="submit" id="ceks" class="btn btn-sm btn-primary waves-effect waves-classic waves-effect waves-classic" style="float:right;margin-top: -5px;">Apply</button>
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
          <?php if( ($search) ){ ?>
          <div class="panel-actions" style="text-align: right;">
            <?= ($date_end != $date_str)?$date_str." <i>to</i> ".$date_end:$date_str; ?>
          </div>
          <?php } ?>
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
        if($sensor){
          foreach($sensor as $d){
            $itemdata = (array)$d;
              if(!empty($itemdata)){
              foreach($listfield as $fd){    
                if(!isset($itemdata[$fd])){
                  $values = '';
                } else if(!is_numeric($itemdata[$fd])){
                  $values = 0;
                } else {
                  $values = $itemdata[$fd];
                }       
                $sensor_data[$fd][] = [$itemdata['date_add_server']->{'$date'},$values];            
              }
            }          
          }
        } 
    ?>
</div>

<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/global/vendor/moment/moment.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/bootstrap-datepicker.js"></script>
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
  var listfield = ["id","lq","x","y","z","accel"];
  $( document ).ready(function() {
    $(".dropdown-menu-right").click(function(e){
      e.stopPropagation();
    })    
    $('input').on('ifChecked', function(event){
      $(".search-date").removeAttr('disabled');
    });
    $('input').on('ifUnchecked', function(event){
      $(".search-date").attr('disabled','disabled');
    });
    // Create the chart
          Highcharts.stockChart('chart_id', {
        chart: {
          events: {
            load: function () {
              var series = this.series[0];
              mychart['id'] = series; 
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
          text: 'ID DATA'
        },

        exporting: {
          enabled: false
        },

        series: [{
          name: 'id',
          data: [[1648787105000,4],[1648787106000,4],[1648787107000,4],[1648787108000,4],[1648787109000,4],[1648787110000,4],[1648787111000,4],[1648787112000,4],[1648787113000,4],[1648787114000,4],[1648787115000,4],[1648787116000,4],[1648787119000,4],[1648787120000,4],[1648787121000,4],[1648787123000,4],[1648787124000,4],[1648787125000,4],[1648787125000,4],[1648787126000,4],[1648787127000,4],[1648787129000,4],[1648787130000,4],[1648787132000,4],[1648787132000,4]]        }]
      });
          Highcharts.stockChart('chart_lq', {
        chart: {
          events: {
            load: function () {
              var series = this.series[0];
              mychart['lq'] = series; 
            }
          }
        },

        time: {
          useUTC: false
        },
        legend:{
          enabled:true
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
          text: 'RAW LQI DATA'
        },
        rangeSelector : {
            enabled: false
        },
        navigator: {
            enabled: false
        },
        exporting: {
          enabled: false
        },
        yAxis: [{
            lineWidth: 1,
            opposite: false,
            title:"LQI"
        }],
        xAxis: [{
            title:"Time"
        }],
        series: [
          { 
            name: 'Device 1',
            data: [[1648787103000,54],[1648787104000,51],[1648787105000,51],[1648787106000,54],[1648787107000,54],[1648787108000,57],[1648787109000,51],[1648787110000,54],[1648787111000,51],[1648787112000,48],[1648787113000,51],[1648787114000,51],[1648787115000,51],[1648787116000,51],[1648787117000,51],[1648787118000,57],[1648787119000,54],[1648787120000,48],[1648787121000,51],[1648787122000,51],[1648787123000,54],[1648787124000,51],[1648787125000,54],[1648787126000,51],[1648787127000,51],[1648787128000,51],[1648787129000,51],[1648787130000,54],[1648787131000,51],[1648787132000,54]]
          },
          { 
            name: 'Device 2',
            data: [[1648787105000,39],[1648787106000,45],[1648787107000,42],[1648787108000,42],[1648787109000,48],[1648787110000,39],[1648787111000,45],[1648787112000,39],[1648787113000,48],[1648787114000,48],[1648787115000,42],[1648787116000,48],[1648787119000,42],[1648787120000,42],[1648787121000,42],[1648787123000,48],[1648787124000,48],[1648787125000,48],[1648787125000,39],[1648787126000,42],[1648787127000,48],[1648787129000,48],[1648787130000,42],[1648787132000,39],[1648787132000,42]]
          },
          { 
            name: 'Device 3',
            data: [[1648787104000,48],[1648787104000,48],[1648787105000,48],[1648787106000,48],[1648787106000,48],[1648787107000,48],[1648787108000,42],[1648787110000,48],[1648787112000,45],[1648787113000,45],[1648787114000,48],[1648787115000,45],[1648787115000,42],[1648787116000,45],[1648787117000,48],[1648787119000,45],[1648787120000,48],[1648787121000,48],[1648787122000,45],[1648787123000,48],[1648787124000,45],[1648787125000,45],[1648787126000,48],[1648787128000,48],[1648787129000,48],[1648787130000,48],[1648787131000,48],[1648787132000,42]]
          },
        ]
      }
      );
      
      
      
      Highcharts.stockChart('chart_x', {
        chart: {
          events: {
            load: function () {
              var series = this.series[0];
              mychart['x'] = series; 
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
          text: 'X DATA'
        },

        exporting: {
          enabled: false
        },

        series: [{
          name: 'x',
          data: [[1648787105000,0],[1648787106000,0],[1648787107000,0],[1648787108000,0],[1648787109000,0],[1648787110000,0],[1648787111000,0],[1648787112000,0],[1648787113000,0],[1648787114000,0],[1648787115000,0],[1648787116000,0],[1648787119000,0],[1648787120000,0],[1648787121000,0],[1648787123000,0],[1648787124000,0],[1648787125000,0],[1648787125000,0],[1648787126000,0],[1648787127000,0],[1648787129000,0],[1648787130000,0],[1648787132000,0],[1648787132000,0]]        }]
      });
      Highcharts.stockChart('chart_y', {
        chart: {
          events: {
            load: function () {
              var series = this.series[0];
              mychart['y'] = series; 
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
          text: 'Y DATA'
        },

        exporting: {
          enabled: false
        },

        series: [{
          name: 'y',
          data: [[1648787105000,0],[1648787106000,0],[1648787107000,0],[1648787108000,0],[1648787109000,0],[1648787110000,0],[1648787111000,0],[1648787112000,0],[1648787113000,0],[1648787114000,0],[1648787115000,0],[1648787116000,0],[1648787119000,0],[1648787120000,0],[1648787121000,0],[1648787123000,0],[1648787124000,0],[1648787125000,0],[1648787125000,0],[1648787126000,0],[1648787127000,0],[1648787129000,0],[1648787130000,0],[1648787132000,0],[1648787132000,0]]        }]
      });
          Highcharts.stockChart('chart_z', {
        chart: {
          events: {
            load: function () {
              var series = this.series[0];
              mychart['z'] = series; 
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
          text: 'Z DATA'
        },

        exporting: {
          enabled: false
        },

        series: [{
          name: 'z',
          data: [[1648787105000,0],[1648787106000,0],[1648787107000,0],[1648787108000,0],[1648787109000,0],[1648787110000,0],[1648787111000,0],[1648787112000,0],[1648787113000,0],[1648787114000,0],[1648787115000,0],[1648787116000,0],[1648787119000,0],[1648787120000,0],[1648787121000,0],[1648787123000,0],[1648787124000,0],[1648787125000,0],[1648787125000,0],[1648787126000,0],[1648787127000,0],[1648787129000,0],[1648787130000,0],[1648787132000,0],[1648787132000,0]]        }]
      });
          Highcharts.stockChart('chart_accel', {
        chart: {
          events: {
            load: function () {
              var series = this.series[0];
              mychart['accel'] = series; 
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
          text: 'ACCEL DATA'
        },

        exporting: {
          enabled: false
        },

        series: [{
          name: 'accel',
          data: [[1648787105000,0],[1648787106000,0],[1648787107000,0],[1648787108000,0],[1648787109000,0],[1648787110000,1],[1648787111000,2],[1648787112000,3],[1648787113000,4],[1648787114000,5],[1648787115000,6],[1648787116000,7],[1648787119000,8],[1648787120000,9],[1648787121000,10],[1648787123000,11],[1648787124000,12],[1648787125000,14],[1648787125000,13],[1648787126000,15],[1648787127000,16],[1648787129000,17],[1648787130000,18],[1648787132000,20],[1648787132000,19]]        }]
      });
        
        
    //--------------------------------------------///
    //////MQTT SETTING/////
    var mqtt;
    var reconnectTimeout = 2000, host = 'localhost', port = 1884,topic = 'mqtt/output/device-lo15';

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
        if(msg.device_code == 'lo15'){
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
        if( values == "" ){
          values = "-";
        }
        $("#last-"+itemfield).html(values);
      }
      var timestamp = moment.unix(data['date_add_server_unix']/1000);
      $("#last-date").html(timestamp.format("YYYY-MM-DD HH:mm:ss")); 
    }
  }
  lastdata(JSON.parse('{"_id":"6292ce7be4670000e1003ed8","accel":19,"channel_type":"mqtt","date_add_server":{"$date":1648787132000},"date_add_server_unix":"1.64879E+12","device_code":"lo15","id":4,"lq":42,"topic":"\/Project_IPS\/client23","x":0,"y":0,"z":0}'));
</script>