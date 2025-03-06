<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Add New Employee</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart("product/createDummy", array('id' => "frmProduct", 'class' => "form-horizontal form-label-left")) ?>
                         <input type="hidden" class="txtValuationId" name="product[prd_valuation_id]" />
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle Reg No</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" class="txtprdRegnoPrt1 form-control col-md-7 col-xs-12" name="product[prd_regno_prt_1]" maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="KL" />

                                   <input type="text" class="txtprdRegnoPrt2 form-control col-md-7 col-xs-12" name="product[prd_regno_prt_2]" maxlength="2" style="text-transform: uppercase;width: 49px;" required placeholder="00" />

                                   <input type="text" class="txtprdRegnoPrt3 form-control col-md-7 col-xs-12" name="product[prd_regno_prt_3]" maxlength="3" style="text-transform: uppercase;width: 49px;" placeholder="AA" />

                                   <input type="text" class="txtprdRegnoPrt4 txtVehicleNo form-control col-md-7 col-xs-12" name="product[prd_regno_prt_4]" maxlength="4" style="text-transform: uppercase;width: 80px;" required placeholder="0000" />
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Product number</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input readonly type="text" class="form-control col-md-7 col-xs-12" name="product[prd_number]" id="prd_number" value="<?php echo gen_random(); ?>" />
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Walk around</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input placeholder="Walk around" type="text" class="form-control col-md-7 col-xs-12" name="product[prd_video]" id="prd_video" />
                              </div>
                         </div>

                         <!-- -->
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
                                   <span style="float: right;cursor: pointer;position: fixed;top: 276px;right: 12%;" class="btn btn-success glyphicon glyphicon-plus btnMoreProductImages"></span>
                              </div>
                         </div>
                         <div id="divMoreProductImages"></div>

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