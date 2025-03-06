  <?php
    //print_r($staffEnqSts);
    ?>
<tr class="hdr singleline">
                                                  <td class="bg-"> </td>
                                                  <td class="bg-"></td>
                                                
                                                 
                                                      <td class="bg-last_mnth"><b>HOT +</b></td>
                                                     <td class="bg-last_mnth"><b>Hot</b></td>
                                                   <td class="bg-last_mnth"><b>Warm</b></td>
                                                   <td class="bg-last_mnth"><b>Cold</b></td>
                                                   <td class="bg-last_mnth"><b>Total</b></td>
                                                   <td class="bg-wk"><b>HOT +</b></td>
                                                   <td class="bg-wk"><b>Hot</b></td>
                                                     <td class="bg-wk"><b>Warm</b></td>
                                                   <td class="bg-wk"><b>Cold</b></td>
                                                   <td class="bg-wk"><b>Total</b></td>
                                                  <td class="bg-net"><b>HOT +</b></td>
                                                     <td class="bg-net"><b>Hot</b></td>
                                                   <td class="bg-net"><b>Warm</b></td>
                                                   <td class="bg-net"><b>Cold</b></td>
                                                   <td class="bg-net"><b>Total</b></td>
                                                     
                                                  
                                                  
                                             </tr>
<?php if(!empty($hotLists)){ 
      foreach ($hotLists as $key => $value) {
           
           print_r($value);
     ?>

<tr class="hdr singleline">
                                                  <td class="lbl-blk"> <?php echo $key+1; ?></td>
                                                 
                                                  <td class="lbl-blk"><b><?php echo $value['staffInfo']['satff_name']?></b> </td>
                                                 
                                                   <td class="bg-last_mnth"><?php echo $value['hotList']['last_month_hot_Plus'];?></td>
                                                     <td class="bg-last_mnth"><?php echo $value['hotList']['last_month_hot'];?></td>
                                                   <td class="bg-last_mnth"><?php echo $value['hotList']['last_month_warm'];?></td>
                                                   <td class="bg-last_mnth"><?php echo $value['hotList']['last_month_cold'];?></td>
                                                   <td class="bg-last_mnth"><?php echo $value['hotList']['last_month_hot_Plus']+$value['hotList']['last_month_hot']+$value['hotList']['last_month_warm']+$value['hotList']['last_month_cold'];?></td>
                                                   
                                                   <td class="bg-wk"><?php echo $value['hotList']['this_week_hot_plus'];?></td>
                                                   <td class="bg-wk"><?php echo $value['hotList']['this_week_hot'];?></td>
                                                     <td class="bg-wk"><?php echo $value['hotList']['this_week_warm'];?></td>
                                                   <td class="bg-wk"><?php echo $value['hotList']['this_week_cold'];?></td>
                                                   <td class="bg-wk"><?php echo $value['hotList']['this_week_hot_plus']+$value['hotList']['this_week_hot']+$value['hotList']['this_week_warm']+$value['hotList']['this_week_cold'];?></td>
                                                    <td class="bg-net"><?php echo $net_hot_plus=$value['hotList']['last_month_hot_Plus']+$value['hotList']['this_week_hot_plus'];?></td>
                                                    <td class="bg-net"><?php echo $net_hot=$value['hotList']['last_month_hot']+$value['hotList']['this_week_hot'];?></td>
                                                     <td class="bg-net"><?php echo $net_warm=$value['hotList']['last_month_warm']+$value['hotList']['this_week_warm'];?></td>
                                                   <td class="bg-net"><?php echo $net_cold=$value['hotList']['last_month_cold']+$value['hotList']['this_week_cold'];?></td>
                                                   <td class="bg-net"><?php echo $net_hot_plus+$net_hot+$net_warm+$net_cold ?></td>
                                                   
                                                  
                                                  
                                             </tr>
                                             
<?php  } 

      } ?>