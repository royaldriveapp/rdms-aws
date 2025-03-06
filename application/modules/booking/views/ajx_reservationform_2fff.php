<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Order Booking
                    </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <form class="frmReserveVehicle1" name="frmReserveVehicle1" action="<?php echo site_url('booking/reserveVehicle'); ?>" enctype="multipart/form-data" onsubmit="return validateForm();" method="post">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Customer Detail</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <input type="hidden" value="<?php echo ($is_api == 1) ? 0 : @$enquiry['enq_id']; ?>" name="bm[vbk_enq_id]" />

                                        <input type="hidden" value="<?php echo $vehicles['val_id']; ?>" name="bm[vbk_evaluation_veh_id]" />
                                        <input type="hidden" name="add_info" value="<?php echo strtoupper($vehicles['val_veh_no']) . ' - ' . $vehicles['brd_title'] . ', ' . $vehicles['mod_title'] . ', ' . $vehicles['var_variant_name']; ?>" />
                                        <input type="hidden" value="<?php echo ($is_api == 1) ? 1 : 0 ?>" name="bm[vbk_api]" />
                                        <table class="table table-bordered" style="margin-bottom: 0px;">
                                            <tr>
                                                <td>Customer name : <input name="bm[vbk_cust_name]" class="select2_group form-control" value="<?php echo ($is_api == 1) ? $booking['ab_name'] : @$enquiry['enq_cus_name']; ?>" />
                                                </td>
                                                <td style="font-size: 25px;color: #1d73bd;font-weight: bold;
                                                      padding-top: 15px;padding-left: 30px;">Date :
                                                    <?php echo date('d-m-Y'); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="">Permanent address :
                                                    <textarea name="bm[vbk_per_address]" class="form-control col-md-7 col-xs-12"><?php echo ($is_api == 1) ? $booking['ab_address'] . ',' . $booking['ab_district'] : @$enquiry['enq_cus_address'] . ',' . $enquiry['cit_name']; ?></textarea>
                                                </td>
                                                <td>
                                                    RC Transfer address :
                                                    <textarea name="bm[vbk_rd_trans_address]" class="form-control col-md-7 col-xs-12"><?php echo ($is_api == 1) ? $booking['ab_address'] . ',' . $booking['ab_district'] : @$enquiry['enq_cus_address'] . ',' . $enquiry['cit_name']; ?></textarea><br>
                                                    PIN : <input required class="numOnly" type="text" name="bm[vbk_pin]" value="<?php echo ($is_api == 1) ? $booking['ab_pin'] : ''; ?>" />

                                                    <br>RC Transfer mobile :
                                                    <input name="bm[vbk_rc_trans_phone]" class="numOnly select2_group form-control" value="<?php echo $enquiry['enq_cus_mobile']; ?>" /><br>
                                                    PIN : <input required class="numOnly" type="text" name="bm[vbk_rc_trns_pin]" value="<?php echo ($is_api == 1) ? $booking['ab_pin'] : ''; ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Phone number (Official) : <input name="bm[vbk_off_ph_no]" class="numOnly select2_group form-control" value="<?php echo ($is_api == 1) ? '' : @$enquiry['enq_cus_mobile']; ?>" />
                                                </td>
                                                <td>Phone number (Personal) : <input name="bm[vbk_per_ph_no]" class="numOnly select2_group form-control" value="<?php echo ($is_api == 1) ? '' : @$enquiry['enq_cus_mobile']; ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Email ID : <input type="email" required name="bm[vbk_email]" class="select2_group form-control" value="<?php echo ($is_api == 1) ? '' : @$enquiry['enq_cus_email']; ?>" />
                                                </td>
                                                <td>DOB : <input autocomplete="off" required name="bm[vbk_dob]" class="dtpDMY select2_group form-control" value="" /></td>
                                            </tr>
                                        </table>
                                        <table class="table table-bordered tblBokDocs">
                                            <tr>
                                                <th colspan="4">Documents <i class="btnAddBookDocs fa fa-plus"></i>
                                                </th>
                                            </tr>
                                            <tr class="trBokDocs">
                                                <td>
                                                    <select name="ap[vbd_doc_type][]" class="select2_group form-control">
                                                        <option value="0">Select address proof</option>
                                                        <?php foreach ($addressProof as $key => $value) { ?>
                                                            <option value="<?php echo $value['adp_id']; ?>">
                                                                <?php echo $value['adp_proof_title']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="select2_group form-control" type="text" name="ap[vbd_doc_number][]" placeholder="Address proof number" />
                                                </td>
                                                <td>
                                                    <input type="file" name="vbd_doc_file[]" />
                                                </td>
                                                <td><i class="btnRemoveRow fa fa-minus"></i></td>
                                            </tr>
                                        </table>
                                        <table class="table table-bordered">
                                            <!-- <tr>
                                                <th colspan="4">Adhaar <i class="btnAddBookDocs fa fa-plus"></i>
                                                </th>
                                            </tr> -->
                                            <tr class="">

                                                <?php

                                                $base_url = ($is_api == 1) ? 'https://royaldrive-prod.s3.ap-south-1.amazonaws.com' : '';

                                                // If $is_api is 1, set the file value and name
                                                $aadhaarFile = $is_api == 1 ? $base_url . '/' . $booking['ab_aadhaar_img'] : '';
                                                $panFile = $is_api == 1 ? $base_url . '/' . $booking['ab_pan_img'] : '';

                                                ?>
                                                <td>
                                                    <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">Aadhaar
                                                    </label>

                                                    <input type="hidden" name="ap[vbd_doc_type][]" class="select2_group form-control" value="1">
                                                    <input class="select2_group form-control" type="text" name="ap[vbd_doc_number][]" placeholder="Aadhaar Number" value="<?php echo ($is_api == 1) ? $booking['ab_aadhaar_no'] : ''; ?>" />



                                                </td>

                                                <td>


                                                    <input type="file" name="vbd_doc_file[]" <?php echo empty($booking['ab_aadhaar_img']) ? 'required' : ''; ?> value="<?php echo $aadhaarFile; ?>" />


                                                    <!-- img -->
                                                    <?php if ($is_api == 1) : ?>
                                                        <!-- Display Adhaar Image -->
                                                        <?php if (!empty($aadhaarFile)) : ?>
                                                            <img src="<?= $aadhaarFile; ?>" width="20px" alt="Adhaar Image">
                                                        <?php else : ?>
                                                            <p>Adhaar image not available.</p>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <!-- @ -->


                                                </td>

                                            </tr>
                                        </table>
                                        <table class="table table-bordered">

                                            <tr class="">
                                                <td>
                                                    <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">PAN
                                                    </label>

                                                    <input type="hidden" name="ap[vbd_doc_type][]" class="select2_group form-control" value="2">
                                                    <input value="<?php echo ($is_api == 1) ? $booking['ab_pan_no'] : ''; ?>" class="select2_group form-control" type="text" name="ap[vbd_doc_number][]" placeholder="PAN Number" />

                                                </td>

                                                <td>
                                                    <input type="file" name="vbd_doc_file[]" <?php echo empty($booking['ab_pan_img']) ? 'required' : ''; ?> value="<?php echo $panFile; ?>" />
                                                    <!-- img -->
                                                    <?php if ($is_api == 1) : ?>
                                                        <!-- Display Pan Image -->
                                                        <?php if (!empty($panFile)) : ?>
                                                            <img src="<?= $panFile; ?>" width="20px" alt="Pan Image">
                                                        <?php else : ?>
                                                            <p>Pan image not available.</p>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <!-- @ -->


                                                </td>

                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Vehicle Details <a title="detailed view of evaluation" target="blank" href="<?php echo site_url('evaluation/printevaluation/' . encryptor($vehicles['val_id'])); ?>"><i class="fa fa-copy"></i></a></h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>
                                                    Reg No : <?php echo strtoupper($vehicles['val_veh_no']); ?>
                                                    Make : <?php echo $vehicles['brd_title']; ?>
                                                </td>
                                                <td>
                                                    Model :
                                                    <?php echo $vehicles['mod_title'] . ', ' . $vehicles['var_variant_name']; ?>
                                                    Production Year : <?php echo $vehicles['val_minif_year']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Chassis Number : <?php echo $vehicles['val_chasis_no']; ?>
                                                </td>
                                                <td>
                                                    <div style="width: 45%;float: left;">
                                                        <div style="width: 30px;float: left;">KM : </div>
                                                        <div style="float: left;width: 104px;">
                                                            <?php echo $vehicles['val_km']; ?></div>
                                                    </div>
                                                    <div style="width: 55%;float: left;">
                                                        <div style="width: 100px;float: left;">No of ownership :
                                                        </div>
                                                        <div style="float: left;width: 60px;">
                                                            <?php echo $vehicles['val_no_of_owner']; ?></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th colspan="1" style="text-align: center;">Insurance</th>
                                                    <th colspan="2" style="text-align: center;">Insurance Company
                                                    </th>
                                                    <th colspan="3" style="text-align: center;">
                                                        <?php echo $vehicles['val_insurance_company']; ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Comprehensive</td>
                                                    <td>Valid up to</td>
                                                    <td><?php echo !empty($vehicles['val_insurance_comp_date']) ? date('d-m-Y', strtotime($vehicles['val_insurance_comp_date'])) : ''; ?>
                                                    </td>
                                                    <td>IDV</td>
                                                    <td><?php echo $vehicles['val_insurance_comp_idv']; ?></td>
                                                    <td>NCB%</td>
                                                    <td><?php echo $vehicles['val_insurance_ll_idv']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Third Party</td>
                                                    <td>Valid up to</td>
                                                    <td><?php echo !empty($vehicles['val_insurance_ll_date']) ? date('d-m-Y', strtotime($vehicles['val_insurance_ll_date'])) : ''; ?>
                                                    </td>
                                                    <td>Insurance Type</td>
                                                    <td>
                                                        <?php
                                                        $insType = unserialize(INSURANCE_TYPES);
                                                        echo isset($insType[$vehicles['val_insurance']]) ? $insType[$vehicles['val_insurance']] : '';
                                                        ?>
                                                    </td>
                                                    <td>NCB Required</td>
                                                    <td><?php echo ($vehicles['val_insurance_need_ncb'] == 1) ? 'YES' : 'NO'; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Exchange -->
                            <?php if (!empty($purchaseVeh)) { ?>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Exchange Details </h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td>
                                                        <b>Vehicle:</b> <?php echo $purchaseVeh['brd_title'] ?>|
                                                        <?php echo $purchaseVeh['mod_title'] ?>|
                                                        <?php echo $purchaseVeh['var_variant_name'] ?>

                                                    </td>
                                                    <td>
                                                        <b>Reg No:</b> <?php echo $purchaseVeh['val_veh_no'] ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b>Exchang Value:</b> 00
                                                    </td>
                                                    <td>
                                                        <b>Evaluation Date:</b>
                                                        <?php echo !empty($vehicles['val_valuation_date']) ? date('d-m-Y', strtotime($vehicles['val_valuation_date'])) : ''; ?>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- @Exchange -->
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Other details</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="form-group">
                                            <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">Expect delivery
                                                date</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input placeholder="Expect delivery date" type="text" class="dtpExpDelTime form-control col-md-7 col-xs-12" name="bm[vbk_expect_delivery]" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Vehicle price details</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div>
                                                <table class="table table-bordered tblAddRefurb">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="3" style="text-align: center;">
                                                                <div style="width: 70%;" class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                    Required Refurbish <span class="snpAddRefurbTotal">Rs/- 0.00</span>
                                                                </div>
                                                            </th>
                                                            <th>
                                                                <div style="float: right;"><i class="btnNewAddRefurb fa fa-plus"></i>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tr class="trAddRefurb">
                                                        <td><input type="text" class="form-control col-md-7 col-xs-12" name="rf[vbr_refurb_desc][]" id="mod_title" placeholder="Refurbish" /></td>
                                                        <td id="test"><input type="text" class="txtReqRefurbAmt form-control col-md-7 col-xs-12 decimalOnly" name="rf[vbr_refurb_amt][]" id="mod_title" placeholder="Refurbish amount" /></td>
                                                        <td id="donwby">
                                                            <select name="rf[vbr_don_by][]" class="form-control cmbBookingRefurb" data-id="asd">
                                                                <option value="1">RD</option>
                                                                <option value="2">Customer</option>
                                                            </select>
                                                        </td>
                                                        <td><i class="btnRemoveRow fa fa-minus"></i></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div>
                                                <table class="table table-bordered tblAddAccessories">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="3" style="text-align: center;">
                                                                <div style="width: 70%;" class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                    Required Accessories<span class="spnAddAccessoriesTotal">Rs/-
                                                                        0.00</span></div>
                                                            </th>
                                                            <th>
                                                                <div style="float: right;"><i class="btnNewAddAccessories fa fa-plus"></i>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tr class="trAddAccessories">
                                                        <td><input type="text" class="form-control col-md-7 col-xs-12" name="ac[vba_accessories_desc][]" id="mod_title" placeholder="Accessories" /></td>
                                                        <td><input type="text" class="txtReqAccessoriesAmt form-control col-md-7 col-xs-12 decimalOnly" name="ac[vba_accessories_amt][]" id="mod_title" placeholder="Accessories amount" /></td>
                                                        <td>
                                                            <select name="ac[vba_don_by][]" class="form-control cmbBookingAccessories">
                                                                <option value="1">RD</option>
                                                                <option value="2">Customer</option>
                                                            </select>
                                                        </td>
                                                        <td><i class="btnRemoveRow fa fa-minus"></i></td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="5">
                                                                <div class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                    Insurance and loan details</div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2">
                                                                <span class="small">Insurance Company</span>
                                                                <input ype="text" class="form-control col-md-7 col-xs-12" name="bm[vbk_insurance_co]" id="mod_title" placeholder="Insurance Company" />
                                                            </td>

                                                            <td colspan="2">
                                                                <span class="small">Insurance Amount</span>
                                                                <input type="text" class="txtInsuranceAmt form-control col-md-7 col-xs-12 decimalOnly" value="0.00" name="bm[vbk_insurance_amt]" id="mod_title" placeholder="Insurance Amount" />
                                                            </td>
                                                            <td>
                                                                <select name="bm[vbk_insurance_don_by]" class="form-control cmbInsurance">
                                                                    <option value="1">RD</option>
                                                                    <option value="2">Customer</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="3">
                                                                <span class="small" style="float:left;width: 100%;">Loan
                                                                    Select</span>
                                                                <div style="float:left;">
                                                                    <select class="cmbMultiSelect select2_group form-control txtChkBank" name="bm[vbk_fin_bank_name]" id="val_hypo_bank">
                                                                        <option value="">Select bank</option>
                                                                        <?php foreach ($banks as $key => $value) { ?>
                                                                            <option value="<?php echo $value['bnk_id']; ?>">
                                                                                <?php echo $value['bnk_name']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <span class="small">Loan Amount</span>
                                                                <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_loan_amt]" id="mod_title" placeholder="Loan Amount" />
                                                            </td>

                                                            <td>
                                                                <span class="small">Tenor</span>
                                                                <input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_tenor]" id="mod_title" placeholder="Tenor" />
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="2">
                                                                <span class="small">Payment Mode</span>
                                                                <select required name="bm[vbk_pay_mod]" class="cmbBookPaymentMode form-control col-md-7 col-xs-12">
                                                                    <option value="">Select payment mode</option>
                                                                    <option value="1">Cheque</option>
                                                                    <option value="2">Cash</option>
                                                                    <option value="3">G-pay</option>
                                                                    <option value="4">Swiping</option>
                                                                    <option value="5">RTGS</option>
                                                                    <option value="6">NEFT</option>
                                                                </select>
                                                            </td>
                                                            <td colspan="3">
                                                                <span class="small">Cheque/Cash amount</span>
                                                                <input type="text" class="txtChkAmt form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_chk_amt]" id="mod_title" placeholder="Cheque/Cash amount" />
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="2">
                                                                <span class="small" style="float:left;width: 100%;">Cheque
                                                                    bank</span>
                                                                <select class="cmbMultiSelect select2_group form-control txtChkBank" name="bm[vbk_chk_bank]" id="val_hypo_bank">
                                                                    <option value="">Select bank</option>
                                                                    <?php foreach ($banks as $key => $value) { ?>
                                                                        <option value="<?php echo $value['bnk_id']; ?>">
                                                                            <?php echo $value['bnk_name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td colspan="3">
                                                                <span class="small">Cheque number</span>
                                                                <input type="text" class="txtChkNum form-control col-md-7 col-xs-12" name="bm[vbk_chk_num]" id="mod_title" placeholder="Cheque number" />
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="3">
                                                                <span class="small">Cheque date</span>
                                                                <input type="text" class="dtpDMY txtChkDate form-control col-md-7 col-xs-12" name="bm[vbk_chk_date]" id="mod_title" placeholder="Cheque date" />
                                                            </td>

                                                            <td colspan="3">
                                                                <span class="small">Cheque holder</span>
                                                                <input type="text" class="txtChkHolder form-control col-md-7 col-xs-12" name="bm[vbk_chk_holder]" id="mod_title" placeholder="Account holder" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">Select Company</td>
                                                            <td colspan="3">
                                                                <select class="select2_group form-control" name="bm[vbk_fin_year_code]" id="vbk_company" required>
                                                                    <option value="">Select company</option>
                                                                    <?php foreach ($company as $key => $value) { ?>
                                                                        <option <?php echo ($this->div == $value['div_id']) ? 'selected' : ''; ?> value="<?php echo $value['cmp_finance_year_code']; ?>">
                                                                            <?php echo $value['cmp_name']; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="hidden" class="txtTCSPer" value="<?php echo get_settings_by_key('tcs_per'); ?>" />
                                            <input type="hidden" class="txtTCSLimit" value="<?php echo get_settings_by_key('tcs_limit'); ?>" />
                                            <div>
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td>Vehicle sold price</td>
                                                            <td><input required type="text" class="txtVehiclePrice form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_vehicle_amt]" value="0.00" id="mod_title" placeholder="Vehicle sold price" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div style="float: left;">TCS
                                                                    (<?php echo get_settings_by_key('tcs_per'); ?>)
                                                                </div>
                                                                <!-- <div style="float: left;margin-left: 20px;"> <input type="checkbox" value="1" class="chkIsTCSApply" /> TCS Apply </div> -->
                                                            </td>
                                                            <td>
                                                                <input readonly name="bm[vbk_tcs]" type="text" class="txtTCSAmt form-control col-md-7 col-xs-12 decimalOnly" placeholder="TCS" value="0.00" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>RTO Transfer & Service Charge</td>
                                                            <td><input name="bm[vbk_rto_charges]" type="text" class="txtRTOCharges form-control col-md-7 col-xs-12 decimalOnly" value="0.00" id="mod_title" placeholder="RTO Transfer & Service Charge" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Refurbishment Charge</td>
                                                            <td><input type="text" class="txtAddRefurbTotal form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_refurbish_cost]" value="0.00" id="mod_title" placeholder="Refurbishment Charge" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Accessories Charge</td>
                                                            <td><input type="text" class="txtAddAccessoriesTotal form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_accessories_cost]" value="0.00" id="mod_title" placeholder="Accessories Charge" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Insurance</td>
                                                            <td><input type="text" class="txtGrndInsurance form-control col-md-7 col-xs-12 decimalOnly" name="" value="0.00" id="mod_title" placeholder="Insurance" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Sales Amount</td>
                                                            <td><input type="text" class="txtTtlSaleAmt form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_ttl_sale_amt]" value="0.00" id="mod_title" placeholder="Total Sales Amount" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Advance Amount</td>
                                                            <td><input required type="text" class="txtAdvanceAmt form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_advance_amt]" value="<?php echo ($is_api == 1) ? $booking['ab_advance_amount'] : '0.00'; ?>" id="mod_title" placeholder="Advance Amount" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Balance Amount</td>
                                                            <td><input type="text" class="txtBalanceAmt form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_balance]" value="0.00" id="mod_title" placeholder="Balance Amount" />
                                                            </td>
                                                        </tr>

                                                        <!-- <tr style="background-color: #f9d2a2">
                                                                 <td>Total Sales Amount B+W</td>
                                                                 <td><input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" 
                                                                            name="bm[vbk_bsatw]" value="0.00" id="mod_title" placeholder="Total Sales Amount B+W"/></td>
                                                            </tr>
                                                            <tr style="background-color: #f9d2a2">
                                                                 <td>Advance Cash</td>
                                                                 <td><input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" 
                                                                            name="bm[vbk_adc]" value="0.00" id="mod_title" placeholder="Advance Cash"/></td>
                                                            </tr>
                                                            <tr style="background-color: #f9d2a2">
                                                                 <td>Advance Balance Cash</td>
                                                                 <td><input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" 
                                                                            name="bm[vbk_adbc]" value="0.00" id="mod_title" placeholder="Advance Balance Cash"/></td>
                                                            </tr>-->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input name="btnSubmit" type="submit" value="Submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .focused {
        border: solid 1px red;
    }
</style>
<script>
    function validateForm() {
        var txtVehiclePrice = parseFloat($('.txtVehiclePrice').val()) || 0;
        var txtVehicleAdvPrice = parseFloat($('.txtAdvanceAmt').val()) || 0;
        var errorFlag = 0;
        if (txtVehiclePrice <= 0) {
            alert('Must enter vehicle sold price');
            $('.txtVehiclePrice').focus();
            return false;
        }
        if (txtVehicleAdvPrice <= 0) {
            alert('Must enter vehicle advance');
            $('.txtAdvanceAmt').focus();
            return false;
        }
        document.frmReserveVehicle.btnSubmit.disabled = true;
        document.frmReserveVehicle.btnSubmit.value = 'Please wait...';
    }
</script>
</script>