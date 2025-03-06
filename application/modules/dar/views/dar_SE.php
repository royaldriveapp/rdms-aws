<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Daily Assessment Report <?php echo date('j M Y')?> of <?php echo $this->session->userdata('usr_username');?></h2>
                         <div class="clearfix"></div>
                    </div>
                    <form class="form-horizontal form-label-left frmDAR" action="<?php echo site_url('dar/processDar');?>" method="post"
                          onsubmit="$('.btnDARSubmit').prop('disabled', true);">
                         <input type="hidden" name="master[darm_showroom]" value="<?php echo $this->shrm;?>"/>
                         <input type="hidden" name="master[darm_added_by]" value="<?php echo $this->uid;?>"/>
                         <?php if (isset($todaysEnquires['inquires'])) {?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                     <div class="x_panel">
                                          <div class="x_title">
                                               <h2><i class="glyphicon glyphicon-list-alt"></i> Today's inquiry
                                               
                                             </h2>
                                               <ul class="nav navbar-right panel_toolbox">
                                                    <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                               </ul>
                                               <div class="clearfix"></div>
                                          </div>
                                          <div class="x_content">
                                               <div class="form-group">
                                                    <div class="table-responsive">
                                                         <table class="table table-striped table-bordered ">
                                                              <thead style="background-color: grey; color: white;">
                                                                   <tr>
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
                                                                   $modOfContact = unserialize(MODE_OF_CONTACT);
                                                                   $hwcStatus = unserialize(ENQUIRY_UP_STATUS);
                                                                   $hwc = array();
                                                                   $enqCount = count($todaysEnquires['inquires']);
                                                                   foreach ($todaysEnquires['inquires'] as $key => $value) {
                                                                        $hwc[$value['enq_cus_when_buy']] = isset($hwc[$value['enq_cus_when_buy']]) ?
                                                                                $hwc[$value['enq_cus_when_buy']] : '';
                                                                        $hwc[$value['enq_cus_when_buy']] = $hwc[$value['enq_cus_when_buy']] + 1;
                                                                        ?>
                                                                        <tr data-url="<?php echo site_url('enquiry/printTrackCard/' . encryptor($value['enq_id']));?>">
                                                                             <td class="trVOE">
                                                                                  <?php echo strtoupper($value['enq_cus_name']);?>
                                                                                  <input type="hidden" name="enquiry[<?php echo $key;?>][dare_enq]" value="<?php echo $value['enq_id'];?>"/>
                                                                                  <input type="hidden" name="enquiry[<?php echo $key;?>][dare_enq_customer]" value="<?php echo $value['enq_cus_name'];?>"/>
                                                                                  <input type="hidden" name="enquiry[<?php echo $key;?>][dare_cus_when_buy]" value="<?php echo $value['enq_cus_when_buy'];?>"/>
                                                                                 <input type="hidden" name="enquiry[<?php echo $key;?>][dare_enq_current_status]" value="<?php echo $value['enq_current_status'];?>"/>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php echo $value['enq_cus_mobile'];?>
                                                                                  <input type="hidden" name="enquiry[<?php echo $key;?>][dare_enq_mobile]" value="<?php echo $value['enq_cus_mobile'];?>"/>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php echo $value["cmd_title"];?>
                                                                                  <input type="hidden" name="enquiry[<?php echo $key;?>][dare_enq_mode_enquiry]" value="<?php echo $value['enq_mode_enq'];?>"/>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php
                                                                                  echo isset($hwcStatus[$value["enq_cus_when_buy"]]) ?
                                                                                          $hwcStatus[$value["enq_cus_when_buy"]] : '';
                                                                                  ?>
                                                                                  <input type="hidden" name="enquiry[<?php echo $key;?>][dare_enq_status]" value="<?php echo $value['enq_cus_when_buy'];?>"/>
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
                                                                                  <input required="true" class="form-control col-md-5 col-xs-12 numOnly txtDARExpectedAmt" type="text" name="enquiry[<?php echo $key;?>][dare_expected_amount]">
                                                                             </td>
                                                                        </tr> 
                                                                   <?php }?>
                                                              </tbody>
                                                              <tfoot style="background-color: darkgreen; color: white;">
                                                                   <tr>
                                                                        <td align="center" colspan="5" ><i class="fa fa-spinner"> TOTAL ENQUIRY : <?php echo $enqCount;?> </i></td>
                                                                        <td>
                                                                             TOTAL : <i class="fa fa-inr lblDARExpectedTotal"> 0.00 /-</i>
                                                                             <input class="txtDarmExpecRevenue" type="hidden" name="master[darm_expec_revenue]"/> 
                                                                        </td>
                                                                   </tr>
                                                              </tfoot>
                                                         </table>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                </div>
                           <?php }?>
                         <!-- -->
                         <?php
                           if ((isset($todaysEnquires['mod_of_contact']) && !empty($todaysEnquires['mod_of_contact'])) ||
                                   (isset($todaysEnquires['hwc']) && !empty($todaysEnquires['hwc'])) ||
                                   (isset($todaysEnquires['type']) && !empty($todaysEnquires['type']))) {
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
                                                    <?php if (isset($todaysEnquires['mod_of_contact']) && !empty($todaysEnquires['mod_of_contact'])) {?>
                                                         <input type="hidden" name="master[darm_cnt_mod]" value='<?php echo serialize($todaysEnquires['mod_of_contact']);?>'/>     
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
                                                                                       foreach ($todaysEnquires['mod_of_contact'] as $key => $value) {
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
                                                    <?php } if (isset($todaysEnquires['hwc']) && !empty($todaysEnquires['hwc'])) {?>
                                                         <input type="hidden" name="master[darm_cnt_status]" value='<?php echo serialize($todaysEnquires['hwc']);?>'/>
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
                                                                                       foreach ($todaysEnquires['hwc'] as $key => $value) {
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
                                                    <?php } if (isset($todaysEnquires['type']) && !empty($todaysEnquires['type'])) {?>
                                                         <input type="hidden" name="master[darm_cnt_type]" value='<?php echo serialize($todaysEnquires['type']);?>'/>
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
                                                                                       foreach ($todaysEnquires['type'] as $key => $value) {
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
                         <!-- -->
                         <?php if (isset($todaysFollowups)) {?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                     <div class="x_panel">
                                          <div class="x_title">
                                               <h2><i class="fa fa-pencil-square-o"></i> Today's followup</h2>
                                               <ul class="nav navbar-right panel_toolbox">
                                                    <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                               </ul>
                                               <div class="clearfix"></div>
                                          </div>
                                          <div class="x_content">
                                               <div class="form-group">
                                                    <div class="table-responsive">
                                                         <table class="table table-striped table-bordered ">
                                                              <thead style="background-color: gray; color: white;">
                                                                   <tr>
                                                                        <th>Vehicle</th>
                                                                        <th>Customer</th>
                                                                        <th>Mobile</th>
                                                                        <th>Status</th>
                                                                        <th>Next followup</th>
                                                                        <th>Customer feedback</th>
                                                                        <th>Next action plan</th>
                                                                        <th>Test drive</th>
                                                                        <th>Home visit</th>
                                                                        <th>Remarks</th>
                                                                   </tr>
                                                              </thead>
                                                              <tbody>
                                                                   <?php
                                                                   $hvtd = array();
                                                                   foreach ((array) $todaysFollowups as $key => $value) {
                                                                        $followDate = $this->followup->getLatestFollowupDate($value['enq_id'], 'd-m-Y');
                                                                        if (!isset($hvtd['hv'][$value['enq_id']])) {
                                                                             $hvtd['hv'][$value['enq_id']] = $value['enq_cus_home_visit'];
                                                                        }

                                                                        if (!isset($hvtd['td'][$value['enq_id']])) {
                                                                             $hvtd['td'][$value['enq_id']] = $value['enq_cus_test_drive'];
                                                                        }
                                                                        ?>
                                                                        <tr data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($value['enq_id']));?>">
                                                                             <td class="trVOE">
                                                                                  <?php echo $vehFullname = $value['brd_title'] . ',' . $value['mod_title'] . ',' . $value['var_variant_name'];?>
                                                                                  <input type="hidden" name="followup[<?php echo $key;?>][darf_vehicle]" value="<?php echo $value['veh_id'];?>"/>
                                                                                  <input type="hidden" name="followup[<?php echo $key;?>][darf_vehicle_full_name]" value="<?php echo $vehFullname;?>"/>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php echo strtoupper($value['enq_cus_name']);?>
                                                                                  <input type="hidden" name="followup[<?php echo $key;?>][darf_enq]" value="<?php echo $value['veh_enq_id'];?>"/>
                                                                                  <input type="hidden" name="followup[<?php echo $key;?>][darf_enq_customer]" value="<?php echo $value['enq_cus_name'];?>"/>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php echo $value['enq_cus_mobile'];?>
                                                                                  <input type="hidden" name="followup[<?php echo $key;?>][darf_enq_mobile]" value="<?php echo $value['enq_cus_mobile'];?>"/>
                                                                             </td>

                                                                             <td class="trVOE">
                                                                                  <?php echo isset($hwcStatus[$value["foll_status"]]) ? $hwcStatus[$value["foll_status"]] : '';?>
                                                                             </td>
                                                                             <td class="trVOE"><?php echo $followDate;?>
                                                                                  <input type="hidden" name="followup[<?php echo $key;?>][darf_followup]" value="<?php echo $value['foll_id'];?>"/>
                                                                                  <input type="hidden" name="followup[<?php echo $key;?>][darf_next_foll_date]" value="<?php
                                                                                  echo (isset($value['nextFollowup']['foll_next_foll_date']) && !empty($value['nextFollowup']['foll_next_foll_date'])) ?
                                                                                          $value['nextFollowup']['foll_next_foll_date'] : $value['foll_next_foll_date'];
                                                                                  ?>"/>
                                                                             </td>
                                                                             <td class="trVOE"><?php echo $value['foll_customer_feedback'];?>
                                                                                  <input type="hidden" name="followup[<?php echo $key;?>][darf_customer_feedback]" value="<?php echo $value['foll_customer_feedback'];?>"/>
                                                                             </td>
                                                                             <td class="trVOE"><?php echo $actionPlan = $value['foll_action_plan'];?>
                                                                                  <input type="hidden" name="followup[<?php echo $key;?>][darf_next_foll_act_plan]" value="<?php echo $actionPlan;?>"/>
                                                                             </td>

                                                                             <td>
                                                                                  <?php
                                                                                  echo ($value['enq_cus_test_drive'] == 1) ? '<i class="glyphicon glyphicon-ok green"></i>' :
                                                                                          '<i class="glyphicon glyphicon-remove green"></i>';
                                                                                  ?>
                                                                             </td>
                                                                             <td>
                                                                                  <?php
                                                                                  echo ($value['enq_cus_home_visit'] == 1) ? '<i class="glyphicon glyphicon-ok green"></i>' :
                                                                                          '<i class="glyphicon glyphicon-remove green"></i>';
                                                                                  ?>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php
                                                                                  echo $remark = $value['foll_remarks'];
                                                                                  ?>
                                                                                  <input type="hidden" name="followup[<?php echo $key;?>][darf_foll_remark]" value="<?php echo $remark;?>"/>
                                                                             </td>
                                                                        </tr>
                                                                   <?php }?>
                                                              <tfoot style="background-color: darkgreen; color: white;">
                                                                   <tr>
                                                                        <td align="center" colspan="10">
                                                                             <i class="fa fa-spinner"> TOTAL FOLLOWUP : <?php echo count($todaysFollowups)?> </i></td>
                                                                   </tr>
                                                              </tfoot>
                                                              </tbody>
                                                         </table>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                </div>
                                <?php } if (isset($todaysRegFollowup)) { ?>
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="x_panel">
                                               <div class="x_title">
                                                    <h2><i class="fa fa-pencil-square-o"></i> Today's register followup</h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                         <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                               </div>
                                               <div class="x_content">
                                                    <div class="form-group">
                                                         <div class="table-responsive">
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
                                                                        <?php foreach ((array) $todaysRegFollowup as $key => $value) {?>
                                                                             <tr>
                                                                                  <td>
                                                                                       <?php echo $vehFullname = $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name'];?>
                                                                                       <input type="hidden" name="regFollowup[<?php echo $key;?>][darrf_vehicle_full_name]" value="<?php echo $vehFullname;?>"/>
                                                                                       <input type="hidden" name="regFollowup[<?php echo $key;?>][darrf_fol_id]" value="<?php echo $value['regf_id'];?>"/>
                                                                                       <input type="hidden" name="regFollowup[<?php echo $key;?>][darrf_reg_id]" value="<?php echo $value['vreg_id'];?>"/>
                                                                                  </td>
                                                                                  <td>
                                                                                       <?php echo strtoupper($value['vreg_cust_name']);?>
                                                                                       <input type="hidden" name="regFollowup[<?php echo $key;?>][darrf_customer]" value="<?php echo $value['vreg_cust_name'];?>"/>
                                                                                  </td>
                                                                                  <td>
                                                                                       <?php echo $value['vreg_cust_phone'];?>
                                                                                       <input type="hidden" name="regFollowup[<?php echo $key;?>][darrf_mobile]" value="<?php echo $value['vreg_cust_phone'];?>"/>
                                                                                  </td>
                                                                                  <td><?php echo date('d-m-Y', strtotime($value['regf_next_folowup']));?>
                                                                                       <input type="hidden" name="regFollowup[<?php echo $key;?>][darrf_next_foll_date]" value="<?php echo $value['regf_next_folowup'];?>"/>
                                                                                  </td>
                                                                                  <td><?php echo $value['regf_desc'];?>
                                                                                       <input type="hidden" name="regFollowup[<?php echo $key;?>][darrf_foll_comment]" value="<?php echo $value['regf_desc'];?>"/>
                                                                                  </td>
                                                                             </tr>
                                                                        <?php }?>
                                                                   </tbody>
                                                                   <tfoot style="background-color: darkgreen; color: white;">
                                                                        <tr>
                                                                             <td align="center" colspan="5">
                                                                                  <i class="fa fa-spinner"> TOTAL FOLLOWUP : <?php echo count($todaysRegFollowup)?> </i></td>
                                                                        </tr>
                                                                   </tfoot>
                                                              </table>
                                                         </div>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                              <?php } if (isset($todaysRegistrations) && !empty($todaysRegistrations)) {?>
                                <div class="col-md-12 col-sm-12 col-xs-12" style="width: 100%;overflow-y: hidden;overflow-x: scroll;">
                                     <div class="x_panel">
                                          <div class="x_title">
                                               <h2><i class="fa fa-pencil-square-o"></i> Today's register</h2>
                                               <ul class="nav navbar-right panel_toolbox">
                                                    <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                               </ul>
                                               <div class="clearfix"></div>
                                          </div>
                                          <div class="x_content">
                                               <div class="form-group">
                                                    <div class="table-responsive">
                                                         <table class="table table-striped table-bordered ">
                                                              <thead style="background-color: gray; color: white;">
                                                                   <tr>
                                                                        <th>Customer</th>
                                                                        <th>Mobile</th>
                                                                        <th>Place</th>
                                                                        <th>Mod of enq</th>
                                                                        <th>Vehicle</th>
                                                                        <th>Remarks</th>
                                                                   </tr>
                                                              </thead>
                                                              <tbody>
                                                                   <?php
                                                                   $modOfContact = unserialize(MODE_OF_CONTACT);
                                                                   foreach ((array) $todaysRegistrations as $key => $value) {
                                                                        $vehicle = '';
                                                                        if (!empty($value['brd_title'])) {
                                                                             $vehicle = $value['brd_title'] . ',' . $value['mod_title'] . ',' . $value['var_variant_name'];
                                                                        } else if ($value['vreg_inquiry'] > 0) {
                                                                             $vehicle = $this->reports->getVehicleDetails($value['vreg_inquiry']);
                                                                        }
                                                                        $cmd = isset($value['regh_remarks']) ? $value['regh_remarks'] : '';
                                                                        $sysCmd = isset($value['regh_system_cmd']) ? $value['regh_system_cmd'] : '';
                                                                        ?>
                                                                        <tr d="<?php echo $value['vreg_id']; ?>" title="<?php echo $cmd .' - ' . $sysCmd;?>">
                                                                             <td class="trVOE">
                                                                                  <?php echo $value['vreg_cust_name'];?>
                                                                                  <input type="hidden" name="register[<?php echo $key;?>][dvr_register]" value="<?php echo $value['vreg_id'];?>"/>
                                                                                  <input type="hidden" name="register[<?php echo $key;?>][dvr_cust_name]" value="<?php echo $value['vreg_cust_name'];?>"/>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php echo $value['vreg_cust_phone'];?>
                                                                                  <input type="hidden" name="register[<?php echo $key;?>][dvr_cust_phone]" value="<?php echo $value['vreg_cust_phone'];?>"/>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php echo $value['vreg_cust_place'];?>
                                                                                  <input type="hidden" name="register[<?php echo $key;?>][dvr_cust_place]" value="<?php echo $value['vreg_cust_place'];?>"/>
                                                                             </td>
                                                                             <td class="trVOE">
                                                                                  <?php echo isset($modOfContact[$value['vreg_contact_mode']]) ? $modOfContact[$value['vreg_contact_mode']] : '';?>
                                                                                  <input type="hidden" name="register[<?php echo $key;?>][dvr_contact_mode]" value="<?php echo $value['vreg_contact_mode'];?>"/>
                                                                             </td>
                                                                             <td><?php echo $vehicle;?></td>
                                                                             <td class="trVOE">
                                                                                  <?php echo $vreg_customer_remark = str_replace('"=""', '', $value['vreg_customer_remark']);?>
                                                                                  <input type="hidden" name="register[<?php echo $key;?>][dvr_customer_remark]" value="<?php echo $vreg_customer_remark;?>"/>
                                                                             </td>
                                                                        </tr>
                                                                   <?php }?>
                                                              <tfoot style="background-color: darkgreen; color: white;">
                                                                   <tr>
                                                                        <td align="center" colspan="8" >
                                                                             <i class="fa fa-spinner"> TOTAL REGISTRATION : <?php echo count($todaysRegistrations)?> </i></td>
                                                                   </tr>
                                                              </tfoot>
                                                              </tbody>
                                                         </table>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                </div>
                           <?php }?> 
                         <?php if (isset($hvtd) && !empty($hvtd)) {?>
                                <input type="hidden" name="master[darm_cnt_td_mv]" value='<?php echo serialize($hvtd);?>'/>
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
                                                                                  $sum = array_sum($hvtd['hv']) + array_sum($hvtd['td']);
                                                                                  if ($hvtd['hv'] > 0) {
                                                                                       ?>
                                                                                       <tr>
                                                                                            <th style="width:50%">Home visit</th>
                                                                                            <td><?php echo array_sum($hvtd['hv']);?></td>
                                                                                       </tr>
                                                                                  <?php } if ($hvtd['td'] > 0) {?>
                                                                                       <tr>
                                                                                            <th style="width:50%">Test drive</th>
                                                                                            <td><?php echo array_sum($hvtd['td']);?></td>
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

                         <!-- Petty cash and expense -->
                         <?php if ($this->usr_grp == 'AC') {?>
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
                                               <div class="form-group">
                                                    <div class="table-responsive">
                                                         <div class="form-group">
                                                              <label for="enq_cus_test_drive" class="control-label col-md-3 col-sm-3 col-xs-12" style="padding-top: 0px;">Balance C/F</label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <input type="text" id="transliterateTextarea" required name="accounts[acc_bal_CF]" class="numOnly form-control col-md-5 col-xs-12" rows="2"/>
                                                              </div>
                                                         </div>
                                                         <div class="form-group">
                                                              <label  class="control-label col-md-3 col-sm-3 col-xs-12" style="padding-top: 0px;">Income</label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <input type="text" id="transliterateTextarea" required name="accounts[acc_dr]" class="numOnly form-control col-md-5 col-xs-12" rows="2"/>
                                                              </div>
                                                         </div>
                                                         <div class="form-group">
                                                              <label  class="control-label col-md-3 col-sm-3 col-xs-12" style="padding-top: 0px;">Expense</label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <input type="text" required name="accounts[acc_cr]" class="numOnly form-control col-md-5 col-xs-12"/>
                                                              </div>
                                                         </div>
                                                         <div class="form-group">
                                                              <label  class="control-label col-md-3 col-sm-3 col-xs-12">Narration</label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <textarea required name="accounts[acc_narration]" class="form-control col-md-5 col-xs-12 "></textarea>
                                                              </div>
                                                         </div>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                </div>
                           <?php }?>
                         <!-- Other -->
                        

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
                                                       <label for="enq_cus_test_drive" class="control-label col-md-3 col-sm-3 col-xs-12"
                                                              style="padding-top: 0px;">Is participate DOMM ?</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="checkbox" class="js-switch" name="master[darm_is_participate_DOMM]" value="1"/>
                                                       </div>
                                                  </div>
                                                  <div class="form-group">
                                                       <label  class="control-label col-md-3 col-sm-3 col-xs-12">Main Challenges</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea id="transliterateTextarea" required name="master[darm_challenges]" class="form-control col-md-5 col-xs-12" rows="2"></textarea>
                                                       </div>
                                                  </div>
                                                  <div class="form-group">
                                                       <label  class="control-label col-md-3 col-sm-3 col-xs-12">Pending works</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea required name="master[darm_pending]" class="form-control col-md-5 col-xs-12 "></textarea>
                                                       </div>
                                                  </div>
                                                  <div class="form-group">
                                                       <label  class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea required name="master[darm_remarks]" class="form-control col-md-5 col-xs-12 "></textarea>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success btnDARSubmit">Submit DAR</button>
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