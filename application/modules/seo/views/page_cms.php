<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Set SEO details</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart($controller . "/setPagecms", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left")) ?>
                         <input value="<?php echo $data['seocms_id']; ?>" type="hidden" name="seocms_id"/>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Page</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php echo $data['seop_name']; ?>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Section</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php echo $data['seocms_section']; ?>
                              </div>
                         </div>

                         <!-- <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Banner</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="file" class="form-control" name="banner"/>
                              </div>
                         </div> -->

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Content</label>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                   <textarea required class="editor" name="seocms_content" id="seocms_content" 
                                             placeholder="Content"><?php echo $data['seocms_content']; ?></textarea>
                              </div>
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