<?php
  if (!empty($reports)) {
       foreach ($reports as $key => $value) {
            //$count = $this->reports->getPurchaseCount($enquery['veh_varient'], $enquery['veh_year'], $date_filter, $formFilter);
           $total=$value['Walkin']+$value['cug_rd_in']+$value['fst_trk_print_adv']+$value['whatsApp']+$value['EVENTS']+$value['olx_rd']+$value['cug_own']+$value['fb_rd']+$value['cug_own']+$value['olx_own']+$value['fb_own']+$value['other_telecall_rd_dbt']+$value['other_Web_just_dial']+$value['other_Web_enq_car_wale']+$value['other_Web_enq_india_mart']+$value['other_Web_enq_google']+$value['other_Web_enq_RD_OUT']+$value['other_referal_own_dbt'];
            ?>
            <tr class="hdr singleline">
                 <td><?php echo date('d-m-Y', strtotime($value['enq_entry_date']));?></td> <td class="td-total"><?php echo $value['Walkin']?></td><td class="td-qlt"> ? </td>  <td class="td-total"><?php echo $value['cug_rd_in']?></td>
                 <td class="td-qlt">?</td><td class="td-total"><?php echo $value['fst_trk_print_adv']?></td><td class="td-qlt">?</td>
                 <td class="td-total"><?php echo $value['whatsApp']?></td><td class="td-qlt">?</td><td class="td-total"><?php echo $value['EVENTS']?></td><td class="td-qlt">?</td>
                 <td class="td-total"><?php echo $value['olx_rd'];//olx?></td><td class="td-qlt">?</td><td class="td-total"><?php echo $value['fb_rd'];//fb?></td><td class="td-qlt">?</td> 
                 <td class="td-green"><?php echo $value['cug_own']+$value['olx_own']+$value['fb_own'];//Own ?></td><td class="td-green"><?php echo $value['other_telecall_rd_dbt']//Tele in?></td><td class="td-green"><?php echo $value['other_Web_just_dial']+$value['other_Web_enq_car_wale']+$value['other_Web_enq_india_mart']+$value['other_Web_enq_google']+$value['other_Web_enq_RD_OUT']//Web?></td><td class="td-green"><?php echo $value['other_referal_own_dbt']//Refferal ?></td><td class="td-qlt">?</td><td class="td-total"><?php echo $total;?></td>
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