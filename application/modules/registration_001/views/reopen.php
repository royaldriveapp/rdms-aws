
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
                         <?php
                         echo form_open_multipart($controller . "/reopen", array('id' => "frmVehicleModel", 'class' => "form-horizontal form-label-left",
                             'onsubmit' => "var text = document.getElementById('regh_remarks').value; if(text.length < 40) { alert('Please enter atleast 40 characters in customer feedback'); document.getElementById('regh_remarks').focus(); return false; } return true;"));
                         ?>
                         <input type="hidden" name="regh_register_master" value="<?php echo $data['vreg_id']; ?>"/>
                         <input type="hidden" name="regh_assigned_by" value="<?php echo $data['vreg_added_by']; ?>"/>
                         <!-- <input type="hidden" name="regh_assigned_to" value="<?php echo $data['vreg_assigned_to']; ?>"/> -->
                         <input type="hidden" name="regh_phone_num" value="<?php echo $data['vreg_cust_phone']; ?>"/>

                         <div class="row">
                              <div class="column">
                                   <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Effective?</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo ($data['vreg_is_effective'] == 1) ? 'Yes' : 'No'; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php
                                             $mods = unserialize(MODE_OF_CONTACT);
                                             echo isset($mods[$data['vreg_contact_mode']]) ? $mods[$data['vreg_contact_mode']] : '';
                                             ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Lead type </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php
                                             $callType = unserialize(CALL_TYPE);
                                             echo isset($callType[$data['vreg_call_type']]) ? $callType[$data['vreg_call_type']] : '';
                                             ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Entry date </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo date('d-m-Y', strtotime($data['vreg_entry_date'])); ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer name </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_cust_name']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_cust_phone']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_cust_place']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_address']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Occupation </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_occupation']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Company</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_company']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Existing vehicle</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_existing_vehicle']; ?>
                                        </div>
                                   </div>
                              </div>
                              <div class="column">
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Year</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_year']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Investment</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_investment']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">KM</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_km']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ownership</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_ownership']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Customer status</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php
                                             $sts = unserialize(ENQUIRY_UP_STATUS);
                                             echo isset($sts[$data['vreg_customer_status']]) ? $sts[$data['vreg_customer_status']] : '';
                                             ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer remarks </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['vreg_customer_remark']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Reason for drop </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo isset($histry['regh_remarks']) ? $histry['regh_remarks'] : ''; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">First added by </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['ownedby_usr_first_name']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Added by </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['addedby_usr_first_name']; ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Assigned to</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 9px;">
                                             <?php echo $data['assign_usr_first_name']; ?>
                                             <select style="float: right;width: 150px;" required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="regh_assigned_to">
                                                  <option value="">Select executive</option>
                                                  <?php if (check_permission('registration', 'canselfassignreopenregister')) { ?>
                                                       <option value="<?php echo $this->uid; ?>">My self</option>
                                                  <?php } foreach ($salesExe as $key => $value) {?>
                                                       <option value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')';?></option>                                               
                                                  <?php }?>
                                             </select>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <i><?php echo isset($histry['regh_system_cmd']) ? $histry['regh_system_cmd'] : ''; ?></i>
                              </div>
                         </div>
                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Comments</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <textarea required class="form-control col-md-7 col-xs-12" name="regh_remarks" 
                                             id="regh_remarks" placeholder="Remarks"></textarea>
                              </div>
                         </div>

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
     </div>
</div>

<style>
.column {
     height: 100% !important;
     overflow: auto;
}
</style>