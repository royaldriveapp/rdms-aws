<div class="right_col" role="main"> 
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Products</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart("", array('id' => "frmCar", 'name' => "frmCar", 'class' => "form-horizontal form-label-left")) ?>
                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Division <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control cmbBindShowroomByDivision" name="product[fap_division]" id="vreg_division"
                                           data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom" 
                                           data-dflt-select="Select Showroom">
                                        <option value="">Select division</option>
                                        <?php
                                        foreach ($division as $key => $value) {
                                             ?>
                                             <option value="<?php echo $value['div_id']; ?>"><?php echo $value['div_name']; ?></option>
                                             <?php
                                        }
                                        ?>
                                   </select>
                              </div>
                         </div>

                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Showroom <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select required class="select2_group form-control cmbShowroom shorm_stf" name="product[fap_showroom]" id="vreg_showroom">
                                        <option value="">Select showroom</option>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Category</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <?php build_category_tree($this, $locations, 0); ?>

                                   <select name="product[prd_cat_id]" id="supplierID" class="form-control col-md-7 col-xs-12"
                                           data-url="<?php echo site_url('fixedassets/getpurchasefields'); ?>">
                                        <option value="0">Select Category</option> 
                                        <?php echo $locations ?>
                                   </select>

                                   <?php

                                   function build_category_tree($f, &$output, $preselected, $parent = 0, $indent = "") {
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
                         <div class="table-responsive">
                              <table id="datatable-responsive" class="tblSales table table-striped table-bordered dt-responsive nowrap no-footer" cellspacing="0" width="100%"></table>
                         </div>
                    </div>
                    <div class="row">
                         <div class="clearfix"></div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                         <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <button type="submit" class="btn btn-success" name="submit" value="submit">Submit</button>
                              <!-- <button class="btn btn-primary" type="submit" name="submit" value="print">Submit and Print</button>-->
                         </div>
                    </div>
                    <?php echo form_close() ?>
               </div>
          </div>
     </div>
</div>