<div class="row-fluid">
     <div class="span12">
          <div class="widget green">
               <div class="widget-title">
                    <h4><i class="icon-reorder"></i> <?php echo $this->section; ?></h4>
               </div>
               <div class="widget-body">
                    <?php echo form_open_multipart("product/doImport", array('id' => "frmProductImport", 'class' => "form-horizontal")) ?>
                    
                    <div class="control-group">
                         <label class="control-label">Number of products</label>
                         <div class="controls">
                              <input type="text" class="form-control" name="product_count" id="product_count"/>
                                   <span class="help-block">Please enter number of product to import</span>
                         </div>
                    </div>
                    
                    <div class="control-group">
                         <label class="control-label">Filter Type</label>
                         <div class="controls">
                              <?php
                                $options = get_options($category);
                                echo '<select name="prd_category" id="prd_category"  class="form-control">';
                                echo '<option value="">Select Filter Type</option>';
                                foreach ($options as $key => $val) {
                                     echo "<option value='" . substr($key, 1) . "'>" . $val . "</option>";
                                }
                                echo "</select>";
                              ?>
                         </div>
                    </div>
                    
                    <div class="control-group">
                         <label class="control-label">Product Excel File</label>
                         <div class="controls">
                              <input required type="file" class="form-control" name="product_file" id="product_file"/>
                              <span class="help-block">Please select .xls or .xlsx only</span>
                         </div>
                    </div>
                    
                    <div class="control-group">
                         <label class="control-label">Images Zipped File</label>
                         <div class="controls">
                              <input  type="file" name="image_zip" class="form-control" id="image_zip"/>
                              <span class="help-block">Please select .zip file only</span>
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