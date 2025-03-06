<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update Showroom</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart($controller . "/update", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left"))?>
                         <input value="<?php echo $data['shr_id'];?>" type="hidden" name="shr_id" id="shr_id"/>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Designation</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select required class="form-control col-md-7 col-xs-12" name="shr_division">
                                        <option value="">Select designation</option>
                                        <?php foreach ($divisions as $key => $value) {?>
                                               <option <?php echo ($data['shr_division'] == $value['div_id']) ? 'selected="selected"' : '';?> 
                                                    value="<?php echo $value['div_id'];?>"><?php echo $value['div_name'];?></option>
                                               <?php }?>
                                   </select>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">District</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $data['shr_location'];?>" type="text" class="form-control col-md-7 col-xs-12" 
                                          name="shr_location" id="shr_location" placeholder="District"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $data['shr_address'];?>" type="text" class="form-control col-md-7 col-xs-12" 
                                          name="shr_address" id="shr_address" placeholder="Address"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone number</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="shr_phone_num" id="shr_phone_num"
                                          value="<?php echo $data['shr_phone_num'];?>" placeholder="Phone number"/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Whatsapp</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="shr_whatsapp" id="shr_whatsapp"
                                          value="<?php echo $data['shr_whatsapp'];?>" placeholder="Whatsapp"/>
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