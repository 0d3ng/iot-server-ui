<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Data Synchronization Service Batch Process</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>datasync">Filter</a></li>
    <li class="breadcrumb-item active">Simulation</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>
<div class="page-content">
  <form method="POST" id="formSeach" >
    <div class="row row-lg">
      <div class="col-md-6">
        <div class="panel-bordered panel-success">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="icon wb-memory" aria-hidden="true"></i> &nbsp;Select Device</h3>
          </div>
          <div class="panel-body bg-white">
              <div class="form-group form-material" id="selectGroup">
                  <label class="form-control-label" for="inputDevice">Device</label>
                  <select class="form-control " id="inputDevice" name="device" onchange="deviceForm()" required>
                    <option value="">--- Select Device Data---</option>
                    <?php foreach ($data as $d) { ?>
                      <option value="<?= $d->device_code?>"><?= $d->name?> [<?= $d->device_code?>] </option>
                    <?php } ?>
                  </select>
              </div>   
              <div class="form-group form-material" id="selectGroup">
                  <label class="form-control-label" for="inputField">Data Field</label>
                  <select class="form-control " id="inputField" name="field" required>
                      <option value="">--- Select Field---</option>
                  </select>
              </div>     
          </div>
        </div>  
        <div class="panel-bordered panel-success mt-10">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="icon wb-memory" aria-hidden="true"></i> &nbsp;Select Filter Method</h3>
          </div>
          <div class="panel-body bg-white">
              <div class="form-group form-material">
                  <label class="form-control-label" for="inputMethod">Method</label>
                  <select class="form-control " id="inputMethod" name="method" onchange="methodForm()">
                    <option value="">--- Select Method---</option>
                    <?php 
                    $method_list = array();
                    foreach ($method as $d) { 
                    $method_list[$d->name] = $d;
                    ?>
                      <option value="<?= $d->name ?>"><?= $d->label ?></option>
                    <?php } ?>
                  </select>
              </div>   
              <div id="params">
                  
              </div>     
          </div>
        </div>  
      </div>
      <div class="col-md-6">
        <div class="panel-bordered panel-success">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="icon wb-time" aria-hidden="true"></i> &nbsp;Search Data</h3>
          </div>
          <div class="panel-body bg-white">
              <!-- Example Date Range -->
              <div class="example-wrap">
                  <h4 class="example-title">Date Range Data</h4>                
                  <div class="example">
                      
                    <div class="row">
                        <div class="form-group form-material col-md-12 col-xl-6">
                            <label class="form-control-label" for="inputDate">From</label>
                            <div class="form-group form-material row">
                                <div class="col-6">
                                    <input type="text" class="form-control" data-plugin="datepicker" id="inputDateStart" name="date_start" value="<?= date("Y-m-d") ?>" autocomplete="off" required>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control " data-autoclose="true" data-plugin="clockpicker" id="inputTimeStart" name="time_start" value="<?= date("H:i") ?>" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-material col-md-12 col-xl-6">
                            <label class="form-control-label" for="inputDate">To</label>
                            <div class="form-group form-material row">
                                <div class="col-6">
                                    <input type="text" class="form-control" data-plugin="datepicker" id="inputDateEnd" name="date_end" value="<?= date("Y-m-d") ?>" autocomplete="off" required>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control " data-autoclose="true" data-plugin="clockpicker" id="inputTimeEnd" name="time_end" value="<?= date("H:i") ?>" autocomplete="off" required>
                                </div>
                            </div>
                        </div>   
                    </div>
                    <div class="form-group form-material">
                        <span class="input-group-addon" style="background:none; border:none;"> </span>
                        <button type="submit" class="btn btn-primary waves-effect waves-classic">Search Sensor Data</button>
                    </div>    
                      
                  </div>
              </div>
              <!-- End Example Date Range -->
          </div>
        </div>      
      </div>
    </div>
  </form>
  <div class="row row-lg mt-20">
    <div class="col-md-12">
      <div class="panel panel-primary panel-line">
        <div class="panel-heading">
          <h3 class="panel-title">Data Filter Simulation</h3>
        </div>
        <div class="panel-body">
          <div id="chart" ></div>
        </div>
      </div>
    </div>
  </div> 
</div>

<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/global/vendor/moment/moment.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/vendor/clockpicker/bootstrap-clockpicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/clockpicker.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/highstock.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/exporting.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/export-data.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/icheck/icheck.min.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/icheck.js"></script>

<script>
  function deviceForm(){
    var device = $("#inputDevice").val();
    $.ajax({
        type: 'post',
        url: '<?= base_url()?>datasync/device/'+device,
        data: {},
        success: function (result){
          var item = "";
          var collect = result.collect;
          for (let i = 0; i < result.field.length; i++) {
            item+='<option value="'+result.field[i]+'">'+result.field[i]+'</option>';
          }
          var field='<option value="">--- Select Field---</option>'+item;
          $("#inputField").html(field);
        }
    });
  }
  var mychart1, mychart2;
  var method_list = <?php echo json_encode($method_list); ?>;
  function chart_build(field,data,filter){
    Highcharts.stockChart('chart', {
      chart: {
          events: {
              load: function() {
                  var series = this.series[0];
                  var series2 = this.series[1];
                  mychart1 = series;
                  mychart2 = series2;
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
              }
          ],
          inputEnabled: false,
          selected: 0
      },

      title: {
          text: field+' DATA'
      },
      exporting: {
          enabled: false
      },
      
      yAxis: [{
          lineWidth: 1,
          opposite: false,
          title: field
      }],
      xAxis: [{
          title: "Time"
      }],
      series: [{
              name: 'Real Data',
              data: data,
              turboThreshold:200000
          },
          {
              name: 'Filtered Data',
              data: filter,
              turboThreshold:200000
          }
      ]
    });  
  }

  function filtering(device,field,method,params,startdate,starttime,enddate,endtime){
    var params = JSON.stringify(params);
    console.log(params);
    $.ajax({
        type: 'post',
        url: '<?= base_url()?>filter/process/'+device,
        data: {'method':method,"field":field,"params":params,"date_start":startdate,"time_start":starttime,"date_end":enddate,"time_end":endtime},
        success: function (result){
          console.log(result);
          filter = result['filter'];
          data = result['data'];
          field = result['field'];
          chart_build(field,data,filter); 
        }
    });
  }

  function methodForm(){
    var method = $("#inputMethod").val(); 
    $("#params").html(""); 
    if(method != ""){
      var params = method_list[method]["params"];    
      for (var i = 0; i < params.length; i++) {
        var obj = params[i];
        if(obj["type"] == "float"){
          var item_form = '<div class="form-group form-material ">'+
                '<label class="form-control-label" for="input'+obj['name']+'">'+obj['label']+'</label>'+
                '<input type="number" class="form-control inputparams" id="input'+obj['name']+'" name="'+obj['name']+'" value="" step="any" autocomplete="off">'+
              '</div>';
        }
        $("#params").append(item_form);
      }
    }
  }


  $( document ).ready(function() {
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
    function sleep(milliseconds) {
      var start = new Date().getTime();
      for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
          break;
        }
      }
    }

    $("#formSeach").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        totalRecord = 0;
        var startdate = $("#inputDateStart").val();
        var starttime = $("#inputTimeStart").val();
        var enddate = $("#inputDateEnd").val();
        var endtime = $("#inputTimeEnd").val();  
        var device = $("#inputDevice").val();     
        var field = $("#inputField").val();     
        var method = $("#inputMethod").val(); 
        var inputs = $(".inputparams");
        var params = {};
        for(var i = 0; i < inputs.length; i++){
          var name = $(inputs[i]).attr('name');
          var type = $(inputs[i]).attr('type');
          var value = $(inputs[i]).val();
          if(type=="number")
            value = parseFloat(value);
          params[name] = value;
        }  
        console.log(params);
        filtering(device,field,method,params,startdate,starttime,enddate,endtime); 
    });

  });

  
  
</script>

