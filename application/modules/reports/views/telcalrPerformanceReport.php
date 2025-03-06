<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Telecaller Performance Report</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table class="table table-striped table-bordered">
                              <thead>
                                   <tr> 
                                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Date</th>
                                        <th colspan="7" style="text-align: center;">Tele out</th>
                                        <th colspan="6" style="text-align: center;">Tele in</th>
                                        <th colspan="2" style="text-align: center;">Summery</th>
                                   </tr>
                                   <tr>
                                        <th>Effective calls</th>
                                        <th>Ineffective calls</th>
                                        <th>Hot</th>
                                        <th>Warm</th>
                                        <th>Cold</th>
                                        <th>Assigned</th>
                                        <th>Pending</th>
                                        <th title="Total voxbay call including missed and other range issues">Tele In</th>
                                        <th title="Voxay missed calls">Missed</th>
                                        <th title="Voxay call related to sales and purchase department">Inquiry</th>
                                        <th title="Total effective voxbay calls">Effective</th>
                                        <th title="Inquiry follwup followd by telecallers">Followup</th>
                                        <th title="Pending missed calls from voxbay">Pending</th>
                                        <!--<th>Total</th>-->
                                        <th title="Effective calls on telein and tele out">Effective calls</th>
                                        <th title="Total connected tele in/out calls">Total calls</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($report)) {
                                          foreach ($report as $key => $value) {
                                               $totalCalls = $value['efectedCall'] + $value['ineffectiveCall'] + $value['smryTotal'];
                                               ?>
                                               <tr>
                                                    <td><?php echo $key;?></td>
                                                    <td class="bold-text"><?php echo $value['efectedCall'];?></td>
                                                    <td class="bold-text"><?php echo $value['ineffectiveCall'];?></td>
                                                    <td class="bold-text"><?php echo $value['hot'];?></td>
                                                    <td class="bold-text"><?php echo $value['warm'];?></td>
                                                    <td class="bold-text"><?php echo $value['cold'];?></td>
                                                    <td class="bold-text"><?php echo $value['ttlAssigned'];?></td>
                                                    <td class="bold-text"><?php echo $value['pending'];?></td>
                                                    <td class="bold-text popCallDetails" 
                                                        data-url="<?php echo site_url('reports/telcalrPerformanceDeailReport/telein/' . $key);?>">
                                                             <?php echo $value['teleIn'];?>
                                                    </td>
                                                    <td class="bold-text"><?php echo $value['missed'];?></td>
                                                    <td class="bold-text"><?php echo $value['salesPurchase'];?></td>
                                                    <td class="bold-text"><?php echo $value['effective'];?></td>
                                                    <td class="bold-text"><?php echo $value['followup'];?></td>
                                                    <td class="bold-text popCallDetails"
                                                        data-url="<?php echo site_url('reports/telcalrPerformanceDeailReport/teleinpending/' . $key);?>">
                                                             <?php echo $value['pendingToCall'];?></td>
                                                    <!--<td>Total</td>-->
                                                    <td class="bold-text"><?php echo $value['efectedCall'] + $value['effective'];?></td>
                                                    <td class="bold-text"><?php echo $totalCalls;?></td>
                                               </tr>
                                               <?php
                                          }
                                     }
                                   ?>
                              </tbody>
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