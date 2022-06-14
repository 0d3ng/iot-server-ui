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
  <div class="row row-lg">
    <div class="col-md-6">
      <div class="panel-bordered panel-success">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="icon wb-memory" aria-hidden="true"></i> &nbsp;Select Device</h3>
        </div>
        <div class="panel-body bg-white">
            <div class="form-group form-material" id="selectGroup">
                <label class="form-control-label" for="inputDevice">Device</label>
                <select class="form-control " id="inputDevice" name="device" onchange="deviceForm()">
                  <option value="">--- Select Device Data---</option>
                  <?php foreach ($data as $d) { ?>
                    <option value="<?= $d->device_code?>"><?= $d->name?> [<?= $d->device_code?>] </option>
                  <?php } ?>
                </select>
            </div>   
            <div class="form-group form-material" id="selectGroup">
                <label class="form-control-label" for="inputField">Data Field</label>
                <select class="form-control " id="inputField" name="field">
                    <option value="">--- Select Field---</option>
                </select>
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
                    <form method="POST" id="formSeach" >
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
                    </form>
                </div>
            </div>
            <!-- End Example Date Range -->
        </div>
      </div>      
    </div>
    <div class="col-md-6">
      <div class="panel-bordered panel-success">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="icon wb-memory" aria-hidden="true"></i> &nbsp;Select Filter Method</h3>
        </div>
        <div class="panel-body bg-white">
            <div class="form-group form-material">
                <label class="form-control-label" for="inputMethod">Method</label>
                <select class="form-control " id="inputMethod" name="method" onchange="methodForm()">
                  <option value="">--- Select Method---</option>
                  <?php foreach ($method as $d) { ?>
                    <option value="<?= $d->name ?>"><?= $d->label ?></option>
                  <?php } ?>
                </select>
            </div>   
            <div id="">
                
            </div>     
        </div>
      </div>  
    </div>
  </div> 
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
  var method = <?php echo json_encode($method); ?>;
  console.log(method);
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
      rangeSelector: {
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
          title: field
      }],
      xAxis: [{
          title: "Time"
      }],
      series: [{
              name: 'Real Data',
              data: data
          },
          {
              name: 'Filtered Data',
              data: filter
          }
      ]
    });  
  }

  function filter(device,method,params,startdate,starttime,enddate,endtime){
    $.ajax({
        type: 'post',
        url: '<?= base_url()?>filter/process/'+device,
        data: {'method':method,"params":params,"date_start":startdate,"time_start":starttime,"date_end":enddate,"time_end":endtime},
        success: function (result){
          console.log(result)
        }
    });
  }

  function method(){
    var device = $("#inputMethod").val();  
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

    $("#formBatch").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        totalRecord = 0;
        var startdate = $("#inputDateStart").val();
        var starttime = $("#inputTimeStart").val();
        var enddate = $("#inputDateEnd").val();
        var endtime = $("#inputTimeEnd").val();        
    });

    // data = [[1648787103000,54],[1648787104000,51],[1648787105000,51],[1648787106000,54],[1648787107000,54],[1648787108000,57],[1648787109000,51],[1648787110000,54],[1648787111000,51],[1648787112000,48],[1648787113000,51],[1648787114000,51],[1648787115000,51],[1648787116000,51],[1648787117000,51],[1648787118000,57],[1648787119000,54],[1648787120000,48],[1648787121000,51],[1648787122000,51],[1648787123000,54],[1648787124000,51],[1648787125000,54],[1648787126000,51],[1648787127000,51],[1648787128000,51],[1648787129000,51],[1648787130000,54],[1648787131000,51],[1648787132000,54]];
    // filter = [[1648787105000,39],[1648787106000,45],[1648787107000,42],[1648787108000,42],[1648787109000,48],[1648787110000,39],[1648787111000,45],[1648787112000,39],[1648787113000,48],[1648787114000,48],[1648787115000,42],[1648787116000,48],[1648787119000,42],[1648787120000,42],[1648787121000,42],[1648787123000,48],[1648787124000,48],[1648787125000,48],[1648787125000,39],[1648787126000,42],[1648787127000,48],[1648787129000,48],[1648787130000,42],[1648787132000,39],[1648787132000,42]];
    // field = "Accelero X";

    // chart_build(field,data,filter);
    // var statusStart = ': <span class="badge badge-primary">No Process</span>';
    // var statusFinish = ': <span class="badge badge-success">Finish</span>';
    // var statusProcess = ': <span class="badge badge-warning">On Process</span>';
    
    // var totalRecord = 0;
    // function resetprog(){
    //   progres = 0;
    //   totalRecord = 0;
    //   console.log(progres+"%");
    //   $("#progresbar").html(progres+"%");
    //   $("#progresbar").css("width",progres+"%");
    //   $("#total").html(totalRecord);
    // }

    // function batch(start,end,datalist,current,enddate){
    //   console.log(start+" --- "+end);
    //   $("#statusProcess").html(statusProcess);
    //   $.ajax({
    //       type: 'post',
    //       url: '',
    //       data: {"date_start":start,"date_end":end},
    //       success: function (result){
    //         totalRecord = totalRecord + result["data"]["insert_count"];
    //         current++;
    //         var progres = current / datalist.length * 100;
    //         progres = progres.toFixed(2);
    //         console.log(progres+"%");
    //         $("#progresbar").html(progres+"%");
    //         $("#progresbar").css("width",progres+"%");
    //         $("#total").html(totalRecord);
    //         if(datalist.length-1 == current){
    //           batch(datalist[current],enddate,datalist,current,enddate);
    //         } else if(datalist.length > current){
    //           batch(datalist[current],datalist[current+1],datalist,current,enddate);
    //         } else {
    //           $("#statusProcess").html(statusFinish);
    //         }
    //       }
    //   });
    // }

    // function findList(start,end){
    //     var getDaysBetweenDates = function(startDate, endDate) {
    //         var now = startDate.clone(), dates = [];
    
    //         while (now.isBefore(endDate)) {
    //             dates.push(now.format('YYYY-MM-DD HH:mm:ss'));
    //             now.add(, 'seconds');
    //         }
    //         console.log(dates);
    //         return dates;
    //     };
    
    //     var startDate = moment(start);
    //     var endDate = moment(end);
    
    //     var dateList = getDaysBetweenDates(startDate, endDate);
    //     return dateList;
    // }

    // $("#formBatch").submit(function(e) {
    //     e.preventDefault(); // avoid to execute the actual submit of the form.

    //     alertify.confirm('Do you continue to datasync process?', 
    //     function(){ 
    //         totalRecord = 0;
    //         var startdate = $("#inputDateStart").val();
    //         var starttime = $("#inputTimeStart").val();
    //         var enddate = $("#inputDateEnd").val();
    //         var endtime = $("#inputTimeEnd").val();
    //         startdate = startdate + " " + starttime;
    //         enddate = enddate + " " + endtime;
    //         datalist = findList(startdate,enddate);
    //         current = 0;
    //         resetprog();
    //         enddate = enddate+":00"; 
    //         if(datalist.length == 1){
    //             batch(datalist[current],enddate,datalist,current,enddate);
    //         } else {
    //             batch(datalist[current],datalist[current+1],datalist,current,enddate);
    //         }
    //     },function(){ 
          
    //     });

    // });

  });

  
  
</script>

