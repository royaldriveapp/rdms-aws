<style>
     .inp{
          margin-top: 1px;
     }
</style>
<?php if ($preference == 1) { ?>
     <div class="prnt">
          <div class="col-md-4 inp_fld">
               <select   data-placeholder="colors" name="colors[]" class="select2_group form-control cmbMultiSelect prfSel2  rmv_<?php echo $count ?>" >
                    <option selected>-Select-</option>
                    <?php foreach ($colors as $color) { ?>
                         <option value="<?php echo $color['vc_id'] ?>"><?php echo $color['vc_color'] ?></option>
                    <?php } ?>

               </select>
          </div>
          <div class="col-md-4 desc">
               <input type="text" name='colors_description[]' placeholder="Description" id="form34" class="form-control validate inp"> 
          </div>

          <span style="cursor: pointer;" data-id="<?php echo $count ?>" class="glyphicon glyphicon-trash Rmvbtn col-md-1 del"></span>  

     </div>
<?php } elseif ($preference == 2) { ?>
     <div class="prnt">
          <div class="col-md-4 inp_fld">
               <input type="text" name='registration[]' placeholder="Registration" id="form34" class="form-control validate inp"> 
          </div>
          <div class="col-md-4 desc">
               <input type="text" name='Reg_description[]' placeholder="Description" id="form34" class="form-control validate inp"> 
          </div>

          <span style="cursor: pointer;" data-id="<?php echo $count ?>" class="glyphicon glyphicon-trash Rmvbtn col-md-1 del"></span>  
     </div> 
<?php } elseif ($preference == 3) { ?>
     <div class="prnt">   
          <div class="col-md-4 inp_fld">
          <!--         <input type="text" name='other_state[]' placeholder="Other State" id="form34" class="form-control validate inp"> -->
               <select   data-placeholder="other_state" name="other_state[]" class="select2_group form-control cmbMultiSelect prfSel2  rmv_<?php echo $count ?>" >
                    <option selected>-Select-</option>
                    <?php foreach ($states as $state) { ?>
                         <option value="<?php echo $state['sts_id'] ?>"><?php echo $state['sts_name'] ?></option>
                    <?php } ?>
               </select>
          </div>
          <div class="col-md-4 desc">
               <input type="text" name='other_description[]' placeholder="Description" id="form34" class="form-control validate inp"> 
          </div>

          <span style="cursor: pointer;" data-id="<?php echo $count ?>" class="glyphicon glyphicon-trash Rmvbtn col-md-1 del"></span>  
     </div>

<?php } elseif ($preference == 4) { ?>
     <div class="prnt">
          <div class="col-md-4 inp_fld">
       <!--         <input type="text" name='vehicle_type[]' placeholder="Vehicle type" id="form34" class="form-control validate inp"> -->
               <select   data-placeholder="vehicle_type" name="vehicle_type[]" class="select2_group form-control cmbMultiSelect  " >
                    <option selected>-Select-</option>
                    <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) { ?>
                         <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
               </select>
          </div>
          <div class="col-md-4 desc">
               <input type="text" name='vehicle_description[]' placeholder="Description" id="form34" class="form-control validate inp"> 
          </div>

          <span style="cursor: pointer;" data-id="<?php echo $count ?>" class="glyphicon glyphicon-trash Rmvbtn col-md-1 del"></span>
     </div>
<?php }elseif ($preference == 5) { ?>

 <div class="prnt">   
          <div class="col-md-4 inp_fld">
          <!--         <input type="text" name='other_state[]' placeholder="Other State" id="form34" class="form-control validate inp"> -->
               <select   data-placeholder="RTO" name="rto[]" class="select2_group form-control cmbMultiSelect prfSel2  rmv_<?php echo $count ?>" >
                    <option selected>-Select-</option>
                    <?php foreach ($rto as $value) { ?>
                         <option value="<?php echo $value['rto_id'] ?>"><?php echo $value['rto_reg_num'].'-'.$value['rto_place']; ?></option>
                    <?php } ?>
               </select>
          </div>
          <div class="col-md-4 desc">
               <input type="text" name='rto_description[]' placeholder="Description" id="form34" class="form-control validate inp"> 
          </div>

          <span style="cursor: pointer;" data-id="<?php echo $count ?>" class="glyphicon glyphicon-trash Rmvbtn col-md-1 del"></span>  
     </div>
<?php } ?>
