<?php include("header.php") ?>
<div class="page-content page-content container-fluid">
  <div class="row" data-plugin="matchHeight" data-by-row="true">
    <?php for($i=0; $i< $max_panel; $i++){ ?>
        <div class="col-md-12" id="addDiv-<?= $i?>">
          <div class="panel panel-bordered animation-scale-up " style="animation-fill-mode: backwards; animation-duration: 250ms; animation-delay: 0ms;">
            <div class="panel-heading">
              <h3 class="panel-title">Dashboard Widget Panel - <?= $i+1 ?></h3>
              <div class="panel-actions">
                <a class="panel-action icon md-minus" aria-expanded="true" data-toggle="panel-collapse" aria-hidden="true"></a>
                <a class="panel-action icon md-fullscreen" data-toggle="panel-fullscreen" aria-hidden="true"></a>
              </div>
            </div>
            <div class="panel-body" style="text-align:center">
              <div class="page-content vertical-align-middle ml-auto mr-auto" >
                <button type="button" class="btn btn-floating btn-dark waves-effect waves-classic"><i class="icon md-plus" aria-hidden="true" onclick="AddPanel(<?= $i?>);"></i></button>
                <h4>Add Group Device Data</h4>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12" id="divTable-<?= $i?>" style="display: none;">
          <div class="panel">
            <header class="panel-heading">
              <div class="panel-actions"></div>
              <h3 class="panel-title">Dashboard Widget Panel - List of Data : <span id="group-name-<?= $i?>"></span> </h3>
              <div class="panel-actions">
                <a class="panel-action icon md-minus" aria-expanded="true" data-toggle="panel-collapse" aria-hidden="true"></a>
                <a class="panel-action icon md-fullscreen" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                <a class="btn btn-danger waves-effect waves-classic text-white" onclick="removeGroup(<?=$i?>);"><i class="icon md-delete " aria-hidden="true"></i> Remove Group Data</a>
              </div>
            </header>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-15">
                    <button id="addToTable-<?= $i?>" class="btn btn-primary waves-effect waves-classic" type="button">
                      <i class="icon md-refresh " aria-hidden="true"></i> <b id="newMessage-<?= $i?>"></b> New Data, Reload to show data
                    </button>
                  </div>
                </div>
              </div>
              <table class="table table-hover dataTable table-striped w-full" id="dataTable-<?= $i?>">
              </table>
            </div>
          </div>
        </div>  
    <?php } ?>
    
  </div>
</div>

<button class="btn btn-primary" data-target="#modalData" id="btnModal" data-toggle="modal"
                      type="button" style="display: none;">Generate</button>

<!-- Modal -->
<div class="modal fade" id="modalData" aria-hidden="false" aria-labelledby="exampleFormModalLabel"
  role="dialog" tabindex="-1">
  <div class="modal-dialog modal-simple">
    <form class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
        <h4 class="modal-title" id="exampleFormModalLabel">My Group Device</h4>
      </div>
      <div class="modal-body mt-5 mb-4" id="list">
        
      </div>
    </form>
  </div>
</div>
<!-- End Modal -->

<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/js/elastic/elasticsearch.js"></script>
<script src="<?= base_url()?>assets/js/elastic/jquery.elastic-datatables.js"></script>
<script src="<?= base_url()?>assets/js/mqttws31.js"></script>
<script type="text/javascript">
  var tables = [];
  var groups = [];
  var client = elasticsearch.Client({
      host: '<?= $this->config->item('url_elastic')?>',
      method: 'POST'
    });



  function AddPanel(index){
    $.ajax({
        type: 'post',
        url: '<?= base_url()?>devicegroups/list/'+index,
        success: function (result) {
          if(result){
            $("#list").html(result);
            $("#btnModal").click();
          } else {
            toastr.error('No Group Device', 'Failed', {timeOut: 3000});
          }        
        }
    });    
  }

  function addGroup(code,index, name=''){
      $("#addDiv-"+index).css({display:'none'});
      $("#divTable-"+index).css({display:'block'});
      if(name){
        $("#group-name-"+index).html(name);
      } else {
        $("#group-name-"+index).html($("#name-"+code).val());
        $("#btnModal").click();
      }
      $("#addToTable-"+index).hide();
      dataTable(code,index);
      $.ajax({
          type: 'post',
          url: '<?= base_url()?>devicegroups/addIndex/'+code,
          success: function (result) {
          }
      });
      groups[index] = code;
  }

  function removeGroup(index){
      $("#addDiv-"+index).css({display:'block'});
      $("#divTable-"+index).css({display:'none'});
      $("#group-name-"+index).html('');
      $('#dataTable-'+index).html('');  
      $.ajax({
          type: 'post',
          url: '<?= base_url()?>devicegroups/removeIndex/'+groups[index],
          success: function (result) {
          }
      });
      tables[index] = '';
      groups[index] = '';
  }

  function dataTable(code,index){
    $.fn.dataTable.getMapping({
      index: 'group-'+code,
          client: client,
          execpt:['raw_message','date_add_sensor_unix','date_add_server_unix','topic','token_access','ip_sender'],
    },function(result){
      tables[index] = $('#dataTable-'+index).dataTable( {
          'columns':result,
          "scrollX": true,
          "searching": false,
          'bProcessing': true,
          'bServerSide': true,
          'fnServerData': $.fn.dataTable.elastic_datatables( {
              index: 'group-'+code,
              type: 'authors',
              client: client,
              columnsList:result,
              body:{
                size:15,
                sort: [
                      {
                          "date_add_server":  "desc"
                      }
                  ],
                  query: {
                      "match_all": {}
                  } 
              },
          } )
      } );
    });
  }

  <?php for($i=0; $i< $max_panel; $i++){ 
    if(!empty($panel[$i])){ ?>
    addGroup('<?= $panel[$i]->code_name ?>',<?= $i?>,'<?= $panel[$i]->name ?>');
  <?php }
  } ?>

</script>
