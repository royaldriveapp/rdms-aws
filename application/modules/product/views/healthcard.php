<?php //debug($main);?>
<page size="A4">
<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            /* border: 1px solid #ddd; */
            padding: 8px;
            /* Set a fixed width for the specific td element */
            width: 200px; /* Adjust the width as needed */
            white-space: nowrap; /* Prevent content from wrapping */
            overflow: hidden; /* Hide overflow content */
            text-overflow: ellipsis; /* Display ellipsis for overflow content */
        }
    </style>
<!--float: left;text-align: center;-->
<div style="width: 100%;float: left;">
<?php
if($this->div==2){?>
 <img src="https://rdms.royaldrive.in/assets/images/health_card/rd-lx-logo.svg" style="width: 207px;margin-left: 70px;margin-top: 30px;float: left;" />
<?php
}elseif($this->div==1){?>

<img src="https://royaldrivesmart.in/assets/images/rdsmart-logo.png" style="width: 380px;margin-left: 70px;margin-top: 30px;float: left;" />
<?php }
?>
    
     <div style="float: right;margin-right: 80px;margin-top: 30px;text-align: center;">
          <img src="https://rdms.royaldrive.in/assets/images/health_card/rd-app-qr.png" style="width: 100px;" /><br>
          <label>SCAN QR CODE <br> FOR MORE INFO </label>
     </div>
</div>
<div style="float: left;width: 100%;padding-top: 30px;">

     <ul>
          <li><span>General Information 
          <?= ($uid == 100) ? '<a href="' . site_url('product/deleteHealthCard/' . $main['hc_id']) . '" class="btn btn-info" style="font-size:14px; color:red">Delete <i class="fa fa-trash-o"></i></a>' : '' ?>

          |

          <?= ($uid==100) ? '<a href="' . site_url('product/editHealthCard/' . $main['hc_id']) . '" class="btn btn-info" style="font-size:14px; color:white">Edit <i class="fa fa-trash-o"></i></a>' : '' ?>


 </span></li>
     </ul>
     <table style="width: 86%;margin-left: 57px;margin-top: 20px;">
          <tr>
               <td>Brand</td>
               <td>:</td>
               <td><?php echo $main['brd_title']; ?></td>
               <td>KM Driven</td>
               <td>:</td>
               <!-- <td><?php echo inr_currency_format($main['hc_km'], false); ?></td> -->

               <td><?php echo $main['hc_km']; ?></td>
          </tr>

          <tr>
               <td>Model</td>
               <td>:</td>
               <td><?php echo $main['mod_title']; ?></td>
               <td>Ownership</td>
               <td>:</td>
               <td><?php echo $main['hc_no_of_owner']; ?></td>
          </tr>

          <tr>
               <td>Variant</td>
               <td>:</td>
               <td><?php echo $main['var_variant_name']; ?></td>
               <td>Body Type</td>
               <td>:</td>
               <td>
                    <?php
                    $vehicleType = unserialize(ENQ_VEHICLE_TYPES);
                    echo $vehicleType[$main['hc_veh_type']];
                    ?>
               </td>
          </tr>

          <tr>
               <td><span style="font-size: 9px;">Month & Year of </span><br> Manufacture</td>
               <td>:</td>
               <td><?php echo $main['hc_minif_month'] . '/' . $main['hc_minif_year']; ?></td>
               <td>Fuel<br>Color</td>
               <td>:<br>:</td>
               <td>
                    <?php
                    $fuel = unserialize(FUAL);
                    echo isset($fuel[$main['hc_prd_fual']]) ? $fuel[$main['hc_prd_fual']] : '';
                    ?><br><?php echo $main['hc_prd_color']; ?>
               </td>
          </tr>

          <tr>
               <td><span style="font-size: 9px;">Month & Year of </span> <br> Registration</td>
               <td>:</td>
               <td><?php echo date('M/Y', strtotime($main['hc_reg_date'])); ?></td>
               <td><span style="font-size: 15px;">ARAI Tested</span> <br> Fuel efficiency</td>
               <td>:</td>
               <td><?php echo $main['hc_arai_tstd_fuel_efncy']; ?></td>
          </tr>

          <tr>
               <td><span style="font-size: 15px;">Current</span> <br> On Road Price</td>
               <td>:</td>
               <td><?php echo $main['hc_on_road_price']; ?></td>
               <td><span style="font-weight: bolder;">RD Price</span></td>
               <td>:</td>
               <td><?php echo ($main['hc_rd_price'] > 0) ? inr_currency_format($main['hc_rd_price']) : ''; ?></td>
          </tr>
     </table>
     <ul>
          <li><span>Engine & Transmission</span></li>
     </ul>
     <table style="width: 86%;margin-left: 57px;margin-top: 20px;">
          <tr>
               <td>Engine Capacity (CC) </td>
               <td> : </td>
               <td><?php echo $main['hc_eng_cc']; ?></td>
               <td>Power/Torque</td>
               <td> : </td>
               <td><?php echo $main['hc_power'] . '/' . $main['hc_torque']; ?></td>
          </tr>

          <tr>
               <td>Transmission</td>
               <td> : </td>
               <td>
                    <?php
                    if ($main['hc_transmission'] == 1) {
                         echo 'M/T';
                    } else if ($main['hc_transmission'] == 2) {
                         echo 'A/T';
                    } else if ($main['hc_transmission'] == 3) {
                         echo 'S/T';
                    }
                    ?>
               </td>
               <td>Drive Train</td>
               <td> : </td>
               <td>
                    <?php
                    $driveTrain = unserialize(DRIVE_TRAINS);
                    echo $driveTrain[$main['hc_drive_train']];
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
                    echo $insType[$main['hc_insurance']];
                    ?>
               </td>
               <td>PUC Valid upto</td>
               <td> : </td>
               <td><?php echo date('d-m-Y', strtotime($main['hc_pucc_valid'])); ?></td>
          </tr>

          <tr>
               <td>Insurance IDV</td>
               <td> : </td>
               <td><?php echo inr_currency_format($main['hc_prd_insurance_idv']); ?></td>
               <td>Insurance Valid upto</td>
               <td> : </td>
               <td><?php echo $main['hc_prd_insurance_validity']; ?></td>
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
                    <?php $warntyDate = !empty($main['hc_wrnty_validity']) ? date('d-m-Y', strtotime($main['hc_wrnty_validity'])) : '';
                    $km = !empty($main['hc_wrnty_km']) ? $main['hc_wrnty_km'] : '';
                    echo $warntyDate . '/' . $km; ?></td>
               <td>Type</td>
               <td> : </td>
               <td><?php echo $main['hc_wrnty_type']; ?></td>
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
                    $serviceDate = !empty($main['hc_wrnty_nxt_ser_date']) ? date('d-m-Y', strtotime($main['hc_wrnty_nxt_ser_date'])) : '';
                    $serviceKm = !empty($main['hc_wrnty_nxt_ser_km']) ? $main['hc_wrnty_nxt_ser_km'] : '';
                    echo $serviceDate . '/' . $serviceKm; ?>
               </td>
               <td>Type</td>
               <td> : </td>
               <td><?php echo $main['hc_service_type']; ?></td>
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
                    $lstService = !empty($main['hc_last_service']) ? date('d-m-Y', strtotime($main['hc_last_service'])) : '';
                    $lstServiceKm = !empty($main['hc_last_service_km']) ? $main['hc_last_service_km'] : '';
                    echo $lstService . '/' . $lstServiceKm; ?>
               </td>
          </tr>
          <tr>
               <td>Last Service done at (Service centre)</td>
               <td> : </td>
               <td><?php echo $main['hc_lst_service_place']; ?></td>
          </tr>
          <tr>
               <td>Next Service due (Date / KM)</td>
               <td> : </td>
               <td><?php
                    $nxtService = !empty($main['hc_next_serv_date']) ? date('d-m-Y', strtotime($main['hc_next_serv_date'])) : '';
                    $nxtServiceKm = !empty($main['hc_next_serv_km']) ? $main['hc_next_serv_km'] : '';
                    echo $nxtService . '/' . $nxtServiceKm;
                    ?>
               </td>
          </tr>
     </table>

     <fieldset style="min-height: 200px;width: 86%;margin-left: 57px;margin-top: 20px;text-align: center;border-radius: 25px;">
          <legend class="bg-head" style="padding: 9px 16px;color: #fff;">Additional Service Information:</legend>
        <?php echo $main['hc_additonal_serv_info']; ?>
     </fieldset>
</div>
</page>
<page size="A4">

<fieldset style="min-height: 200px;width: 86%;margin-left: 57px;margin-top: 20px;text-align: center;border-radius: 25px;">
     <legend class="bg-head" style="padding: 9px 16px;color: #fff;">Details of any Claim/ Replace:</legend>
     <?php echo $main['hc_calim_or_replace']; ?>
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
                                   <td>: </td>
                                   <td> <?php echo $main['hct_tyre_1']; ?> </td>
                              </tr>
                              <tr>
                                   <td>Brand</td>
                                   <td>: <?php  
                                       echo $tyr=$this->product_model->getTyreCompanay($main['hct_tyre_1_com']);
                                   ?></td>
                                   <td></td>
                              </tr>
                              <tr>
                                   <td>Year</td>
                                   <td>: </td>
                                   <td> <?php echo $main['hct_tyre_1_yer']; ?> </td>
                              </tr>
                         </table>
                    </fieldset>
               </div>

               <div>
                    <fieldset style="min-height: 75px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                         <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Break Pad (%) FL </legend>
                         <?php  echo $main['hct_bp_fl']; ?>
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
                                   <td> <?php echo $main['hct_tyre_3']; ?></td>
                              </tr>
                              <tr>
                                   <td>Brand</td>
                                   <td>: <?php  
                                   echo  $tyr=$this->product_model->getTyreCompanay($main['hct_tyre_3_com']);
                                   ?></td>
                                   <td></td>
                              </tr>
                              <tr>
                                   <td>Year</td>
                                   <td>: </td>
                                   <td> <?php echo $main['hct_tyre_3_yer']; ?></td>
                              </tr>
                         </table>
                    </fieldset>
               </div>

               <div>
                    <fieldset style="min-height: 75px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                         <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Break Pad (%) RL </legend>
                         <?php echo $main['hct_bp_rl']; ?>
                    </fieldset>
               </div>
          </div>
     </div>

     <div id="middlebox">
          <div>
               <img src="https://rdms.royaldrive.in/assets/images/health_card/hcardcar.png" width="260px" />
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
                              <td>: </td>
                              <td> <?php echo $main['hct_tyre_2']; ?></td>
                         </tr>
                         <tr>
                              <td>Brand</td>
                              <td>: <?php  
                                    echo $tyr=$this->product_model->getTyreCompanay($main['hct_tyre_2_com']);
                                   ?></td>
                              <td></td>
                         </tr>
                         <tr>
                              <td>Year</td>
                              <td>: </td>
                              <td> <?php echo $main['hct_tyre_2_yer']; ?></td>
                         </tr>
                    </table>
               </fieldset>
          </div>

          <div>
               <fieldset style="min-height: 75px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                    <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Break Pad (%) FR</legend>
                    
                    <?php echo $main['hct_bp_fr']; ?>
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
                              <td><?php echo $main['hct_tyre_4']; ?></td>
                         </tr>
                         <tr>
                              <td>Brand</td>
                              <td>: <?php  
                                    echo $tyr=$this->product_model->getTyreCompanay($main['hct_tyre_4_com']);
                                   ?></td>
                              <td></td>
                         </tr>
                         <tr>
                              <td>Year</td>
                              <td>:</td>
                              <td> <?php echo $main['hct_tyre_4_yer']; ?></td>
                         </tr>
                    </table>
               </fieldset>
          </div>

          <div>
               <fieldset style="min-height: 75px;width: 250px;margin-left: 57px;margin-top: 20px;border-radius: 10px;position: relative;">
                    <legend class="bg-head" style="padding: 5px 16px;color: #fff;">Break Pad (%) RR </legend>
                    <?php  echo $main['hct_bp_rr']; ?>
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
          <td> : <?php echo $main['hcb_battery_brand']; ?> </td>
          <td></td>
          <td>Warranty upto</td>
          <td> : <?php   echo !empty($main['hcb_warranty_upto']) ? date('d-m-Y', strtotime($main['hcb_warranty_upto'])) : ''; ?> </td>
          <td></td>
     </tr>

     <tr>
          <td>Year</td>
          <td> : <?php echo $main['hcb_battery_year']; ?> </td>
          <td></td>
          <td>Current Capacity</td>
          <td> : <?php echo $main['hcb_current_capacity']; ?> </td>
          <td></td>
     </tr>
</table>

<fieldset style="min-height: 200px;width: 86%;margin-left: 57px;margin-top: 20px;text-align: center;border-radius: 25px;">
     <legend class="bg-head" style="padding: 9px 16px;color: #fff;">Refurbishment Details:<?php //echo $main['hc_id']; ?></legend>

     <?php
//$rfDetails=$this->product_model->rfDetails($main['hc_id']);
     ?>
     <table class="table table-striped table-bordered">
                                     
                                       <tbody class="tbUpgradDet">
                                           <?php
                                           if (!empty($rfDetails)) {
                                               foreach ($rfDetails as $upkey => $upval) {
                                           ?>
                                                   <tr>
                                                       <td><?php echo $upval['hcr_key']; ?></td>
                                                       <!-- <td><?php echo @$upval['hcr_value']; ?></td> -->
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
     <?php echo @$main['hc_disclaimer']; ?>
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
