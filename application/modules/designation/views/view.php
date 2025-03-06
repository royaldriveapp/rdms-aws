<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update Grade</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php 
                         //debug($data['travelEligibi']);
                         $travelEligible = array_column($data['travelEligibi'], 'dte_travel_mod');
                         echo form_open_multipart($controller . "/update", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left")) ?>
                         <input value="<?php echo $data['desig_id']; ?>" type="hidden" name="desig_id" id="id"/>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Code</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required value="<?php echo $data['desig_slug']; ?>" type="text" class="form-control col-md-7 col-xs-12" 
                                          name="desig_slug" id="grp_slug" placeholder="Code"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">name</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="desig_title" 
                                          id="grd_code" placeholder="name" value="<?php echo $data['desig_title']; ?>"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Own Cars Per Km</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_own_cars_per_km" 
                                          id="grd_code" placeholder="Own Cars Per Km" value="<?php echo $data['desig_own_cars_per_km']; ?>"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Own Two Wheeler per km</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_own_two_whelr_per_km" 
                                          id="grd_code" placeholder="Own Two Wheeler per km" value="<?php echo $data['desig_own_two_whelr_per_km']; ?>"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Breakfast</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_breakfast" 
                                          id="grd_code" placeholder="Breakfast" value="<?php echo $data['desig_breakfast']; ?>"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Lunch</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_lunch" 
                                          id="grd_code" placeholder="Lunch" value="<?php echo $data['desig_lunch']; ?>"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Dinner</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_dinner" 
                                          id="grd_code" placeholder="Dinner" value="<?php echo $data['desig_dinner']; ?>"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">if above 15hrs</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_abov_fiften_hrs" 
                                          id="grd_code" placeholder="if above 15hrs" value="<?php echo $data['desig_abov_fiften_hrs']; ?>"/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Room Tariff With in Kerala</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_room_tariff_in_kl" 
                                          id="grd_code" placeholder="Room Tariff With in Kerala" value="<?php echo $data['desig_room_tariff_in_kl']; ?>"/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Room Tariff Outside Kerala</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_room_tariff_out_kl" 
                                          id="grd_code" placeholder="Room Tariff Outside Kerala" value="<?php echo $data['desig_room_tariff_out_kl']; ?>"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Travel Eligibility Inside Kerala</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control enq_se_id cmbSearchList" name="trvelig[1][]" multiple>
                                        <option value="">Travel Eligibility Inside Kerala</option>
                                        <?php foreach ($travelModes as $key => $value) { ?>
                                             <option <?php echo in_array($value['dtm_id'], $travelEligible) ? 'selected="selected"' : ''; ?> value="<?php echo $value['dtm_id']; ?>"><?php echo $value['dtm_title']; ?></option>
                                             <?php } ?>
                                   </select>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Travel Eligibility outside Kerala</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control enq_se_id cmbSearchList" name="trvelig[2][]" multiple>
                                        <option value="">Travel Eligibility outside Kerala</option>
                                        <?php foreach ($travelModes as $key => $value) { ?>
                                             <option <?php echo in_array($value['dtm_id'], $travelEligible) ? 'selected="selected"' : ''; ?> value="<?php echo $value['dtm_id']; ?>"><?php echo $value['dtm_title']; ?></option>
                                             <?php } ?>
                                   </select>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Travel Eligibility outside India</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control enq_se_id cmbSearchList" name="trvelig[3][]" multiple>
                                        <option value="">Travel Eligibility outside India</option>
                                        <?php foreach ($travelModes as $key => $value) { ?>
                                             <option <?php echo in_array($value['dtm_id'], $travelEligible) ? 'selected="selected"' : ''; ?> value="<?php echo $value['dtm_id']; ?>"><?php echo $value['dtm_title']; ?></option>
                                             <?php } ?>
                                   </select>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Local Conveyance within Kerala</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control enq_se_id cmbSearchList" name="trvelig[4][]" multiple>
                                        <option value="">Local Conveyance within Kerala</option>
                                        <?php foreach ($travelModes as $key => $value) { ?>
                                             <option <?php echo in_array($value['dtm_id'], $travelEligible) ? 'selected="selected"' : ''; ?> value="<?php echo $value['dtm_id']; ?>"><?php echo $value['dtm_title']; ?></option>
                                             <?php } ?>
                                   </select>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Local Conveyance Outside Kerala</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control enq_se_id cmbSearchList" name="trvelig[5][]" multiple>
                                        <option value="">Local Conveyance Outside Kerala</option>
                                        <?php foreach ($travelModes as $key => $value) { ?>
                                             <option <?php echo in_array($value['dtm_id'], $travelEligible) ? 'selected="selected"' : ''; ?> value="<?php echo $value['dtm_id']; ?>"><?php echo $value['dtm_title']; ?></option>
                                             <?php } ?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">JD</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input class="filDamagesFile" name="jd" type="file" style="width: 100%;" />
                              </div>
                         </div>
                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success">Submit</button>
                                   <button class="btn btn-primary" type="reset">Reset</button>
                              </div>
                         </div>
                         <?php echo form_close() ?>
                    </div>
               </div>
          </div>
     </div>
</div>