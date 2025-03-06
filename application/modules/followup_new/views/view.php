<style>
     .enq-sts-bg-{
          background-color:#004099!important;
     }
     .panel-default>.panel-heading {
    background-color: #787b7724!important;
    border-color: #ddd!important;
}
.pnl-bg-color{
     background-color:#faf7f799!important;
}
.cusfdbkhcolor{
  background-color: #565a541a!important;   
}
.pnl-hgt{
     height:338px!important;
}

</style>
<div class="row ">
          <div class="col-md-12"> 
              <?php if (check_permission($controller, 'changestatus')) { ?>
                                   <div class="panel pnl-bg-color panel-default enq-sts-bg">
                                        <div class="panel-heading cusfdbkhcolor lbl">Change enquiry status</div>
                                        <div class="panel-body">
                                             <?php
                                             if (empty($vehicle['current_status']) ||
                                                     (isset($vehicle['current_status']['sts_value']) && $vehicle['current_status']['sts_value'] == 1)) {
                                                  ?>
                                                  <form id="demo-form2" method="post" action="<?php echo site_url('followup/changeEnqStatus'); ?>" data-parsley-validate class="form-horizontal form-label-left frmVehicleStatus frmChangeEnqStatus">
                                                       <input type="hidden" class="txtEnqId" name="enh_enq_id" value="<?php echo isset($vehicles['enq_id']) ? $vehicles['enq_id'] : 0; ?>"/>

                                                      

                                                      <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                                          
                                                                 <select class="select2_group form-control cmbFollStatus" name="enh_status" required="required" id="enq-status">
                                                                      <option value="">Select status</option>
                                                                      <?php foreach ((array) $statuses as $key => $value) { ?>
                                                                           <option data-slug="<?php echo $value['sts_slug']; ?>" value="<?php echo $value['sts_value']; ?>"><?php echo $value['sts_title']; ?></option>
                                                                      <?php } ?>
                                                                 </select>
                                                            
                                                       </div>
                                                         <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                                         <textarea placeholder="Remarks" required="required" name="enh_remarks" 
                                                                           class="form-control col-md-7 col-xs-12 text-left vst_remarks"></textarea>
                                                          
                                                       </div>
                                                       <div id="lost" style="display:none">
                                                   
                                                        </div>
                                                       

                                                       <div class="ln_solid"></div>
                                                       <div class="form-group">
                                                            <div class="col-md-7 col-sm-6 col-xs-12 col-md-offset-3">
                                                                 <button class="btn btn-primary" type="reset">Reset</button>
                                                                 <button type="submit" class="btn btn-success">Submit</button>
                                                            </div>
                                                       </div>
                                                  </form>
                                                  <?php
                                             }
                                             ?>
                                        </div>
                                   </div>
                              <?php } ?> 
          </div>
     </div>
<form id="demo-form2" method="post" data-parsley-validate class="form-horizontal form-label-left frmFollowUpFeedBack">
     <input type="hidden" name="quickfollowup" value="<?php echo isset($_GET['quickfollowup']) ? $_GET['quickfollowup'] : '';?>"/>
     <?php $enqId = isset($enqId) ? $enqId : 0;?>
     <input type="hidden" class="txtEnqId" name="foll_cus_id" value="<?php echo $enqId;?>"/>
     <input type="hidden" class="txtFollowupDate" value="<?php echo $date;?>"/>
     <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12">
               <div class="panel pnl-bg-color panel-default" style="float: left;width: 100%;">
                    <div class="panel-heading cus-fdbk-h-color lbl">Customer feedback on <?php echo date('d D M Y', strtotime($date));?> <span style="color: red;font-size: 10px;font-weight: bold;" class="alignright"> *Please enter at least one customer feedback</span></div>
                    <div class="panel-body">
                         <div class="divCustomerFeedBack">
                              <?php
                                if (!empty($followup)) {
                                     foreach ($followup as $key => $value) {
                                          ?>
                                          <div class="form-group">
                                               <label class="control-label col-md-6 col-sm-3 col-xs-12 lbl" style="text-align: left;" for="textarea">
                                                    <?php
                                                    $type = $value['veh_status'] == 1 ? 'Sell' : 'Buy';
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
                                        <label class="lbl">
                                             <input class="chk chkCommon" data-url="<?php echo site_url('followup/changeTestDriveHomeVisit/' . encryptor($enqId) . '/' . encryptor('enq_cus_test_drive'));?>" 
                                             <?php echo (isset($enquiry['enq_cus_test_drive']) && $enquiry['enq_cus_test_drive'] == 1) ? "checked" : '';?>
                                                    type="checkbox" value="1"><span> Customer test drive?</span>
                                        </label>
                                        <label class="lbl"> 
                                             <input class="chk chkCommon" data-url="<?php echo site_url('followup/changeTestDriveHomeVisit/' . encryptor($enqId) . '/' . encryptor('enq_cus_home_visit'));?>" 
                                             <?php echo (isset($enquiry['enq_cus_home_visit']) && $enquiry['enq_cus_home_visit'] == 1) ? "checked" : '';?>
                                                    type="checkbox" value="1"> <span> Customer home visit?</span>
                                        </label>
                                   </div>
                                   <!-- -->
                                   <div class="col-md-12 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                             <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Budget</label>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <input placeholder="Budget from" type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="followup[foll_budget_from]"/>
                                             </div>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <input placeholder="Budget to" type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="followup[foll_budget_to]"/>
                                             </div>
                                        </div>
                                        
                                        <div class="form-group">
                                             <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Model year</label>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <input placeholder="Model year from" type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="followup[foll_model_y_from]"/>
                                             </div>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <input placeholder="Model year to" type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="followup[foll_model_y_to]"/>
                                             </div>
                                        </div>
                                        
                                        <div class="form-group">
                                             <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">KM</label>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <input placeholder="KM from" type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="followup[foll_km_from]"/>
                                             </div>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <input placeholder="KM to" type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="followup[foll_km_to]"/>
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
                                if ($active == 0) {
                                     ?>
                                     <div class="form-group">
                                          <label class="control-label col-md-6 col-sm-3 col-xs-12 lbl" style="text-align: left;"> 
                                               Refer this enquiry to other sales officer?
                                          </label>
                                          <div class="tmpRefer">
                                               <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group">
                                                         <div class="col-md-7 col-sm-6 col-xs-12">
                                                              <select class="select2_group form-control" name="salesOfficers" id="salesOfficers" required>
                                                                   <option value="">Select sales officer</option>
                                                                   <?php foreach ($salesExe as $key => $value) {?>
                                                                        <option value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')';?></option>                                               
                                                                   <?php }?>
                                                              </select>
                                                         </div>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                     <?php
                                }
                           }
                         ?>
                         <!-- -->

                         <?php if (check_permission('followup', 'showthismessagetotelecaller')) {?>
                                <div class="form-group">
                                     <label class="control-label col-md-6 col-sm-3 col-xs-12 lbl" style="text-align: left;"> 
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
               <div class="panel pnl-bg-color  panel-default pnl-hgt" style="float: left;width: 100%;">
                    <div class="panel-heading cus-fdbk-h-color">Set next followup</div>
                    <div class="panel-body">
                         <div class="form-group">
                              <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Status</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control cmbFollowStatus vreg_customer_status" name="followup[foll_status]" required="required">
                                        <option value="">Select status</option>
                                        <?php
                                          foreach (unserialize(FOLLOW_UP_STATUS) as $key => $value) {
                                               //if ($key <= $enquiry['enq_cus_when_buy']) {
                                               ?>
                                               <option <?php echo ($enquiry['enq_cus_when_buy'] == $key) ? 'selected="selected"' : '';?> 
                                                    value="<?php echo $key;?>"><?php echo $value;?></option>
                                                    <?php
                                                    //}
                                               }
                                             ?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Mode of contact</label>
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
                              <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Next action plan</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input placeholder="Next action plan" id="foll_action_plan" class="form-control col-md-7 col-xs-12 txtNextActionPlan" 
                                          type="text" name="followup[foll_action_plan]" required="required">
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Next follow up date</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" class="form-control col-md-7 col-xs-12 dtpNewFollowDate" required="required"
                                          data-url="<?php echo site_url('followup/getfollowupByDate/' . encryptor($enqId));?>"
                                          placeholder="Next follow up date" name="followup[foll_next_foll_date]" autocomplete="off">
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="foll_remarks" class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Remarks</label>
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
<script>
     $(document).ready(function () {
      $('#enq-statusk').change(function () {
               var selected = $(this).children("option:selected").val();
               if (selected === '4') {
                     $("#lost").show();

               } else {
                    $("#lost").hide();
               }
               //alert(selectedCountry);
          });
          $('#enq-status').on('change', function (e) {
                       var valueSelected = this.value;
                                           if (valueSelected === '4') {
                     $("#lost").show();
                  var enqType="<?php echo $enqType?>";
                           $.ajax({
               type: 'get',
               "url": site_url + "followup/append_lost_flds",
               data: {enqType: enqType},
               success: function (resp) {
                          $("#lost").html(resp);
               }
          });

               } else {
                    $("#lost").hide();
               }

     });
          });
     </script>