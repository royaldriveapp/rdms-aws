<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New enquiry</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <!-- Smart Wizard -->
                         <!--<p>This is a basic form wizard example that inherits the colors from the selected scheme.</p>-->
                         <form id="wizard" data-url="<?php echo site_url('enquiry/add');?>" class="form_wizard wizard_horizontal" action="#" role="form" data-toggle="validator" method="post" accept-charset="utf-8">
                              <ul class="wizard_steps">
                                   <li>
                                        <a href="#step-1">
                                             <span class="step_no">1</span>
                                             <span class="step_descr">
                                                  Step 1<br />
                                                  <small>Customer enquiry</small>
                                             </span>
                                        </a>
                                   </li>
                                   <li>
                                        <a href="#step-2">
                                             <span class="step_no">2</span>
                                             <span class="step_descr">
                                                  Step 2<br />
                                                  <small>Inquiry Questions</small>
                                             </span>
                                        </a>
                                   </li>
                                   <li>
                                        <a href="#step-3">
                                             <span class="step_no">3</span>
                                             <span class="step_descr">
                                                  Step 3<br />
                                                  <small>Vehicle details</small>
                                             </span>
                                        </a>
                                   </li>
                                   <li>
                                        <a href="#step-4">
                                             <span class="step_no">4</span>
                                             <span class="step_descr">
                                                  Step 4<br />
                                                  <small>Mode of payment</small>
                                             </span>
                                        </a>
                                   </li>
                                   <li>
                                        <a href="#step-5">
                                             <span class="step_no">5</span>
                                             <span class="step_descr">
                                                  Step 5<br />
                                                  <small>Followup</small>
                                             </span>
                                        </a>
                                   </li>
                              </ul>
                              <div id="step-1">
                                   <div class="form-horizontal form-label-left">
                                        <div id="form-step-0" role="form" data-toggle="validator">
                                             <?php
                                               if (!empty($salesExe) && $this->usr_grp != 'SE') {
                                                    ?>
                                                    <div class="form-group">
                                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sales Executive
                                                              <span class="required">*</span>
                                                         </label>
                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                              <select required="true" class="select2_group form-control enq_se_id cmbSearchList" name="enquiry[enq_se_id]">
                                                                   <option value="">Assign to sales executive</option>
                                                                   <?php foreach ($salesExe as $key => $value) {?>
                                                                        <option value="<?php echo $value['usr_id'];?>"><?php echo $value['usr_first_name'];?></option>
                                                                   <?php }?>
                                                              </select>
                                                         </div>
                                                    </div>
                                                    <?php
                                               }
                                             ?>
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enq_cus_name">Enquiry Date
                                                       <span class="required">*</span>
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input name="enquiry[enq_entry_date]" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" required="true"
                                                              value="<?php echo date('d-m-Y');?>"/>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enq_cus_name">Name
                                                       <span class="required">*</span>
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input name="enquiry[enq_cus_name]" type="text" id="enq_cus_name" class="form-control col-md-7 col-xs-12 enq_cus_name" required="">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_address" class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_address" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_address]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_mobile" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile
                                                       <span class="required">*</span>
                                                  </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_mobile" class="form-control col-md-7 col-xs-12 numOnly enq_cus_mobile" required=""
                                                              data-url="<?php echo site_url($controller . '/registerExists');?>" type="text" name="enquiry[enq_cus_mobile]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_city" class="control-label col-md-3 col-sm-3 col-xs-12">Place<span class="required">*</span></label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_city" class="autoComCity form-control col-md-7 col-xs-12" required=""
                                                              type="text" name="enquiry[enq_cus_city]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_email" class="form-control col-md-7 col-xs-12 emailOnly" type="text" name="enquiry[enq_cus_email]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_whatsapp" class="control-label col-md-3 col-sm-3 col-xs-12">Whatsapp</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_whatsapp" class="form-control col-md-7 col-xs-12 numOnly enq_cus_whatsapp" type="text" name="enquiry[enq_cus_whatsapp]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_fbid" class="control-label col-md-3 col-sm-3 col-xs-12">Customer FB Id</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_fbid" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_fbid]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_age_group" class="control-label col-md-3 col-sm-3 col-xs-12">Age group</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control" name="enquiry[enq_cus_age_group]">
                                                            <?php foreach (unserialize(CUST_AGE_GROUP) as $key => $value) {?>
                                                                   <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                              <?php }?>
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_occu" class="control-label col-md-3 col-sm-3 col-xs-12">Occupation</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_occu" class="autoComOccupation form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_occu]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_company" class="control-label col-md-3 col-sm-3 col-xs-12">Company</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_company" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_company]">
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_phone_res" class="control-label col-md-3 col-sm-3 col-xs-12">Resi phone</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_phone_res" class="form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_phone_res]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_country" class="control-label col-md-3 col-sm-3 col-xs-12">Country</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_country" class="autoComCountry form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_country]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_state" class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_state" class="autoComState form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_state]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_dist" class="control-label col-md-3 col-sm-3 col-xs-12">District</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_dist" class="autoComDistrict form-control col-md-7 col-xs-12" type="text" name="enquiry[enq_cus_dist]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_cus_pin" class="control-label col-md-3 col-sm-3 col-xs-12">Pin</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input id="enq_cus_pin" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_pin]">
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label for="enq_budget" class="control-label col-md-3 col-sm-3 col-xs-12">Budget</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="enquiry[enq_budget]" value="0" required gtrzro="true"/>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_vehicle_type" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle type</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control enq_cus_when_buy" name="enquiry[enq_vehicle_type]" required>
                                                            <option value="">Select one</option>
                                                            <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                   <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                              <?php }?>
                                                       </select>
                                                  </div>
                                             </div>
<!--                                             <div class="form-group">
                                                  <label for="enq_cus_test_drive" class="control-label col-md-3 col-sm-3 col-xs-12">Test drive</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <input type="checkbox" class="js-switch" name="enquiry[enq_cus_test_drive]" value="1"/>
                                                  </div>
                                             </div>-->
                                             <div class="form-group">
                                                  <label for="enq_cus_status" class="control-label col-md-3 col-sm-3 col-xs-12">Type</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control cmbEnqStatus" name="enquiry[enq_cus_status]">
                                                            <option value="1">Sales</option>
                                                            <option value="2">Purchase</option>
                                                            <option value="3">Exchange</option> 
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="enq_cus_status" class="control-label col-md-3 col-sm-3 col-xs-12" required>Mode of enquiry</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control cmbModeOfContact" name="enquiry[enq_mode_enq]" required>
                                                            <option value="">Select one</option>
                                                            <?php
                                                              foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                                   if (in_array($key, array(18, 17, 6, 19, 20))) {
                                                                        ?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                        <?php
                                                                   }
                                                              }
                                                            ?>
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="divReferral"></div>
                                             <div class="form-group">
                                                  <label for="enq_cus_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <textarea class="form-control col-md-7 col-xs-12" name="enquiry[enq_cus_remarks]"></textarea>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div id="step-2" class="step2">
                                   <div class="form-horizontal form-label-left">
                                        <div id="form-step-0" role="form" data-toggle="validator">
                                             <div class="qstSell">
                                                  <?php
                                                    foreach ((array) $questions['sell'] as $k => $value) {
                                                         $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                         ?>
                                                         <div class="form-group">
                                                              <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-6 col-sm-6 col-xs-12">
                                                                   <?php echo $value['qus_question'];?>
                                                              </label>
                                                              <div class="col-md-6 col-sm-3 col-xs-12">
                                                                   <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                        <input type="checkbox"  <?php echo $required;?> name="questions[sel_<?php echo $value['qus_id'];?>]" value="1"/>
                                                                   <?php } else { // Text box ?>
                                                                        <textarea autocomplete="off" <?php echo $required;?>  id="enq_cus_need" type="text" class="form-control col-md-7 col-xs-12" name="questions[sel_<?php echo $value['qus_id'];?>]"></textarea>
                                                                   <?php }?>
                                                                   <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                              </div>
                                                         </div>
                                                    <?php }?>
                                             </div>
                                             <div class="qstBuy" style="display: none;">
                                                  <?php
                                                    foreach ((array) $questions['buy'] as $k => $value) {
                                                         $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                         ?>
                                                         <div class="form-group">
                                                              <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-3 col-sm-3 col-xs-12">
                                                                   <?php echo $value['qus_question'];?>
                                                              </label>
                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                   <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                        <input <?php echo $required;?> type="checkbox" class="chk" name="questions[buy_<?php echo $value['qus_id'];?>]" value="1"/>
                                                                   <?php } else { // Text box ?>
                                                                        <textarea <?php echo $required;?> id="enq_cus_need" class="form-control col-md-7 col-xs-12" type="text" 
                                                                                                          name="questions[buy_<?php echo $value['qus_id'];?>]"></textarea>
                                                                                                  <?php }?>
                                                                   <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                              </div>
                                                         </div>
                                                    <?php }?>
                                             </div>
                                             <div class="qstExch" style="display: none;">
                                                  <?php
                                                    foreach ((array) $questions['exch'] as $k => $value) {
                                                         $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                         ?>
                                                         <div class="form-group">
                                                              <label for="enq_cus_address" style="font-size: 11px;" class="control-label col-md-3 col-sm-3 col-xs-12">
                                                                   <?php echo $value['qus_question'];?>
                                                              </label>
                                                              <div class="col-md-7 col-sm-6 col-xs-12">
                                                                   <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                        <input type="checkbox" <?php echo $required;?> class="chk" name="questions[exc_<?php echo $value['qus_id'];?>]" value="1"/>
                                                                   <?php } else { // Text box ?>
                                                                        <textarea <?php echo $required;?> id="enq_cus_need" class="form-control col-md-7 col-xs-12" type="text" 
                                                                                                          name="questions[exc_<?php echo $value['qus_id'];?>]"></textarea>
                                                                                                  <?php }?>
                                                                   <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                              </div>
                                                         </div>
                                                    <?php }?>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div id="step-3" class="step3">
                                   <h2 class="StepTitle lblSale" style="width: 100%;">Customer required vehicle<span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsSale"></span></h2>
                                   <div class="table-responsive divVehDetailsSale">
                                        <table id="datatable-responsive" class="vehDetailsSale table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                             <thead>
                                                  <tr>
                                                       <th colspan="11">
                                                            <span style="float: left;cursor: pointer;font-size: 18px;margin: 5px 10px;" class="glyphicon glyphicon-remove btnRemoveEnqVehTable"></span>
                                                            <select style="width: 170px;float: left;" class="cmbSearchList select2_group form-control cmbStock" 
                                                                    name="vehicle[sale][veh_stock_id][]" data-url="<?php echo site_url('enquiry/bindSalesTable');?>">
                                                                 <option value="0">Select Vehicle</option>
                                                                 <?php
                                                                   foreach ((array) $evaluation as $key => $value) {
                                                                        if (!$this->evaluation->isVehicleSold($value['val_id'])) { // check if vehicle sold
                                                                             ?>
                                                                             <option value="<?php echo $value['val_id'];?>">
                                                                                  <?php
                                                                                  echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                                                  $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                                                  ?>
                                                                             </option>
                                                                             <?php
                                                                        }
                                                                   }
                                                                 ?>
                                                            </select>
                                                       </th>
                                                  </tr>
                                                  <tr>
                                                       <th>Brand</th>
                                                       <th>Model</th>
                                                       <th>Variant</th>
                                                       <th>Fuel</th>
                                                       <th>Year</th>
                                                       <th>Color</th>
                                                       <th>Price from</th>
                                                       <th>Price to.</th>
                                                       <th>Km from</th>
                                                       <th>Km to</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <tr>
                                                       <td>
                                                            <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModel" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[sale][veh_brand][]">
                                                                 <option value="0">Select Brand</option>
                                                                 <?php foreach ($brands as $key => $value) {?>
                                                                        <option value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td></td>
                                                       <td></td>
                                                       <td>
                                                            <select required="true" style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
                                                                 <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_year][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_color][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_from][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_to][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_from][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_to][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="6">
                                                            <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">
                                                       </td>
                                                       <td colspan="5">
                                                            <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[sale][veh_owner][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="11">
                                                            <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks][]">
                                                       </td>
                                                  </tr>
                                             </tbody>
                                        </table>
                                   </div>
                                   <h2 class="StepTitle lblBuy" style="display: none; width: 100%;">Purchase<small> (Vehicle from customer)</small><span style="display: none; float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsBuy"></span></h2>
                                   <div class="table-responsive divVehDetailsBuy" style="display: none;">
                                        <table id="datatable-responsive" class="vehDetailsBuy table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                             <thead>
                                                  <tr>
                                                       <th colspan="11">
                                                            <span style="margin: 5px 10px;cursor: pointer;font-size: 18px;" class="glyphicon glyphicon-remove btnRemoveEnqVehTable"></span>
                                                       </th>
                                                  </tr>
                                                  <tr>
                                                       <th>Brand</th>
                                                       <th>Model</th>
                                                       <th>Variant</th>
                                                       <th>Fuel</th>
                                                       <th>Model year</th>
                                                       <th>Color</th>
                                                       <th>Price from</th>
                                                       <th>Price to.</th>
                                                       <th>Km from</th>
                                                       <th>Km to</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <tr>
                                                       <td>
                                                            <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModelBuy" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[buy][veh_brand][]">
                                                                 <option value="0">Select Brand</option>
                                                                 <?php foreach ($brands as $key => $value) {?>
                                                                        <option value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td></td>
                                                       <td></td>
                                                       <td>
                                                            <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_fuel][]">
                                                                 <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_year][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_color][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_price_from][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_price_to][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_from][]">
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_to][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="4">
                                                            <input placeholder="Customer expectation" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_cus_expect][]">
                                                       </td>
                                                       <td colspan="4">
                                                            <input placeholder="Market estimate" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_estimate][]">
                                                       </td>
                                                       <td colspan="3">
                                                            <input placeholder="Dealer valued" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_dealer_value][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="4">
                                                            <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_reg][]">
                                                       </td>
                                                       <td colspan="4">
                                                            <input placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_owner][]">
                                                       </td>
                                                       <td colspan="3">
                                                            <input placeholder="Chassis number" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_chassis_number][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="11">
                                                            <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_remarks][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="2">
                                                            <input placeholder="First delivery date" id="veh_delivery_date" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12" 
                                                                   type="text" name="vehicle[buy][veh_delivery_date][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="First reg date" id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][veh_first_reg][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="First manf year" id="veh_manf_year" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][veh_manf_year][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <select class="form-control col-md-4 col-xs-6" name="vehicle[buy][veh_ac][]" id="veh_ac">
                                                                 <option value="">Select A/C</option>
                                                                 <option value="1">W/o</option>
                                                                 <option value="2">Single</option>
                                                                 <option value="3">Dual</option>
                                                                 <option value="4">Multi</option>
                                                            </select>
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Ac zone" id="veh_ac_zone" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][veh_ac_zone][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="2">
                                                            <input placeholder="CC" id="veh_cc" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][veh_cc][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <select class="select2_group form-control" name="vehicle[buy][veh_vehicle_type][]">
                                                                 <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Engine number" id="veh_engine_num" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_engine_num][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <select required class="select2_group form-control" name="vehicle[buy][veh_transmission][]" id="val_transmission">
                                                                 <option value="">Select Transmission</option>
                                                                 <option value="1">M/T</option>
                                                                 <option value="2">A/T</option>
                                                                 <option value="3">S/T</option>
                                                            </select>
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="No of seat" id="veh_seat_no" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_seat_no][]">
                                                       </td>
                                                  </tr>
                                             </tbody>
                                        </table>
                                   </div>
                              </div>

                              <div id="step-4">
                                   <div class="form-horizontal form-label-left">
                                        <div class="form-group">
                                             <label for="enq_cus_loan_perc" class="control-label col-md-3 col-sm-3 col-xs-12">Loan percentage</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_perc" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_perc]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_amount" class="control-label col-md-3 col-sm-3 col-xs-12">Loan amount</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_amount" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_amount]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_emi" class="control-label col-md-3 col-sm-3 col-xs-12">Loan EMI</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_emi]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="enq_cus_loan_period" class="control-label col-md-3 col-sm-3 col-xs-12">Loan total period</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="enq_cus_loan_period" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="enquiry[enq_cus_loan_period]">
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div id="step-5">
                                   <div class="form-horizontal form-label-left">
                                        <div class="form-group">
                                             <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required="true" class="select2_group form-control" name="followup[foll_status]" id="foll_status">
                                                       <option value="">Select one</option>
                                                       <?php foreach (unserialize(FOLLOW_UP_STATUS) as $key => $value) {?>
                                                              <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                         <?php }?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="foll_remarks" class="form-control col-md-7 col-xs-12" type="text" name="followup[foll_remarks]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control" name="followup[foll_contact]" id="foll_contact">
                                                       <?php foreach (unserialize(MODE_OF_CONTACT_FOLLOW_UP) as $key => $value) {?>
                                                              <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                         <?php }?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12">Next action plan
                                                  <span class="required">*</span>
                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="true" id="foll_action_plan" class="form-control col-md-7 col-xs-12" type="text" 
                                                         name="followup[foll_action_plan]">
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12">Next follow up date
                                                  <span class="required">*</span>
                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="true" type="text" class="foll_next_foll_date form-control col-md-7 col-xs-12 dtpNextFollowDate" 
                                                         placeholder="Next follow up date" id="foll_next_foll_date" name="followup[foll_next_foll_date]">
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>

<script>
     $(document).ready(function () {
          /*Clone of sell buy table*/
          var vehDetailsSale = $(".vehDetailsSale").prop('outerHTML');
          var vehDetailsBuy = $(".vehDetailsBuy").prop('outerHTML');
          $(document).on('click', '.btnAddVehDetailsSale', function () {
               $('.divVehDetailsSale').append(vehDetailsSale);
               $('.cmbSearchList').SumoSelect({csvDispCount: 3, search: true, searchText: 'Enter here.'});
          });
          $(document).on('click', '.btnAddVehDetailsBuy', function () {
               $('.divVehDetailsBuy').append(vehDetailsBuy);
               $('.cmbSearchList').SumoSelect({csvDispCount: 3, search: true, searchText: 'Enter here.'});
          });
     });
</script>