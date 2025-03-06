<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Check In Vehicle</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- Smart Wizard -->
                        <div class="form-horizontal form-label-left">
                            <?php echo form_open_multipart("tracking/check_in") ?>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-name">Vehicle
                                    No</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_group form-control" name="trk_vehicle_no" disabled="">
                                        <option value="">Select Registration No</option>
                                        <?php foreach ((array) $vehicles as $key => $value) { ?>
                                            <option <?php echo $value['val_id'] == $trackingVehicles['trk_vehicle_no'] ? 'selected="selected"' : ''; ?> value="<?php echo $value['val_id']; ?>">
                                                <?php echo $value['val_veh_no'] . ' ' . $value['brd_title'] . '-' . $value['mod_title'] . '-' . $value['var_variant_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date
                                    (OUT)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo $trackingVehicles['trk_out_pass_time']; ?>" id="trk_out_pass_time" name="trk_out_pass_time" type="datetime" class="form-control col-md-7 col-xs-12" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Purpose <span class="required"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo $trackingVehicles['trk_out_pass_purpose']; ?>" type="text" id="trk_out_pass_purpose" name="trk_out_pass_purpose" class="form-control col-md-7 col-xs-12" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="enq_cus_address" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle
                                    Driver (OUT)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo (isset($trackingVehicles['usr_username']) && !empty($trackingVehicles['usr_username'])) ? $trackingVehicles['usr_username'] : $trackingVehicles['trk_out_pass_other_driver']; ?>" id="trk_out_pass_other_driver" class="form-control col-md-7 col-xs-12" name="track_veh_driver_out" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="enq_cus_mobile" class="control-label col-md-3 col-sm-3 col-xs-12">Place</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo (isset($trackingVehicles['out_pass_to_location']) && !empty($trackingVehicles['out_pass_to_location'])) ? $trackingVehicles['out_pass_to_location'] : $trackingVehicles['trk_out_pass_to_place']; ?>" id="trk_out_pass_to_place" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="trk_out_pass_to_place" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="enq_cus_whatsapp" class="control-label col-md-3 col-sm-3 col-xs-12"> KM
                                    (OUT)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo $trackingVehicles['trk_out_pass_km']; ?>" id="trk_out_pass_km" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="trk_out_pass_km" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="trk_out_pass_est_return_time" class="control-label col-md-3 col-sm-3 col-xs-12">Estimate Arrival Date and
                                    Time</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo $trackingVehicles['trk_out_pass_est_return_time']; ?>" id="trk_out_pass_est_return_time" class="form-control col-md-7 col-xs-12 numOnly" type="text" name="trk_out_pass_est_return_time" placeholder="text" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a target="_blank" href="<?php echo site_url('tracking/generateOutPass/' . encryptor($trackingVehicles['trk_id'])); ?>" class="btn btn-round btn-success">Print gate pass</a>
                                    <a target="_blank" href="<?php echo site_url('tracking/trackingLog/' . encryptor($trackingVehicles['trk_vehicle_no'])); ?>" class="btn btn-round btn-success">View vehicle track list</a>
                                </div>
                            </div>
                            <div class="ln_solid"></div>

                            <div class="form-group">
                                <label for="trk_check_in_rd_driver" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle Driver</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_group form-control cmbSearchList" name="checkin[trk_check_in_rd_driver]" required="required" onchange="if ($(this).val() == -1) {
                                                                    $('.divDriver').show();
                                                                    $('#trk_check_in_other_driver').attr('required', 'required');
                                                               } else {
                                                                    $('.divDriver').hide();
                                                                    $('#trk_check_in_other_driver').removeAttr('required');
                                                               }">
                                        <option value=""> Select Staff </option>
                                        <option value="-1"> Other drivers </option>
                                        <option value="-2">Car Delivery</option>
                                        <optgroup label="Royal drive staf">
                                            <?php foreach ($stafs as $key => $value) { ?>
                                                <option <?php
                                                        if (($value['usr_id'] == $trackingVehicles['trk_out_pass_rd_driver']) ||
                                                            ($trackingVehicles['trk_check_in_rd_driver'] == $value['usr_id'])
                                                        ) {
                                                            echo 'selected="selected"';
                                                        }
                                                        ?> value="<?php echo $value['usr_id']; ?>">
                                                    <?php echo $value['usr_first_name'] . $value['usr_last_name'] . ' - ' . $value['shr_location']; ?>
                                                </option>
                                            <?php } ?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group divDriver" style="<?php echo empty($trackingVehicles['trk_check_in_other_driver']) ? 'display: none;' : '' ?>">
                                <label for="enq_cus_address" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle
                                    Driver</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo $trackingVehicles['trk_check_in_other_driver']; ?>" id="trk_check_in_other_driver" class="form-control col-md-7 col-xs-12" name="checkin[trk_check_in_other_driver]" />
                                </div>
                            </div>
                            <!-- -->
                            <div class="form-group">
                                <label for="trk_check_in_rd_showroom" class="control-label col-md-3 col-sm-3 col-xs-12">To</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_group form-control" name="checkin[trk_check_in_rd_showroom]" required="required" onchange="if ($(this).val() < 0) {
                                                                    $('.divCheckInPlace').show();
                                                                    $('#trk_check_in_other_place').attr('required', 'required');
                                                               } else {
                                                                    $('.divCheckInPlace').hide();
                                                                    $('#trk_check_in_other_place').removeAttr('required');
                                                               }">
                                        <option value=""> Select Showroom </option>
                                        <option value="-1"> Other place </option>
                                        <optgroup label="Royal drive showrooms">
                                            <?php foreach ($showrooms as $key => $value) { ?>
                                                <option <?php echo ($value['shr_id'] == $trackingVehicles['trk_check_in_rd_showroom']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['shr_id']; ?>">
                                                    <?php echo $value['shr_location'] . ' (' . $value['div_name'] . ')'; ?></option>
                                            <?php } ?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group divCheckInPlace" style="display: none;">
                                <label for="trk_check_in_other_place" class="control-label col-md-3 col-sm-3 col-xs-12">To Place</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="trk_check_in_other_place" class="form-control col-md-7 col-xs-12" type="text" name="checkin[trk_check_in_other_place]">
                                </div>
                            </div>
                            <!-- -->
                            <div class="form-group">
                                <label for="trk_check_in_date" class="control-label col-md-3 col-sm-3 col-xs-12">Arrived
                                    time</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo $trackingVehicles['trk_check_in_date']; ?>" id="trk_check_in_date" class="form-control col-md-7 col-xs-12 dtpDateTimePicker" type="text" name="checkin[trk_check_in_date]" required="required" placeholder="DD-MM-YYYY H:M AM/PM">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="trk_check_in_km" class="control-label col-md-3 col-sm-3 col-xs-12"> KM
                                    (IN)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="<?php echo $trackingVehicles['trk_check_in_km']; ?>" id="trk_check_in_km" class="form-control col-md-7 col-xs-12 numOnly" type="number" name="checkin[trk_check_in_km]" required="required">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="trk_check_in_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    Remarks</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="trk_check_in_remarks" class="form-control col-md-7 col-xs-12" rows="4" name="checkin[trk_check_in_remarks]"><?php echo $trackingVehicles['trk_check_in_remarks']; ?></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="checkin[trk_id]" value="<?php echo $trackingVehicles['trk_id']; ?>" />
                            <?php if (empty($trackingVehicles['trk_check_in_date'])) { ?>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                    </div>
                                </div>
                            <?php }
                            echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>