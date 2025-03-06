<?php //debug($userDetails);  ?>
<div class="row-fluid">
     <div class="span12">
          <div class="widget green">
               <div class="widget-title">
                    <h4><i class="icon-reorder"></i> <?php echo $this->section; ?></h4>
               </div>
               <div class="widget-body">
                    <?php echo form_open_multipart("user/update", array('id' => "frmUser", 'class' => "form-horizontal", 'userId' => $userDetails['user_id'])) ?>
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $userDetails['user_id']; ?>"/>
                    <div class="control-group">
                         <label class="control-label">First name</label>
                         <div class="controls">
                              <input type="text" class="form-control" name="user[first_name]" value="<?php echo $userDetails['first_name']; ?>" id="first_name" placeholder="First name"/>
                         </div>
                    </div>

                    <div class="control-group">
                         <label class="control-label">Last name</label>
                         <div class="controls">
                              <input type="text" class="form-control" name="user[last_name]" value="<?php echo $userDetails['last_name']; ?>" id="last_name" placeholder="Last name"/>
                         </div>
                    </div>

                    <div class="control-group">
                         <label class="control-label">Email</label>
                         <div class="controls">
                              <input type="text" placeholder="Email" class="form-control" name="user[email]" id="email" value="<?php echo $userDetails['email']; ?>"/>
                         </div>
                    </div>

                    <div class="control-group">
                         <label class="control-label">Phone</label>
                         <div class="controls">
                              <input type="text" placeholder="Phone" class="form-control" name="user[phone]" value="<?php echo $userDetails['phone']; ?>"/>
                         </div>
                    </div>

                    <div class="control-group">
                         <label class="control-label">User name</label>
                         <div class="controls">
                              <input type="text" class="form-control" name="user[username]" value="<?php echo $userDetails['username']; ?>" id="username" placeholder="User name"/>
                              <!--<span class="help-inline">Some hint here</span>-->
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Password</label>
                         <div class="controls">
                              <input type="password" name="user[password]" value="" class="form-control" id="password" placeholder="Password"/>
                         </div>
                    </div>

                    <div class="control-group">
                         <label class="control-label">Confirm Password</label>
                         <div class="controls">
                              <input type="password" name="user[password_confirm]" value="" class="form-control" id="password_confirm" placeholder="Password confirm"/>
                         </div>
                    </div>

                    <!-- -->
                    <?php
                      if (isset($userDetails['avatar']) && !empty($userDetails['avatar'])) {
                           ?>
                           <div class="form-group">
                                <label class="control-label">Avatar</label>
                                <div class="controls">
                                     <div class="input-group">
                                          <?php echo img(array('src' => FILE_UPLOAD_PATH . 'avatar/' . $userDetails['avatar'], 'height' => '80', 'width' => '100', 'id' => 'imgBrandImage')); ?>
                                     </div>
                                     <?php if ($userDetails['avatar']) { ?>
                                          <span class="help-block">
                                               <a data-url="<?php echo site_url('user/removeImage/' . $userDetails['user_id']); ?>" href="javascript:void(0);" style="width: 100px;" class="btn btn-block btn-danger btn-xs btnDeleteImage">Delete</a>
                                          </span>
                                     <?php } ?>
                                </div>
                           </div>
                           <?php
                      } 
                           ?>
                           <div class="control-group">
                                <label class="control-label">Avatar</label>
                                <div class="controls">
                                     <div id="newupload">
                                          <input type="hidden" id="x10" name="x1" />
                                          <input type="hidden" id="y10" name="y1" />
                                          <input type="hidden" id="x20" name="x2" />
                                          <input type="hidden" id="y20" name="y2" />
                                          <input type="hidden" id="w0" name="w" />
                                          <input type="hidden" id="h0" name="h" />
                                          <input type="file" class="form-control" style="display: table;margin-bottom: 10px;" name="avatar" id="image_file0" onchange="fileSelectHandler('0', '500', '333')" />
                                          <img id="preview0" class="preview"/>
                                     </div>
                                     <!--<span class="help-inline">You can crop image</span>-->
                                </div>
                           </div>
                      
                    <div class="form-actions">
                         <input type="submit" class="btn blue"/>
                         <button type="reset" class="btn"><i class=" icon-remove"></i> Cancel</button>
                    </div>
                    <?php echo form_close() ?>
               </div>
          </div>
     </div>
</div>