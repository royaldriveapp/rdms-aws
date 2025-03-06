+
<?php
  if (!empty($reports['pendingPymnts'])) {
       foreach ($reports['pendingPymnts'] as $key => $report) {
            
     
            ?>
            <tr  class="bdy singleline txtBlk" data-url="#">
                 <td  class="details-control"><?php echo @$key+1; ?></td>
                 <td class="details-control"><?php echo $report['vbk_cust_name'] ?></td>
                 <td class="details-control"><?php echo $report['enq_cus_mobile']; ?></td>
                 <td class="details-control">
           <?php echo $report['val_veh_no']; ?>           
                     
  </td>
                 <td class="details-control">
                   <?php echo $report['brd_title'] .'&'. $report['mod_title'] ;
                                           ?>
                 </td>
                 
                 <td class="details-control"><?php echo date('d-m-Y', strtotime($report['val_sold_date'])); ?></td>
                 <td class="details-control">fc</td>
                 <td><?php echo date('d-m-Y', strtotime($report['vbk_do_date']));?> </td>
                 <td class="details-control">Days from DO</td>
                 <td class="details-control"><?php echo $report['val_hypo_loan_amt']?></td>
                 <td class="details-control"><?php 
                                           echo unserialize(Showrooms)[$reports['shrm']];
                                                     ?> </td>
                 <td class="details-control"><?php echo $report['sales_staff']?></td>
                    <td class="details-control"><?php echo $report['asm']?> </td>

            </tr>
            <?php
       }
  }
?>
            <style>
                  .delivered{
       background-color: #bde9ba;
     }
      .cancelled{
       background-color: #ea111126;
     }
     .rejected{
       background-color: #ea11114a;
     }
      .txtBlk{
          color: black !important;
     }
            </style>
<script>
     $(document).ready(function () {    
          $("#rowClick .bdy").click(function (e) {
               window.open($(this).data("url"), '_blank');
          });
     });
</script>

