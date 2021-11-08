<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Password Setting</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item active">Password Setting</li>
  </ol>
</div>

<div class="page-content">
    <div class="row row-lg">
    <div class="col-md-6">
      <div class="panel">
        <div class="panel-body container-fluid">
        
          <!-- Example Basic Form (Form grid) -->
          <div class="example-wrap">
            <h4 class="example-title">Password Setting</h4>
            <div class="example">
              <form method="post" autocomplete="off">
                <div class="form-group form-material ">
                  <label class="form-control-label" for="inputOldPassword">Old Password</label>
                  <input type="password" class="form-control" id="inputOldPassword" name="old_password"
                    placeholder="Password" autocomplete="off" required/>
                </div>
                <div class="form-group form-material ">
                  <label class="form-control-label" for="inputNewPassword">New Password</label>
                  <input type="password" class="form-control" id="inputNewPassword" name="password"
                    placeholder="Password" autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters" required />
                </div>
                <div class="form-group form-material ">
                  <label class="form-control-label" for="inputConfPassword">Retype new Password</label>
                  <input type="password" class="form-control" id="inputConfPassword" name="passconf"
                    placeholder="Password" autocomplete="off" required/>
                </div>
                <div class="form-group form-material">
                  <button type="submit" name="save" value="save" class="btn btn-primary">Update Password</button>
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
    
    ////Validation Password////
    var password = document.getElementById("inputNewPassword")
        ,confirm_password = document.getElementById("inputConfPassword");

    function validatePassword(){
      if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
      } else {
        confirm_password.setCustomValidity('');
      }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
  });
</script>