<style>
 .req_add_new{
/*           background-color:#141213; */
  background-color:#98cdd9; 
           border: 4px dotted #fffffff2
     }
     hr.dot-line {
  border-top: 1px dotted red;
}
</style>
<?php 
 $kms = get_km_ranges();
  $price_ranges = get_price_ranges();
  $vehicleColors = getVehicleColors();
?>

<div class="reqVeh rq-<?php echo $count?>">
     <hr class="dot-line">
                                   <span style="float: left;cursor: pointer;font-size: 18px;margin: 5px 10px;" class="glyphicon glyphicon-remove btnRemoveRqVeh"></span> <h2 class="StepTitle lblSale" style="width: 100%;">Required vehicle <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsRqVeh"></span></h2>
                                   
                                      <div class="table-responsive">
                                        <table id="datatable-responsive" class="req_add_new vehDetailsSale table table-stripedj table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                             <thead>
                                                 
                                                  <tr>
                                                       <th>Brand</th>
                                                       <th>Model</th>
                                                       <th>Variant</th>
                                                       <th>Fuel</th>
                                                         <th colspan="2">Manufacturing Year</th>
                                                       <th>Prefer Colour</th>
                                                       <th>Budget range </th>
                                                       <th>Km Range</th>
                                                  </tr>
                                             </thead>
                                        <tbody>
                                                  <tr>
                                                       <td>
                                                            <select required="true" style="width: 170px;" class="select2_group form-control cmbBindModel" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[sale][veh_brand][]">
                                                                 <option value="0">Select Brand</option>
                                                                 <?php foreach ($brands as $key => $value) {?>
                                                                        <option value="<?php echo $value['brd_id']?>">
                                                                           <?php echo $value['brd_title']?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select style="width: 170px;" required="" data-url="<?php echo site_url('enquiry/bindVarient');?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                                    class="cmbEvModel select2_group form-control bindToDropdown" name="vehicle[sale][veh_model][]" id="vreg_model">
                                                                         <?php foreach ((array) $model as $key => $value) {?>
                                                                        <option 
                                                                             value="<?php echo $value['mod_id'];?>"><?php echo $value['mod_title'];?></option>
                                                                        <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select style="width: 170px;" required="" class="select2_group form-control cmbEvVariant" name="vehicle[sale][veh_varient][]" id="vreg_varient">
                                                                 <?php foreach ((array) $variant as $key => $value) {?>
                                                                        <option  
                                                                             value="<?php echo $value['var_id'];?>"><?php echo $value['var_variant_name'];?></option>
                                                                        <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select required="" style="width: 170px;" class="select2_group form-control" name="vehicle[sale][veh_fuel][]">
                                                                 <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                      
                                                            <select required="" data-placeholder="Select Year" name="vehicle[sale][veh_manf_year_from][]" style="width: 85px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                 <option value="0">..From</option>
                                                                 <?php
                                                                   $earliest_year = YEAR_RANGE_START;
                                                                   $latest_year = date('Y');
                                                                   foreach (range($latest_year, $earliest_year) as $i) {
                                                                        ?>
                                                                        <option  value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                   <?php }?>  

                                                            </select>
                                                       </td>
                                                       <td> <select required="true" data-placeholder="Select Year" name="vehicle[sale][veh_manf_year_to][]" style="width: 85px;" class="select2_group form-control cmbMultiSelectmm" >
                                                                 <option value="0">To</option>
                                                                 <?php
                                                                   $earliest_year = YEAR_RANGE_START;
                                                                   $latest_year = date('Y');
                                                                   foreach (range($latest_year, $earliest_year) as $i) {
                                                                        ?>
                                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                                   <?php }?>  

                                                            </select></td>
                                                       <td>
                                                            <select data-placeholder="Select Color" name="vehicle[sale][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                 <option value="0">-Select Color-</option>
                                                                 <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                        <option value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                                                   <?php }?>
                                                            </select> 
                                                       </td>
                                                       <td>
                                                            <select data-placeholder="Select KM" name="vehicle[sale][veh_price_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                 <option value="0">-Select Price-</option>
                                                                 <?php foreach ($price_ranges as $price_range) {?>
                                                                        <option value="<?php echo $price_range['pr_id'];?>"><?php echo $price_range['pr_range']?></option>

                                                                   <?php }?>
                                                            </select>                              
                                                       </td>
                                                       <td>
                                                            <select data-placeholder="Select KM" name="vehicle[sale][veh_km_id][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                 <option value="0">-Select KM-</option>
                                                                 <?php foreach ($kms as $km) {?>
                                                                        <option value="<?php echo $km['kmr_id'];?>"><?php echo $km['kmr_range_from']?> KM - <?php echo $km['kmr_range_to']?> KM</option>

                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                  </tr>
                                                  <tr>
<!--                                                       <td>Prefer Number</td>-->
                                                       <td colspan="2">
                                                            <p class="labl">Prefer Number</p>
<!--                                                            <input placeholder="Registration" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_reg][]">-->
                                                            <input placeholder="Prefer Number" id="enq_cus_loan_emi" style="width: 313px;" class="form-control col-md-12 col-xs-12" type="text" name="vehicle[sale][veh_prefer_number][]" autocomplete="off">             
                                                       </td>
                                                       <td colspan="1">
                                                              <p class="labl">Expected Date of Purchase</p>
                                                            <input placeholder="Expected Date of Purchase"  class="dtpDMY form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_exptd_date_purchase][]">
                                                       </td>
                                                  
                                                       <td colspan="5">
                                                              <p class="labl">Remarks</p>
                                                            <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][veh_remarks][]">
                                                       </td>
                                                  </tr>
                                                   <!--proc -->
                                                   <tr style="background-color:#ffb3008f;">
                                                       <td colspan="9">
                                                            <span style="color: #fff;font-weight: bolder;font-size: 18px;">If you want to inform this vehicle to procurement team, please provide following details.</span>
                                                       </td>
                                                  </tr>
                                                  <tr style="background-color:#888787e3;color: #fff;">
                                                       <td colspan="1">
                                                            <p class="labl" style="color: #fff;">Purchase period</p>
                                                            <select name="vehicle[sale][proc_purchase_prd][]" id="var_brand_id"  class="form-control col-md-7 col-xs-12" data-dflt-select="Select Model">
                                                                 <option value="0">Select purchase period</option>
                                                                 <?php foreach (unserialize(PURCHASE_PERIOD) as $key => $value) { ?>
                                                                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </td>
                                                       <td colspan="9">
                                                            <p class="labl" style="color: #fff;">Remarks</p>
                                                            <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[sale][proc_desc][]">
                                                       </td>
                                                  </tr>
                                                  <!--@proc -->
                                             </tbody>
                                        </table>
                                   </div>
                                   </div>
                                   <script>
                                         $(document).on('click', '.btnRemoveRqVeh', function () {
                                           
//                                        $(this).parent('.reqVeh').remove();
 //$(this).parent('.reqVeh').fadeOut();
 $(this).parent('.reqVeh').hide('slow',function(){ 
    $(this).slideUp(150, function() {
        $(this).remove(); 
    }); 
});
                                         }); 
                                          $('.dtpDMY').datetimepicker({format: "DD-MM-YYYY"});
                                        </script>
                                