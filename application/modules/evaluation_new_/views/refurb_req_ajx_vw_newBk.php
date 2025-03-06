<?php
  
  if (!empty($refurbs)) {
     
       foreach ($refurbs as $key => $refurb) {
            //$count = $this->reports->getPurchaseCount($enquery['veh_varient'], $enquery['veh_year'], $date_filter, $formFilter);//model-refurb-req
            ?>
                   
           <tr onclick="showHideRow('hidden_row1');" class="bdy singleline model-refurb-req <?php echo!empty($refurb) ? 'bg-approved' : 'bg-un-approved';?>" data-url="<?php echo site_url('evaluation/open_refurb_req_model') . '/' . encryptor($refurb['upgrd_id']);?>" 
                                              >
                <td><?php  // print_r($refurbs); ?></td> 
                                                                
                                                                 <td><?php echo unserialize(Showrooms)[$refurb[refurbInfo][val_showroom]] ?></td>
                                                                 <td><?php echo $refurb['refurbInfo']['val_purchased_date']?date('d-m-Y', strtotime($refurb['refurbInfo']['val_purchased_date'])):'';?></td>
                                                                 <td><?php 
                                   echo $refurb['val_type']==1?'Purchase':($refurb['val_type']==3?'Park and sale':($refurb['val_type']==4?'Park and sale':($refurb['val_type']==5?'Exchange':'')));
                   ?></td>
                                                                  <td><?php echo $refurb['refurbInfo']['val_veh_no'] ?></td> 
                                                                 <td><?php echo $refurb['refurbInfo']['brd_title'] ?></td>
                                                                 <td><?php echo $refurb['refurbInfo']['mod_title'] ?></td>
                                                                 <td><?php echo $refurb['refurbInfo']['val_model_year'];?></td>
                                                                   <td><?php echo $refurb['refurbInfo']['val_km'];?></td> 
                                                                   <td><?php foreach ($refurb['refJobs'] as $key => $rfJob) {
                                                                        $jb[]= $rfJob['upgrd_key'];
                                                                        
                                                                        

} ?></td>
                                                                 <td></td>
                                                                 <td>yes</td>
                                                                 <td></td>
                                                                 <td></td>
                                                                 <td></td>
                                                                  <td></td>
            </tr>
            <tr id="hidden_row1" class="hidden_row">
				<td colspan=4>
					Person-1 is 24 years old and
					he is a computer programmer
					he earns 60000 per month
				</td>
			</tr>
            <?php
       }
  }
?>

<script>
     $(document).ready(function () {
//          $("#rowClick .bdy").click(function (e) {
//               window.open($(this).data("url"), '_blank');
//          });
     });
</script>