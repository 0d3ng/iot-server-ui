<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Schema Data</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>schema">Schema</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>schema/data/<?= $id ?>">Data</a></li>
    <li class="breadcrumb-item active">Import</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-6">
      <div class="pricing-list text-left">
        <div class="pricing-header bg-blue-600">
          <div class="pricing-title">Schema Info</div>
          <div class="pricing-price" style="padding-top:0px; padding-bottom: 0px;font-size: 2.858rem;">
            <span class="pricing-currency"><i class="icon md-collection-text" aria-hidden="true"></i></span>
            <span class="pricing-amount"><?= $data->name; ?></span>            
          </div>
          <p class="px-30 font-size-16" ><strong>Schema Code</strong>: <i><?= $data->schema_code; ?></i></p>
        </div>
        <ul class="pricing-features font-size-16" style="background-color: #fff;" >
          <li>
            <strong>Purpose :</strong> <?= $data->information->purpose; ?></li>
          <li>
            <strong>Detail Infomation :</strong> <?= $data->information->detail; ?></li>
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel-bordered panel-success" id="formUploadDiv" style="<?= (!empty($list))?"display:none;":""; ?>">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="icon wb-upload" aria-hidden="true"></i> &nbsp;Data Import</h3>
            <div class="panel-actions" style="text-align: right;">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle waves-effect waves-classic" id="BulletDropdown2" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon wb-download" aria-hidden="true"></i> Download Template
                    </button>
                    <div class="dropdown-menu bullet dropdown-menu-right" aria-labelledby="BulletDropdown2" role="menu">
                        <a class="dropdown-item" target="_blank" href="<?= base_url() ?>schema/template/csv/<?=  $data->schema_code; ?>" role="menuitem">CSV</a>
                        <a class="dropdown-item" target="_blank" href="<?= base_url() ?>schema/template/excel/<?=  $data->schema_code; ?>" role="menuitem">Excel</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body bg-white">
            <!-- Example Date Range -->
            <div class="example-wrap">
                <div class="example">
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-group form-material row">
                          <input type="file" name="import" id="input-file-now" data-plugin="dropify" data-default-file=""/>
                        </div> 
                        <div class="form-group row form-material row">
                            <button type="submit" name="save" value="import" class="btn btn-primary waves-effect waves-classic">Import </button>
                        </div>   
                    </form>
                </div>

            </div>
            <!-- End Example Date Range -->
        </div>
      </div>
      <div class="panel-bordered panel-info mt-10" id="progressDiv" style="<?= (empty($list))?"display:none;":""; ?>">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="icon wb-time" aria-hidden="true"></i> &nbsp;Data Imprort Process</h3>
        </div>
        <div class="panel-body bg-white">
            <div class="example-wrap">
              <div class="example">
                <h5>Process Status <span id="statusProcess">: <span class="badge badge-primary">No Process</span></span></h5>
                <div class="progress progress-lg">
                  <div class="progress-bar progress-bar-danger" id="progresbar" style="width: 0%;" role="progressbar">0%</div>
                </div>
                <h5>Total Record: <span id="total"></span> </h5>
              </div>
              <button type="button" id="addNew" value="import" class="btn btn-primary waves-effect waves-classic"><i class="icon md-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add New Data Import </button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/global/vendor/jquery-ui/jquery-ui.js"></script>
<script src="<?= base_url()?>assets/global/vendor/blueimp-tmpl/tmpl.js"></script>
<script src="<?= base_url()?>assets/global/vendor/blueimp-canvas-to-blob/canvas-to-blob.js"></script>
<script src="<?= base_url()?>assets/global/vendor/blueimp-load-image/load-image.all.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/blueimp-file-upload/jquery.fileupload.js"></script>
<script src="<?= base_url()?>assets/global/vendor/blueimp-file-upload/jquery.fileupload-process.js"></script>
<script src="<?= base_url()?>assets/global/vendor/blueimp-file-upload/jquery.fileupload-image.js"></script>
<script src="<?= base_url()?>assets/global/vendor/blueimp-file-upload/jquery.fileupload-audio.js"></script>
<script src="<?= base_url()?>assets/global/vendor/blueimp-file-upload/jquery.fileupload-video.js"></script>
<script src="<?= base_url()?>assets/global/vendor/blueimp-file-upload/jquery.fileupload-validate.js"></script>
<script src="<?= base_url()?>assets/global/vendor/blueimp-file-upload/jquery.fileupload-ui.js"></script>
<script src="<?= base_url()?>assets/global/vendor/dropify/dropify.min.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/dropify.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/asprogress.js"></script>
<script>
  <?php if(!empty($list)){ ?>
    var statusStart = ': <span class="badge badge-primary">No Process</span>';
    var statusFinish = ': <span class="badge badge-success">Finish</span>';
    var statusProcess = ': <span class="badge badge-warning">On Process</span>';
    function resetprog(){
      progres = 0;
      totalRecord = 0;
      console.log(progres+"%");
      $("#progresbar").html(progres+"%");
      $("#progresbar").css("width",progres+"%");
      $("#total").html(totalRecord);
    }
    var list = JSON.parse('<?php echo str_replace('&quot;', '', json_encode($list)) ?>');
    var header = JSON.parse('<?php echo str_replace('&quot;', '', json_encode($header)) ?>');
    var totalRecord = Object.keys(list).length;
    var success = 0;
    function save(current){
      send = list[current+2];
      data = {};
      for (var key in header){
        var value = header[key];
        if(value in send){
          data[key] = send[value];
        }
      }
      $("#statusProcess").html(statusProcess);
      $.ajax({
          type: 'post',
          url: '<?= base_url()?>schema/import_add/<?= $id; ?>',
          data: data,
          success: function (result){            
            if(result.status){
              success++;
            }
            current++;
            var progres = current / totalRecord * 100;
            progres = progres.toFixed(2);
            $("#progresbar").html(progres+"%");
            $("#progresbar").css("width",progres+"%");
            $("#total").html(success+"/"+totalRecord);
            if(totalRecord != current){            
              save(current);
            } else {
              $("#statusProcess").html(statusFinish);
              $("#addNew").css("display","block");
            }
          }
      });
    }
    $("#addNew").css("display","none");
    
  <?php } ?>
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
    save(0);
    $("#addNew").click(function(){      
      $("#progressDiv").css("display","none");
      $("#formUploadDiv").css("display","block");
    });
  });
</script>