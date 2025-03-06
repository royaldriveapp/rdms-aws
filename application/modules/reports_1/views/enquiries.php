<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <?php if (check_permission('reports', 'xlsx_rpt_enq_veh_based')) {?>
                                   <li style="float: right;">
                                        <a href="<?php echo site_url('reports/exportEnquires?' . $_SERVER['QUERY_STRING']);?>">
                                             <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                        </a>
                                   </li>
                              <?php } ?>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="<?php echo site_url('reports/enquiries/');?>" method="get">
                              <table>
                                   <td>
                                        <input autocomplete="off" name="enq_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date from" value="<?php echo $enq_date_from;?>"/>
                                   </td>
                                   <td style="padding-left: 10px;">
                                        <input autocomplete="off" name="enq_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date to" value="<?php echo $enq_date_to?>"/>
                                   </td>
                                   <?php if (is_roo_user() || $this->usr_grp == 'DE'|| $this->usr_grp == 'MG' || $this->usr_grp == 'TL') {?>
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

                                          <td style="padding-left: 10px;">
                                               <select multiple="multiple" style="float: left;width: auto;" class="muliSelectCombo select2_group form-control cmbSalesExecutives" name="executive[]">
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
                                     <?php }?>
                                   <td style="padding-left: 10px;">
                                        <select style="float: left;width: auto;" class="select2_group form-control" name="status">
                                             <option value="0">All Types</option>
                                             <?php  foreach (unserialize(ENQUIRY_UP_STATUS) as $sts => $stsName) {?>
                                                    <option <?php echo ((int)$sts == (int)$enqStatus) ? 'selected="selected"' : '';?>
                                                         value="<?php echo $sts;?>"><?php echo $stsName?></option>
                                                    <?php }?>
                                        </select>
                                   </td>
                                   <td style="padding-left: 10px;">
                                        <select style="float: left;width: auto;" class="select2_group form-control" name="mode">
                                             <option value="0">All Mode of enquiry</option>
                                             <?php foreach (unserialize(MODE_OF_CONTACT) as $sts => $stsName) {?> 
                                                    <option <?php echo ((int) $sts == (int) $mode) ? 'selected="selected"' : '';?>
                                                         value="<?php echo $sts;?>"><?php echo $stsName?></option>
                                                    <?php }?>
                                        </select>
                                   </td>
                                   <td style="padding-left: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>
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
                                        <th>Vehicle</th>
                                        <th>Type</th>
                                        <?php if ($this->usr_grp != 'SE') {?>
                                               <th>Showroom</th>
                                               <th>Executive</th>
                                          <?php }?>
                                        <th>Enq Date</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $searchResult as $key => $veh) {
                                          $canEdit = (($this->uid == $veh['enq_se_id']) || is_roo_user() || (check_permission('reports', 'showtrackcardfromreportrow'))) ? 'trVOE' : '';
                                          $vehicle = $this->reports->getVehicleDetails($veh['enq_id']);
                                          //enquiry/printTrackCard
                                          ?>
                                          <tr data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($veh['enq_id']));?>">
                                               <td class="<?php echo $canEdit;?>"><?php echo generate_vehicle_virtual_id($veh['enq_id']);?></td>
                                               <td class="<?php echo $canEdit;?>"><?php echo strtoupper($veh['enq_cus_name']);?></td>
                                               <td><a href="tel:<?php echo $veh['usr_phone'];?>"><?php echo $veh['enq_cus_mobile'];?></a></td>
                                               <td class="<?php echo $canEdit;?>">
                                                    <?php
                                                    $mods = unserialize(MODE_OF_CONTACT);
                                                    echo isset($mods[$veh['enq_mode_enq']]) ? $mods[$veh['enq_mode_enq']] : '';
                                                    ?>
                                               </td>
                                               <td class="<?php echo $canEdit;?>"><?php echo $vehicle;?></td>
                                               <td class="<?php echo $canEdit;?>"><?php echo $veh['enq_cus_status'] == 1 ? 'Sell' : 'Buy';?></td>
                                               <?php if ($this->usr_grp != 'SE') {?>
                                                    <td class="<?php echo $canEdit;?>"><?php echo $veh['shr_location'];?></td>
                                                    <td class="<?php echo $canEdit;?>"><?php echo $veh['usr_first_name'];?></td>
                                               <?php }?>
                                               <td><?php echo date('j M Y', strtotime($veh['enq_entry_date']));?></td>
                                          </tr>
                                          <?php
                                     }
                                   ?>
                              </tbody>
                         </table>
                         <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex; ?> to <?php echo $limit; ?> of <?php echo $totalRow; ?> entries</div>
                         <div>
                              <div style="float: left;">
                                   <strong><?php echo $totalRows . ' Enquires found'; ?></strong>
                              </div>
                              <div style="float: right;">
                                   <?php echo $links;?>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>