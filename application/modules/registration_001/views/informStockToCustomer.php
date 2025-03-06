<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Stock Matching Registers</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <!---fltr-------------->
                         <form action="<?php echo site_url('registration/informStockToCustomer/');?>" method="get">
                              <table>
                                   <td>
                                        <input autocomplete="off" name="date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date from" value="<?php echo @$_GET['date_from'];?>"/>
                                   </td>
                                   <td style="padding-left: 10px;">
                                        <input autocomplete="off" name="date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date to" value="<?php echo @$_GET['date_to'];?>"/>
                                   </td>
                                 
                                   <td style="padding-left: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>
                              </table>
                         </form>
                         <!--@fltr---------------->

                         <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" style="background: none;">
                                   <li role="presentation" class="active">
                                        <a href="#tab_dar" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Luxury</a>
                                   </li>
                                   <li role="presentation">
                                        <a href="#tab_website" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Smart</a>
                                   </li>
                              </ul>
                              <div id="myTabContent" class="tab-content">
                                   <div role="tabpanel" class="tab-pane fade active in" id="tab_dar" aria-labelledby="dar-tab">
                                        <?php
                                          foreach ($datas['luxury'] as $key => $value) {
                                               //$demandedVehicle = $this->registration->getRelatedVehicle($value['prd_brand'], $value['prd_model'], $value['prd_variant']);
                                               $demandedVehicle = $this->registration->getRelatedVehicle($value['prd_brand'], $value['prd_model'], $value['prd_variant'],$_GET);
                                               ?>
                                               <div style="float: left; width: 100%;overflow-x: scroll;overflow-y: hidden;">
                                                    <h3><?php echo $value['brd_title'] . ',' . $value['mod_title'] . ',' . $value['var_variant_name'];?></h3>
                                                    <table class="datatable-resp table table-striped table-bordered">
                                                         <thead>
                                                              <tr>
                                                                   <th>Entry date</th>
                                                                   <th>Customer name</th>
                                                                   <th>Contact</th>
                                                                   <th>Place</th>
                                                                   <th>Contact mode</th>
                                                                   <th>Event</th>
                                                                   <th>Brand</th>
                                                                   <th>Model</th>
                                                                   <th>Variant</th>
                                                                   <th>Price</th>
                                                                   <th>Year</th>
                                                                   <th>Investment</th>
                                                                   <th>Added on</th>
                                                                   <th>Assigned to</th>
                                                                   <th>Added by</th>
                                                                   <th>Call type</th>
                                                                   <th>Comments</th>
                                                                   <th>Sales officer comment</th>
                                                                   <th>Punch</th>
                                                                   <?php if (check_permission('registration', 'reassignstockmatching')) {?>
                                                                      <th>Action</th>
                                                                   <?php } ?>
                                                              </tr>
                                                         </thead>
                                                         <tbody>
                                                              <?php
                                                              foreach ((array) $demandedVehicle as $dk => $dvalue) {
                                                                   $regId = encryptor($dvalue['vreg_id']);
                                                                   $canPunch = 1;
                                                                   if ($dvalue['vreg_is_verified'] != 1) {
                                                                        $canPunch = 0;
                                                                   }
                                                                   ?>
                                                                   <tr style="<?php echo ($dvalue['vreg_status'] == 0) ? 'color: #fff;background-color: red;' : '';?>"
                                                                       data-url="<?php echo site_url($controller . '/view/' . encryptor($dvalue['vreg_id']));?>">
                                                                        <td class="trVOE"><?php echo date('j M Y', strtotime($dvalue['vreg_entry_date']));?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_cust_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_cust_phone'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_cust_place'];?></td>
                                                                        <td class="trVOE">
                                                                             <?php
                                                                             $modes = unserialize(MODE_OF_CONTACT);
                                                                             echo isset($modes[$dvalue['vreg_contact_mode']]) ? $modes[$dvalue['vreg_contact_mode']] : '';
                                                                             ?>
                                                                        </td>
                                                                        <td class="trVOE"><?php echo $dvalue['evnt_title'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['brd_title'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['mod_title'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['var_variant_name'];?></td>
                                                                        <td class="trVOE"><?php echo get_in_currency_format($value['prd_price']);?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_year'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_investment'];?></td>
                                                                        <td class="trVOE"><?php echo date('j M Y', strtotime($dvalue['vreg_added_on']));?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['assign_usr_first_name'] . ' ' . $dvalue['assign_usr_last_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['addedby_usr_first_name'] . ' ' . $dvalue['addedby_usr_last_name'];?></td>
                                                                        <td>
                                                                             <?php
                                                                             $callTypes = unserialize(CALL_TYPE);
                                                                             echo isset($callTypes[$dvalue['vreg_call_type']]) ? $callTypes[$dvalue['vreg_call_type']] : '';
                                                                             ?>
                                                                        </td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_customer_remark'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_last_action'];?></td>
                                                                        <td>
                                                                             <?php if (check_permission('registration', 'alloworeassign') && ($canPunch == 1)) {?>
                                                                                  <div onclick="$('#<?php echo $dvalue['vreg_id'];?>').modal({backdrop: false});"><i class="fa fa-pencil-square" data-toggle="modal" data-target="#<?php //echo $value['vreg_id'];?>"></i></div>
                                                                                  <div class="modal fade divModel" id="<?php echo $dvalue['vreg_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                       <div class="modal-dialog" role="document" style="width: 100%;">
                                                                                            <div class="modal-content" style="color: black;">
                                                                                                 <div class="modal-header">
                                                                                                      <h5 style="width: 66px;float: left;" class="modal-title" id="exampleModalLabel">Punch register</h5>
                                                                                                      <button style="float:right;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                           <span aria-hidden="true">&times;</span>
                                                                                                      </button>
                                                                                                 </div>
                                                                                                 <div class="modal-body">
                                                                                                      <div class="container">
                                                                                                           <div class="row">
                                                                                                                <div class="col-sm">
                                                                                                                     <div class="col-md-6 col-sm-12 col-xs-12">
                                                                                                                          <div class="x_panel">
                                                                                                                               <div class="x_content">
                                                                                                                                    <div class="form-group" style="width: 100%;float: left;">
                                                                                                                                         <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer name</label>
                                                                                                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                              <?php echo $dvalue['vreg_cust_name'];?>
                                                                                                                                         </div>
                                                                                                                                    </div>

                                                                                                                                    <div class="form-group" style="width: 100%;float: left;">
                                                                                                                                         <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer contact</label>
                                                                                                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                              <a style="color: #000;" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $dvalue['vreg_cust_phone'];?>"><?php echo $dvalue['vreg_cust_phone'];?></a>
                                                                                                                                         </div>
                                                                                                                                    </div>

                                                                                                                                    <div class="form-group" style="width: 100%;float: left;">
                                                                                                                                         <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                                                                                                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                              <?php echo $dvalue['vreg_cust_place'];?>
                                                                                                                                         </div>
                                                                                                                                    </div>

                                                                                                                                    <div class="form-group" style="width: 100%;float: left;white-space: normal;">
                                                                                                                                         <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer feedback</label>
                                                                                                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                              <?php echo $dvalue['vreg_customer_remark'];?>
                                                                                                                                         </div>
                                                                                                                                    </div>

                                                                                                                                    <div class="form-group" style="width: 100%;float: left;">
                                                                                                                                         <label class="control-label col-md-3 col-sm-3 col-xs-12">Assigned by</label>
                                                                                                                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                              <?php echo $dvalue['addedby_usr_first_name'] . ' ' . $dvalue['addedby_usr_last_name'];?>
                                                                                                                                         </div>
                                                                                                                                    </div>
                                                                                                                                    <?php
                                                                                                                                    $call = $this->enquiry->getConnectedCallByRegister($value['vreg_id']);
                                                                                                                                    $call = isset($call['ccb_recording_URL']) ? $call['ccb_recording_URL'] : '';
                                                                                                                                    if (!empty($call)) {
                                                                                                                                         ?>
                                                                                                                                         <div class="form-group" style="width: 100%;float: left;white-space: normal;">
                                                                                                                                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Call record</label>
                                                                                                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                                   <audio controls><source src="<?php echo 'http://pbx.voxbaysolutions.com/callrecordings/' . $call;?>"/></audio>
                                                                                                                                              </div>
                                                                                                                                         </div>
                                                                                                                                    <?php }?>
                                                                                                                               </div>
                                                                                                                               <?php
                                                                                                                               if (check_permission('registration', 'showreghistory')) {
                                                                                                                                    $regHistory = $this->registration->reghistory($value['vreg_id']);
                                                                                                                                    ?>
                                                                                                                                    <div style="width: 100%;overflow-x: scroll;">
                                                                                                                                         <table class="table table-striped table-bordered">
                                                                                                                                              <thead>
                                                                                                                                                   <tr>
                                                                                                                                                        <th>Date</th>
                                                                                                                                                        <th>Assigned By</th>
                                                                                                                                                        <th>Assigned To</th>
                                                                                                                                                        <th>Comments</th>
                                                                                                                                                        <th>Remarks</th>
                                                                                                                                                   </tr>
                                                                                                                                              </thead>
                                                                                                                                              <tbody>
                                                                                                                                                   <?php
                                                                                                                                                   foreach ($regHistory as $hkey => $hvalue) {
                                                                                                                                                        ?>
                                                                                                                                                        <tr>
                                                                                                                                                             <td><?php echo date('j M Y h:i', strtotime($hvalue['regh_added_date']));?></td>
                                                                                                                                                             <td><?php echo $hvalue['addedby_usr_first_name'] . ' ' . $hvalue['addedby_usr_last_name'];?></td>
                                                                                                                                                             <td><?php echo $hvalue['assign_usr_first_name'] . ' ' . $hvalue['assign_usr_last_name'];?></td>
                                                                                                                                                             <td><?php echo $hvalue['regh_remarks'];?></td>
                                                                                                                                                             <td><?php echo $hvalue['regh_system_cmd'];?></td>
                                                                                                                                                        </tr>
                                                                                                                                                        <?php
                                                                                                                                                   }
                                                                                                                                                   ?>
                                                                                                                                              </tbody>
                                                                                                                                         </table>
                                                                                                                                    </div>
                                                                                                                               <?php } if (check_permission('registration', 'canpnchenqorfolup')) {?>
                                                                                                                                    <div class="row" style="text-align: center;">
                                                                                                                                         <div>
                                                                                                                                              <?php $txtPunch = !empty($dvalue['vreg_inquiry']) ? 'Followup' : 'Punch to enquiry';?>
                                                                                                                                              <a class="btn btn-primary" href="<?php echo $url;?>"><?php echo $txtPunch;?></a><br>
                                                                                                                                         </div>
                                                                                                                                    </div>
                                                                                                                               <?php }?>
                                                                                                                          </div>
                                                                                                                     </div>
                                                                                                                </div>
                                                                                                                <?php if (check_permission('registration', 'candoregfolup')) {?>
                                                                                                                     <div class="col-sm">
                                                                                                                          <div class="col-md-6 col-sm-12 col-xs-12">
                                                                                                                               <div class="x_panel">
                                                                                                                                    <!-- -->
                                                                                                                                    <?php if (!empty($regFollowups)) {?>
                                                                                                                                         <div style="height: 150px;overflow-x: hidden;overflow-y: scroll;">
                                                                                                                                              <?php foreach ($regFollowups as $fkey => $fvalue) {?>
                                                                                                                                                   <div style="float: left;width: 100%; font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;margin-bottom: 10px;">
                                                                                                                                                        <p class="excerpt">Remarks : <?php echo isset($fvalue['regf_desc']) ? $fvalue['regf_desc'] : '';?></p>
                                                                                                                                                        <p class="excerpt">Followup date : <?php echo isset($fvalue['regf_next_folowup']) ? date('d-m-Y h:i A', strtotime($fvalue['regf_next_folowup'])) : '';?></p>
                                                                                                                                                        <p class="excerpt" style="float: right;">Added on : <?php echo isset($fvalue['regf_added_on']) ? $fvalue['regf_added_on'] : '';?></p>
                                                                                                                                                   </div>
                                                                                                                                              <?php }?>
                                                                                                                                         </div>
                                                                                                                                    <?php }?>
                                                                                                                                    <!-- -->
                                                                                                                                    <form class="x_content frmRegisterFollowup" method="post" action="<?php echo site_url('enquiry/setRegisterFollowup');?>">
                                                                                                                                         <input type="hidden" name="vreg_assigned_to" value="<?php echo $dvalue['vreg_assigned_to'];?>"/>
                                                                                                                                         <input type="hidden" name="vreg_added_by" value="<?php echo $dvalue['vreg_added_by'];?>"/>
                                                                                                                                         <input type="hidden" name="regfoll[regf_reg_id]" value="<?php echo $dvalue['vreg_id'];?>"/>
                                                                                                                                         <input type="hidden" name="regfoll[regf_added_by]" value="<?php echo $this->uid;?>"/>
                                                                                                                                         <input type="hidden" name="regfoll[regf_added_on]" value="<?php echo date('Y-m-d H:i:s');?>"/>

                                                                                                                                         <div class="form-group" style="width: 100%;float: left;">
                                                                                                                                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Call type <span class="required">*</span></label>
                                                                                                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                                   <select required class="select2_group form-control cmbContactMode" name="regfoll[regf_reson]" id="vreg_contact_mode">
                                                                                                                                                        <option value="">Call type</option>
                                                                                                                                                        <?php
                                                                                                                                                        foreach (unserialize(CALL_TYPE) as $tkey => $tvalue) {
                                                                                                                                                             ?>
                                                                                                                                                             <option value="<?php echo $tkey;?>"><?php echo $tvalue;?></option>
                                                                                                                                                             <?php
                                                                                                                                                        }
                                                                                                                                                        ?>
                                                                                                                                                   </select>
                                                                                                                                              </div>
                                                                                                                                         </div>

                                                                                                                                         <div class="form-group" style="width: 100%;float: left;">
                                                                                                                                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Followup <span class="required">*</span></label>
                                                                                                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                                   <textarea required name="regfoll[regf_desc]" class="form-control col-md-5 col-xs-12"></textarea>
                                                                                                                                              </div>
                                                                                                                                         </div>

                                                                                                                                         <div class="form-group" style="width: 100%;float: left;">
                                                                                                                                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Next followup date <span class="required">*</span></label>
                                                                                                                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                                   <input autocomplete="off" type="text" name="regfoll[regf_next_folowup]" class="form-control col-md-5 col-xs-12 dtpDateTimePickerRegFollowup" 
                                                                                                                                                          required value="<?php echo date('Y-m-d H:i:A');?>"/>
                                                                                                                                              </div>
                                                                                                                                         </div>
                                                                                                                                         <div class="form-group" style="width: 100%;float: left;text-align: center;">
                                                                                                                                              <div>
                                                                                                                                                   <button class="btn btn-primary btnSubmitRegFollowup" type="submit">Set followup</button>
                                                                                                                                              </div>
                                                                                                                                         </div>
                                                                                                                                    </form>
                                                                                                                               </div>
                                                                                                                          </div>
                                                                                                                     </div>
                                                                                                                <?php }?>
                                                                                                           </div>
                                                                                                           <?php if (check_permission('registration', 'canretnregister')) {?>
                                                                                                                <div class="row" style="text-align: center;font-weight: bolder;font-size: 25px;">OR</div>
                                                                                                                <form method="post" class="row" action="<?php echo site_url($controller . '/sendBackRegister');?>">
                                                                                                                     <input type="hidden" name="assignedTo" value="<?php echo $dvalue['vreg_added_by']?>"/>
                                                                                                                     <input type="hidden" name="assignedFrom" value="<?php echo $dvalue['vreg_assigned_to']?>"/>
                                                                                                                     <input type="hidden" name="regMaster" value="<?php echo $dvalue['vreg_id']?>"/>

                                                                                                                     <div class="col-md-6 col-sm-12 col-xs-12">
                                                                                                                          <div class="x_panel">
                                                                                                                               <div class="form-group">
                                                                                                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Call type <span class="required">*</span></label>
                                                                                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                         <select required class="select2_group form-control cmbContactMode" name="call_type" id="vreg_contact_mode">
                                                                                                                                              <option value="">Call type</option>
                                                                                                                                              <?php
                                                                                                                                              foreach (unserialize(CALL_TYPE) as $ttkey => $ttvalue) {
                                                                                                                                                   ?>
                                                                                                                                                   <option value="<?php echo $ttkey;?>"><?php echo $ttvalue;?></option>
                                                                                                                                                   <?php
                                                                                                                                              }
                                                                                                                                              ?>
                                                                                                                                         </select>
                                                                                                                                    </div>
                                                                                                                               </div>
                                                                                                                          </div>
                                                                                                                     </div>
                                                                                                                </form>
                                                                                                           <?php }?>
                                                                                                      </div>
                                                                                                 </div>
                                                                                            </div>
                                                                                       </div>
                                                                                  </div>
                                                                             <?php }?>
                                                                        </td>
                                                                        <?php if (check_permission('registration', 'reassignstockmatching')) {?>
                                                                           <td><a href="<?php echo site_url("registration/reassignStockMatching/" . $regId); ?>"><i class="fa fa-repeat"></i></a></td>
                                                                        <?php } ?>
                                                                   </tr>
                                                              <?php }?>
                                                         </tbody>
                                                    </table>
                                               </div>
                                               <?php
                                          }
                                        ?>
                                   </div>
                                   <div role="tabpanel" class="tab-pane fade" id="tab_website" aria-labelledby="dar-tab">
                                        <?php
                                          foreach ($datas['smart'] as $key => $value) {
                                               $demandedVehicle = $this->registration->getRelatedVehicle($value['prd_brand'], $value['prd_model'], $value['prd_variant'],$_GET);
                                               $vehPrice = !empty($value['prd_price']) ? preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $value['prd_price']) : 0;
                                               ?>
                                               <div style="float: left; width: 100%;overflow-x: scroll;overflow-y: hidden;">
                                                    <h3><?php echo $value['brd_title'] . ',' . $value['mod_title'] . ',' . $value['var_variant_name'];?></h3>
                                                    <table class="datatable-resp table table-striped table-bordered">
                                                         <thead>
                                                              <tr>
                                                                   <th>Entry date</th>
                                                                   <th>Customer name</th>
                                                                   <th>Contact</th>
                                                                   <th>Place</th>
                                                                   <th>Contact mode</th>
                                                                   <th>Event</th>
                                                                   <th>Brand</th>
                                                                   <th>Model</th>
                                                                   <th>Variant</th>
                                                                   <th>Price</th>
                                                                   <th>Year</th>
                                                                   <th>Investment</th>
                                                                   <th>Added on</th>
                                                                   <th>Assigned to</th>
                                                                   <th>Added by</th>
                                                                   <th>Call type</th>
                                                                   <th>Comments</th>
                                                                   <th>Sales officer comment</th>
                                                                   <?php if (check_permission('registration', 'reassignstockmatching')) {?>
                                                                      <th>Action</th>
                                                                   <?php } ?>
                                                              </tr>
                                                         </thead>
                                                         <tbody>
                                                              <?php foreach ((array) $demandedVehicle as $dk => $dvalue) {
                                                                   $regId = encryptor($dvalue['vreg_id']);
                                                                   ?>
                                                                   <tr style="<?php echo ($dvalue['vreg_status'] == 0) ? 'color: #fff;background-color: red;' : '';?>"
                                                                       data-url="<?php echo site_url($controller . '/view/' . encryptor($dvalue['vreg_id']));?>">
                                                                        <td class="trVOE"><?php echo date('j M Y', strtotime($dvalue['vreg_entry_date']));?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_cust_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_cust_phone'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_cust_place'];?></td>
                                                                        <td class="trVOE">
                                                                             <?php
                                                                             $modes = unserialize(MODE_OF_CONTACT);
                                                                             echo isset($modes[$dvalue['vreg_contact_mode']]) ? $modes[$dvalue['vreg_contact_mode']] : '';
                                                                             ?>
                                                                        </td>
                                                                        <td class="trVOE"><?php echo $dvalue['evnt_title'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['brd_title'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['mod_title'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['var_variant_name'];?></td>
                                                                        <td class="trVOE"><?php echo get_in_currency_format($value['prd_price']);?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_year'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_investment'];?></td>
                                                                        <td class="trVOE"><?php echo date('j M Y', strtotime($dvalue['vreg_added_on']));?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['assign_usr_first_name'] . ' ' . $dvalue['assign_usr_last_name'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['addedby_usr_first_name'] . ' ' . $dvalue['addedby_usr_last_name'];?></td>
                                                                        <td>
                                                                             <?php
                                                                             $callTypes = unserialize(CALL_TYPE);
                                                                             echo isset($callTypes[$dvalue['vreg_call_type']]) ? $callTypes[$dvalue['vreg_call_type']] : '';
                                                                             ?>
                                                                        </td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_customer_remark'];?></td>
                                                                        <td class="trVOE"><?php echo $dvalue['vreg_last_action'];?></td>
                                                                        <?php if (check_permission('registration', 'reassignstockmatching')) {?>
                                                                           <td><a href="<?php echo site_url("registration/reassignStockMatching/" . $regId); ?>"><i class="fa fa-repeat"></i></a></td>
                                                                        <?php } ?>
                                                                   </tr>
                                                              <?php }?>
                                                         </tbody>
                                                    </table>
                                               </div>
                                               <?php
                                          }
                                        ?>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
<style>
     .table>thead>tr>th {
          white-space: nowrap;
          width: 1%;
     }
     .table>tbody>tr>td {
          white-space: nowrap;
          width: 1%;
     }
</style>