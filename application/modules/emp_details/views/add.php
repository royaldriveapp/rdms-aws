<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Register New Employee</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <form id="demo-form2" method="post" action="<?php echo site_url($controller . '/add'); ?>" data-parsley-validate class="form-horizontal form-label-left frmEmployee" enctype="multipart/form-data">
                              <div class="form-row">
                                   <div class="form-group col-md-4">
                                        <label for="inputEmail4">First Name <span class="required">*</span></label>
                                        <input type="text" id="first-name" required="required" class="form-control" name="usr_first_name">
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputPassword4">Last Name <span class="required">*</span></label>
                                        <input type="text" id="last-name" name="usr_last_name" required="required" class="form-control">
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputEmail4">Showroom <span class="required">*</span></label>
                                        <select class="cmbShowRoom select2_group form-control" name="usr_showroom" data-url="<?php echo site_url('emp_details/getTeamLeads'); ?>">
                                             <?php foreach ($showroom as $key => $value) { ?>
                                                  <option value="<?php echo $value['shr_id']; ?>"><?php echo $value['shr_location'] . ' (' . $value['div_name'] . ')'; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>

                              <div class="form-row">
                                   <div class="form-group col-md-4">
                                        <label for="inputEmail4">Designation <span class="required">*</span></label>
                                        <select required class="form-control bindToDropdown" name="usr_group" data-bind="cmbGrade" data-dflt-select="Select Grade" data-url="<?php echo site_url($controller . '/bindDesignationGrades'); ?>" onchange="/*this.value == 8 ? $('.divTeamLead').show() : $('.divTeamLead').hide();*/">
                                             <option value="">Select designation</option>
                                             <?php foreach ($designationOld as $key => $value) { ?>
                                                  <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputEmail4">Grade <span class="required">*</span></label>
                                        <select required class="form-control cmbGrade" name="usr_grade"></select>
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputEmail4">Departments <span class="required">*</span></label>
                                        <select class="cmbShowRoom select2_group form-control" name="usr_grade">
                                             <option value="">Select Departments</option>
                                             <?php foreach ($departments as $key => $value) { ?>
                                                  <option value="<?php echo $value['dep_id']; ?>"><?php echo $value['dep_name'] . ' (' . $value['div_name'] . ')'; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="form-row">
                                   <div class="form-group col-md-4 divTeamLead" style="display: block;">
                                        <label for="inputEmail4">Reporting to <span class="required">*</span></label>
                                        <select class="cmbTeamLead1 cmbselect2_group form-control" name="usr_tl">
                                             <option value="">Select Team Lead</option>
                                             <?php foreach ($teamLeads as $key => $value) { ?>
                                                  <option value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title']; ?></option>
                                             <?php
                                             }
                                             ?>
                                        </select>
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputPassword4">Mobile <span class="required">*</span></label>
                                        <input type="text" id="last-name" name="usr_phone" required="required" data-past=".usr_whatsapp" class="form-control">
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputEmail4">Whatsapp <span class="required">*</span></label>
                                        <input type="text" id="last-name" name="usr_whatsapp" required="required" class="numOnly form-control usr_whatsapp">
                                   </div>
                              </div>
                              <div class="form-row">
                                   <div class="form-group col-md-4">
                                        <label for="inputPassword4">Email <span class="required">*</span></label>
                                        <input type="text" id="last-name" name="usr_email" required="required" class="pastContent form-control">
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputPassword4">Password <span class="required">*</span></label>
                                        <input type="text" id="usr_password" name="usr_password" required="required" class="form-control usr_password">
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputEmail4">Re enter Password <span class="required">*</span></label>
                                        <input type="text" id="usr_password_conf" name="usr_password_conf" required="required" class="form-control usr_password_conf">
                                   </div>
                              </div>
                              <div class="form-row">
                                   <div class="form-group col-md-4">
                                        <label for="inputPassword4">Address <span class="required">*</span></label>
                                        <input type="text" id="usr_address" name="usr_address" required="required" class="form-control">
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputPassword4">Country <span class="required">*</span></label>
                                        <input autocomplete="off" type="text" id="usr_country" name="usr_country" required="required" class="form-control">
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputEmail4">State <span class="required">*</span></label>
                                        <input autocomplete="off" type="text" id="usr_state" name="usr_state" required="required" class="form-control">
                                   </div>
                              </div>
                              <div class="form-row">
                                   <div class="form-group col-md-4">
                                        <label for="inputPassword4">City <span class="required">*</span></label>
                                        <input type="text" id="usr_city" name="usr_city" required="required" class="form-control">
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputPassword4">District <span class="required">*</span></label>
                                        <input type="text" id="usr_district" name="usr_district" required="required" class="form-control">
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputEmail4">Avatar <span class="required">*</span></label>
                                        <input type="file" name="usr_avatar" class="form-control">
                                   </div>

                              </div>
                              <div class="form-row">
                                   <div class="form-group col-md-4">
                                        <label for="inputPassword4">Designation <span class="required">*</span></label>
                                        <select required class="form-control bindToDropdown" name="usr_designation_new">
                                             <option value="">Select designation</option>
                                             <?php foreach ($designation as $key => $value) { ?>
                                                  <option value="<?php echo $value['desig_id']; ?>"><?php echo $value['desig_title']; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputPassword4">Role <span class="required">*</span></label>
                                        <select required class="form-control bindToDropdown" name="usr_rol">
                                             <option value="">Select role</option>
                                             <?php foreach ($roles as $key => $value) { ?>
                                                  <option value="<?php echo $value['rol_id']; ?>"><?php echo $value['rol_name']; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                                   <div class="form-group col-md-4">
                                        <label for="inputEmail4"> </label>
                                        <button type="submit" class="btn btn-primary form-control">Register New Employee</button>
                                   </div>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>