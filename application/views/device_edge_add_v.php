<?php include("header.php") ?>
<div class="page-header">  
  <h1 class="page-title">Add New Edge Configuration</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device">Devices</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device/edge/<?= $id ?>">Edge Configuration</a></li>
    <li class="breadcrumb-item active">Add</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>

<div class="page-content">
    <div class="row row-lg">
        <div class="col-sm-12 col-md-4 col-xl-3">
            <div class="pricing-list text-left">
                <div class="pricing-header bg-green-600">
                    <div class="pricing-title">Device Info</div>
                    <div class="pricing-price" style="padding-top:0px; padding-bottom: 0px;font-size: 2.858rem;">
                        <span class="pricing-currency"><i class="icon wb-memory" aria-hidden="true"></i></span>
                        <span class="pricing-amount"><?= $data->device_code; ?></span>            
                    </div>
                    <p class="px-30 font-size-16" ><strong>Device Name</strong>: <i><?= $data->name; ?> </i></p>
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
        <div class="col-sm-12 col-md-8 col-xl-9">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Form Add New Edge Configuration </h3>
                </div>    
                <div class="panel-body">
                    <div class="nav-tabs-horizontal" data-plugin="tabs">
                        <ul class="nav nav-tabs pearls row" role="tablist" style="border-bottom:none;">
                            <li class="nav-item pearl current col-3" role="presentation" id="navDeviceConfiguration">
                                <a class="pearl-icon active" data-toggle="tab" href="#deviceConfiguration" aria-controls="deviceConfiguration" role="tab">
                                    <i class="icon md-settings" aria-hidden="true"></i>
                                </a>
                                <span class="pearl-title">Device Configuration</span>
                            </li>
                            <li class="nav-item pearl  col-3" role="presentation" id="navDataResource">
                                <a class="pearl-icon " data-toggle="tab" href="#dataResource" aria-controls="dataResource" role="tab">
                                    <i class="icon md-sign-in" aria-hidden="true"></i>
                                </a>
                                <span class="pearl-title">Data Resource & Converter</span>
                            </li>
                            <li class="nav-item pearl col-3" role="presentation" id="navDataTransmitted">
                                <a class="pearl-icon " data-toggle="tab" href="#dataTransmitted" aria-controls="dataTransmitted" role="tab">
                                    <i class="icon md-cloud-upload" aria-hidden="true"></i>
                                </a>
                                <span class="pearl-title">Data Transmission</span>
                            </li>
                            <li class="nav-item pearl col-3" role="presentation" id="navFinalData">
                                <a class="pearl-icon " data-toggle="tab" href="#finalData" aria-controls="finalData" role="tab">
                                    <i class="icon md-check" aria-hidden="true"></i>
                                </a>
                                <span class="pearl-title">Confirmation</span>
                            </li>
                        </ul>
                        <form method="post" autocomplete="off">
                        <div class="tab-content pt-20">
                            <div class="tab-pane active" id="deviceConfiguration" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-material ">
                                            <label class="form-control-label" for="inputTimeInterval">Time Interval (seconds)</label>
                                            <input type="number" class="form-control" id="inputTimeInterval" name="timeInterval" placeholder="1" onchange="validation1()"/>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="wizard-buttons mt-10">
                                    <a class="btn btn-primary btn-outline float-right waves-effect waves-classic next-step" href="#" role="button">Next</a>
                                </div>
                            </div>
                            <div class="tab-pane" id="dataResource" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4">   
                                        <h4 class="example-title">Resource</h4>
                                        <div class="form-group form-material ">
                                            <select class="form-control " id="inputResouce" name="resource" required>
                                                <option value="" >Select Resource</option>
                                                <?php foreach ($resource as $d) { ?>
                                                <option value="<?= $d?>" ><?= $d?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 row" id="form_resource">   
                                    
                                    </div>
                                    <div class="col-md-12 col-xl-8" id="form_output" style="display: none;">   
                                        <h4 class="example-title" style="color:#0D47A1;">Pattern for Data Resource Output</h4>
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
                                        </div>
                                        <button type="button" id="btnAddChildField" onclick="addForm()" class="btn btn-sm btn-info waves-effect waves-classic mt-15 mb-5 waves-effect waves-classic"><i class="md-plus"></i> Add New</button>                                                      
                                    </div>
                                </div>


                                <div class="wizard-buttons mt-10">
                                    <a class="btn btn-default btn-outline  waves-effect waves-classic prev-step" href="#" role="button">Back</a>
                                    <a class="btn btn-primary btn-outline float-right waves-effect waves-classic next-step" href="#" role="button">Next</a>
                                </div>
                            </div>
                            <div class="tab-pane" id="dataTransmitted" role="tabpanel">                                
                                <div class="wizard-buttons mt-10">
                                    <a class="btn btn-default btn-outline  waves-effect waves-classic prev-step" href="#" role="button">Back</a>
                                    <a class="btn btn-primary btn-outline float-right waves-effect waves-classic next-step" href="#" role="button">Next</a>
                                </div>
                            </div>
                            <div class="tab-pane" id="finalData" role="tabpanel">
                                Metus subtilius texit consilio fugiendam, opinionum levius amici inertissimae pecuniae
                                tribus ordiamur, alienus artes solitudo, minime praesidia
                                proficiscuntur reiciat detracta involuta veterum. Rutilius
                                quis honestatis hominum, quisquis percussit sibi explicari.
                                <div class="wizard-buttons mt-10">
                                    <a class="btn btn-default btn-outline  waves-effect waves-classic prev-step" href="#" role="button">Back</a>
                                    <a class="btn btn-success btn-outline float-right waves-effect waves-classic " href="#"  role="submit">Finish</a>
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


<script src="<?= base_url()?>assets/global/js/Plugin/responsive-tabs.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/closeable-tabs.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/tabs.js"></script>

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
            }
            $("select[name='field_"+id+"']").html(optionDevice);
        }); 
    }

    function patternForm(){
        $("input[name='object_pattern[]']").each(function() {
            // console.log($(this).val()); 
        });   
    }

    ///wizard
    function nextTab(elem) {
        $(elem).parent().next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
        $(elem).parent().prev().find('a[data-toggle="tab"]').click();
    }

    function validation1(){
        val = $("#inputTimeInterval").val();
        console.log(val);
        if(val){
            $("#navDeviceConfiguration").addClass("done");    
        }else{
            $("#navDeviceConfiguration").removeClass("done");
        }
    }

    function sleep(milliseconds) {
      var start = new Date().getTime();
      for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
          break;
        }
      }
    }

    $( document ).ready(function() {
        toastr.options = {
            positionClass: 'toast-top-center'
        };
        <?php if($success){ ?>
        toastr.success('<?= $success; ?>', 'Success', {timeOut: 3000})
        <?php }  
        if($error){ ?>
            toastr.error('<?= $error; ?>', 'Failed', {timeOut: 3000});
        <?php } ?>

        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            var $target = $(e.target);
            $(".nav-item").removeClass("current");
            $target.parent().addClass("current");
            if ($target.parent().hasClass('disabled')) {
                return false;
            }
        });

        $(".next-step").click(function (e) {
            var $active = $('.nav-tabs li>.active');
            $active.parent().next().find('.nav-link').removeClass('disabled');
            nextTab($active);
        });
        
        $(".prev-step").click(function (e) {
            var $active = $('.nav-tabs li>a.active');
            prevTab($active);
        });  
        
        $("#inputResouce").change(function(){
            var resource = $("#inputResouce").val();
            if(resource == ""){
                $("#form_resource").html("");
                $("#form_output").hide();
            } else {
                $.ajax({
                    type: 'post',
                    url: '<?= base_url()?>device/resource/',
                    data: {resource:resource},
                    success: function (result){
                        $("#form_resource").html(result);
                        $("#form_output").show();
                        if(resource == "USB Serial"){
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
                        }
                        if(resource == "USB Mono Stick"){
                            patternProcess();     
                        }
                    }
                });
            }
        });  
    });
</script>