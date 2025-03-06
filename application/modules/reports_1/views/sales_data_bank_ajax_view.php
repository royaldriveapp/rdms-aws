<?php
  if (!empty($sdb)) {
       foreach ($sdb as $key => $value) {
            $enqs = $this->reports->enqData($value['enq_id']);
             $hmvst = $this->reports->didHomeVisit($value['enq_id']);
                      ?>
            <tr class="hdr singleline txtBlk">
                 <td><?php echo $key+1; ?><?php //print_r($enqs); ?></td>
                 <td><?php echo $value['enq_cus_name']?> </td>
                 <td><?php echo $value['satff_name']?></td>
                 <td><?php echo $value['enq_cus_mobile']?> </td>
                 <td><?php // foreach ($enqs as $key => $enq) {
               //  echo $enq['veh_reg'].'<hr style="height:2px;border-width:0;color:gray;background-color:gray"><br>';
            //}  ?>
                      <table class="table table-striped table-bordered table-responsive">
                           <tr><th>Reg No</th><th>Make & Model	</th><th>Executive Remark</th><th>ASM Remark</th><th>SM Remark</th><th>Expect Booking Date</th></tr>
                           <?php  foreach ($enqs as $key => $enq) {?>
                             <tr><td><?php  echo $enq['veh_reg']; ?></td><td><?php  echo $enq['brd_title'].'|'.$enq['mod_title']; ?></td>
                                  <td><?php echo $enq['veh_remarks']?></td>
                                   <td><?php echo $enq['veh_tl_remarks']?></td>
                                   <td><?php echo $enq['veh_sm_remarks']?></td>
                                    <td>...</td>
                                     
                             </tr>
               
           <?php }  ?>
           
            
           
            </table>
                 
                 </td>
                 <td><?php echo $hmvst?'Yes':'No'; ?></td>
            </tr>
            <?php
       }
  }
?>
            