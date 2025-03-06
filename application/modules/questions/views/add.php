<div class="right_col" role="main">
     <div class="">
          <div class="page-title">
               <div class="title_left">
                    <h3>Questions Details</h3>
               </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                         <div class="x_content">
                              <!-- Smart Wizard -->
                              <div class="form-horizontal form-label-left">
                                   <?php echo form_open_multipart($controller . "/add", array('id' => "frmCategory", 'class' => "form-horizontal"))?>
                                   <!--                                   <div class="form-group">
                                                                           <label class="control-label col-md-3 col-sm-3 col-xs-12">Parent Question</label>
                                                                           <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php
                                     //build_category_tree($this, $locations, 0);
                                   ?>
                                   
                                                                                <select name="category[cat_parent]" id="cat_parent" class="form-control">
                                                                                     <option value="0">Select Parent</option> 
                                   <?php //echo $locations?>
                                                                                </select>
                                   <?php
//                                               function build_category_tree($f, &$output, $preselected, $parent = 0, $indent = "") {
//                                                    $ser_parent = '';
//                                                    $parentCategories = $f->questions->getCategoryChaild($parent);
//                                                    foreach ($parentCategories as $key => $value) {
//                                                         $selected = ($value["qus_id"] == $ser_parent) ? "selected=\"selected\"" : "";
//                                                         $output .= "<option value=\"" . $value["qus_id"] . "\" " . $selected . ">" . $indent . $value["qus_question"] . "</option>";
//                                                         if ($value["qus_id"] != $parent) {
//                                                              build_category_tree($f, $output, $preselected, $value["qus_id"], $indent . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
//                                                         }
//                                                    }
//                                               }
                                   ?>
                                                                           </div>
                                                                      </div>-->

                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Type <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <select name="qus_type" id="cat_order" class="form-control" required>
                                                  <option value="">Select Type</option>
                                                  <?php
                                                    $type = unserialize(ENQ_QUESTION_TYPES);
                                                    foreach ($type as $key => $value) {
                                                         ?>
                                                         <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                    <?php }?>
                                             </select>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Question <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <textarea name="qus_question" class="editor ml"></textarea>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?php if (!empty($order)) {?>
                                                    <select name="qus_order" id="cat_order" class="form-control">
                                                         <option value="">Select Priority</option>
                                                         <?php for ($i = 1; $i <= $order; $i++) {?>
                                                              <option <?php echo ($i == $order) ? "selected='selected'" : '';?> 
                                                                   value="<?php echo $i;?>"><?php echo $i;?></option>
                                                              <?php }?>
                                                    </select>
                                               <?php }?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <textarea name="qus_desc" class='editor ml'></textarea>
                                        </div>
                                   </div>

                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is yes/no question</label>
                                        <div class="col-md-4">
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="checkbox" name="qus_is_togler" value="1"/>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is mandatory</label>
                                        <div class="col-md-4">
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="checkbox" name="qus_is_mandatory" value="1"/>
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
     </div>
</div>