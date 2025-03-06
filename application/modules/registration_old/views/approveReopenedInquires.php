<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Quick vehicle register</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li class="dropdown" style="float: right;">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                   <?php if (isset($data['enq_id']) && !empty($data['enq_id'])) {?>
                                          <ul class="dropdown-menu" role="menu">
                                               <li><a target="blank" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($data['enq_id']));?>">View tracking card</a></li>
                                          </ul>
                                     <?php }?>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <?php echo form_open_multipart($controller . "/approveReopenedInquires", array('id' => "frmVehicleModel", 'class' => "form-horizontal form-label-left"))?>
                         <input type="hidden" name="vreg_id" value="<?php echo !empty($data['vreg_id']) ? $data['vreg_id'] : 0;?>"/>
                         <input type="hidden" name="vreg_inquiry" value="<?php echo !empty($data['enq_id']) ? $data['enq_id'] : 0;?>"/>
                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Mode of contact</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select required class="select2_group form-control" name="vreg_contact_mode" id="vreg_contact_mode"
                                           onchange="$(this).val() == 5 ? $('.divEvents').show() : $('.divEvents').hide();">
                                        <option value="">Select one</option>
                                        <optgroup label="RD Mode of Enquiry">
                                             <?php
                                               foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                    if (!in_array($key, array(18, 17, 6, 19, 20))) {
                                                         ?>
                                                         <option <?php echo ($data['vreg_contact_mode'] == $key) ? 'selected="selected"' : '';?> 
                                                              value="<?php echo $key;?>"><?php echo $value;?></option>
                                                              <?php
                                                         }
                                                    }
                                                  ?>
                                        </optgroup>
                                        <optgroup label="Own Mode of Enquiry">
                                             <?php
                                               foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                    if (in_array($key, array(18, 17, 6, 19, 20))) {
                                                         ?>
                                                         <option <?php echo ($data['vreg_contact_mode'] == $key) ? 'selected="selected"' : '';?> 
                                                              value="<?php echo $key;?>"><?php echo $value;?></option>
                                                              <?php
                                                         }
                                                    }
                                                  ?>
                                        </optgroup>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Entry date</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="dtpCmnDatePicker form-control col-md-7 col-xs-12" 
                                          value="<?php echo date('d-m-Y', strtotime($data['vreg_entry_date']));?>"
                                          name="vreg_entry_date" id="vreg_entry_date" autocomplete="off" placeholder="Entry date"/>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer name</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="form-control col-md-7 col-xs-12" 
                                          value="<?php echo $data['vreg_cust_name'];?>" name="vreg_cust_name" id="vreg_cust_name"
                                          autocomplete="off" placeholder="Customer name"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" class="form-control col-md-7 col-xs-12" name="vreg_cust_phone" id="vreg_cust_phone"
                                          value="<?php echo $data['vreg_cust_phone'];?>" autocomplete="off" placeholder="Customer phone"/>
                                   <h6 class="vreg_cust_phone_msg" style="color: red;"></h6>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Place</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" class="form-control col-md-7 col-xs-12" name="vreg_cust_place" id="vreg_cust_place"
                                          value="<?php echo $data['vreg_cust_place'];?>" autocomplete="off" placeholder="Customer place"/>
                              </div>
                         </div>

                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Assigned to
                                   <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select required="true" class="select2_group form-control enq_se_id cmbSearchList" name="vreg_assigned_to">
                                        <option value="">Assign to sales executive</option>
                                        <?php foreach ($salesExe as $key => $value) {?>
                                               <option <?php echo ($data['vreg_assigned_to'] == $value['usr_id']) ? 'selected="selected"' : '';?> 
                                                    value="<?php echo $value['usr_id'];?>"><?php echo $value['usr_first_name'];?></option>
                                               <?php }?>
                                   </select>
                              </div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Comments by <i><?php echo $data['reg_usr_first_name']; ?></i></label>
                              <div class="col-md-6 col-sm-6 col-xs-12"><?php echo $data['vreg_customer_remark']; ?></div>
                         </div>
                         
                         <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Remarks </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <textarea required class="form-control col-md-7 col-xs-12" name="remarks" id="remarks" placeholder="Remarks"></textarea>
                              </div>
                         </div>
                         
                         <div class="ln_solid"></div>
                         <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <button type="submit" class="btn btn-success btnSubmitRegister">Submit and confirm</button>
                              </div>
                         </div>
                         <?php echo form_close()?>
                    </div>
               </div>
          </div>
     </div>
</div>