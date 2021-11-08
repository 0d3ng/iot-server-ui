<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Car</h4>
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
								<a href="<?= base_url()?>car">Car</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Update Data</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-8 col-lg-6">
							<form  method="post" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - Update Car Data</div>
								</div>
								
								<div class="card-body">
									<div class="row">
										<div class="col-md-12 col-lg-12">
											<div class="form-group">
												<label for="vnumber">Vehicle Number</label>
												<input type="text" class="form-control" id="vnumber" name="vnumber" placeholder="Enter Vehicle Number" required="required" value="<?= $data->vehicle_number?>">
											</div>
											<div class="form-group">
												<label for="capacity">Capacity (Liter)</label>
												<input type="number" class="form-control" id="capacity" name="capacity" placeholder="Enter Capacity" required="required" value="<?= $data->capacity?>" >
											</div>
											<div class="form-group">
												<label for="stnk">STNK</label>
												<input type="text" class="form-control" id="stnk" name="stnk" placeholder="Enter STNK" value="<?= $data->vehicle_number?>" value="<?= $data->stnk?>" required="required">
											</div><div class="form-group">
												<label for="model">Model</label>
												<input type="text" class="form-control" id="model" name="model" placeholder="Enter Model" value="<?= $data->model?>">
											</div>
											<div class="form-group">
												<label for="body-machine">Body Machine</label>
												<input type="text" class="form-control" id="body-machine" name="body-machine" placeholder="Enter Body Machine" value="<?= $data->body_machine?>">
											</div>
											<div class="form-group">
												<label for="name">Owner</label>
												<select class="form-control" id="owner" name="owner" required>
													<option value="PT easybensin">PT easybensin</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="card-action">
									<button class="btn btn-success" name="save" value="save">Submit</button>
									<a href="<?= base_url()?>car"><button class="btn btn-danger" type="button">Cancel</button></a>
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
</script>