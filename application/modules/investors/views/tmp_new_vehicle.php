<div class="form-group">
     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Current vehicle</label>
     <div class="col-md-3 col-sm-7 col-xs-12">
          <select data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbEvModel<?php echo $rand; ?>" 
                  data-dflt-select="Select Model" class="cmbBrand select2_group form-control bindToDropdown" name="veh[invv_brand][]" id="invv_brand">
               <option value="">Select Brand</option>
               <?php
               if (!empty($brand)) {
                    foreach ($brand as $key => $value) {
                         ?>
                         <option value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?></option>
                         <?php
                    }
               }
               ?>
          </select>
     </div>
     <div class="col-md-3 col-sm-6 col-xs-12">
          <select data-url="<?php echo site_url('enquiry/bindVarient'); ?>" data-bind="cmbEvVariant<?php echo $rand; ?>" data-dflt-select="Select Variant"
                  class="cmbEvModel<?php echo $rand; ?> select2_group form-control bindToDropdown" name="veh[invv_model][]" id="invv_model">
          </select>
     </div>
     <div class="col-md-3 col-sm-6 col-xs-12">
          <select class="select2_group form-control cmbEvVariant<?php echo $rand; ?>" name="veh[invv_varient][]" id="invv_varient"></select>
     </div>
     <a onclick="$(this).parent('div').remove();" href="javascriot:void(0)" style="margin-top: -25px;float: right;margin-right: -8px;"><i class="fa fa-minus"></i></a>
</div>