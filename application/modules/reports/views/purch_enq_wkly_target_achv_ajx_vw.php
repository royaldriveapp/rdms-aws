
     
            <tr class="hdr singleline lbl-blk">
                                             <td></td>  
                                             <td>Target</td> 
                                              <td>Achivement</td>
                                               <td>Target</td> 
                                              <td>Achivement</td>
                                             <td>Target</td> 
                                              <td>Achivement</td>
                                              <td>Target</td> 
                                              <td>Achivement</td>
                                              <td>Target</td> 
                                              <td>Achivement</td>
                                        </tr>
                                        <?php foreach ($weeklyData as $key => $value) {
                                          $f_wk_target+=$value['st_1st_week_target'];  
                                          $sec_wk_target+=$value['st_2nd_week_target'];
                                          $thrd_wk_target+=$value['st_3rd_week_target'];
                                          $frth_wk_target+=$value['st_4th_week_target'];
                                        
                                          $f_wk_ach+=$value['1st_week_achivement'];  
                                          $sec_wk_ach+=$value['2nd_week_achivement'];
                                          $thrd_wk_ach+=$value['3rd_week_achivement'];
                                          $frth_wk_ach+=$value['4th_week_achivement'];
                                         ?>
                                        <tr class="hdr singleline lbl-blk">
                                             <td><?php echo $value['staff'];?></td> 
                                               <td><?php echo $value['st_1st_week_target'];?></td> 
                                              <td><?php echo $value['1st_week_achivement'];?></td>
                                               <td><?php echo $value['st_2nd_week_target'];?></td> 
                                              <td><?php echo $value['2nd_week_achivement'];?></td>
                                             <td><?php echo $value['st_3rd_week_target'];?></td> 
                                              <td><?php echo $value['3rd_week_achivement'];?></td>
                                              <td><?php echo $value['st_4th_week_target'];?></td> 
                                              <td><?php echo $value['4th_week_achivement'];?></td>
                                              <td><?php echo $value['st_1st_week_target']+$value['st_2nd_week_target']+$value['st_3rd_week_target']+$value['st_4th_week_target'];?></td> 
                                              <td><?php echo $value['1st_week_achivement']+$value['2nd_week_achivement']+$value['3rd_week_achivement']+$value['4th_week_achivement'];?></td>  
                                        </tr>
                                        <?php } ?>
                                        <tr class="hdr singleline total-tr">
                                             <td>TOTAL</td>  
                                             <td><?php echo $f_wk_target;?></td> 
                                              <td><?php echo $f_wk_ach ;?></td>
                                               <td><?php echo $sec_wk_target;?></td> 
                                              <td><?php echo $sec_wk_ach ;?></td>
                                             <td><?php echo $thrd_wk_target;?></td> 
                                              <td><?php echo $thrd_wk_ach ;?></td>
                                              <td><?php echo $frth_wk_target;?></td> 
                                              <td><?php echo $frth_wk_ach ;?></td>
                                              <td><?php echo $totalTarget=$f_wk_target+$sec_wk_target+$thrd_wk_target+$frth_wk_target?></td> 
                                              <td><?php echo $totalAch=$f_wk_ach+$sec_wk_ach+$thrd_wk_ach+$frth_wk_ach;?></td>
                                        </tr>
                                         <tr class="hdr singleline percent-tr">
                                             <td>%</td>  
                                             <td><?php echo findPercentage($f_wk_target, 0, $totalTarget);?>%</td> 
                                              <td><?php echo findPercentage($f_wk_ach, 0, $totalTarget);?>%</td>
                                               <td><?php echo findPercentage($sec_wk_target, 0, $totalTarget);?>%</td> 
                                              <td><?php echo findPercentage($sec_wk_ach, 0, $totalTarget);?>%</td>
                                             <td><?php echo findPercentage($thrd_wk_target, 0, $totalTarget);?>%</td> 
                                              <td><?php echo findPercentage($thrd_wk_ach, 0, $totalTarget);?>%</td>
                                              <td><?php echo findPercentage($frth_wk_target, 0, $totalTarget);?>%</td> 
                                              <td><?php echo findPercentage($frth_wk_ach, 0, $totalTarget);?>%</td>
                                              <td><?php echo findPercentage($totalTarget, 0, $totalTarget);?>%</td> 
                                              <td><?php echo findPercentage($totalAch, 0, $totalTarget);?>%</td>
                                        </tr>
<?php


// function mean($count,$total) {
//       $d=date('d');
//      //$result=1312313;
//     $result=($count+$total)/$d;
//  $result= round($result,3);
//       return $result;
//       
//       
//  }
  ?>