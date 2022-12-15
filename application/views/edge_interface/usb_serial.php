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
                        <label class="form-control-label" for="inputConfigPort">USB Serial Port</label>
                        <input type="text" class="form-control" id="inputConfigPort" name="config_port" value="<?= (empty($data->config->port))?'':$data->config->port;  ?>" 
                            placeholder="port"/>
                    </div>
                    <div class="form-group form-material ">
                        <label class="form-control-label" for="inputBaudrate">Baudrate</label>
                        <select class="form-control " id="inputConfigBaudrate" name="config_baudrate" >
                          <?php foreach ($forms->baudrate as $d) { ?>
                          <option value="<?= $d; ?>" <?= ($d == $data->config->baudrate)?'selected':'' ?> ><?= $d; ?></option>
                          <?php } ?>
                        </select>
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
                        <label class="form-control-label" for="inputStringSample">Example of Message</label>
                        <textarea class="form-control empty" rows="3" id="inputStringSample" name="string_sample"><?= (empty($data->string_sample))?'':$data->string_sample;  ?></textarea>
                    </div>
                    <div class="row">
                      <div class="col-md-4" id="form_delimeter1">   
                        <div class="form-group form-material ">
                          <label class="form-control-label" for="inputDelimeter1">Delimeter 1</label>
                          <input type="text" class="form-control" id="inputDelimeter1" name="delimeter[0]"  value="<?= (empty($data->delimeter[0]))?'':$data->delimeter[0];  ?>"/>
                        </div>
                      </div>   
                      <div class="col-md-4" id="form_delimeter2">   
                        <div class="form-group form-material ">
                          <label class="form-control-label" for="inputDelimeter2">Delimeter 2</label>
                          <input type="text" class="form-control" id="inputDelimeter2" name="delimeter[1]" value="<?= (empty($data->delimeter[1]))?'':$data->delimeter[1];  ?>"/>
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
                    <div class="form-group form-material">
                      <label class="form-control-label" for="inputPattern">Data Pattern</label>
                      <textarea class="form-control empty" rows="3" id="inputPattern" name="string_pattern" readonly><?= (empty($data->string_pattern))?'':$data->string_pattern;  ?></textarea>
                    </div>
                  </div>
                </div>

                