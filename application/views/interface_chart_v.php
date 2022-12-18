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
                      <div id="chart" style="width: 100%;height: 80vh;"></div>    
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
<script src="<?= base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/highstock.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/exporting.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/export-data.js"></script>
<script src="<?= base_url()?>assets/js/mqttws31.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/icheck/icheck.min.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/icheck.js"></script>
<script src="<?= base_url()?>assets/global/vendor/clockpicker/bootstrap-clockpicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/clockpicker.js"></script>

<?php 

    $chart = array();
    $x_axis = $interfaces->configuration->x_axis;
    $y_axis = $interfaces->configuration->y_axis;
    foreach($y_axis as $d){
        $field = $d->field;
        $chart[$field] = array();    
    }
    if($sensor){
        foreach($sensor as $d){
            $itemdata = (array)$d;
            if($x_axis->field == "date_add_server"){
                $item_x = $itemdata['date_add_server']->{'$date'};
            }else{
                if(!isset($itemdata[$x_axis->field]))
                    continue;
                    $item_x = $itemdata[$x_axis->field];
            }
            foreach($y_axis as $d){
                $field = $d->field;
                if(!isset($itemdata[$field])){
                    continue;
                } else if(is_string($itemdata[$field])){
                    continue;
                } else if(!is_numeric($itemdata[$field])){
                    $item_y = 0;
                } else {
                    $item_y = $itemdata[$field];
                }
                $chart[$field][] = [$item_x,$item_y];
            }
        }
    }
?>

<script>
    <?php
        foreach($y_axis as $d){
            $field = $d->field;
            echo "var mychart_".$field.";"; 
        } 
    ?>
    $( document ).ready(function() {

        $('input').on('ifChecked', function(event){
            $(".search-time").removeAttr('disabled');
        });
        $('input').on('ifUnchecked', function(event){
            $(".search-time").attr('disabled','disabled');
        });

        Highcharts.stockChart('chart', {
            chart: {
                events: {
                    load: function() {
                        <?php
                            $i=0;
                            foreach($y_axis as $d){
                                $field = $d->field;
                                echo "var series$i = this.series[$i];";
                                echo "var mychart_$field = series$i;"; 
                                $i++;
                            } 
                        ?>
                    }
                }
            },
            time: {
                useUTC: false
            },
            legend: {
                enabled: true,         
                floating: true,
                // title: {
                //     text: 'Sensor Data',
                //     style: {
                //         fontStyle: 'italic',
                //         fontSize: '15px'
                //     }
                // },
                layout: 'horizontal',
                align: 'right',
                verticalAlign: 'top',
                x: -20,
                y: -10,
                itemStyle: {
                    fontSize: '16px'
                }
            },
            plotOptions: {
                series: {
                    lineWidth: 5,
                    states: {
                        hover: {
                            enabled: true,
                            lineWidth: 5
                        }
                    }
                }
            },


            <?php if($x_axis->field == "date_add_server"){ ?>
            rangeSelector: {
                buttons: [{
                        count: 10,
                        type: 'minute',
                        text: '5M'
                    }, {
                        count: 1,
                        type: 'hours',
                        text: '1H'
                    }, {
                        count: 1,
                        type: 'days',
                        text: '1D'
                    },
                    {
                        type: 'all',
                        text: 'All'
                    }
                ],
                inputEnabled: false,
                selected: 0
            },
            <?php } ?>

            title: {
                text: "<?= $interfaces->title; ?>"
            },
            exporting: {
                enabled: false
            },
            
            // yAxis: [{
            //     lineWidth: 1,
            //     opposite: false,
            //     title: field
            // }],

            
            // xAxis: [{
            //     title: "<?=  $x_axis->title?>"
            // }],
            xAxis: {
                title: {
                    text: '<?=  $x_axis->title?>',
                    style: {
                        fontWeight: 'bold',
                        fontSize:'16px'
                    }
                }
            },
            series: [
                <?php 
                    $i = 0;
                    $max = count($y_axis);     
                    foreach($y_axis as $d){
                        $field = $d->field; 
                        $title = $d->title; 
                        $i++;
                ?>
                {
                    name: '<?= $title?>',
                    data: <?php echo json_encode($chart[$field]); ?>,
                    turboThreshold:200000
                }
                <?php 
                    if($i<$max)
                        echo ",";
                } ?>
            ]
        });  
    });
</script>