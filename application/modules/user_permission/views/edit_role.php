<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update Role permission</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart("user_permission/addRole", array('id' => "frmPermission", 'class' => "form-horizontal form-label-left")) ?>
                                              <div class="form-group">
                              <label for="usr_showroom" class="control-label col-md-3 col-sm-3 col-xs-12">All Role*</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php if (!empty($roles)) { ?>
                                   <select required name="rol_id" class="select2_group form-control cmbRole" data-url="<?php echo site_url('user_permission/getRolePermission'); ?>">
                                             <option value="">Select Role</option>
                                             <?php
                                             foreach ($roles as $key => $value) {
                                                                                              
                                                       ?>
                                                      <option value="<?php echo $value['rol_id']; ?>"><?php echo $value['rol_name']; ?></option>
                                                       <?php
                                                  
                                             }
                                             ?>
                                        </select>
                                   <?php } ?>
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="usr_showroom" class="control-label col-md-3 col-sm-3 col-xs-12">Change role name</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                             <input type="text" class="form-control col-md-7 col-xs-12 " name="rol_name" autocomplete="off" placeholder="new role name" >
                                                                 
                              </div>
                         </div>

                         <?php
                         if ($modules) {
                              foreach ($modules as $module => $permissions) {
                                   ?>
                                   <div class="form-group">
                                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="first-name"><?php echo ucfirst(clean_text($module)); ?></label>
                                        <div class="col-md-11 col-sm-6 col-xs-12">
                                             <?php if (!empty($permissions)) { ?>
                                                  <?php foreach ($permissions as $controller => $val) { ?>
                                                       <div style="float: left;display: inline-block;margin: 10px;">
                                                            <input id="<?php echo $module . '-' . $controller ?>" type="checkbox" 
                                                                   class="chkPermissions custom-control-input" value="<?php echo $controller; ?>" 
                                                                   name="rol_access[<?php echo $module; ?>][]">
                                                            <label class="custom-control-label" for="defaultInline1"><?php echo $val; ?></label>
                                                       </div>
                                                  <?php } ?>
                                             <?php } ?>
                                        </div>
                                   </div>
                                   <div class="clearfix"></div>
                                   <?php
                              }
                         }
                         ?>

                         <div class="form-group" style="position: fixed;top: 200px;right: 42px;">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                         </div>
                         <?php echo form_close(); ?>
                    </div>
               </div>
          </div>
     </div>
</div>
