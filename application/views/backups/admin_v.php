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
								<a href="#">Administrator</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Administrator Data List</h4>
										<a href="<?= base_url()?>admin/add/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											Add New Administrator
										</button></a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>ID</th>
													<th>Name</th>
													<th>Username</th>
													<th>Email</th>
													<th>Phone</th>
													<th>Status</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>ID</th>
													<th>Name</th>
													<th>Username</th>
													<th>Email</th>
													<th>Phone</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($data as $d) { $id=number_format($d->admin_id,0,'',''); ?>
												<tr>
													<td><?= $id ?></td>
													<td><?= $d->name ?></td>
													<td><?= $d->username ?></td>
													<td><?= $d->email ?></td>
													<td><?= $d->phone ?></td>
													<td>
														<?php if($d->status == 0){ ?>
														<span class="text-warning pl-3">Not Verification</span>
	                                                    <?php } else if($d->status == 1){ ?>
	                                                    <span class="text-success pl-3">Active</span>
	                                                    <?php } else { ?>
	                                                    <span class="text-danger pl-3">Suspend</span> 
	                                                    <?php } ?>
													</td>
													<td>
														<?php if($d->role != "super-admin"){ ?>
														<div class="form-button-action" style="margin-left: -20px;">
															<?php if($d->status == 0){ ?>
															<a href="<?= base_url();?>admin/active/<?= $id; ?>"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg" data-original-title="Manual Verification" style="padding: .375rem .75rem;">
																<i class="fa fa-check"></i>
															</button></a>
		                                                    <?php } else if($d->status == 1){ ?>
		                                                    <a href="<?= base_url();?>admin/nonactive/<?= $id; ?>"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-warning btn-lg" data-original-title="Suspend Administrator" style="padding: .375rem .75rem;">
																<i class="fa fa-ban"></i>
															</button></a>
		                                                    <?php } else { ?>
		                                                    <a href="<?= base_url();?>admin/active/<?= $id; ?>"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-sm" data-original-title="Set Active Administrator" style="padding: .375rem .75rem;">
																<i class="fa fa-check"></i>
															</button></a> 
		                                                    <?php } ?>
															<a href="<?= base_url();?>admin/edit/<?= $id; ?>"><button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Data" style="padding: .375rem .75rem;">
																<i class="fa fa-edit"></i>
															</button></a>
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove" style="padding: .375rem .75rem;">
																<a href="<?= base_url();?>admin/delete/<?= $id; ?>" class="btn-delete">
																<i class="fa fa-times"></i>
																</a>
															</button>
														</div>
														<?php } ?>
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