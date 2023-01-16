<div class="col-md-4">
<div class="example-wrap">
  <h3 class="example-title" style="color:#0D47A1;">Interface Configuration</h3>
  <div class="form-group form-material ">
      <label class="form-control-label" for="inputInterface">Network Interface</label>
      <select class="form-control " id="inputInterface" name="interface" >
        <?php foreach ($forms->interface as $d) { ?>
        <option value="<?= $d["type"] ?>" <?= ($d["type"] == $data->type)?'selected':'' ?> ><?= $d["label"]?></option>
        <?php } ?>
      </select>
  </div>
  <div class="form-group form-material ">
      <label class="form-control-label" for="inputConfigPort">URL of Web Services</label>
      <input type="text" class="form-control" id="inputConfigPort" name="config_url" value="<?= (empty($data->config->url))?'':$data->config->url;  ?>" 
          placeholder="port"/>
  </div>
  <div class="form-group form-material ">
      <label class="form-control-label" for="inputConfigTimeout">Timeout</label>
      <input type="text" class="form-control" id="inputConfigTimeout" name="config_timeout" value="<?= (empty($data->config->timeout))?'':$data->config->timeout;  ?>" 
          placeholder="timeout"/>
  </div>
</div>
</div>
<div class="col-md-8">
<div class="example-wrap">
  <h3 class="example-title" style="color:#0D47A1;">Data Converter Method</h3>
  <div class="form-group form-material ">
      <label class="form-control-label" for="inputMethod">Method</label>
      <select class="form-control " id="inputMethod" name="method" >
        <option value="">Select Method</option>
        <?php foreach ($forms->method as $d) { ?>
        <option value="<?= $d["type"] ?>" <?= ($d["type"] == $data->method)?'selected':'' ?> ><?= $d["label"] ?></option>
        <?php } ?>                     
      </select>
  </div>
  <div class="form-group form-material">
      <label class="form-control-label" for="inputWebScrapResults">Web Scrapping Results</label>
      <textarea class="form-control empty" rows="3" id="inputWebScrapResults" name="web_scrapping_result"><?= (empty($data->web_scrapping_result))?'':$data->web_scrapping_result;  ?></textarea>
  </div>
  <div class="row">
    <div class="col-md-4" id="form_delimeter1">   
      <div class="form-group form-material ">
        <label class="form-control-label" for="inputIndexName">Index Data for Sensor Name</label>
        <input type="text" class="form-control" id="inputIndexName" name="index_name"  value="<?= (!isset($data->index_name))?'':$data->index_name;  ?>"/>
      </div>
    </div>   
    <div class="col-md-4" id="form_delimeter2">   
      <div class="form-group form-material ">
        <label class="form-control-label" for="inputIndexValue">Index Data for Sensor Value</label>
        <input type="text" class="form-control" id="inputIndexValue" name="index_value" value="<?= (empty($data->index_value))?'':$data->index_value;  ?>"/>
      </div>
    </div>   
    <div class="col-md-4" id="form_delimeter2">   
      <div class="form-group form-material ">
        <label class="form-control-label" for="inputMaxSequence">Maximum Sequence Data</label>
        <input type="text" class="form-control" id="inputMaxSequence" name="max_sequence" value="<?= (empty($data->max_sequence))?'':$data->max_sequence;  ?>"/>
      </div>
    </div>
    <div class="col-md-4" id="form_process">
      <div class="form-group form-material" id="frmprocess" style="display: block;">
        <span class="input-group-addon" style="background:none; border:none;"> </span>
        <button type="button" onclick="patternProcess('Data Logger [GL240]')" class="btn btn-info waves-effect waves-classic waves-effect waves-classic">Process</button>
        <input type="hidden" name="back" value="back">
      </div>
    </div>   
  </div>
</div>
</div>

