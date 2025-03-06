
<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Edit banner</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart("manage_banner/update", array('id' => "frmBanner", 'class' => "form-horizontal"))?>
                         <input type="hidden" name="bnr_id" value="<?php echo $banner['bnr_id']?>" />
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php if (!empty($order)) {?>
                                          <select name="banner[bnr_order]" id="bnr_order" class="form-control">
                                               <option value="">Select Priority</option>
                                               <?php for ($i = 1; $i <= $order; $i++) {?>
                                                    <option <?php echo ($i == $banner['bnr_order']) ? "selected='selected'" : '';?> 
                                                         value="<?php echo $i;?>"><?php echo $i;?></option>
                                                    <?php }?>
                                          </select>
                                     <?php }?>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="form-control cmbAddCategory" name="banner[bnr_category]">
                                        <option <?php echo ($banner['bnr_category'] == 1) ? "selected='selected'" : '';?> value="1">Website</option>
                                        <option <?php echo ($banner['bnr_category'] == 2) ? "selected='selected'" : '';?> value="2">App</option>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Url</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $banner['bnr_url']; ?>" type="text" class="form-control" name="banner[bnr_url]"/>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Banner</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <div class="input-group">
                                        <?php echo img(array('src' => FILE_UPLOAD_PATH . 'banner/' . $banner['bnr_image'], 'height' => '80', 'width' => '100', 'id' => 'imgBrandImage'));?>
                                   </div>
                                   <?php if ($banner['bnr_image']) {?>
                                          <span class="help-block">
                                               <a data-url="<?php echo site_url('manage_banner/removeImage/' . $banner['bnr_id'] . '/' . $banner['bnr_image']);?>" href="javascript:void(0);" style="width: 100px;" class="btn btn-block btn-danger btn-xs btnDeleteImage">Delete</a>
                                          </span>
                                     <?php }?>
                              </div>
                         </div>
                         <br />
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">New Banner</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <div id="newupload">
                                        <input type="hidden" id="x10" name="x1[]" />
                                        <input type="hidden" id="y10" name="y1[]" />
                                        <input type="hidden" id="x20" name="x2[]" />
                                        <input type="hidden" id="y20" name="y2[]" />
                                        <input type="hidden" id="w0" name="w[]" />
                                        <input type="hidden" id="h0" name="h[]" />
                                        <input type="file" class="form-control" name="banner" id="image_file0" 
                                               onchange="fileSelectHandler('0', 1920, 1080)" />
                                        <img id="preview0" class="preview"/>
                                   </div>
                                   <span class="help-inline">Upload approximate this dimension 1600px × 930px</span>
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
