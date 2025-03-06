<div class="popReservationForm_2 modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog full-width" role="document" style="float: left;">
        <form class="modal-content frmReserveVehicle" action="<?php echo site_url('followup/reserveVehicle'); ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="float: left;">Order Booking From</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Customer Detail</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <input type="hidden" value="<?php echo $enquiry['enq_id']; ?>" name="bm[vbk_enq_id]"/>
                                <input type="hidden" value="<?php echo $vehicles['val_id']; ?>" name="bm[vbk_evaluation_veh_id]"/>

                                <table class="table table-bordered" style="margin-bottom: 0px;">
                                    <tr>
                                        <td>Customer name : <input name="bm[vbk_cust_name]" class="select2_group form-control" 
                                                                   value="<?php echo $enquiry['enq_cus_name']; ?>"/></td>
                                        <td>Date : <?php echo date('d-m-Y'); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="">Permanent address : 
                                            <textarea name="bm[vbk_per_address]" class="form-control col-md-7 col-xs-12"><?php echo $enquiry['enq_cus_address'] . ', ' . $enquiry['cit_name']; ?></textarea>
                                        </td>
                                        <td>RC Transfer address : <textarea name="bm[vbk_rd_trans_address]" class="form-control col-md-7 col-xs-12"><?php echo $enquiry['enq_cus_address'] . ', ' . $enquiry['cit_name']; ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Phone number (Official) : <input name="bm[vbk_off_ph_no]" class="select2_group form-control" value="<?php echo $enquiry['enq_cus_mobile']; ?>"/></td>
                                        <td>Phone number (Personal) : <input name="bm[vbk_per_ph_no]" class="select2_group form-control" value="<?php echo $enquiry['enq_cus_mobile']; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>Email ID : <input name="bm[vbk_email]" class="select2_group form-control" value="<?php echo $enquiry['enq_cus_email']; ?>"/></td>
                                        <td>DOB : <input name="bm[vbk_dob]" class="select2_group form-control" value=""/></td>
                                    </tr>
                                </table>
                                <table class="table table-bordered tblBokDocs">
                                    <tr>
                                        <th colspan="4">Documents <i class="btnAddBookDocs fa fa-plus"></i></th>
                                    </tr>
                                    <tr class="trBokDocs">
                                        <td>
                                            <select name="ap[vbd_doc_type][]" class="select2_group form-control">
                                                <option value="0">Select address proof</option>
                                                <?php foreach ($addressProof as $key => $value) { ?>
                                                    <option value="<?php echo $value['adp_id']; ?>"><?php echo $value['adp_proof_title']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="select2_group form-control" type="text" name="ap[vbd_doc_number][]" placeholder="Address proof number"/>
                                        </td>
                                        <td>
                                            <input type="file" name="vbd_doc_file[]"/>
                                        </td>
                                        <td><i class="btnRemoveRow fa fa-minus"></i></td>
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
                                            Model : <?php echo $vehicles['mod_title'] . ', ' . $vehicles['var_variant_name']; ?>
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
                                                <div style="float: left;width: 104px;"><?php echo $vehicles['val_km']; ?></div>
                                            </div>
                                            <div style="width: 55%;float: left;">
                                                <div style="width: 100px;float: left;">No of ownership : </div>
                                                <div style="float: left;width: 60px;"><?php echo $vehicles['val_no_of_owner']; ?></div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="1" style="text-align: center;">Insurance</th>
                                            <th colspan="2" style="text-align: center;">Insurance Company</th>
                                            <th colspan="3" style="text-align: center;"><?php echo $vehicles['val_insurance_company']; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Comprehensive</td>
                                            <td>Valid up to</td>
                                            <td><?php echo!empty($vehicles['val_insurance_comp_date']) ? date('d-m-Y', strtotime($vehicles['val_insurance_comp_date'])) : ''; ?></td>
                                            <td>IDV</td>
                                            <td><?php echo $vehicles['val_insurance_comp_idv']; ?></td>
                                            <td>NCB%</td>
                                            <td><?php echo $vehicles['val_insurance_ll_idv']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Third Party</td>
                                            <td>Valid up to</td>
                                            <td><?php echo!empty($vehicles['val_insurance_ll_date']) ? date('d-m-Y', strtotime($vehicles['val_insurance_ll_date'])) : ''; ?></td>
                                            <td>Insurance Type</td>
                                            <td>
                                                <?php
                                                $insType = unserialize(INSURANCE_TYPES);
                                                echo isset($insType[$vehicles['val_insurance']]) ? $insType[$vehicles['val_insurance']] : '';
                                                ?>
                                            </td>
                                            <td>NCB Required</td>
                                            <td><?php echo ($vehicles['val_insurance_need_ncb'] == 1) ? 'YES' : 'NO'; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Other details</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="form-group">
                                    <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">Expect delivery date</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input placeholder="Expect delivery date" type="text" class="dtpExpDelTime form-control col-md-7 col-xs-12" 
                                               name="bm[vbk_expect_delivery]"/>
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
                                                        <div style="width: 70%;" class="control-label col-md-12 col-sm-12 col-xs-12">Required Refurbish <span class="snpAddRefurbTotal">Rs/- 0.00</span></div>
                                                    </th>
                                                    <th><div style="float: right;"><i class="btnNewAddRefurb fa fa-plus"></i></div></th>
                                                </tr>
                                            </thead>
                                            <tr class="trAddRefurb">
                                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="rf[vbr_refurb_desc][]" id="mod_title" placeholder="Refurbish"/></td>
                                                <td><input type="text" class="txtReqRefurbAmt form-control col-md-7 col-xs-12 decimalOnly" name="rf[vbr_refurb_amt][]" id="mod_title" placeholder="Refurbish amount"/></td>
                                                <td>
                                                    <select name="rf[vbr_don_by][]" class="form-control">
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
                                                        <div style="width: 70%;" class="control-label col-md-12 col-sm-12 col-xs-12">Required Accessories<span class="spnAddAccessoriesTotal">Rs/- 0.00</span></div>

                                                    </th>
                                                    <th><div style="float: right;"><i class="btnNewAddAccessories fa fa-plus"></i></div></th>
                                                </tr>
                                            </thead>
                                            <tr class="trAddAccessories">
                                                <td><input type="text" class="form-control col-md-7 col-xs-12" name="ac[vba_accessories_desc][]" id="mod_title" placeholder="Accessories"/></td>
                                                <td><input type="text" class="txtReqAccessoriesAmt form-control col-md-7 col-xs-12 decimalOnly" name="ac[vba_accessories_amt][]" id="mod_title" placeholder="Accessories amount"/></td>
                                                <td>
                                                    <select name="ac[vba_don_by][]" class="form-control">
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
                                                    <th colspan="3" style="text-align: center;">
                                                        <div class="control-label col-md-12 col-sm-12 col-xs-12">Insurance and loan details</div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2"><input ype="text" class="form-control col-md-7 col-xs-12"
                                                                           name="bm[vbk_insurance_co]" id="mod_title" placeholder="Insurance Company"/></td>

                                                    <td><input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" 
                                                               name="bm[vbk_insurance_amt]" id="mod_title" placeholder="Insurance Amount"/></td>
                                                </tr>

                                                <tr>
                                                    <td><input type="text" class="form-control col-md-7 col-xs-12" 
                                                               name="bm[vbk_fin_bank_name]" id="mod_title" placeholder="If By Finance : Bank Name:"/></td>

                                                    <td><input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" 
                                                               name="bm[vbk_loan_amt]" id="mod_title" placeholder="Loan Amount"/></td>

                                                    <td><input type="text" class="form-control col-md-7 col-xs-12 decimalOnly" 
                                                               name="bm[vbk_tenor]" id="mod_title" placeholder="Tenor"/></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="hidden" class="txtTCSPer" value="<?php echo get_settings_by_key('tcs_per'); ?>"/>
                                    <input type="hidden" class="txtTCSLimit" value="<?php echo get_settings_by_key('tcs_limit'); ?>"/>
                                    <div>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Vehicle sold price</td>
                                                    <td><input type="text" class="txtVehiclePrice form-control col-md-7 col-xs-12 decimalOnly" 
                                                               name="bm[vbk_vehicle_amt]" value="0.00" id="mod_title" placeholder="Vehicle sold price"/></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div style="float: left;">TCS (<?php echo get_settings_by_key('tcs_per'); ?>) </div> 
                                                        <div style="float: left;margin-left: 20px;"> <input type="checkbox" value="1" class="chkIsTCSApply"/> TCS Apply </div>
                                                    </td>
                                                    <td>
                                                        <input name="bm[vbk_tcs]" type="text" class="txtTCSAmt form-control col-md-7 col-xs-12 decimalOnly" placeholder="TCS" value="0.00"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>RTO Transfer & Service Charge</td>
                                                    <td><input name="bm[vbk_rto_charges]" type="text" class="txtRTOCharges form-control col-md-7 col-xs-12 decimalOnly" 
                                                               value="0.00" id="mod_title" placeholder="RTO Transfer & Service Charge"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Refurbishment Charge</td>
                                                    <td><input type="text" class="txtAddRefurbTotal form-control col-md-7 col-xs-12 decimalOnly" 
                                                               name="bm[vbk_refurbish_cost]" value="0.00" id="mod_title" placeholder="Refurbishment Charge"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Accessories Charge</td>
                                                    <td><input type="text" class="txtAddAccessoriesTotal form-control col-md-7 col-xs-12 decimalOnly" 
                                                               name="bm[vbk_accessories_cost]" value="0.00" id="mod_title" placeholder="Accessories Charge"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Sales Amount</td>
                                                    <td><input type="text" class="txtTtlSaleAmt form-control col-md-7 col-xs-12 decimalOnly" 
                                                               name="bm[vbk_ttl_sale_amt]" value="0.00" id="mod_title" placeholder="Total Sales Amount"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Advance Amount</td>
                                                    <td><input type="text" class="txtAdvanceAmt form-control col-md-7 col-xs-12 decimalOnly" 
                                                               name="bm[vbk_advance_amt]" value="0.00" id="mod_title" placeholder="Advance Amount"/></td>
                                                </tr>
                                                <tr>
                                                    <td>Balance Amount</td>
                                                    <td><input type="text" class="txtBalanceAmt form-control col-md-7 col-xs-12 decimalOnly" 
                                                               name="bm[vbk_balance]" value="0.00" id="mod_title" placeholder="Balance Amount"/></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>