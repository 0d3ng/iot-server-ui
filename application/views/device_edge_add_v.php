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
        <div class="col-md-12">
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
                                <a class="nav-links pearl-icon disabled" data-toggle="tab" href="#dataResource" aria-controls="dataResource" role="tab"  id="navDataResource_link">
                                    <i class="icon md-sign-in" aria-hidden="true"></i>
                                </a>
                                <span class="pearl-title">Data Resource & Converter</span>
                            </li>
                            <li class="nav-item pearl col-3" role="presentation" id="navDataTransmitted">
                                <a class="nav-links pearl-icon disabled" data-toggle="tab" href="#dataTransmitted" aria-controls="dataTransmitted" role="tab" id="navDataTransmitted_link">
                                    <i class="icon md-cloud-upload" aria-hidden="true" ></i>
                                </a>
                                <span class="pearl-title">Data Transmission</span>
                            </li>
                            <li class="nav-item pearl col-3" role="presentation" id="navFinalData">
                                <a class="nav-links pearl-icon disabled" data-toggle="tab" href="#finalData" aria-controls="finalData" role="tab" id="navFinalData_link">
                                    <i class="icon md-check" aria-hidden="true" ></i> 
                                </a>
                                <span class="pearl-title">Confirmation</span>
                            </li>
                        </ul>
                        <form method="post" autocomplete="off" novalidate>
                        <div class="tab-content pt-20">
                            <div class="tab-pane active" id="deviceConfiguration" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <h3 class="example-title" style="color:#0D47A1;">Device Information</h3>
                                        <div class="pricing-list text-left">
                                            <div class="pricing-header bg-green-600">                                                
                                                <div class="pricing-price" style="padding-bottom: 0px;font-size: 2rem;">
                                                    <span class="pricing-currency"><i class="icon wb-memory" aria-hidden="true"></i></span>
                                                    <span class="pricing-amount">Code: <?= $data->device_code; ?></span>            
                                                </div>
                                                <p class="px-30 font-size-16" ><strong>Device Name</strong>: <i><?= $data->name; ?> </i></p>
                                            </div>
                                            <ul class="pricing-features font-size-16" style="background-color: #fff;" >
                                                <li>
                                                    <strong>Location :</strong> <?= $data->information->location; ?></li>
                                                <li>
                                                    <strong>Purpose :</strong> <?= $data->information->purpose; ?>
                                                </li>
                                                <?php if(!empty($group)){ ?>
                                                <li>
                                                    <strong>Devices Group :</strong> <?= $group->name; ?></li>
                                                <?php } ?>
                                                <li>
                                                    <strong>Detail Infomation :</strong> <?= $data->information->detail; ?>
                                                </li>
                                                <li>
                                                    <strong>Sensor :</strong> <?= implode(", ",$field); ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h3 class="example-title" style="color:#0D47A1;">Device Configuration</h3>
                                        <div class="form-group form-material ">
                                            <label class="form-control-label" for="inputTimeInterval">Time Interval (seconds)</label>
                                            <input type="number" class="form-control" id="inputTimeInterval" name="time_interval" onchange="validation1()"/>
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
                                        <h3 class="example-title" style="color:#0D47A1;">Resource</h3>
                                        <div class="form-group form-material ">
                                            <select class="form-control " id="inputResouce" name="resource" >
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
                                        <h3 class="example-title" style="color:#0D47A1;">Data Resource Output</h3>
                                        <div class="row" id="specFrm">
                                            <div class="form-material col-md-12">
                                                <div class="form-material row">
                                                    <div class="col-md-5 col-sm-5 col-8">
                                                        <label class="form-control-label" style="width: 100%;padding: 5px 10px 5px;background-color: #f1f4f5;">Data Pattern</label>
                                                    </div>
                                                    <div class="col-md-5 col-sm-4 col-8">
                                                        <label class="form-control-label" style="width: 100%;padding: 5px 10px 5px;background-color: #f1f4f5;">Output Variable</label>
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
                                <div class="row">
                                    <div class="col-md-6">   
                                        <h3 class="example-title" style="color:#0D47A1;">Communication Protocol</h3>
                                        <div class="form-group form-material ">
                                            <select class="form-control " id="inputComService" name="comeservice" >
                                                <option value="" >Select Communication Services</option>
                                                <?php foreach ($commservice["list"] as $d) { ?>
                                                    <option value="<?= $d->type?>" ><?= $d->label?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php if( !empty($commservice["http_url"]) ){ ?>
                                        <div class="example-wrap" id="http-config" style="display:none">
                                            <h3 class="example-title" style="color:#0D47A1;">Configuration for HTTP Communication </h3>
                                            <div class="form-group form-material ">
                                                <label class="form-control-label" for="inputHTTPPost">REST-API URL</label>
                                                <input type="text" class="form-control" id="inputHTTPPost" name="http_post" value="<?= $commservice["http_url"] ?>" 
                                                    readonly="true"/>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php if( !empty($commservice["mqtt"]) ) { ?>
                                        <div class="example-wrap" id="mqtt-config" style="display:none">
                                            <h3 class="example-title" style="color:#0D47A1;">Configuration for MQTT Communication </h3>
                                            <div class="form-group form-material ">
                                                <label class="form-control-label" for="inputMQTTServer">Server</label>
                                                <input type="text" class="form-control" id="inputMQTTServer" name="mqtt_server" value="<?= (empty($commservice["mqtt"]->{"server"}))?'':$commservice["mqtt"]->{"server"};  ?>" 
                                                    readonly="true"/>
                                            </div>
                                            <div class="form-group form-material ">
                                                <label class="form-control-label" for="inputMQTTPort">Port</label>
                                                <input type="text" class="form-control" id="inputMQTTPort" name="mqtt_port" value="<?= (empty($commservice["mqtt"]->{"port"}))?'':$commservice["mqtt"]->{"port"};  ?>" 
                                                    readonly="true"/>
                                            </div>
                                            <div class="form-group form-material ">
                                                <label class="form-control-label" for="inputMQTTTopic">Topic</label>
                                                <input type="text" class="form-control" id="inputMQTTTopic" name="mqtt_topic" value="<?= (empty($commservice["mqtt"]->{"topic"}))?'':$commservice["mqtt"]->{"topic"};  ?>" 
                                                    readonly="true"/>
                                            </div>
                                        </div>
                                        <?php } ?>                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="example-wrap">
                                            <h3 class="example-title">Sensor Data Transmit to The Server</h3>
                                            <div class="example">
                                                <table class="table table-hover" data-plugin="selectable" data-row-selectable="true">
                                                    <thead>
                                                        <tr>
                                                            <th class="w-50">
                                                                <!-- <span class="checkbox-custom checkbox-primary">
                                                                <input class="selectable-all" type="checkbox">
                                                                <label></label>
                                                                </span> -->
                                                            </th>                                                        
                                                            <th> Sensor Field </th>
                                                            <th> Data Source </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($field as $d){ ?>
                                                        <tr>
                                                            <td>
                                                                <span class="checkbox-custom checkbox-primary">
                                                                <input class="selectable-item" type="checkbox" name="data_transmitted[]" value="<?= $d ?>">
                                                                <label for="row-619"></label>
                                                                </span>
                                                            </td>
                                                            <td><?= $d ?></td>
                                                            <td>
                                                                <select class="form-control transmited-data" id="field_<?= $d ?>"  name="field_<?= $d ?>"></select>   
                                                            </td>                                                            
                                                        </tr>  
                                                        <?php } ?>                                                     
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-buttons mt-10">
                                    <a class="btn btn-default btn-outline  waves-effect waves-classic prev-step" href="#" role="button">Back</a>
                                    <a class="btn btn-primary btn-outline float-right waves-effect waves-classic next-step" href="#" role="button">Next</a>
                                </div>
                            </div>
                            <div class="tab-pane" id="finalData" role="tabpanel">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-20" id="mqtt-config">
                                            <h4 class="example-title" style="color:#0D47A1;">Device Configuration</h4>
                                            <div class="row">
                                                <div class="col-11 col-md-4"><h5><b>Time Interval</b></h5></div>
                                                <div class="col-1"><h5>:</h5></div>
                                                <div class="col-md-7"><h5><span id="label_timeInterval">-</span> Seconds</h5></div>
                                            </div>                
                                        </div>
                                        <div class="mb-20" id="mqtt-config">
                                            <h4 class="example-title" style="color:#0D47A1;">Data Resource</h4>
                                            <div class="row">
                                                <div class="col-11 col-md-4"><h5><b>Resource</b></h5></div>
                                                <div class="col-1"><h5>:</h5></div>
                                                <div class="col-md-7"><h5><span id="label_resource">-</span></h5></div>
                                                <div class="col-11 col-md-4"><h5><b>Interface</b></h5></div>
                                                <div class="col-1"><h5>:</h5></div>
                                                <div class="col-md-7"><h5><span id="label_interface">-</span></h5></div>
                                                <div class="col-11 col-md-4"><h5><b>Data Converter Method</b></h5></div>
                                                <div class="col-1"><h5>:</h5></div>
                                                <div class="col-md-7"><h5><span id="label_converter">-</span></h5></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-20" id="mqtt-config">
                                            <h4 class="example-title" style="color:#0D47A1;">Data Transmitted</h4>
                                            <div class="row">
                                                <div class="col-11 col-md-4"><h5><b>Communication Protocol</b></h5></div>
                                                <div class="col-1"><h5>:</h5></div>
                                                <div class="col-md-7"><h5><span id="label_comService">-</span></h5></div>                                                 
                                                <div class="col-11 col-md-4"><h5><b>Item Data Transmitted</b></h5></div>
                                                <div class="col-1"><h5>:</h5></div>
                                                <div class="col-md-7" id="label_dataTransmitted">
                                                    -
                                                </div>                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-buttons mt-10">
                                    <a class="btn btn-default btn-outline  waves-effect waves-classic prev-step" href="#" role="button">Back</a>
                                    <button class="btn btn-success btn-outline float-right waves-effect waves-classic" name="save" value="save" role="submit">Finish</button>
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
<!-- <script src="<?= base_url()?>assets/global/js/Plugin/asselectable.js"></script> -->
<!-- <script src="<?= base_url()?>assets/global/js/Plugin/selectable.js"></script> -->
<!-- <script src="<?= base_url()?>assets/global/js/Plugin/table.js"></script> -->

<script>
    var fieldDevice=<?php echo json_encode($field); ?>;
    var usedFieldDevice=[];
    var objectPattern = {};
    var usedObjectPattern = [];
    var resourceOutput = {};
    
    function patternProcess(resource = "USB Mono Stick"){
        console.log(resource);
        if( resource == "USB Mono Stick"){
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
        if(resource == "Data Logger [GL240]"){
            var method = $("#inputMethod").val();
            var webresult = $("#inputWebScrapResults").val();  
            var indexName = $("#inputIndexName").val();
            var indexValue = $("#inputIndexValue").val();
            var maxSequence = $("#inputMaxSequence").val();
            if(method!="" && webresult!="" && indexName!="" && maxSequence!=""){
                data = {
                    "method":method,
                    "webresult":webresult,
                    "indexname":indexName,
                    "indexvalue":indexValue,
                    "maxsequence":maxSequence
                };
                console.log(data)
                $.ajax({
                    type: 'post',
                    url: '<?= base_url()?>device/edge/<?= $id ?>/process',
                    data: data,
                    success: function (result){
                        status = result["status"];
                        console.log(result);
                        if(status){            
                            objectPattern = result["data"];
                            fieldForm();
                            patternFormStart();
                            $("#btnsave").show();
                        }else{
                            toastr.error('Process Failed', 'Failed', {timeOut: 3000});
                        }
                    }
                });
            }else{      
                toastr.error('Please choose method and fill all form data', 'Failed', {timeOut: 3000});
            } 
        }
        
        
        
    }

    function patternFormStart(){
        var method = $("#inputMethod").val();
        var optionPattern = '<option value="">--- Select Data Pattern---</option>';    
        $("input[name='object_pattern[]']").each(function() {
            var optionDevice = '<option value="">--- Select Field---</option>';
            id =  $(this).val();
            var value = $("select[name='pattern_"+id+"']").val();
            if(method == "array_list"){
                for(var i in objectPattern){
                    if(!usedObjectPattern.includes(i)){
                    optionPattern +='<option value="'+i+'">item['+i+'] ('+objectPattern[i]+') </option>';
                    }else if(objectPattern[i] == value){
                    optionPattern +='<option value="'+i+'" selected>item['+i+'] ('+objectPattern[i]+') </option>';
                    }
                }
            } else if(method == "json_object" || method == "web_scrapping"){
                for(var i in objectPattern){
                    if(!usedObjectPattern.includes(i)){
                    optionPattern +='<option value="'+i+'">'+i+' ('+objectPattern[i]+') </option>';
                    }else if(objectPattern[i] == value){
                    optionPattern +='<option value="'+i+'" selected>'+i+' ('+objectPattern[i]+') </option>';
                    }
                }
            }
            $("select[name='pattern_"+id+"']").html(optionPattern);
        }); 

    }

    function addForm(){
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
        } else if(method == "json_object"|| method == "web_scrapping"){
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
                    '<select class="form-control" onchange="patternForm(\''+id+'\')" name="pattern_'+id+'" >'+
                    optionPattern + 
                    '</select>'+
                '</div>'+         
                '<div class="col-md-5 col-8">'+
                    '<input class="form-control" type="text" name="field_'+id+'" onchange="fieldForm()" >'+                    
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
    }

    function removeForm(id){           
        $("#"+id).remove();    
        fieldForm();
    }

    function fieldForm(){
        resourceOutput = {};
        $("input[name='object_pattern[]']").each(function() {
            id =  $(this).val();
            var field = $("input[name='field_"+id+"']").val();
            var value = $("select[name='pattern_"+id+"']").val();
            if(value !="" && field != ""){
                resourceOutput[field] = value;
            }
            
        });
        validation2(!jQuery.isEmptyObject(resourceOutput));

        $(".transmited-data").each(function() {
            var optionResourceOuput = '<option value="">--- Select Item Data Resource---</option>';    
            value =  $(this).val();
            for(var i in resourceOutput){
                if(value == i){
                    optionResourceOuput +='<option selected value="'+i+'">'+i+'</option>';    
                }else{
                    optionResourceOuput +='<option value="'+i+'">'+i+'</option>';
                }
            }
            $(this).html(optionResourceOuput);
        });                 

    } 

    function patternForm(id){        
        value  = $("select[name='pattern_"+id+"']").val();
        $("input[name='field_"+id+"']").val(value);
        fieldForm();
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
        if(val){
            $("#navDeviceConfiguration").addClass("done");   
            $("#navDataResource_link").removeClass("disabled"); 
        }else{
            $("#navDeviceConfiguration").removeClass("done");
            $("#navDataResource_link").addClass("disabled");
        }
    }

    function validation2(val){                
        if(val){
            $("#navDataResource").addClass("done");   
            $("#navDataTransmitted_link").removeClass("disabled"); 
        }else{
            $("#navDataResource").removeClass("done");
            $("#navDataTransmitted_link").addClass("disabled");
        }
    }

    function validation3(){                
        comservice = $("#inputComService").val();        
        var valid_transmit = false;
        $('input[type=checkbox]').each(function () {
            field = $(this).val();
            if(this.checked){
                valid_transmit = true;
                item_value = $("#field_"+field).val();
                if(item_value == ""){
                    valid_transmit = false;
                    return false;
                }
            }            
        });
        
        if( comservice != "" && valid_transmit == true){
            $("#navDataTransmitted").addClass("done");   
            $("#navFinalData_link").removeClass("disabled"); 
        }else{
            $("#navDataTransmitted").removeClass("done");
            $("#navFinalData_link").addClass("disabled");
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
        
        // $(".disabled").on("click", function(e) {
        //     e.preventDefault();
        //     return false;
        // });

        $('a[data-toggle="tab"]').click(function(e){            
            if($(this).hasClass("disabled")){
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                return false;
            }
            menu = $(this).attr("id");
            console.log(menu);
            if(menu == "navFinalData_link"){
                $("#label_timeInterval").html($("#inputTimeInterval").val());
                $("#label_resource").html($("#inputResouce option:selected").text());
                $("#label_interface").html($("#inputInterface option:selected").text());
                $("#label_converter").html($("#inputMethod option:selected").text());
                $("#label_comService").html($("#inputComService option:selected").text());

                list_trasmitted = "";
                $('input[type=checkbox]').each(function () {
                    field = $(this).val();
                    if(this.checked){
                        list_trasmitted+="<h5><span>"+field+"</span></h5>";
                    }            
                });
                $("#label_dataTransmitted").html(list_trasmitted);

            }
            
        });

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
            if(!$active.parent().next().find('.nav-links').hasClass('disabled')){
                nextTab($active);   
            }
        });
        
        $(".prev-step").click(function (e) {
            var $active = $('.nav-tabs li>a.active');
            prevTab($active);
        });  
        
        $("#inputComService").change(function(){
            var comservice = $("#inputComService").val();
            if(comservice == "http_post" ){
                $("#http-config").show();    
                $("#mqtt-config").hide();    
            } else if(comservice == "mqtt" ){
                $("#mqtt-config").show();    
                $("#http-config").hide();    
            } else {
                $("#mqtt-config").hide();    
                $("#http-config").hide();    
            } 
            validation3();
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
                        } else {
                            patternProcess(resource);
                        }                        
                    }
                });
            }
        });  

        $(".selectable-item").change(function() {
            field = $(this).val();
            // if(this.checked) {
            //     $("#field_"+field).attr("required","required");
            // }else{
            //     $("#field_"+field).removeAttr("required");
            // }
            validation3();
        });

        $(".transmited-data").change(function(){
            validation3();
        });
    });
</script>