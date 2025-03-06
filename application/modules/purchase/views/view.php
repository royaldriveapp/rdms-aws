<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Purchase</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <!-- <div class="panel panel-default">
                                   <div class="panel-heading">
                                        <div><button data-url="£" class="btnBookingForm btn btn-primary">Submit</button></div>
                                        <div class="divBookingForm"></div>
                                   </div>
                                   <div class="panel-body">
    <form id="purchaseForm">
        <ul class="list-group">
            <li class="list-group-item">
                <select class="select2_group form-control cmbFollStatus" name="pr_mou_no" required="required">
                    <option value="0">Select Vehicle</option>
                    <?php foreach ($purchase_data['mou'] as $item) : ?>
                        <option value="<?= $item['moum_number'] ?>" data-advance="<?= $item['moum_adv_token'] ?>"><?= "{$item['moum_number']} / {$item['moum_reg_num']}" ?></option>
                    <?php endforeach; ?>
                </select>
            </li>
            <li class="list-group-item">
                Total price: <input type="number" placeholder="Total Amount" name="pr_total" class="form-control col-md-7 col-xs-12">
            </li>
            <li class="list-group-item">
                Refurb job Total: <input type="number" placeholder="Refurb job Total" name="pr_refurb_total" class="form-control col-md-7 col-xs-12">
            </li>
            <li class="list-group-item">
                Advance: : <input type="number" value="" placeholder="Advance" id="advanceField" name="pr_advance" class="form-control col-md-7 col-xs-12">
            </li>
            <li class="list-group-item">
                Fine: <input type="number" placeholder="Fine" name="pr_fine" class="form-control col-md-7 col-xs-12">
            </li>
            <li class="list-group-item">
                Brokerage: <input type="number" placeholder="Brokerage" name="pr_brokerage" class="form-control col-md-7 col-xs-12">
            </li>
            <li class="list-group-item">
                Insurance: <input type="number" placeholder="Insurance" name="pr_insurance" class="form-control col-md-7 col-xs-12">
            </li>
        </ul>
    </form>
</div>

                              </div> -->

                        <div class="panel panel-default">
                            <div class="panel-heading">
                            </div>
                            <?php //debug($purchase_data['mou']);
                            ?>
                            <div class="panel-body">
                                <form action="<?php echo site_url('purchase/add'); ?>" method="post" accept-charset="utf-8" id="frmVehicleModel" class="form-horizontal form-label-left" onsubmit="document.frmReserveVehicle.btnSubmit.disabled = true;
        document.frmReserveVehicle.btnSubmit.value = 'Please wait...';" enctype="multipart/form-data">

                                    <input type="hidden" name="pr_enq_id" value="<?php echo $enq_id; ?>">
                                    <input type="hidden" name="pr_val_id" class="pr_val_id" value="<?php echo $val_id; ?>">
                                    <input type="hidden" name="pr_reg_no" id="regField">
                                    <input type="hidden" name="pr_stocknum">

                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Procurement Staff *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select required class="select2_group form-control cmbFollStatus select2 vehicleSelect" name="pr_proc_staff">
                                                <option value="">Procurement Staff</option>
                                                <?php foreach ($salesExe as $items) : ?>
                                                    <option <?php echo ($salesDetails['enq_se_id'] == $items['usr_id']) ? 'selected' : ''; ?> value="<?= $items['usr_id'] ?>"><?php echo $items['usr_username']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <spam class="spnLabel">Please confirm the procurement staff</spam>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">MOU
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_group form-control cmbFollStatus select2" name="pr_mou_no">
                                                <option value="0">Select MOU</option>
                                                <?php foreach ($purchase_data['mou'] as $item) : ?>
                                                    <option value="<?= $item['moum_number'] ?>" data-advance="<?= $item['moum_adv_token'] ?>" data-reg-no="<?= $item['moum_reg_num'] ?>" data-stknum="<?= $item['moum_stock_num'] ?>" data-netprice="<?= $item['moum_net_price'] ?>" data-vehiclecategory="<?= $item['moum_vehicle_category'] ?>" data-purchasetype="<?= $item['moum_purchase_type'] ?>" data-finyearcode="<?= $item['moum_fin_year_code'] ?>" data-district="<?= $item['std_district_name'] ?>" data-customername="<?= $item['moum_customer_name']; ?>">
                                                        <?= "{$item['moum_number']} / {$item['moum_reg_num']}" ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label id="lblDetails"></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle*
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="cmbSearchList form-control cmbFollStatus vehicleSelect" required>
                                                <option value="0">Select Vehicle*</option>
                                                <?php foreach ($valuations as $valuation) : ?>
                                                    <option value="<?= $valuation['val_id'] ?>" data-reg-no="<?= $valuation['val_veh_no'] ?>">
                                                        <?php echo $valuation['val_veh_no'] . '-' . $valuation['val_stock_num']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12">Total price<span class="required">*</span></label> -->
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sourcing Amount<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <!-- <input type="number" placeholder="Total Amount" name="pr_total" class="form-control col-md-7 col-xs-12 numOnly" required> -->
                                            <input type="number" id="pr_veh_amount" placeholder="Vehicle Amount" name="pr_veh_amount" class="txtVehFullAmt form-control col-md-7 col-xs-12 numOnly" required>
                                            <?php if (get_settings_by_key('show_bl_on_sales') == 1) { ?>
                                                <spam class="spnLabel">Cash amount</spam>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Evaluation
                                            Expences</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" placeholder="Evaluation Expences" name="pr_dicount_amt" value="<?php echo $purchase_data['valuation']['val_trade_in_price']; ?>" class="form-control col-md-7 col-xs-12 numOnly">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12"> Refurb job Total: <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">


                                                  <input type="number" placeholder="Refurb job Total" name="pr_refurb_total" class="form-control col-md-7 col-xs-12 numOnly" required>
                                             </div>
                                        </div> -->

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Advance</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" value="" placeholder="Advance" id="advanceField" name="pr_advance" class="txtAdvt form-control col-md-7 col-xs-12 numOnly">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Fine
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" placeholder="Fine" name="pr_fine" class="form-control col-md-7 col-xs-12 numOnly">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Broker name
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" placeholder="Broker name" name="pr_broker" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Brokerage</label>
                                        <div class="col-md-1 col-sm-6 col-xs-12">
                                            <input type="number" id="pr_brokerage" placeholder="%" name="pr_brokerage_per" class="txtBrkPer form-control col-md-7 col-xs-12 numOnly">
                                        </div>
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                            <input type="number" id="pr_brokerage" placeholder="Brokerage" name="pr_brokerage" class="txtBrkAmt form-control col-md-7 col-xs-12 numOnly">
                                        </div>
                                    </div>

                                    <!-- <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">  Insurance*
                                                                                               </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="number" placeholder="Insurance" name="pr_insurance" required class="form-control col-md-7 col-xs-12 numOnly">

                                        </div>
                                        </div> -->

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Refurb job total*
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" placeholder="Refurb job total" name="pr_refurb_total" value="<?php echo $purchase_data['valuation']['val_refurb_cost']; ?>" required class="form-control col-md-7 col-xs-12 numOnly">
                                        </div>
                                    </div>

                                    <!-- <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Trade in Price*
                                                                                               </label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="number" placeholder="Trade in Price" name="pr_trade_in_price" value="<?php echo $purchase_data['valuation']['val_trade_in_price']; ?>" required class="form-control col-md-7 col-xs-12 numOnly">

                                        </div>
                                        </div> -->

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">TCS Amount</label>
                                        <div class="col-md-1 col-sm-6 col-xs-12">
                                            <input type="checkbox" id="pr_brokerage" class="chkTCS">
                                        </div>
                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                            <input type="number" placeholder="TCS Amount" name="pr_tcs_amt" required class="txtTcs form-control col-md-7 col-xs-12 numOnly">
                                            <spam class="spnLabel">TCS Applicable for only purchase from organisation
                                            </spam>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group"> -->
                                    <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12">Total Vehicle Cost<span class="required">*</span></label> -->
                                    <!-- <div class="col-md-6 col-sm-6 col-xs-12"> -->
                                    <input type="hidden" placeholder="Total Amount" name="pr_total" class="form-control col-md-7 col-xs-12 numOnly" required>
                                    <!-- </div> -->
                                    <!-- </div> -->
                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle Category*</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_group form-control cmbFollStatus" name="pr_val_type" id="cmbPrValType" required="required">
                                                <option value="">Select</option>
                                                <?php foreach (unserialize(VAL_TYPE_TITLE) as $key => $val_type) : ?>
                                                    <option value="<?= $key ?>"><?= $val_type ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Sourcing type*</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_group form-control cmbFollStatus" name="pr_sourcing_type" id="cmbSourcingType" required="required">
                                                <option value="">Select</option>
                                                <?php foreach (unserialize(SOURCING_TYPE) as $key => $sourcing_type) : ?>
                                                    <option value="<?= $key ?>"><?= $sourcing_type ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Agreement Date*
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" placeholder="Agriment date" name="pr_agreement_date" required class="form-control col-md-7 col-xs-12 dtpDatePicker">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">States <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select required class="select2_group form-control cmbBindDistrictBystate" name="pr_state" id="pr_state" data-url="<?php echo site_url('purchase/bindDistrictBystate'); ?>" data-bind="cmbShowroom" data-dflt-select="Select States">
                                                <option value="">Select States</option>
                                                <?php
                                                foreach ($states as $key => $value) {
                                                ?>
                                                    <option value="<?php echo $value['sts_id']; ?>">
                                                        <?php echo $value['sts_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">District <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select required class="select2_group form-control cmbDistrict shorm_stf" name="pr_district" id="pr_district">
                                                <option value="">Select District</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Company <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_group form-control" name="pr_fin_year_code" id="cmbCompany" required>
                                                <option value="0">Select company</option>
                                                <?php foreach ($company as $key => $value) { ?>
                                                    <option <?php echo ($this->div == $value['div_id']) ? 'selected' : ''; ?> value="<?php echo $value['cmp_finance_year_code']; ?>">
                                                        <?php echo $value['cmp_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Remarks <span class="required"></span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea required="" class="form-control col-md-7 col-xs-12" name="pr_remarks" placeholder="Remarks"></textarea>
                                        </div>
                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" class="btn btn-success btnSubmitRegister">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<style>
    .spnLabel {
        font-size: 9px;
        font-style: italic;
    }
</style>
<script>
    $(document).ready(function() {
        $('.txtBrkPer').on('keyup', function(e) {
            var txtBrkPer = $(this).val();
            if (txtBrkPer > 0) {
                var txtVehFullAmt = $('.txtVehFullAmt').val();
                var txtAdvt = $('.txtAdvt').val();
                txtVehFullAmt = txtVehFullAmt ? parseFloat(txtVehFullAmt) : 0;
                txtAdvt = txtAdvt ? parseFloat(txtAdvt) : 0;
                txtBrkPer = txtBrkPer ? txtBrkPer : 0;
                var totalPlusAdvt = txtVehFullAmt + txtAdvt;
                $('.txtBrkAmt').val((totalPlusAdvt / 100) * txtBrkPer);
            }
            updateTotal();
        });
    });
    $('.select2').select2();
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var mouNoSelect = document.querySelector('select[name="pr_mou_no"]');
        var advanceField = document.querySelector('input[name="pr_advance"]');
        var totalField = document.querySelector('input[name="pr_total"]');
        var refurbTotalField = document.querySelector('input[name="pr_refurb_total"]');
        var RegField = document.querySelector('input[name="pr_reg_no"]');
        var pr_stocknum = document.querySelector('input[name="pr_stocknum"]');
        // Initialize Select2
        $(mouNoSelect).select2();

        // Listen to the Select2 change event
        $(mouNoSelect).on('change', function(e) {
            var selectedOption = mouNoSelect.options[mouNoSelect.selectedIndex];
            var advanceValue = selectedOption.getAttribute('data-advance');
            var totalValue = selectedOption.getAttribute('data-total');
            var refurbTotalValue = selectedOption.getAttribute('data-refurb-total');
            var regValue = selectedOption.getAttribute('data-reg-no');
            var val_pr_stocknum = selectedOption.getAttribute('data-stknum');

            advanceField.value = advanceValue || '';
            totalField.value = totalValue || '';
            refurbTotalField.value = refurbTotalValue || '';
            RegField.value = regValue || '';
            pr_stocknum.value = val_pr_stocknum || '';
            document.querySelector('input[name="pr_veh_amount"]').value = selectedOption.getAttribute(
                'data-netprice');
            document.getElementById('cmbPrValType').value = selectedOption.getAttribute(
                'data-vehiclecategory');
            document.getElementById('cmbSourcingType').value = selectedOption.getAttribute(
                'data-purchasetype');
            ///document.getElementById('cmbCompany').value = selectedOption.getAttribute('data-finyearcode');
            $('#lblDetails').html('District : ' + selectedOption.getAttribute('data-district') +
                ', Customer name : ' + selectedOption.getAttribute('data-customername') +
                ', Stock Num : ' + val_pr_stocknum);
            updateTotal();
        });
    });

    $(document).on('change', '.cmbBindDistrictBystate', function() {
        var id = $(this).val();
        var url = $(this).attr('data-url');
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            data: {
                state_id: id
            },
            success: function(resp) {

                $('.cmbDistrict').html('<option value="">Select District</option>');
                $.each(resp.districts, function(index, value) {
                    $('.cmbDistrict').append('<option value="' + value.std_id + '">' + value
                        .std_district_name + '</option>');
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.chkTCS').change(function() {
            updateTotal();
        });
        // Function to update pr_total based on the input values
        function updateTotal() {
            // Get input values
            $('input[name="pr_tcs_amt"]').val(0.00);
            var vehAmount = parseFloat($('input[name="pr_veh_amount"]').val()) || 0;
            var brokerage = parseFloat($('input[name="pr_brokerage"]').val()) || 0;
            var advance = parseFloat($('input[name="pr_advance"]').val()) || 0;
            var pr_dicount_amt = parseFloat($('input[name="pr_dicount_amt"]').val()) || 0;

            var w = vehAmount - pr_dicount_amt;
            var tcs = 0.00;
            if ((w >= 1000000) && ($('.chkTCS').is(':checked'))) {
                tcs = (w * 1) / 100;
            }
            // Calculate pr_total
            //var total = (vehAmount + brokerage) + advance;
            // + tcs
            var total = vehAmount + brokerage;
            // Update the pr_total input field
            $('input[name="pr_total"]').val(total.toFixed(2));
            if ($('.chkTCS').is(':checked')) {
                $('input[name="pr_tcs_amt"]').val(tcs.toFixed(2));
            }
        }

        // Attach the updateTotal function to the keyup event of relevant input fields
        $('input[name="pr_veh_amount"], input[name="pr_brokerage"], input[name="pr_advance"], input[name="pr_brokerage_per"]')
            .on('keyup',
                function() {
                    updateTotal();
                });

        // Initial calculation on page load
        updateTotal();

        function updateFields() {
            var selectedVehicle = $('.vehicleSelect').find(':selected');
            var regNo = selectedVehicle.data('reg-no');
            //$('#regField').val(regNo);
        }
        $('.vehicleSelect').on('change', function() {
            $('.pr_val_id').val($(this).val());
            updateFields();
        });
        //updateFields();
    });
</script>
</script>