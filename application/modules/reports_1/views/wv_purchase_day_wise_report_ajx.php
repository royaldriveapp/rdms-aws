<?php foreach ($reports as $value) {?>
       <tr class="hdr singleline lbl-blk">


            <td>  <?php echo $value['staffInfo']['satff_name']?> </td>
            <td><?php echo $value['yDayAchvmnt']['darm_todays_achievement'];?></td>
            <td><?php echo $value['this_wk_achivement'];?> </td>
            <td>
                  <ul>
                 <?php
                          foreach ($value['UnslvdBtlneck'] as $key => $bottlelneck) {
                 echo'<li>';
                  echo $bottlelneck['btn_bottle_neck'].'</li>' ;    
             } 
            
              ?>
                        </ul>
                  </td>
            
             
             
                  <td>
                <ul>
                 <?php
                          foreach ($value['UnslvdBtlneck'] as $key => $bottlelneck) {
                 echo'<li>';
                  echo $bottlelneck['btnk_need_hlp_frm_mng']?'Yes':'No'.'</li>' ;    
             } 
            
              ?>
                        </ul>
                  </td>
            <td><?php //echo $value['monthlyTarget']; ?>
            <?php echo $value['monthlyTarget']; ?>
            </td>
              <td><?php echo $value['purchAchvmnt']; ?></td>
                <td><?php echo $value['parkAchvmnt']; ?></td>
              <td><?php echo $value['achvmntPurchWithLoan']; ?></td>
              <td><?php echo $value['totalAchvmnt']; ?></td>
            
            
            <?php
//                                                    $value['booking']=0;
//                                                    $value['delivered']=6;
//                                                    $value['target']=8;
            ?>
        

       </tr>
  <?php }
?>