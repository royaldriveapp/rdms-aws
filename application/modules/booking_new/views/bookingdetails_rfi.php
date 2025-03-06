<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Booked vehicles - <?php echo $bookingDetails['vbk_ref_no']; ?></h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form method="post" action="<?php echo site_url('booking/decisionMaking'); ?>" 
                               class="form-horizontal form-label-left" enctype="multipart/form-data">

                              <table class="table table-bordered">
                                   <tbody>
                                        <tr>
                                             <th>Sales staff : <?php echo $bookingDetails['bkdby_first_name'] . ' ' . $bookingDetails['btdby_last_name']; ?></th>
                                             <td>
                                                  <a target="blank" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($bookingDetails['vbk_enq_id'])); ?>">
                                                       <span class="glyphicon glyphicon-print"></span> Track card
                                                  </a>
                                             </td>
                                             <td>
                                                  <a target="blank" href="<?php echo site_url('evaluation/printevaluation/' . encryptor($bookingDetails['vbk_evaluation_veh_id'])); ?>">
                                                       <i title="View valuation report" class="fa fa-copy"></i> Evaluation report
                                                  </a>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>
                              <table class="table table-bordered">
                                   <tbody>
                                        <tr>
                                             <th colspan="2" style="text-align: center;">Customer details</th>
                                        </tr>
                                        <tr>
                                             <td>Customer name : <?php echo $bookingDetails['vbk_cust_name']; ?></td>
                                             <td>Date : <?php echo $bookingDetails['vbk_added_on']; ?></td>
                                        </tr>
                                        <tr>
                                             <td colspan="">Permanent address : <?php echo $bookingDetails['vbk_per_address']; ?></td>
                                             <td>RC Transfer address : <?php echo $bookingDetails['vbk_rd_trans_address']; ?></td>
                                        </tr>
                                        <tr>
                                             <td>Phone number (Official) : <?php echo $bookingDetails['vbk_off_ph_no']; ?></td>
                                             <td>Phone number (Personal) : <?php echo $bookingDetails['vbk_per_ph_no']; ?></td>
                                        </tr>
                                        <tr>
                                             <td>Email ID : <?php echo $bookingDetails['vbk_email']; ?></td>
                                             <td>DOB : <?php echo!empty($bookingDetails['vbk_dob']) ? date('d-m-Y', strtotime($bookingDetails['vbk_dob'])) : ''; ?></td>
                                        </tr>
                                   </tbody>
                              </table>
                              <table class="table table-bordered">
                                   <tbody>
                                        <tr>
                                             <th colspan="2" style="text-align: center;">Vehicle details</th>
                                        </tr>
                                        <tr>
                                             <td>
                                                  <?php echo $bookingDetails['val_veh_no']; ?>
                                             </td>
                                             <td>
                                                  <?php echo $bookingDetails['brd_title'] . ', ' . $bookingDetails['mod_title'] . ', ' . $bookingDetails['var_variant_name']; ?>
                                                  Production Year : <?php echo $bookingDetails['val_minif_year']; ?>
                                             </td>
                                        </tr>
                                        <tr>
                                             <td>
                                                  Chassis Number : <?php echo $bookingDetails['val_chasis_no']; ?>                                                  
                                             </td>
                                             <td>
                                                  <div style="width: 45%;float: left;">
                                                       <div style="width: 30px;float: left;">KM : </div>
                                                       <div style="float: left;width: 104px;"><?php echo $bookingDetails['val_km']; ?></div>
                                                  </div>
                                                  <div style="width: 55%;float: left;">
                                                       <div style="width: 110px;float: left;">No of ownership : </div>
                                                       <div style="float: left;width: 60px;"><?php echo $bookingDetails['val_no_of_owner']; ?></div>
                                                  </div>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>
                              <?php if (!empty($bookingDetails['refurb'])) { ?>
                                   <table class="table table-bordered">
                                        <tr style="text-align:center;font-weight: bolder;">
                                             <td colspan="4">Refurbishment <?php echo get_in_currency_format(array_sum(array_column($bookingDetails['refurb'], 'vbr_refurb_amt')), 2); ?></td>
                                        </tr>
                                        <?php foreach ((array) $bookingDetails['refurb'] as $key => $value) { ?>
                                             <tr class="trBokDocs">
                                                  <td>
                                                       <?php echo $value['vbr_refurb_desc']; ?>
                                                  </td>
                                                  <td>
                                                       <?php echo get_in_currency_format($value['vbr_refurb_amt'], 2); ?>
                                                  </td>
                                                  <td>
                                                       <?php echo ($value['vbr_don_by'] == 1) ? 'RD' : 'Customer'; ?>
                                                  </td>
                                                  <?php if (check_permission('booking', 'allowrejectorconfirm')) { ?>
                                                       <td>
                                                            <input value="<?php echo $value['vbr_id']; ?>" type="checkbox" name="verifyRefurb[<?php echo $value['vbr_id']; ?>]"/> Verify
                                                       </td>
                                                  <?php } ?>
                                             </tr>
                                        <?php } ?>
                                   </table>
                              <?php } if (!empty($bookingDetails['access'])) { ?>
                                   <table class="table table-bordered">
                                        <tr style="text-align:center;font-weight: bolder;">
                                             <td colspan="4">Accessories <?php echo get_in_currency_format(array_sum(array_column($bookingDetails['access'], 'vba_accessories_amt')), 2); ?></td>
                                        </tr>
                                        <?php foreach ((array) $bookingDetails['access'] as $key => $value) { ?>
                                             <tr class="trBokDocs">
                                                  <td>
                                                       <?php echo $value['vba_accessories_desc']; ?>
                                                  </td>
                                                  <td>
                                                       <?php echo get_in_currency_format($value['vba_accessories_amt'], 2); ?>
                                                  </td>
                                                  <td>
                                                       <?php echo ($value['vba_don_by'] == 1) ? 'RD' : 'Customer'; ?>
                                                  </td>
                                                  <?php if (check_permission('booking', 'allowrejectorconfirm')) { ?>
                                                       <td>
                                                            <input value="<?php echo $value['vba_id']; ?>" type="checkbox" name="verifyAccess[<?php echo $value['vba_id']; ?>]"/> Verify
                                                       </td>
                                                  <?php } ?>
                                             </tr>
                                        <?php } ?>
                                   </table>
                              <?php } ?>
                              <table class="table table-bordered">
                                   <thead>
                                        <tr>
                                             <th colspan="7" style="text-align: center;">
                                                  Existing insurance details
                                             </th>
                                        </tr>
                                        <tr>
                                             <th colspan="2" style="text-align: center;">Insurance Company</th>
                                             <th colspan="5" style="text-align: center;"><?php echo $bookingDetails['val_insurance_company']; ?></th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <td>Comprehensive</td>
                                             <td>Valid up to</td>
                                             <td><?php echo!empty($bookingDetails['val_insurance_comp_date']) ? date('d-m-Y', strtotime($bookingDetails['val_insurance_comp_date'])) : ''; ?></td>
                                             <td>IDV</td>
                                             <td><?php echo get_in_currency_format($bookingDetails['val_insurance_comp_idv']); ?></td>
                                             <td>NCB%</td>
                                             <td><?php echo $bookingDetails['val_insurance_ll_idv']; ?></td>
                                        </tr>
                                        <tr> 
                                             <td>Third Party</td>
                                             <td>Valid up to</td>
                                             <td><?php echo!empty($bookingDetails['val_insurance_ll_date']) ? date('d-m-Y', strtotime($bookingDetails['val_insurance_ll_date'])) : ''; ?></td>
                                             <td>Insurance Type</td>
                                             <td>
                                                  <?php
                                                  $insType = unserialize(INSURANCE_TYPES);
                                                  echo isset($insType[$bookingDetails['val_insurance']]) ? $insType[$bookingDetails['val_insurance']] : '';
                                                  ?>
                                             </td>
                                             <td>NCB Required</td>
                                             <td><?php echo ($bookingDetails['val_insurance_need_ncb'] == 1) ? 'YES' : 'NO'; ?></td>
                                        </tr>
                                   </tbody>
                              </table>
                              <table class="table table-bordered">
                                   <thead>
                                        <tr>
                                             <th colspan="3" style="text-align: center;">
                                                  New insurance and loan details
                                                  <div style="float: right;">Is new insurance <input <?php echo ($bookingDetails['vbk_rfi_cust'] == 1) ? 'checked' : ''; ?> 
                                                            style="margin:6px;" type="checkbox" name="bm[vbk_is_new_ins]" value="1"/>
                                                  </div>
                                             </th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <td colspan="2">
                                                  Insurance : <?php echo $bookingDetails['vbk_insurance_co']; ?>
                                             </td>
                                             <td>
                                                  Insurance Amount : <?php echo get_in_currency_format($bookingDetails['vbk_insurance_amt']); ?>
                                             </td>
                                        </tr>

                                        <tr>
                                             <td>
                                                  Finance : <?php echo $bookingDetails['bnk_name']; ?>
                                             </td>
                                             <td>
                                                  Load Amount : <?php echo get_in_currency_format($bookingDetails['vbk_loan_amt']); ?>
                                             </td>
                                             <td>
                                                  Tenor : <?php echo $bookingDetails['vbk_tenor']; ?>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>
                              <?php if (check_permission('booking', 'showfindetails')) { ?>
                                   <table class="table table-bordered">
                                        <tbody>
                                             <tr>
                                                  <th colspan="2" style="text-align: center;">Booking amount details</th>
                                             </tr>
                                             <tr>
                                                  <td>Booking amount</td>
                                                  <td>
                                                       <?php echo get_in_currency_format($bookingDetails['vbk_vehicle_amt']); ?>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>
                                                       <div style="float: left;">TCS (<?php echo get_settings_by_key('tcs_per'); ?>)</div>
                                                  </td>
                                                  <td><?php echo get_in_currency_format($bookingDetails['vbk_tcs']); ?></td>
                                             </tr>
                                             <tr>
                                                  <td>RTO Transfer &amp; Service Charge</td>
                                                  <td><?php echo get_in_currency_format($bookingDetails['vbk_rto_charges']); ?></td>
                                             </tr>
                                             <tr>
                                                  <td>Refurbishment Charge</td>
                                                  <td><?php echo get_in_currency_format($bookingDetails['vbk_refurbish_cost']); ?></td>
                                             </tr>
                                             <tr>
                                                  <td>Accessories Charge</td>
                                                  <td><?php echo get_in_currency_format($bookingDetails['vbk_accessories_cost']); ?></td>
                                             </tr>
                                             <tr>
                                                  <td>Total Sales Amount</td>
                                                  <td><?php echo get_in_currency_format($bookingDetails['vbk_ttl_sale_amt']); ?></td>
                                             </tr>
                                             <tr>
                                                  <td>Advance Amount</td>
                                                  <td><?php echo get_in_currency_format($bookingDetails['vbk_advance_amt']); ?></td>
                                             </tr>
                                             <tr>
                                                  <td>Balance Amount</td>
                                                  <td><?php echo get_in_currency_format($bookingDetails['vbk_balance']); ?></td>
                                             </tr>
                                        </tbody>
                                   </table>
                              <?php } ?>

                              <!-- Hidden fields -->
                              <input type="hidden" name="confim[vbc_book_master]" value="<?php echo $bookingDetails['vbk_id']; ?>"/>
                              <input type="hidden" name="confim[vbc_verify_by]" value="<?php echo $this->uid; ?>"/>
                              <input type="hidden" name="confim[vbc_verify_by_grp_slug]" value="<?php echo $this->usr_grp; ?>"/>
                              <input type="hidden" name="confim[vbc_verify_by_grp_id]" value="<?php echo $this->grp_id; ?>"/>
                              <input type="hidden" name="confim[vbc_verify_by_showrm]" value="<?php echo $this->shrm; ?>"/>
                              <input type="hidden" name="confim[vbc_enq_id]" value="<?php echo $bookingDetails['vbk_enq_id']; ?>"/>
                              <!-- Hidden fields -->

                              <table class="table table-bordered">
                                   <tr>
                                        <?php
                                        $paymentMod = !empty($bookingDetails['vbk_rfi_bok_mod']) ? $bookingDetails['vbk_rfi_bok_mod'] :
                                                $bookingDetails['vbk_pay_mod'];

                                        $expectDelivery = (!empty($bookingDetails['vbk_rfi_exp_del_date']) &&
                                                strtotime($bookingDetails['vbk_rfi_exp_del_date']) > 0) ? date('d-m-Y', strtotime($bookingDetails['vbk_rfi_exp_del_date'])) : '';

                                        $loanAmount = !empty($bookingDetails['vbk_rfi_loan_amt']) ? $bookingDetails['vbk_rfi_loan_amt'] :
                                                $bookingDetails['vbk_loan_amt'];

                                        $bank = !empty($bookingDetails['vbk_rfi_bank']) ? $bookingDetails['vbk_rfi_bank'] :
                                                $bookingDetails['vbk_chk_bank'];
                                        $bank = !empty($bank) ? $bank : $bookingDetails['vbk_fin_bank_name'];
                                        ?>
                                        <td>
                                             <span class="small">Sales Mode</span>
                                             <select class="select2_group form-control" name="bm[vbk_rfi_bok_mod]" title="Payment mode">
                                                  <option>Select payment mode</option>
                                                  <?php foreach (unserialize(RFI_PAYMENT_MODE) as $key => $value) { ?>
                                                       <option <?php echo ($paymentMod == $key) ? 'selected="selected"' : ''; ?> 
                                                            value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <span class="small">Select bank</span>
                                             <select class="cmbMultiSelect select2_group form-control txtChkBank" 
                                                     name="bm[vbk_rfi_bank]" id="val_hypo_bank">
                                                  <option value="">Select bank</option>
                                                  <?php foreach ($banks as $key => $value) { ?>
                                                       <option <?php echo ($bank == $value['bnk_id']) ? 'selected="selected"' : ''; ?> 
                                                            value="<?php echo $value['bnk_id']; ?>"><?php echo $value['bnk_name']; ?></option>
                                                       <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <span class="small">Bank branch</span>
                                             <input type="text" title="Bank branch" placeholder="Bank branch" 
                                                    value="<?php echo $bookingDetails['vbk_rfi_bank_branch']; ?>" name="bm[vbk_rfi_bank_branch]" class="select2_group form-control"/>
                                        </td>
                                        <td>
                                             <span class="small">Loan amount</span>
                                             <input type="text" title="Loan amount" placeholder="Loan amount" 
                                                    value="<?php echo $loanAmount; ?>" name="bm[vbk_rfi_loan_amt]" 
                                                    class="select2_group form-control"/>
                                        </td>
                                        <td>
                                             <span class="small">Loan number</span>
                                             <input type="text" title="Loan number" placeholder="Loan number" 
                                                    value="<?php echo $bookingDetails['vbk_loan_number']; ?>" name="bm[vbk_loan_number]" 
                                                    class="select2_grosup form-control"/>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td colspan="2" style="padding: 21px;">
                                             <input <?php echo ($bookingDetails['vbk_rfi_in_house'] == 1) ? 'checked' : ''; ?> 
                                                  style="margin:6px;" type="checkbox" name="bm[vbk_rfi_in_house]" value="1"/> RD (in house)

                                             <input <?php echo ($bookingDetails['vbk_rfi_dsa'] == 1) ? 'checked' : ''; ?> 
                                                  style="margin:6px;" type="checkbox" name="bm[vbk_rfi_dsa]" value="1"/> DSA

                                             <input <?php echo ($bookingDetails['vbk_rfi_cust'] == 1) ? 'checked' : ''; ?> 
                                                  style="margin:6px;" type="checkbox" name="bm[vbk_rfi_cust]" value="1"/> Customer
                                        </td>
                                        <td>
                                             <span class="small">DSA Name/Bank executive</span>
                                             <input type="text" title="DSA Name/Bank executive" placeholder="DSA Name/Bank executive" 
                                                    value="<?php echo $bookingDetails['vbk_rfi_executive']; ?>" name="bm[vbk_rfi_executive]" class="select2_group form-control"/>
                                        </td>
                                        <td>
                                             <span class="small">Contact number</span>
                                             <input type="text" title="Contact number" placeholder="Contact number" 
                                                    value="<?php echo $bookingDetails['vbk_rfi_contact_num']; ?>" name="bm[vbk_rfi_contact_num]" class="select2_group form-control"/>
                                        </td>
                                        <td>
                                             <span class="small">Expecting payout %</span>
                                             <input type="text" title="Expecting payout %" placeholder="Expecting payout %" 
                                                    value="<?php echo $bookingDetails['vbk_rfi_exp_payout']; ?>" name="bm[vbk_rfi_exp_payout]" 
                                                    class="decimalOnly select2_group form-control"/>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>
                                             <span class="small">Select RC Transfer Status <a style="float: right;color: red;" class="small" href="https://parivahan.gov.in/parivahan//en" target="_blank">Status</a></span>
                                             <select class="select2_group form-control" name="bm[vbk_rfi_rc_trans_sts]" title="RC Transfer Status">
                                                  <option>Select RC Transfer Status</option>
                                                  <?php foreach ($rcTransferStatuses as $key => $value) { ?>
                                                       <option <?php echo ($bookingDetails['vbk_rfi_rc_trans_sts'] == $value['sts_value']) ? 'selected="selected"' : ''; ?> 
                                                            value="<?php echo $value['sts_value']; ?>"><?php echo $value['sts_title']; ?></option>
                                                       <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <span class="small">RC transfer exp date</span>
                                             <input type="text" title="RC tranfer exp date" placeholder="RC tranfer exp date" 
                                                    value="<?php echo $bookingDetails['vbk_rc_trans_exp_date']; ?>" name="bm[vbk_rc_trans_exp_date]" class="dtpDatePickerEvaluation select2_group form-control"/>
                                        </td>

                                        <td>
                                             <span class="small">RC Transfer Date</span>
                                             <input type="text" title="RC Transfer Date" placeholder="RC Transfer Date" 
                                                    value="<?php
                                                    echo (strtotime($bookingDetails['vbk_rfi_rc_tranfd_date']) > 0) ?
                                                            date('d-m-Y', $bookingDetails['vbk_rfi_rc_tranfd_date']) : '';
                                                    ?>" name="bm[vbk_rfi_rc_tranfd_date]" class="dtpDatePickerEvaluation select2_group form-control"/>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>
                                             <span class="small">Insurance Transfer Status</span>
                                             <select class="select2_group form-control" name="bm[vbk_ins_trans_sts]" title="Insurance Transfer Status">
                                                  <option>Select Insurance Transfer Status</option>
                                                  <?php foreach ($rcTransferInsurnce as $key => $value) { ?>
                                                       <option <?php echo ($bookingDetails['vbk_ins_trans_sts'] == $value['sts_value']) ? 'selected="selected"' : ''; ?> 
                                                            value="<?php echo $value['sts_value']; ?>"><?php echo $value['sts_title']; ?></option>
                                                       <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <span class="small">Ins. Transfer Expected date</span>
                                             <input type="text" title="Ins. Transfer Expected date" placeholder="Ins. Transfer Expected date" 
                                                    value="<?php echo $bookingDetails['vbk_ins_trans_exp_date']; ?>" name="bm[vbk_ins_trans_exp_date]" class="dtpDatePickerEvaluation select2_group form-control"/>
                                        </td>
                                        <td>
                                             <span class="small">Ins. Transferred  date</span>
                                             <input type="text" title="Ins. Transferred  date" placeholder="Ins. Transferred  date" 
                                                    value="<?php
                                                    echo (strtotime($bookingDetails['vbk_rfi_ins_tranfd_date']) > 0) ?
                                                            date('d-m-Y', $bookingDetails['vbk_rfi_ins_tranfd_date']) : '';
                                                    ?>" name="bm[vbk_rfi_ins_tranfd_date]" class="dtpDatePickerEvaluation select2_group form-control"/>
                                        </td>
                                        <td>
                                             <span class="small">Expect delivery date</span>
                                             <input type="text" title="Expect delivery date" placeholder="Expect delivery date" 
                                                    value="<?php echo $expectDelivery; ?>" name="bm[vbk_rfi_exp_del_date]" 
                                                    class="dtpDatePickerEvaluation select2_group form-control"/>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>
                                             <span class="small">RTO</span>
                                             <select class="cmbMultiSelect select2_group form-control" name="bm[vbk_rto]">
                                                  <option value="0">Select RTO</option>
                                                  <?php foreach ($RTO as $key => $value) { ?>
                                                       <option <?php echo ($bookingDetails['vbk_rto'] == $value['rto_id']) ? 'selected="selected"' : ''; ?> 
                                                            value="<?php echo $value['rto_id']; ?>"><?php echo $value['rto_reg_num'] . ' - ' . $value['rto_place'] . ' - ' . $value['std_district_name']; ?></option>
                                                  <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <span class="small">Sub RTO</span>
                                             <input type="text" title="Sub RTO" placeholder="Sub RTO" name="bm[vbk_rto_sub]" 
                                                    value="<?php echo $bookingDetails['vbk_rto_sub']; ?>" class="select2_group form-control"/>
                                        </td>
                                        <td>
                                             <span class="small">Agent</span>
                                             <select class="select2_group form-control" name="bm[vbk_rto_agent]" title="Select Agent">
                                                  <option value="">Select Agent</option>
                                                  <option <?php echo ($bookingDetails['vbk_rto_agent'] == 1) ? 'selected="selected"' : ''; ?> value="1">RTO Agent</option>
                                                  <option <?php echo ($bookingDetails['vbk_rto_agent'] == 2) ? 'selected="selected"' : ''; ?> value="2">Bank Agent</option>
                                                  <option <?php echo ($bookingDetails['vbk_rto_agent'] == 3) ? 'selected="selected"' : ''; ?> value="3">Direct Customer</option>
                                             </select>
                                        </td>
                                        <td>
                                             <span class="small">Agent Name</span>
                                             <input type="text" title="Agent Name" placeholder="Agent Name" name="bm[vbk_rto_name]" 
                                                    value="<?php echo $bookingDetails['vbk_rto_name']; ?>" class="select2_group form-control"/>
                                        </td>
                                        <td>
                                             <span class="small">Agent Phone</span>
                                             <input type="text" title="Agent Phone" placeholder="Agent Phone" name="bm[vbk_rto_phone]" 
                                                    value="<?php echo $bookingDetails['vbk_rto_phone']; ?>" class="select2_group form-control"/>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td colspan="6">
                                             <span class="small">Description</span>
                                             <input type="text" title="Description" placeholder="Description" name="bm[vbk_rto_desc]" 
                                                    value="<?php echo $bookingDetails['vbk_rto_desc']; ?>" class="select2_group form-control"/>
                                        </td>
                                   </tr>
                              </table>
                              <table class="table table-bordered tblBokDocs">
                                   <tr style="text-align:center;font-weight: bolder;">
                                        <td colspan="2">
                                             <label style="font-size: 18px;width: 100%;text-align: center;" 
                                                    class="control-label col-md-6 col-sm-6 col-xs-12">Papers collected</label>
                                        </td>
                                        <td>
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">File status</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control" name="bm[vbk_rfi_file_trans_sts]" title="File Transfer Status">
                                                       <option>File Transfer Status</option>
                                                       <?php foreach ($fileTransferStatuses as $key => $value) { ?>
                                                            <option <?php echo ($bookingDetails['vbk_rfi_file_trans_sts'] == $value['sts_value']) ? 'selected="selected"' : ''; ?> 
                                                                 value="<?php echo $value['sts_value']; ?>"><?php echo $value['sts_title']; ?></option>
                                                            <?php } ?>
                                                  </select>
                                             </div>
                                        </td>
                                   </tr>
                                   <?php foreach ((array) $bookingDetails['addressProof'] as $key => $value) {
                                        if (!empty($value['vbd_doc_number']) || !empty($value['vbd_doc_file'])) {
                                             ?>
                                             <tr class="trBokDocs">
                                                  <td>
                                                       <?php echo $value['adp_proof_title']; ?>
                                                  </td>
                                                  <td>
                                                       <?php echo $value['vbd_doc_number']; ?>
                                                  </td>
                                                  <td>
                                                       <?php if (!empty($value['vbd_doc_file'])) { ?>
                                                            <a target="_blank" href="<?php echo '../../assets/uploads/documents/booking/' . $value['vbd_doc_file']; ?>">
                                                                 <i title="View document" class="fa fa-eye"></i>
                                                            </a>
                                                       <?php } ?>
                                                  </td>
                                             </tr>
                                             <?php
                                        }
                                   }
                                   ?>
                              </table>
                              <table class="table table-bordered tblRFIPaprColtd">
                                   <tr>
                                        <th colspan="3" style="text-align: center;">New documents</th>
                                        <th><i class="fa fa-plus btnNewRow" data-target="RFIPaprColtd"></i></th>
                                   </tr>
                                   <tr class="trRFIPaprColtd">
                                        <td>
                                             <?php
                                             $docUploaded = array_column($bookingDetails['addressProof'], 'adp_id');
                                             ?>
                                             <select name="docs[type][]" class="select2_group form-control">
                                                  <option value="">Select document</option>
                                                  <?php
                                                  foreach ($addressProof as $key => $value) {
                                                       if (!in_array($value['adp_id'], $docUploaded)) {
                                                            ?>
                                                            <option value="<?php echo $value['adp_id']; ?>"><?php echo $value['adp_proof_title']; ?></option>
                                                            <?php
                                                       }
                                                  }
                                                  ?>
                                                  <option value="-1">Other</option>
                                             </select>
                                        </td>
                                        <td>
                                             <input type="text" title="Specify other document" placeholder="Specify other document/Description" 
                                                    name="docs[number][]" class="select2_group form-control"/>
                                        </td>
                                        <td>
                                             <input type="file" name="papers[]"/>
                                        </td>
                                        <td>
                                             <i class="fa fa-minus btnRemoveRow"></i>
                                        </td>
                                   </tr>
                              </table>

                              <div class="form-group">
                                   <div class="col-md-10 col-sm-6 col-xs-8">
                                        <textarea required type="text" class="form-control col-md-7 col-xs-8" 
                                                  name="confim[vbc_verify_desc]" placeholder="Current status"></textarea>    
                                   </div>
                                   <div class="col-md-2 col-sm-6 col-xs-8">
                                        <select required class="select2_group form-control" name="bm[vbk_rfi_status]" title="Overall Status">
                                             <option>Overall Status</option>
                                             <?php foreach ($rfiStatus as $key => $value) { ?>
                                                  <option <?php echo ($bookingDetails['vbk_rfi_status'] == $value['sts_value']) ? 'selected="selected"' : ''; ?> 
                                                       value="<?php echo $value['sts_value']; ?>"><?php echo $value['sts_title']; ?></option>
                                                  <?php } ?>
                                        </select>
                                   </div>
                              </div>

                              <div class="ln_solid"></div>
                              <button value="<?php echo confm_book; ?>" name="status" type="submit" 
                                      class="btn btn-success">Submit comments <i class="fa fa-comments"></i></button>

<!--                              <button value="<?php echo rfi_loan_approved; ?>" name="status" style="float: right;"
                                      type="submit" class="btn btn-success">Loan approved <i class="fa fa-arrow-right"></i></button>-->

                         </form>
                         <?php echo $history; ?>
                    </div>
               </div>
          </div>
     </div>
</div>