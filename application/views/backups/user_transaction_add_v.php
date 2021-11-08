<?php include("header.php") ?>
			<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Transaction</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?= base_url()?>">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?= base_url('user')?>/transaction">Transaction</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Add New Data</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-10">
							<form  method="post" action="">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Form - Add New Transaction Data</div>
									<div style="margin-top: 10px; ">
										<h6 class="fw-bold text-uppercase text-success op-8">Total EB Money : <?= number_format($ebmoney->money,0,',','.'); ?>&nbsp;&nbsp;<a href="<?= base_url('user')?>/topup/add" class="btn btn-sm btn-secondary btn-border btn-round ">Go Top Up</a> </h6> 
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="phone">Fuel Type</label>
												<select class="form-control" id="fuel-type" name="fuel-type" required>
													<?php 
													$prices = array(); 
													foreach ($fuel as $d) { 
														$prices[] = $d->price; ?>
													<option value="<?= $d->fuel ?>" onclick="setprice(<?= $d->price ?>)"><?= $d->fuel ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="model">Fuel Price</label>
												<input type="number" class="form-control" id="price" name="price" placeholder="Enter Fuel Price" required="required" value="<?php if(!empty($prices)) echo $prices[0]; ?>" readonly>
											</div>
											<div class="form-group">
												<label for="model">Total</label>
												<input type="number" class="form-control" id="fuel-total" name="fuel-total" placeholder="Enter Total" required="required" >
											</div>
											<div class="form-group">
												<label for="model">Pay</label>
												<input type="number" class="form-control" id="pay" name="pay" placeholder="0" required="required" readonly>
											</div>
											<div class="form-group">
												<label for="phone">Note</label>
												<textarea class="form-control" id="note" name="note" rows="2"></textarea>
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label for="phone">Meet Location</label>
												<div id="map" style="height: 300px;"></div>
											</div>
											<div class="form-group">
												<label for="phone">Address</label>
												<textarea class="form-control" id="address" name="address" rows="2"></textarea>
											</div>
										</div>
										<input type="hidden" id="location-lat" name="location-lat">
										<input type="hidden" id="location-lng" name="location-lng">
									</div>
								</div>
								<div class="card-action">
									<button class="btn btn-success" name="save" value="save">Submit</button>
									<button class="btn btn-danger">Cancel</button>
								</div>								
							</div>
							</form>
						</div>
					</div>
				</div>
<?php include("footer.php") ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0-beta.2.rc.2/leaflet.js"></script>

<script src="https://unpkg.com/esri-leaflet@2.2.3/dist/esri-leaflet.js" integrity="sha512-YZ6b5bXRVwipfqul5krehD9qlbJzc6KOGXYsDjU9HHXW2gK57xmWl2gU6nAegiErAqFXhygKIsWPKbjLPXVb2g==" crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css" integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ==" crossorigin="">
<script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js" integrity="sha512-zdT4Pc2tIrc6uoYly2Wp8jh6EPEWaveqqD3sT0lf5yei19BC1WulGuh5CesB0ldBKZieKGD7Qyf/G0jdSe016A==" crossorigin=""></script>


<script type="text/javascript">
	var map,marker,geocodeService;

	function cb(data){
		console.log(data);
		$("#address").val(data.display_name);
	}

	function getaddres(marker){
		// myLat = marker[0];
		// myLng = marker[1];
		// var script = document.createElement('script');
		// script.id = 'nominatim';
		// script.async = true; // This is required for asynchronous execution
		// script.src = 'https://nominatim.openstreetmap.org/reverse?json_callback=cb&format=json&lat=' + myLat + '&lon=' +
		// myLng + '&zoom=27&addressdetails=1';
		// document.body.appendChild(script);
   		// document.body.removeChild(script);
   		$("#location-lat").val(marker[0]);
   		$("#location-lng").val(marker[1]);
  		geocodeService.reverse().latlng(marker).run(function(error, result) {  			
  			$("#address").val(result.address.Match_addr);
		});
	}
	
	function initMaps(center){
		console.log(center);
		map = L.map('map').setView(center, 15);
		L.tileLayer(
		  'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		    maxZoom: 18
		  }).addTo(map);
		marker = L.marker(center).addTo(map);
		getaddres(center);
		map.on('click', function(e) {        
		    var popLocation= [e.latlng.lat,e.latlng.lng]; 
		    map.removeLayer(marker);
		    marker = L.marker(popLocation).addTo(map); 
		    getaddres(popLocation);   
		});
	}
	// get location using the Geolocation interface
	var geoLocationOptions = {
	  enableHighAccuracy: true,
	  timeout: 10000,
	  maximumAge: 0
	}

	function success(position) {
	  	myLat = position.coords.latitude.toFixed(6);
	  	myLng = position.coords.longitude.toFixed(6);
	  	latLng = [myLat, myLng];
	  	console.log('success');
	  	initMaps(latLng);
	}

	function error(err) {
		var center = [-6.2819487,106.6613594];
		console.log('error');
		initMaps(center);
	  	console.warn(`ERROR(${err.code}): ${err.message}`)
	}

	$(document).ready(function() {	
		geocodeService = L.esri.Geocoding.geocodeService();	
		navigator.geolocation.getCurrentPosition(success, error, geoLocationOptions)

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

		var ebmoney = <?= $ebmoney->money?>;
		function counts(){
			var total = parseFloat($( "#price" ).val()) * parseFloat($( "#fuel-total" ).val());
			
			if(total > ebmoney){
				$.notify({
					icon: 'flaticon-error',
					title: 'EB Money not enough',
					message: 'Your balance EB Money is not enough!',
				},{
					type: 'danger',
					placement: {
						from: "bottom",
						align: "right"
					},
					time: 3000,
				});	
				$( "#fuel-total" ).val(0);
				total = parseFloat($( "#price" ).val()) * parseFloat($( "#fuel-total" ).val());
			}

			$("#pay").val(total);
		}
		$( "#price" ).keyup(function( event ) {
			counts();
		});
		$( "#fuel-total" ).keyup(function( event ) {
			counts();
		});

		<?php
		$js_array = json_encode($prices);
		echo "var prices = ". $js_array . ";\n";
		?>
		$("#fuel-type").change(function() {
			var index = $(this).children('option:selected').index();
			var price = prices[index];
			$( "#price" ).val(price);
			$( "#price" ).keyup();
		});

	});

</script>