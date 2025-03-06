<div class="right_col" role="main">     
     <div class="row">          
          <div class="col-md-12 col-sm-12 col-xs-12">               
               <div class="x_panel">                    
                    <div class="x_title">                         
                         <h2>My register</h2>                         
                         <div style="float: right;">                              
                              <a href="<?php echo site_url($controller . '/myregister?type=ex');?>">
                                   <i class="fa fa-circle" style="color: #003580;"> Existing </i>
                              </a>                              
                              <a href="<?php echo site_url($controller . '/myregister?type=nw');?>">
                                   <i class="fa fa-circle" style="color: red;"> New </i>
                              </a>                              
                              <a href="<?php echo site_url($controller . '/myregister');?>">
                                   <i class="fa fa-circle" style="color: black;"> All </i>
                              </a>                         
                         </div>                         
                         <div class="clearfix"></div>                    
                    </div>
                    <div class="row">
                         <div class="col-md-12 col-sm-12 ">
                              <div class="x_panel">
                                   <div class="x_title">
                                        <h2>Register analysis</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                             <li style="float: right;">
                                                  <?php if (check_permission('enquiry', 'export_excel')) { ?>
                                                       <a href="<?php echo site_url('enquiry/export_excel?' . $_SERVER['QUERY_STRING']); ?>">
                                                            <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                                       </a>
                                                  <?php } ?>
                                             </li>
                                             <li style="float:right;"><a 
                                                       data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" 
                                                       aria-controls="collapseExample"><i class="fa fa-chevron-up"></i>
                                                       <i class="fa fa-chevron-down"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                   </div>
                                   <div class="x_content collapse" id="collapseExample">
                                   <?php if (check_permission('enquiry', 'myregistercallanalysis')) {?>
                                        <h2>Todays calls analysis</h2>
                                        <div class="x_content">
                                             <table class="table table-striped table-bordered">
                                                  <tbody>
                                                       <?php
                                                       if (!empty($tc)) {
                                                            foreach ($tc as $key => $value) {
                                                                 $mod = unserialize(MODE_OF_CONTACT);
                                                                 if (!empty($value['analysis'])) {
                                                                      ?>
                                                                      <tr>
                                                                           <td>
                                                                                <?php echo $value['col_title'];?>
                                                                           </td>
                                                                           <td class="bold-text">
                                                                                <?php foreach ($value['analysis'] as $k => $val) {
                                                                                     ?> <span><?php echo $mod[$val['vreg_contact_mode']];?></span> : 
                                                                                     <span><?php echo $val['cnt'];?></span> <?php
                                                                                }
                                                                                ?>
                                                                           </td>
                                                                      </tr>
                                                                      <?php
                                                                 }
                                                            }
                                                       }
                                                       ?>
                                                  </tbody>
                                             </table>
                                        </div>
                                   <?php } if (is_roo_user() && !empty($staff)) { ?>
                                        <div class="x_content">
                                             <table class="table table-striped table-bordered">
                                                  <tbody>
                                                       <?php foreach ($staff as $key => $rgvalue) {
                                                            $stf = $this->enquiry->regPendingCount($rgvalue['user_id']);
                                                            ?>
                                                            <tr>
                                                                 <td><?php echo $rgvalue['col_title'];?></td>
                                                                 <td class="bold-text"><?php echo count($stf);?></td>
                                                            </tr>
                                                            <?php
                                                       }
                                                       ?>
                                                  </tbody>
                                             </table>
                                        </div>
                                        <?php
                                   }?>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="x_content">
                         <?php
                           $currentURL = current_url();
                           $params = $_SERVER['QUERY_STRING'];
                           $fullURL = $currentURL . '?' . $params;
                         ?>
                         <form action="<?php echo $fullURL;?>" method="get">
                              <input type="hidden" name="type" value="<?php echo isset($_GET['type']) ? $_GET['type'] : '';?>"/>
                              <table>
                                   <tr>
                                        <td>
                                             <select class="select2_group form-control" name="vreg_department">
                                                  <option value="">Select Departments</option>
                                                  <?php
                                                    foreach ($departments as $key => $value) {
                                                         $selected = (isset($_GET['vreg_department']) && ($_GET['vreg_department'] == $value['dep_id'])) ? 'selected="selected"' : '';
                                                         ?>
                                                         <option <?php echo $selected;?>
                                                              value="<?php echo $value['dep_id'];?>"><?php echo $value['dep_name'] . ' (' . $value['div_name'] . ')';?></option>
                                                         <?php }?>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control" name="vreg_call_type">
                                                  <option value="">Select Lead type</option>
                                                  <?php
                                                    foreach (unserialize(CALL_TYPE) as $key => $value) {
                                                         $selected = (isset($_GET['vreg_call_type']) && ($_GET['vreg_call_type'] == $key)) ? 'selected="selected"' : '';
                                                         ?>
                                                         <option <?php echo $selected;?> value="<?php echo $key;?>"><?php echo $value;?></option><?php
                                                    }
                                                  ?>
                                             </select>
                                        </td>

                                        <td>
                                             <select class="select2_group form-control" name="vreg_contact_mode">
                                                  <option value="">Mode of contact</option>
                                                  <?php
                                                    foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                                         $selected = (isset($_GET['vreg_contact_mode']) && ($_GET['vreg_contact_mode'] == $key)) ?
                                                                 'selected="selected"' : '';
                                                         ?>
                                                         <option <?php echo $selected;?> value="<?php echo $key;?>"><?php echo $value;?></option><?php
                                                    }
                                                  ?>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control" name="vreg_is_effective">
                                                  <option value="">All</option>
                                                  <option <?php echo (isset($_GET['vreg_is_effective']) && ($_GET['vreg_is_effective'] == '1')) ? 'selected="selected"' : '';?>
                                                       value="1">Effective call</option>
                                                  <option <?php echo (isset($_GET['vreg_is_effective']) && ($_GET['vreg_is_effective'] == '0')) ? 'selected="selected"' : '';?>
                                                       value="0">Ineffective call</option>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control" name="added_entry">
                                                  <option value="">Added/Entry date</option>
                                                  <option value="vreg_added_on" <?php echo (isset($_GET['added_entry']) && $_GET['added_entry'] == 'vreg_added_on') ? 'selected="selected"' : '';?>>Added date</option>
                                                  <option value="vreg_entry_date" <?php echo (isset($_GET['added_entry']) && $_GET['added_entry'] == 'vreg_entry_date') ? 'selected="selected"' : '';?>>Entry date</option>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control" name="hhpwc">
                                                  <option value="">Please select customer status</option>
                                                       <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $key => $value) { ?>
                                                            <option value="<?php echo $key; ?>" <?php echo (isset($_GET['hhpwc']) && ($_GET['hhpwc'] == $key)) ? 'selected="selected"' : ''; ?>>
                                                            <?php echo $value; ?></option>
                                                  <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <input autocomplete="off" name="vreg_added_on_fr" type="text" class="dtpDatePickerDMY form-control col-md-7 col-xs-12" 
                                                    placeholder="Date from" value="<?php echo isset($_GET['vreg_added_on_fr']) ? $_GET['vreg_added_on_fr'] : '';?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <input autocomplete="off" name="vreg_added_on_to" type="text" class="dtpDatePickerDMY form-control col-md-7 col-xs-12" 
                                                    placeholder="Date to" value="<?php echo isset($_GET['vreg_added_on_to']) ? $_GET['vreg_added_on_to'] : '';?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>
                                             <select data-url="<?php echo site_url('enquiry/bindModel');?>" data-bind="cmbEvModel" 
                                                     data-dflt-select="Select Model" class="cmbBrand select2_group form-control bindToDropdown" name="vreg_brand" id="vreg_brand">
                                                  <option value="">Select Brand</option>
                                                  <?php
                                                    if (!empty($brand)) {
                                                         foreach ($brand as $key => $value) {
                                                              ?>
                                                              <option value="<?php echo $value['brd_id'];?>"><?php echo $value['brd_title'];?></option>
                                                              <?php
                                                         }
                                                    }
                                                  ?>
                                             </select>
                                        </td>
                                        <td>
                                             <select data-url="<?php echo site_url('enquiry/bindVarient');?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                     class="cmbEvModel select2_group form-control bindToDropdown" name="vreg_model" id="vreg_model">
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control cmbEvVariant" name="vreg_varient" id="vreg_varient"></select>
                                        </td>
                                        <?php if (check_permission('enquiry', 'myregisterassignaddedfilter')) { ?>
                                             <td>
                                                  <select class="select2_group form-control enq_se_id" name="vreg_assigned_to">
                                                       <option value="">Assign to</option>
                                                       <?php foreach ($staff as $key => $value) { ?>
                                                            <option value="<?php echo $value['col_id']; ?>"
                                                                    <?php echo (isset($_GET['vreg_assigned_to']) && ($_GET['vreg_assigned_to'] == $value['col_id'])) ? 'selected="selected"' : '';?>><?php echo $value['col_title']; ?></option>                                               
                                                       <?php } ?>
                                                  </select>
                                             </td>
                                             <td>
                                                  <select class="select2_group form-control enq_se_id" name="vreg_first_owner">
                                                       <option value="">Added by</option>
                                                       <?php foreach ($teleCallers as $key => $value) { ?>
                                                            <option value="<?php echo $value['col_id']; ?>"
                                                                    <?php echo (isset($_GET['vreg_first_owner']) && ($_GET['vreg_first_owner'] == $value['col_id'])) ? 'selected="selected"' : '';?>><?php echo $value['col_title']; ?></option>                                               
                                                       <?php } ?>
                                                  </select>
                                             </td>
                                        <?php } ?>
                                   </tr>
                              </table>
                         </form>
                    </div>       
                    <!-- -->
                    <div class="x_content">
                         <form method="get">
                              <table>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="search" type="text" class="form-control col-md-7 col-xs-12" 
                                                    placeholder="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '';?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Search</button>
                                        </td>
                                   </tr>
                              </table>
                         </form>
                    </div>
                    <div class="x_content">
                         <div style="width: 100%;overflow-x: scroll;">
                              <table class="table table-striped table-bordered">                              
                                   <thead>
                                        <tr>
                                             <th>Entry date</th>
                                             <th>Customer name</th>
                                             <th>Customer status</th>
                                             <th>Contact</th>
                                             <th>Place</th>
                                             <th>Disctrict</th>
                                             <th>Contact mode</th>
                                             <th>Event</th>
                                             <th>Brand</th>
                                             <th>Model</th>
                                             <th>Variant</th>
                                             <th>Year</th>
                                             <th>Investment</th>
                                             <th>Added on</th>
                                             <th>Status</th>
                                             <th>Call type</th>
                                             <td>Department</td>
                                             <?php if (check_permission('registration', 'showassignto')) {?>        
                                                    <th>Assigned to</th>
                                               <?php }?>
                                             <th>Added by</th>
                                             <?php if (check_permission('registration', 'candelete')) {?>        
                                                    <th>Delete</th>
                                               <?php } if (check_permission('registration', 'alloworeassign')) {?>
                                                    <th>Punch</th>
                                               <?php }?>
                                             <td>Remarks</td>
                                             <td>Punched on</td>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                          $colspan = 16;

                                          if (!empty($datas)) {
                                               foreach ((array) $datas as $key => $value) {
                                                    $regFollowups = $this->enquiry->regFollowups($value['vreg_id']);
                                                    $remarks = strip_tags($value['vreg_customer_remark']);
                                                    $url = '';
                                                    //if ($value['vreg_is_verified']) {
                                                    $url = !empty($value['vreg_inquiry']) ?
                                                            site_url('followup/viewFollowup/' . encryptor($value['vreg_inquiry'])) : site_url($controller . '/regiter_2_inquiry/' . encryptor($value['vreg_id']));
                                                    //}
                                                    $color = 'color: #fff';
                                                    $bgColor = '';
                                                    $canPunch = 1;
                                                    if (empty($value['vreg_inquiry'])) {
                                                         $bgColor = 'red';
                                                    } else if ($value['vreg_is_verified'] != 1) {
                                                         $bgColor = '#4c3000';
                                                         $canPunch = 0;
                                                    } else {
                                                         $bgColor = '#004099';
                                                    }

                                                    $trVOE = '';
                                                    if (check_permission('registration', 'caneditmyregister') || $this->usr_grp == 'AD') {
                                                         $trVOE = 'trVOE';
                                                    }
                                                    ?>
                                                    <tr data-url="<?php echo site_url('registration/view/' . encryptor($value['vreg_id']));?>"
                                                        style="<?php echo $color;?>;background-color: <?php echo $bgColor;?>">
                                                         <td style="wid">
                                                              <?php if ($value['vreg_is_effective'] == 1) {?><i title="Effective call" style="color: green;" class="fa fa-check"></i> <?php }?>
                                                              <?php echo date('j M Y', strtotime($value['vreg_entry_date']));?>
                                                         </td>
                                                         <td><?php echo $value['vreg_cust_name'];?></td>
                                                         <td>
                                                            <?php $stsMods = unserialize(ENQUIRY_UP_STATUS);
                                                                  echo $stsMods = isset($stsMods[$value['vreg_customer_status']]) ? $stsMods[$value['vreg_customer_status']] : ''; 
                                                            ?>
                                                         </td>
                                                         <td><a style="color: #fff;" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $value['vreg_cust_phone'];?>"><?php echo $value['vreg_cust_phone'];?></a></td>
                                                         <td><?php echo $value['vreg_cust_place'];?></td>
                                                         <td><?php echo $value['std_district_name'];?></td>
                                                         <td>
                                                              <?php
                                                              $modes = unserialize(MODE_OF_CONTACT);
                                                              echo isset($modes[$value['vreg_contact_mode']]) ? $modes[$value['vreg_contact_mode']] : '';
                                                              ?>                                               
                                                         </td>
                                                         <td><?php echo $value['evnt_title'];?></td>
                                                         <td><?php echo $value['brd_title'];?></td>
                                                         <td><?php echo $value['mod_title'];?></td>
                                                         <td><?php echo $value['var_variant_name'];?></td>
                                                         <td><?php echo $value['vreg_year'];?></td>
                                                         <td><?php echo $value['vreg_investment'];?></td>
                                                         <td><?php echo date('j M Y', strtotime($value['vreg_added_on']));?></td>
                                                         <td><?php echo ($value['vreg_is_verified'] == 1) ? 'Verified' : 'Pending';?></td>
                                                         <td>
                                                              <?php
                                                              $callTypes = unserialize(CALL_TYPE);
                                                              echo isset($callTypes[$value['vreg_call_type']]) ? $callTypes[$value['vreg_call_type']] : '';
                                                              ?>
                                                         </td>
                                                         <td><?php echo $value['dep_name'];?></td>
                                                         <?php if (check_permission('registration', 'showassignto')) {?>        
                                                              <td><?php echo $value['assign_usr_first_name'];?></td>
                                                         <?php }?>
                                                         <td><?php echo $value['addedby_usr_first_name'];?>
                                                              <?php if ($value['vreg_last_action']) {?>
                                                                   <i class="fa fa-comment" style="color: #fff;" title="<?php echo $value['vreg_last_action'];?>"></i>
                                                              <?php }?>
                                                         </td>
                                                         <?php
                                                         if (check_permission('registration', 'candelete')) {
                                                              $colspan = $colspan + 1;
                                                              ?>    
                                                              <td>
                                                                   <a class="pencile deleteListItem" href="javascript:void(0);" data-url="<?php echo site_url('registration/delete/' . $value['vreg_id']);?>">  
                                                                        <i class="fa fa-remove"></i>
                                                                   </a>
                                                              </td>
                                                         <?php } if (check_permission('registration', 'alloworeassign') && ($canPunch == 1)) {?>
                                                              <td>
                                                                   <div onclick="$('#<?php echo $value['vreg_id'];?>').modal({backdrop: false});"><i class="fa fa-pencil-square" data-toggle="modal" data-target="#<?php //echo $value['vreg_id'];?>"></i></div>
                                                                   <div class="modal fade divModel" id="<?php echo $value['vreg_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog" role="document" style="width: 100%;">
                                                                             <div class="modal-content" style="color: black;">
                                                                                  <div class="modal-header">
                                                                                       <h5 style="width: 66px;float: left;" class="modal-title" id="exampleModalLabel">Modal title</h5>
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
                                                                                                                <div class="row" style="text-align: center;font-weight: bolder;font-size: 18px;">Followup/New enquiry</div>
                                                                                                                     <div class="form-group" style="width: 100%;float: left;white-space: normal;">
                                                                                                                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer name</label>
                                                                                                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                               <?php echo $value['vreg_cust_name'];?>
                                                                                                                          </div>
                                                                                                                     </div>

                                                                                                                     <div class="form-group" style="width: 100%;float: left;white-space: normal;">
                                                                                                                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer contact</label>
                                                                                                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                               <a style="color: #000;" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $value['vreg_cust_phone'];?>"><?php echo $value['vreg_cust_phone'];?></a>
                                                                                                                          </div>
                                                                                                                     </div>

                                                                                                                     <div class="form-group" style="width: 100%;float: left;white-space: normal;">
                                                                                                                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                                                                                                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                               <?php echo $value['vreg_cust_place'];?>
                                                                                                                          </div>
                                                                                                                     </div>

                                                                                                                     <div class="form-group" style="width: 100%;float: left;white-space: normal;">
                                                                                                                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer feedback</label>
                                                                                                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                               <?php echo $value['vreg_customer_remark'];?>
                                                                                                                          </div>
                                                                                                                     </div>

                                                                                                                     <div class="form-group" style="width: 100%;float: left;white-space: normal;">
                                                                                                                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Assigned by</label>
                                                                                                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                               <?php echo $value['addedby_usr_first_name'] . ' ' . $value['addedby_usr_last_name'];?>
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
                                                                                                                     <div class="form-group" style="width: 100%;float: left;white-space: normal;">
                                                                                                                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Other remark</label>
                                                                                                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                               <?php echo $value['vreg_last_action'];?>
                                                                                                                          </div>
                                                                                                                     </div>
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
                                                                                                                                    <?php }?>
                                                                                                                               </tbody>
                                                                                                                          </table>
                                                                                                                     </div>
                                                                                                                <?php } if (check_permission('registration', 'canpnchenqorfolup')) {?>
                                                                                                                     <div class="row" style="text-align: center;float: left;">
                                                                                                                          <div>
                                                                                                                               <?php $txtPunch = !empty($value['vreg_inquiry']) ? 'Followup' : 'Punch to enquiry';?>
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
                                                                                                                     <form class="x_content frmRegisterFollowup" method="post" action="<?php echo site_url($controller . '/setRegisterFollowup');?>">
                                                                                                                          <h3 style="text-align: center;font-weight: bold;">Set followup</h3>
                                                                                                                          <input type="hidden" name="vreg_assigned_to" value="<?php echo $value['vreg_assigned_to'];?>"/>
                                                                                                                          <input type="hidden" name="vreg_added_by" value="<?php echo $value['vreg_added_by'];?>"/>
                                                                                                                          <input type="hidden" name="regfoll[regf_reg_id]" value="<?php echo $value['vreg_id'];?>"/>
                                                                                                                          <input type="hidden" name="regfoll[regf_added_by]" value="<?php echo $this->uid;?>"/>
                                                                                                                          <input type="hidden" name="regfoll[regf_added_on]" value="<?php echo date('Y-m-d H:i:s');?>"/>

                                                                                                                          <div class="form-group" style="width: 100%;float: left;">
                                                                                                                               <label class="control-label col-md-3 col-sm-3 col-xs-12">Call type <span class="required">*</span></label>
                                                                                                                               <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                    <select required class="select2_group form-control cmbContactMode" name="regfoll[regf_reson]" id="vreg_contact_mode">
                                                                                                                                         <option value="">Call type</option>
                                                                                                                                         <option value="3">Call not attend</option>
                                                                                                                                         <option value="12">Line busy</option>
                                                                                                                                         <option value="13">Not reachable</option>
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
                                                                                                                                           required value="<?php echo date('d-m-Y h:i:A');?>"/>
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

                                                                                            <div class="col-sm">
                                                                                               <div class="col-md-6 col-sm-12 col-xs-12">
                                                                                                    <div class="x_panel">             
                                                                                                         <?php 
                                                                                                         //if (($value['vreg_next_followup_cont'] >= 5) || $this->usr_grp == 'TL' || $this->usr_grp == 'TC'  || $this->usr_grp == 'AD') {?>
                                                                                                         <?php if (check_permission('registration', 'canretnregister')) {?>
                                                                                                              <div class="row" style="text-align: center;font-weight: bolder;font-size: 18px;">Re-assign to CRE</div>
                                                                                                              <form method="post" class="row" action="<?php echo site_url($controller . '/sendBackRegister');?>">
                                                                                                                   <input type="hidden" name="assignedTo" value="<?php echo $value['vreg_added_by']?>"/>
                                                                                                                   <input type="hidden" name="assignedFrom" value="<?php echo $value['vreg_assigned_to']?>"/>
                                                                                                                   <input type="hidden" name="regMaster" value="<?php echo $value['vreg_id']?>"/>

                                                                                                                   <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                                                        <div class="x_panel">
                                                                                                                             <div class="form-group" style="width: 100%;float: left;">
                                                                                                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Call type <span class="required">*</span></label>
                                                                                                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                       <select required class="select2_group form-control cmbContactMode" name="call_type" id="vreg_contact_mode">
                                                                                                                                            <option value="">Call type</option>
                                                                                                                                            <?php
                                                                                                                                            foreach (unserialize(CALL_TYPE) as $key => $ctvalue) {
                                                                                                                                                 ?>
                                                                                                                                                 <option value="<?php echo $key;?>"><?php echo $ctvalue;?></option>
                                                                                                                                                 <?php
                                                                                                                                            }
                                                                                                                                            ?>
                                                                                                                                       </select>
                                                                                                                                  </div>
                                                                                                                             </div>
                                                                                                                             <div class="form-group" style="width: 100%;float: left;">
                                                                                                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Reason for send back <span class="required">*</span>
                                                                                                                                  </label>
                                                                                                                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                       <textarea required name="reason" class="form-control col-md-5 col-xs-12 "></textarea>
                                                                                                                                  </div>
                                                                                                                             </div>
                                                                                                                             <div class="modal-footer" style="float: left;width: 100%;text-align: center;">
                                                                                                                                  <button type="submit" class="btn btn-primary">Reassign to telecaller</button>
                                                                                                                             </div>
                                                                                                                        </div>
                                                                                                                   </div>
                                                                                                              </form>
                                                                                                              <?php }?>
                                                                                                         <?php //} else {?>
                                                                                                              <!-- <span>You can reassign register after five followup only, 
                                                                                                              if you are want to reassign immediately please inform your TC or TL</span>-->
                                                                                                         <?php //} ?>
                                                                                                    </div>
                                                                                               </div>
                                                                                               <?php if (check_permission('registration', 'allowquickdropregister')) {?>
                                                                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                                                                         <div class="x_panel">
                                                                                                              <div class="x_content">
                                                                                                                   <div class="row" style="text-align: center;font-weight: bolder;font-size: 18px;">Drop register</div>
                                                                                                                        <form method="post" action="<?php echo site_url('registration/changeRegisterStatus'); ?>" 
                                                                                                                             class="row frmRequestForDrop">
                                                                                                                             <input type="hidden" name="regMaster" value="<?php echo $value['vreg_id']; ?>"/>
                                                                                                                             <input type="hidden" name="status" value="<?php echo reg_droped; ?>"/>
                                                                                                                             <input type="hidden" name="callback" value="enquiry/myregister"/>
                                                                                                                             <!-- -->
                                                                                                                             <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                                                                  <div class="x_panel">
                                                                                                                                       <div class="form-group" style="width: 100%;float: left;">
                                                                                                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Reason for drop <span class="required">*</span>
                                                                                                                                            </label>
                                                                                                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                                                 <textarea required name="reason" class="txtDropRegReason form-control col-md-5 col-xs-12 "></textarea>
                                                                                                                                            </div>
                                                                                                                                       </div>
                                                                                                                                       <div class="modal-footer" style="float: left;width: 100%;text-align: center;">
                                                                                                                                            <input type="submit" class="btn btn-primary btnRequestForDrop" value="Drop register"/>
                                                                                                                                       </div>
                                                                                                                                  </div>
                                                                                                                             </div>
                                                                                                                        </form>
                                                                                                                   </div>
                                                                                                              </div>
                                                                                                         </div>
                                                                                                    </div>
                                                                                               <?php } ?>
                                                                                          </div>               
                                                                                       </div>
                                                                                  </div>
                                                                             </div>
                                                                        </div>
                                                                   </td>
                                                         <?php }?>
                                                         <td class="<?php echo $trVOE;?>"><?php echo $remarks;?></td>
                                                         <td style="wid">
                                                              <?php echo date('j M Y h:i A', strtotime($value['vreg_added_on']));?>
                                                         </td>
                                                    </tr>
                                                    <?php
                                               }
                                          } else {
                                               ?> 
                                               <tr>
                                                    <td style="text-align: center;" colspan="<?php echo $colspan;?>">No data available in table</td>
                                               </tr>
                                          <?php }?>
                                   </tbody>                         
                              </table>                         
                         </div>
                         <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex;?> to <?php echo $limit;?> of <?php echo $totalRow;?> entries</div>                         
                         <div style="float: right;">                              
                              <?php echo $links;?>                         
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