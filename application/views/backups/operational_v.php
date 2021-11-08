<?php include("header.php") ?>				
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Car Active</h4>
					</div>
					<div class="row row-projects">
						<?php foreach ($car as $d) { $id=number_format($d->car->car_id,0,'',''); 
							if(!isset($car_income[$id])){
								$car_income[$id] = (object) array(
									'total_income' => 0, 
									'total_item' => 0, 
									'total_fuel' => 0, 
								);
							} 
						?>
						<div class="col-sm-6 col-lg-3">
							<div class="card">
								<div class="p-2">
									<div class="">
										<img class="card-img-top rounded" src="<?= ($d->car->photo)?$this->config->item('url_node').'car/'.$data->file:base_url().'assets/img/default-car.png';  ?>"  alt="Product 1"> <!-- style="max-height: 142px;" -->
									</div>
									<div class="card-danger p-1"><h4 class="mb-1 fw-bold text-center"><?= $d->car->vehicle_number; ?></h4></div>
								</div>
								<div class="card-body pt-2">
									<p class="text-muted  mb-1 text-center"><b>Driver</b>: <?= $d->driver->name; ?> </p>
									<p class="text-muted  mb-1 text-center"><b>Total KM</b>: <?= number_format($d->car->total_km,2,',','.'); ?> KM </p>
									<div class="separator-dashed"></div>
									<p class="text-muted  mb-1 text-center"><b>Tank 1</b>: <?= number_format($d->car->tank,0,',','.'); ?> L </p>
									<div class="separator-dashed"></div>
									<p class="text-muted mb-1 text-center "><b>Transaction</b> : <?= number_format($car_income[$id]->total_item,0,',','.')?> items </p>
									<p class="text-muted mb-1 text-center"> Rp. <?= number_format($car_income[$id]->total_income,0,',','.')?> | <?= number_format($car_income[$id]->total_fuel,0,',','.')?>L </p>
									<div class="separator-dashed"></div>
									<?php if($d->car->geo_alert){ ?>
									<div class="card-danger mb-1"><p class="mb-1 fw-bold text-center">Out of Area</p></div>
									<?php } else { ?>
									<p class="text-muted mb-1 text-center">
										<span class="text-success">In Area </span>
									</p>
									<?php } ?>
									<div class="separator-dashed"></div>
									<?php if($d->car->speed_limit_alert){ ?>
									<div class="card-danger mb-1"><p class="mb-1 fw-bold text-center">Out of Speed Limit</p></div>
									<?php } else { ?>
									<p class="text-muted mb-1 text-center">
										<span class="text-success">Under Speed Limit </span>
									</p>
									<?php } ?>
									<div class="separator-dashed"></div>
									<?php if( date('Y-m-d',strtotime($d->car->next_service_date)) <= date('Y-m-d') ){ ?>
									<div class="card-danger mb-1"><p class="mb-1 fw-bold text-center">Schedule Maintenance </p></div>
									<p class="mb-1 small text-center"> on <?= date('Y-m-d',strtotime($d->car->next_service_date))?> </p>
									<?php } else if( $d->car->total_km >= $d->car->maintance_km ){ ?>
									<div class="card-danger mb-1"><p class="mb-1 fw-bold text-center">Must do Maintenance </p></div>
									<p class="mb-1 small text-center"> Out of Car Kilometers Limit </p>
									<?php } else { ?>
									<p class="text-muted mb-1 text-center">
										<span class="text-success">No Schedule Maintenance </span>
									</p>
									<?php } ?>

								</div>
							</div>
						</div>
						<?php } ?>
					</div>
					<br/><br/>
					
					<div class="page-header">
						<h4 class="page-title">Driver Active</h4>
					</div>
					<div class="row row-projects">
						<?php foreach ($car as $d) { $id=number_format($d->car_driver_id,0,'',''); ?>
						<div class="col-sm-6 col-lg-3">
							<div class="card card-stats">
								<div class="p-2">
									<div class="icon-big icon-warning text-center pt-3 pb-3" style="font-size: 3.5em;">
										<i class="la flaticon-user-2"></i>
									</div>
									<div class="card-danger p-1 mt-1"><h4 class="mb-1 fw-bold text-center"><?= $d->driver->name; ?></h4></div>
								</div>
								<div class="card-body pt-2">
									<p class="text-muted  mb-1 text-center"><b>Phone</b>: <?= $d->driver->phone; ?> </p>
									<div class="separator-dashed"></div>
									<p class="text-muted  mb-1 text-center"><b>Car Vehicle Number</b>: <?= $d->car->vehicle_number; ?> </p>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
<?php include("footer.php") ?>			


<!-- <div class="d-flex">
										<div class="avatar">
											<span class="avatar-title rounded-circle border border-white bg-danger"><span class="la flaticon-user-2"></span</span>
										</div>
										<div class="flex-1 pt-1 ml-2" style="align-items:center;">
											<h5 class="fw-bold mb-1"><?= $d->driver->name; ?></h5>
										</div>
									</div> -->