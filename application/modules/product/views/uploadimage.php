<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Edit Vehicle</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart("product/updateImage", array('id' => "frmProduct", 'class' => "form-horizontal form-label-left")) ?>
                         <input type="hidden" name="prd_id" value="<?php echo $productsDetails['product_details']['prd_id']; ?>" />
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Product number</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php
                                   echo !empty($productsDetails['product_details']['prd_number']) ?
                                        $productsDetails['product_details']['prd_number'] : gen_random();
                                   ?>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle Reg No</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php
                                   echo $productsDetails['product_details']['prd_regno_prt_1'] . '-' . $productsDetails['product_details']['prd_regno_prt_2'] . '-' .
                                        $productsDetails['product_details']['prd_regno_prt_3'] . '-' . $productsDetails['product_details']['prd_regno_prt_4'];
                                   ?>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Walkaround</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $productsDetails['product_details']['prd_video']; ?>" type="text" class="form-control col-md-7 col-xs-12" name="prd_video" id="prd_video" />
                              </div>
                         </div>

                         <div class="form-group">
                              <?php if ($productsDetails['product_images']) { ?>
                                   <label class="control-label col-md-3 col-sm-3 col-xs-3">Vehicle images</label>
                                   <?php foreach ($productsDetails['product_images'] as $key => $value) {
                                   ?>
                                        <div class="col-md-2 col-sm-2 col-xs-2" style="float: left;">
                                             <div class="input-group">
                                                  <?php echo img(array('src' => PRODUCT_BASE_URL . $value['pdi_image'], 'height' => '80', 'width' => '100', 'id' => 'imgBrandImage'));
                                                  ?>

                                             </div>
                                             <?php if ($value['pdi_image']) { ?>
                                                  <span class="help-block">
                                                       <a data-url="<?php echo site_url('product/removeImage/' . $value['pdi_id']); ?>" href="javascript:void(0);" style="width: 100px;" class="btn btn-block btn-danger btn-xs btnDeleteImage">Delete</a>
                                                  </span>
                                                  <div>
                                                       <input <?php echo ($value['pdi_is_default'] == 1) ? "checked" : ''; ?> data-url="<?php echo site_url('product/setDefaultImage/' . $value['pdi_id'] . '/' . $productsDetails['product_details']['prd_id']); ?>" class="radSetDefaultUpdate" type="radio" name="setdefault" />&nbsp;Set default
                                                  </div>
                                             <?php } ?>
                                        </div>
                              <?php
                                   }
                              }
                              ?>
                         </div>

                         <div class="form-group">
                              <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12">Product Images</label>
                              <div class="col-md-5 col-sm-3 col-xs-12">
                                   <div id="newupload">
                                        <input type="hidden" id="x10" name="x1[]" />
                                        <input type="hidden" id="y10" name="y1[]" />
                                        <input type="hidden" id="x20" name="x2[]" />
                                        <input type="hidden" id="y20" name="y2[]" />
                                        <input type="hidden" id="w0" name="w[]" />
                                        <input type="hidden" id="h0" name="h[]" />
                                        <input type="file" class="form-control col-md-7 col-xs-12" style="display: table;margin-bottom: 10px;" name="prd_image[]" id="image_file0" onchange="fileSelectHandler('0', '760', '476', true)" />
                                        <img id="preview0" class="preview" />
                                        <span class="help-inline">Choose 760(W) X 476(H)</span>
                                   </div>
                              </div>

                              <span style="float: right;cursor: pointer;position: fixed;top: 276px;right: 12%;" class="btn btn-success glyphicon glyphicon-plus btnMoreProductImages"></span>
                         </div>
                         <div id="divMoreProductImages"></div>

                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success">Submit</button>
                                   <button class="btn btn-primary" type="reset">Reset</button>
                              </div>
                         </div>
                         <?php echo form_close() ?>
                    </div>
               </div>
          </div>
     </div>
</div>