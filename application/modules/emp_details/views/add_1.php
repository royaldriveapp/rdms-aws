<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Add New Employee</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <form id="demo-form2" method="post" action="<?php echo site_url($controller . '/add'); ?>" data-parsley-validate class="form-horizontal form-label-left frmEmployee" enctype="multipart/form-data">
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="usr_first_name">
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="last-name" name="usr_last_name" required="required" class="form-control col-md-7 col-xs-12">
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label for="usr_showroom" class="control-label col-md-3 col-sm-3 col-xs-12">Showroom</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="cmbShowRoom select2_group form-control" name="usr_showroom"
                                        data-url="<?php echo site_url('emp_details/getTeamLeads');?>">
                                             <?php foreach ($showroom as $key => $value) { ?>
                                                    <option value="<?php echo $value['shr_id']; ?>"><?php echo $value['shr_location']; ?></option>
                                               <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label for="usr_group" class="control-label col-md-3 col-sm-3 col-xs-12">User group</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="select2_group form-control" name="usr_group" required="true"
                                        onchange="this.value == 8 ? $('.divTeamLead').show() : $('.divTeamLead').hide();">
                                             <?php
                                               foreach ($group as $key => $value) {
                                                    if(strpos($value['grp_access'], $this->usr_grp) !== false) {
                                                         ?>
                                                         <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                         <?php
                                                    }
                                               }
                                             ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="form-group divTeamLead" style="display: none;">
                                   <label for="usr_group" class="control-label col-md-3 col-sm-3 col-xs-12">Team Lead</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="cmbTeamLead1 cmbselect2_group form-control" name="usr_tl">
                                             <option value="">Select Team Lead</option>
                                             <?php foreach ($teamLeads as $key => $value) { ?>
                                                    <option value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'];?></option>
                                                    <?php
                                               }
                                             ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Mobile<span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="last-name" name="usr_phone" required="required" data-past=".usr_whatsapp" class="pastContent numOnly form-control col-md-7 col-xs-12">
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Whatsapp<span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="last-name" name="usr_whatsapp" required="required" class="numOnly form-control col-md-7 col-xs-12 usr_whatsapp">
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email<span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="email" id="last-name" name="usr_email" required="required" class="form-control col-md-7 col-xs-12">
                                   </div>
                              </div>

                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Password<span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="usr_password" name="usr_password" required="required" class="form-control col-md-7 col-xs-12 usr_password">
                                   </div>
                              </div>

                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Re enter Password<span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="usr_password_conf" name="usr_password_conf" required="required" class="form-control col-md-7 col-xs-12 usr_password_conf">
                                   </div>
                              </div>

                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usr_address">Address<span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="usr_address" name="usr_address" required="required" class="form-control col-md-7 col-xs-12">
                                   </div>
                              </div>

                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usr_country">Country<span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="usr_country" name="usr_country" required="required" class="autoComCountry form-control col-md-7 col-xs-12">
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usr_state">State<span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="usr_state" name="usr_state" required="required" class="autoComState form-control col-md-7 col-xs-12">
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usr_district">District<span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="usr_district" name="usr_district" required="required" class="autoComDistrict form-control col-md-7 col-xs-12">
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usr_city">City<span class="required">*</span>
                                   </label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="usr_city" name="usr_city" required="required" class="autoComCity form-control col-md-7 col-xs-12">
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usr_city">Avatar</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="usr_avatar" class="autoComCity form-control col-md-7 col-xs-12">
                                   </div>
                              </div>

                              <div class="ln_solid"></div>
                              <div class="form-group">
                                   <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                   </div>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>