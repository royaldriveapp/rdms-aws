<div class="row-fluid">
     <div class="span12">
          <div class="widget green">
               <div class="widget-title">
                    <h4><i class="icon-reorder"></i> <?php echo $this->section; ?></h4>
               </div>
               <div class="widget-body">
                    <?php echo form_open_multipart("brand/update", array('id' => "frmBrand", 'class' => "form-horizontal")) ?>
                    <input value="<?php echo $brand['brd_id']; ?>" type="hidden" name="brd_id" id="brd_id"/>
<!--                    <div class="control-group">
                         <label class="control-label">Category Parent</label>
                         <div class="controls">
                              <?php
                                //build_category_tree($brand['brd_id'], $brand['brd_parent'], $this, $locations, 0);
                              ?>

                              <select name="brd_parent" id="brd_parent" class="form-control">
                                   <option value="0">Select Parent</option> 
                                   <?php //echo $locations ?>
                              </select>
                              <?php

//                                function build_category_tree($catId, $selectedId, $f, &$output, $preselected, $parent = 0, $indent = "") {
//                                     $parentCategories = $f->brand_model->getBrandChaild($parent, $catId);
//                                     foreach ($parentCategories as $key => $value) {
//                                          $selected = ($value["brd_id"] == $selectedId) ? "selected=\"selected\"" : "";
//                                          $output .= "<option value=\"" . $value["brd_id"] . "\" " . $selected . ">" . $indent . $value["brd_title"] . "</option>";
//                                          if ($value["brd_id"] != $parent) {
//                                               build_category_tree($catId, $selectedId, $f, $output, $preselected, $value["brd_id"], $indent . "&nbsp;&nbsp;");
//                                          }
//                                     }
//                                }
                              ?>
                         </div>
                    </div>-->
                    <div class="control-group">
                         <label class="control-label"><?php echo ($brand['brd_parent'] == 0) ? "Brand Title" : "Sub Brand Title"; ?>     </label>
                         <div class="controls">
                              <input value="<?php echo $brand['brd_title']; ?>" type="text" class="form-control" name="brd_title" id="brd_title" placeholder="Brand Title"/>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Brand Url</label>
                         <div class="controls">
                              <input value="<?php echo $brand['brd_url']; ?>" type="text" class="form-control" name="brd_url" id="brd_url" placeholder="Brand Url"/>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Priority</label>
                         <div class="controls">
                              <?php if (!empty($maxOrder)) { ?>
                                     <select name="brd_sort_order" id="brd_sort_order" class="form-control">
                                          <option value="">Select Priority</option>
                                          <?php for ($i = 1; $i <= $maxOrder; $i++) { ?>

                                               <option <?php echo ($i == $brand['brd_sort_order']) ? "selected='selected'" : ''; ?> 
                                                    value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                               <?php } ?>
                                     </select>
                                <?php } ?>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Description</label>
                         <div class="controls" style="width: 50%;">
                              <textarea name="brd_desc" id="brd_desc" class='editor'><?php echo $brand['brd_url']; ?></textarea>
                         </div>
                    </div>

                    <!-- -->
                    <?php
                      if (isset($brand['brd_logo']) && !empty($brand['brd_logo'])) {
                           ?>
                           <div class="form-group">
                                <label class="control-label"></label>
                                <div class="controls">
                                     <div class="input-group">
                                          <?php echo img(array('src' => FILE_UPLOAD_PATH . 'brand/' . $brand['brd_logo'], 'height' => '80', 'width' => '100', 'id' => 'imgBrandImage')); ?>
                                     </div>
                                     <?php if ($brand['brd_logo']) { ?>
                                          <span class="help-block">
                                               <a data-url="<?php echo site_url('brand/removeImage/' . $brand['brd_id']); ?>" href="javascript:void(0);" style="width: 100px;" class="btn btn-block btn-danger btn-xs btnDeleteImage">Delete</a>
                                          </span>
                                     <?php } ?>
                                </div>
                           </div>
                           <?php
                      }
                    ?>
                    <div class="control-group">
                         <label class="control-label">Product Image</label>
                         <div class="controls">
                              <div id="newupload">
                                   <input type="hidden" id="x10" name="x1[]" />
                                   <input type="hidden" id="y10" name="y1[]" />
                                   <input type="hidden" id="x20" name="x2[]" />
                                   <input type="hidden" id="y20" name="y2[]" />
                                   <input type="hidden" id="w0" name="w[]" />
                                   <input type="hidden" id="h0" name="h[]" />
                                   <input type="file" class="form-control" name="brd_logo" id="image_file0" onchange="fileSelectHandler('0', '500', '268')" />
                                   <img id="preview0" class="preview"/>
                              </div>
                         </div>
                    </div>
                    <div class="form-actions">
                         <input type="submit" class="btn blue"/>
                         <button type="reset" class="btn"><i class=" icon-remove"></i> Cancel</button>
                    </div>
                    <?php echo form_close() ?>
               </div>
          </div>
     </div>
</div>