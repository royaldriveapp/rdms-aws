<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Source Master</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <?php echo form_open_multipart($controller . "/update_source_master", array('id' => "frmBrand", 'class' => "form-horizontal form-label-left frmEmployee"))?>
                    <div class="form-group">
                    <input type="hidden"  name="id"  value="<?php echo $data['cmd_mod_id']?>">       <!-- Master id to update  -->  
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <!-- Use $data['cmd_title'] to pre-fill the value -->
                            <input required="true" type="text" class="form-control col-md-7 col-xs-12" 
                                name="cmd_title" id="name" placeholder="Name" value="<?php echo isset($data['cmd_title']) ? $data['cmd_title'] : ''; ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Funnel</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="cmd_funnel" id="cmd_funnel" class="form-control col-md-7 col-xs-12">
                                <option value="">Select Funnel</option>
                                <?php
                                    if (!empty($funnelMasters)) {
                                        foreach ($funnelMasters as $key => $value) {
                                            // Use $data['cmd_funnel'] to pre-select the option
                                            $selected = ($value['sfnl_id'] == $data['cmd_funnel']) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $value['sfnl_id'];?>" <?php echo $selected; ?>><?php echo $value['sfnl_funnel'];?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Active <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <!-- Use $data['cmd_status'] to determine if the checkbox should be checked -->
                            <input <?php echo $data['cmd_status'] == 1 ? 'checked' : ''; ?> type="checkbox" value="1" name="cmd_status" class="" id="active">
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
