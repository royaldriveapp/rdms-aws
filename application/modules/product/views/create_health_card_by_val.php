<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Create Health Card &nbsp;
                              <?php echo isset($valuation['val_stock_num']) ? $valuation['val_stock_num'] : ''; ?></h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                         <form class="x_content createhealth" id="myForm" action="<?php echo site_url($controller . '/saveHealthCard'); ?>" method="post">
                              <div class="row">
                                   <input type="hidden" name="hc_val_id" value="<?php echo $valuation['val_id'] ?>">
                                   <input type="hidden" name="hc_prd_id" value="0">
                                   <input type="hidden" name="hc_brd_id" value="<?php echo $valuation['val_brand'] ?>">
                                   <input type="hidden" name="hc_mod_id" value="<?php echo $valuation['val_model'] ?>">
                                   <input type="hidden" name="hc_var_id" value="<?php echo $valuation['val_variant'] ?>">
                                   <input type="hidden" name="f" value="1">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <?php echo $valuation['brd_title'] . ' | ' . $valuation['mod_title'] . ' | ' . $valuation['var_variant_name']; ?>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Reg No</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">

                                                  <?php echo $valuation['val_prt_1'] . ' | ' . $valuation['val_prt_2'] . ' | ' . $valuation['val_prt_3'] . ' | ' . $valuation['val_prt_4']; ?>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">KM Driven</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="required" type="number" class="form-control col-md-7 col-xs-12 numOnly" name="hc_km" value="<?php echo $valuation['val_km']; ?>" id="val_km" placeholder="Km">
                                                  <div class="validation-message" id="kmValidation"></div>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Ownership</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="required" class="form-control col-md-7 col-xs-12 numOnly" value="<?php echo $valuation['val_no_of_owner']; ?>" placeholder="No.of Owner(s)" type="number" name="hc_no_of_owner" id="val_no_of_owner">
                                             </div>
                                        </div>
                                   </div>

                              </div>
                              <div class="row">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Manufacture Month</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="required" type="number" class="form-control col-md-7 col-xs-12 numOnly" name="hc_minif_month" value="<?php echo $valuation['val_minif_month']; ?>" id="man_month" placeholder="Manufacture Month">
                                                  <div class="validation-message" id="errManMonth"></div>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Manufacture Year</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="required" class="form-control col-md-7 col-xs-12 numOnly" name="hc_minif_year" value="<?php echo $valuation['val_minif_year']; ?>" placeholder="Manufacture Year" type="number" id="man_year">
                                                  <div class="validation-message" id="errManYear"></div>
                                             </div>
                                        </div>
                                   </div>



                              </div>
                              <div class="row">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">Body type</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control" name="hc_veh_type" required>
                                                       <option value="">Select vehicle type</option>
                                                       <?php foreach (unserialize(ENQ_VEHICLE_TYPES) as $key => $value) { ?>
                                                            <option <?php echo ($valuation['val_veh_type'] == $key) ? 'selected="selected"' : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>
                                   </div>

                              </div>

                              <div class="row">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">Color</label>
                                             <!-- val js -->
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2 select2_group form-control" name="hc_prd_color" id="val_color">
                                                       <option value="">Select</option>
                                                       <?php foreach ($color as $key => $value) { ?>
                                                            <option <?php echo ($valuation['val_color'] == $value['vc_id']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['vc_id']; ?>">
                                                                 <?php echo $value['vc_color']; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">Fuel</label>
                                             <?php
                                             // debug(unserialize(FUAL));
                                             ?>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <!-- val js -->
                                                  <select required class="select2_group form-control bindToDropdown" name="hc_prd_fual" i="val_fuel">
                                                       <option value="">Select</option>
                                                       <?php foreach (unserialize(FUAL) as $key => $value) { ?>
                                                            <option value="<?php echo $key; ?>" <?php echo ($valuation['val_fuel'] == $key) ? 'selected="selected"' : ''; ?>>
                                                                 <?php echo $value ?> </option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>
                                   </div>

                              </div>

                              <div class="row">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Registration Date</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" value="<?php echo $valuation['val_reg_date']; ?>" name="hc_reg_date" id="reg_date" placeholder="Date" required="required">
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">ARAI
                                                  Tested
                                                  Fuel efficiency</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 " value="<?php echo $valuation['val_arai_tstd_fuel_efncy']; ?>" name="hc_arai_tstd_fuel_efncy" id="hc_arai_tstd_fuel_efncy" placeholder="Fuel efficiency" required="required">
                                                  <div class="validation-message" id="err_arai_tstd_fuel_efncy"></div>
                                             </div>
                                        </div>
                                   </div>

                              </div>

                              <div class="row">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Current On Road Price</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="" type="text" class="form-control col-md-7 col-xs-12 decimalOnly" name="hc_on_road_price" value="0.00" id="hc_on_road_price" placeholder="On Road price">
                                                  <div class="validation-message" id="err_on_road_price"></div>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">RD
                                                  Price</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="required" class="form-control col-md-7 col-xs-12 decimalOnly" value="0.00" placeholder="RD Price" type="text" name="hc_rd_price" id="rd_price">
                                                  <div class="validation-message" id="err_rd_price"></div>
                                             </div>
                                        </div>
                                   </div>

                              </div>

                              <div class="row">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Engine Capacity (CC)</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="" type="number" class="form-control col-md-7 col-xs-12 numOnly" name="hc_eng_cc" value="<?php echo $valuation['val_eng_cc']; ?>" id="val_eng_cc" placeholder="Engine Capacity (CC)">
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Power</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="required" class="form-control col-md-7 col-xs-12 numOnly" value="<?php echo $valuation['val_power']; ?>" placeholder="Power" type="number" name="hc_power" id="val_power">
                                                  <div class="validation-message" id="err_power"></div>
                                             </div>
                                        </div>
                                   </div>

                              </div>

                              <div class="row">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Torque</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="required" type="number" class="form-control col-md-7 col-xs-12 numOnly" name="hc_torque" value="<?php echo $valuation['val_torque']; ?>" id="hc_torque" placeholder="Torque">
                                                  <div class="validation-message" id="err_torque"></div>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">Transmission</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control" name="hc_transmission" id="hc_transmission">
                                                       <option value="">Select Transmission</option>
                                                       <option value="1" <?php echo ($valuation['val_transmission'] == 1) ? 'selected="selected"' : ''; ?>>
                                                            M/T</option>
                                                       <option value="2" <?php echo ($valuation['val_transmission'] == 2) ? 'selected="selected"' : ''; ?>>
                                                            A/T</option>
                                                       <option value="3" <?php echo ($valuation['val_transmission'] == 3) ? 'selected="selected"' : ''; ?>>
                                                            S/T</option>
                                                  </select>
                                             </div>
                                        </div>
                                   </div>

                              </div>

                              <div class="row">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <?php
                                             $driveTrain = unserialize(DRIVE_TRAINS);

                                             ?>
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Drive Train

                                             </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="col-md-2 col-xs-5 select2_group form-control" name="hc_drive_train" id="hc_drive_train" required>
                                                       <option value="">Select </option>
                                                       <?php foreach (unserialize(DRIVE_TRAINS) as $key => $value) { ?>
                                                            <option <?php echo ($valuation['val_drive_train'] == $key) ? 'selected="selected"' : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <?php
                                        // $insType = unserialize(INSURANCE_TYPES);
                                        //echo $insType[$valuation['val_insurance']];
                                        ?>
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Insurance
                                                  Type</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">

                                                  <select class="col-md-2 col-xs-5 select2_group form-control" name="hc_insurance" id="hc_insurance" required>
                                                       <option value="">Select Insurance Type</option>
                                                       <?php foreach (unserialize(INSURANCE_TYPES) as $key => $value) { ?>
                                                            <option <?php echo ($valuation['val_insurance'] == $key) ? 'selected="selected"' : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>
                                   </div>

                              </div>

                              <div class="row">
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  PUC Valid upto</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" value="<?php echo $valuation['val_pucc_valid'] ?>" name="hc_pucc_valid" id="hc_pucc_valid" placeholder="PUC Valid upto" required="required">
                                                  <div class="validation-message" id="err_puc_valid"></div>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Insurance
                                                  IDV</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="required" class="form-control col-md-7 col-xs-12 numOnly" value="<?php echo $valuation['val_insurance_comp_idv']; ?>" placeholder="Insurance IDV" type="text" name="hc_prd_insurance_idv" id="prd_insurance_idv">
                                                  <div class="validation-message" id="err_prd_insurance_idv"></div>
                                             </div>
                                        </div>
                                   </div>

                              </div>

                              <div class="row">

                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  <?php
                                                  $prd_insurance_validity = !empty($valuation['val_insurance_comp_date']) ?
                                                       date('d-m-Y', strtotime($valuation['val_insurance_comp_date'])) : '';
                                                  ?>
                                                  Insurance valid upto
                                             </label>

                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" value="<?php echo $prd_insurance_validity; ?>" name="hc_prd_insurance_validity" id="hc_prd_insurance_validity" placeholder="Insurance Valid upto" required="required">
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Warranty Date</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" value="<?php echo $valuation['val_wrnty_validity'] ?>" name="hc_wrnty_validity" id="hc_wrnty_validity" placeholder="Warranty Validiy">
                                             </div>
                                        </div>
                                   </div>

                              </div>

                              <div class="row">

                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Warranty KM</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 numOnly" value="<?php echo $valuation['val_wrnty_km'] ?>" name="hc_wrnty_km" id="hc_wrnty_km" placeholder="Warranty KM">
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Warranty Type</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $valuation['val_wrnty_type'] ?>" name="hc_wrnty_type" id="hc_wrnty_type" placeholder="Warranty Type">
                                             </div>
                                        </div>
                                   </div>

                              </div>

                              <div class="row">
                                   <hr><span>
                                        <center>Service Package</center>
                                   </span>
                                   <div class="col-sm-4">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Valid upto</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" value="<?php echo $valuation['val_wrnty_nxt_ser_date'] ?>" name="hc_wrnty_nxt_ser_date" id="hc_wrnty_nxt_ser_date" placeholder="Warranty Next Service date">
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-4">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  KM</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-7 col-xs-12 " value="<?php echo $valuation['val_wrnty_nxt_ser_km'] ?>" name="hc_wrnty_nxt_ser_km" id="hc_wrnty_nxt_ser_km" placeholder="Warranty Next Service KM">
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-4">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Service Type</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-12 col-xs-12 " value="<?php echo $valuation['val_service_type'] ?>" name="hc_service_type" id="hc_service_type" placeholder="Service Type">
                                             </div>
                                        </div>
                                   </div>

                              </div>
                              <div class="row">
                                   <hr><span>
                                        <center>Service Details</center>
                                   </span>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Last Service Done date</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-12 col-xs-12 dtpDatePickerEvaluation" value="<?php echo $valuation['val_last_service'] ?>" name="hc_last_service" id="hc_last_service" placeholder="Last Service Done date" required="required">
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Last Service Done KM</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-12 col-xs-12 " value="<?php echo $valuation['val_last_service_km'] ?>" name="hc_last_service_km" id="hc_last_service_km" placeholder="Last Service Done KM" required="required">
                                             </div>
                                        </div>
                                   </div>


                              </div>


                              <div class="row">

                                   <div class="col-sm-4">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Last Service done at (Service centre)</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-12 col-xs-12 " value="<?php echo $valuation['val_lst_service_place'] ?>" name="hc_lst_service_place" id="hc_lst_service_place" placeholder="Last Service done at (Service centre)">
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-sm-4">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Next Service due Date</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-12 col-xs-12 dtpDatePickerEvaluation" value="<?php echo $valuation['val_next_serv_date'] ?>" name="hc_next_serv_date" id="hc_next_serv_date" placeholder="Next Service due Date">
                                             </div>
                                        </div>
                                   </div>

                                   <div class="col-sm-4">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Next Service KM</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" class="form-control col-md-12 col-xs-12 " value="<?php echo $valuation['val_next_serv_km'] ?>" name="hc_next_serv_km" id="hc_next_serv_km" placeholder="Next Service KM">
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div class="row">
                                   <hr><span>
                                        <center>Additional Service Information</center>
                                   </span>
                                   <div class="col-sm-12">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Details</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <textarea class="form-control col-md-12 col-xs-12 " name="hc_additonal_serv_info">
                                   <?php echo $valuation['val_additonal_serv_info'] ?>
                                   </textarea>
                                             </div>
                                        </div>
                                   </div>



                              </div>
                              <div class="row">
                                   <hr><span>
                                        <center>Details of any Claim/ Replace</center>
                                   </span>
                                   <div class="col-sm-12">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Details</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <textarea class="form-control col-md-12 col-xs-12 " name="hc_calim_or_replace">
                                   <?php echo $valuation['val_calim_or_replace'] ?>
                                   </textarea>
                                             </div>
                                        </div>
                                   </div>



                              </div>

                              <div class="row">
                                   <table class="table table-striped table-bordered">
                                        <thead>
                                             <tr>
                                                  <th colspan="10" style="text-align: center;font-size: 20px;">
                                                       Tire and spare tire information
                                                  </th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                  <td class="td-head"> Tire - FR</td>
                                                  <td>
                                                       <select name="valuation[val_tyre_2_com]" id="val_tyre_2_com" class="form-control col-md-7 col-xs-12">
                                                            <option value="0">Company</option>
                                                            <?php if (!empty($tyre)) {
                                                                 foreach ($tyre as $key => $tyr) { ?>
                                                                      <option value="<?php echo $tyr['tyc_id']; ?>">
                                                                           <?php echo $tyr['tyc_name']; ?></option>
                                                            <?php }
                                                            } ?>
                                                       </select>
                                                  </td>
                                                  <!-- <td>
                                                       <input value="<?php echo $valuation['val_tyre_2_wek']; ?>" required class="form-control" type="text" id="val_tyre_2_wek" name="valuation[val_tyre_2_wek]" placeholder="Week" />
                                                  </td> -->
                                                  <td>
                                                       <input value="<?php echo $valuation['val_tyre_2_yer']; ?>" required class="form-control" type="text" id="val_tyre_2_yer" name="valuation[val_tyre_2_yer]" placeholder="Year">
                                                  </td>
                                                  <td>
                                                       <input value="<?php echo $valuation['val_tyre_2']; ?>" required class="form-control" type="text" id="val_tyre_2_per" name="valuation[val_tyre_2]" placeholder="Percentage">
                                                  </td>

                                                  <td class="td-head"> Tire - FL</td>
                                                  <td>
                                                       <select name="valuation[val_tyre_1_com]" id="val_tyre_1_com" class="form-control col-md-7 col-xs-12">
                                                            <option value="0">Company</option>
                                                            <?php if (!empty($tyre)) {
                                                                 foreach ($tyre as $key => $tyr) { ?>
                                                                      <option value="<?php echo $tyr['tyc_id']; ?>">
                                                                           <?php echo $tyr['tyc_name']; ?></option>
                                                            <?php }
                                                            } ?>
                                                       </select>
                                                  </td>
                                                  <!-- <td>
                                                       <input value="<?php echo $valuation['val_tyre_1_wek']; ?>" required class="form-control" type="text" id="val_tyre_1_wek" name="valuation[val_tyre_1_wek]" placeholder="Week">
                                                  </td> -->
                                                  <td>
                                                       <input value="<?php echo $valuation['val_tyre_1_yer']; ?>" required class="form-control" type="text" id="val_tyre_1_yer" name="valuation[val_tyre_1_yer]" placeholder="Year">
                                                  </td>
                                                  <td>
                                                       <input value="<?php echo $valuation['val_tyre_1']; ?>" required class="form-control" type="text" id="val_tyre_1_per" name="valuation[val_tyre_1]" placeholder="Percentage">
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td class="td-head"> Tire - RR</td>
                                                  <td>
                                                       <select name="valuation[val_tyre_4_com]" id="val_tyre_4_com" class="form-control col-md-7 col-xs-12">
                                                            <option value="0">Company</option>
                                                            <?php if (!empty($tyre)) {
                                                                 foreach ($tyre as $key => $tyr) { ?>
                                                                      <option value="<?php echo $tyr['tyc_id']; ?>">
                                                                           <?php echo $tyr['tyc_name']; ?></option>
                                                            <?php }
                                                            } ?>
                                                       </select>
                                                  </td>
                                                  <!-- <td>
                                                       <input value="<?php echo $valuation['val_tyre_4_wek']; ?>" required class="form-control" type="text" id="val_tyre_4_wek" name="valuation[val_tyre_4_wek]" placeholder="Week">
                                                  </td> -->
                                                  <td>
                                                       <input value="<?php echo $valuation['val_tyre_4_yer']; ?>" required class="form-control" type="text" id="val_tyre_4_yer" name="valuation[val_tyre_4_yer]" placeholder="Year">
                                                  </td>
                                                  <td>
                                                       <input value="<?php echo $valuation['val_tyre_4']; ?>" required class="form-control" type="text" id="val_tyre_4_per" name="valuation[val_tyre_4]" placeholder="Percentage">
                                                  </td>

                                                  <td style="width: 90px;" class="td-head"> Tire - RL</td>
                                                  <td>
                                                       <select name="valuation[val_tyre_3_com]" id="val_tyre_3_com" class="form-control col-md-7 col-xs-12">
                                                            <option value="0">Company</option>
                                                            <?php if (!empty($tyre)) {
                                                                 foreach ($tyre as $key => $tyr) { ?>
                                                                      <option value="<?php echo $tyr['tyc_id']; ?>">
                                                                           <?php echo $tyr['tyc_name']; ?></option>
                                                            <?php }
                                                            } ?>
                                                       </select>
                                                  </td>
                                                  <!-- <td>
                                                       <input value="<?php echo $valuation['val_tyre_3_wek']; ?>" required class="form-control" type="text" id="val_tyre_3_wek" name="valuation[val_tyre_3_wek]" placeholder="Week">
                                                  </td> -->
                                                  <td>
                                                       <input value="<?php echo $valuation['val_tyre_3_yer']; ?>" required class="form-control" type="text" id="val_tyre_3_yer" name="valuation[val_tyre_3_yer]" placeholder="Year">
                                                  </td>
                                                  <td>
                                                       <input value="<?php echo $valuation['val_tyre_3']; ?>" required class="form-control" type="text" id="val_tyre_3_per" name="valuation[val_tyre_3]" placeholder="Percentage">
                                                  </td>
                                             </tr>
                                             <!--  -->
                                        </tbody>
                                   </table>
                              </div>

                              <div class="row">
                                   <table class="table table-striped table-bordered">
                                        <thead>
                                             <tr>
                                                  <th colspan="8" style="text-align: center;font-size: 20px;">
                                                       Breakpad
                                                  </th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                  <td class="td-head"> FL</td>
                                                  <td>
                                                       <input value="0.00" class="form-control numOnly" type="number" id="val_bp_fl" name="valuation[val_bp_fl]" placeholder="FL">
                                                  </td>
                                                  <td class="td-head"> FR</td>
                                                  <td>
                                                       <input value="0.00" class="form-control numOnly" type="number" id="val_bp_fr" name="valuation[val_bp_fr]" placeholder="FR">
                                                  </td>
                                                  <td class="td-head"> RL</td>
                                                  <td>
                                                       <input value="0.00" class="form-control numOnly" type="number" id="val_bp_rl" name="valuation[val_bp_rl]" placeholder="RL">
                                                  </td>

                                                  <td class="td-head"> RR</td>
                                                  <td>
                                                       <input value="0.00" class="form-control numOnly" type="number" id="val_bp_rr" name="valuation[val_bp_rr]" placeholder="RR">
                                                  </td>

                                             </tr>


                                        </tbody>
                                   </table>
                              </div>

                              <div class="row">
                                   <table class="table table-striped table-bordered">
                                        <thead>
                                             <tr>
                                                  <th colspan="8" style="text-align: center;font-size: 20px;">
                                                       Battery
                                                  </th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                  <td class="td-head"> Brand</td>
                                                  <td>
                                                       <input value="" class="form-control " type="text" id="val_battery_make" name="valuation[val_battery_make]" placeholder="Brand">
                                                  </td>
                                                  <td class="td-head"> Warranty upto</td>
                                                  <td>
                                                       <input value="0" class="form-control dtpDatePickerEvaluation txtNxtServiceDate" type="text" id="val_battery_warranty" name="valuation[val_battery_warranty]" placeholder="Warranty upto">
                                                  </td>
                                                  <td class="td-head"> Current Capacity</td>
                                                  <td>
                                                       <input value="" class="form-control" type="text" id="val_current_capacity" name="valuation[val_current_capacity]" placeholder="Current Capacity">
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td class="td-head"> Year</td>
                                                  <td>
                                                       <input value="" class="form-control numOnly" type="number" id="hcb_battery_year" name="valuation[hcb_battery_year]" placeholder="Year">
                                                  </td>

                                             </tr>

                                        </tbody>
                                   </table>
                              </div>
                              <div class="row">
                                   <table class="table table-striped table-bordered">
                                        <thead>
                                             <tr>
                                                  <th style="text-align: center;font-size: 20px;" colspan="10">
                                                       Refurbish Details
                                                  </th>
                                             </tr>
                                        </thead>
                                        <tbody class="tbUpgradDet">
                                             <?php if (!empty($refurbDetails)) {
                                                  foreach ($refurbDetails as $key => $value) {
                                             ?>
                                                       <tr>
                                                            <td><input name="upgradedetails[rf_id][]" class="txtUpgradDetKey" type="checkbox" style="width: 100%;" value="<?php echo $value->upgrd_id; ?>"></td>

                                                            <td> <?php echo $value->upgrd_key; ?>
                                                                 <input name="upgradedetails[upgrd_key][]" class="txtUpgradDetKey" value="<?php echo $value->upgrd_key; ?>" type="hidden">
                                                            </td>
                                                            <!-- <td><?php echo get_in_currency_format($value->upgrd_value); ?></td> -->
                                                       </tr>
                                             <?php }
                                             } ?>
                                        </tbody>
                                   </table>
                              </div>

                              <div class="row">
                                   <!-- <hr><span><center>Details of any Claim/ Replace</center></span> -->
                                   <div class="col-sm-12">
                                        <div class="form-group">
                                             <label class="control-label col-md-4 col-sm-3 col-xs-12">
                                                  Disclaimer</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <textarea class="form-control col-md-12 col-xs-12 " name="disclaimer">
                                   <?php echo $valuation['val_calim_or_replace'] ?>
                                   </textarea>

                                             </div>
                                        </div>
                                   </div>



                              </div>

                              <!-- <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12">Division</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select required="" class="select2_group form-control cmbBindShowroomByDivision" name="valuation[val_division]" id="vreg_division" data-url="https://rdms.royaldrive.in/index.php/enquiry/bindShowroomByDivision" data-bind="cmbShowroom" data-dflt-select="Select Showroom">
                                                    <option value="">Select division</option>
                                                                                                            <option value="1">
                                                            Smart</option>
                                                                                                            <option value="2">
                                                            luxury</option>
                                                                                                            <option value="3">
                                                            Care</option>
                                                                                                            <option value="4">
                                                            Store</option>
                                                                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">Procurement Staff</label>
                                                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select required="" id="cmbRegisterAssignTo" class="cmbRegisterAssignTo select2_group form-control enq_se_id" name="valuation[val_sales_officer]">
                                                    <option value="0">Select Procurement Staff</option>
                                                                                                            <option value="966">
                                                            Abbas V A</option>
                                                                                                            <option value="817">
                                                            Abdul Azees</option>
                                                                                                            <option value="11037">
                                                            Abhilash Pillai</option>
                                                                                                            <option value="938">
                                                            Abhirami  S</option>
                                                                                                            <option value="11041">
                                                       
                                                                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                              <div id="response-message"></div>

                              <div class="ln_solid"></div>
                              <div class="form-group">
                                   <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                   </div>
                              </div>
                              <?php echo form_close() ?>
                    </div>
               </div>
          </div>
     </div>
</div>
<style>
     .validation-message {
          color: red;
     }
</style>
<script>
     function validateForm() {
          var kmValue = document.getElementById("val_km").value;
          var ownerValue = document.getElementById("val_no_of_owner").value;
          var man_month = document.getElementById("man_month").value;
          var man_year = document.getElementById("man_year").value;
          var hc_torque = document.getElementById("hc_torque").value;
          var hc_arai_tstd_fuel_efncy = document.getElementById("hc_arai_tstd_fuel_efncy").value;
          var base_url = "<?php echo site_url('/'); ?>";

          if (kmValue <= 0) {
               document.getElementById("kmValidation").innerHTML = "KM must be greater than zero";
               return false;
          } else {
               document.getElementById("kmValidation").innerHTML = "";
          }

          if (ownerValue <= 0) {
               document.getElementById("ownerValidation").innerHTML = "Number of owners must be greater than zero";
               return false;
          } else {
               document.getElementById("ownerValidation").innerHTML = "";
          }

          if (man_month <= 0) {
               document.getElementById("errManMonth").innerHTML = "This field is required";
               return false;
          } else {
               document.getElementById("errManMonth").innerHTML = "";
          }
          if (man_year <= 0) {
               document.getElementById("errManYear").innerHTML = "This field is required";
               return false;
          } else {
               document.getElementById("errManYear").innerHTML = "";
          }

          if (hc_arai_tstd_fuel_efncy <= 0) {
               document.getElementById("err_arai_tstd_fuel_efncy").innerHTML = "This field is required";
               return false;
          } else {
               document.getElementById("err_arai_tstd_fuel_efncy").innerHTML = "";
          }

          if (hc_torque <= 0) {
               document.getElementById("err_torque").innerHTML = "Torque field is required";
               return false;
          } else {
               document.getElementById("err_torque").innerHTML = "";
          }



          return true;
     }


     $(document).ready(function() {
          $('form').submit(function(event) {
               event.preventDefault();
               // Disable the submit button
               $('button[type="submit"]').prop('disabled', true);
               $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                         if (response.success) {
                              // Success message
                              $('#response-message').html('<div class="alert alert-success">' +
                                   response.message + '</div>');
                              // Redirect to the specified URL after a short delay (e.g., 2 seconds)
                              setTimeout(function() {
                                   window.location.href = response.url;
                              }, 2000);
                         } else {
                              // Error message
                              $('#response-message').html('<div class="alert alert-danger">' +
                                   response.message + '</div>');
                              setTimeout(function() {
                                   $('#response-message').html('');
                              }, 5000);
                         }
                    },
                    error: function() {
                         console.log('AJAX request failed');
                    },
                    complete: function() {
                         // Enable the submit button after the request is complete
                         $('button[type="submit"]').prop('disabled', false);
                    }
               });
          });
     });
</script>                                                   Abdul Azees</option>
                                                                                                            <option value="11037">
                                                            Abhilash Pillai</option>
                                                                                                            <option value="938">
                                                            Abhirami  S</option>
                                                                                                            <option value="11041">
                                                       
                                                                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                        <div id="response-message"></div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.validation-message {
    color: red;
}
</style>
<script>
function validateForm() {
    var kmValue = document.getElementById("val_km").value;
    var ownerValue = document.getElementById("val_no_of_owner").value;
    var man_month = document.getElementById("man_month").value;
    var man_year = document.getElementById("man_year").value;
    var hc_torque = document.getElementById("hc_torque").value;
    var hc_arai_tstd_fuel_efncy = document.getElementById("hc_arai_tstd_fuel_efncy").value;
    var base_url = "<?php echo site_url('/'); ?>";

    if (kmValue <= 0) {
        document.getElementById("kmValidation").innerHTML = "KM must be greater than zero";
        return false;
    } else {
        document.getElementById("kmValidation").innerHTML = "";
    }

    if (ownerValue <= 0) {
        document.getElementById("ownerValidation").innerHTML = "Number of owners must be greater than zero";
        return false;
    } else {
        document.getElementById("ownerValidation").innerHTML = "";
    }

    if (man_month <= 0) {
        document.getElementById("errManMonth").innerHTML = "This field is required";
        return false;
    } else {
        document.getElementById("errManMonth").innerHTML = "";
    }
    if (man_year <= 0) {
        document.getElementById("errManYear").innerHTML = "This field is required";
        return false;
    } else {
        document.getElementById("errManYear").innerHTML = "";
    }

    if (hc_arai_tstd_fuel_efncy <= 0) {
        document.getElementById("err_arai_tstd_fuel_efncy").innerHTML = "This field is required";
        return false;
    } else {
        document.getElementById("err_arai_tstd_fuel_efncy").innerHTML = "";
    }

    if (hc_torque <= 0) {
        document.getElementById("err_torque").innerHTML = "Torque field is required";
        return false;
    } else {
        document.getElementById("err_torque").innerHTML = "";
    }



    return true;
}


$(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault();
        // Disable the submit button
        $('button[type="submit"]').prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Success message
                    $('#response-message').html('<div class="alert alert-success">' +
                        response.message + '</div>');
                    // Redirect to the specified URL after a short delay (e.g., 2 seconds)
                    setTimeout(function() {
                        window.location.href = response.url;
                    }, 2000);
                } else {
                    // Error message
                    $('#response-message').html('<div class="alert alert-danger">' +
                        response.message + '</div>');
                    setTimeout(function() {
                        $('#response-message').html('');
                    }, 5000);
                }
            },
            error: function() {
                console.log('AJAX request failed');
            },
            complete: function() {
                // Enable the submit button after the request is complete
                $('button[type="submit"]').prop('disabled', false);
            }
        });
    });
});
</script>