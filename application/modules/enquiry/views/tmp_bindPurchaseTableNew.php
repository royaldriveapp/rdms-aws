    <?php 
  $kms = get_km_ranges();
  $price_ranges = get_price_ranges();
  $vehicleColors = getVehicleColors();
?>
                                                  <tr>
                                                       <td>
                                                            <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModelBuy" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[buy][veh_brand][]">
                                                                 <option value="0">Select Brand--</option>
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
                                                            <select data-placeholder="Select Year" name="vehicle[buy][veh_year][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                 <option value="0">-Select Year-</option>
                                                                 <?php
                                                                   $earliest_year = YEAR_RANGE_START;
                                                                   $latest_year = date('Y');
                                                                   foreach (range($latest_year, $earliest_year) as $i) {
                                                                        ?>
                                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                   <?php }?>  

                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select data-placeholder="Select Color" name="vehicle[buy][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                 <option value="0">-Select Color-</option>
                                                                 <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                        <option value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                                                   <?php }?>
                                                            </select>  
                                                       </td>
                                                       <td>
                                                            <select data-placeholder="Select Price" name="vehicle[buy][veh_price_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                 <option value="0">-Select Price-</option>
                                                                 <?php foreach ($price_ranges as $price_range) {?>
                                                                        <option value="<?php echo $price_range['pr_id'];?>"><?php echo $price_range['pr_range']?></option>

                                                                   <?php }?>
                                                            </select>  
                                                       </td>
                                                       <td>
                                                            <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_from][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="2">
                                                            <select data-placeholder="Select Color" name="vehicle[buy][veh_color_in_rc][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                 <option value="0">-Color in RC-</option>
                                                                 <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                        <option value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                                                   <?php }?>
                                                            </select>  
                                                       </td>
                                                       <td colspan="2">
                                                            <input  placeholder="Delivery Location" class="form-control col-md-7 col-xs-12 " type="text" name="vehicle[buy][veh_delivery_location][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Delivery State"  class="form-control col-md-7 col-xs-12 " type="text" name="vehicle[buy][veh_delivery_state][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Dealership"  class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_dealership][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="3">
<!-- <input required="true" placeholder="KL-00-AA-0000" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_reg][]">-->
                                                            <input required placeholder="KL" id="enq_cus_loan_emi" style="width: 50px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[buy][veh_reg1][]" autocomplete="off">
                                                            <input required placeholder="00" id="enq_cus_loan_emi" style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[buy][veh_reg2][]" autocomplete="off">
                                                            <input required placeholder="AA" id="enq_cus_loan_emi" style="width: 60px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[buy][veh_reg3][]" autocomplete="off">
                                                            <input required placeholder="0000" id="enq_cus_loan_emi" style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[buy][veh_reg4][]" autocomplete="off">
                                                       <td>
                                                            <input placeholder="Re Registration" style="width: 170px;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[buy][veh_re_reg][]">
                                                       </td>


                                                       <td colspan="1">
                                                            <input placeholder="No Of ownes" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_owner][]">
                                                       </td>
                                                       <td colspan="1">
                                                            <select data-placeholder="Select Comprossr" name="vehicle[buy][veh_comprossr][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                 <option value="0">-Comprossr-</option>

                                                                 <option value="Single">Single</option>
                                                                 <option value="Double">Double</option>
                                                            </select>
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Chassis number" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_chassis_number][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="8">
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
                                                            <select data-placeholder="First manf year" name="vehicle[buy][veh_manf_year][]" style="width: 270px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                 <option value="0">-Select First manf year-</option>
                                                                 <?php
                                                                   $earliest_year = YEAR_RANGE_START;
                                                                   $latest_year = date('Y');
                                                                   foreach (range($latest_year, $earliest_year) as $i) {
                                                                        ?>
                                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                   <?php }?>  

                                                            </select>
                                                       </td>
                                                       <td colspan="1">
                                                            <select class="form-control col-md-4 col-xs-6" name="vehicle[buy][veh_ac][]" id="veh_ac">
                                                                 <option value="0">Select A/C</option>
                                                                 <option value="1">W/o</option>
                                                                 <option value="2">Single</option>
                                                                 <option value="3">Dual</option>
                                                                 <option value="4">Multi</option>
                                                            </select>
                                                       </td>
                                                       <td colspan="1">
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
                                                                 <option value="0">-Vehicle type-</option>
                                                                 <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Engine number" id="veh_engine_num" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_engine_num][]">
                                                       </td>
                                                       <td colspan="1">
                                                            <select required class="select2_group form-control" name="vehicle[buy][veh_transmission][]" id="val_transmission">
                                                                 <option value="0">Select Transmission</option>
                                                                 <option value="1">M/T</option>
                                                                 <option value="2">A/T</option>
                                                                 <option value="3">S/T</option>
                                                            </select>
                                                       </td>
                                                       <td colspan="1">
                                                            <input placeholder="No of seat" id="veh_seat_no" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_seat_no][]">
                                                       </td>
                                                  </tr>
                                                   <!-- insu -->
                                                  <tr>
                                                       <td colspan="12"><h3><center>Insurance Details</center></h3></td>
                                                        
                                                       
                                                  </tr>
                                                   <tr>
                                                       <td colspan="3">Company name</td>
                                                        <td colspan="8"><input placeholder="Insurance Company" id="veh_cc" class="form-control col-md-7 col-xs-12 " 
                                                                   type="text" name="vehicle[buy][insurance_company][]"></td>
                                                        
                                                       
                                                  </tr>
                                                    <tr>
                                                      
                                                       <td colspan="2">
                                                        Comprehesive    
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Valid Up to " id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][valid_up_to][]">
                                                       </td>
                                                       <td colspan="2">
                                                             <input placeholder="IDV"  class=" form-control col-md-7 col-xs-12 " 
                                                                   type="text" name="vehicle[buy][idv][]">
                                                       </td>
                                                       <td colspan="2">
                                                             <input placeholder="NCB%"  class=" form-control col-md-7 col-xs-12 " 
                                                                   type="text" name="vehicle[buy][ncb_percentage][]">
                                                       </td>
                                                       
                                                  </tr>
                                                   <tr>
                                                      
                                                       <td colspan="2">
                                                        Third party    
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Valid Up to " id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][val_insurance_ll_date][]">
                                                       </td>
                                                       <td colspan="2">
                                                            
                                                              <select required class="select2_group form-control" name="vehicle[buy][insurance_type][]" >
                                                                 <option value="0">Insurance Type</option>
                                                                 <option value="1">RTI</option>
                                                                 <option value="2">RTI</option>
                                                                 <option value="3">B2B</option>
                                                                 <option value="3">FIRST CLASS</option>
                                                                  <option value="3">SECOUND CLASS</option>
                                                            </select>
                                                       </td>
                                                       <td colspan="2">
                                                              <select required class="select2_group form-control" name="vehicle[buy][ncb_req][]" >
                                                                 <option value="0">NCB Required </option>
                                                                 <option value="1">Yes</option>
                                                                 <option value="0">No</option>
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
                                                                   type="text" name="vehicle[buy][finance_company][]"> </td>
                                                         <td colspan="3"><p class="labl">Bank</p> <select class="cmbSearchList select2_group form-control cmbValHypoBank" name="vehicle[buy][bank]" id="val_hypo_bank">
                                                                 <option value="0">Select bank</option>
                                                                 <?php foreach ($banks as $key => $value) {?>
                                                                        <option value="<?php echo $value['bnk_id'];?>"><?php echo $value['bnk_name'];?></option>
                                                                   <?php }?>
                                                            </select></td>
                                                          <td colspan="2"><p class="labl">Branch</p><input placeholder="Branch"  class=" form-control col-md-7 col-xs-12 " 
                                                                   type="text" name="vehicle[buy][bank_branch][]"></td>
                                                       <td colspan="2"> <p class="labl">Hypothecation will close by customer</p><input class="chkHypoByCust" type="checkbox" name=vehicle[buy][val_hypo_close_by_cust]" value="1" ></td>
                                                  </tr>
                                                  <tr>
                                                        <td colspan="2"> <p class="labl">Loan Starting Date </p><input placeholder="Loan Starting Date "  class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][loan_starting_date][]"></td>
                                                  
                                                   
                                                        <td colspan="2"> <p class="labl">Loan Ending Date </p><input placeholder="Loan Ending Date"  class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][loan_ending_date][]"></td>
                                                
                                                   
                                                        <td colspan="1"> <p class="labl">Loan amount </p><input placeholder="Loan amount"  class=" form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][loan_amount][]"></td>
                                                        <td colspan="1"> <p class="labl">Forclousure value </p><input placeholder="Forclousure value"  class=" form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][forclousure_value][]"></td>
                                                
                                                  
                                                        <td colspan="2"> <p class="labl">Forclousure date </p><input placeholder="Forclousure date"  class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][forclousure_date][]"></td>
                                                        
                                                </tr>
                                                <tr>
                                                     <td colspan="2"> <p class="labl">Daily Interest </p><input placeholder="Daily Interest "  class=" form-control col-md-7 col-xs-12 numOnly" 
                                                                   type="text" name="vehicle[buy][daily_interest][]"></td>
                                                     <td colspan="2"> <p class="labl">Any Top up Loan  </p><input class="chkHypoByCust" type="checkbox" name=vehicle[buy][any_top_up_loan][]" value="1" ></td>
                                                </tr>
                                                  <!-- @hypothi --> 
                                          