<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Booked vehicles</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form method="post" action="<?php echo site_url('followup/decisionMaking');?>" class="form-horizontal form-label-left">
                              <table class="table table-bordered">
                                   <tbody>
                                        <tr>
                                             <th colspan="2" style="text-align: center;">Customer details</th>
                                        </tr>
                                        <tr>
                                             <td>Customer name : <?php echo $bookingDetails['vbk_cust_name'];?></td>
                                             <td>Date : <?php echo $bookingDetails['vbk_added_on'];?></td>
                                        </tr>
                                        <tr>
                                             <td colspan="">Permanent address : <?php echo $bookingDetails['vbk_per_address'];?></td>
                                             <td>RC Transfer address : <?php echo $bookingDetails['vbk_rd_trans_address'];?></td>
                                        </tr>
                                        <tr>
                                             <td>Phone number (Official) : <?php echo $bookingDetails['vbk_off_ph_no'];?></td>
                                             <td>Phone number (Personal) : <?php echo $bookingDetails['vbk_per_ph_no'];?></td>
                                        </tr>
                                        <tr>
                                             <td>Email ID : <?php echo $bookingDetails['vbk_email'];?></td>
                                             <td>DOB : <?php echo $bookingDetails['vbk_dob'];?></td>
                                        </tr>
                                   </tbody>
                              </table>
                              <table class="table table-bordered tblBokDocs">
                                   <tr style="text-align:center;font-weight: bolder;">
                                        <td colspan="3">Address proof</td>
                                   </tr>
                                   <?php foreach ((array) $bookingDetails['addressProof'] as $key => $value) {?>
                                          <tr class="trBokDocs">
                                               <td>
                                                    <?php echo $value['adp_proof_title'];?>
                                               </td>
                                               <td>
                                                    <?php echo $value['vbd_doc_number'];?>
                                               </td>
                                               <td>
                                                    <a target="_blank" href="<?php echo '../../assets/uploads/documents/booking/' . $value['vbd_doc_file'];?>">
                                                         <i title="View document" class="fa fa-eye"></i>
                                                    </a>
                                               </td>
                                          </tr>
                                     <?php }?>
                              </table>
                              <table class="table table-bordered">
                                   <tr style="text-align:center;font-weight: bolder;">
                                        <td colspan="4">Refurbishment</td>
                                   </tr>
                                   <?php foreach ((array) $bookingDetails['refurb'] as $key => $value) {?>
                                          <tr class="trBokDocs">
                                               <td>
                                                    <?php echo $value['vbr_refurb_desc'];?>
                                               </td>
                                               <td>
                                                    <?php echo $value['vbr_refurb_amt'];?>
                                               </td>
                                               <td>
                                                    <?php echo ($value['vbr_don_by'] == 1) ? 'RD' : 'Customer';?>
                                               </td>
                                               <td>
                                                    <input value="<?php echo $value['vbr_id']; ?>" type="checkbox" name="verifyRefurb[<?php echo $value['vbr_id'];?>]"/> Verify
                                               </td>
                                          </tr>
                                     <?php }?>
                              </table>
                              <table class="table table-bordered">
                                   <tr style="text-align:center;font-weight: bolder;">
                                        <td colspan="4">Accessories</td>
                                   </tr>
                                   <?php foreach ((array) $bookingDetails['access'] as $key => $value) {?>
                                          <tr class="trBokDocs">
                                               <td>
                                                    <?php echo $value['vba_accessories_desc'];?>
                                               </td>
                                               <td>
                                                    <?php echo $value['vba_accessories_amt'];?>
                                               </td>
                                               <td>
                                                    <?php echo ($value['vba_don_by'] == 1) ? 'RD' : 'Customer';?>
                                               </td>
                                               <td>
                                                    <input value="<?php echo $value['vba_id']; ?>" type="checkbox" name="verifyAccess[<?php echo $value['vba_id'];?>]"/> Verify
                                               </td>
                                          </tr>
                                     <?php }?>
                              </table>
                              <table class="table table-bordered">
                                   <tbody>
                                        <tr>
                                             <th colspan="2" style="text-align: center;">Vehicle details</th>
                                        </tr>
                                        <tr>
                                             <td>
                                                  <?php echo $bookingDetails['val_veh_no'];?>
                                             </td>
                                             <td>
                                                  <?php echo $bookingDetails['brd_title'] . ', ' . $bookingDetails['mod_title'] . ', ' . $bookingDetails['var_variant_name'];?>
                                                  Production Year : <?php echo $bookingDetails['val_minif_year'];?>
                                             </td>
                                        </tr>
                                        <tr>
                                             <td>
                                                  Chassis Number : <?php echo $bookingDetails['val_chasis_no'];?>                                                  
                                             </td>
                                             <td>
                                                  <div style="width: 45%;float: left;">
                                                       <div style="width: 30px;float: left;">KM : </div>
                                                       <div style="float: left;width: 104px;"><?php echo $bookingDetails['val_km'];?></div>
                                                  </div>
                                                  <div style="width: 55%;float: left;">
                                                       <div style="width: 110px;float: left;">No of ownership : </div>
                                                       <div style="float: left;width: 60px;"><?php echo $bookingDetails['val_no_of_owner'];?></div>
                                                  </div>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>
                              <table class="table table-bordered">
                                   <thead>
                                        <tr>
                                             <th colspan="7" style="text-align: center;">
                                                  Existing insurance details
                                             </th>
                                        </tr>
                                        <tr>
                                             <th colspan="2" style="text-align: center;">Insurance Company</th>
                                             <th colspan="5" style="text-align: center;"><?php echo $bookingDetails['val_insurance_company'];?></th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <td>Comprehensive</td>
                                             <td>Valid up to</td>
                                             <td><?php echo!empty($bookingDetails['val_insurance_comp_date']) ? date('d-m-Y', strtotime($bookingDetails['val_insurance_comp_date'])) : '';?></td>
                                             <td>IDV</td>
                                             <td><?php echo $bookingDetails['val_insurance_comp_idv'];?></td>
                                             <td>NCB%</td>
                                             <td><?php echo $bookingDetails['val_insurance_ll_idv'];?></td>
                                        </tr>
                                        <tr>
                                             <td>Third Party</td>
                                             <td>Valid up to</td>
                                             <td><?php echo!empty($bookingDetails['val_insurance_ll_date']) ? date('d-m-Y', strtotime($bookingDetails['val_insurance_ll_date'])) : '';?></td>
                                             <td>Insurance Type</td>
                                             <td>
                                                  <?php
                                                    $insType = unserialize(INSURANCE_TYPES);
                                                    echo isset($insType[$bookingDetails['val_insurance']]) ? $insType[$bookingDetails['val_insurance']] : '';
                                                  ?>
                                             </td>
                                             <td>NCB Required</td>
                                             <td><?php echo ($bookingDetails['val_insurance_need_ncb'] == 1) ? 'YES' : 'NO';?></td>
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
                                                  Insurance : <?php echo $bookingDetails['vbk_insurance_co'];?>
                                             </td>
                                             <td>
                                                  Insurance Amount : <?php echo $bookingDetails['vbk_insurance_amt'];?>
                                             </td>
                                        </tr>

                                        <tr>
                                             <td>
                                                  Finance : <?php echo $bookingDetails['vbk_fin_bank_name'];?>
                                             </td>
                                             <td>
                                                  Load Amount : <?php echo $bookingDetails['vbk_loan_amt'];?>
                                             </td>
                                             <td>
                                                  Tenor : <?php echo $bookingDetails['vbk_tenor'];?>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>
                              <?php if (check_permission('reservation', 'allowfindetails')) {?>
                                     <table class="table table-bordered">
                                          <tbody>
                                               <tr>
                                                    <td>Vehicle sold price</td>
                                                    <td><input type="text" class="txtVehiclePrice form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_vehicle_amt]" value="0.00" id="mod_title" placeholder="Vehicle sold price"></td>
                                               </tr>
                                               <tr>
                                                    <td>
                                                         <div style="float: left;">TCS () </div> 
                                                         <div style="float: left;margin-left: 20px;"> <input type="checkbox" value="1" class="chkIsTCSApply"> TCS Apply </div>
                                                    </td>
                                                    <td>
                                                         <input name="bm[vbk_tcs]" type="text" class="txtTCSAmt form-control col-md-7 col-xs-12 decimalOnly" placeholder="TCS" value="0.00">
                                                    </td>
                                               </tr>
                                               <tr>
                                                    <td>RTO Transfer &amp; Service Charge</td>
                                                    <td><input name="bm[vbk_rto_charges]" type="text" class="txtRTOCharges form-control col-md-7 col-xs-12 decimalOnly" value="0.00" id="mod_title" placeholder="RTO Transfer &amp; Service Charge"></td>
                                               </tr>
                                               <tr>
                                                    <td>Refurbishment Charge</td>
                                                    <td><input type="text" class="txtAddRefurbTotal form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_refurbish_cost]" value="0.00" id="mod_title" placeholder="Refurbishment Charge"></td>
                                               </tr>
                                               <tr>
                                                    <td>Accessories Charge</td>
                                                    <td><input type="text" class="txtAddAccessoriesTotal form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_accessories_cost]" value="0.00" id="mod_title" placeholder="Accessories Charge"></td>
                                               </tr>
                                               <tr>
                                                    <td>Total Sales Amount</td>
                                                    <td><input type="text" class="txtTtlSaleAmt form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_ttl_sale_amt]" value="0.00" id="mod_title" placeholder="Total Sales Amount"></td>
                                               </tr>
                                               <tr>
                                                    <td>Advance Amount</td>
                                                    <td><input type="text" class="txtAdvanceAmt form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_advance_amt]" value="0.00" id="mod_title" placeholder="Advance Amount"></td>
                                               </tr>
                                               <tr>
                                                    <td>Balance Amount</td>
                                                    <td><input type="text" class="txtBalanceAmt form-control col-md-7 col-xs-12 decimalOnly" name="bm[vbk_balance]" value="0.00" id="mod_title" placeholder="Balance Amount"></td>
                                               </tr>
                                          </tbody>
                                     </table>
                              <?php }?>

                              <!-- Hidden fields -->
                              <input type="hidden" name="confim[vbc_book_master]" value="<?php echo $bookingDetails['vbk_id'];?>"/>
                              <input type="hidden" name="confim[vbc_verify_by]" value="<?php echo $this->uid;?>"/>
                              <input type="hidden" name="confim[vbc_verify_by_grp_slug]" value="<?php echo $this->usr_grp;?>"/>
                              <input type="hidden" name="confim[vbc_verify_by_grp_id]" value="<?php echo $this->grp_id;?>"/>
                              <input type="hidden" name="confim[vbc_verify_by_showrm]" value="<?php echo $this->shrm;?>"/>
                              <input type="hidden" name="confim[vbc_enq_id]" value="<?php echo $bookingDetails['vbk_enq_id'];?>"/>
                              <!-- Hidden fields -->

                              <div class="form-group">
                                   <div class="col-md-12 col-sm-6 col-xs-12">
                                        <textarea required type="text" class="form-control col-md-7 col-xs-12" 
                                                  name="confim[vbc_verify_desc]" placeholder="Description"></textarea>
                                   </div>
                              </div>

                              <div class="ln_solid"></div>
                              <div class="form-group">
                                   <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button value="<?php echo reject_book;?>" name="status" type="submit" class="btn btn-danger">Reject the booking</button>
                                        <button value="<?php echo confm_book;?>" name="status" type="submit" class="btn btn-success">Verify the booking</button>
                                   </div>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>