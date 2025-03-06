<link href="../vendors/dropzone/dropzone.css" type="text/css" rel="stylesheet"/>
<script src="../vendors/dropzone/dropzone.js" type="text/javascript"></script>
<div class="right_col" role="main">
     <?php
       $colors=$this->evaluation->getColors();
       
       ?>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update valuation </h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li class="dropdown" style="float: right;">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <i class="fa fa-wrench"></i>
                                   </a>
                                   <ul class="dropdown-menu" role="menu">
                                        <li><a target="blank" href="<?php echo site_url('evaluation/refurbisheReturn/' . encryptor($vehicles['val_id'])); ?>">Refurbish job</a></li>
                                        <li><a target="blank" href="<?php echo site_url('evaluation/printevaluation/' . encryptor($vehicles['val_id'])); ?>">Print evaluation</a></li>
                                   </ul>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <form class="x_content frmNewValuation" data-url="<?php echo site_url($controller . '/update'); ?>">
                         <input type="hidden" name="val_id" value="<?php echo $vehicles['val_id']; ?>"/>
                         <input type="hidden" name="val_status" value="<?php echo $vehicles['val_status']; ?>"/>
                         <!-- SmartWizard html -->
                         <div id="wizEvaluation">
                              <ul>
                                   <li><a href="#step-1">Step 1<br /><small>Evaluation lead creation</small></a></li>
                                   <li><a href="#step-2">Step 2<br /><small>Vehicle evaluation details</small></a></li>
                                   <li><a href="#step-3">Step 3<br /><small>Structural Hits and Damages</small></a></li>
                                   <li><a href="#step-4">Step 4<br /><small>Documents</small></a></li>
                                   <li><a href="#step-5">Step 5<br /><small>Vehicle images</small></a></li>
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
                                                                    data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom" 
                                                                    data-dflt-select="Select Showroom">
                                                                 <option value="">Select division</option>
                                                                 <?php
                                                                 foreach ($division as $key => $value) {
                                                                      ?>
                                                                      <option <?php echo ($vehicles['val_division'] == $value['div_id']) ? 'selected="selected"' : ''; ?>
                                                                           value="<?php echo $value['div_id']; ?>"><?php echo $value['div_name']; ?></option>
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
                                                       <?php $slsOficer = !empty($vehicles['val_sales_officer']) ? $vehicles['val_sales_officer'] : $vehicles['enq_se_id']; ?>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" 
                                                                    name="valuation[val_sales_officer]">
                                                                 <option value="">Select executive</option>
                                                                 <?php foreach ($salesExe as $key => $value) { ?>
                                                                      <option <?php echo ($slsOficer == $value['usr_id']) ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $value['usr_id']; ?>"><?php echo $value['usr_username']; ?></option>                                               
                                                                      <?php } ?>
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
                                                            <select class="select2_group form-control cmbShowroom" name="valuation[val_showroom]" id="val_showroom">
                                                                 <?php foreach ($showroom as $key => $value) { ?>
                                                                      <option <?php echo ($vehicles['val_showroom'] == $value['shr_id']) ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $value['shr_id']; ?>"><?php echo $value['shr_location']; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerDMY" 
                                                                   value="<?php
                                                                   echo!empty($vehicles['val_valuation_date']) ?
                                                                           date('d-m-Y', strtotime($vehicles['val_valuation_date'])) : date('d-m-Y');
                                                                   ?>" 
                                                                   name="valuation[val_valuation_date]" id="val_valuation_date" placeholder="Date" required="required"/>
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
                                                            <select <?php //echo ($readOnly == 1) ? 'disabled' : '';      ?> 
                                                                 class="select2_group form-control" name="valuation[val_evaluator]" id="val_evaluator">
                                                                 <option value="">Select Evaluator</option>
                                                                 <?php
                                                                 if (!empty($evaluators)) {
                                                                      foreach ($evaluators as $key => $value) {
                                                                           ?>
                                                                           <option <?php echo ($vehicles['val_evaluator'] == $value['col_id']) ? 'selected="selected"' : ''; ?>
                                                                                value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title']; ?></option>
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
                                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $vehicles['val_location']; ?>"
                                                                   name="valuation[val_location]" id="val_location" placeholder="Evaluation Location"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Manager</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control" name="valuation[val_manager]" id="val_manager">
                                                                 <option value="">Select Manager</option>
                                                                 <?php
                                                                 if (!empty($managers)) {
                                                                      foreach ($managers as $key => $value) {
                                                                           ?>
                                                                           <option <?php echo ($vehicles['val_manager'] == $value['col_id']) ? 'selected="selected"' : ''; ?> 
                                                                                value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title'] . ' (' . $value['shr_location'] . ')'; ?></option>
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
                                                            <input type="text" class="form-control col-md-4 col-xs-6 hourPicker"
                                                                   style="width: 50%;" value="<?php echo $vehicles['val_in_time']; ?>" name="valuation[val_in_time]" id="val_in_time" placeholder="IN Time"/>

                                                            <input type="text" class="form-control col-md-4 col-xs-6 hourPicker"
                                                                   style="width: 50%;" value="<?php echo $vehicles['val_out_time']; ?>" name="valuation[val_out_time]" id="val_out_time" placeholder="Out Time"/>
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
                                                                   value="<?php echo $vehicles['val_cust_name']; ?>" required id="val_cust_name" placeholder="Customer Name"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Phone Number</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_cust_phone]" 
                                                                   value="<?php echo $vehicles['val_cust_phone']; ?>" required id="val_cust_phone" placeholder="Phone Number"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Email</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-4 col-xs-6"
                                                                   value="<?php echo $vehicles['val_cust_email']; ?>" placeholder="Email" name="valuation[val_cust_email]" id="val_cust_email"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Purchase type</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required="" class="select2_group form-control" name="valuation[val_type]" id="val_fuel">
                                                                 <option value="">Select type</option>
                                                                 <?php foreach (unserialize(EVALUATION_TYPES) as $key => $value) { ?>
                                                                      <option <?php echo ($vehicles['val_type'] == $key) ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Customer Source</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control cmbModeOfContact" name="valuation[val_cust_source]">
                                                                 <option value="">Select one</option>
                                                                 <?php
                                                                 foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                      ?>
                                                                      <option <?php echo ($vehicles['val_cust_source'] == $key) ? 'selected="selected"' : ''; ?>  
                                                                           value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                           <?php
                                                                      }
                                                                      ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Reference</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 txtReference"
                                                                   value="<?php echo $vehicles['val_reference']; ?>" name="valuation[val_reference]" id="val_reference" placeholder="Reference"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Referal type</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="valuation[val_refferal_type]">
                                                                 <option value="">Referal type</option>
                                                                 <option <?php echo ($vehicles['val_refferal_type'] == 1) ? 'selected="selected"' : ''; ?> value="1">Staff</option>
                                                                 <option <?php echo ($vehicles['val_refferal_type'] == 2) ? 'selected="selected"' : ''; ?> value="2">Sales staff</option>
                                                                 <option <?php echo ($vehicles['val_refferal_type'] == 3) ? 'selected="selected"' : ''; ?> value="3">Broker</option>
                                                                 <option <?php echo ($vehicles['val_refferal_type'] == 4) ? 'selected="selected"' : ''; ?> value="4">NVS</option>
                                                                 <option <?php echo ($vehicles['val_refferal_type'] == 5) ? 'selected="selected"' : ''; ?> value="5">MGMT</option>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Refferer name</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12"
                                                                   value="<?php echo $vehicles['val_refferer_name']; ?>" name="valuation[val_refferer_name]" 
                                                                   id="val_reference" placeholder="Refferer name"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">First delivery state</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $vehicles['val_first_dlvry_state']; ?>"
                                                                   name="valuation[val_first_dlvry_state]" id="val_reference" placeholder="First delivery state"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Dealership</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $vehicles['val_first_dlvry_dlrship']; ?>"
                                                                   name="valuation[val_first_dlvry_dlrship]" id="val_reference" placeholder="Dealership"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-12">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-2 col-sm-3 col-xs-12">Location</label>
                                                       <div class="col-md-9 col-sm-6 col-xs-6">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $vehicles['val_first_dlvry_location']; ?>"
                                                                   name="valuation[val_first_dlvry_location]" id="val_reference" placeholder="Location"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Vehicle details</h3>
                                        </div>

                                        <!-- -->
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Reg: NO</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_prt_1]" 
                                                                   value="<?php echo $vehicles['val_prt_1']; ?>"  maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="KL"/>

                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_prt_2]" 
                                                                   value="<?php echo $vehicles['val_prt_2']; ?>" maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="00"/>

                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_prt_3]" 
                                                                   value="<?php echo $vehicles['val_prt_3']; ?>" maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="AA"/>

                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_prt_4]" 
                                                                   value="<?php echo $vehicles['val_prt_4']; ?>" maxlength="4" style="text-transform: uppercase;width: 80px;" required placeholder="0000"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Brand</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required="true" data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbEvModel" 
                                                                    data-dflt-select="Select Model" class="select2_group form-control bindToDropdown" name="valuation[val_brand]" id="val_brand">
                                                                 <option value="">Select Brand</option>
                                                                 <?php
                                                                 if (!empty($brand)) {
                                                                      foreach ($brand as $key => $value) {
                                                                           ?>
                                                                           <option <?php echo $value['brd_id'] == $vehicles['val_brand'] ? 'selected="selected"' : ''; ?> 
                                                                                value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?></option>
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
                                                            <select required data-url="<?php echo site_url('enquiry/bindVarient'); ?>" 
                                                                    data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                                    class="cmbEvModel select2_group form-control bindToDropdown" 
                                                                    name="valuation[val_model]" id="val_model">

                                                                 <?php foreach ((array) $model as $key => $value) { ?>
                                                                      <option <?php echo $value['mod_id'] == $vehicles['val_model'] ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $value['mod_id']; ?>"><?php echo $value['mod_title']; ?></option>
                                                                      <?php } ?>

                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Variant</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control cmbEvVariant" 
                                                                    name="valuation[val_variant]" id="val_variant">
                                                                         <?php foreach ((array) $variant as $key => $value) { ?>
                                                                      <option <?php echo $value['var_id'] == $vehicles['val_variant'] ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $value['var_id']; ?>"><?php echo $value['var_variant_name']; ?></option>
                                                                      <?php } ?>
                                                            </select>
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
                                                                   value="<?php echo date('d-m-Y', strtotime($vehicles['val_delv_date'])); ?>"
                                                                   type="text" name="valuation[val_delv_date]" id="val_delv_date">
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Fuel</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control bindToDropdown" name="valuation[val_fuel]" i="val_fuel">
                                                                 <?php foreach (unserialize(FUAL) as $key => $value) { ?>
                                                                      <option value="<?php echo $key; ?>" <?php echo ($vehicles['val_fuel'] == $key) ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                                                 <?php } ?>
                                                            </select>
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
                                                                   value="<?php echo date('d-m-Y', strtotime($vehicles['val_reg_date'])); ?>"
                                                                   name="valuation[val_reg_date]" id="val_reg_date" placeholder="1ST Reg Date"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">RC Color</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" required
                                                                   value="<?php echo $vehicles['val_rc_color']; ?>"
                                                                   name="valuation[val_rc_color]" id="val_rc_color" placeholder="RC Color"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Model Year</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-4 col-xs-6 numOnly val_model_year"
                                                                   value="<?php echo $vehicles['val_model_year']; ?>"  maxlength="4" style="width: 50%;" name="valuation[val_model_year]" id="val_model_year" placeholder="Model Year"/>

                                                            <input type="text" class="form-control col-md-4 col-xs-6 numOnly val_minif_year"
                                                                   value="<?php echo $vehicles['val_minif_year']; ?>"  maxlength="4" style="width: 50%;" name="valuation[val_minif_year]" id="val_minif_year" placeholder="Mnf Year" required/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Color</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-4 col-xs-6" name="val_color" required>
                                                                 <option value="">Colour</option>
                                                                 <?php foreach ($colors as $key => $value) { ?>
                                                                      <option <?php echo $vehicles['val_color']==$value['vc_id']?'selected':''; ?> value="<?php echo $value['vc_id']; ?>"><?php echo $value['vc_color']; ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">A/C</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select style="width: 50%;" class="form-control col-md-4 col-xs-6" name="valuation[val_ac]" id="val_ac">
                                                                 <option value="">Select A/C</option>
                                                                 <option <?php echo ($vehicles['val_ac'] == 1) ? 'selected="selected"' : ''; ?> value="1">W/o</option>
                                                                 <option <?php echo ($vehicles['val_ac'] == 2) ? 'selected="selected"' : ''; ?> value="2">Single</option>
                                                                 <option <?php echo ($vehicles['val_ac'] == 3) ? 'selected="selected"' : ''; ?> value="3">Dual</option>
                                                                 <option <?php echo ($vehicles['val_ac'] == 4) ? 'selected="selected"' : ''; ?> value="4">Multi</option>
                                                            </select>

                                                            <input type="text" class="form-control col-md-4 col-xs-6 numOnly"
                                                                   value="<?php echo $vehicles['val_ac_zone']; ?>" style="width: 50%;" name="valuation[val_ac_zone]" id="val_model_year" placeholder="No of zone" required/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">No.of Owner(s)</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   value="<?php echo $vehicles['val_no_of_owner']; ?>" placeholder="No.of Owner(s)" 
                                                                   type="text" name="valuation[val_no_of_owner]" id="val_no_of_owner">
                                                       </div>
                                                  </div>
                                             </div>
                                             <!--                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Manufacture Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   type="text" name="valuation[val_manf_date]" id="val_manf_date">
                                                       </div>
                                                  </div>
                                             </div>-->
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Eng CC</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_eng_cc]" 
                                                                   value="<?php echo $vehicles['val_eng_cc']; ?>" id="val_eng_cc" placeholder="Eng CC"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <!-- <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Registration Date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   type="text" name="valuation[val_reg_date]" id="val_reg_date">
                                                       </div>
                                                  </div>
                                             </div>-->
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Transmission</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select required class="select2_group form-control" name="valuation[val_transmission]" id="val_transmission">
                                                                 <option value="">Select Transmission</option>
                                                                 <option value="1" <?php echo ($vehicles['val_transmission'] == 1) ? 'selected="selected"' : ''; ?>>M/T</option>
                                                                 <option value="2" <?php echo ($vehicles['val_transmission'] == 2) ? 'selected="selected"' : ''; ?>>A/T</option>
                                                                 <option value="3" <?php echo ($vehicles['val_transmission'] == 3) ? 'selected="selected"' : ''; ?>>S/T</option>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Vehicle type</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control" name="valuation[val_veh_type]" required>
                                                                 <option value="">Select vehicle type</option>
                                                                 <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) { ?>
                                                                      <option <?php echo ($vehicles['val_veh_type'] == $key) ? 'selected="selected"' : ''; ?> 
                                                                           value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">No.of Seats</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   value="<?php echo $vehicles['val_no_of_seats']; ?>" placeholder="No.of Seats"  type="text" name="valuation[val_no_of_seats]" id="val_no_of_seats">
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
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Engine Number</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12" 
                                                                   value="<?php echo $vehicles['val_engine_no']; ?>" placeholder="Engine Number" type="text" name="valuation[val_engine_no]" id="val_engine_no">
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Chassis Number</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12" 
                                                                   value="<?php echo $vehicles['val_chasis_no']; ?>" placeholder="Chassis Number" type="text" name="valuation[val_chasis_no]" id="val_chasis_no">
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Compressor</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="form-control col-md-7 col-xs-12" name="valuation[val_ac_compressor]">
                                                                 <option value="">Select Compressor</option>
                                                                 <option <?php echo ($vehicles['val_ac_compressor'] == 1) ? 'selected="selected"' : ''; ?> value="1">Single</option>
                                                                 <option <?php echo ($vehicles['val_ac_compressor'] == 2) ? 'selected="selected"' : ''; ?> value="2">Double</option>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">KM Reading</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="valuation[val_km]" 
                                                                   value="<?php echo $vehicles['val_km']; ?>" id="val_km" placeholder="KM Reading" required/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <!--<div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">No.of Camera fine</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input required="required" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="valuation[val_camera_fine]" id="val_camera_fine">
                                                       </div>
                                                  </div>
                                             </div>-->
                                        </div>
                                        <!-- -->

                                        <div class="chk-container">
                                             <h3 class="border-bottom border-gray pb-2 text-center">Insurance</h3>
                                        </div>

                                        <div class="row">
                                             <!-- -->
                                             <table class="table table-striped table-bordered">
                                                  <tr>
                                                       <th>Insurance</th>
                                                       <th>Valid UP to</th>
                                                       <th>IDV Value</th>
                                                  </tr>
                                                  <tr>
                                                       <td>Comprehensive <?php echo $vehicles['val_insurance_comp_date']; ?></td>
                                                       <td><input value="<?php
                                                            echo!empty($vehicles['val_insurance_comp_date']) ?
                                                                    date('d-m-Y', strtotime($vehicles['val_insurance_comp_date'])) : '';
                                                            ?>" placeholder="Valid UP to (comprehensive)" 
                                                                  type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" name="valuation[val_insurance_comp_date]"/></td>
                                                       <td><input value="<?php echo $vehicles['val_insurance_comp_idv']; ?>" placeholder="IDV Value (comprehensive)" 
                                                                  type="text" class="form-control col-md-7 col-xs-12 decimalOnly" name="valuation[val_insurance_comp_idv]"/></td>
                                                  </tr>
                                                  <tr>
                                                       <td>Limited Liability</td>
                                                       <td><input value="<?php echo!empty($vehicles['val_insurance_ll_date']) ? date('d-m-Y', strtotime($vehicles['val_insurance_ll_date'])) : ''; ?>" 
                                                                  placeholder="Limited Liability (Limited Liability)" type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" name="valuation[val_insurance_ll_date]"/></td>
                                                       <td><input value="<?php echo $vehicles['val_insurance_ll_idv']; ?>" 
                                                                  placeholder="NCB" type="text" class="form-control col-md-7 col-xs-12" name="valuation[val_insurance_ll_idv]"/></td>
                                                  </tr>
                                                  <tr>
                                                       <td>NCB need by Customer</td>
                                                       <td><input <?php echo ($vehicles['val_insurance_need_ncb'] == 1) ? 'checked' : ''; ?>  value="1" type="checkbox" 
                                                                                                                                              name="valuation[val_insurance_need_ncb]"/></td>
                                                       <td>
                                                            <span style="float: left;">Type</span>
                                                            <div style="float: left;width: 200px;margin-left: 20px;">
                                                                 <select class="col-md-2 col-xs-5 select2_group form-control"
                                                                         name="valuation[val_insurance]" id="val_insurance">
                                                                      <option value="0">Select Insurance Type</option>
                                                                      <?php foreach (unserialize(INSURANCE_TYPES) as $key => $value) { ?>
                                                                           <option <?php echo ($vehicles['val_insurance'] == $key) ? 'selected="selected"' : ''; ?>   
                                                                                value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                           <?php } ?>
                                                                 </select>
                                                            </div>
                                                       </td>
                                                  </tr>
                                             </table>
                                             <!-- -->
                                             <!--<div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Type</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control" name="valuation[val_insurance]" id="val_insurance">
                                                                 <option value="0">Select Insurance Type</option>
                                             <?php foreach (unserialize(INSURANCE_TYPES) as $key => $value) { ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                             <?php } ?>
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
                                             </div>-->
                                        </div>
                                        <div class="row">
                                             <div class="col-sm-12">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-6 col-sm-3 col-xs-12">Insurance company Name</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 txtValHypoBankBranch" value="<?php echo $vehicles['val_insurance_company']; ?>"
                                                                   name="valuation[val_insurance_company]" id="val_hypo_bank_branch" placeholder="Insurance company Name"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <!--                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">IDV Value</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" name="valuation[val_insurance_idv]" 
                                                                   id="val_insurance_idv" placeholder="IDV Value"/>
                                                       </div>
                                                  </div>
                                             </div>-->
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
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="checkbox" <?php echo ($vehicles['val_finance'] == 1) ? 'checked' : ''; ?>
                                                                   name="valuation[val_finance]" value="1" id="val_finance"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Hypothecation will close by customer</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12"><input <?php echo ($vehicles['val_hypo_close_by_cust'] == 1) ? 'checked' : ''; ?> 
                                                                 type="checkbox" name="valuation[val_hypo_close_by_cust]" value="1" id="val_hypo_close_by_cust"/></div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Bank</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select class="cmbSearchList select2_group form-control" name="valuation[val_hypo_bank]" id="val_hypo_bank">
                                                                 <option value="">Select bank</option>
                                                                 <?php foreach ($banks as $key => $value) { ?>
                                                                      <option <?php echo ($vehicles['val_hypo_bank'] == $value['bnk_id']) ? 'selected="selected"' : ''; ?>
                                                                           value="<?php echo $value['bnk_id']; ?>"><?php echo $value['bnk_name']; ?></option>
                                                                      <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Branch</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $vehicles['val_hypo_bank_branch']; ?>"
                                                                   name="valuation[val_hypo_bank_branch]" id="val_hypo_bank_branch" placeholder="Branch"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Loan amount</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" value="<?php echo $vehicles['val_hypo_loan_amt']; ?>"
                                                                   name="valuation[val_hypo_loan_amt]" id="val_hypo_loan_amt" placeholder="Loan amount"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Loan date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   value="<?php echo!empty($vehicles['val_hypo_loan_date']) ? date('d-m-Y', strtotime($vehicles['val_hypo_loan_date'])) : ''; ?>" 
                                                                   name="valuation[val_hypo_loan_date]" id="val_hypo_loan_date" placeholder="Loan date"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Foreclosure value</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" 
                                                                   value="<?php echo $vehicles['val_hypo_frclos_val']; ?>"
                                                                   name="valuation[val_hypo_frclos_val]" id="mod_title" placeholder="Foreclosure value"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Foreclosure date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   value="<?php echo!empty($vehicles['val_hypo_frclos_date']) ? date('d-m-Y', strtotime($vehicles['val_hypo_frclos_date'])) : ''; ?>"
                                                                   name="valuation[val_hypo_frclos_date]" id="val_hypo_frclos_date" placeholder="Foreclosure date"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Daily interest</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" 
                                                                   value="<?php echo $vehicles['val_hypo_daily_int']; ?>"
                                                                   name="valuation[val_hypo_daily_int]" id="val_hypo_daily_int" placeholder="Daily interest"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-6">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Loan ending date</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" 
                                                                   value="<?php echo!empty($vehicles['val_hypo_loan_end_date']) ? date('d-m-Y', strtotime($vehicles['val_hypo_loan_end_date'])) : ''; ?>"
                                                                   name="valuation[val_hypo_loan_end_date]" id="val_hypo_loan_end_date" placeholder="Loan ending date"/>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-12">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-2 col-sm-3 col-xs-12">Description</label>
                                                       <div class="col-md-9 col-sm-6 col-xs-12">
                                                            <textarea id="val_finance_remark" class="form-control col-md-7 col-xs-12" 
                                                                      rows="4" name="valuation[val_finance_remark]"><?php echo $vehicles['val_finance_remark']; ?></textarea>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="col-sm-12">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-2 col-sm-3 col-xs-12">Any Top up Loan</label>
                                                       <div class="col-md-9 col-sm-6 col-xs-12">
                                                            <input type="checkbox" name="valuation[val_top_up_loan]" value="1" 
                                                                   <?php echo ($vehicles['val_top_up_loan'] == 1) ? 'checked' : ''; ?> />
                                                       </div>
                                                  </div>
                                             </div>

                                             <!-- Features -->
                                             <?php $features = $vehicles['features']; ?>
                                             <div class="chk-container" style="float: left;width: 100%;">
                                                  <h3 class="border-bottom border-gray pb-2 text-center">Features <i style="cursor: pointer;" type="button" class="fa fa-plus" data-toggle="modal" data-target="#exampleModal"></i></h3>
                                                  <ul class="ks-cboxtags ulVehicleFeatures">
                                                       <?php
                                                       if (!empty($vehicleFeatures)) {
                                                            foreach ($vehicleFeatures as $key => $value) {
                                                                 ?>
                                                                 <li>
                                                                      <input <?php echo (in_array($value['vftr_id'], $features)) ? 'checked' : ''; ?> 
                                                                           type="checkbox" name="features[<?php echo $value['vftr_id']; ?>]" id="checkboxOne<?php echo $value['vftr_id']; ?>" value="<?php echo $value['vftr_id']; ?>">
                                                                      <label for="checkboxOne<?php echo $value['vftr_id']; ?>"><?php echo $value['vftr_feature']; ?></label>
                                                                 </li>
                                                                 <?php
                                                            }
                                                       }
                                                       ?>
                                                  </ul>
                                             </div>

                                             <!-- Add on features -->
                                             <div class="chk-container" style="float: left;width: 100%;">
                                                  <h3 class="border-bottom border-gray pb-2 text-center">Add on features / loadings</h3>
                                                  <ul class="ks-cboxtags ulVehicleAdOnFeatures">
                                                       <?php
                                                       if (!empty($vehicleAddOnFeatures)) {
                                                            foreach ($vehicleAddOnFeatures as $key => $value) {
                                                                 ?>
                                                                 <li>
                                                                      <input <?php echo (in_array($value['vftr_id'], $features)) ? 'checked' : ''; ?> 
                                                                           type="checkbox" name="features[<?php echo $value['vftr_id']; ?>]" id="checkboxOne<?php echo $value['vftr_id']; ?>" value="<?php echo $value['vftr_id']; ?>">
                                                                      <label for="checkboxOne<?php echo $value['vftr_id']; ?>"><?php echo $value['vftr_feature']; ?></label>
                                                                 </li>
                                                                 <?php
                                                            }
                                                       }
                                                       ?>
                                                  </ul>
                                             </div>
                                             <!-- Features -->
                                        </div>

                                        <div class="row">
                                             <div class="col-sm-4">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Air Bags</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="valuation[val_air_bags]" 
                                                                   value="<?php echo $vehicles['val_air_bags']; ?>" id="val_air_bags" placeholder="Air Bags"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-4">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">No of Exhaust</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="valuation[val_exhaust]" 
                                                                   value="<?php echo $vehicles['val_exhaust']; ?>" id="val_exhaust" placeholder="No of Exhaust"/>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-4">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-6 col-sm-3 col-xs-12">No of power window</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="valuation[val_no_of_pw]" 
                                                                   value="<?php echo $vehicles['val_no_of_pw']; ?>" id="val_exhaust" placeholder="No of power window"/>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <div id="step-2" class="">
                                        <table class="table table-striped table-bordered">
                                             <thead>
                                                  <tr>
                                                       <th style="text-align: center;font-size: 20px;" colspan="10">Vehicle evaluation details</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php
                                                  $bdChkup = $vehicles['bdChkup'];
                                                  foreach ($fullBodyCheckupMaster as $mk => $mstr) {
                                                       $fullBodyCheckupDetails = $this->evaluation->getFullBodyCheckupDetailByMaster($mstr['vfbcm_id']);
                                                       ?>
                                                       <tr>
                                                            <td class="td-head"><?php echo $mstr['vfbcm_title']; ?></td>
                                                            <?php foreach ($fullBodyCheckupDetails as $dk => $dtls) { ?>   
                                                                 <td>
                                                                      <label class="ctrl-container"><?php echo $dtls['vfbcd_title']; ?>
                                                                           <input <?php echo (in_array($dtls['vfbcd_id'], $bdChkup)) ? 'checked' : ''; ?>
                                                                                type="radio" value="<?php echo $dtls['vfbcd_id']; ?>" 
                                                                                id="fulbdchk<?php echo $dtls['vfbcd_id']; ?>" name="fulbdchk[<?php echo $mstr['vfbcm_id']; ?>]">
                                                                           <span class="checkmark"></span>
                                                                      </label>
                                                                 </td>
                                                            <?php } ?>
                                                       </tr>
                                                  <?php } ?>
                                             </tbody>
                                        </table>
                                        <!-- -->
                                        <div>
                                             <!-- -->
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
                                                                             <?php echo ($vehicles['val_wrnty'] == 1) ? 'checked' : ''; ?> onclick="$('.tdValidityKM').show();">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <td>
                                                                 <label class="ctrl-container">Not Valid
                                                                      <input type="radio" name="valuation[val_wrnty]" value="0" id="val_wrnty_n"
                                                                             <?php echo ($vehicles['val_wrnty'] == 0) ? 'checked' : ''; ?> onclick="$('.tdValidityKM').hide();">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <td class="td-head"> Ser History ; LS Date</td>
                                                            <td>
                                                                 <input value="<?php echo!empty($vehicles['val_last_service']) ? date('d-m-Y', strtotime($vehicles['val_last_service'])) : ''; ?>" name="valuation[val_last_service]" 
                                                                        id="val_last_service" type="text" class="form-control dtpDatePickerEvaluation" style="width: 100%;"/>
                                                            </td>
                                                            <td class="td-head"> LS KM</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_last_service_km']; ?>" name="valuation[val_last_service_km]" id="val_last_service_km" type="text" class="form-control numOnly" style="width: 100%;"/>
                                                            </td>
                                                       </tr>
                                                       <tr class="tdValidityKM" style="<?php echo ($vehicles['val_wrnty'] == 0) ? 'display: none;' : ''; ?>">
                                                            <td colspan="2" class="td-head"> Warranty Validity up to</td>
                                                            <td colspan="2">
                                                                 <input class="form-control dtpDatePickerEvaluation" type="text" id="val_wrnty_validity"
                                                                        value="<?php echo $vehicles['val_wrnty_validity']; ?>" style="width: 100%;" name="valuation[val_wrnty_validity]"/>
                                                            </td>
                                                            <td  colspan="2" class="td-head"> Warranty Validity KM up to</td>
                                                            <td colspan="2">
                                                                 <input value="<?php echo $vehicles['val_wrnty_km']; ?>" 
                                                                        type="text" class="form-control numOnly" style="width: 100%;" id="val_wrnty_km" name="valuation[val_wrnty_km]"/>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Extra Warranty </td>
                                                            <td>
                                                                 <label class="ctrl-container">Reg
                                                                      <input value="1" <?php echo ($vehicles['val_wrnty_extra'] == 1) ? 'checked' : ''; ?> name="valuation[val_wrnty_extra]" 
                                                                             onclick="$('.tdExtraWarDetails').show();" id="val_wrnty_extra_y" value="1" type="radio">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <td>
                                                                 <label class="ctrl-container">Not Reg
                                                                      <input type="radio" name="valuation[val_wrnty_extra]" onclick="$('.tdExtraWarDetails').hide();" 
                                                                             <?php echo ($vehicles['val_wrnty_extra'] == 0) ? 'checked' : ''; ?> id="val_wrnty_extra_n" value="0">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <td class="td-head"> Service Req A.O.D</td>
                                                            <td>
                                                                 <input type="text" name="valuation[val_wrnty_service_req_aod]" id="val_wrnty_service_req_aod" 
                                                                        value="<?php echo $vehicles['val_wrnty_service_req_aod']; ?>" class="form-control" style="width: 100%;"/>
                                                            </td>
                                                            <td class="td-head"> Act Serv A.O.D</td>
                                                            <td>
                                                                 <input type="text" name="valuation[val_wrnty_act_serv_aod]" id="val_wrnty_act_serv_aod" 
                                                                        value="<?php echo $vehicles['val_wrnty_act_serv_aod']; ?>" class="form-control" style="width: 100%;"/>
                                                            </td>
                                                       </tr>
                                                       <tr class="tdExtraWarDetails" style="<?php echo ($vehicles['val_wrnty_extra'] == 0) ? 'display: none;' : ''; ?>">
                                                            <td colspan="2" class="td-head"> Ex Warranty Validity up to</td>
                                                            <td colspan="2">
                                                                 <input class="form-control dtpDatePickerEvaluation" type="text" id="val_wrnty_validity"
                                                                        value="<?php echo!empty($vehicles['val_ex_wrnty_validity']) ? date('d-m-Y', strtotime($vehicles['val_ex_wrnty_validity'])) : ''; ?>"
                                                                        style="width: 100%;" name="valuation[val_ex_wrnty_validity]"/>
                                                            </td>
                                                            <td colspan="2" class="td-head"> Ex Warranty Validity KM up to</td>
                                                            <td colspan="2">
                                                                 <input type="text" class="form-control numOnly" style="width: 100%;" id="val_wrnty_km" 
                                                                        value="<?php echo $vehicles['val_ex_wrnty_km']; ?>" name="valuation[val_ex_wrnty_km]"/>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Service Package</td>
                                                            <td>
                                                                 <label class="ctrl-container">Yes
                                                                      <input type="radio" name="valuation[val_ser_package]" id="val_ser_package_y" onclick="$('.tdNxtSerDtKM').show();"
                                                                             <?php echo ($vehicles['val_ser_package'] == 1) ? 'checked' : ''; ?> value="1" >
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <!--<td>
                                                                 <label class="ctrl-container">Yes
                                                                      <input checked type="radio" name="valuation[val_wrnty_system_scan]" id="val_wrnty_system_scan_y" value="1">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>-->
                                                            <td>
                                                                 <label class="ctrl-container">No
                                                                      <input type="radio" name="valuation[val_ser_package]" id="val_ser_package_n" 
                                                                             <?php echo ($vehicles['val_ser_package'] == 0) ? 'checked' : ''; ?> value="0" 
                                                                             onclick="$('.tdNxtSerDtKM').hide();">
                                                                      <span class="checkmark"></span>
                                                                 </label>
                                                            </td>
                                                            <td class="td-head"> Spl Ser Observations</td>
                                                            <td colspan="3">
                                                                 <input type="text" class="form-control" style="width: 100%;" id="val_wrnty_spl_ser_observ" 
                                                                        value="<?php echo $vehicles['val_wrnty_spl_ser_observ']; ?>" name="valuation[val_wrnty_spl_ser_observ]"/>
                                                            </td>
                                                       </tr>
                                                       <tr class="tdNxtSerDtKM" style="<?php echo ($vehicles['val_ser_package'] == 0) ? 'display: none;' : ''; ?>">
                                                            <td colspan="2" class="td-head"> Service package date up to</td>
                                                            <td colspan="2">
                                                                 <input class="form-control dtpDatePickerEvaluation" type="text" id="val_next_service_date"
                                                                        value="<?php echo!empty($vehicles['val_wrnty_nxt_ser_date']) ? date('d-m-Y', strtotime($vehicles['val_wrnty_nxt_ser_date'])) : ''; ?>"
                                                                        style="width: 100%;" name="valuation[val_wrnty_nxt_ser_date]"/>
                                                            </td>
                                                            <td colspan="2" class="td-head"> Service package KM up to </td>
                                                            <td colspan="2">
                                                                 <input type="text" class="form-control numOnly" style="width: 100%;" id="val_next_service_km" 
                                                                        value="<?php echo $vehicles['val_wrnty_nxt_ser_km']; ?>"  name="valuation[val_wrnty_nxt_ser_km]"/>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head">Accident history remarks</td>
                                                            <td colspan="7">
                                                                 <input type="text" class="form-control" style="width: 100%;" id="val_wrnty_im_observ" 
                                                                        value="<?php echo $vehicles['val_acc_history_remarks']; ?>" placeholder="Accident history remarks" 
                                                                        name="valuation[val_acc_history_remarks]"/>
                                                            </td>
                                                       </tr>

                                                       <tr>
                                                            <td class="td-head">Warranty service remarks</td>
                                                            <td colspan="7">
                                                                 <input type="text" class="form-control" style="width: 100%;" id="val_wrnty_spl_comments" 
                                                                        value="<?php echo $vehicles['val_wrnty_ser_remarks']; ?>" placeholder="Warranty service remarks" 
                                                                        name="valuation[val_wrnty_ser_remarks]"/>
                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                             <!-- -->

                                             <div class="row">
                                                  <table class="table table-striped table-bordered">
                                                       <thead>
                                                            <tr>
                                                                 <th style="text-align: center;font-size: 20px;" colspan="10">Refurbish Details
                                                                      <span style="cursor: pointer;" class="glyphicon glyphicon-plus btnAddUpgradDet"></span>
                                                                 </th>
                                                            </tr>
                                                       </thead>
                                                       <tbody class="tbUpgradDet">
                                                            <?php
                                                            if (!empty($vehicles['upgradeDetails'])) {
                                                                 foreach ($vehicles['upgradeDetails'] as $upkey => $upval) {
                                                                      ?>
                                                                      <tr>
                                                                           <td><input value="<?php echo $upval['upgrd_key']; ?>" name="upgradedetails[upgrd_key][]" class="form-control txtUpgradDetKey" type="text" style="width: 100%;"/></td>
                                                                           <td><input value="<?php echo $upval['upgrd_value']; ?>" name="upgradedetails[upgrd_value][]" class="form-control txtUpgradDetValue" type="text" style="width: 100%;"/></td>
                                                                           <td><span style="cursor: pointer;" class="btnRemUpgradDet glyphicon glyphicon-minus"></span></td>
                                                                      </tr>
                                                                      <?php
                                                                 }
                                                            }
                                                            ?>
                                                       </tbody>
                                                  </table>
                                             </div>
                                        </div>
                                   </div>

                                   <div id="step-3" class="">
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
                                                                 <input value="<?php echo $vehicles['val_pfr']; ?>" class="form-control" type="text" name="valuation[val_pfr]" id="val_pfr">
                                                            </td>

                                                            <td class="td-head"> Glass - Wint sheeld</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_gws']; ?>" class="form-control" type="text" name="valuation[val_gws]" id="val_gws">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> FL</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_pfl']; ?>" class="form-control" type="text" name="valuation[val_pfl]" id="val_pfl">
                                                            </td>

                                                            <td class="td-head"> Rear Glass</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_grg']; ?>" class="form-control" type="text" name="valuation[val_grg]" id="val_grg">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> CR</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_pcr']; ?>" class="form-control" type="text" name="valuation[val_pcr]" id="val_pcr">
                                                            </td>

                                                            <td class="td-head"> Door Glass R</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_gdgr']; ?>" class="form-control" type="text" name="valuation[val_gdgr]" id="val_gdgr">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> CL</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_pcl']; ?>" class="form-control" type="text" name="valuation[val_pcl]" id="val_pcl">
                                                            </td>

                                                            <td class="td-head"> Door Glass LS</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_gdgls']; ?>" class="form-control" type="text" name="valuation[val_gdgls]" id="val_gdgls">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> RR</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_prr']; ?>" class="form-control" type="text" name="valuation[val_prr]" d="val_prr">
                                                            </td>

                                                            <td class="td-head"> Q Glass R</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_qgr']; ?>" class="form-control" type="text" name="valuation[val_qgr]" id="val_qgr">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> RL</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_prl']; ?>" class="form-control" type="text" name="valuation[val_prl]" id="val_prl">
                                                            </td>

                                                            <td class="td-head"> Q Glass I</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_qgi']; ?>" class="form-control" type="text" name="valuation[val_qgi]" id="val_qgi">
                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                        </div>

                                        <div class="row">
                                             <table class="table table-striped table-bordered">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="8" style="text-align: center;font-size: 20px;">
                                                                 Tire and spare tire information
                                                            </th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td class="td-head"> Tire - FR</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_2_wek']; ?>" required class="form-control" type="text" id="val_tyre_2_wek" name="valuation[val_tyre_2_wek]" placeholder="Week"/>
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_2_yer']; ?>" required class="form-control" type="text" id="val_tyre_2_yer" name="valuation[val_tyre_2_yer]" placeholder="Year">
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_2']; ?>" required class="form-control" type="text" id="val_tyre_2_per" name="valuation[val_tyre_2]" placeholder="Percentage">
                                                            </td>

                                                            <td class="td-head"> Tire - FL</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_1_wek']; ?>" required class="form-control" type="text" id="val_tyre_1_wek" name="valuation[val_tyre_1_wek]" placeholder="Week">
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_1_yer']; ?>" required class="form-control" type="text" id="val_tyre_1_yer" name="valuation[val_tyre_1_yer]" placeholder="Year">
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_1']; ?>" required class="form-control" type="text" id="val_tyre_1_per" name="valuation[val_tyre_1]" placeholder="Percentage">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Tire - RR</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_4_wek']; ?>" required class="form-control" type="text" id="val_tyre_4_wek" name="valuation[val_tyre_4_wek]" placeholder="Week">
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_4_yer']; ?>" required class="form-control" type="text" id="val_tyre_4_yer" name="valuation[val_tyre_4_yer]" placeholder="Year">
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_4']; ?>" required class="form-control" type="text" id="val_tyre_4_per" name="valuation[val_tyre_4]" placeholder="Percentage">
                                                            </td>

                                                            <td style="width: 90px;" class="td-head"> Tire - RL</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_3_wek']; ?>" required class="form-control" type="text" id="val_tyre_3_wek" name="valuation[val_tyre_3_wek]" placeholder="Week">
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_3_yer']; ?>" required class="form-control" type="text" id="val_tyre_3_yer" name="valuation[val_tyre_3_yer]" placeholder="Year">
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_3']; ?>" required class="form-control" type="text" id="val_tyre_3_per" name="valuation[val_tyre_3]" placeholder="Percentage">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td style="width: 90px;" class="td-head"> Spare tire</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_5_wek']; ?>" required class="form-control" type="text" id="val_tyre_5_wek" name="valuation[val_tyre_5_wek]" placeholder="Week">
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_5_yer']; ?>" required class="form-control" type="text" id="val_tyre_5_yer" name="valuation[val_tyre_5_yer]" placeholder="Year">
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_5']; ?>" required class="form-control" type="text" id="val_tyre_5_per" name="valuation[val_tyre_5]" placeholder="Percentage">
                                                            </td>

                                                            <td style="width: 90px;" class="td-head"> Space savor</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_6_wek']; ?>" required class="form-control" type="text" id="val_tyre_6_wek" name="valuation[val_tyre_6_wek]" placeholder="Week">
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_6_yer']; ?>" required class="form-control" type="text" id="val_tyre_6_yer" name="valuation[val_tyre_6_yer]" placeholder="Year">
                                                            </td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_tyre_6']; ?>" required class="form-control" type="text" id="val_tyre_6_per" name="valuation[val_tyre_6]" placeholder="Percentage">
                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                        </div>

                                        <div class="row">
                                             <table class="table table-striped table-bordered">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="8" style="text-align: center;font-size: 20px;">
                                                                 Battery
                                                            </th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td class="td-head"> Make</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_battery_make']; ?>" class="form-control" type="text" name="valuation[val_battery_make]" placeholder="Make"/>
                                                            </td>

                                                            <td class="td-head"> Year</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_battery_year']; ?>" class="form-control numOnly" type="text" id="val_tyre_2_wek" name="valuation[val_battery_year]" placeholder="Year"/>
                                                            </td>

                                                            <td class="td-head"> Warranty</td>
                                                            <td>
                                                                 <input <?php echo ($vehicles['val_battery_warranty'] == 1) ? 'checked="checked"' : ''; ?> class="form-control" type="checkbox" name="valuation[val_battery_warranty]" value="1"/>
                                                            </td>

                                                            <td class="td-head"> Description</td>
                                                            <td>
                                                                 <input value="<?php echo $vehicles['val_battery_desc']; ?>" class="form-control" type="text" id="val_tyre_1_wek" name="valuation[val_battery_desc]" placeholder="Description">
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
                                                  <tbody class="tbDamages">
                                                       <?php if ($vehicles['complaints']) { ?>
                                                            <?php foreach ($vehicles['complaints'] as $comkey => $comvalue) { ?>
                                                                 <tr>
                                                                      <td>
                                                                           <?php
                                                                           if (!empty($comvalue['comp_pic'])) {
                                                                                echo img(array('src' => './assets/uploads/evaluation/' . $comvalue['comp_pic'], 'height' => '80', 'width' => '100', 'id' => 'imgBrandImage'));
                                                                           } else {
                                                                                ?>
                                                                                <input class="filDamagesFile" name="complaint_file[]" type="file" style="width: 100%;"/>
                                                                           <?php } ?>
                                                                      </td>
                                                                      <td><?php echo $comvalue['comp_complaint']; ?></td>
                                                                      <td>
                                                                           <a  data-url="<?php echo site_url($controller . '/removeImage/' . $comvalue['comp_id']); ?>" href="javascript:void(0);" style="width: 100px;" 
                                                                               class="btn btn-block btn-danger btn-xs btnDeleteImage">Delete</a>
                                                                      </td>
                                                                 </tr>
                                                                 <?php
                                                            }
                                                       }
                                                       ?>

                                                       <tr class="tbDamages">
                                                            <td><input class="filDamagesFile" name="complaint_file[]" type="file" style="width: 100%;"/></td>
                                                            <td><input class="form-control txtDamagesDesc" name="complaint_title[]" type="text" style="width: 100%;"/></td>
                                                            <td><span style="cursor: pointer;" class="glyphicon glyphicon-plus btnAddDamages"></span></td>
                                                       </tr>
                                                       <tr>
                                                            <td colspan="3">
                                                                 <textarea name="valuation[val_struct_observation]" id="val_struct_observation" placeholder="Structural Observations" class="form-control"><?php echo $vehicles['val_struct_observation']; ?></textarea>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td colspan="3">
                                                                 <textarea name="valuation[val_adj_cond]" id="val_adj_cond" placeholder="Adj For Condition" class="form-control"><?php echo $vehicles['val_adj_cond']; ?></textarea>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Suspected purchase price</td>
                                                            <td colspan="2">
                                                                 <input value="<?php echo $vehicles['val_suspt_purchase_price']; ?>" class="form-control" type="text" name="valuation[val_suspt_purchase_price]" id="val_suspt_purchase_price">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> New Vehicle Price</td>
                                                            <td colspan="2">
                                                                 <input value="<?php echo $vehicles['val_new_vehicle_price']; ?>" class="form-control" type="text" name="valuation[val_new_vehicle_price]" id="val_new_vehicle_price">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Best Market sale Price</td>
                                                            <td colspan="2">
                                                                 <input value="<?php echo $vehicles['val_price_market_est']; ?>" class="form-control" type="text" name="valuation[val_price_market_est]" id="val_price_market_est">
                                                            </td>

                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Refreshment Cost</td>
                                                            <td colspan="2">
                                                                 <input value="<?php echo $vehicles['val_refurb_cost']; ?>" class="form-control" type="text" name="valuation[val_refurb_cost]" id="val_refurb_cost">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Adj For Condition +/-</td>
                                                            <td colspan="2">
                                                                 <input value="<?php echo $vehicles['val_adj_ond_pm']; ?>" class="form-control" type="text" name="valuation[val_adj_ond_pm]" id="val_adj_ond_pm">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Profit</td>
                                                            <td colspan="2">
                                                                 <input value="<?php echo $vehicles['val_profit']; ?>" class="form-control" type="text" name="valuation[val_profit]" id="val_profit">
                                                            </td>

                                                       </tr>
                                                       <tr>
                                                            <td class="td-head"> Trade in Price</td>
                                                            <td colspan="2">
                                                                 <input value="<?php echo $vehicles['val_trade_in_price']; ?>" class="form-control" type="text" name="valuation[val_trade_in_price]" id="val_trade_in_price">
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td colspan="3">
                                                                 <textarea name="valuation[val_rfresh_job_did]" id="val_rfresh_job_did" placeholder="Refreshment job Did" class="form-control"><?php echo $vehicles['val_rfresh_job_did']; ?></textarea>
                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                        </div>
                                   </div>

                                   <div id="step-4" class="">
                                        <h3 class="border-bottom border-gray pb-2 text-center">Documents</h3>
                                        <div class="row">
                                             <div class="col-sm-12">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Document Details</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea id="val_document_details" class="form-control col-md-7 col-xs-12" rows="4" name="valuation[val_document_details]"><?php echo $vehicles['val_document_details']; ?></textarea>
                                                            <?php echo!check_permission('evaluation', 'updatedocumentdetails') ? '<p style="color:red;">You are not permission to update this field</p>' : ''; ?>
                                                       </div>
                                                  </div>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-4 col-sm-3 col-xs-12">Other Remarks</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea id="val_remarks" class="form-control col-md-7 col-xs-12"  rows="4"  name="valuation[val_remarks]"><?php echo $vehicles['val_remarks']; ?></textarea>
                                                       </div>
                                                  </div>

                                                  <!-- -->
                                                  <?php foreach ((array) $vehicles['documents'] as $key => $value) { ?>
                                                       <div class="form-group" style="float: left;width: 100%;">

                                                            <div class="gallery deleteRow<?php echo $value['vdoc_id']; ?> col-md-6 col-sm-6 col-xs-12" style="padding: 10px;">
                                                                 <a target="_blank" href="javascript:;">
                                                                      <?php
                                                                      if (is_image($value['vdoc_doc'])) {
                                                                           echo img(array('class' => 'img', 'src' => 'https://royaldrive.in/assets/uploads/evaluation/' . $value['vdoc_doc'], 'style' => "width:200px;float:left;"));
                                                                      } else {
                                                                           echo img(array('src' => './assets/images/' . get_file_extension($value['vdoc_doc']) . '.png', 'style' => "width:25px;float:left;"));
                                                                      }
                                                                      ?>
                                                                 </a>
                                                                 <div class="col-md-3 col-sm-3 col-xs-12">
                                                                      <select name="document_type[]" class="form-control cmbCommonPlane" 
                                                                              data-url="<?php echo site_url('evaluation/updateDocumentType/' . $value['vdoc_id']); ?>" 
                                                                              data-confmsg="Are you sure want to change this?"
                                                                              data-meta="0"><?php foreach (unserialize(VAL_DOCUMENT_TYPE) as $dkey => $dtypes) { ?>
                                                                                <option <?php echo ($dkey == $value['vdoc_doc_type']) ? 'selected="selected"' : ''; ?> 
                                                                                     value="<?php echo $dkey; ?>"><?php echo $dtypes; ?></option>
                                                                                <?php } ?>
                                                                      </select>
                                                                      <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $value['vdoc_doc_title']; ?></label>
                                                                 </div>
                                                                 <div style="float: left;width: 100%;text-align: center;margin-top: 10px;">
                                                                      <a href="<?php echo '../../assets/uploads/evaluation/' . $value['vdoc_doc']; ?>" 
                                                                         target="_blank" class="btn btn-primary btn-xs" style="margin-bottom: 0px;">
                                                                           <i class="fa fa-file-o"></i> View</a>
                                                                      <?php if (check_permission('evaluation', 'deletedocument')) { ?>
                                                                           <a data-url="<?php echo site_url('evaluation/deleteDocument/' . encryptor($value['vdoc_id'])); ?>" 
                                                                              data-id="<?php echo $value['vdoc_id']; ?>" href="javascript:;" 
                                                                              class="deleteRow btn btn-danger btn-xs" style="margin-bottom: 0px;">
                                                                                <i class="fa fa-trash-o"></i> Delete</a>
                                                                      <?php } ?>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  <?php } ?>
                                                  <!-- -->

                                                  <?php if (check_permission('evaluation', 'updatedocumentdetails')) { ?>
                                                       <div class="form-group" style="width: 100%;float: left;">
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                 <input placeholder="Document name" id="comp_complaint" class="form-control col-md-7 col-xs-12" type="text" name="document_title[]">
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                 <select name="document_type[]" class="form-control">
                                                                      <?php foreach (unserialize(VAL_DOCUMENT_TYPE) as $key => $value) { ?>
                                                                           <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                      <?php } ?>
                                                                 </select>
                                                            </div>
                                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                                 <input type="file" class="form-control col-md-7 col-xs-12" id="file" name="documents[]" />
                                                            </div>
                                                            <div class="col-md-1 col-sm-1 col-xs-12">
                                                                 <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnMoreDocumentsEval"></span>
                                                            </div>
                                                       </div>
                                                       <div  style="width: 100%;float: left;" class="divbtnMoreDocumentsEval"></div>
                                                  <?php } ?>
                                             </div>
                                        </div>
                                   </div>

                                   <div id="step-5" class="step-5">
                                        <h3 class="border-bottom border-gray pb-2 text-center">Vehicle images</h3>
                                        <div class="row">
                                             <!--                                             <div class="form-group">
                                                                                               <label for="enq_cus_email" class="control-label col-md-4 col-sm-3 col-xs-12">Image title</label>
                                                                                               <div class="col-md-3 col-sm-3 col-xs-12">
                                                                                                    <input placeholder="Image name" id="comp_complaint" class="form-control col-md-7 col-xs-12" type="text" name="image_title[]">
                                                                                               </div>
                                                                                               <div class="col-md-2 col-sm-2 col-xs-12">
                                                                                                    <input type="file" class="form-control col-md-7 col-xs-12" id="file" name="images[]" />
                                                                                               </div>
                                                                                               <div class="col-md-1 col-sm-1 col-xs-12">
                                                                                                    <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnMoreEvalImage"></span>
                                                                                               </div>
                                                                                          </div>
                                                                                          <div  style="width: 100%;float: left;" class="divbtnMoreEvalImage"></div>-->
                                             <div class="form-group divFile">
                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f1']['vvi_image']) ? $vehicles['valVehImages']['f1']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f1']['vvi_id']) ? $vehicles['valVehImages']['f1']['vvi_id'] : '';
                                                       ?>
                                                       <div class="frame01 dropzone" id="fileupload" action="<?= base_url('index.php/evaluation/uploadFile?frame=1') ?>">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_1]" class="frame_1" value="<?php echo $img; ?>"/>
                                                  </div>

                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f2']['vvi_image']) ? $vehicles['valVehImages']['f2']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f2']['vvi_id']) ? $vehicles['valVehImages']['f2']['vvi_id'] : '';
                                                       ?>
                                                       <div class="frame02 dropzone" action="<?= base_url('index.php/evaluation/uploadFile?frame=2') ?>" id="fileupload">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_2]" class="frame_2" value="<?php echo $img; ?>"/>
                                                  </div>

                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f3']['vvi_image']) ? $vehicles['valVehImages']['f3']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f3']['vvi_id']) ? $vehicles['valVehImages']['f3']['vvi_id'] : '';
                                                       ?>
                                                       <div class="frame03 dropzone" id="fileupload" action="<?= base_url('index.php/evaluation/uploadFile?frame=3') ?>">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_3]" class="frame_3" value="<?php echo $img; ?>"/>
                                                  </div>
                                             </div>
                                             <div class="form-group divFile">
                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f4']['vvi_image']) ? $vehicles['valVehImages']['f4']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f4']['vvi_id']) ? $vehicles['valVehImages']['f4']['vvi_id'] : '';
                                                       ?>
                                                       <div action="<?= base_url('index.php/evaluation/uploadFile?frame=4') ?>" class="frame04 dropzone" id="fileupload">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_4]" class="frame_4" value="<?php echo $img; ?>"/>
                                                  </div>

                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f5']['vvi_image']) ? $vehicles['valVehImages']['f5']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f5']['vvi_id']) ? $vehicles['valVehImages']['f5']['vvi_id'] : '';
                                                       ?>
                                                       <div action="<?= base_url('index.php/evaluation/uploadFile?frame=5') ?>" class="frame05 dropzone" id="fileupload">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div>
                                                       <input type="hidden" name="eveimg[frame_5]" class="frame_5" value="<?php echo $img; ?>"/>
                                                  </div>

                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f6']['vvi_image']) ? $vehicles['valVehImages']['f6']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f6']['vvi_id']) ? $vehicles['valVehImages']['f6']['vvi_id'] : '';
                                                       ?>
                                                       <div action="<?= base_url('index.php/evaluation/uploadFile?frame=6') ?>" class="frame06 dropzone" id="fileupload">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_6]" class="frame_6" value="<?php echo $img; ?>"/>
                                                  </div>
                                             </div>
                                             <div class="form-group divFile">
                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f7']['vvi_image']) ? $vehicles['valVehImages']['f7']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f7']['vvi_id']) ? $vehicles['valVehImages']['f7']['vvi_id'] : '';
                                                       ?>
                                                       <div action="<?= base_url('index.php/evaluation/uploadFile?frame=7') ?>" class="dropzone frame07" id="fileupload">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_7]" class="frame_7" value="<?php echo $img; ?>"/>
                                                  </div>
                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f8']['vvi_image']) ? $vehicles['valVehImages']['f8']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f8']['vvi_id']) ? $vehicles['valVehImages']['f8']['vvi_id'] : '';
                                                       ?>
                                                       <div action="<?= base_url('index.php/evaluation/uploadFile?frame=8') ?>" class="dropzone frame08" id="fileupload">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_8]" class="frame_8" value="<?php echo $img; ?>"/>
                                                  </div>
                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f9']['vvi_image']) ? $vehicles['valVehImages']['f9']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f9']['vvi_id']) ? $vehicles['valVehImages']['f9']['vvi_id'] : '';
                                                       ?>
                                                       <div action="<?= base_url('index.php/evaluation/uploadFile?frame=9') ?>" class="dropzone frame09" id="fileupload">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_9]" class="frame_9" value="<?php echo $img; ?>"/>
                                                  </div>
                                             </div>
                                             <div class="form-group divFile">
                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f10']['vvi_image']) ? $vehicles['valVehImages']['f10']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f10']['vvi_id']) ? $vehicles['valVehImages']['f10']['vvi_id'] : '';
                                                       ?>
                                                       <div action="<?= base_url('index.php/evaluation/uploadFile?frame=10') ?>" class="dropzone frame10" id="fileupload">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_10]" class="frame_10" value="<?php echo $img; ?>"/>
                                                  </div>

                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f11']['vvi_image']) ? $vehicles['valVehImages']['f11']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f11']['vvi_id']) ? $vehicles['valVehImages']['f11']['vvi_id'] : '';
                                                       ?>
                                                       <div action="<?= base_url('index.php/evaluation/uploadFile?frame=11') ?>" class="dropzone frame11" id="fileupload">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_11]" class="frame_11" value="<?php echo $img; ?>"/>
                                                  </div>

                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f12']['vvi_image']) ? $vehicles['valVehImages']['f12']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f12']['vvi_id']) ? $vehicles['valVehImages']['f12']['vvi_id'] : '';
                                                       ?>
                                                       <div action="<?= base_url('index.php/evaluation/uploadFile?frame=12') ?>" class="dropzone frame12" id="fileupload">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_12]" class="frame_12" value="<?php echo $img; ?>"/>
                                                  </div>
                                             </div>
                                             <div class="form-group divFile">
                                                  <div class="content">
                                                       <?php
                                                       $img = isset($vehicles['valVehImages']['f13']['vvi_image']) ? $vehicles['valVehImages']['f13']['vvi_image'] : '';
                                                       $imgId = isset($vehicles['valVehImages']['f13']['vvi_id']) ? $vehicles['valVehImages']['f13']['vvi_id'] : '';
                                                       ?>
                                                       <div action="<?= base_url('index.php/evaluation/uploadFile?frame=13') ?>" class="dropzone frame13" id="fileupload">
                                                            <?php if (!empty($img)) { ?>
                                                                 <div style="position: relative;" class="deleteRow<?php echo $imgId; ?>">
                                                                      <?php
                                                                      echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "296"));
                                                                      ?>
                                                                      <img data-url="<?php echo site_url('evaluation/deleteValuationVehicleImage/' . encryptor($imgId)); ?>" 
                                                                           style="font-size: 25px;color: red;position: absolute;top: 0px;right: 0px;cursor: pointer;" 
                                                                           data-id="<?php echo $imgId; ?>" class="deleteRow" href="javascript:void(0);" src="../assets/images/delete.png"/>
                                                                 </div>
                                                            <?php } ?>
                                                       </div> 
                                                       <input type="hidden" name="eveimg[frame_13]" class="frame_13" value="<?php echo $img; ?>"/>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </form>

                    <!-- -->
                    <h3 class="border-bottom border-gray pb-2 text-center">Documents</h3>
                    <div class="row">
                         <div class="col-sm-12">
                              <?php if (check_permission('evaluation', 'updatedocumentdetails') && !empty($vehicles['val_document_details'])) { ?>
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Document Details</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?php echo $vehicles['val_document_details']; ?>
                                        </div>
                                   </div>
                              <?php } ?>
                              <div class="form-group">
                                   <label class="control-label col-md-4 col-sm-3 col-xs-12">Other Remarks</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php echo $vehicles['val_remarks']; ?>
                                   </div>
                              </div>

                              <!-- -->
                              <?php foreach ((array) $vehicles['documents'] as $key => $value) { ?>
                                   <div class="form-group" style="float: left;width: 100%;">

                                        <div class="gallery deleteRow<?php echo $value['vdoc_id']; ?> col-md-6 col-sm-6 col-xs-12" style="padding: 10px;">
                                             <a target="_blank" href="javascript:;">
                                                  <?php
                                                  if (is_image($value['vdoc_doc'])) {
                                                       echo img(array('class' => 'img', 'src' => 'https://royaldrive.in/assets/uploads/evaluation/' . $value['vdoc_doc'], 'style' => "width:200px;float:left;"));
                                                  } else {
                                                       echo img(array('src' => './assets/images/' . get_file_extension($value['vdoc_doc']) . '.png', 'style' => "width:25px;float:left;"));
                                                  }
                                                  ?>
                                             </a>
                                             <div class="col-md-3 col-sm-3 col-xs-12">
                                                  <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $value['vdoc_doc_title']; ?></label>
                                             </div>
                                             <div>
                                                  <a href="<?php echo 'https://royaldrive.in/assets/uploads/evaluation/' . $value['vdoc_doc']; ?>" 
                                                     target="_blank" class="btn btn-primary btn-xs" style="margin-bottom: 0px;">
                                                       <i class="fa fa-file-o"></i> View</a>
                                                  <?php if (check_permission('evaluation', 'deletedocument')) { ?>
                                                       <a data-url="<?php echo site_url('evaluation/deleteDocument/' . encryptor($value['vdoc_id'])); ?>" 
                                                          data-id="<?php echo $value['vdoc_id']; ?>" href="javascript:;" 
                                                          class="deleteRow btn btn-danger btn-xs" style="margin-bottom: 0px;">
                                                            <i class="fa fa-trash-o"></i> Delete</a>
                                                  <?php } ?>
                                             </div>
                                        </div>
                                   </div>
                              <?php } ?>
                         </div>
                    </div>
                    <!-- -->
               </div>
          </div>
     </div>
</div>

<style>
     .frame01 {background-image: url("images/01dim.jpeg");}
     .frame02 {background-image: url("images/02dim.jpeg");}
     .frame03 {background-image: url("images/03dim.jpeg");}

     .frame04 {background-image: url("images/04dim.jpeg");}
     .frame05 {background-image: url("images/05dim.jpeg");}
     .frame06 {background-image: url("images/06dim.jpeg");}

     .frame07 {background-image: url("images/07dim.jpeg");}
     .frame08 {background-image: url("images/08dim.jpeg");}
     .frame09 {background-image: url("images/09dim.jpeg");}

     .frame10 {background-image: url("images/10dim.jpeg");}
     .frame11 {background-image: url("images/11dim.jpeg");}
     .frame12 {background-image: url("images/12dim.jpeg");}

     .frame13 {background-image: url("images/13dim.jpeg");}

     .divFile {
          float: left;
     }
     .content{
          width: 300px;
          height: 300px;
          padding: 5px;
          float: left;
     }
     .content span{
          width: 250px;
     }
     .dz-message{
          text-align: center;
          font-size: 15px;
     }

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
          $(document).on('change', '.cmbModeOfContact', function () {
               var contactMod = $(this).val();
               if (contactMod == 13) { //C/O others.
                    $('.txtReference').attr('required', 'true');
               } else {
                    $('.txtReference').removeAttr('required');
               }
          });
          $('.chkHypo').change(function () {
               if (this.checked) {
                    $('.cmbValHypoBank').attr('required', 'true');
                    $('.txtValHypoBankBranch').attr('required', 'true');
               } else {
                    $('.cmbValHypoBank').removeAttr('required');
                    $('.txtValHypoBankBranch').removeAttr('required');
                    $('.txtValHypoBankBranch').css('border', '1px solid #ccc');
                    $('.txtValHypoBankBranch').next('.CaptionCont').css('border', '1px solid #ccc');
               }
          });

          $('.chkHypo').change(function () {
               $('.CaptionCont').css('border', '1px solid #ccc');
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
                    $('.txtValHypoBankBranch').next('.CaptionCont').css('border', '1px solid #ccc');
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
          /*More documents*/
          $('.btnMoreEvalImage').click(function () {
               $('.divbtnMoreEvalImage').append('<div class="form-group grp-more-image">' +
                       '<label for="enq_cus_email" class="control-label col-md-4 col-sm-3 col-xs-12">Image title</label>' +
                       '<div class="col-md-3 col-sm-3 col-xs-12">' +
                       '<input placeholder="Image name" id="comp_complaint" class="form-control col-md-7 col-xs-12" type="text" name="image_title[]">' +
                       '</div>' +
                       '<div class="col-md-2 col-sm-2 col-xs-12">' +
                       '<input type="file" class="form-control col-md-7 col-xs-12" id="file" name="images[]" />' +
                       '</div>' +
                       '<div class="col-md-1 col-sm-1 col-xs-12">' +
                       '<span style="float: right;cursor: pointer;" class="glyphicon glyphicon-minus btnRemoveMoreEval"></span>' +
                       '</div></div>');
          });
          $(document).on('click', '.btnRemoveMoreEval', function () {
               $(this).closest('.grp-more-image').remove();
          });
     });
</script>
<!-- Include SmartWizard CSS -->
<link href="../vendors/jwizard/css/smart_wizard.css" rel="stylesheet" type="text/css" />
<!-- Optional SmartWizard theme -->
<link href="../vendors/jwizard/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" />
<link href="../vendors/jwizard/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
<link href="../vendors/jwizard/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />

<div class="tmpDocuments" style="display: none">
     <div class="form-group" style="width:100%;float: left;">
          <div class="col-md-3 col-sm-3 col-xs-12">
               <input placeholder="Document name" id="comp_complaint" class="form-control col-md-7 col-xs-12" type="text" name="document_title[]">
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
               <select name="document_type[]" class="form-control">
                    <?php foreach (unserialize(VAL_DOCUMENT_TYPE) as $key => $value) { ?>
                         <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
               </select>
          </div>
          <div class="col-md-2 col-sm-2 col-xs-12">
               <input type="file" class="form-control col-md-7 col-xs-12" id="file" name="documents[]" />
          </div>
          <div class="col-md-1 col-sm-1 col-xs-12">
               <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-minus btnRemoveProductImages"></span>
          </div>
     </div>
</div>

<div class="modal fade mdlNewFeature" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
          <form class="modal-content frmNewFeature" action="<?php echo site_url('evaluation/newvehiclefature'); ?>">
               <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"  style="width: 50%;float: left;">New feature</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                    </button>
               </div>
               <div class="modal-body" style="float: left;">
                    <div class="col-sm-12">
                         <div class="form-group">
                              <label class="control-label col-md-6 col-sm-3 col-xs-12">Feature name</label>
                              <div class="col-md-6 col-sm-12 col-xs-12">
                                   <input required type="text" class="vftr_feature form-control col-md-7 col-xs-12" 
                                          name="vftr_feature" placeholder="Feature name"/>
                              </div>
                         </div>
                    </div>
                    <div class="col-sm-12">
                         <div class="form-group">
                              <label class="control-label col-md-6 col-sm-3 col-xs-12">Is Add on features / loadings</label>
                              <div class="col-md-6 col-sm-12 col-xs-12">
                                   <input type="checkbox" value="1" name="vftr_features_add_on" class="vftr_features_add_on" placeholder="Feature name"/>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnNewFeature">Submit</button>
               </div>
          </form>
     </div>
</div>