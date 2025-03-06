<?php
  if (!empty($enquiries)) {
       foreach ($enquiries as $key => $enquery) {
            $count = $this->reports->getPurchaseCount($enquery['veh_varient'], $enquery['veh_year'], $date_filter, $formFilter);
            ?>
            <tr class="bdy" data-url="<?php echo site_url('reports/enquiry_pool/' . encryptor($enquery['veh_varient']) . '/' . encryptor($enquery['veh_year']));?>">
                 <td class="details-control trVOE"><?php echo $enquery['brd_title']; ?></td>
                 <td class="details-control trVOE"><?php echo $enquery['mod_title']; ?></td>
                 <td class="details-control trVOE"><?php echo $enquery['var_variant_name']; ?></td>
                 <td class="details-control trVOE"><?php echo $enquery['veh_year']; ?></td>
                 <td class="details-control trVOE"><?php echo $enquery['hot_plus']; ?></td>
                 <td class="details-control trVOE"><?php echo $enquery['hot']; ?></td>
                 <td class="details-control trVOE"><?php echo $enquery['warm']; ?></td>
                 <td class="details-control trVOE"><?php echo $enquery['cold']; ?></td>
                 <td class="details-control trVOE"><?php echo $enquery['hot_plus'] + $enquery['hot'] + $enquery['warm'] + $enquery['cold'];?></td>
                 <td class="details-control trVOE"><?php echo $enquery['hot_plus'] + $enquery['hot'] + $enquery['warm'] + $enquery['cold'] + $enquery['dropCount'];?></td>
                 <td class="details-control trVOE"><?php echo $enquery['dropCount'];?></td>
                 <td class="details-control trVOE"><?php echo $count['purchase_count'];?></td>
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