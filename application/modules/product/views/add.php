<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add New Product</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <?php echo form_open_multipart("product/add", array('id' => "frmProduct", 'class' => "form-horizontal form-label-left", "onsubmit" => "document.getElementById('submit').disabled=true;")) ?>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle Reg No</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control col-md-7 col-xs-12" name="product[prd_regno_prt_1]"
                                value="<?php echo isset($vehNo['0']) ? $vehNo['0'] : ''; ?>" maxlength="2"
                                style="text-transform: uppercase;width: 49px;" required placeholder="KL" />

                            <input type="text" class="numOnly form-control col-md-7 col-xs-12"
                                name="product[prd_regno_prt_2]"
                                value="<?php echo isset($vehNo['1']) ? $vehNo['1'] : ''; ?>" maxlength="2"
                                style="text-transform: uppercase;width: 49px;" required placeholder="00" />

                            <input type="text" class="form-control col-md-7 col-xs-12" name="product[prd_regno_prt_3]"
                                value="<?php echo isset($vehNo['2']) ? $vehNo['2'] : ''; ?>" maxlength="3"
                                style="text-transform: uppercase;width: 49px;" placeholder="AA" />

                            <input type="text" class="numOnly form-control col-md-7 col-xs-12"
                                name="product[prd_regno_prt_4]"
                                value="<?php echo isset($vehNo['3']) ? $vehNo['3'] : ''; ?>" maxlength="4"
                                style="text-transform: uppercase;width: 80px;" required placeholder="0000" />
                        </div>
                    </div>
                    <?php if ((isset($location)) && !empty($location)) { ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select required name="product[prd_location]" class="select2_group form-control"
                                placeholder="Color">
                                <option value="0">Select location</option>
                                <?php foreach ($location as $key => $value) { ?>
                                <option <?php echo ($value['shr_id'] == $this->shrm) ? "selected='selected'" : ''; ?>
                                    value="<?php echo $value['shr_id']; ?>"><?php echo $value['shr_location']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Smart?</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="1" type="checkbox" name="product[prd_rd_mini]" class="" id="prd_rd_mini" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product number</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input readonly type="text" class="form-control col-md-7 col-xs-12"
                                name="product[prd_number]" id="prd_number" value="<?php echo gen_random(); ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Brand</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="product[prd_brand]" id="prd_brand"
                                class="form-control col-md-7 col-xs-12 bindToDropdown" data-dflt-select="Select Model"
                                required data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbModel">
                                <option value="">Select Brand</option>
                                <?php
                                        if (!empty($brands)) {
                                             foreach ($brands as $key => $value) {
                                        ?>
                                <option value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?>
                                </option>
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
                            <select required data-url="<?php echo site_url('enquiry/bindVarient'); ?>"
                                data-bind="cmbVariant" data-dflt-select="Select Variant"
                                class="cmbModel select2_group form-control bindToDropdown" name="product[prd_model]"
                                id="val_brand">
                                <option>Select brand first</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Variant</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select required class="select2_group form-control cmbVariant" name="product[prd_variant]"
                                id="val_brand">
                                <option value="">Select brand and model first</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Loan available</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="1" type="checkbox" name="product[prd_loan_avail]" class=""
                                id="prd_loan_avail" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-12" style="width: 50%;">
                            <textarea placeholder="Design feature" class="form-control col-md-7 col-xs-12 editor1"
                                name="product[prd_desc]"></textarea>
                        </div>
                    </div>
                    <?php //if ($this->shrm == 1 || $this->uid == 100) { 
                         ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Safety feature</label>
                        <div class="col-md-6 col-sm-6 col-xs-12" style="width: 50%;">
                            <textarea placeholder="Safety feature" class="form-control col-md-7 col-xs-12 editor1"
                                name="product[prd_safety_feture]"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Comfort & Convenience feature</label>
                        <div class="col-md-6 col-sm-6 col-xs-12" style="width: 50%;">
                            <textarea placeholder="Comfort & Convenience feature"
                                class="form-control col-md-7 col-xs-12 editor1"
                                name="product[prd_cmfort_cnvnent_feture]"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Warranty upto</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="product[prd_warranty_upto]" class="form-control"
                                id="prd_warranty_upto" placeholder="Warranty upto" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Insurance type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="col-md-2 col-xs-5 select2_group form-control"
                                name="product[prd_insurance_type]" id="prd_insurance_type">
                                <option value="0">Select Insurance Type</option>
                                <?php foreach (unserialize(INSURANCE_TYPES) as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Transmission</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select required class="select2_group form-control" name="product[prd_transmission]"
                                id="prd_transmission">
                                <option value="">Select Transmission</option>
                                <?php foreach (unserialize(TRANSMISSIONS) as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">ARAI Tested Mileage</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="product[prd_arai_mileage]" class="numOnly form-control"
                                id="prd_arai_mileage" placeholder="ARAI Mileage" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Accessories Fitted</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="product[prd_acc_ftd]" class="form-control" id="prd_acc_ftd"
                                placeholder="Accessories Fitted" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Current on road price</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="product[prd_or_road_price]" class="numOnly form-control"
                                id="prd_or_road_price" placeholder="Current on road price" />
                        </div>
                    </div>
                    <?php //} 
                         ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Year</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <!--<input type="text" name="product[prd_year]" class="form-control col-md-7 col-xs-12" id="prd_year" placeholder="Year"/>-->
                            <select name="product[prd_year]" class="select2_group form-control"
                                placeholder="Year of registered">
                                <option value="0">Select year</option>
                                <?php for ($i = date('Y') - 30; $i <= date('Y'); $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Color</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <!--<input type="text" name="product[prd_color]" class="form-control col-md-7 col-xs-12" id="prd_color" placeholder="Color"/>-->
                            <select name="product[prd_color_id]" class="select2 select2_group form-control"
                                placeholder="Color">
                                <option value="0">Select color</option>
                                <?php foreach ($color as $key => $value) { ?>
                                <option value="<?php echo $value['vc_id']; ?>"><?php echo $value['vc_color']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Wrapp color</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="product[prd_wrapp_color]" class="form-control col-md-7 col-xs-12"
                                id="prd_wrapp_color" placeholder="Wrapp color" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Km</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="product[prd_km_run]"
                                class="numOnly form-control col-md-7 col-xs-12" id="prd_km_run" placeholder="Km" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Insurance Validity</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="product[prd_insurance_validity]"
                                class="dtpDatePickerEvaluation form-control col-md-7 col-xs-12"
                                id="prd_insurance_validity" placeholder="Insurance Validity" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Insurance IDV</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="product[prd_insurance_idv]"
                                class="numOnly form-control col-md-7 col-xs-12" id="prd_insurance_idv"
                                placeholder="Insurance IDV" />
                        </div>
                    </div>
                    <!-- <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Fual</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select name="product[prd_fual]" id="prd_fual"  class="form-control col-md-7 col-xs-12">
                                        <option value="0">Select Fuel Type</option>
                                        <option value="diesel">Diesel</option>
                                        <option value="petrol">Petrol</option>
                                        <option value="gas">Gas</option>
                                        <option value="Hybrid">Hybrid</option>
                                        <option value="Electric">Electric</option>
                                        <option value="CNG">CNG</option>
                                   </select>
                              </div>
                         </div>-->

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fuel</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select required="true" style="width: 170px;"
                                class="cmbFuel form-control col-md-7 col-xs-12" name="product[prd_fual]">
                                <?php foreach (unserialize(FUAL) as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Price</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" placeholder="Price" class="numOnly form-control col-md-7 col-xs-12"
                                name="product[prd_price]" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mileage</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="product[prd_mileage]"
                                class="numOnly form-control col-md-7 col-xs-12" id="prd_mileage"
                                placeholder="Mileage" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Owner</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="product[prd_owner]" class="form-control col-md-7 col-xs-12"
                                id="prd_owner" placeholder="Owner" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Engine in cc</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="product[prd_engine_cc]"
                                class="numOnly form-control col-md-7 col-xs-12" id="prd_engine_cc"
                                placeholder="Engine in cc" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">New Arrivals</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="1" type="checkbox" name="product[prd_new_arrivals]" class=""
                                id="prd_new_arrivals" placeholder="Model" />
                        </div>
                    </div>
                    <!-- -->
                    <div class="form-group">
                        <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12">Product
                            Images</label>
                        <div class="col-md-5 col-sm-3 col-xs-12">
                            <div id="newupload">
                                <input type="hidden" id="x10" name="x1[]" />
                                <input type="hidden" id="y10" name="y1[]" />
                                <input type="hidden" id="x20" name="x2[]" />
                                <input type="hidden" id="y20" name="y2[]" />
                                <input type="hidden" id="w0" name="w[]" />
                                <input type="hidden" id="h0" name="h[]" />
                                <input type="file" class="form-control col-md-7 col-xs-12"
                                    style="display: table;margin-bottom: 10px;" name="prd_image[]" id="image_file0"
                                    onchange="fileSelectHandler('0', '760', '476', true)" />
                                <img id="preview0" class="preview" />
                                <span class="help-inline">Choose 760(W) X 476(H)</span>
                            </div>
                        </div>

                        <div class="col-md-1 col-sm-1 col-xs-12">
                            <span style="float: right;cursor: pointer;"
                                class="glyphicon glyphicon-plus btnMoreProductImages"></span>
                        </div>
                    </div>
                    <div id="divMoreProductImages"></div>

                    <!-- Technical details -->
                    <div class="form-group">
                        <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12">Product
                            specification</label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <input type="text" class="form-control col-md-7 col-xs-12"
                                placeholder="Technical Details Key" name="specification[spe_specification][]">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <input type="text" class="form-control col-md-7 col-xs-12"
                                placeholder="Technical Details Value" name="specification[spe_specification_detail][]">
                        </div>

                        <div class="col-md-1 col-sm-1 col-xs-12">
                            <span style="float: right;cursor: pointer;" class="glyphicon glyphicon-plus"
                                id="btnAddMoreSpecification"></span>
                        </div>
                    </div>
                    <div id="divSpecificatiion"></div>

                    <!-- Technical details -->
                    <!-- Features -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3>Features</h3>
                        </div>
                    </div>
                    <?php if (!empty($features)) { ?>
                    <?php foreach ($features as $key => $value) { ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="form-group no-margin-bot">
                                    <div class=" col-md-6 col-sm-6 col-xs-12-row">
                                        <input type="checkbox" class="input-block-level"
                                            name="features[<?php echo $value['ftr_id']; ?>]" value="1"
                                            style="margin-right: 10px;margin-top: -4px;" /><?php echo $value['ftr_feature']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                              }
                         }
                         ?>
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