
<tr class="hdr singleline lbl-blk">
   <?php if(!empty($stsWithHmVst['enqData'])){ ?>
     <td> <?php $shrms=unserialize(Showrooms);
// echo $shrms[$stsWithHmVst['shrm']];
     ?></td>
     <td><?php echo $total_hot_plus=$stsWithHmVst['enqData']['total_hot_plus'] ?></td>
     <td><?php echo findPercentage($total_hot_plus, 0, $stsWithHmVst['enqData']['total_enq']);?>%</td>
     <td><?php echo $total_hot=$stsWithHmVst['enqData']['total_hot'] ?></td>
     <td><?php echo findPercentage($total_hot, 0, $stsWithHmVst['enqData']['total_enq']);?>%</td>
     <td><?php echo $total_warm=$stsWithHmVst['enqData']['total_warm'] ?></td>
     <td><?php echo findPercentage($total_warm, 0, $stsWithHmVst['enqData']['total_enq']);?>%</td>
     <td><?php echo $total_cold=$stsWithHmVst['enqData']['total_cold'] ?></td>
     <td><?php echo findPercentage($total_cold, 0, $stsWithHmVst['enqData']['total_enq']);?>%</td>
     <td><?php echo $stsWithHmVst['enqData']['total_enq'] ?></td>
     <td><?php echo $stsWithHmVst['enqData']['total_home_visit'] ?></td>
     <td><?php echo findPercentage($stsWithHmVst['enqData']['homeVisit_hot_plus'], 0, $stsWithHmVst['enqData']['total_home_visit']);?> % </td>
     <td><?php echo findPercentage($stsWithHmVst['enqData']['homeVisit_hot'], 0, $stsWithHmVst['enqData']['total_home_visit']);?> %</td>
     <td>?</td>
     <td>? </td>
     <td>?</td>
     <td>?</td>            
   <?php }else{
       echo 'No data found';
   }
   ?>

</tr>
