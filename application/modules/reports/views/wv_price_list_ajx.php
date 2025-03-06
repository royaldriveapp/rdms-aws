<?php
  if (!empty($details)) {
       foreach ($details as $key => $value) {
            ?>
            <tr class="hdr singleline txtBlk" title="<?php echo $value['val_id'] . '-' . $value['prd_valuation_id']; ?>">
                 <td><?php echo $key + 1;?><?php //print_r($enqs); ?></td>
                 <td><?php echo $value['brd_title']?> </td> 
                 <td><?php echo $value['mod_title']?> | <?php echo $value['var_variant_name']?></td>
                 <td><?php echo $value['val_type']==1 ? 'O':$value['val_type']==5?'O':'P'?> xcx <?php echo $value['val_type']?> </td>
                 <td><?php echo $value['val_color']?>  </td>
                 <td><?php echo $value['val_fuel']?>  </td>             
                 <td><?php echo $value['val_minif_year']?>  </td>  
                 <td><?php echo $value['val_manf_date']?>  </td>  
                 <td><?php echo $value['val_veh_no']?>  </td> 
                 <td><?php echo $value['val_km']?>  </td>
                 <td><?php echo $value['val_no_of_owner']?>  </td>             
                 <td><?php echo $value['val_insurance_validity']?>  </td>  
                 <td><?php echo $value['val_insurance_idv']?>  </td>  
                 <td><?php echo $value['prd_price']?>  </td> 
                 <td>avg </td>             
                 <td>hp  </td>  
                 <td>option  </td>  
                 <td><?php echo $value['vbk_added_on']?>  </td> 
                 <td><?php echo $value['booked_staff']?>  </td>  
                 <td>sts  </td> 
                 <?php
            }
       }
     ?>
            