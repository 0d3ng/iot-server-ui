<?php include("header.php") ?>
<div class="page-header">  
  <h1 class="page-title">Add New Edge Configuration</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url();?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device">Devices</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url();?>device/edge/<?= $id ?>">Edge Configuration</a></li>
    <li class="breadcrumb-item active">Add</li>
  </ol>
  <div class="page-header-actions">
  </div>
</div>

<div class="page-content">
  <div class="row row-lg">
    <div class="col-md-12">
        <div class="panel" id="exampleWizardFormContainer">
            <div class="panel-heading">
            <h3 class="panel-title">Pearls Steps</h3>
            </div>
            <div class="panel-body">
            <!-- Steps -->
            <div class="pearls row">
                <div class="pearl current col-4">
                <div class="pearl-icon"><i class="icon md-account" aria-hidden="true"></i></div>
                <span class="pearl-title">Account Info</span>
                </div>
                <div class="pearl col-4">
                <div class="pearl-icon"><i class="icon md-card" aria-hidden="true"></i></div>
                <span class="pearl-title">Billing Info</span>
                </div>
                <div class="pearl col-4">
                <div class="pearl-icon"><i class="icon md-check" aria-hidden="true"></i></div>
                <span class="pearl-title">Confirmation</span>
                </div>
            </div>
            <!-- End Steps -->

            <!-- Wizard Content -->
            <form id="exampleFormContainer">
                <div class="wizard-content">
                <div class="wizard-pane active" role="tabpanel">
                    <div class="form-group form-material">
                    <label class="form-control-label" for="inputUserNameOne">Username</label>
                    <input type="text" class="form-control" id="inputUserNameOne" name="username" >
                    </div>
                    <div class="form-group form-material">
                    <label class="form-control-label" for="inputPasswordOne">Password</label>
                    <input type="password" class="form-control" id="inputPasswordOne" name="password"
                        >
                    </div>
                </div>
                <div class="wizard-pane" id="exampleBillingOne" role="tabpanel">
                    <div class="form-group form-material">
                    <label class="form-control-label" for="inputCardNumberOne">Card Number</label>
                    <input type="text" class="form-control" id="inputCardNumberOne" name="number" placeholder="Card number">
                    </div>
                    <div class="form-group form-material">
                    <label class="form-control-label" for="inputCVVOne">CVV</label>
                    <input type="text" class="form-control" id="inputCVVOne" name="cvv" placeholder="CVV">
                    </div>
                </div>
                <div class="wizard-pane" id="exampleGettingOne" role="tabpanel">
                    <div class="text-center my-20">
                    <h4>Please confrim your order.</h4>
                    <div class="table-responsive">
                        <table class="table table-hover text-right">
                        <thead>
                            <tr>
                            <th class="text-center">#</th>
                            <th>Description</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Unit Cost</th>
                            <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td class="text-center">1</td>
                            <td class="text-left">Server hardware purchase</td>
                            <td>32</td>
                            <td>$75</td>
                            <td>$2152</td>
                            </tr>
                            <tr>
                            <td class="text-center">2</td>
                            <td class="text-left">Office furniture purchase</td>
                            <td>15</td>
                            <td>$169</td>
                            <td>$4169</td>
                            </tr>
                            <tr>
                            <td class="text-center">3</td>
                            <td class="text-left">Company Anual Dinner Catering</td>
                            <td>69</td>
                            <td>$49</td>
                            <td>$1260</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                </div>
            </form>
            <!-- Wizard Content -->
            </div>
        </div>        
    </div>
  </div>
</div>


<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/global/vendor/moment/moment.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/bootstrap-datepicker.js"></script>
<script src="<?= base_url()?>assets/global/vendor/clockpicker/bootstrap-clockpicker.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/clockpicker.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/highstock.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/exporting.js"></script>
<script src="<?= base_url()?>assets/global/vendor/highchart/export-data.js"></script>
<script src="<?= base_url()?>assets/global/vendor/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script src="<?= base_url()?>assets/global/vendor/icheck/icheck.min.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/icheck.js"></script>
<script src="<?= base_url()?>assets/global/vendor/jquery-wizard/jquery-wizard.js"></script>
<script src="<?= base_url()?>assets/global/js/Plugin/jquery-wizard.js"></script>
<script src="<?= base_url()?>assets/global/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="<?= base_url()?>assets/global/vendor/formvalidation/formValidation.js"></script>
<script src="<?= base_url()?>assets/global/vendor/formvalidation/framework/bootstrap.js"></script>
<script src="<?= base_url()?>assets/global/vendor/matchheight/jquery.matchHeight-min.js"></script>
<script src="<?= base_url()?>assets/examples/js/forms/wizard.js"></script>
<script>
    $( document ).ready(function() {
        $('#exampleEnableWhenVisited').wizard({
            enableWhenVisited: true,
            onFinish: function() {
              alert('finish');
            }
          });
    });
</script>