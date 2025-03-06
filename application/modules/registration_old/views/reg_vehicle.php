<style>
     .x_panel {
          width: 100% !important;
          padding: 10px 7px !important;
          display: inline-block !important;
          background: #a9aaac42 !important;
          border: 7px dotted #fffffff2 !important;
          -webkit-column-break-inside: avoid !important;
          -moz-column-break-inside: avoid !important;
          column-break-inside: avoid !important;
          opacity: 1;
          transition: all .2s ease !important;
     }

     .error {
          color: red;
     }

     .excerpt {

          overflow-wrap: break-word !important;
     }

     /* New Customer */
     .lbl {
          color: black !Important;
     }

     .bg-gray {
          background-color: #cacaca !important;
     }

     .brd-radi {
          border-radius: 0px !important;
          border-top-left-radius: 0px !important;
          border-top-right-radius: 0px !important;
          border-bottom-right-radius: 35px !important;
          border-bottom-left-radius: 35px !important;
     }

     .h-brd-radi {
          border-radius: 0px !important;
          border-top-left-radius: 35px !important;
          border-top-right-radius: 35px !important;
          border-bottom-right-radius: 0px !important;
          border-bottom-left-radius: 0px !important;

     }

     .modal-content {
          border: 7px solid rgba(0, 0, 0, .2) !important;
          border-radius: 42px !important;
     }

     /* @New Customer */
     /* lbl fld alignment */
     /* Styles for the phone field input and button */
     .phone-field-custom .phone-input {
          flex: 1;
     }

     .phone-field-custom .phone-button {
          margin-left: -73px;
          /* Add spacing between input and button */
     }

     /* @lbl fld alignment */
</style>
<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Quick vehicle register</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="col-md-7 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                   <div class="panel-heading">New register
                                        <?php
                                        $f_err = $this->session->flashdata('f_err');
                                        if ($f_err) {

                                        ?>

                                             <div class="alert alert-danger">
                                                  <strong>Error!</strong> <?php

                                                                           print_r($f_err);

                                                                           ?>
                                             </div>
                                        <?php } ?>
                                   </div>
                                   <div class="panel-body">
                                        <?php
                                        echo form_open_multipart($controller . "/add", array('id' => "frmVehicleModel", 'class' => "form-horizontal form-label-left", "onsubmit" => "return validateForm()"))
                                        ?>
                                        <input type="hidden" name="<?php echo isset($reference) ? $reference : 'vreg_voxbay_ref'; ?>" value="<?php echo $voxbayId; ?>" />
                                        <input type="hidden" name="vreg_tele_type" value="<?php echo $teleType; ?>" />
                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Effective?</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="checkbox" name="vreg_is_effective" value="1" />
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Division
                                                  <?php echo isset($mandatory['vreg_division']) ? '<span class="required">*</span>' : ''; ?>
                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control cmbBindShowroomByDivision" name="vreg_division" id="vreg_division" data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom" <?php echo isset($mandatory['vreg_division']) ? 'required' : ''; ?> data-dflt-select="Select Showroom">
                                                       <option value="">Select division</option>
                                                       <?php
                                                       foreach ($division as $key => $value) {
                                                       ?>
                                                            <option value="<?php echo $value['div_id']; ?>"><?php echo $value['div_name']; ?></option>
                                                       <?php
                                                       }
                                                       ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Showroom <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control cmbShowroom shorm_stf" name="vreg_showroom" id="vreg_showroom">
                                                       <option value="">Select showroom</option>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Departments
                                                  <?php echo isset($mandatory['vreg_department']) ? '<span class="required">*</span>' : ''; ?>
                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select <?php echo isset($mandatory['vreg_department']) ? 'required' : ''; ?> class="select2_group form-control cmbDepartment" name="vreg_department" id="vreg_department">
                                                       <option value="">Select departments</option>
                                                  </select>
                                             </div>
                                        </div>
                                        <!-- <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control cmbContactMode" name="vreg_contact_mode" id="vreg_contact_mode">
                                                       <option value="">Select Mode of Contacts</option>
                                                       <optgroup label="RD Mode of Enquiry">
                                                            <?php
                                                            foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                 if (!in_array($key, array(18, 17, 6, 19, 20, 30, 31, 34))) {
                                                            ?>
                                                                        <option <?php echo ($mod == $key) ? 'selected="selected"' : ''; ?> 
                                                                             value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                             <?php
                                                                           }
                                                                      }
                                                                                ?>
                                                       </optgroup>
                                                       <optgroup label="Own Mode of Enquiry">
                                                            <?php
                                                            foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                 if (in_array($key, array(18, 17, 6, 19, 20, 30, 31, 34))) {
                                                            ?>
                                                                        <option <?php echo ($mod == $key) ? 'selected="selected"' : ''; ?> 
                                                                             value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                             <?php
                                                                           }
                                                                      }
                                                                                ?>
                                                       </optgroup>
                                                  </select>
                                             </div>
                                        </div> -->

                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control cmbContactMode" name="vreg_contact_mode" id="vreg_contact_mode">
                                                       <option value="">Select Mode of Contacts</option>
                                                       <optgroup label="RD Mode of Enquiry">
                                                            <?php foreach ($mode_of_contact as $mode) : ?>
                                                                 <?php if (!in_array($mode['cmd_mod_id'], [18, 17, 6, 19, 20, 30, 31, 34])) : ?>
                                                                      <option value="<?php echo $mode['cmd_mod_id']; ?>"><?php echo $mode['cmd_title']; ?></option>
                                                                 <?php endif; ?>
                                                            <?php endforeach; ?>
                                                       </optgroup>
                                                       <optgroup label="Own Mode of Enquiry">
                                                            <?php foreach ($mode_of_contact as $mode) : ?>
                                                                 <?php if (in_array($mode['cmd_mod_id'], [18, 17, 6, 19, 20, 30, 31, 34])) : ?>
                                                                      <option value="<?php echo $mode['cmd_mod_id']; ?>"><?php echo $mode['cmd_title']; ?></option>
                                                                 <?php endif; ?>
                                                            <?php endforeach; ?>
                                                       </optgroup>
                                                  </select>
                                             </div>
                                        </div>

                                        <!-- $ -->
                                        <div class="form-group rfrl_type" style="display: none">
                                             <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Referal Type
                                                  <?php echo isset($mandatory['referal_type']) ? '<span class="required">*</span>' : ''; ?>
                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select <?php echo isset($mandatory['referal_type']) ? 'required' : ''; ?> class="select2_group form-control referal_type" name="referal_type" id="referal_type">
                                                       <option value="">Please select</option>
                                                       <?php foreach (unserialize(REFERAL_TYPES) as $key => $value) { ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group rfrl_typeChld" style="display: none" id="referal_details">
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Staff </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select id="referalRdStaffs" class="referalRdStaffs select2_group form-control staff_select" name="referal_name1"></select>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="text" class="form-control col-md-7 col-xs-12 numOnly " value="" name="referal_phone1" id="referal_phone1" autocomplete="off" placeholder="Referal phone" />

                                                  </div>
                                             </div>
                                        </div>
                                        <div class="form-group rfrl_typeChld" style="display: none" id="referal_details2">
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Phone</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <!-- <input  type="text" class="form-control col-md-7 col-xs-12 numOnly customer_phone" name="referal_phone2" id="customer_phone"
                           data-url="<?php echo site_url('registration_1/customerByPhone'); ?>" 
                           autocomplete="off" placeholder="Referal phone(Customer)" value="<?php echo $customerNumber; ?>"/> -->
                                                       <input type="text" class="form-control col-md-7 col-xs-12 numOnly customer_phone" name="referal_phone2" id="customer_phone" data-url="<?php echo site_url('registration/customerByPhone'); ?>" autocomplete="off" placeholder="Referal phone(Customer)" value="<?php echo $customerNumber; ?>" />
                                                       <h6 class="customer_phone_msg" id="customer_phone_msg" style="color: red;"></h6>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="text" class="form-control col-md-7 col-xs-12" name="referal_name2" id="referal_customer_name" autocomplete="off" placeholder="Referal Name" />
                                                  </div>
                                             </div>
                                             <input type="hidden" name="referal_enq_cus_id" id="referal_enq_cus_id" />

                                        </div>
                                        <div class="form-group rfrl_typeChld" style="display: none" id="referal_details3">
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="text" class="form-control col-md-7 col-xs-12" name="referal_name3" id="referal_name3" autocomplete="off" placeholder="Referal Name" />
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="text" class="form-control col-md-7 col-xs-12 numOnly " name="referal_phone3" id="referal_phone3" autocomplete="off" placeholder="Referal phone" />
                                                  </div>
                                             </div>
                                        </div>
                                        <!-- @ -->
                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Lead type
                                                  <?php echo isset($mandatory['vreg_call_type']) ? '<span class="required">*</span>' : ''; ?>
                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select <?php echo isset($mandatory['vreg_call_type']) ? 'required' : ''; ?> class="select2_group form-control" name="vreg_call_type" id="vreg_call_type">
                                                       <option value="0">Select lead type</option>
                                                       <?php
                                                       foreach (unserialize(CALL_TYPE) as $key => $value) {
                                                       ?><option value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
                                                                                                                        }
                                                                                                                             ?>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Entry date <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo date('d-m-Y'); ?>" required type="text" class="dtpDatePicker form-control col-md-7 col-xs-12" name="vreg_entry_date" id="vreg_entry_date" autocomplete="off" placeholder="Entry date" />
                                             </div>
                                        </div>
                                        <!-- search by phone -->
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required type="text" class="form-control col-md-7 col-xs-12 numOnly vreg_cust_phone cust_search" name="vreg_cust_phone" id="vreg_cust_phone" data-url="<?php echo site_url('registration/matchingInquiry'); ?>" autocomplete="off" placeholder="Customer phone" value="<?php echo $existingCustomer['cusd_phone']; ?>" />
                                                  <!-- new -->

                                                  <small id="no_customer_message" class="text-danger" style="display:none;">There is no customer found. Please add a new customer.</small>
                                                  <!-- End new -->
                                                  <h6 class="vreg_cust_phone_msg" style="color: red;"><?php echo isset($ifEnqAlready) ? $ifEnqAlready : ''; ?></h6>
                                             </div>
                                             <button type="button" class="homeVisit btn btn-warning" data-toggle="modal" data-target="#homeVisit">+New</button>
                                        </div>
                                        <!-- End search by phone -->
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer name <span class="required">*</span> </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required type="text" class="form-control col-md-7 col-xs-12" name="vreg_cust_name" id="vreg_cust_name" value="<?php echo isset($existingCustomer['cusd_name']) ? $existingCustomer['cusd_name'] : ''; ?>" autocomplete="off" placeholder="Customer name" readonly />
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Location
                                                  <?php echo isset($mandatory['vreg_cust_place']) ? '<span class="required">*</span>' : ''; ?>
                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input <?php echo isset($mandatory['vreg_cust_place']) ? 'required' : ''; ?> type="text" class="form-control col-md-7 col-xs-12" name="vreg_cust_place" id="vreg_cust_place" value="<?php echo isset($existingCustomer['cusd_place']) ? $existingCustomer['cusd_place'] : ''; ?>" autocomplete="off" placeholder="Customer location" readonly />
                                             </div>
                                        </div>
                                        <input type="hidden" name="vreg_cust_id" id="vreg_customer_id" value="<?php echo isset($existingCustomer['cusd_id']) ? $existingCustomer['cusd_id'] : ''; ?>" required>
                                        <input type="hidden" name="vreg_district" id="vreg_district" value="<?php echo isset($existingCustomer['cusd_district']) ? $existingCustomer['cusd_district'] : ''; ?>" required>
                                        <div class="divSale"></div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer remarks <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <textarea required class="form-control col-md-7 col-xs-12" name="vreg_customer_remark" id="<?php echo ($this->usr_grp != 'TC') ? 'vreg_customer_remark' : ''; ?>" placeholder="Customer remarks"></textarea>
                                             </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                             <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                  <button type="submit" class="btn btn-success btnSubmitRegister">Submit</button>
                                                  <button class="btn btn-primary" type="reset">Reset</button>
                                             </div>
                                        </div>
                                        <?php echo form_close() ?>
                                   </div>
                              </div>
                         </div>
                         <div class="col-md-5 col-sm-12 col-xs-12">
                              <div class="form-group">
                                   <label class="control-label col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-6 col-xs-6 txtGotoWp" />
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a class="btnGotoWp" target="_blank"><input class="btn btn-primary" type="button" value="Go to Whatsapp" /></a>
                                   </div>
                              </div>
                         </div>
                         <div class="col-md-5 col-sm-12 col-xs-12">
                              <div class="panel panel-default divRegisterHistory">
                                   <div class="panel-heading">Previous history</div>
                                   <div class="panel-body">
                                        <?php if (!empty($reghistory)) { ?>
                                             <ul class="list-unstyled timeline">
                                                  <?php
                                                  $modes = unserialize(MODE_OF_CONTACT);
                                                  foreach ($reghistory as $key => $value) {
                                                  ?>
                                                       <li>
                                                            <div class="block">
                                                                 <div class="tags">
                                                                      <a href="javascript:;" class="tag">
                                                                           <span><?php echo date('j M Y', strtotime($value['vreg_added_on'])); ?></span>
                                                                      </a>
                                                                 </div>
                                                                 <div class="block_content">
                                                                      <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                           <span><?php echo 'Customer name : ' . $value['vreg_cust_name']; ?></span>
                                                                      </p>
                                                                 </div>
                                                                 <div class="block_content">
                                                                      <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                           <span><?php echo !empty($value['vreg_cust_place']) ? 'Place : ' . $value['vreg_cust_place'] : ''; ?></span>
                                                                      </p>
                                                                 </div>
                                                                 <div class="block_content">
                                                                      <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                           <span><?php echo isset($value['std_district_name']) ? 'Dist : ' . $value['std_district_name'] : ''; ?></span>
                                                                      </p>
                                                                 </div>
                                                                 <div class="block_content">
                                                                      <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                           <span><?php echo 'Assign to : ' . $value['assto_usr_name']; ?></span>
                                                                      </p>
                                                                 </div>
                                                                 <div class="block_content">
                                                                      <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                           <span><?php echo 'Assigned BY : ' . $value['adby_usr_name']; ?></span>
                                                                      </p>
                                                                 </div>
                                                                 <div class="block_content">
                                                                      <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                           <span><?php echo 'First Added By : ' . $value['fwon_usr_name']; ?></span>
                                                                      </p>
                                                                 </div>
                                                                 <div class="block_content">
                                                                      <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                           <span><?php echo  isset($modes[$value['vreg_contact_mode']]) ? 'Mode of contact : ' . $modes[$value['vreg_contact_mode']] : ''; ?></span>
                                                                      </p>
                                                                 </div>
                                                                 <!-- Repeated contents -->
                                                                 <div style="font-style: italic;background: #E7E7E7;padding: 10px;">
                                                                      <p class="excerpt"><?php echo $value['vreg_customer_remark']; ?></p>
                                                                 </div>

                                                                 <?php if (isset($value['vreg_last_action']) && !empty($value['vreg_last_action'])) { ?>
                                                                      <div>Reassigned by : <?php echo $value['adby_usr_name']; ?></div>
                                                                      <span class="glyphicon glyphicon-comment"><?php echo $value['vreg_last_action']; ?></span>
                                                                 <?php } ?>

                                                            </div>
                                                       </li>
                                                  <?php
                                                  }
                                                  ?>
                                             </ul>
                                        <?php } else { ?>
                                             <span>No previous history found</span>
                                        <?php } ?>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<!--<div class="tmpModOfContact" style="display: none;">
     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Assigned to
               <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="vreg_assigned_to">
                    <option value="">Select mode of assign</option>
                    <option value="0">Auto assign to sales executives</option>
                    <option value="<?php echo $this->uid; ?>">Self</option>
               </select>
          </div>
     </div>
</div>

<div class="tmpAllExecutives" style="display: none;">
     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Assigned to
               <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
<?php /* if (check_permission('registration', 'canselfassignregister')) {?>
    <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="vreg_assigned_to">
    <option value="">Select executive</option>
    <option value="<?php echo $this->uid;?>">Self</option>
    <?php foreach ($salesExe as $key => $value) {?>
    <option value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')';?></option>
    <?php }?>
    </select>
    <?php } else {?>
    <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="vreg_assigned_to">
    <option value="">Select executive</option>
    <?php foreach ($salesExe as $key => $value) {?>
    <option value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')';?></option>
    <?php }?>
    </select>
    <?php } */ ?>
          </div>
     </div>
</div>
<div class="tmpRefer" style="display: none;">
     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Refer division <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select required class="select2_group form-control cmbDivisionRefer" name="vreg_refer_division" id="vreg_refer_division"></select>
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Refer showroom <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select required class="select2_group form-control cmbShowroomRefer" name="vreg_refer_showroom" id="vreg_refer_showroom"></select>
          </div>
     </div>
</div>-->

<div class="tmpSaleRelated" style="display: none;">

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Occupation <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="vreg_occupation" id="vreg_occupation" required autocomplete="off" placeholder="Occupation" />
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Company </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="vreg_company" id="vreg_company" autocomplete="off" placeholder="Company" />
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Existing vehicle</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12" name="vreg_existing_vehicle" id="vreg_existing_vehicle" autocomplete="off" placeholder="Existing vehicle" />
          </div>
     </div>

     <div class="form-group divEvents" style="display: none;">
          <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Events</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select class="select2_group form-control" name="vreg_event" id="vreg_event">
                    <option value="">Select Event</option>
                    <?php
                    foreach ($events as $key => $value) {
                    ?>
                         <option value="<?php echo $value['evnt_id']; ?>"><?php echo $value['evnt_title']; ?></option>
                    <?php
                    }
                    ?>
               </select>
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Desired Brand<?php echo ($this->desi != 'AH' || $this->desi != 'CRE') ? '*' : ''; ?></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select <?php echo ($this->desi != 'AH' || $this->desi != 'CRE') ? 'required' : ''; ?> data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbEvModel" data-dflt-select="Select Model" class="cmbBrand select2_group form-control bindToDropdown" name="vreg_brand" id="vreg_brand">
                    <option value="">Select Brand</option>
                    <?php
                    if (!empty($brand)) {
                         foreach ($brand as $key => $value) {
                    ?>
                              <option value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?></option>
                    <?php
                         }
                    }
                    ?>
               </select>
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Model<?php echo ($this->desi != 'AH') ? '*' : ''; ?></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select <?php echo ($this->desi != 'AH') ? 'required' : ''; ?> data-url="<?php echo site_url('enquiry/bindVarient'); ?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant" class="cmbEvModel select2_group form-control bindToDropdown" name="vreg_model" id="vreg_model">
               </select>
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Variant</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select class="select2_group form-control cmbEvVariant" name="vreg_varient" id="vreg_varient"></select>
          </div>
     </div>

     <!-- <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Year</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="number" class="numOnly form-control col-md-7 col-xs-12" name="vreg_year" id="vreg_year"
                      autocomplete="off" placeholder="Year"/>
          </div>
     </div> -->
     <div class="form-group">
          <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Year <span class="required"><?php echo ($this->desi != 'AH') ? '*' : ''; ?> </span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <!--               <input type="text" class="numOnly form-control col-md-7 col-xs-12" name="vreg_year" id="vreg_year"
                      autocomplete="off" placeholder="Year"/>-->

               <select <?php echo ($this->desi != 'AH') ? 'required' : ''; ?> class="select2_group form-control " name="vreg_year" id="vreg_year" data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>">
                    <option value="">Select year</option>
                    <?php for ($i = 1947; $i <= date('Y'); $i++) { ?>
                         <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
               </select>

          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Present Investment Plan</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="number" class="numOnly form-control col-md-7 col-xs-12" name="vreg_investment" id="vreg_investment" autocomplete="off" placeholder="Investment" />
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">KM</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="number" class="numOnly form-control col-md-7 col-xs-12" name="vreg_km" id="vreg_km" autocomplete="off" placeholder="KM" />
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Ownership</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="number" class="numOnly form-control col-md-7 col-xs-12" name="vreg_ownership" id="vreg_ownership" autocomplete="off" placeholder="Ownership" />
          </div>
     </div>

     <div class="form-group">
          <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Customer status</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select <?php echo ($this->usr_grp != 'TC') ? 'required' : ''; ?> class="select2_group form-control" name="vreg_customer_status" id="vreg_customer_status">
                    <option value="">Please select customer status</option>
                    <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $key => $value) { ?>
                         <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
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
                                   <li>The customer will Purchase based on a subject (Marriage or need to sell his Vehicle Etc)</li>
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
                                   <li>The price difference is less than 5 lakhs or less than 5 % of the vehicle value whichever is high.</li>
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
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Assigned to
               <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <?php if (check_permission('registration', 'canselfassignregister')) { ?>
                    <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="vreg_assigned_to">
                         <option value="">Select executive</option>
                         <option value="<?php echo $this->uid; ?>">Self</option>
                         <?php foreach ($salesExe as $key => $value) { ?>
                              <option value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')'; ?></option>
                         <?php } ?>
                    </select>
               <?php } else { ?>
                    <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="vreg_assigned_to">
                         <option value="">Select executive</option>
                         <?php foreach ($salesExe as $key => $value) { ?>
                              <option value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')'; ?></option>
                         <?php } ?>
                    </select>
               <?php } ?>
          </div>
     </div>

     <!--                         <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Refer this case</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input style="margin-top: 12px;" class="chkReferThisCase" type="checkbox"/>
                                   </div>
                              </div>-->

     <div class="divRefer"></div>
     <div class="divModOfContact"></div>
</div>

<!--Add New Customer  -->
<div class="modal fade" id="homeVisit" role="dialog">
     <div class="modal-dialog ">
          <?php echo form_open_multipart("customers/storeCustomer", array('id' => "customer_form", 'class' => "submitCustomer  modal-content form-horizontal form-label-left")) ?>
          <div class="modal-header bg-gray h-brd-radi">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title lbl"> Add New Cutomer <span class="msg"></span></h4>

          </div>
          <div class="modal-body bg-gray brd-radi">
               <div class="mdl_div">
                    <div class='flds'>


                         <div class="row">
                              <div class="form-group col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                   <label class="lbl col-md-3 col-form-label text-right">Name <span class="required">*</span></label>
                                   <div class="col-md-9">
                                        <input type="text" class="form-control col-md-7 col-xs-12" name="new_cus_name" placeholder="Enter Customer Name" required>
                                   </div>
                              </div>
                              <!-- <div class="form-group col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
        <label class="lbl col-md-3 col-form-label text-right">Phone <span class="required">*</span></label>
        <div class="col-md-9">
            <input type="text" class="form-control col-md-7 col-xs-12 numOnly" id="new_cus_phone" name="new_cus_phone" placeholder="Enter Customer Phone" required>
        </div>
    </div> -->
                              <div class="form-group col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                   <label class="lbl col-md-3 col-form-label text-right">Phone<span class="required">*</span></label>
                                   <div class="col-md-9">
                                        <div id="phone-container">
                                             <div class="phone-field mb-2 d-flex align-items-center phone-field-custom">
                                                  <input type="text" class="form-control numOnly phone-input" name="new_cus_phone[]" placeholder="Enter Customer Phone" required>
                                                  <button type="button" class="btn btn-success add-phone phone-button">+Ph</button>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div class="form-group col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                   <label class="lbl col-md-3 col-form-label text-right">Email</label>
                                   <div class="col-md-9">
                                        <input type="text" class="form-control col-md-7 col-xs-12" name="new_cus_email" placeholder="Enter Email">
                                   </div>
                              </div>
                              <div class="form-group col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                   <label class="lbl col-md-3 col-form-label text-right">Location</label>
                                   <div class="col-md-9">
                                        <input type="text" class="form-control col-md-7 col-xs-12" name="new_cus_location" placeholder="Enter Location">
                                   </div>
                              </div>
                              <div class="form-group col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                   <label class="lbl col-md-3 col-form-label text-right">Address</label>
                                   <div class="col-md-9">
                                        <input type="text" class="form-control col-md-7 col-xs-12" name="new_cus_address" placeholder="Enter Address">
                                   </div>
                              </div>
                              <div class="form-group col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                   <label class="lbl col-md-3 col-form-label text-right">District<span class="required">*</span></label>
                                   <div class="col-md-9">
                                        <select name="new_cus_district" id="new_cus_district" class="form-control col-md-6 col-xs-6 travel_mod" required>
                                             <option value="0">-Select-</option>
                                             <?php foreach ($districts as $key => $value) : ?>
                                                  <option value="<?php echo $value['std_id']; ?>"><?php echo $value['std_district_name']; ?></option>
                                             <?php endforeach; ?>
                                        </select>
                                   </div>
                              </div>
                         </div>






                    </div>
               </div>
               <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
               <?php echo form_close() ?>
          </div>
     </div>
</div>
<!-- End add new customer -->
<script>
     function validateForm() {
          // Validate customer feedback length
          const feedback = document.getElementById('vreg_customer_remark').value.trim();
          if (feedback.length < 30) {
               alert('Please enter at least 30 characters in customer feedback');
               return false;
          }

          // Validate customer ID
          const customerId = document.getElementById('vreg_customer_id').value.trim();
          if (!customerId) {
               alert('Please select a valid customer');
               return false;
          }

          // Disable submit button to prevent duplicate submissions
          document.querySelector('.btnSubmitRegister').disabled = true;

          // Return true if all validations pass
          return true;
     }

     $(document).ready(function() {
          $(".txtGotoWp").bind("paste", function(e) {
               var pastedData = e.originalEvent.clipboardData.getData('text');
               $('.btnGotoWp').attr('href', "https://api.whatsapp.com/send?phone=" + pastedData);
          });
     });
     //Customer form
     document.addEventListener("DOMContentLoaded", function() {
// Attach event listener for form submission
const form = document.querySelector("#customer_form");
const noCusMessage = document.getElementById('no_customer_message');
form.addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(form);

    // Get the form's action URL dynamically
    const actionUrl = form.getAttribute("action");

    // Show a loading indicator (optional)
    const submitButton = form.querySelector("button[type='submit']");
    submitButton.disabled = true;
    submitButton.textContent = "Submitting...";

    // Send data via AJAX
    fetch(actionUrl, {
            method: "POST",
            body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Display success message
                alert("Customer added successfully!");
                for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        // retrieve all phone numbers
        const phoneNumbers = formData.getAll("new_cus_phone[]");

        // Debugging: Alert first phone number
        if (phoneNumbers.length > 0) {
            //alert(phoneNumbers[0]);
            document.getElementById("vreg_cust_phone").value = phoneNumbers[0];
            noCusMessage.style.display = 'none';
        } else {
            alert("No phone numbers found.");
        }
                document.getElementById("vreg_cust_name").value = formData.get("new_cus_name");
                document.getElementById("vreg_cust_place").value = formData.get("new_cus_location");
                document.getElementById("vreg_customer_id").value = data.customer_id; //API returns the new customer ID
                document.getElementById("vreg_district").value = formData.get("new_cus_district");

                //fields read-only
                document.getElementById("vreg_cust_name").readOnly = true;
                document.getElementById("vreg_cust_place").readOnly = true;
                document.getElementById("vreg_district").readOnly = true;

                form.reset(); // Clear the form fields
                $('#homeVisit').modal('hide'); // Hide the modal
            } else {
                // Display error message
                alert("Error: " + (data.message || "An error occurred."));
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("An unexpected error occurred. Please try again.");
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.textContent = "Submit";
        });
});


     });

     //End customer form
     // Search
     document.addEventListener('DOMContentLoaded', function() {

          const phoneInput = document.getElementById('vreg_cust_phone');
          const nameInput = document.getElementById('vreg_cust_name');
          const placeInput = document.getElementById('vreg_cust_place');
          const customerId = document.getElementById('vreg_customer_id');
          const customerDistrict = document.getElementById('vreg_district');
          const noCustomerMessage = document.getElementById('no_customer_message'); // Message element

          phoneInput.addEventListener('input', function() {
               const phone = this.value.trim();

               // Only trigger if input has at least 10 digits
               if (phone.length >= 10) {
                    fetch(`${site_url}customers/searchCustomerByPhone?phone=${phone}`)
                         .then(response => response.json())
                         .then(customer => {
                              // Reset fields and message
                              nameInput.value = '';
                              nameInput.readOnly = true;
                              placeInput.value = '';
                              placeInput.readOnly = true;
                              customerId.value = '';
                              customerDistrict.value = '';
                              noCustomerMessage.style.display = 'none';

                              if (customer && customer.cusd_id) {
                                   // Auto-fill customer details
                                   nameInput.value = customer.cusd_name;
                                   nameInput.readOnly = true;
                                   placeInput.value = customer.cusd_place;
                                   placeInput.readOnly = true;
                                   customerId.value = customer.cusd_id;
                                   customerDistrict.value = customer.cusd_district;
                                   matchingEnq(customer.cusd_id);
                              } else {
                                   $('.vreg_cust_phone_msg').html('');
                                   $('.divRegisterHistory').html(`
    <div class="panel-heading">Previous history</div>
    <div class="panel-body">
        <span>No previous history found..</span>
    </div>
`);

                                   // Show "no customer found" message
                                   noCustomerMessage.textContent = 'There is no customer found. Please add a new customer.';
                                   noCustomerMessage.style.display = 'block';
                              }
                         })
                         .catch(err => {
                              console.error('Error fetching data:', err);
                              noCustomerMessage.textContent = 'Error fetching customer data. Please try again.';
                              noCustomerMessage.style.display = 'block';
                         });
               } else {
                    // Clear fields and message for invalid input
                    nameInput.value = '';
                    nameInput.readOnly = true;
                    placeInput.value = '';
                    placeInput.readOnly = true;
                    customerId.value = '';
                    customerDistrict.value = '';
                    noCustomerMessage.style.display = 'none';
               }
          });

          //End serach
          //Auto trigger Model
          const showModal = <?php echo json_encode((bool)$showModal); ?>;
          //alert(showModal); 
          if (showModal) {
               document.getElementById("new_cus_phone").value = <?php echo json_encode($customerNumber); ?>;
               $('#homeVisit').modal('show');
          }
          //End Auto trigger Model

              // Matching enq operations
    function matchingEnq(customerId) {
        // Trigger .vreg_cust_id logic
        registerAssociationByCusId();
//alert(customerId);
        const url = $('.vreg_cust_phone').data('url');
        if (customerId && url !== '') {
            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                data: { 'customerId': customerId },
                success: function (resp) {
                    $('.vreg_cust_phone_msg').html(resp.msg);
                    $('.divRegisterHistory').html(resp.regHistory);

                    if (resp.usr_id) {
                        $('#cmbRegisterAssignTo [value=' + resp.usr_id + ']').attr('selected', 'true');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error in AJAX request:', error);
                }
            });
        }
    }

    // handling associations
    function registerAssociationByCusId() {
        if ($('.chkReferThisCase').prop("checked") === true) {
            $('.divRefer').html($('.tmpRefer').html());
        } else {
            $('.divRefer').html('');
            $('.divModOfContact').html('');
        }

        const regStatus = $('#vreg_customer_status').val();
        const mod = $('.cmbContactMode').val();
        mod == 5 ? $('.divEvents').show() : $('.divEvents').hide();
        mod == 34 ? $('.rfrl_type').show() : $('.rfrl_type').hide();
        mod != 30 ? $('.rfrl_typeChld').hide() : '';
        $('.divModOfContact').html('');
        $('.vreg_cust_phone_msg').html('');

        if ([1, 5, 9, 10, 11, 12, 13, 7, 16, 14, 2, 3, 4, 8, 15, 21, 22].includes(mod)) {
            const url = $('.vreg_cust_phone').data('url');
            if (customerId && url !== '') {
                $.ajax({
                    type: 'post',
                    url: url,
                    dataType: 'json',
                    data: { 'customerId': customerId },
                    success: function (resp) {
                        $('.vreg_cust_phone_msg').html(resp.msg);
                        if (resp.usr_id) {
                            $('#cmbRegisterAssignTo [value=' + resp.usr_id + ']').attr('selected', 'true');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error in AJAX request:', error);
                    }
                });
            }
        } else if (!$('.chkReferThisCase').prop("checked") && (regStatus == 2 || regStatus == 3)) {
            $('.divModOfContact').html($('.tmpModOfContact').html());
        }
    }

     });
</script>
<script>
     document.addEventListener('DOMContentLoaded', () => {
          const phoneContainer = document.getElementById('phone-container');

          // Add new phone field
          phoneContainer.addEventListener('click', function(e) {
               if (e.target.classList.contains('add-phone')) {
                    const newPhoneField = document.createElement('div');
                    newPhoneField.className = 'phone-field mb-2 d-flex align-items-center phone-field-custom';
                    newPhoneField.innerHTML = `
                <input type="text" class="form-control numOnly phone-input" name="new_cus_phone[]" placeholder="Enter Customer Phone" required>
                <button type="button" class="btn btn-danger remove-phone phone-button">-</button>
            `;
                    phoneContainer.appendChild(newPhoneField);
               }
          });

          // Rmv phone field
          phoneContainer.addEventListener('click', function(e) {
               if (e.target.classList.contains('remove-phone')) {
                    e.target.parentElement.remove();
               }
          });
     });
</script>