<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>New Model</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <?php echo form_open_multipart("model/add", array('id' => "frmCar", 'class' => "form-horizontal form-label-left", "onsubmit" => "document.getElementById('submit').disabled=true;")) ?>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Brand</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php if (!empty($brand)) { ?>
                            <select name="mod_brand" id="rcn_brand" class="form-control col-md-7 col-xs-12"
                                required="required">
                                <option value="">Select brand</option>
                                <?php foreach ($brand as $key => $value) { ?>
                                <option value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title'] ?>
                                </option>
                                <?php } ?>
                            </select>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Model</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control col-md-7 col-xs-12" name="mod_title" id="mod_title"
                                placeholder="Model" required="required" />
                        </div>
                    </div>

                    <!--                    <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                                                  <div class="col-md-6 col-sm-6 col-xs-12" style="width: 50%;">
                                                       <textarea placeholder="Description" class="editor" name="rcn_desc"></textarea>
                                                  </div>
                                             </div>-->

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" id="submit">Submit</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>