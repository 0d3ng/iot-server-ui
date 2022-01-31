<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Devices Process</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device">Devices</a></li>
    <li class="breadcrumb-item active">Process</li>
  </ol>
  <div class="page-header-actions">
    <a href="<?= base_url()?>device/process/<?= (empty($data->device_code))?'':$data->device_code; ?>/batch"><button type="button" class="btn btn-sm btn-icon btn-success btn-round waves-effect waves-classic">
      <i class="icon md-storage" aria-hidden="true"></i> &nbsp; Batch Process&nbsp;&nbsp; 
    </button></a>
    <a href="<?= base_url()?>device/process/<?= (empty($data->device_code))?'':$data->device_code; ?>/add"><button type="button" class="btn btn-sm btn-icon btn-primary btn-round waves-effect waves-classic">
      <i class="icon md-plus" aria-hidden="true"></i> &nbsp; Add New Process&nbsp;&nbsp; 
    </button></a>
  </div>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-12">
      <div class="panel">
        <header class="panel-heading">
          <div class="panel-actions"></div>
          <h3 class="panel-title">List of Process for Devices:[<?= (empty($data->device_code))?'':$data->device_code; ?>] <?= $data->name?></h3>
        </header>
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
            <thead>
              <tr>
                <th>Field</th>
                <th>Declaration</th>
                <th>Code for Process(Python Based)</th>
                <th>Variable</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Field</th>
                <th>Declaration</th>
                <th>Code for Process(Python Based)</th>
                <th>Variable</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              <?php 
              if(!empty($data->field_process))
                foreach($data->field_process as $key => $val){ ?>
              <tr>
                <td><?= $key?></td>
                <td><?= $val->pre?></td>
                <td><?= $val->process?></td>
                <td><?= implode($val->var,", ") ?></td>
                <td class="actions">
                  <a href="<?= base_url()?>device/process/<?= $data->device_code ?>/edit/<?= $key; ?>" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                    data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                  <a href="<?= base_url()?>device/process/<?= $data->device_code ?>/delete/<?= $key; ?>" class="btn btn-sm btn-icon btn-pure btn-default btn-leave on-default remove-row"
                    data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
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
      alertify.confirm('Do you continue to delete this device?', 
        function(){ 
          location.replace(link);
        },function(){ 
          
        });
    });

  });
</script>