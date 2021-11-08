<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Devices Groups Data</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>devicegroups">Devices Groups</a></li>
    <li class="breadcrumb-item active">Data</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-12">
      <div class="panel">
        <header class="panel-heading">
          <div class="panel-actions"></div>
          <h3 class="panel-title">List of Data : <?= $data->name; ?></h3>
        </header>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-15">
                <button id="addToTable" class="btn btn-primary waves-effect waves-classic" type="button">
                  <i class="icon md-refresh " aria-hidden="true"></i> <b id="newMessage"></b> New Data, Reload to show data
                </button>
              </div>
            </div>
          </div>
          <table class="table table-hover dataTable table-striped w-full" id="example">
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("footer.php") ?>
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
      index: 'group-<?= $data->code_name ?>',
          client: client,
          execpt:['raw_message','date_add_sensor_unix','date_add_server_unix','topic','token_access','ip_sender']
    },function(result){
      tables = $('#example').dataTable( {
          'columns':result,
          "scrollX": true,
          "searching": false,
          'bProcessing': true,
          'bServerSide': true,
          'fnServerData': $.fn.dataTable.elastic_datatables( {
              index: 'group-<?= $data->code_name ?>',
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
                      "match_all": {}
                  } 
              },
          } )
      } );

      $("#example_info").removeAttr('aria-live');

    });

    //--------------------------------------------///
    //////MQTT SETTING/////
    var mqtt;
      var reconnectTimeout = 2000, host = '<?= $this->config->item('host_mqtt')?>', port = <?= $this->config->item('port_mqtt')?>,topic = 'mqtt/elastic/group-<?= $data->code_name; ?>';

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
      console.lo(message)
      new_message++;     
      $("#newMessage").html(new_message); 
      $("#addToTable").show();
    };

    MQTTconnect();
    //--------------------------------------------///  

  });
</script>