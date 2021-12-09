<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Schema Data</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>schema">Schema</a></li>
    <li class="breadcrumb-item active">Table Data</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-6">
      <div class="pricing-list text-left">
        <div class="pricing-header bg-blue-600">
          <div class="pricing-title">Device Info</div>
          <div class="pricing-price" style="padding-top:0px; padding-bottom: 0px;font-size: 2.858rem;">
            <span class="pricing-currency"><i class="icon wb-memory" aria-hidden="true"></i></span>
            <span class="pricing-amount"><?= $data->name; ?></span>            
          </div>
          <p class="px-30 font-size-16" ><strong>Device Code</strong>: <i><?= $data->schema_code; ?></i></p>
        </div>
        <ul class="pricing-features font-size-16" style="background-color: #fff;" >
          <li>
            <strong>Purpose :</strong> <?= $data->information->purpose; ?></li>
          <li>
            <strong>Detail Infomation :</strong> <?= $data->information->detail; ?></li>
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel-bordered panel-success">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="icon wb-time" aria-hidden="true"></i> &nbsp;Search Data</h3>
        </div>
        <div class="panel-body bg-white">
            <!-- Example Date Range -->
            <div class="example-wrap">
                <h4 class="example-title">Date Range Data</h4>                
                <div class="example">
                    <form method="GET">
                        <div class="form-group form-material row">
                            <div class="input-daterange" data-plugin="datepicker">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="icon md-calendar" aria-hidden="true"></i>
                                </span>
                                <input type="text" class="form-control" name="start" value="<?= $date_str?>" data-date-format="yyyy-mm-dd"/>
                                </div>
                                <div class="input-group">
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control" name="end" value="<?= $date_end?>" data-date-format="yyyy-mm-dd"/>
                                </div>
                            </div>
                        </div>    
                        <div class="form-group form-material row">
                            <span class="input-group-addon" style="background:none; border:none;"> </span>
                            <button type="submit" class="btn btn-primary waves-effect waves-classic">Search </button>
                        </div>    
                    </form>
                </div>

            </div>
            <!-- End Example Date Range -->
        </div>
      </div>
    </div>
  </div>
  <div class="row row-lg mt-20">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Sensor Data</h3>
          <div class="panel-actions" style="text-align: right;">    
              <a href="<?= base_url() ?>schema/data/<?=  $data->schema_code; ?>/add/"><button type="button" class="btn btn-sm btn-icon btn-primary btn-round waves-effect waves-classic waves-effect waves-classic">
                <i class="icon md-plus" aria-hidden="true"></i> &nbsp; Add New Data&nbsp;&nbsp; 
              </button></a>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-md-12">
              <!-- Example Toolbar -->
            <div class="example-wrap">
              <div class="example">
                  <!-- <div class="btn-group hidden-sm-down" id="exampleToolbar" role="group">
                  <button type="button" class="btn btn-info btn-icon">
                      <i class="icon md-plus" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btn btn-info btn-icon">
                      <i class="icon md-favorite" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btn btn-info btn-icon">
                      <i class="icon md-delete" aria-hidden="true"></i>
                  </button>
                  </div> -->
                  <table id="sensordata" data-mobile-responsive="true">
                  <thead>
                      <tr>
                        <th data-field="date" style="white-space:nowrap;">DATE ADD</th>
                        <?php foreach($extract as $d){ ?>
                        <th data-field="<?= $d ?>"><?= strtoupper( str_replace("_", " ", str_replace("-"," - ",$d)) ); ?></th>
                        <?php } ?>
                        <th data-field="action-form" style="white-space:nowrap;">ACTION</th>
                      </tr>
                  </thead>
                  </table>
              </div>
              </div>
              <!-- End Example Toolbar -->
          </div>
        </div>
      </div>  
    </div>
  </div>
</div>

<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/global/vendor/moment/moment.js"></script>
<script src="<?= base_url()?>assets/js/mqttws31.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/bootstrap-table.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js"></script>
<!-- <script src="<?= base_url()?>assets/examples/js/tables/bootstrap.js"></script> -->
<script>
  function del(link){
    alertify.confirm('Do you continue to delete this schema?', 
      function(){ 
        location.replace(link);
      },function(){ 
    });
  }
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
    $('#sensordata').bootstrapTable({
        url: "<?= base_url() ?>schema/datatable/<?=  $data->schema_code; ?>?start=<?= $date_str?>&end=<?= $date_end?>",
        pagination: true,
        sidePagination: 'server',
        pageSize: '25',
        pageList: '[10,25, 50, 100]',
        // search: true,
        showRefresh: true,
        showToggle: true,
        showColumns: true,
        toolbar: '#exampleToolbar',
        iconsPrefix: 'icon',
        iconSize: 'icon',
        icons: {
          refresh: 'md-refresh',
          toggle: 'md-receipt',
          columns: 'md-view-list-alt'
        }
    });
  });
</script>