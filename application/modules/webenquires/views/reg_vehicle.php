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
                                   <div class="panel-heading">New register</div>
                                   <div class="panel-body">
                         <?php
                           echo form_open_multipart($controller . "/add", array('id' => "frmVehicleModel", 'class' => "form-horizontal form-label-left", "onsubmit" => "return validateForm()"))
                         ?>
                         <!-- These will remove -->
                         <input type="hidden" name="hash" value='<?php echo $hid;?>'/>
                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Effective?</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="checkbox" name="vreg_is_effective" value="1"/>
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Division <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control cmbBindShowroomByDivision" name="vreg_division" id="vreg_division"
                                           data-url="<?php echo site_url('enquiry/bindShowroomByDivision');?>" data-bind="cmbShowroom" 
                                           data-dflt-select="Select Showroom">
                                        <option value="">Select division</option>
                                        <?php
                                          foreach ($division as $key => $value) {
                                               ?>
                                               <option value="<?php echo $value['div_id'];?>"><?php echo $value['div_name'];?></option>
                                               <?php
                                          }
                                        ?>
                                   </select>
                              </div>
                         </div>

                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Showroom <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select required class="select2_group form-control cmbShowroom" name="vreg_showroom" id="vreg_showroom">
                                        <option value="">Select showroom</option>
                                   </select>
                              </div>
                         </div>

                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Departments</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control cmbDepartment" name="vreg_department" id="vreg_department">
                                        <option value="">Select departments</option>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select required class="select2_group form-control cmbContactMode" name="vreg_contact_mode" id="vreg_contact_mode">
                                        <option value="">Select Mode of Contacts</option>
                                        <optgroup label="RD Mode of Enquiry">
                                             <?php
                                               foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                    if (!in_array($key, array(18, 17, 6, 19, 20))) {
                                                         ?>
                                                         <option <?php echo ($mod == $key) ? 'selected="selected"' : '';?>
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
                                                         <option <?php echo ($mod == $key) ? 'selected="selected"' : '';?> 
                                                              value="<?php echo $key;?>"><?php echo $value;?></option>
                                                              <?php
                                                         }
                                                    }
                                                  ?>
                                        </optgroup>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Lead type </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select <?php echo ($this->usr_grp != 'TC') ? 'required' : '';?> class="select2_group form-control" name="vreg_call_type" id="vreg_call_type">
                                        <option value="">Select lead type</option>
                                        <?php
                                          foreach (unserialize(CALL_TYPE) as $key => $value) {
                                               ?><option value="<?php echo $key;?>"><?php echo $value;?></option><?php
                                          }
                                        ?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Entry date <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo date('d-m-Y');?>" required type="text" class="dtpDatePicker form-control col-md-7 col-xs-12"
                                          name="vreg_entry_date" id="vreg_entry_date" autocomplete="off" placeholder="Entry date"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer name <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="vreg_cust_name" id="vreg_cust_name"
                                          value="<?php echo isset($customerName) ? $customerName : '';?>" 
                                          autocomplete="off" placeholder="Customer name"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12 numOnly vreg_cust_phone" name="vreg_cust_phone" id="vreg_cust_phone"
                                          data-url="<?php echo site_url('registration/matchingInquiry');?>" 
                                          autocomplete="off" placeholder="Customer phone" value="<?php echo $customerNumber;?>"/>
                                   <h6 class="vreg_cust_phone_msg" style="color: red;"><?php echo isset($ifEnqAlready) ? $ifEnqAlready : '';?></h6>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" class="form-control col-md-7 col-xs-12" name="vreg_cust_place" id="vreg_cust_place"
                                          autocomplete="off" placeholder="Customer location"/>
                              </div>
                         </div>

                         <div class="divSale"></div>


                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer says</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <span><?php echo isset($fulldata['cws_comments']) ? $fulldata['cws_comments'] : '';?></span>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer remarks <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <textarea class="form-control col-md-7 col-xs-12" name="vreg_customer_remark" id="vreg_customer_remark" placeholder="Customer remarks"></textarea>
                              </div>
                         </div>

                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success btnSubmitRegister">Submit</button>
                                   <button class="btn btn-primary" type="reset">Reset</button>
                              </div>
                         </div>
                         <?php echo form_close()?>
                         </div>
                         </div>
                         </div>
                         <div class="col-md-5 col-sm-12 col-xs-12">
                              <div class="panel panel-default divRegisterHistory">
                                   <div class="panel-heading">Previous history</div>
                                   <div class="panel-body">
                                        <?php if (!empty($reghistory)) {?>
                                               <ul class="list-unstyled timeline">
                                                    <?php
                                                    foreach ($reghistory as $key => $value) {
                                                         ?>
                                                         <li>
                                                              <div class="block">
                                                                   <div class="tags">
                                                                        <a href="javascript:;" class="tag">
                                                                             <span><?php echo date('j M Y', strtotime($value['vreg_added_on']));?></span>
                                                                        </a>
                                                                   </div>
                                                                   <div class="block_content">
                                                                        <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                             <span><?php echo 'Customer name : ' . $value['vreg_cust_name'];?></span>
                                                                        </p>
                                                                   </div>
                                                                   <div class="block_content">
                                                                        <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                             <span><?php echo 'Assign to : ' . $value['assto_usr_name'];?></span>
                                                                        </p>
                                                                   </div>
                                                                   <div class="block_content">
                                                                        <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                             <span><?php echo 'Added by : ' . $value['adby_usr_name'];?></span>
                                                                        </p>
                                                                   </div>
                                                                   <!-- Repeated contents -->
                                                                   <div style="font-style: italic;background: #E7E7E7;padding: 10px;">
                                                                        <p class="excerpt"><?php echo $value['vreg_customer_remark'];?></p>
                                                                   </div>
                                                              </div>
                                                         </li>
                                                         <?php
                                                    }
                                                    ?>
                                               </ul>
                                          <?php } else {?>
                                               <span>No previous history found</span>
                                          <?php }?>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="tmpModOfContact" style="display: none;">
     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Assigned to
               <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="vreg_assigned_to">
                    <option value="">Select mode of assign</option>
                    <option value="0">Auto assign to sales executives</option>
                    <option value="<?php echo $this->uid;?>">Self</option>
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
               <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="vreg_assigned_to">
                    <option value="">Select executive</option>
                    <option value="<?php echo $this->uid;?>">Self</option>
                    <?php foreach ($salesExe as $key => $value) {?>
                           <option value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')';?></option>                                               
                      <?php }?>
               </select>
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
</div>

<div class="tmpSaleRelated" style="display: none;">
     <div class="form-group divEvents" style="display: none;">
          <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Events</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select class="select2_group form-control" name="vreg_event" id="vreg_event">
                    <option value="">Select Event</option>
                    <?php
                      foreach ($events as $key => $value) {
                           ?>
                           <option value="<?php echo $value['evnt_id'];?>"><?php echo $value['evnt_title'];?></option>
                           <?php
                      }
                    ?>
               </select>
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Brand</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select data-url="<?php echo site_url('enquiry/bindModel');?>" data-bind="cmbEvModel" 
                       data-dflt-select="Select Model" class="cmbBrand select2_group form-control bindToDropdown" name="vreg_brand" id="vreg_brand">
                    <option value="">Select Brand</option>
                    <?php
                      if (!empty($brand)) {
                           foreach ($brand as $key => $value) {
                                ?>
                                <option <?php echo ($brd_sel == $value['brd_id']) ? 'selected="selected"' : '';?>
                                     value="<?php echo $value['brd_id'];?>"><?php echo $value['brd_title'];?></option>
                                     <?php
                                }
                           }
                         ?>
               </select>
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Model</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select data-url="<?php echo site_url('enquiry/bindVarient');?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                       class="cmbEvModel select2_group form-control bindToDropdown" name="vreg_model" id="vreg_model">
                            <?php foreach ($model as $key => $value) {?>
                           <option <?php echo ($mod_sel == $value['mod_id']) ? 'selected="selected"' : '';?> 
                                value="<?php echo $value['mod_id'];?>"><?php echo $value['mod_title'];?></option>
                           <?php }?>
               </select>
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Variant</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select class="select2_group form-control cmbEvVariant" name="vreg_varient" id="vreg_varient">
                    <?php foreach ($variant as $key => $value) {?>
                           <option <?php echo ($var_sel == $value['var_id']) ? 'selected="selected"' : '';?> 
                                value="<?php echo $value['var_id'];?>"><?php echo $value['var_variant_name'];?></option>
                           <?php }?>
               </select>
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Year</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="text" class="numOnly form-control col-md-7 col-xs-12" name="vreg_year" id="vreg_year"
                      autocomplete="off" placeholder="Year"/>
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Investment</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="text" class="numOnly form-control col-md-7 col-xs-12" name="vreg_investment" id="vreg_investment"
                      autocomplete="off" placeholder="Investment"/>
          </div>
     </div>

     <div class="form-group">
          <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Customer status</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select required class="select2_group form-control" name="vreg_customer_status" id="vreg_customer_status">
                    <option value="">Please select customer status</option>
                    <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $key => $value) {?>
                           <option value="<?php echo $key;?>"><?php echo $value;?></option>
                      <?php }?>
               </select>
          </div>
     </div>

     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Assigned to
               <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="vreg_assigned_to">
                    <option value="">Select executive</option>
                    <option value="<?php echo $this->uid;?>">Self</option>
                    <?php foreach ($salesExe as $key => $value) {?>
                           <option value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')';?></option>                                               
                      <?php }?>
               </select>
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

<script>
     function validateForm() {
          var text = document.getElementById('vreg_customer_remark').value.trim();
          if (text.length < 30) {
               alert('Please enter atleast 40 characters in customer feedback');
               return false;
          } else {
               return true;
          }
     }
</script>