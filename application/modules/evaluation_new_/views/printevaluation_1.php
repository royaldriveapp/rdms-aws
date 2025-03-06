<style>
     .titletext {
          margin-left: 13px;
          margin-top: 8px;
          position: absolute;
          text-decoration: none;
     }
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

     .subpage {
          /*padding: 1cm;*/
          /*border: 5px red solid;*/
          height: 292mm;
          /*outline: 2cm #FFEAEA solid;*/
     }

     @page {
          size: A4;
          margin: 0;
     }

     @media print {
          .page {
               margin: 0;
               border: initial;
               border-radius: initial;
               width: initial;
               min-height: initial;
               box-shadow: initial;
               background: initial;
               page-break-after: always;
          }
     }

     /*complaint*/
     div.gallery {
          margin: 5px;
          border: 1px solid #ccc;
          float: left;
          width: 200px;
     }

     div.gallery:hover {
          border: 1px solid #777;
     }

     div.gallery img {
          width: 100%;
          height: auto;
     }

     div.desc {
          padding: 15px;
          text-align: center;
     }

     /*complaint*/
     .table {
          margin-bottom: 0px !important;
     }

     .table>tbody>tr>td,
     .table>tbody>tr>th,
     .table>tfoot>tr>td,
     .table>tfoot>tr>th,
     .table>thead>tr>td,
     .table>thead>tr>th {
          padding: 5px !important;
     }

     .table>tbody>tr>td,
     .table>tbody>tr>th,
     .table>tfoot>tr>td,
     .table>tfoot>tr>th {
          border: none !important;
     }

     .x_content {
          font-size: 11px;
     }

     @media print {
          .right_col {
               margin-left: 0px !important;
          }

          .left_col {
               display: none !important;
          }

          .right_col {
               height: 400px !important;
          }

          .row {
               height: 400px !important;
          }

          .div-col-body {
               height: 400px !important;
          }

          .x_panel {
               max-height: 271px !important;
          }
     }

     @media print {

          .no-print,
          .no-print * {
               display: none!important;
          }
     }
     .refrftable td,
     .refrftable th {
          border: 1px solid black !important;
          padding: 8px !important;
     }
     .refrftable th {
          padding-top: 12px !important;
          padding-bottom: 12px !important;
          text-align: left;
          color: black !important;
     }

     .refrb-bottom-tbl>thead>tr>th {
          padding: 8px!important;
          line-height: 1.777!important;
          vertical-align: top!important;
          border-top: 0px !important;
     }
     .tblBasicDetails span{
          line-height: 32px;
          font-size: 18px;
     }
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="div-col-body col-md-12 col-sm-12 col-xs-12">
               <div class="page">
                    <div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                   aria-hidden="true">×</span></button>
                         <strong>Data updated successfully!</strong>
                    </div>
                    <!-- tab -->
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">

                         <ul id="myTab" class="nav nav-tabs bar_tabs no-print" role="tablist" style="background: none;">
                              <li role="presentation" class="active">
                                   <a href="#eval-report_1-tab" role="tab" data-toggle="tab" aria-expanded="true">Evaluation report</a>
                              </li>
                              <?php if (check_permission('evaluation', 'tab_purchasechecklist')) { ?>
                                   <li role="presentation">
                                        <a href="#chklist2tab" role="tab" data-toggle="tab" aria-expanded="true">Purchase Check List</a>
                                   </li>
                              <?php } if (check_permission('evaluation', 'tab_refurbreq')) { ?>
                                   <li role="presentation">
                                        <a href="#refurbisheReq" role="tab" data-toggle="tab" aria-expanded="true">Refurbishment Request</a>
                                   </li>
                              <?php }if (check_permission('evaluation', 'tab_offer_price')) { ?>
                                   <li role="presentation">
                                        <a href="#offerPrice" role="tab" data-toggle="tab" aria-expanded="true">Offer price</a>
                                   </li>
                              <?php } ?>
                              <li role="presentation">
                                   <a href="#booking_sts_tab" role="tab" data-toggle="tab" aria-expanded="true">Booking status</a>
                              </li>
                         </ul>

                         <!-- tab content -->
                         <div id="myTabContent" class="tab-content">

                              <!-- 1st tab content -->
                              <div role="tabpanel" class="tab-pane fade active in" id="eval-report_1-tab" aria-labelledby="eval-report_1-tab">
                                   <div class="x_title">
                                        <h2>Evaluation report</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                             <li class="dropdown" style="float: right;">
                                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                       <i class="fa fa-wrench"></i>
                                                  </a>
                                                  <?php if (check_permission('evaluation', 'update')) { ?>
                                                       <ul class="dropdown-menu" role="menu">
                                                            <li><a target="blank" href="<?php echo site_url('evaluation/view/' . encryptor($vehicles['val_id'])); ?>">Edit</a>
                                                            </li>
                                                       </ul>
                                                  <?php } ?>
                                             </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                   </div>
                                   <div class="x_content">
                                        <div class="subpage">
                                             <div style="width:50%;float: left;">
                                                  <div style="display:none;" class="mySpriteSpin" id='mySpriteSpin'></div>
                                                  <div style="display:none;margin:0 auto;" class="html5gallery" data-skin="gallery" data-width="480" 
                                                       data-height="272" data-resizemode="fill" data-thumbshowtitle="false" data-responsive="true">
                                                            <?php
                                                            foreach ($vehicles['valVehImages'] as $key => $value) {
                                                                 $img = isset($value['vvi_image']) ? $value['vvi_image'] : '';
                                                                 if (!empty($img)) {
                                                                      ?>
                                                                 <a href="<?php echo '../../assets/uploads/evaluation/vehicle/' . $img; ?>">
                                                                      <img src="<?php echo '../../assets/uploads/evaluation/vehicle/' . $img; ?>">
                                                                 </a>
                                                                 <?php
                                                            }
                                                       }
                                                       ?>
                                                  </div>
                                             </div>

                                             <div style="width:50%;float: right;">
                                                  <table style="width:90%;margin-left: 30px;" class="tblBasicDetails">
                                                       <tr>
                                                            <td><span>Stock Status</span></td>
                                                            <td></td>
                                                       </tr>
                                                       <tr>
                                                            <td><span>Stock Location</span></td>
                                                            <td></td>
                                                       </tr>
                                                       <tr>
                                                            <td colspan="2">
                                                                 <h1 style="font-size:18px;">
                                                                      <b>
                                                                           <?php
                                                                           echo $vehicles['brd_title'] . ', ' . $vehicles['mod_title'] . ', ' . $vehicles['var_variant_name'];
                                                                           ?>
                                                                      </b>
                                                                 </h1>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td><span>Registration</span></td>
                                                            <td style="text-align:right;"><span><?php echo $vehicles['val_veh_no']; ?></span></td>
                                                       </tr>
                                                       <tr>
                                                            <td><span>Model Year</span></td>
                                                            <td style="text-align:right;">
                                                                 <span>
                                                                      <?php echo $vehicles['val_model_year']; ?>
                                                                 </span>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td><span>Minif Year</span></td>
                                                            <td style="text-align:right;"><span><?php echo $vehicles['val_minif_year']; ?></span></td>
                                                       </tr>
                                                       <tr>
                                                            <td><span>kilometers</span></td>
                                                            <td style="text-align:right;"><span><?php echo $vehicles['val_km']; ?></span></td>
                                                       </tr>
                                                       <tr>
                                                            <td><span>Fuel</span></td>
                                                            <td style="text-align:right;">
                                                                 <span>
                                                                      <?php
                                                                      $fuel = unserialize(FUAL);
                                                                      echo $fuel[$vehicles['val_fuel']];
                                                                      ?>
                                                                 </span>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td><span>Transmission</span></td>
                                                            <td style="text-align:right;">
                                                                 <span>
                                                                      <?php
                                                                      if ($vehicles['val_transmission'] == 1) {
                                                                           echo 'M/T';
                                                                      } else if ($vehicles['val_transmission'] == 2) {
                                                                           echo 'A/T';
                                                                      } else if ($vehicles['val_transmission'] == 3) {
                                                                           echo 'S/T';
                                                                      }
                                                                      ?>
                                                                 </span>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td><span>NO Of Owners</span></td>
                                                            <td style="text-align:right;"><span><?php echo $vehicles['val_no_of_owner']; ?></span></td>
                                                       </tr>
                                                       <tr>
                                                            <td><span>Colour</span></td>
                                                            <td style="text-align:right;"><span><?php echo $vehicles['val_color']; ?></span></td>
                                                       </tr>
                                                       <tr>
                                                            <td><span>Type Of Vehicle</span></td>
                                                            <td style="text-align:right;">
                                                                 <span>
                                                                      <?php
                                                                      $vehicleType = unserialize(ENQ_VEHICLE_TYPES);
                                                                      echo isset($vehicleType[$vehicles['val_veh_type']]) ?
                                                                              $vehicleType[$vehicles['val_veh_type']] : '';
                                                                      ?>
                                                                 </span>
                                                            </td>
                                                       </tr>
                                                  </table>
                                             </div>

                                             <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="6" style="text-align: center;">Vehicle Evaluation Sheet
                                                            </th>
                                                       </tr>
                                                       <tr>
                                                            <th>Division</th>
                                                            <th><?php echo $vehicles['div_name']; ?></th>
                                                            <th>Branch</th>
                                                            <th><?php echo $vehicles['shr_location']; ?></th>
                                                            <th>Date</th>
                                                            <th><?php echo date('d-m-Y', strtotime($vehicles['val_added_date'])); ?>
                                                            </th>
                                                       </tr>
                                                  </thead>
                                                  <?php if (check_permission('evaluation', 'showplacetimerefer') || is_roo_user() || ($vehicles['val_added_by'] == $this->uid)) { ?>
                                                       <tbody>
                                                            <tr>
                                                                 <td>Purchase type</td>
                                                                 <td>
                                                                      <?php
                                                                      $purchaseTypes = unserialize(EVALUATION_TYPES);
                                                                      echo isset($purchaseTypes[$vehicles['val_type']]) ? $purchaseTypes[$vehicles['val_type']] : '';
                                                                      ?>
                                                                 </td>
                                                                 <td>Referral</td>
                                                                 <td>
                                                                      <?php
                                                                      echo ($vehicles['val_cust_source'] == 10 ||
                                                                      $vehicles['val_cust_source'] == 11 ||
                                                                      $vehicles['val_cust_source'] == 12 ||
                                                                      $vehicles['val_cust_source'] == 13) ? 'YES' : 'NO';
                                                                      ?>
                                                                 </td>
                                                                 <td>Refferal type</td>
                                                                 <td>
                                                                      <?php
                                                                      if ($vehicles['val_refferal_type'] == 1) {
                                                                           echo 'Staff';
                                                                      } else if ($vehicles['val_refferal_type'] == 2) {
                                                                           echo 'Sales staff';
                                                                      } else if ($vehicles['val_refferal_type'] == 3) {
                                                                           echo 'Broker';
                                                                      } else if ($vehicles['val_refferal_type'] == 4) {
                                                                           echo 'NVS';
                                                                      } else if ($vehicles['val_refferal_type'] == 5) {
                                                                           echo 'MGMT';
                                                                      }
                                                                      ?>
                                                                 </td>
                                                            </tr>
                                                            <tr>
                                                                 <td>Refferer Name</td>
                                                                 <td><?php echo $vehicles['val_refferer_name']; ?></td>
                                                                 <td>Evaluator</td>
                                                                 <td><?php echo $vehicles['evtr_first_name'] . ' ' . $vehicles['evtr_last_name']; ?>
                                                                 </td>
                                                                 <td>Executive</td>
                                                                 <td><?php echo $vehicles['so_usr_username']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                 <td>Evaluation location</td>
                                                                 <td><?php echo $vehicles['val_location']; ?></td>
                                                                 <td>In time</td>
                                                                 <td><?php echo $vehicles['val_in_time']; ?></td>
                                                                 <td>Out time</td>
                                                                 <td><?php echo $vehicles['val_out_time']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                 <td>Customer name</td>
                                                                 <td><?php echo $vehicles['val_cust_name']; ?></td>
                                                                 <td>Customer source</td>
                                                                 <td>
                                                                      <?php
                                                                      $modofcontact = unserialize(MODE_OF_CONTACT);
                                                                      echo isset($modofcontact[$vehicles['val_cust_source']]) ?
                                                                              $modofcontact[$vehicles['val_cust_source']] : '';
                                                                      ?>
                                                                 </td>
                                                                 <td>Phone number</td>
                                                                 <td><?php echo $vehicles['val_cust_phone']; ?></td>
                                                            </tr>
                                                       </tbody>
                                                  <?php } ?>
                                             </table>

                                             <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="6" style="text-align: center;">Vehicle Details</th>
                                                       </tr>
                                                       <tr>
                                                            <th>Reg: NO</th>
                                                            <th><?php echo strtoupper($vehicles['val_veh_no']); ?></th>
                                                            <th>Make</th>
                                                            <th><?php echo $vehicles['brd_title']; ?></th>
                                                            <th>Model variant</th>
                                                            <th><?php echo $vehicles['mod_title'] . ' ' . $vehicles['var_variant_name']; ?>
                                                            </th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td>Model code</td>
                                                            <td>Newfield</td>
                                                            <td>First Delivery Date</td>
                                                            <td><?php echo!empty($vehicles['val_delv_date']) ? date('d-m-Y', strtotime($vehicles['val_delv_date'])) : ''; ?>
                                                            </td>
                                                            <td>Delivery Location</td>
                                                            <td><?php echo $vehicles['val_first_dlvry_location']; ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Delivery State</td>
                                                            <td><?php echo $vehicles['val_first_dlvry_state']; ?></td>
                                                            <td>Dealership</td>
                                                            <td><?php echo $vehicles['val_first_dlvry_dlrship']; ?></td>
                                                            <td>1ST Reg Date</td>
                                                            <td><?php echo!empty($vehicles['val_reg_date']) ? date('d-m-Y', strtotime($vehicles['val_reg_date'])) : ''; ?>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>No Of owners</td>
                                                            <td><?php echo $vehicles['val_no_of_owner']; ?></td>
                                                            <td>Vehicle type</td>
                                                            <td>
                                                                 <?php
                                                                 $vehicleType = unserialize(ENQ_VEHICLE_TYPES);
                                                                 echo isset($vehicleType[$vehicles['val_veh_type']]) ?
                                                                         $vehicleType[$vehicles['val_veh_type']] : '';
                                                                 ?>
                                                            </td>
                                                            <td>No Of seats</td>
                                                            <td><?php echo $vehicles['val_no_of_seats']; ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Eng CC</td>
                                                            <td><?php echo $vehicles['val_eng_cc']; ?></td>
                                                            <td>Color</td>
                                                            <td><?php echo $vehicles['val_color']; ?></td>
                                                            <td>KM</td>
                                                            <td><?php echo $vehicles['val_km']; ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Model year</td>
                                                            <td><?php echo $vehicles['val_model_year']; ?></td>
                                                            <td>Manf. Year</td>
                                                            <td><?php echo $vehicles['val_minif_year']; ?></td>
                                                            <td>Fuel</td>
                                                            <td>
                                                                 <?php
                                                                 $fuel = unserialize(FUAL);
                                                                 echo $fuel[$vehicles['val_fuel']];
                                                                 ?>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>Transmission</td>
                                                            <td>
                                                                 <?php
                                                                 if ($vehicles['val_transmission'] == 1) {
                                                                      echo 'M/T';
                                                                 } else if ($vehicles['val_transmission'] == 2) {
                                                                      echo 'A/T';
                                                                 } else if ($vehicles['val_transmission'] == 3) {
                                                                      echo 'S/T';
                                                                 }
                                                                 ?>
                                                            </td>
                                                            <td>A/C</td>
                                                            <td>
                                                                 <?php
                                                                 if ($vehicles['val_ac'] == 1) {
                                                                      echo 'W/o';
                                                                 } else if ($vehicles['val_ac'] == 2) {
                                                                      echo 'Single';
                                                                 } else if ($vehicles['val_ac'] == 3) {
                                                                      echo 'Dual';
                                                                 } else if ($vehicles['val_ac'] == 4) {
                                                                      echo 'Multi';
                                                                 }
                                                                 ?>
                                                            </td>
                                                            <td>No Of A/c Zone</td>
                                                            <td> <?php echo $vehicles['val_ac_zone']; ?> </td>
                                                       </tr>
                                                       <tr>
                                                            <td>Engine number</td>
                                                            <td> <?php echo $vehicles['val_engine_no']; ?> </td>
                                                            <td>Chasis number</td>
                                                            <td> <?php echo $vehicles['val_chasis_no']; ?> </td>
                                                            <td>RC owner</td>
                                                            <td><?php echo $vehicles['val_rc_owner']; ?> </td>
                                                       </tr>
                                                  </tbody>
                                             </table>

                                             <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="3" style="text-align: center;">Insurance</th>
                                                            <th colspan="1" style="text-align: center;">Insurance Company</th>
                                                            <th colspan="3" style="text-align: center;">
                                                                 <?php echo $vehicles['val_insurance_company']; ?></th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td>Comprehensive</td>
                                                            <td>Valid up to</td>
                                                            <td><?php echo!empty($vehicles['val_insurance_comp_date']) ? date('d-m-Y', strtotime($vehicles['val_insurance_comp_date'])) : ''; ?></td>
                                                            <td>IDV</td>
                                                            <td><?php echo $vehicles['val_insurance_comp_idv']; ?></td>
                                                            <td>NCB%</td>
                                                            <td><?php echo $vehicles['val_insurance_ll_idv']; ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Third Party</td>
                                                            <td>Valid up to</td>
                                                            <td><?php echo!empty($vehicles['val_insurance_ll_date']) ? date('d-m-Y', strtotime($vehicles['val_insurance_ll_date'])) : ''; ?></td>
                                                            <td>Insurance Type</td>
                                                            <td>
                                                                 <?php
                                                                 $insType = unserialize(INSURANCE_TYPES);
                                                                 echo @$insType[$vehicles['val_insurance']];
                                                                 ?>
                                                            </td>
                                                            <td>NCB Required</td>
                                                            <td><?php echo ($vehicles['val_insurance_need_ncb'] == 1) ? 'YES' : 'NO'; ?></td>
                                                       </tr>
                                                  </tbody>
                                             </table>

                                             <?php if (($vehicles['val_finance'] == 1) || ($vehicles['val_hypo_close_by_cust'] == 1)) { ?>
                                                  <table class="table table-striped">
                                                       <thead>
                                                            <tr>
                                                                 <th colspan="2" style="text-align: center;">Hypothecation Details</th>
                                                                 <th colspan="4" style="text-align: center;">Finance Company :
                                                                      <?php echo $vehicles['bnk_name']; ?></th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <tr>
                                                                 <td>Hypothecation Closed by</td>
                                                                 <td>
                                                                      <?php
                                                                      if ($vehicles['val_finance'] == 1) {
                                                                           echo 'RD';
                                                                      } else if ($vehicles['val_hypo_close_by_cust'] == 1) {
                                                                           echo 'Customer';
                                                                      }
                                                                      ?>
                                                                 </td>
                                                                 <td>Bank Branch</td>
                                                                 <td><?php echo $vehicles['val_hypo_bank_branch']; ?></td>
                                                                 <td>Loan Amount</td>
                                                                 <td><?php echo $vehicles['val_hypo_loan_amt']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                 <td>Loan Starting Date</td>
                                                                 <td><?php echo!empty($vehicles['val_hypo_loan_date']) ? date('d-m-Y', strtotime($vehicles['val_hypo_loan_date'])) : ''; ?>
                                                                 </td>
                                                                 <td>Foreclosure value</td>
                                                                 <td><?php echo $vehicles['val_hypo_frclos_val']; ?></td>
                                                                 <td>Foreclosure Date</td>
                                                                 <td><?php echo!empty($vehicles['val_hypo_frclos_date']) ? date('d-m-Y', strtotime($vehicles['val_hypo_frclos_date'])) : ''; ?>
                                                                 </td>
                                                            </tr>
                                                            <tr>
                                                                 <td>Loan Ending Date</td>
                                                                 <td><?php echo!empty($vehicles['val_hypo_loan_end_date']) ? date('d-m-Y', strtotime($vehicles['val_hypo_loan_end_date'])) : ''; ?>
                                                                 </td>
                                                                 <td>Daily Interest</td>
                                                                 <td><?php echo $vehicles['val_hypo_daily_int']; ?></td>
                                                                 <td>Any Top up Loan</td>
                                                                 <td><?php echo ($vehicles['val_top_up_loan'] == 1) ? 'Yes' : 'No'; ?>
                                                                 </td>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                             <?php } ?>

                                             <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="6" style="text-align: center;">Features & Loadings</th>
                                                       </tr>
                                                  </thead>

                                                  <tbody>
                                                       <tr>
                                                            <td>No Of Airbag</td>
                                                            <td><?php echo $vehicles['val_air_bags']; ?></td>
                                                            <td>No Of Exhaust</td>
                                                            <td><?php echo $vehicles['val_exhaust']; ?></td>
                                                            <td>No Of Power Window</td>
                                                            <td><?php echo $vehicles['val_no_of_pw']; ?></td>
                                                       </tr>
                                                       <?php if (!empty($vehicles['features'])) { ?>
                                                            <tr>
                                                                 <td colspan="6">
                                                                      <?php echo 'Features : ' . implode(', ', array_column($vehicles['features'], 'vftr_feature')); ?>
                                                                 </td>
                                                            </tr>
                                                            <?php
                                                       }
                                                       if (!empty($vehicles['featuresLoadings'])) {
                                                            ?>
                                                            <tr>
                                                                 <td colspan="6">
                                                                      <?php echo 'Loadings : ' . implode(', ', array_column($vehicles['featuresLoadings'], 'vftr_feature')); ?>
                                                                 </td>
                                                            </tr>
                                                       <?php } ?>
                                                  </tbody>
                                             </table>

                                             <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="8" style="text-align: center;">VEHICLE EVALUATION DETAILS
                                                            </th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <?php
                                                       foreach ($vehicles['bdChkup'] as $bchkey => $bchvalue) {
                                                            echo ($bchkey != 0 && $bchkey % 4 == 0) ? '</tr>' : '';
                                                            echo ($bchkey == 0 || $bchkey % 4 == 0) ? '<tr>' : '';
                                                            ?>
                                                       <td><?php echo $bchvalue['vfbcm_title']; ?></td>
                                                       <td><?php echo $bchvalue['vfbcd_title']; ?></td>
                                                       <?php
                                                       echo ($bchkey == (count($vehicles['bdChkup']) - 1)) ? '</tr>' : '';
                                                  }
                                                  ?>
                                                  </tbody>
                                             </table>

                                             <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="8" style="text-align: center;">Warranty and Service History
                                                            </th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td>Warranty</td>
                                                            <td><?php echo ($vehicles['val_wrnty'] == 1) ? 'Valid' : 'Not Valid'; ?>
                                                            </td>
                                                            <td>Valid Up to</td>
                                                            <td><?php echo!empty($vehicles['val_wrnty_validity']) ? date('d-m-Y', strtotime($vehicles['val_wrnty_validity'])) : 'NA'; ?>
                                                            </td>
                                                            <td>Last Service Date</td>
                                                            <td><?php echo!empty($vehicles['val_last_service']) ? date('d-m-Y', strtotime($vehicles['val_last_service'])) : 'NA'; ?>
                                                            </td>
                                                            <td>KM</td>
                                                            <td><?php echo $vehicles['val_last_service_km'] ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Extra Warranty</td>
                                                            <td><?php echo ($vehicles['val_wrnty_extra'] == 1) ? 'Valid' : 'Not Valid'; ?>
                                                            </td>
                                                            <td>Valid Up to</td>
                                                            <td><?php echo!empty($vehicles['val_ex_wrnty_validity']) ? date('d-m-Y', strtotime($vehicles['val_ex_wrnty_validity'])) : 'NA'; ?>
                                                            </td>
                                                            <td>Service Req A.O.D</td>
                                                            <td><?php echo $vehicles['val_wrnty_service_req_aod']; ?></td>
                                                            <td>Serv A.O.D</td>
                                                            <td><?php echo $vehicles['val_wrnty_act_serv_aod'] ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Spl Ser Observations</td>
                                                            <td colspan="7"><?php echo $vehicles['val_wrnty_spl_ser_observ']; ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Next service date/KM</td>
                                                            <td colspan="7">
                                                                 <?php
                                                                 $nextServiceDate = !empty($vehicles['val_next_serv_date']) ? date('d-m-Y', strtotime($vehicles['val_next_serv_date'])) . ' / ' : '';
                                                                 echo $nextServiceDate . $vehicles['val_next_serv_km'] . ' KM';
                                                                 ?>
                                                            </td>
                                                       </tr>
                                                       <?php if (!empty($vehicles['val_acc_history_remarks'])) { ?>
                                                            <tr>
                                                                 <td>Accident History</td>
                                                                 <td colspan="7"><?php echo $vehicles['val_acc_history_remarks']; ?></td>
                                                            </tr>
                                                            <?php
                                                       }
                                                       if (!empty($vehicles['val_wrnty_ser_remarks'])) {
                                                            ?>
                                                            <tr>
                                                                 <td>Warranty service remarks</td>
                                                                 <td colspan="7"><?php echo $vehicles['val_wrnty_ser_remarks']; ?></td>
                                                            </tr>
                                                            <?php
                                                       }
                                                       if (!empty($vehicles['val_adj_cond'])) {
                                                            ?>
                                                            <tr>
                                                                 <td>Adj For Condition</td>
                                                                 <td colspan="7"><?php echo $vehicles['val_adj_cond']; ?></td>
                                                            </tr>
                                                            <?php
                                                       }
                                                       if (check_permission('evaluation', 'updatedocumentdetails') && !empty($vehicles['val_document_details'])) {
                                                            ?>
                                                            <tr>
                                                                 <td>Document details</td>
                                                                 <td colspan="7"><?php echo $vehicles['val_document_details']; ?></td>
                                                            </tr>
                                                       <?php } ?>
                                                  </tbody>
                                             </table>
                                        </div>

                                        <div class="subpage">
                                             <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="2" style="text-align: center;">Pillar</th>
                                                            <th colspan="2" style="text-align: center;">Glass</th>
                                                            <th colspan="2" style="text-align: center;">Tire</th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td>FR</td>
                                                            <td><?php echo $vehicles['val_pfr']; ?></td>

                                                            <td>Wint sheeld</td>
                                                            <td><?php echo $vehicles['val_gws']; ?></td>

                                                            <td>FR</td>
                                                            <td>
                                                                 <?php echo $vehicles['val_tyre_2_wek']; ?>
                                                                 <?php echo $vehicles['val_tyre_2_yer']; ?>
                                                                 <?php echo $vehicles['val_tyre_2']; ?>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>FL</td>
                                                            <td><?php echo $vehicles['val_pfl']; ?></td>

                                                            <td>Rear Glass</td>
                                                            <td><?php echo $vehicles['val_grg']; ?></td>

                                                            <td>FL</td>
                                                            <td>
                                                                 <?php echo $vehicles['val_tyre_1_wek']; ?>
                                                                 <?php echo $vehicles['val_tyre_1_yer']; ?>
                                                                 <?php echo $vehicles['val_tyre_1']; ?>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>CR</td>
                                                            <td><?php echo $vehicles['val_pcr']; ?></td>

                                                            <td>Door Glass R</td>
                                                            <td><?php echo $vehicles['val_gdgr']; ?></td>

                                                            <td>RR</td>
                                                            <td>
                                                                 <?php echo $vehicles['val_tyre_4_wek']; ?>
                                                                 <?php echo $vehicles['val_tyre_4_yer']; ?>
                                                                 <?php echo $vehicles['val_tyre_4']; ?>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>CL</td>
                                                            <td><?php echo $vehicles['val_pcl']; ?></td>

                                                            <td>Door Glass LS</td>
                                                            <td><?php echo $vehicles['val_gdgls']; ?></td>

                                                            <td>RL</td>
                                                            <td>
                                                                 <?php echo $vehicles['val_tyre_3_wek']; ?>
                                                                 <?php echo $vehicles['val_tyre_3_yer']; ?>
                                                                 <?php echo $vehicles['val_tyre_3']; ?>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>RR</td>
                                                            <td><?php echo $vehicles['val_prr']; ?></td>

                                                            <td>Q Glass R</td>
                                                            <td><?php echo $vehicles['val_qgr']; ?></td>

                                                            <td>Spare</td>
                                                            <td>
                                                                 <?php echo $vehicles['val_tyre_5_wek']; ?>
                                                                 <?php echo $vehicles['val_tyre_5_yer']; ?>
                                                                 <?php echo $vehicles['val_tyre_5']; ?>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>RL</td>
                                                            <td><?php echo $vehicles['val_prl']; ?></td>

                                                            <td>Q Glass L</td>
                                                            <td><?php echo $vehicles['val_qgi']; ?></td>

                                                            <td>Space savor</td>
                                                            <td>
                                                                 <?php echo $vehicles['val_tyre_6_wek']; ?>
                                                                 <?php echo $vehicles['val_tyre_6_yer']; ?>
                                                                 <?php echo $vehicles['val_tyre_6']; ?>
                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>

                                             <table class="table table-striped">
                                                  <tbody>
                                                       <tr>
                                                            <td colspan="2" style="text-align: center;">Battery</td>
                                                            <td colspan="2" style="text-align: center;">Make</td>
                                                            <td colspan="2" style="text-align: center;">
                                                                 <?php echo $vehicles['val_battery_make']; ?></td>
                                                            <td colspan="2" style="text-align: center;">Year</td>
                                                            <td colspan="2" style="text-align: center;">
                                                                 <?php echo $vehicles['val_battery_year']; ?></td>
                                                            <td colspan="2" style="text-align: center;">Warranty</td>
                                                            <td colspan="2" style="text-align: center;">
                                                                 <?php echo ($vehicles['val_battery_warranty'] == 1) ? 'YES' : 'NO'; ?>
                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                             <!-- -->
                                             <div>
                                                  <span style="margin-top: 20px;width: 100%;float: left;">Structural Hits and
                                                       Damages</span>
                                                  <img src="images/hit-damage.png" />
                                             </div>
                                             <!-- -->
                                             <?php if (check_permission('evaluation', 'showrefurbdetails') || is_roo_user() || ($vehicles['val_added_by'] == $this->uid)) { ?>
                                                  <table class="table table-striped">
                                                       <thead>
                                                            <tr>
                                                                 <th colspan="2" style="text-align: center;">Refurbishment Details</th>
                                                            </tr>
                                                            <tr>
                                                                 <th>Job details</th>
                                                                 <th>Amount</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php foreach ($vehicles['upgradeDetails'] as $key => $value) { ?>
                                                                 <tr>
                                                                      <td><?php echo $value['upgrd_key']; ?></td>
                                                                      <td><?php
                                                                           if (isset($datas['upgrd_value'])) {
                                                                                echo number_format($value['upgrd_value'], 2);
                                                                           }
                                                                           ?>
                                                                      </td>
                                                                 </tr>
                                                            <?php } ?>
                                                       </tbody>
                                                  </table>
                                                  <table class="table table-striped">
                                                       <thead>
                                                            <tr>
                                                                 <th colspan="6" style="text-align: center;">Refurbishment Job did</th>
                                                            </tr>
                                                            <tr>
                                                                 <th>SL NO</th>
                                                                 <th>Refurbish job in evaluation</th>
                                                                 <th>Estimated cost</th>
                                                                 <th>Actual job description</th>
                                                                 <th>Actual cost</th>
                                                                 <th>Description</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php
                                                            if (!empty($vehicles['upgradeDetails'])) {
                                                                 foreach ($vehicles['upgradeDetails'] as $key => $value) {
                                                                      ?>
                                                                      <tr>
                                                                           <td><?php echo $key + 1; ?></td>
                                                                           <td><?php echo $value['upgrd_key']; ?></td>
                                                                           <td><?php echo $value['upgrd_value']; ?></td>
                                                                           <td><?php echo @$value['upgrd_refurb_actual_job'] ?></td>
                                                                           <td><?php echo $value['upgrd_refurb_actual_cost'] ?></td>
                                                                           <td><?php echo $value['upgrd_refurb_remarks'] ?></td>
                                                                      </tr>
                                                                      <?php
                                                                 }
                                                            }
                                                            ?>
                                                            <tr>
                                                                 <th colspan="6">Refurb job did :
                                                                      <?php echo $vehicles['val_rfresh_job_did']; ?></th>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                             <?php } ?>
                                             <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="2" style="text-align: center;">Refurbishment Details</th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td>Suspected purchase price</td>
                                                            <td><?php echo $vehicles['val_suspt_purchase_price']; ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>New Vehicle Price</td>
                                                            <td><?php echo $vehicles['val_new_vehicle_price']; ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Best Market sale Price</td>
                                                            <td><?php echo $vehicles['val_price_market_est']; ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Refreshment Cost</td>
                                                            <td><?php echo $vehicles['val_refurb_cost']; ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Adj For Condition +/-</td>
                                                            <td><?php echo $vehicles['val_adj_ond_pm']; ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Profit</td>
                                                            <td><?php echo $vehicles['val_profit']; ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Trade in Price</td>
                                                            <td><?php echo $vehicles['val_trade_in_price']; ?></td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                             <!-- -->

                                             <?php if (!empty(array_filter($vehicles['valVehImages']))) { ?>
                                                  <div style="margin-top: 300px;">
                                                       <h3>Vehicle images</h3>
                                                       <div class="row">
                                                            <?php
                                                            foreach ($vehicles['valVehImages'] as $key => $value) {
                                                                 $img = isset($value['vvi_image']) ? $value['vvi_image'] : '';
                                                                 if (!empty($img)) {
                                                                      ?>
                                                                      <div style="float: left;padding: 10px;">
                                                                           <?php echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "320", 'height' => "260")); ?>
                                                                      </div>
                                                                      <?php
                                                                 }
                                                            }
                                                            ?>
                                                       </div>
                                                  </div>
                                             <?php } if (!empty($vehicles['complaints'])) { ?>
                                                  <div style="margin-top: 300px;">
                                                       <h3>Structural Hits and Damages</h3>
                                                       <div class="row">
                                                            <?php
                                                            foreach ($vehicles['complaints'] as $key => $value) {
                                                                 $img = isset($value['comp_pic']) ? $value['comp_pic'] : '';
                                                                 if (!empty($img)) {
                                                                      ?>
                                                                      <div class="gallery">
                                                                           <a target="_blank" href="<?php echo '../../assets/uploads/evaluation/' . $img; ?>">
                                                                                <?php echo img(array('src' => '../assets/uploads/evaluation/' . $img, 'width' => "200", 'height' => "200", 'width' => '600', 'height' => '400')); ?>
                                                                           </a>
                                                                           <div class="desc"><?php echo $value['comp_complaint']; ?></div>
                                                                      </div>
                                                                      <?php
                                                                 }
                                                            }
                                                            ?>
                                                       </div>
                                                  </div>
                                             <?php } ?>
                                        </div>
                                   </div>
                              </div>

                              <!-- @end 1st tab content -->

                              <!-- 2nd tab content -->
                              <div role="tabpanel" class="tab-pane fade" id="chklist2tab" aria-labelledby="chk-list_2-tab">
                                   <?= $prchs_chk_list_vw ?>
                              </div>
                              <!-- @end 2nd tab content -->

                              <!-- 3rd tab content -->
                              <div role="tabpanel" class="tab-pane fade" id="refurbisheReq" aria-labelledby="refurbisheReq">
                                   <div class="page" id="printRefrb">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                             <div class="x_panel">
                                                  <button type="submit" class="btn btn-info no-print" id="printBtn_rfrb"><i class="fa fa-print" style="color:white"></i> Print</button>
                                                  <a href="<?php echo site_url('evaluation/refurbisheReturn/' . encryptor($vehicles["val_id"])) ?>" 
                                                     class="btn btn-info no-print refurbRetBtnk" id="edit_btn" style="float: right;"><i class="fa fa-edit" style="color:White"></i> Edit</a>
                                                  <div class="x_content">
                                                       <div class="chk-container" style="float: right;width: 100%;">
                                                            <h3 class="border-bottom border-gray pb-2 text-center">
                                                                 Refurbishment
                                                            </h3>

                                                            <div class="row">
                                                                 <?php $description = isset($result['masterData']['pcl_description']) ? json_decode($result['masterData']['pcl_description']) : ''; ?>
                                                                 <!-- table one -->
                                                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                                                      <table class="toptable table table-stripedk table-borderedj">
                                                                           <tbody>
                                                                                <tr class="top-tbl-tr">
                                                                                     <td><b>Vehicle Registration NO :</b>  <?php echo strtoupper($vehicles['val_veh_no']); ?></td>
                                                                                     <td><b>Vehicle Make & Model :</b> <?php echo $vehicles['brd_title'] . ', ' . $vehicles['mod_title'] . ', ' . $vehicles['var_variant_name']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                     <td><b>Date of Evaluation :</b> <?php echo date('d-m-Y', strtotime($vehicles['val_added_date'])); ?></td>
                                                                                     <td><b>Purchase Executive :</b> 
                                                                                          <?php
                                                                                          $purchaseTypes = unserialize(EVALUATION_TYPES);
                                                                                          echo isset($purchaseTypes[$vehicles['val_type']]) ? $purchaseTypes[$vehicles['val_type']] : '';
                                                                                          ?>
                                                                                     </td>
                                                                                </tr>
                                                                                <tr>
                                                                                     <td><b>Evaluator :</b> <?php echo isset($vehicles['usr_username']) ? $vehicles['usr_username'] : ''; ?></td>
                                                                                     <td><b>Approver </b> :</td>
                                                                                </tr>
                                                                                <tr>
                                                                                     <td><b>Date of Stocking :</b> <?php echo ($stk_added_date != '') ? date('d-m-Y', strtotime($stk_added_date)) : ''; ?></td>
                                                                                     <td></td>
                                                                                </tr>
                                                                                <tr>
                                                                                     <td><b>Attach the Evaluation Sheet </b> </td>
                                                                                </tr>
                                                                           </tbody>
                                                                      </table>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="row">
                                                  <form action="<?php echo site_url('checklist/add_purchase_check_list'); ?>" 
                                                        method="post" class="x_content frmNewValuation" id="chk_list_form" data-url="<?php echo site_url('evaluation/add_purchase_check_list'); ?>">
                                                       <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                 <table class="tabled table-striped table-bordered refrftable">
                                                                      <tr>
                                                                           <th style="width:3%;">Sl No</th>
                                                                           <th style="width:33%;">Refurbishment Job in Evaluation </th>
                                                                           <th style="width:7%;">Estimated Cost</th>
                                                                           <th style="width:33%;">Actual Job Description </th>
                                                                           <th style="width:7%;">Actual Cost </th>
                                                                           <th>Remark </th>
                                                                      </tr>
                                                                      <?php
                                                                      $slno = 1;
                                                                      if (!empty($refurbDetails)) {
                                                                           foreach ($refurbDetails as $key => $value) {
                                                                                ?>
                                                                                <tr>
                                                                                     <td><?php echo $slno++ ?></td>
                                                                                     <td><?php echo $value->upgrd_key; ?></td>
                                                                                     <td><?php echo get_in_currency_format($value->upgrd_value); ?></td>
                                                                                     <td><?php echo $value->actual_job_description; ?></td>
                                                                                     <td><?php
                                                                                          echo ($value->upgrd_refurb_actual_cost > 0) ?
                                                                                                  get_in_currency_format($value->upgrd_refurb_actual_cost) : '';
                                                                                          ?></td>
                                                                                     <td><?php echo $value->upgrd_refurb_remarks; ?></td>
                                                                                </tr>
                                                                                <?php
                                                                           }
                                                                      }
                                                                      ?>
                                                                 </table>
                                                            </div>
                                                       </div>
                                                  </form>
                                             </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                             <table class="toptable table table-stripedk table-borderedj refrb-bottom-tbl">
                                                  <tbody>
                                                       <tr class="top-tbl-tr">
                                                            <td><h5>Request By</h5> </td>
                                                            <td><h5>Checked BY  ( Delivery Co ordinator)</h5> </td>
                                                            <td><h5>Approved BY - COO/VP/MD</h5> </td>
                                                       </tr>
                                                       <tr>
                                                            <td><b>Name:</b> </td>
                                                            <td><b>Name:</b> </td>
                                                            <td><b>Name:</b> </td>
                                                       </tr>
                                                       <tr>
                                                            <td><b>Sign:</b> </td>
                                                            <td><b>Sign:</b> </td>
                                                            <td><b>Sign:</b> </td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                        </div>
                                   </div>
                              </div>                          
                              <!-- 4th tab content -->

                              <div role="tabpanel" class="tab-pane fade" id="offerPrice" aria-labelledby="offerPrice">
                                   <div class="page" id="printRefrb">
                                        <center><h5 class="titletext"><?php echo strtoupper($vehicles['val_veh_no']); ?> | <?php echo $vehicles['brd_title']; ?>
                                                  <?php echo $vehicles['mod_title'] . ' ' . $vehicles['var_variant_name']; ?></h5></center>  

                                        <br/><br/>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                             <div class="x_panel">
                                                  <?php echo form_open_multipart("evaluation/add_offer_price", array('id' => "frmOfferPrice", 'class' => "frmOfferPrice form-horizontal form-label-left")) ?>

                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Enquriry</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select name="ofrp_enq_id" id="enq_id"  class="select2_group form-control col-md-7 col-xs-12" 
                                                                    data-bind="cmbModel" data-dflt-select="Select Model" required>
                                                                 <option value="">Select Enquiry</option>
                                                                 <?php
                                                                 if (!empty($enquiries)) {
                                                                      foreach ($enquiries as $key => $value) {
                                                                           ?>
                                                                           <option value="<?php echo $value['enq_id']; ?>"><?php echo $value['enq_cus_name'] . '-' . $value['enq_cus_mobile']; ?></option>
                                                                           <?php
                                                                      }
                                                                 }
                                                                 ?>
                                                            </select>
                                                       </div>

                                                  </div>
                                                  <input type="hidden" name='ofrp_val_id' value="<?php echo $vehicles['val_id']; ?>">
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Offer price</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" name="ofrp_price"  class="form-control col-md-7 col-xs-12 numOnly" required>
                                                       </div>
                                                  </div>
                                                  <div class="form-group">
                                                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                                                       <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea name="ofrp_description" class="form-control col-md-7 col-xs-12 "></textarea>
                                                       </div>
                                                  </div>

                                                  <div class="ln_solid"></div>
                                                  <div class="form-group">
                                                       <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                            <button type="submit" class="btn btn-success">Submit</button>
                                                            <button class="btn btn-primary" type="reset">Reset</button>
                                                       </div>
                                                  </div>
                                                  <?php echo form_close() ?>

                                             </div>
                                        </div>
                                   </div>
                              </div> 
                              <!-- @4th tab -->
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
<script src='https://unpkg.com/spritespin@x.x.x/release/spritespin.js' type='text/javascript'></script>
<script type="text/javascript" src="http://localhost/royalportal/rdportal/assets/scripts/../../../assets/html5gallery/html5gallery.js"></script>
<script>
     $(document).ready(function () {
          $("#printBtn_rfrb").click(function () {
               window.print();
          });
          $(document).on('click', '.html5gallery-car-mask-0', function () {
               $('.html5gallery-elem-0').show();
               $('#mySpriteSpin').hide();
               $('.html5gallery-title-text-0').show();
          });
          $('#html5-watermark').hide();
          $('#html5-title').hide();
     });
     $('.360img').click(function (e) {
          $('.html5gallery-elem-0').hide();
          $('#mySpriteSpin').show();
          $('.html5gallery-title-text-0').hide();
     });
</script>
<style>
     @media only screen and (max-width: 600px) {
          .html5gallery-car-0 {
               top: 304px!important;
               zoom: 75%!important;
          }
          .threeSix {
               top: 323px!important;
               left: 400px!important;
               zoom: 75%!important;
          }
     }
     .threeSix {
          margin-left: 3px!important;
          display: block;
          overflow: hidden;
          position: absolute;
          width: 99px;height: 47px;
          top: 456px;left: 662px;
     }
     .mySpriteSpin {
          z-index: 1;top: 2px;
          width: 771px!important;
          height: 436px!important;
          position: absolute!important;
     }
</style>