<?php include("header.php") ?>
<?php  
	
	$fuel_name_today = array();
	$fuel_income_today = array();
	$fuel_item_today = array();
	
	foreach ($fuel_today as $value) {
		$fuel_name_today[] = $value->fuel_type;
		$fuel_income_today[] = $value->total_income;
		$fuel_item_today[] = $value->total_fuel;
	}
	$fuel_trans = $fuel_item_today;

	///////////////////////////////////
	$total_capacity = 0; 
	foreach( $car as $value){
		$total_capacity += $value->car->capacity;
	}

	$total_trans = 0; $total_item_trans = 0; $total_fuel_trans=0;
	foreach ($trans_today as $value) {
		$total_trans+=$value->pay;
		$total_fuel_trans+=$value->total_fuel;
		$total_item_trans++;
	}
	
	///////////////////////////////

	$hour_field = array();
	$hour_item = array();
	$hour_item_fuel = array();
	$hour_item_count = array();
	$hours_now = date('H');
	$hour_field[] = '00:01';
	if($hours_income){
		$hour_item[] = ($hours_income->{'00_01'})?$hours_income->{'00_01'}:'0';
		$hour_item_fuel[] = ($hours_income->{'00_01_count'})?$hours_income->{'00_01_count'}:'0';
		$hour_item_count[] = ($hours_income->{'00_01_fuel'})?$hours_income->{'00_01_fuel'}:'0';
	}else{
		$hour_item[] = '0';
		$hour_item_fuel[] = '0';
		$hour_item_count[] = '0';
	}

	for($i=1; $i<=$hours_now; $i++){
		$field = sprintf("%02d", (int)$i);
		$hour_field[] = $field.':00';
		if($hours_income){
			$hour_item[] = ($hours_income->{$field.'_00'})?$hours_income->{$field.'_00'}:'0';
			$hour_item_fuel[] = ($hours_income->{$field.'_00_count'})?$hours_income->{$field.'_00_count'}:'0';
			$hour_item_count[] = ($hours_income->{$field.'_00_fuel'})?$hours_income->{$field.'_00_fuel'}:'0';
		} else {
			$hour_item[] = '0';
			$hour_item_fuel[] = '0';
			$hour_item_count[] = '0';
		}
	}
	////////HAPUS DIBAWAH INI/////////////
	// $total_car = 5;//count($car);
	// $allcar = 20;
	// $total_trans = 1500090; 
	// $total_item_trans = 10;
	// $total_fuel_trans=100;
	// $new_customer = 20;

?>
				<div class="page-inner">
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-3">
							<div class="card card-stats card-round">
								<div class="card-body ">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-primary bubble-shadow-small">
												<i class="flaticon-delivery-truck"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Active Vehicle</p>
												<h4 class="card-title"> <?= number_format($total_car,0,',','.') ?> <small>Car from</small> <?= number_format($allcar,0,',','.'); ?> <br/><?= number_format($total_capacity,0,',','.'); ?> L </h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-sm-12 col-md-6 col-lg-3">
							<div class="card card-stats card-round">
								<div class="card-body ">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-success bubble-shadow-small">
												<i class="flaticon-coins"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Total Transaction</p>
												<h4 class="card-title"> <?= number_format($total_item_trans,0,',','.') ?> |  <?= number_format($total_fuel_trans,0,',','.') ?> L <br/><small>Rp</small> <?= number_format($total_trans,0,',','.') ?></h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-3">
							<div class="card card-stats card-round">
								<div class="card-body ">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-warning bubble-shadow-small">
												<i class="flaticon-cart-1"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Fuel in the Tank</p>
												<h4 class="card-title">
												<?= number_format($total_capacity - $total_fuel_trans,0,',','.'); ?> L

												<?php 
												// foreach ($fuel_trans as $value) {
												// 	echo number_format($value,2,',','.'); 
												// 	echo ' L | ';
												// }
												?></h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-3">
							<div class="card card-stats card-round">
								<div class="card-body ">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-info bubble-shadow-small">
												<i class="flaticon-users"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">New Customer</p>
												<h4 class="card-title"><?= number_format($new_customer,0,',','.') ?></h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title">Live Maps - Car</div>
										<div class="card-tools">
										</div>
									</div>
								</div>
								<div class="card-body">
									<div id='map' style="min-height:400px;width:100%;"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title"><i class="fas fa-chart-line"></i> Transaction Chart</div>
								</div>
								<div class="card-body">
									<div class="chart-container">
										<canvas id="transChartToday"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title"><i class="fas fa-shopping-cart"></i> Last Transaction Today</h4>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table " >
											<thead>
												<tr>
													<th>Time</th>
													<th>Transaction Code</th>
													<th>Customer</th>
													<th>Driver</th>
													<th>Car</th>
													<th>Total</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Time</th>
													<th>Transaction Code</th>
													<th>Customer</th>
													<th>Driver</th>
													<th>Car</th>
													<th>Total</th>
												</tr>
											</tfoot>
											<tbody>
												<?php foreach ($trans_today as $d) { $id=number_format($d->transaction_id,0,'',''); ?>
												<tr>
													<td><?= date("H:i:s", strtotime($d->date_add)) ?></td>
													<td><?= $d->transaction_code ?></td>
													<td><?= $d->customer->name ?></td>
													<td><?= $d->driver->name ?></td>
													<td><?= $d->car->vehicle_number ?></td>
													<td><?= number_format($d->pay,0,',','.'); ?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div> 
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-head-row"> 
										<h4 class="card-title"><i class="fas fa-user-circle"></i> Driver & Vehicle Active</h4>
										<!-- <div class="card-tools">
											<a href="<?= base_url()?>schedule"><button class="btn btn-icon btn-link btn-primary btn-xs"><span class="fa fa-search"></span> Show All</button></a>
										</div> -->
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive ">
										<table id="add-row" class="display table table-head-bg-primary " >
											<thead>
												<tr>
													<th>Name</th>
													<th>Phone</th>
													<th>Car</th>
													<th>Tank</th>
													<th>Owner</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($car as $d) { $id=number_format($d->car_driver_id,0,'',''); ?>
												<tr>
													<td><?= $d->driver->name ?></td>
													<td><?= $d->driver->phone ?></td>
													<td><?= $d->car->vehicle_number ?></td>
													<td><?= number_format($d->car->tank,0,',','.'); ?></td>
													<td><?= $d->car->owner ?></td>
													<td>
														<?php if($d->status == 0){ ?>
														<span class="text-warning pl-3">Leave</span>
	                                                    <?php } else if($d->status == 1){ ?>
	                                                    <span class="text-success pl-3">On Trip</span>
	                                                    <?php }  ?>
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
				</div>
<?php include("footer.php") ?>			
<script type="text/javascript" src="https://pubnub.github.io/eon/v/eon/1.1.0/eon.js"></script>
<script src="<?= base_url()?>assets/js/mqttws31.js" type="text/javascript"></script>	
<script type="text/javascript">
        console.log(PubNub);
        console.log(L.mapbox);
        console.log(eon);
        var dev_id = 'all';
        var devices = { list:[], location:[], data:[] };
        var map;
        var userIcon = L.icon({
		    iconUrl: '<?= base_url()?>assets/img/icons/user.png',
		    iconSize: [50, 50]
		});
		var driverIcon = L.icon({
		    iconUrl: '<?= base_url()?>assets/img/icons/driver.png',
		    iconSize: [50, 50]
		});
        L.RotatedMarker = L.Marker.extend({
		    options: { angle: 90 },
		    _setPos: function(pos) {
		        L.Marker.prototype._setPos.call(this, pos);
		        if (L.DomUtil.TRANSFORM) {
		            // use the CSS transform rule if available
		            this._icon.style[L.DomUtil.TRANSFORM] += ' rotate(' + (this.options.angle) + 'deg)';
		            if (this.options.angle >= 0 && this.options.angle <= 180) this._icon.style[L.DomUtil.TRANSFORM] += ' scaleX(-1) ';
		        } else if (L.Browser.ie) {
		            // fallback for IE6, IE7, IE8
		            var rad = this.options.angle * L.LatLng.DEG_TO_RAD,
		                costheta = Math.cos(rad),
		                sintheta = Math.sin(rad);
		            this._icon.style.filter += ' progid:DXImageTransform.Microsoft.Matrix(sizingMethod=\'auto expand\', M11=' +
		                costheta + ', M12=' + (-sintheta) + ', M21=' + sintheta + ', M22=' + costheta + ')';
		        }
		    }
		});

        function getNonZeroRandomNumber(){
            var random = Math.floor(Math.random()*199) - 99;
            if(random==0) return getNonZeroRandomNumber();
            return random;
        }

        var pubnub = new PubNub({
            publishKey: 'pub-c-f91d6dd2-2d49-4bea-b00d-8db6741441dd',
            subscribeKey: 'sub-c-01099264-8f83-11ea-8e98-72774568d584'
        });
        <?php 
        	$listid = array();
        	$listdata = array();
        	foreach ($car as $d) { 
        		$id=number_format($d->car->device_id,0,'','');
        		$driver = 'None';
        		$status = 'On Trip';
        		if($d->status == 0){
        			$status = 'Leave';
        		}
        		$listid[] = 'pubnub-mapbox-on-active-'.$id;
        		$listdata['pubnub-mapbox-on-active-'.$id] = array(
        			'device_id' => $id,
        			'vehicle_number' => $d->car->vehicle_number,
        			'driver' => $d->driver->name,
        			'status' => $status,
        			'latlng' => [ $d->car->postion_lat , $d->car->postion_lng]
        		); 

        		// For All Car Access //
        		// $cardriver = $cardriver_m->search(array('car_id'=>$id,'status'=>1,'detail'=>true))->data;
        		// $driver = 'None';
        		// $status = 'not-active';
        		// if($cardriver){
        		// 	$driver = $cardriver[0]->driver->name;
        		// 	$status = 'Active';
        		// }
        		// $listid[] = 'pubnub-mapbox-device-'.$id;
        		// $listdata['pubnub-mapbox-device-'.$id] = array(
        		// 	'vehicle_number' => $d->vehicle_number,
        		// 	'driver' => $driver,
        		// 	'status' => $status
        		// );
        	}
        ?>
        var channels = ['<?= implode("','", $listid)?>'];
        var channels_group = "devices-car-on-active";
        var car_data = JSON.parse('<?php echo JSON_encode($listdata);?>'); 
        // create channel group
        pubnub.channelGroups.addChannels(
            {
                channels: channels,
                channelGroup: channels_group
            },
            function(status) {
                if (status.error) {
                console.log("operation failed w/ status: ", status);
                } else {
                    console.log("operation done!")

                    // list channels
                    pubnub.channelGroups.listChannels(
                        {
                            channelGroup: channels_group
                        },
                        function (status, response) {
                            if (status.error) {
                                console.log("operation failed w/ error:", status);
                                return;
                            }

                            console.log("listing push channel for device")
                            response.channels.forEach( function (channel) {
                                console.log(channel)
                            })
                        }
                    );

                }
            }
        );

        
        
        //////MQTT SETTING/////
        var mqtt;
	    var reconnectTimeout = 2000, host = '161.117.58.227', port = 1884,topic = 'eb/embedded/data/sensor';

	    function MQTTconnect() {
	        mqtt = new Paho.MQTT.Client(
	            host,
	            port,
	            "web_" + parseInt(Math.random() * 100, 10)
	        );
	        var options = {
	            timeout: 3,
	            userName: "T0dSaE5USTVNekUxWWpZMFpXUmxOMkV3TmpJMk16ZzE=",
	            password: "aGRNRldER1RuZmJoZm94b1c3WVhVOEl3eUFoRmJE",    
	            onSuccess: onConnect,
	            onFailure: function (message) {
	                console.log("Connection failed: " + message.errorMessage + "Retrying");
	                setTimeout(MQTTconnect, reconnectTimeout);
	            }
	        };

	        mqtt.onConnectionLost = onConnectionLost;
	        mqtt.onMessageArrived = onMessageArrived;        
	        console.log("Host="+ host + ", port=" + port);
	        console.log(mqtt);
	        //username_pw_set(username="OGRhNTI5MzE1YjY0ZWRlN2EwNjI2Mzg1",password="hdMFWDGTnfbhfoxoW7YXU8IwyAhFbD");
	        mqtt.connect(options);
	    }

        function onConnect() {
            mqtt.subscribe(topic, {qos: 0});
            console.log("subscribe topic: "+topic);
        }

        function onConnectionLost(response) {
            setTimeout(MQTTconnect, reconnectTimeout);
            console.log("connection lost: " + response.errorMessage + ". Reconnecting");
        };

        function onMessageArrived(message) {
        	console.log(message);
            var topic = message.destinationName;
            var payload = message.payloadString;
            var message = JSON.parse(payload);
            var latlng = [message.gps.lat,message.gps.long];
            var id = parseInt(message.device_id);
            var new_point = {
                latlng : latlng
            };
            var i = channels.indexOf("pubnub-mapbox-on-active-"+id);
            if(i>-1){
	            pubnub.publish({
	                channel: channels[i],
	                message: [{dev_id:'device'+id,gps:latlng,data:{id:"pubnub-mapbox-on-active-"+id} }]
	            });
        	}
        };

        $(document).ready(function() {
            map = eon.map({
                pubnub: pubnub,
                id: 'map',
                mbToken: 'pk.eyJ1IjoiaWFuamVubmluZ3MiLCJhIjoiZExwb0p5WSJ9.XLi48h-NOyJOCJuu1-h-Jg',
                mbId: 'ianjennings.l896mh2e',
                channelGroups: [channels_group],
                connect: connect,
                rotate: true,
                history: true,
                options: {
                    zoomAnimation: false,
                },
                transform:function(data){
                    try {
                        var result = data.find(function(value){
                            if (dev_id == 'all') return true;
                            return value['dev_id'] == dev_id;
                        });
                       if (dev_id == 'all'){
                            var index = devices.list.indexOf(result.dev_id);
                            if (index == -1){
                                devices.list.push(result.dev_id);
                                devices.location.push({latlng:result.gps});
                                devices.data.push(result.data);
                            }
                            else{
                                devices.location[index] = {latlng:result.gps};
                                devices.data[index] = result.data;
                            }
                            return devices.location;
                        }
                        return [ {latlng:result.gps} ];
                    }
                    catch (e){
                        return null;
                    }
                },
                marker: function (latlng, data) {
                    var data =  devices.data[ devices.location.length - 1 ];
                    var marker = new L.RotatedMarker(latlng, {
                        icon: L.icon({
                            iconUrl: '<?= base_url();?>assets/img/icons/driver.png',
                            iconSize: [50, 50]
                        })
                    });
                    var basicCarData = car_data[data.id];
                    marker.bindPopup('<p>Vehicle Number:  <b>' +basicCarData.vehicle_number+'</b><br/>'+
                    	'Driver: '+basicCarData.driver+'<br/>'+
                    	'Status: '+basicCarData.status+'</p>');
                    return marker;
                }
            });
            map.setView([-7.42657, 112.73506] , 11);
            function connect() {
            	for (var prop in car_data) {
            		item = car_data[prop];
					pubnub.publish({
		                channel: prop,
		                message: [{dev_id:'device'+item.device_id,gps:item.latlng,data:{id:prop} }]
		            });
				}
            }

            <?php foreach ($trans_today as $d) { $id=number_format($d->transaction_id,0,'',''); ?>
            	L.marker([<?= $d->location_lat?>,<?= $d->location_lng?>],{icon: userIcon }).addTo(map);
            <?php } ?>
            
            MQTTconnect();

            ///Chart////
            transChartToday = document.getElementById('transChartToday').getContext('2d');
            var myFuelChartWeekly = new Chart(transChartToday, {
				type: 'line',
				data: {
					labels: ["<?= implode('","', $hour_field)?>"],
					datasets: [{
						label: "Transaction Income (Rp.)",
						borderColor: "#1d7af3",
						pointBorderColor: "#FFF",
						pointBackgroundColor: "#1d7af3",
						pointBorderWidth: 2,
						pointHoverRadius: 4,
						pointHoverBorderWidth: 1,
						pointRadius: 4,
						backgroundColor: 'transparent',
						fill: true,
						borderWidth: 2,
						data: [<?= implode(',', $hour_item)?>]
					},{
						label: "Fuel Transaction Count (L)",
						borderColor: "#28a745",
						pointBorderColor: "#FFF",
						pointBackgroundColor: "#28a745",
						pointBorderWidth: 2,
						pointHoverRadius: 4,
						pointHoverBorderWidth: 1,
						pointRadius: 4,
						backgroundColor: 'transparent',
						fill: true,
						borderWidth: 2,
						data: [<?= implode(',', $hour_item_fuel)?>]
					},{
						label: "Transaction Count",
						borderColor: "#ffad46",
						pointBorderColor: "#FFF",
						pointBackgroundColor: "#ffad46",
						pointBorderWidth: 2,
						pointHoverRadius: 4,
						pointHoverBorderWidth: 1,
						pointRadius: 4,
						backgroundColor: 'transparent',
						fill: true,
						borderWidth: 2,
						data: [<?= implode(',', $hour_item_count)?>]
					}]
				},
				options : {
					responsive: true, 
					maintainAspectRatio: false,
					legend: {
						position: 'bottom',
						labels : {
							padding: 10,
							fontColor: '#1d7af3',
						}
					},
					tooltips: {
						bodySpacing: 4,
						mode:"nearest",
						intersect: 0,
						position:"nearest",
						xPadding:10,
						yPadding:10,
						caretPadding:10
					},
					layout:{
						padding:{left:15,right:15,top:15,bottom:15}
					}
				}
			});

			$('#add-row').DataTable({
			});

        });
</script>