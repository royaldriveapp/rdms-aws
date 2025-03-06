<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Re-assign or drop stock maching register</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="col-md-7 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                   <div class="panel-heading">Register</div>
                                   <div class="panel-body">
                                        <?php
                                        echo form_open_multipart("enquiry/reassigntosalesstaff", array('id' => "frmVehicleModel", 'class' => "form-horizontal form-label-left", "onsubmit" => "return validateForm()"))
                                        ?>
                                        <input type="hidden" name="vreg_id" value="<?php echo $data['vreg_id']; ?>"/>
                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Effective?</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input <?php echo ($data['vreg_is_effective'] == 1) ? 'checked' : ''; ?> type="checkbox" name="vreg_is_effective" value="1"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Division <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control cmbBindShowroomByDivision" name="vreg_division" id="vreg_division"
                                                          data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom" 
                                                          data-dflt-select="Select Showroom">
                                                       <option value="">Select division</option>
                                                       <?php
                                                       foreach ($division as $key => $value) {
                                                            ?>
                                                            <option <?php echo ($value['div_id'] == $data['vreg_division']) ? 'selected="selected"' : ''; ?>
                                                                 value="<?php echo $value['div_id']; ?>"><?php echo $value['div_name']; ?></option>
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
                                                       <?php foreach ($showroom as $key => $value) { ?>
                                                            <option <?php echo ($value['shr_id'] == $data['vreg_showroom']) ? 'selected="selected"' : ''; ?>
                                                                 value="<?php echo $value['shr_id']; ?>"><?php echo $value['shr_location']; ?></option>
                                                                 <?php
                                                            }
                                                            ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Departments </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control cmbDepartment" name="vreg_department" id="vreg_department">
                                                       <option value="">Select departments</option>
                                                       <?php
                                                       foreach ($department as $key => $value) {
                                                            $parent = !empty($value['dep_parent_name']) ? ' (' . $value['dep_parent_name'] . ')' : '';
                                                            ?>
                                                            <option <?php echo ($value['dep_id'] == $data['vreg_department']) ? 'selected="selected"' : ''; ?>
                                                                 data-issale="<?php echo $value['dep_is_sale_rel']; ?>" value="<?php echo $value['dep_id']; ?>"><?php echo $value['dep_name'] . $parent; ?></option>
                                                                 <?php
                                                            }
                                                            ?>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select disabled="true" required <?php echo $data['vreg_status'] == 1 ? 'disabled' : ''; ?> class="cmbContactMode select2_group form-control" 
                                                          name="vreg_contact_mode" id="vreg_contact_mode" onchange="$(this).val() == 5 ? $('.divEvents').show() : $('.divEvents').hide();">
                                                       <option value="">Select Mode of Contacts</option>
                                                       <optgroup label="RD Mode of Enquiry">
                                                            <?php
                                                            foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                 if (!in_array($key, array(18, 17, 6, 19, 20, 30, 31))) {
                                                                      ?>
                                                                      <option <?php echo ($data['vreg_contact_mode'] == $key) ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $key; ?>"><?php echo $value; ?></option>
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
                                                                      <option <?php echo ($data['vreg_contact_mode'] == $key) ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                           <?php
                                                                      }
                                                                 }
                                                                 ?>
                                                       </optgroup>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Lead type <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control" name="vreg_call_type" id="vreg_call_type">
                                                       <option value="">Select lead type</option>
                                                       <?php
                                                       foreach (unserialize(CALL_TYPE) as $key => $value) {
                                                            ?><option <?php echo ($key == $data['vreg_call_type']) ? 'selected="selected"' : ''; ?> 
                                                                 value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
                                                            }
                                                            ?>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Entry date <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo date('d-m-Y', strtotime($data['vreg_entry_date'])); ?>" required type="text" class="dtpDatePicker form-control col-md-7 col-xs-12"
                                                         name="vreg_entry_date" id="vreg_entry_date" autocomplete="off" placeholder="Entry date"/>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer name <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required type="text" class="form-control col-md-7 col-xs-12" name="vreg_cust_name" id="vreg_cust_name"
                                                         value="<?php echo $data['vreg_cust_name']; ?>" autocomplete="off" placeholder="Customer name"/>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required type="text" class="form-control col-md-7 col-xs-12 numOnly vreg_cust_phone" name="vreg_cust_phone" id="vreg_cust_phone"
                                                         data-url="<?php echo site_url('registration/matchingInquiry'); ?>" 
                                                         autocomplete="off" placeholder="Customer phone" value="<?php echo $data['vreg_cust_phone']; ?>"/>
                                                  <h6 class="vreg_cust_phone_msg" style="color: red;"></h6>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="vreg_cust_place" id="vreg_cust_place"
                                                         value="<?php echo $data['vreg_cust_place']; ?>" autocomplete="off" placeholder="Customer location"/>
                                             </div>
                                        </div>

                                        <div class="divSale">
                                             <?php if (isset($data['dep_is_sale_rel'])) { ?>

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
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="vreg_address" id="vreg_address"
                                                                   value="<?php echo $data['vreg_address']; ?>" autocomplete="off" placeholder="Address"/>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">District <span class="required">*</span></label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control" name="vreg_district" id="vreg_district">
                                                                 <option value="">Select District</option>
                                                                 <?php
                                                                 foreach ($districts as $key => $value) {
                                                                      ?>
                                                                      <option <?php echo $value['std_id'] == $data['vreg_district'] ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $value['std_id']; ?>"><?php echo $value['std_district_name']; ?></option>
                                                                           <?php
                                                                      }
                                                                      ?>
                                                            </select>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Occupation <span class="required">*</span></label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="vreg_occupation" id="vreg_occupation"
                                                                   value="<?php echo $data['vreg_occupation']; ?>" required autocomplete="off" placeholder="Occupation"/>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Company</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="vreg_company" id="vreg_company"
                                                                   value="<?php echo $data['vreg_company']; ?>" autocomplete="off" placeholder="Company"/>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Existing vehicle</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="vreg_existing_vehicle" id="vreg_existing_vehicle"
                                                                   value="<?php echo $data['vreg_existing_vehicle']; ?>" autocomplete="off" placeholder="Existing vehicle"/>
                                                       </div>
                                                  </div>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Brand </label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbEvModel" 
                                                                    data-dflt-select="Select Model" class="select2_group form-control bindToDropdown" name="vreg_brand" id="vreg_brand">
                                                                 <option value="">Select Brand</option>
                                                                 <?php
                                                                 foreach ((array) $brand as $key => $value) {
                                                                      ?>
                                                                      <option <?php echo $value['brd_id'] == $data['vreg_brand'] ? 'selected="selected"' : ''; ?> value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?></option>
                                                                      <?php
                                                                 }
                                                                 ?>
                                                            </select>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Model</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select data-url="<?php echo site_url('enquiry/bindVarient'); ?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                                    class="cmbEvModel select2_group form-control bindToDropdown" name="vreg_model" id="vreg_model">
                                                                         <?php foreach ((array) $model as $key => $value) { ?>
                                                                      <option <?php echo $value['mod_id'] == $data['vreg_model'] ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $value['mod_id']; ?>"><?php echo $value['mod_title']; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Variant </label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control cmbEvVariant" name="vreg_varient" id="vreg_varient">
                                                                 <?php foreach ((array) $variant as $key => $value) { ?>
                                                                      <option <?php echo $value['var_id'] == $data['vreg_varient'] ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $value['var_id']; ?>"><?php echo $value['var_variant_name']; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <?php if (check_permission('registration', 'canassigntose')) { ?>
                                                       <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Assigned to
                                                                 <span class="required">*</span>
                                                            </label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="vreg_assigned_to">
                                                                      <option value="">Select executive</option>
                                                                      <?php if (check_permission('registration', 'canselfassignregister')) { ?>
                                                                           <option <?php echo ($data['vreg_assigned_to'] == $this->uid) ? 'selected="selected"' : ''; ?> 
                                                                                value="<?php echo $this->uid; ?>">Self</option>
                                                                           <?php } foreach ($salesExe as $key => $value) { ?>
                                                                           <option <?php
                                                                           echo ($data['vreg_added_by'] == $value['col_id'] ||
                                                                           ($data['vreg_assigned_to'] == $value['col_id'])) ? 'selected="selected"' : '';
                                                                           ?>
                                                                                value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')'; ?></option>                                               
                                                                           <?php } ?>
                                                                 </select>
                                                            </div>
                                                       </div>
                                                  <?php } else { ?>
                                                       <div class="form-group">
                                                            <input type="hidden" name="vreg_assigned_to" value="<?php echo $data['vreg_assigned_to']; ?>"/>
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                 You have no permission to reassign
                                                            </div>
                                                       </div>
                                                  <?php } ?>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Year</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="numOnly form-control col-md-7 col-xs-12" name="vreg_year" id="vreg_year"
                                                                   value="<?php echo $data['vreg_year']; ?>"  autocomplete="off" placeholder="Year"/>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Investment</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="numOnly form-control col-md-7 col-xs-12" name="vreg_investment" id="vreg_investment"
                                                                   value="<?php echo $data['vreg_investment']; ?>" autocomplete="off" placeholder="Investment"/>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">KM</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="numOnly form-control col-md-7 col-xs-12" name="vreg_km" id="vreg_km"
                                                                   value="<?php echo $data['vreg_km']; ?>" autocomplete="off" placeholder="KM"/>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Ownership</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="numOnly form-control col-md-7 col-xs-12" name="vreg_ownership" id="vreg_ownership"
                                                                   value="<?php echo $data['vreg_ownership']; ?>" autocomplete="off" placeholder="Ownership"/>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Customer status</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control" name="vreg_customer_status" id="vreg_customer_status">
                                                                 <option value="">Please select customer status</option>
                                                                 <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $key => $value) { ?>
                                                                      <option <?php echo $key == $data['vreg_customer_status'] ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>

                                                  <div class="divRefer"></div>
                                                  <div class="divModOfContact"></div>
                                             <?php } ?>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer remarks <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <textarea class="form-control col-md-7 col-xs-12" name="vreg_customer_remark" 
                                                            id="vreg_customer_remark" placeholder="Customer remarks"><?php echo $data['vreg_customer_remark']; ?></textarea>
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
                              <div class="panel panel-default">
                                   <div class="panel-heading">Drop</div>
                                   <div class="panel-body">
                                        <form method="post" action="<?php echo site_url('registration/changeRegisterStatus'); ?>" 
                                              class="form-horizontal form-label-left frmRequestForDrop">
                                             <input type="hidden" name="regMaster" value="<?php echo $data['vreg_id']; ?>"/>
                                             <input type="hidden" name="status" value="<?php echo reg_droped; ?>"/>
                                             <input type="hidden" name="callback" value="registration/informStockToCustomer"/>
                                             <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12">Reason for drop <span class="required">*</span>
                                                  </label>
                                                  <div class="col-md-8 col-sm-6 col-xs-12">
                                                       <textarea required name="reason" class="txtDropRegReason form-control col-md-5 col-xs-12 "></textarea>
                                                  </div>
                                             </div>
                                             <div class="ln_solid"></div>
                                             <div class="form-group">
                                                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
                                                       <input type="submit" class="btn btn-primary btnRequestForDrop" value="Drop register"/>
                                                  </div>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>