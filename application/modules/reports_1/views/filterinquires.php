<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li style="float: right;">
                                   <?php /*if (check_permission('reports', 'xlsx_rpt_enq_based')) { ?>
                                        <a href="<?php echo site_url('reports/exportEnquires?' . $_SERVER['QUERY_STRING']); ?>">
                                             <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                        </a>
                                   <?php }*/ ?>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="<?php echo site_url('reports/filterinquires/'); ?>" method="get">
                              <table>
                                   <tr>
                                        <?php if (check_permission('reports', 'fltr_enquiries_enq_showroom')) { ?>
                                             <td>
                                                  <select style="float: left;width: auto;" class="select2_group form-control bindSalesExecutives" 
                                                          data-url="<?php echo site_url('emp_details/salesExecutivesByShowroom'); ?>"
                                                          data-bind="cmbSalesExecutives" name="showroom" data-dflt-select="All Sales executives">
                                                       <option value="0">All Showroom</option>
                                                       <?php foreach ($allShowrooms as $key => $value) { ?>
                                                            <option <?php echo ($showroom == $value['shr_id']) ? 'selected="selected"' : ''; ?>
                                                                 value="<?php echo $value['shr_id'] ?>"><?php echo $value['shr_location'] ?></option>
                                                            <?php } ?>
                                                  </select>
                                             </td>
                                        <?php } if (check_permission('reports', 'fltr_enquiries_enq_salesstaff')) { ?>
                                             <td style="padding-left: 10px;">
                                                  <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control cmbSalesExecutives" name="executive[]">
                                                       <?php
                                                       foreach ((array) $salesExecutives as $key => $value) {
                                                            if (!empty($showroom)) {
                                                                 if ($showroom == $value['usr_showroom']) {
                                                                      ?>
                                                                      <option value="<?php echo $value['usr_id']; ?>"
                                                                              <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?>>
                                                                           <?php echo $value['usr_first_name']; ?></option> 
                                                                      <?php
                                                                 }
                                                            } else {
                                                                 ?>
                                                                 <option <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?>
                                                                      value="<?php echo $value['usr_id']; ?>"><?php echo $value['usr_first_name']; ?></option> 
                                                                      <?php
                                                                 }
                                                            }
                                                            ?>
                                                  </select>
                                             </td>
                                        <?php } if (check_permission('reports', 'fltr_enquiries_enq_type')) { ?>
                                             <td style="padding-left: 10px;">
                                                  <select style="float: left;width: auto;" class="select2_group form-control" name="status">
                                                       <option value="0">All Types</option>
                                                       <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $sts => $stsName) { ?>
                                                            <option <?php echo ((int) $sts == (int) $enqStatus) ? 'selected="selected"' : ''; ?>
                                                                 value="<?php echo $sts; ?>"><?php echo $stsName ?></option>
                                                            <?php } ?>
                                                  </select>
                                             </td>
                                        <?php } if (check_permission('reports', 'fltr_enquiries_enq_mod')) { ?>
                                             <td style="padding-left: 10px;">
                                                  <select multiple="multiple" style="float: left;width: auto;" class="select2_group form-control cmbMultiSelect" name="mode">
                                                       <option value="0">All Mode of enquiry</option>
                                                       <?php foreach (unserialize(MODE_OF_CONTACT) as $sts => $stsName) { ?> 
                                                            <option <?php echo ((int) $sts == (int) $mode) ? 'selected="selected"' : ''; ?>
                                                                 value="<?php echo $sts; ?>"><?php echo $stsName ?></option>
                                                            <?php } ?>
                                                  </select>
                                             </td>
                                             <?php
                                        }
                                        ?>
                                        <td style="padding-left: 10px;">
                                             <select multiple="multiple" style="float: left;width: auto;" 
                                                     class="select2_group form-control cmbMultiSelect" name="dist[]">
                                                  <option value="0">All Mode of enquiry</option>
                                                  <?php foreach ($districts as $sts => $stsName) { ?> 
                                                       <option <?php echo (!empty($distSelected) && (in_array($stsName['std_id'], $distSelected))) ? 'selected="selected"' : ''; ?>
                                                            value="<?php echo $stsName['std_id']; ?>"><?php echo $stsName['std_district_name']; ?>
                                                       </option>
                                                  <?php } ?>
                                             </select>
                                        </td>

                                        <td style="padding-left: 10px;">
                                             <select style="float: left;width: auto;" class="select2_group form-control" name="type">
                                                  <option value="0">Type</option>
                                                  <option value="1">Sales</option>
                                                  <option value="2">Purchase</option>
                                                  <option value="3">Exchange</option>
                                             </select>
                                        </td>
                                        
                                        <td style="padding-left: 10px;">
                                             <select style="float: left;width: auto;" class="select2_group form-control" name="currentstatus">
                                                  <option <?php echo (isset($_GET['currentstatus']) && $_GET['currentstatus'] == 0) ? 'selected="selected"' : '';?> value="0">All status</option>
                                                  <option <?php echo (isset($_GET['currentstatus']) && $_GET['currentstatus'] == 1) ? 'selected="selected"' : '';?> value="1">Open</option>
                                                  <option <?php echo (isset($_GET['currentstatus']) && $_GET['currentstatus'] == 2) ? 'selected="selected"' : '';?> value="2">Request for Drop</option>
                                                  <option <?php echo (isset($_GET['currentstatus']) && $_GET['currentstatus'] == 3) ? 'selected="selected"' : '';?> value="3">Dropped</option>
                                                  <option <?php echo (isset($_GET['currentstatus']) && $_GET['currentstatus'] == 4) ? 'selected="selected"' : '';?> value="4">Request for Loss of sale or purchase</option>
                                                  <option <?php echo (isset($_GET['currentstatus']) && $_GET['currentstatus'] == 5) ? 'selected="selected"' : '';?> value="5">Lost</option>
                                                  <option <?php echo (isset($_GET['currentstatus']) && $_GET['currentstatus'] == 13) ? 'selected="selected"' : '';?> value="13">Booked</option>
                                             </select>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="enq_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                    placeholder="Date from" value="<?php echo $enq_date_from; ?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <input autocomplete="off" name="enq_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                    placeholder="Date to" value="<?php echo $enq_date_to ?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <input <?php echo ($isMissedFollowup == 1) ? 'checked' : ''; ?> type="checkbox" name="isMissedFollowup" value="1"/> Is followup missed
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
                                        <?php if ($this->usr_grp != 'SE') { ?>
                                             <th>Showroom</th>
                                             <th>Executive</th>
                                        <?php } ?>
                                        <th>Enq Date</th>
                                        <th>Next followup</th>
                                        <th>Current status</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   foreach ((array) $searchResult as $key => $veh) {
                                        $canEdit = (($this->uid == $veh['enq_se_id']) || is_roo_user()) ? 'trVOE' : '';
                                        ?>
                                        <tr data-url="<?php echo site_url('enquiry/printTrackCard/' . encryptor($veh['enq_id'])); ?>">
                                             <td class="<?php echo $canEdit; ?>"><?php echo generate_vehicle_virtual_id($veh['enq_id']); ?></td>
                                             <td class="<?php echo $canEdit; ?>"><?php echo strtoupper($veh['enq_cus_name']); ?></td>
                                             <td><a href="tel:<?php echo $veh['enq_cus_mobile']; ?>"><?php echo $veh['enq_cus_mobile']; ?></a></td>
                                             <td class="<?php echo $canEdit; ?>">
                                                  <?php
                                                  $mods = unserialize(MODE_OF_CONTACT);
                                                  echo isset($mods[$veh['enq_mode_enq']]) ? $mods[$veh['enq_mode_enq']] : '';
                                                  ?>
                                             </td>
                                             <td class="<?php echo $canEdit; ?>"><?php echo $veh['enq_cus_status'] == 1 ? 'Sales' : 'Purchase'; ?></td>
                                             <?php if ($this->usr_grp != 'SE') { ?>
                                                  <td class="<?php echo $canEdit; ?>"><?php echo $veh['shr_location']; ?></td>
                                                  <td class="<?php echo $canEdit; ?>"><?php echo $veh['usr_first_name']; ?></td>
                                             <?php } ?>
                                             <td><?php echo date('j M Y', strtotime($veh['enq_entry_date'])); ?></td>
                                             <td><?php echo date('j M Y', strtotime($veh['enq_next_foll_date'])); ?></td>
                                             <td><?php echo $veh['sts_title']; ?></td>
                                        </tr>
                                        <?php
                                   }
                                   ?>
                              </tbody>
                         </table>
                         <!--<div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex; ?> to <?php echo $limit; ?> of <?php echo $totalRow; ?> entries</div>-->
                         <div>
                              <div style="float: left;">
                                   <strong><?php echo $totalRows . ' Enquires found'; ?></strong>
                              </div>
                              <div style="float: right;">
                                   <?php echo $links; ?>
                              </div>
                         </div>

                         <!-- -->
<!--                         <div class="x_content">
                              <form class="frmQuickAssign" data-url="<?php //echo site_url('reports/quickassign'); ?>" method="get">
                                   <input type="hidden" name="searchValues" value='<?php //echo!empty($_GET) ? serialize($_GET) : ''; ?>'/>
                                   <table>
                                        <td style="padding-left: 10px;">
                                             <select multiple="multiple" style="float: left;width: auto;" class="muliSelectCombo select2_group form-control cmbSalesExecutives" name="executive[]">
                                                  <?php
                                                  /*foreach ((array) $salesExecutives as $key => $value) {
                                                       if (!empty($showroom)) {
                                                            if ($showroom == $value['usr_showroom']) {
                                                                 ?>
                                                                 <option value="<?php echo $value['usr_id']; ?>"
                                                                         <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?>>
                                                                      <?php echo $value['usr_first_name']; ?></option> 
                                                                 <?php
                                                            }
                                                       } else {
                                                            ?>
                                                            <option <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?>
                                                                 value="<?php echo $value['usr_id']; ?>"><?php echo $value['usr_first_name']; ?></option> 
                                                                 <?php
                                                            }
                                                       }*/
                                                       ?>
                                             </select>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Assign</button>
                                        </td>
                                   </table>
                              </form>
                         </div>-->
                         <!-- -->
                    </div>
               </div>
          </div>
     </div>
</div>