<style>
     .multiselect{
          width: 590px !important; 
     }
     body {
    color: #287f5b!important;
     }
</style>
<div class='flds'>
     <?php
       $kms = get_km_ranges();
       $price_ranges = get_price_ranges();
       $vehicleColors = getVehicleColors();
   
     ?>
     
     <div class="row">
          <h5 align="center">  <label class="control-label  lbl">Brand:</label><?php echo $vehicle['brd_title'];?>&nbsp;
            <label class="control-label  lbl">Model:</label> <?php echo $vehicle['mod_title'];?>&nbsp;
            <label class="control-label  lbl">Variant:</label>  <?php echo $vehicle['var_variant_name'];?>&nbsp;
           <label class="control-label  lbl">Fuel:</label>   <?php echo unserialize(FUAL)[$vehicle['val_fuel']];?>&nbsp;
            <label class="control-label  lbl">Modfel Year:</label>    <?php echo $vehicle['val_model_year'];?>&nbsp;
             <label class="control-label  lbl">Our Offer:</label>  <?php echo $vehicle['val_price_market_est']?>&nbsp;
                        </h5>
          <div class="form-group"> 
               <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label  lbl">Customer offer</label>
                  <input placeholder="Customer offer" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[pitched][veh_customer_offer]">
               </div>

               <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label lbl">Executive Remark</label>
                    <input placeholder="Executive Remark" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_remarks]">
               </div>

          </div>
     </div>
     <div class="row">
          <div class="form-group">

               <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label lbl" for="first-name">TL remarks</label>
                   <input placeholder="TL remarks " class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_tl_remarks]">
               </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <label class="control-label  lbl">SM Remarks</label>
                   <input placeholder="SM Remarks " class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_sm_remarks]">
               </div>
               <div class="col-md-3 col-sm-3 col-xs-3">
                    <label class="control-label  lbl">Gm Reamrk</label>
                  <input placeholder="Gm Reamrk " class="form-control col-md-7 col-xs-12" type="text" name="vehicle[pitched][veh_gm_remarks]">
               </div>
          </div>
     </div>
     <input type="hidden" name="veh_enq_id" value="<?php echo @$veh_enq_id;?>">
     <input type="hidden" name="old_veh_id" value="<?php echo @$veh_id;?>">
     <input type="hidden" name="old_veh_brand" value="<?php echo @$veh_brand;?>">
     <input type="hidden" name="old_veh_model" value="<?php echo @$veh_model;?>">
     <input type="hidden" name="old_veh_varient" value="<?php echo @$veh_varient;?>">
</div>
     

 

<script>
     $('.cmbMultiSelect').multiselect({
          maxHeight: 450,
          enableFiltering: true,
          includeFilterClearBtn: false,
          enableCaseInsensitiveFiltering: true,

     });

</script>
