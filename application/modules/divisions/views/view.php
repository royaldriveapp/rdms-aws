<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update Accessories</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart($controller . "/update", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left"))?>
                         <input value="<?php echo $data['div_id'];?>" type="hidden" name="div_id" id="acc_id"/>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $data['div_name'];?>" type="text" class="form-control col-md-7 col-xs-12" 
                                          name="div_name" id="acc_title" placeholder="Title"/>
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