<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>New Brand</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <?php echo form_open_multipart($controller . "/add", array('id' => "frmBrand", 'class' => "form-horizontal form-label-left frmEmployee", "onsubmit" => "document.getElementById('submit').disabled=true;")) ?>
                    <!--                    <div class="form-group">
                                                  <label class="control-label">Parent Brand</label>
                                                  <div class="controls">
                         <?php
                         //build_category_tree($this, $locations, 0);
                         ?>
                         
                                                       <select name="brd_parent" id="brd_parent" class="form-control">
                                                            <option value="0">Select Parent</option> 
                         <?php //echo $locations 
                         ?>
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
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Brand Title <span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input required="true" type="text" class="form-control col-md-7 col-xs-12" name="brd_title"
                                id="brd_title" placeholder="Brand Title" />
                        </div>
                    </div>
                    <!--                    <div class="form-group">
                                                  <label class="control-label">Brand Url</label>
                                                  <div class="controls">
                                                       <input type="text" class="form-control" name="brd_url" id="brd_url" placeholder="Brand Url"/>
                                                  </div>
                                             </div>-->
                    <!--                    <div class="form-group">
                                                  <label class="control-label">Priority</label>
                                                  <div class="controls">
                         <?php // if (!empty($orderNumber)) { 
                         ?>
                                                              <select name="brd_sort_order" id="brd_sort_order"  class="form-control">
                                                                   <option value="">Select Priority</option>
                         <?php // for ($i = 1; $i <= $orderNumber; $i++) { 
                         ?>
                                                                        <option <?php // echo ($i == $orderNumber) ? "selected='selected'" : ''; 
                                                                                ?> 
                                                                             value="<?php // echo $i; 
                                                                                     ?>"><?php // echo $i; 
                                                                                                              ?></option>
                         <?php // } 
                         ?>
                                                              </select>
                         <?php // } 
                         ?>
                                                  </div>
                                             </div>-->
                    <!--                    <div class="form-group">
                                                  <label class="control-label">Description</label>
                                                  <div class="controls" style="width: 50%;">
                                                       <textarea placeholder="Description" class="editor" name="brd_desc"></textarea>
                                                  </div>
                                             </div>-->

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Image</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="newupload">
                                <input type="hidden" id="x10" name="x1[]" />
                                <input type="hidden" id="y10" name="y1[]" />
                                <input type="hidden" id="x20" name="x2[]" />
                                <input type="hidden" id="y20" name="y2[]" />
                                <input type="hidden" id="w0" name="w[]" />
                                <input type="hidden" id="h0" name="h[]" />
                                <input type="file" class="form-control" name="brd_logo" id="image_file0"
                                    onchange="fileSelectHandler('0', '500', '268')" />
                                <img id="preview0" class="preview" />
                            </div>
                            <span class="help-inline"></span>
                        </div>
                    </div>

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