<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Schema Update</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>schema">Schema</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>schema/data/<?= $id ?>">Data</a></li>
    <li class="breadcrumb-item active">Update</li>
  </ol>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-body container-fluid">
        
          <!-- Example Basic Form (Form grid) -->
          <div class="example-wrap">
            <h4 class="example-title">Form - Schema Update</h4>
            <div class="example">
              <form method="post" autocomplete="off">
                <div class="row">
                  <div class="col-md-6">
                    <?php 
                      foreach($form[0] as $d){
                        echo $d;
                      }
                    ?>
                  </div>
                  <div class="col-md-6">
                    <?php 
                      foreach($form[1] as $d){
                        echo $d;
                      }
                    ?>
                  </div>

                </div>

                <div class="form-group form-material">
                  <button type="submit" name="save" value="save" class="btn btn-primary">Update</button>&nbsp; &nbsp;
                  <a href="<?= base_url();?>schema/data/<?= $id ?>"><button type="button" class="btn btn-default">Cancel</button></a>
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
<script src="<?= base_url()?>assets/global/vendor/moment/moment.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/vendor/clockpicker/bootstrap-clockpicker-second.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/clockpicker.js"></script>
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
  });
</script>