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

<?php include("footer.php") ?>
<script type="text/javascript" src="<?= base_url();?>assets/leaflet/dist/leaflet-src.js"></script>
<script src='<?= base_url();?>assets/leaflet/Leaflet.GoogleMutant.js'></script>

<script type="text/javascript" src="<?= base_url();?>assets/leaflet/turf.min.js"></script>


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
        
        

        function category_color(cat) {
            if(cat == "1") return "red";
            if(cat == "2") return "blue";
            if(cat == "3") return "yellow"; 
            if(cat == "4") return "green"; 
        }

        function category_style(feature) {
            return {
                fillColor: category_color(feature.properties.<?= $interfaces->configuration->marker->category ?>),
                weight: 1,
                opacity: 1,
                color: "white",
                fillOpacity: 0.5
            };
        }

        function update_maps(year, month){
            $.ajax({
                type: 'get',
                url: '<?= base_url();?>interfaces/resource/<?= $data->device_code?>',
                data: {'year':year,"month":month},
                success: function (result){
                    data = {
                        "type": "FeatureCollection",
                        "features":[]
                    };

                    for (var i = 0; i < result.length; i++) {
                        feature = {
                            "type": "Feature",
                            "geometry": {
                                "type": "Point",
                                "coordinates": [result[i].<?= $interfaces->configuration->marker->longitude ?>,result[i].<?= $interfaces->configuration->marker->latitude ?>]
                            },
                            "properties": result[i]
                        };  
                        data.features.push(feature);   
                    }    
                    
                    turf.clusterEach(data, "<?= $interfaces->configuration->marker->category ?>", function(cluster, clusterValue, currentIndex) {
                        clustered = turf.clustersDbscan(cluster, 1);
                        console.log(clusterValue);
                        console.log(currentIndex);
                        console.log(clustered);
                        
                        turf.clusterEach(clustered, "cluster", function(cluster2, clusterValue2, currentIndex2) {
                            // console.log(cluster2);
                            let ch = turf.convex(cluster2);
                            ch.properties.<?= $interfaces->configuration->marker->category ?> = clusterValue;
                            L.geoJSON(ch, {style: category_style}).addTo(map);
                        });
                        L.geoJSON(cluster, {
                            onEachFeature: function(feature, layer) {
                                var popups = "<h4>Information Detail</h4>"
                                    <?php foreach($interfaces->configuration->popup as $value){ ?>
                                    +"<span> <?= str_replace("_"," ",strtoupper($value)) ?> : <b>"+feature.properties.<?= $value?>+"</b></span><br>"
                                    <?php } ?>                    
                
                                layer.bindPopup(popups);
                            },
                            pointToLayer: function(geoJsonPoint, latlng) {
                                return L.circleMarker(latlng);
                            },
                            style: category_style
                        }).addTo(map);
                    });

                }
            });
        }
        let map = L.map("map").setView([<?= $interfaces->configuration->center->latitude ?>, <?= $interfaces->configuration->center->longitude ?>], <?= $interfaces->configuration->center->zoom ?>);
        // var maps = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/dark_all/{z}/{x}/{y}.png', { 
        //     attribution: '-',
        //     maxZoom: 18,
        //     minZoom: 10,
        //     id: 'mapbox.streets',
        //     accessToken: 'pk.eyJ1IjoiYWRlc3VsYWltYW4iLCJhIjoiY2prcWFqcW85MW00YzNsbW54ZThscmpvdSJ9.ai7YM6Pj5ayquazYjHnOCA'
        // }).addTo(map);

        // var map = L.map('map',  {
        //     editable: true,
        //     center: [<?= $interfaces->configuration->center->latitude ?>, <?= $interfaces->configuration->center->longitude ?>],
        //     zoom: <?= $interfaces->configuration->center->zoom ?>,
        //     scrollWheelZoom: false,
        //     zoomControl: true,
        //     layers: [maps] //, heatmapLayer
        // });  
        L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", 
            {attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'}
        ).addTo(map);

        var totalhal = 0;
        update_maps(<?= date("Y,m")?>);
    });
</script>