<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Add New Data Synchronization Service</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>datasync">Data Synchronization</a></li>
    <li class="breadcrumb-item active">Add</li>
  </ol>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-body container-fluid">
        
          <!-- Example Basic Form (Form grid) -->
          <div class="example-wrap">
            <h4 class="example-title">Form Add New Data Synchronization Function</h4>
            <div class="example">
              <form method="post" autocomplete="off">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group form-material ">
                      <label class="form-control-label" for="inputBasicFirstName">Data Synchronization Service Name</label>
                      <input type="text" class="form-control" id="inputBasicName" name="name" value="<?= (empty($data->name))?'':$data->name;  ?>" 
                        placeholder="Name" autocomplete="off" required/>
                    </div>
                    <div class="form-group form-material" >
                      <label class="form-control-label" for="inputSchema">Schema Target</label>
                      <select class="form-control " id="inputSchema" name="schema" required>
                          <option value="">--- Select Schema Target ---</option>
                          <?php foreach ($schema as $d) { ?>
                          <option value="<?= $d->schema_code?>"><?= $d->name?> [<?= $d->schema_code?>]</option>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="form-group form-material ">
                      <label class="form-control-label" for="inputTime">Sampling Time (in second)</label>
                      <input type="number" class="form-control" id="inputTime" name="time_loop" value="<?= (empty($data->time_loop))?'':$data->time_loop;  ?>" 
                        placeholder="Sampling time in second" autocomplete="off" required/>
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
                    <div class="form-group form-material">
                      <label class="form-control-label" for="inputPurpose">Purpose</label>
                      <input type="text" class="form-control" id="inputPurpose" name="purpose" value="<?= (empty($data->purpose))?'':$data->purpose;  ?>"
                        placeholder="Purpose data syncs group" autocomplete="off" />
                    </div>
                    <div class="form-group form-material">
                        <label class="form-control-label">Detail Information</label>
                        <textarea class="form-control empty" rows="3" name="detail"><?= (empty($data->detail))?'':$data->detail;  ?></textarea>
                    </div>  
                  </div>

                  <div class="col-md-6" id="form_schema">
                    
                  </div>
                </div>
                <div class="form-group form-material">
                  <button type="submit" name="save" value="save" class="btn btn-primary">Add New Data Synchronization Service</button>&nbsp; &nbsp;
                  <a href="<?= base_url();?>datasync"><button type="button" class="btn btn-default">Cancel</button></a>
                  <input type="hidden" name="field" id="listField">
                </div>
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
    
    $("#inputSchema").change(function(){
        var shcema = $("#inputSchema").val();
        $.ajax({
            type: 'post',
            url: '<?= base_url()?>datasync/schema/'+shcema,
            data: {},
            success: function (result){
                $("#form_schema").html(result);
            }
        });
    });    
  });

  var key = "";
  var key_ui = "";

  function checkForm(field){
    var check = $("#inputcheck_"+field).is(':checked');
    var radio = $("#inputfieldkey_"+field).is(':checked');  

    if( check && !radio ){
      $("#form_"+field).removeAttr("style");
    } else {
      $("#form_"+field).css("display","none");
    }  
    if(radio){            
      if(key != field){
        var check2 = $("#inputcheck_"+key).is(':checked');
        var radio2 = $("#inputfieldkey_"+key).is(':checked');   
        if( check2 && !radio2 ){
          $("#form_"+key).removeAttr("style");
        } else {
          $("#form_"+key).css("display","none");
        }
      }       
      if(!check){
        $("#inputcheck_"+field).prop('checked', true);
        var check = $("#inputcheck_"+field).is(':checked');        
      }
      key = field;
    }    
  }

  function deviceForm(field){
    var device = $("#inputDevice_"+field).val();
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
          var keyform='<option value="">--- Select Field as Key ---</option>'+item;
          var valform='<option value="">--- Select Field as Value ---</option>'+item;
          $("#inputKey_"+field).html(keyform);
          $("#inputValue_"+field).html(valform);
          $("#inputCollect_"+field).val(collect);
        }
    });
  }
</script>
<script src="<?= base_url()?>assets/js/Site.js"></script>
