<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Schema Data</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>schema">Schema</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>schema/data/<?= $id ?>">Data</a></li>
    <li class="breadcrumb-item active">Import</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-6">
      <div class="pricing-list text-left">
        <div class="pricing-header bg-blue-600">
          <div class="pricing-title">Schema Info</div>
          <div class="pricing-price" style="padding-top:0px; padding-bottom: 0px;font-size: 2.858rem;">
            <span class="pricing-currency"><i class="icon md-collection-text" aria-hidden="true"></i></span>
            <span class="pricing-amount"><?= $data->name; ?></span>            
          </div>
          <p class="px-30 font-size-16" ><strong>Schema Code</strong>: <i><?= $data->schema_code; ?></i></p>
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
            <h3 class="panel-title"><i class="icon wb-upload" aria-hidden="true"></i> &nbsp;Data Import</h3>
            <div class="panel-actions" style="text-align: right;">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle waves-effect waves-classic" id="BulletDropdown2" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon wb-download" aria-hidden="true"></i> Download Template
                    </button>
                    <div class="dropdown-menu bullet dropdown-menu-right" aria-labelledby="BulletDropdown2" role="menu">
                        <a class="dropdown-item" target="_blank" href="<?= base_url() ?>schema/template/csv/<?=  $data->schema_code; ?>" role="menuitem">CSV</a>
                        <a class="dropdown-item" target="_blank" href="<?= base_url() ?>schema/template/excel/<?=  $data->schema_code; ?>" role="menuitem">Excel</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body bg-white">
            <!-- Example Date Range -->
            <div class="example-wrap">
                <h4 class="example-title">Date Range Data</h4>                
                <div class="example">
                    <form method="GET" class="form-horizontal">
                        <div class="form-group form-material row">
                            <div class="input-daterange" data-plugin="datepicker">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="icon md-calendar" aria-hidden="true"></i>
                                </span>
                                <input type="text" class="form-control" name="start"  data-date-format="yyyy-mm-dd"/>
                                </div>
                                <div class="input-group">
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control" name="end"  data-date-format="yyyy-mm-dd"/>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group row form-material row">
                            <button type="submit" class="btn btn-primary waves-effect waves-classic">Import </button>
                        </div>   
                    </form>
                </div>

            </div>
            <!-- End Example Date Range -->
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("footer.php") ?>
<!-- <script src="<?= base_url()?>assets/examples/js/tables/bootstrap.js"></script> -->
<script>
  $( document ).ready(function() {
    
  });
</script>