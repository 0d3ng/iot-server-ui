<?php include("header.php") ?>				
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Administration</h4>
					</div>
					<div class="row row-projects">
						<?php 
							$menu = array();
							$menu[] = (object)array( "color"=>'menu-adminstrator', "title"=>'Administrator', "link"=> base_url("").'admin', 'icon'=>'fas fa-user-tie');
							$menu[] = (object)array( "color"=>'menu-car', "title"=>'Car', "link"=> base_url("").'car', 'icon'=>'fas fa-truck');
							$menu[] = (object)array( "color"=>'menu-car-maps', "title"=>'Car Map', "link"=> base_url("").'car/maps', 'icon'=>'fas fa-map-marked');
							$menu[] = (object)array( "color"=>'menu-fuel', "title"=>'Fuel', "link"=> base_url("").'fuel', 'icon'=>'fas fa-fill-drip');
							$menu[] = (object)array( "color"=>'menu-driver', "title"=>'Driver', "link"=> base_url("").'driver', 'icon'=>'far fa-id-badge');
							$menu[] = (object)array( "color"=>'menu-customer', "title"=>'Customer', "link"=> base_url("").'customer', 'icon'=>'fas fa-users');
							$menu[] = (object)array( "color"=>'menu-transaction', "title"=>'Order Transaction', "link"=> base_url("").'transaction', 'icon'=>'fas fa-file-alt');
							$menu[] = (object)array( "color"=>'menu-ebtransaction-transaction', "title"=>'EB Money - Transaction', "link"=> base_url("").'ebtransaction', 'icon'=>'fas fa-money-check-alt');
							$menu[] = (object)array( "color"=>'menu-ebtransaction-customer', "title"=>'EB Money - Customer', "link"=> base_url("").'ebtransaction/customer', 'icon'=>'fas fa-id-card');
							$menu[] = (object)array( "color"=>'menu-topup', "title"=>'Top up', "link"=> base_url("").'ebtransaction/topup', 'icon'=>'fas fa-plus');
							$menu[] = (object)array( "color"=>'menu-schedule', "title"=>'Schedule Driver', "link"=> base_url("").'schedule', 'icon'=>'link-icon icon-calendar');
						?>
						<?php foreach($menu as $m){ ?>
						<div class="col-lg-3 col-md-4 col-sm-6 col-6">
							<a href="<?= $m->link?>" class="block-menu">
							<div class="card <?= $m->color ?> card-annoucement card-round">
								<div class="card-body text-center">
									<div class="card-desc icon-menu-big">
										<i class="<?= $m->icon?>"></i>
									</div>
									<div class="card-opening admin-menu-title"><?= $m->title?></div>									
								</div>
							</div>
							</a>
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