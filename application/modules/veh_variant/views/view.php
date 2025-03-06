<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update Variant</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart("veh_variant/update", array('id' => "frmVehicleModel", 'class' => "form-horizontal form-label-left", "onsubmit" => "document.getElementById('submit').disabled=true;")) ?>
                         <input type="hidden" name="var_id" value="<?php echo $car['var_id'] ?>" />
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Brand</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select name="var_brand_id" id="var_brand_id" class="form-control col-md-7 col-xs-12 bindToDropdown" data-bind="cmbModel" data-dflt-select="Select Model" data-url="<?php echo site_url('enquiry/bindModel'); ?>">
                                        <option value="">Select Brand</option>
                                        <?php
                                        if (!empty($brands)) {
                                             foreach ($brands as $key => $value) {
                                        ?>
                                                  <option value="<?php echo $value['brd_id']; ?>" <?php echo ($value['brd_id'] == $car['var_brand_id']) ? "selected='true'" : ''; ?>>
                                                       <?php echo $value['brd_title']; ?></option>
                                        <?php
                                             }
                                        }
                                        ?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Model</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <span class="spanModel">
                                        <select name="var_model_id" id="var_model_id" class="form-control col-md-7 col-xs-12 cmbModel">
                                             <option value="">Select Model</option>
                                             <?php
                                             if (!empty($model)) {
                                                  foreach ($model as $key => $value) {
                                             ?>
                                                       <option value="<?php echo $value['mod_id']; ?>" <?php echo ($value['mod_id'] == $car['var_model_id']) ? "selected='true'" : ''; ?>>
                                                            <?php echo $value['mod_title']; ?></option>
                                             <?php
                                                  }
                                             }
                                             ?>
                                        </select>
                                   </span>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Variant</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $car['var_variant_name']; ?>" type="text" class="form-control col-md-7 col-xs-12" name="var_variant_name" id="var_variant_name" placeholder="Variant" />
                              </div>
                         </div>

                         <!--                    <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12" style="width: 50%;">
                                                       <textarea placeholder="Description" class="editor" name="mod_model_desc"></textarea>
                                                  </div>
                                             </div>-->

                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success" id="submit">Submit</button>
                                   <button class="btn btn-primary" type="reset">Reset</button>
                              </div>
                         </div>
                         <?php echo form_close() ?>
                    </div>
               </div>
          </div>
     </div>
</div>