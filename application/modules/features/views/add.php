<div class="row-fluid">
     <div class="span12">
          <div class="widget green">
               <div class="widget-title">
                    <h4><i class="icon-reorder"></i> <?php echo $this->section; ?></h4>
               </div>
               <div class="widget-body">
                    <?php echo form_open_multipart("brand/insert", array('id' => "frmBrand", 'class' => "form-horizontal")) ?>
<!--                    <div class="control-group">
                         <label class="control-label">Parent Brand</label>
                         <div class="controls">
                              <?php
                                //build_category_tree($this, $locations, 0);
                              ?>

                              <select name="brd_parent" id="brd_parent" class="form-control">
                                   <option value="0">Select Parent</option> 
                                   <?php //echo $locations ?>
                              </select>
                              <?php

//                                function build_category_tree($f, &$output, $preselected, $parent = 0, $indent = "") {
//                                     $ser_parent = '';
//                                     $parentCategories = $f->brand_model->getBrandChaild($parent);
//                                     foreach ($parentCategories as $key => $value) {
//                                          $selected = ($value["brd_id"] == $ser_parent) ? "selected=\"selected\"" : "";
//                                          $output .= "<option value=\"" . $value["brd_id"] . "\" " . $selected . ">" . $indent . $value["brd_title"] . "</option>";
//                                          if ($value["brd_id"] != $parent) {
//                                               build_category_tree($f, $output, $preselected, $value["brd_id"], $indent . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
//                                          }
//                                     }
//                                }
                              ?>
                         </div>
                    </div>-->
                    <div class="control-group">
                         <label class="control-label">Brand Title</label>
                         <div class="controls">
                              <input type="text" class="form-control" name="brd_title" id="brd_title" placeholder="Brand Title"/>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Brand Url</label>
                         <div class="controls">
                              <input type="text" class="form-control" name="brd_url" id="brd_url" placeholder="Brand Url"/>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Priority</label>
                         <div class="controls">
                              <?php if (!empty($orderNumber)) { ?>
                                     <select name="brd_sort_order" id="brd_sort_order"  class="form-control">
                                          <option value="">Select Priority</option>
                                          <?php for ($i = 1; $i <= $orderNumber; $i++) { ?>
                                               <option <?php echo ($i == $orderNumber) ? "selected='selected'" : ''; ?> 
                                                    value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                               <?php } ?>
                                     </select>
                                <?php } ?>
                         </div>
                    </div>
                    <div class="control-group">
                         <label class="control-label">Description</label>
                         <div class="controls" style="width: 50%;">
                              <textarea placeholder="Description" class="editor" name="brd_desc"></textarea>
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
                                   <input type="file" class="form-control" name="brd_logo" id="image_file0" onchange="fileSelectHandler('0', '500', '268')" />
                                   <img id="preview0" class="preview"/>
                              </div>
                              <span class="help-inline"></span>
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