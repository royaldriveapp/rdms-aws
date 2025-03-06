<style>
     .bg-approved{
/*          background-color:#304c51; */
background-color:#5f4474; 
          
          color: #ffffff!important;
     }
     .bg-un-approved{
          background-color:#000000; 
          color: #ffffff!important;
     }
     .thColor{
/*          background-color:#7fa28ab8!important; */
/* background-color: #0a0909!important; */
background-color: #1d1b1b!important; 
         
/*          color: #000000!important;  */
/*color: #55fe4c!important; */
color: #00ff00!important; 
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
/*          font-weight: 550;*/

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

.table-responsive tr td {
    white-space: nowrap;
}
.table-responsive tr th {
    white-space: nowrap;
}

</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Home visit Approval Request</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-responsive" >
                         <table class="datatableFollowup table table-stripedj table-bordered">
                              <thead class="thColor">
                                   <tr>
                                        <th>Requested Date</th>
                                        <th>Place</th>
                                        <th>Staff</th>
                                        <th>Department</th>
                                        <th>Travel With </th>
                                        <th class="bg-veh-details">Vehicle used for home visit</th>
                                        <th class="bg-veh-details">Reg No</th>
                                        <th class="bg-veh-details">Out km  </th>
                                        <th class="bg-veh-details">In Km </th>
                                        <th class="bg-veh-details">In Date  </th>
                                        <th class="bg-veh-details"> Approved By </th>
                                        <th>Discussion Time  </th>
                                        <th>Met the Customer with Family  </th>
<!--                                        <th> Executive Remak</th>
                                        <th>TL Remark  </th>
                                        <th> SM Remark </th>-->

                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ($homeVisits as $homeVisit) {
                                          $approvalData = $this->followup->checkHomeVisitApprovals($homeVisit['hmv_id']);
                                          $approvedBy = '';
                                          $approved = 'No one approved yet';
                                          if (!empty($approvalData)) {
                                               foreach ($approvalData as $key => $value) {
                                                    $action = '<font color="#00CC00">Approved</font>';
                                                    if ($value['hmva_approval_status'] == 2) {
                                                         $action = '<font color="red">Rejected</font>';
                                                    }
                                                    $approvedBy .= $value['approved_by'] . ':' . $action . '<br>';
                                               }

                                               //$approved = chop($approvedBy,",");
                                          }
                                          //print_r($approvalData); 
                                          ?>
                                          <tr class="edit-model-hmVisit <?php echo!empty($approvalData) ? 'bg-approved' : 'bg-un-approved';?>" data-url="<?php echo site_url('followup/edit_home_visit_approval') . '/' . encryptor($homeVisit['hmv_id']);?>" 
                                              >
                                                   <?php $date1 = new DateTime($date = date('d-m-Y', strtotime($homeVisit['hmv_date'])));?>
                                               <td class=""><?php echo $date;?></td>

                                               <td class="jtrVOE"><?php echo $homeVisit['hmv_place'];?></td>
                                                <td class="jtrVOE"><?php echo $homeVisit['enq_added_by_name'];?></td>
                                                  <td class="jtrVOE"><?php  
                                                
                                                 if($homeVisit['usr_departments']==4 OR $homeVisit['usr_departments']==6){
                                                    echo 'Sales';
                                               }elseif($homeVisit['usr_departments']==7 OR $homeVisit['usr_departments']==8){
                                                         echo 'Purchase';        
                                                           }
                                                    ?></td>
                                               <td class="jtrVOE"><?php echo $homeVisit['travel_with'];?></td>
                                               <td class="jtrVOE bg-veh-details">
                                               <?php
                                                    if ($homeVisit['hmv_travel_mod'] == 13) {

                                                         if ($homeVisit['hmv_fleet_veh'] == 1) {
                                                              $vehnm = $homeVisit['brd_title'] . '|' . $homeVisit['mod_title'] . '|' . $homeVisit['var_variant_name'];
                                                              $veh_type = 'Company veh';
                                                              $veh_no = $homeVisit['val_veh_no'];
                                                              echo $vehnm . '(' . $veh_type . ')';
                                                         } else if ($homeVisit['hmv_fleet_veh'] == 2) {
                                                              $vehnm = $homeVisit['brd_title'] . '|' . $homeVisit['mod_title'] . '|' . $homeVisit['var_variant_name'];
                                                              $veh_type = 'Stock veh';
                                                              $veh_no = $homeVisit['val_veh_no'];
                                                              echo $vehnm . '(' . $veh_type . ')';
                                                         } else if ($homeVisit['hmv_fleet_veh'] == 3) {
                                                              $veh_type = 'Own vehicle';
                                                              $veh_no = $homeVisit['hmv_veh_no'];
                                                              echo $veh_type;
                                                         }
                                                    } else {
                                                         echo $homeVisit['dtm_title'];
                                                           $veh_no='';
                                                    }
//echo $homeVisit['hmv_travel_mod']==8? ($homeVisit['brd_title'] . '|' . $homeVisit['mod_title'] . '|' . $homeVisit['var_variant_name']):$homeVisit['dtm_title'];
                                                    ?>   
                                               </td>
                                               <td class="jtrVOE bg-veh-details"><?php echo @$veh_no;?></td>
                                               <td class="jtrVOE bg-veh-details"><?php echo $homeVisit['hmv_out_km'];?></td>
                                               <td class="jtrVOE bg-veh-details"><?php echo $homeVisit['hmv_in_km'];?></td>

                                               <td class="jtrVOE bg-veh-details"><?php echo $homeVisit['hmv_in_date'];?> </td>
                                               <td class="jtrVOE bg-veh-details"><?php
                                            // $approvedBy['app']='';

                                            echo $approvedBy;
                                            // echo '<br>';
                                            //echo $homeVisit['hmva_approval_status'];
                                                   ?></td>
                                               <td class="jtrVOE"><?php echo $homeVisit['hmv_discussion_time'];?></td>
                                               <td class="jtrVOE"><?php echo $homeVisit['hmv_met_cus_with_family'] ? 'YES' : 'NO';?></td>
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
                                        <?php echo form_open_multipart("followup/update_home_visit_approval", array('id' => "update_home_visit", 'class' => "upd_hm_visit"))?>
                                        <div class="modal-header bg-gray h-brd-radi">
                                             <h5 class="modal-title lbl" id="exampleModalLabel" style="float: left;">Update Home Visit Approval..</h5>
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
