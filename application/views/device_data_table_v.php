<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Devices Groups Data</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device">Devices</a></li>
    <li class="breadcrumb-item active">Data</li>
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
          <p class="px-30 font-size-16" ><strong>Device Code</strong>: <i><?= $data->device_code; ?></i></p>
        </div>
        <ul class="pricing-features font-size-16" style="background-color: #fff;" >
          <li>
            <strong>Location :</strong> <?= $data->information->location; ?></li>
          <li>
            <strong>Purpose :</strong> <?= $data->information->purpose; ?></li>
          <li>
            <strong>Devices Group :</strong> <?= $group->name; ?></li>
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
                    <form>
                        <div class="form-group form-material row">
                            <div class="input-daterange" data-plugin="datepicker">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="icon md-calendar" aria-hidden="true"></i>
                                </span>
                                <input type="text" class="form-control" name="start" data-date-format="yyyy-mm-dd"/>
                                </div>
                                <div class="input-group">
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control" name="end" data-date-format="yyyy-mm-dd"/>
                                </div>
                            </div>
                        </div>    
                        <div class="form-group form-material row">
                            <button type="button" class="btn btn-primary waves-effect waves-classic">Search </button>
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
    

  </div>
</div>

<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/global/vendor/moment/moment.js"></script>
<script src="<?= base_url()?>assets/js/mqttws31.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/bootstrap-datepicker.js"></script>
