
<?php
  function findDays($start_date){
$purchased_date=date('Y-m-d', strtotime($start_date));
$startDate = new DateTime($purchased_date);
$now=date("Y-m-d");
$endDate = new DateTime($now);
$difference = $endDate->diff($startDate);
return $difference->format("%a");
//$interval = $startDate->diff($endDate);
}
  if (!empty($reports)) {
       foreach ($reports as $key => $report) {
            
            //$count = $this->reports->getPurchaseCount($enquery['veh_varient'], $enquery['veh_year'], $date_filter, $formFilter);
               if($report['vbk_status']==40){
                 $bgColor='delivered';
            } elseif ($report['vbk_status']==29) {
             $bgColor='cancelled';    
            }
            elseif ($report['vbk_status']==27) {
             $bgColor='rejected';    
            }
            ?>
            <tr  class="bdy singleline txtBlk" data-url="#<?php echo site_url('reports/enquiry_pool/' . encryptor($report['val_veh_no']) . '/' . encryptor($report['val_veh_no']));?>">
                 <td  class="details-control <?php echo @$bgColor; ?>"><?php //echo 'sts:'.$report['vbk_status'].'val_id:'.$report['val_id']; ?><?php //echo $report['usr_id']; ?><?php echo @$key+1; ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo date('d-m-Y', strtotime($report['val_purchased_date'])); ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo date('d-m-Y', strtotime($report['vbk_added_on'])); ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>">
                      
                      <?php echo findDays($report['vbk_added_on']); 
                      $expFullPyment=$this->reports->expFullPyment($report['val_id']);
                                           ?>
  </td>
                 <td class="details-control <?php echo @$bgColor; ?>">
                  <?php echo findDays($report['val_purchased_date']); 
                  ?>
                 </td>
                 
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['shr_location']; ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['sales_staff'];?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['asm'];?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['enq_cus_name'] ;?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['enq_cus_mobile'];?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['val_veh_no'];?></td>
                  <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['brd_title'].' & '.$report['mod_title'];?></td>
                   <td class="details-control <?php echo @$bgColor; ?>"><?php echo @unserialize(MODE_OF_CONTACT)[$report['val_cust_source']];?></td>
                    <td class="details-control <?php echo @$bgColor; ?>"><?php echo $expFullPyment? date('d-m-Y', strtotime($expFullPyment)):''; ?></td>
                     <td class="details-control <?php echo @$bgColor; ?>">
                    <?php echo date('d-m-Y', strtotime($report['vbk_expect_delivery'])); ?>
                     </td>
                     <td class="details-control <?php echo @$bgColor; ?>"> <?php echo $report['val_sold_date']? date('d-m-Y', strtotime($report['val_sold_date'])):''; ?></td>
                      <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['sts_title'];?></td>

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

