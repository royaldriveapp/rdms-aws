<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New Department</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart($controller . "/add", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left"))?>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Divisions</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select required class="form-control col-md-7 col-xs-12" name="dep_division">
                                        <option value="">Select divisions</option>
                                        <?php foreach ($divisions as $key => $value) {?>
                                               <option value="<?php echo $value['div_id'];?>"><?php echo $value['div_name'];?></option>
                                          <?php }?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Parent department</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="form-control col-md-7 col-xs-12" name="dep_parent">
                                        <option value="">Parent department</option>
                                        <?php foreach ($parentDeptment as $key => $value) {?>
                                               <option value="<?php echo $value['dep_id'];?>"><?php echo $value['dep_name'];?></option>
                                          <?php }?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="dep_name" id="dep_name" placeholder="Name"/>
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