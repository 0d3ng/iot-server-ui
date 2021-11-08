<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Transaction</h4>
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
								<a href="<?= base_url()?>transaction">Transaction</a>
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
						<div class="col-md-12 col-lg-12">
							<form  method="post" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - Add New Transaction Data</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="name">Customer</label>
												<select class="form-control" id="exampleFormControlSelect1" name="customer">
													<?php foreach ($customer as $d) { $id=number_format($d->customer_id,0,'',''); ?>
													<option value="<?= $id ?>"><?= $d->name ?>&nbsp;&nbsp;&nbsp;[ <?= $d->email ?> - <?= $d->phone ?> ]</option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="name">Car</label>
												<select class="form-control" id="exampleFormControlSelect1" name="car">
													<?php foreach ($car as $d) { $id=number_format($d->car_id,0,'',''); ?>
													<option value="<?= $id ?>"><?= $d->vehicle_number ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="name">Driver</label>
												<select class="form-control" id="exampleFormControlSelect1" name="driver">
													<?php 
														foreach ($driver as $d) { 
															$id=number_format($d->driver_id,0,'',''); 													
													?>
													<option value="<?= $id ?>"><?= $d->name ?>&nbsp;&nbsp;&nbsp;[ <?= $d->username ?> - <?= $d->phone ?> ]</option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="phone">Fuel Type</label>
												<select class="form-control" id="fuel-type" name="fuel-type" required>
													<?php 
													$prices = array(); 
													foreach ($fuel as $d) { 
														$prices[] = $d->price; ?>
													<option value="<?= $d->fuel ?>" onclick="setprice(<?= $d->price ?>)"><?= $d->fuel ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="model">Fuel Price</label>
												<input type="number" class="form-control" id="price" name="price" placeholder="Enter Fuel Price" required="required" value="<?php if(!empty($prices)) echo $prices[0]; ?>">
											</div>
											<div class="form-group">
												<label for="model">Total</label>
												<input type="number" class="form-control" id="fuel-total" name="fuel-total" placeholder="Enter Total" required="required">
											</div>
											<div class="form-group">
												<label for="model">Pay</label>
												<input type="number" class="form-control" id="pay" name="pay" placeholder="0" required="required">
											</div>
											<div class="form-check">
												<label class="form-check-label">
													<input class="form-check-input" type="checkbox" name="paid" value="true" checked>
													<span class="form-check-sign">Paid Transaction</span>
												</label>
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

	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd'
	});
	$( "#price" ).keyup(function( event ) {
		var total = parseFloat($( "#price" ).val()) * parseFloat($( "#fuel-total" ).val());
		$("#pay").val(total);
	});
	$( "#fuel-total" ).keyup(function( event ) {
		var total = parseFloat($( "#price" ).val()) * parseFloat($( "#fuel-total" ).val());
		$("#pay").val(total);
	});
	<?php
	$js_array = json_encode($prices);
	echo "var prices = ". $js_array . ";\n";
	?>
	$("#fuel-type").change(function() {
		var index = $(this).children('option:selected').index();
		var price = prices[index];
		$( "#price" ).val(price);
		$( "#price" ).keyup();
	});

</script>