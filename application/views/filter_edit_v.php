<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Add New Data Filter Service</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>filter">Data Filter</a></li>
    <li class="breadcrumb-item active">Edit</li>
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
              <div class="form-group form-material">
                    <label class="form-control-label" for="inputLocation">Data Filter Service Code</label>
                    <input type="text" class="form-control" id="inputLocation" name="filtercode" value="<?= (empty($filter_code))?'':$filter_code;  ?>"
                    readonly/>
               </div>
              <div class="form-group form-material" id="selectGroup">
                  <label class="form-control-label" for="inputDevice">Device</label>
                  <select class="form-control " id="inputDevice" name="device" onchange="deviceForm()" required>
                    <option value="">--- Select Device Data---</option>
                    <?php foreach ($data as $d) { ?>
                      <option value="<?= $d->device_code?>" <?= ($d->device_code==$setting["device"])?"selected":""; ?> ><?= $d->name?> [<?= $d->device_code?>] </option>
                    <?php } ?>
                  </select>
              </div>   
              <div class="form-group form-material" id="selectGroup">
                  <label class="form-control-label" for="inputField">Data Field</label>
                  <select class="form-control " id="inputField" name="field" required>
                      <option value="">--- Select Field---</option>
                      <?php foreach ($setting["list_field"] as $d) { ?>
                        <option value="<?= $d?>" <?= ($d==$setting["field"])?"selected":""; ?>  ><?= $d?></option>
                      <?php } ?>
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
                      <option value="<?= $d->name ?>" <?= ($d->name==$setting["method"])?"selected":""; ?>  ><?= $d->label ?></option>
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
                    <div class="form-group row">
                      <div class="form-group form-material col-md-6">
                        <label class="form-control-label" for="inputWaiting">Waiting Tollerance (seconds)</label>
                        <input type="text" class="form-control" id="inputWaiting" name="waiting" value="<?= (empty($setting["waiting_time"]))?'':$setting["waiting_time"];  ?>" 
                          placeholder="60" autocomplete="off" required/>
                      </div>
                      <div class="form-group form-material col-md-6">
                        <label class="form-control-label" for="inputSaveTo">Field Name to Store Filtered Data</label>
                        <input type="text" class="form-control" id="inputSaveTo" name="save_to" value="<?= (empty($setting["save_to"]))?'':$setting["save_to"];  ?>"
                        required/>
                      </div>
                    </div>


                    <div class="form-group form-material">
                        <label class="form-control-label mt-3" for="inputLocation"  style="width:100px;">Stream Process</label>
                        <div>
                            <label class="float-left pt-3" for="inputStream">Off</label>
                            <div class="float-left ml-20 mr-20">
                                <input type="checkbox" id="inputStream" name="stream" data-plugin="switchery"
                                <?= ($setting["stream"])?'checked':'' ?> />
                            </div>
                            <label class="pt-3" for="inputStream">On</label>
                        </div>
                    </div>
                    <h4 class="example-title">Grouped Data</h4>
                    <div class="row" id="specFrm">
                      <?php foreach ($setting["group"] as $d) {  
                        $code = substr(md5(mt_rand()), 0, 5);
                        ?>
                        <div class="form-material col-md-12" id="form_src_<?= $code ?>">
                          <div class="form-material row">
                            <div class="col-2">
                                <label class="form-control-label" style="margin-top: 10px;">Field</label>
                            </div>
                            <div class="col-8">
                                <select class="form-control" name="group[]" >
                                <?php foreach ($setting["list_field"] as $f) { ?>
                                  <option value="<?= $f?>" <?= ($d==$f)?"selected":""; ?>  ><?= $f?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="col-2">
                                <a onclick="removeForm(this.name)" name="form_src_<?= $code ?>" class="btn btn-icon btn-pure btn-default btn-leave on-default remove-row" data-toggle="tooltip" data-original-title="Remove" >
                                <i class="icon md-delete" aria-hidden="true"></i>
                                </a>
                            </div>
                          </div>
                      </div>
                      <?php } ?>
                    </div>
                    <button type="button" id="btnAddChildField" onclick="addForm()" class="btn btn-sm btn-info waves-effect waves-classic mt-15 mb-5 waves-effect waves-classic"><i class="md-plus"></i> Add New</button>                                  
                    <div class="form-group form-material mt-10">
                        <button type="submit" name="save" value="edit" id="save" class="btn btn-primary mt-10">Data Filter Update</button>&nbsp; &nbsp;
                        <button type="button" id="simulation" class="btn btn-info mt-10">Simulation</button>&nbsp; &nbsp;
                        <a href="<?= base_url();?>filter"><button type="button" class="btn btn-default mt-10">Cancel</button></a>
                        <input type="hidden" name="id" value="<?= $id ?>">
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

    $("#inputField").change(function(e){
        $("#inputSaveTo").val("filtered_"+$("#inputField").val());
    });

    <?php if($setting["device"]){ ?>
    fieldDevice =  $("#inputField").html().replace('selected','');;
    <?php } ?>
    methodForm();
    <?php foreach ($setting["parameter"] as $key => $d) { ?>
      $("#input<?= $key ?>").val("<?= $d ?>");
    <?php } ?>
  });

  
  
</script>

