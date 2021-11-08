<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Schedule History </h4>
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
								<a href="#">Schedule History</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<form  method="get" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Search By Date</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="body-machine">Start</label>
												<input type="text" class="form-control datepicker" data-name="str" name="str" placeholder="Enter Birth" required="required" value="<?= $str_date?>" >
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="body-machine">End</label>
												<input type="text" class="form-control datepicker" data-name="end" name="end" placeholder="Enter Birth" required="required" value="<?= $end_date?>" >
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group" style="padding-top:35px;">
												<button class="btn btn-primary" type="submit">Search</button>
											</div>
										</div>
									</div>
								</div>								
							</div>
							</form>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Schedule History Data List</h4>									
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Date</th>
													<?php if($role_user != 'driver'){ ?>
													<th>Driver</th>
													<th>Driver Phone</th>
													<?php } ?>
													<th>Car</th>
													<th>Capacity</th>
													<th>Owner</th>
													<th>Status</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Date</th>
													<?php if($role_user != 'driver'){ ?>
													<th>Driver</th>
													<th>Driver Phone</th>
													<?php } ?>
													<th>Car</th>
													<th>Capacity</th>
													<th>Owner</th>
													<th>Status</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->car_driver_id,0,'',''); ?>
												<tr>
													<td><?= date("Y-m-d", strtotime($d->date_add)) ?></td>
													<?php if($role_user != 'driver'){ ?>
													<td><?= $d->driver->name ?></td>
													<td><?= $d->driver->phone ?></td>
													<?php } ?>
													<td><?= $d->car->vehicle_number ?></td>
													<td><?= number_format($d->car->capacity,0,',','.'); ?></td>
													<td><?= $d->car->owner ?></td>
													<td>
														<?php if($d->status == 0){ ?>
														<span class="text-warning pl-3">Not Active</span>
	                                                    <?php } else if($d->status == 1){ ?>
	                                                    <span class="text-success pl-3">Active</span>
	                                                    <?php }  ?>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
<?php include("footer.php") ?>
	
<script type="text/javascript">
	$(document).ready(function() {
		$('#add-row').DataTable({
			});
		//Notify
		<?php if($success){ ?>
		$.notify({
			icon: 'flaticon-success',
			title: 'Success',
			message: "<?= $success; ?>",
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
			message: "<?= $error; ?>",
		},{
			type: 'danger',
			placement: {
				from: "bottom",
				align: "right"
			},
			time: 3000,
		});	
		<?php } ?>

		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		});

	});
</script>