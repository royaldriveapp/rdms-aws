<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="page" id="printDiv">
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                         <!-- <button type="submit" class="btn btn-info no-print" id="print_btn">Print</button> -->
                         <div class="x_title">
                              <h2>Edit Purchase check list</h2>
                              <div class="clearfix"></div>
                         </div>

                         <div class="x_content">
                              <div class="chk-container" style="float: left;width: 100%;">
                                   <h3 class="border-bottom border-gray pb-2 text-center">
                                        <b><font color="red">Purchase Agreement Docket</font></b>
                                   </h3>

                                   <div class="row">
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12">Vehicle Registration NO</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12"><?php echo $evaluation_details['val_veh_no'];?></div>
                                             </div>
                                        </div>
                                        <div class="col-sm-6">
                                             <div class="form-group">
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Make and Model </label>
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
                                                  <div class="col-md-6 col-sm-6 col-xs-12"><?php echo $evaluation_details['val_chasis_no'];?></div>
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
                                                  <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Team Leader </label>
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

                         <form action="<?php echo site_url('evaluation/update_purchase_check_list');?>" method="post"
                               class="x_content frmNewValuation" id="chk_list_form"
                               data-url="<?php echo site_url($controller . '/add_purchase_check_list');?>">

                              <input type="hidden" name="val_id" value="<?php echo $val_id?>">
                              <input type="hidden" name="var_id" value="<?php echo $evaluation_details['var_id']?>">
                              <input type="hidden" name="brd_id" value="<?php echo $evaluation_details['brd_id']?>">
                              <input type="hidden" name="mod_id" value="<?php echo $evaluation_details['mod_id']?>">
                              <input type="hidden" name="description" value='<?php echo json_encode($description);?>'>
                              <input type="hidden" name="vehicle_reg_no" value="<?php echo $evaluation_details['val_veh_no'];?>">
                              <input type="hidden" name="chasis_number" value="<?php echo $evaluation_details['val_chasis_no'];?>">
                              <input type="hidden" name="team_lead_id" value="0">

                              <div class="row">

                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <table class="table table-striped table-bordered">
                                             <tr>
                                                  <th>SI No</th>
                                                  <th>Items</th>
                                                  <th>Yes / No</th>
                                                  <th>Remarks</th>
                                             </tr>

                                             <?php
                                               if (!empty($result['items'])) {
                                                    $slno = 1;
                                                    foreach ($result['items'] as $key => $value) {
                                                         if ($key % 2 != 0) {
                                                              $chkLstData = $this->evaluation->getChkDtls($value->chitem_id, $chkLstMstrId);
                                                              ?>

                                                              <tr>
                                                                   <td><?php echo $slno++?></td>
                                                                   <td><?php echo $value->chitem_name;?><?php echo $value->chitem_id;?></td>
                                                                   <td><input type="checkbox" name="item[<?php echo $value->chitem_id;?>][yn]"
                                                                              id="checkboxOne<?php echo $value->chitem_id;?>"
                                                                              value="<?php echo $value->chitem_id;?>"  <?php echo ($chkLstData->pcld_check_list_item_value == 1) ? 'checked' : '';?>  >
                                                                   </td>
                                                                   <td><input value="<?php echo $chkLstData->pcld_remarks?>" placeholder="Enter Remarks" type="text"
                                                                              class="form-control col-md-7 col-xs-12 "
                                                                              name="item[<?php echo $value->chitem_id;?>][desc]" /></td>

                                                              <input value="<?php echo $chkLstData->pcld_id?>"  type="hidden"
                                                                     class="form-control col-md-7 col-xs-12 "
                                                                     name="item[<?php echo $value->chitem_id;?>][ChkDtl_id]" />
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
                                                  <th>Yes / No</th>
                                                  <th>Remarks</th>
                                             </tr>

                                             <?php
                                               if (!empty($result['items'])) {
                                                    foreach ($result['items'] as $key => $value) {
                                                         if ($key % 2 == 0) {

                                                              $chkLstData = $this->evaluation->getChkDtls($value->chitem_id, $chkLstMstrId);
                                                              ?>
                                                              <tr>
                                                                   <td><?php echo $slno++?></td>
                                                                   <td><?php echo $value->chitem_name;?></td>
                                                                   <td>
                                                                        <input type="checkbox" name="item[<?php echo $value->chitem_id;?>][yn]"
                                                                               id="checkboxOne<?php echo $value->chitem_id;?>"
                                                                               value="<?php echo $value->chitem_id;?>"  <?php echo ($chkLstData->pcld_check_list_item_value == 1) ? 'checked' : '';?>>
                                                                   </td>
                                                                   <td><input value="<?php echo $chkLstData->pcld_remarks?>" placeholder="Enter Remarks" type="text"
                                                                              class="form-control col-md-7 col-xs-12 "
                                                                              name="item[<?php echo $value->chitem_id;?>][desc]" /></td>

                                                              <input value="<?php echo $chkLstData->pcld_id?>"  type="hidden"
                                                                     class="form-control col-md-7 col-xs-12 "
                                                                     name="item[<?php echo $value->chitem_id;?>][ChkDtl_id]" />
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
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
          <strong>Data updated successfully!</strong>
     </div>

     <div class="alert alert-danger alert-dismissible fade in ErrorMsgBox" role="alert" style="display: none;">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
          <strong>Error:Could not be submitted successfully!</strong>
     </div>

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
     $(document).ready(function () {

          $("#print_btn").click(function () {
               window.print();
          });
     });


     $("#chk_list_form").submit(function (e) {

          e.preventDefault();

          var form = $(this);
          var url = form.attr('action');

          $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(),
               dataType: "json",
               beforeSend: function () {

                    $('.divLoading').show();
               },
               success: function (data) {
                    $('.divLoading').hide();

                    if (data.status == "success") {
                         //console.log(data.check_listMasterId);

                         $('.msgBox').show();


                         setTimeout(
                                 function () {
                                      $('.msgBox').fadeOut();
                                      //window.location.replace(site_url+"evaluation/purchase_check_list_print/"+data.check_listMasterId);
                                 }, 1500);
                    } else {
                         $('.ErrorMsgBox').show();
                    }
               }
          });
     });
</script>