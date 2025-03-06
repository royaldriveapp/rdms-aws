<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Daily Assessment Report <?php
                                echo isset($dar['darm_added_on']) ?
                                        date('j M Y', strtotime($dar['darm_added_on'])) : '';
                              ?> of 
                              <?php echo isset($dar['ab_usr_username']) ? $dar['ab_usr_username'] : '';?></h2>
                         <div class="clearfix"></div>
                    </div>
                    <form action="<?php echo site_url('dar/verifydar');?>" method="post" class="verifyTeamDAR" onsubmit="$('.verifyTeamDAR').submit();">
                         <input type="hidden" name="darm_added_by" value="<?php echo $dar['darm_added_by'];?>"/>
                         <input type="hidden" name="darm_id" value="<?php echo $dar['darm_id'];?>"/>
                         <div class="form-horizontal form-label-left">
                              <?php
                                $isVerifiedByTL = (isset($dar['darm_is_verified_team_lead']) && !empty($dar['darm_is_verified_team_lead'])) ? true : false;
                                $isVerifiedByMG = (isset($dar['darm_is_verified_manager']) && !empty($dar['darm_is_verified_manager'])) ? true : false;
                                if (isset($dar['enquiry']) && !empty($dar['enquiry'])) {
                                     ?>
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="x_panel">
                                               <div class="x_title">
                                                    <h2><i class="glyphicon glyphicon-list-alt"></i> Inquiries 
                                                         <?php if (check_permission('dar', 'verifydar')) {?>
                                                              <small class="red">Please enter comments for all enquiry</small>
                                                         <?php }?>
                                                    </h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                         <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                               </div>
                                               <div class="x_content">
                                                    <div class="table-responsive">
                                                         <table id="tblViewDarEnquires" class="table table-striped table-bordered ">
                                                              <thead style="background-color: grey; color: white;">
                                                                   <tr>
                                                                        <?php echo check_permission('dar', 'verifydar') ? '<th></th>' : '';?>
                                                                        <th>Customer</th>
                                                                        <th>Mobile</th>
                                                                        <th>Mode of Contact</th>
                                                                        <th>Status</th>
                                                                        <th>Type</th>
                                                                        <th>Expected Revenue</th>
                                                                   </tr>
                                                              </thead>
                                                              <tbody>
                                                                   <?php
                                                                   $enqFooterColspan = 2;
                                                                   $folFooterColspan = 7;
                                                                   $modOfContact = unserialize(MODE_OF_CONTACT);
                                                                   $hwcStatus = unserialize(ENQUIRY_UP_STATUS);
                                                                   $enqCount = count($dar['enquiry']);
                                                                   $hwc = array();

                                                                   foreach ((array) $dar['enquiry'] as $key => $value) {
                                                                        $hwc[$value['dare_enq_status']] = isset($hwc[$value['dare_enq_status']]) ?
                                                                                $hwc[$value['dare_enq_status']] : '';
                                                                        $hwc[$value['dare_enq_status']] = $hwc[$value['dare_enq_status']] + 1;
                                                                        ?>
                                                                        <tr data-url="<?php echo site_url('enquiry/printTrackCard/' . encryptor($value['dare_enq']));?>">
                                                                             <?php if (check_permission('dar', 'verifydar')) {?>
                                                                                  <td class="details-control">
                                                                                       <img src="images/details_open.png" class="btnOpenClose" style="cursor: pointer;"/>
                                                                                  </td>
                                                                             <?php }?>
                                                                             <td class="trVOE">
                                                                                  <?php echo strtoupper($value['dare_enq_customer']);?>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php echo $value['dare_enq_mobile'];?>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php
                                                                                  echo isset($modOfContact[$value["dare_enq_mode_enquiry"]]) ?
                                                                                          $modOfContact[$value["dare_enq_mode_enquiry"]] : '';
                                                                                  ?>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php
                                                                                  echo isset($hwcStatus[$value["dare_enq_status"]]) ?
                                                                                          $hwcStatus[$value["dare_enq_status"]] : '';
                                                                                  ?>
                                                                             </td>
                                                                             <td>
                                                                                  <?php
                                                                                  if ($value['enq_cus_status'] == 1) {
                                                                                       echo 'Sale';
                                                                                  } else if ($value['enq_cus_status'] == 2) {
                                                                                       echo 'Buy';
                                                                                  } else if ($value['enq_cus_status'] == 3) {
                                                                                       echo 'Exchange';
                                                                                  }
                                                                                  ?>                                             
                                                                             </td>
                                                                             <td style="width: 150px;">
                                                                                  <?php echo number_format($value['dare_expected_amount'], 2);?>
                                                                             </td>
                                                                        </tr>
                                                                        <?php
                                                                        if (check_permission('dar', 'verifydar')) {
                                                                             $enqFooterColspan = 2;
                                                                             ?>
                                                                             <tr style="display: none;">
                                                                                  <td colspan="7">
                                                                                       <input req="true" class="form-control" type="text" placeholder="Comments for teamlead"
                                                                                       <?php echo $isVerifiedByTL ? 'readonly="true"' : '';?>
                                                                                              value="<?php echo $value['dare_TL_comments']?>" name="enq_comments[<?php echo $value['dare_id']?>]"/>
                                                                                              <?php if (is_roo_user() || $this->usr_grp == 'MG') {?>
                                                                                            <input req="true" class="form-control" placeholder="Comments for manager"
                                                                                                   <?php echo $isVerifiedByMG ? 'readonly="true"' : '';?> type="text" 
                                                                                                   value="<?php echo $value['dare_MG_comments'];?>" name="mgr_enq_comments[<?php echo $value['dare_id']?>]"/>
                                                                                              <?php }?>
                                                                                  </td>
                                                                             </tr>
                                                                             <?php
                                                                        }
                                                                   }
                                                                   ?>
                                                              </tbody>
                                                              <tfoot style="background-color: darkgreen; color: white;">
                                                                   <tr>
                                                                        <td align="center" colspan="<?php echo $enqFooterColspan;?>">
                                                                             <i class="fa fa-spinner"> TOTAL ENQUIRY : <?php echo $enqCount;?> </i>
                                                                        </td>
                                                                        <?php
                                                                        foreach ($hwcStatus as $key => $value) {
                                                                             $count = isset($hwc[$key]) ? $hwc[$key] : 0;
                                                                             $per = ($enqCount > 0) ? ($count * 100) / $enqCount : 0;
                                                                             if ($per >= 80 && $per <= 100) {
                                                                                  $battery = 'fa-battery-full';
                                                                             } else if ($per >= 60 && $per < 80) {
                                                                                  $battery = 'fa-battery-three-quarters';
                                                                             } else if ($per >= 40 && $per < 60) {
                                                                                  $battery = 'fa-battery-half';
                                                                             } else if ($per >= 10 && $per < 40) {
                                                                                  $battery = 'fa-battery-1';
                                                                             } else if ($per < 10 && $per > 0) {
                                                                                  $battery = 'fa-battery-1';
                                                                             } else if ($per <= 0) {
                                                                                  $battery = 'fa-battery-empty';
                                                                             }
                                                                             ?>
                                                                             <td>
                                                                                  <i class="fa <?php echo $battery;?>">
                                                                                       <?php echo strtoupper($value) . ' : ' . $count;?>
                                                                                  </i>
                                                                             </td>
                                                                        <?php }?>
                                                                        <td>
                                                                             Total : <i class="fa fa-inr lblDARExpectedTotal"> <?php echo number_format($dar['darm_expec_revenue'], 2);?> /-</i>
                                                                        </td>
                                                                   </tr>
                                                              </tfoot>
                                                         </table>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                <?php }?>
                              <?php
                                if ((isset($dar['mod_of_contact']) && !empty($dar['mod_of_contact'])) ||
                                        (isset($dar['hwc']) && !empty($dar['hwc'])) ||
                                        (isset($dar['type']) && !empty($dar['type']))) {
                                     ?>
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="x_panel">
                                               <div class="x_title">
                                                    <h2><i class="fa fa-line-chart"></i> Inquiry data analysis</h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                         <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                               </div>
                                               <div class="x_content">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                         <?php if (isset($dar['mod_of_contact']) && !empty($dar['mod_of_contact'])) {?>
                                                              <div class="col-md-4 col-sm-4 col-xs-12">
                                                                   <div class="x_panel">
                                                                        <div class="x_title">
                                                                             <h2><i class="glyphicon glyphicon-phone-alt" aria-hidden="true"></i> Mode of contact</h2>
                                                                             <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="x_content">
                                                                             <div class="table-responsive">
                                                                                  <table class="table">
                                                                                       <tbody>
                                                                                            <?php
                                                                                            $sum = 0;
                                                                                            foreach ($dar['mod_of_contact'] as $key => $value) {
                                                                                                 $sum += $value['enq_mode_enq_count'];
                                                                                                 ?>
                                                                                                 <tr>
                                                                                                      <th style="width:50%"><?php echo $value['cmd_title'];?>:</th>
                                                                                                      <td><?php echo $value['enq_mode_enq_count'];?></td>
                                                                                                 </tr>
                                                                                            <?php }?>
                                                                                            <tr>
                                                                                                 <th>Total:</th>
                                                                                                 <td><?php echo $sum;?></td>
                                                                                            </tr>
                                                                                       </tbody>
                                                                                  </table>
                                                                             </div>
                                                                             <div class="clearfix"></div>
                                                                        </div>
                                                                   </div>
                                                              </div>
                                                         <?php } if (isset($dar['hwc']) && !empty($dar['hwc'])) {?>
                                                              <div class="col-md-4 col-sm-4 col-xs-12">
                                                                   <div class="x_panel">
                                                                        <div class="x_title">
                                                                             <h2><i class="glyphicon glyphicon-dashboard" aria-hidden="true"></i> Status</h2></h2>
                                                                             <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="x_content">
                                                                             <div class="table-responsive">
                                                                                  <table class="table">
                                                                                       <tbody>
                                                                                            <?php
                                                                                            $sum = 0;
                                                                                            foreach ($dar['hwc'] as $key => $value) {
                                                                                                 $sum += $value['enq_cus_when_buy_count'];
                                                                                                 ?>
                                                                                                 <tr>
                                                                                                      <th style="width:50%">
                                                                                                           <?php
                                                                                                           echo isset($hwcStatus[$value["enq_cus_when_buy"]]) ?
                                                                                                                   $hwcStatus[$value["enq_cus_when_buy"]] : '';
                                                                                                           ?>
                                                                                                           :</th>
                                                                                                      <td><?php echo $value['enq_cus_when_buy_count'];?></td>
                                                                                                 </tr>
                                                                                            <?php }?>
                                                                                            <tr>
                                                                                                 <th>Total:</th>
                                                                                                 <td><?php echo $sum;?></td>
                                                                                            </tr>
                                                                                       </tbody>
                                                                                  </table>
                                                                             </div>
                                                                             <div class="clearfix"></div>
                                                                        </div>
                                                                   </div>
                                                              </div>
                                                         <?php } if (isset($dar['type']) && !empty($dar['type'])) {?>
                                                              <div class="col-md-4 col-sm-4 col-xs-12">
                                                                   <div class="x_panel">
                                                                        <div class="x_title">
                                                                             <h2><i class="glyphicon glyphicon-transfer" aria-hidden="true"></i> Type</h2>
                                                                             <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="x_content">
                                                                             <div class="table-responsive">
                                                                                  <table class="table">
                                                                                       <tbody>
                                                                                            <?php
                                                                                            $sum = 0;
                                                                                            $sbe = unserialize(VEHICLE_DETAILS_STATUS);
                                                                                            foreach ($dar['type'] as $key => $value) {
                                                                                                 $sum += $value['enq_cus_status_count'];
                                                                                                 ?>
                                                                                                 <tr>
                                                                                                      <th style="width:50%">
                                                                                                           <?php
                                                                                                           echo isset($sbe[$value["enq_cus_status"]]) ?
                                                                                                                   $sbe[$value["enq_cus_status"]] : '';
                                                                                                           ?>
                                                                                                           :</th>
                                                                                                      <td><?php echo $value['enq_cus_status_count'];?></td>
                                                                                                 </tr>
                                                                                            <?php }?>
                                                                                            <tr>
                                                                                                 <th>Total:</th>
                                                                                                 <td><?php echo $sum;?></td>
                                                                                            </tr>
                                                                                       </tbody>
                                                                                  </table>
                                                                             </div>
                                                                             <div class="clearfix"></div>
                                                                        </div>
                                                                   </div>
                                                              </div>
                                                         <?php }?>
                                                    </div> 
                                               </div>
                                          </div>
                                     </div>
                                <?php }?>
                              <?php if (isset($dar['followup']) && !empty($dar['followup'])) {?>
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="x_panel">
                                               <div class="x_title">
                                                    <h2><i class="fa fa-pencil-square-o"></i> Followups</h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                         <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                               </div>
                                               <div class="x_content">
                                                    <div class="form-group">
                                                         <div class="table-responsive">
                                                              <div class="form-group">
                                                                   <div class="table-responsive">
                                                                        <table class="table table-striped table-bordered ">
                                                                             <thead style="background-color: gray; color: white;">
                                                                                  <tr>
                                                                                       <?php echo check_permission('dar', 'verifydar') ? '<th></th>' : '';?>
                                                                                       <th>Vehicle</th>
                                                                                       <th>Customer</th>
                                                                                       <th>Mobile</th>
                                                                                       <th>Status</th>
                                                                                       <th>Next followup</th>
                                                                                       <th>Customer feedback</th>
                                                                                       <th>Next action plan</th>
                                                                                       <th>Remarks</th>
                                                                                  </tr>
                                                                             </thead>
                                                                             <tbody>
                                                                                  <?php
                                                                                  $follCount = count($dar['followup']);
                                                                                  $modes = unserialize(FOLLOW_UP_STATUS);
                                                                                  foreach ((array) $dar['followup'] as $key => $value) {
                                                                                       ?>
                                                                                       <tr data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($value['darf_enq']));?>">
                                                                                            <?php if (check_permission('dar', 'verifydar')) {?>
                                                                                                 <td class="details-control">
                                                                                                      <img src="images/details_open.png" class="btnOpenClose" style="cursor: pointer;"/>
                                                                                                 </td>
                                                                                            <?php }?>
                                                                                            <td class="trVOE"><?php echo $value['darf_vehicle_full_name'];?></td>
                                                                                            <td class="trVOE"><?php echo $value['darf_enq_customer'];?></td>
                                                                                            <td class="trVOE"><?php echo $value['darf_enq_mobile'];?></td>
                                                                                            <td class="trVOE"><?php echo isset($modes[$value['foll_status']]) ? $modes[$value['foll_status']] : '';?></td>

                                                                                            <td class="trVOE"><?php
                                                                                                 echo!empty($value['darf_next_foll_date']) ?
                                                                                                         date('j M Y', strtotime($value['darf_next_foll_date'])) : '';
                                                                                                 ?>
                                                                                            </td>
                                                                                            <td class="trVOE"><?php echo $value['darf_customer_feedback'];?></td>
                                                                                            <td class="trVOE"><?php echo $value['darf_next_foll_act_plan'];?></td>
                                                                                            <td class="trVOE"><?php echo $value['darf_foll_remark'];?></td>
                                                                                       </tr>
                                                                                       <?php
                                                                                       if (check_permission('dar', 'verifydar')) {
                                                                                            $folFooterColspan = 10;
                                                                                            ?>
                                                                                            <tr style="display: none;">
                                                                                                 <td colspan="9">
                                                                                                      <input req="<?php echo $value['foll_status'] == 1 ? 'true' : 'false';?>" class="form-control" type="text" 
                                                                                                             placeholder="Comments for teamlead"
                                                                                                             <?php echo $isVerifiedByTL ? 'readonly="true"' : '';?>
                                                                                                             value="<?php echo $value['darf_TL_comments']?>" name="foll_comments[<?php echo $value['darf_id']?>]"/>

                                                                                                      <?php if (is_roo_user() || $this->usr_grp == 'MG') {?>
                                                                                                           <input req="<?php echo $value['foll_status'] == 1 ? 'true' : 'false';?>" class="form-control" type="text" 
                                                                                                                  placeholder="Comments for manager" <?php echo $isVerifiedByMG ? 'readonly="true"' : '';?>
                                                                                                                  value="<?php echo $value['darf_MG_comments']?>" name="mgr_foll_comments[<?php echo $value['darf_id']?>]"/>
                                                                                                             <?php }?>
                                                                                                 </td>
                                                                                            </tr>
                                                                                            <?php
                                                                                       }
                                                                                  }
                                                                                  ?>
                                                                             <tfoot style="background-color: darkgreen; color: white;">
                                                                                  <tr>
                                                                                       <td align="center" colspan="<?php echo $folFooterColspan;?>">
                                                                                            <i class="fa fa-spinner"> TOTAL FOLLOWUP : <?php echo $follCount;?> </i>
                                                                                       </td>
                                                                                  </tr>
                                                                             </tfoot>
                                                                             </tbody>
                                                                        </table>
                                                                   </div>
                                                              </div>
                                                         </div>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>

                                <?php } if (isset($dar['td_mv']) && !empty($dar['td_mv'])) {?>
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="x_panel">
                                               <div class="x_title">
                                                    <h2><i class="fa fa-line-chart"></i> Followup data analysis</h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                         <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                               </div>
                                               <div class="x_content">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                         <div class="col-md-4 col-sm-4 col-xs-12">
                                                              <div class="x_panel">
                                                                   <div class="x_title">
                                                                        <h2><i class="fa fa-car" aria-hidden="true"></i> Test drive / home visit</h2>
                                                                        <div class="clearfix"></div>
                                                                   </div>
                                                                   <div class="x_content">
                                                                        <div class="table-responsive">
                                                                             <table class="table">
                                                                                  <tbody>
                                                                                       <?php
                                                                                       $sum = array_sum($dar['td_mv']['hv']) + array_sum($dar['td_mv']['td']);
                                                                                       if ($dar['td_mv']['hv'] > 0) {
                                                                                            ?>
                                                                                            <tr>
                                                                                                 <th style="width:50%">Home visit</th>
                                                                                                 <td><?php echo array_sum($dar['td_mv']['hv']);?></td>
                                                                                            </tr>
                                                                                       <?php } if ($dar['td_mv']['td'] > 0) {?>
                                                                                            <tr>
                                                                                                 <th style="width:50%">Test drive</th>
                                                                                                 <td><?php echo array_sum($dar['td_mv']['td']);?></td>
                                                                                            </tr>
                                                                                       <?php } if ($sum > 0) {?>
                                                                                            <tr>
                                                                                                 <th>Total:</th>
                                                                                                 <td><?php echo $sum;?></td>
                                                                                            </tr>
                                                                                       <?php }?>
                                                                                  </tbody>
                                                                             </table>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                   </div>
                                                              </div>
                                                         </div>
                                                    </div> 
                                               </div>
                                          </div>
                                     </div>
                                <?php }?>

                              <?php if (isset($dar['register']) && !empty($dar['register'])) {
                                     ?>
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="x_panel">
                                               <div class="x_title">
                                                    <h2><i class="fa fa-pencil-square-o"></i> Vehicle register</h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                         <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                               </div>
                                               <div class="x_content">
                                                    <div class="form-group">
                                                         <div class="table-responsive">
                                                              <div style="height: 300px; width: 100%;overflow-x: scroll;overflow-y: scroll;">
                                                                   <table class="table table-striped table-bordered ">
                                                                        <thead style="background-color: gray; color: white;">
                                                                             <tr>
                                                                                  <th>Customer</th>
                                                                                  <th>Mobile</th>
                                                                                  <th>Place</th>
                                                                                  <th>Mod of enq</th>
                                                                                  <!-- <th>Lead type</th> -->
                                                                                  <th>Vehicle</th>
                                                                                  <th>Remarks</th>
                                                                                  <th>Assigned by</th>
                                                                                  <th>Assigned to</th>
                                                                             </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                             <?php
                                                                             $modOfContact = unserialize(MODE_OF_CONTACT);
//                                                                             $type = unserialize(CALL_TYPE);
                                                                             foreach ((array) $dar['register'] as $key => $value) {
                                                                                  $vehicle = '';
                                                                                  if ($value['vreg_inquiry'] > 0) {
                                                                                       $vehicle = $this->reports->getVehicleDetails($value['vreg_inquiry']);
                                                                                  }
                                                                                  ?>
                                                                                  <tr>
                                                                                       <td><?php echo $value['dvr_cust_name'];?></td>
                                                                                       <td><?php echo $value['dvr_cust_phone'];?></td>
                                                                                       <td><?php echo $value['dvr_cust_place'];?></td>
                                                                                       <td><?php echo isset($modOfContact[$value['dvr_contact_mode']]) ? $modOfContact[$value['dvr_contact_mode']] : '';?></td>
                                                                                       <!--<td><?php //echo isset($type[$value['vreg_call_type']]) ? $type[$value['vreg_call_type']] : ''; ?></td>-->
                                                                                       <td><?php echo $vehicle;?></td>
                                                                                       <td><?php echo $value['dvr_customer_remark'];?></td>

                                                                                       <td><?php echo $value['addedby_usr_first_name'] . ' ' . $value['addedby_usr_last_name'];?></td>
                                                                                       <td><?php echo $value['assign_usr_first_name'] . ' ' . $value['assign_usr_last_name'];?></td>
                                                                                  </tr>
                                                                             <?php }?>
                                                                        <tfoot style="background-color: darkgreen; color: white;">
                                                                             <tr>
                                                                                  <td align="center" colspan="8" >
                                                                                       <i class="fa fa-spinner"> TOTAL REGISTRATION : <?php echo count($dar['register'])?> </i>
                                                                                  </td>
                                                                             </tr>
                                                                        </tfoot>
                                                                   </table>
                                                              </div>
                                                         </div>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                <?php } if (isset($dar['registerFolls']) && !empty($dar['registerFolls'])) {
                                     ?>
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="x_panel">
                                               <div class="x_title">
                                                    <h2><i class="fa fa-pencil-square-o"></i> Register followup</h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                         <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                               </div>
                                               <div class="x_content">
                                                    <div class="form-group">
                                                         <div class="table-responsive">
                                                              <div style="height: 300px; width: 100%;overflow-x: scroll;overflow-y: scroll;">
                                                                   <table class="table table-striped table-bordered ">
                                                                        <thead style="background-color: gray; color: white;">
                                                                        <tr>
                                                                             <th>Vehicle</th>
                                                                             <th>Customer</th>
                                                                             <th>Mobile</th>
                                                                             <th>Next followup</th>
                                                                             <th>Followup comment</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                             <?php
                                                                             foreach ((array) $dar['registerFolls'] as $rfkey => $rfvalue) { ?>
                                                                                  <tr>
                                                                                       <td><?php echo $rfvalue['darrf_vehicle_full_name'];?></td>
                                                                                       <td><?php echo $rfvalue['darrf_customer'];?></td>
                                                                                       <td><?php echo $rfvalue['darrf_mobile'];?></td>
                                                                                       <td><?php echo $rfvalue['darrf_next_foll_date'];?></td>
                                                                                       <td><?php echo $rfvalue['regf_desc'];?></td>
                                                                                  </tr>
                                                                             <?php }?>
                                                                        <tfoot style="background-color: darkgreen; color: white;">
                                                                             <tr>
                                                                                  <td align="center" colspan="5">
                                                                                       <i class="fa fa-spinner"> TOTAL REGISTRATION : <?php echo count($dar['registerFolls'])?> </i>
                                                                                  </td>
                                                                             </tr>
                                                                        </tfoot>
                                                                   </table>
                                                              </div>
                                                         </div>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                <?php } if ($this->usr_grp == 'AC') {?>

                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="x_panel">
                                               <div class="x_title">
                                                    <h2><i class="fa fa-pencil-square-o"></i> Petty cash and expense</h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                         <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                               </div>
                                               <div class="x_content">
                                                    <table class="table">
                                                         <thead>
                                                              <tr>
                                                                   <th>Balance C/F</th>
                                                                   <th>Income</th>
                                                                   <th>Expense</th>
                                                              </tr>
                                                         </thead>
                                                         <tbody>
                                                              <tr>
                                                                   <td><h3><?php echo isset($dar['account']['acc_bal_CF']) ? $dar['account']['acc_bal_CF'] : '';?></h3></td>
                                                                   <td><h3 class="green"><?php echo isset($dar['account']['acc_dr']) ? $dar['account']['acc_dr'] : '';?></h3></td>
                                                                   <td><h3 class="red"><?php echo isset($dar['account']['acc_cr']) ? $dar['account']['acc_cr'] : '';?></h3></td>
                                                              </tr>
                                                              <tr>
                                                                   <td>
                                                                        Narration
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <?php echo isset($dar['account']['acc_narration']) ? $dar['account']['acc_narration'] : '';?>
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="3">
                                                                        <input class="form-control" type="hidden" name="accounts[acc_id]" value="<?php echo isset($dar['account']['acc_id']) ? $dar['account']['acc_id'] : '';?>"/>
                                                                        <input class="form-control" type="text" placeholder="Comments for teamlead" 
                                                                               value="<?php echo isset($dar['account']['acc_TL_comments']) ? $dar['account']['acc_TL_comments'] : '';?>" 
                                                                               name="accounts[acc_TL_comments]" <?php echo $isVerifiedByTL ? 'readonly="true"' : '';?>/>
                                                                   </td>
                                                              </tr>
                                                              <?php if (is_roo_user() || $this->usr_grp == 'MG') {?>
                                                                   <tr>
                                                                        <td colspan="3">
                                                                             <input value="<?php echo isset($dar['account']['acc_MG_comments']) ? $dar['account']['acc_MG_comments'] : '';?>" 
                                                                                    class="form-control" type="text" placeholder="Comments for manager" name="accounts[acc_MG_comments]"/>
                                                                        </td>
                                                                   </tr>
                                                              <?php }?>
                                                         </tbody>
                                                    </table>
                                               </div>
                                          </div>
                                     </div>
                                <?php }?>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                   <div class="x_panel">
                                        <div class="x_title">
                                             <h2><i class="fa fa-pencil-square-o"></i> Other</h2>
                                             <ul class="nav navbar-right panel_toolbox">
                                                  <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                             </ul>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                             <div class="form-group">
                                                  <div class="table-responsive">
                                                       <div class="form-group">
                                                            <label  class="control-label col-md-3 col-sm-3 col-xs-12">Participate DOMM</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <?php echo ($dar['darm_is_participate_DOMM'] == 1) ? "YES" : "NO";?>
                                                            </div>
                                                       </div>
                                                       <?php if (!empty($dar['darm_challenges'])) {?>
                                                              <div class="form-group">
                                                                   <label  class="control-label col-md-3 col-sm-3 col-xs-12">Challenges</label>
                                                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <?php echo $dar['darm_challenges'];?>
                                                                   </div>
                                                              </div>
                                                         <?php } if (!empty($dar['darm_pending'])) {?>
                                                              <div class="form-group">
                                                                   <label  class="control-label col-md-3 col-sm-3 col-xs-12">Pending</label>
                                                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <?php echo $dar['darm_pending'];?>
                                                                   </div>
                                                              </div>
                                                         <?php } if (!empty($dar['darm_remarks'])) {?>
                                                              <div class="form-group">
                                                                   <label  class="control-label col-md-3 col-sm-3 col-xs-12">Other Remarks</label>
                                                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <?php echo $dar['darm_remarks'];?>
                                                                   </div>
                                                              </div>
                                                         <?php }?>
                                                  </div>
                                                  <?php
                                                    if (check_permission('dar', 'verifydar')) {
                                                         //if ($this->usr_grp == 'TL') {
                                                              ?>
                                                              <div class="ln_solid"></div>
                                                              <div class="form-group">
                                                                   <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                                   </div>
                                                              </div>
                                                         <?php //} else {?>
                                                              <div class="form-group">
                                                                   <label for="enq_cus_test_drive" class="control-label col-md-3 col-sm-3 col-xs-12">Is verified</label>
                                                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <?php $darId = $dar['darm_id']?>
                                                                        <input <?php echo $dar['darm_is_verified'] == 1 ? 'checked="true" disabled' : '';?> 
                                                                             data-url="<?php echo site_url('dar/verifyDARajax/' . $darId);?>" type="checkbox" 
                                                                             class="js-switch chkCommon" name="darm_is_verified" value="1"/>
                                                                   </div>
                                                              </div>
                                                              <?php
                                                         //}
                                                    }
                                                  ?>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                    </form>
               </div>
          </div>
     </div>
</div>

<style>
     .table>thead>tr>th {
          white-space: nowrap;
          width: 1%;
     }
     .table>tbody>tr>td {
          white-space: nowrap;
          width: 1%;
     }
</style>