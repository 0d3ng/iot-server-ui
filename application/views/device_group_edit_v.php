<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Edit Devices Group</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>devicegroups">Devices Groups</a></li>
    <li class="breadcrumb-item active">Edit</li>
  </ol>
</div>

<div class="page-content">
    <div class="row row-lg">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-body container-fluid">
        
          <!-- Example Basic Form (Form grid) -->
          <div class="example-wrap">
            <h4 class="example-title">Form Edit Devices Group</h4>
            <div class="example">
              <form method="post" autocomplete="off">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group form-material">
                      <label class="form-control-label" for="inputLocation">Devices Group Code</label>
                      <input type="text" class="form-control" id="inputLocation" name="location" value="<?= (empty($data->code_name))?'':$data->code_name;  ?>"
                        readonly/>
                    </div>
                    <div class="form-group form-material">
                      <label class="form-control-label" for="inputLocation">Token Access</label>
                      <input type="text" class="form-control" id="inputLocation" name="location" value="<?= (empty($data->token_access))?'':$data->token_access;  ?>"
                        readonly/>
                    </div>

                    <div class="form-group form-material ">
                      <label class="form-control-label" for="inputSelectType">Type</label>
                      <select class="form-control" id="inputSelectType" name="type">
                          <option value="personal" <?= ($data->group_type == 'personal')?'selected':'' ?> >Personal</option>
                          <option value="group" <?= ($data->group_type == 'group')?'selected':'' ?> >Group</option>
                      </select>
                    </div>
                    <div class="form-group form-material" id="selectGroup">
                      <label class="form-control-label" for="inputSelectGroup">User Group</label>
                      <select class="form-control " id="inputSelectGroup" name="group">
                          <?php foreach ($group as $d) { ?>
                          <option value="<?= $d->group_code?>" <?= (!empty($data->group_code))?( ($data->group_code == $d->group_code)?'selected':'' ):''; ?> ><?= $d->name?></option>
                          <?php } ?>
                      </select>
                    </div>

                    <div class="form-group form-material ">
                      <label class="form-control-label" for="inputBasicFirstName">Devices Group Name</label>
                      <input type="text" class="form-control" id="inputBasicName" name="name" value="<?= (empty($data->name))?'':$data->name;  ?>" 
                        placeholder="Name" autocomplete="off" />
                    </div>
                    <div class="form-group form-material">
                      <label class="form-control-label" for="inputPurpose">Purpose</label>
                      <input type="text" class="form-control" id="inputPurpose" name="purpose" value="<?= (empty($data->information->purpose))?'':$data->information->purpose;  ?>"
                        placeholder="Purpose devices group" autocomplete="off" />
                    </div>
                    <div class="form-group form-material">
                        <label class="form-control-label">Detail Information</label>
                        <textarea class="form-control empty" rows="3" name="detail"><?= (empty($data->information->detail))?'':$data->information->detail;  ?></textarea>
                    </div>   
                    <div class="form-group form-material">
                      <label class="form-control-label" for="inputLocation">Location</label>
                      <input type="text" class="form-control" id="inputLocation" name="location" value="<?= (empty($data->information->location))?'':$data->information->location;  ?>"
                        placeholder="Location devices group" autocomplete="off" />
                    </div>

                  </div>

                  <div class="col-md-6">
                    

                    <div class="form-group form-material">
                      <label class="form-control-label font-size-16" for="inputLocation">Communication Channel</label>
                      <div class="example mt-2 mb-2">
                        <label class="form-control-label float-left mt-3" for="inputLocation" style="width:100px;">HTTP POST</label>
                        <div class="float-left">
                          <label class="float-left pt-3" for="inputBasicOff">On</label>
                          <div class="float-left ml-20 mr-20">
                            <input type="checkbox" id="inputBasicOff" name="http_post" data-plugin="switchery" <?= ($data->communication->{'http-post'})?'checked':'' ?> />
                          </div>
                          <label class="pt-3" for="inputBasicOff">Off</label>
                        </div>
                      </div>
                      <div>
                        <code class="p-10" style="display: block;">
                          <b class="font-weight-700">Send your sensor through HTTP-POST request using format </b><br/>
                          <span class="ml-10">[url server]/comdata/sensor/[token access]</span> <br/>
                          <b class="font-weight-700">Example:</b><br/>
                          <span class="ml-10"><?= $this->config->item('url_node') ?>comdata/sensor/<?= $data->token_access?>/</span> 
                        </code>
                      </div>


                      <div class="example mt-20 mb-2">
                        <label class="form-control-label float-left mt-3" for="inputLocation"  style="width:100px;">MQTT</label>
                        <div class="float-left">
                          <label class="float-left pt-3" for="inputBasicOff">On</label>
                          <div class="float-left ml-20 mr-20">
                            <input type="checkbox" id="inputBasicOff" name="mqtt" data-plugin="switchery"
                            <?= ($data->communication->{'mqtt'})?'checked':'' ?> />
                          </div>
                          <label class="pt-3" for="inputBasicOff">Off</label>
                        </div>
                      </div>
                      <div>
                        <code class="p-10" style="display: block;">
                          <b class="font-weight-700">Send your sensor through MQTT using this topic </b><br/>
                          <span class="ml-10">message/sensor/[devices group code]</span> <br/>
                          <b class="font-weight-700">Example:</b><br/>
                          <span class="ml-10">message/sensor/<?= $data->code_name?></span> 
                        </code>
                      </div>

                      <div class="example mt-20 mb-2">
                        <label class="form-control-label float-left mt-3" for="inputLocation"  style="width:100px;">NATS</label>
                        <div class="float-left">
                          <label class="float-left pt-3" for="inputBasicOff">On</label>
                          <div class="float-left ml-20 mr-20">
                            <input type="checkbox" id="inputBasicOff" name="nats" data-plugin="switchery"
                            <?= ($data->communication->{'nats'})?'checked':'' ?> />
                          </div>
                          <label class="pt-3" for="inputBasicOff">Off</label>
                        </div>
                      </div>
                      <div>
                        <code class="p-10" style="display: block;">
                          <b class="font-weight-700">Send your sensor through NATS using this subject </b><br/>
                          <span class="ml-10">message/sensor/[devices group code]</span> <br/>
                          <b class="font-weight-700">Example:</b><br/>
                          <span class="ml-10">message/sensor/<?= $data->code_name?></span> 
                        </code>
                      </div>

                      <div class="example mt-20 mb-2">
                        <label class="form-control-label float-left mt-3" for="inputLocation"  style="width:100px;">KAFKA <br/><span style="color:red; font-size: 10px;">*for image data</span> </label>
                        <div class="float-left">
                          <label class="float-left pt-3" for="inputBasicOff">On</label>
                          <div class="float-left ml-20 mr-20">
                            <input type="checkbox" id="inputBasicOff" name="kafka" data-plugin="switchery"
                            <?= ($data->communication->{'kafka'})?'checked':'' ?> />
                          </div>
                          <label class="pt-3" for="inputBasicOff">Off</label>
                        </div>
                      </div>
                      <div>
                        <code class="p-10" style="display: block;">
                          <b class="font-weight-700">Send your sensor through Kafka using this topic </b><br/>
                          <span class="ml-10">message-sensor-[devices group code]</span> <br/>
                          <b class="font-weight-700">Example:</b><br/>
                          <span class="ml-10">message-sensor-<?= $data->code_name?></span> 
                        </code>
                      </div>

                    </div>
                  </div>

                </div>

                <div class="form-group form-material">
                  <button type="submit" name="save" value="save" class="btn btn-primary">Update Device Group</button>&nbsp; &nbsp;
                  <a href="<?= base_url();?>devicegroups"><button type="button" class="btn btn-default">Cancel</button></a>
                </div>
                <input type="hidden" name="id" value="<?= $data->id ?>">
              </form>
            </div>
          </div>
          <!-- End Example Basic Form -->
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("footer.php") ?>
<script type="text/javascript">
  $( document ).ready(function() {
    <?php if( (empty($group)) ) { ?>
      $("#selectGroup").hide();
    <?php } else if($data->group_type != 'group'){  ?>
      $("#selectGroup").hide();
    <?php } ?>
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
    
    $("#inputSelectType").change(function(){
      var typeval = $("#inputSelectType").val();
      if(typeval == 'group'){
        $("#selectGroup").show();
      } else {
        $("#selectGroup").hide();
      }

    });

  });
</script>