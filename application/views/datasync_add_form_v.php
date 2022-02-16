<?php 
    for ($i = 0; $i < count($data->field); $i++) { 
        $item = $data->field[$i];
        foreach($item as $key=>$value) {
?>
<div class="row">
    <div class="form-group form-material col-6">
        <div class="checkbox-custom checkbox-primary">
            <input type="checkbox" name="inputcheck_<?= $key ?>" id="inputcheck_<?= $key ?>" onchange="checkForm('<?= $key ?>')" >
            <label for="inputcheck_<?= $key ?>"><?=  strtoupper( str_replace("_", " ", str_replace("-"," - ",$key)) ) ?></label>
        </div>
    </div>
    <div class="form-group form-material col-6">
        <div class="radio-custom radio-primary">
            <input type="radio" id="inputfieldkey_<?= $key ?>" name="input_field_key" value="<?= $key ?>" onchange="checkForm('<?= $key ?>')" />
            <label for="inputfieldkey">Set Field as Key</label>
        </div>
    </div>
</div>
<div class="row" id="form_<?= $key ?>" style="display:none;">
    <div class="form-group form-material col-xl-4 col-md-6 col-6">
        <label class="form-control-label" for="inputDevice_<?= $key ?>">Device (Data Source)</label>
        <select class="form-control " id="inputDevice_<?= $key ?>" name="<?= $key ?>_device" onchange="deviceForm('<?= $key ?>')">
            <option value="">--- Select Device ---</option>
            <?php foreach ($device as $d) { ?>
            <option value="<?= $d->device_code?>"><?= $d->name?> [<?= $d->device_code?>] </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group form-material col-xl-4 col-md-6 col-6">
        <label class="form-control-label" for="inputKey_<?= $key ?>">Key Field</label>
        <select class="form-control " id="inputKey_<?= $key ?>" name="<?= $key ?>_key_field" >
            <option value="">--- Select Field as Key ---</option>
        </select>
    </div>
    <div class="form-group form-material col-xl-4 col-md-6 col-6">
        <label class="form-control-label" for="inputValue_<?= $key ?>">Value Field</label>
        <select class="form-control " id="inputValue_<?= $key ?>" name="<?= $key ?>_value_field" >
            <option value="">--- Select Field as Value ---</option>
        </select>
    </div>
    <div class="form-group form-material col-xl-4 col-md-6 col-6">
        <label class="form-control-label" for="inputDefault_<?= $key ?>">Default Value</label>
        <input type="text" class="form-control" id="inputDefault_<?= $key ?>" name="<?= $key ?>_default_val" value="" 
        autocomplete="off" />
    </div>
    <input type="hidden" id="inputCollect_<?= $key ?>" name="<?= $key ?>_collection" value="" />
    <div class="form-group form-material col-xl-6 col-md-6 col-6">
        <label class="form-control-label" for="inputMethod_<?= $key ?>">Sampling Function Method</label>
        <select class="form-control " id="inputMethod_<?= $key ?>" name="<?= $key ?>_method" >
            <option value="">--- Select Method ---</option>
            <option value="average">Average</option>
            <option value="first">First Data</option>
            <option value="last">Last Data</option>
            <option value="variance">Variance</option>
        </select>
    </div>
</div>
<?php }
} ?>