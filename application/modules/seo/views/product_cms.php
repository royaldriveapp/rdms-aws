<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Product title list</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?php
                         echo form_open_multipart('', array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left"));
                         ?>
                    <input value="<?php echo $product['prd_id']; ?>" type="hidden" name="prd_id" id="seop_id" />
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product page title</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea required class="form-control col-md-7 col-xs-12" name="prd_page_title"
                                id="prd_page_title"
                                placeholder="Product page title"><?php echo $product['prd_page_title']; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product meta tag</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea required class="form-control col-md-7 col-xs-12" name="prd_meta_desc"
                                id="prd_meta_desc"
                                placeholder="Product meta tag"><?php echo $product['prd_meta_desc']; ?></textarea>
                        </div>
                    </div>
                    <?php
                         if (!empty($product['images'])) {
                              foreach ($product['images'] as $key => $value) {
                                   ?>
                    <div class="col-md-55">
                        <div class="thumbnail">
                            <div class="image view view-first">
                                <?php
                                                  echo img(array('style' => 'width: 100%; display: block;',
                                                      'src' => PRODUCT_BASE_URL . $value['pdi_image']));
                                                  ?>
                            </div>
                            <div class="caption">
                                <p><input type="text" class="form-control col-md-7 col-xs-12"
                                        name="pdi_image_alt[<?php echo $value['pdi_id']; ?>]" id="pdi_image_alt"
                                        value="<?php echo $value['pdi_image_alt']; ?>" placeholder="Image alt" />
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                              }
                         }
                         ?>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>