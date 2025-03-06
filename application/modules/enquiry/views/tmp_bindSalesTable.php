
<?php
  $kms = get_km_ranges();
  $price_ranges = get_price_ranges();
  $vehicleColors = getVehicleColors();
?><tr>
     <td>
          <select style="width: 170px;" class="select2_group form-control cmbBindModel" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[sale][veh_brand][]">
               <option value="0">Select Brand</option>
               <?php foreach ($brands as $key => $value) {?>
                      <option <?php echo $vehicle['val_brand'] == $value['brd_id'] ? 'selected="selected"' : '';?>
                           value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                      <?php }?>
          </select>
     </td>
     <td>
          <?php $model = $this->myEnquiry->bindModel($vehicle['val_brand'], 'array');?>
          <select style="width: 170px;" class="select2_group form-control cmbBindVariantBuy" name="vehicle[sale][veh_model][]" data-url="<?php echo site_url('enquiry/bindVarient');?>">
               <?php foreach ((array) $model as $key => $value) {?>
                      <option <?php echo (isset($vehicle['val_model']) && ($value['mod_id'] == $vehicle['val_model'])) ? 'selected="selected"' : '';?> value="<?php echo $value['mod_id']?>"><?php echo $value['mod_title']?></option>
                 <?php }?>
          </select>
     </td>
     <td>
          <?php $variant = $this->myEnquiry->bindVarient($vehicle['val_model'], 'array');?>
          <select style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_varient][]">
               <?php foreach ((array) $variant as $key => $value) {?>
                      <option <?php echo (isset($vehicle['val_variant']) && ($value['var_id'] == $vehicle['val_variant'])) ? 'selected="selected"' : '';?> value="<?php echo $value['var_id']?>"><?php echo $value['var_variant_name']?></option>
                 <?php }?>
          </select>
     </td>
     <td>
          <select style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
               <?php foreach (unserialize(FUAL) as $key => $value) {?>
                      <option <?php echo ($key == $vehicle['val_fuel']) ? 'selected="selected"' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option>
                 <?php }?>
          </select>
     </td>
     <td>
<!--          <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_year][]">-->
          <select id="enq_cus_loan_emi" data-placeholder="Select Year" name="vehicle[sale][veh_year][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
               <option value="0">-Select Year-</option>
               <?php
                 $earliest_year = YEAR_RANGE_START;
                 $latest_year = date('Y');
                 foreach (range($latest_year, $earliest_year) as $i) {
                      ?>
                      <option <?php echo $vehicle['val_model_year'] == $i ? 'selected' : ''?> value="<?php echo $i;?>"><?php echo $i;?></option>
                 <?php }?>  

          </select>
     </td>
     <td>
<!--          <input value="<?php echo $vehicle['val_color'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_color][]">-->
          <select data-placeholder="Select Color" name="vehicle[sale][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
               <option value="0">-Select Color-</option>
               <?php foreach ($vehicleColors as $vehicleColor) {?>
                      <option <?php echo $vehicle['val_color'] == $vehicleColor['vc_id'] ? 'selected' : ''?> value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                 <?php }?>
          </select> 

     </td>
     <td>
          <?php //  print_r($vehicle);?>
<!--          <input value="<?php echo $vehicle['val_price_rd_from'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_from][]">-->
    
      <select data-placeholder="Select Price" name="vehicle[sale][veh_price_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                                      <option value="0">-Select Price-</option>
                                                                                      <?php foreach ($price_ranges as $price_range) {?>
                                                                                           <option <?php echo $vehicle['val_price_rd_from'] == $price_range['pr_id'] ? 'selected' : ''?> value="<?php echo $price_range['pr_id'];?>"><?php echo $price_range['pr_range']?></option>

                                                                                      <?php }?>
                                                                                 </select>   
     </td>
<!--     <td>
          <input value="<?php echo $vehicle['val_price_rd_to'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_to][]">
     </td>-->
     <td>
<!--          <input value="<?php echo $vehicle['val_km'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_from][]">-->
          <select data-placeholder="Select KM" name="vehicle[sale][veh_km_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
               <option value="0">-Select KM-</option>
               <?php foreach ($kms as $km) {?>
                      <option <?php echo $vehicle['val_km'] >= $km['kmr_range_from']&&$vehicle['val_km'] <= $km['kmr_range_to'] ? 'selected' : ''?> value="<?php echo $km['kmr_id'];?>"><?php echo $km['kmr_range_from']?> KM - <?php echo $km['kmr_range_to']?> KM</option>

                 <?php }?>
          </select>
     </td>
<!--     <td>
          <input value="<?php echo $vehicle['val_km'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_to][]">
     </td>-->
</tr>
<tr>
     <td colspan="2">
          <?php// print_r($vehicle); ?>
<!--          <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">-->
          <input required="true" value="<?php echo $vehicle['val_prt_1'] ?>" placeholder="KL" id="enq_cus_loan_emi" style="width: 50px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[sale][veh_reg1][]" autocomplete="off">
          <input required="true" value="<?php echo $vehicle['val_prt_2'] ?>" placeholder="00" id="enq_cus_loan_emi" style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[sale][veh_reg2][]" autocomplete="off">
          <input required="true" value="<?php echo $vehicle['val_prt_3'] ?>" placeholder="AA" id="enq_cus_loan_emi" style="width: 60px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[sale][veh_reg3][]" autocomplete="off">
          <input required="true" value="<?php echo $vehicle['val_prt_4'] ?>" placeholder="0000" id="enq_cus_loan_emi" style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[sale][veh_reg4][]" autocomplete="off">
     </td>
     <td colspan="1">
          <input value="<?php echo $vehicle['val_no_of_owner'];?>" placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[sale][veh_owner][]">
     </td>

     <td colspan="5">
          <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks][]">
     </td>
</tr>
<tr>
     <td colspan="11">
          <label>Evaluated By : <?php echo $vehicle['usr_first_name'] . ' ' . $vehicle['usr_last_name'];?></label>
     </td>
</tr>