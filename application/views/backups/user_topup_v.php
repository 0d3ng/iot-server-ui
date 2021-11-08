<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">EB Money Top Up</h4>
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
								<a href="#">My Top Up</a>
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
						<div class="col-md-4">
							<div class="card card-stats card-round" style="margin-bottom: 5px;">
								<div class="card-body ">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-center">
												<i class="flaticon-coins text-success"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Your Balance</p>
												<h4 class="card-title"><?= number_format($ebmoney->money,0,',','.'); ?></h4>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card card-stats card-round" style="margin-bottom: 5px;">
								<div class="card-body ">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-center">
												<i class="flaticon-plus text-info"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Total Topup</p>
												<h4 class="card-title" id="total-trans">0</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">EB Money Top Up Transaction List</h4>
										<a href="<?= base_url('user')?>/topup/add/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											New Top Up Transaction
										</button></a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th width="15%">Date</th>
													<th>Transaction Code</th>
													<th>Amount</th>
													<th>Information</th>
													<th>Status</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Date</th>
													<th>Transaction Code</th>
													<th>Amount</th>
													<th>Information</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php $total = 0; foreach ($data as $d) { $id=number_format($d->id,0,'',''); ?>
												<tr>
													<td><?= date("Y-m-d H:i:s", strtotime($d->date_add)) ?></td>
													<td><?= $d->transaction_code ?></td>
													<td><?= number_format($d->credit,0,',','.'); ?></td>
													<td><?= $d->information ?></td>
													<td>
														<?php if($d->status == 0){ ?>
														<span class="text-warning pl-3">Not Paid</span>
	                                                    <?php } else if($d->status == 1){
	                                                    	$total+=$d->credit;
	                                                    ?>
	                                                    <span class="text-success pl-3">Success</span>
	                                                    <?php } else if($d->status == 2){ ?>
	                                                    <span class="text-info pl-3">Verification</span>
	                                                    <?php }  ?>
													</td>
													<td>
														<div class="form-button-action" style="margin-left: -20px;">
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-info" data-original-title="Detail" style="padding: .375rem .75rem;">
																<a href="<?= base_url('user');?>/topup/detail/<?= $id; ?>"  class="text-info">
																<i class="fas fa-search"></i>
																</a>
															</button>
															<?php if( $d->status == 0 ){ ?>
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Pay" style="padding: .375rem .75rem;">
																<a href="<?= base_url('user');?>/topup/pay/<?= $id; ?>"  class="text-success">
																<i class="fa fa-money-check-alt"></i>
																</a>
															</button>
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Cancel" style="padding: .375rem .75rem;">
																<a href="<?= base_url('user');?>/topup/cancel/<?= $id; ?>"  class="btn-delete text-danger">
																<i class="fa fa-times"></i>
																</a>
															</button>
															<?php } ?>
														</div>
													</td>
												</tr>
												<?php  }  ?>
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
		$("#total-trans").html("<?= number_format($total,0,',','.'); ?>");

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