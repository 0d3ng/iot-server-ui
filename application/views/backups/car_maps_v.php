<?php header('Access-Control-Allow-Origin: *'); ?>
<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Car</h4>
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
								<a href="#">Car Maps</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Car Maps Monitoring</h4>
										<a href="<?= base_url()?>car/add/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											Add New Car
										</button></a>
									</div>
								</div>
								<div class="card-body">
									<div id='map' style="min-height:700px;width:100%;"></div>
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
        	foreach ($data as $d) { 
        		$id=number_format($d->car_id,0,'','');
        		$cardriver = $cardriver_m->search(array('car_id'=>$id,'status'=>1,'detail'=>true))->data;
        		$driver = 'None';
        		$status = 'not-active';
        		if($cardriver){
        			$driver = $cardriver[0]->driver->name;
        			$status = 'Active';
        		}
                $device_id = $d->device_id;
        		$listid[] = 'pubnub-mapbox-device-try'.$device_id;
        		$listdata['pubnub-mapbox-device-try'.$device_id] = array(
        			'vehicle_number' => $d->vehicle_number,
        			'driver' => $driver,
        			'status' => $status
        		);
        	}
        ?>
        var channels = ['<?= implode("','", $listid)?>'];
        var car_data = JSON.parse('<?php echo JSON_encode($listdata);?>'); 
        // create channel group
        pubnub.channelGroups.addChannels(
            {
                channels: channels,
                channelGroup: "devices-carmaps-try"
            },
            function(status) {
                if (status.error) {
                console.log("operation failed w/ status: ", status);
                } else {
                    console.log("operation done!")

                    // list channels
                    pubnub.channelGroups.listChannels(
                        {
                            channelGroup: "devices-carmaps-try"
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
            var message = JSON.parse(payload);
            var latlng = [message.gps.lat,message.gps.long];
            var id = parseInt(message.device_id);
            var new_point = {
                latlng : latlng
            };
            var i = channels.indexOf("pubnub-mapbox-device-try"+id);
            if(i>-1){
	            pubnub.publish({
	                channel: channels[i],
	                message: [{dev_id:'device'+id,gps:latlng,data:{id:"pubnub-mapbox-device-try"+id} }]
	            });
        	}
        };

        $(document).ready(function() {
            map = eon.map({
                pubnub: pubnub,
                id: 'map',
                mbToken: 'pk.eyJ1IjoiaWFuamVubmluZ3MiLCJhIjoiZExwb0p5WSJ9.XLi48h-NOyJOCJuu1-h-Jg',
                mbId: 'ianjennings.l896mh2e',
                channelGroups: ['devices-carmaps-try'],
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
                            iconSize: [30, 30]
                        })
                    });
                    // console.log("------------------------------------");
                    // console.log(car_data);
                    // console.log(data.id);
                    // console.log(car_data[data.id]);
                    // console.log("------------------------------------");
                    var basicCarData = car_data[data.id];
                    marker.bindPopup('<p>Vehicle Number:  <b>' +basicCarData.vehicle_number+'</b><br/>'+
                    	'Driver: '+basicCarData.driver+'<br/>'+
                    	'Status: '+basicCarData.status+'</p>');
                    return marker;
                }
            });
            map.setView([-7.42657, 112.73506] , 13);
            function connect() {
            }
            MQTTconnect();
        });
  </script>