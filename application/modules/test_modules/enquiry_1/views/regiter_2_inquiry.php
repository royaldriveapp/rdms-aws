<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New enquiry</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php
                           $questions = array_map('array_filter', $questions);
                           $questions = array_filter($questions);
                           $defRegAnswer[5] = isset($datas['vreg_existing_vehicle']) ? $datas['vreg_existing_vehicle'] : '';
                         ?>
                         <!-- Smart Wizard -->
                         <!--<p>This is a basic form wizard example that inherits the colors from the selected scheme.</p>-->
                         <form id="wizard" data-url="<?php echo site_url('enquiry/punchEnquiry');?>" class="form_wizard wizard_horizontal" action="#" role="form" data-toggle="validator" method="post" accept-charset="utf-8">
                              <input type="hidden" value="<?php echo isset($datas['vreg_id']) ? $datas['vreg_id'] : '';?>" name="vreg_id"/>
                              <input type="hidden" value="<?php echo isset($datas['vreg_assigned_to']) ? $datas['vreg_assigned_to'] : '';?>" name="vreg_assigned_to"/>
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
                                   <?php if (!empty($questions)) {?>
                                          <li>
                                               <a href="#step-2">
                                                    <span class="step_no">2</span>
                                                    <span class="step_descr">
                                                         Step 2<br />
                                                         <small>Inquiry Questions</small>
                                                    </span>
                                               </a>
                                          </li>
                                     <?php }?>
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
                                   <li>
                                        <a href="#step-5">
                                             <span class="step_no">5</span>
                                             <span class="step_descr">
                                                  Step 5<br />
                                                  <small>Followup</small>
                                             </span>
                                        </a>
                                   </li>
                              </ul>
                              <div id="step-1">
                                   <div class="form-horizontal form-label-left">
                                        <div id="form-step-0" role="form" data-toggle="validator">
                                             <div class="form-group">
                                                  <label for="enq_cus_status" class="control-label col-md-3 col-sm-3 col-xs-12">Type</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control cmbEnqStatus" name="enquiry[enq_cus_status]">
                                                            <option value="1">Sales</option>
                                                            <option value="2">Purchase</option>
                                                            <option value="3">Exchange</option>
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Customer Grade<span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select required="true" class="select2_group form-control" name="enquiry[enq_customer_grade]">
                                                            <option value="">Customer grade</option>
                                                            <?php foreach ($customerGrades as $key => $value) {?>
                                                                   <option value="<?php echo $value['sgrd_id'];?>"><?php echo $value['sgrd_grade'];?></option>
                                                              <?php }?>
                                                       </select>
                                                  </div>
                                                  <!-- Modal -->
                                                                 <i class="fa fa-question" style="cursor:pointer;" data-toggle="modal" data-target="#popupinfo"></i>
                                                                 <div class="modal fade" id="popupinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                                                           <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                     <h5 style="width:120px;float: left;" class="modal-title" id="exampleModalLongTitle">Customer Grade</h5>
                                                                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                          <span aria-hidden="true">&times;</span>
                                                                                     </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                     Royal Drive Customers are Categorized into 3 Category:
                                                                                     These List including Sales and Purchase
                                                                                     <h5>Platinum Plus Customer</h5>
                                                                                     <ul>     
                                                                                          <li>Customers who are buying or selling vehicles above 1 crore.</li>
                                                                                          <li>The customers who are using above one crore vehicle , </li>
                                                                                          <li>Customers who are buying or selling 2 vehicles every year.</li>
                                                                                          <li>Celebrities, VVIPs, or any Persons who is identified in society as unique. (Positive)</li>
                                                                                          <li>Customers those who are regularly giving reference and it is materialising.(Min 4)</li>     
                                                                                     </ul>
                                                                                     <h5>Platinum Customer</h5>
                                                                                     <ul>     
                                                                                          <li>Any Customer those who are buying vehicles above 45 lakhs to 1 Crore</li>
                                                                                          <li>Customer who is having more than one vehicle </li>
                                                                                          <li>Customers those who are regularly giving reference and it is materialising.(Min 2)</li>
                                                                                     </ul>
                                                                                     <h5>Gold Customer</h5>
                                                                                     <ul>     
                                                                                          <li>All  other Customers who are buying below 45 lakhs.</li>
                                                                                          <li>Customers those who are regularly giving reference and it is materialising.(1)</li>
                                                                                     </ul>
                                                                                </div>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                                 <!-- -->
                                             </div>
                                             <?php
                                               if (check_permission('enquiry', 'assignenquires') && !empty($salesExe)) {
                                                    ?>
                                                    <div class="form-group">
                                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sales Executive
                                                              <span class="required">*</span>
                                                         </label>
                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                              <select required="true" class="select2_group form-control enq_se_id cmbSearchList" name="enquiry[enq_se_id]">
                                                                   <option value="">Assign to sales executive</option>
                                                                   <?php foreach ($salesExe as $key => $value) {?>
                                                                        <option <?php echo ($datas['vreg_assigned_to'] == $value['usr_id']) ? 'selected="selected"' : '';?>
                                                                             value="<?php echo $value['usr_id'];?>"><?php echo $value['usr_first_name'];?></option>
                                                                        <?php }?>
                                                              </select>
                                                         </div>
                                                    </div>
                                                    <?php
                                               }
                                             ?>
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enq_cus_name">Enquiry Date
                                                       <span class="required">*</span>
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input name="enquiry[enq_entry_date]" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" required="true"
                                                              value="<?php echo date('d-m-Y');?>"/>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enq_cus_name">Name
                                                       <span class="required">*</span>
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo isset($datas['vreg_cust_name']) ? $datas['vreg_cust_name'] : '';?>" name="enquiry[enq_cus_name]" type="text" id="enq_cus_name" class="form-control col-md-7 col-xs-12 enq_cus_name" required="">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_address" class="control-label col-md-3 col-sm-3 col-xs-12">Address <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input required="true" id="enq_cus_address" value="<?php echo isset($datas['vreg_address']) ? $datas['vreg_address'] : '';?>" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_address]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_mobile" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile
                                                       <span class="required">*</span>
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input value="<?php echo isset($datas['vreg_cust_phone']) ? $datas['vreg_cust_phone'] : '';?>" id="enq_cus_mobile" class="form-control col-md-7 col-xs-12 enq_cus_mobile" type="text" name="enquiry[enq_cus_mobile]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_city" class="control-label col-md-3 col-sm-3 col-xs-12">Place<span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input required value="<?php echo isset($datas['vreg_cust_place']) ? $datas['vreg_cust_place'] : '';?>" id="enq_cus_city" class="autoComCity form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_city]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_email" value="<?php echo isset($datas['vreg_email']) ? $datas['vreg_email'] : '';?>" 
                                                              class="form-control col-md-7 col-xs-12 emailOnly" type="text" name="enquiry[enq_cus_email]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_whatsapp" class="control-label col-md-3 col-sm-3 col-xs-12">Whatsapp</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_whatsapp" class="form-control col-md-7 col-xs-12 numOnly enq_cus_whatsapp" type="text" name="enquiry[enq_cus_whatsapp]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_fbid" class="control-label col-md-3 col-sm-3 col-xs-12">Customer FB Id</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_fbid" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_fbid]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_age_group" class="control-label col-md-3 col-sm-3 col-xs-12">Age group</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control" name="enquiry[enq_cus_age_group]">
                                                            <?php foreach (unserialize(CUST_AGE_GROUP) as $key => $value) {?>
                                                                   <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                              <?php }?>
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_occu" class="control-label col-md-3 col-sm-3 col-xs-12">Occupation</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_occu" value="<?php echo $datas['vreg_occupation'];?>" class="autoComOccupation form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_occu]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_company" class="control-label col-md-3 col-sm-3 col-xs-12">Company <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input required="true" id="enq_cus_company" value="<?php echo $datas['vreg_company'];?>" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_company]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_phone_res" class="control-label col-md-3 col-sm-3 col-xs-12">Resi phone</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_phone_res" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_phone_res]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_country" class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_country" class="autoComCountry form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_country]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_state" class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_state" class="autoComState form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_state]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">District <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select required class="select2_group form-control" name="enquiry[enq_cus_dist]">
                                                            <option value="">Select District</option>
                                                            <?php
                                                              foreach ($districts as $key => $value) {
                                                                   ?>
                                                                   <option <?php echo (isset($datas['vreg_district']) && $datas['vreg_district'] == $value['std_id']) ? 'selected="selected"' : ''; ?>
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
                                                       <input id="enq_cus_pin" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_pin]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_budget" class="control-label col-md-3 col-sm-3 col-xs-12">Budget</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="text" class="numOnly form-control col-md-7 col-xs-12 numOnly" 
                                                              name="enquiry[enq_budget]" value="<?php echo $datas['vreg_investment'];?>" required gtrzro="true"/>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_vehicle_type" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle type</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control enq_cus_when_buy" name="enquiry[enq_vehicle_type]" required>
                                                            <option value="">Select one</option>
                                                            <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                   <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                              <?php }?>
                                                       </select>
                                                  </div>
                                             </div>
                                             
                                             <div class="form-group">
                                                  <label for="enq_cus_status" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of enquiry</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select required class="select2_group form-control enq_mode_enq cmbModeOfContact" name="enquiry[enq_mode_enq]" disabled>
                                                            <option value="">Select one</option>
                                                            <optgroup label="RD Mode of Enquiry">
                                                                 <?php
                                                                   foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                        if (!in_array($key, array(18, 17, 6, 19, 20, 30, 31))) {
                                                                             ?>
                                                                             <option <?php echo ($datas['vreg_contact_mode'] == $key) ? 'selected="selected"' : '';?> 
                                                                                  value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                                  <?php
                                                                             }
                                                                        }
                                                                      ?>
                                                            </optgroup>
                                                            <optgroup label="Own Mode of Enquiry">
                                                                 <?php
                                                                   foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                        if (in_array($key, array(18, 17, 6, 19, 20, 30, 31))) {
                                                                             ?>
                                                                             <option <?php echo ($datas['vreg_contact_mode'] == $key) ? 'selected="selected"' : '';?> 
                                                                                  value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                                  <?php
                                                                             }
                                                                        }
                                                                      ?>
                                                            </optgroup>
                                                       </select>
                                                       <input type="hidden" name="enquiry[enq_mode_enq]" value="<?php echo $datas['vreg_contact_mode'];?>"/>
                                                  </div>
                                             </div>
                                             <div class="divReferral">
                                                  <?php if (isset($datas['vreg_contact_mode']) && $datas['vreg_contact_mode'] == 6) {?>
                                                         <div class="form-group">
                                                              <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Referral contact no *</label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <input required="true" placeholder="Referral contact no" type="text" class="form-control col-md-7 col-xs-12" name="enquiry[enq_ref_phone]"/>
                                                              </div>
                                                         </div>
                                                         <div class="form-group">
                                                              <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Referral name</label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <input placeholder="Referral name" type="text" class="form-control col-md-7 col-xs-12" name="enquiry[enq_ref_name]"/>
                                                              </div>
                                                         </div>
                                                    <?php }?>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <textarea class="form-control col-md-7 col-xs-12" name="enquiry[enq_cus_remarks]"><?php echo isset($datas['vreg_customer_remark']) ? strip_tags($datas['vreg_customer_remark']) : '';?></textarea>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Last Comments</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <?php echo isset($datas['vreg_last_action']) ? strip_tags($datas['vreg_last_action']) : '';?>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <?php if (!empty($questions)) {?>
                                     <div id="step-2" class="step2">
                                          <div class="form-horizontal form-label-left">
                                               <div id="form-step-0" role="form" data-toggle="validator">
                                                    <div class="qstSell">
                                                         <?php
                                                         foreach ((array) $questions['sell'] as $k => $value) {
                                                              $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                              ?>
                                                              <div class="form-group">
                                                                   <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-6 col-sm-6 col-xs-12">
                                                                        <?php echo $value['qus_question'];?>
                                                                   </label>
                                                                   <div class="col-md-6 col-sm-3 col-xs-12">
                                                                        <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                             <input type="checkbox"  <?php echo $required;?> name="saquestions[<?php echo $value['qus_id'];?>]" value="1"/>
                                                                        <?php } else { // Text box ?>
                                                                             <textarea autocomplete="off" <?php echo $required;?>  id="enq_cus_need" type="text" class="form-control col-md-7 col-xs-12" 
                                                                                       name="saquestions[<?php echo $value['qus_id'];?>]"><?php echo isset($defRegAnswer[$value['qus_id']]) ? $defRegAnswer[$value['qus_id']] : ''; ?></textarea>
                                                                        <?php }?>
                                                                        <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                                   </div>
                                                              </div>
                                                         <?php }?>
                                                    </div>
                                                    <div class="qstBuy" style="display: none;">
                                                         <?php
                                                         foreach ((array) $questions['buy'] as $k => $value) {
                                                              $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                              ?>
                                                              <div class="form-group">
                                                                   <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-3 col-sm-3 col-xs-12">
                                                                        <?php echo $value['qus_question'];?>
                                                                   </label>
                                                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                                                        <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                             <input <?php echo $required;?> type="checkbox" name="byquestions[<?php echo $value['qus_id'];?>]" value="1"/>
                                                                        <?php } else { // Text box ?>
                                                                             <textarea <?php echo $required;?> id="enq_cus_need" class="form-control col-md-7 col-xs-12" type="text" 
                                                                                                               name="byquestions[<?php echo $value['qus_id'];?>]"><?php echo isset($defRegAnswer[$value['qus_id']]) ? $defRegAnswer[$value['qus_id']] : ''; ?></textarea><?php }?>
                                                                        <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                                   </div>
                                                              </div>
                                                         <?php }?>
                                                    </div>
                                                    <div class="qstExch" style="display: none;">
                                                         <?php
                                                         foreach ((array) $questions['exch'] as $k => $value) {
                                                              $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                              ?>
                                                              <div class="form-group">
                                                                   <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-3 col-sm-3 col-xs-12">
                                                                        <?php echo $value['qus_question'];?>
                                                                   </label>
                                                                   <div class="col-md-7 col-sm-6 col-xs-12">
                                                                        <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                             <input type="checkbox" <?php echo $required;?> name="exquestions[<?php echo $value['qus_id'];?>]" value="1"/>
                                                                        <?php } else { // Text box ?>
                                                                             <textarea <?php echo $required;?> id="enq_cus_need" class="form-control col-md-7 col-xs-12" type="text" 
                                                                                                               name="exquestions[<?php echo $value['qus_id'];?>]"><?php echo isset($defRegAnswer[$value['qus_id']]) ? $defRegAnswer[$value['qus_id']] : ''; ?></textarea><?php }?>
                                                                        <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                                   </div>
                                                              </div>
                                                         <?php }?>
                                                    </div>
                                               </div>
                                          </div>
                                     </div>
                                <?php }?>
                              <div id="step-3">
                                   <h2 class="StepTitle lblSale" style="width: 100%;">Customer required vehicle<span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsSale"></span></h2>
                                   <div class="table-responsive divVehDetailsSale">
                                        <table id="datatable-responsive" class="vehDetailsSale table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                             <thead>
                                                  <tr>
                                                       <th colspan="11">
                                                            <span style="float: left;cursor: pointer;font-size: 18px;margin: 5px 10px;" class="glyphicon glyphicon-remove btnRemoveEnqVehTable"></span>
                                                            <select style="width: 170px;float: left;" class="cmbSearchList select2_group form-control cmbStock" 
                                                                    name="vehicle[sale][veh_stock_id][]" data-url="<?php echo site_url('enquiry/bindSalesTable');?>">
                                                                 <option value="0">Select Vehicle</option>
                                                                 <?php
                                                                   foreach ((array) $evaluation as $key => $value) {
                                                                        if (!$this->evaluation->isVehicleSold($value['val_id'])) { // check if vehicle sold
                                                                             ?>
                                                                             <option value="<?php echo $value['val_id'];?>">
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
                                                            <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModel" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[sale][veh_brand][]">
                                                                 <option value="0">Select Brand</option>
                                                                 <?php foreach ($brands as $key => $value) {?>
                                                                        <option <?php echo $value['brd_id'] == $datas['vreg_brand'] ? 'selected="selected"' : '';?> 
                                                                             value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                        <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select style="width: 170px;" required="" data-url="<?php echo site_url('enquiry/bindVarient');?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                                    class="cmbEvModel select2_group form-control bindToDropdown" name="vehicle[sale][veh_model][]" id="vreg_model">
                                                                         <?php foreach ((array) $model as $key => $value) {?>
                                                                        <option <?php echo $value['mod_id'] == $datas['vreg_model'] ? 'selected="selected"' : '';?> 
                                                                             value="<?php echo $value['mod_id'];?>"><?php echo $value['mod_title'];?></option>
                                                                        <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select style="width: 170px;" required="" class="select2_group form-control cmbEvVariant" name="vehicle[sale][veh_varient][]" id="vreg_varient">
                                                                 <?php foreach ((array) $variant as $key => $value) {?>
                                                                        <option <?php echo $value['var_id'] == $datas['vreg_varient'] ? 'selected="selected"' : '';?> 
                                                                             value="<?php echo $value['var_id'];?>"><?php echo $value['var_variant_name'];?></option>
                                                                        <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select required="true" style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
                                                                 <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <input value="<?php echo $datas['vreg_year'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_year][]">
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
                                                            <input placeholder="Registration (KL-00-AA-0000)" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">
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
                                                  <!-- -->
                                                  <tr style="background-color:red;">
                                                       <td colspan="9">
                                                            <span style="color: #fff;font-weight: bolder;font-size: 18px;">If you want to inform this vehicle to procurement team, please provide following details.</span>
                                                       </td>
                                                  </tr>
                                                  <tr style="background-color:red;color: #fff;">
                                                       <td colspan="1">
                                                            <p class="labl" style="color: #fff;">Purchase period</p>
                                                            <select name="vehicle[sale][proc_purchase_prd][]" id="var_brand_id"  class="form-control col-md-7 col-xs-12" data-dflt-select="Select Model">
                                                                 <option value="">Select purchase period</option>
                                                                 <?php foreach (unserialize(PURCHASE_PERIOD) as $key => $value) { ?>
                                                                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </td>
                                                       <td colspan="9">
                                                            <p class="labl" style="color: #fff;">Remarks</p>
                                                            <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][proc_desc][]">
                                                       </td>
                                                  </tr>
                                                  <!-- -->
                                             </tbody>
                                        </table>
                                   </div>
                                   <h2 class="StepTitle lblBuy" style="display: none; width: 100%;">Purchase vehicle<small> (Vehicle from customer)</small><span style="display: none; float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsBuy"></span></h2>
                                   <div class="table-responsive divVehDetailsBuy" style="display: none;">
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
                                                       <th>RD Price from</th>
                                                       <th>RD Price to.</th>
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
                                                            <input required="true" placeholder="KL-00-AA-0000" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_reg][]">
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
                                                            <input placeholder="Engine number" id="veh_engine_num" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_engine_num][]">
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
                                   </div>
                              </div>
                              <div id="step-4">
                                   <div class="form-horizontal form-label-left">
                                        <div class="form-group">
                                             <label for="enq_cus_loan_perc" class="control-label col-md-3 col-sm-3 col-xs-12">Loan percentage</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_perc" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_perc]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_amount" class="control-label col-md-3 col-sm-3 col-xs-12">Loan amount</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_amount" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_amount]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_emi" class="control-label col-md-3 col-sm-3 col-xs-12">Loan EMI</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_emi]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_period" class="control-label col-md-3 col-sm-3 col-xs-12">Loan total period</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_period" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_period]">
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div id="step-5">
                                   <div class="form-horizontal form-label-left">
                                        <div class="form-group">
                                             <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required="true" class="select2_group form-control" name="followup[foll_status]" id="foll_status">
                                                       <option value="">Select one</option>
                                                       <?php foreach (unserialize(FOLLOW_UP_STATUS) as $key => $value) {?>
                                                              <option  <?php echo ($datas['vreg_customer_status'] == $key) ? 'selected="selected"' : ''; ?> 
                                                                   value="<?php echo $key;?>"><?php echo $value;?></option>
                                                         <?php }?>
                                                  </select>
                                             </div>
                                             <!-- Modal -->
                                             <i class="fa fa-question" style="cursor:pointer;" data-toggle="modal" data-target="#popupinfoHWC"></i>
                                             <div class="modal fade" id="popupinfoHWC" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                                       <div class="modal-content">
                                                            <div class="modal-header">
                                                                 <h5 style="width:120px;float: left;" class="modal-title" id="exampleModalLongTitle">Enquiry Status</h5>
                                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                 </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                 <h4 style="text-align: center;">Sales</h4>
                                                                 <h5>Hot + Customer </h5>
                                                                 <ul>     
                                                                      <li>Time Frame ( 15 Days )</li>
                                                                      <li>The customer has the capacity to buy</li>
                                                                      <li>The customer is ready to buy now </li>
                                                                      <li>The customer whose financials are ready </li>
                                                                      <li>The customer whose category of Vehicle is available in stock (Convertion</li>     
                                                                 </ul>
                                                                 <h5>Hot Customer</h5>
                                                                 <ul>     
                                                                      <li>Time Frame (30 Days)</li>
                                                                      <li>The customer has the capacity to buy</li>
                                                                      <li>The customer is ready to buy now</li>
                                                                      <li>The customer whose financials are ready</li>
                                                                      <li>The customer whose category of Vehicle <b>is not available</b> in stock</li>
                                                                 </ul>
                                                                 <h5>Warm Customer</h5>
                                                                 <ul>     
                                                                      <li>Time Frame (60Days)</li>
                                                                      <li>The customer has the capacity to buy</li>
                                                                      <li>The customer will Purchase based on a subject  (Marriage or need to sell his Vehicle Etc)</li>
                                                                      <li>The customer whose financials are ready </li>
                                                                 </ul>
                                                                 <h5>Cold Customer</h5>
                                                                 <ul>     
                                                                      <li>Time Frame (Above 90 Days )</li>
                                                                      <li>The customer has the capacity to buy</li>
                                                                      <li>The customer whose financials are ready </li>
                                                                      <li>The customer has the intention to buy</li>
                                                                 </ul>
                                                                 <h4 style="text-align: center;">Purchase</h4>
                                                                 <h5>Hot + Customer</h5>
                                                                 <ul>     
                                                                      <li>Customer has the intention to sell the vehicle.</li>
                                                                      <li>The price difference is less than 5 lakhs or  less than 5 % of the vehicle value whichever is high.</li>
                                                                      <li>Interest to buy a vehicle subject to the sale of the vehicle and the difference as mentioned above.</li>
                                                                      <li>Customer has the financial liability to sell the vehicle or need to settle the loan in urgent bases.</li>
                                                                 </ul>
                                                                 <h5>Hot Customer</h5>
                                                                 <ul>     
                                                                      <li>Customer has the intention to sell the vehicle.</li>
                                                                      <li>The price difference is between 2 to 5 lakhs or 5 to 10 % of the vehicle value which ever is high.</li>
                                                                      <li>Interest to buy a vehicle subject to the sale of the vehicle and the difference as mentioned above.</li>
                                                                 </ul>
                                                                 <h5>Warm Customer</h5>
                                                                 <ul>     
                                                                      <li>Customer has the intention to sell the vehicle.</li>
                                                                      <li>The price difference is above 5 lakhs or 10 % above the vehicle value whichever is higher.</li>
                                                                 </ul>
                                                                 <h5>Cold Customer</h5>
                                                                 <ul>     
                                                                      <li>All customers having vehicle is Cold customer.</li>
                                                                 </ul>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <!-- -->
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo isset($datas['vreg_customer_remark']) ? strip_tags($datas['vreg_customer_remark']) : '';?>" 
                                                         id="foll_remarks" class="form-control col-md-7 col-xs-12" type="text" name="followup[foll_remarks]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control" name="followup[foll_contact]" id="foll_contact">
                                                       <?php foreach (unserialize(MODE_OF_CONTACT_FOLLOW_UP) as $key => $value) {?>
                                                              <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                         <?php }?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12">Next action plan
                                                  <span class="required">*</span>
                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="true" id="foll_action_plan" class="form-control col-md-7 col-xs-12" type="text" 
                                                         name="followup[foll_action_plan]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12">Next follow up date
                                                  <span class="required">*</span>
                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="true" type="text" class="foll_next_foll_date form-control col-md-7 col-xs-12 dtpNextFollowDate" 
                                                         placeholder="Next follow up date" id="foll_next_foll_date" name="followup[foll_next_foll_date]">
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
          $(".chkNeedProcReq").click(function () {
               if ($(this).is(":checked")) {
                    $(".divProcReq").show();
               } else {
                    $(".divProcReq").hide();
               }
          });
          /*Clone of sell buy table*/
          var vehDetailsSale = $(".vehDetailsSale").prop('outerHTML');
          var vehDetailsBuy = $(".vehDetailsBuy").prop('outerHTML');
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