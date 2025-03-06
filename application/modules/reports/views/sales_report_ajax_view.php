
       <tr class="hdr singleline lbl-blk">
                                                  <td>Last month</td><!--Walkin -->
                                                  <td>Y's Day</td>
                                                  <td>Total</td>
                                                  <td>Mean OF <?php echo date("F Y");  ?></td>
                                                  <td>YOY%</td>
                                                  <td>Y's Day</td><!--cug -->
                                                  <td>Total</td>
                                                  <td>Mean OF <?php echo date("F Y");  ?></td>
                                                  <td>YOY%</td>
                                                  <td>Y's Day</td><!--Online -->
                                                  <td>Total</td>
                                                  <td>Mean OF <?php echo date("F Y");  ?></td>
                                                  <td>YOY%</td>
                                                  <td>Y's Day</td><!--Others -->
                                                  <td>Total</td>
                                                  <td>Mean OF <?php echo date("F Y");  ?></td>
                                                  <td>YOY%</td>
                                                  <td>Y's Day</td><!--OLx -->
                                                  <td>Total</td>
                                                  <td>Mean OF <?php echo date("F Y");  ?></td>
                                                  <td>YOY%</td>
                                                  <td>Y's Day</td><!--Total -->
                                                  <td>Total</td>
                                                  <td>Mean OF <?php echo date("F Y");  ?></td>
                                                  <td>YOY%</td>
                                             </tr>
                                             <tr class="hdr singleline lbl-blk">
                                                  <td>
                                                      
                                                      
                                                       <?php echo (unserialize(Showrooms))[$shrm] ?></td><!--walking -->
                                                  <td><?php echo $reports['yester_day_walk_in']; ?></td>
                                                  <td><?php echo $reports['total_walk_in']; ?></td>
                                                  <td><?php 
                                                     echo mean($reports['yester_day_walk_in'],$reports['total_walk_in']); 
                                                  ?>
                                                  </td>
                                                  <td>?</td>

                                                  <td><?php echo $reports['yester_day_cug']; ?></td><!--cug -->
                                                  <td><?php echo $reports['total_cug']; ?></td>
                                                  <td><?php echo mean($reports['yester_day_cug'],$reports['total_cug']); ?></td>
                                                  <td>?</td>

                                                 <td><?php echo $reports['yester_day_online']; ?></td><!--online -->
                                                  <td><?php echo $reports['total_online']; ?></td>
                                                  <td><?php echo mean($reports['yester_day_online'],$reports['total_online']); ?></td>
                                                  <td>?</td>
                                                  
                                                    <td><?php echo $reports['yester_day_other']; ?></td><!--other -->
                                                  <td><?php echo $reports['total_other']; ?></td>
                                                  <td><?php echo mean($reports['yester_day_other'],$reports['total_other']); ?></td>
                                                  <td>?</td>
                                                  
                                                   <td><?php echo $reports['yester_day_olx']; ?></td><!--olx -->
                                                  <td><?php echo $reports['total_olx']; ?></td>
                                                  <td><?php echo mean($reports['yester_day_olx'],$reports['total_olx']); ?></td>
                                                  <td>?</td>
                                                  <?php
                                       
                                                   $yesterdayTotal=$reports['yester_day_walk_in']+$reports['yester_day_cug']+$reports['yester_day_online']+$reports['yester_day_other']+$reports['yester_day_olx'];
                                                   $grandTotal=$reports['total_walk_in']+$reports['total_cug']+$reports['total_online']+$reports['total_other']+$reports['total_olx'];
                                                   $meanTotal= mean($yesterdayTotal,$grandTotal);
                                                           ?>
                                                  
                                                  <td><?php echo $yesterdayTotal ?></td><!--Total -->
                                                  <td><?php echo $grandTotal ?></td>
                                                  <td><?php echo $meanTotal; ?></td>
                                                  <td></td>


                                             </tr>
<?php


 function mean($count,$total) {
       $d=date('d');
      //$result=1312313;
     $result=($count+$total)/$d;
  $result= round($result,3);
       return $result;
       
       
  }
  ?>