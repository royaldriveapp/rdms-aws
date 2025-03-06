<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>User permission</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart("user_permission/setPermission", array('id' => "frmPermission", 'class' => "form-horizontal form-label-left"))?>
                         <!--<form id="demo-form2" method="post" action="<?php echo site_url($controller . '/add');?>" data-parsley-validate class="form-horizontal form-label-left frmEmployee">-->


                         <div class="form-group">
                              <label for="usr_showroom" class="control-label col-md-3 col-sm-3 col-xs-12">All staff</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php if (!empty($designations)) {?>
                                          <select name="cua_user_id" class="cmbSearchList select2_group form-control cmbUser" data-url="<?php echo site_url('user_permission/getPermission');?>">
                                               <option value="">Select user</option>
                                               <?php
                                               foreach ($designations as $key => $value) {
                                                    $users = $this->user_permission_model->getUsers($value['desig_id']);
                                                    if (!empty($users)) {
                                                         ?>
                                                         <optgroup label="<?php echo $value['desig_title'];?>">
                                                              <?php foreach ($users as $ukey => $usr) {?>
                                                                   <option value="<?php echo $usr['usr_id'];?>"><?php echo $usr['usr_first_name'] . $usr['usr_last_name'] . ' - ' . $usr['desig_title'] . ' - ' . $usr['shr_location'] . ' - ' . $usr['usr_id'];?></option>
                                                              <?php }
                                                              ?>
                                                         </optgroup>
                                                         <?php
                                                    }
                                               }
                                               ?>
                                          </select>
                                     <?php }?>
                              </div>
                         </div>

                         <?php
                           if ($modules) {
                                foreach ($modules as $module => $permissions) {
                                     ?>
                                     <div class="form-group">
                                          <label class="control-label col-md-1 col-sm-3 col-xs-12" for="first-name"><?php echo ucfirst(clean_text($module));?></label>
                                          <div class="col-md-11 col-sm-6 col-xs-12">
                                               <?php if (!empty($permissions)) {?>
                                                    <?php foreach ($permissions as $controller => $val) {?>
                                                         <div style="float: left;display: inline-block;margin: 10px;">
                                                              <input id="<?php echo $module . '-' . $controller?>" type="checkbox" 
                                                                     class="chkPermissions custom-control-input" value="<?php echo $controller;?>" 
                                                                     name="cua_access[<?php echo $module;?>][]">
                                                              <label class="custom-control-label" for="defaultInline1"><?php echo $val;?></label>
                                                         </div>
                                                    <?php }?>
                                               <?php }?>
                                          </div>
                                     </div>
                                     <div class="clearfix"></div>
                                     <?php
                                }
                           }
                         ?>

                         <div class="ln_solid"></div>
                         <div class="form-group" style="position: fixed;top: 200px;right: 42px;">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <!-- <button class="btn btn-primary" type="reset">Reset</button> -->
                                   <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                         </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>
