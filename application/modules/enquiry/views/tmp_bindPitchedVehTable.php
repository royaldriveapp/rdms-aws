
<?php
  $kms = get_km_ranges();
  $price_ranges = get_price_ranges();
  $vehicleColors = getVehicleColors();
?><tr>

     <td>
       <input type="hidden" value="<?php echo $vehicle['val_id'];?>" name="vehicle[pitched][veh_val_id][]" >
       <span class="lbl-wt"><?php echo $vehicle['brd_title'];?></span></span>
     </td>
     <td>
            <span class="lbl-wt"><?php echo $vehicle['mod_title'];?></span>
     </td>
     <td>
            <span class="lbl-wt"><?php echo $vehicle['var_variant_name'];?></span>
     </td>
     <td>
           <span class="lbl-wt"> <?php echo unserialize(FUAL)[$vehicle['val_fuel']];?></span>
     </td>
     <td>
            <span class="lbl-wt"><?php echo $vehicle['val_model_year'];?></span>
     </td>
     <td>     
            <span class="lbl-wt"><?php echo $vehicle['val_price_market_est']?></span>
          <!--veh_exch_estimate-->
     </td>
     <td>
          <!--veh_exch_cus_expect-->

          <input placeholder="Customer Offer" style="width: 100%;"  class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[pitched][veh_customer_offer][]">

     </td>
</tr>
<tr>
     <td colspan="2">
          <span class="lbl-wt">   <?php echo $vehicle['val_prt_1'] . '-' . $vehicle['val_prt_2'] . '-' . $vehicle['val_prt_3'] . '-' . $vehicle['val_prt_4']?></span>
     </td>
     <td colspan="3">
          <input placeholder="Executive Remarks "  class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_remarks][]">
     </td>
     <td colspan="3">
          <input placeholder="TL remarks "  class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_tl_remarks][]">
     </td>

</tr>
<tr>

     <td colspan="4">
          <input placeholder="SM Remarks "  class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_sm_remarks][]">
     </td>
     <td colspan="6">
          <input placeholder="Gm Reamrk "  class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_gm_remarks][]">
     </td>
</tr>
<tr>
     <td colspan="11">
            <span class="lbl-wt"><label>Evaluated By : <?php echo $vehicle['usr_first_name'] . ' ' . $vehicle['usr_last_name'];?></label></span>
     </td>
</tr>
