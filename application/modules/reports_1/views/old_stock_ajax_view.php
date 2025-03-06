
<?php
 $bgColor='';
  if (!empty($reports)) {
       foreach ($reports as $key => $report) {
            
     
            ?>
            <tr  class="bdy singleline txtBlk" data-url="#">
                 <td  class="details-control <?php echo @$bgColor; ?>"><?php //echo 'sts:'.$report['vbk_status'].'val_id:'.$report['val_id']; ?><?php //echo $report['usr_id']; ?><?php echo @$key+1; ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo date('d-m-Y', strtotime($report['val_purchased_date'])); ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['val_veh_no']; ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>">
                      
                      <?php echo $report['brd_title'] .'&'. $report['mod_title'] ;
                                           ?>
  </td>
                 <td class="details-control <?php echo @$bgColor; ?>">
                  <?php echo $report['val_model_year']; 
                  ?>
                 </td>
                 
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['val_km']; ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['day_in_stock'];?></td>
                 <td> </td>

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
            </style>
<script>
     $(document).ready(function () {    
          $("#rowClick .bdy").click(function (e) {
               window.open($(this).data("url"), '_blank');
          });
     });
</script>

