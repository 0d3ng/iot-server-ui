<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Devices Process - Batch Process</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device">Devices</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device/process/<?= $id ?>">Process</a></li>
    <li class="breadcrumb-item active">Batch Process</li>
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
          <h3 class="panel-title"><i class="icon wb-time" aria-hidden="true"></i> &nbsp;Search Data</h3>
        </div>
        <div class="panel-body bg-white">
            <!-- Example Date Range -->
            <div class="example-wrap">
                <h4 class="example-title">Date Range Data</h4>                
                <div class="example">
                    <form method="POST" id="formBatch" >
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
                            <button type="submit" class="btn btn-primary waves-effect waves-classic">Start Batch Process </button>
                        </div>    
                    </form>
                </div>
            </div>
            <!-- End Example Date Range -->
        </div>
      </div>
      <div class="panel-bordered panel-info mt-10" id="progressDiv">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="icon wb-time" aria-hidden="true"></i> &nbsp;Batch Process Status</h3>
        </div>
        <div class="panel-body bg-white">
            <div class="example-wrap">
              <div class="example">
                <h5>Process Status <span id="statusProcess">: <span class="badge badge-primary">No Process</span></span></h5>
                <div class="progress progress-lg">
                  <div class="progress-bar progress-bar-danger" id="progresbar" style="width: 0%;" role="progressbar">0%</div>
                </div>
                <h5>Total Record: <span id="total"></span> </h5>
              </div>
            </div>
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
<script src="<?= base_url()?>assets/global/js/Plugin/asprogress.js"></script>
<!-- <script src="<?= base_url()?>assets/examples/js/uikit/progress-bars.js"></script> -->

<script>
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

    var statusStart = ': <span class="badge badge-primary">No Process</span>';
    var statusFinish = ': <span class="badge badge-success">Finish</span>';
    var statusProcess = ': <span class="badge badge-warning">On Process</span>';
    
    var totalRecord = 0;
    function resetprog(){
      progres = 0;
      totalRecord = 0;
      console.log(progres+"%");
      $("#progresbar").html(progres+"%");
      $("#progresbar").css("width",progres+"%");
      $("#total").html(totalRecord);
    }

    function batch(start,end,datalist,current,enddate){
      console.log(start+" --- "+end);
      $("#statusProcess").html(statusProcess);
      $.ajax({
          type: 'post',
          url: '<?= base_url()?>device/batchprocess/<?= $id; ?>',
          data: {"date_start":start,"date_end":end},
          success: function (result){
            totalRecord = totalRecord + result["data"]["insert_count"];
            current++;
            var progres = current / datalist.length * 100;
            progres = progres.toFixed(2);
            console.log(progres+"%");
            $("#progresbar").html(progres+"%");
            $("#progresbar").css("width",progres+"%");
            $("#total").html(totalRecord);
            if(datalist.length-1 == current){
              batch(datalist[current],enddate,datalist,current,enddate);
            } else if(datalist.length > current){
              batch(datalist[current],datalist[current+1],datalist,current,enddate);
            } else {
              $("#statusProcess").html(statusFinish);
            }
          }
      });
    }

    function findList(start,end){
        var getDaysBetweenDates = function(startDate, endDate) {
            var now = startDate.clone(), dates = [];
    
            while (now.isBefore(endDate)) {
                dates.push(now.format('YYYY-MM-DD HH:mm'));
                now.add(10, 'minutes');
            }
            console.log(dates);
            return dates;
        };
    
        var startDate = moment(start);
        var endDate = moment(end);
    
        var dateList = getDaysBetweenDates(startDate, endDate);
        return dateList;
    }

    $("#formBatch").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        alertify.confirm('Do you continue to data synchronization process?', 
        function(){ 
            totalRecord = 0;
            var startdate = $("#inputDateStart").val();
            var starttime = $("#inputTimeStart").val();
            var enddate = $("#inputDateEnd").val();
            var endtime = $("#inputTimeEnd").val();
            startdate = startdate + " " + starttime;
            enddate = enddate + " " + endtime;
            datalist = findList(startdate,enddate);
            current = 0;
            resetprog();
            if(datalist.length == 1){
                batch(datalist[current],enddate,datalist,current,enddate);
            } else {
                batch(datalist[current],datalist[current+1],datalist,current,enddate);
            }
        },function(){ 
          
        });

    });

  });

  
</script>

