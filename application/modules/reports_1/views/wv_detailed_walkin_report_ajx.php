<?php 
  $total=0;
  foreach ($reports as $value) {?>
       <tr class="hdr singleline lbl-blk">


            <td>  <?php echo $value['staffInfo']['satff_name']?> </td>
            <td><?php echo $value['yDayWalkin']['nums'];?></td>
           
            
            <?php
$total=$value['yDayWalkin']['nums']+$total;
            ?>
        

       </tr>
  <?php }
?>
       <tr>
          <td> Total </td>
            <td><?php echo $total;?></td>  
       </tr>