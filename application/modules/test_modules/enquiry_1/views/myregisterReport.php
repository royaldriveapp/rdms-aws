<div class="right_col" role="main">     
     <div class="row">          
          <div class="col-md-12 col-sm-12 col-xs-12">               
               <div class="x_panel">                    
                    <div class="x_title">                         
                         <h2>My register</h2>                         
                         <div style="float: right;">                              
                              <a href="javascript:;<?php //echo site_url($controller . '/myregisterReport?type=ex');        ?>">
                                   <i class="fa fa-circle" style="color: #003580;"> Existing </i>
                              </a>                              
                              <a href="javascript:;<?php //echo site_url($controller . '/myregisterReport?type=nw');        ?>">
                                   <i class="fa fa-circle" style="color: red;"> New </i>
                              </a>                              
                              <a href="javascript:;<?php //echo site_url($controller . '/myregisterReport');        ?>">
                                   <i class="fa fa-circle" style="color: black;"> All </i>
                              </a>  
                              <a href="javascript:;<?php //echo site_url($controller . '/myregisterReport');        ?>">
                                   <i class="fa fa-circle" style="color: #4EA929;"> Punched </i>
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
                                                       <a href="<?php echo site_url('enquiry/exportRegisterReportExl?' . $_SERVER['QUERY_STRING']); ?>">
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
                                        <?php if (check_permission('enquiry', 'myregistercallanalysis')) { ?>
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
                                                                                     <?php echo $value['col_title']; ?>
                                                                                </td>
                                                                                <td class="bold-text">
                                                                                     <?php foreach ($value['analysis'] as $k => $val) {
                                                                                          ?> <span><?php echo $mod[$val['vreg_contact_mode']]; ?></span> : 
                                                                                          <span><?php echo $val['cnt']; ?></span> <?php
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
                                             <?php
                                        } if (is_roo_user() && !empty($staff)) {
                                             $ttl = 0;
                                             ?>
                                             <div class="x_content">
                                                  <table class="table table-striped table-bordered">
                                                       <tbody>
                                                            <?php
                                                            foreach ($staff as $key => $rgvalue) {
                                                                 $stf = $this->enquiry->regPendingCount($rgvalue['user_id']);
                                                                 $ttl = $ttl + count($stf);
                                                                 ?>
                                                                 <tr>
                                                                      <td><?php echo $rgvalue['col_title']; ?></td>
                                                                      <td class="bold-text"><?php echo count($stf); ?></td>
                                                                 </tr>
                                                                 <?php
                                                            }
                                                            ?>
                                                            <tr>
                                                                 <td>Total</td>
                                                                 <td><?php echo $ttl; ?></td>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                             </div>
                                        <?php }
                                        ?>
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
                         <form action="<?php echo $fullURL; ?>" method="get">
                              <input type="hidden" name="type" value="<?php echo isset($_GET['type']) ? $_GET['type'] : ''; ?>"/>
                              <table>
                                   <tr>
                                        <td>
                                             <select class="select2_group form-control cmbBindShowroomByDivision" name="vreg_division" id="vreg_division"
                                                     data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom" 
                                                     data-dflt-select="Select Showroom">
                                                  <option value="">Select division</option>
                                                  <?php foreach ($division as $key => $value) { ?>
                                                       <option <?php
                                                       echo (isset($_GET['vreg_division']) && ($_GET['vreg_division'] == $value['div_id'])) ?
                                                               'selected="selected"' : '';
                                                       ?> value="<?php echo $value['div_id']; ?>"><?php echo $value['div_name']; ?></option>
                                                       <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control cmbShowroom shorm_stf" 
                                                     name="vreg_showroom" id="vreg_showroom">
                                                  <option value="">Select showroom</option>
                                                  <?php foreach ($showroom['associatedShowroom'] as $key => $value) { ?>
                                                       <option <?php
                                                       echo (isset($_GET['vreg_showroom']) && ($_GET['vreg_showroom'] == $value['col_id'])) ?
                                                               'selected="selected"' : '';
                                                       ?> value="<?php echo $value['col_id']; ?>"> <?php echo $value['col_title']; ?>
                                                       </option>
                                                  <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control" name="vreg_department">
                                                  <option value="">Select Departments</option>
                                                  <?php
                                                  foreach ($departments as $key => $value) {
                                                       $selected = (isset($_GET['vreg_department']) && ($_GET['vreg_department'] == $value['dep_id'])) ? 'selected="selected"' : '';
                                                       ?>
                                                       <option <?php echo $selected; ?>
                                                            value="<?php echo $value['dep_id']; ?>"><?php echo $value['dep_name'] . ' (' . $value['div_name'] . ')'; ?></option>
                                                       <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control" name="vreg_call_type">
                                                  <option value="">Select Lead type</option>
                                                  <?php
                                                  foreach (unserialize(CALL_TYPE) as $key => $value) {
                                                       $selected = (isset($_GET['vreg_call_type']) && ($_GET['vreg_call_type'] == $key)) ? 'selected="selected"' : '';
                                                       ?>
                                                       <option <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
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
                                                       <option <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
                                                  }
                                                  ?>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control" name="vreg_is_effective">
                                                  <option value="">All</option>
                                                  <option <?php echo (isset($_GET['vreg_is_effective']) && ($_GET['vreg_is_effective'] == '1')) ? 'selected="selected"' : ''; ?>
                                                       value="1">Effective call</option>
                                                  <option <?php echo (isset($_GET['vreg_is_effective']) && ($_GET['vreg_is_effective'] == '0')) ? 'selected="selected"' : ''; ?>
                                                       value="0">Ineffective call</option>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control" name="added_entry">
                                                  <option value="">Added/Entry date</option>
                                                  <option value="vreg_added_on" <?php echo (isset($_GET['added_entry']) && $_GET['added_entry'] == 'vreg_added_on') ? 'selected="selected"' : ''; ?>>Added date</option>
                                                  <option value="vreg_entry_date" <?php echo (isset($_GET['added_entry']) && $_GET['added_entry'] == 'vreg_entry_date') ? 'selected="selected"' : ''; ?>>Entry date</option>
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
                                                    placeholder="Date from" value="<?php echo isset($_GET['vreg_added_on_fr']) ? $_GET['vreg_added_on_fr'] : ''; ?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <input autocomplete="off" name="vreg_added_on_to" type="text" class="dtpDatePickerDMY form-control col-md-7 col-xs-12" 
                                                    placeholder="Date to" value="<?php echo isset($_GET['vreg_added_on_to']) ? $_GET['vreg_added_on_to'] : ''; ?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>
                                             <select data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbEvModel" 
                                                     data-dflt-select="Select Model" class="cmbBrand select2_group form-control bindToDropdown" name="vreg_brand" id="vreg_brand">
                                                  <option value="">Select Brand</option>
                                                  <?php
                                                  if (!empty($brand)) {
                                                       foreach ($brand as $key => $value) {
                                                            ?>
                                                            <option value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?></option>
                                                            <?php
                                                       }
                                                  }
                                                  ?>
                                             </select>
                                        </td>
                                        <td>
                                             <select data-url="<?php echo site_url('enquiry/bindVarient'); ?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                     class="cmbEvModel select2_group form-control bindToDropdown" name="vreg_model" id="vreg_model">
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control cmbEvVariant" name="vreg_varient" id="vreg_varient"></select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control enq_se_id" name="vreg_first_owner">
                                                  <option value="">First punched by</option>
                                                  <?php foreach ($totalActiveStaff as $key => $value) { ?>
                                                       <option value="<?php echo $value['usr_id']; ?>"
                                                               <?php echo (isset($_GET['vreg_first_owner']) && ($_GET['vreg_first_owner'] == $value['usr_id'])) ? 'selected="selected"' : ''; ?>><?php echo $value['usr_username']; ?></option>                                               
                                                          <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control enq_se_id" name="vreg_assigned_to">
                                                  <option value="">Assign to</option>
                                                  <?php foreach ($totalActiveStaff as $key => $value) { ?>
                                                       <option value="<?php echo $value['usr_id']; ?>"
                                                               <?php echo (isset($_GET['vreg_assigned_to']) && ($_GET['vreg_assigned_to'] == $value['usr_id'])) ? 'selected="selected"' : ''; ?>><?php echo $value['usr_username']; ?></option>                                               
                                                          <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control enq_se_id" name="vreg_added_by">
                                                  <option value="">Added by</option>
                                                  <?php foreach ($totalActiveStaff as $key => $value) { ?>
                                                       <option value="<?php echo $value['usr_id']; ?>"
                                                               <?php echo (isset($_GET['vreg_added_by']) && ($_GET['vreg_added_by'] == $value['usr_id'])) ? 'selected="selected"' : ''; ?>><?php echo $value['usr_username']; ?></option>                                               
                                                          <?php } ?>
                                             </select>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td colspan="2">
                                             <input type="checkbox" name="showallsts" value="1" 
                                                    <?php echo (isset($_GET['showallsts']) && !empty($_GET['showallsts'])) ? "checked" : ''; ?>/> &nbsp; Show all status 
                                        </td>
                                        <td colspan="2">
                                             <input type="checkbox" name="vreg_is_punched" value="1" 
                                                    <?php echo (isset($_GET['vreg_is_punched']) && !empty($_GET['vreg_is_punched'])) ? "checked" : ''; ?>/> &nbsp; Both punched and pending 
                                        </td>
                                   </tr>
                              </table>
                         </form>
                    </div>
                    <div class="x_content">
                         <form method="get">
                              <table>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="search" type="text" class="form-control col-md-7 col-xs-12" 
                                                    placeholder="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"/>
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
                                             <th>District</th>
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
                                             <th>Added by</th>
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
                                                  $color = 'color: #fff';
                                                  $bgColor = '';
                                                  $canPunch = 1;
                                                  if (empty($value['vreg_inquiry'])) {
                                                       $bgColor = 'red';
                                                  } else if ($value['vreg_is_verified'] != 1) {
                                                       $bgColor = '#4c3000';
                                                       $canPunch = 0;
                                                  } else if ($value['vreg_is_punched'] == 1) {
                                                       $bgColor = '#4EA929';
                                                  } else {
                                                       $bgColor = '#004099';
                                                  }

                                                  $trVOE = '';
                                                  if (check_permission('registration', 'caneditmyregister') || $this->usr_grp == 'AD') {
                                                       $trVOE = 'trVOE';
                                                  }
                                                  ?>
                                                  <tr style="<?php echo $color; ?>;background-color: <?php echo $bgColor; ?>">
                                                       <td style="wid">
                                                            <?php if ($value['vreg_is_effective'] == 1) { ?><i title="Effective call" style="color: green;" class="fa fa-check"></i> <?php } ?>
                                                            <?php echo date('j M Y', strtotime($value['vreg_entry_date'])); ?>
                                                       </td>
                                                       <td><?php echo $value['vreg_cust_name']; ?></td>
                                                       <td>
                                                            <?php
                                                            $stsMods = unserialize(ENQUIRY_UP_STATUS);
                                                            echo $stsMods = isset($stsMods[$value['vreg_customer_status']]) ? $stsMods[$value['vreg_customer_status']] : '';
                                                            ?>
                                                       </td>
                                                       <td><a style="color: #fff;" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $value['vreg_cust_phone']; ?>"><?php echo $value['vreg_cust_phone']; ?></a></td>
                                                       <td><?php echo $value['vreg_cust_place']; ?></td>
                                                       <td><?php echo $value['std_district_name']; ?></td>
                                                       <td>
                                                            <?php
                                                            $modes = unserialize(MODE_OF_CONTACT);
                                                            echo isset($modes[$value['vreg_contact_mode']]) ? $modes[$value['vreg_contact_mode']] : '';
                                                            ?>                                               
                                                       </td>
                                                       <td><?php echo $value['evnt_title']; ?></td>
                                                       <td><?php echo $value['brd_title']; ?></td>
                                                       <td><?php echo $value['mod_title']; ?></td>
                                                       <td><?php echo $value['var_variant_name']; ?></td>
                                                       <td><?php echo $value['vreg_year']; ?></td>
                                                       <td><?php echo $value['vreg_investment']; ?></td>
                                                       <td><?php echo date('j M Y', strtotime($value['vreg_added_on'])); ?></td>
                                                       <td><?php echo ($value['vreg_is_verified'] == 1) ? 'Verified' : 'Pending'; ?></td>
                                                       <td>
                                                            <?php
                                                            $callTypes = unserialize(CALL_TYPE);
                                                            echo isset($callTypes[$value['vreg_call_type']]) ? $callTypes[$value['vreg_call_type']] : '';
                                                            ?>
                                                       </td>
                                                       <td><?php echo $value['dep_name']; ?></td>

                                                       <td><?php echo $value['assign_usr_first_name']; ?></td>

                                                       <td><?php echo $value['addedby_usr_first_name']; ?>
                                                            <?php if ($value['vreg_last_action']) { ?>
                                                                 <i class="fa fa-comment" style="color: #fff;" title="<?php echo $value['vreg_last_action']; ?>"></i>
                                                            <?php } ?>
                                                       </td>

                                                       <td><?php echo $remarks; ?></td>
                                                       <td style="wid">
                                                            <?php echo date('j M Y h:i A', strtotime($value['vreg_added_on'])); ?>
                                                       </td>
                                                  </tr>
                                                  <?php
                                             }
                                        } else {
                                             ?> 
                                             <tr>
                                                  <td style="text-align: center;" colspan="<?php echo $colspan; ?>">No data available in table</td>
                                             </tr>
                                        <?php } ?>
                                   </tbody>                         
                              </table>                         
                         </div>
                         <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex; ?> to <?php echo $limit; ?> of <?php echo $totalRow; ?> entries</div>                         
                         <div style="float: right;">                              
                              <?php echo $links; ?>                         
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