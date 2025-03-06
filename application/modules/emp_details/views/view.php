<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Update Employee Details</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form id="demo-form2" method="post" action="<?php echo site_url($controller . '/update'); ?>" data-parsley-validate class="form-horizontal form-label-left frmEmployee" enctype="multipart/form-data">
                        <input value="<?php echo $userDetails['usr_id'] ?>" type="hidden" name="usr_id" />
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">First Name <span class="required">*</span></label>
                                <input value="<?php echo $userDetails['usr_first_name'] ?>" type="text" id="first-name" required="required" class="form-control" name="usr_first_name">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Last Name <span class="required">*</span></label>
                                <input value="<?php echo $userDetails['usr_last_name'] ?>" type="text" id="last-name" name="usr_last_name" required="required" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Showroom <span class="required">*</span></label>
                                <select class="cmbShowRoom select2_group form-control" name="usr_showroom" data-url="<?php echo site_url('emp_details/getTeamLeads'); ?>">
                                    <?php foreach ($showroom as $key => $value) { ?>
                                        <option <?php echo ($value['shr_id'] == $userDetails['usr_showroom']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['shr_id']; ?>"><?php echo $value['shr_location'] . ' (' . $value['div_name'] . ')'; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Designation <span class="required">*</span></label>
                                <select class="form-control bindToDropdown" name="usr_group" data-bind="cmbGrade" data-dflt-select="Select Grade" data-url="<?php echo site_url($controller . '/bindDesignationGrades'); ?>" onchange="/*this.value == 8 ? $('.divTeamLead').show() : $('.divTeamLead').hide();*/">
                                    <option value="">Select designation</option>
                                    <?php foreach ($designationOld as $key => $value) { ?>
                                        <option <?php echo ($value['id'] == $currDesignation) ? 'selected="selected"' : ''; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Grade <span class="required">*</span></label>
                                <select class="form-control cmbGrade" name="usr_grade">
                                    <option value="">Select Grade</option>
                                    <?php foreach ((array) $grades as $key => $value) { ?>
                                        <option <?php echo ($value['col_id'] == $userDetails['usr_grade']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title']; ?>
                                        </option>
                                    <?php }
                                    ?>

                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Departments <span class="required">*</span></label>
                                <select class="cmbShowRoom select2_group form-control" name="usr_departments">
                                    <option value="">Select Departments</option>
                                    <?php foreach ($departments as $key => $value) { ?>
                                        <option <?php echo ($value['dep_id'] == $userDetails['usr_departments']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['dep_id']; ?>">
                                            <?php echo $value['dep_name'] . ' (' . $value['div_name'] . ')'; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 divTeamLead" style="<?php /*echo empty($userDetails['usr_tl']) ? 'display: none;' : ''*/ ?>">
                                <label for="inputEmail4">Reporting to <span class="required">*</span></label>
                                <select class="cmbTeamLead1 cmbselect2_group form-control" name="usr_tl">
                                    <option value="">Select Team Lead</option>
                                    <?php foreach ($teamLeads as $key => $value) { ?>
                                        <option <?php echo ($value['col_id'] == $userDetails['usr_tl']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Mobile <span class="required">*</span></label>
                                <input type="text" id="last-name" name="usr_phone" data-past=".usr_whatsapp" value="<?php echo $userDetails['usr_phone'] ?>" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Whatsapp <span class="required">*</span></label>
                                <input type="text" id="last-name" name="usr_whatsapp" value="<?php echo $userDetails['usr_whatsapp'] ?>" class="numOnly form-control usr_whatsapp">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Email <span class="required">*</span></label>
                                <input value="<?php echo $userDetails['usr_email'] ?>" type="text" id="last-name" name="usr_email" class="pastContent form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Password <span class="required">*</span></label>
                                <input type="text" id="usr_password" name="usr_password" class="form-control usr_password">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Re enter Password <span class="required">*</span></label>
                                <input type="text" id="usr_password_conf" name="usr_password_conf" class="form-control usr_password_conf">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Address <span class="required">*</span></label>
                                <input value="<?php echo $userDetails['usr_address'] ?>" type="text" id="usr_address" name="usr_address" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Country <span class="required">*</span></label>
                                <input value="<?php echo $userDetails['usr_country'] ?>" autocomplete="off" type="text" id="usr_country" name="usr_country" class="autoComCountry form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">State <span class="required">*</span></label>
                                <input value="<?php echo $userDetails['usr_state'] ?>" autocomplete="off" type="text" id="usr_state" name="usr_state" class="autoComState form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">District <span class="required">*</span></label>
                                <select required class="select2_group form-control" name="usr_district" id="vreg_district">
                                    <option value="">Select District</option>
                                    <?php
                                    foreach ($districts as $key => $value) {
                                    ?>
                                        <option <?php echo ($userDetails['usr_district'] == $value['std_id']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['std_id']; ?>">
                                            <?php echo $value['std_district_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- -->
                            <?php if (!empty($userDetails['usr_avatar'])) { ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usr_city">Avatar</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php
                                        echo img(array('src' => 'assets/uploads/avatar/' . $userDetails['usr_avatar'], 'width' => '100', 'id' => 'imgBrandImage'));
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- -->
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Avatar <span class="required">*</span></label>
                                <input type="file" name="usr_avatar" class="autoComCity form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4"><?php echo $userDetails['usr_designation_new']; ?> Designation <span class="required">*</span></label>
                                <select required class="cmbSearchList form-control bindToDropdown" name="usr_designation_new">
                                    <option value=""> Select designation</option>
                                    <?php foreach ($designation as $key => $value) { ?>
                                        <option <?php echo ($value['desig_id'] == $userDetails['usr_designation_new']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['desig_id']; ?>"><?php echo $value['desig_title']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">City <span class="required">*</span></label>
                                <input value="<?php echo $userDetails['usr_city']; ?>" type="text" id="usr_city" name="usr_city" required="required" class="autoComCity form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Role <span class="required">*</span></label>
                                <select class="form-control" name="usr_rol">
                                    <option value="0">Select role</option>
                                    <?php foreach ($roles as $key => $value) { ?>
                                        <option <?php echo ($value['rol_id'] == $userDetails['usr_rol']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['rol_id']; ?>"><?php echo $value['rol_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if ($this->uid == 100) { ?>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Shared credentioals</label>
                                    <textarea id="usr_cred_shared" name="usr_cred_shared" class="form-control"><?php echo $userDetails['usr_cred_shared']; ?></textarea>
                                </div>
                            <?php } ?>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4"> </label>
                                <button type="submit" class="btn btn-primary form-control">Update Employee
                                    Details</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>