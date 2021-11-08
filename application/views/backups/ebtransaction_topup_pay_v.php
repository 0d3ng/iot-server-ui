<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">EB Money Top Up</h4>
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
								<a href="<?= base_url('')?>ebtransaction/topup">Top Up</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Detail Top Up</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-8">
							<form  method="post" action="" >
							<div class="card">
								<div class="card-header">
									<div class="card-title"> Form - Pay EB Money Topup </div>
									<div style="margin-top: 10px; ">
										<?php if($data->status == 0){ ?>
										<h6 class="fw-bold text-uppercase text-warning op-8">Status Top Up = Not Paid</h6>
										<span class="text-warning pl-3"></span>
	                                    <?php } else if($data->status == 1){ ?>
	                                    <h6 class="fw-bold text-uppercase text-success op-8">Status Top Up = Success</h6>
	                                    <?php } else if($data->status == 2){ ?>
	                                    <h6 class="fw-bold text-uppercase text-info op-8">Status Top Up = Verification</h6>
	                                    <?php }  ?>
									</div>

								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="model">Amount</label>
												<input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount" readonly="" value="<?= number_format($data->credit,0,',','.'); ?>" >
											</div>											
											<div class="form-group">
												<label for="exampleFormControlFile1">Payment Struct - Photo/Image</label>
												<br/>
												<?php if($data->file){ ?>
													<img class="img-responsive" style="max-height: 300px;" src="<?= $this->config->item('url_node').'ebmoney/'.$data->file ?>" >
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<div class="card-action">
									<?php if($data->status == 2){ ?>
									<button class="btn btn-success btn-confirm" name="save" value="save">Verification</button>
									<?php } ?>
									<a href="<?= base_url('')?>ebtransaction/topup"><button type="button" class="btn btn-danger">Cancel</button></a>
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
		$('.btn-confirm').click(function(){
			return confirm('Are you sure to verification this payment?');		   
		});
	});

</script>