<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Force Action Save Expence</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right;">
                            <a href="<?php echo site_url('ihits_api/log'); ?>">List</a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php echo form_open_multipart($controller . "/saveExpense", array('id' => "frmBrand", 'class' => "form-horizontal form-label-left")) ?>
                    <?php isset($responce) ? print_r(unserialize($responce), 0) : ''; ?>
                    <div>
                        <span>Added on : <?php echo $aplg_added_on; ?></span>
                        <table>
                            <?php foreach (unserialize($aplg_res) as $key => $value) { ?>
                                <?php if ($key != 'errors') { ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>
                                        <td><?php echo $value; ?></td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>
                                        <td><?php var_dump($value); ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </table>
                    </div>
                    <?php
                    echo 'Master<br>';
                    foreach ($aplg_value['head'][0] as $key => $value) { ?>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $key; ?></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $type = 'text';
                                if ($key == 'gcCode') {
                                    $value = (int) $value;
                                    $type = "number";
                                }
                                ?>
                                <input type="<?php echo $type; ?>" class="form-control col-md-7 col-xs-12" name="head[0][<?php echo $key; ?>]" value="<?php echo $value; ?>" />
                            </div>
                        </div>
                        <?php }
                    echo '<br>Detail<br>';
                    foreach ($aplg_value['detail'] as $dKey => $dValue) {
                        foreach ($dValue as $key => $value) {
                        ?>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo $key; ?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" name="detail[<?php echo $dKey; ?>][<?php echo $key; ?>]" value="<?php echo $value; ?>" />
                                </div>
                            </div>
                    <?php }
                        echo '<br>--------------------------------------------------<br>';
                    } ?>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">aplg_enq_id</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="hidden" class="form-control col-md-7 col-xs-12" name="sales[aplg_enq_id]" value="<?php echo $aplg_enq_id; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">aplg_booking_id</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="hidden" class="form-control col-md-7 col-xs-12" name="sales[aplg_booking_id]" value="<?php echo $aplg_booking_id; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">aplg_valuation_id</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="hidden" class="form-control col-md-7 col-xs-12" name="sales[aplg_valuation_id]" value="<?php echo $aplg_valuation_id; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">aplg_refurb_id</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="hidden" class="form-control col-md-7 col-xs-12" name="sales[aplg_refurb_id]" value="<?php echo $aplg_refurb_id; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">aplg_net_total</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="hidden" class="form-control col-md-7 col-xs-12" name="sales[aplg_net_total]" value="<?php echo $aplg_net_total; ?>" />
                        </div>
                    </div>

                    <input type="hidden" name="aplg_id" value="<?php echo $aplg_id; ?>" />

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