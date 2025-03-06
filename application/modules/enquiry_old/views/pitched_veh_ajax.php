<style>
     .tbl-pitch{
  background-color:#474a56;  
/*   border: 4px dotted #d9cb21*/
 border: 4px dotted #fffffff2;
}
  hr.dot-line {
  border-top: 1px dotted red;
}

</style>  
<div class="pitchedParent pitc-<?php echo $count?>">  
      <hr class="dot-line">
     <span style="float: left;cursor: pointer;font-size: 18px;margin: 5px 10px;" class="glyphicon glyphicon-remove btnRemovePitchedVeh"></span><h2 class="StepTitle lblSale" style="width: 100%;">Pitched vehicle </h2>
     <div class="table-responsive ">
          <table id="datatable-responsive" class="tbl-pitch vehDetailsSale table table-stripedj table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
               <thead>
                    <tr>
                         <th colspan="11">
                              <select style="width: 170px;float: left;" class="cmbSearchList select2_group form-control cmbStock" 
                                      name="vehicle[pitched][veh_stock_id][]" data-url="<?php echo site_url('enquiry/bindPitchedVehTable');?>">
                                   <option value="0">Select Vehicle</option>
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
                         </th>
                    </tr>
                    <tr>
                         <th>Brand</th>
                         <th>Model</th>
                         <th>Variant</th>
                         <th>Fuel</th>
                         <th>Year</th>
<!--                                                       <th>Color</th>-->
                         <th>Our Price</th>
                         <th>Customer Offer</th>
                    </tr>
               </thead>
               <tbody>


               </tbody>
          </table>
     </div>
</div>
<script>
     $('.cmbSearchList').SumoSelect({csvDispCount: 3, search: true, searchText: 'Enter here.'});
     $(document).on('click', '.btnDARDates', function (e) {
          var url = $(this).attr('data-url');
          $.ajax({
               type: 'post',
               url: url,
               dataType: 'json',
               success: function (resp) {
                    $('.divDARDetails').html(resp.html);
                    $('#datatable').dataTable();
               }
          });
     });
     $(document).on('click', '.btnRemovePitchedVeh', function () {
//                  $(this).parent('.pitchedParent').remove();
// $(this).parent('.pitchedParent').fadeOut();
 $(this).parent('.pitchedParent').hide('slow',function(){ 
    $(this).slideUp(150, function() {
        $(this).remove(); 
    }); 
});
     });
     $('.dtpDMY').datetimepicker({format: "DD-MM-YYYY"});

</script>