<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New enquiry <i class="fa fa-plus"></i></h2>
                         <div class="clearfix"></div>
                    </div>
                    <form class="x_content frmNewValuation" data-url="<?php echo site_url($controller . '/add');?>">
                         <!-- SmartWizard html -->
                         <div id="wizEvaluation">
                              <ul>
                                   <li><a href="#step-1">Step 1<br /><small>Evaluation lead creation</small></a></li>
                                   <li><a href="#step-2">Step 2<br /><small>Vehicle evaluation details</small></a></li>
                                   <li><a href="#step-3">Step 3<br /><small>Structural Hits and Damages</small></a></li>
                                   <li><a href="#step-4">Step 4<br /><small>Documents</small></a></li>
                              </ul>

                              <div>
                                   <div id="step-1" class="">
                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Evaluation lead creation</h3>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Division</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control cmbBindShowroomByDivision" name="valuation[val_division]" id="vreg_division"
                                                                    data-url="<?php echo site_url('enquiry/bindShowroomByDivision');?>" data-bind="cmbShowroom" 
                                                                    required data-dflt-select="Select Showroom">
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
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Sales Officer</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required="true" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" 
                                                                    name="valuation[val_sales_officer]">
                                                                 <option value="">Select executive</option>
                                                                 <option value="<?php echo $this->uid;?>">Self</option>
                                                                 <?php foreach ($salesExe as $key => $value) {?>
                                                                        <option value="<?php echo $value['usr_id'];?>"><?php echo $value['usr_username'];?></option>                                               
                                                                   <?php }?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Branch</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control cmbShowroom" name="valuation[val_showroom]" id="val_showroom">
                                                                 <option value="">Select showroom</option>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePicker" 
                                                                   value="" name="valuation[val_valuation_date]" id="val_valuation_date" placeholder="Date" required="required"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Evaluator</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <?php
                                                              $readOnly = 0;
                                                              if (in_array($this->uid, array_column($evaluators, 'col_id'))) {
                                                                   $readOnly = 1;
                                                              }
                                                            ?>
                                                            <select required="true" <?php echo ($readOnly == 1) ? 'disabled' : '';?> 
                                                                    class="select2_group form-control" name="valuation[shr_added_by]" id="shr_added_by">
                                                                 <option value="">Select Evaluator</option>
                                                                 <?php
                                                                   if (!empty($evaluators)) {
                                                                        foreach ($evaluators as $key => $value) {
                                                                             ?>
                                                                             <option <?php echo ($this->uid == $value['col_id']) ? 'selected="selected"' : '';?>
                                                                                  value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'];?></option>
                                                                                  <?php
                                                                             }
                                                                        }
                                                                      ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Evaluation Location</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" 
                                                                   name="valuation[val_location]" id="val_location" placeholder="Location"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Manager</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required="true" class="select2_group form-control" name="valuation[val_manager]" id="val_manager">
                                                                 <option value="">Select Manager</option>
                                                                 <?php
                                                                   if (!empty($managers)) {
                                                                        foreach ($managers as $key => $value) {
                                                                             ?>
                                                                             <option value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')';?></option>
                                                                             <?php
                                                                        }
                                                                   }
                                                                 ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Evaluation</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-4 col-xs-6 hourPicker" required
                                                                   style="width: 50%;"  name="valuation[val_in_time]" id="val_in_time" placeholder="IN Time"/>

                                                            <input type="text" class="form-control col-md-4 col-xs-6 hourPicker" required
                                                                   style="width: 50%;" name="valuation[val_out_time]" id="val_out_time" placeholder="Out Time"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Customer Name</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_cust_name]" 
                                                                   required id="val_cust_name" placeholder="Customer Name"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Customer Source</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control cmbModeOfContact" name="valuation[val_cust_source]">
                                                                 <option value="">Select one</option>
                                                                 <?php
                                                                   foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                        ?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                        <?php
                                                                   }
                                                                 ?>
                                                            </select>                                                            
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Phone Number</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_cust_phone]" 
                                                                   required id="val_cust_phone" placeholder="Phone Number"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Email</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-4 col-xs-6"
                                                                   placeholder="Email" name="valuation[val_cust_email]" id="val_cust_email"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Reference</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_reference]" 
                                                                   id="val_reference" placeholder="Reference"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Reference mediator</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_reference_mediator]" 
                                                                   id="val_reference_mediator" placeholder="Reference mediator"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Vehicle details</h3>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Reg: NO</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_veh_no]" 
                                                                   style="text-transform: uppercase;" required id="val_veh_no" placeholder="Reg: NO"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Brand</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required="true" data-url="<?php echo site_url('enquiry/bindModel');?>" data-bind="cmbEvModel" 
                                                                    data-dflt-select="Select Model" class="select2_group form-control bindToDropdown" name="valuation[val_brand]" id="val_brand">
                                                                 <option value="">Select Brand</option>
                                                                 <?php
                                                                   if (!empty($brand)) {
                                                                        foreach ($brand as $key => $value) {
                                                                             ?>
                                                                             <option value="<?php echo $value['brd_id'];?>"><?php echo $value['brd_title'];?></option>
                                                                             <?php
                                                                        }
                                                                   }
                                                                 ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Model</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required data-url="<?php echo site_url('enquiry/bindVarient');?>" 
                                                                    data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                                    class="cmbEvModel select2_group form-control bindToDropdown" 
                                                                    name="valuation[val_model]" id="val_model"></select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Variant</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control cmbEvVariant" 
                                                                    name="valuation[val_variant]" id="val_variant"></select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">1ST Reg Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   name="valuation[val_reg_date]" id="val_reg_date" placeholder="1ST Reg Date"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Color</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" required
                                                                   name="valuation[val_color]" id="val_color" placeholder="Color"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Eng CC</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_eng_cc]" 
                                                                   id="val_eng_cc" placeholder="Eng CC"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Model Year</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-4 col-xs-6 numOnly"
                                                                   style="width: 50%;"  name="valuation[val_model_year]" id="val_model_year" placeholder="Model Year"/>

                                                            <input type="text" class="form-control col-md-4 col-xs-6 numOnly"
                                                                   style="width: 50%;" name="valuation[val_minif_year]" id="val_model_year" placeholder="Mnf Year" required/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Transmission</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control" name="valuation[val_transmission]" id="val_transmission">
                                                                 <option value="">Select Transmission</option>
                                                                 <option value="1">M/T</option>
                                                                 <option value="2">A/T</option>
                                                                 <option value="3">S/T</option>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">KM Reading</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="valuation[val_km]" 
                                                                   id="val_km" placeholder="KM Reading" required/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Model Year</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select style="width: 50%;" class="form-control col-md-4 col-xs-6" name="valuation[val_ac]" id="val_ac">
                                                                 <option value="">Select A/C</option>
                                                                 <option value="1">W/o</option>
                                                                 <option value="2">Single</option>
                                                                 <option value="3">Dual</option>
                                                                 <option value="4">Multi</option>
                                                            </select>

                                                            <input type="text" class="form-control col-md-4 col-xs-6 numOnly"
                                                                   style="width: 50%;" name="valuation[val_ac_zone]" id="val_model_year" placeholder="No of zone" required/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Manufacture Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   type="text" name="valuation[val_manf_date]" id="val_manf_date">
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Fuel</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control bindToDropdown" name="valuation[val_fuel]" i="val_fuel">
                                                                 <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Registration Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   type="text" name="valuation[val_reg_date]" id="val_reg_date">
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Delivery Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   type="text" name="valuation[val_delv_date]" id="val_delv_date">
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">No.of Seats</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="valuation[val_no_of_seats]" id="val_no_of_seats">
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <!-- <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Milage</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 decimalOnly" 
                                                                   type="text" name="valuation[val_milage]" id="val_milage">
                                                       </div>
                                                  </div>
                                             </div>-->
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">No.of Owner(s)</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="valuation[val_no_of_owner]" id="val_no_of_owner">
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Engine Number</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12" 
                                                                   type="text" name="valuation[val_engine_no]" id="val_engine_no">
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">No.of Camera fine</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="valuation[val_camera_fine]" id="val_camera_fine">
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Chassis Number</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12" 
                                                                   type="text" name="valuation[val_chasis_no]" id="val_chasis_no">
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Insurance</h3>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Type</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control" name="valuation[val_insurance]" id="val_insurance">
                                                                 <option value="0">Select Insurance Type</option>
                                                                 <?php foreach (unserialize(INSURANCE_TYPES) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Valid Up to</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   name="valuation[val_insurance_validity]" id="val_insurance_validity" placeholder="Valid Up to"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Company Name</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_insurance_company]" 
                                                                   id="val_insurance_company" placeholder="Company Name"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">IDV Value</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" name="valuation[val_insurance_idv]" 
                                                                   id="val_insurance_idv" placeholder="IDV Value"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="chk-container">
                                                  <h3 class="border-bottom border-gray pb-2 text-center">Hypothecation Details</h3>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Hypothecation</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12"><input class="chkHypo" type="checkbox" name="valuation[val_finance]" value="1" id="val_finance"/></div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Hypothecation will close by customer</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12"><input class="chkHypoByCust" type="checkbox" name="valuation[val_hypo_close_by_cust]" value="1" id="val_hypo_close_by_cust"/></div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Bank</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="cmbSearchList select2_group form-control cmbValHypoBank" name="valuation[val_hypo_bank]" id="val_hypo_bank">
                                                                 <option value="">Select bank</option>
                                                                 <?php foreach ($banks as $key => $value) {?>
                                                                        <option value="<?php echo $value['bnk_id'];?>"><?php echo $value['bnk_name'];?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Branch</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 txtValHypoBankBranch" 
                                                                   name="valuation[val_hypo_bank_branch]" id="val_hypo_bank_branch" placeholder="Branch"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Loan amount</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly txtValHypoLoanAmt" 
                                                                   name="valuation[val_hypo_loan_amt]" id="val_hypo_loan_amt" placeholder="Loan amount"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Loan date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation txtValHypoLoanDate" 
                                                                   name="valuation[val_hypo_loan_date]" id="val_hypo_loan_date" placeholder="Loan date"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Foreclosure value</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly txtValHypoFrclosVal" 
                                                                   name="valuation[val_hypo_frclos_val]" id="val_hypo_frclos_val" placeholder="Foreclosure value"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Foreclosure date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation txtValHypoFrclosDate" 
                                                                   name="valuation[val_hypo_frclos_date]" id="val_hypo_frclos_date" placeholder="Foreclosure date"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Daily interest</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly txtValHypoDailyInt" 
                                                                   name="valuation[val_hypo_daily_int]" id="val_hypo_daily_int" placeholder="Daily interest"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Loan ending date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation txtValHypoLoanEndDate" 
                                                                   name="valuation[val_hypo_loan_end_date]" id="val_hypo_loan_end_date" placeholder="Loan ending date"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-12">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-2 col-sm-3 col-xs-12">Description</label>
                                                       <div class="col-md-9 col-sm-6 col-xs-12">
                                                            <textarea id="val_finance_remark" class="form-control col-md-7 col-xs-12" 
                                                                      rows="4" name="valuation[val_finance_remark]"></textarea>
                                                       </div>
                                                  </div>
                                             </div>

                                             <!-- Features -->
                                             <div class="chk-container" style="float: left;width: 100%;">
                                                  <h3 class="border-bottom border-gray pb-2 text-center">Features</h3>
                                                  <ul class="ks-cboxtags">
                                                       <?php
                                                         if (!empty($vehicleFeatures)) {
                                                              foreach ($vehicleFeatures as $key => $value) {
                                                                   ?>
                                                                   <li>
                                                                        <input type="checkbox" name="features[<?php echo $value['vftr_id'];?>]" id="checkboxOne<?php echo $value['vftr_id'];?>" value="<?php echo $value['vftr_id'];?>">
                                                                        <label for="checkboxOne<?php echo $value['vftr_id'];?>"><?php echo $value['vftr_feature'];?></label>
                                                                   </li>
                                                                   <?php
                                                              }
                                                         }
                                                       ?>
                                                  </ul>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Air Bags</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="valuation[val_air_bags]" 
                                                                   id="val_air_bags" placeholder="Air Bags"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">No of Exhaust</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="valuation[val_exhaust]" 
                                                                   id="val_exhaust" placeholder="No of Exhaust"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <div id="step-2" class="step-2">
                                        <!-- -->
                                        <table class="table table-striped table-bordered">
                                             <thead>
                                                  <tr>
                                                       <th style="text-align: center;font-size: 20px;" colspan="10">Vehicle evaluation details</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php
                                                    foreach ($fullBodyCheckupMaster as $mk => $mstr) {
                                                         $fullBodyCheckupDetails = $this->evaluation->getFullBodyCheckupDetailByMaster($mstr['vfbcm_id']);
                                                         ?>
                                                         <tr>
                                                              <td class="td-head"><?php echo $mstr['vfbcm_title'];?></td>
                                                              <?php foreach ($fullBodyCheckupDetails as $dk => $dtls) {?>   
                                                                   <td>
                                                                        <label class="ctrl-container"><?php echo $dtls['vfbcd_title'];?>
                                                                             <input <?php echo ($dk == 0) ? 'checked' : '';?> type="radio" value="<?php echo $dtls['vfbcd_id'];?>" 
                                                                                                                              id="fulbdchk<?php echo $dtls['vfbcd_id'];?>" name="fulbdchk[<?php echo $mstr['vfbcm_id'];?>]">
                                                                             <span class="checkmark"></span>
                                                                        </label>
                                                                   </td>
                                                              <?php }?>
                                                         </tr>
                                                    <?php }?>
                                             </tbody>
                                        </table>
                                        <!-- -->

                                        <div>
                                             <table class="table table-striped table-bordered">
                                                  <thead>
                                                       <tr>
                                                            <th style="text-align: center;font-size: 20px;" colspan="10">Warranty and Service History</th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td class="td-head"> Warranty</td>
                                                            <td>
                                                                 <label class="ctrl-container">Valid
                                                                      <input type="radio" name="valuation[val_wrnty]" value="1" id="val_wrnty_y"
                                                                             onclick="$('.tdValidityKM').show();">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <td>
                                                                 <label class="ctrl-container">Not Valid
                                                                      <input checked type="radio" name="valuation[val_wrnty]" value="0" id="val_wrnty_n"
                                                                             onclick="$('.tdValidityKM').hide();">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <td class="td-head"> Ser History ; LS Date</td>
                                                            <td>
                                                                 <input name="valuation[val_last_service]" id="val_last_service" type="text" class="form-control dtpDatePicker" style="width: 100%;"/>
                                                            </td>
                                                            <td class="td-head"> LS KM</td>
                                                            <td>
                                                                 <input name="valuation[val_last_service_km]" id="val_last_service_km" type="text" class="form-control numOnly" style="width: 100%;"/>
                                                            </td>
                                                       </tr>

                                                       <tr>
                                                            <td class="td-head"> Extra Warranty</td>
                                                            <td>
                                                                 <label class="ctrl-container">Reg
                                                                      <input checked name="valuation[val_wrnty_extra]" id="val_wrnty_extra_y" value="1" type="radio">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <td>
                                                                 <label class="ctrl-container">Not Reg
                                                                      <input type="radio" name="valuation[val_wrnty_extra]" id="val_wrnty_extra_n" value="0">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <td class="td-head"> Service Req A.O.D</td>
                                                            <td>
                                                                 <input type="text" name="valuation[val_wrnty_service_req_aod]" id="val_wrnty_service_req_aod" class="form-control" style="width: 100%;"/>
                                                            </td>
                                                            <td class="td-head"> Act Serv A.O.D</td>
                                                            <td>
                                                                 <input type="text" name="valuation[val_wrnty_act_serv_aod]" id="val_wrnty_act_serv_aod" class="form-control" style="width: 100%;"/>
                                                            </td>
                                                       </tr>

                                                       <tr>
                                                            <td class="td-head"> System Scan</td>
                                                            <td>
                                                                 <label class="ctrl-container">Yes
                                                                      <input checked type="radio" name="valuation[val_wrnty_system_scan]" id="val_wrnty_system_scan_y" value="1">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <td>
                                                                 <label class="ctrl-container">No
                                                                      <input type="radio" name="valuation[val_wrnty_system_scan]" id="val_wrnty_system_scan_n" value="0">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <td class="td-head"> Spl Ser Observations</td>
                                                            <td colspan="3">
                                                                 <input type="text" class="form-control" style="width: 100%;" id="val_wrnty_spl_ser_observ" 
                                                                        name="valuation[val_wrnty_spl_ser_observ]"/>
                                                            </td>
                                                       </tr>

                                                       <tr>
                                                            <td class="td-head"> IMP Observations</td>
                                                            <td colspan="7">
                                                                 <input type="text" class="form-control" style="width: 100%;" id="val_wrnty_im_observ" 
                                                                        name="valuation[val_wrnty_im_observ]"/>
                                                            </td>
                                                       </tr>

                                                       <tr>
                                                            <td class="td-head"> Spl Comments</td>
                                                            <td colspan="7">
                                                                 <input type="text" class="form-control" style="width: 100%;" id="val_wrnty_spl_comments" 
                                                                        name="valuation[val_wrnty_spl_comments]"/>
                                                            </td>
                                                       </tr>
                                                       <tr class="tdValidityKM" style="display: none;">
                                                            <td class="td-head"> Warranty Validity</td>
                                                            <td colspan="3">
                                                                 <input class="form-control dtpDatePickerEvaluation" type="text" id="val_wrnty_validity"
                                                                        style="width: 100%;" name="valuation[val_wrnty_validity]"/>
                                                            </td>
                                                            <td class="td-head"> KM</td>
                                                            <td colspan="3">
                                                                 <input type="text" class="form-control numOnly" style="width: 100%;" id="val_wrnty_km" name="valuation[val_wrnty_km]"/>
                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                             <div class="row">
                                                  <table class="table table-striped table-bordered">
                                                       <thead>
                                                            <tr>
                                                                 <th style="text-align: center;font-size: 20px;" colspan="10">Up-gradation Details</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody class="tbUpgradDet">
                                                            <tr>
                                                                 <td><input name="upgradedetails[upgrd_key][]" placeholder="Refurbish job" class="form-control txtUpgradDetKey" type="text" style="width: 100%;"/></td>
                                                                 <td><input name="upgradedetails[upgrd_value][]" placeholder="Refurbish amount" class="form-control txtUpgradDetValue" type="text" style="width: 100%;"/></td>
                                                                 <td><span style="cursor: pointer;" class="glyphicon glyphicon-plus btnAddUpgradDet"></span></td>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                             </div>
                                        </div>
                                   </div>

                                   <div id="step-3" class="step-3">
                                        <div class="row">
                                             <table class="table table-striped table-bordered">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="4" style="text-align: center;font-size: 20px;">
                                                                 Structural Hits and Damages
                                                            </th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td class="td-head"> Pillar - FR</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_pfr" name="valuation[val_pfr]">
                                                            </td>

                                                            <td class="td-head"> Glass - Wint sheeld</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_gws" name="valuation[val_gws]">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> FL</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_pfl" name="valuation[val_pfl]">
                                                            </td>

                                                            <td class="td-head"> Rear Glass</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_grg" name="valuation[val_grg]">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> CR</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_pcr" name="valuation[val_pcr]">
                                                            </td>

                                                            <td class="td-head"> Door Glass R</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_gdgr" name="valuation[val_gdgr]">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> CL</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_pcl" name="valuation[val_pcl]">
                                                            </td>

                                                            <td class="td-head"> Door Glass LS</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_gdgls" name="valuation[val_gdgls]">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> RR</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_prr" name="valuation[val_prr]">
                                                            </td>

                                                            <td class="td-head"> Q Glass R</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_qgr" name="valuation[val_qgr]">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> RL</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_prl" name="valuation[val_prl]">
                                                            </td>

                                                            <td class="td-head"> Q Glass I</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_qgi" name="valuation[val_qgi]">
                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                        </div>

                                        <div class="row">
                                             <table class="table table-striped table-bordered">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="4" style="text-align: center;font-size: 20px;">
                                                                 Tire and spare tire information
                                                            </th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td class="td-head"> Tire - FR</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_tyre_2" name="valuation[val_tyre_2]">
                                                            </td>

                                                            <td class="td-head"> Tire - FL</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_tyre_1" name="valuation[val_tyre_1]">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Tire - RR</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_tyre_4" name="valuation[val_tyre_4]">
                                                            </td>

                                                            <td class="td-head"> Tire - RL</td>
                                                            <td>
                                                                 <input required class="form-control" type="text" id="val_tyre_3" name="valuation[val_tyre_3]">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Spare tire</td>
                                                            <td colspan="3">
                                                                 <input required class="form-control" type="text" id="val_tyre_5" name="valuation[val_tyre_5]">
                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                        </div>

                                        <div class="row">
                                             <table class="table table-striped table-bordered">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="3" style="text-align: center;font-size: 20px;">
                                                                 Structural Hits and Damages
                                                            </th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr class="trDamages">
                                                            <td><input class="filDamagesFile" name="complaint_file[]" type="file" style="width: 100%;"/></td>
                                                            <td><input class="form-control txtDamagesDesc" name="complaint_title[]" type="text" style="width: 100%;"/></td>
                                                            <td><span style="cursor: pointer;" class="glyphicon glyphicon-plus btnAddDamages"></span></td>
                                                       </tr>
                                                       <tr>
                                                            <td colspan="3">
                                                                 <textarea name="valuation[val_struct_observation]" id="val_struct_observation" placeholder="Structural Observations" class="form-control"></textarea>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td colspan="3">
                                                                 <textarea name="valuation[val_adj_cond]" id="val_adj_cond" placeholder="Adj For Condition" class="form-control"></textarea>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Suspected purchase price</td>
                                                            <td colspan="2">
                                                                 <input class="form-control" type="text" name="valuation[val_suspt_purchase_price]" id="val_suspt_purchase_price">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> New Vehicle Price</td>
                                                            <td colspan="2">
                                                                 <input class="form-control" type="text" name="valuation[val_new_vehicle_price]" id="val_new_vehicle_price">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Best Market sale Price</td>
                                                            <td colspan="2">
                                                                 <input class="form-control" type="text" name="valuation[val_price_market_est]" id="val_price_market_est">
                                                            </td>

                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Refreshment Cost</td>
                                                            <td colspan="2">
                                                                 <input class="form-control" type="text" name="valuation[val_refurb_cost]" id="val_refurb_cost">
                                                            </td>

                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Adj For Condition +/-</td>
                                                            <td colspan="2">
                                                                 <input class="form-control" type="text" name="valuation[val_adj_ond_pm]" id="val_adj_ond_pm">
                                                            </td>

                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Profit</td>
                                                            <td colspan="2">
                                                                 <input class="form-control" type="text" name="valuation[val_profit]" id="val_profit">
                                                            </td>

                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Trade in Price</td>
                                                            <td colspan="2">
                                                                 <input class="form-control" type="text" name="valuation[val_trade_in_price]" id="val_trade_in_price">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td colspan="3">
                                                                 <textarea name="valuation[val_rfresh_job_did]" id="val_rfresh_job_did" placeholder="Refreshment job Did" class="form-control"></textarea>
                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                        </div>
                                   </div>

                                   <div id="step-4" class="step-4">
                                        <h3 class="border-bottom border-gray pb-2 text-center">Documents</h3>
                                        <div class="row">
                                             <div class="col-sm-12">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Document Details</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea id="val_document_details" class="form-control col-md-7 col-xs-12" rows="4" name="valuation[val_document_details]"></textarea>
                                                            <?php echo!check_permission('evaluation', 'updatedocumentdetails') ? '<p style="color:red;">You are not permission to update this field</p>' : '';?>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Other Remarks</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea id="val_remarks" class="form-control col-md-7 col-xs-12"  rows="4"  name="valuation[val_remarks]"></textarea>
                                                       </div>
                                                  </div>

                                                  <?php if (check_permission('evaluation', 'updatedocumentdetails')) {?>
                                                         <div class="form-group">
                                                              <label for="enq_cus_email" class="control-label col-md-4 col-sm-3 col-xs-12">Documents</label>
                                                              <div class="col-md-3 col-sm-3 col-xs-12">
                                                                   <input placeholder="Document name" id="comp_complaint" class="form-control col-md-7 col-xs-12" type="text" name="document_title[]">
                                                              </div>
                                                              <div class="col-md-2 col-sm-2 col-xs-12">
                                                                   <input type="file" class="form-control col-md-7 col-xs-12" id="file" name="documents[]" />
                                                              </div>
                                                              <div class="col-md-1 col-sm-1 col-xs-12">
                                                                   <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnMoreDocumentsEval"></span>
                                                              </div>
                                                         </div>
                                                         <div  style="width: 100%;float: left;" class="divbtnMoreDocumentsEval"></div>
                                                    <?php }?>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </form>
               </div>
          </div>
     </div>
</div>

<style>
     /* The container */
     .ctrl-container {
          display: block;
          position: relative;
          padding-left: 35px;
          /*margin-bottom: 12px;*/
          margin-bottom: 0px !important;
          cursor: pointer;
          font-size: 13px;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
     }

     /* Hide the browser's default radio button */
     .ctrl-container input {
          position: absolute;
          opacity: 0;
          cursor: pointer;
     }

     /* Create a custom radio button */
     .checkmark {
          position: absolute;
          top: 0;
          left: 0;
          height: 15px;
          width: 15px;
          background-color: #eee;
          border: 1px solid black;
          border-radius: 50%;
     }

     /* On mouse-over, add a grey background color */
     .ctrl-container:hover input ~ .checkmark {
          background-color: #ccc;
     }

     /* When the radio button is checked, add a blue background */
     .ctrl-container input:checked ~ .checkmark {
          background-color: #2196F3;
          border: 1px solid #2196F3;
     }

     /* Create the indicator (the dot/circle - hidden when not checked) */
     .checkmark:after {
          content: "";
          position: absolute;
          display: none;
     }

     /* Show the indicator (dot/circle) when checked */
     .ctrl-container input:checked ~ .checkmark:after {
          display: block;
     }

     /* Style the indicator (dot/circle) */
     .ctrl-container .checkmark:after {
          top: 19%;
          left: 20%;
          width: 7px;
          height: 8px;
          border-radius: 50%;
          background: white;
     }
     .td-head {
          background-color: #ebcccc;color: black;
     }

     /*Features*/
     .chk-container {
          max-width: 100%;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          font-size: 13px;
     }

     ul.ks-cboxtags {
          list-style: none;
          padding: 20px;
     }
     ul.ks-cboxtags li{
          display: inline;
     }
     ul.ks-cboxtags li label{
          display: inline-block;
          background-color: rgba(255, 255, 255, .9);
          border: 2px solid rgba(139, 139, 139, .3);
          color: #adadad;
          border-radius: 25px;
          white-space: nowrap;
          margin: 3px 0px;
          -webkit-touch-callout: none;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
          -webkit-tap-highlight-color: transparent;
          transition: all .2s;
     }

     ul.ks-cboxtags li label {
          padding: 8px 12px;
          cursor: pointer;
     }

     ul.ks-cboxtags li label::before {
          display: inline-block;
          font-style: normal;
          font-variant: normal;
          text-rendering: auto;
          -webkit-font-smoothing: antialiased;
          font-family: "FontAwesome";
          font-weight: 900;
          font-size: 12px;
          padding: 2px 6px 2px 2px;
          content: "\f067";
          transition: transform .3s ease-in-out;
     }

     ul.ks-cboxtags li input[type="checkbox"]:checked + label::before {
          content: "\f00c";
          transform: rotate(-360deg);
          transition: transform .3s ease-in-out;
     }

     ul.ks-cboxtags li input[type="checkbox"]:checked + label {
          border: 2px solid #1bdbf8;
          background-color: #12bbd4;
          color: #fff;
          transition: all .2s;
     }

     ul.ks-cboxtags li input[type="checkbox"] {
          display: absolute;
     }
     ul.ks-cboxtags li input[type="checkbox"] {
          position: absolute;
          opacity: 0;
     }
     ul.ks-cboxtags li input[type="checkbox"]:focus + label {
          border: 2px solid #e9a1ff;
     }
     .form-control {margin-bottom: 5px;}
     /**/
</style>

<script>
     $(document).ready(function () {


          $('.chkHypo').change(function () {
               if (this.checked) {
                    $('.cmbValHypoBank').attr('required', 'true');
                    $('.txtValHypoBankBranch').attr('required', 'true');
               } else {
                    $('.cmbValHypoBank').removeAttr('required');
                    $('.txtValHypoBankBranch').removeAttr('required');
                    $('.txtValHypoBankBranch').css('border', '1px solid #ccc');
                    $('txtValHypoBankBranch').next('.CaptionCont').css('border', '1px solid #ccc');
               }
          });

          $('.chkHypoByCust').change(function () {
               if (this.checked) {
                    $('.cmbValHypoBank').attr('required', 'true');
                    $('.txtValHypoBankBranch').attr('required', 'true');
                    $('.txtValHypoLoanAmt').attr('required', 'true');
                    $('.txtValHypoLoanDate').attr('required', 'true');
                    $('.txtValHypoFrclosVal').attr('required', 'true');
                    $('.txtValHypoFrclosDate').attr('required', 'true');
                    $('.txtValHypoFrclosDate').attr('required', 'true');
                    $('.txtValHypoDailyInt').attr('required', 'true');
                    $('.txtValHypoLoanEndDate').attr('required', 'true');
               } else {
                    $('.cmbValHypoBank').removeAttr('required');
                    $('.txtValHypoBankBranch').removeAttr('required');
                    $('.txtValHypoBankBranch').css('border', '1px solid #ccc');
                    $('txtValHypoBankBranch').next('.CaptionCont').css('border', '1px solid #ccc');

                    $('.txtValHypoLoanAmt').removeAttr('required', 'true');
                    $('.txtValHypoLoanDate').removeAttr('required', 'true');
                    $('.txtValHypoFrclosVal').removeAttr('required', 'true');
                    $('.txtValHypoFrclosDate').removeAttr('required', 'true');
                    $('.txtValHypoFrclosDate').removeAttr('required', 'true');
                    $('.txtValHypoDailyInt').removeAttr('required', 'true');
                    $('.txtValHypoLoanEndDate').removeAttr('required', 'true');

                    $('.txtValHypoLoanAmt').css('border', '1px solid #ccc');
                    $('.txtValHypoLoanDate').css('border', '1px solid #ccc');
                    $('.txtValHypoFrclosVal').css('border', '1px solid #ccc');
                    $('.txtValHypoFrclosDate').css('border', '1px solid #ccc');
                    $('.txtValHypoFrclosDate').css('border', '1px solid #ccc');
                    $('.txtValHypoDailyInt').css('border', '1px solid #ccc');
                    $('.txtValHypoLoanEndDate').css('border', '1px solid #ccc');
                    $('.txtValHypoBankBranch').css('border', '1px solid #ccc');
               }
          });
     });
</script>
<!-- Include SmartWizard CSS -->
<link href="../vendors/jwizard/css/smart_wizard.css" rel="stylesheet" type="text/css" />
<!-- Optional SmartWizard theme -->
<link href="../vendors/jwizard/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" />
<link href="../vendors/jwizard/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
<link href="../vendors/jwizard/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />