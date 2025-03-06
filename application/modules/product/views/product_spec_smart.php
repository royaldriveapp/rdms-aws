<div class="right_col" role="main">
     <!--width: 800px;border: 1px solid red;-->
     <div class="clearfix"></div>
     <div class="row">
          <style>
               .tdSpec{font-size: 15px;padding-left: 5px;padding-bottom: 15px;}
          </style>
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_content">
                         <div class="row">
                              <div class="col-md-12 col-sm-12">
                                   <div class="x_panel tile">
                                        <div class="x_content">
                                             <div style="text-align: center;">
                                                  <?php 
                                                       $name = $product_details['brd_title'] . ' ' . $product_details['mod_title'] . ' ' . $product_details['var_variant_name'];
                                                       $location = isset($product_details['shr_location']) ? $product_details['shr_location'] : '';
                                                       $url = 'https://www.royaldrivesmart.in/vehicle/' . $product_details['prd_id'] . '-' . get_url_string($name);
                                                  ?>
                                                  <table border="0" style="border-collapse: collapse;width: 100%;">
                                                       <tr>
                                                            <td><img src="https://www.royaldrivesmart.in/assets/images/smart-logo-spec.jpg" style="float: left;"/></td>
                                                            <td>
                                                                 <p style="font-size: 30px;font-weight: bolder;padding-top: 25px;"><strong>SPEC SHEET</strong></p>
                                                            </td>
                                                            <td style="text-align: right;">
                                                                 <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?php echo $url; ?>"/>
                                                            </td>
                                                       </tr>
                                                  </table>
                                                  <table border="1" style="border-collapse: collapse;width: 100%;">
                                                       <tr>
                                                            <td class="tdSpec"><strong>MAKE</strong></td>
                                                            <td class="tdSpec" style="text-align:center;"><strong><?php echo $product_details['brd_title']; ?></strong></td>
                                                            <td class="tdSpec"><strong>MODEL VARIANT</strong></td>
                                                            <td class="tdSpec" style="text-align:center;"><strong><?php echo $product_details['mod_title'] . ' ' . $product_details['var_variant_name']; ?></strong></td>
                                                       </tr>
                                                       <tr>
                                                            <td class="tdSpec"><strong>TRANSMISSION</strong></td>
                                                            <td class="tdSpec" style="text-align:center;">
                                                                 <strong>
                                                                      <?php
                                                                      $trans = unserialize(TRANSMISSIONS);
                                                                      $trans = isset($trans[$product_details['prd_transmission']]) ? $trans[$product_details['prd_transmission']] : '';
                                                                      echo $trans;
                                                                      ?>
                                                                 </strong>
                                                            </td>
                                                            <td class="tdSpec"><strong>FUEL</strong></td>
                                                            <td class="tdSpec" style="text-align:center;">
                                                                 <strong>
                                                                      <?php
                                                                      $fuel = unserialize(FUAL);
                                                                      $fual = isset($fuel[$product_details['prd_fual']]) ? $fuel[$product_details['prd_fual']] : '';
                                                                      echo $fual;
                                                                      ?>
                                                                 </strong>
                                                            </td>
                                                       </tr>

                                                       <tr>
                                                            <td class="tdSpec"><strong>MANUFACTURE YEAR</strong></td>
                                                            <td class="tdSpec" style="text-align:center;"><strong><?php echo $product_details['prd_year']; ?></strong></td>
                                                            <td class="tdSpec"><strong>KM</strong></td>
                                                            <td class="tdSpec" style="text-align:center;"><strong><?php echo inr_currency_format($product_details['prd_km_run'], false); ?></strong></td>
                                                       </tr>

                                                       <tr>
                                                            <td class="tdSpec"><strong>OWNERSHIP</strong></td>
                                                            <td class="tdSpec" style="text-align:center;"><strong><?php echo get_ownership_text($product_details['prd_owner']); ?></strong></td>
                                                            <td class="tdSpec"><strong>INSURANCE VALID UP TO</strong></td>
                                                            <td class="tdSpec" style="text-align:center;"><strong><?php echo $product_details['prd_insurance_validity']; ?></strong></td>
                                                       </tr>

                                                       <tr>
                                                            <td class="tdSpec"><strong>INSURANCE IDV</strong></td>
                                                            <td class="tdSpec" style="text-align:center;">
                                                                 <?php
                                                                 if (is_numeric($product_details['prd_insurance_idv'])) {
                                                                      echo '<strong>' . inr_currency_format($product_details['prd_insurance_idv']) . '</strong>';
                                                                 } else {
                                                                      echo '<strong>' . $product_details['prd_insurance_idv'] . '</strong>';
                                                                 }
                                                                 ?>
                                                            </td>

                                                            <td class="tdSpec"><strong>INSURANCE TYPE</strong></td>
                                                            <td class="tdSpec" style="text-align:center;">
                                                                 <strong>
                                                                      <?php
                                                                      $fuel = unserialize(INSURANCE_TYPES);
                                                                      $fual = isset($fuel[$product_details['prd_insurance_type']]) ? $fuel[$product_details['prd_insurance_type']] : '';
                                                                      echo $fual;
                                                                      ?>
                                                                 </strong>
                                                            </td>
                                                       </tr>
                                                       <tr> 
                                                            <td class="tdSpec"><strong>ARAI TESTED MILEAGE</strong></td>
                                                            <td class="tdSpec" style="text-align:center;"><strong><?php echo ($product_details['prd_arai_mileage'] > 0) ? $product_details['prd_arai_mileage'] : ''; ?></strong></td>
                                                            <td class="tdSpec"><strong>WARRANTY UP TO</strong></td>
                                                            <td class="tdSpec" style="text-align:center;"><strong><?php echo $product_details['prd_warranty_upto']; ?></strong></td>
                                                       </tr>
                                                       <tr><td style="text-align: center;" class="tdSpec" colspan="4"><strong><h3>FEATURES</h3></strong></td></tr>
                                                       <tr>
                                                            <td class="tdSpec" colspan="2">DESIGN FEATURES</td>
                                                            <td class="tdSpec" colspan="2" style="font-size:14px;"><?php echo strip_tags($product_details['prd_desc']); ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td class="tdSpec" colspan="2">SAFETY FEATURES</td>
                                                            <td class="tdSpec" colspan="2" style="font-size:14px;"><?php echo strip_tags($product_details['prd_safety_feture']); ?></td>
                                                       </tr>
                                                       <tr>
                                                            <td class="tdSpec" colspan="2">COMFORT & CONVENIENCE FEATURES</td>
                                                            <td class="tdSpec" colspan="2" style="font-size:14px;"><?php echo strip_tags($product_details['prd_cmfort_cnvnent_feture']); ?></td>
                                                       </tr>
                                                       <?php if (!empty($product_details['prd_acc_ftd'])) { ?>
                                                            <tr><td style="text-align: center;" class="tdSpec" colspan="4"><strong><h3>ACCESSORIES FITTED</h3></strong></td></tr>
                                                            <tr><td style="text-align: center;" class="tdSpec" colspan="4"><?php echo strip_tags($product_details['prd_acc_ftd']); ?></td></tr>
                                                       <?php } ?>
                                                       <tr>
                                                            <td class="tdSpec" colspan="2">CURRENT ON ROAD PRICE</td>
                                                            <td class="tdSpec" colspan="2"><strong>RD PRICE</strong></td>
                                                       </tr>
                                                       <tr>
                                                            <td class="tdSpec" colspan="2"><?php echo!empty($product_details['prd_or_road_price']) ? inr_currency_format($product_details['prd_or_road_price']) : ''; ?></td>
                                                            <td class="tdSpec" colspan="2"><strong><?php echo inr_currency_format($product_details['prd_price']); ?></strong></td>
                                                       </tr>
                                                  </table>
                                                  <?php if (isset($product_specification) && !empty($product_specification)) { ?>
                                                       <h2>Special Features</h2>
                                                       <table border="0" style="border-collapse: collapse;width: 100%;">
                                                            <?php foreach ($product_specification as $key => $value) { ?>
                                                                 <tr>
                                                                      <td class="tdSpec">
                                                                           <?php if (!empty($value['spe_specification'])) { ?>
                                                                                <img src="https://cust.royaldrive.in/assets/images/carpix.png" width="50"/>
                                                                                <strong>     <?php echo $value['spe_specification']; ?></strong>
                                                                           <?php } ?>
                                                                      </td>
                                                                      <td class="tdSpec">
                                                                           <?php if (!empty($value['spe_specification_detail'])) { ?>
                                                                                <img src="https://cust.royaldrive.in/assets/images/carpix.png" width="50"/>
                                                                                <strong>     <?php echo $value['spe_specification_detail']; ?></strong>
                                                                           <?php } ?>
                                                                      </td>
                                                                 </tr>
                                                            <?php } ?>
                                                       </table>
                                                  <?php } ?>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>