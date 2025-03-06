<?php
  if (!empty($refurbs)) {
       foreach ($refurbs as $key => $refurb) {
            //$count = $this->reports->getPurchaseCount($enquery['veh_varient'], $enquery['veh_year'], $date_filter, $formFilter);
            ?>
            <tr class="bdy singleline" data-url="<?php echo site_url('reports/enquiry_pool/' . encryptor($report['val_veh_no']) . '/' . encryptor($report['val_veh_no']));?>">
                  <td>1</td> 
                                                                
                                                                 <td>Calicut</td>
                                                                 <td>Purchase</td>
                                                                  <td>KL-07-BY-2727</td> 
                                                                 <td>BENZ</td>
                                                                 <td>A 180</td>
                                                                 <td>2013</td>
                                                                   <td>43158</td> 
                                                                 <td>POLISHING/INTERIOR</td>
                                                                 <td>2</td>
                                                                 <td>No</td>
                                                                 <td>02-02-2022</td>
                                                                 <td>02-05-2022</td>
                                                                 <td>PRO COLOR</td>
                                                                  <td></td>
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