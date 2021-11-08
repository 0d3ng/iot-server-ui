<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Transaction</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?= base_url()?>">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Transaction</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-8">
							<form  method="get" action="">
							<div class="card">
								<div class="card-header">
									<div class="ml-auto" style="float: right;">
										<input type="checkbox" <?= ($all == 'date')?'checked':''; ?> data-toggle="toggle" data-onstyle="primary" style="width: 200px;" onchange="changeToggle(this)">
									</div>	
									<div class="card-title">Filter By Date</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="body-machine">Start</label>
												<input type="text" id="str" class="form-control datepicker" data-name="str" name="str" placeholder="Enter Birth" required="required" value="<?= $str_date?>" <?= ($all == 'all')?'disabled':''; ?> >
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="body-machine">End</label>
												<input type="text" id="end" class="form-control datepicker" data-name="end" name="end" placeholder="Enter Birth" required="required" value="<?= $end_date?>" <?= ($all == 'all')?'disabled':''; ?> >
											</div>
										</div>
										<input type="hidden" name="filter" id="all" value="<?= $all; ?>">
										<div class="col-md-4">
											<div class="form-group" style="padding-top:35px;">
												<button class="btn btn-primary" type="submit">Refresh</button>
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
										<h4 class="card-title">Transaction Data List</h4>
										<a href="<?= base_url('user')?>/transaction/add/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											Add New Transaction
										</button></a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Date</th>
													<th>Transaction Code</th>
													<th>Driver</th>
													<th>Car</th>
													<th>Total</th>
													<th>Status</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Date</th>
													<th>Transaction Code</th>
													<th>Driver</th>
													<th>Car</th>
													<th>Total</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->transaction_id,0,'',''); ?>
												<tr>
													<td><?= date("Y-m-d H:i:s", strtotime($d->date_add)) ?></td>
													<td><?= $d->transaction_code ?></td>
													<td><?= $d->driver->name ?></td>
													<td><?= $d->car->vehicle_number ?></td>
													<td><?= number_format($d->pay,0,',','.'); ?></td>
													<td>
														<?php if($d->status == 0){ ?>
														<span class="text-warning pl-3">Order</span>
	                                                    <?php } else if($d->status == 1){ ?>
	                                                    <span class="text-success pl-3">Transaction Succes</span>
	                                                    <?php } else if($d->status == 2){ ?>
	                                                    <span class="text-info pl-3">Driver On The Way</span>
	                                                    <?php } else if($d->status == 3){ ?>
	                                                    <span class="text-primary pl-3">Transaction Start</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<div class="form-button-action" style="margin-left: -20px;">
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-info" data-original-title="Detail" style="padding: .375rem .75rem;">
																<a href="<?= base_url('user');?>/transaction/detail/<?= $id; ?>"  class="text-info">
																<i class="fas fa-search"></i>
																</a>
															</button>
															<?php if( $d->status == 0 || $d->status == 2){ ?>
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Cancel" style="padding: .375rem .75rem;">
																<a href="<?= base_url('user');?>/transaction/cancel/<?= $id; ?>"  class="btn-delete text-danger">
																<i class="fa fa-times"></i>
																</a>
															</button>
															<?php } ?>
															<!-- <?php if( $d->status == 1 ){ ?>
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Invoice" style="padding: .375rem .75rem;">
																<a href="<?= base_url('user');?>/transaction/invocie/<?= $id; ?>"  class="btn-delete text-success">
																<i class="fa fa-times"></i>
																</a>
															</button>
															<?php } ?> -->

														</div>
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
	function changeToggle(input){
		if(input.checked){
			$("#all").val("date");
			$("#str").prop("disabled", false);
			$("#end").prop("disabled", false);
		} else {
			$("#all").val("all");
			$("#str").prop("disabled", true);
			$("#end").prop("disabled", true);
		}
	}
</script>