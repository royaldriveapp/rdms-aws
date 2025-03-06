+
<?php
  if (!empty($reports['RcPendings'])) {
       foreach ($reports['RcPendings'] as $key => $report) {
            
     
            ?>
            <tr  class="bdy singleline txtBlk" data-url="#">
                 <td  class="details-control"><?php echo @$key+1; ?></td>
                   <td class="details-control"><?php echo date('M-Y', strtotime($report['vbk_delivered_date'])); //vbk_rfi_rc_tranfd_date?></td>
                 <td class="details-control"><?php echo $report['vbk_cust_name'] ?></td>
                 <td class="details-control"><?php echo $report['enq_cus_mobile']; ?></td>
                 <td class="details-control">
           <?php echo $report['val_veh_no']; ?>           
                     
  </td>
                 <td class="details-control">
                   <?php echo $report['brd_title'] .'&'. $report['mod_title'] ;
                                           ?>
                 </td>
                 
                 <td class="details-control"><?php echo date('d-m-Y', strtotime($report['vbk_delivered_date'])); ?></td>
                 <td class="details-control"><?php echo $report['sts_title']?> </td>
                 <td><?php echo $report['rto_place']?> </td>
                 <td class="details-control"><?php 
                                           echo unserialize(Showrooms)[$reports['shrm']];
                                                     ?></td>
                 <td class="details-control"><?php echo $report['sales_staff']?></td>
                 <td class="details-control"><?php echo $report['asm']?>  </td>
                 <td class="details-control"><?php echo date('d-m-Y', strtotime($report['vbk_rc_trans_exp_date'])); ?></td>
                    <td class="details-control"><?php echo $report['sts_des']?> </td>

            </tr>
            <?php
       }
  }
    if (!empty($reports['RcTrnfrdThisMnth'])) {
       foreach ($reports['RcTrnfrdThisMnth'] as $key => $report) {
            
     
            ?>
            <tr  class="bdy singleline txtRed" data-url="#">
                 <td  class="details-control"><?php echo count($reports['RcPendings'])+@$key+1; ?></td>
                   <td class="details-control"><?php echo date('M-Y', strtotime($report['vbk_delivered_date'])); //vbk_rfi_rc_tranfd_date?></td>
                 <td class="details-control"><?php echo $report['vbk_cust_name'] ?></td>
                 <td class="details-control"><?php echo $report['enq_cus_mobile']; ?></td>
                 <td class="details-control">
           <?php echo $report['val_veh_no']; ?>           
                     
  </td>
                 <td class="details-control">
                   <?php echo $report['brd_title'] .'&'. $report['mod_title'] ;
                                           ?>
                 </td>
                 
                 <td class="details-control"><?php echo date('d-m-Y', strtotime($report['vbk_delivered_date'])); ?></td>
                 <td class="details-control"><?php echo $report['sts_title']?> </td>
                 <td><?php echo $report['rto_place']?> </td>
                 <td class="details-control"><?php 
                                           echo unserialize(Showrooms)[$reports['shrm']];
                                                     ?></td>
                 <td class="details-control"><?php echo $report['sales_staff']?></td>
                 <td class="details-control"><?php echo $report['asm']?>  </td>
                 <td class="details-control"><?php echo date('d-m-Y', strtotime($report['vbk_rc_trans_exp_date'])); ?></td>
                    <td class="details-control"><?php echo $report['sts_des']?> </td>

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
     .txtRed{
          color: red !important;
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

