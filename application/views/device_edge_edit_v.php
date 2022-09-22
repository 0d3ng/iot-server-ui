<?php include("header.php") ?>
<div class="page-header">  
  <h1 class="page-title">Add New Edge Configuration</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device">Devices</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device/edge/<?= $id ?>">Edge Configuration</a></li>
    <li class="breadcrumb-item active">Edit</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-body container-fluid">
          <div class="example-wrap">
            <h4 class="example-title">Form Edit Edge Configuration for Device <?= (empty($data->name))?'':$data->name;  ?> </h4>
            <form method="post" autocomplete="off">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-material ">
                      <label class="form-control-label" for="inputEdgeCode">Edge Computing ID</label>
                      <input type="text" class="form-control" id="inputEdgeCode" name="code" value="<?= $edge->edgeconfig_code ?>" 
                          placeholder="Edge Code" readonly="true"/>
                  </div>
                  <div class="form-group form-material ">
                      <label class="form-control-label" for="inputDevice">Device</label>
                      <input type="text" class="form-control" id="inputDevice" name="name" value="[<?= $id ?>] <?= (empty($data->name))?'':$data->name;  ?>" 
                          placeholder="Name" readonly="true"/>
                  </div>
                  <div class="form-group form-material ">
                      <label class="form-control-label" for="inputInterface">Network Interface</label>
                      <select class="form-control " id="inputInterface" name="interface" required>
                        <?php foreach ($interface as $d) { ?>
                        <option value="<?= $d?>" <?= ($d == $edge->interface)?'selected':'' ?> ><?= $d?></option>
                        <?php } ?>
                      </select>
                  </div>
                  <div class="form-group form-material ">
                      <label class="form-control-label" for="inputMethod">Method</label>
                      <select class="form-control " id="inputMethod" name="method" required>
                        <option value="">Select Method</option>
                        <option value="array_list" <?= ($edge->method == "array_list")?'selected':'' ?> >Covert to Array List</option>
                        <option value="json_object" <?= ($edge->method == "json_object")?'selected':'' ?> >Covert to JSON Object</option>                        
                      </select>
                  </div>
                  <div class="form-group form-material">
                      <label class="form-control-label" for="inputStringSample">Example of Message</label>
                      <textarea class="form-control empty" rows="3" id="inputStringSample" name="string_sample"><?= (empty($edge->string_sample))?'':$edge->string_sample;  ?></textarea>
                  </div>
                  <div class="row">
                    <div class="col-md-4" id="form_delimeter1">   
                      <div class="form-group form-material ">
                        <label class="form-control-label" for="inputDelimeter1">Delimeter 1</label>
                        <input type="text" class="form-control" id="inputDelimeter1" name="delimeter[0]" value="<?= (empty($edge->delimeter[0]))?'':$edge->delimeter[0];  ?>"/>
                      </div>
                    </div>   
                    <div class="col-md-4" id="form_delimeter2">   
                      <div class="form-group form-material ">
                        <label class="form-control-label" for="inputDelimeter2">Delimeter 2</label>
                        <input type="text" class="form-control" id="inputDelimeter2" name="delimeter[1]" value="<?= (empty($edge->delimeter[1]))?'':$edge->delimeter[1];  ?>"/>
                      </div>
                    </div>
                    <div class="col-md-4" id="form_process">
                      <div class="form-group form-material" id="frmprocess" style="display: block;">
                        <span class="input-group-addon" style="background:none; border:none;"> </span>
                        <button type="button" onclick="patternProcess()" class="btn btn-info waves-effect waves-classic waves-effect waves-classic">Process</button>
                        <input type="hidden" name="back" value="back">
                      </div>
                    </div>   
                  </div>
                  
                </div>  
                <div class="col-md-6">
                  <div class="form-group form-material">
                    <label class="form-control-label" for="inputPattern">Pattern</label>
                    <textarea class="form-control empty" rows="3" id="inputPattern" name="string_pattern" readonly><?= (empty($edge->string_pattern))?'':$edge->string_pattern;  ?></textarea>
                  </div>
                  <h4 class="example-title">Sensor Pattern for Data Conveter</h4>
                  <div class="row" id="specFrm">
                    <div class="form-material col-md-12">
                      <div class="form-material row">
                        <div class="col-md-5 col-sm-4 col-8">
                            <label class="form-control-label" style="width: 100%;padding: 5px 10px 5px;background-color: #f1f4f5;">Sensor Field</label>
                        </div>  
                        <div class="col-md-5 col-sm-5 col-8">
                            <label class="form-control-label" style="width: 100%;padding: 5px 10px 5px;background-color: #f1f4f5;">Data Pattern</label>
                        </div>    
                        <div class="col-md-2 col-sm-3 col-4" >
                            <label class="form-control-label" style="width: 100%;padding: 5px 5px 5px;background-color: #f1f4f5;">Action</label>
                        </div>                                                      
                      </div>
                    </div>                    
                    <?php foreach ($edge->object_used as $key => $val) {  
                      $code = substr(md5(mt_rand()), 0, 5);
                      ?>
                    <div class="form-material col-md-12" id="form_src_<?= $code ?>">
                      <div class="form-material row">
                        <div class="col-md-5 col-8">
                          <select class="form-control" onchange="fieldForm()" name="field_<?= $code ?>" required="">
                            <option value="<?= $key?>"><?= $key?></option>
                          </select>
                        </div>
                        <div class="col-md-5 col-8">
                          <select class="form-control" onchange="patternForm()" name="pattern_<?= $code ?>" required="">
                            <option value="<?= $val?>"><?= $val?></option>
                          </select>
                        </div>
                        <div class="col-md-2 col-4">
                          <a onclick="removeForm(this.name)" name="form_src_<?= $code ?>" class="btn btn-icon btn-pure btn-default btn-leave on-default remove-row" data-toggle="tooltip" data-original-title="Remove">
                            <i class="icon md-delete" aria-hidden="true"></i>
                          </a>
                        </div>
                      </div>
                      <input type="hidden" name="object_pattern[]" value="<?= $code ?>">                                            
                    </div>
                    <?php } ?>
                  </div>
                  <button type="button" id="btnAddChildField" onclick="addForm()" class="btn btn-sm btn-info waves-effect waves-classic mt-15 mb-5 waves-effect waves-classic"><i class="md-plus"></i> Add New</button>                                                      
                </div>   
                <div class="col-md-12" id="btnsave">
                  <div class="form-group form-material">
                    <button type="submit" name="save" value="save" class="btn btn-primary waves-effect waves-classic">Update Edge Configuration</button>&nbsp; &nbsp;
                    <a href="<?= base_url();?>device/edge/<?= $id ?>"><button type="button" class="btn btn-default waves-effect waves-classic">Cancel</button></a>                    
                  </div>
                </div>             
              </div>  
            </form> 
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
<script src="<?= base_url()?>assets/global/vendor/highchart/highstock.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/exporting.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/export-data.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/icheck/icheck.min.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/icheck.js"></script>

<script>  
  var fieldDevice=<?php echo json_encode($field); ?>;
  var usedFieldDevice=[];
  var objectPattern = {};
  var usedObjectPattern = [];
  function patternProcess(){
    var method = $("#inputMethod").val();
    var sample = $("#inputStringSample").val();
    var del1 = $("#inputDelimeter1").val();
    var del2 = $("#inputDelimeter2").val();
    
    if(method!="" && sample!=""){
      data = {
        "method":method,
        "sample":sample
      };
      if(del1!=""){ data["delimeter1"] = del1; }
      if(del2!=""){ data["delimeter2"] = del2; }
      $.ajax({
          type: 'post',
          url: '<?= base_url()?>device/edge/<?= $id ?>/process',
          data: data,
          success: function (result){
           status = result["status"];
           console.log(result);
           if(status){            
            if(method == "array_list"){
              $("#inputDelimeter1").val(result["data"]["delimeter"][0]);
              objectPattern = result["data"]["list"]; 
            } else if(method == "json_object"){              
              $("#inputDelimeter1").val(result["data"]["delimeter"][0]);
              $("#inputDelimeter2").val(result["data"]["delimeter"][1]);
              objectPattern = result["data"]["object"]; 
            }
            $("#inputPattern").val(result["data"]["string_pattern"]);
            fieldForm();
            patternFormStart();
            $("#btnsave").show();
           }else{
            toastr.error('Process Failed', 'Failed', {timeOut: 3000});
           }
          }
      });
    }else{      
      toastr.error('Please choose method and fill example of message input', 'Failed', {timeOut: 3000});
    }
  }

  function addForm(){
    if($("input[name='object_pattern[]']").length < fieldDevice.length){
      var method = $("#inputMethod").val();
      var pattern = $("#inputPattern").val();
      var optionDevice = '<option value="">--- Select Field---</option>';
      var optionPattern = '<option value="">--- Select Data Pattern---</option>';
      for(var i in fieldDevice){
        if(!usedFieldDevice.includes(fieldDevice[i])){
          optionDevice +='<option value="'+fieldDevice[i]+'">'+fieldDevice[i]+'</option>';
        }
      }
      if(method == "array_list"){
        for(var i in objectPattern){
          if(!usedObjectPattern.includes(i)){
            optionPattern +='<option value="'+i+'">item['+i+'] ('+objectPattern[i]+') </option>';
          }
        }
      } else if(method == "json_object"){
        for(var i in objectPattern){
          if(!usedObjectPattern.includes(i)){
            optionPattern +='<option value="'+i+'">'+i+' ('+objectPattern[i]+') </option>';
          }
        }
      }
          
      if(method!="" && pattern!=""){
        var id = (Math.random() + 1).toString(36).substring(7);
        var forms = '<div class="form-material col-md-12" id="form_src_'+id+'">'+
            '<div class="form-material row">'+            
              '<div class="col-md-5 col-8">'+
                  '<select class="form-control" onchange="fieldForm()" name="field_'+id+'" required>'+
                  optionDevice + 
                  '</select>'+
              '</div>'+
              '<div class="col-md-5 col-8">'+
                  '<select class="form-control" onchange="patternForm()" name="pattern_'+id+'" required>'+
                  optionPattern + 
                  '</select>'+
              '</div>'+
              '<div class="col-md-2 col-4">'+
                '<a onclick="removeForm(this.name)" name="form_src_'+id+'" class="btn btn-icon btn-pure btn-default btn-leave on-default remove-row" data-toggle="tooltip" data-original-title="Remove" >'+
                  '<i class="icon md-delete" aria-hidden="true"></i>'+
                '</a>'+
              '</div>'+
            '</div>'+
            '<input type="hidden" name="object_pattern[]" value="'+id+'"/>'+
          '</div>';
        $("#specFrm").append(forms);
      }else{
        toastr.error('Please choose the device data.', 'Failed', {timeOut: 3000});  
      }
    }else{
      toastr.error('You have reached the maximum number of sensor fields', 'Failed', {timeOut: 3000});  
    }
  }

  function removeForm(id){
    var fieldUsed = $("input[name='field_"+id+"']");
    var patternUsed = $("input[name='pattern_"+id+"']");    
    $("#"+id).remove();    
    fieldForm();
  }

  function fieldForm(){
    usedFieldDevice = [];
    var method = $("#inputMethod").val();    
    $("input[name='object_pattern[]']").each(function() {
        id =  $(this).val();
        var value = $("select[name='field_"+id+"']").val();        
        usedFieldDevice.push(value);
    }); 
    $("input[name='object_pattern[]']").each(function() {
        var optionDevice = '<option value="">--- Select Field---</option>';
        id =  $(this).val();
        var value = $("select[name='field_"+id+"']").val();
        for(var i in fieldDevice){
          if(!usedFieldDevice.includes(fieldDevice[i])){
            optionDevice +='<option value="'+fieldDevice[i]+'">'+fieldDevice[i]+'</option>';
          }else if(fieldDevice[i] == value){
            optionDevice +='<option value="'+fieldDevice[i]+'" selected>'+fieldDevice[i]+'</option>';
          }
          $("select[name='field_"+id+"']").html(optionDevice);
        }
    }); 
  }

  function patternForm(){
    // $("input[name='object_pattern[]']").each(function() {
    //     console.log($(this).val()); 
    // });   
  }

  function patternFormStart(){
    var method = $("#inputMethod").val();
    var optionPattern = '<option value="">--- Select Data Pattern---</option>';    
    $("input[name='object_pattern[]']").each(function() {
        var optionDevice = '<option value="">--- Select Field---</option>';
        id =  $(this).val();
        var value = $("select[name='pattern_"+id+"']").val();
        var fields = $("select[name='field_"+id+"']").val();        
        if(method == "array_list"){
          for(var i in objectPattern){
            if(i == value){
              optionPattern +='<option value="'+i+'" selected>item['+i+'] ('+objectPattern[i]+') </option>';
            }else if(!usedObjectPattern.includes(i)){
              optionPattern +='<option value="'+i+'">item['+i+'] ('+objectPattern[i]+') </option>';
            }
          }
        } else if(method == "json_object"){
          for(var i in objectPattern){
            if(i == value){
              optionPattern +='<option value="'+i+'" selected>'+i+' ('+objectPattern[i]+') </option>';
            }else if(!usedObjectPattern.includes(i)){
              optionPattern +='<option value="'+i+'">'+i+' ('+objectPattern[i]+') </option>';
            }
          }
        }
        $("select[name='pattern_"+id+"']").html(optionPattern);
    }); 

  }

  $( document ).ready(function() {
    // Override global options
    
    <?php if($edge->method == "array_list"){ ?>
    $("#form_delimeter2").hide();
    <?php } ?>
   
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

    $("#inputMethod").change(function() {
      val = $("#inputMethod").val();
      $("#form_delimeter1").hide();
      $("#form_delimeter2").hide();
      if(val == "json_object"){
        $("#form_delimeter1").show(); 
        $("#form_delimeter2").show(); 
        $("#form_process").show();
      }else if(val == "array_list"){
        $("#form_delimeter1").show();
        $("#form_process").show();
      } else {
        $("#form_process").hide();
      }
    });
    patternProcess();    
  });

  
  // $('#select_id option[value="'+value+'"]').attr("disabled", true);
</script>

