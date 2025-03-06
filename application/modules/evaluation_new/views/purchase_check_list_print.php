<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <!--  print div-->
          <div class="page" id="printDiv">
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                         <button type="submit" class="btn btn-info no-print" id="print_btn">
                              <i class="fa fa-print" style="color:white"></i> Print
                         </button>
                         <div class="x_title">
                              <h2>Purchase check list</h2>
                              <div class="clearfix"></div>
                         </div>

                         <div class="x_content">
                              <div class="chk-container" style="float: left;width: 100%;">
                                   <h3 class="border-bottom border-gray pb-2 text-center">Purchase Agreement Docket</h3>
                                   <span class="float-right">
                                        <?php
                                        $val_typeId = $this->evaluation->getTypeByEvalId($result['masterData']['pcl_val_id']);
                                        $purchaseTypes = unserialize(EVALUATION_TYPES);
                                        ?>
                                        <p><h5><b>Purchase type: <?php echo isset($purchaseTypes[$val_typeId]) ? $purchaseTypes[$val_typeId] : ''; ?></b></h5></p>
                                        <p>DOC NO: </p>
                                        <p>Date: <?php echo date('d-m-Y'); ?></p>
                                   </span>
                                   <?php $description = json_decode($result['masterData']['pcl_description']); ?>
                                   <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                             <table class="toptable table table-stripedk table-borderedj">
                                                  <tbody>
                                                       <tr class="top-tbl-tr">
                                                            <td><b>Vehicle Registration NO :</b> <?php echo $result['masterData']['pcl_vehicle_reg_no']; ?> </td>
                                                            <td><b>Make and Model :</b><?php echo $description->brd_title . ', ' . $description->mod_title . ', ' . $description->var_variant_name ?> </td>
                                                       </tr>
                                                       <tr>
                                                            <td><b>Chassis Number :</b> <?php echo $result['masterData']['pcl_chasis_number']; ?></td>
                                                            <td><b>Purchase Staff </b>: </td>
                                                       </tr>
                                                       <tr>
                                                            <td><b>Team Leader :</b> </td>
                                                            <td><b>Vehicle Received Date :</b></td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="row">
                         <form action="<?php echo site_url('checklist/add_purchase_check_list'); ?>" method="post" class="x_content frmNewValuation" 
                               id="chk_list_form" data-url="<?php echo site_url($controller . '/add_purchase_check_list'); ?>">
                              <input type="hidden" name="vehicle_reg_no" value="12337">
                              <input type="hidden" name="chasis_number" value="1971651">
                              <input type="hidden" name="team_lead_id" value="75">

                              <div class="row">
                                   <!-- table left -->
                                   <div class="col-md-6 col-sm-6 col-xs-6">
                                        <table class="table table-striped table-bordered">
                                             <tr>
                                                  <th>SI No</th>
                                                  <th>Items</th>
                                                  <th>Yes / No</th>
                                                  <th>Remarks</th>
                                             </tr>
                                             <?php
                                             if (!empty($result['detailsData'])) {
                                                  $slno = 1;
                                                  foreach ($result['detailsData'] as $key => $value) {
                                                       if ($key % 2 != 0) {
                                                            ?>
                                                            <tr>
                                                                 <td><?php echo $slno++ ?></td>
                                                                 <td><?php echo $value->chitem_name; ?></td>
                                                                 <td><?php echo ($value->pcld_check_list_item_value == 1) ? 'Yes' : 'No'; ?></td>
                                                                 <td><?php echo $value->pcld_remarks; ?></td>
                                                            </tr>
                                                            <?php
                                                       }
                                                  }
                                             }
                                             ?>
                                        </table>
                                   </div>

                                   <div class="col-md-6 col-sm-6 col-xs-6">
                                        <table class="table table-striped table-bordered">
                                             <tr>
                                                  <th>SI No</th>
                                                  <th>Items</th>
                                                  <th>Yes / No</th>
                                                  <th>Remarks</th>
                                             </tr>

                                             <?php
                                             if (!empty($result['detailsData'])) {
                                                  foreach ($result['detailsData'] as $key => $value) {
                                                       if ($key % 2 == 0) {
                                                            ?>
                                                            <tr>
                                                                 <td><?php echo $slno++ ?></td>
                                                                 <td><?php echo $value->chitem_name; ?></td>
                                                                 <td><?php echo ($value->pcld_check_list_item_value == 1) ? 'Yes' : 'No'; ?></td>
                                                                 <td><?php echo $value->pcld_remarks; ?></td>
                                                            </tr>
                                                            <?php
                                                       }
                                                  }
                                             }
                                             ?>
                                        </table>
                                   </div>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>

     <div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <strong>Data submited successfully!</strong>
     </div>

     <div class="alert alert-danger alert-dismissible fade in ErrorMsgBox" role="alert" style="display: none;">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
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

     .toptable>tbody>tr>td,
     .table>tbody>tr>th,
     .table>tfoot>tr>td,
     .table>tfoot>tr>th,
     .table>thead>tr>td,
     .table>thead>tr>th {
          padding: 8px;
          line-height: 0.777;
          vertical-align: top;
          border-top: 0px !important;
     }
     .float-right {
          float: right;
     }

     .ktop-tbl-tr {
          line-height: 5;
     }

     td {
          max-width: 100px;
          text-overflow: ellipsis;
          white-space: nowrap;
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
                    // setting a timeout
                    $('.divLoading').show();
               },
               success: function (data) {
                    $('.divLoading').hide();

                    if (data.status == "success") {
                         $('.msgBox').show();
                         //$('#myDiv').html(content.message);
                    } else {
                         $('.ErrorMsgBox').show();
                    }
               }
          });
     });
</script>