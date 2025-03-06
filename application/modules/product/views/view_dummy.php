<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Edit Vehicle</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart("product/update", array('id' => "frmProduct", 'class' => "form-horizontal form-label-left")) ?>
                         <input type="hidden" name="prd_id" value="<?php echo $productsDetails['product_details']['prd_id']; ?>" />
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Product number</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input readonly type="text" class="form-control" name="product[prd_number]" id="prd_number" value="<?php
                                                                                                                                       echo !empty($productsDetails['product_details']['prd_number']) ?
                                                                                                                                            $productsDetails['product_details']['prd_number'] : gen_random();
                                                                                                                                       ?>" />
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle Reg No</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" class="form-control col-md-7 col-xs-12" name="product[prd_regno_prt_1]" value="<?php
                                                                                                                                       echo isset($prdValuationDtl['val_prt_1']) ? $prdValuationDtl['val_prt_1'] :
                                                                                                                                            $productsDetails['product_details']['prd_regno_prt_1'];
                                                                                                                                       ?>" maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="KL" />

                                   <input type="text" class="numOnly form-control col-md-7 col-xs-12" name="product[prd_regno_prt_2]" value="<?php
                                                                                                                                                 echo isset($prdValuationDtl['val_prt_2']) ? $prdValuationDtl['val_prt_2'] :
                                                                                                                                                      $productsDetails['product_details']['prd_regno_prt_2'];
                                                                                                                                                 ?>" maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="00" />

                                   <input type="text" class="form-control col-md-7 col-xs-12" name="product[prd_regno_prt_3]" value="<?php
                                                                                                                                       echo isset($prdValuationDtl['val_prt_3']) ? $prdValuationDtl['val_prt_3'] :
                                                                                                                                            $productsDetails['product_details']['prd_regno_prt_3'];
                                                                                                                                       ?>" maxlength="3" style="text-transform: uppercase;width: 49px;" placeholder="AA" />

                                   <input type="text" class="numOnly form-control col-md-7 col-xs-12" name="product[prd_regno_prt_4]" value="<?php
                                                                                                                                                 echo isset($prdValuationDtl['val_prt_4']) ? $prdValuationDtl['val_prt_4'] :
                                                                                                                                                      $productsDetails['product_details']['prd_regno_prt_4'];
                                                                                                                                                 ?>" maxlength="4" style="text-transform: uppercase;width: 80px;" required placeholder="0000" />
                              </div>
                         </div>
                         <?php if ((isset($location)) && !empty($location)) { ?>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select required name="product[prd_location]" class="select2_group form-control" placeholder="Color">
                                             <option value="0">Select location</option>
                                             <?php foreach ($location as $key => $value) { ?>
                                                  <option <?php echo ($value['shr_id'] == $this->shrm) ? "selected='selected'" : ''; ?> value="<?php echo $value['shr_id']; ?>"><?php echo $value['shr_location']; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                         <?php } ?>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Smart?</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="1" type="checkbox" name="product[prd_rd_mini]" id="prd_rd_mini" />
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Brand</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select name="product[prd_brand]" id="prd_brand" class="form-control col-md-7 col-xs-12 bindToDropdown" data-dflt-select="Select Model" data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbModel">
                                        <option value="">Select Brand</option>
                                        <?php
                                        $prdValuationDtl['val_brand'] = isset($prdValuationDtl['val_brand']) ? $prdValuationDtl['val_brand'] : 0;
                                        if (!empty($brands)) {
                                             foreach ($brands as $key => $value) {
                                        ?>
                                                  <option <?php echo ($selectBrand == $value['brd_id']) ? "selected='selected'" : ''; ?> value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?></option>
                                        <?php
                                             }
                                        }
                                        ?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Model</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select required="" data-url="<?php echo site_url('enquiry/bindVarient'); ?>" data-bind="cmbVariant" data-dflt-select="Select Variant" class="cmbModel select2_group form-control bindToDropdown" name="product[prd_model]" id="val_brand">
                                        <option>Select Model</option>
                                        <?php $prdValuationDtl['val_model'] = isset($prdValuationDtl['val_model']) ? $prdValuationDtl['val_model'] : 0;
                                        if (!empty($model)) {
                                             foreach ($model as $key => $value) {
                                        ?>
                                                  <option <?php echo ($selectModel == $value['mod_id']) ? "selected='selected'" : ''; ?> value="<?php echo $value['mod_id']; ?>"><?php echo $value['mod_title']; ?></option>
                                        <?php
                                             }
                                        }
                                        ?>
                                   </select>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Variant</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select required="" class="select2_group form-control cmbVariant" name="product[prd_variant]" id="val_brand">
                                        <option>Select Variant</option>
                                        <?php
                                        $prdValuationDtl['val_variant'] = isset($prdValuationDtl['val_variant']) ? $prdValuationDtl['val_variant'] : 0;
                                        if (!empty($variant)) {
                                             foreach ($variant as $key => $value) {
                                        ?>
                                                  <option <?php echo ($selectVarint == $value['var_id']) ? "selected='selected'" : ''; ?> value="<?php echo $value['var_id']; ?>"><?php echo $value['var_variant_name']; ?></option>
                                        <?php
                                             }
                                        }
                                        ?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Loan available</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="1" type="checkbox" name="product[prd_loan_avail]" class="" id="prd_loan_avail" <?php echo ($productsDetails['product_details']['prd_loan_avail']) ? "checked='true'" : ''; ?> />
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                              <div class="col-md-6 col-sm-6 col-xs-12" style="width: 50%;">
                                   <textarea placeholder="Design feature" class="editor1 form-control col-md-7 col-xs-12" name="product[prd_desc]"><?php echo strip_tags($productsDetails['product_details']['prd_desc']); ?></textarea>
                              </div>
                         </div>
                         <?php if ($this->shrm == 1 || $this->uid == 100) { ?>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Safety feature</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12" style="width: 50%;">
                                        <textarea placeholder="Safety feature" class="form-control col-md-7 col-xs-12 editor1" name="product[prd_safety_feture]"><?php echo strip_tags($productsDetails['product_details']['prd_safety_feture']); ?></textarea>
                                   </div>
                              </div>

                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Comfort & Convenience feature</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12" style="width: 50%;">
                                        <textarea placeholder="Comfort & Convenience feature" class="form-control col-md-7 col-xs-12 editor1" name="product[prd_cmfort_cnvnent_feture]"><?php echo strip_tags($productsDetails['product_details']['prd_cmfort_cnvnent_feture']); ?></textarea>
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Warranty upto</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="<?php echo $productsDetails['product_details']['prd_warranty_upto']; ?>" type="text" name="product[prd_warranty_upto]" class="form-control" id="prd_warranty_upto" placeholder="Warranty upto" />
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Insurance type</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="col-md-2 col-xs-5 select2_group form-control" name="product[prd_insurance_type]" id="prd_insurance_type">
                                             <option value="0">Select Insurance Type</option>
                                             <?php foreach (unserialize(INSURANCE_TYPES) as $key => $value) { ?>
                                                  <option <?php echo ($productsDetails['product_details']['prd_insurance_type'] == $key) ? 'selected="selected"' : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Transmission</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select required class="select2_group form-control" name="product[prd_transmission]" id="prd_transmission">
                                             <option value="">Select Transmission</option>
                                             <?php foreach (unserialize(TRANSMISSIONS) as $key => $value) { ?>
                                                  <option <?php echo ($productsDetails['product_details']['prd_transmission'] == $key) ? 'selected="selected"' : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                             <?php } ?>
                                        </select>
                                   </div>
                              </div>

                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">ARAI Tested Mileage</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="<?php echo $productsDetails['product_details']['prd_arai_mileage']; ?>" type="text" name="product[prd_arai_mileage]" class="numOnly form-control" id="prd_arai_mileage" placeholder="ARAI Mileage" />
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Accessories Fitted</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="<?php echo $productsDetails['product_details']['prd_acc_ftd']; ?>" type="text" name="product[prd_acc_ftd]" class="form-control" id="prd_acc_ftd" placeholder="Accessories Fitted" />
                                   </div>
                              </div>

                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Current on road price</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="<?php echo $productsDetails['product_details']['prd_or_road_price']; ?>" type="text" name="product[prd_or_road_price]" class="numOnly form-control" id="prd_or_road_price" placeholder="Current on road price" />
                                   </div>
                              </div>
                         <?php } ?>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Year</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <!--<input value="<?php echo $productsDetails['product_details']['prd_year']; ?>" type="text" name="product[prd_year]" class="form-control" id="prd_year" placeholder="Year"/>-->
                                   <select name="product[prd_year]" class="select2_group form-control" placeholder="Year of registered">
                                        <option value="0">Select year</option>
                                        <?php
                                        $prdValuationDtl['val_minif_year'] = isset($prdValuationDtl['val_minif_year']) ? $prdValuationDtl['val_minif_year'] : 0;
                                        for ($i = date('Y') - 30; $i <= date('Y'); $i++) { ?>
                                             <option <?php echo ($selectYear == $i) ? "selected='true'" : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Color</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <!--<input value="<?php echo $productsDetails['product_details']['prd_color']; ?>" type="text" name="product[prd_color]" class="form-control" id="prd_color" placeholder="Color"/>-->
                                   <select name="product[prd_color]" class="select2 select2_group form-control" placeholder="Color">
                                        <option value="none">Select color</option>
                                        <?php foreach ($color as $key => $value) { ?>
                                             <option <?php echo ($value['vc_id'] == $productsDetails['product_details']['prd_color_id']) ? "selected='selected'" : ''; ?> value="<?php echo $value['vc_id']; ?>"><?php echo $value['vc_color']; ?></option>
                                        <?php } ?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Wrapp color</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" value="<?php echo $productsDetails['product_details']['prd_wrapp_color']; ?>" name="product[prd_wrapp_color]" class="form-control col-md-7 col-xs-12" id="prd_wrapp_color" placeholder="Wrapp color" />
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Km</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo isset($prdValuationDtl['val_km']) ? $prdValuationDtl['val_km'] : $productsDetails['product_details']['prd_km_run']; ?>" type="text" name="product[prd_km_run]" class="numOnly form-control" id="prd_km_run" placeholder="Km" />
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Insurance Validity</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo isset($prdValuationDtl['val_insurance_comp_date']) ? $prdValuationDtl['val_insurance_comp_date'] :
                                                       $productsDetails['product_details']['prd_insurance_validity'];
                                                  ?>" type="text" name="product[prd_insurance_validity]" class="dtpDatePickerEvaluation form-control" id="prd_insurance_validity" placeholder="Insurance Validity" />
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Insurance IDV</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" value="<?php
                                                                 echo isset($prdValuationDtl['val_insurance_comp_idv']) ? $prdValuationDtl['val_insurance_comp_idv'] :
                                                                      $productsDetails['product_details']['prd_insurance_idv'];
                                                                 ?>" name="product[prd_insurance_idv]" class="numOnly form-control col-md-7 col-xs-12" id="prd_insurance_idv" placeholder="Insurance IDV" />
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Fuel</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select name="product[prd_fual]" id="prd_fual" class="select2_group form-control">
                                        <option value="0">Select Fuel Type</option>
                                        <?php
                                        $prdValuationDtl['val_fuel'] = isset($prdValuationDtl['val_fuel']) ? $prdValuationDtl['val_fuel'] : 0;
                                        foreach (unserialize(FUAL) as $key => $value) {
                                        ?>
                                             <option <?php echo ($selectFuel == $key) ? "selected='selected'" : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                   </select>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Price</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $productsDetails['product_details']['prd_price']; ?>" type="text" placeholder="Price" class="numOnly form-control" name="product[prd_price]" />
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Mileage</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $productsDetails['product_details']['prd_mileage']; ?>" type="text" name="product[prd_mileage]" class="numOnly form-control" id="prd_mileage" placeholder="Mileage" />
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Owner</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo isset($prdValuationDtl['val_no_of_owner']) ? $prdValuationDtl['val_no_of_owner'] : $productsDetails['product_details']['prd_owner']; ?>" type="text" name="product[prd_owner]" class="numOnly form-control" id="prd_owner" placeholder="Owner" />
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Engine in cc</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo isset($prdValuationDtl['val_eng_cc']) ? $prdValuationDtl['val_eng_cc'] : $productsDetails['product_details']['prd_engine_cc']; ?>" type="text" name="product[prd_engine_cc]" class="numOnly form-control" id="prd_engine_cc" placeholder="Engine in cc" />
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Priority</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="<?php echo $productsDetails['product_details']['prd_order']; ?>" type="text" name="product[prd_order]" class="form-control" id="prd_order" placeholder="Priority" />
                                   <?php /* if (!empty($order)) {?>
                                            <select name="product[prd_order]" id="exp_order" class="select2_group form-control">
                                            <option value="">Select Priority</option>
                                            <?php for ($i = 1; $i <= $order; $i++) {?>
                                            <option <?php echo ($i == $productsDetails['product_details']['prd_order']) ? "selected='selected'" : '';?>
                                            value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php }?>
                                            </select>
                                            <?php } */ ?>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">New Arrivals</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input value="1" <?php echo ($productsDetails['product_details']['prd_new_arrivals']) ? "checked='true'" : ''; ?> type="checkbox" name="product[prd_new_arrivals]" id="prd_new_arrivals" placeholder="Model" />
                              </div>
                         </div>

                         <!-- -->
                         <?php
                         if ($productsDetails['product_details']['product_images']) {
                              foreach ($productsDetails['product_details']['product_images'] as $key => $value) {
                         ?>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="input-group">
                                                  <?php echo img(array('src' => '../assets/uploads/product/' . $value['pdi_image'], 'height' => '80', 'width' => '100', 'id' => 'imgBrandImage')); ?>
                                             </div>
                                             <?php if ($value['pdi_image']) { ?>
                                                  <span class="help-block">
                                                       <a data-url="<?php echo site_url('product/removeImage/' . $value['pdi_id']); ?>" href="javascript:void(0);" style="width: 100px;" class="btn btn-block btn-danger btn-xs btnDeleteImage">Delete</a>
                                                  </span>
                                                  <div>
                                                       <input <?php echo ($value['pdi_is_default'] == 1) ? "checked" : ''; ?> data-url="<?php echo site_url('product/setDefaultImage/' . $value['pdi_id'] . '/' . $productsDetails['product_details']['prd_id']); ?>" class="radSetDefaultUpdate" type="radio" name="setdefault" />&nbsp;Set default
                                                  </div>
                                             <?php } ?>
                                        </div>
                                   </div>
                         <?php
                              }
                         }
                         ?>

                         <div class="form-group">
                              <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12">Product Images</label>
                              <div class="col-md-5 col-sm-3 col-xs-12">
                                   <div id="newupload">
                                        <input type="hidden" id="x10" name="x1[]" />
                                        <input type="hidden" id="y10" name="y1[]" />
                                        <input type="hidden" id="x20" name="x2[]" />
                                        <input type="hidden" id="y20" name="y2[]" />
                                        <input type="hidden" id="w0" name="w[]" />
                                        <input type="hidden" id="h0" name="h[]" />
                                        <input type="file" class="form-control col-md-7 col-xs-12" style="display: table;margin-bottom: 10px;" name="prd_image[]" id="image_file0" onchange="fileSelectHandler('0', '760', '476', true)" />
                                        <img id="preview0" class="preview" />
                                        <span class="help-inline">Choose 760(W) X 476(H)</span>
                                   </div>
                              </div>

                              <div class="col-md-1 col-sm-1 col-xs-12">
                                   <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus btnMoreProductImages"></span>
                              </div>
                         </div>
                         <div id="divMoreProductImages"></div>

                         <!-- Product specification -->
                         <div class="form-group">
                              <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12">Product specification</label>
                              <div class="col-md-3 col-sm-3 col-xs-12">
                                   <input type="text" class="form-control col-md-7 col-xs-12" placeholder="Technical Details Key" name="specification[spe_specification][]">
                              </div>
                              <div class="col-md-3 col-sm-3 col-xs-12">
                                   <input type="text" class="form-control col-md-7 col-xs-12" placeholder="Technical Details Value" name="specification[spe_specification_detail][]">
                              </div>

                              <div class="col-md-1 col-sm-1 col-xs-12">
                                   <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus" id="btnAddMoreSpecification"></span>
                              </div>
                         </div>
                         <div id="divSpecificatiion"></div>

                         <?php
                         if ($productsDetails['product_details']['product_specification']) {
                              foreach ($productsDetails['product_details']['product_specification'] as $key => $value) {
                         ?>
                                   <div class="form-group grp-specification">
                                        <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                             <input value="<?php echo $value['spe_specification']; ?>" type="text" class="form-control col-md-7 col-xs-12" placeholder="Technical Details Key" name="specification[spe_specification][]">
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                             <input value="<?php echo $value['spe_specification_detail']; ?>" type="text" class="form-control col-md-7 col-xs-12" placeholder="Technical Details Value" name="specification[spe_specification_detail][]">
                                        </div>

                                        <div class="col-md-1 col-sm-1 col-xs-12">
                                             <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-minus btnRemoveMoreSpecification"></span>
                                        </div>
                                   </div>
                         <?php
                              }
                         }
                         ?>
                         <!-- Features -->
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <h3>Features</h3>
                              </div>
                         </div>
                         <?php
                         if (!empty($features)) {
                              $productFeatures = explode(',', $productsDetails['product_details']['product_features']);
                              foreach ($features as $key => $value) {
                         ?>
                                   <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                        <div class="row-fluid">
                                             <div class="span4">
                                                  <div class="form-group no-margin-bot">
                                                       <div class=" col-md-6 col-sm-6 col-xs-12-row">
                                                            <input <?php echo (!empty($productFeatures) && in_array($value['ftr_id'], $productFeatures)) ? "checked='true'" : ''; ?> type="checkbox" class="input-block-level" name="features[<?php echo $value['ftr_id']; ?>]" value="1" style="margin-right: 10px;margin-top: -4px;" /><?php echo $value['ftr_feature']; ?>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              <?php } ?>
                         <?php } ?>
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
<script type="text/template" id="temSpecification">
     <div class="form-group grp-specification">
     <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12"></label>
     <div class="col-md-3 col-sm-3 col-xs-12">
     <input type="text" class="form-control col-md-7 col-xs-12" placeholder="Technical Details Key" name="specification[spe_specification][]">
     </div>
     <div class="col-md-3 col-sm-3 col-xs-12">
     <input type="text" class="form-control col-md-7 col-xs-12" placeholder="Technical Details Value" name="specification[spe_specification_detail][]">
     </div>
     <div class="col-md-1 col-sm-1 col-xs-12">
     <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-minus btnRemoveMoreSpecification"></span>
     </div>
     </div>
</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
     $(document).ready(function() {
          $('.select2').select2();
     });
</script>