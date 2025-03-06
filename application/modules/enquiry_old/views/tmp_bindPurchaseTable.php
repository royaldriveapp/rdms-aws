    <?php 
  $kms = get_km_ranges();
  $price_ranges = get_price_ranges();
  $vehicleColors = getVehicleColors();
?>
                                         
                                                              <tr>
                                                                   <td>
                                                                             <?php //print_r($buy); ?>
                                                                        <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModelBuy" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[buy][veh_brand][]">
                                                                             <option value="0">Select Brand</option>
            <?php foreach ($brands as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_brand']) && ($value['brd_id'] == $buy['veh_brand'])) ? 'selected="selected"' : '';?> value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
            <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td><?php $model = $this->myEnquiry->bindModel($buy['veh_brand'], 'array');?>
                                                                        <select required="true" style="width: 170px;" class="select2_group form-control cmbBindVariantBuy" name="vehicle[buy][veh_model][]" data-url="<?php echo site_url('enquiry/bindVarient');?>">
            <?php foreach ((array) $model as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_model']) && ($value['mod_id'] == $buy['veh_model'])) ? 'selected="selected"' : '';?> value="<?php echo $value['mod_id']?>"><?php echo $value['mod_title']?></option>
                                                                             <?php }?>
                                                                        </select></td>
                                                                   <td><?php $variant = $this->myEnquiry->bindVarient($buy['veh_model'], 'array');?>
                                                                        <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_varient][]">
            <?php foreach ((array) $variant as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_varient']) && ($value['var_id'] == $buy['veh_varient'])) ? 'selected="selected"' : '';?> value="<?php echo $value['var_id']?>"><?php echo $value['var_variant_name']?></option>
                                                                             <?php }?>
                                                                        </select></td>
                                                                   <td>
                                                                        <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_fuel][]">
            <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                                  <option <?php echo (isset($buy['veh_fuel']) && ($key == $buy['veh_fuel'])) ? 'selected="selected"' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option>
            <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <select data-placeholder="Select Year" name="vehicle[buy][veh_year][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                             <option value="0">-Select Year-</option>
                                                                             <?php
                                                                             $earliest_year = YEAR_RANGE_START;
                                                                             $latest_year = date('Y');
                                                                             foreach (range($latest_year, $earliest_year) as $i) {
                                                                                  ?>
                                                                                  <option <?php echo $buy['veh_year'] == $i ? 'selected' : ''?> value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php }?>  

                                                                        </select>
                                                                   </td>
                                                                   <td>
                                                                        <select data-placeholder="Select Color" name="vehicle[buy][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                             <option value="0">-Select Color1-</option>
            <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                                  <option <?php echo $buy['veh_color'] == $vehicleColor['vc_id'] ? 'selected' : ''?> value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
            <?php }?>
                                                                        </select>  
                                                                   </td>
                                                                   <td>
                                                                        <select data-placeholder="Select Price" name="vehicle[buy][veh_price_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                             <option value="0">-Select Price-</option>
                                                                             <?php foreach ($price_ranges as $price_range) {?>
                                                                                  <option <?php echo $buy['veh_price_id'] == $price_range['pr_id'] ? 'selected' : ''?> value="<?php echo $price_range['pr_id'];?>"><?php echo $price_range['pr_range']?></option>

            <?php }?>
                                                                        </select> 
                                                                   </td>
                                                                   <td>
                                                                        <input style="width: 100px;" value="<?php echo isset($buy['veh_km_from']) ? $buy['veh_km_from'] : '';?>" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_from][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="2">
                                                                        <select data-placeholder="Select Color" name="vehicle[buy][veh_color_in_rc][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                             <option value="0">-Color in RC-</option>
            <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                                  <option <?php echo $buy['veh_color_in_rc'] == $vehicleColor['vc_id'] ? 'selected' : ''?> value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
            <?php }?>
                                                                        </select>  
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input  placeholder="Delivery Location" class="form-control col-md-7 col-xs-12 " type="text" value="<?php echo @$buy['veh_delivery_location'];?>" name="vehicle[buy][veh_delivery_location][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="Delivery State"  class="form-control col-md-7 col-xs-12 " type="text" value="<?php echo @$buy['veh_delivery_state'];?>" name="vehicle[buy][veh_delivery_state][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="Dealership"  class="form-control col-md-7 col-xs-12 numOnly" type="text" value="<?php echo @$buy['veh_dealership'];?>" name="vehicle[buy][veh_dealership][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="3">
            <?php
            $regNo = explode("-", $buy['veh_reg']);
            ?>
            <!-- <input required="true" placeholder="KL-00-AA-0000" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_reg][]">-->
                                                                        <input value="<?php echo $regNo[0];?>" required placeholder="KL" id="enq_cus_loan_emi" style="width: 50px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[buy][veh_reg1][]" autocomplete="off">
                                                                        <input value="<?php echo $regNo[1];?>" required placeholder="00" id="enq_cus_loan_emi" style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[buy][veh_reg2][]" autocomplete="off">
                                                                        <input value="<?php echo $regNo[2];?>" required placeholder="AA" id="enq_cus_loan_emi" style="width: 60px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[buy][veh_reg3][]" autocomplete="off">
                                                                        <input value="<?php echo $regNo[3];?>" required placeholder="0000" id="enq_cus_loan_emi" style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[buy][veh_reg4][]" autocomplete="off">
                                                                   <td>
                                                                        <input placeholder="Re Registration" style="width: 170px;" class="form-control col-md-3 col-xs-3" value="<?php echo @$buy['veh_re_reg'];?>" type="text" name="vehicle[buy][veh_re_reg][]">
                                                                   </td>


                                                                   <td colspan="1">
                                                                        <input placeholder="No Of owners" class="form-control col-md-7 col-xs-12" type="number" value="<?php echo @$buy['veh_owner'];?>" name="vehicle[buy][veh_owner][]">
                                                                   </td>
                                                                   <td colspan="1">
                                                                        <select data-placeholder="Select Comprossr" name="vehicle[buy][veh_comprossr][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                             <option value="0">-Comprossr-</option>

                                                                             <option <?php echo $buy['veh_comprossr'] == 'Single' ? 'selected' : ''?> value="Single">Single</option>
                                                                             <option <?php echo $buy['veh_comprossr'] == 'Double' ? 'selected' : ''?> value="Double">Double</option>
                                                                        </select>
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="Chassis number" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo @$buy['veh_chassis_number'];?>" name="vehicle[buy][veh_chassis_number][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="8">
                                                                        <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo @$buy['veh_remarks'];?>" name="vehicle[buy][veh_remarks][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="2">
                                                                        <input placeholder="First delivery date" id="veh_delivery_date" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12" 
                                                                               type="text" value="<?php echo date('d-m-Y', strtotime($buy['veh_delivery_date']));?>" name="vehicle[buy][veh_delivery_date][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="First reg date" id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                               type="text" value="<?php echo date('d-m-Y', strtotime($buy['veh_first_reg']));?>" name="vehicle[buy][veh_first_reg][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <select data-placeholder="First manf year" name="vehicle[buy][veh_manf_year][]" style="width: 270px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                             <option value="0">-Select First manf year-</option>
                                                                             <?php
                                                                             $earliest_year = YEAR_RANGE_START;
                                                                             $latest_year = date('Y');
                                                                             foreach (range($latest_year, $earliest_year) as $i) {
                                                                                  ?>
                                                                                  <option <?php echo $buy['veh_manf_year'] == $i ? 'selected' : '';?> value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php }?>  

                                                                        </select>
                                                                   </td>
                                                                   <td colspan="1">
                                                                        <select class="form-control col-md-4 col-xs-6" name="vehicle[buy][veh_ac][]" id="veh_ac">
                                                                             <option value="0">Select A/C</option>
                                                                             <option <?php echo $buy['veh_ac'] == 1 ? 'selected' : '';?> value="1">W/o </option>
                                                                             <option <?php echo $buy['veh_ac'] == 2 ? 'selected' : '';?> value="2">Single </option>
                                                                             <option <?php echo $buy['veh_ac'] == 3 ? 'selected' : '';?> value="3">Dual </option>
                                                                             <option <?php echo $buy['veh_ac'] == 4 ? 'selected' : '';?> value="4">Multi </option>
                                                                        </select>
                                                                   </td>
                                                                   <td colspan="1">
                                                                        <input placeholder="Ac zone" id="veh_ac_zone" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                               type="text" value="<?php echo @$buy['veh_ac_zone'];?>" name="vehicle[buy][veh_ac_zone][]">
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="2">
                                                                        <input placeholder="CC" id="veh_cc" class="form-control col-md-7 col-xs-12 numOnly" 
                                                                               type="text" value="<?php echo @$buy['veh_cc'];?>" name="vehicle[buy][veh_cc][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <select class="select2_group form-control" name="vehicle[buy][veh_vehicle_type][]">
                                                                             <option value="0">-Vehicle type-</option>
            <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                                  <option <?php echo $buy['veh_vehicle_type'] == $key ? 'selected' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option> 
            <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="Engine number" id="veh_engine_num" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo @$buy['veh_engine_num'];?>" name="vehicle[buy][veh_engine_num][]">
                                                                   </td>
                                                                   <td colspan="1">
                                                                        <select required class="select2_group form-control" name="vehicle[buy][veh_transmission][]" id="val_transmission">
                                                                             <option value="0">Select Transmission</option>
                                                                             <option <?php echo $buy['veh_transmission'] == 1 ? 'selected' : '';?> value="1">M/T</option>
                                                                             <option <?php echo $buy['veh_transmission'] == 2 ? 'selected' : '';?> value="2">A/T</option>
                                                                             <option <?php echo $buy['veh_transmission'] == 3 ? 'selected' : '';?> value="3">S/T</option>
                                                                        </select>
                                                                   </td>
                                                                   <td colspan="1">
                                                                        <input placeholder="No of seat" id="veh_seat_no" class="form-control col-md-7 col-xs-12 numOnly" type="text" value="<?php echo $buy['veh_seat_no'];?>" name="vehicle[buy][veh_seat_no][]">
                                                                   </td>
                                                              </tr>
                                                              <!-- insu -->
                                                              <tr>
                                                                   <td colspan="12"><h3><center>Insurance Details</center></h3></td>
                                                                   <?php
                                                                   $insurance_and_hyp = $this->evaluation->insuranceDetails($buy['veh_id']);

                                                                   // debug($insurance_and_hyp['insurance_company']);
                                                                   ?>

                                                              </tr>
                                                              <tr>
                                                                   <td colspan="3" class="lbl-blk">Company name</td>
                                                                   <td colspan="8"><input placeholder="Insurance Company" id="veh_cc" class="form-control col-md-7 col-xs-12 " 
                                                                                          type="text" value="<?php echo $insurance_and_hyp['insurance_company'];?>" name="vehicle[buy][insurance_company][]"></td>


                                                              </tr>
                                                              <tr>

                                                                   <td colspan="2">
                                                                        Comprehesive    
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="Valid Up to " id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                               type="text" value="<?php echo date('d-m-Y', strtotime($insurance_and_hyp['valid_up_to']));?>" name="vehicle[buy][valid_up_to][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="IDV"  class=" form-control col-md-7 col-xs-12 " 
                                                                               type="text" value="<?php echo $insurance_and_hyp['idv'];?>" name="vehicle[buy][idv][]">
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="NCB%"  class=" form-control col-md-7 col-xs-12 " 
                                                                               type="text" value="<?php echo $insurance_and_hyp['ncb_percentage'];?>" name="vehicle[buy][ncb_percentage][]">
                                                                   </td>

                                                              </tr>
                                                              <tr>

                                                                   <td colspan="2" class="lbl-blk">
                                                                        Third party    
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <input placeholder="Valid Up to "  class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                               type="text" value="<?php echo date('d-m-Y', strtotime($insurance_and_hyp['val_insurance_ll_date']));?>" name="vehicle[buy][val_insurance_ll_date][]">
                                                                   </td>
                                                                   <td colspan="2">

                                                                        <select required class="select2_group form-control" name="vehicle[buy][insurance_type][]" >
                                                                             <option value="0">Insurance Type</option>
            <?php foreach (unserialize(INSURANCE_TYPES) as $key => $value) {?>
                                                                                  <option <?php echo $insurance_and_hyp['insurance_type'] == $key ? 'selected' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option>
            <?php }?>
                                                                        </select>
                                                                   </td>
                                                                   <td colspan="2">
                                                                        <select required class="select2_group form-control" name="vehicle[buy][ncb_req][]" >
                                                                             <option value="0">NCB Required  </option>
                                                                             <option <?php echo $insurance_and_hyp['ncb_req'] == 1 ? 'selected' : '';?> value="1">Yes</option>
                                                                             <option <?php echo $insurance_and_hyp['ncb_req'] == 0 ? 'selected' : '';?> value="0">No</option>
                                                                        </select>
                                                                   </td>

                                                              </tr>
                                                              <!-- @insu -->
                                                              <!--- hypothi-->
                                                              <tr>
                                                                   <td colspan="12"><h3><center>Hypothecation Details</center></h3></td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="1"><p class="labl">Finance Company </p><input placeholder="Finance Company"  class=" form-control col-md-7 col-xs-12 " 
                                                                                                                              type="text" value="" name="vehicle[buy][finance_company][]"> </td>
                                                                   <td colspan="3"><p class="labl">Bank<?php echo $insurance_and_hyp['bank'];?></p> <select class="cmbSearchList select2_group form-control cmbValHypoBank" name="vehicle[buy][bank][]" id="val_hypo_bank">
                                                                             <option value="">Select bank</option>
            <?php foreach ($banks as $key => $value) {?>
                                                                                  <option <?php echo $insurance_and_hyp['bank'] == $value['bnk_id'] ? 'selected' : ''?> value="<?php echo $value['bnk_id'];?>"><?php echo $value['bnk_name'];?></option>
            <?php }?>
                                                                        </select></td>
                                                                   <td colspan="2"><p class="labl">Branch</p><input placeholder="Branch"  class=" form-control col-md-7 col-xs-12 " 
                                                                                                                    type="text" value="<?php echo $insurance_and_hyp['bank_branch'];?>" name="vehicle[buy][bank_branch][]"></td>
                                                                   <td colspan="2"> <p class="labl">Hypothecation will close by customer</p><input class="chkHypoByCust" type="checkbox" <?php echo $insurance_and_hyp['val_hypo_close_by_cust'] ? 'checked' : ''?> name=vehicle[buy][val_hypo_close_by_cust][]" value="1" ></td>
                                                              </tr>
                                                              <tr>
                                                                   <td colspan="2"> <p class="labl">Loan Starting Date </p><input placeholder="Loan Starting Date "  class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                                                                                  type="text" value="<?php echo date('d-m-Y', strtotime($insurance_and_hyp['loan_starting_date']));?>" name="vehicle[buy][loan_starting_date][]"></td>


                                                                   <td colspan="2"> <p class="labl">Loan Ending Date <?php echo $insurance_and_hyp['loan_ending_date'];?></p><input placeholder="Loan Ending Date"  class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                                                                                                                                     type="text" value="<?php echo date('d-m-Y', strtotime($insurance_and_hyp['loan_ending_date']));?>" name="vehicle[buy][loan_ending_date][]"></td>

                                                                   <td colspan="1"> <p class="labl">Loan amount </p><input placeholder="Loan amount"  class=" form-control col-md-7 col-xs-12 numOnly" 
                                                                                                                           type="text" value="<?php echo $insurance_and_hyp['loan_amount'];?>" name="vehicle[buy][loan_amount][]"></td>
                                                                   <td colspan="1"> <p class="labl">Forclousure value </p><input placeholder="Forclousure value"  class=" form-control col-md-7 col-xs-12 numOnly" 
                                                                                                                                 type="text" value="<?php echo $insurance_and_hyp['forclousure_value'];?>" name="vehicle[buy][forclousure_value][]"></td>


                                                                   <td colspan="2"> <p class="labl">Forclousure date </p><input placeholder="Forclousure date"  class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                                                                                type="text" value="<?php echo date('d-m-Y', strtotime($insurance_and_hyp['forclousure_date']));?>" name="vehicle[buy][forclousure_date][]"></td>

                                                              </tr>
                                                              <tr>
                                                                   <td colspan="2"> <p class="labl">Daily Interest </p><input placeholder="Daily Interest "  class=" form-control col-md-7 col-xs-12 numOnly" 
                                                                                                                              type="text" value="<?php echo $insurance_and_hyp['daily_interest'];?>" name="vehicle[buy][daily_interest][]"></td>
                                                                   <td colspan="2"> <p class="labl">Any Top up Loan  </p><input class="chkHypoByCust" type="checkbox" <?php echo $insurance_and_hyp['any_top_up_loan'] ? 'checked' : ''?> name=vehicle[buy][any_top_up_loan][]" value="1" ></td>
                                                              </tr>
                                                              <!-- @hypothi --> 
                                                     