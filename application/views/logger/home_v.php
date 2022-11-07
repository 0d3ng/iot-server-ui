<?php include("header.php") ?>
<div class="page-content">
  <div class="row row-lg mt-20">
    <div class="col-md-12">
      <div class="panel panel-primary panel-line">
        <div class="panel-heading">
          <form method="GET">
            <div class="panel-title">
                <div style="display:flex">
                    <h4 style="color: #3f51b5;">Data</h4>
                    <div class="input-group" style="margin-left: 20px; max-width:200px; float:left;">
                        <select name="channel" data-plugin="selectpicker" data-style="btn-primary">
                            <?php foreach($channel_list as $i){ ?>
                            <option <?= ($i == $channel)?'selected':'' ?> value="<?= $i ?>" >Channel <?=  $i?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>        
            <div class="panel-actions" style="text-align: right;">
                <div class="input-group">
                    <span class="input-group-addon">
                    <i class="icon md-calendar" aria-hidden="true"></i>
                    </span>
                    <input type="text" class="form-control" name="date" data-plugin="datepicker" value="<?= $date; ?>">
                    <button type="submit" id="ceks" class="btn btn-sm btn-primary waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic" style="float:right;margin-left:10px">Apply</button>
                </div>
            </div>
          </form>
        </div>
        <div class="panel-body">
          <div id="chart" ></div>
        </div>
      </div>
    </div>
  </div>
  <?php
        ///Convert
        $fd = "ch_".$channel;
        $sensor_data = array();
        if($sensor){
          foreach($sensor as $d){
            $itemdata = (array)$d;
            if(!empty($itemdata)){
                if(!isset($itemdata[$fd])){
                    continue;
                } else if(is_string($itemdata[$fd])){
                    continue;
                } else if(!is_numeric($itemdata[$fd])){
                    $values = 0;
                } else {
                    $values = $itemdata[$fd];
                }       
                $sensor_data[] = [$itemdata['date_add_server']->{'$date'},$values];            
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
    Highcharts.stockChart('chart', {
    chart: {
        events: {
            load: function () {
                var series = this.series[0];
                mychart = series; 
            }
        }
    },

    time: {
        useUTC: false
    },
    legend: {
        enabled: true
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
        text: 'CHANEL <?= $channel?> DATA'
    },

    exporting: {
        enabled: false
    },

    series: [{
        name: 'Temperature (<span>&#176;</span>C) ',
        data: <?php echo json_encode($sensor_data); ?>
    }]
    });
    
    
    //--------------------------------------------///
    //////MQTT SETTING/////
    var mqtt;
    var reconnectTimeout = 2000, host = '<?= $this->config->item('host_mqtt')?>', port = <?= $this->config->item('port_mqtt')?>,topic = '<?= $mqtt; ?>';

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
      addValue(msg);
    };

    <?php if($date == date("Y-m-d")){ ?>
    MQTTconnect();
    <?php } ?>
    
    //--------------------------------------------///  
  });
</script>
