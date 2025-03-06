<div class="row cls_<?php echo $count; ?>">
                  <div class="col-md-3 mrgn">
                          <i class=" prefix grey-text"></i>
                
          <select data-count="<?php echo $count; ?>" data-placeholder="Preference"  class="select2_group form-control cmbMultiSelect prfSel2 cls_<?php echo $count; ?>" >
               <option selected>-Select-</option>
                <?php $preferences= unserialize(PREFERENCE_KEYS); 
 foreach ($preferences as $key => $value) {?>
   <option value="<?php echo $key; ?>"><?php echo $value; ?></option>   
 <?php }
               ?>

          </select>
                  </div>
                  <div class="prf_fld_ajx_<?php echo $count; ?>">
                       
                  </div>
               
                  
                  
             </div>
<script>
       $('.prfSel2').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
var count=$(this).data("count");
 $.ajax({
               type: 'get',
              "url": site_url + "followup/append_pref_flds",
//               dataType: 'json',
             data:{prefernce:valueSelected,count:count},
               success: function (resp) {
                       $(".prf_fld_ajx_"+count).html(resp);

               }
          });
    
});
     </script>
     