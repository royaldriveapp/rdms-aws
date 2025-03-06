<div class="row-fluid">
     <div class="span12">
          <div class="widget green">
               <div class="widget-title">
                    <h4><i class="icon-reorder"></i> <?php echo $this->section; ?></h4>
               </div>
               <div class="widget-body">
                    <?php echo form_open_multipart("category/insert", array('id' => "frmCategory", 'class' => "form-horizontal")) ?>
                    <div class="control-group">
                         <label class="control-label">Parent Category</label>
                         <div class="controls">
                              <?php
                                build_category_tree($this, $locations, 0);
                              ?>

                              <select name="category[cat_parent]" id="cat_parent" class="form-control">
                                   <option value="0">Select Parent</option> 
                                   <?php echo $locations ?>
                              </select>
                              <?php

                                function build_category_tree($f, &$output, $preselected, $parent = 0, $indent = "") {
                                     $ser_parent = '';
                                     $parentCategories = $f->category_model->getCategoryChaild($parent);
                                     foreach ($parentCategories as $key => $value) {
                                          $selected = ($value["cat_id"] == $ser_parent) ? "selected=\"selected\"" : "";
                                          $output .= "<option value=\"" . $value["cat_id"] . "\" " . $selected . ">" . $indent . $value["cat_title"] . "</option>";
                                          if ($value["cat_id"] != $parent) {
                                               build_category_tree($f, $output, $preselected, $value["cat_id"], $indent . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
                                          }
                                     }
                                }
                              ?>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Category Title</label>
                         <div class="controls">
                              <input type="text" class="form-control" name="category[cat_title]" id="cat_title" placeholder="Category Title"/>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Priority</label>
                         <div class="controls">
                              <?php if (!empty($order)) { ?>
                                     <select name="category[cat_order]" id="cat_order" class="form-control">
                                          <option value="">Select Priority</option>
                                          <?php for ($i = 1; $i <= $order; $i++) { ?>
                                               <option <?php echo ($i == $order) ? "selected='selected'" : ''; ?> 
                                                    value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                               <?php } ?>
                                     </select>
                                <?php } ?>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Description</label>
                         <div class="controls">
                              <textarea name="category[cat_desc]" class='editor'></textarea>
                         </div>
                    </div>

                    <div class="control-group">
                         <label class="control-label">Is show on home page</label>
                         <div class="col-md-4">
                              <div class="controls">
                                   <input type="checkbox" name="category[cat_show_on_home_page]" value="1"/>
                              </div>
                         </div>
                    </div>
                    
                    <div class="control-group">
                         <label class="control-label">Is show on footer</label>
                         <div class="col-md-4">
                              <div class="controls">
                                   <input type="checkbox" name="category[cat_show_on_footer]" value="1"/>
                              </div>
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