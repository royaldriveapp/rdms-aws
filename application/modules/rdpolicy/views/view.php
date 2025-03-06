<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New Policy</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                         <?php echo form_open_multipart($controller . "/update", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left")) ?>
                         <input type="hidden" name="pol_id" value="<?php echo $data['pol_id']; ?>"/>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" 
                                          value="<?php echo $data['pol_title']; ?>" name="pol_title" id="pol_title" placeholder="Title"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="pol_desc" 
                                          value="<?php echo $data['pol_desc']; ?>" id="pol_desc" placeholder="Description"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Document</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="file" class="form-control col-md-7 col-xs-12" name="pol_doc" id="pol_doc"/>
                              </div>
                              <span class="help-inline">Please upload PDF format</span>
                         </div>

                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success">Submit</button>
                                   <button class="btn btn-primary" type="reset">Reset</button>
                              </div>
                         </div>
                         <?php echo form_close() ?>
                    </div>
               </div>
          </div>
     </div>
</div>