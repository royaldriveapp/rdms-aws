<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Reassigned register's count</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table class="table table-striped table-bordered">
                              <thead>
                                   <?php foreach ($reassignedcounts as $key => $value) { ?>
                                        <tr data-url="<?php echo site_url('registration/reassignedregistersdetails/' . encryptor($value['col_id'])); ?>">
                                             <th class="trVOE" style="text-align: center;vertical-align: middle;"><?php echo strtoupper($value['col_title']); ?></th>
                                             <th class="trVOE" style="text-align: center;"><?php echo count($value['counts']); ?></th>
                                        </tr>
                                   <?php } ?>
                              </thead>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>
<style>
     .bold-text {
          font-size: 20px;font-weight: bolder;text-align: center;
     }
     .popCallDetails {
          cursor: pointer;
     }
</style>


<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="popCallDetails" tabindex="-1" role="dialog" aria-labelledby="popCallDetails" aria-hidden="true">
     <div class="modal-dialog" role="document">
          <div class="modal-content">
               <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                    </button>
               </div>
               <div class="modal-body">
                    <table id="dtblCallList" class="display" style="width:100%">
                         <thead>
                              <tr>
                                   <th>Number</th>
                                   <th>Punch to register</th>
                              </tr>
                         </thead>
                    </table>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
          </div>
     </div>
</div>


<script>
     $(document).ready(function () {
          $('.popCallDetails').click(function () {
               $('#popCallDetails').modal('show');
               var url = $(this).data('url');
               $('#dtblCallList').DataTable({
                    "order": [[1, "asc"]],
                    "processing": true,
                    "serverSide": true,
                    'serverMethod': 'post',
                    "destroy": true,
                    "ajax": {
                         "type": "POST",
                         "url": url
                    },
                    'columns': [
                         {data: 'ccb_callerNumber'},
                         {
                              "mData": null,
                              "bSortable": true,
                              "mRender": function (data, type, row) {
                                   return '<a target="_blank" title="Call list" href="' + site_url + 'voxbay/calllog/' +
                                           row.ccb_callerNumber + '"><span class="glyphicon glyphicon-phone"></span></a>';
                              }
                         }
                    ]
               });
          });
     });
</script>