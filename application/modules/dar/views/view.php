<?php $folFooterColspan = 9;?>
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
                    <form action="<?php echo site_url('dar/verifydar');?>" method="post" class="verifyTeamDAR">
                         <input type="hidden" name="darm_added_by" value="<?php echo $dar['darm_added_by'];?>"/>
                         <input type="hidden" name="darm_id" value="<?php echo $dar['darm_id'];?>"/>
                         <div class="form-horizontal form-label-left">
                              <?php if (isset($dar['enquiry']) && !empty($dar['enquiry'])) {?>
                                     <div class="form-group">
                                          <h4>
                                               <?php if (check_permission('dar', 'verifydar')) {?>
                                                    <small class="red">Please enter comments for all enquiry</small>
                                               <?php }?>
                                          </h4>
                                          <div class="col-md-12 col-sm-12 col-xs-12">
                                               <div class="x_panel">
                                                    <div class="x_title">
                                                         <h2><i class="glyphicon glyphicon-list-alt"></i> Inquiry report on 
                                                              <?php echo isset($dar['darm_added_on']) ? date('j M Y', strtotime($dar['darm_added_on'])) : '';?>
                                                         </h2>
                                                         <ul class="nav navbar-right panel_toolbox">
                                                              <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                                         </ul>
                                                         <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content">
                                                         <div class="form-group">
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
                                                                             $enqFooterColspan = 5;
                                                                             $modOfContact = unserialize(MODE_OF_CONTACT);
                                                                             $hwcStatus = unserialize(ENQUIRY_UP_STATUS);
                                                                             $enqCount = count($dar['enquiry']);
                                                                             $hwc = array();

                                                                             foreach ((array) $dar['enquiry'] as $key => $value) {
                                                                                  $hwc[$value['dare_enq_status']] = isset($hwc[$value['dare_enq_status']]) ? $hwc[$value['dare_enq_status']] : '';
                                                                                  $hwc[$value['dare_enq_status']] = $hwc[$value['dare_enq_status']] + 1;
                                                                                  ?>
                                                                                  <tr data-url="<?php echo site_url('enquiry/printTrackCard/' . encryptor($value['dare_enq']));?>">
                                                                                       <?php if (check_permission('dar', 'verifydar')) {?>
                                                                                            <td class="details-control">
                                                                                                 <img src="images/details_open.png" class="btnOpenClose" style="cursor: pointer;"/>
                                                                                            </td>
                                                                                       <?php }?>
                                                                                       <td class="trVOE"><?php echo strtoupper($value['dare_enq_customer']);?></td>
                                                                                       <td class="trVOE"><?php echo $value['dare_enq_mobile'];?></td>
                                                                                       <td class="trVOE"><?php echo $value["cmd_title"];?></td>
                                                                                       <td class="trVOE"><?php echo isset($hwcStatus[$value["enq_cus_when_buy"]]) ? $hwcStatus[$value["enq_cus_when_buy"]] : '';?></td>
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
                                                                                       <td style="width: 150px;"><?php echo number_format($value['dare_expected_amount'], 2);?></td>
                                                                                  </tr> 
                                                                                  <?php
                                                                                  if (check_permission('dar', 'verifydar')) {
                                                                                       $enqFooterColspan = 6;
                                                                                       ?>
                                                                                       <tr style="display: none;">
                                                                                            <td colspan="7">
                                                                                                 <input req="true" class="form-control" type="text" readonly="true"
                                                                                                        value="<?php echo $value['dare_TL_comments']?>" name="enq_comments[<?php echo $value['dare_enq']?>]"/>
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
                                                                                  <td>
                                                                                       Total : <i class="fa fa-inr lblDARExpectedTotal"> <?php echo number_format($dar['darm_expec_revenue'], 2);?> /-</i>
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
                                     </div>
                                <?php }?>
                              <?php
                                $darmmodOfContact = !empty($dar['darm_cnt_mod']) ? unserialize($dar['darm_cnt_mod']) : array();
                                $darmStatus = !empty($dar['darm_cnt_status']) ? unserialize($dar['darm_cnt_status']) : array();
                                $modType = !empty($dar['darm_cnt_mod']) ? unserialize($dar['darm_cnt_mod']) : array();

                                if (!empty($darmmodOfContact) || !empty($darmStatus) || !empty($modType)) {
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
                                                         <?php if (!empty($darmmodOfContact)) {?>
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
                                                                                            foreach ($darmmodOfContact as $key => $value) {
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
                                                         <?php } if (!empty($darmStatus)) {?>
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
                                                                                            foreach ($darmStatus as $key => $value) {
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
                                                         <?php } if (!empty($modType)) {
                                                              ?>
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
                                                                                            foreach ($modType as $key => $value) {
                                                                                                 $sum += $value['enq_mode_enq_count'];
                                                                                                 ?>
                                                                                                 <tr>
                                                                                                      <th style="width:50%">
                                                                                                           <?php
                                                                                                           echo $value["cmd_title"];
                                                                                                           ?>
                                                                                                           :</th>
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
                                                    <h2><i class="fa fa-pencil-square-o"></i>Followup</h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                         <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                               </div>
                                               <div class="x_content">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                         <h4>Followup</h4>
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
                                                                             $type = $value['veh_status'] == 1 ? 's' : 'b';
                                                                             ?>
                                                                             <tr data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($value['veh_enq_id']) . '/' . encryptor($value['veh_id']) . '/' . $type);?>">
                                                                                  <?php if (check_permission('dar', 'verifydar')) {?>
                                                                                       <td class="details-control">
                                                                                            <img src="images/details_open.png" class="btnOpenClose" style="cursor: pointer;"/>
                                                                                       </td>
                                                                                  <?php }?>
                                                                                  <td class="trVOE">
                                                                                       <?php echo $vehFullname = $value['brd_title'] . ',' . $value['mod_title'] . ',' . $value['var_variant_name'];?>
                                                                                  </td>
                                                                                  <td class="trVOE"><?php echo strtoupper($value['darf_enq_customer']);?></td>
                                                                                  <td class="trVOE"><?php echo $value['darf_enq_mobile'];?></td>

                                                                                  <td class="trVOE">
                                                                                       <?php echo isset($hwcStatus[$value["foll_status"]]) ? $hwcStatus[$value["foll_status"]] : '';?>
                                                                                  </td>
                                                                                  <td class="trVOE"><?php echo ((strtotime($value['foll_next_foll_date']) > 0) && !empty($value['foll_next_foll_date'])) ?
                                                                                   date('j M Y', strtotime($value['foll_next_foll_date'])) : '';?></td>
                                                                                  <td class="trVOE"><?php echo $value['foll_customer_feedback'];?></td>
                                                                                  <td class="trVOE"><?php echo $actionPlan = $value['foll_action_plan'];?></td>
                                                                                  <td class="trVOE"><?php echo $remark = $value['foll_remarks'];?></td>
                                                                             </tr>
                                                                             <?php
                                                                             if (check_permission('dar', 'verifydar')) {
                                                                                  $folFooterColspan = 10;
                                                                                  ?>
                                                                                  <tr style="display: none;">
                                                                                       <td colspan="8">
                                                                                            <input req="<?php echo $value['foll_status'] == 1 ? 'true' : 'false';?>" 
                                                                                                   value="<?php echo $value['darf_TL_comments']?>" readonly="true"
                                                                                                   class="form-control" type="text" name="foll_comments[<?php echo $value['darf_followup']?>]"/>
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
                                <?php }?>
                              <?php
                                $hvtd = !empty($dar['darm_cnt_td_mv']) ? unserialize($dar['darm_cnt_td_mv']) : array();
                                if (!empty($hvtd)) {
                                     ?>
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
                                                         <?php if (!empty($hvtd)) {?>
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
                                                         <?php }?>
                                                    </div> 
                                               </div>
                                          </div>
                                     </div>
                                <?php }?>
                              <?php if (isset($dar['register']) && !empty($dar['register'])) {?>
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="x_panel">
                                               <div class="x_title">
                                                    <h2><i class="fa fa-pencil-square-o"></i> Register</h2>
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
                                                                             <th>Remarks</th>
                                                                        </tr>
                                                                   </thead>
                                                                   <tbody>
                                                                        <?php
                                                                        foreach ((array) $dar['register'] as $key => $value) {
                                                                             ?>
                                                                             <tr data-url="">
                                                                                  <td class="trVOE"><?php echo $value['dvr_cust_name'];?></td>
                                                                                  <td class="trVOE"><?php echo $value['dvr_cust_phone'];?></td>
                                                                                  <td class="trVOE"><?php echo $value['dvr_cust_place'];?></td>
                                                                                  <td class="trVOE"><?php echo $value['cmd_title'];?></td>
                                                                                  <td class="trVOE"><?php echo $value['dvr_customer_remark'];?></td>
                                                                             </tr>
                                                                        <?php }?>
                                                                   <tfoot style="background-color: darkgreen; color: white;">
                                                                        <tr>
                                                                             <td align="center" colspan="8" >
                                                                                  <i class="fa fa-spinner"> TOTAL REGISTRATION : <?php echo count($dar['register'])?> </i></td>
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
                                                         </tbody>
                                                    </table>
                                               </div>
                                          </div>
                                     </div>
                              <?php }?>
                              <?php if (isset($dar['registerFolls']) && !empty($dar['registerFolls'])) {?>
                                     <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="x_panel">
                                               <div class="x_title">
                                                    <h2><i class="fa fa-pencil-square-o"></i>Register Followup</h2>
                                                    <ul class="nav navbar-right panel_toolbox">
                                                         <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                               </div>
                                               <div class="x_content">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                         <h4>Followup</h4>
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
                                                                        <?php
                                                                        foreach ((array) $dar['registerFolls'] as $key => $value) {
                                                                             ?>
                                                                             <tr data-url="<?php echo site_url('registration/view/' . encryptor($value['darrf_reg_id']));?>">
                                                                                  <td class="trVOE"><?php echo $value['darrf_vehicle_full_name']; ?></td>
                                                                                  <td class="trVOE"><?php echo $value['darrf_customer']; ?></td>
                                                                                  <td class="trVOE"><?php echo $value['darrf_mobile']; ?></td>
                                                                                  <td class="trVOE"><?php echo $value['darrf_next_foll_date']; ?></td>
                                                                                  <td class="trVOE"><?php echo $value['darrf_foll_comment']; ?></td>
                                                                             </tr>
                                                                           <?php
                                                                        }
                                                                   ?>
                                                                   <tfoot style="background-color: darkgreen; color: white;">
                                                                        <tr>
                                                                             <td align="center" colspan="5">
                                                                                  <i class="fa fa-spinner"> TOTAL REGISTER FOLLOWUP : <?php echo count($dar['registerFolls']);?> </i>
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
                                <?php }?>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                   <div class="x_panel">
                                        <div class="x_title">
                                             <h2><i class="fa fa-pencil-square-o"></i> Others</h2>
                                             <ul class="nav navbar-right panel_toolbox">
                                                  <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                             </ul>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                             <?php if (!empty($dar['darm_challenges'])) {?>
                                                    <div class="form-group">
                                                         <h4>Challenges</h4>
                                                         <label  class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                              <?php echo $dar['darm_challenges'];?>
                                                         </div>
                                                    </div>
                                               <?php } if (!empty($dar['darm_pending'])) {?>
                                                    <div class="form-group">
                                                         <h4>Pending</h4>
                                                         <label  class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                              <?php echo $dar['darm_pending'];?>
                                                         </div>
                                                    </div>
                                               <?php } if (!empty($dar['darm_remarks'])) {?>
                                                    <div class="form-group">
                                                         <h4>Other Remarks</h4>
                                                         <label  class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                              <?php echo $dar['darm_remarks'];?>
                                                         </div>
                                                    </div>
                                               <?php } if (is_roo_user() || $this->usr_grp == 'MG') {?>
                                                    <div class="form-group">
                                                         <label for="enq_cus_test_drive" class="control-label col-md-3 col-sm-3 col-xs-12">Is verified</label>
                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                              <?php $darId = $dar['darm_id']?>
                                                              <input <?php echo $dar['darm_is_verified'] == 1 ? 'checked="true"' : '';?> 
                                                                   data-url="<?php echo site_url('dar/verifyDAR/' . $darId);?>" type="checkbox" 
                                                                   class="js-switch chkCommon" name="darm_is_verified" value="1"/>
                                                         </div>
                                                    </div>
                                               <?php }?>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <?php if ($this->usr_grp == 'MG' || $this->usr_grp == 'TL') {?>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                     <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                          <button type="submit" class="btn btn-success">Submit</button>
                                     </div>
                                </div>    
                         <?php }?>
                    </form>
               </div>
          </div>
     </div>
</div>