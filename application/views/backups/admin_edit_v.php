<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Administrator</h4>
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
								<a href="<?= base_url()?>admin">Administrator</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Edit Data</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-8">
							<form  method="post" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - Edit Administrator Data</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="name">Name</label>
												<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required="required" value="<?= $data->name?>">
											</div>
											<div class="form-group">
												<label for="username">Username</label>
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">@</span>
													</div>
													<input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" aria-label="Username" aria-describedby="basic-addon1" disabled="true" value="<?= $data->username?>">
												</div>											
											</div>
											<div class="form-group">
												<label for="email">Email</label>
												<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required="required"  value="<?= $data->email?>">
											</div>
											<div class="form-group">
												<label for="phone">Phone</label>
												<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" required="required" value="<?= $data->phone?>">
											</div>
											
											<div class="form-group">
												<div class="row">
													<div class="col-lg-6 col-md-12">
														<label for="phone">Business Page Acces</label>
														<div>
															<input type="checkbox" <?= ($data->business_access)?'checked':''; ?> name="business" data-toggle="toggle" data-onstyle="primary" style="width: 200px;" onchange="changeToggle(this)" value="1">
														</div>	
													</div>
													<div class="col-lg-6 col-md-12">
														<label for="phone">Operational Page Acces</label>
														<div>
															<input type="checkbox" <?= ($data->operational_access)?'checked':''; ?> name="operational" data-toggle="toggle" data-onstyle="primary" style="width: 200px;" onchange="changeToggle(this)" value="1">
														</div>	
													</div>
												</div>	
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