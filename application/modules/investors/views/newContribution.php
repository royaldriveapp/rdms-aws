<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>New Contribution</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="col-md-8 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                   <div class="panel-heading">New Contribution</div>
                                   <div class="panel-body">
                                        <?php
                                        echo form_open_multipart($controller . "/makeInvest", array('id' => "frmVehicleModel",
                                            'class' => "form-horizontal form-label-left", "onsubmit" => "return validateForm()"))
                                        ?>
                                        <input type="hidden" name="voxbayId" value="<?php echo $voxBay; ?>" />

                                        <div class="form-group">
                                             <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Select Investor</label>
                                             <div class="col-md-5 col-sm-5 col-xs-12">
                                                  <select required class="select2_group form-control" name="details[invd_investor]" id="invd_status">
                                                       <option value="">Please select </option>
                                                       <?php foreach ($investors as $key => $value) { ?>
                                                            <option <?php echo (isset($investor) && $investor == $value['inv_id']) ? 'selected="selected"' : ''; ?>
                                                                 value="<?php echo $value['inv_id']; ?>"><?php echo $value['inv_name']; ?></option>
                                                            <?php } ?>
                                                  </select>
                                             </div>
                                             <a href="<?php echo site_url('investors/newinvestor/' . $voxBay); ?>">
                                                  <i class="fa fa-plus-square" style="font-size: 37px;"></i>
                                             </a>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Entry date <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input value="<?php echo date('d-m-Y'); ?>" required type="text" class="dtpDatePicker form-control col-md-7 col-xs-12"
                                                         name="details[invd_entry_date]" id="invd_entry_date" autocomplete="off" placeholder="Entry date"/>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Time of investment</label>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control" name="details[invd_tim_year]" id="vreg_contact_mode">
                                                       <option value="">Year</option>
                                                       <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i . ' Year'; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                             <div class="col-md-3 col-sm-6 col-xs-12">
                                                  <select class="select2_group form-control" name="details[invd_tim_month]" id="vreg_contact_mode">
                                                       <option value="">Month</option>
                                                       <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i . ' Month'; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Investment amount</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control" name="details[invd_inv_amount]" id="vreg_contact_mode">
                                                       <option value="">Investment amount</option>
                                                       <?php foreach (unserialize(INV_AMOUNT) as $key => $value) { ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Customer status</label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <select required class="select2_group form-control" name="details[invd_status]" id="invd_status">
                                                       <option value="">Please select customer status</option>
                                                       <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $key => $value) { ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </div>
                                        <!-- -->
                                        <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer remarks <span class="required">*</span></label>
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <textarea class="form-control col-md-7 col-xs-12" name="details[invd_coment]" id="invd_coment" placeholder="Customer remarks"></textarea>
                                             </div>
                                        </div>
                                        <div class="divSale"></div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                             <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                  <button type="submit" class="btn btn-success btnSubmitRegister">Submit</button>
                                             </div>
                                        </div>
                                        <?php echo form_close() ?>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>