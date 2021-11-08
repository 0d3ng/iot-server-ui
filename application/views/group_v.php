<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Group</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item active">Group</li>
  </ol>
  <div class="page-header-actions">
    <a href="<?= base_url()?>groups/add/"><button type="button" class="btn btn-sm btn-icon btn-primary btn-round waves-effect waves-classic">
      <i class="icon md-plus" aria-hidden="true"></i> &nbsp; Add New Groups&nbsp;&nbsp; 
    </button></a>
  </div>
</div>

<div class="page-content">
  <div class="row row-lg">
    <?php foreach ($data as $d) {
            $status = ''; 
            foreach($d->member as $v){
              if($v->user_id == $user_now->id){
                $status = ucwords($v->role);
                break;
              }
            }
            $total_gs = $groupsensor_m->search_count(array('group_code'=>$d->group_code))->data;

      ?>
      <div class="col-xl-4 col-lg-6">
        <!-- Widget User list -->
        <div class="card" id="widgetUserList">
          <div class="card-header cover overlay">
            <img class="cover-image h-150" src="<?= base_url();?>assets//examples/images/dashboard-header.jpg" alt="...">
            <div class="overlay-panel vertical-align overlay-background">
              <div class="vertical-align-middle">
                <div class="float-left">
                  <div class="font-size-20"><?= $d->name?></div>
                  <p class="mb-20 text-nowrap">
                    <span class="text-break"><?= $d->email?></span>
                    <br/><span class="text-break"><b><?= $status?></b></span>
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-block">
            <div class="row no-space pt-20">
              <div class="col-6">
                <div class="counter">
                  <div class="counter-label"><i class="icon md-account" aria-hidden="true"></i>  Member</div>
                  <span class="counter-number"><?= count($d->member); ?></span>
                </div>
              </div>
              <div class="col-6">
                <div class="counter">
                  <div class="counter-label"><i class="icon md-device-hub" aria-hidden="true"></i>  Group Sensor</div>
                  <span class="counter-number"><?= $total_gs; ?></span>
                </div>
              </div>
            </div>
            <?php if($d->add_by == $user_now->id){ ?>
            <a href="<?= base_url()?>groups/edit/<?= $d->group_code?>"><button type="button" class="btn-raised btn btn-default btn-floating waves-effect waves-classic waves-effect waves-light" data-toggle="tooltip" data-original-title="Edit">
              <i class="icon md-edit" aria-hidden="true"></i>
            </button></a>
            <?php } ?>
          </div>
          <div class="card-block clearfix">
            <div class="card-actions float-left" style="font-size: 1.4rem;">
              <a href="<?= base_url()?>groups/member/<?= $d->group_code ?>" data-toggle="tooltip" data-original-title="Show Member">
                <i class="icon md-account"></i>
              </a>
              <a href="<?= base_url()?>devicegroups/groups/<?= $d->group_code ?>" data-toggle="tooltip" data-original-title="Show Group Sensor">
                <i class="icon md-device-hub"></i>
              </a>
            </div>
            <a class="btn btn-danger card-link float-right waves-effect waves-classic btn-leave" href="<?= base_url()?>groups/leave/<?= $d->id ?>">
              <i class="icon md-arrow-right"></i> Leave Group
            </a>
          </div>

        </div>
        <!-- End Widget User list -->
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
      e.preventDefault();
      link = $(this).attr('href');
      alertify.confirm('Do you continue to leave this group?', 
        function(){ 
          location.replace(link);
        },function(){ 
          
        });
    });
    
  });
</script>