<style>
   .multiselect{
          width: 590px !important; 
     }
     </style>
<?php if($enqType=='purchase'){?>
<div class="row">
     <div class="form-group col-md-6 col-sm-6 col-xs-12">
          <input placeholder="Sold through" name="enh_sold_through"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="Organisation" name="enh_organisation"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
</div>
<div class="row">
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="Concern Person" name="enh_concern_person"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="Lost date " name="enh_lost_date"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
</div>
<div class="row">
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="First date of Contact " name="enh_first_date_of_contact"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="Last Date of Contact " name="enh_last_date_of_contact"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
</div>
<div class="row">
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="Our Offer" name="enh_our_offer"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="Sold Rate " name="enh_sold_rate"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
</div>
<div class="row">
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="Executive Remak" name="enh_exicutive_remark"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="TL Remark" name="enh_tl_remark"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
</div>
<div class="row">
     <div class="form-group col-md-12 col-sm-6 col-xs-12">

          <input placeholder="PM Remark" name="enh_pm_remark"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
</div>
<?php }elseif ($enqType=='sale') {?>
      <div class="row">
     <div class="form-group col-md-6 col-sm-6 col-xs-12">
            
                                  
                                        <select name="enh_brand" id="var_brand_id"  class="form-control col-md-7 col-xs-12 bindToDropdown cmbMultiSelect" 
                                                data-bind="cmbModel" data-dflt-select="Select Model"
                                                data-url="<?php echo site_url('enquiry/bindModel'); ?>">
                                             <option value="">Select Brand</option>
                                             <?php
                                             if (!empty($brands)) {
                                                  foreach ($brands as $key => $value) {
                                                       ?>
                                                       <option value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?></option>
                                                       <?php
                                                  }
                                             }
                                             ?>
                                        </select>

     </div>
     <div class="form-group col-md-6 col-sm-6 col-xs-12">
   <select data-placeholder="Select Manf Year" name="enh_manf_year" style="width: 170px;" class="select2_group form-control cmbMultiSelect" >
                                                                 <option value="">Select Manf Year</option>
                                                                 <?php
                                                                   $earliest_year = YEAR_RANGE_START;
                                                                   $latest_year = date('Y');
                                                                   foreach (range($latest_year, $earliest_year) as $i) {
                                                                        ?>
                                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                   <?php }?>  

                                                            </select>

     </div>
</div>
<div class="row">
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

        <select name="enh_model" id="var_brand_id" data-bind="cmbEvVariant" data-dflt-select="Select Varient"
                                                data-url="<?php echo site_url('enquiry/bindVarient'); ?>"  class="form-control col-md-7 col-xs-12 cmbModel bindToDropdown "></select>

     </div>
     <div class="form-group col-md-6 col-sm-6 col-xs-12">
 <select data-placeholder="Select Model Year" name="enh_model_year" style="width: 170px;" class="select2_group form-control cmbMultiSelect" >
                                                                 <option value="">Select Model Year</option>
                                                                 <?php
                                                                   $earliest_year = YEAR_RANGE_START;
                                                                   $latest_year = date('Y');
                                                                   foreach (range($latest_year, $earliest_year) as $i) {
                                                                        ?>
                                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                   <?php }?>  

                                                            </select>

     </div>
</div>
<div class="row">
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <select class="select2_group form-control cmbEvVariant" name="enh_variant" id="vreg_varient"></select>

     </div>
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="Purchased from" name="enh_purchased_from"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
</div>
<div class="row">
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="Purchased Price" name="enh_purchased_price"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="Name" name="enh_name"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
</div>
<div class="row">
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="Executive Remak" name="enh_exicutive_remark"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
     <div class="form-group col-md-6 col-sm-6 col-xs-12">

          <input placeholder="TL Remark" name="enh_tl_remark"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
</div>
<div class="row">
     <div class="form-group col-md-12 col-sm-6 col-xs-12">

          <input placeholder="GM Remark" name="enh_gm_remark"  class="form-control col-md-7 col-xs-12 text-left">

     </div>
</div>
  <?php } ?>
<script>
       $('.cmbMultiSelect').multiselect({
          maxHeight: 450,
          enableFiltering: true,
          includeFilterClearBtn: false,
          enableCaseInsensitiveFiltering: true,
        
     });
     </script>
