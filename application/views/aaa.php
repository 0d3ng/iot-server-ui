<div class="col-md-12" >
        <div class="panel">
          <header class="panel-heading">
            <div class="panel-actions"></div>
            <h3 class="panel-title">Dashboard Widget Panel - Graph of Data : Gyro Sensor </h3>
            <div class="panel-actions">
              <a class="panel-action icon md-minus" aria-expanded="true" data-toggle="panel-collapse" aria-hidden="true"></a>
              <a class="panel-action icon md-fullscreen" data-toggle="panel-fullscreen" aria-hidden="true"></a>
              <a class="btn btn-danger waves-effect waves-classic text-white" onclick="removeGroup(3);"><i class="icon md-delete " aria-hidden="true"></i> Remove Group Data</a>
            </div>
          </header>
          <div class="panel-body">
            <div class="row">
            <iframe src="http://localhost:5601/app/visualize#/edit/d0f7c2c0-12b9-11eb-b447-9df40a6a4f62?embed=true&_g=(filters%3A!()%2CrefreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-15m%2Cto%3Anow))" class="col-md-12" height="600" ></iframe>
            </div>
          </div>
        </div>
      </div> 



      <script src="<?= base_url()?>assets/js/elastic/elasticsearch.js"></script>
<script src="<?= base_url()?>assets/js/elastic/jquery.elastic-datatables.js"></script>
<script src="<?= base_url()?>assets/js/mqttws31.js"></script>

<script type="text/javascript">
  var tables,new_message=0;
  $("#addToTable").click(function(){
    tables.fnClearTable();
    new_message=0;
    $("#addToTable").hide();
  });

  $( document ).ready(function() {
    $("#addToTable").hide();
    // Override global options
    toastr.options = {
      positionClass: 'toast-top-center'
    };
    <?php if($success){ ?>
      toastr.success('<?= $success; ?>', 'Success', {timeOut: 3000})
    <?php }  
    if($error){ ?>
        toastr.error('<?= $error; ?>', 'Failed', {timeOut: 3000});
    <?php } ?>
    
    var client = elasticsearch.Client({
      host: '<?= $this->config->item('url_elastic')?>',
      method: 'POST'
    });

    $.fn.dataTable.getMapping({
      index: 'group-<?= $group->code_name ?>',
          client: client,
          execpt:['raw_message','date_add_sensor_unix','date_add_server_unix','topic','token_access','ip_sender']
    },function(result){
      console.log(result);
      tables = $('#example').dataTable( {
          'columns':result,
          "scrollX": true,
          "searching": false,
          'bProcessing': true,
          'bServerSide': true,
          'fnServerData': $.fn.dataTable.elastic_datatables( {
              index: 'group-<?= $group->code_name ?>',
              type: 'authors',
              client: client,
              columnsList:result,
              body:{
                size:15,
                sort: [
                      {
                          "date_add_server":  "desc"
                      }
                  ],
                  query: {
                      "match_phrase": {
                        "device_code": "<?= $data->device_code; ?>"
                      }
                  } 
              }
          } )
      } );
      $("#example_info").removeAttr('aria-live');

    })

    //--------------------------------------------///
    //////MQTT SETTING/////
    var mqtt;
    var reconnectTimeout = 2000, host = '<?= $this->config->item('host_mqtt')?>', port = <?= $this->config->item('port_mqtt')?>,topic = 'mqtt/elastic/group-<?= $group->code_name; ?>';

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
          new_message++;     
          $("#newMessage").html(new_message); 
          $("#addToTable").show();  
        }
      }
    };

    MQTTconnect();
    //--------------------------------------------///  

  });
</script>