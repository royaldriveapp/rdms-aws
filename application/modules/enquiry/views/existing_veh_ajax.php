
<style>
     .existing_add_new{
          background-color:#c39d337a;
     }
         hr.dot-line {
  border-top: 1px dotted red;
}
</style>
<?php $vehicleColors = getVehicleColors(); ?>
<div class="exisParent lblBuyk exist-<?php echo $count?>">
     <hr class="dot-line">
                                  <span style="float: left;cursor: pointer;font-size: 18px;margin: 5px 10px;" class="glyphicon glyphicon-remove btnRemoveExVeh"></span> <h2 class="StepTitle lblSale" style="width: 100%;">Existing vehicle <!-- <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnAddVehDetailsExisting"></span>--></h2>
                                   <div class="table-responsive">
                                        <table id="datatable-responsive" class="existing_add_new vehDetailsBuy table table-stripedj table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                             <thead>
                                                
                                                  <tr>
                                                       <th>Make</th>
                                                       <th>Model</th>
                                                       <th>Variant</th>
                                                       <th>Fuel</th>
                                                       <th>Manf Year</th>
                                                       <th>Color</th>
                                                          <th>KM</th>
                                                       <th>Exchange intrested</th>
                                                    
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <tr>
                                                       <td>
                                                            <select required style="width: 170px;" class="select2_group form-control cmbBindModelExisting" data-url="<?php echo site_url('enquiry/bindModel');?>" name="vehicle[existing][veh_brand][]">
                                                                 <option value="0">Select Brand</option>
                                                                 <?php foreach ($brands as $key => $value) {?>
                                                                        <option value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td></td>
                                                       <td></td>
                                                       <td>
                                                            <select required style="width: 170px;" class="select2_group form-control" name="vehicle[existing][veh_fuel][]">
                                                                 <?php foreach (unserialize(FUAL) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                            </select>
                                                       </td>
                                                       <td>
                                                            <select required data-placeholder="Select Year" name="vehicle[existing][veh_manf_year][]" style="width: 170px;" class="select2_group form-control cmbMultiSelectmm" >
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
                                                            <select data-placeholder="Select Color" name="vehicle[existing][veh_color][]" style="width: 170px;" class="select2_group form-control  cmbMultiSelectjks" >
                                                                 <option value="0">-Select Color-</option>
                                                                 <?php foreach ($vehicleColors as $vehicleColor) {?>
                                                                        <option value="<?php echo $vehicleColor['vc_id'];?>"><?php echo $vehicleColor['vc_color']?></option>
                                                                   <?php }?>
                                                            </select>  
                                                       </td>
                                                       <td>
                                                             <input style="width: 100px;" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][veh_km_from][]">
                                                          
                                                       </td>
                                                       <td>
                                                            <select data-placeholder="Select Color" name="vehicle[existing][exchange_intrested][]" style="width: 170px;" class=" form-control  " >
                                                                 <option value="0">-Select-</option>
                                                              
                                                                        <option value="1">Yes</option>
                                                                         <option value="0">No</option>
                                                                 
                                                            </select>  
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="4">
                                                              <input placeholder="Market value" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][market_value][]">
                                                            
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Our Offer" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][our_offer][]">
                                                       </td>
                                                       <td colspan="2">
                                                         <input  placeholder="Customer expectation" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="vehicle[existing][veh_exch_cus_expect][]"> 
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="4">

                                                            <input required placeholder="KL" id="enq_cus_loan_emi" style="width: 50px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[existing][veh_reg1][]" autocomplete="off">
                                                            <input required placeholder="00" id="enq_cus_loan_emi" style="width: 60px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[existing][veh_reg2][]" autocomplete="off">
                                                            <input required placeholder="AA" id="enq_cus_loan_emi" style="width: 60px;text-transform:uppercase;" class="form-control col-md-3 col-xs-3" type="text" name="vehicle[existing][veh_reg3][]" autocomplete="off">
                                                            <input required placeholder="0000" id="enq_cus_loan_emi" style="width: 99px;" class="form-control col-md-3 col-xs-3 numOnly" type="text" name="vehicle[existing][veh_reg4][]" autocomplete="off">
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Ownership" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="number" name="vehicle[existing][veh_owner][]">
                                                       </td>
                                                       <td colspan="2">
                                                            <input placeholder="Insurance Validity " id="enq_cus_loan_emi" class="dtpDMY form-control col-md-7 col-xs-12" type="text" name="vehicle[existing][insurance_validity][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                       <td colspan="8">
                                                            <input placeholder="Tyre condition" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[existing][tyre_condition][]">
                                                       </td>
                                                  </tr>
                                                  <tr>
                                                      <td colspan="8">
                                                            <input placeholder="Remarks" id="enq_cus_loan_emi" class="form-control col-md-7 col-xs-12" type="text" name="vehicle[existing][veh_remarks][]">
                                                       </td>
                                                  </tr>
                                                
                                             </tbody>
                                        </table>
                                   </div>
                                   </div>
                                   <script>
                                         $(document).on('click', '.btnRemoveExVeh', function () {
                                           
                              // $(this).parent('.exisParent').remove();
                              
$(this).parent('.exisParent').hide('slow',function(){ 
    $(this).slideUp(150, function() {
        $(this).remove(); 
    }); 
});
                                         }); 
                                          $('.dtpDMY').datetimepicker({format: "DD-MM-YYYY"});
                                        </script>
                                