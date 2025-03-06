<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Renew insurance</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php echo form_open_multipart($controller . "/updateins", array('id' => "frmVehicleModel", 'class' => "form-horizontal form-label-left")); ?>
                         <input type="hidden" name="val_id" value="<?php echo $stockVehicle['val_id']; ?>" />
                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle</label>
                              <b class="col-md-6 col-sm-6 col-xs-12">
                                   <?php echo $stockVehicle['val_veh_no'] . ' - ' . $stockVehicle['brd_title'] . ', ' . $stockVehicle['mod_title'] . ', ' . $stockVehicle['var_variant_name']; ?>
                              </b>
                         </div>
                         <!-- -->
                         <div class="row">
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Customer Name</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="text" class="form-control col-md-7 col-xs-12" name="val_cust_name" id="val_cust_name" placeholder="Customer Name" value="<?php echo $stockVehicle['val_cust_name']; ?>" />
                                        </div>
                                   </div>
                              </div>
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Phone Number</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="text" class="form-control col-md-7 col-xs-12" name="val_cust_phone" id="val_cust_phone" placeholder="Phone Number" value="<?php echo $stockVehicle['val_cust_phone']; ?>" />
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Email</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="text" class="form-control col-md-4 col-xs-6" value="<?php echo $stockVehicle['val_cust_email']; ?>" placeholder="Email" name="val_cust_email" id="val_cust_email" />
                                        </div>
                                   </div>
                              </div>
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Customer place<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input required type="text" class="form-control col-md-7 col-xs-12" name="val_cust_place" value="<?php echo $stockVehicle['val_cust_place']; ?>" id="val_cust_place" value="" autocomplete="off" placeholder="Customer place" />
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="row">
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">RC owner name</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $stockVehicle['val_rc_owner']; ?>" name="val_rc_owner" id="val_rc_owner" placeholder="RC owner name" />
                                        </div>
                                   </div>
                              </div>
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">No.of Owner(s)</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input required="required" class="form-control col-md-7 col-xs-12 numOnly" value="<?php echo $stockVehicle['val_no_of_owner']; ?>" placeholder="No.of Owner(s)" type="number" name="val_no_of_owner" id="val_no_of_owner">
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <!-- -->
                         <div class="row">
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">No.of Seats</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input required="required" class="form-control col-md-7 col-xs-12 numOnly" value="<?php echo $stockVehicle['val_no_of_seats']; ?>" placeholder="No.of Seats" type="number" name="val_no_of_seats" id="val_no_of_seats">
                                        </div>
                                   </div>
                              </div>
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Eng CC</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input required="required" type="number" class="form-control col-md-7 col-xs-12" name="val_eng_cc" value="<?php echo $stockVehicle['val_eng_cc']; ?>" id="val_eng_cc" placeholder="Eng CC" />
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="row">
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Address</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $stockVehicle['val_cust_adrs']; ?>" placeholder="Address" type="text" name="val_cust_adrs" id="val_cust_adrs">
                                        </div>
                                   </div>
                              </div>
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Age</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="number" class="numOnly form-control col-md-7 col-xs-12" name="val_cust_age" value="<?php echo $stockVehicle['val_cust_age']; ?>" id="val_eng_cc" placeholder="Age" />
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="row">
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">PIN</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input required="required" class="form-control col-md-7 col-xs-12 numOnly" value="<?php echo $stockVehicle['val_cust_pin']; ?>" placeholder="PIN" type="text" name="val_cust_pin" id="val_cust_pin">
                                        </div>
                                   </div>
                              </div>
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">HP</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="number" class="numOnly form-control col-md-7 col-xs-12" name="val_hp" value="<?php echo $stockVehicle['val_hp']; ?>" id="val_eng_cc" placeholder="HP" />
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="chk-container">
                              <h3 class="border-bottom border-gray pb-2 text-center">Insurance</h3>
                         </div>
                         <div class="row">
                              <!-- -->
                              <table class="table table-striped table-bordered">
                                   <tr>
                                        <th>Insurance</th>
                                        <th>Valid UP to</th>
                                        <th>IDV Value</th>
                                   </tr>
                                   <tr>
                                        <td>Comprehensive</td>

                                        <td><input value="<?php echo !empty($stockVehicle['val_insurance_comp_date']) ? date('d-m-Y', strtotime($stockVehicle['val_insurance_comp_date'])) : ''; ?>" placeholder="Valid UP to (comprehensive)" type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" name="val_insurance_comp_date" /></td>

                                        <td><input value="<?php echo $stockVehicle['val_insurance_comp_idv']; ?>" placeholder="IDV Value (comprehensive)" type="text" class="form-control col-md-7 col-xs-12 decimalOnly" name="val_insurance_comp_idv" /></td>
                                   </tr>
                                   <tr>
                                        <td>Limited Liability</td>

                                        <td><input placeholder="Limited Liability (Limited Liability)" type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerEvaluation" value="<?php echo !empty($stockVehicle['val_insurance_ll_date']) ? date('d-m-Y', strtotime($stockVehicle['val_insurance_ll_date'])) : ''; ?>" name="val_insurance_ll_date" /></td>

                                        <td><input placeholder="NCB" type="text" value="<?php echo $stockVehicle['val_insurance_ll_idv']; ?>" class="form-control col-md-7 col-xs-12" name="val_insurance_ll_idv" /></td>
                                   </tr>
                                   <tr>
                                        <td>NCB need by Customer</td>
                                        <td><input <?php echo ($stockVehicle['val_insurance_need_ncb'] == 1) ? 'checked' : ''; ?> value="1" type="checkbox" name="val_insurance_need_ncb" /></td>
                                        <td>
                                             <span style="float: left;">Type</span>
                                             <div style="float: left;width: 200px;margin-left: 20px;">
                                                  <select class="col-md-2 col-xs-5 select2_group form-control" name="val_insurance" id="val_insurance">
                                                       <option value="0">Select Insurance Type</option>
                                                       <?php foreach (unserialize(INSURANCE_TYPES) as $key => $value) { ?>
                                                            <option <?php echo ($stockVehicle['val_insurance'] == $key) ? 'selected="selected"' : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             </div>
                                        </td>
                                   </tr>
                              </table>
                         </div>
                         <div class="row">
                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Insurance company</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input type="text" class="form-control col-md-7 col-xs-12 txtValHypoBankBranch" value="<?php echo $stockVehicle['val_insurance_company']; ?>" name="val_insurance_company" id="val_hypo_bank_branch" placeholder="Insurance company Name" />
                                        </div>
                                   </div>
                              </div>

                              <div class="col-sm-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Remarks</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <?php
                                             $remark = '';
                                             if (!empty($stockVehicle['val_ins_remarks'])) {
                                                  $remark = unserialize($stockVehicle['val_ins_remarks']);
                                                  $remark = isset($remark[$this->uid]) ? $remark[$this->uid] : '';
                                             } ?>
                                             <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $remark; ?>" name="val_ins_remarks" id="val_ins_remarks" placeholder="Remarks" />
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <!-- Upload document -->
                         <div class="form-group">
                              <div class="col-md-3 col-sm-3 col-xs-12">
                                   <input placeholder="Document name" id="comp_complaint" class="form-control col-md-7 col-xs-12" type="text" name="document_title">
                              </div>
                              <div class="col-md-3 col-sm-3 col-xs-12">
                                   <select name="document_type" class="form-control">
                                        <option value="2">Insurance</option>
                                   </select>
                              </div>
                              <div class="col-md-2 col-sm-2 col-xs-12">
                                   <input type="file" class="form-control col-md-7 col-xs-12" id="file" name="documents[]" />
                              </div>
                         </div>
                         <!-- Upload document -->
                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success btnSubmitRegister">Submit</button>
                                   <button class="btn btn-primary" type="reset">Reset</button>
                              </div>
                         </div>
                         <?php echo form_close() ?>

                         <!-- Documents -->
                         <?php
                         $server1 = "https://royaldrive.in/assets/uploads/evaluation/";
                         $server2 = "https://vestletech.com/demo/royalportal/rdportal/assets/uploads/evaluation/";
                         if (!empty($stockVehicle['documents'])) { ?>
                              <div class="hideOnPrint">
                                   <h3>Document</h3>
                                   <?php foreach ((array) $stockVehicle['documents'] as $key => $value) { ?>
                                        <div class="form-group" style="float: left;width: 100%;">

                                             <div class="gallery deleteRow<?php echo $value['vdoc_id']; ?> col-md-6 col-sm-6 col-xs-12" style="padding: 10px;">
                                                  <a target="_blank" href="javascript:;">
                                                       <?php
                                                       if (is_image($value['vdoc_doc'])) {
                                                            echo img(array('class' => 'img', 'src' => $server2 . $value['vdoc_doc'], 'style' => "width:200px;float:left;"));
                                                       } else {
                                                            echo img(array('src' => './assets/images/' . get_file_extension($value['vdoc_doc']) . '.png', 'style' => "width:25px;float:left;"));
                                                       }
                                                       ?>
                                                  </a>
                                                  <div class="col-md-3 col-sm-3 col-xs-12">
                                                       <label for="enq_cus_email" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $value['vdoc_doc_title']; ?></label>
                                                  </div>
                                                  <div>
                                                       <?php
                                                       $fl = '';
                                                       if (file_exists('../assets/uploads/evaluation/' . $value['vdoc_doc'])) { // Old
                                                            $fl = $server1 . $value['vdoc_doc'];
                                                       } else {
                                                            $fl = $server2 . $value['vdoc_doc'];
                                                       }
                                                       ?>
                                                       <a href="<?php echo $fl; ?>" target="_blank" class="btn btn-primary btn-xs" style="margin-bottom: 0px;">
                                                            <i class="fa fa-file-o"></i> View.</a>
                                                       <?php if (check_permission('evaluation', 'deletedocument')) { ?>
                                                            <a data-url="<?php echo site_url('evaluation/deleteDocument/' . encryptor($value['vdoc_id'])); ?>" data-id="<?php echo $value['vdoc_id']; ?>" href="javascript:;" class="deleteRow btn btn-danger btn-xs" style="margin-bottom: 0px;">
                                                                 <i class="fa fa-trash-o"></i> Delete</a>
                                                       <?php } ?>
                                                  </div>
                                             </div>
                                        </div>
                                   <?php } ?>
                              </div> 
                         <?php } ?>
                         <!-- -->
                    </div>
               </div>
          </div>
     </div>
</div>