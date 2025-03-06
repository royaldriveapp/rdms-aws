<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Token cancel <?php echo $data['vbk_ref_no'] . ' - ' . $data['val_veh_no']; ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="post" action="<?php echo site_url('booking/editBooking'); ?>" class="form-horizontal form-label-left" enctype="multipart/form-data">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Customer Name</th>
                                    <td><?php echo $data['vbk_cust_name']; ?></td>
                                    <th>State</th>
                                    <td><?php echo $data['sts_name']; ?></td>
                                    <th>District</th>
                                    <td><?php echo $data['std_district_name']; ?></td>
                                </tr>
                                <tr>
                                    <th>Sales Amount</th>
                                    <td><?php echo $data['vbk_ttl_sale_amt']; ?></td>
                                    <th>Advance Amount</th>
                                    <td><?php echo $data['vbk_advance_amt']; ?></td>
                                    <th>TCS</th>
                                    <td><?php echo $data['vbk_tcs']; ?></td>
                                </tr>
                                <tr>
                                    <th>RTO Charges</th>
                                    <td><?php echo $data['vbk_rto_charges']; ?></td>
                                    <th>Company</th>
                                    <td><?php echo $data['cmp_name']; ?></td>
                                    <th>Minif Year</th>
                                    <td><?php echo $data['val_minif_year']; ?></td>
                                </tr>
                                <tr>
                                    <th>Engine</th>
                                    <td><?php echo $data['val_engine_no']; ?></td>
                                    <th>Chasis</th>
                                    <td><?php echo $data['val_chasis_no']; ?></td>
                                    <th>Color</th>
                                    <td><?php echo $data['val_color']; ?></td>
                                </tr>
                                <tr>
                                    <th>Vehicle</th>
                                    <td colspan="3"><?php echo $data['brd_title'] . ', ' . $data['mod_title'] . ', ' . $data['var_variant_name']; ?></td>
                                    <th>Model Year</th>
                                    <td><?php echo $data['val_model_year']; ?></td>
                                </tr>
                                <tr>
                                    <th>Address 1</th>
                                    <td colspan="5"><?php echo $data['vbk_per_address']; ?></td>
                                </tr>
                                <tr>
                                    <th>Address 2</th>
                                    <td colspan="5"><?php echo $data['vbk_rd_trans_address']; ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <tr>
                                <th colspan="4">Account Details</th>
                            </tr>
                            <tr>
                                <td>A/c Number</td>
                                <td><input required type="text" class="form-control col-md-7 col-xs-12" name="vbk_accnumber" id="vbk_accnumber" placeholder="A/c Number" /></td>
                                <td>IFSC Code</td>
                                <td><input required type="text" class="form-control col-md-7 col-xs-12" name="vbk_ifsc" id="vbk_ifsc" placeholder="IFSC Code" /></td>
                                <td>A/c Holder Name</td>
                                <td><input required type="text" class="form-control col-md-7 col-xs-12" name="vbk_accholdername" id="vbk_accholdername" placeholder="A/c Holder Name" /></td>
                            </tr>
                            <tr>
                                <td>Bank Name</td>
                                <td colspan="2">
                                    <select class="cmbSearchList select2_group form-control" name="bm[vbk_fin_bank_name]" id="val_hypo_bank">
                                        <option value="">Select bank</option>
                                        <?php foreach ($banks as $key => $value) { ?>
                                            <option value="<?php echo $value['bnk_id']; ?>">
                                                <?php echo $value['bnk_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>Branch</td>
                                <td colspan="2"><input required type="text" class="form-control col-md-7 col-xs-12" name="vbk_bank_branch" id="vbk_bank_branch" placeholder="Branch" /></td>
                            </tr>
                        </table>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-primary">Cancel</button>
                                <a href="<?php echo site_url($__CLASS__); ?>" class="btn btn-primary">Exit</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    td {
        vertical-align: middle;
    }
</style>