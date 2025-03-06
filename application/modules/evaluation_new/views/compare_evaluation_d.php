<style>
     .titletext {
          margin-left: 13px;
          margin-top: 8px;
          position: absolute;
          text-decoration: none;
     }
     .page {
          min-height: 29.7cm;
          background: white;
     }

     .subpage {
          height: 292mm;
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

     .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
          padding: 5px !important;
     }

     .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th {
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
<?php
 // print_r($vehicles)
  ?>
<div class="right_col" role="main">
     <div class="row">
          <div class="div-col-body col-md-12 col-sm-12 col-xs-12">
               <div class="page">
                    <div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                         </button>
                         <strong>Data updated successfully!</strong>
                    </div>
                    <!-- tab -->
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">

                         <ul id="myTab" class="nav nav-tabs bar_tabs no-print" role="tablist" style="background: none;">
                              <?php                             foreach ($vehicles as $k=>$value) {?>
                                  
                            
                              <li role="presentation" class="<?php echo $k==0?'active':''?>">
                                   <a href="#tb_<?php echo $value['val_id']; ?>" role="tab" data-toggle="tab" aria-expanded="true"><?php echo $value['usr_username']; ?> - <?php echo strtoupper($value['val_veh_no']); ?> </a>
                              </li>
                              <?php } ?>
<!--                              <li role="presentation">
                                   <a href="#purchase" role="tab" data-toggle="tab" aria-expanded="true">KJJKK</a>
                              </li>
                              <li role="presentation">
                                   <a href="#eval-report_1-tab" role="tab" data-toggle="tab" aria-expanded="true">FGFH</a>
                              </li>
                              <?php if (check_permission('evaluation', 'tab_purchasechecklist')) { ?>
                                   <li role="presentation">
                                        <a href="#chklist2tab" role="tab" data-toggle="tab" aria-expanded="true">HFGHFGH</a>
                                   </li>
                              <?php } if (check_permission('evaluation', 'tab_refurbreq')) { ?>
                                   <li role="presentation">
                                        <a href="#refurbisheReq" role="tab" data-toggle="tab" aria-expanded="true">FGHFGHFGH</a>
                                   </li>
                              <?php }if (check_permission('evaluation', 'tab_offer_price')) { ?>
                                   <li role="presentation">
                                        <a href="#offerPrice" role="tab" data-toggle="tab" aria-expanded="true">FGHFGH</a>
                                   </li>
                              <?php } ?>
                              <li role="presentation">
                                   <a href="#booking_sts_tab" role="tab" data-toggle="tab" aria-expanded="true">HFGHGFEWRT</a>
                              </li>-->
                         </ul>

                         <!-- tab content -->
                         <div id="myTabContent" class="tab-content">
                               <?php  foreach ($vehicles as $key=>$vehicles) {?>
                              <div role="tabpanel" class="tab-pane fade <?php echo $key==0?'active in':''?>" id="tb_<?php echo $vehicles['val_id']; ?>" aria-labelledby="stock">
                              
                                
                              
                                 <div class="x_title">
                                        <h2>Evaluation report (<?php echo $vehicles['usr_username']; ?>)</h2>
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
                                            <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="6" style="text-align: center;">Vehicle Evaluation Sheet</th>
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
                                                            <th>JK-12-SD-21313</th>
                                                            <th>Make</th>
                                                            <th>MG</th>
                                                            <th>Model variant</th>
                                                            <th>Hector                                                             </th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td>Model code</td>
                                                            <td>Newfield</td>
                                                            <td>First Delivery Date</td>
                                                            <td>02-09-2021                                                            </td>
                                                            <td>Delivery Location</td>
                                                            <td></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Delivery State</td>
                                                            <td></td>
                                                            <td>Dealership</td>
                                                            <td></td>
                                                            <td>1ST Reg Date</td>
                                                            <td>02-09-2021                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>No Of owners</td>
                                                            <td>1</td>
                                                            <td>Vehicle type</td>
                                                            <td>
                                                                 Coupe                                                            </td>
                                                            <td>No Of seats</td>
                                                            <td>6</td>
                                                       </tr>
                                                       <tr>
                                                            <td>Eng CC</td>
                                                            <td>4564</td>
                                                            <td>Color</td>
                                                            <td>4</td>
                                                            <td>KM</td>
                                                            <td>246546</td>
                                                       </tr>
                                                       <tr>
                                                            <td>Model year</td>
                                                            <td>2014</td>
                                                            <td>Manf. Year</td>
                                                            <td>2011</td>
                                                            <td>Fuel</td>
                                                            <td>
                                                                 Diesel                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>Transmission</td>
                                                            <td>
                                                                 A/T                                                            </td>
                                                            <td>A/C</td>
                                                            <td>
                                                                 Dual                                                            </td>
                                                            <td>No Of A/c Zone</td>
                                                            <td> 1 </td>
                                                       </tr>
                                                       <tr>
                                                            <td>Engine number</td>
                                                            <td> 456456456 </td>
                                                            <td>Chasis number</td>
                                                            <td> 12312312 </td>
                                                            <td>RC owner</td>
                                                            <td> </td>
                                                       </tr>
                                                  </tbody>
                                             </table>

                                             <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="3" style="text-align: center;">Insurance</th>
                                                            <th colspan="1" style="text-align: center;">Insurance Company</th>
                                                            <th colspan="3" style="text-align: center;">
4645645</th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td>Comprehensive</td>
                                                            <td>Valid up to</td>
                                                            <td>20-09-2002</td>
                                                            <td>IDV</td>
                                                            <td>45645.00</td>
                                                            <td>NCB%</td>
                                                            <td>645645</td>
                                                       </tr>
                                                       <tr>
                                                            <td>Third Party</td>
                                                            <td>Valid up to</td>
                                                            <td>20-09-2002</td>
                                                            <td>Insurance Type</td>
                                                            <td>
                                                                 PLATINUM                                                            </td>
                                                            <td>NCB Required</td>
                                                            <td>YES</td>
                                                       </tr>
                                                  </tbody>
                                             </table>

                                                  <table class="table table-striped">
                                                       <thead>
                                                            <tr>
                                                                 <th colspan="2" style="text-align: center;">Hypothecation Details</th>
                                                                 <th colspan="4" style="text-align: center;">Finance Company :
     ABHYUDAYA COOPERATIVE BANK LIMITED</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <tr>
                                                                 <td>Hypothecation Closed by</td>
                                                                 <td>
                                                                      Customer                                                                 </td>
                                                                 <td>Bank Branch</td>
                                                                 <td>5645645</td>
                                                                 <td>Loan Amount</td>
                                                                 <td>4546645.00</td>
                                                            </tr>
                                                            <tr>
                                                                 <td>Loan Starting Date</td>
                                                                 <td>02-09-2021                                                                 </td>
                                                                 <td>Foreclosure value</td>
                                                                 <td>46456</td>
                                                                 <td>Foreclosure Date</td>
                                                                 <td>02-09-2021                                                                 </td>
                                                            </tr>
                                                            <tr>
                                                                 <td>Loan Ending Date</td>
                                                                 <td>02-09-2021                                                                 </td>
                                                                 <td>Daily Interest</td>
                                                                 <td>0.00</td>
                                                                 <td>Any Top up Loan</td>
                                                                 <td>Yes                                                                 </td>
                                                            </tr>
                                                       </tbody>
                                                  </table>

                                             <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="6" style="text-align: center;">Features & Loadings</th>
                                                       </tr>
                                                  </thead>

                                                  <tbody>
                                                       <tr>
                                                            <td>No Of Airbag</td>
                                                            <td>0</td>
                                                            <td>No Of Exhaust</td>
                                                            <td>0</td>
                                                            <td>No Of Power Window</td>
                                                            <td>0</td>
                                                       </tr>
                                                            <tr>
                                                                 <td colspan="6">
     Features : Virtual Cockpit, DVD, USB, AUX                                                                 </td>
                                                            </tr>
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
                                                            <td>Not Valid                                                            </td>
                                                            <td>Valid Up to</td>
                                                            <td>NA                                                            </td>
                                                            <td>Last Service Date</td>
                                                            <td>NA                                                            </td>
                                                            <td>KM</td>
                                                            <td></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Extra Warranty</td>
                                                            <td>Not Valid                                                            </td>
                                                            <td>Valid Up to</td>
                                                            <td>NA                                                            </td>
                                                            <td>Service Req A.O.D</td>
                                                            <td></td>
                                                            <td>Serv A.O.D</td>
                                                            <td></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Spl Ser Observations</td>
                                                            <td colspan="7"></td>
                                                       </tr>
                                                       <tr>
                                                            <td>Next service date/KM</td>
                                                            <td colspan="7">
                                                                  KM                                                            </td>
                                                       </tr>
                                                            <tr>
                                                                 <td>Adj For Condition</td>
                                                                 <td colspan="7">434</td>
                                                            </tr>
                                                                                                                        <tr>
                                                                 <td>Document details</td>
                                                                 <td colspan="7">432423</td>
                                                            </tr>
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
                                                            <td>232</td>

                                                            <td>Wint sheeld</td>
                                                            <td>324234</td>

                                                            <td>FR</td>
                                                            <td>
                                                                 3424                                                                 434434                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>FL</td>
                                                            <td>3423</td>

                                                            <td>Rear Glass</td>
                                                            <td>23423</td>

                                                            <td>FL</td>
                                                            <td>
                                                                 3434                                                                 4343434                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>CR</td>
                                                            <td>434</td>

                                                            <td>Door Glass R</td>
                                                            <td>423</td>

                                                            <td>RR</td>
                                                            <td>
                                                                 32423                                                                 343434                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>CL</td>
                                                            <td>434</td>

                                                            <td>Door Glass LS</td>
                                                            <td>34343</td>

                                                            <td>RL</td>
                                                            <td>
                                                                 434                                                                 34343434                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>RR</td>
                                                            <td>3434</td>

                                                            <td>Q Glass R</td>
                                                            <td>434</td>

                                                            <td>Spare</td>
                                                            <td>
                                                                 43                                                                 44443                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>RL</td>
                                                            <td>434</td>

                                                            <td>Q Glass L</td>
                                                            <td>33343</td>

                                                            <td>Space savor</td>
                                                            <td>
                                                                 4343                                                                 4344344                                                            </td>
                                                       </tr>
                                                  </tbody>
                                             </table>

                                             <table class="table table-striped">
                                                  <tbody>
                                                       <tr>
                                                            <td colspan="2" style="text-align: center;">Battery</td>
                                                            <td colspan="2" style="text-align: center;">Make</td>
                                                            <td colspan="2" style="text-align: center;">
434</td>
                                                            <td colspan="2" style="text-align: center;">Year</td>
                                                            <td colspan="2" style="text-align: center;">
434</td>
                                                            <td colspan="2" style="text-align: center;">Warranty</td>
                                                            <td colspan="2" style="text-align: center;">
YES                                                            </td>
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
                                                                      <tr>
                                                                      <td></td>
                                                                      <td>                                                                      </td>
                                                                 </tr>
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
                                                                                                                                  <tr>
                                                                           <td>1</td>
                                                                           <td></td>
                                                                           <td></td>
                                                                           <td></td>
                                                                           <td>0.00</td>
                                                                           <td></td>
                                                                      </tr>
                                                                                                                                  <tr>
                                                                 <th colspan="6">Refurb job did :
     42342</th>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                             <table class="table table-striped">
                                                  <thead>
                                                       <tr>
                                                            <th colspan="2" style="text-align: center;">Refurbishment Details</th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <tr>
                                                            <td>Suspected purchase price</td>
                                                            <td>4234.00</td>
                                                       </tr>
                                                       <tr>
                                                            <td>New Vehicle Price</td>
                                                            <td>344.00</td>
                                                       </tr>
                                                       <tr>
                                                            <td>Best Market sale Price</td>
                                                            <td>434</td>
                                                       </tr>
                                                       <tr>
                                                            <td>Refreshment Cost</td>
                                                            <td>434</td>
                                                       </tr>
                                                       <tr>
                                                            <td>Adj For Condition +/-</td>
                                                            <td>4</td>
                                                       </tr>
                                                       <tr>
                                                            <td>Profit</td>
                                                            <td>34344</td>
                                                       </tr>
                                                       <tr>
                                                            <td>Trade in Price</td>
                                                            <td>434</td>
                                                       </tr>
                                                  </tbody>
                                             </table>
                                             <!-- -->

                                        </div>
                                   </div>
                             
                              </div>
                               <?php }?>

                              <!-- 1st tab content -->
                       

                              <!-- @end 1st tab content -->

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