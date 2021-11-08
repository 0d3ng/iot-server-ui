<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Fuel</h4>
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
								<a href="<?= base_url()?>fuel">Fuel</a>
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
									<div class="card-title">Form - Update Fuel Data</div>
								</div>
								
								<div class="card-body">
									<div class="row">
										<div class="col-md-12 col-lg-12">
											<div class="form-group">
												<label for="fuel">Fuel</label>
												<input type="text" class="form-control" id="fuel" name="fuel" placeholder="Enter Fuel" required="required" value="<?= $data->fuel?>">
											</div>
											<div class="form-group">
												<label for="capacity">Price</label>
												<input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" required="required" value="<?= $data->price?>">
											</div>
											<div class="form-group">
												<label for="address">Information</label>
												<textarea class="form-control" id="information" name="information" rows="2"><?= $data->information?></textarea>
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
</script>