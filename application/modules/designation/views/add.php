<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New designation</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart($controller . "/add", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left"))?>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Code</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required value="" type="text" class="form-control col-md-7 col-xs-12" name="desig_slug" id="grp_slug" placeholder="Code"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">name</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" name="desig_title" id="grd_code" placeholder="name" value=""/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Own Cars Per Km</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_own_cars_per_km" 
                                          id="grd_code" placeholder="Own Cars Per Km" value=""/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Own Two Wheeler per km</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_own_two_whelr_per_km" 
                                          id="grd_code" placeholder="Own Two Wheeler per km" value=""/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Breakfast</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_breakfast" 
                                          id="grd_code" placeholder="Breakfast" value=""/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Lunch</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_lunch" 
                                          id="grd_code" placeholder="Lunch" value=""/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Dinner</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_dinner" 
                                          id="grd_code" placeholder="Dinner" value=""/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">if above 15hrs</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_abov_fiften_hrs" 
                                          id="grd_code" placeholder="if above 15hrs" value=""/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Room Tariff With in Kerala</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_room_tariff_in_kl" 
                                          id="grd_code" placeholder="Room Tariff With in Kerala" value=""/>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Room Tariff Outside Kerala</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input  type="text" class="decimalOnly form-control col-md-7 col-xs-12" name="desig_room_tariff_out_kl" 
                                          id="grd_code" placeholder="Room Tariff Outside Kerala" value=""/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Travel Eligibility Inside Kerala</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control enq_se_id cmbSearchList" name="trvelig[1][]" multiple>
                                        <option value="">Travel Eligibility Inside Kerala</option>
                                        <?php foreach ($travelModes as $key => $value) { ?>
                                             <option value="<?php echo $value['dtm_id']; ?>"><?php echo $value['dtm_title']; ?></option>
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
                                             <option value="<?php echo $value['dtm_id']; ?>"><?php echo $value['dtm_title']; ?></option>
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
                                             <option value="<?php echo $value['dtm_id']; ?>"><?php echo $value['dtm_title']; ?></option>
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
                                             <option value="<?php echo $value['dtm_id']; ?>"><?php echo $value['dtm_title']; ?></option>
                                             <?php } ?>
                                   </select>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Local Conveyance Outisde Kerala</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control enq_se_id cmbSearchList" name="trvelig[5][]" multiple>
                                        <option value="">Local Conveyance Outside Kerala</option>
                                        <?php foreach ($travelModes as $key => $value) { ?>
                                             <option value="<?php echo $value['dtm_id']; ?>"><?php echo $value['dtm_title']; ?></option>
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
                         <?php echo form_close()?>
                    </div>
               </div>
          </div>
     </div>
</div>