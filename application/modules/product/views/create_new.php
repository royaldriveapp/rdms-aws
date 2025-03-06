<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Add New Employee</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart("", array('class' => "frmSearchVehicleNumber form-horizontal form-label-left")) ?>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle Reg No</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" class="txtprdRegnoPrt1 form-control col-md-7 col-xs-12" name="regNo1" maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="KL" />

                                   <input type="text" class="txtprdRegnoPrt2 form-control col-md-7 col-xs-12" name="regNo2" maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="00" />

                                   <input type="text" class="txtprdRegnoPrt3 form-control col-md-7 col-xs-12" name="regNo3" maxlength="3" style="text-transform: uppercase;width: 49px;" placeholder="AA" />

                                   <input type="text" class="txtprdRegnoPrt4 txtVehicleNo form-control col-md-7 col-xs-12" name="regNo4" data-url="<?php echo site_url('product/getPhotoUploadedImages'); ?>" maxlength="4" style="text-transform: uppercase;width: 80px;" required placeholder="0000" />
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                              <div class="col-md-6 col-sm-6 col-xs-12 divAlreadyImageUploaded"></div>
                         </div>

                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                         </div>
                         <?php echo form_close() ?>
                    </div>
               </div>
          </div>
     </div>
</div>