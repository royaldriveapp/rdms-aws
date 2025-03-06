<?php
  if (!empty($refurbs)) {

       foreach ($refurbs as $key => $refurb) {
            //$count = $this->reports->getPurchaseCount($enquery['veh_varient'], $enquery['veh_year'], $date_filter, $formFilter);//model-refurb-req
            ?>

            <tr onclick="showHideRow('hidden_row_<?php echo $key + 1?>');" class="bdy singleline kmodel-refurb-req <?php echo!empty($refurb) ? 'bg-approved' : 'bg-un-approved';?>"  
                >
                 <?php if ((check_permission('evaluation_new', 'viewrefurbreqs'))) {?>  <td><span class="hidden_row_<?php echo $key + 1?>"><p class='pbtn'> + </p></span></td> <?php }?>
                 <td><?php echo $key + 1 + $s?></td>

                 <td><?php echo @unserialize(Showrooms)[$refurb['refurbInfo']['val_showroom']]?></td>
                 <td class="wrp"><?php echo $refurb['upgrd_key'];?></td>
                 <td><?php echo $refurb['val_veh_no']?></td> 
                 <td><?php echo $refurb['brd_title'] . ' | ' . $refurb['mod_title']?></td>
                 <td></td>

                 <td></td>
                 <td></td>
            </tr>

            <tr id="hidden_row_<?php echo $key + 1?>" class="hidden_row">
                 <td>
                      <table   class="table table-striped table-bordered jbg-clr "  id="table_detailk" width="2000">
                           <thead style="background-color: ; color: white;">
                                <tr class="hdr singleline">
                                     <th class="lbl-blk">No of days required </th>
                                     <th class="lbl-blk"> service given date	 </th>

                                     <th class="lbl-blk" > Service Location </th>
                                     <th width="50%" class="lbl-blk"> Action </th>

                                </tr>
                           </thead>
                           <tbody >
                                <!-- comment -->
                                <tr>
                                     <td>
                                          <input type="text" class="form-control col-md-7 col-xs-12 numOnly" id="num_of_days<?php echo  $refurb['upgrd_id']?>" placeholder="Enter" value="<?php echo  $refurb['upgrd_days_required']?>" autocomplete="off">
                                     </td>
                                     <td>
                                          <input type="text" class="dtpDatePickerDMY form-control col-md-7 col-xs-12 " id="service_given_date<?php echo  $refurb['upgrd_id']?>" id="date" placeholder="Enter " value="<?php echo  $refurb['upgrd_service_given_date']?>" >
                                     </td>
                                     <td>
                                          <input type="text" class="form-control col-md-7 col-xs-12 " id="service_location<?php echo  $refurb['upgrd_id']?>" placeholder="Enter " value="<?php echo  $refurb['upgrd_service_location']?>">
                                     </td>
                                     <td>
                                          <button type="button" data-id="<?php echo $refurb['upgrd_id']?>" class="btn btn-success save-btn">Save<?php echo $refurb['upgrd_id']?></button>
                                     </td>


                                </tr>


                           </tbody>
                      </table>
                 </td>
            </tr>
            <?php
       }
  }
?>

<script>
     $('.save-btn').click(function () {
          //alert(1321);
 var job_id = $(this).data("id");
          var num_of_days = $('#num_of_days'+job_id).val();
          var service_given_date = $('#service_given_date'+job_id).val();
          var service_location = $('#service_location'+job_id).val();
          var url = "<?php echo site_url('evaluation_new/update_refurb_job_by_staff');?>";
                  $.ajax({
               type: "POST",
               url: url,
               data: { job_id: job_id,num_of_days: num_of_days, service_given_date: service_given_date,service_location: service_location},
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

     });
     $(document).ready(function () {
//          $("#rowClick .bdy").click(function (e) {
//               window.open($(this).data("url"), '_blank');
//          });
     });
</script>
