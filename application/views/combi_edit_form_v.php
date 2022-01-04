<?php 
    for ($i = 0; $i < count($data->field); $i++) { 
        $item = $data->field[$i];
        $item_data = ["","",""]; 
        $status = false;        
        $status_form = false;
        $status_key = false;
        $def_value = "";
        $method_value = "";
        foreach($item as $key=>$value) {           
            if(!empty($combi[$key])){
                $status = true;
                if($combi[$key] == 'key'){
                    $status_key = true;
                } else {
                    $status_form = true;
                    $device_field = $combi[$key]->device_field;
                    $item_data = $combi[$key]->data;
                    $def_value = $combi[$key]->default;
                    $method_value = $combi[$key]->option;
                }
            }
?>
<div class="row">
    <div class="form-group form-material col-6">
        <div class="checkbox-custom checkbox-primary">
            <input type="checkbox" name="inputcheck_<?= $key ?>" id="inputcheck_<?= $key ?>" onchange="checkForm('<?= $key ?>')" <?= (!empty($status))?"checked":""; ?> >
            <label for="inputcheck_<?= $key ?>"><?=  strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ) ?></label>
        </div>
    </div>
    <div class="form-group form-material col-6">
        <div class="radio-custom radio-primary">
            <input type="radio" id="inputfieldkey_<?= $key ?>" name="input_field_key" value="<?= $key ?>" onchange="checkForm('<?= $key ?>')" <?= (!empty($status_key))?"checked":""; ?> />
            <label for="inputfieldkey">Set Field as Key</label>
        </div>
    </div>
</div>
<div class="row" id="form_<?= $key ?>" <?= (empty($status_form))?'style="display:none;"':''; ?> >
    <div class="form-group form-material col-xl-4 col-md-6 col-6">
        <label class="form-control-label" for="inputDevice_<?= $key ?>">Device Data</label>
        <select class="form-control " id="inputDevice_<?= $key ?>" name="<?= $key ?>_device" onchange="deviceForm('<?= $key ?>')">
            <option value="">--- Select Device ---</option>
            <?php foreach ($device as $d) { ?>
            <option value="<?= $d->device_code?>"  <?= ($item_data[0] == $d->device_code)?"selected":""; ?> ><?= $d->name?> [<?= $d->device_code?>] </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group form-material col-xl-4 col-md-6 col-6">
        <label class="form-control-label" for="inputKey_<?= $key ?>">Key Field</label>
        <select class="form-control " id="inputKey_<?= $key ?>" name="<?= $key ?>_key_field" >            
            <option value="">--- Select Field as Key ---</option>
            <?php 
                if(!empty($status_form)){
                    foreach($device_field as $d) { 
            ?>
                <option value="<?= $d ?>" <?= ($item_data[2] == $d)?"selected":""; ?> ><?= $d ?></option>
            <?php   
                    }    
                }
            ?>
        </select>
    </div>
    <div class="form-group form-material col-xl-4 col-md-6 col-6">
        <label class="form-control-label" for="inputValue_<?= $key ?>">Value Field</label>
        <select class="form-control " id="inputValue_<?= $key ?>" name="<?= $key ?>_value_field" >
            <option value="">--- Select Field as Value ---</option>
            <?php 
                if(!empty($status_form)){
                    foreach($device_field as $d) { 
            ?>
                <option value="<?= $d ?>" <?= ($item_data[1] == $d)?"selected":""; ?> ><?= $d ?></option>
            <?php   
                    }    
                }
            ?>
        </select>
    </div>
    <div class="form-group form-material col-xl-4 col-md-6 col-6">
        <label class="form-control-label" for="inputDefault_<?= $key ?>">Default Value</label>
        <input type="text" class="form-control" id="inputDefault_<?= $key ?>" name="<?= $key ?>_default_val" value="<?= $def_value; ?>" 
        autocomplete="off" />
    </div>
    <div class="form-group form-material col-xl-4 col-md-6 col-6">
        <label class="form-control-label" for="inputMethod_<?= $key ?>">Method</label>
        <select class="form-control " id="inputMethod_<?= $key ?>" name="<?= $key ?>_method" >
            <option value="">--- Select Method ---</option>
            <option value="average" <?= ($method_value == "average")?"selected":""; ?>  >Average</option>
        </select>
    </div>
</div>
<?php }
} ?>