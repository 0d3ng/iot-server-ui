<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">EB Money Transaction</h4>
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
								<a href="#">Customer List</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Customer Data List</h4>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>ID</th>
													<th>Name</th>
													<th>KTP</th>
													<th>Username</th>
													<th>Balance</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>ID</th>
													<th>Name</th>
													<th>KTP</th>
													<th>Username</th>
													<th>Balance</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->customer->customer_id,0,'',''); ?>
												<tr>
													<td><?= $id ?></td>
													<td><?= $d->customer->name ?></td>
													<td><?= $d->customer->ktp ?></td>
													<td><?= $d->customer->username ?></td>
													<td><?= number_format($d->money,0,',','.'); ?></td>
													<td>
														<div class="form-button-action" style="margin-left: -20px;">
															<a href="<?= base_url();?>ebtransaction/customer/<?= $id; ?>"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="List Transaction" style="padding: .375rem .75rem;">
																<i class="fa fa-search"></i>
															</button></a>
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
	});
</script>