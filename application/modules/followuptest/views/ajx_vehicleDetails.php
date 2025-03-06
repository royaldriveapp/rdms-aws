<table class="table table-striped">
     <thead>
          <tr>
               <th colspan="6" style="text-align: center;">Vehicle Evaluation Sheet</th>
          </tr>
          <tr>
               <th>Division</th>
               <th><?php echo $vehicles['div_name'];?></th>
               <th>Branch</th>
               <th><?php echo $vehicles['shr_location'];?></th>
               <th>Date</th>
               <th><?php echo date('d-m-Y', strtotime($vehicles['val_added_date']));?></th>
          </tr>
          <tr>
               <th>Reg: NO</th>
               <th><?php echo strtoupper($vehicles['val_veh_no']);?></th>
               <th>Vehicle</th>
               <th colspan="3"><?php echo $vehicles['brd_title'] . ', ' . $vehicles['mod_title'] . ', ' . $vehicles['var_variant_name'];?></th>
          </tr>
     </thead>
</table>
<table class="table table-striped">
     <thead>
          <tr>
               <th colspan="3" style="text-align: center;">Insurance</th>
               <th colspan="1" style="text-align: center;">Insurance Company</th>
               <th colspan="3" style="text-align: center;"><?php echo $vehicles['val_insurance_company'];?></th>
          </tr>
     </thead>
     <tbody>
          <tr>
               <td>Comprehensive</td>
               <td>Valid up to</td>
               <td><?php echo!empty($vehicles['val_insurance_comp_date']) ? date('d-m-Y', strtotime($vehicles['val_insurance_comp_date'])) : '';?></td>
               <td>IDV</td>
               <td><?php echo $vehicles['val_insurance_comp_idv'];?></td>
               <td>NCB%</td>
               <td><?php echo $vehicles['val_insurance_ll_idv'];?></td>
          </tr>
          <tr>
               <td>Third Party</td>
               <td>Valid up to</td>
               <td><?php echo!empty($vehicles['val_insurance_ll_date']) ? date('d-m-Y', strtotime($vehicles['val_insurance_ll_date'])) : '';?></td>
               <td>Insurance Type</td>
               <td>
                    <?php
                      $insType = unserialize(INSURANCE_TYPES);
                      echo $insType[$vehicles['val_insurance']];
                    ?>
               </td>
               <td>NCB Required</td>
               <td><?php echo ($vehicles['val_insurance_need_ncb'] == 1) ? 'YES' : 'NO';?></td>
          </tr>
     </tbody>
</table>
