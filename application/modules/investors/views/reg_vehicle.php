<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New Investor</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="col-md-8 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                   <div class="panel-heading">New Investor</div>
                                   <div class="panel-body">
                                        <?php
                                        echo form_open_multipart($controller . "/add", array('id' => "frmVehicleModel",
                                            'class' => "form-horizontal form-label-left", "onsubmit" => "return validateForm()"))
                                        ?>
                                        <input type="hidden" name="vreg_voxbay_ref" value="<?php echo $voxbayId; ?>"/>
                                        <input type="hidden" name="vreg_tele_type" value="<?php echo $teleType; ?>"/>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Entry date <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo date('d-m-Y'); ?>" required type="text" class="dtpDatePicker form-control col-md-7 col-xs-12"
                                                         name="details[invd_entry_date]" id="invd_entry_date" autocomplete="off" placeholder="Entry date"/>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required type="text" class="form-control col-md-7 col-xs-12" name="master[inv_name]" id="inv_name"
                                                         autocomplete="off" placeholder="Customer name"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="master[inv_address]" id="inv_address"
                                                         autocomplete="off" placeholder="Address"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">District <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control" name="master[inv_dist]" id="inv_dist">
                                                       <option value="">Select District</option>
                                                       <?php
                                                       foreach ($districts as $key => $value) {
                                                            ?>
                                                            <option value="<?php echo $value['std_id']; ?>"><?php echo $value['std_district_name']; ?></option>
                                                            <?php
                                                       }
                                                       ?>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Occupation <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class=" form-control col-md-7 col-xs-12" name="master[inv_occupation]" id="inv_occupation"
                                                         required autocomplete="off" placeholder="Occupation"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Company </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class=" form-control col-md-7 col-xs-12" name="master[inv_company]" id="inv_company"
                                                         autocomplete="off" placeholder="Company"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Primary phone <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required type="text" class="form-control col-md-7 col-xs-12 numOnly vreg_cust_phone" 
                                                         name="phone[invp_phone][]" id="invp_phone"
                                                         data-url="<?php echo site_url($controller . '/matchingInquiry'); ?>" 
                                                         autocomplete="off" placeholder="Primary phone" value="<?php echo $customerNumber; ?>"/>
                                                  <h6 class="vreg_cust_phone_msg" style="color: red;"><?php echo isset($ifEnqAlready) ? $ifEnqAlready : ''; ?></h6>
                                             </div>
                                             <a onclick="$('.divPhoneNumbers').append($('.divTemPhone').html());" href="javascriot:void(0)" style="margin-top: 10px;float: left;"><i class="fa fa-plus"></i></a>
                                        </div>
                                        <div class="divTemPhone" style="display: none;">
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Alternate Phone <span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input required type="text" class="form-control col-md-7 col-xs-12 numOnly vreg_cust_phone" name="phone1" id="invp_phone"
                                                              data-url="<?php echo site_url($controller . '/matchingInquiry'); ?>" 
                                                              autocomplete="off" placeholder="Alternate phone" value="<?php echo $customerNumber; ?>"/>
                                                       <h6 class="vreg_cust_phone_msg" style="color: red;"><?php echo isset($ifEnqAlready) ? $ifEnqAlready : ''; ?></h6>
                                                  </div>
                                                  <a onclick="$(this).parent('div').remove();" href="javascriot:void(0)" style="margin-top: 10px;float: left;">
                                                       <i class="fa fa-minus"></i>
                                                  </a>
                                             </div>
                                        </div>
                                        <div class="divPhoneNumbers"></div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="master[inv_email]" id="inv_email"
                                                         autocomplete="off" placeholder="Email"/>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Address proof</label>
                                             <div class="col-md-3 col-sm-3 col-xs-12">
                                                  <select name="proof[invpf_proof_id][]" class="select2_group form-control">
                                                       <option value="0">Select one</option>
                                                       <?php foreach ($addressProof as $key => $value) { ?>
                                                            <option value="<?php echo $value['adp_id']; ?>"><?php echo $value['adp_proof_title']; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                             <div class="col-md-3 col-sm-3 col-xs-12">
                                                  <input class="select2_group form-control" type="text" name="proof[invpf_proof_number][]" 
                                                         placeholder="Address proof number"/>
                                             </div>
                                             <a onclick="$('.divAddressProof').append($('.divTemAddressProof').html());" href="javascriot:void(0)" 
                                                style="margin-top: 10px;float: left;"><i class="fa fa-plus"></i></a>
                                        </div>

                                        <div class="divAddressProof"></div>

                                        <div class="divTemAddressProof" style="display: none;">
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Address proof</label>
                                                  <div class="col-md-3 col-sm-3 col-xs-12">
                                                       <select name="proof[invpf_proof_id][]" class="select2_group form-control">
                                                            <option value="0">Select one</option>
                                                            <?php foreach ($addressProof as $key => $value) { ?>
                                                                 <option value="<?php echo $value['adp_id']; ?>"><?php echo $value['adp_proof_title']; ?></option>
                                                            <?php } ?>
                                                       </select>
                                                  </div>
                                                  <div class="col-md-3 col-sm-3 col-xs-12">
                                                       <input class="select2_group form-control" type="text" name="proof[invpf_proof_number][]" 
                                                              placeholder="Address proof number"/>
                                                  </div>
                                                  <a onclick="$(this).parent('div').remove();" href="javascriot:void(0)" 
                                                     style="margin-top: 10px;float: left;"><i class="fa fa-minus"></i></a>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control cmbRegisterModeOfContact" name="details[invd_contact_mode]" id="invd_contact_mode">
                                                       <option value="">Select Mode of Contacts</option>
                                                       <optgroup label="RD Mode of Enquiry">
                                                            <?php
                                                            foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                 if (!in_array($key, array(18, 17, 6, 19, 20, 30, 31))) {
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
                                                                 if (in_array($key, array(18, 17, 6, 19, 20, 30, 31))) {
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
                                        </div>
                                        <div class="divRefereals"></div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="master[inv_location]" id="inv_location"
                                                         autocomplete="off" placeholder="Customer location"/>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Invested in other company</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="company[invd_inv_amount][]" id="invd_inv_amount"
                                                         autocomplete="off" placeholder="Invested in other company"/>
                                             </div>
                                             <a onclick="$('.divInvestLocation').append($('.divTemInvestLocation').html());" href="javascriot:void(0)" 
                                                style="margin-top: 10px;float: left;"><i class="fa fa-plus"></i></a>
                                        </div>

                                        <div class="divInvestLocation"></div>
                                        <div class="divTemInvestLocation" style="display: none;">
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Invested in other company</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input class="select2_group form-control" type="text" name="company[invd_inv_amount][]" 
                                                              id="invd_inv_amount" placeholder="Invested in other company"/>
                                                  </div>
                                                  <a onclick="$(this).parent('div').remove();" href="javascriot:void(0)" 
                                                     style="margin-top: 10px;float: left;"><i class="fa fa-minus"></i></a>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Time of investment</label>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control" name="details[invd_tim_year]" id="vreg_contact_mode">
                                                       <option value="">Year</option>
                                                       <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i . ' Year'; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control" name="details[invd_tim_month]" id="vreg_contact_mode">
                                                       <option value="">Month</option>
                                                       <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i . ' Month'; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Investment amount</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="details[invd_inv_amount]" 
                                                         id="invd_inv_amount" autocomplete="off" placeholder="Investment amount"/>
                                             </div>
                                        </div>
                                        <!-- -->
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Current vehicle</label>
                                             <div class="col-md-3 col-sm-7 col-xs-12">
                                                  <select data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbEvModel" 
                                                          data-dflt-select="Select Model" class="cmbBrand select2_group form-control bindToDropdown" name="veh[invv_brand][]" id="invv_brand">
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
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <select data-url="<?php echo site_url('enquiry/bindVarient'); ?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                          class="cmbEvModel select2_group form-control bindToDropdown" name="veh[invv_model][]" id="invv_model">
                                                  </select>
                                             </div>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control cmbEvVariant" name="veh[invv_varient][]" id="invv_varient"></select>
                                             </div>
                                             <a class="bindToDiv" href="javascriot:void(0)" 
                                                data-url="<?php echo site_url($controller . '/bindToDiv'); ?>" 
                                                data-bind="divExistingVehicle" style="margin-top: -25px;float: right;margin-right: -8px;">
                                                  <i class="fa fa-plus"></i>
                                             </a>
                                        </div>

                                        <div class="divExistingVehicle"></div>
                                        <div class="form-group">
                                             <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Customer status</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control" name="details[invd_status]" id="invd_status">
                                                       <option value="">Please select customer status</option>
                                                       <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $key => $value) { ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>
                                        <!-- -->
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer remarks <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <textarea  class="form-control col-md-7 col-xs-12" name="details[invd_coment]" id="invd_coment" placeholder="Customer remarks"></textarea>
                                             </div>
                                        </div>
                                        <div class="divSale"></div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                             <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                  <button type="submit" class="btn btn-success btnSubmitRegister">Submit</button>
                                             </div>
                                        </div>
                                        <?php echo form_close() ?>
                                   </div>
                              </div>
                         </div>
                         <div class="col-md-4 col-sm-12 col-xs-12">
                              <div class="panel panel-default divRegisterHistory">
                                   <div class="panel-heading">Previous history</div>
                                   <div class="panel-body">
                                        <?php if (!empty($reghistory)) { ?>
                                             <ul class="list-unstyled timeline">
                                                  <?php
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
                                                                           <span><?php echo 'Place : ' . $value['vreg_cust_place']; ?></span>
                                                                      </p>
                                                                 </div>
                                                                 <div class="block_content">
                                                                      <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                           <span><?php echo 'Dist : ' . isset($value['std_district_name']) ? $value['std_district_name'] : ''; ?></span>
                                                                      </p>
                                                                 </div>
                                                                 <div class="block_content">
                                                                      <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                           <span><?php echo 'Assign to : ' . $value['assto_usr_name']; ?></span>
                                                                      </p>
                                                                 </div>
                                                                 <div class="block_content">
                                                                      <?php $addorreassign = ($value['fwon_usr_id'] == $value['adby_usr_id']) ? 'Added by ' : 'Re-assgned by '; ?>
                                                                      <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                           <span><?php echo $addorreassign . $value['fwon_usr_name']; ?></span>
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

<!-- -->
<div class="tmpSaleRelated">
     <div class="form-group rfrl_type">
          <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Referal Type</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select class="select2_group form-control referal_type" name="referal_type" id="referal_type">
                    <option value="">Please select</option>
                    <?php foreach (unserialize(REFERAL_TYPES) as $key => $value) { ?>
                         <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
               </select>
          </div>
     </div>

     <div class="form-group rfrl_typeChld" style="display: none" id="referal_details">
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Staff</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <select  id="referalRdStaffs" class="referalRdStaffs select2_group form-control staff_select" name="referal_name1"></select>
               </div>
          </div>
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="referal_phone1" id="referal_phone1"
                           autocomplete="off" placeholder="Referal phone"/>
               </div>
          </div>
     </div>
     <div class="form-group rfrl_typeChld" style="display: none" id="referal_details2">
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Phone</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input  type="text" class="form-control col-md-7 col-xs-12 numOnly customer_phone" name="referal_phone2" id="customer_phone"
                            data-url="<?php echo site_url('registration/customerByPhone'); ?>" 
                            autocomplete="off" placeholder="Referal phone(Customer)" value="<?php echo $customerNumber; ?>"/>
                    <h6 class="customer_phone_msg" id="customer_phone_msg" style="color: red;"></h6>
               </div>
          </div>
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" name="referal_name2" id="referal_customer_name"
                           autocomplete="off" placeholder="Referal Name"/>
               </div>
          </div>
          <input type="hidden"  name="referal_enq_cus_id" id="referal_enq_cus_id"  />

     </div>
     <div class="form-group rfrl_typeChld" style="display: none" id="referal_details3">

          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" name="referal_name3" id="referal_name3"
                           autocomplete="off" placeholder="Referal Name"/>
               </div>
          </div>
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12 numOnly " name="referal_phone3" id="referal_phone3"
                           autocomplete="off" placeholder="Referal phone"/>
               </div>
          </div>
     </div>
     <div class="divRefer"></div>
     <div class="divModOfContact"></div>
</div>
<!-- -->

<script>

     function validateForm() {
          var text = document.getElementById('vreg_customer_remark').value.trim();
          if (text.length < 30) {
               alert('Please enter atleast 30 characters in customer feedback');
               return false;
          } else {
               $('.btnSubmitRegister').prop('disabled', true);
               return true;
          }
     }
</script>