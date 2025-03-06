
<?php
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
            <tr  class="bdy singleline " data-url="#<?php echo site_url('reports/enquiry_pool/' . encryptor($report['val_veh_no']) . '/' . encryptor($report['val_veh_no']));?>">
                 <td  class="details-control <?php echo @$bgColor; ?>"><?php echo $report['vbk_id']; ?>-<?php echo @$key+1; ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['shr_location']; ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo date('d-m-Y', strtotime($report['val_purchased_date'])); ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>">
                      <?php echo date('d-m-Y', strtotime($report['vbk_added_on'])); ?>
 
                 
                 </td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php 
                     echo $report['val_type']==1?'Purchase':($report['val_type']==3?'Park and sale':($report['val_type']==4?'Park and sale':($report['val_type']==5?'Exchange':'')));
                   ?></td>
                 
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['val_veh_no']; ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['brd_title']; ?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['mod_title'];?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['var_variant_name'] ;?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['val_model_year'];?></td>
                 <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['val_km'];?></td>
                  <td class="details-control <?php echo @$bgColor; ?>"><?php echo $report['sales_staff'];?></td>
                   <td class="details-control <?php echo @$bgColor; ?>"><?php echo @unserialize(MODE_OF_CONTACT)[$report['val_cust_source']];?></td>
                    <td class="details-control <?php echo @$bgColor; ?>"><?php echo date('d-m-Y', strtotime($report['vbk_expect_delivery'])); ?></td>
                     <td class="details-control <?php echo @$bgColor; ?>">
                     --
                     </td>
                     <td class="details-control <?php echo @$bgColor; ?>">--</td>
                      <td class="details-control <?php echo @$bgColor; ?>">---</td>
                        <td class="details-control <?php echo @$bgColor; ?>"> <?php echo $report['sts_title'];?> </td>
                          <td class="details-control <?php echo @$bgColor; ?>">--- </td>
                            <td class="details-control <?php echo @$bgColor; ?>"> ---</td>
                            <td class="details-control <?php echo @$bgColor; ?>">               <?php  
$purchased_date=date('Y-m-d', strtotime($report['vbk_added_on']));
$startDate = new DateTime($purchased_date);
$now=date("Y-m-d");
$endDate = new DateTime($now);
$difference = $endDate->diff($startDate);
echo $difference->format("%a");
$interval = $startDate->diff($endDate);
//echo $interval->d;

?></td>
            </tr>
            <?php
       }
  }
?>

<script>
     $(document).ready(function () {
          $("#rowClick .bdy").click(function (e) {
               window.open($(this).data("url"), '_blank');
          });
     });
</script>

