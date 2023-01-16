<?php include("header.php") ?>
<div class="page-header">
  <h1 class="page-title">Devices Data</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device">Devices</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device">Interface Visualization</a></li>
    <li class="breadcrumb-item active">Maps Visualizaion</li>
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
          <?php if(!empty($group)){ ?>
          <li>
            <strong>Devices Group :</strong> <?= $group->name; ?></li>
          <?php } ?>
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
                            <div class="input-group" style="margin-top:20px;">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" class="icheckbox-primary" id="searchState" name="with_time"
                                      data-plugin="iCheck" data-checkbox-class="icheckbox_flat-blue" <?= ($with_time)?"checked":""; ?>/>  
                                    </span>
                                    <label style="margin-top: 10px;" for="lastData">Search By Date</label>
                                </div>
                                <div class="input-group">
                                  <span class="input-group-addon">
                                      <i class="icon md-time-countdown" aria-hidden="true"></i>
                                  </span>
                                  <input type="text" class="form-control search-time" data-autoclose="true" data-plugin="clockpicker" id="inputTimeStart" name="tstart"  value="<?= $time_str ?>" autocomplete="off" required>
                                </div>
                                <div class="input-group">
                                  <span class="input-group-addon">to</span>
                                  <input type="text" class="form-control search-time" data-autoclose="true" data-plugin="clockpicker" id="inputTimeEnd" name="tend" value="<?= $time_end ?>" autocomplete="off" required>
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
          <h2 class="panel-title" style="font-weight:bold;"><?= $interfaces->title; ?> Data</h2>
        </div>
        <div class="panel-body">
          <div class="col-md-12">
                <!-- Example Toolbar -->
                <div class="example-wrap">
                    <div class="example">
                      <div id="map" style="width: 100%;height: 80vh;"></div>    
                    </div>
                </div>
                <!-- End Example Toolbar -->
          </div>
        </div>
      </div>  
    </div>
  </div>
</div>
<div class="circle bg-yellow shadow ">AAAAAAAAAAAA</div>

<?php include("footer.php") ?>
<!-- <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script> -->
<script type="text/javascript" src="<?= base_url();?>assets/leaflet/dist/leaflet-src.js"></script>
<script src='<?= base_url();?>assets/leaflet/Leaflet.GoogleMutant.js'></script>
<!-- <script src='<?= base_url();?>assets/leaflet/heatmap.min.js'></script> -->
<!-- <script src='<?= base_url();?>assets/leaflet/leaflet-heatmap.js'></script> -->
<script src='<?= base_url();?>assets/leaflet/leaflet-heatmap-2014.js'></script>




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
  $( document ).ready(function() {
    // Maps 
    var maps = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/dark_all/{z}/{x}/{y}.png', { 
      // var maps = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
            attribution: '-',
            maxZoom: 18,
            minZoom: 10,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoiYWRlc3VsYWltYW4iLCJhIjoiY2prcWFqcW85MW00YzNsbW54ZThscmpvdSJ9.ai7YM6Pj5ayquazYjHnOCA'
          });

    // let cfg = {
    //   "radius": 20,
    //   "blur": 15,
    //   "useLocalExtrema": true,
    //   "valueField": 'category'
    // }

    // let heatmapLayer = new HeatmapOverlay(cfg)
    var map = L.map('map',  {
        editable: true,
        center: [<?= $interfaces->configuration->center->latitude ?>, <?= $interfaces->configuration->center->longitude ?>],
        zoom: <?= $interfaces->configuration->center->zoom ?>,
        scrollWheelZoom: false,
        zoomControl: true,
        layers: [maps] //, heatmapLayer
    });  
    var totalhal = 0;
      
    function update_maps(hal){
        url_jsaon = "<?= base_url();?>interfaces/resource/<?= $data->device_code?>";
        var hasilpasien=$.getJSON(url_jsaon, function (data) {
        var location = [];
        for (var i = 0; i < data.length; i++) {
            var lat = data[i].<?= $interfaces->configuration->marker->latitude ?>;
            var lng = data[i].<?= $interfaces->configuration->marker->longitude ?>;
            var category = data[i].<?= $interfaces->configuration->marker->category ?>;
            // location.push({lat:lat,lng:lng,category:category});
            location.push([lat,lng,category]);
        }
        // console.log(location);
        // heatmapLayer.setData({
        //     min: 1,
        //     max: 6, 
        //     data: location
        // });
        var heat = L.heatLayer(location,{
            radius: 20,
            blur: 15, 
            maxZoom: 17,
        }).addTo(map);
    });

        // if(totalhal>hal){
        //     setTimeout(function(){
        //         update_maps(hal+1);
        //     }, 1000);
        // }

      }
      update_maps(1);
  });
</script>