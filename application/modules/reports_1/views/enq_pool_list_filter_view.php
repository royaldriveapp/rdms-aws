<?php
debug($enquiries);
if (!empty($enquiries)) {
     foreach ($enquiries as $key => $enquery) {
          $count = $this->reports->getDataCount($enquery['veh_varient'], $enquery['veh_year']);
          ?>
          <tr data-url="<?php echo site_url('reports/enquiry_pool/' . encryptor($enquery['veh_varient']) . '/' . encryptor($enquery['veh_year'])); ?>">
               <td class="details-control trVOE"">
                    <?php echo $enquery['brd_title']; ?>
               </td>
               <td class="details-control trVOE"">
                    <?php echo $enquery['mod_title']; ?>
               </td>
               <td class="details-control trVOE"">
                    <?php echo $enquery['var_variant_name']; ?>
               </td>
               <td class="details-control trVOE"">
                    <?php echo $enquery['veh_year']; ?>
               </td>
               <td class="details-control trVOE"">
                    <?php echo $count['hot_plus']; ?>
               </td>
               <td class="details-control trVOE"">
                    <?php echo $count['hot']; ?>
               </td>
               <td class="details-control trVOE"">
                    <?php echo $count['warm']; ?>
               </td>
               <td class="details-control trVOE"">
                    <?php echo $count['cold']; ?>
               </td>
               <td class="details-control trVOE"">
                    <?php echo $count['hot_plus'] + $count['hot'] + $count['warm'] + $count['cold']; ?> 
               </td>
               <td class="details-control trVOE"">
                    <?php echo $count['hot_plus'] + $count['hot'] + $count['warm'] + $count['cold'] + $count['dropCount']; ?>
               </td>
               <td class="details-control trVOE"">    
                    <?php echo $count['dropCount']; ?>
               </td>
               <td class="details-control trVOE"">
                    <?php echo $count['purchase_count']; ?>
               </td>
          </tr>
          <?php
     }
}
?>
<script>
     $(document).ready(function () {
          $("#rowClick tr").click(function (e) {
               window.open($(this).data("url"), '_blank');
          });
     });
</script>