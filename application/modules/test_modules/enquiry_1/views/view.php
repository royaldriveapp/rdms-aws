<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update enquiry</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <!-- Smart Wizard -->
                         <!--<p></p>-->
                         <form id="wizard" data-url="<?php echo site_url('enquiry/update');?>" class="form_wizard wizard_horizontal" action="#" role="form" data-toggle="validator" method="post" accept-charset="utf-8">
                              <input type="hidden" class="txtEnqId" name="enq_id" value="<?php echo $enquiry['enq_id'];?>"/>
                              <ul class="wizard_steps">
                                   <li>
                                        <a href="#step-1">
                                             <span class="step_no">1</span>
                                             <span class="step_descr">
                                                  Step 1<br />
                                                  <small>Customer enquiry</small>
                                             </span>
                                        </a>
                                   </li>

                                   <li>
                                        <a href="#step-2">
                                             <span class="step_no">2</span>
                                             <span class="step_descr">
                                                  Step 2<br />
                                                  <small>Inquiry Questions</small>
                                             </span>
                                        </a>
                                   </li>

                                   <li>
                                        <a href="#step-3">
                                             <span class="step_no">3</span>
                                             <span class="step_descr">
                                                  Step 3<br />
                                                  <small>Vehicle details</small>
                                             </span>
                                        </a>
                                   </li>
                                   <li>
                                        <a href="#step-4">
                                             <span class="step_no">4</span>
                                             <span class="step_descr">
                                                  Step 4<br />
                                                  <small>Mode of payment</small>
                                             </span>
                                        </a>
                                   </li>
                              </ul>
                              <div id="step-1">
                                   <div class="form-horizontal form-label-left">
                                        <div id="form-step-0" role="form" data-toggle="validator">
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Grade<span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select required="true" class="select2_group form-control" name="enquiry[enq_customer_grade]">
                                                            <option value="">Customer grade</option>
                                                            <?php foreach ($customerGrades as $key => $value) {?>
                                                                   <option <?php echo $value['sgrd_id'] == $enquiry['enq_customer_grade'] ? 'selected="selected"' : '';?>
                                                                        value="<?php echo $value['sgrd_id'];?>"><?php echo $value['sgrd_grade'];?></option>
                                                              <?php }?>
                                                       </select>
                                                  </div>
                                             </div>
                                             <?php
                                               if (check_permission('enquiry', 'assignenquires') && !empty($salesExe)) {
                                                    ?>
                                                    <div class="form-group">
                                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sales Executive
                                                              <span class="required">*</span>
                                                         </label>
                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                              <select class="select2_group form-control enq_se_id cmbSearchList" name="enquiry[enq_se_id]">
                                                                   <option value="">Assign to sales executive</option>
                                                                   <?php foreach ($salesExe as $key => $value) {?>
                                                                        <option <?php echo $value['usr_id'] == $enquiry['enq_se_id'] ? 'selected="selected"' : '';?> value="<?php echo $value['usr_id'];?>"><?php echo $value['usr_first_name'];?></option>
                                                                   <?php }?>
                                                              </select>
                                                         </div>
                                                    </div>
                                                    <?php
                                               }
                                             ?>
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name
                                                       <span class="required">*</span>
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['enq_cus_name']?>" name="enquiry[enq_cus_name]" type="text" id="first-name" class="enq_cus_name form-control col-md-7 col-xs-12" required>
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_address" class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['enq_cus_address']?>" id="enq_cus_address" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_address]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_mobile" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile
                                                       <span class="required">*</span>
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input <?php echo!can_access_module('canchangesemodemobile') ? "disabled" : '';?> 
                                                            value="<?php echo $enquiry['enq_cus_mobile']?>" id="enq_cus_mobile" 
                                                            class="enq_cus_mobile form-control col-md-7 col-xs-12 numOnly" type="text" 
                                                            name="enquiry[enq_cus_mobile]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_city" class="control-label col-md-3 col-sm-3 col-xs-12">Place<span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['cit_name']?>" id="enq_cus_city" class="autoComCity form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_city]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['enq_cus_email']?>" id="enq_cus_email" class="form-control col-md-7 col-xs-12 emailOnly" type="text" name="enquiry[enq_cus_email]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_whatsapp" class="control-label col-md-3 col-sm-3 col-xs-12">Whatsapp</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['enq_cus_whatsapp']?>" id="enq_cus_whatsapp" class="form-control col-md-7 col-xs-12 numOnly enq_cus_whatsapp" type="text" name="enquiry[enq_cus_whatsapp]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_fbid" class="control-label col-md-3 col-sm-3 col-xs-12">Customer FB Id</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['enq_cus_fbid']?>" id="enq_cus_fbid" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_fbid]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_age_group" class="control-label col-md-3 col-sm-3 col-xs-12">Age group</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control" name="enquiry[enq_cus_age_group]">
                                                            <?php foreach (unserialize(CUST_AGE_GROUP) as $key => $value) {?>
                                                                   <option <?php echo $enquiry['enq_cus_age_group'] == $key ? 'selected="selected"' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option>
                                                              <?php }?>
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_occu" class="control-label col-md-3 col-sm-3 col-xs-12">Occupation</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['occ_name']?>" id="enq_cus_occu" class="autoComOccupation form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_occu]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_company" class="control-label col-md-3 col-sm-3 col-xs-12">Company</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['enq_cus_company']?>" id="enq_cus_company" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_company]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_phone_res" class="control-label col-md-3 col-sm-3 col-xs-12">Resi phone</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['enq_cus_phone_res']?>" id="enq_cus_phone_res" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_phone_res]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_country" class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['cnt_name']?>" id="enq_cus_country" class="autoComCountry form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_country]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_state" class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['stt_name']?>" id="enq_cus_state" class="autoComState form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_state]">
                                                  </div>
                                             </div>

                                             <!-- <div class="form-group">
                                                  <label for="enq_cus_dist" class="control-label col-md-3 col-sm-3 col-xs-12">District</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input required="true" value="<?php echo $enquiry['dit_name']?>" id="enq_cus_dist" class="autoComDistrict form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_dist]">
                                                  </div>
                                             </div> -->

                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">District</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control" name="enquiry[enq_cus_dist]">
                                                            <option value="0">Select District</option>
                                                            <?php
                                                              foreach ($districts as $key => $value) {
                                                                   ?>
                                                                   <option <?php echo ($enquiry['enq_cus_dist'] == $value['std_id']) ? 'selected="selected"' : ''; ?>
                                                                        value="<?php echo $value['std_id'];?>"><?php echo $value['std_district_name'];?></option>
                                                                   <?php
                                                              }
                                                            ?>
                                                       </select>
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_pin" class="control-label col-md-3 col-sm-3 col-xs-12">Pin</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['enq_cus_pin']?>" id="enq_cus_pin" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_pin]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_when_buy" class="control-label col-md-3 col-sm-3 col-xs-12">When would you like to buy?</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control" name="enquiry[enq_cus_when_buy]" disabled="true">
                                                            <option value="">Select one</option>
                                                            <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $key => $value) {?>
                                                                   <option <?php echo $enquiry['enq_cus_when_buy'] == $key ? 'selected="selected"' : '';?> 
                                                                        value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_budget" class="control-label col-md-3 col-sm-3 col-xs-12">Budget</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo $enquiry['enq_budget']?>" type="text" class="form-control col-md-7 col-xs-12 numOnly" name="enquiry[enq_budget]" gtrzro="true" required/>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_vehicle_type" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle type</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control enq_cus_when_buy" name="enquiry[enq_vehicle_type]" required>
                                                            <option value="">Select one</option>
                                                            <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                   <option <?php echo $enquiry['enq_vehicle_type'] == $key ? 'selected="selected"' : '';?> 
                                                                        value="<?php echo $key;?>"><?php echo $value;?></option>
                                                              <?php }?>
                                                       </select>
                                                  </div>
                                             </div>
                                             <input type="hidden" value="<?php echo $enquiry['enq_cus_test_drive']; ?>" name="enquiry[enq_cus_test_drive]"/>
<!--                                             <div class="form-group">
                                                  <label for="enq_cus_test_drive" class="control-label col-md-3 col-sm-3 col-xs-12">Test drive</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="checkbox" class="js-switch" name="enquiry[enq_cus_test_drive]" 
                                                       <?php //echo $enquiry['enq_cus_test_drive'] == 1 ? 'checked="checked"' : '';?>
                                                              value="1"/>
                                                  </div>
                                             </div>-->
                                             <div class="form-group">
                                                  <label for="enq_cus_status" class="control-label col-md-3 col-sm-3 col-xs-12">Type</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control cmbEnqStatus" name="enquiry[enq_cus_status]">
                                                            <option <?php echo $enquiry['enq_cus_status'] == 1 ? 'selected="selected"' : '';?> value="1">Sales</option>
                                                            <option <?php echo $enquiry['enq_cus_status'] == 2 ? 'selected="selected"' : '';?> value="2">Purchase</option>
                                                            <option <?php echo $enquiry['enq_cus_status'] == 3 ? 'selected="selected"' : '';?> value="3">Exchange</option>
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_status" class="control-label col-md-3 col-sm-3 col-xs-12" required>Mode of enquiry</label>
                                                  <!-- -->
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select required class="select2_group form-control enq_mode_enq" name="enquiry[enq_mode_enq]" disabled>
                                                            <option value="">Select one</option>
                                                            <optgroup label="RD Mode of Enquiry">
                                                                 <?php
                                                                   foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                        if (!in_array($key, array(18, 17, 6, 19, 20))) {
                                                                             ?>
                                                                             <option <?php echo ($enquiry['enq_mode_enq'] == $key) ? 'selected="selected"' : '';?> 
                                                                                  value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                                  <?php
                                                                             }
                                                                        }
                                                                      ?>
                                                            </optgroup>
                                                            <optgroup label="Own Mode of Enquiry">
                                                                 <?php
                                                                   foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                        if (in_array($key, array(18, 17, 6, 19, 20))) {
                                                                             ?>
                                                                             <option <?php echo ($enquiry['enq_mode_enq'] == $key) ? 'selected="selected"' : '';?> 
                                                                                  value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                                  <?php
                                                                             }
                                                                        }
                                                                      ?>
                                                            </optgroup>
                                                       </select>
                                                  </div>
                                                  <!-- -->
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <textarea class="form-control col-md-7 col-xs-12" name="enquiry[enq_cus_remarks]"><?php echo $enquiry['enq_cus_remarks'];?></textarea>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div id="step-2" class="step2">
                                   <div class="form-horizontal form-label-left">
                                        <div id="form-step-0" role="form" data-toggle="validator">
                                             <div class="qstSell" style="<?php echo ($enquiry['enq_cus_status'] == 1) ? 'display: block;' : 'display: none;'; ?>">
                                                  <?php
                                                    foreach ((array) $questions['sell'] as $k => $value) {
                                                         $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                         $answer = isset($enquiry['questions'][$value['qus_id']]['enqq_answer']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_answer'] : '';
                                                         $enqQuesId = isset($enquiry['questions'][$value['qus_id']]['enqq_id']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_id'] : 0;
                                                         
                                                         ?>
                                                         <div class="form-group">
                                                              <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-6 col-sm-6 col-xs-12">
                                                                   <?php echo $value['qus_question'];?>
                                                              </label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                        <input type="checkbox"  <?php
                                                                        echo $required;
                                                                        echo ($answer == 1) ? ' checked="checked"' : '';
                                                                        ?> name="saquestions[<?php echo $value['qus_id'];?>]" value="1"/>
                                                                          <?php } else { // Text box ?>
                                                                        <textarea autocomplete="off" <?php echo $required;?>  id="enq_cus_need" type="text" 
                                                                                  class="form-control col-md-7 col-xs-12" name="saquestions[<?php echo $value['qus_id'];?>]"><?php echo $answer;?></textarea>
                                                                             <?php }?>
                                                                   <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                              </div>
                                                         </div>
                                                    <?php }?>
                                             </div>
                                             <div class="qstBuy" style="<?php echo ($enquiry['enq_cus_status'] == 2) ? 'display: block;' : 'display: none;'; ?>">
                                                  <?php
                                                    foreach ((array) $questions['buy'] as $k => $value) {
                                                         $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                         $answer = isset($enquiry['questions'][$value['qus_id']]['enqq_answer']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_answer'] : '';
                                                         $enqQuesId = isset($enquiry['questions'][$value['qus_id']]['enqq_id']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_id'] : '';
                                                         ?>
                                                         <div class="form-group">
                                                              <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-6 col-sm-6 col-xs-12">
                                                                   <?php echo $value['qus_question'];?>
                                                              </label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                        <input <?php
                                                                        echo $required;
                                                                        echo ($answer == 1) ? ' checked="checked"' : '';
                                                                        ?> type="checkbox" name="byquestions[<?php echo $value['qus_id'];?>]" value="1"/>
                                                                        <?php } else { // Text box ?>
                                                                        <textarea <?php echo $required;?> id="enq_cus_need" class="form-control col-md-7 col-xs-12" type="text" 
                                                                                                          name="byquestions[<?php echo $value['qus_id'];?>]"><?php echo $answer;?></textarea>
                                                                                                     <?php }?>
                                                                   <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                              </div>
                                                         </div>
                                                    <?php }?>
                                             </div>
                                             <div class="qstExch" style="<?php echo ($enquiry['enq_cus_status'] == 3) ? 'display: block;' : 'display: none;'; ?>">
                                                  <?php
                                                    foreach ((array) $questions['exch'] as $k => $value) {
                                                         $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                         $answer = isset($enquiry['questions'][$value['qus_id']]['enqq_answer']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_answer'] : '';
                                                         $enqQuesId = isset($enquiry['questions'][$value['qus_id']]['enqq_id']) ?
                                                                 $enquiry['questions'][$value['qus_id']]['enqq_id'] : '';
                                                         ?>
                                                         <div class="form-group">
                                                              <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-6 col-sm-6 col-xs-12">
                                                                   <?php echo $value['qus_question'];?>
                                                              </label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                        <input type="checkbox" <?php
                                                                        echo $required;
                                                                        echo ($answer == 1) ? ' checked="checked"' : '';
                                                                        ?>  name="exquestions[<?php echo $value['qus_id'];?>]" value="1"/>
                                                                          <?php } else { // Text box ?>
                                                                        <textarea <?php echo $required;?> id="enq_cus_need" class="form-control col-md-7 col-xs-12" type="text" 
                                                                                                          name="exquestions[<?php echo $value['qus_id'];?>]"><?php echo $answer;?></textarea>
                                                                                                     <?php }?>
                                                                   <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                              </div>
                                                         </div>
                                                    <?php }?>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div id="step-3">
                                   <h2 class="StepTitle lblSale" style="<?php echo ($enquiry['enq_cus_status'] == 1 || $enquiry['enq_cus_status'] == 3) ? "" : "display:none;";?> width: 100%;">Customer required vehicle<span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsSale"></span></h2>
                                   <div class="table-responsive divVehDetailsSale" style="<?php echo ($enquiry['enq_cus_status'] == 1 || $enquiry['enq_cus_status'] == 3) ? "" : "display:none;";?>">
                                        <?php
                                          //if (!empty($enquiry['vehicle_sall'])) {
                                               foreach ($enquiry['vehicle_sall'] as $key => $sales) {
                                                    if (empty($sales['vst_current_status']) || $sales['vst_current_status'] == 1) {
                                                         ?>
                                                         <script type="text/javascript">
                                                              $(document).ready(function () {
                                                                   $(".tblVehicleSales" +<?php echo $sales['veh_id'];?> + " :input").prop("disabled", false);
                                                              });
                                                         </script>
                                                    <?php } else {?>
                                                         <script type="text/javascript">
                                                              $(document).ready(function () {
                                                                   $(".tblVehicleSales" +<?php echo $sales['veh_id'];?> + " :input").prop("disabled", true);
                                                              });
                                                         </script>
                                                    <?php }?>

                                                    <input value="<?php echo isset($sales['veh_delete']) ? $sales['veh_delete'] : '';?>" 
                                                           type="hidden" name="vehicle[sale][veh_delete][]">
                                                    <table id="datatable-responsive" class="vehDetailsSale tblVehicleSales<?php echo $sales['veh_id'];?> tblVehicle<?php echo $sales['veh_id'];?> table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                         <thead>
                                                              <tr>
                                                                   <th colspan="11">
                                                                        <input type="hidden" name="vehicle[sale][veh_id][]" value="<?php echo isset($sales['veh_id']) ? $sales['veh_id'] : '';?>"/>
                                                                        <select style="width: 170px;" class="cmbSearchList select2_group form-control cmbStock" 
                                                                                name="vehicle[sale][veh_stock_id][]" data-url="<?php echo site_url('enquiry/bindSalesTable');?>">
                                                                             <option value="0">Select Vehicle</option>
                                                                             <?php
                                                                             foreach ((array) $evaluation as $key => $value) {
                                                                                  if (!$this->evaluation->isVehicleSold($value['val_id'])) { // check if vehicle sold
                                                                                       ?>
                                                                                       <option <?php echo ($sales['veh_stock_id'] == $value['val_id']) ? 'selected="selected"' : '';?>
                                                                                            value="<?php echo $value['val_id'];?>">
                                                                                                 <?php
                                                                                                 echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                                                                 $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                                                                 ?>
                                                                                       </option>
                                                                                       <?php
                                                                                  }
                                                                             }
                                                                             ?>
                                                                        </select>
                                                                   </th>
                                                              </tr>
                                                              <tr>
                                                                   <th>Brand</th>
                                                                   <th>Model</th>
                                                                   <th>Variant</th>
                                                                   <th>Fuel</th>
                                                                   <th>Year</th>
                                                                   <th>Color</th>
                                                                   <th>Price from</th>
                                                                   <th>Price to.</th>
                                                                   <th>Km from</th>
                                                                   <th>Km to</th>
                                                              </tr>
                                                         </thead>
                                                         <tbody>
                                                              <tr>
                                                                   <td>
                                                                        <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModel" name="vehicle[sale][veh_brand][]" data-url="<?php echo site_url('enquiry/bindModel');?>">
                                                                             <option value="0">Select Brand</option>
                                                                             <?php foreach ($brands as $key => $value) {?>
                                                                                  <option <?php echo (isset($sales['veh_brand']) && ($value['brd_id'] == $sales['veh_brand'])) ? 'selected="selected"' : '';?> value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <?php $model = $this->myEnquiry->bindModel($sales['veh_brand'], 'array');?>
                                                                        <select required="true" style="width: 170px;" class="select2_group form-control cmbBindVariant" name="vehicle[sale][veh_model][]" data-url="<?php echo site_url('enquiry/bindVarient');?>">
                                                                             <option value="0">Select Model</option>
                                                                             <?php foreach ((array) $model as $key => $value) {?>
                                                                                  <option <?php echo (isset($sales['veh_model']) && ($value['mod_id'] == $sales['veh_model'])) ? 'selected="selected"' : '';?> value="<?php echo $value['mod_id']?>"><?php echo $value['mod_title']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <?php $variant = $this->myEnquiry->bindVarient($sales['veh_model'], 'array');?>
                                                                        <select style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_varient][]">
                                                                             <option value="0">Select Variant</option>
                                                                             <?php foreach ((array) $variant as $key => $value) {?>
                                                                                  <option <?php echo (isset($sales['veh_varient']) && ($value['var_id'] == $sales['veh_varient'])) ? 'selected="selected"' : '';?> value="<?php echo $value['var_id']?>"><?php echo $value['var_variant_name']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <select style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
                                                                             <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                                  <option <?php echo (isset($sales['veh_fuel']) && ($key == $sales['veh_fuel'])) ? 'selected="selected"' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($sales['veh_year']) ? $sales['veh_year'] : '';?>" id="veh_year" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_year][]">
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($sales['veh_color']) ? $sales['veh_color'] : '';?>" id="veh_color" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_color][]">
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($sales['veh_price_from']) ? $sales['veh_price_from'] : '';?>" id="veh_price_from" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_from][]">
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($sales['veh_price_to']) ? $sales['veh_price_to'] : '';?>" id="veh_price_to" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_to][]">
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($sales['veh_km_from']) ? $sales['veh_km_from'] : '';?>" id="veh_km_from" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_from][]">
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($sales['veh_km_to']) ? $sales['veh_km_to'] : '';?>" id="veh_km_to" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_to][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="6">
                                                                        <input value="<?php echo isset($sales['veh_reg']) ? $sales['veh_reg'] : '';?>" placeholder="Registration" id="veh_reg" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">
                                                                   </td>
                                                                   <td colspan="5">
                                                                        <input value="<?php echo isset($sales['veh_owner']) ? $sales['veh_owner'] : '';?>" placeholder="Owner" id="veh_owner" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[sale][veh_owner][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="11">
                                                                        <input value="<?php echo isset($sales['veh_remarks']) ? $sales['veh_remarks'] : '';?>" placeholder="Remarks" id="veh_remarks" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="11">
                                                                        <?php $whoEvaluated = $this->myEnquiry->evaluation->getEvaluation($sales['veh_stock_id']);?>
                                                                        <label>Evaluated By : <?php
                                                                             echo isset($whoEvaluated['usr_first_name']) ? $whoEvaluated['usr_first_name'] : '';
                                                                             echo isset($whoEvaluated['usr_last_name']) ? ' ' . $whoEvaluated['usr_last_name'] : '';
                                                                             ?></label>
                                                                   </td>
                                                              </tr>
                                                         </tbody>
                                                    </table>
                                                    <?php
                                               }
                                          //} else {
                                               ?>
                                               <!-- <table id="datatable-responsive" class="vehDetailsSale table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                    <thead>
                                                         <tr>
                                                              <th colspan="11">
                                                                   <input type="hidden" name="vehicle[sale][veh_id][]" value="0"/>
                                                                   <select style="width: 170px;" class="cmbSearchList select2_group form-control cmbStock" 
                                                                           name="vehicle[sale][veh_stock_id][]" data-url="<?php echo site_url('enquiry/bindSalesTable');?>">
                                                                        <option value="0">Select Vehicle</option>
                                                                        <?php
                                                                        foreach ((array) $evaluation as $key => $value) {
                                                                             ?>
                                                                             <option value="<?php echo $value['val_id'];?>">
                                                                                  <?php
                                                                                  echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                                                  $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                                                  ?>
                                                                             </option>
                                                                        <?php }?>
                                                                   </select>
                                                              </th>
                                                         </tr>
                                                         <tr>
                                                              <th>Brand</th>
                                                              <th>Model</th>
                                                              <th>Variant</th>
                                                              <th>Fuel</th>
                                                              <th>Year</th>
                                                              <th>Color</th>
                                                              <th>Price from</th>
                                                              <th>Price to.</th>
                                                              <th>Km from</th>
                                                              <th>Km to</th>
                                                         </tr>
                                                    </thead>
                                                    <tbody>
                                                         <tr>
                                                              <td>
                                                                   <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModel" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[sale][veh_brand][]">
                                                                        <option value="0">Select Brand</option>
                                                                        <?php foreach ($brands as $key => $value) {?>
                                                                             <option value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                        <?php }?>
                                                                   </select>
                                                              </td>
                                                              <td></td>
                                                              <td></td>
                                                              <td>
                                                                   <select style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
                                                                        <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                             <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                        <?php }?>
                                                                   </select>
                                                              </td>
                                                              <td>
                                                                   <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_year][]">
                                                              </td>
                                                              <td>
                                                                   <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_color][]">
                                                              </td>
                                                              <td>
                                                                   <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_from][]">
                                                              </td>
                                                              <td>
                                                                   <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_to][]">
                                                              </td>
                                                              <td>
                                                                   <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_from][]">
                                                              </td>
                                                              <td>
                                                                   <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_to][]">
                                                              </td>
                                                         </tr>
                                                         <tr>
                                                              <td colspan="6">
                                                                   <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">
                                                              </td>
                                                              <td colspan="5">
                                                                   <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[sale][veh_owner][]">
                                                              </td>
                                                         </tr>
                                                         <tr>
                                                              <td colspan="11">
                                                                   <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks][]">
                                                              </td>
                                                         </tr>
                                                    </tbody>
                                               </table> -->
                                          <?php //}
                                        ?>
                                   </div>
                                   <h2 class="StepTitle lblBuy" style="<?php echo ($enquiry['enq_cus_status'] == 2 || $enquiry['enq_cus_status'] == 3) ? "" : "display:none;";?>width: 100%;">Purchase<small> (Vehicle from customer)</small><span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsBuy"></span></h2>
                                   <div class="table-responsive divVehDetailsBuy" style="<?php echo ($enquiry['enq_cus_status'] == 2 || $enquiry['enq_cus_status'] == 3) ? "" : "display:none;";?>">
                                        <?php
                                          //if (!empty($enquiry['vehicle_buy'])) {
                                               foreach ($enquiry['vehicle_buy'] as $key => $buy) {
                                                    if (empty($buy['vst_current_status']) || $buy['vst_current_status'] == 1) {
                                                         ?>
                                                         <script type="text/javascript">
                                                              $(document).ready(function () {
                                                                   $(".tblVehicleBuy" +<?php echo $buy['veh_id'];?> + " :input").prop("disabled", false);
                                                              });
                                                         </script>
                                                    <?php } else {?>
                                                         <script type="text/javascript">
                                                              $(document).ready(function () {
                                                                   $(".tblVehicleBuy" +<?php echo $buy['veh_id'];?> + " :input").prop("disabled", true);
                                                              });
                                                         </script>
                                                    <?php }?>
                                                    <input type="hidden" name="vehicle[buy][veh_id][]" value="<?php echo isset($buy['veh_id']) ? $buy['veh_id'] : '';?>"/>
                                                    <input value="<?php echo isset($buy['veh_delete']) ? $buy['veh_delete'] : '';?>" 
                                                           type="hidden" name="vehicle[buy][veh_delete][]">
                                                    <table id="datatable-responsive" class="vehDetailsBuy tblVehicleBuy<?php echo $buy['veh_id'];?> tblVehicle<?php echo $buy['veh_id'];?> table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                         <thead>
                                                              <tr>
                                                                   <th>Brand</th>
                                                                   <th>Model</th>
                                                                   <th>Variant</th>
                                                                   <th>Fuel</th>
                                                                   <th>Year</th>
                                                                   <th>Color</th>
                                                                   <th>Price from</th>
                                                                   <th>Price to.</th>
                                                                   <th>Km from</th>
                                                                   <th>Km to</th>
                                                              </tr>
                                                         </thead>
                                                         <tbody>
                                                              <tr>
                                                                   <td>
                                                                        <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModelBuy" name="vehicle[buy][veh_brand][]" data-url="<?php echo site_url('enquiry/bindModel');?>">
                                                                             <option value="0">Select Brand</option>
                                                                             <?php foreach ($brands as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_brand']) && ($value['brd_id'] == $buy['veh_brand'])) ? 'selected="selected"' : '';?> value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <?php $model = $this->myEnquiry->bindModel($buy['veh_brand'], 'array');?>
                                                                        <select required="true" style="width: 170px;" class="select2_group form-control cmbBindVariantBuy" name="vehicle[buy][veh_model][]" data-url="<?php echo site_url('enquiry/bindVarient');?>">
                                                                             <?php foreach ((array) $model as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_model']) && ($value['mod_id'] == $buy['veh_model'])) ? 'selected="selected"' : '';?> value="<?php echo $value['mod_id']?>"><?php echo $value['mod_title']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <?php $variant = $this->myEnquiry->bindVarient($buy['veh_model'], 'array');?>
                                                                        <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_varient][]">
                                                                             <?php foreach ((array) $variant as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_varient']) && ($value['var_id'] == $buy['veh_varient'])) ? 'selected="selected"' : '';?> value="<?php echo $value['var_id']?>"><?php echo $value['var_variant_name']?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_fuel][]">
                                                                             <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_fuel']) && ($key == $buy['veh_fuel'])) ? 'selected="selected"' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                             <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($buy['veh_year']) ? $buy['veh_year'] : '';?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_year][]">
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($buy['veh_color']) ? $buy['veh_color'] : '';?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_color][]">
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($buy['veh_price_from']) ? $buy['veh_price_from'] : '';?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_price_from][]">
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($buy['veh_price_to']) ? $buy['veh_price_to'] : '';?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_price_to][]">
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($buy['veh_km_from']) ? $buy['veh_km_from'] : '';?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_from][]">
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($buy['veh_km_to']) ? $buy['veh_km_to'] : '';?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_to][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="4">
                                                                        <input value="<?php echo isset($buy['veh_exch_cus_expect']) ? $buy['veh_exch_cus_expect'] : '';?>" placeholder="Customeer expectation" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_exch_cus_expect][]">
                                                                   </td>
                                                                   <td colspan="4">
                                                                        <input value="<?php echo isset($buy['veh_exch_estimate']) ? $buy['veh_exch_estimate'] : '';?>" placeholder="Market estimate" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_estimate][]">
                                                                   </td>
                                                                   <td colspan="3">
                                                                        <input value="<?php echo isset($buy['veh_exch_dealer_value']) ? $buy['veh_exch_dealer_value'] : '';?>" placeholder="Dealer valued" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_dealer_value][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="6">
                                                                        <input value="<?php echo isset($buy['veh_reg']) ? $buy['veh_reg'] : '';?>" placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_reg][]">
                                                                   </td>
                                                                   <td colspan="5">
                                                                        <input value="<?php echo isset($buy['veh_owner']) ? $buy['veh_owner'] : '';?>" placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_owner][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="11">
                                                                        <input value="<?php echo isset($buy['veh_remarks']) ? $buy['veh_remarks'] : '';?>" placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_remarks][]">
                                                                   </td>
                                                              </tr>

                                                              <!-- -->
                                                              <tr>
                                                                 <td colspan="2">
                                                                      <input placeholder="First delivery date" id="veh_delivery_date" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12" 
                                                                           type="text" name="vehicle[buy][veh_delivery_date][]" data-d="<?php echo $buy['veh_delivery_date'];?>" value="<?php echo isset($buy['veh_delivery_date']) ? date('d-m-Y', strtotime($buy['veh_delivery_date'])) : '';?>">
                                                                 </td>
                                                                 <td colspan="2">
                                                                      <input placeholder="First reg date" id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                           type="text" name="vehicle[buy][veh_first_reg][]" value="<?php echo isset($buy['veh_first_reg']) ? date('d-m-Y', strtotime($buy['veh_first_reg'])) : '';?>">
                                                                 </td>
                                                                 <td colspan="2">
                                                                      <input placeholder="First manf year" id="veh_manf_year" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                           type="text" name="vehicle[buy][veh_manf_year][]" value="<?php echo isset($buy['veh_manf_year']) ? $buy['veh_manf_year'] : '';?>">
                                                                 </td>
                                                                 <td colspan="2">
                                                                      <select class="form-control col-md-4 col-xs-6" name="vehicle[buy][veh_ac][]" id="veh_ac">
                                                                           <option value="">Select A/C</option>
                                                                           <option <?php echo (isset($buy['veh_fuel']) && (1 == $buy['veh_fuel'])) ? 'selected="selected"' : '';?> value="1">W/o</option>
                                                                           <option <?php echo (isset($buy['veh_fuel']) && (2 == $buy['veh_fuel'])) ? 'selected="selected"' : '';?> value="2">Single</option>
                                                                           <option <?php echo (isset($buy['veh_fuel']) && (3 == $buy['veh_fuel'])) ? 'selected="selected"' : '';?> value="3">Dual</option>
                                                                           <option <?php echo (isset($buy['veh_fuel']) && (4 == $buy['veh_fuel'])) ? 'selected="selected"' : '';?> value="4">Multi</option>
                                                                      </select>
                                                                 </td>
                                                                 <td colspan="2">
                                                                      <input placeholder="Ac zone" id="veh_ac_zone" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                      value="<?php echo isset($buy['veh_ac_zone']) ? $buy['veh_ac_zone'] : '';?>" type="text" name="vehicle[buy][veh_ac_zone][]">
                                                                 </td>
                                                               </tr>
                                                               <tr>
                                                                 <td colspan="2">
                                                                      <input placeholder="CC" id="veh_cc" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                      value="<?php echo isset($buy['veh_cc']) ? $buy['veh_cc'] : '';?>" type="text" name="vehicle[buy][veh_cc][]">
                                                                 </td>
                                                                 <td colspan="2">
                                                                      <select class="select2_group form-control" name="vehicle[buy][veh_vehicle_type][]">
                                                                           <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                                <option <?php echo ($key == $buy['veh_vehicle_type']) ? 'selected="selected"' : '';?> 
                                                                                value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                           <?php }?>
                                                                      </select>
                                                                 </td>
                                                                 <td colspan="2">
                                                                      <input placeholder="Engine number" id="veh_engine_num" class="form-control col-md-7 col-xs-12" 
                                                                      value="<?php echo isset($buy['veh_engine_num']) ? $buy['veh_engine_num'] : '';?>"
                                                                      type="text" name="vehicle[buy][veh_engine_num][]">
                                                                 </td>
                                                                 <td colspan="2">
                                                                      <select required class="select2_group form-control" name="vehicle[buy][veh_transmission][]" id="val_transmission">
                                                                           <option value="">Select Transmission</option>
                                                                           <option value="1" <?php echo (isset($buy['veh_transmission']) && (1 == $buy['veh_transmission'])) ? 'selected="selected"' : '';?>>M/T</option>
                                                                           <option value="2" <?php echo (isset($buy['veh_transmission']) && (2 == $buy['veh_transmission'])) ? 'selected="selected"' : '';?>>A/T</option>
                                                                           <option value="3" <?php echo (isset($buy['veh_transmission']) && (3 == $buy['veh_transmission'])) ? 'selected="selected"' : '';?>>S/T</option>
                                                                      </select>
                                                                 </td>
                                                                 <td colspan="2">
                                                                      <input placeholder="No of seat" id="veh_seat_no" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                      value="<?php echo isset($buy['veh_seat_no']) ? $buy['veh_seat_no'] : '';?>"
                                                                      type="text" name="vehicle[buy][veh_seat_no][]">
                                                                 </td>
                                                               </tr>
                                                            <!-- -->
                                                         </tbody>
                                                    </table>
                                                    <?php
                                               }
                                          //} else if ($enquiry['enq_cus_status'] != 1) {
                                               ?>
                                               <table id="datatable-responsive" class="vehDetailsBuy table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                    <thead>
                                                       <tr>
                                                            <th colspan="11">
                                                                 <span style="margin: 5px 10px;cursor: pointer;font-size: 18px;" class="glyphicon glyphicon-remove btnRemoveEnqVehTable"></span>
                                                            </th>
                                                       </tr>
                                                       <tr>
                                                            <th>Brand</th>
                                                            <th>Model</th>
                                                            <th>Variant</th>
                                                            <th>Fuel</th>
                                                            <th>Model year</th>
                                                            <th>Color</th>
                                                            <th>Price from</th>
                                                            <th>Price to.</th>
                                                            <th>Km from</th>
                                                            <th>Km to</th>
                                                       </tr>
                                                     </thead>
                                                  <tbody>
                                                  <tr>
                                                       <td>
                                                            <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModelBuy" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[buy][veh_brand][]">
                                                                 <option value="0">Select Brand</option>
                                                                 <?php foreach ($brands as $key => $value) {?>
                                                                        <option value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td></td>
                                                       <td></td>
                                                       <td>
                                                            <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_fuel][]">
                                                                 <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_year][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_color][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_price_from][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_price_to][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_from][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_to][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="4">
                                                            <input placeholder="Customer expectation" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_cus_expect][]">
                                                       </td>
                                                       <td colspan="4">
                                                            <input placeholder="Market estimate" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_estimate][]">
                                                       </td>
                                                       <td colspan="3">
                                                            <input placeholder="Dealer valued" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_dealer_value][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="4">
                                                            <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_reg][]">
                                                       </td>
                                                       <td colspan="4">
                                                            <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_owner][]">
                                                       </td>
                                                       <td colspan="3">
                                                            <input placeholder="Chassis number" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_chassis_number][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="11">
                                                            <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_remarks][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="2">
                                                            <input placeholder="First delivery date" id="veh_delivery_date" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12" 
                                                                   type="text" name="vehicle[buy][veh_delivery_date][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="First reg date" id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][veh_first_reg][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="First manf year" id="veh_manf_year" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][veh_manf_year][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <select class="form-control col-md-4 col-xs-6" name="vehicle[buy][veh_ac][]" id="veh_ac">
                                                                 <option value="">Select A/C</option>
                                                                 <option value="1">W/o</option>
                                                                 <option value="2">Single</option>
                                                                 <option value="3">Dual</option>
                                                                 <option value="4">Multi</option>
                                                            </select>
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Ac zone" id="veh_ac_zone" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][veh_ac_zone][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="2">
                                                            <input placeholder="CC" id="veh_cc" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][veh_cc][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <select class="select2_group form-control" name="vehicle[buy][veh_vehicle_type][]">
                                                                 <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Engine number" id="veh_engine_num" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_engine_num][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <select required class="select2_group form-control" name="vehicle[buy][veh_transmission][]" id="val_transmission">
                                                                 <option value="">Select Transmission</option>
                                                                 <option value="1">M/T</option>
                                                                 <option value="2">A/T</option>
                                                                 <option value="3">S/T</option>
                                                            </select>
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="No of seat" id="veh_seat_no" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_seat_no][]">
                                                       </td>
                                                  </tr>
                                                  </tbody>
                                               </table>
                                          <?php //}
                                        ?>
                                   </div>
                              </div>
                              <div id="step-4">
                                   <div class="form-horizontal form-label-left">
                                        <div class="form-group">
                                             <label for="enq_cus_loan_perc" class="control-label col-md-3 col-sm-3 col-xs-12">Loan percentage</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo $enquiry['enq_cus_loan_perc']?>" id="enq_cus_loan_perc" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_perc]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_amount" class="control-label col-md-3 col-sm-3 col-xs-12">Loan amount</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo $enquiry['enq_cus_loan_amount']?>" id="enq_cus_loan_amount" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_amount]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_emi" class="control-label col-md-3 col-sm-3 col-xs-12">Loan EMI</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo $enquiry['enq_cus_loan_emi']?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_emi]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_period" class="control-label col-md-3 col-sm-3 col-xs-12">Loan total period</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo $enquiry['enq_cus_loan_period']?>" id="enq_cus_loan_period" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_period]">
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>
<script>
     $(document).ready(function () {
          /*Clone of sell buy table*/
          var vehDetailsSale = $(".tmpVehDetailsSale").prop('outerHTML');
          var vehDetailsBuy = $(".tmpVehDetailsBuy").prop('outerHTML');
          $(document).on('click', '.btnAddVehDetailsSale', function () {
               $('.divVehDetailsSale').append(vehDetailsSale);
               $('.cmbSearchList').SumoSelect({csvDispCount: 3, search: true, searchText: 'Enter here.'});
          });
          $(document).on('click', '.btnAddVehDetailsBuy', function () {
               $('.divVehDetailsBuy').append(vehDetailsBuy);
               $('.cmbSearchList').SumoSelect({csvDispCount: 3, search: true, searchText: 'Enter here.'});
          });
     });
</script>

<div style="display: none;">
     <table id="datatable-responsive" class="tmpVehDetailsSale vehDetailsSale table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
               <tr>
                    <th colspan="11">
                         <input type="hidden" name="vehicle[sale][veh_id][]" value="0"/>
                         <span style="float: left;cursor: pointer;font-size: 18px;margin: 5px 10px;" 
                               class="cmbSearchList glyphicon glyphicon-remove btnRemoveEnqVehTable"></span>
          <div>
               <select style="width: 170px;" class="select2_group form-control cmbStock" 
                       name="vehicle[sale][veh_stock_id][]" data-url="<?php echo site_url('enquiry/bindSalesTable');?>">
                    <option value="0">Select Vehicle</option>
                    <?php
                      foreach ((array) $evaluation as $key => $value) {
                           ?>
                           <option value="<?php echo $value['val_id'];?>">
                                <?php
                                echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                $value['mod_title'] . ', ' . $value['var_variant_name'];
                                ?>
                           </option>
                      <?php }?>
               </select>
          </div>
          </th>
          </tr>
          <tr>
               <th>Brand</th>
               <th>Model</th>
               <th>Variant</th>
               <th>Fuel</th>
               <th>Year</th>
               <th>Color</th>
               <th>Price from</th>
               <th>Price to.</th>
               <th>Km from</th>
               <th>Km to</th>
          </tr>
          </thead>
          <tbody>
               <tr>
                    <td>
                         <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModel" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[sale][veh_brand][]">
                              <option value="0">Select Brand</option>
                              <?php foreach ($brands as $key => $value) {?>
                                     <option value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                <?php }?>
                         </select>
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                         <select style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
                              <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                     <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                <?php }?>
                         </select>
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_year][]">
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[sale][veh_color][]">
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_from][]">
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_to][]">
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_from][]">
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_to][]">
                    </td>
               </tr>
               <tr>
                    <td colspan="6">
                         <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">
                    </td>
                    <td colspan="5">
                         <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[sale][veh_owner][]">
                    </td>
               </tr>
               <tr>
                    <td colspan="11">
                         <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks][]">
                    </td>
               </tr>
          </tbody>
     </table>
     <table id="datatable-responsive" class="tmpVehDetailsBuy vehDetailsBuy table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
               <tr>
                    <th colspan="11">
                         <input type="text" name="vehicle[buy][veh_id][]" value="0"/>
                         <span style="margin: 5px 10px;cursor: pointer;font-size: 18px;" class="glyphicon glyphicon-remove btnRemoveEnqVehTable"></span>
                    </th>
               </tr>
               <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Variant</th>
                    <th>Fuel</th>
                    <th>Year</th>
                    <th>Color</th>
                    <th>Price from</th>
                    <th>Price to.</th>
                    <th>Km from</th>
                    <th>Km to</th>
               </tr>
          </thead>
          <tbody>
               <tr>
                    <td>
                         <select style="width: 170px;" class="select2_group form-control cmbBindModelBuy" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[buy][veh_brand][]">
                              <?php foreach ($brands as $key => $value) {?>
                                     <option value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                <?php }?>
                         </select>
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                         <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_fuel][]">
                              <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                     <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                <?php }?>
                         </select>
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_year][]">
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_color][]">
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_price_from][]">
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_price_to][]">
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_from][]">
                    </td>
                    <td>
                         <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_to][]">
                    </td>
               </tr>
               <tr>
                    <td colspan="4">
                         <input placeholder="Customeer expectation" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_cus_expect][]">
                    </td>
                    <td colspan="4">
                         <input placeholder="Market estimate" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_estimate][]">
                    </td>
                    <td colspan="3">
                         <input placeholder="Dealer valued" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_dealer_value][]">
                    </td>
               </tr>
               <tr>
                    <td colspan="6">
                         <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_reg][]">
                    </td>
                    <td colspan="5">
                         <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_owner][]">
                    </td>
               </tr>
               <tr>
                    <td colspan="11">
                         <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_remarks][]">
                    </td>
               </tr>
          </tbody>
     </table>
</div>