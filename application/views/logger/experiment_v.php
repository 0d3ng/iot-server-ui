<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Experiment</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <!-- <li class="breadcrumb-item"><a href="<?= base_url();?>logger/experiment">Experiment</a></li> -->
    <li class="breadcrumb-item active">Experiment</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>

<div class="page-content">
  <form method="GET">
  <div class="row row-lg">
  
    <div class="col-md-6">
      <div class="panel-bordered panel-warning">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="icon wb-time" aria-hidden="true"></i> &nbsp;Search Data</h3>
          <div class="panel-actions panel-actions-keep">
            <input type="checkbox" name="search" data-plugin="switchery" data-size="small" <?= ($search == TRUE)?'checked':'' ?> />
          </div>
        </div>
        <div class="panel-body bg-white">
            <!-- Example Date Range -->
            <div class="example-wrap">
                <h4 class="example-title">Date Range Data</h4>                
                <div class="example">
                    
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
                    
                </div>

            </div>
            <!-- End Example Date Range -->
        </div>
      </div>
    </div>
    
  </div>
  </form>
  <div class="row row-lg mt-20">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Experiment Data</h3>
          <div class="panel-actions" style="text-align: right;">    
              <a href="<?= base_url() ?>logger/experiment/add/"><button type="button" class="btn btn-sm btn-icon btn-primary btn-round waves-effect waves-classic waves-effect waves-classic">
                <i class="icon md-plus" aria-hidden="true"></i> &nbsp; Add New Experiment Data&nbsp;&nbsp; 
              </button></a>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-md-12">
              <!-- Example Toolbar -->
            <div class="example-wrap">
              <div class="example">
                  <table id="sensordata" data-mobile-responsive="true" data-show-export="true" data-sort-name="date" data-sort-order="desc">
                  <thead>
                      <tr>
                        <th data-field="date" data-sortable="true" style="white-space:nowrap;">DATE ADD</th>
                        <th data-field="time" data-visible="false">TIME ADD</th>
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
<!--   -->

<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/tableExport.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/jspdf.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/moment/moment.js"></script>
<script src="<?= base_url()?>assets/js/mqttws31.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/bootstrap-table.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-table/extensions/export/bootstrap-table-export.js"></script>
<script src="<?= base_url()?>assets/global/vendor/clockpicker/bootstrap-clockpicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/clockpicker.js"></script>
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
    $('input').on('ifChecked', function(event){
      $(".search-time").removeAttr('disabled');
    });
    $('input').on('ifUnchecked', function(event){
      $(".search-time").attr('disabled','disabled');
    });

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
        url: "<?= base_url() ?>logger/experiment/datatable/?<?= ($search)?"&start=".$date_str."&end=".$date_end:""; ?>",
        pagination: true,
        sidePagination: 'server',
        pageSize: '25',
        pageList: '[10,25, 50, 100]',
        // search: true,
        sortable: true,
        showRefresh: true,
        showToggle: true,
        showColumns: true,
        toolbar: '#exampleToolbar',
        iconsPrefix: 'icon',
        iconSize: 'icon',
        icons: {
          refresh: 'md-refresh',
          toggle: 'md-receipt',
          columns: 'md-view-list-alt',
          export: 'md-download'
        },
        exportDataType: "all",
        exportTypes: ['json','csv', 'txt','excel'],
        exportOptions: {
            ignoreColumn: ["action-form"],
            fileName: 'Experiment Data - <?= ($search)?$date_str." to ".$date_end:""; ?>',
            preventInjection: false
        },
        exportHiddenColumns:["time"]
    });
  });
</script>