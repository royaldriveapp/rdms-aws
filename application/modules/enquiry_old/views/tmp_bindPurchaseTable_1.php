
<tr>
     <td>
          <input type="hidden" name="valId" value="<?php echo $vehicle['val_id'] ?>">
          <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModelBuy" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[buy][veh_brand][]">
               <option disabled value="0">Select Brand. </option>
               <?php foreach ($brands as $key => $value) {?>
                      <option disabled readonly="readonly" <?php echo $vehicle['val_brand'] == $value['brd_id'] ? 'selected="selected"' : '';?> value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                 <?php }?>
          </select>
          <input type="hidden" name="vehicle[buy][veh_brand][]" value="<?php echo $vehicle['val_brand']?>">
     </td>
     <td>
          <?php $model = $this->myEnquiry->bindModel($vehicle['val_brand'], 'array');?>
          <select style="width: 170px;" class="select2_group form-control cmbBindVariantBuy" name="vehicle[buy][veh_model][]" data-url="<?php echo site_url('enquiry/bindVarient');?>">
               <?php foreach ((array) $model as $key => $value) {?>
                      <option disabled <?php echo (isset($vehicle['val_model']) && ($value['mod_id'] == $vehicle['val_model'])) ? 'selected="selected"' : '';?> value="<?php echo $value['mod_id']?>"><?php echo $value['mod_title']?></option>
                 <?php }?>
          </select>
          <input type="hidden" name="vehicle[buy][veh_model][]" value="<?php echo $vehicle['val_model']?>">
     </td>
     <td>
          <?php $variant = $this->myEnquiry->bindVarient($vehicle['val_model'], 'array');?>
          <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_varient][]">
               <?php foreach ((array) $variant as $key => $value) {?>
                      <option disabled <?php echo (isset($vehicle['val_variant']) && ($value['var_id'] == $vehicle['val_variant'])) ? 'selected="selected"' : '';?> value="<?php echo $value['var_id']?>"><?php echo $value['var_variant_name']?></option>
                 <?php }?>
          </select>
          <input type="hidden" name="vehicle[buy][veh_varient][]" value="<?php echo $vehicle['val_variant']?>">
     </td>
     <td>
          <select style="width: 170px;" class="select2_group form-control" name="vehicle[buy][veh_fuel][]" >
               <?php foreach (unserialize(FUAL) as $key => $value) {?>
                      <option disabled <?php echo ($key == $vehicle['val_fuel']) ? 'selected="selected"' : '';?> value="<?php echo $key;?>" ><?php echo $value;?></option>
                 <?php }?>
          </select>
           <input type="hidden" name="vehicle[buy][veh_fuel][]" value="<?php echo $vehicle['val_fuel']?>">
     </td>
     <td>
          <input readonly="readonly" value="<?php echo $vehicle['val_model_year'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_year][]">
     </td>
     <td>
          <input readonly="readonly" value="<?php echo $vehicle['val_color'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_color][]">
     </td>
     <td>
          <input readonly="readonly"  style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_price_from][]">
     </td>
     <td>
          <input readonly="readonly" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_price_to][]">
     </td>
     <td>
          <input readonly="readonly" value="<?php echo $vehicle['val_km'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_from][]">
     </td>
     <td>
          <input readonly="readonly" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_km_to][]">
     </td>
</tr>
<tr>
     <td colspan="4">
         <p class='label-txt'>Customer expectation</p>
          <input readonly="readonly" value="<?php echo $vehicle['val_price_cus_exp'];?>" placeholder="Customer expectation" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_cus_expect][]">
     </td>
     <td colspan="4">
             <p class='label-txt'>Market estimate</p>
          <input readonly="readonly" value="<?php echo $vehicle['val_price_market_est'];?>"  placeholder="Market estimate" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_estimate][]">
     </td>
     <td colspan="3">
            <p class='label-txt'> Dealer valued</p>
          <input readonly="readonly" value="<?php echo $vehicle['val_price_dealer'];?>" placeholder="Dealer valued" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[buy][veh_exch_dealer_value][]">
     </td>
</tr>
<tr>
     <td colspan="4">
           <p class='label-txt'>Registration No. </p>
          <input readonly="readonly" value="<?php echo $vehicle['val_veh_no'];?>" required="true" placeholder="KL-00-AA-0000" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_reg][]">
     </td>
     <td colspan="4">
           <p class='label-txt'>No of owner</p>
          <input readonly="readonly" value="<?php echo $vehicle['val_no_of_owner'];?>" placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[buy][veh_owner][]">
     </td>
     <td colspan="3">
           <p class='label-txt'>Chasis No. </p>
          <input readonly="readonly" value="<?php echo $vehicle['val_chasis_no'];?>" placeholder="Chassis number" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_chassis_number][]">
     </td>
</tr>
<tr>
     <td colspan="11"> <p class='label-txt'> Remarks</p>
          <input readonly="readonly" value="<?php echo $vehicle['val_remarks'];?>"  placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_remarks][]">
     </td>
</tr>
<tr>
     <td colspan="2"> <p class='label-txt'> First delivery date</p>
          <input readonly="readonly" value="<?php echo $vehicle['val_delv_date'];?>"  placeholder="First delivery date" id="veh_delivery_date" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12" 
                 type="text" name="vehicle[buy][veh_delivery_date][]">
     </td>
     <td colspan="2"> <p class='label-txt'> First reg date</p>
          <input readonly="readonly" value="<?php echo $vehicle['val_reg_date'];?>"  placeholder="First reg date" id="veh_first_reg" class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12 numOnly" 
                 type="text" name="vehicle[buy][veh_first_reg][]">
     </td>
     <td colspan="2"> <p class='label-txt'>First manf year </p>
          <input readonly="readonly" value="<?php echo $vehicle['val_minif_year'];?>"  placeholder="First manf year" id="veh_manf_year" class="form-control col-md-7 col-xs-12 numOnly" 
                 type="text" name="vehicle[buy][veh_manf_year][]">
     </td>
     <td colspan="2"> <p class='label-txt'>A/C </p>
          <select class="form-control col-md-4 col-xs-6" name="vehicle[buy][veh_ac][]" id="veh_ac">
               <option disabled value="0">Select A/C</option>
               <option disabled <?php echo (1 == $vehicle['val_ac']) ? 'selected="selected"' : '';?> value="1">W/o</option>
               <option disabled <?php echo (2 == $vehicle['val_ac']) ? 'selected="selected"' : '';?> value="2">Single</option>
               <option disabled <?php echo (3 == $vehicle['val_ac']) ? 'selected="selected"' : '';?> value="3">Dual</option>
               <option disabled  <?php echo (4 == $vehicle['val_ac']) ? 'selected="selected"' : '';?> value="4">Multi</option>
          </select>
          <input type="hidden" name="vehicle[buy][veh_ac][]" value="<?php echo  $vehicle['val_ac']?>">
     </td>
     <td colspan="2"> <p class='label-txt'>Ac zone </p>
          <input readonly="readonly" value="<?php echo $vehicle['val_ac_zone'];?>" placeholder="Ac zone" id="veh_ac_zone" class="form-control col-md-7 col-xs-12 numOnly" 
                 type="text" name="vehicle[buy][veh_ac_zone][]">
     </td>
</tr>
<tr>
     <td colspan="2"> <p class='label-txt'> CC </p>
          <input readonly="readonly" value="<?php echo $vehicle['val_eng_cc'];?>" placeholder="CC" id="veh_cc" class="form-control col-md-7 col-xs-12 numOnly" 
                 type="text" name="vehicle[buy][veh_cc][]">
     </td>
     <td colspan="2"> <p class='label-txt'>Vehicle type </p>
          <select class="select2_group form-control" name="vehicle[buy][veh_vehicle_type][]">
               <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) {?>
                      <option disabled <?php echo ($key == $vehicle['val_type']) ? 'selected="selected"' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option>
                 <?php }?>
          </select>
           <input type="hidden" name="vehicle[buy][veh_vehicle_type][]" value="<?php echo  $vehicle['val_type']?>">
     </td>
     <td colspan="2"> <p class='label-txt'>Engine number </p>
          <input readonly="readonly" value="<?php echo $vehicle['val_engine_no'];?>" placeholder="Engine number" id="veh_engine_num" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[buy][veh_engine_num][]">
     </td>
     <td colspan="2"> <p class='label-txt'> Transmission </p>
          <select required class="select2_group form-control" name="vehicle[buy][veh_transmission][]" id="val_transmission">
               <option disabled value="0">Select Transmission</option>
               <option disabled <?php echo (1 == $vehicle['val_transmission']) ? 'selected="selected"' : '';?> value="1">M/T</option>
               <option disabled <?php echo (2 == $vehicle['val_transmission']) ? 'selected="selected"' : '';?> value="2">A/T</option>
               <option disabled <?php echo (3 == $vehicle['val_transmission']) ? 'selected="selected"' : '';?> value="3">S/T</option>
          </select>
          <input type="hidden" name="vehicle[buy][veh_transmission][]" value="<?php echo  $vehicle['val_transmission']?>">
     </td>
     <td colspan="2"> <p class='label-txt'>No of seat </p>
          <input readonly="readonly" value="<?php echo $vehicle['val_no_of_seats'];?>" placeholder="No of seat" id="veh_seat_no" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="vehicle[buy][veh_seat_no][]">
     </td>
</tr>