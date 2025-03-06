<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Update Accessories</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart("accessories/update", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left"))?>
                         <input value="<?php echo $accessories['acc_id'];?>" type="hidden" name="acc_id" id="acc_id"/>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $accessories['acc_title'];?>" type="text" class="form-control col-md-7 col-xs-12" name="acc_title" id="acc_title" placeholder="Title"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $accessories['acc_price'];?>" type="text" class="form-control col-md-7 col-xs-12" name="acc_price" id="acc_price" placeholder="Price"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php if (!empty($maxOrder)) {?>
                                          <select name="acc_sort_order" id="brd_sort_order" class="form-control col-md-7 col-xs-12">
                                               <option value="">Select Priority</option>
                                               <?php for ($i = 1; $i <= $maxOrder; $i++) {?>

                                                    <option <?php echo ($i == $accessories['acc_sort_order']) ? "selected='selected'" : '';?> 
                                                         value="<?php echo $i;?>"><?php echo $i;?></option>
                                                    <?php }?>
                                          </select>
                                     <?php }?>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                              <div class="col-md-6 col-sm-6 col-xs-12" style="width: 50%;">
                                   <textarea name="acc_desc" id="acc_desc" class='editor'><?php echo $accessories['acc_desc'];?></textarea>
                              </div>
                         </div>

                         <!-- -->
                         <?php
                           if (isset($accessories['acc_logo']) && !empty($accessories['acc_logo'])) {
                                ?>
                                <div class="form-group">
                                     <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                          <div class="input-group">
                                               <?php echo img(array('src' => FILE_UPLOAD_PATH . 'accessories/' . $accessories['acc_logo'], 'height' => '80', 'width' => '100', 'id' => 'imgBrandImage'));?>
                                          </div>
                                          <?php if ($accessories['acc_logo']) {?>
                                               <span class="help-block">
                                                    <a data-url="<?php echo site_url('accessories/removeImage/' . $accessories['acc_id']);?>" href="javascript:void(0);" style="width: 100px;" class="btn btn-block btn-danger btn-xs btnDeleteImage">Delete</a>
                                               </span>
                                          <?php }?>
                                     </div>
                                </div>
                                <?php
                           }
                         ?>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Image</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <div id="newupload">
                                        <input type="hidden" id="x10" name="x1[]" />
                                        <input type="hidden" id="y10" name="y1[]" />
                                        <input type="hidden" id="x20" name="x2[]" />
                                        <input type="hidden" id="y20" name="y2[]" />
                                        <input type="hidden" id="w0" name="w[]" />
                                        <input type="hidden" id="h0" name="h[]" />
                                        <input type="file" class="form-control col-md-7 col-xs-12" name="brd_logo" id="image_file0" onchange="fileSelectHandler('0', '500', '268')" />
                                        <img id="preview0" class="preview"/>
                                   </div>
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