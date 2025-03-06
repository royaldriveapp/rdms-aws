<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Edit Investor</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="col-md-8 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                   <div class="panel-heading">Edit Investor</div>
                                   <div class="panel-body">
                                        <?php echo form_open_multipart($controller . "/update", array('id' => "frmNewInvester", 'class' => "form-horizontal form-label-left")); ?>
                                        <input type="hidden" name="inv_id" value="<?php echo $master['inv_id']; ?>" />
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="mstr[inv_name]" id="inv_name"
                                                         value="<?php echo $master['inv_name']; ?>" autocomplete="off" placeholder="Customer name"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="numOnlyj form-control col-md-7 col-xs-12" name="mstr[inv_address]" id="inv_address"
                                                         value="<?php echo $master['inv_address']; ?>" autocomplete="off" placeholder="Address"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">District <span class="">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control" name="mstr[inv_dist]" id="inv_dist">
                                                       <option value="">Select District</option>
                                                       <?php
                                                       foreach ($districts as $key => $value) {
                                                            ?>
                                                            <option <?php echo ($master['inv_dist'] == $value['std_id']) ? 'selected="selected"' : ''; ?>
                                                                 value="<?php echo $value['std_id']; ?>"><?php echo $value['std_district_name']; ?></option>
                                                                 <?php
                                                            }
                                                            ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <!-- -->
                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control cmbModOfCntInvestor" name="mstr[inv_mode_of_cntct]" id="invd_contact_mode">
                                                       <option value="">Select Mode of Contacts</option>
                                                       <optgroup label="RD Mode of Enquiry">
                                                            <?php
                                                            foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                 if (!in_array($key, array(18, 17, 6, 19, 20, 30, 31))) {
                                                                      ?> 
                                                                      <option <?php echo ($master['inv_mode_of_cntct'] == $key) ? 'selected="selected"' : ''; ?>
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
                                                                      <option <?php echo ($master['inv_mode_of_cntct'] == $key) ? 'selected="selected"' : ''; ?>
                                                                           value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                           <?php
                                                                      }
                                                                 }
                                                                 ?>
                                                       </optgroup>
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="divRefereals">
                                             <?php if ($master['inv_mode_of_cntct'] == 34) { ?>
                                                  <div class="form-group">
                                                       <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Referal Type</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="form-control col-md-7 col-xs-12 cmbReferalType" name="mstr[inv_ref_type]" id="referal_type">
                                                                 <option value="">Please select</option>
                                                                 <?php foreach (unserialize(REFERAL_TYPES) as $key => $value) { ?>
                                                                      <option <?php echo ($master['inv_ref_type'] == $key) ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             <?php } ?>
                                        </div>
                                        <div class="divRefTypes">
                                             <?php if ($master['inv_ref_type'] == 5) {// Rd customer ?>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Phone</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input  type="text" class="form-control col-md-7 col-xs-12 numOnly customer_phone" 
                                                                    name="mstr[inv_ref_cotact_no]" id="customer_phone"
                                                                    value="<?php echo $master['inv_ref_cotact_no']; ?>"
                                                                    data-url="<?php echo site_url('registration/customerByPhone'); ?>" 
                                                                    autocomplete="off" placeholder="Referal phone (Customer)"/>
                                                            <h6 class="customer_phone_msg" id="customer_phone_msg" style="color: red;"></h6>
                                                       </div>
                                                  </div>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="mstr[inv_ref_name]" 
                                                                   value="<?php echo $master['inv_ref_name']; ?>" id="referal_customer_name"
                                                                   autocomplete="off" placeholder="Referal Name"/>
                                                       </div>
                                                  </div>
                                                  <input type="hidden" value="<?php echo $master['inv_ref_cust_id']; ?>" 
                                                         name="mstr[inv_ref_cust_id]" id="referal_enq_cus_id"/>
                                                    <?php } else if ($master['inv_ref_type'] == 4) {//Rd Staff ?>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Staff</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select  id="referalRdStaffs" class="referalRdStaffs select2_group form-control staff_select" 
                                                                     name="mstr[inv_ref_staff]">
                                                                          <?php foreach ($staff as $sKey => $stfVal) { ?>
                                                                      <option <?php echo ($master['inv_ref_staff'] == $stfVal['col_id']) ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $stfVal['col_id']; ?>"><?php echo $stfVal['col_title']; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             <?php } else { ?>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="mstr[inv_ref_name]" id="referal_name3"
                                                                   value="<?php echo $master['inv_ref_name']; ?>" autocomplete="off" placeholder="Referal Name"/>
                                                       </div>
                                                  </div>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 numOnly " name="mstr[inv_ref_cotact_no]" id="referal_phone3"
                                                                   value="<?php echo $master['inv_ref_cotact_no']; ?>" autocomplete="off" placeholder="Referal phone"/>
                                                       </div>
                                                  </div>
                                             <?php } ?>
                                        </div>
                                        <!-- -->

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Occupation <span class="">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class=" form-control col-md-7 col-xs-12" name="mstr[inv_occupation]" id="inv_occupation"
                                                         value="<?php echo $master['inv_occupation']; ?>" autocomplete="off" placeholder="Occupation"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Company </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class=" form-control col-md-7 col-xs-12" name="mstr[inv_company]" id="inv_company"
                                                         value="<?php echo $master['inv_company']; ?>" autocomplete="off" placeholder="Company"/>
                                             </div>
                                        </div>
                                        <?php
                                        if (!empty($phone)) {
                                             foreach ($phone as $key => $numbers) {
                                                  ?>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="">*</span></label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 numOnly vreg_cust_phone" 
                                                                   name="cnct[invp_phone_u][<?php echo $numbers['invp_id']; ?>]" value="<?php echo $numbers['invp_phone']; ?>"
                                                                   autocomplete="off" placeholder="Customer phone"/>
                                                       </div>
                                                       <a onclick="$(this).parent('div').remove();" href="javascriot:void(0)" style="margin-top: 10px;float: left;">
                                                            <i class="fa fa-minus"></i>
                                                       </a>
                                                  </div>
                                                  <?php
                                             }
                                        }
                                        ?>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 numOnly vreg_cust_phone" name="cnct[invp_phone][]"
                                                         autocomplete="off" placeholder="Customer phone"/>
                                             </div>
                                             <a onclick="$('.divPhoneNumbers').append($('.divTemPhone').html());" href="javascriot:void(0)" style="margin-top: 10px;float: left;">
                                                  <i class="fa fa-plus"></i></a>
                                        </div>
                                        <div class="divPhoneNumbers"></div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="mstr[inv_email]" id="inv_email"
                                                         value="<?php echo $master['inv_email']; ?>" autocomplete="off" placeholder="Email"/>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <?php $time = unserialize(INV_CONV_TIME); ?>
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Convenient time</label>
                                             <div class="col-md-3 col-sm-3 col-xs-12">
                                                  <select name="mstr[inv_conv_time_frm]" class="select2_group form-control">
                                                       <option value="0">Time from</option>
                                                       <?php foreach ($time as $key => $value) { ?>
                                                            <option <?php echo ($master['inv_conv_time_frm'] == $key) ? 'selected="selected"' : ''; ?> 
                                                                 value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                             <div class="col-md-3 col-sm-3 col-xs-12">
                                                  <select name="mstr[inv_conv_time_to]" class="select2_group form-control">
                                                       <option value="0">Time to</option>
                                                       <?php foreach ($time as $key => $value) { ?>
                                                            <option <?php echo ($master['inv_conv_time_to'] == $key) ? 'selected="selected"' : ''; ?>  
                                                                 value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                             <i style="float: left;padding-left: 26%;">Convenient time to talk with customer</i>
                                        </div>
                                        <?php
                                        if (!empty($proof)) {
                                             foreach ($proof as $key => $proofD) {
                                                  ?>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Address proof</label>
                                                       <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <select name="ap[invpf_proof_id_u][<?php echo $proofD['invpf_id']; ?>]" class="select2_group form-control">
                                                                 <option value="0">Select one</option>
                                                                 <?php foreach ($addressProof as $key => $addValue) { ?>
                                                                      <option <?php echo ($proofD['invpf_proof_id'] == $addValue['adp_id']) ? 'selected="selected"' : ''; ?>
                                                                           value="<?php echo $addValue['adp_id']; ?>"><?php echo $addValue['adp_proof_title']; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                       <div class="col-md-3 col-sm-3 col-xs-12">
                                                            <input class="select2_group form-control" type="text" name="ap[invpf_proof_number_u][<?php echo $proofD['invpf_id']; ?>]" 
                                                                   value="<?php echo $proofD['invpf_proof_number']; ?>"  placeholder="Address proof number"/>
                                                       </div>
                                                       <a onclick="$(this).parent('div').remove();" href="javascriot:void(0)" style="margin-top: 10px;float: left;">
                                                            <i class="fa fa-minus"></i>
                                                       </a>
                                                  </div>
                                                  <?php
                                             }
                                        }
                                        ?>
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Address proof</label>
                                             <div class="col-md-3 col-sm-3 col-xs-12">
                                                  <select name="ap[invpf_proof_id][]" class="select2_group form-control">
                                                       <option value="0">Select one</option>
                                                       <?php foreach ($addressProof as $key => $value) { ?>
                                                            <option value="<?php echo $value['adp_id']; ?>"><?php echo $value['adp_proof_title']; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                             <div class="col-md-3 col-sm-3 col-xs-12">
                                                  <input class="select2_group form-control" type="text" name="ap[invpf_proof_number][]" 
                                                         placeholder="Address proof number"/>
                                             </div>
                                             <a onclick="$('.divAddressProof').append($('.divTemAddressProof').html());" href="javascriot:void(0)" 
                                                style="margin-top: 10px;float: left;"><i class="fa fa-plus"></i></a>
                                        </div>

                                        <div class="divAddressProof"></div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="mstr[inv_location]" id="inv_location"
                                                         value="<?php echo $master['inv_location']; ?>" autocomplete="off" placeholder="Customer location"/>
                                             </div>
                                        </div>

                                        <?php
                                        if (!empty($otherInvest)) {
                                             foreach ($otherInvest as $key => $othInv) {
                                                  ?>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Other investments</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="select2_group form-control" type="text" name="company[invic_company_u][<?php echo $othInv['invic_id']; ?>]" 
                                                                   value="<?php echo $othInv['invic_company']; ?>"  placeholder="Invested in other company"/>
                                                       </div>
                                                       <a onclick="$(this).parent('div').remove();" href="javascriot:void(0)" style="margin-top: 10px;float: left;">
                                                            <i class="fa fa-minus"></i>
                                                       </a>
                                                  </div>
                                                  <?php
                                             }
                                        }
                                        ?>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Other investments</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" name="company[invic_company][]" id="invd_inv_amount"
                                                         autocomplete="off" placeholder="Invested in other company"/>
                                             </div>
                                             <a onclick="$('.divInvestLocation').append($('.divTemInvestLocation').html());" href="javascriot:void(0)" 
                                                style="margin-top: 10px;float: left;"><i class="fa fa-plus"></i></a>
                                        </div>

                                        <div class="divInvestLocation"></div>

                                        <?php
                                        if (!empty($vehle)) {
                                             foreach ($vehle as $key => $veh) {
                                                  $model = $this->enquiry->getModelByBrand($veh['invv_brand']);
                                                  $variant = $this->enquiry->getVariantByModel($veh['invv_model']);
                                                  ?>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Current vehicle</label>
                                                       <div class="col-md-3 col-sm-7 col-xs-12">

                                                            <select data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbEvModel<?php echo $veh['invv_id']; ?>" 
                                                                    data-dflt-select="Select Model" class="cmbBrand select2_group form-control bindToDropdown" 
                                                                    name="veh[invv_brand_u][<?php echo $veh['invv_id']; ?>]" id="invv_brand">
                                                                 <option value="">Select Brand</option>
                                                                 <?php
                                                                 if (!empty($brand)) {
                                                                      foreach ($brand as $key => $value) {
                                                                           ?>
                                                                           <option <?php echo ($value['brd_id'] == $veh['invv_brand']) ? 'selected="selected"' : ''; ?>
                                                                                value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?></option>
                                                                                <?php
                                                                           }
                                                                      }
                                                                      ?>
                                                            </select>
                                                       </div>
                                                       <div class="col-md-3 col-sm-6 col-xs-12">
                                                            <select data-url="<?php echo site_url('enquiry/bindVarient'); ?>" data-bind="cmbEvVariant<?php echo $veh['invv_id']; ?>" data-dflt-select="Select Variant"
                                                                    class="cmbEvModel<?php echo $veh['invv_id']; ?> select2_group form-control bindToDropdown" 
                                                                    name="veh[invv_model_u][<?php echo $veh['invv_id']; ?>]" id="invv_model">
                                                                         <?php foreach ($model as $mk => $mdl) { ?>
                                                                      <option <?php echo ($mdl['mod_id'] == $veh['invv_model']) ? 'selected="selected"' : ''; ?>
                                                                           value="<?php echo $mdl['mod_id']; ?>"><?php echo $mdl['mod_title']; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                       <div class="col-md-3 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control cmbEvVariant<?php echo $veh['invv_id']; ?>" name="veh[invv_varient_u][<?php echo $veh['invv_id']; ?>]" id="invv_varient">
                                                                 <?php foreach ($variant as $mk => $rvnt) { ?>
                                                                      <option <?php echo ($rvnt['var_id'] == $veh['invv_varient']) ? 'selected="selected"' : ''; ?>
                                                                           value="<?php echo $rvnt['var_id']; ?>"><?php echo $rvnt['var_variant_name']; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                       <a onclick="$(this).parent('div').remove();" href="javascriot:void(0)" style="margin-top: -25px;float: right;margin-right: -8px;"><i class="fa fa-minus"></i></a>
                                                  </div>
                                                  <?php
                                             }
                                        }
                                        ?>

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

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                             <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                  <button type="submit" class="btn btn-success" name="submit" value="submit">Submit</button>
                                             </div>
                                        </div>
                                        <?php echo form_close() ?>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="divTemAddressProof" style="display: none;">
     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Address proof</label>
          <div class="col-md-3 col-sm-3 col-xs-12">
               <select name="ap[invpf_proof_id][]" class="select2_group form-control">
                    <option value="0">Select one</option>
                    <?php foreach ($addressProof as $key => $value) { ?>
                         <option value="<?php echo $value['adp_id']; ?>"><?php echo $value['adp_proof_title']; ?></option>
                    <?php } ?>
               </select>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
               <input class="select2_group form-control" type="text" name="ap[invpf_proof_number][]" 
                      placeholder="Address proof number"/>
          </div>
          <a onclick="$(this).parent('div').remove();" href="javascriot:void(0)" 
             style="margin-top: 10px;float: left;"><i class="fa fa-minus"></i></a>
     </div>
</div>
<div class="divTemPhone" style="display: none;">
     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Alternate Phone <span class="">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="text" class="form-control col-md-7 col-xs-12 numOnly vreg_cust_phone" name="cnct[invp_phone][]"
                      autocomplete="off" placeholder="Customer phone"/>
          </div>
          <a onclick="$(this).parent('div').remove();" href="javascriot:void(0)" style="margin-top: 10px;float: left;">
               <i class="fa fa-minus"></i>
          </a>
     </div>
</div>
<div class="divTemInvestLocation" style="display: none;">
     <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Other investments</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <input class="select2_group form-control" type="text" name="company[invic_company][]" 
                      id="invd_inv_amount" placeholder="Invested in other company"/>
          </div>
          <a onclick="$(this).parent('div').remove();" href="javascriot:void(0)" 
             style="margin-top: 10px;float: left;"><i class="fa fa-minus"></i></a>
     </div>
</div>

<div class="tmpSaleRelated">
     <div class="divRefType" style="display: none;">
          <div class="form-group">
               <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Referal Type</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <select required class="form-control col-md-7 col-xs-12 cmbReferalType" name="mstr[inv_ref_type]" id="referal_type">
                         <option value="">Please select</option>
                         <?php foreach (unserialize(REFERAL_TYPES) as $key => $value) { ?>
                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                         <?php } ?>
                    </select>
               </div>
          </div>
     </div>
</div>

<div>
     <div class="form-group divRefStaff" style="display: none" id="referal_details">
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Staff</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <select  id="referalRdStaffs" class="referalRdStaffs select2_group form-control staff_select" name="mstr[inv_ref_staff]"></select>
               </div>
          </div>
     </div>
     <div class="form-group divRefCust" style="display: none" id="referal_details2">
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Phone</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input  type="text" class="form-control col-md-7 col-xs-12 numOnly customer_phone" name="mstr[inv_ref_cotact_no]" id="customer_phone"
                            data-url="<?php echo site_url('registration/customerByPhone'); ?>" 
                            autocomplete="off" placeholder="Referal phone (Customer)"/>
                    <h6 class="customer_phone_msg" id="customer_phone_msg" style="color: red;"></h6>
               </div>
          </div>
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" name="mstr[inv_ref_name]" id="referal_customer_name"
                           autocomplete="off" placeholder="Referal Name"/>
               </div>
          </div>
          <input type="hidden"  name="mstr[inv_ref_cust_id]" id="referal_enq_cus_id"/>
     </div>
     <div class="form-group divRefOthers" style="display: none" id="referal_details3">
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" name="mstr[inv_ref_name]" id="referal_name3"
                           autocomplete="off" placeholder="Referal Name"/>
               </div>
          </div>
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12 numOnly " name="mstr[inv_ref_cotact_no]" id="referal_phone3"
                           autocomplete="off" placeholder="Referal phone"/>
               </div>
          </div>
     </div>
</div>

<script>
     $(document).ready(function () {
          $(document).on('change', '.cmbModOfCntInvestor', function (e) {
               var mod = $(this).val();
               if (mod == 34) {
                    $('.divRefereals').append($('.divRefType').html());
               }
          });
          $(document).on('change', '.cmbReferalType', function () {
               var type = $(this).val();
               if (type == 5) {//Rd customer
                    $('.divRefTypes').html($('.divRefCust').html());
               } else if (type == 4) {//Rd Staff
                    $.ajax({
                         type: 'get',
                         url: "<?php echo site_url($controller . '/getAllRdStaffs'); ?>",
                         dataType: 'json',
                         success: function (resp) {
                              $('.referalRdStaffs').html('<option value="">-Select staff-</option>');
                              $.each(resp, function (index, value) {
                                   if (value.shr_location != null)
                                   {
                                        $('.referalRdStaffs').append('<option data-phone="' + value.satff_phone + '" value="' + value.col_id + '">' + value.col_title + '(' + value.shr_location + ')</option>');
                                   } else {
                                        $('.referalRdStaffs').append('<option data-phone="' + value.satff_phone + '" value="' + value.col_id + '">' + value.col_title + '</option>');
                                   }
                              });
                         }
                    });
                    $('.divRefTypes').html($('.divRefStaff').html());
               } else {
                    $('.divRefTypes').html($('.divRefOthers').html());
               }
          });
     });
</script>