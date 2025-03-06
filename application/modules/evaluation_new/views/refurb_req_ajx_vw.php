<?php
  
  if (!empty($refurbs)) {
     
       foreach ($refurbs as $key => $refurb) {
            //$count = $this->reports->getPurchaseCount($enquery['veh_varient'], $enquery['veh_year'], $date_filter, $formFilter);//model-refurb-req
            ?>
                   
           <tr onclick="showHideRow('hidden_row_<?php echo $key+1 ?>');" class="bdy singleline kmodel-refurb-req <?php echo!empty($refurb) ? 'bg-approved' : 'bg-un-approved';?>"  
                                              >
              <?php if ((check_permission('evaluation','viewrefurbreqs'))) {?>  <td><span class="hidden_row_<?php echo $key+1 ?>"><p class='pbtn'> + </p></span></td> <?php }?>
                <td><?php echo $key+1+$s ?></td>
                                                                
                                                                 <td><?php echo @unserialize(Showrooms)[$refurb['refurbInfo']['val_showroom']] ?></td>
                                                                 <td><?php echo $refurb['refurbInfo']['val_purchased_date']?date('d-m-Y', strtotime($refurb['refurbInfo']['val_purchased_date'])):'';?></td>
                                                                 <td><?php 
                                   echo $refurb['refurbInfo']['val_type']==1?'Purchase':($refurb['refurbInfo']['val_type']==3?'Park and sale':($refurb['refurbInfo']['val_type']==4?'Park and sale':($refurb['refurbInfo']['val_type']==5?'Exchange':'')));
                   ?></td>
                                                                  <td><?php echo $refurb['refurbInfo']['val_veh_no'] ?></td> 
                                                                 <td><?php echo $refurb['refurbInfo']['brd_title'] ?></td>
                                                                 <td><?php echo $refurb['refurbInfo']['mod_title'] ?></td>
                                                                 <td><?php echo $refurb['refurbInfo']['val_model_year'];?></td>
                                                                   <td><?php echo $refurb['refurbInfo']['val_km'];?></td> 
                                                                   <td></td>
                                                                 <td></td>
                                                                                                                                 <td></td>
                                                                 <td></td>
                                                                 <td></td>
                                                                  <td></td>
            </tr>
          
            <tr id="hidden_row_<?php echo $key+1 ?>" class="hidden_row">
				<td>
                                   <table   class="table table-striped table-bordered jbg-clr "  id="table_detail" style="width:1001px;">
                                        <thead style="background-color: ; color: white;">
                                             <tr class="hdr singleline">
                                                   <th class="lbl-blk"> JOB List </th>
                                                    <th class="lbl-blk"> Cost </th>
                                                   <?php if ((check_permission('evaluation', 'viewrefurbreqs')) && (check_permission('evaluation', 'update_refurb_req_approval')) ) {
                                                              ?> <th class="lbl-blk" colspan="2"> Is approved?  </th>
                                                     <th class="lbl-blk"> Remarks </th>
                                                      <?php  } ?>
                                                     <th class="lbl-blk">Added by</th>
                                                     <th class="lbl-blk">Created at</th>
                                             </tr>
                                               </thead>
                                               <tbody >
                                                    <?php foreach ($refurb['refJobs'] as $k => $rfJob) {
                                                                   ;?>
                                                                        
                                                                        


                                                    <tr>
                                                         <td>
                                                              <?php echo $rfJob['upgrd_key']; ?>
                                                         </td>
                                                         <td>
                                                             <?php echo $rfJob['upgrd_refurb_actual_cost']; ?>
                                                         </td>
                                                         <?php if ((check_permission('evaluation', 'viewrefurbreqs')) && (check_permission('evaluation', 'update_refurb_req_approval')) ) {
                                                              ?>
                                                         <td>
                                                            
                                   <div class="form-check">
                                        <label class="form-check-label" for="expet_booking">
                                             <span class="lbl">Yes</span>
                                        </label>
                                        <input class="form-check-input radio-btn" type="radio" name="is_approved[<?php echo $k ?>]" value="1" data-id='<?php echo $rfJob['upgrd_id'] ?>' id="flexRadioDisabled">
                                        
                                      
                                   </div>
                             
                                                              
                                                         </td>
                                                         <td>
                                                              <label class="form-check-label" for="expet_booking">
                                             <span class="lbl">No</span>
                                        </label>
                                        <input class="form-check-input radio-btn" type="radio" name="is_approved[<?php echo $k ?>]" value="0" data-id='<?php echo $rfJob['upgrd_id'] ?>' id="flexRadioDisabled">
                                          
                                                         </td>
                                                         <td>
                                                              <textarea id="remarks_<?php echo $rfJob['upgrd_id'] ?>" placeholder="Enter Remark" >
                                                                   
                                                              </textarea>
<!--                                                              <input type="text" class="form-control col-md-7 col-xs-12 " name="remark" id="remarks_<?php echo $rfJob['upgrd_id'] ?>" placeholder="Enter Remark">-->
                                                         </td>
                                                         <?php  } ?>
                                                         <td> <?php echo $rfJob['usr_first_name']; ?></td>
                                                         <td><?php echo $rfJob['upgrd_created_at']?date('d-m-Y', strtotime($rfJob['upgrd_created_at'])):'';?></td>
                                                    </tr>
                                                                      <?php  } ?>
                                                    
                                               </tbody>
                                   </table>
				</td>
			</tr>
            <?php
       }
  }
?>

<script>
     $('.radio-btn').click(function() {
      if($('.radio-btn').is(':checked')) 
  { 
       var status=this.value;
       var job_id=$(this).data("id");
       var remarks = $('#remarks_'+job_id).val();

      // alert(remarks);
   var url="<?php echo site_url('evaluation/update_refurb_req_approval');?>";
       alert(url);
    $.ajax({
               type: "POST",
               url: url,
               data: {status:status,job_id:job_id,remarks:remarks},
               dataType: "JSON",
               beforeSend: function () {
                    $('.divLoading').show();
               },
               success: function (data) {
                    $('.divLoading').hide();
                     $('.msgBox').show();
               setTimeout(function () {
                    $('.msgBox').fadeOut();
               }, 1500);
                   // alert(data);
                          }
          });
  }                      
});
     $(document).ready(function () {
//          $("#rowClick .bdy").click(function (e) {
//               window.open($(this).data("url"), '_blank');
//          });
     });
</script>