<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Force Action</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <?php if (!empty($responce)) {
                        echo $responce;
                    } ?>
                    <?php echo form_open_multipart($controller . "/forceSource", array('id' => "frmBrand", 'class' => "form-horizontal form-label-left")) ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Enq id <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input required="true" type="text" class="form-control col-md-7 col-xs-12" name="pr_enq_id" id="pr_enq_id" placeholder="pr_enq_id" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">pr_id/aplg_booking_id <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input required="true" type="text" class="form-control col-md-7 col-xs-12" name="pr_id" id="pr_id" placeholder="pr_id" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">pr_val_id <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input required="true" type="text" class="form-control col-md-7 col-xs-12" name="pr_val_id" id="pr_val_id" placeholder="pr_val_id" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">val_sales_officer_name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input required="true" type="text" class="form-control col-md-7 col-xs-12" name="val_sales_officer_name" id="val_sales_officer_name" placeholder="val_sales_officer_name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea required="true" class="form-control col-md-7 col-xs-12" placeholder="Serialize" name="ser_data"></textarea>
                        </div>
                    </div>

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