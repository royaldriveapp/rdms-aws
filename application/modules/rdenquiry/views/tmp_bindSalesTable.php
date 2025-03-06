<tr>
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
          <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_year][]">
     </td>
     <td>
          <input value="<?php echo $vehicle['val_color'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_color][]">
     </td>
     <td>
          <input value="<?php echo $vehicle['val_price_rd_from'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_from][]">
     </td>
     <td>
          <input value="<?php echo $vehicle['val_price_rd_to'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_price_to][]">
     </td>
     <td>
          <input value="<?php echo $vehicle['val_km'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_from][]">
     </td>
     <td>
          <input value="<?php echo $vehicle['val_km'];?>" style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[sale][veh_km_to][]">
     </td>
</tr>
<tr>
     <td colspan="6">
          <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">
     </td>
     <td colspan="5">
          <input value="<?php echo $vehicle['val_no_of_owner'];?>" placeholder="Owner" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[sale][veh_owner][]">
     </td>
</tr>
<tr>
     <td colspan="11">
          <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks][]">
     </td>
</tr>
<tr>
     <td colspan="11">
          <label>Evaluated By : <?php echo $vehicle['usr_first_name'] . ' ' . $vehicle['usr_last_name'];?></label>
     </td>
</tr>