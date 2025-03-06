
       <tr class="hdr singleline lbl-blk">
                                                  <td>Last Day</td><!--Walkin -->
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

                                                 <td><?php 
                                                   $online_and_olx_ysday=$reports['yester_day_online']+$reports['yester_day_olx'];
                                                   $online_and_olx_total=$reports['total_online']+$reports['total_olx'];
                                                   echo $online_and_olx_ysday; ?></td><!--online -->
                                                  <td><?php echo $online_and_olx_total; ?></td>
                                                  <td><?php echo mean($online_and_olx_ysday,$online_and_olx_total); ?></td>
                                                  <td>?</td>
                                                  
                                                    <td><?php echo $reports['brkr_or_refferal'];//yesterDay ?></td><!--other -->
                                                  <td><?php echo $reports['total_brkr_or_refferal']; ?></td>
                                                  <td><?php echo mean($reports['brkr_or_refferal'],$reports['total_brkr_or_refferal']); ?></td>
                                                  <td>?</td>
                                                  
                                                   <td><?php echo $reports['exch_and_sales_rfrl'];//yesterDay ?></td><!--olx -->
                                                  <td><?php echo $reports['total_exch_and_sales_rfrl']; ?></td>
                                                  <td><?php echo mean($reports['exch_and_sales_rfrl'],$reports['total_exch_and_sales_rfrl']); ?></td>
                                                  <td>?</td>
                                                                                                 
                                                  <td><?php echo $yesterDayTotal=reports['yester_day_walk_in']+$reports['yester_day_cug']+$online_and_olx_ysday+$reports['brkr_or_refferal']+$reports['exch_and_sales_rfrl'];//$reports['grand_tot_ysday'] ?></td><!--Total -->
                                                  <td><?php echo $grand_total=$reports['total_walk_in']+$reports['total_cug']+$online_and_olx_total+$reports['total_brkr_or_refferal']+$reports['total_exch_and_sales_rfrl'] //$reports['total_grand_total'] ?></td>
                                                  <td><?php echo mean($yesterDayTotal,$grand_total); ?></td>
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