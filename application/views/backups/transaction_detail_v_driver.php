<?php header('Access-Control-Allow-Origin: *'); ?>
<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Transaction</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?= base_url()?>administration">
									<i class="link-icon icon-grid"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?= base_url()?>/transaction">Transaction</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Detail</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-10">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Detail Transaction Order</div>
									<div style="margin-top: 10px; ">
										<?php if($data->status == 0){ ?>
										<h6 class="fw-bold text-uppercase text-warning op-8">Status : In Order Queue</h6>
                                        <?php } else if($data->status == 1){ ?>
                                        <h6 class="fw-bold text-uppercase text-success op-8">Status : Transaction Success - Done</h6>
                                        <?php } else if($data->status == 2){ ?>
                                        <h6 class="fw-bold text-uppercase text-info op-8">Status : Driver On The Way</h6>
                                        <?php } else if($data->status == 3){ ?>
                                        <h6 class="fw-bold text-uppercase text-primary op-8">Status : Transaction Start - 
Refueling Process</h6>
                                        <span class="text-primary pl-3"></span>
                                        <?php }  ?>
										
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="phone">Customer</label>
												<input type="text" class="form-control" id="customer" name="customer" placeholder="Enter Fuel Price" required="required" value="<?= $data->customer->name; ?>" disable>
											</div>
											<div class="form-group">
												<label for="phone">Phone</label>
												<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Fuel Price" required="required" value="<?= $data->customer->phone; ?>" disable>
											</div>
											<div class="form-group">
												<label for="phone">Vehicle Number</label>
												<input type="text" class="form-control" id="price" name="price" placeholder="Enter Fuel Price" required="required" value="<?= $data->car->vehicle_number; ?>" disable>
											</div>
											<div class="form-group">
												<label for="phone">Fuel Type</label>
												<input type="text" class="form-control" id="fuel_type" name="fuel_type" placeholder="Enter Fuel Price" required="required" value="<?= $data->fuel_type; ?>" disable>
											</div>
											<div class="form-group">
												<label for="model">Fuel Price</label>
												<input type="number" class="form-control" id="price" name="price" placeholder="Enter Fuel Price" required="required" value="<?= number_format($data->price,0,',','.'); ?>" disable>
											</div>
											<div class="form-group">
												<label for="model">Total</label>
												<input type="number" class="form-control" id="fuel-total" name="fuel-total" placeholder="Enter Total" required="required" value="<?= number_format($data->total_fuel,0,',','.'); ?>" disable>
											</div>
											<div class="form-group">
												<label for="model">Pay</label>
												<input type="number" class="form-control" id="pay" name="pay" placeholder="0" required="required" disable value="<?= number_format($data->pay,0,',','.'); ?>">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="phone">Meet Location</label>
												<div id="map" style="height: 300px;"></div>
											</div>
											<div class="form-group">
												<label for="phone">Address</label>
												<textarea class="form-control" id="address" name="address" rows="2" disable><?= $data->location_address; ?></textarea>
											</div>
											<div class="form-group">
												<label for="phone">Note</label>
												<textarea class="form-control" id="note" name="note" rows="2" disable><?= $data->note; ?></textarea>
											</div>
										</div>
									</div>
								</div>
								<form method="post">
								<div class="card-action">
									<?php if($data->status == 0){ ?>
									<button class="btn btn-success" name="save" value="save">Take the Order</button>
									<input type="hidden" name="status" value="2">
									<?php } ?>
									<?php if($data->status == 2){ ?>
									<button class="btn btn-success" name="save" value="save">Start Transaction Manual</button>
									<input type="hidden" name="status" value="3">
									<?php } ?>
									<?php if($data->status == 3){ ?>
									<button class="btn btn-success" name="save" value="save">Transaction Finish Manual</button>
									<input type="hidden" name="status" value="1">
									<?php } ?>
									<a href="<?= base_url()?>/transaction"><button type="button" class="btn btn-danger">Back</button></a>
								</div>	
								</form>							
							</div>
							
						</div>
					</div>
				</div>
<?php include("footer.php") ?>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0-beta.2.rc.2/leaflet.js"></script> -->
<script src="<?= base_url()?>assets/js/pubnub-single-bundle.js" type="text/javascript"></script>
<script src="<?= base_url()?>assets/js/mqttws31.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/leaflet-routing-machine.js"></script>

<script type="text/javascript">
	var map,marker,driver_marker,geocodeService;
	var userIcon = L.icon({
	    iconUrl: '<?= base_url()?>assets/img/icons/user.png',
	    iconSize: [48, 48]
	});
	var driverIcon = L.icon({
	    iconUrl: '<?= base_url()?>assets/img/icons/driver.png',
	    iconSize: [48, 48]
	});

	//Pubnub Setting///
    var pubnub = new PubNub({
        publishKey: 'pub-c-f91d6dd2-2d49-4bea-b00d-8db6741441dd',
        subscribeKey: 'sub-c-01099264-8f83-11ea-8e98-72774568d584'
    });
	var channel = 'pubnub-mapbox-trans<?= $data->transaction_id;?>';
	var deviceId = '<?=$data->car->device_id; ?>';
	var map 
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
	//--------------------------------------------///
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
		var topic = message.destinationName;
		var payload = message.payloadString;
		console.log(payload);
		var message = JSON.parse(payload);
		var latlng = [message.gps.lat,message.gps.long];
        var id = parseInt(message.device_id);
		var new_point = {
			latlng : latlng
		};
		if(id == deviceId){
			pubnub.publish({
				channel: channel,
				message: [new_point]
			});
		}
	};
	//--------------------------------------------///
	function initMaps(center){
		console.log(center);
		// map = L.map('map').setView(center, 15);
		// L.tileLayer(
		//   'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		//     maxZoom: 18
		//   }).addTo(map);
		function connect() {
			var new_point = {
				latlng : center
			};
			pubnub.publish({
				channel: channel,
				message: [new_point]
			});	
		}
		map = eon.map({
            pubnub: pubnub,
            id: 'map',
            mb_token: 'pk.eyJ1IjoiaWFuamVubmluZ3MiLCJhIjoiZExwb0p5WSJ9.XLi48h-NOyJOCJuu1-h-Jg',
            mb_id: 'ianjennings.l896mh2e',
            channel: channel,
            connect: connect,
            options: {
            	zoomAnimation: false,
            },marker: function (latlng, data) {
                var marker = new L.RotatedMarker(latlng,{icon: driverIcon } );
                return marker;
            }
        });
        map.setView(center, 15);
		//driver_marker = L.marker(center,{icon: driverIcon }).addTo(map);
		MQTTconnect();
		<?php if($data->status == 2){ ?>
			marker = L.marker([<?= $data->location_lat; ?>,<?= $data->location_lng; ?>],{icon: userIcon }).addTo(map);
			route([<?=$data->car->postion_lat; ?>,<?=$data->car->postion_lng; ?>],[<?= $data->location_lat; ?>,<?= $data->location_lng; ?>]);
		<?php } ?>
	}

	function route(from,to){
		var layercontrol = L.control.layers(null, {}).addTo(map);
		var router = new L.Routing.OSRMv1({});	

		var route1waypoints = [
		    L.Routing.waypoint(L.latLng(from[0], from[1])),
		    L.Routing.waypoint(L.latLng(to[0], to[1]))
		],
		route1plan = L.Routing.plan(route1waypoints);

		router.route(route1waypoints, function(error, routes) {
			console.log(error);
			console.log(routes);
		  var route1line = L.Routing.line(routes[0]);
		  var route1group = L.layerGroup([ route1line]).addTo(map); //route1plan,
		  layercontrol.addOverlay(route1group, "LayerRoute1");
		}, null, {});
	}

	$(document).ready(function() {
		<?php if($data->car->postion_lat){ ?>
			initMaps([<?= $data->car->postion_lat; ?>,<?= $data->car->postion_lng; ?>]);
						
		<?php } else { ?>
			initMaps([-6.2819487,106.6613594]);
		<?php } ?>


		//Notify
		<?php if($success){ ?>
		$.notify({
			icon: 'flaticon-success',
			title: 'Success',
			message: '<?= $success; ?>',
		},{
			type: 'success',
			placement: {
				from: "bottom",
				align: "right"
			},
			time: 3000,
		});	
		<?php } 
		 if($error){ ?>
		$.notify({
			icon: 'flaticon-error',
			title: 'Failed',
			message: '<?= $error; ?>',
		},{
			type: 'danger',
			placement: {
				from: "bottom",
				align: "right"
			},
			time: 3000,
		});	
		<?php } ?>
	});

</script>