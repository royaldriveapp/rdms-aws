<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li style="float: right;">
                                   <?php if (check_permission('reports', 'xlsx_rpt_enq_based')) {?>
                                          <a href="<?php echo site_url('reports/exportEnquires?' . $_SERVER['QUERY_STRING']);?>">
                                               <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                          </a>
                                     <?php }?>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="<?php echo site_url('reports/enquiries_enq/');?>" method="get">
                              <table>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="enq_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                    placeholder="Date from" value="<?php echo $enq_date_from;?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <input autocomplete="off" name="enq_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                    placeholder="Date to" value="<?php echo $enq_date_to?>"/>
                                        </td>
                                        <?php if (check_permission('reports', 'fltr_enquiries_enq_showroom')) {?>
                                               <td style="padding-left: 10px;">
                                                    <select style="float: left;width: auto;" class="select2_group form-control bindSalesExecutives" 
                                                            data-url="<?php echo site_url('emp_details/salesExecutivesByShowroom');?>"
                                                            data-bind="cmbSalesExecutives" name="showroom" data-dflt-select="All Sales executives">
                                                         <option value="0">All Showroom</option>
                                                         <?php foreach ($allShowrooms as $key => $value) {?>
                                                              <option <?php echo ($showroom == $value['shr_id']) ? 'selected="selected"' : '';?>
                                                                   value="<?php echo $value['shr_id']?>"><?php echo $value['shr_location']?></option>
                                                              <?php }?>
                                                    </select>
                                               </td>
                                          <?php } if (check_permission('reports', 'fltr_enquiries_enq_salesstaff')) {?>
                                               <td style="padding-left: 10px;">
                                                    <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control cmbSalesExecutives" name="executive[]">
                                                         <option value="<?php echo $this->uid;?>">My self</option>
                                                         <?php
                                                         foreach ((array) $salesExecutives as $key => $value) {
                                                              if (!empty($showroom)) {
                                                                   if ($showroom == $value['usr_showroom']) {
                                                                        ?>
                                                                        <option value="<?php echo $value['usr_id'];?>"
                                                                                <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : '';?>>
                                                                             <?php echo $value['usr_first_name'];?></option> 
                                                                        <?php
                                                                   }
                                                              } else {
                                                                   ?>
                                                                   <option <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : '';?>
                                                                        value="<?php echo $value['usr_id'];?>"><?php echo $value['usr_first_name'];?></option> 
                                                                        <?php
                                                                   }
                                                              }
                                                              ?>
                                                    </select>
                                               </td>
                                          <?php } if (check_permission('reports', 'fltr_enquiries_enq_type')) {?>
                                               <td style="padding-left: 10px;">
                                                    <select style="float: left;width: auto;" class="select2_group form-control" name="status">
                                                         <option value="0">All Types</option>
                                                         <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $sts => $stsName) {?>
                                                              <option <?php echo ((int) $sts == (int) $enqStatus) ? 'selected="selected"' : '';?>
                                                                   value="<?php echo $sts;?>"><?php echo $stsName?></option>
                                                              <?php }?>
                                                    </select>
                                               </td>
                                          <?php } if (check_permission('reports', 'fltr_enquiries_enq_mod')) {?>
                                               <td style="padding-left: 10px;">
                                                    <select multiple="multiple" style="float: left;width: auto;" class="select2_group form-control cmbMultiSelect" name="mode">
                                                         <option value="0">All Mode of enquiry</option>
                                                         <?php foreach (unserialize(MODE_OF_CONTACT) as $sts => $stsName) {?> 
                                                              <option <?php echo ((int) $sts == (int) $mode) ? 'selected="selected"' : '';?>
                                                                   value="<?php echo $sts;?>"><?php echo $stsName?></option>
                                                              <?php }?>
                                                    </select>
                                               </td>
                                          <?php }?>
                                        <td style="padding-left: 10px;">
                                             <select multiple="multiple" style="float: left;width: auto;" 
                                                     class="select2_group form-control cmbMultiSelect" name="dist[]">
                                                  <option value="0">District</option>
                                                  <?php foreach ($districts as $sts => $stsName) {?> 
                                                         <option <?php echo (in_array($stsName['std_id'], $distSelected)) ? 'selected="selected"' : '';?>
                                                              value="<?php echo $stsName['std_id'];?>"><?php echo $stsName['std_district_name'];?>
                                                         </option>
                                                    <?php }?>
                                             </select>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <select style="float: left;width: auto;" class="select2_group form-control" name="type">
                                                  <option <?php echo (isset($_GET['type']) && $_GET['type'] == 0) ? 'selected="selected"' : '';?> value="0">Type</option>
                                                  <option <?php echo (isset($_GET['type']) && $_GET['type'] == 1) ? 'selected="selected"' : '';?> value="1">Sales</option>
                                                  <option <?php echo (isset($_GET['type']) && $_GET['type'] == 2) ? 'selected="selected"' : '';?> value="2">Purchase</option>
                                                  <option <?php echo (isset($_GET['type']) && $_GET['type'] == 3) ? 'selected="selected"' : '';?> value="3">Exchange</option>
                                             </select>
                                        </td>

                                   </tr>
                                   <tr>
                                        <td style="padding-left: 10px;">
                                             <input <?php echo ($isMissedFollowup == 1) ? 'checked' : '';?> type="checkbox" name="isMissedFollowup" value="1"/> Is followup missed
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   </tr>
                              </table>
                         </form>
                    </div>
                    <div class="x_content">
                         <table class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Customer ID</th>
                                        <th>Customer</th>
                                        <th>Contact No</th>
                                        <th>Mode of inquiry</th>
                                        <th>Type</th>
                                        <?php if ($this->usr_grp != 'SE') {?>
                                               <th>Showroom</th>
                                               <th>Executive</th>
                                          <?php }?>
                                        <th>Enq Date</th>
                                        <th>Last followup on</th>
                                        <th>Next followup on</th>
                                        <?php if (check_permission('reports', 'viewfollowupfromreport')) {?>
                                               <th>Followup</th>
                                          <?php }?>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $searchResult as $key => $veh) {
                                          $lastFollowupDate = $this->reports->getLastFollowupDate($veh['enq_id']);
                                          $canEdit = (($this->uid == $veh['enq_se_id']) || is_roo_user() || (check_permission('reports', 'showtrackcardfromreportrow'))) ? 'trVOE' : '';
                                          ?>
                                          <tr data-url="<?php echo site_url('enquiry/printTrackCard/' . encryptor($veh['enq_id']));?>">
                                               <td class="<?php echo $canEdit;?>"><?php echo generate_vehicle_virtual_id($veh['enq_id']);?></td>
                                               <td class="<?php echo $canEdit;?>"><?php echo strtoupper($veh['enq_cus_name']);?></td>
                                               <td><a href="tel:<?php echo $veh['usr_phone'];?>"><?php echo $veh['enq_cus_mobile'];?></a></td>
                                               <td class="<?php echo $canEdit;?>">
                                                    <?php
                                                    $mods = unserialize(MODE_OF_CONTACT);
                                                    echo isset($mods[$veh['enq_mode_enq']]) ? $mods[$veh['enq_mode_enq']] : '';
                                                    ?>
                                               </td>
                                               <td class="<?php echo $canEdit;?>"><?php echo $veh['enq_cus_status'] == 1 ? 'Sales' : 'Purchase';?></td>
                                               <?php if ($this->usr_grp != 'SE') {?>
                                                    <td class="<?php echo $canEdit;?>"><?php echo $veh['shr_location'];?></td>
                                                    <td class="<?php echo $canEdit;?>"><?php echo $veh['usr_first_name'];?></td>
                                               <?php }?>
                                               <td><?php echo date('j M Y', strtotime($veh['enq_entry_date']));?></td>
                                               <td>
                                                    <?php
                                                    echo (isset($lastFollowupDate['foll_entry_date']) && !empty($lastFollowupDate['foll_entry_date'])) ?
                                                            date('j M Y', strtotime($lastFollowupDate['foll_entry_date'])) : '';
                                                    ?>
                                               </td>
                                               <td><?php echo date('j M Y', strtotime($veh['enq_next_foll_date']));?></td>    
                                               <?php if (check_permission('reports', 'viewfollowupfromreport')) {?>
                                                    <td>
                                                         <a style="margin-left: 10px;" title="Followup" href="<?php echo site_url('followup/viewFollowup/' . encryptor($veh['enq_id']))?>">
                                                              <i class="fa fa-calendar-check-o"></i>
                                                         </a>
                                                    </td>
                                               <?php }?>
                                          </tr>
                                          <?php
                                     }
                                   ?>
                              </tbody>
                         </table>
                         <!--<div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex;?> to <?php echo $limit;?> of <?php echo $totalRow;?> entries</div>-->
                         <div>
                              <div style="float: left;width:100%">
                                   <strong><?php echo $totalRows . ' Enquires found';?></strong>
                              </div>
                              <div style="float: right;">
                                   <?php echo $links;?>
                              </div>
                         </div>
                         <?php if (check_permission('reports', 'allowquickassignenquires')) {?>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                     <div class="x_panel tile fixed_height_320">
                                          <div class="x_title">
                                               <h2>Assign to CRE</h2>
                                               <div class="clearfix"></div>
                                          </div>
                                          <div class="dashboard-widget-content">
                                               <div class="x_content">
                                                    <form class="frmQuickAssign" data-url="<?php echo site_url('reports/quickassign');?>" method="get">
                                                         <input type="hidden" name="searchValues" value='<?php echo!empty($_GET) ? serialize($_GET) : '';?>'/>
                                                         <input type="hidden" name="source" value="rpt_enquires"/>
                                                         <table>
                                                              <tr>
                                                                   <td style="padding-left: 10px;">
                                                                        <!-- muliSelectCombo -->
                                                                        <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control cmbSalesExecutives" name="executive[]">
                                                                             <?php
                                                                             foreach ((array) $teleCallers as $key => $value) {
                                                                                  /* if (!empty($showroom)) {
                                                                                    if ($showroom == $value['usr_showroom']) {
                                                                                    ?>
                                                                                    <option value="<?php echo $value['col_id'];?>"
                                                                                    <?php echo (@in_array($value['col_id'], $executive)) ? 'selected="selected"' : '';?>>
                                                                                    <?php echo $value['col_title'];?></option>
                                                                                    <?php
                                                                                    }
                                                                                    } else { */
                                                                                  ?>
                                                                                  <option <?php echo (@in_array($value['col_id'], $executive)) ? 'selected="selected"' : '';?>
                                                                                       value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'];?></option> 
                                                                                       <?php
                                                                                       /* } */
                                                                                  }
                                                                                  ?>
                                                                        </select>
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td style="padding:10px;">
                                                                        <?php
                                                                        $enq_date_from_se = !empty($enq_date_from) ? 'date from ' . $enq_date_from : '';
                                                                        $enq_date_to_se = !empty($enq_date_to) ? ', date to ' . $enq_date_to : '';
                                                                        ?>
                                                                        <textarea placeholder="Desction" name="desc" class="select2_group form-control" required><?php echo $enq_date_from_se . $enq_date_to_se;?></textarea>
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td style="padding-left: 10px;">
                                                                        <button type="submit" class="btn btn-round btn-primary">Assign</button>
                                                                   </td>
                                                              </tr>
                                                         </table>
                                                    </form>
                                               </div>
                                          </div>
                                     </div>
                                </div>       
                           <?php } if (check_permission('reports', 'allowquickassignenquirestosalesstaff')) {?>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                     <div class="x_panel tile fixed_height_320">
                                          <div class="x_title">
                                               <h2>Assign to sales staff</h2>
                                               <div class="clearfix"></div>
                                          </div>
                                          <div class="dashboard-widget-content">
                                               <div class="x_content">
                                                    <form class="frmQuickAssign" data-url="<?php echo site_url('reports/allowquickassignenquirestosalesstaff');?>" method="get">
                                                         <input type="hidden" name="searchValues" value='<?php echo!empty($_GET) ? serialize($_GET) : '';?>'/>
                                                         <table>
                                                              <tr>
                                                                   <td style="padding:10px;">
                                                                        <?php
                                                                        $enq_date_from = !empty($enq_date_from) ? 'date from ' . $enq_date_from : '';
                                                                        $enq_date_to = !empty($enq_date_to) ? ', date to ' . $enq_date_to : '';
                                                                        ?>
                                                                        <textarea placeholder="Desction" name="desc" class="select2_group form-control" required><?php echo $enq_date_from . $enq_date_to;?></textarea>
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td style="padding-left: 10px;">
                                                                        <button type="submit" class="btn btn-round btn-primary">Assign</button>
                                                                   </td>
                                                              </tr>
                                                         </table>
                                                    </form>
                                               </div>
                                          </div>
                                     </div>
                                </div>
                           <?php }?>
                         <!-- -->
                         <!-- reAssign-->
                         <?php if (check_permission('reports', 'allowquickassignenquires')) {?>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                     <div class="x_panel tile fixed_height_320">
                                          <div class="x_title">
                                               <h2>Re Assign to Staffs</h2>
                                               <div class="clearfix"></div>
                                          </div>
                                          <div class="dashboard-widget-content">
                                               <div class="x_content">
                                                    <form class="frmQuickAssign" data-url="<?php echo site_url('reports/submitReAssign');?>" method="get">
                                                         <input type="hidden" name="searchValues" value='<?php echo!empty($_GET) ? serialize($_GET) : '';?>'/>
                                                         <input type="hidden" name="source" value="rpt_enquires"/>
                                                         <table>
                                                              <tr>
                                                                   <td style="padding-left: 10px;">
                                                                        <!-- muliSelectCombo -->
                                                                        <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control cmbSalesExecutives" name="executive[]">
                                                                             <?php
                                                                             foreach ((array) $teleCallers as $key => $value) {
                                                                                  /* if (!empty($showroom)) {
                                                                                    if ($showroom == $value['usr_showroom']) {
                                                                                    ?>
                                                                                    <option value="<?php echo $value['col_id'];?>"
                                                                                    <?php echo (@in_array($value['col_id'], $executive)) ? 'selected="selected"' : '';?>>
                                                                                    <?php echo $value['col_title'];?></option>
                                                                                    <?php
                                                                                    }
                                                                                    } else { */
                                                                                  ?>
                                                                                  <option 
                                                                                       value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'];?></option> 
                                                                                       <?php
                                                                                       /* } */
                                                                                  }
                                                                                  ?>
                                                                        </select>
                                                                   </td>
                                                              </tr>
                                                              <tr>
                                                                   <td style="padding:10px;">
                                                                        <?php
                                                                        $enq_date_from_se = !empty($enq_date_from) ? 'date from ' . $enq_date_from : '';
                                                                        $enq_date_to_se = !empty($enq_date_to) ? ', date to ' . $enq_date_to : '';
                                                                        ?>
                                                                        <textarea placeholder="Desction" name="desc" class="select2_group form-control" required><?php echo $enq_date_from_se . $enq_date_to_se;?></textarea>
                                                                   </td>
                                                              </tr>
<!--                                                              <tr>
                                                                   <td style="padding-left: 10px;">
                                                                        <input type="checkbox" name="isRandomFollDays" value="1" id="foll_days"> Set Random followup days 
                                                                   </td>

                                                              </tr>
                                                              <tr>
                                                                   <td style="padding:10px;">

                                                                        <input placeholder="Enter followup days" type="text" name="followup_days" class="form-control" >
                                                                   </td>
                                                              </tr>-->
                                                              <tr>
                                                                   <td style="padding-left: 10px;">
                                                                        <button type="submit" class="btn btn-round btn-primary">Assign</button>
                                                                   </td>
                                                              </tr>
                                                         </table>
                                                    </form>
                                               </div>
                                          </div>
                                     </div>
                                </div>       
                           <?php }?>
                         <!--@reAssign-->

                    </div>
               </div>
          </div>
     </div>
</div>
<!--<script>
     $("#foll_days input:checkbox").change(function () {
          var ischecked = $(this).is(':checked');
          if (!ischecked)
               alert('uncheckd ' + $(this).val());
     });
</script>-->