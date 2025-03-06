  <?php
    //print_r($staffEnqSts);
    ?>
<tr class="hdr singleline">
                                                  <td class="bg-"> </td>
                                                  <td class="bg-"></td>
                                                  <td class="bg-"></td>
                                                 
                                                  <td class="bg-own"><b>Event/field</b></td>
                                                     <td class="bg-own"><b>CUG Own</b></td>
                                                   <td class="bg-own"><b>Fb Own</b></td>
                                                   <td class="bg-own"><b>Referral Own</b></td>
                                                   <td class="bg-own"><b>Total</b></td>
                                                   <td class="bg-rd"><b>Walk-in</b></td>
                                                   <td class="bg-rd"><b>CUG RD IN</b></td>
                                                     <td class="bg-rd"><b>Tele RD</b></td>
                                                   <td class="bg-rd"><b>Whtsp</b></td>
                                                   <td class="bg-rd"><b>Web RD Out</b></td>
                                                   <td class="bg-rd"><b>OLX RD</b></td>
                                                  <td class="bg-rd"><b>C/o Others</b></td>
                                                   <td class="bg-rd"><b>Fb RD</b></td>
                                                    <td class="bg-rd"><b>Insta RD</b></td>
                                                     <td class="bg-rd"><b>Total</b></td>
                                                      <td class="bg-rd"><b>Own Enq : RD Enq</b></td>
                                                     
                                                  
                                                  
                                             </tr>
<?php if(!empty($staffEnqSts)){ 
      foreach ($staffEnqSts as $key => $value) {
           
           print_r($value);
     ?>

<tr class="hdr singleline">
                                                  <td class="lbl-blk"> <?php echo $key+1; ?></td>
                                                  <td class="lbl-blk"><b><?php echo $value['satff_data']['tl_name']?></b></td>
                                                  <td class="lbl-blk"><b><?php echo $value['satff_data']['satff_name']?></b> </td>
                                                 
                                                   <td class="bg-own"><?php echo $value['enqCounts']['EVENTS'];?></td>
                                                     <td class="bg-own"><?php echo $value['enqCounts']['cug_own'];?></td>
                                                   <td class="bg-own"><?php echo $value['enqCounts']['fb_own'];?></td>
                                                   <td class="bg-own"><?php echo $value['enqCounts']['other_referal_own_dbt'];?></td>
                                                   <td class="bg-own"><?php echo $value['enqCounts']['EVENTS']+$value['enqCounts']['cug_own']+$value['enqCounts']['fb_own']+$value['enqCounts']['other_referal_own_dbt'];?></td>
                                                   
                                                   <td class="bg-rd"><?php echo $value['enqCounts']['Walkin'];?></td>
                                                   <td class="bg-rd"><?php echo $value['enqCounts']['cug_rd_in'];?></td>
                                                     <td class="bg-rd"><?php echo $value['enqCounts']['other_telecall_rd_dbt'];?></td>
                                                   <td class="bg-rd"><?php echo $value['enqCounts']['whatsApp'];?></td>
                                                   <td class="bg-rd"><?php echo $value['enqCounts']['other_Web_enq_RD_OUT'];?></td>
                                                    <td class="bg-rd"><?php echo $value['enqCounts']['olx_rd'];?></td>
                                                    <td class="bg-rd"><?php echo $value['enqCounts']['co_others'];?></td>
                                                     <td class="bg-rd"><?php echo $value['enqCounts']['fb_rd'];?></td>
                                                   <td class="bg-rd"><?php echo $value['enqCounts']['insta_rd'];?></td>
                                                   <td class="bg-rd"><?php echo $value['enqCounts']['Walkin']+$value['enqCounts']['cug_rd_in']+$value['enqCounts']['other_telecall_rd_dbt']+$value['enqCounts']['whatsApp']+$value['enqCounts']['other_Web_enq_RD_OUT']+$value['enqCounts']['olx_rd']+$value['enqCounts']['co_others']+$value['enqCounts']['fb_rd']+$value['enqCounts']['insta_rd']
                                                           ;?></td>
                                                    <td class="bg-rd">?</td>
                                                  
                                                  
                                             </tr>
                                             
<?php  } 

      } ?>