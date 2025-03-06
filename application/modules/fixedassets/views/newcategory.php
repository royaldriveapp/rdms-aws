<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New Assets Category</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart("fixedassets/insert", array('id' => "frmCategory", 'class' => "form-horizontal form-label-left")) ?>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Parent Category</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php build_category_tree($this, $locations, 0); ?>

                                   <select name="category[fac_parent]" id="cat_parent" class="form-control col-md-7 col-xs-12">
                                        <option value="0">Select Parent</option> 
                                        <?php echo $locations ?>
                                   </select>

                                   <?php function build_category_tree($f, &$output, $preselected, $parent = 0, $indent = "") {
                                        $ser_parent = '';
                                        $parentCategories = $f->fixedassets->getCategoryChaild($parent);
                                        foreach ($parentCategories as $key => $value) {
                                             $selected = ($value["fac_id"] == $ser_parent) ? "selected=\"selected\"" : "";
                                             $output .= "<option value=\"" . $value["fac_id"] . "\" " . $selected . ">" . $indent . $value["fac_title"] . "</option>";
                                             if ($value["fac_id"] != $parent) {
                                                  build_category_tree($f, $output, $preselected, $value["fac_id"], $indent . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
                                             }
                                        }
                                   }
                                   ?>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Title</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" class="form-control col-md-7 col-xs-12" name="category[fac_title]" id="cat_title" placeholder="Category Title"/>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <textarea name="category[fac_desc]" class='editor'></textarea>
                              </div>
                         </div>

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