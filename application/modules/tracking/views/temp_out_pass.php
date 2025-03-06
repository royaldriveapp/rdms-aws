<?php
$fuelList = unserialize(FUAL);
$fuel = $fuelList[$trackingVehicles['val_fuel']];
?>
<div class="wrapper" style="margin-bottom: 20px;">
     <table style="border-bottom: 2px solid #ffcb05;margin-bottom: 10px;">
          <tr>
               <td style="width: 200px;"><img src="./assets/images/logo.jpg" /></td>
               <td style="width: 250px;padding-left: 60px;">GATE PASS</td>
               <td style="width: 250px;"><?php echo isset($showRoom['shr_address']) ? $showRoom['shr_address'] : ''; ?></td>
          </tr>
     </table>
     <?php $driver = (isset($trackingVehicles['usr_username']) && !empty($trackingVehicles['usr_username'])) ? $trackingVehicles['usr_username'] : $trackingVehicles['trk_out_pass_other_driver']; ?>
     <div class=" inner-content">
          <table id="customers">
               <tr>
                    <td>Track number</td>
                    <td><?php echo $trackingVehicles['trk_number'] ?></td>
               </tr>
               <tr>
                    <td>Vehicle No</td>
                    <td><?php echo $trackingVehicles['val_veh_no'] ?></td>
               </tr>
               <tr>
                    <td>Vehicle</td>
                    <td><?php echo $trackingVehicles['brd_title'] . ', ' . $trackingVehicles['mod_title'] . ', ' . $trackingVehicles['var_variant_name'] . '(' . $fuel . ')'; ?></td>
               </tr>
               <tr>
                    <td>Date (OUT)</td>
                    <td><?php echo $trackingVehicles['trk_out_pass_time'] ?></td>
               </tr>
               <tr>
                    <td>Purpose</td>
                    <td><?php echo $trackingVehicles['trk_out_pass_purpose'] ?></td>
               </tr>
               <tr>
                    <td>Responsible Person</td>
                    <td>
                         <?php echo $driver; ?>
                    </td>
               </tr>
               <tr>
                    <td>Place</td>
                    <td>
                         <?php echo $trackingVehicles['trk_out_pass_to_place']; ?>
                    </td>
               </tr>
               <tr>
                    <td>KM (OUT)</td>
                    <td>
                         <?php echo $trackingVehicles['trk_out_pass_km']; ?>
                    </td>
               </tr>
               <?php if ($trackingVehicles['trk_out_pass_rd_driver'] != -2) { ?>
                    <tr>
                         <td>Estimate Arrival Date and Time</td>
                         <td>
                              <?php echo $trackingVehicles['trk_out_pass_est_return_time']; ?>
                         </td>
                    </tr>
               <?php } ?>
               <tr>
                    <td>Issued by</td>
                    <td>
                         <?php $desig = (isset($trackingVehicles['usr_emp_code']) && !empty($trackingVehicles['usr_emp_code'])) ? ' (' . $trackingVehicles['added_by_desig_title'] . ')' : '' ?>
                         <?php echo $trackingVehicles['added_first_name'] . $desig; ?>
                    </td>
               </tr>
          </table>
     </div>

     <div class="footer">
          <table style="margin-top: 40px;" id="customers">
               <tr>
                    <td style="font-size: 10px;">Signature of <?php echo $driver; ?></td>
                    <td style="font-size: 10px;padding-left: 300px">Name and the signature of the manager</td>
               </tr>
          </table>
     </div>
</div>
<div><img src="./assets/images/cut-here.png" /></div>
<div class="wrapper" style="margin-top: 30px">
     <table style="border-bottom: 2px solid #ffcb05;margin-bottom: 10px;">
          <tr>
               <td style="width: 200px;"><img src="./assets/images/logo.jpg" /></td>
               <td style="width: 250px;padding-left: 60px;">GATE PASS</td>
               <td style="width: 250px;"><?php echo isset($showRoom['shr_address']) ? $showRoom['shr_address'] : ''; ?></td>
          </tr>
     </table>

     <div class="inner-content">
          <table id="customers">
               <tr>
                    <td>Track number</td>
                    <td><?php echo $trackingVehicles['trk_number'] ?></td>
               </tr>
               <tr>
                    <td>Vehicle No</td>
                    <td><?php echo $trackingVehicles['val_veh_no'] ?></td>
               </tr>
               <tr>
                    <td>Vehicle</td>
                    <td><?php echo $trackingVehicles['brd_title'] . ', ' . $trackingVehicles['mod_title'] . ', ' . $trackingVehicles['var_variant_name'] . '(' . $fuel . ')'; ?></td>
               </tr>
               <tr>
                    <td>Date (OUT)</td>
                    <td><?php echo $trackingVehicles['trk_out_pass_time'] ?></td>
               </tr>
               <tr>
                    <td>Purpose</td>
                    <td><?php echo $trackingVehicles['trk_out_pass_purpose'] ?></td>
               </tr>
               <tr>
                    <td>Responsible Person</td>
                    <td>
                         <?php echo $driver; ?>
                    </td>
               </tr>
               <tr>
                    <td>Place</td>
                    <td>
                         <?php echo $trackingVehicles['trk_out_pass_to_place']; ?>
                    </td>
               </tr>
               <tr>
                    <td>KM (OUT)</td>
                    <td>
                         <?php echo $trackingVehicles['trk_out_pass_km']; ?>
                    </td>
               </tr>
               <?php if ($trackingVehicles['trk_out_pass_rd_driver'] != -2) { ?>
                    <tr>
                         <td>Estimate Arrival Date and Time</td>
                         <td>
                              <?php echo $trackingVehicles['trk_out_pass_est_return_time']; ?>
                         </td>
                    </tr>
               <?php } ?>
               <tr>
                    <td>Issued by</td>
                    <td>
                         <?php $desig = (isset($trackingVehicles['usr_emp_code']) && !empty($trackingVehicles['usr_emp_code'])) ? ' (' . $trackingVehicles['added_by_desig_title'] . ')' : '' ?>
                         <?php echo $trackingVehicles['added_first_name'] . $desig; ?>
                    </td>
               </tr>
          </table>
     </div>

     <div class="footer">
          <table style="margin-top: 50px;" id="customers">
               <tr>
                    <td style="font-size: 10px;">Signature of <?php echo $driver; ?></td>
                    <td style="font-size: 10px;padding-left: 300px">Name and the signature of the manager</td>
               </tr>
          </table>
     </div>
</div>
<style>
     #customers {

          border-collapse: collapse;
          width: 100%;
     }

     #customers td,
     #customers th {
          padding: 5px;
     }

     #customers th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #4CAF50;
          color: white;
     }

     body {
          margin: 40px;
          font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
          color: #000;
     }

     h1,
     p {
          margin: 0 0 1em 0;
     }

     .wrapper {
          max-width: 940px;
          margin: 0 20px;
          display: block;
     }

     @media screen and (min-width: 500px) {

          /* no grid support? */
          .content {
               float: right;
               width: 79.7872%;
          }

          .wrapper {
               margin: 0 auto;

          }

          .header,
          .footer {
               float: left;
               /* needed for the floated layout */
               clear: both;
          }

     }

     .wrapper>* {
          border-radius: 5px;
          padding: 20px;
          font-size: 150%;
          /* needed for the floated layout*/
          margin-bottom: 10px;
     }

     .cont-right span {
          float: left;
          font-size: 12px;
          width: 100%;
     }
</style>