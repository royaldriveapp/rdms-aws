<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New Customer Grade</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart($controller . "/add", array('id' => "frmNewsEvents", 'class' => "form-horizontal"))?>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Grade</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required placeholder="Grade" type="text" name="grade[sgrd_grade]" id="sgrd_grade_en"
                                          class="form-control col-md-9 col-xs-12"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input min="1" type="number" class="numOnly form-control col-md-7 col-xs-12" name="grade[sgrd_priority]" 
                                          value="<?php echo $priority; ?>" id="sgrd_priority" placeholder="Priority"/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Needed verification</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="1" type="checkbox" name="grade[sgrd_need_verification]" id="sgrd_need_verification" placeholder="Priority"/>
                              </div>
                         </div>

                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success">Submit</button>
                                   <button class="btn btn-primary" type="reset">Reset</button>
                              </div>
                         </div>
                         <?php echo form_close()?>
                    </div>
               </div>
          </div>
     </div>
</div>