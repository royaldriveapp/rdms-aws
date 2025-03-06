<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <?php if (check_permission('emp_details', 'updatestaffmasterview')) { ?>
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Staff master</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <form id="demo-form2" method="post" action="<?php echo site_url($controller . '/quickupdate'); ?>" data-parsley-validate class="form-horizontal form-label-left frmEmployee" enctype="multipart/form-data">
                                   <input type="hidden" name="usr_id" value="<?php echo $userDetails['usr_id']; ?>" />
                                   <div class="form-row">
                                        <div class="form-group col-md-2">
                                             <label for="inputEmail4">Emp code<span class="required">*</span></label>
                                             <input value="<?php echo $userDetails['usr_emp_code']; ?>" type="text" id="first-name" required class="form-control" name="usr_emp_code">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputEmail4">First Name <span class="required">*</span></label>
                                             <input value="<?php echo $userDetails['usr_first_name']; ?>" type="text" id="first-name" required="required" class="form-control" name="usr_first_name">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Last Name </label>
                                             <input value="<?php echo $userDetails['usr_last_name']; ?>" type="text" id="last-name" name="usr_last_name" class="form-control">
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="form-group col-md-2">
                                             <label for="inputEmail4">Branch <span class="required">*</span></label>
                                             <select class="cmbShowRoom select2_group form-control" name="usr_showroom" data-url="<?php echo site_url('emp_details/getTeamLeads'); ?>">
                                                  <?php foreach ($showroom as $key => $value) { ?>
                                                       <option <?php echo ($value['shr_id'] == $userDetails['usr_showroom']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['shr_id']; ?>"><?php echo $value['shr_location'] . ' (' . $value['div_name'] . ')'; ?>
                                                       </option>
                                                  <?php } ?>
                                             </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">RD Mobile</label>
                                             <input type="text" id="last-name" name="usr_phone" data-past=".usr_whatsapp" value="<?php echo $userDetails['usr_phone']; ?>" class="pastContent numOnly form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputEmail4">RD WhatsApp</label>
                                             <input type="text" id="last-name" name="usr_whatsapp" value="<?php echo $userDetails['usr_whatsapp']; ?>" class="numOnly form-control usr_whatsapp">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputEmail4">Personal Mobile <span class="required">*</span></label>
                                             <input type="text" id="last-name" name="usr_mobile_personal" value="<?php echo $userDetails['usr_mobile_personal']; ?>" class="numOnly form-control usr_mobile_personal">
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="form-group col-md-4">
                                             <label for="inputPassword4">Personal email </label>
                                             <input value="<?php echo $userDetails['usr_persnl_email']; ?>" type="text" id="last-name" name="usr_persnl_email" class="pastContent form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                             <label for="inputPassword4">Permanent Address <span class="required">*</span></label>
                                             <input value="<?php echo $userDetails['usr_address']; ?>" type="text" id="usr_address" name="usr_address" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Country <span class="required">*</span></label>
                                             <input value="<?php echo $userDetails['usr_country']; ?>" autocomplete="off" value="India" type="text" name="usr_country" required class="form-control">
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="form-group col-md-2">
                                             <label for="inputEmail4">State <span class="required">*</span></label>
                                             <input value="<?php echo $userDetails['usr_state']; ?>" autocomplete="off" type="text" value="Kerala" name="usr_state" required="required" class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">City <span class="required">*</span></label>
                                             <input value="<?php echo $userDetails['usr_city']; ?>" type="text" id="" name="usr_city" required="required" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                             <label for="inputPassword4">District <span class="required">*</span></label>
                                             <select required class="select2_group form-control" name="usr_district" id="vreg_district">
                                                  <option value="">Select District</option>
                                                  <?php
                                                  foreach ($districts as $key => $value) {
                                                  ?>
                                                       <option <?php echo ($value['std_id'] == $userDetails['usr_district']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['std_id']; ?>">
                                                            <?php echo $value['std_district_name']; ?></option>
                                                  <?php
                                                  }
                                                  ?>
                                             </select>
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="form-group col-md-4">
                                             <label for="inputPassword4">Designation <span class="required">*</span></label>
                                             <select required class="form-control bindToDropdown" name="usr_designation_new">
                                                  <option value="">Select designation</option>
                                                  <?php foreach ($designation as $key => $value) { ?>
                                                       <option <?php echo ($value['desig_id'] == $userDetails['usr_designation_new']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['desig_id']; ?>"><?php echo $value['desig_title']; ?>
                                                       </option>
                                                  <?php } ?>
                                             </select>
                                        </div>
                                   </div>

                                   <!-- -->
                                   <div class="form-row">
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Communication address </label>
                                             <input value="<?php echo $userDetails['usr_address1']; ?>" type="text" id="usr_address1" name="usr_address1" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Emergency no</label>
                                             <input value="<?php echo $userDetails['usr_emergency_no']; ?>" type="text" id="usr_emergency_no" name="usr_emergency_no" class="form-control">
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="form-group col-md-4">
                                             <label for="inputEmail4">Marital status</label>
                                             <select required class="form-control" name="usr_marital_status">
                                                  <option <?php echo ($userDetails['usr_marital_status'] == 0) ? 'selected="selected"' : ''; ?> value="0">Single</option>
                                                  <option <?php echo ($userDetails['usr_marital_status'] == 1) ? 'selected="selected"' : ''; ?> value="1">Married</option>
                                             </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Spouse name</label>
                                             <input value="<?php echo $userDetails['usr_spouse_name']; ?>" type="text" id="usr_spouse_name" name="usr_spouse_name" class="form-control">
                                        </div>
                                   </div>

                                   <div class="form-row">
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Father name </label>
                                             <input value="<?php echo $userDetails['usr_father_name']; ?>" type="text" id="usr_father_name" name="usr_father_name" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Marriage date</label>
                                             <input value="<?php echo !empty($userDetails['usr_marriage_date']) ? date('d-m-Y', strtotime($userDetails['usr_marriage_date'])) : ''; ?>" type="text" id="usr_marriage_date" name="usr_marriage_date" class="dtpDatePickerEvaluation form-control">
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Educational Qualification</label>
                                             <input value="<?php echo $userDetails['usr_edu_quali']; ?>" type="text" id="usr_edu_quali" name="usr_edu_quali" class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Technical Qualification</label>
                                             <input value="<?php echo $userDetails['usr_tech_quali']; ?>" type="text" id="usr_tech_quali" name="usr_tech_quali" class="form-control">
                                        </div>
                                   </div>

                                   <div class="form-row">
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Previous Exp </label>
                                             <input value="<?php echo $userDetails['usr_previous_exp']; ?>" type="text" id="usr_previous_exp" name="usr_previous_exp" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Industry Exp</label>
                                             <input value="<?php echo $userDetails['usr_industry_exp']; ?>" type="text" id="usr_industry_exp" name="usr_industry_exp" class="form-control">
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Bank</label>
                                             <input value="<?php echo $userDetails['usr_bank']; ?>" type="text" id="usr_bank" name="usr_bank" class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">IFSC Code</label>
                                             <input value="<?php echo $userDetails['usr_bank_ifsc']; ?>" type="text" id="usr_bank_ifsc" name="usr_bank_ifsc" class="form-control">
                                        </div>
                                   </div>
                                   <!-- -->
                                   <div class="form-row">
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Date of joining <span class="required">*</span></label>
                                             <input value="<?php echo !empty($userDetails['usr_doj']) ? date('d-m-Y', strtotime($userDetails['usr_doj'])) : ''; ?>" type="text" name="usr_doj" required="required" class="dtpDatePickerEvaluation form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Date of birth</label>
                                             <input value="<?php echo !empty($userDetails['usr_dob']) ? date('d-m-Y', strtotime($userDetails['usr_dob'])) : ''; ?>" type="text" name="usr_dob" class="dtpDatePickerEvaluation form-control" />
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Bank acc no </label>
                                             <input value="<?php echo $userDetails['usr_bank_acc_no']; ?>" type="text" name="usr_bank_acc_no" class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Post code</label>
                                             <input value="<?php echo $userDetails['usr_postcode']; ?>" type="text" name="usr_postcode" class="form-control">
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="form-group col-md-4">
                                             <label for="inputEmail4">Avatar</label>
                                             <input type="file" name="usr_avatar" class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputEmail4"> </label>
                                             <button type="submit" class="btn btn-primary form-control">Update</button>
                                        </div>
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>
          <?php }
          if ($userDetails['usr_resigned'] == 0 && check_permission('emp_details', 'staffresignation')) { ?>
               <div class="col-md-12 col-sm-12 col-xs-12 divStaffResignation">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Staff resignation</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <form id="demo-form2" method="post" action="<?php echo site_url($controller . '/resignation'); ?>" data-parsley-validate class="form-horizontal form-label-left frmStaffResignation" enctype="multipart/form-data">
                                   <input type="hidden" name="usr_id" value="<?php echo $userDetails['usr_id']; ?>" />
                                   <input type="hidden" name="usr_resigned" value="1" />

                                   <div class="form-row">
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Date of reliving <span class="required">*</span></label>
                                             <input placeholder="Date of reliving" type="text" name="usr_resigned_date" required="required" class="dtpDatePickerEvaluation form-control" />
                                        </div>
                                        <div class="form-group col-md-2">
                                             <label for="inputPassword4">Reason for relieving <span class="required">*</span></label>
                                             <select required class="form-control" name="usr_resigned_reason">
                                                  <option value="">Reason for relieving</option>
                                                  <?php foreach (unserialize(RELIVING_REASON) as $key => $value) { ?>
                                                       <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                  <?php } ?>
                                             </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                             <label for="inputPassword4">Remarks <span class="required">*</span></label>
                                             <input type="text" placeholder="Remarks" id="usr_resigned_remarks" name="usr_resigned_remarks" required class="form-control">
                                        </div>

                                        <div class="form-group col-md-2">
                                             <label for="inputEmail4"> </label>
                                             <button type="submit" class="btn btn-primary form-control">Update</button>
                                        </div>
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>
          <?php } ?>
     </div>
</div>
<script>
     $(document).ready(function() {
          $(document).on('submit', '.frmStaffResignation', function(e) {
               var formData = new FormData($(this)[0]);
               var url = $(this).attr('action');
               e.preventDefault();
               $.ajax({
                    type: 'post',
                    url: url,
                    dataType: 'json',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(xhr) {
                         $('.divLoading').show();
                    },
                    success: function(resp) {
                         $('.divLoading').hide();
                         messageBox(resp);
                         $(".divStaffResignation").hide();
                    }
               });
          });
          $('#staffMaster').DataTable({
               "order": [
                    [1, "asc"]
               ],
               "scrollX": true,
               "pageLength": 20,
          });
          $('#extension').DataTable({
               "order": [
                    [1, "asc"]
               ],
               "scrollX": true,
               "pageLength": 20,
          });
     });
</script>

<style>
     div.dataTables_wrapper {
          width: 1109px;
          margin: 0 auto;
     }
</style>