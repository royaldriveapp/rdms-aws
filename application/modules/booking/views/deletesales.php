<?php

?>

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Approve Sales <?php echo $category; ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right;">
                            <!-- <a href="<?php //echo site_url('ihits_api/log'); 
                                            ?>">List</a> -->
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    echo form_open_multipart($controller . "/deletesales/" . $category . '/' . $bkId, array('id' => "frmBrand", 'class' => "form-horizontal form-label-left")) ?>
                    <?php if ($category == 'token') {
                        $labelArray = array(
                            'brd_title' => 'Brand',
                            'mod_title' => 'Model',
                            'var_variant_name' => 'Variant',
                            'vc_color' => 'Color',
                            'val_model_year' => 'Model year',
                            'val_engine_no' => 'Engine no',
                            'val_chasis_no' => 'Chasis no',
                            'val_veh_no' => 'Reg no.',
                            'vbk_cust_name' => 'Customer',
                            'vbk_per_address' => 'Address 1',
                            'vbk_rd_trans_address' => 'Address 2',
                            'vbk_state' => 'State',
                            'vbk_dist' => 'District',
                            'vbk_sales_staff_name' => 'Sales officer',
                            'vbk_added_on' => 'Sale date',
                            'vbk_ttl_sale_amt' => 'Total sale amount',
                            'vbk_advance_amt' => 'Advance',
                            'vbk_discount' => 'Delivery charges',
                            'vbk_sale_type' => 'Sales type',
                            'shr_location' => 'Location',
                            'vbk_ref_no' => 'Reference no',
                            'stockID' => 'Stock id',
                            'enq_trans_mode' => 'Trans mode',
                            'tcS_Amt' => 'TCS Amount',
                            'gcCode' => 'Company Code',
                            'dc' => 'Delivery charges'
                        ); ?>
                        <?php foreach ($saleData as $key => $value) {
                            if ($key == 'gcCode') { ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $labelArray[$key]; ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select required class="select2_group form-control" name="postfields[<?php echo $key; ?>]">
                                            <?php foreach ($company as $kc => $vc) { ?>
                                                <option <?php echo ($vc['cmp_finance_year_code'] == $value) ? 'selected' : ''; ?> value="<?php echo $vc['cmp_finance_year_code']; ?>"><?php echo $vc['cmp_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $labelArray[$key]; ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input required type="text" class="form-control col-md-7 col-xs-12" name="postfields[<?php echo $key; ?>]" value="<?php echo $value; ?>" />
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    <?php } else if ($category == 'sales') {
                        $labelArray = array(
                            'brd_title' => 'Brand',
                            'mod_title' => 'Model',
                            'var_variant_name' => 'Variant',
                            'vc_color' => 'Color',
                            'val_model_year' => 'Model year',
                            'val_engine_no' => 'Engine no',
                            'val_chasis_no' => 'Chasis no',
                            'val_veh_no' => 'Reg no.',
                            'vbk_cust_name' => 'Customer',
                            'vbk_per_address' => 'Address 1',
                            'vbk_rd_trans_address' => 'Address 2',
                            'vbk_state' => 'State',
                            'vbk_dist' => 'District',
                            'vbk_sales_staff_name' => 'Sales officer',
                            'vbk_added_on' => 'Sale date',
                            'vbk_ttl_sale_amt' => 'Total sale amount',
                            'vbk_advance_amt' => 'Advance',
                            'vbk_discount' => 'Delivery charges',
                            'vbk_sale_type' => 'Sales type',
                            'shr_location' => 'Location',
                            'vbk_ref_no' => 'Reference no',
                            'stockID' => 'Stock id',
                            'enq_trans_mode' => 'Trans mode',
                            'tcS_Amt' => 'TCS Amount',
                            'gcCode' => 'Company Code',
                            'dc' => 'Delivery charges'
                        ); ?>
                        <?php foreach ($saleData as $key => $value) {
                            if ($key == 'gcCode') { ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $labelArray[$key]; ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select required class="select2_group form-control" name="postfields[<?php echo $key; ?>]">
                                            <?php foreach ($company as $kc => $vc) { ?>
                                                <option <?php echo ($vc['cmp_finance_year_code'] == $value) ? 'selected' : ''; ?> value="<?php echo $vc['cmp_finance_year_code']; ?>"><?php echo $vc['cmp_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $labelArray[$key]; ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input required type="text" class="form-control col-md-7 col-xs-12" name="postfields[<?php echo $key; ?>]" value="<?php echo $value; ?>" />
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    <?php } ?>

                    <input type="hidden" name="bkId" value="<?php echo $bkId; ?>" />

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>