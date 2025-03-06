
<tr class="hdr singleline lbl-blk">
     <td>
          Purchased Stock 
     </td>
     <td class="bg_abv_121">
          <?php echo $stockReport['prchs_age_abv_121']; //?>
     </td>
     <td class="bg_91to120">
          <?php echo $stockReport['prchs_age_91to120_day'];?>
     </td>
     <td class="bg_61to90">
          <?php echo $stockReport['prchs_age_61to90_day'];?>
     </td>
     <td class="bg_31to60">
          <?php echo $stockReport['prchs_age_31to60_day'];?>
     </td>
     <td class="bg_0to30">
          <?php echo $stockReport['prchs_age_0to30_day'];?>
     </td>
     <td>
          <?php echo $total = $stockReport['prchs_age_abv_121'] + $stockReport['prchs_age_91to120_day'] + $stockReport['prchs_age_61to90_day'] + $stockReport['prchs_age_31to60_day'] + $stockReport['prchs_age_0to30_day'];?>
     </td>


</tr>
<tr class="hdr singleline lbl-blk">
     <td>
          %
     </td>
     <td class="bg_abv_121">
          <?php echo $tot_prch_abv_121 = findPercentage($stockReport['prchs_age_abv_121'], 0, $total);?>%
     </td>
     <td class="bg_91to120">
          <?php echo $tot_prch_91to120 = findPercentage($stockReport['prchs_age_91to120_day'], 0, $total);?>%     
     </td>
     <td class="bg_61to90">
          <?php echo $tot_prch_61to90 = findPercentage($stockReport['prchs_age_61to90_day'], 0, $total);?>%
     </td>
     <td class="bg_31to60">
          <?php echo $tot_prch_31to60 = findPercentage($stockReport['prchs_age_31to60_day'], 0, $total);?>%
     </td>
     <td class="bg_0to30">
          <?php echo $tot_prch_0to30 = findPercentage($stockReport['prchs_age_0to30_day'], 0, $total);?>%
     </td>
     <td>

     </td>


</tr>
<tr class="hdr singleline lbl-blk">
     <td class="lbl-blk">
          Park & Sell 
     </td>
     <td class="bg_abv_121">
          <?php echo $stockReport['park_and_sale_age_abv_121'];?>
     </td>
     <td class="bg_91to120">
          <?php echo $stockReport['park_and_sale_age_91to120_day'];?>
     </td>
     <td class="bg_61to90">
          <?php echo $stockReport['park_and_sale_age_61to90_day'];?>
     </td>
     <td class="bg_31to60">
          <?php echo $stockReport['park_and_sale_age_31to60_day'];?>
     </td>
     <td class="bg_0to30">
          <?php echo $stockReport['park_and_sale_age_0to30_day'];?>
     </td>
     <td>
          <?php echo $total = $stockReport['park_and_sale_age_abv_121'] + $stockReport['park_and_sale_age_91to120_day'] + $stockReport['park_and_sale_age_61to90_day'] + $stockReport['park_and_sale_age_31to60_day'] + $stockReport['park_and_sale_age_0to30_day'];?>
     </td>


</tr>
<tr class="hdr singleline lbl-blk">
     <td>
          %
     </td>
     <td class="bg_abv_121">
          <?php echo $tot_park_and_sale_abv_121 = findPercentage($stockReport['park_and_sale_age_abv_121'], 0, $total);?>%
     </td>
     <td class="bg_91to120">
          <?php echo $tot_park_and_sale_91to120 = findPercentage($stockReport['park_and_sale_age_91to120_day'], 0, $total);?>%     
     </td>
     <td class="bg_61to90">
          <?php echo $tot_park_and_sale_61to90 = findPercentage($stockReport['park_and_sale_age_61to90_day'], 0, $total);?>%
     </td>
     <td class="bg_31to60">
          <?php echo $tot_park_and_sale_31to60 = findPercentage($stockReport['park_and_sale_age_31to60_day'], 0, $total);?>%
     </td>
     <td class="bg_0to30">
          <?php echo $tot_park_and_sale_0to30 = findPercentage($stockReport['park_and_sale_age_0to30_day'], 0, $total);?>%
     </td>
     <td>

     </td>

</tr>
<tr class="hdr singleline lbl-blk">
     <td class="lbl-blk">
          Total
     </td>
     <td class="bg_abv_121">
          <?php echo $total_abv_121 = $stockReport['prchs_age_abv_121'] + $stockReport['park_and_sale_age_abv_121'];?>
     </td>
     <td class="bg_91to120">
          <?php echo $total_91to120 = $stockReport['prchs_age_91to120_day'] + $stockReport['park_and_sale_age_91to120_day'];?>
     </td>
     <td class="bg_61to90">
          <?php echo $total_61to90 = $stockReport['prchs_age_61to90_day'] + $stockReport['park_and_sale_age_61to90_day'];?>
     </td>
     <td class="bg_31to60">
          <?php echo $total_31to60 = $stockReport['prchs_age_31to60_day'] + $stockReport['park_and_sale_age_31to60_day'];?>
     </td>
     <td class="bg_0to30">
          <?php echo $total_0to30 = $stockReport['prchs_age_0to30_day'] + $stockReport['park_and_sale_age_0to30_day'];?>
     </td>
     <td>
          <?php echo $g_total = $total_abv_121 + $total_91to120 + $total_61to90 + $total_31to60 + $total_0to30;?>
     </td>
</tr>
<tr class="hdr singleline lbl-blk">
     <td>
          %
     </td>
     <td class="bg_abv_121">
          <?php echo findPercentage($total_abv_121, 0, $g_total);?>%
     </td>
     <td class="bg_91to120">
          <?php echo findPercentage($total_91to120, 0, $g_total);?>%     
     </td>
     <td class="bg_61to90">
          <?php echo findPercentage($total_61to90, 0, $g_total);?>%
     </td>
     <td class="bg_31to60">
          <?php echo findPercentage($total_31to60, 0, $g_total);?>%
     </td>
     <td class="bg_0to30">
          <?php echo findPercentage($total_0to30, 0, $g_total);?>%
     </td>
     <td>

     </td>

</tr>

