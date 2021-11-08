<?php include("header.php") ?>
<div class="page-header">
	<h1 class="page-title">Group Member</h1>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
		<li class="breadcrumb-item"><a href="<?= base_url();?>groups">Group</a></li>
		<li class="breadcrumb-item active">Member</li>
	</ol>
	
</div>

<div class="page-content">
	<div class="row row-lg">
		<div class="col-lg-7">
			<!-- Widget User list -->
			<div class="card" id="widgetUserList">
				<div class="card-header cover overlay">
					<img class="cover-image h-150" src="<?= base_url();?>assets//examples/images/dashboard-header.jpg" alt="...">
					<div class="overlay-panel vertical-align overlay-background">
						<div class="vertical-align-middle">
							<div class="float-left">
								<div class="font-size-20"><?= $data->name?></div>
								<p class="mb-20 text-nowrap">
									<span class="text-break"><?= $data->email?></span>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="card-block">
					<!-- Panel Projects -->
					<div class="panel" id="projects">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
                  						<td>No</td>
                  						<td>Name</td>
										<td>Email</td>
										<td>Role</td>
                  						<?php if($data->add_by == $user_now->id){ ?>
										<td>Actions</td>
                  						<?php } ?>
									</tr>
								</thead>
								<tbody id="listData">
                					<?php $no=1; foreach($member as $d){ ?>
									<tr>
                  						<td><?= $no++; ?></td>
                 			 			<td><?= $d->name?></td>
										<td><?= $d->email?></td>
										<td><?= ucwords($role[$d->id])?></td>
                  						<?php if($data->add_by == $user_now->id){ ?>
										<td>
											<button type="button" class="btn btn-sm btn-icon btn-pure btn-default waves-effect waves-classic btn-leave" data-toggle="tooltip" data-original-title="Remove Member" data-id="<?= $d->id?>">
												<i class="icon md-close" aria-hidden="true"></i>
											</button>
										</td>
                  						<?php } ?>
									</tr>
                					<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- End Panel Projects -->
					<?php if($data->add_by == $user_now->id){ ?>
					<button type="button" class="btn-raised btn btn-default btn-floating waves-effect waves-classic waves-effect waves-light" data-toggle="tooltip" data-original-title="Add Member" id="btn-add-member" >
						<i class="icon md-plus" aria-hidden="true"></i>
					</button>
					<?php } ?>
				</div>
			</div>
			<!-- End Widget User list -->
		</div>
		<?php if($data->add_by == $user_now->id){ ?>
		<div class="col-lg-5">
			<div id="examplePanel" class="panel is-close" data-load-callback="customRefreshCallback" style="height:auto;">
              	<div class="panel-heading">
                	<h3 class="panel-title">Form Add Group Member</h3>
	                <div class="panel-actions panel-actions-keep">
	                  <a class="panel-action icon md-close btn-panel-close" ></a>
	                </div>
              	</div>
              	<div class="panel-body">
                	<form method="post" id="form-add-member" autocomplete="off">
		                <div class="form-group form-material">
		                  	<label class="form-control-label" for="inputBasicEmail">Member Email Address</label>
		                  	<input type="email" class="form-control" id="inputEmail" name="email"
		                    placeholder="Email Address" autocomplete="off" required=""/>
		                </div>

		                <div class="form-group form-material ">
		                  	<label class="form-control-label" for="inputBasicFirstName">Member Name</label>
		                  	<input type="text" class="form-control" id="inputName" name="name" 
		                    placeholder="Name" autocomplete="off" readonly="true" required="" />
		                </div>
		                <div class="form-group form-material">
		                  	<button type="submit" name="save" value="save" class="btn btn-primary">Add Member Group</button> &nbsp; &nbsp;
		                  	<button type="button" class="btn btn-default btn-panel-close">Cancel</button>
		                </div>
		                <input type="hidden" name="id" id="inputId">
		                <input type="hidden" name="group" value="<?= $data->id ?>">
	              	</form>
              	</div>
              	<div class="panel-loading">
                  <div class="loader loader-default"></div>
                </div>
            </div>
		</div>
		<?php } ?>
	</div>
</div>
<?php include("footer.php") ?>
<script type="text/javascript">
	$( document ).ready(function() {
		// Override global options
		toastr.options = {
			positionClass: 'toast-top-center'
		};
		<?php if($success){ ?>
			toastr.success('<?= $success; ?>', 'Success', {timeOut: 3000})
		<?php }	
		if($error){ ?>
				toastr.error('<?= $error; ?>', 'Failed', {timeOut: 3000});
		<?php } ?>
			
		$(".btn-leave").click(function(e){
			var ids = $(this).attr('data-id');
			alertify.confirm('Do you continue to remove this member?', 
				function(){ 
					$.ajax({
			            type: 'post',
			            url: '<?= base_url()?>groups/ajax_remove_member/',
	            		data: { id:ids, group:"<?= $data->id; ?>"},
			            success: function (result){
			            	if(result == "error"){
			                   toastr.error('Remove member failed', 'Failed', {timeOut: 3000});  
			                } else if(result == "success"){                            
			                   toastr.success('Remove member success', 'Success', {timeOut: 3000});
			                   updateData();
			                }     
			            }
			        });
				},function(){ 
					
				});
		});

		<?php if($data->add_by == $user_now->id){ ?>
		var $panel = $('#examplePanel');
	    var PanelClass = new Plugin.getPlugin('panel');
	    var api = new PanelClass($panel, $panel.data());
	    api.render();
	    $("#btn-add-member").click(function(){
	    	$('#examplePanel').show();
	    });
	    $(".btn-panel-close").click(function(){
	    	$('#examplePanel').hide();
	    });
	    $("#inputEmail").keyup(function(){
	    	var email = $("#inputEmail").val();
	    	$.ajax({
	            type: 'post',
	            url: '<?= base_url()?>groups/ajax_search_member/',
	            data: { email:email},
	            success: function (result) {
	            	if(result){
	            		var memberData = JSON.parse(result);
	            		$("#inputName").val(memberData.name);
	            		$("#inputId").val(memberData.id);
	            	} else {
	            		$("#inputName").val("");
	            		$("#inputId").val("");
	            	}        
	            }
	        });
	    });
	    
	    function updateData(){
	    	$.ajax({
	            type: 'get',
	            url: '<?= base_url()?>groups/ajax_member/<?= $id?>',
	            success: function (result) {
	            	$("#listData").html(result);     
	            }
	        });
	    }

	    $('#form-add-member').on('submit', function (e) {
            $(".panel-loading").show();
            e.preventDefault();
	        $.ajax({
	            type: 'post',
	            url: '<?= base_url()?>groups/ajax_add_member/',
	            data: $('#form-add-member').serialize(),
	            success: function (result) {
	                $(".panel-loading").hide();
	            	$("#inputEmail").val("");
	            	$("#inputName").val("");
	            	$("#inputId").val("");
	                if(result == "error"){
	                   toastr.error('Add member failed', 'Failed', {timeOut: 3000});  
	                } else if(result == "success"){                            
	                   toastr.success('Add member success', 'Success', {timeOut: 3000});
	                   updateData();
	                } 
	            }
	        });    
            return false;
        });
        <?php } ?>

	});
</script>