<?php foreach ($targetVsAch as $value) {?>
       <tr class="hdr singleline lbl-blk">


            <td>  <?php echo $value['staff']?> </td>
            <td><?php echo $value['target'];?></td>
            <td><?php echo $value['booking'];?> </td>
            <td><?php echo $value['cancelled'];?></td>
            <td><?php echo $value['delivered'];?></td>
            <?php
//                                                    $value['booking']=0;
//                                                    $value['delivered']=6;
//                                                    $value['target']=8;
            ?>
            <td><?php  
              /*common_helper*/
                 echo findPercentage($value['booking'], $value['delivered'], $value['target']);
                 ?> %</td>
            <td><?php echo findPercentage($value['booking'], 0, $value['target']);?> %</td>
            <td>? </td>
            <td>?</td>
            <td>?</td>

       </tr>
  <?php }
?>