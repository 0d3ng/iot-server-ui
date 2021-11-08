<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Edit Group</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>groups">Group</a></li>
    <li class="breadcrumb-item active">Edit</li>
  </ol>
</div>

<div class="page-content">
    <div class="row row-lg">
    <div class="col-md-6">
      <div class="panel">
        <div class="panel-body container-fluid">
        
          <!-- Example Basic Form (Form grid) -->
          <div class="example-wrap">
            <h4 class="example-title">Form Edit Group</h4>
            <div class="example">
              <form method="post" autocomplete="off">
                <div class="form-group form-material ">
                  <label class="form-control-label" for="inputBasicFirstName">Group Name</label>
                  <input type="text" class="form-control" id="inputBasicName" name="name" value="<?= (empty($data->name))?'':$data->name;  ?>" 
                    placeholder="Name" autocomplete="off" />
                </div>
                <div class="form-group form-material">
                  <label class="form-control-label" for="inputBasicEmail">Group Email Address</label>
                  <input type="email" class="form-control" id="inputBasicEmail" name="email" value="<?= (empty($data->email))?'':$data->email;  ?>"
                    placeholder="Email Address" autocomplete="off" />
                </div>
                <div class="form-group form-material">
                  <button type="submit" name="save" value="save" class="btn btn-primary">Edit Group</button> &nbsp; &nbsp;
                  <a href="<?= base_url();?>groups"><button type="button" class="btn btn-default">Cancel</button></a>
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