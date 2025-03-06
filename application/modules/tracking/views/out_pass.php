<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Out Pass Vehicle</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- Smart Wizard -->
                        <div class="form-horizontal form-label-left">
                            <?php echo form_open_multipart("tracking/out_pass") ?>
                            <?php if (check_permission('tracking', 'showbookingno')) { ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-name">Booking
                                        No</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="select2_group form-control select2" name="trk_booking_no"
                                            required="required" onchange="$('.txtEnqId').val($(this).find(':selected').data('enq-id')); 
                                            $('.txtDeliveryDate').val($(this).find(':selected').data('delivery-date')); 
                                            $('.cmbVehicleNo').select2().select2('val',$(this).find(':selected').data('valid'));
                                            $('.txtVehicle').val($(this).find(':selected').data('veh'));
                                            $('.txtCustNumber').val($(this).find(':selected').data('cust-no'));">
                                            <option value="">Booking number</option>
                                            <?php foreach ((array) $bookings as $key => $value) { ?>
                                                <option value="<?php echo $value['vbk_id']; ?>"
                                                    data-veh="<?php echo $value['brd_title'] . '-' . $value['mod_title'] . '-' . $value['var_variant_name']; ?>"
                                                    data-valid="<?php echo $value['val_id']; ?>"
                                                    data-enq-id="<?php echo $value['vbk_enq_id']; ?>"
                                                    data-cust-no="<?php echo !empty($value['vbk_per_ph_no']) ? $value['vbk_per_ph_no'] : $value['vbk_off_ph_no']; ?>"
                                                    data-delivery-date='<?php echo !empty($value['vbk_delivery_date']) ? $value['vbk_delivery_date'] : ""; ?>'>
                                                    <?php echo strtoupper($value['vbk_ref_no'] . ' ' . $value['val_veh_no'] . ' ' . $value['brd_title'] . '-' . $value['mod_title'] . '-' . $value['var_variant_name']); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" class="txtDeliveryDate" name="txtDeliveryDate" />
                                <input type="hidden" class="txtEnqId" name="txtEnqId" />
                                <input type="hidden" class="txtVehicle" name="txtVehicle" />
                                <input type="hidden" class="txtCustNumber" name="txtCustNumber" />
                            <?php } ?>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-name">Vehicle
                                    No</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_group form-control cmbVehicleNo" name="trk_vehicle_no"
                                        required="required">
                                        <option value="">Select Registration No</option>
                                        <?php foreach ((array) $vehicles as $key => $value) { ?>
                                            <option value="<?php echo $value['val_id']; ?>">
                                                <?php echo strtoupper($value['val_veh_no'] . ' ' . $value['brd_title'] . '-' . $value['mod_title'] . '-' . $value['var_variant_name']); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date
                                    (OUT)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input placeholder="DD-MM-YYYY H:M AM/PM" value="<?php echo date('d-m-Y h:i:A'); ?>"
                                        id="trk_out_date" name="trk_out_pass_time" type="text" required="required"
                                        class="dtpDateTimePicker form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Purpose <span
                                        class="required"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="trk_purpose" name="trk_out_pass_purpose" required="required"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="emp_job_tittle" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle
                                    Driver</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_group form-control cmbSearchList"
                                        name="trk_out_pass_rd_driver" required="required" onchange="if ($(this).val() == -1) {
                                                                    $('.divDriver').show();
                                                                    $('#trk_veh_driver_out').attr('required', 'required');
                                                               } else {
                                                                    $('.divDriver').hide();
                                                                    $('#trk_veh_driver_out').val('');
                                                                    $('#trk_veh_driver_out').removeAttr('required');
                                                               }">
                                        <option value=""> Select Staff </option>
                                        <option value="-1"> Other drivers </option>
                                        <option value="-2">Car Delivery</option>
                                        <optgroup label="Royal drive staf">
                                            <?php foreach ($stafs as $key => $value) { ?>
                                                <option value="<?php echo $value['usr_id']; ?>">
                                                    <?php echo $value['usr_first_name'] . ' ' . $value['usr_last_name'] . ' - ' . $value['shr_location']; ?>
                                                </option>
                                            <?php } ?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group divDriver" style="display: none;">
                                <label for="enq_cus_address" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle
                                    Driver</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="trk_veh_driver_out" class="form-control col-md-7 col-xs-12"
                                        name="trk_out_pass_other_driver" required="required">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="trk_out_pass_to"
                                    class="control-label col-md-3 col-sm-3 col-xs-12">To</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_group form-control" name="trk_out_pass_to"
                                        required="required" onchange="if ($(this).val() < 0) {
                                                                    $('.divOutPassToPlace').show();
                                                                    $('#trk_out_pass_to_place').attr('required', 'required');
                                                               } else {
                                                                    $('.divOutPassToPlace').hide();
                                                                    $('#trk_out_pass_to_place').val('');
                                                                    $('#trk_out_pass_to_place').removeAttr('required');
                                                               }">
                                        <option value=""> Select Showroom </option>
                                        <option value="-1"> Other place </option>
                                        <optgroup label="Royal drive showrooms">
                                            <?php foreach ($showrooms as $key => $value) { ?>
                                                <option value="<?php echo $value['shr_id']; ?>">
                                                    <?php echo $value['shr_location'] . ' (' . $value['div_name'] . ')'; ?>
                                                </option>
                                            <?php } ?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group divOutPassToPlace" style="display: none;">
                                <label for="enq_cus_mobile" class="control-label col-md-3 col-sm-3 col-xs-12">To
                                    Place</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="trk_out_pass_to_place" class="form-control col-md-7 col-xs-12"
                                        type="text" name="trk_out_pass_to_place">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="enq_cus_whatsapp" class="control-label col-md-3 col-sm-3 col-xs-12">Current
                                    KM (OUT)</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="trk_km_out" class="form-control col-md-7 col-xs-12 numOnly" type="number"
                                        name="trk_out_pass_km" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="enq_cus_whatsapp" class="control-label col-md-3 col-sm-3 col-xs-12">Estimate
                                    Arrival Date and Time</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="trk_est_date" class="form-control col-md-7 col-xs-12 dtpDateTimePicker"
                                        type="text" name="trk_out_pass_est_return_time" required="required"
                                        placeholder="DD-MM-YYYY H:M AM/PM">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">Submit & Print Gate Pass</button>
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
    $('.select2').select2();
    $('.cmbVehicleNo').select2();
</script>