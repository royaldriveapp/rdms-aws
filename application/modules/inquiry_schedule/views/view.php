<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update Enqury schedule</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart($controller . "/update", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left"))?>
                         <input value="<?php echo $data['isch_id'];?>" type="hidden" name="isch_id" id="isch_id"/>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Start</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $data['isch_start'] ?>" required type="text" class="numOnly form-control col-md-7 col-xs-12" name="isch_start" 
                                          id="isch_start" placeholder="Day"/> 
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">End</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $data['isch_end'] ?>" type="text" class="numOnly form-control col-md-7 col-xs-12" name="isch_end" 
                                          id="isch_end" placeholder="Day"/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Designation</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select required class="form-control col-md-7 col-xs-12" name="isch_desig">
                                        <option value="">Select designation</option>
                                        <?php foreach ($designation as $key => $value) {?>
                                               <option <?php echo ($data['isch_desig'] == $value['id']) ? 'selected="selected"' : ''; ?>
                                                       value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                                        <?php }?>
                                   </select>
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