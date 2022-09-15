<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Edge Configuration</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device">Devices</a></li>
    <li class="breadcrumb-item active">Edge Configuration</li>
  </ol>
  <div class="page-header-actions">    
    <a href="<?= base_url()?>device/edge/<?= (empty($data->device_code))?'':$data->device_code; ?>/add"><button type="button" class="btn btn-sm btn-icon btn-primary btn-round waves-effect waves-classic">
      <i class="icon md-plus" aria-hidden="true"></i> &nbsp; Add New Edge Configuration&nbsp;&nbsp; 
    </button></a>
  </div>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-12">
      <div class="panel">
        <header class="panel-heading">
          <div class="panel-actions"></div>
          <h3 class="panel-title">List of Edge Configuration for Devices:[<?= (empty($data->device_code))?'':$data->device_code; ?>] <?= $data->name?></h3>
        </header>
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
            <thead>
              <tr>
                <th>Date Add</th>   
                <th>Edge Configuration Code</th>
                <th>Method</th>
                <th>Example Message</th>                
                <!-- <th>String Pattern</th>                 -->
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Date Add</th>   
                <th>Edge Configuration Code</th>
                <th>Method</th>
                <th>Example Message</th>                
                <!-- <th>String Pattern</th>    -->
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              <?php               
              if(!empty($config_list))
              foreach($config_list as $d){ ?>
              <tr>
                <td><?= date( "Y-m-d H:i:s", $d->date_add->{'$date'}/1000); ?></td>
                <td><?= $d->edgeconfig_code?></td>
                <td><?= ($d->method == "array_list")?"Covert to Array List":"Covert to JSON Object" ?></td>
                <td><?= $d->string_sample?></td>
                <!-- <td><?= $d->string_pattern?></td> -->
                <!-- <td>
                    <?php if($d->active){ ?>
                    <span class="badge badge-pill badge-success font-size-12">Active</span> 
                    <?php } else { ?>
                    <span class="badge badge-pill badge-danger font-size-12">Not Active</span> 
                    <?php } ?>
                </td> -->
                <td class="actions">
                  <a target="_blank" href="<?= base_url()?>device/edge/<?= $id; ?>/download/<?= $d->edgeconfig_code; ?>" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                    data-toggle="tooltip" data-original-title="Download Configuration"><i class="icon md-download" aria-hidden="true"></i></a>
                  <a href="<?= base_url()?>device/edge/<?= $id; ?>/edit/<?= $d->edgeconfig_code; ?>" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                    data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                  <a href="<?= base_url()?>device/edge/<?= $id; ?>/delete/<?= $d->edgeconfig_code; ?>" class="btn btn-sm btn-icon btn-pure btn-default btn-leave on-default remove-row"
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
      alertify.confirm('Do you continue to delete this edge configuration?', 
        function(){ 
          location.replace(link);
        },function(){ 
          
        });
    });

  });
</script>