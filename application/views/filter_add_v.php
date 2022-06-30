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
  <form method="POST" id="formAdd" >
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
                  <select class="form-control " id="inputMethod" name="method" onchange="methodForm()" required>
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
            <h3 class="panel-title"><i class="icon wb-time" aria-hidden="true"></i> &nbsp;Settings</h3>
          </div>
          <div class="panel-body bg-white">
              <!-- Example Date Range -->
              <div class="example-wrap">
                    <div class="form-group form-material ">
                      <label class="form-control-label" for="inputWaiting">Waiting Tollerance (seconds)</label>
                      <input type="text" class="form-control" id="inputWaiting" name="waiting" value="<?= (empty($data->name))?'':$data->name;  ?>" 
                        placeholder="60" autocomplete="off" required/>
                    </div>
                    <div class="form-group form-material">
                        <label class="form-control-label mt-3" for="inputLocation"  style="width:100px;">Stream Process</label>
                        <div>
                            <label class="float-left pt-3" for="inputStream">Off</label>
                            <div class="float-left ml-20 mr-20">
                                <input type="checkbox" id="inputStream" name="stream" data-plugin="switchery"
                                />
                            </div>
                            <label class="pt-3" for="inputStream">On</label>
                        </div>
                    </div>
                    <h4 class="example-title">Grouped Data</h4>
                    <div class="row" id="specFrm">
                    </div>
                    <button type="button" id="btnAddChildField" onclick="addForm()" class="btn btn-sm btn-info waves-effect waves-classic mt-15 mb-5 waves-effect waves-classic"><i class="md-plus"></i> Add New</button>                                  
                    <!-- <div class="form-group form-material" id = "frmsearch">
                        <span class="input-group-addon" style="background:none; border:none;"> </span>
                        <button type="submit" class="btn btn-primary waves-effect waves-classic">Search Sensor Data</button>
                    </div> -->
                    
                    <div class="form-group form-material mt-10">
                        <button type="submit" name="save" value="add" id="save" class="btn btn-primary mt-10">Add New Data Filter</button>&nbsp; &nbsp;
                        <button type="button" id="simulation" class="btn btn-info mt-10">Simulation</button>&nbsp; &nbsp;
                        <a href="<?= base_url();?>filter"><button type="button" class="btn btn-default mt-10">Cancel</button></a>
                    </div>

              </div>
              <!-- End Example Date Range -->
          </div>
        </div>      
      </div>
    </div>
  </form>
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
  var method_list = <?php echo json_encode($method_list); ?>;
  var fieldDevice="";
  function deviceForm(){
    var device = $("#inputDevice").val();
    if(device!=""){
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
            fieldDevice ='<option value="">--- Select Field---</option>'+item;
            $("#inputField").html(fieldDevice);
          }
      });
    }else{
      fieldDevice = "";
      $("#inputField").html('<option value="">--- Select Field---</option>');
    }
  }

  function addForm(){
    if(fieldDevice!=""){
      var id = (Math.random() + 1).toString(36).substring(7);
      var forms = '<div class="form-material col-md-12" id="form_src_'+id+'">'+
          '<div class="form-material row">'+
            '<div class="col-2">'+
                '<label class="form-control-label" style="margin-top: 10px;">Field</label>'+
            '</div>'+
            '<div class="col-8">'+
                '<select class="form-control" name="group[]" >'+
                fieldDevice + 
                '</select>'+
            '</div>'+
            '<div class="col-2">'+
              '<a onclick="removeForm(this.name)" name="form_src_'+id+'" class="btn btn-icon btn-pure btn-default btn-leave on-default remove-row" data-toggle="tooltip" data-original-title="Remove" >'+
                '<i class="icon md-delete" aria-hidden="true"></i>'+
              '</a>'+
            '</div>'+
          '</div>'+
        '</div>';
      $("#specFrm").append(forms);
    }else{
      toastr.error('Please choose the device data.', 'Failed', {timeOut: 3000});  
    }
  }

  function removeForm(id){
    console.log(id);
    $("#"+id).remove();
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
                '<input type="number" class="form-control inputparams" id="input'+obj['name']+'" name="params['+obj['name']+']" value="" step="any" autocomplete="off">'+
              '</div>';
        }
        $("#params").append(item_form);
      }
      $("#frmprocess").css("display","block");
      $("#frmsearch").css("display","none");
    } else {
      $("#frmprocess").css("display","none");
      $("#frmsearch").css("display","block");
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

    $("#simulation").click(function(e){
        $("#formAdd").attr('action','<?= base_url()?>filter/simulation/'); 
        $('.form-control').removeAttr('required'); 
        $("#save").click();  
    });

    // $("#formSeach").submit(function(e) {
    //     e.preventDefault(); // avoid to execute the actual submit of the form.
    //     totalRecord = 0;
    //     var startdate = $("#inputDateStart").val();
    //     var starttime = $("#inputTimeStart").val();
    //     var enddate = $("#inputDateEnd").val();
    //     var endtime = $("#inputTimeEnd").val();  
    //     var device = $("#inputDevice").val();     
    //     var field = $("#inputField").val();     
    //     var method = $("#inputMethod").val(); 
    //     var inputs = $(".inputparams");
    //     var params = {};
    //     var search = {};
    //     for(var i = 0; i < inputs.length; i++){
    //       var name = $(inputs[i]).attr('name');
    //       var type = $(inputs[i]).attr('type');
    //       var value = $(inputs[i]).val();
    //       if(type=="number")
    //         value = parseFloat(value);
    //       params[name] = value;
    //     }  
    //     var searchs = $(".search");
    //     for(var i = 0; i < searchs.length; i++){
    //       var name = $(searchs[i]).attr('name');
    //       if(name!="search"){
    //         var value = $(searchs[i]).val();
    //         if(!isNaN(value))
    //           value = parseInt(value);
    //         search[name] = value;
    //       }
    //     } 
    //     console.log(params);
    //     console.log(search);
    //     filtering(device,field,search,method,params,startdate,starttime,enddate,endtime); 
    // });    
  });

  
  
</script>

