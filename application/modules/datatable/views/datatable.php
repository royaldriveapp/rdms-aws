<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Register table</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <?php if (check_permission('reports', 'xlsx_rpt_enq_veh_based')) {?>
                                   <li style="float: right;">
                                        <a href="<?php echo site_url($controller . '/export');?>">
                                             <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                        </a>
                                   </li>
                              <?php } ?>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
                         <table id="tblDTMasterList" class="table table-bordered">
                              <thead>
                                   <tr>
                                        <?php
                                        foreach ($fields as $field) {
                                             echo '<th>' . $field . '</th>';
                                        }
                                        ?>
                                   </tr>
                              </thead>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>

<script>
     $(document).ready(function () {
          $('#tblDTMasterList').dataTable({
               "order": [],
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": site_url + "datatable/fetchData",
               'initComplete': function (settings) {
                    api = new $.fn.dataTable.Api(settings);
               },
               'columns': [
<?php
foreach ($fields as $field) {
     echo "{data: '" . $field . "'},";
}
?>
               ]
          });
     });
</script>