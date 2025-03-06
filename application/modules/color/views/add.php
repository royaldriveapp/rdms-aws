<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Add New Vehicle Color.</h2>
                                                 <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart("color/add", array('id' => "frmCar", 'class' => "form-horizontal form-label-left"))?>

                       <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Color</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" class="form-control col-md-7 col-xs-12" name="vc_color" id="color" placeholder="Enter Color name" required="required"/>
                              </div>
                       </div>
                       <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sort order</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                 <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="vc_sort_order" id="sort_order" placeholder="Sort order" />
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