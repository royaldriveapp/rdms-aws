<?php
$stockNumber = '';
if (isset($evaluation_details['val_stock_num']) && !empty($evaluation_details['val_stock_num'])) {
     $stockNumber = $evaluation_details['val_stock_num'];
} else if (isset($evaluation_details['val_stock_num_tmp']) && !empty($evaluation_details['val_stock_num_tmp'])) {
     $stockNumber = $evaluation_details['val_stock_num_tmp'];
} else {
     $stockNumber = $evaluation_details['div_short_code'] . 'KL' . date('Ym') . generate_vehicle_virtual_id($evaluation_details['val_id']);
}
?>
<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="page" id="printDiv">
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                         <!-- <button type="submit" class="btn btn-info no-print" id="print_btn">Print</button> -->
                         <div class="x_title">
                              <h2>Purchase check list</h2>
                              <div class="clearfix"></div>
                         </div>

                         <div class="x_content">
                              <div class="chk-container" style="float: left;width: 100%;">
                                   <h3 class="border-bottom border-gray pb-2 text-center">
                                        <b>
                                             <font color="red">Purchase Agreement Docket</font>
                                        </b>
                                        <p style="float:right;font-size: 10px;">
                                             <?php echo 'Stock Number :- ' . $stockNumber; ?>
                                        </p>
                                   </h3>

                                   <div class="row">
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12">Vehicle Registration
                                                       NO</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <?php echo $evaluation_details['val_veh_no']; ?></div>
                                             </div>
                                        </div>
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Make
                                                       and Model </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <?php
                                                       echo $evaluation_details['brd_title'] . ', ' . $evaluation_details['mod_title'] . ', ' . $evaluation_details['var_variant_name'];
                                                       $description = array("brd_title" => $evaluation_details['brd_title'], "mod_title" => $evaluation_details['mod_title'], "var_variant_name" => $evaluation_details['var_variant_name']);
                                                       ?>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Chassis Number</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                       <?php echo $evaluation_details['val_chasis_no']; ?></div>
                                             </div>
                                        </div>

                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Purchase Staff </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12"></div>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="row">
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Team
                                                       Leader </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12"></div>
                                             </div>
                                        </div>

                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Vehicle Received Date </label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12"></div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="row">
                         <form action="<?php echo site_url('evaluation/add_purchase_check_list'); ?>" method="post" class="x_content frmNewValuation" id="chk_list_form" data-url="<?php echo site_url($controller . '/add_purchase_check_list'); ?>">

                              <input type="hidden" name="val_id" value="<?php echo $val_id ?>">
                              <input type="hidden" name="var_id" value="<?php echo $evaluation_details['var_id'] ?>">
                              <input type="hidden" name="brd_id" value="<?php echo $evaluation_details['brd_id'] ?>">
                              <input type="hidden" name="mod_id" value="<?php echo $evaluation_details['mod_id'] ?>">
                              <input type="hidden" name="description" value='<?php echo json_encode($description); ?>'>
                              <input type="hidden" name="vehicle_reg_no" value="<?php echo $evaluation_details['val_veh_no']; ?>">
                              <input type="hidden" name="chasis_number" value="<?php echo $evaluation_details['val_chasis_no']; ?>">
                              <input type="hidden" name="team_lead_id" value="0">
                              <input type="hidden" name="val_stock_num" value="<?php echo strtoupper($stockNumber); ?>">

                              <div class="row">
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <table class="table table-striped table-bordered">
                                             <tr>
                                                  <th>SI No</th>
                                                  <th>Items</th>
                                                  <th>YES / No / NA</th>
                                                  <th>Remarks</th>
                                             </tr>

                                             <?php
                                             if (!empty($result['items'])) {
                                                  $slno = 1;
                                                  foreach ($result['items'] as $key => $value) {
                                                       if ($key % 2 != 0) {
                                             ?>
                                                            <tr>
                                                                 <td><?php echo $slno++ ?></td>
                                                                 <td><?php echo $value->chitem_name; ?></td>
                                                                 <td>

                                                                      <select name="item[<?php echo $value->chitem_id; ?>][yn]">
                                                                           <option value="1">Yes</option>
                                                                           <option value="0">No</option>
                                                                           <option value="2">NA</option>
                                                                      </select>


                                                                 </td>
                                                                 <td><input placeholder="Enter Remarks" type="text" class="form-control col-md-7 col-xs-12 " name="item[<?php echo $value->chitem_id; ?>][desc]" /></td>
                                                            </tr>
                                             <?php
                                                       }
                                                  }
                                             }
                                             ?>
                                        </table>
                                   </div>

                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <table class="table table-striped table-bordered">
                                             <tr>
                                                  <th>SI No</th>
                                                  <th>Items</th>
                                                  <th>YES / No / NA</th>
                                                  <th>Remarks</th>
                                             </tr>


                                             <?php
                                             if (!empty($result['items'])) {

                                                  foreach ($result['items'] as $key => $value) {
                                                       if ($key % 2 == 0) {
                                             ?>
                                                            <tr>
                                                                 <td><?php echo $slno++ ?></td>
                                                                 <td><?php echo $value->chitem_name; ?></td>
                                                                 <td>

                                                                      <select name="item[<?php echo $value->chitem_id; ?>][yn]">
                                                                           <option value="1">Yes</option>
                                                                           <option value="0">No</option>
                                                                           <option value="2">NA</option>
                                                                      </select>
                                                                 </td>
                                                                 <td><input placeholder="Enter Remarks" type="text" class="form-control col-md-7 col-xs-12 " name="item[<?php echo $value->chitem_id; ?>][desc]" /></td>
                                                            </tr>
                                             <?php
                                                       }
                                                  }
                                             }
                                             ?>
                                        </table>
                                   </div>
                              </div>
                              <button type="submit" class="btn btn-success no-print">Submit</button>
                         </form>
                    </div>
               </div>
          </div> <!-- @end print div-->
     </div>

     <div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <strong>Data submited successfully!</strong>
     </div>

     <div class="alert alert-danger alert-dismissible fade in ErrorMsgBox" role="alert" style="display: none;">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <strong>Error:Could not be submitted successfully!</strong>
     </div>

     <!-- Update document details -->
     <?php if (check_permission('evaluation', 'updatedocumentdetails')) { ?>
          <div class="no-print col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel tile overflow_hidden">
                    <div class="x_title">
                         <h2>Update document details</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="form-group" style="float: left;width: 100%;">
                              <div class="col-md-10 col-sm-6 col-xs-8">
                                   <textarea type="text" class="vdh_cmd form-control col-md-7 col-xs-8" name="vdh_cmd" placeholder="Please provide document details here"></textarea>
                              </div>
                              <div class="col-md-2 col-sm-6 col-xs-8">
                                   <button value="28" name="status" type="submit" data-url="<?php echo site_url('evaluation/updateDocumentDetals'); ?>" class="btnSubmitDocumentDetails btn btn-success">Submit comments <i class="fa fa-comments"></i></button>
                              </div>
                         </div>
                         <?php if (isset($dochistry) && !empty($dochistry)) { ?>
                              <div class="timeline-container" style="float:left;height: 400px;overflow-y: scroll;">
                                   <ul class="book-timeline ulTimeline">
                                        <?php
                                        foreach ($dochistry as $key => $value) {
                                        ?>
                                             <li>
                                                  <div class="timeline-time">
                                                       <?php if (!empty($value['vdh_added_on'])) { ?>
                                                            <span class="date"><i class="fa fa-calendar" style="margin-right: 5px;"></i><?php echo date('d-m-Y', strtotime($value['vdh_added_on'])); ?></span>
                                                            <span class="time"><i class="fa fa-clock-o" style="margin-right: 6px;"></i><?php echo date('h:i A', strtotime($value['vdh_added_on'])); ?></span>
                                                       <?php } ?>
                                                  </div>
                                                  <div class="timeline-icon">
                                                       <a href="javascript:;">&nbsp;</a>
                                                  </div>
                                                  <div class="timeline-body">
                                                       <div class="timeline-header">
                                                            <span class="userimage">
                                                                 <?php
                                                                 if (file_exists('assets/uploads/avatar/' . $value['usr_avatar'])) {
                                                                      echo img(array('src' => 'assets/uploads/avatar/' . $value['usr_avatar']));
                                                                 } else {
                                                                 ?><img src="https://www.w3schools.com/howto/img_avatar.png" alt=""><?php
                                                                                                                                  }
                                                                                                                                       ?>
                                                            </span>
                                                            <span class="username">
                                                                 <?php if (!empty($value['usr_first_name'])) { ?>
                                                                      <a href="javascript:;">
                                                                           <?php echo $value['usr_first_name'] . ' ' . $value['usr_last_name']; ?>
                                                                      </a>
                                                                 <?php }
                                                                 if (!empty($value['shr_location'])) { ?>
                                                                      <span style="float:right;"><i class="fa fa-map-marker"></i>
                                                                           <?php echo $value['shr_location']; ?></span>
                                                                 <?php } ?>
                                                            </span>
                                                       </div>
                                                       <div class="timeline-content">
                                                            <p>
                                                                 <?php echo $value['vdh_cmd']; ?>
                                                            </p>
                                                       </div>
                                                  </div>
                                             </li>
                                        <?php
                                        }
                                        ?>
                                   </ul>
                              </div>
                         <?php } ?>
                    </div>
               </div>
          </div>
     <?php } ?>
     <!-- Update document details -->

</div>

<style>
     .page {
          /*width: 21cm;*/
          min-height: 29.7cm;
          /*padding: 2cm;*/
          /*margin: 1cm auto;*/
          /*border: 1px #D3D3D3 solid;*/
          /*border-radius: 5px;*/
          background: white;
          /*box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);*/
     }

     @media print {

          .no-print,
          .no-print * {
               display: none !important;
          }

          html,
          body {
               /* avoid extra blank page while printing  */
               height: 100vh;
               margin: 0 !important;
               padding: 0 !important;
               overflow: hidden;
          }
     }
</style>
<script>
     $(document).ready(function() {
          $(".btnSubmitDocumentDetails").click(function() {
               var documentDetails = $('.vdh_cmd').val().trim();
               if (documentDetails) {
                    $('.vdh_cmd').css('border-color', '');
                    var url = $(this).data('url');
                    $.ajax({
                         type: 'post',
                         url: url,
                         dataType: 'json',
                         data: {
                              vdh_cmd: documentDetails,
                              vdh_val_id: "<?php echo $vehicles['val_id']; ?>"
                         },
                         success: function(resp) {
                              $('.ulTimeline').prepend(resp.msg).effect("shake");
                              $('.vdh_cmd').val('');
                         }
                    });
               } else {
                    $('.vdh_cmd').css('border-color', 'red');
                    $('.vdh_cmd').focus();
               }
          });
          $("#print_btn").click(function() {
               window.print();
               //  printData();
          });
     });

     $("#chk_list_form").submit(function(e) {

          e.preventDefault();

          var form = $(this);
          var url = form.attr('action');

          $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(),
               dataType: "json",
               beforeSend: function() {

                    $('.divLoading').show();
               },
               success: function(data) {
                    $('.divLoading').hide();

                    if (data.status == "success") {
                         //console.log(data.check_listMasterId);
                         $('.msgBox').show();
                         setTimeout(function() {
                              window.location.replace(site_url +
                                   "evaluation/purchase_check_list_print/" + data
                                   .check_listMasterId);
                         }, 1500);
                    } else {
                         $('.ErrorMsgBox').show();
                    }

               }
          });
     });
</script>