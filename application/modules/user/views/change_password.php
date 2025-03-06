<div class="row-fluid">
     <div class="span12">
          <div class="widget green">
               <div class="widget-title">
                    <h4><i class="icon-reorder"></i> <?php echo $this->section; ?></h4>
               </div>
               <div class="widget-body">
                    <?php echo form_open_multipart("user/change_password", array('id' => "frmChangePassword", 'class' => "form-horizontal")) ?>
                    <div class="control-group">
                         <label class="control-label">Username</label>
                         <div class="controls">
<!--                              <input type="text" placeholder="Product Name" class="input-xxlarge" name="product[prd_name]" />-->
                              <?php echo form_input($username);?>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Old Password</label>
                         <div class="controls">
<!--                              <input type="text" placeholder="Product Name" class="input-xxlarge" name="product[prd_name]" />-->
                              <?php echo form_input($old_password);?>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">New Password</label>
                         <div class="controls">
<!--                              <input type="text" placeholder="Product Name" class="input-xxlarge" name="product[prd_name]" />-->
                              <?php echo form_input($new_password);?>
                         </div>
                    </div>
                    
                    <div class="control-group">
                         <label class="control-label">New Password Confirm</label>
                         <div class="controls">
<!--                              <input type="text" placeholder="Product Name" class="input-xxlarge" name="product[prd_name]" />-->
                              <?php echo form_input($new_password_confirm);?>
                         </div>
                    </div>
                    <?php echo form_input($user_id);?>
                    <div class="form-actions">
                         <input type="submit" class="btn blue"/>
                         <button type="button" class="btn"><i class=" icon-remove"></i> Cancel</button>
                    </div>
                    <?php echo form_close() ?>
               </div>
          </div>
     </div>
</div>