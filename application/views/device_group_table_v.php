<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Devices Group</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item active">Devices Group</li>
  </ol>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-12">
      <div class="panel">
        <header class="panel-heading">
          <div class="panel-actions"></div>
          <h3 class="panel-title">List of Devices Group</h3>
        </header>
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
            <thead>
              <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Purpose</th>
                <th>Date Add</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Purpose</th>
                <th>Date Add</th>
              </tr>
            </tfoot>
            <tbody>
              <?php if(!empty($data))
                    foreach($data as $d){ ?>
              <tr>
                <td><?= $d->name?></td>
                <td><?= $d->group_code?></td>
                <td><?= $d->information->purpose; ?></td>
                <td><?= date( "Y-m-d H:i:s", $d->date_add->{'$date'}/1000); ?></td>
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