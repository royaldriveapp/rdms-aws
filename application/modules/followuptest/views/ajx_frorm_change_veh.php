<style>
     .multiselect{
          width: 590px !important; 
     }
</style>
<div class='flds'>
     <?php
       $kms = get_km_ranges();
       $price_ranges = get_price_ranges();
       $vehicleColors = getVehicleColors();
       if($veh_type==1){
     ?>
     <h6><?php echo $veh_details; ?> [Required Vehicle] </h6>
     <div class="row">
        <input type="hidden" name="brd_name_new" id="brd_name_new" value="" />
     <input type="hidden" name="model_name_new" id="model_name_new" value="" />
     <input type="hidden" name="variant_name_new" id="variant_name_new" value="" />
          <div class="form-group"> 
               <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label  lbl">Brand</label>
                    <select name="vehicle[sale][veh_brand]" id="var_brand_id" onchange="document.getElementById('brd_name_new').value=this.options[this.selectedIndex].text"  class="form-control col-md-7 col-xs-12 bindToDropdown" 
                            data-bind="cmbModel" data-dflt-select="Select Model"
                            data-url="<?php echo site_url('enquiry/bindModel');?>">
                         <option value="">Select Brand</option>
                         <?php
                           if (!empty($brands)) {
                                foreach ($brands as $key => $value) {
                                     ?>
                                     <option value="<?php echo $value['brd_id'];?>"><?php echo $value['brd_title'];?></option>
                                     <?php
                                }
                           }
                         ?>
                    </select>
               </div>

               <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label lbl">Model</label>
                    <select name="vehicle[sale][veh_model]" id="var_brand_id" onchange="document.getElementById('model_name_new').value=this.options[this.selectedIndex].text" data-bind="cmbEvVariant" data-dflt-select="Select Model"
                            data-url="<?php echo site_url('enquiry/bindVarient');?>"  class="form-control col-md-7 col-xs-12 cmbModel bindToDropdown"></select>
               </div>

          </div>
     </div>
     <div class="row">
          <div class="form-group">

               <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label lbl" for="first-name">Variant</label>
                    <select class="select2_group form-control cmbEvVariant" name="vehicle[sale][veh_varient]" id="vreg_varient" onchange="document.getElementById('variant_name_new').value=this.options[this.selectedIndex].text"></select>
               </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <label class="control-label  lbl">Fuel</label>
                    <select  class="select2_group form-control" name="vehicle[sale][veh_fuel]">
                         <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                <option value="<?php echo $key;?>"><?php echo $value;?></option>
                           <?php }?>
                    </select>
               </div>
               <div class="col-md-3 col-sm-3 col-xs-3">
                    <label class="control-label  lbl">Color</label>
                    <select data-placeholder="Select Color" name="vehicle[sale][veh_color]"  class="select2_group form-control  cmbMultiSelectjks" >
                         <option value="">-Select Color-</option>
                         <?php foreach ($vehicleColors as $vehicleColor) {?>
                                <option  value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                           <?php }?>
                    </select> 
               </div>
          </div>
     </div>
     <div class="row">
          <div class="form-group">
              <div class="col-md-3 col-sm-3 col-xs-3">
                    <label class="control-label  lbl">Manufacturing Year</label>
           <select data-placeholder="Select Year" name="vehicle[sale][veh_manf_year_from]"  class="select2_group form-control cmbMultiSelectmm" >
                                                                             <option value="">From</option>
                                                                             <?php
                                                                             $earliest_year = YEAR_RANGE_START;
                                                                             $latest_year = date('Y');
                                                                             foreach (range($latest_year, $earliest_year) as $i) {
                                                                                  ?>
                                                                                  <option <?php echo @$sales['veh_manf_year_from'] == $i ? 'selected' : ''?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                             <?php }?>  

                                                                        </select>
               </div>
               <div class="col-md-3 col-sm-3 col-xs-3">
                    <label class="control-label  lbl">Manufacturing Year</label>
                    <select data-placeholder="Select Year" name="vehicle[sale][veh_manf_year_to]"  class="select2_group form-control cmbMultiSelectmm" >
                                                                             <option value="">To</option>
                                                                             <?php
                                                                             $earliest_year = YEAR_RANGE_START;
                                                                             $latest_year = date('Y');
                                                                             foreach (range($latest_year, $earliest_year) as $i) {
                                                                                  ?>
                                                                                  <option <?php echo @$sales['veh_manf_year_to'] == $i ? 'selected' : ''?>  value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                             <?php }?>  

                                                                        </select>
               </div>
                 <div class="col-md-3 col-sm-3 col-xs-3">
                    <label class="control-label  lbl">Budget range</label>
           <select data-placeholder="Select price" name="vehicle[sale][veh_price_id]"  class="select2_group form-control  cmbMultiSelectjks" >
                                                                             <option value="">-Select Price-</option>
                                                                             <?php foreach ($price_ranges as $price_range) {?>
                                                                                  <option <?php echo @$sales['veh_price_id'] == $price_range['pr_id'] ? 'selected' : ''?> value="<?php echo $price_range['pr_id'];?>"><?php echo $price_range['pr_range']?></option>

                                                                             <?php }?>
                                                                        </select>
               </div>
               <div class="col-md-3 col-sm-3 col-xs-3">
                    <label class="control-label  lbl">KM Range</label>
                     <select data-placeholder="Select KM" name="vehicle[sale][veh_km_id]" class="select2_group form-control  cmbMultiSelectjks" >
                                                                             <option value="">-Select KM-</option>
                                                                             <?php foreach ($kms as $km) {?>
                                                                                  <option <?php echo @$sales['veh_km_id'] == $km['kmr_id'] ? 'selected' : ''?> value="<?php echo $km['kmr_id'];?>"><?php echo $km['kmr_range_from']?> KM - <?php echo $km['kmr_range_to']?> KM</option>

                                                                             <?php }?>
                                                                        </select>
               </div>
          </div>
     </div>
         <div class="row">
          <div class="form-group">
               <div class="col-md-3 col-sm-3 col-xs-3">
           <label class="control-label  lbl">Prefer Number</label>
                   <input placeholder="Prefer Number" value="<?php echo @$sales['veh_prefer_no']?>" id="enq_cus_loan_emi" class="form-control col-md-12 col-xs-12" type="text" name="vehicle[sale][veh_prefer_number]" autocomplete="off">
               </div>
               <div class="col-md-3 col-sm-3 col-xs-3">
                    <label class="control-label  lbl">Expected Date of Purchase</label>
                    <input placeholder="Expected Date of Purchase" value="<?php echo @$sales['veh_exptd_date_purchase']?>" class="dtpDatePickerDMY form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_exptd_date_purchase]">
               </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label  lbl">Remarks</label>
                  <input placeholder="Remarks" value="<?php echo @$sales['veh_remarks']?>" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks]">
               </div>
          </div>
     </div>
     
</div>
       <?php } elseif($veh_type==3){
         $evaluation = $this->evaluation->getOwnParkAndSaleCars();
         ?>
  <h6><?php echo $veh_reg_no.' '.$veh_details; ?> [Pitched Vehicle]</h6>
<div class="row">
      <input type="hidden" name="pitched_veh_new" id="pitched_veh_new" value="" />
          <div class="form-group " align="center">
                                   <label class="lbl">Select Vehicle</label>
                                     <select style="width: 900px;"  onchange="document.getElementById('pitched_veh_new').value=this.options[this.selectedIndex].text" class="sumoSearchList select2_group form-control vehcles form-control col-md-7 col-xs-12" 
                                                                    name="veh_stock_id" >
                                                                 <option>Select Vehicle</option>
                                                                 <?php
                                                                   foreach ((array) $evaluation as $key => $value) {//val_color
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
                   </div>
</div>
<div class="pitched_fld">
     
</div>
       <?php } ?>
     <input type="hidden" name="veh_enq_id" value="<?php echo @$veh_enq_id;?>">
      <input type="hidden" name="veh_type" value="<?php echo @$veh_type;?>">
     <input type="hidden" name="old_veh_id" value="<?php echo @$veh_id;?>">
     <input type="hidden" name="old_veh_brand" value="<?php echo @$veh_brand;?>">
     <input type="hidden" name="old_veh_model" value="<?php echo @$veh_model;?>">
     <input type="hidden" name="old_veh_varient" value="<?php echo @$veh_varient;?>">
     <input type="hidden" name="old_veh_details" value="<?php echo @$veh_details;?>">
     <input type="hidden" name="old_veh_reg" value="<?php echo @$veh_reg_no;?>">
     

     

<script>
     $('.cmbMultiSelect').multiselect({
          maxHeight: 450,
          enableFiltering: true,
          includeFilterClearBtn: false,
          enableCaseInsensitiveFiltering: true,

     });
        $(document).on('change', '.vehcles', function () {
                      var id = $(this).val();
                     //alert(id);
          var url = site_url+'/followup/bindPitchedVehForm/' + id;
          
          var me = $(this);
          if (id == 0) {
               $(this).parent('th').parent('tr').parent('thead').parent('table').replaceWith(vehDetailsSale);
          } else {
               $.ajax({
                    type: 'post',
                    url: url,
                    dataType: 'json',
                    success: function (resp) {
                       $('.pitched_fld').html(resp.msg);
                    }
               });
          }
     });
</script>
