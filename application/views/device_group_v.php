<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Devices Groups</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item active">Devices Groups</li>
  </ol>
  <div class="page-header-actions">
    <a href="<?= base_url()?>devicegroups/add/"><button type="button" class="btn btn-sm btn-icon btn-primary btn-round waves-effect waves-classic">
      <i class="icon md-plus" aria-hidden="true"></i> &nbsp; Add New Devices Group&nbsp;&nbsp; 
    </button></a>
  </div>
</div>

<div class="page-content">
  <h2>Personal</h2>
  <div class="row row-lg">
    <?php foreach ($data_personal as $d) {
            $total_dv = $device_m->search_count(array('group_code_name'=>$d->code_name))->data;
      ?>
      <div class="col-xl-3 col-lg-4 col-md-6">
        <!-- Widget Info -->
        <div class="card card-shadow">
          <div class="card-header white bg-light-blue-600 p-30 clearfix">
            <div class="row">
              <div class="col-9">
                <div class="font-size-18 white"><?= $d->name?></div>
                <div class="font-size-14 white "><b><?= $d->code_name?></b></div>
              </div>
              <div class="col-3 text-right">
                <div class="font-size-40">
                  <i class="md-device-hub"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="card-block">
            <h4 class="card-title mb-1 font-size-16">For : <?= $d->information->purpose ?></h4>
            <p class="card-text mb-2"><?= $d->information->detail ?></p>
            <h5 class="card-text mt-2"><i class="md-pin"></i> <?= $d->information->location ?></h5>
          </div>
          <div class="card-block card-footer-bordered pt-10 ">
            <h4 class="card-title font-size-16 mb-2">Communication Channel</h5>  
            <ul class="list-group list-group-dividered mb-0 font-size-12 mt-2">
              <li class="list-group-item px-0">HTTP-POST 
                <?php if($d->communication->{'http-post'}){ ?>
                <span class="badge badge-pill badge-success font-size-12">Active</span> 
                <?php } else { ?>
                <span class="badge badge-pill badge-danger font-size-12">Not Active</span> 
                <?php } ?>
              </li>
              <li class="list-group-item px-0">MQTT 
                <?php if($d->communication->mqtt){ ?>
                <span class="badge badge-pill badge-success font-size-12">Active</span> 
                <?php } else { ?>
                <span class="badge badge-pill badge-danger font-size-12">Not Active</span> 
                <?php } ?>
              </li>              
            </ul>          
          </div>
          <div class="card-block card-footer-bordered pt-10 text-center">
            <a class="btn btn-default btn-block pl-4 pr-4 mb-2 card-link waves-effect waves-classic waves-effect waves-classic  mb-5" href="<?= base_url()?>device/?type=<?= $d->code_name?>">
              <i class="icon md-memory"></i> <?= $total_dv; ?> Devices Register
            </a>
            <br/>
            <!-- <a class="btn btn-info btn-block pl-4 pr-4 card-link waves-effect waves-classic waves-effect waves-classic mb-5" href="<?= base_url()?>devicegroups/data/<?= $d->code_name?>">
              <i class="icon md-file-text"></i> Show Data
            </a> -->
          </div>
          <div class="card-footer card-footer-transparent card-footer-bordered text-muted">
            <div class="row">
              <div class="col-6 text-left p-2">
                  <a class="btn btn-info btn-block card-link waves-effect waves-classic waves-effect waves-classic" href="<?= base_url()?>devicegroups/edit/<?= $d->code_name?>">
                  <i class="icon md-edit"></i> Edit
                  </a>
              </div>
              <div class="col-6 text-right p-2">
                  <a class="btn  btn-danger btn-block card-link float-right waves-effect waves-classic btn-leave waves-effect waves-classic" href="<?= base_url()?>devicegroups/delete/<?= $d->id?>">
                  <i class="icon md-delete"></i> Remove
                  </a>
              </div>
            </div>
          </div>
        </div>
        <!-- End Widget Info -->
      </div>
    <?php } ?>
  </div>
  <br/>
  <h2> User Groups</h2>
  <div class="row row-lg">
    <?php foreach ($data_group as $d) {
            
            $total_dv = $device_m->search_count(array('group_code_name'=>$d->code_name))->data;


      ?>
      <div class="col-xl-3 col-lg-4 col-md-6">
        <!-- Widget Info -->
        <div class="card card-shadow">
          <div class="card-header white bg-cyan-400 p-30 clearfix">
            <div class="row">
              <div class="col-9">
                <div class="font-size-18 white"><?= $d->name?></div>
                <div class="font-size-14 white "><b><?= $d->code_name?></b></div>
                <div class="font-size-16 white "><b><i><?= $group[$d->group_code]->name?></i></b></div>
              </div>
              <div class="col-3 text-right">
                <div class="font-size-40">
                  <i class="md-device-hub"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="card-block">
            <h4 class="card-title mb-1 font-size-16">For : <?= $d->information->purpose ?></h4>
            <p class="card-text mb-2"><?= $d->information->detail ?></p>
            <h5 class="card-text mt-2"><i class="md-pin"></i> <?= $d->information->location ?></h5>
          </div>
          <div class="card-block card-footer-bordered pt-10 ">
            <h4 class="card-title font-size-16 mb-2">Communication Channel</h5>  
            <ul class="list-group list-group-dividered mb-0 font-size-12 mt-2">
              <li class="list-group-item px-0">HTTP-POST 
                <?php if($d->communication->{'http-post'}){ ?>
                <span class="badge badge-pill badge-success font-size-12">Active</span> 
                <?php } else { ?>
                <span class="badge badge-pill badge-danger font-size-12">Not Active</span> 
                <?php } ?>
              </li>
              <li class="list-group-item px-0">MQTT 
                <?php if($d->communication->mqtt){ ?>
                <span class="badge badge-pill badge-success font-size-12">Active</span> 
                <?php } else { ?>
                <span class="badge badge-pill badge-danger font-size-12">Not Active</span> 
                <?php } ?>
              </li>
            </ul>          
          </div>
          <div class="card-block card-footer-bordered pt-10 text-center">
            <a class="btn btn-default btn-block pl-4 pr-4 mb-2 card-link waves-effect waves-classic waves-effect waves-classic  mb-5" href="<?= base_url()?>device/?type=<?= $d->code_name?>">
              <i class="icon md-memory"></i> <?= $total_dv; ?> Devices Register
            </a>
            <br/>
            <!-- <a class="btn btn-info btn-block pl-4 pr-4 card-link waves-effect waves-classic waves-effect waves-classic mb-5" href="<?= base_url()?>devicegroups/data/<?= $d->code_name?>">
              <i class="icon md-file-text"></i> Show Data
            </a> -->
          </div>
          <div class="card-footer card-footer-transparent card-footer-bordered text-muted">
            <div class="row">
              <div class="col-6 text-left p-2">
                  <a class="btn btn-info btn-block card-link waves-effect waves-classic waves-effect waves-classic" href="<?= base_url()?>devicegroups/edit/<?= $d->code_name?>">
                  <i class="icon md-edit"></i> Edit
                  </a>
              </div>
              <div class="col-6 text-right p-2">
                  <a class="btn btn-danger btn-block card-link float-right waves-effect waves-classic btn-leave waves-effect waves-classic" href="<?= base_url()?>devicegroups/delete/<?= $d->id?>">
                  <i class="icon md-delete"></i> Remove
                  </a>
              </div>
            </div>
          </div>
        </div>
        <!-- End Widget Info -->
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
      alertify.confirm('Do you continue to delete this group?', 
        function(){ 
          location.replace(link);
        },function(){ 
          
        });
    });

  });
</script>