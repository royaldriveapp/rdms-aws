<div class="right_col" role="main">
     <div class="row">
          <div class="div-col-body col-md-12 col-sm-12 col-xs-12">
               <div class="page">
                    <div class="x_title">
                         <h2>Evaluation report</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li class="dropdown" style="float: right;">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <i class="fa fa-wrench"></i>
                                   </a>
                                   <?php if (check_permission('evaluation', 'update')) {?>
                                          <ul class="dropdown-menu" role="menu">
                                               <li><a target="blank" href="<?php echo site_url('evaluation/view/' . encryptor($vehicles['val_id']));?>">Edit</a></li>
                                          </ul>
                                     <?php }?>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         
                              <table class="table table-striped">
                                   <thead>
                                        <tr>
                                             <th colspan="6" style="text-align: center;">Vehicle Evaluation Sheet</th>
                                        </tr>
                                        <tr>
                                             <th>Division</th>
                                             <th></th>
                                             <th>Branch</th>
                                             <th></th>
                                             <th>Date</th>
                                             <th></th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <td>Purchase type</td>
                                             <td></td>
                                             <td>Referral</td>
                                             <td></td>
                                             <td>Refferal type</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Refferer Name</td>
                                             <td></td>
                                             <td>Evaluator</td>
                                             <td></td>
                                             <td>Executive</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Evaluation location</td>
                                             <td></td>
                                             <td>In time</td>
                                             <td></td>
                                             <td>Out time</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Customer name</td>
                                             <td></td>
                                             <td>Customer source</td>
                                             <td></td>
                                             <td>Phone number</td>
                                             <td></td>
                                        </tr>
                                   </tbody>
                              </table>

                              <table class="table table-striped">
                                   <thead>
                                        <tr>
                                             <th colspan="6" style="text-align: center;">Vehicle Details</th>
                                        </tr>
                                        <tr>
                                             <th>Reg: NO</th>
                                             <th></th>
                                             <th>Make</th>
                                             <th></th>
                                             <th>Model variant</th>
                                             <th></th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <td>Model code</td>
                                             <td></td>
                                             <td>First Delivery Date</td>
                                             <td></td>
                                             <td>Delivery Location</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Delivery State</td>
                                             <td></td>
                                             <td>Dealership</td>
                                             <td></td>
                                             <td>1ST Reg Date</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>No Of owners</td>
                                             <td></td>
                                             <td>Vehicle type</td>
                                             <td></td>
                                             <td>No Of seats</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Eng CC</td>
                                             <td></td>
                                             <td>Color</td>
                                             <td></td>
                                             <td>KM</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Model year</td>
                                             <td></td>
                                             <td>Manf. Year</td>
                                             <td></td>
                                             <td>Fuel</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Transmission</td>
                                             <td></td>
                                             <td>A/C</td>
                                             <td></td>
                                             <td>No Of A/c Zone</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Engine number</td>
                                             <td></td>
                                             <td>Chasis number</td>
                                             <td></td>
                                             <td>RC owner</td>
                                             <td></td>
                                        </tr>
                                   </tbody>
                              </table>

                              <table class="table table-striped">
                                   <thead>
                                        <tr>
                                             <th colspan="3" style="text-align: center;">Insurance</th>
                                             <th colspan="1" style="text-align: center;">Insurance Company</th>
                                             <th colspan="3" style="text-align: center;"></th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <td>Comprehensive</td>
                                             <td>Valid up to</td>
                                             <td></td>
                                             <td>IDV</td>
                                             <td></td>
                                             <td>NCB%</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Third Party</td>
                                             <td>Valid up to</td>
                                             <td></td>
                                             <td>Insurance Type</td>
                                             <td></td>
                                             <td>NCB Required</td>
                                             <td></td>
                                        </tr>
                                   </tbody>
                              </table>
                              <table class="table table-striped">
                                   <thead>
                                        <tr>
                                             <th colspan="2" style="text-align: center;">Hypothecation Details</th>
                                             <th colspan="4" style="text-align: center;">Finance Company : </th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <td>Hypothecation Closed by</td>
                                             <td></td>
                                             <td>Bank Branch</td>
                                             <td></td>
                                             <td>Loan Amount</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Loan Starting Date</td>
                                             <td></td>
                                             <td>Foreclosure value</td>
                                             <td></td>
                                             <td>Foreclosure Date</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Loan Ending Date</td>
                                             <td></td>
                                             <td>Daily Interest</td>
                                             <td></td>
                                             <td>Any Top up Loan</td>
                                             <td></td>
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
                                             <td></td>
                                             <td>No Of Exhaust</td>
                                             <td></td>
                                             <td>No Of Power Window</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td colspan="6" style="text-align: justify;line-height: 20px;">Features
                                                  <?php echo 'Features : ' . implode(', ', array_column($vehicleFeatures, 'vftr_feature'));?>
                                             </td>
                                        </tr>
                                        <tr>
                                             <td colspan="6" style="text-align: justify;line-height: 20px;">Loadings
                                                  <?php echo 'Features : ' . implode(', ', array_column($vehicleAddOnFeatures, 'vftr_feature'));?>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>

                              <table class="table table-striped">
                                   <thead>
                                        <tr>
                                             <th colspan="8" style="text-align: center;">VEHICLE EVALUATION DETAILS</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                          foreach ($fullBodyCheckupMaster as $mk => $mstr) {
                                               echo ($mk != 0 && $mk % 4 == 0) ? '</tr>' : '';
                                               echo ($mk == 0 || $mk % 4 == 0) ? '<tr>' : '';
                                               ?>
                                          <td><?php echo $mstr['vfbcm_title'];?></td>
                                          <td></td>
                                          <?php
                                          echo ($mk == (count($fullBodyCheckupMaster) - 1)) ? '</tr>' : '';
                                     }
                                   ?>
                                   </tbody>
                              </table>

                              <table class="table table-striped" style="margin-top:200px;">
                                   <thead>
                                        <tr>
                                             <th colspan="8" style="text-align: center;">Warranty and Service History</th>
                                        </tr>
                                   </thead>   
                                   <tbody>
                                        <tr>
                                             <td>Warranty</td>
                                             <td></td>
                                             <td>Valid Up to</td>
                                             <td></td>
                                             <td>Last Service Date</td>
                                             <td></td>
                                             <td>KM</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>Extra Warranty</td>
                                             <td></td>
                                             <td>Valid Up to</td>
                                             <td></td>
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
                                             <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                             <td>Accident History</td>
                                             <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                             <td>Warranty service remarks</td>
                                             <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                             <td>Adj For Condition</td>
                                             <td colspan="7"></td>
                                        </tr>
                                        <tr>
                                             <td>Document details</td>
                                             <td colspan="7"></td>
                                        </tr>
                                   </tbody>
                              </table>
                         
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
                                             <td></td>

                                             <td>Wint sheeld</th>
                                             <td></td>

                                             <td>FR</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>FL</td>
                                             <td></td>

                                             <td>Rear Glass</td>
                                             <td></td>

                                             <td>FL</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>CR</td>
                                             <td></td>

                                             <td>Door Glass R</td>
                                             <td></td>

                                             <td>RR</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>CL</td>
                                             <td></td>

                                             <td>Door Glass LS</td>
                                             <td></td>

                                             <td>RL</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>RR</td>
                                             <td></td>

                                             <td>Q Glass R</td>
                                             <td></td>

                                             <td>Spare</td>
                                             <td></td>
                                        </tr>
                                        <tr>
                                             <td>RL</td>
                                             <td></td>

                                             <td>Q Glass L</td>
                                             <td></td>

                                             <td>Space savor</td>
                                             <td></td>
                                        </tr>
                              </tbody>
                         </table>

                         <table class="table table-striped">
                              <tbody>
                                   <tr>
                                        <td colspan="2" style="text-align: center;">Battery</td>
                                        <td colspan="2" style="text-align: center;">Make</td>
                                        <td colspan="2" style="text-align: center;"></td>
                                        <td colspan="2" style="text-align: center;">Year</td>
                                        <td colspan="2" style="text-align: center;"></td>
                                        <td colspan="2" style="text-align: center;">Warranty</td>
                                        <td colspan="2" style="text-align: center;"></td>
                                   </tr>
                              </tbody>
                         </table>
                         <div>
                              <span style="margin-top: 20px;width: 100%;float: left;">Structural Hits and Damages</span>
                              <img src="images/hit-damage.png"/>
                         </div>

                         <table class="table table-striped">
                              <tr>
                                     <td>IMP Observations : </td>
                              </tr>
                              <tr>
                                     <td>SPL Comments : </td>
                              </tr>
                         </table>
                    </div>
               </div>
          </div>
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
     .table{
          margin-bottom: 0px !important;
     }
     .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
          padding: 5px !important;
     }
     .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th {
          border: none !important;
     }
     .x_content {font-size: 11px;}
     @media print{
          .right_col {margin-left: 0px !important;}
          .left_col {display: none  !important;}
          .right_col {height: 400px !important;}
          .row {height: 400px !important;}
          .div-col-body {height: 400px !important;}
          .x_panel {max-height: 200px !important;}
          .msgBox{display: none  !important;}
          .hideonprint{display: none  !important;}
     }
</style>