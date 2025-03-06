<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Renew insurance</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart($controller . "/updateins", array('id' => "frmVehicleModel", 'class' => "form-horizontal form-label-left")); ?>
                         <input type="hidden" name="val_id" value="<?php echo $stockVehicle['val_id'];?>"/>
                         
                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php echo $stockVehicle['val_veh_no'] . ' - ' . $stockVehicle['brd_title'] . ', ' . $stockVehicle['mod_title'] . ', ' . $stockVehicle['var_variant_name']; ?>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer name<span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="val_cust_name" id="val_cust_name"
                                          value="" autocomplete="off" placeholder="Customer name"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer phone<span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="val_cust_phone" id="val_cust_phone"
                                          value="" autocomplete="off" placeholder="Customer phone"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer place<span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="val_cust_place" id="val_cust_place"
                                          value="" autocomplete="off" placeholder="Customer place"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Insurance validity<span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12" name="val_insurance_validity" id="val_insurance_validity"
                                          value="" autocomplete="off" placeholder="Insurance validity"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Insurance company<span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="val_insurance_company" id="val_insurance_company"
                                          value="" autocomplete="off" placeholder="Insurance company"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">IDV</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="val_insurance_comp_idv" 
                                          value="" autocomplete="off" placeholder="IDV" id="val_insurance_comp_idv"/>
                              </div>
                         </div>
                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success btnSubmitRegister">Submit</button>
                                   <button class="btn btn-primary" type="reset">Reset</button>
                              </div>
                         </div>
                         <?php echo form_close()?>
                    </div>
               </div>
          </div>
     </div>
</div>