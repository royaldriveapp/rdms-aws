<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Edit Funnel Master</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <?php echo form_open_multipart($controller . "/update_funnel_master", array('id' => "frmBrand", 'class' => "form-horizontal form-label-left frmEmployee"))?>
                   <input type="hidden" name="id" value="<?php echo $data['sfnl_id']; ?>">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input required="true" type="text" class="form-control col-md-7 col-xs-12" 
                                   name="sfnl_funnel" id="name" placeholder="Name" value="<?php echo isset($data['sfnl_funnel']) ? $data['sfnl_funnel'] : ''; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Active <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input <?php echo isset($data['sfnl_status']) && $data['sfnl_status'] == 1 ? 'checked' : ''; ?> type="checkbox" name="sfnl_status" class="" id="active">
                        </div>
                    </div>



                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                        </div>
                    </div>

                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </div>
</div>
