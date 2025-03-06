<form id="demo-form2" method="post" data-parsley-validate class="form-horizontal form-label-left frmFollowUpFeedBack">
     <input type="hidden" name="quickfollowup" value="<?php echo isset($_GET['quickfollowup']) ? $_GET['quickfollowup'] : '';?>"/>
     <input type="hidden" name="cb" value="<?php echo isset($_GET['cb']) ? $_GET['cb'] : '';?>"/>
     <?php $enqId = isset($enqId) ? $enqId : 0;?>
     <input type="hidden" class="txtEnqId" name="foll_cus_id" value="<?php echo $enqId;?>"/>
     <input type="hidden" class="txtFollowupDate" value="<?php echo $date;?>"/>
     <input type="hidden" name="txtSalesOfficer" value="<?php echo $enquiry['enq_se_id'];?>"/>
     <input type="hidden" name="assignto" value="<?php echo isset($assignto) ? $assignto : '';?>"/>
     <input type="hidden" name="p" value="<?php echo isset($p) ? $p : '';?>"/>
     
     <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12">
               <div class="panel panel-default" style="float: left;width: 100%;">
                    <div class="panel-heading">Customer feedback on <?php echo date('d D M Y', strtotime($date));?> <span style="color: red;font-size: 10px;font-weight: bold;" class="alignright"> *Please enter at least one customer feedback</span></div>
                    <div class="panel-body">
                         <div class="divCustomerFeedBack">
                              <?php
                                if (!empty($followup)) {
                                     foreach ($followup as $key => $value) {
                                          ?>
                                          <div class="form-group">
                                               <label class="control-label col-md-6 col-sm-3 col-xs-12" style="text-align: left;" for="textarea">
                                                    <?php
                                                       $type = $value['veh_status'] == 1 ? 'Sales vehicle' : 'Purchase vehicle';
                                                       echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name'] . ' (' . $type . ')';
                                                    ?>
                                               </label>

                                               <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea min="20" min-msg="Please enter customer feedback at least 20 characters" required="required" name="foll_customer_feedback[<?php echo $value['foll_id'];?>]" class="form-control col-md-7 col-xs-12 text-left foll_customer_feedback 
                                                              foll_customer_feedback_<?php echo $value['foll_cus_vehicle_id'];?>"><?php echo $value['foll_customer_feedback'];?></textarea>
                                               </div>
                                          </div>
                                          <?php
                                     }
                                }
                              ?>
                              <div class="form-group">
                                   <label class="control-label col-md-6 col-sm-3 col-xs-12" style="text-align: left;" for="textarea"></label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label>
                                             <input class="chk chkCommon" data-url="<?php echo site_url('followup/changeTestDriveHomeVisit/' . encryptor($enqId) . '/' . encryptor('enq_cus_test_drive'));?>" 
                                             <?php echo (isset($enquiry['enq_cus_test_drive']) && $enquiry['enq_cus_test_drive'] == 1) ? "checked" : '';?>
                                                    type="checkbox" value="1"><span> Customer test drive?</span>
                                        </label>
                                        <label>
                                             Now you can set home visit, please choose home visit button on followup window.
                                             <!-- <input class="chk chkCommon" data-url="<?php //echo site_url('followup/changeTestDriveHomeVisit/' . encryptor($enqId) . '/' . encryptor('enq_cus_home_visit'));?>" 
                                             <?php //echo (isset($enquiry['enq_cus_home_visit']) && $enquiry['enq_cus_home_visit'] == 1) ? "checked" : '';?>
                                                    type="checkbox" value="1"> <span> Customer home visit?</span> -->
                                        </label>
                                   </div>
                                   <div class="col-md-12 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                             <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">Budget</label>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control cmbFollStatus" name="followup[foll_budget]" id="enq-status">
                                                       <option value="0">Select Budget Ranges</option>
                                                       <?php foreach ((array) $budgetRanges as $key => $value) { ?>
                                                            <option value="<?php echo $value['pr_id']; ?>"><?php echo $value['pr_range']; ?></option>
                                                       <?php } ?>
                                                  </select>
                                                  <input value="0" type="hidden" name="followup[foll_budget_from]"/>
                                                  <input value="0" type="hidden" name="followup[foll_budget_to]"/>
                                             </div>
                                             <!-- <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <input value="0" placeholder="Budget to" type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="followup[foll_budget_to]"/>
                                             </div> -->
                                        </div>
                                        
                                        <div class="form-group">
                                             <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">Model year</label>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <input value="0" placeholder="Model year from" type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="followup[foll_model_y_from]"/>
                                             </div>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <input value="0" placeholder="Model year to" type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="followup[foll_model_y_to]"/>
                                             </div>
                                        </div>
                                        
                                        <div class="form-group">
                                             <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">KM</label>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <input value="0" placeholder="KM from" type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="followup[foll_km_from]"/>
                                             </div>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <input value="0" placeholder="KM to" type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="followup[foll_km_to]"/>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <!-- -->
                         <?php
                           if (check_permission('followup', 'assignenquiresfromfollowup')) {
                                $active = isset($followup[0]['usr_active']) ? $followup[0]['usr_active'] : 0;
                                $registerdShowRoom = isset($latest['vreg_division']) ? $latest['vreg_division'] : 0;
                                //if ($active == 0) {
                                     ?>
                                     <div class="form-group">
                                          <label class="control-label col-md-6 col-sm-3 col-xs-12" style="text-align: left;"> 
                                               Refer this enquiry to other sales officer?
                                          </label>
                                          <div class="tmpRefer">
                                               <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group">
                                                         <div class="col-md-7 col-sm-6 col-xs-12">
                                                              <select class="select2_group form-control" name="salesOfficers" id="salesOfficers" required>
                                                                   <option value="">Select sales officer</option>
                                                                   <?php foreach ($salesExe as $key => $value) {?>
                                                                        <option value="<?php echo $value['usr_id'];?>"><?php echo $value['usr_username'];?></option>
                                                                   <?php }?>
                                                                        <option value="729">Ambily C S (Luxury)</option>
                                                              </select>
                                                         </div>
                                                    </div>

                                                    <div class="form-group">
                                                         <div class="col-md-7 col-sm-6 col-xs-12">
                                                              <textarea name="remark" required class="form-control col-md-7 col-xs-12" placeholder="Reson for re-assign enquires"></textarea>
                                                         </div>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                     <?php } else if(check_permission('followup', 'asgnenqtoslsstffthemself')) { ?>
                                        <div class="form-group">
                                          <label class="control-label col-md-6 col-sm-3 col-xs-12" style="text-align: left;"> 
                                               After followup this enquiry reassiged to your account, otherwise you can drop this case.
                                          </label>
                                          <div class="tmpRefer">
                                               <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group">
                                                         <div class="col-md-7 col-sm-6 col-xs-12">
                                                              <textarea name="remark" required class="form-control col-md-7 col-xs-12" placeholder="Reson for re-assign enquires"></textarea>
                                                              <input type="hidden" name="salesOfficers" id="salesOfficers" value="<?php echo $this->uid; ?>"/>
                                                         </div>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                              <?php
                           }
                         ?>
                         <!-- -->

                         <?php if (check_permission('followup', 'showthismessagetotelecaller')) {?>
                                <div class="form-group">
                                     <label class="control-label col-md-6 col-sm-3 col-xs-12" style="text-align: left;"> 
                                          <label><input name="followup[foll_can_show_all]" class="" type="checkbox" value="1"/></label> Show this message to telecaller?
                                     </label>
                                </div>
                           <?php } if (is_roo_user()) {?>
                                <button type="button" class="btn btn-primary btnQuickUpdateFollowup" 
                                        data-url="<?php echo site_url('followup/quickUpdateFollowup');?>">Update feedback</button>
                                   <?php }?>
                         <span style="color: red;font-size: 10px;font-weight: bold;" class="alignright msgFollowup"></span>
                    </div>
               </div>
          </div>

          <div class="col-md-6 col-sm-12 col-xs-12">
               <div class="panel panel-default" style="float: left;width: 100%;">
                    <div class="panel-heading">Set next followup</div>
                    <div class="panel-body">
                         <div class="form-group">
                              <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control cmbFollowStatus vreg_customer_status" name="followup[foll_status]" required="required">
                                        <option value="">Select status</option>
                                        <?php
                                          foreach (unserialize(FOLLOW_UP_STATUS) as $key => $value) {
                                               //if ($key <= $enquiry['enq_cus_when_buy']) {
                                               $dayPer = 0;
                                                  if ($key == 3) {
                                                       $dayPer = 1;
                                                  } else if ($key == 4) {
                                                       $dayPer = 3;
                                                  }
                                                    ?>
                                                    <option <?php //echo ($enquiry['enq_cus_when_buy'] == $key) ? 'selected="selected"' : ''; ?> 
                                                         data-per-day="<?php echo $dayPer; ?>" value="<?php echo $key;?>"><?php echo $value;?></option>
                                                    <?php
                                               //}
                                          }
                                        ?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control cmbModeOfContact" name="followup[foll_contact]" required="required">
                                        <option value="">Select mode of contact</option>
                                        <?php foreach (unserialize(MODE_OF_CONTACT_FOLLOW_UP) as $key => $value) {?>
                                               <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                          <?php }?>
                                   </select>
                              </div>
                         </div>

                         <div class="form-group">
                              <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12">Next action plan</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input placeholder="Next action plan" id="foll_action_plan" class="form-control col-md-7 col-xs-12 txtNextActionPlan" 
                                          type="text" name="followup[foll_action_plan]" required="required">
                              </div>
                         </div>
                         <!--<div class="form-group">-->
                         <!--     <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12">Next follow up date</label>-->
                         <!--     <div class="col-md-6 col-sm-6 col-xs-12">-->
                         <!--          <input type="text" class="form-control col-md-7 col-xs-12 dtpNewFollowDate" required="required"-->
                         <!--                 data-url="<?php //echo site_url('followup/getfollowupByDate/' . encryptor($enqId));?>"-->
                         <!--                 placeholder="Next follow up date" name="followup[foll_next_foll_date]" autocomplete="off">-->
                         <!--     </div>-->
                         <!--</div>-->
                         <div class="divFollowupDate"></div>
                         <div class="form-group">
                              <label for="foll_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input placeholder="Remarks" id="foll_remarks" class="form-control col-md-7 col-xs-12 txtFollowRemarks" 
                                          required="required" ype="text" name="followup[foll_remarks]">
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</form>

<div style="display:none;">
     <div class="divNewFollowDateH">
          <div class="form-group">
               <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Next follow up date</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12 dtpNewFollowDateH" required="required"
                           data-url="<?php echo site_url('followup/getfollowupByDate/' . encryptor($enqId)); ?>"
                           placeholder="Next follow up date Hot Hot+" name="followup[foll_next_foll_date]" autocomplete="off">
               </div>
          </div>
     </div>

     <div class="divNewFollowDateW">
          <div class="form-group">
               <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Next follow up date</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12 dtpNewFollowDateW" required="required"
                           data-url="<?php echo site_url('followup/getfollowupByDate/' . encryptor($enqId)); ?>"
                           placeholder="Next follow up date Walm" name="followup[foll_next_foll_date]" autocomplete="off">
               </div>
          </div>
     </div>

     <div class="divNewFollowDateC">
          <div class="form-group">
               <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Next follow up date</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12 dtpNewFollowDateC" required="required"
                           data-url="<?php echo site_url('followup/getfollowupByDate/' . encryptor($enqId)); ?>"
                           placeholder="Next follow up date Cold" name="followup[foll_next_foll_date]" autocomplete="off">
               </div>
          </div>
     </div>
</div>