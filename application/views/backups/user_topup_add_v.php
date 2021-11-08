<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">New EB Money Top Up</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?= base_url('user')?>">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?= base_url('user')?>/topup">Top Up</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">New Top Up</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-8">
							<form  method="post" action="" enctype="multipart/form-data">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - New EB Money Topup</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="model">Amount</label>
												<input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount" required="required">
											</div>											
											<div class="form-group">
												<label for="exampleFormControlFile1">Payment Struct - Photo/Image</label>
												<input type="file" class="form-control-file" id="exampleFormControlFile1" name="photo">
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

		// $("#idForm").submit(function(e) {
		//     e.preventDefault(); // avoid to execute the actual submit of the form.

		//     var form = $(this);
		//     var url = form.attr('action');

		//     $.ajax({
		//            type: "POST",
		//            url: "ebmoney/topup/upload/",
		//            data: form.serialize(), // serializes the form's elements.
		//            success: function(data)
		//            {
		//                console.log(data); // show response from the php script.
		//            }
		//          });
		// });
	});

</script>