<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Booked vehicles</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form method="post" action="<?php echo site_url('booking/editBooking'); ?>" class="form-horizontal form-label-left" enctype="multipart/form-data">
                              <table class="table table-bordered">
                                   <tbody>
                                        <tr>
                                             <th>Booked by : <?php echo $bookingDetails['bkdby_first_name'] . ' ' . $bookingDetails['btdby_last_name']; ?></th>
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
                                             <td>Customer name : <input required type="text" name="bm[vbk_cust_name]" value="<?php echo $bookingDetails['vbk_cust_name']; ?>" /></td>
                                             <td>Booking Date : <?php echo $bookingDetails['vbk_added_on']; ?></td>
                                        </tr>
                                        <tr>
                                             <td colspan="">
                                                  Permanent address : <textarea required name="bm[vbk_per_address]"><?php echo $bookingDetails['vbk_per_address']; ?></textarea><br>
                                                  PIN : <input required class="numOnly" type="text" name="bm[vbk_pin]" value="<?php echo $bookingDetails['vbk_pin']; ?>" />
                                             </td>
                                             <td>
                                                  RC Transfer address : <textarea required name="bm[vbk_rd_trans_address]"><?php echo $bookingDetails['vbk_rd_trans_address']; ?></textarea><br>
                                                  PIN : <input required class="numOnly" type="text" name="bm[vbk_rc_trns_pin]" value="<?php echo $bookingDetails['vbk_rc_trns_pin']; ?>" />
                                             </td>
                                        </tr>
                                        <tr>
                                             <td>Phone number (Official) : <input required class="numOnly" type="text" name="bm[vbk_off_ph_no]" value="<?php echo $bookingDetails['vbk_off_ph_no']; ?>" /></td>
                                             <td>Phone number (Personal) : <input required class="numOnly" type="text" name="bm[vbk_per_ph_no]" value="<?php echo $bookingDetails['vbk_per_ph_no']; ?>" /></td>
                                        </tr>
                                        <tr>
                                             <td>Email ID : <input type="email" name="bm[vbk_email]" value="<?php echo $bookingDetails['vbk_email']; ?>" /></td>
                                             <td>DOB : <input class="dtpEnquiry" name="bm[vbk_dob]" value="<?php echo !empty($bookingDetails['vbk_dob']) ? date('d-m-Y', strtotime($bookingDetails['vbk_dob'])) : ''; ?>" /> </td>
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
                                                  <?php echo strtoupper($bookingDetails['val_veh_no']); ?>
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
                              <?php if (!empty($bookingDetails['addressProof'])) { ?>
                                   <table class="table table-bordered tblBokDocs">
                                        <tr style="text-align:center;font-weight: bolder;">
                                             <td colspan="3">Address proof</td>
                                        </tr>
                                        <?php
                                        foreach ((array) $bookingDetails['addressProof'] as $key => $value) {
                                             if (!empty($value['vbd_doc_file'])) {
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
                              <?php } ?>
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
                                             <select <?php echo empty($bookingDetails['addressProof']) ? 'required' : ''; ?> name="docs[type][]" class="select2_group form-control">
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
                                             <input type="text" title="Specify other document" placeholder="Specify other document/Description" name="docs[number][]" class="select2_group form-control" />
                                        </td>
                                        <td>
                                             <input type="file" name="papers[]" />
                                        </td>
                                        <td>
                                             <i class="fa fa-minus btnRemoveRow"></i>
                                        </td>
                                   </tr>
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
                                                            <input value="<?php echo $value['vbr_id']; ?>" type="checkbox" name="verifyRefurb[<?php echo $value['vbr_id']; ?>]" /> Verify
                                                       </td>
                                                  <?php } ?>
                                             </tr>
                                        <?php } ?>
                                   </table>
                              <?php }
                              if (!empty($bookingDetails['access'])) { ?>
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
                                                            <input value="<?php echo $value['vba_id']; ?>" type="checkbox" name="verifyAccess[<?php echo $value['vba_id']; ?>]" /> Verify
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
                                             <td><?php echo !empty($bookingDetails['val_insurance_comp_date']) ? date('d-m-Y', strtotime($bookingDetails['val_insurance_comp_date'])) : ''; ?></td>
                                             <td>IDV</td>
                                             <td><?php echo get_in_currency_format($bookingDetails['val_insurance_comp_idv']); ?></td>
                                             <td>NCB%</td>
                                             <td><?php echo $bookingDetails['val_insurance_ll_idv']; ?></td>
                                        </tr>
                                        <tr>
                                             <td>Third Party</td>
                                             <td>Valid up to</td>
                                             <td><?php echo !empty($bookingDetails['val_insurance_ll_date']) ? date('d-m-Y', strtotime($bookingDetails['val_insurance_ll_date'])) : ''; ?></td>
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
                                                  <div class="control-label col-md-12 col-sm-12 col-xs-12">New insurance and loan details</div>
                                             </th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <td colspan="2">
                                                  Insurance company : <input type="text" value="<?php echo $bookingDetails['vbk_insurance_co']; ?>" name="bm[vbk_insurance_co]" />
                                                  Insurance validity : <input type="text" value="<?php echo !empty($bookingDetails['vbk_insurance_valid_upto']) ? date('d-m-Y', strtotime($bookingDetails['vbk_insurance_valid_upto'])) : ''; ?>" class="dtpDatePickerEvaluation" name="bm[vbk_insurance_valid_upto]" />
                                             </td>
                                             <td>
                                                  Insurance Amount : <input type="text" value="<?php echo $bookingDetails['vbk_insurance_amt']; ?>" name="bm[vbk_insurance_amt]" class="decimalOnly" />
                                             </td>
                                             <td>IDV : <input type="text" value="<?php echo $bookingDetails['vbk_insurance_idv']; ?>" name="bm[vbk_insurance_idv]" class="decimalOnly" /> </td>
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
                                                  <td>Vehicle sold price</td>
                                                  <td>
                                                       <input type="text" value="<?php echo $bookingDetails['vbk_vehicle_amt']; ?>" name="bm[vbk_vehicle_amt]" class="decimalOnly" />
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>
                                                       <div style="float: left;">TCS (<?php echo get_settings_by_key('tcs_per'); ?>)</div>
                                                  </td>
                                                  <td>
                                                       <input type="text" value="<?php echo $bookingDetails['vbk_tcs']; ?>" name="bm[vbk_tcs]" class="decimalOnly" />
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>RTO Transfer &amp; Service Charge</td>
                                                  <td>
                                                       <input type="text" value="<?php echo $bookingDetails['vbk_rto_charges']; ?>" name="bm[vbk_rto_charges]" class="decimalOnly" />
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Refurbishment Charge</td>
                                                  <td>
                                                       <input type="text" value="<?php echo $bookingDetails['vbk_refurbish_cost']; ?>" name="bm[vbk_refurbish_cost]" class="decimalOnly" />
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Accessories Charge</td>
                                                  <td>
                                                       <input type="text" value="<?php echo $bookingDetails['vbk_accessories_cost']; ?>" name="bm[vbk_accessories_cost]" class="decimalOnly" />
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Total Sales Amount</td>
                                                  <td>
                                                       <input type="text" value="<?php echo $bookingDetails['vbk_ttl_sale_amt']; ?>" name="bm[vbk_ttl_sale_amt]" class="decimalOnly" />
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Advance Amount</td>
                                                  <td>
                                                       <input type="text" value="<?php echo $bookingDetails['vbk_advance_amt']; ?>" name="bm[vbk_advance_amt]" class="decimalOnly" />
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td>Balance Amount</td>
                                                  <td>
                                                       <input type="text" value="<?php echo $bookingDetails['vbk_balance']; ?>" name="bm[vbk_balance]" class="decimalOnly" />
                                                  </td>
                                             </tr>
                                        </tbody>
                                   </table>
                              <?php } ?>

                              <!-- Hidden fields -->
                              <input type="hidden" name="bm[vbk_enq_id]" value="<?php echo $bookingDetails['vbk_enq_id']; ?>" />
                              <input type="hidden" name="bm[vbk_id]" value="<?php echo $bookingDetails['vbk_id']; ?>" />
                              <input type="hidden" name="bm[vbk_evaluation_veh_id]" value="<?php echo $bookingDetails['vbk_evaluation_veh_id']; ?>" />
                              <input type="hidden" name="add_info" value="<?php echo strtoupper($vehicles['val_veh_no']) . ' - ' . $vehicles['brd_title'] . ', ' . $vehicles['mod_title'] . ', ' . $vehicles['var_variant_name']; ?>" />
                              <input type="hidden" name="status" value="<?php echo $bookingDetails['vbk_status']; ?>" />
                              <input type="hidden" name="bm[vbk_sales_staff]" value="<?php echo $bookingDetails['vbk_sales_staff']; ?>" />
                              <input type="hidden" name="vehicleDetails" value='<?php echo serialize($bookingDetails); ?>' />
                              <!-- Hidden fields -->

                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Delivery date</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" name="bm[vbk_delivery_date]" autocomplete="off" id="vbk_delivery_date" placeholder="Delivery date" />
                                   </div>
                              </div>

                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea type="text" class="form-control col-md-7 col-xs-12" name="bm[vbc_verify_desc]" placeholder="Description"></textarea>

                                   </div>
                              </div>

                              <div class="ln_solid"></div>
                              <div class="form-group">
                                   <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                   </div>
                              </div>
                         </form>
                         <?php echo isset($history) ? $history : ''; ?>
                    </div>
               </div>
          </div>
     </div>
</div>