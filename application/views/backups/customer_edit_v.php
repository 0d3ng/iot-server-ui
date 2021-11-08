<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Customer</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?= base_url()?>administration">
									<i class="link-icon icon-grid"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?= base_url()?>customer">Customer</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Add New Data</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-8">
							<form  method="post" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - Edit Customer Data</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="name">Name</label>
												<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required="required" value="<?= $data->name?>">
											</div>
											<!-- <div class="form-group">
												<label for="username">Username</label>
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">@</span>
													</div>
													<input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" aria-label="Username" aria-describedby="basic-addon1" disabled="true" value="<?= $data->username?>">
												</div>											
											</div> -->
											<div class="form-group">
												<label for="email">Email</label>
												<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required="required"  value="<?= $data->email?>">
											</div>
											<div class="form-group">
												<label for="phone">Phone</label>
												<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" required="required" value="<?= $data->phone?>">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="phone">NIN (KTP)</label>
												<input type="text" class="form-control" id="ktp" name="ktp" placeholder="Enter NIN" required="required" value="<?= $data->ktp?>">
											</div>
											<div class="form-group">
												<label for="body-machine">Birth</label>
												<input type="text" class="form-control" id="datepicker" data-name="birth" name="birth" placeholder="Enter Birth" required="required" value="<?= $data->birth?>" >
											</div>
											<div class="form-check">
												<label>Gender</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="gender" value="male" <?php if($data->gender == "male") echo ' checked="" '; ?> >
													<span class="form-radio-sign">Male</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="gender" value="female" <?php if($data->gender == "female") echo ' checked="" '; ?>   >
													<span class="form-radio-sign">Female</span>
												</label>
											</div>
											<div class="form-group">
												<label for="address">Address</label>
												<textarea class="form-control" id="address" name="address" rows="2"><?= $data->address?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="card-action">
									<button class="btn btn-success" name="save" value="save">Submit</button>
									<button class="btn btn-danger">Cancel</button>
								</div>								
							</div>
							</form>
						</div>
					</div>
				</div>
<?php include("footer.php") ?>
<script type="text/javascript">
	$(document).ready(function() {
		//Notify
		<?php if($success){ ?>
		$.notify({
			icon: 'flaticon-success',
			title: 'Success',
			message: '<?= $success; ?>',
		},{
			type: 'success',
			placement: {
				from: "bottom",
				align: "right"
			},
			time: 3000,
		});	
		<?php } 
		 if($error){ ?>
		$.notify({
			icon: 'flaticon-error',
			title: 'Failed',
			message: '<?= $error; ?>',
		},{
			type: 'danger',
			placement: {
				from: "bottom",
				align: "right"
			},
			time: 3000,
		});	
		<?php } ?>
	});

	////Validation Password////
	var password = document.getElementById("password")
	  	,confirm_password = document.getElementById("confirm_password");

	function validatePassword(){
	  if(password.value != confirm_password.value) {
	    confirm_password.setCustomValidity("Passwords Don't Match");
	  } else {
	    confirm_password.setCustomValidity('');
	  }
	}

	password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;

	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd'
	});
</script>