<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update Customer Grade</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart($controller . "/update", array('id' => "frmNewsEvents", 'class' => "form-horizontal"))?>
                         <input type="hidden" name="grade[sgrd_id]" value="<?php echo $supplierGrade['sgrd_id']; ?>"/>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Grade</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $supplierGrade['sgrd_grade']; ?>" required placeholder="Grade" type="text" 
                                          name="grade[sgrd_grade]" id="sgrd_grade_en" class="form-control col-md-9 col-xs-12"/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="number" class="numOnly form-control col-md-7 col-xs-12" name="grade[sgrd_priority]" 
                                          value="<?php echo $supplierGrade['sgrd_priority']; ?>" id="sgrd_priority" placeholder="Priority"/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Needed verification</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="checkbox" name="grade[sgrd_need_verification]" value="1"
                                          <?php echo ($supplierGrade['sgrd_need_verification'] == 1) ? 'checked=""' : ''; ?>
                                          id="sgrd_need_verification" placeholder="Priority"/>
                              </div>
                         </div>
                         
                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <?php echo check_permission($controller, 'update') ? '<button type="submit" class="btn btn-success">Submit</button>' : '';?>
                                   <button class="btn btn-primary" type="reset">Reset</button>
                              </div>
                         </div>
                         <?php echo form_close()?>
                    </div>
               </div>
          </div>
     </div>
</div>