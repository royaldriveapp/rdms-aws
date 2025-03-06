<div class="right_col" role="main">
     <div class="row">
          <div class="div-col-body col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Evaluation report</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li class="dropdown" style="float: right;">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <i class="fa fa-wrench"></i>
                                   </a>
                                   <ul class="dropdown-menu" role="menu">
                                        <li><a target="blank" href="<?php echo site_url('evaluation/view/' . encryptor($vehicles['val_id']));?>">Edit</a></li>
                                   </ul>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart($controller . "/refurbisheReturn", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left"))?>
                         <table class="table table-striped">
                              <thead>
                                   <tr>
                                        <th colspan="6" style="text-align: center;">Vehicle Evaluation Sheet</th>
                                   </tr>
                                   <tr>
                                        <th>Division</th>
                                        <th><?php echo $vehicles['div_name'];?></th>
                                        <th>Branch</th>
                                        <th><?php echo $vehicles['shr_location'];?></th>
                                        <th>Date</th>
                                        <th><?php echo date('d-m-Y', strtotime($vehicles['val_added_date']));?></th>
                                   </tr>
                              </thead>
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
                                        <td><?php echo $vehicles['val_refferer_name'];?></td>
                                        <td>Evaluator</td>
                                        <td><?php echo $vehicles['usr_username'];?></td>
                                        <td>Executive</td>
                                        <td><?php echo $vehicles['so_usr_username'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Evaluation location</td>
                                        <td><?php echo $vehicles['val_location'];?></td>
                                        <td>In time</td>
                                        <td><?php echo $vehicles['val_in_time'];?></td>
                                        <td>Out time</td>
                                        <td><?php echo $vehicles['val_out_time'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Customer name</td>
                                        <td><?php echo $vehicles['val_cust_name'];?></td>
                                        <td>Customer source</td>
                                        <td>
                                             <?php
                                               $modofcontact = unserialize(MODE_OF_CONTACT);
                                               echo $modofcontact[$vehicles['val_cust_source']];
                                             ?>
                                        </td>
                                        <td>Phone number</td>
                                        <td><?php echo $vehicles['val_cust_phone'];?></td>
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
                                        <th><?php echo strtoupper($vehicles['val_veh_no']);?></th>
                                        <th>Make</th>
                                        <th><?php echo $vehicles['brd_title'];?></th>
                                        <th>Model variant</th>
                                        <th><?php echo $vehicles['mod_title'] . ' ' . $vehicles['var_variant_name'];?></th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <tr>
                                        <td>Model code</td>
                                        <td>Newfield</td>
                                        <td>First Delivery Date</td>
                                        <td><?php echo!empty($vehicles['val_first_dlvry_state']) ? date('d-m-Y', strtotime($vehicles['val_first_dlvry_state'])) : '';?></td>
                                        <td>Delivery Location</td>
                                        <td><?php echo $vehicles['val_first_dlvry_location'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Delivery State</td>
                                        <td><?php echo $vehicles['val_first_dlvry_state'];?></td>
                                        <td>Dealership</td>
                                        <td><?php echo $vehicles['val_first_dlvry_dlrship'];?></td>
                                        <td>1ST Reg Date</td>
                                        <td><?php echo!empty($vehicles['val_reg_date']) ? date('d-m-Y', strtotime($vehicles['val_reg_date'])) : '';?></td>
                                   </tr>
                                   <tr>
                                        <td>No Of owners</td>
                                        <td><?php echo $vehicles['val_no_of_owner'];?></td>
                                        <td>Vehicle type</td>
                                        <td>
                                             <?php
                                               $vehicleType = unserialize(ENQ_VEHICLE_TYPES);
                                               echo $vehicleType[$vehicles['val_veh_type']];
                                             ?>
                                        </td>
                                        <td>No Of seats</td>
                                        <td><?php echo $vehicles['val_no_of_seats'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Eng CC</td>
                                        <td><?php echo $vehicles['val_eng_cc'];?></td>
                                        <td>Color</td>
                                        <td><?php echo $vehicles['val_color'];?></td>
                                        <td>KM</td>
                                        <td><?php echo $vehicles['val_km'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Model year</td>
                                        <td><?php echo $vehicles['val_model_year'];?></td>
                                        <td>Manf. Year</td>
                                        <td><?php echo $vehicles['val_minif_year'];?></td>
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
                                        <td> <?php echo $vehicles['val_ac_zone'];?> </td>
                                   </tr>
                              </tbody>
                         </table>

                         <table class="table table-striped">
                              <thead>
                                   <tr>
                                        <th colspan="3" style="text-align: center;">Insurance</th>
                                        <th colspan="1" style="text-align: center;">Insurance Company</th>
                                        <th colspan="3" style="text-align: center;"><?php echo $vehicles['val_insurance_company'];?></th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <tr>
                                        <td>Comprehensive</td>
                                        <td>Valid up to</td>
                                        <td><?php echo!empty($vehicles['val_insurance_comp_date']) ? date('d-m-Y', strtotime($vehicles['val_insurance_comp_date'])) : '';?></td>
                                        <td>IDV</td>
                                        <td><?php echo $vehicles['val_insurance_comp_idv'];?></td>
                                        <td>NCB%</td>
                                        <td><?php echo $vehicles['val_insurance_ll_idv'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Third Party</td>
                                        <td>Valid up to</td>
                                        <td><?php echo!empty($vehicles['val_insurance_ll_date']) ? date('d-m-Y', strtotime($vehicles['val_insurance_ll_date'])) : '';?></td>
                                        <td>Insurance Type</td>
                                        <td>
                                             <?php
                                               $insType = unserialize(INSURANCE_TYPES);
                                               echo $insType[$vehicles['val_insurance']];
                                             ?>
                                        </td>
                                        <td>NCB Required</td>
                                        <td><?php echo ($vehicles['val_insurance_need_ncb'] == 1) ? 'YES' : 'NO';?></td>
                                   </tr>
                              </tbody>
                         </table>

                         <?php if (($vehicles['val_finance'] == 1) || ($vehicles['val_hypo_close_by_cust'] == 1)) {?>
                                <table class="table table-striped">
                                     <thead>
                                          <tr>
                                               <th colspan="2" style="text-align: center;">Hypothecation Details</th>
                                               <th colspan="4" style="text-align: center;">Finance Company : <?php echo $vehicles['bnk_name'];?></th>
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
                                               <td><?php echo $vehicles['val_hypo_bank_branch'];?></td>
                                               <td>Loan Amount</td>
                                               <td><?php echo $vehicles['val_hypo_loan_amt'];?></td>
                                          </tr>
                                          <tr>
                                               <td>Loan Starting Date</td>
                                               <td><?php echo!empty($vehicles['val_hypo_loan_date']) ? date('d-m-Y', strtotime($vehicles['val_hypo_loan_date'])) : '';?></td>
                                               <td>Foreclosure value</td>
                                               <td><?php echo $vehicles['val_hypo_frclos_val'];?></td>
                                               <td>Foreclosure Date</td>
                                               <td><?php echo!empty($vehicles['val_hypo_frclos_date']) ? date('d-m-Y', strtotime($vehicles['val_hypo_frclos_date'])) : '';?></td>
                                          </tr>
                                          <tr>
                                               <td>Loan Ending Date</td>
                                               <td><?php echo!empty($vehicles['val_hypo_loan_end_date']) ? date('d-m-Y', strtotime($vehicles['val_hypo_loan_end_date'])) : '';?></td>
                                               <td>Daily Interest</td>
                                               <td><?php echo $vehicles['val_hypo_daily_int'];?></td>
                                               <td>Any Top up Loan</td>
                                               <td><?php echo ($vehicles['val_top_up_loan'] == 1) ? 'Yes' : 'No';?></td>
                                          </tr>
                                     </tbody>
                                </table>
                           <?php }?>

                         <table class="table table-striped">
                              <thead>
                                   <tr>
                                        <th colspan="6" style="text-align: center;">Features & Loadings</th>
                                   </tr>
                              </thead>

                              <tbody>
                                   <tr>
                                        <td>No Of Airbag</td>
                                        <td><?php echo $vehicles['val_air_bags'];?></td>
                                        <td>No Of Exhaust</td>
                                        <td><?php echo $vehicles['val_exhaust'];?></td>
                                        <td>No Of Power Window</td>
                                        <td><?php echo $vehicles['val_no_of_pw'];?></td>
                                   </tr>
                                   <?php if (!empty($vehicles['features'])) {?>
                                          <tr>
                                               <td colspan="6"><?php echo 'Features : ' . implode(', ', array_column($vehicles['features'], 'vftr_feature'));?></td>
                                          </tr>
                                     <?php } if (!empty($vehicles['featuresLoadings'])) {?>
                                          <tr>
                                               <td colspan="6"><?php echo 'Loadings : ' . implode(', ', array_column($vehicles['featuresLoadings'], 'vftr_feature'));?></td>
                                          </tr>
                                     <?php }?>
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
                                     foreach ($vehicles['bdChkup'] as $bchkey => $bchvalue) {
                                          echo ($bchkey != 0 && $bchkey % 4 == 0) ? '</tr>' : '';
                                          echo ($bchkey == 0 || $bchkey % 4 == 0) ? '<tr>' : '';
                                          ?>
                                     <td><?php echo $bchvalue['vfbcm_title'];?></td>
                                     <td><?php echo $bchvalue['vfbcd_title'];?></td>
                                     <?php
                                     echo ($bchkey == (count($vehicles['bdChkup']) - 1)) ? '</tr>' : '';
                                }
                              ?>
                              </tbody>
                         </table>

                         <table class="table table-striped">
                              <thead>
                                   <tr>
                                        <th colspan="8" style="text-align: center;">Warranty and Service History</th>
                                   </tr>
                              </thead>   
                              <tbody>
                                   <tr>
                                        <td>Warranty</td>
                                        <td><?php echo ($vehicles['val_wrnty'] == 1) ? 'Valid' : 'Not Valid';?></td>
                                        <td>Valid Up to</td>
                                        <td><?php echo!empty($vehicles['val_wrnty_validity']) ? date('d-m-Y', strtotime($vehicles['val_wrnty_validity'])) : '';?></td>
                                        <td>Last Service Date</td>
                                        <td><?php echo!empty($vehicles['val_last_service']) ? date('d-m-Y', strtotime($vehicles['val_last_service'])) : '';?></td>
                                        <td>KM</td>
                                        <td><?php echo $vehicles['val_last_service_km']?></td>
                                   </tr>
                                   <tr>
                                        <td>Extra Warranty</td>
                                        <td><?php echo ($vehicles['val_wrnty_extra'] == 1) ? 'Valid' : 'Not Valid';?></td>
                                        <td>Valid Up to</td>
                                        <td><?php echo!empty($vehicles['val_ex_wrnty_validity']) ? date('d-m-Y', strtotime($vehicles['val_ex_wrnty_validity'])) : '';?></td>
                                        <td>Service Req A.O.D</td>
                                        <td><?php echo $vehicles['val_wrnty_service_req_aod'];?></td>
                                        <td>Serv A.O.D</td>
                                        <td><?php echo $vehicles['val_wrnty_act_serv_aod']?></td>
                                   </tr>
                                   <tr>
                                        <td>Spl Ser Observations</td>
                                        <td colspan="7"><?php echo $vehicles['val_wrnty_spl_ser_observ'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Accident History</td>
                                        <td colspan="7"><?php echo $vehicles['val_acc_history_remarks'];?></td>
                                   </tr>
                                   <tr>
                                        <td>SPL Comments</td>
                                        <td colspan="7"><?php echo $vehicles['val_acc_history_remarks'];?></td>
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
                                        <td><?php echo $vehicles['val_pfr'];?></td>

                                        <td>Wint sheeld</th>
                                        <td><?php echo $vehicles['val_gws'];?></td>

                                        <td>FR</td>
                                        <td>
                                             <?php echo $vehicles['val_tyre_2_wek'];?>
                                             <?php echo $vehicles['val_tyre_2_yer'];?>
                                             <?php echo $vehicles['val_tyre_2'];?>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>FL</td>
                                        <td><?php echo $vehicles['val_pfl'];?></td>

                                        <td>Rear Glass</td>
                                        <td><?php echo $vehicles['val_grg'];?></td>

                                        <td>FL</td>
                                        <td>
                                             <?php echo $vehicles['val_tyre_1_wek'];?>
                                             <?php echo $vehicles['val_tyre_1_yer'];?>
                                             <?php echo $vehicles['val_tyre_1'];?>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>CR</td>
                                        <td><?php echo $vehicles['val_pcr'];?></td>

                                        <td>Door Glass R</td>
                                        <td><?php echo $vehicles['val_gdgr'];?></td>

                                        <td>RR</td>
                                        <td>
                                             <?php echo $vehicles['val_tyre_4_wek'];?>
                                             <?php echo $vehicles['val_tyre_4_yer'];?>
                                             <?php echo $vehicles['val_tyre_4'];?>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>CL</td>
                                        <td><?php echo $vehicles['val_pcl'];?></td>

                                        <td>Door Glass LS</td>
                                        <td><?php echo $vehicles['val_gdgls'];?></td>

                                        <td>RL</td>
                                        <td>
                                             <?php echo $vehicles['val_tyre_3_wek'];?>
                                             <?php echo $vehicles['val_tyre_3_yer'];?>
                                             <?php echo $vehicles['val_tyre_3'];?>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>RR</td>
                                        <td><?php echo $vehicles['val_prr'];?></td>

                                        <td>Q Glass R</td>
                                        <td><?php echo $vehicles['val_qgr'];?></td>

                                        <td>Spare</td>
                                        <td>
                                             <?php echo $vehicles['val_tyre_5_wek'];?>
                                             <?php echo $vehicles['val_tyre_5_yer'];?>
                                             <?php echo $vehicles['val_tyre_5'];?>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>RL</td>
                                        <td><?php echo $vehicles['val_prl'];?></td>

                                        <td>Q Glass L</td>
                                        <td><?php echo $vehicles['val_qgi'];?></td>

                                        <td>Space savor</td>
                                        <td>
                                             <?php echo $vehicles['val_tyre_6_wek'];?>
                                             <?php echo $vehicles['val_tyre_6_yer'];?>
                                             <?php echo $vehicles['val_tyre_6'];?>
                                        </td>
                                   </tr>
                              </tbody>
                         </table>

                         <table class="table table-striped">
                              <tbody>
                                   <tr>
                                        <td colspan="2" style="text-align: center;">Battery</td>
                                        <td colspan="2" style="text-align: center;">Make</td>
                                        <td colspan="2" style="text-align: center;"><?php echo $vehicles['val_battery_make'];?></td>
                                        <td colspan="2" style="text-align: center;">Year</td>
                                        <td colspan="2" style="text-align: center;"><?php echo $vehicles['val_battery_year'];?></td>
                                        <td colspan="2" style="text-align: center;">Warranty</td>
                                        <td colspan="2" style="text-align: center;"><?php echo ($vehicles['val_battery_warranty'] == 1) ? 'YES' : 'NO';?></td>
                                   </tr>
                              </tbody>
                         </table>
                         <!-- -->
                         <div>
                              <span>Structural Hits and Damages</span>
                              <img src="images/hit-damage.png"/>
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
                                   <?php foreach ($vehicles['upgradeDetails'] as $key => $value) {?>
                                          <tr>
                                               <td><?php echo $value['upgrd_key'];?></td>
                                               <td><?php echo number_format($value['upgrd_value'], 2);?></td>
                                          </tr>
                                     <?php }?>
                                   <tr>
                                        <td colspan="2">Adj For Condition : <?php echo $vehicles['val_adj_cond'];?></td>
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
                                   <?php
                                     if (!empty($vehicles['upgradeDetails'])) {
                                          foreach ($vehicles['upgradeDetails'] as $key => $value) {
                                               ?>
                                               <tr>
                                                    <td><?php echo $key + 1;?></td>
                                                    <td><?php echo $value['upgrd_key'];?></td>
                                                    <td><?php echo $value['upgrd_value'];?></td>
                                                    <td><?php echo $value['upgrd_value'];?></td>
                                                    <td><?php echo $value['upgrd_refurb_actual_job']?></td>
                                                    <td><?php echo $value['upgrd_refurb_actual_cost']?></td>
                                                    <td><?php echo $value['upgrd_refurb_remarks']?></td>
                                               </tr>
                                               <?php
                                          }
                                     }
                                   ?>
                                   <tr>
                                        <th colspan="6">Refurb job did : <?php echo $vehicles['val_rfresh_job_did'];?></th>
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
                                        <td><?php echo $vehicles['val_suspt_purchase_price'];?></td>
                                   </tr>
                                   <tr>
                                        <td>New Vehicle Price</td>
                                        <td><?php echo $vehicles['val_new_vehicle_price'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Best Market sale Price</td>
                                        <td><?php echo $vehicles['val_price_market_est'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Refreshment Cost</td>
                                        <td><?php echo $vehicles['val_refurb_cost'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Adj For Condition +/-</td>
                                        <td><?php echo $vehicles['val_adj_ond_pm'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Profit</td>
                                        <td><?php echo $vehicles['val_profit'];?></td>
                                   </tr>
                                   <tr>
                                        <td>Trade in Price</td>
                                        <td><?php echo $vehicles['val_trade_in_price'];?></td>
                                   </tr>
                              </tbody>
                         </table>
                         <!-- -->
                         <div class="row">
                              <div class="form-group divFile">
                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f1']['vvi_image']) ? $vehicles['valVehImages']['f1']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f1']['vvi_id']) ? $vehicles['valVehImages']['f1']['vvi_id'] : '';
                                        ?>
                                        <div class="frame01 dropzone" id="fileupload" action="<?= base_url('index.php/evaluation/uploadFile?frame=1')?>">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>

                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f2']['vvi_image']) ? $vehicles['valVehImages']['f2']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f2']['vvi_id']) ? $vehicles['valVehImages']['f2']['vvi_id'] : '';
                                        ?>
                                        <div class="frame02 dropzone" action="<?= base_url('index.php/evaluation/uploadFile?frame=2')?>" id="fileupload">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>

                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f3']['vvi_image']) ? $vehicles['valVehImages']['f3']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f3']['vvi_id']) ? $vehicles['valVehImages']['f3']['vvi_id'] : '';
                                        ?>
                                        <div class="frame03 dropzone" id="fileupload" action="<?= base_url('index.php/evaluation/uploadFile?frame=3')?>">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>
                              </div>
                              <div class="form-group divFile">
                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f4']['vvi_image']) ? $vehicles['valVehImages']['f4']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f4']['vvi_id']) ? $vehicles['valVehImages']['f4']['vvi_id'] : '';
                                        ?>
                                        <div action="<?= base_url('index.php/evaluation/uploadFile?frame=4')?>" class="frame04 dropzone" id="fileupload">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>

                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f5']['vvi_image']) ? $vehicles['valVehImages']['f5']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f5']['vvi_id']) ? $vehicles['valVehImages']['f5']['vvi_id'] : '';
                                        ?>
                                        <div action="<?= base_url('index.php/evaluation/uploadFile?frame=5')?>" class="frame05 dropzone" id="fileupload">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div>
                                   </div>

                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f6']['vvi_image']) ? $vehicles['valVehImages']['f6']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f6']['vvi_id']) ? $vehicles['valVehImages']['f6']['vvi_id'] : '';
                                        ?>
                                        <div action="<?= base_url('index.php/evaluation/uploadFile?frame=6')?>" class="frame06 dropzone" id="fileupload">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>
                              </div>
                              <div class="form-group divFile">
                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f7']['vvi_image']) ? $vehicles['valVehImages']['f7']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f7']['vvi_id']) ? $vehicles['valVehImages']['f7']['vvi_id'] : '';
                                        ?>
                                        <div action="<?= base_url('index.php/evaluation/uploadFile?frame=7')?>" class="dropzone frame07" id="fileupload">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>
                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f8']['vvi_image']) ? $vehicles['valVehImages']['f8']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f8']['vvi_id']) ? $vehicles['valVehImages']['f8']['vvi_id'] : '';
                                        ?>
                                        <div action="<?= base_url('index.php/evaluation/uploadFile?frame=8')?>" class="dropzone frame08" id="fileupload">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>
                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f9']['vvi_image']) ? $vehicles['valVehImages']['f9']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f9']['vvi_id']) ? $vehicles['valVehImages']['f9']['vvi_id'] : '';
                                        ?>
                                        <div action="<?= base_url('index.php/evaluation/uploadFile?frame=9')?>" class="dropzone frame09" id="fileupload">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>
                              </div>
                              <div class="form-group divFile">
                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f10']['vvi_image']) ? $vehicles['valVehImages']['f10']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f10']['vvi_id']) ? $vehicles['valVehImages']['f10']['vvi_id'] : '';
                                        ?>
                                        <div action="<?= base_url('index.php/evaluation/uploadFile?frame=10')?>" class="dropzone frame10" id="fileupload">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>

                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f11']['vvi_image']) ? $vehicles['valVehImages']['f11']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f11']['vvi_id']) ? $vehicles['valVehImages']['f11']['vvi_id'] : '';
                                        ?>
                                        <div action="<?= base_url('index.php/evaluation/uploadFile?frame=11')?>" class="dropzone frame11" id="fileupload">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>

                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f12']['vvi_image']) ? $vehicles['valVehImages']['f12']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f12']['vvi_id']) ? $vehicles['valVehImages']['f12']['vvi_id'] : '';
                                        ?>
                                        <div action="<?= base_url('index.php/evaluation/uploadFile?frame=12')?>" class="dropzone frame12" id="fileupload">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>
                              </div>
                              <div class="form-group divFile">
                                   <div class="content">
                                        <?php
                                          $img = isset($vehicles['valVehImages']['f13']['vvi_image']) ? $vehicles['valVehImages']['f13']['vvi_image'] : '';
                                          $imgId = isset($vehicles['valVehImages']['f13']['vvi_id']) ? $vehicles['valVehImages']['f13']['vvi_id'] : '';
                                        ?>
                                        <div action="<?= base_url('index.php/evaluation/uploadFile?frame=13')?>" class="dropzone frame13" id="fileupload">
                                             <?php if (!empty($img)) {?>
                                                    <div style="position: relative;" class="deleteRow<?php echo $imgId;?>">
                                                         <?php
                                                         echo img(array('src' => '../assets/uploads/evaluation/vehicle/' . $img, 'width' => "286", 'height' => "194"));
                                                         ?>
                                                    </div>
                                               <?php }?>
                                        </div> 
                                   </div>
                              </div>
                         </div>
                         <!-- -->
                         <div class="ln_solid"></div>
                         <?php echo form_close()?>
                    </div>
               </div>
          </div>
     </div>
</div>

<style>
     .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
          padding: 5px !important;
     }
     .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th {
          border: none !important;
     }
     form {font-size: 11px;}
     @media print{
          .right_col {height: 400px !important;}
          .row {height: 400px !important;}
          .div-col-body {height: 400px !important;}
          .x_panel {max-height: 200px !important;}
     }
</style>