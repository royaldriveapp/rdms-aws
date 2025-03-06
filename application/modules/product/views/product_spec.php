<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <style>
               .tdSpec{
                    font-size: 18px;width: 30%;padding-left: 50px;padding-bottom: 30px;
               }
          </style>
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_content">
                         <div class="row">
                              <div class="col-md-12 col-sm-12">
                                   <div class="x_panel tile">
                                        <div class="x_content">
                                             <div style="text-align: center;">
                                                  <?php if ($product_details['prd_rd_mini'] == 1) { ?>
                                                       <img src="https://www.royaldrivesmart.in/assets/images/smart-logo-spec.jpg" style="float: left;"/>
                                                  <?php } else { ?>
                                                       <img src="https://www.cust.royaldrive.in/assets/images/logo-royal-drive.png" style="float: left;"/>
                                                  <?php } ?>
                                                  <p style="font-size: 30px;font-weight: bolder;padding-top: 25px;"><strong>SPEC SHEET</strong></p>
                                                  <p style="padding-top: 50px;padding-left: 30px;">
                                                  <table border="0" style="border-collapse: collapse;width: 100%;" id="">
                                                       <tr>
                                                            <td class="tdSpec"><strong>MAKE</strong></td>
                                                            <td class="tdSpec"><strong><?php echo $product_details['brd_title']; ?></strong></td>
                                                       </tr>
                                                       <tr>
                                                            <td class="tdSpec"><strong>MODEL VARIANT</strong></td>
                                                            <td class="tdSpec"><strong><?php echo $product_details['mod_title'] . ' ' . $product_details['var_variant_name']; ?></strong></td>
                                                       </tr>

                                                       <tr>
                                                            <td class="tdSpec"><strong>FUEL</strong></td>
                                                            <td class="tdSpec">
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
                                                            <td class="tdSpec"><strong>KM</strong></td>
                                                            <td class="tdSpec"><strong><?php echo inr_currency_format($product_details['prd_km_run'], false); ?></strong></td>
                                                       </tr>

                                                       <tr>
                                                            <td class="tdSpec"><strong>MANUFACTURE YEAR</strong></td>
                                                            <td class="tdSpec"><strong><?php echo $product_details['prd_year']; ?></strong></td>
                                                       </tr>

                                                       <tr>
                                                            <td class="tdSpec"><strong>OWNERSHIP</strong></td>
                                                            <td class="tdSpec"><strong><?php echo get_ownership_text($product_details['prd_owner']); ?></strong></td>
                                                       </tr>

                                                       <tr>
                                                            <td class="tdSpec"><strong>INSURANCE VALID UP TO</strong></td>
                                                            <td class="tdSpec"><strong><?php echo $product_details['prd_insurance_validity']; ?></strong></td>
                                                       </tr>

                                                       <tr>
                                                            <td class="tdSpec"><strong>INSURANCE IDV</strong></td>
                                                            <td class="tdSpec"><strong><?php echo inr_currency_format($product_details['prd_insurance_idv']); ?></strong></td>
                                                       </tr>

                                                       <tr>
                                                            <td class="tdSpec"><strong>FINAL PRICE</strong></td>
                                                            <td class="tdSpec"><strong><?php echo ($product_details['prd_price'] > 0) ? inr_currency_format($product_details['prd_price']) : ''; ?></strong></td>
                                                       </tr>
                                                  </table>
                                                  <?php if(isset($product_specification) && !empty($product_specification)) { ?>
                                                       <h2><u>Special Features<u></h2>
                                                       <table border="0" style="border-collapse: collapse;width: 100%;" id="">
                                                            <?php foreach ($product_specification as $key => $value) { ?>
                                                                 <tr>
                                                                      <td class="tdSpec">
                                                                           <?php if(!empty($value['spe_specification'])) { ?>
                                                                                <strong> 
                                                                                     <img src="https://cust.royaldrive.in/assets/images/carpix.png" width="50"/>
                                                                                     <?php echo $value['spe_specification']; ?>
                                                                                </strong>
                                                                           <?php } ?>
                                                                      </td>
                                                                      <td class="tdSpec">
                                                                           <?php if(!empty($value['spe_specification_detail'])) { ?>
                                                                                <strong>
                                                                                     <img src="https://cust.royaldrive.in/assets/images/carpix.png" width="50"/>
                                                                                     <?php echo $value['spe_specification_detail']; ?>
                                                                                </strong>
                                                                           <?php } ?>
                                                                      </td>
                                                                 </tr>
                                                            <?php } ?>
                                                       </table>
                                                  <?php } ?>
                                                  </p>
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