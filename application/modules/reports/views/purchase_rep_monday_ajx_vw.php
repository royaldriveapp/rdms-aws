<?php foreach ($reports as $value) {?>
       <tr class="hdr singleline lbl-blk">


            <td>  <?php echo $value['staff_id']?>  <?php echo $value['staff']?> </td>
            <td><?php echo $value['this_wk_target'];?></td>
            <td>- </td>
            <td>
                -
              
                  </td>
                  <td>
                         <?php echo $value['this_wk_achivement_purch'];?>
               
                  </td>
                  <td><?php echo $value['this_wk_achivement_park'];?>
                 
                  </td>
                  <td> 
                       
                       <?php echo $value['this_wk_achivement_purch_with_loan'];?>
                         
                  </td>
                  <td> 
                
                  </td>
            <td></td>
              <td>  <ul>
                 <?php
                          foreach ($value['UnslvdBtlneck'] as $key => $bottlelneck) {
                 echo'<li>';
                  echo $bottlelneck['btn_bottle_neck'].'</li>' ;    
             } 
            
              ?>
                        </ul></td>
            <td>   <ul>
                 <?php
                          foreach ($value['UnslvdBtlneck'] as $key => $bottlelneck) {
                 echo'<li>';
                  echo $bottlelneck['btnk_action_plan']?$bottlelneck['btnk_action_plan']:'---'.'</li>' ;    
             } 
            
              ?>
                        </ul></td>
              <td><ul>
                 <?php
                          foreach ($value['UnslvdBtlneck'] as $key => $bottlelneck) {
                 echo'<li>';
                  echo $bottlelneck['resp_person']?$bottlelneck['resp_person']:'---'.'</li>' ;    
             } 
            
              ?>
                        </ul></td>
            <td> <ul>
                 <?php
                          foreach ($value['UnslvdBtlneck'] as $key => $bottlelneck) {
                 echo'<li>';
              // echo date('d-m-Y', strtotime($report['btnk_completion_date']));
                  echo $bottlelneck['btnk_completion_date']?date('d-m-Y', strtotime($report['btnk_completion_date'])):'---'.'</li>' ;    
             } 
            
              ?>
                        </ul></td>
              <td><ul>
                 <?php
                          foreach ($value['UnslvdBtlneck'] as $key => $bottlelneck) {
                 echo'<li>';
                  echo $bottlelneck['btnk_need_hlp_frm_mng']?'Yes':'No'.'</li>' ;    
             } 
            
              ?>
                        </ul>
              <td>
                <?php echo $value['totalTarget_purch']; ?>
                </td>
            <td>- </td>
            <td> -</td>
            <td> <?php echo $value['totalAchivement_purch']; ?> </td>
            <td><?php echo $value['totalAchivement_park']; ?></td>
            <td> <?php echo $value['totalAchivement_purch_with_loan']; ?></td>
          
          
            <?php
//                                                    $value['booking']=0;
//                                                    $value['delivered']=6;
//                                                    $value['target']=8;
            ?>
        

       </tr>
  <?php }
?>