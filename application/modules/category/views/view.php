<div class="row-fluid">
     <div class="span12">
          <div class="widget green">
               <div class="widget-title">
                    <h4><i class="icon-reorder"></i> <?php echo $this->section; ?></h4>
               </div>
               <div class="widget-body">
                    <?php echo form_open_multipart("category/update", array('id' => "frmCategory", 'class' => "form-horizontal")) ?>
                    <input type="hidden" name="category[cat_id]" value="<?php echo $categories['cat_id']; ?>" />
                    <div class="control-group">
                         <label class="control-label">Parent Category</label>
                         <div class="controls">
                              <?php
                                build_category_tree($categories['cat_id'], $categories['cat_parent'], $this, $locations, 0);
                              ?>

                              <select name="category[cat_parent]" id="cat_parent" class="form-control">
                                   <option value="0">Select Parent</option> 
                                   <?php echo $locations ?>
                              </select>
                              <?php

                                function build_category_tree($catId, $selectedId, $f, &$output, $preselected, $parent = 0, $indent = "") {
                                     $parentCategories = $f->category_model->getCategoryChaild($parent, $catId);
                                     foreach ($parentCategories as $key => $value) {
                                          $selected = ($value["cat_id"] == $selectedId) ? "selected=\"selected\"" : "";
                                          $output .= "<option value=\"" . $value["cat_id"] . "\" " . $selected . ">" . $indent . $value["cat_title"] . "</option>";
                                          if ($value["cat_id"] != $parent) {
                                               build_category_tree($catId, $selectedId, $f, $output, $preselected, $value["cat_id"], $indent . "&nbsp;&nbsp;");
                                          }
                                     }
                                }
                              ?>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label"><?php echo ($categories['cat_parent'] == 0) ? 'Category Title' : 'Sub Category Title'; ?></label>
                         <div class="controls">
                              <input type="text" class="form-control" value="<?php echo $categories['category_name']; ?>" name="category[cat_title]" id="cat_title" placeholder="Category Title"/>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Priority</label>
                         <div class="controls">
                              <?php if (!empty($order)) { ?>
                                     <select name="category[cat_order]" id="exp_order" class="form-control">
                                          <option value="">Select Priority</option>
                                          <?php for ($i = 1; $i <= $order; $i++) { ?>
                                               <option <?php echo ($i == $categories['cat_order']) ? "selected='selected'" : ''; ?> 
                                                    value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                               <?php } ?>
                                     </select>
                                <?php } ?>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Description</label>
                         <div class="controls">
                              <textarea name="category[cat_desc]" class='editor'><?php echo $categories['category_desc']; ?></textarea>
                         </div>
                    </div>

                    <div class="control-group">
                         <label class="control-label">Is show on home page</label>
                         <div class="col-md-4">
                              <div class="controls">
                                   <input type="checkbox" name="category[cat_show_on_home_page]" value="1" <?php echo ($categories['cat_show_on_home_page'] == '1') ? 'checked' : ''; ?>/>
                              </div>
                         </div>
                    </div>
                    
                    <div class="control-group">
                         <label class="control-label">Is show on footer</label>
                         <div class="col-md-4">
                              <div class="controls">
                                   <input type="checkbox" name="category[cat_show_on_footer]" value="1" <?php echo ($categories['cat_show_on_footer'] == '1') ? 'checked' : ''; ?>/>
                              </div>
                         </div>
                    </div>
                    

                    <div class="form-group">
                         <label class="control-label"></label>
                         <div class="controls">
                              <div class="input-group">
                                   <?php echo img(array('src' => FILE_UPLOAD_PATH . 'category/' . $categories['cat_image'], 'height' => '80', 'width' => '100', 'id' => 'imgBrandImage')); ?>
                              </div>
                              <?php if ($categories['cat_image']) { ?>
                                     <span class="help-block">
                                          <a data-url="<?php echo site_url('category/removeImage/' . $categories['cat_id']); ?>" href="javascript:void(0);" style="width: 100px;" class="btn btn-block btn-danger btn-xs btnDeleteImage">Delete</a>
                                     </span>
                                <?php } ?>
                         </div>
                    </div>
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
                                   <input type="file" class="form-control" name="cat_image" id="image_file0" onchange="fileSelectHandler('0', '500', '268')" />
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