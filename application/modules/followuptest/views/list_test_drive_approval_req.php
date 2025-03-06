<style>
     .bg-approved{
          background-color:#304c51; 
          color: #ffffff!important;
     }
     .bg-un-approved{
          background-color:#000000; 
          color: #ffffff!important;
     }
     .thColor{
          background-color:#7fa28ab8!important; 
          color: #000000!important;  
     }
     .bg-veh-detailsj{
          background-color:#000000; 
          color: #ffffff!important;
     }
     th {
          /*    border: solid 1px #00000!important;*/
          border: solid 1px;
     }
     tr:hover {
          background-color:#ffcb05;
          color: black!important;
          font-weight: 550;

     }
     .bg-gray{
          background-color: #cacaca!important;
     }
     .brd-radi{
          border-radius: 0px!important;
          border-top-left-radius: 0px !important;
          border-top-right-radius: 0px !important;
          border-bottom-right-radius: 35px !important;
          border-bottom-left-radius: 35px !important;   
     }
     .h-brd-radi{
          border-radius: 0px!important;
          border-top-left-radius: 35px !important;
          border-top-right-radius: 35px !important;
          border-bottom-right-radius: 0px !important;
          border-bottom-left-radius: 0px !important; 

     }
     .dialog {
          /*    width: 746px !important;*/
          /*    margin: 30px auto !important ;*/
          /*    width: 746px !important;*/
     }
     .bg-gray{
          background-color: #cacaca!important;
     }
     .modal-content {
          border: 7px solid rgba(0,0,0,.2)!important;
          border-radius: 42px!important;
     }
     /*.cus-fdbk-content{
      border: 7px solid rgb(205 204 199 / 26%)!important;
     }*/
     .cus-fdbk-content {
          border: 7px solid #cdcbc373!important;
     }
     .lbl{
          color: black !Important;
     }
     /*tr:nth-child(even) {background:#94c6d6}
     tr:nth-child(odd) {background: #fc8c84}*/



</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Test Drive Approval Request</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-responsive" >
                         <table class="datatableFollowup table table-stripedj table-bordered">
                              <thead class="thColor">
                                   <tr>
                                        <th>Date</th>
                                        <th>Test drive at</th>
                                                                              <th class="bg-veh-details">Vehicle</th>
                                        <th class="bg-veh-details">Reg No</th>
                                        <th class="bg-veh-details">Out km  </th>
                                        <th class="bg-veh-details">In Km </th>
                                       
                                        <th class="bg-veh-details"> Approved By </th>
                                        <th>Required/Pitched Vehicle </th>
                                        <th>Expect Booking  </th>
<!--                                        <th> Executive Remak</th>
                                        <th>TL Remark  </th>
                                        <th> SM Remark </th>-->

                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ($testDrives as $testDrive) {
                                          $approvalData = $this->followup->checkTestDriveApprovals($testDrive['tdrv_id']);
                                          $approvedBy = '';
                                          $approved = 'No one approved yet';
                                          if (!empty($approvalData)) {
                                               foreach ($approvalData as $key => $value) {
                                                    $action = '<font color="#00CC00">Approved</font>';
                                                    if ($value['tdrv_approval_status'] == 2) {
                                                         $action = '<font color="red">Rejected</font>';
                                                    }
                                                    $approvedBy .= $value['approved_by'] . ':' . $action . '<br>';
                                               }

                                               //$approved = chop($approvedBy,",");
                                          }
                                          //print_r($approvalData); 
                                          ?>
                                          <tr class="edit-model-tstDrv <?php echo!empty($approvalData) ? 'bg-approved' : 'bg-un-approved';?>" data-url="<?php echo site_url('followup/edit_test_drive_approval') . '/' . encryptor($testDrive['tdrv_id']);?>" 
                                              >
                                                   <?php $date1 = new DateTime($date = date('d-m-yy', strtotime($testDrive['tdrv_test_drive_date'])));?>
                                               <td class=""><?php echo $date;?></td>

                                               <td class="jtrVOE"><?php echo $testDrive['tdrv_test_drive_at'];?></td>
                                             
                                               <td class="jtrVOE bg-veh-details"><?php echo $testDrive['brd_title'] . '|' . $testDrive['mod_title'] . '|' . $testDrive['var_variant_name'];?></td>
                                               <td class="jtrVOE bg-veh-details"><?php echo $testDrive['val_veh_no'];?></td>
                                               <td class="jtrVOE bg-veh-details"><?php echo $testDrive['tdrv_out_km'];?></td>
                                               <td class="jtrVOE bg-veh-details"><?php echo $testDrive['tdrv_in_km'];?></td>

                                             
                                               <td class="jtrVOE bg-veh-details"><?php
                                            // $approvedBy['app']='';

                                            echo $approvedBy;
                                            // echo '<br>';
                                            //echo $homeVisit['hmva_approval_status'];
                                                   ?></td>
                                               <td class="jtrVOE"><?php echo $testDrive['tdrv_req_or_pitched'] ? 'YES' : 'NO';?></td>
                                               <td class="jtrVOE"><?php echo $testDrive['tdrv_expet_booking'] ? 'YES' : 'NO';?></td>
       <!--                                               <td class="jtrVOE"><?php echo $homeVisit['hmv_executive_remark'];?></td>
                                               <td class="jtrVOE"><?php echo $homeVisit['hmv_tl_remark'];?></td>
                                               <td class="jtrVOE"><?php echo $homeVisit['hmv_sm_remark'];?></td>-->
                                          </tr>
                                     <?php }?>

                              </tbody>
                         </table>
                         <!-- popup -->
                         <div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document" >
                                   <div class=" modal-content bg-gray brd-radi cus-fdbk-content">
                                        <?php echo form_open_multipart("followup/update_test_drive_approval", array('id' => "update_home_visit", 'class' => "upd_hm_visit"))?>
                                        <div class="modal-header bg-gray h-brd-radi">
                                             <h5 class="modal-title lbl" id="exampleModalLabel" style="float: left;">Update Test Drive Approval</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                             </button>
                                        </div>
                                        <div class="modal-body viewEditModel bg-gray brd-radi"></div>
                                        <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary btnCloseModel lbl" data-dismiss="modal">Close</button>
                                             <button type="submit" class="btn btn-success btnSubmit">Submit</button>
                                        </div>
                                        <?php echo form_close()?>
                                   </div>
                              </div>
                         </div>
                         <!-- @popup -->

                         <div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                              <strong>Enq Status Updated successfully!</strong>
                         </div>

                         <div class="alert alert-danger alert-dismissible fade in ErrorMsgBox" role="alert" style="display: none;">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                              <strong>Error:Could not be submitted successfully!</strong>
                         </div>

                    </div>
               </div>
          </div>
     </div>
</div>
