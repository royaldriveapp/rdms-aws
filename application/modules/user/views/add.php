<div class="row-fluid">
     <div class="span12">
          <div class="widget green">
               <div class="widget-title">
                    <h4><i class="icon-reorder"></i> <?php echo $this->section; ?></h4>
               </div>
               <div class="widget-body">
                    <?php echo form_open_multipart("user/insert", array('id' => "frmUser", 'class' => "form-horizontal" , "userId" => "")) ?>
                    
                    <div class="control-group">
                         <label class="control-label">First name</label>
                         <div class="controls">
                              <input type="text" class="form-control" name="user[first_name]" id="first_name" placeholder="First name"/>
                         </div>
                    </div>
                    
                    <div class="control-group">
                         <label class="control-label">Last name</label>
                         <div class="controls">
                              <input type="text" class="form-control" name="user[last_name]" id="last_name" placeholder="Last name"/>
                         </div>
                    </div>
                    
                    <div class="control-group">
                         <label class="control-label">Email</label>
                         <div class="controls">
                              <input type="text" placeholder="Email" class="form-control" name="user[email]"/>
                         </div>
                    </div>
                    
                    <div class="control-group">
                         <label class="control-label">Phone</label>
                         <div class="controls">
                              <input type="text" placeholder="Phone" class="form-control" name="user[phone]"/>
                         </div>
                    </div>
                    
                    <div class="control-group">
                         <label class="control-label">User name</label>
                         <div class="controls">
                              <input type="text" class="form-control" name="user[username]" id="username" placeholder="User name"/>
                              <!--<span class="help-inline">Some hint here</span>-->
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Password</label>
                         <div class="controls">
                              <input type="password" name="user[password]" class="form-control" id="password" placeholder="Password" required/>
                         </div>
                    </div>
                    
                    <div class="control-group">
                         <label class="control-label">Confirm Password</label>
                         <div class="controls">
                              <input type="password" name="user[password_confirm]" class="form-control" id="password_confirm" placeholder="Password confirm"/>
                         </div>
                    </div>
                    
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