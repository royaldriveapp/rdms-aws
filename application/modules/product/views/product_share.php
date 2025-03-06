<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo $product_details['prd_number'] . ': ' . $product_details['brd_title'] . ', ' . $product_details['mod_title'] . ', ' . $product_details['var_variant_name']; ?>
                        <small class="red">*Please check and verify before share the content.</small>
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                         $trans = unserialize(TRANSMISSIONS);
                         $trans = isset($trans[$product_details['prd_transmission']]) ? $trans[$product_details['prd_transmission']] : '';

                         $location = '';
                         $name = $product_details['brd_title'] . ' ' . $product_details['mod_title'] . ' ' . $product_details['var_variant_name'];
                         $location = isset($product_details['shr_location']) ? $product_details['shr_location'] : '';
                         if ($product_details['prd_rd_mini'] == 1) {
                              $url = 'https://royaldrivesmart.in/vehicle/' . $product_details['prd_id'] . '-' . get_url_string($name);
                              $location = empty($location) ? 'Malappuram' : $location;
                         } else {
                              $url = 'https://royaldrive.in/' . $product_details['brd_slug'] . '/' . get_url_string($name) . '-' . $product_details['prd_id'];
                              $location = empty($location) ? 'Calicut' : $location;
                         }

                         $fuel = unserialize(FUAL);
                         $model = !empty($product_details['prd_year']) ? $product_details['prd_year'] : $valuation['val_model_year'];
                         $fual = isset($fuel[$product_details['prd_fual']]) ? $fuel[$product_details['prd_fual']] : '';

                         if ($product_details['prd_rd_mini'] == 1) {
                              $otherFet = '💯 Design Features : ' . strip_tags($product_details['prd_desc']) . '%0a 💯 Safty Features : ' .
                                   strip_tags($product_details['prd_safety_feture']) . '%0a 💯 Comfort and Convenience Features : ' .
                                   strip_tags($product_details['prd_cmfort_cnvnent_feture']) . '%0a';
                         } else {
                              $otherFet = '💯 Benefits : ' . strip_tags($product_details['prd_desc']) . '%0a';
                         }
                         $warranty = !empty($product_details['prd_warranty_upto']) ? '🛡️Warranty upto : ' . $product_details['prd_warranty_upto'] . '%0a' : '';
                         $tcs = '';
                         if ($product_details['prd_price'] >= 1000000) {
                              $tcs = ' + 1% TCS';
                         }
                         $msgWithtPrice = $message = '🚘 Vehicle : ' . $product_details['brd_title'] . '%0a' .
                              '👉 Option  : ' . $product_details['mod_title'] . ' ' . $product_details['var_variant_name'] . '%0a' .
                              '📅 Model   : ' . $model . '%0a' .
                              '⛽ Fuel    : ' . $fual . '%0a' .
                              '⚙️ Transmission  : ' . $trans . '%0a' .
                              '🌈 Colour  : ' . $product_details['prd_color'] . ' ' . $product_details['prd_wrapp_color'] . '%0a' .
                              '🚧 KM      :  ' . inr_currency_format($product_details['prd_km_run'], false) . '%0a' . $otherFet .
                              '🙋🏻‍♂ Ownership : ' . get_ownership_text($product_details['prd_owner']) . '%0a' .
                              '📅 Insurance  : ' . $product_details['prd_insurance_validity'] . '%0a' .
                              '🛣 Location : Royal Drive ' . $location . '%0a' . $warranty .
                              '📶 https://royaldrive.in, https://royaldrivesmart.in %0a' .
                              '📞 +91 812990 9090 %0a' .
                              '🌐 ' . $url . ' %0a' .
                              '🌐  https://cust.royaldrive.in/rd-app-qr%0a%0a RD PRICE : *' . inr_currency_format($product_details['prd_price']) . $tcs . '*';

                         // if (($product_details['prd_rd_mini'] != 1) && ($product_details['prd_price'] > 0) && ($product_details['prd_show_price'] == 1)) { //Luxury
                         //      $message = $message . '%0a%0a RD PRICE : *' . inr_currency_format($product_details['prd_price']) . $tcs . '*';
                         // }
                         ?>
                    <!-- '📞 +91 953906 9090 (Kochi) %0a' . '📞 +91 735690 6060 (Malappuram) %0a' . -->
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="x_panel tile">
                                <div class="x_title">
                                    <h2>Vehicle details</h2>
                                    <ul class="nav navbar-right panel_toolbox">


                                        <li style="float: right;">
                                            <a title="Health card" style="color: green;" target="_blank"
                                                href="<?php echo site_url('product/healthcard_luxury/' . $product_details['prd_id']); ?>">
                                                <i class='fa fa-ambulance' style='font-size:22px'></i> <b>Health
                                                    Card</b>
                                            </a>
                                        </li>


                                        <li style="float: right;">
                                            <a title="Download spec" target="_blank"
                                                href="<?php echo site_url('product/downloadspec/' . $product_details['prd_id']); ?>">
                                                <img width="20" title="Export to excel" src="images/pdf.png" />
                                            </a>
                                        </li>
                                        <li>
                                            <a title="Share on whatsapp" style="color: green;" target="_blank"
                                                href="https://api.whatsapp.com/send/?text=<?php echo $message; ?>">
                                                <i style="font-size: 23px;" class="fa fa-whatsapp"></i>
                                            </a>
                                        </li>
                                        <?php if (check_permission('product', 'view')) { ?>
                                        <li>
                                            <a title="Update product" style="color: green;" target="_blank"
                                                href="<?php echo site_url('product/view/' . $product_details['prd_id']); ?>">
                                                <i style="font-size: 23px;" class="fa fa-pencil-square-o"></i>
                                            </a>
                                        </li>
                                        <?php }
                                                  if (check_permission('product', 'index')) { ?>
                                        <li>
                                            <a title="List product" style="color: green;" target="_blank"
                                                href="<?php echo site_url('product'); ?>">
                                                <i style="font-size: 23px;" class="fa fa-list"></i>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div>
                                        <?php
                                                  if ($product_details['prd_rd_mini'] == 1) {
                                                       echo str_replace('%0a', '<br>', $message) . '';
                                                       echo '<br><br> RD PRICE : *' . inr_currency_format($product_details['prd_price']) . $tcs . '*';
                                                  } else {
                                                       echo str_replace('%0a', '<br>', $message);
                                                  }
                                                  ?>
                                    </div>
                                    <?php if (check_permission('product', 'update')) { ?>
                                    <div
                                        style="background: #ece8e8;float: left;width: 100%;margin-top: 20px;padding: 13px 6px 6px 6px;">
                                        <div class="form-group">
                                            <label for="enq_cus_test_drive" style="font-size: 18px;"
                                                class="control-label col-md-8 col-sm-6 col-xs-12">
                                                Please verify to publish website
                                            </label>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <input for="status"
                                                    data-url="<?php echo site_url('product/changesCheckBoxFields/prd_status/' . $product_details['prd_id']) ?>"
                                                    class="js-switch chkStatus" type="checkbox" name="chkStatus"
                                                    value="<?php echo $product_details['prd_status']; ?>"
                                                    <?php echo ($product_details['prd_status'] == 1) ? "checked" : ''; ?> />
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <!-- -->
                        <?php if (check_permission('product', 'show_google_share')) {

                                   $cnt = (isset($product_details['brd_hash_tag']) && !empty($product_details['brd_hash_tag'])) ? $product_details['brd_hash_tag'] . '<br>' : '';
                                   $cnt = $cnt . str_replace('%0a', '<br>', $msgWithtPrice);

                              ?>
                        <div class="col-md-6 col-sm-6">
                            <div class="x_panel tile">
                                <div class="x_title">
                                    <h2>Product Share On Google</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li style="float: right;">
                                            <i style="font-size: 23px;" class="fa fa-copy btnCoppy"
                                                data-section=".divShareGoogle"></i>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content divShareGoogle">
                                    <div><?php echo $cnt; ?></div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- -->

                        <div class="col-md-6 col-sm-6">
                            <div class="x_panel tile">
                                <div class="x_title">
                                    <h2>Vehicle images</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li style="float: right;">
                                            <a title="Download all images" style="color: green;" target="_blank"
                                                href="<?php echo site_url('product/downloadimagezip/' . encryptor($product_details['prd_id'])); ?>">
                                                <i style="font-size: 23px;" class="fa fa-download"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <?php
                                             if (!empty($product_images)) {
                                                  foreach ($product_images as $key => $value) {
                                                       //if (file_exists('../assets/uploads/product/380X238_' . $value['pdi_image'])) {PRODUCT_BASE_URL
                                             ?>
                                    <div class="col-md-6">
                                        <div class="thumbnail" style="height: auto;">
                                            <div class="image view view-first">
                                                <?php echo img(array('style' => 'width: -webkit-fill-available;', 'src' => PRODUCT_BASE_URL . $value['pdi_image'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                                       //}
                                                  }
                                             }
                                             ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>