<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Feedback </h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart($controller . "/update", array('id' => "frmNewsEvents", 'class' => "form-horizontal"));?>
                         <input type="hidden" value="<?php echo $data['app_feedback_id']?>" name="app_feedback_id"/>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Date</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php echo date('j M Y', strtotime($data['app_feedback_date'])); ?>
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="enq_cus_city" class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php echo $data['app_feedback_name']; ?>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php echo $data['app_feedback_phone']; ?>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Feedback</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php echo $data['app_feedback']; ?>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Action plan</label>
                              <div class="col-md-6 col-sm-6 col-xs-12 redactor-width">
                                   <textarea class="form-control col-md-7 col-xs-12" placeholder="Action plan"  name="app_feedback_action_pln"></textarea>
                              </div>
                         </div>

                         
                         <!-- Technical details -->
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