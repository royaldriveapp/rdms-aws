<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Campaign master</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart($controller . "/create_campaign_master", array('id' => "frmBrand", 'class' => "form-horizontal form-label-left frmEmployee"))?>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required="true" type="text" class="form-control col-md-7 col-xs-12" 
                                          name="evnt_title" id="name" placeholder="Name"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Source</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select name="evnt_source" id="evnt_source"  class="form-control col-md-7 col-xs-12" >
                                        <option value="">Select Source</option>
                                        <?php
                                          if (!empty($sources)) {
                                               foreach ($sources as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $value['cmd_mod_id'];?>"><?php echo $value['cmd_title'];?></option>
                                                    <?php
                                               }
                                          }
                                        ?>
                                   </select>
                              </div>
                         </div> 

                         <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Campaign Start<span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo date('d-m-Y');?>" required type="text" class="dtpDatePicker form-control col-md-7 col-xs-12"
                                                         name="evnt_date" id="evnt_date" autocomplete="off" placeholder="Campaign Start"/>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Campaign End<span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo date('d-m-Y');?>" required type="text" class="dtpDatePicker form-control col-md-7 col-xs-12"
                                                         name="evnt_end_date" id="evnt_end_date" autocomplete="off" placeholder="Campaign End"/>
                                             </div>
                                        </div>
                         
                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Division <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control cmbBindShowroomByDivision" name="vreg_division" id="vreg_division"
                                                          data-url="<?php echo site_url('enquiry/bindShowroomByDivision');?>" data-bind="cmbShowroom" 
                                                          data-dflt-select="Select Showroom">
                                                       <option value="">Select division</option>
                                                       <?php
                                                         foreach ($division as $key => $value) {
                                                              ?>
                                                              <option value="<?php echo $value['div_id'];?>"><?php echo $value['div_name'];?></option>
                                                              <?php
                                                         }
                                                       ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Showroom <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control cmbShowroom shorm_stf" name="vreg_showroom" id="vreg_showroom">
                                                       <option value="">Select showroom</option>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Departments </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control cmbDepartment" name="vreg_department" id="vreg_department">
                                                       <option value="">Select departments</option>
                                                  </select>
                                             </div>
                                        </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Active <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                              <input value="1" type="checkbox" name="evnt_status" class="" id="active">
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