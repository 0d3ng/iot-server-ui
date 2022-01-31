<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Add Devices Process</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device">Devices</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device/process/<?= $id ?>">Process</a></li>
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
            <h4 class="example-title">Form Add New Process for Device <?= (empty($data->name))?'':$data->name;  ?> </h4>
            <form method="post" autocomplete="off">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-material ">
                            <label class="form-control-label" for="inputBasicFirstName">Device</label>
                            <input type="text" class="form-control" id="inputBasicName" name="name" value="[<?= $id ?>] <?= (empty($data->name))?'':$data->name;  ?>" 
                                placeholder="Name" readonly="true"/>
                        </div>
                    </div>   
                    <div class="col-md-6">
                        <div class="form-group form-material ">
                            <label class="form-control-label" for="inputBasicFirstName">Field to be processed</label>
                            <select class="form-control " id="inputField" name="field" required>
                            </select>
                        </div>    
                    </div>    
                    <div class="col-md-6">
                        <div class="form-group form-material">
                                <label class="form-control-label" for="inputNumber">Number of Variables to be used</label>
                                <div class="input-group">
                                    <div class="form-control-wrap">
                                        <input type="number" class="form-control" id="inputNumber" name="number" autocomplete="off" required/>
                                    </div>
                                    <span class="input-group-btn">
                                        <button class="btn btn-info waves-effect waves-classic" type="button" id="buildNumber" >Build</button>
                                    </span>
                                </div>
                        </div>
                    </div>             
                    <div class="col-md-6">
                        <div class="form-group form-material">
                                <label class="form-control-label" for="inputPre">Declaration</label>
                                <textarea class="form-control empty" rows="3" id="inputPre" name="pre"><?= (empty($data->detail))?'':$data->detail;  ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group form-material">
                            <label class="form-control-label" for="inputProcess">Code for Process</label>
                            <input type="text" class="form-control"  name="process" value="" placeholder="" id="inputProcess" autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="row" id="formVar">
                </div>
                <div class="form-group form-material">
                  <button type="submit" name="save" value="save" class="btn btn-primary">Add New Process</button>&nbsp; &nbsp;
                  <a href="<?= base_url();?>schema"><button type="button" class="btn btn-default">Cancel</button></a>
                  <input type="hidden"  id="inputCode" value="<?= $id ?>"/>
                </div>
            </form>
          </div>
          <!-- End Example Basic Form -->
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("footer.php") ?>
<script type="text/javascript">
  var item = "";
  function deviceForm(){
    var device = $("#inputCode").val();
    $.ajax({
        type: 'post',
        url: '<?= base_url()?>combination/device/'+device,
        data: {},
        success: function (result){
          var collect = result.collect;
          for (let i = 0; i < result.field.length; i++) {
            item+='<option value="'+result.field[i]+'">'+result.field[i]+'</option>';
          }
          var keyform='<option value="">--- Select Field to be processed---</option>'+item;
          $("#inputField").html(keyform);
        }
    });
  }

    function buildVar(total){
        var formvar = "";
        for(i=0;i<total;i++){
            x = i+1;
            var formvar =formvar+'<div class="col-md-6"><div class="form-group form-material ">'+
                '<label class="form-control-label" for="inputVar'+x+'">Variable '+x+' &nbsp;&nbsp;(<span style="color:#f44336">var['+i+']</span>)</label>' + 
                '<select class="form-control " id="inputVar'+x+'" name="var['+i+']" >'+item+'</select>' +
            '</div></div>';
        }
        $("#formVar").html(formvar);
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
    $("#buildNumber").click(function(){    
        var total = $("#inputNumber").val();
        if(total!=""){
            if(total>0){
                buildVar(total);
            }
        }
    });
    deviceForm();
  });
  
</script>