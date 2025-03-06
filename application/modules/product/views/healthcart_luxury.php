<page size="A4">
     <!--float: left;text-align: center;-->
     <div style="width: 100%;float: left;">
          <img src="https://rdmsdev.royaldrive.in/assets/images/hc-logo-luxury.jpeg" style="width: 380px;margin-left: 70px;margin-top: 30px;float: left;" />
          <div style="float: right;margin-right: 80px;margin-top: 30px;text-align: center;">
               <img src="https://rdmsdev.royaldrive.in/assets/images/rd-app-qr.png" style="width: 100px;" /><br>
               <label>SCAN QR CODE <br> FOR MORE INFO</label>
          </div>
     </div>
     <div style="float: left;width: 100%;padding-top: 30px;">
          <ul>
               <li><span>General Information</span></li>
          </ul>
          <table style="width: 86%;margin-left: 57px;margin-top: 20px;">
               <tr>
                    <td>Brand</td>
                    <td>:</td>
                    <td><?php echo $product_details['brd_title']; ?></td>
                    <td>KM Driven</td>
                    <td>:</td>
                    <td><?php echo inr_currency_format($product_details['prd_km_run'], false); ?></td>
               </tr>

               <tr>
                    <td>Model</td>
                    <td>:</td>
                    <td><?php echo $product_details['mod_title']; ?></td>
                    <td>Ownership</td>
                    <td>:</td>
                    <td><?php echo get_ownership_text($product_details['prd_owner']); ?></td>
               </tr>

               <tr>
                    <td>Variant</td>
                    <td>:</td>
                    <td><?php echo $product_details['var_variant_name']; ?></td>
                    <td>Body Type</td>
                    <td>:</td>
                    <td>
                         <?php
                         $vehicleType = unserialize(ENQ_VEHICLE_TYPES);
                         echo $vehicleType[$valuation['val_veh_type']];
                         ?>
                    </td>
               </tr>

               <tr>
                    <td><span style="font-size: 9px;">Month & Year of </span><br> Manufacture</td>
                    <td>:</td>
                    <td><?php echo $valuation['val_minif_month'] . '/' . $valuation['val_minif_year']; ?></td>
                    <td>Fuel<br>Color</td>
                    <td>:<br>:</td>
                    <td>
                         <?php
                         $fuel = unserialize(FUAL);
                         echo isset($fuel[$product_details['prd_fual']]) ? $fuel[$product_details['prd_fual']] : '';
                         ?><br><?php echo $product_details['prd_color']; ?>
                    </td>
               </tr>

               <tr>
                    <td><span style="font-size: 9px;">Month & Year of </span> <br> Registration</td>
                    <td>:</td>
                    <td><?php echo date('M/Y', strtotime($valuation['val_reg_date'])); ?></td>
                    <td><span style="font-size: 15px;">ARAI Tested</span> <br> Fuel efficiency</td>
                    <td>:</td>
                    <td><?php echo $valuation['val_arai_tstd_fuel_efncy']; ?></td>
               </tr>

               <tr>
                    <td><span style="font-size: 15px;">Current</span> <br> On Road Price</td>
                    <td>:</td>
                    <td><?php echo $valuation['val_new_vehicle_price']; ?></td>
                    <td><span style="font-weight: bolder;">RD Price</span></td>
                    <td>:</td>
                    <td><?php echo ($product_details['prd_price'] > 0) ? inr_currency_format($product_details['prd_price']) : ''; ?></td>
               </tr>
          </table>
          <ul>
               <li><span>Engine & Transmission</span></li>
          </ul>
          <table style="width: 86%;margin-left: 57px;margin-top: 20px;">
               <tr>
                    <td>Engine Capacity (CC)</td>
                    <td> : </td>
                    <td><?php echo $valuation['val_eng_cc']; ?></td>
                    <td>Power/Torque</td>
                    <td> : </td>
                    <td><?php echo $valuation['val_power'] . '/' . $valuation['val_torque']; ?></td>
               </tr>

               <tr>
                    <td>Transmission</td>
                    <td> : </td>
                    <td>
                         <?php
                         if ($valuation['val_transmission'] == 1) {
                              echo 'M/T';
                         } else if ($valuation['val_transmission'] == 2) {
                              echo 'A/T';
                         } else if ($valuation['val_transmission'] == 3) {
                              echo 'S/T';
                         }
                         ?>
                    </td>
                    <td>Drive Train</td>
                    <td> : </td>
                    <td>
                         <?php
                         $driveTrain = unserialize(DRIVE_TRAINS);
                         echo $driveTrain[$valuation['val_drive_train']];
                         ?>
                    </td>
               </tr>
          </table>
          <ul>
               <li><span>Insurance & PUC</span></li>
          </ul>

          <table style="width: 86%;margin-left: 57px;margin-top: 20px;">
               <tr>
                    <td>Insurance Type</td>
                    <td> : </td>
                    <td><?php
                         $insType = unserialize(INSURANCE_TYPES);
                         echo $insType[$valuation['val_insurance']];
                         ?>
                    </td>
                    <td>PUC Valid upto</td>
                    <td> : </td>
                    <td><?php echo date('d-m-Y', strtotime($valuation['val_pucc_valid'])); ?></td>
               </tr>

               <tr>
                    <td>Insurance IDV</td>
                    <td> : </td>
                    <td><?php echo inr_currency_format($product_details['prd_insurance_idv']); ?></td>
                    <td>Insurance Valid upto</td>
                    <td> : </td>
                    <td><?php echo $product_details['prd_insurance_validity']; ?></td>
               </tr>
          </table>
          <ul>
               <li><span>Warranty</span></li>
          </ul>
          <table style="width: 86%;margin-left: 57px;margin-top: 20px;">
               <tr>
                    <td>Valid upto (Date/KM)</td>
                    <td> : </td>
                    <td>
                         <?php $warntyDate = !empty($valuation['val_wrnty_validity']) ? date('d-m-Y', strtotime($valuation['val_wrnty_validity'])) : '';
                         $km = !empty($valuation['val_wrnty_km']) ? $valuation['val_wrnty_km'] : '';
                         echo $warntyDate . '/' . $km; ?></td>
                    <td>Type</td>
                    <td> : </td>
                    <td><?php echo $valuation['val_wrnty_type']; ?></td>
               </tr>
          </table>

          <ul>
               <li><span>Service Package</span></li>
          </ul>
          <table style="width: 86%;margin-left: 57px;margin-top: 20px;">
               <tr>
                    <td>Valid upto (Date/KM)</td>
                    <td> : </td>
                    <td><?php
                         $serviceDate = !empty($valuation['val_wrnty_nxt_ser_date']) ? date('d-m-Y', strtotime($valuation['val_wrnty_nxt_ser_date'])) : '';
                         $serviceKm = !empty($valuation['val_wrnty_nxt_ser_km']) ? $valuation['val_wrnty_nxt_ser_km'] : '';
                         echo $serviceDate . '/' . $serviceKm; ?>
                    </td>
                    <td>Type</td>
                    <td> : </td>
                    <td><?php echo $valuation['val_service_type']; ?></td>
               </tr>
          </table>

          <ul>
               <li><span>Service Details</span></li>
          </ul>
          <table style="width: 86%;margin-left: 57px;margin-top: 20px;">
               <tr>
                    <td>Last Service done (Date & KM)</td>
                    <td>:</td>
                    <td><?php
                         $lstService = !empty($valuation['val_last_service']) ? date('d-m-Y', strtotime($valuation['val_last_service'])) : '';
                         $lstServiceKm = !empty($valuation['val_last_service']) ? $valuation['val_last_service'] : '';
                         echo $lstService . '/' . $lstServiceKm; ?>
                    </td>
               </tr>
               <tr>
                    <td>Last Service done at (Service centre)</td>
                    <td> : </td>
                    <td><?php echo $valuation['val_lst_service_place']; ?></td>
               </tr>
               <tr>
                    <td>Next Service due (Date / KM)</td>
                    <td> : </td>
                    <td><?php
                         $nxtService = !empty($valuation['val_next_serv_date']) ? date('d-m-Y', strtotime($valuation['val_next_serv_date'])) : '';
                         $nxtServiceKm = !empty($valuation['val_next_serv_km']) ? $valuation['val_next_serv_km'] : '';
                         echo $nxtService . '/' . $nxtServiceKm;
                         ?>
                    </td>
               </tr>
          </table>

          <fieldset style="min-height: 200px;width: 86%;margin-left: 57px;margin-top: 20px;text-align: center;border-radius: 25px;">
               <legend class="bg-head" style="padding: 9px 16px;color: #fff;">Additional Service Information:</legend>
             <?php echo $valuation['val_additonal_serv_info']; ?>
          </fieldset>
     </div>
</page>
<page size="A4">

     <fieldset style="min-height: 200px;width: 86%;margin-left: 57px;margin-top: 20px;text-align: center;border-radius: 25px;">
          <legend class="bg-head" style="padding: 9px 16px;color: #fff;">Details of any Claim/ Replace:</legend>
          <?php echo $valuation['val_calim_or_replace']; ?>
     </fieldset>

     <ul style="margin-top: 20px;">
          <li><span>Tyre & Break Pad(%)</span></li>
     </ul>

     <!-- -->
     <div id="boxes">
          <div id="leftbox">
               <div>
                    <div>
                         <fieldset style="min-height: 130px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                              <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Tyre</legend>
                              <span style="text-align: center;top: -30px;right: -15px;color:#fff;border-radius: 50px;background: #605f5f;
                                    position: absolute;height: 40px;width: 40px;"><label style="float: left;margin-left: 12px;margin-top: 10px;">FL</label></span>
                              <table>
                                   <tr>
                                        <td>Thickness (%)</td>
                                        <td>:</td>
                                        <td><?php echo $valuation['val_tyre_1']; ?></td>
                                   </tr>
                                   <tr>
                                        <td>Brand</td>
                                        <td>:<?php  
                                        echo $tyr=$this->product_model->getTyreCompanay($valuation['val_tyre_1_com']);
                                        ?></td>
                                        <td></td>
                                   </tr>
                                   <tr>
                                        <td>Year</td>
                                        <td>:</td>
                                        <td><?php echo $valuation['val_tyre_1_yer']; ?></td>
                                   </tr>
                              </table>
                         </fieldset>
                    </div>

                    <div>
                         <fieldset style="min-height: 75px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                              <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Break Pad (%) FL</legend>
                              <?php echo $valuation['val_bp_fl']; ?>
                         </fieldset>
                    </div>

                    <div>
                         <fieldset style="min-height: 130px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                              <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Tyre</legend>
                              <span style="text-align: center;top: -30px;right: -15px;color:#fff;border-radius: 50px;background: #605f5f;
                                    position: absolute;height: 40px;width: 40px;"><label style="float: left;margin-left: 12px;margin-top: 10px;">RL</label></span>

                              <table>
                                   <tr>
                                        <td>Thickness (%)</td>
                                        <td>:</td>
                                        <td><?php echo $valuation['val_tyre_3']; ?></td>
                                   </tr>
                                   <tr>
                                        <td>Brand</td>
                                        <td>:<?php  
                                        echo $tyr=$this->product_model->getTyreCompanay($valuation['val_tyre_3_com']);
                                        ?></td>
                                        <td></td>
                                   </tr>
                                   <tr>
                                        <td>Year</td>
                                        <td>:</td>
                                        <td><?php echo $valuation['val_tyre_3_yer']; ?></td>
                                   </tr>
                              </table>
                         </fieldset>
                    </div>

                    <div>
                         <fieldset style="min-height: 75px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                              <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Break Pad (%) RL</legend>
                              <?php echo $valuation['val_bp_rl']; ?>
                         </fieldset>
                    </div>
               </div>
          </div>

          <div id="middlebox">
               <div>
                    <img src="https://rdmsdev.royaldrive.in/assets/images/hcardcar.png" width="260px" />
               </div>
          </div>

          <div id="rightbox">
               <div>
                    <fieldset style="min-height: 130px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                         <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Tyre</legend>
                         <span style="text-align: center;top: -30px;right: -15px;color:#fff;border-radius: 50px;background: #605f5f;
                               position: absolute;height: 40px;width: 40px;"><label style="float: left;margin-left: 12px;margin-top: 10px;">FR</label></span>

                         <table>
                              <tr>
                                   <td>Thickness (%)</td>
                                   <td>:</td>
                                   <td><?php echo $valuation['val_tyre_2']; ?></td>
                              </tr>
                              <tr>
                                   <td>Brand</td>
                                   <td>:<?php  
                                        echo $tyr=$this->product_model->getTyreCompanay($valuation['val_tyre_2_com']);
                                        ?></td>
                                   <td></td>
                              </tr>
                              <tr>
                                   <td>Year</td>
                                   <td>:</td>
                                   <td><?php echo $valuation['val_tyre_2_yer']; ?></td>
                              </tr>
                         </table>
                    </fieldset>
               </div>

               <div>
                    <fieldset style="min-height: 75px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                         <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Break Pad (%) FR</legend>
                         
                         <?php echo $valuation['val_bp_fr']; ?>
                    </fieldset>
               </div>

               <div>
                    <fieldset style="min-height: 130px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                         <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Tyre</legend>
                         <span style="text-align: center;top: -30px;right: -15px;color:#fff;border-radius: 50px;background: #605f5f;
                               position: absolute;height: 40px;width: 40px;"><label style="float: left;margin-left: 12px;margin-top: 10px;">RR</label></span>

                         <table>
                              <tr>
                                   <td>Thickness (%)</td>
                                   <td>:</td>
                                   <td><?php echo $valuation['val_tyre_4']; ?></td>
                              </tr>
                              <tr>
                                   <td>Brand</td>
                                   <td>:<?php  
                                        echo $tyr=$this->product_model->getTyreCompanay($valuation['val_tyre_4_com']);
                                        ?></td>
                                   <td></td>
                              </tr>
                              <tr>
                                   <td>Year</td>
                                   <td>:</td>
                                   <td><?php echo $valuation['val_tyre_4_yer']; ?></td>
                              </tr>
                         </table>
                    </fieldset>
               </div>

               <div>
                    <fieldset style="min-height: 75px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                         <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Break Pad (%) RR </legend>
                         <?php echo $valuation['val_bp_rr']; ?>
                    </fieldset>
               </div>
          </div>
     </div>
     <!-- -->
     <div style="clear: both;"></div>
     <ul>
          <li><span>Battery</span></li>
     </ul>

     <table style="width: 86%;margin-left: 57px;margin-top: 20px;">
          <tr>
               <td>Brand</td>
               <td> : <?php echo $valuation['val_battery_brand']; ?> </td>
               <td></td>
               <td>Warranty upto</td>
               <td> : <?php   echo !empty($valuation['val_warranty_upto']) ? date('d-m-Y', strtotime($valuation['val_warranty_upto'])) : ''; ?> </td>
               <td></td>
          </tr>

          <tr>
               <td>Year</td>
               <td> : <?php echo $valuation['val_battery_year']; ?> </td>
               <td></td>
               <td>Current Capacity</td>
               <td> : <?php echo $valuation['val_current_capacity']; ?> </td>
               <td></td>
          </tr>
     </table>

     <fieldset style="min-height: 200px;width: 86%;margin-left: 57px;margin-top: 20px;text-align: center;border-radius: 25px;">
          <legend class="bg-head" style="padding: 9px 16px;color: #fff;">Refurbishment Details:<?php echo $valuation['val_id']; ?></legend>

          <?php
$refurbDetails=$this->product_model->refurbDetails($valuation['val_id']);
          ?>
          <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;font-size: 20px;" colspan="10">
                                                     
                                                        <?php if (empty($refurbDetails['upgradeDetails'])) { ?>
                                                            <span style="cursor: pointer;" class="glyphicon glyphicon-plus btnAddUpgradDet"></span>
                                                        <?php } ?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbUpgradDet">
                                                <?php
                                                if (!empty($refurbDetails['upgradeDetails'])) {
                                                    foreach ($refurbDetails['upgradeDetails'] as $upkey => $upval) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $upval['upgrd_key']; ?></td>
                                                            <td><?php echo $upval['upgrd_value']; ?></td>
                                                            <!-- <td><span style="cursor: pointer;" class="btnRemUpgradDet glyphicon glyphicon-minus"></span></td> -->
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
     </fieldset>

     <fieldset style="min-height: 200px;width: 86%;margin-left: 57px;margin-top: 20px;text-align: center;border-radius: 25px;">
          <legend class="bg-head" style="padding: 9px 16px;color: #fff;">Disclaimer:</legend>
          <?php echo $valuation['val_calim_or_replace']; ?>
     </fieldset>
</page>

<!--21-->
<style>
     #boxes {
          float: left;
          width: 100%;
     }

     #leftbox {
          float: left;
          /*          background:Red;*/
          width: 38%;
          /*height:280px;*/
     }

     #middlebox {
          float: left;
          /*background:Green;*/
          width: 20%;
          /*height:280px;*/
     }

     #rightbox {
          float: right;
          /*background:blue;*/
          width: 36%;
          /*height:280px;*/
     }

     body {
          font-family: 'Raleway';
          background: rgb(204, 204, 204);
     }

     page {
          background: white;
          display: block;
          margin: 0 auto;
          margin-bottom: 0.5cm;
     }

     page[size="A4"] {
          /*width: 21cm;
          height: 29.7cm;*/
          width: 29cm;
          height: 40.7cm;
     }

     @media print {

          body,
          page {
               background: white;
               margin: 0;
               box-shadow: 0;
          }
     }

     ul,
     .bg-head {
          list-style-type: none;
          margin: 0px 40px 0px 40px;
          padding: 0;
          overflow: hidden;
          background: #605f5f !important;
          border-radius: 25px;
          -webkit-print-color-adjust: exact;

     }

     li {
          float: left;
          width: 100%;
     }

     li span {
          display: block;
          color: white;
          text-align: center;
          padding: 9px 16px;
          text-decoration: none;
     }

     td {
          font-size: 17px;
          padding: 8px;
     }
</style>