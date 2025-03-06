<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update Blog Tag</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart("blog/updateTag", array('id' => "frmNewsEvents", 'class' => "form-horizontal"))?>
                         <input type="hidden" name="btag_id" value="<?php echo $data['btag_id']; ?>"/>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="btag_title" id="btag_title" 
                                          placeholder="Category" value="<?php echo $data['btag_title']; ?>"/>
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