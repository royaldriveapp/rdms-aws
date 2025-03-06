<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Quick search vehicle</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <?php if (check_permission('reports', 'xlsx_rpt_quick_vehicle_search')) {?>
                                   <li style="float: right;">
                                        <a href="<?php echo site_url('reports/exportVehicleSearch?' . $_SERVER['QUERY_STRING']);?>">
                                             <img width="28" title="Export to excel" src="images/excel-export.png">
                                        </a>
                                   </li>
                              <?php } if (is_roo_user()) {?>
                                     <li style="float: right;">
                                          <a href="<?php echo site_url('tools/sendBulkSms?' . $_SERVER['QUERY_STRING']);?>">
                                               <img width="20" title="Export to excel" src="images/sms.png">
                                          </a>
                                     </li>
                                <?php }?>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="<?php echo site_url('reports/quickVehicleSearch/');?>" method="get">
                              <table>
                                   <tr>
                                        <td style="margin: 10px;">
                                             <select required="true" style="float: left;width: auto;" class="select2_group form-control cmbBindModel" 
                                                  data-url="<?php echo site_url('enquiry/bindModel');?>" 
                                                  name="vehicle[sale][veh_brand][]">
                                                  <option value="0">Select Brand</option>
                                                  <?php foreach ($brands as $key => $value) {?>
                                                       <option <?php echo $veh_brand == $value['brd_id'] ? 'selected="selected"' : '';?> 
                                                            value="<?php echo $value['brd_id']?>"><?php echo $value['brd_title']?></option>
                                                       <?php }?>
                                             </select>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <?php if (isset($model) && !empty($model)) {?>
                                                  <select required="true" style="float: left;width: auto;" class="select2_group form-control cmbBindVariant" 
                                                            data-url="<?php echo site_url('enquiry/bindVarient');?>" 
                                                            name="vehicle[sale][veh_model][]">
                                                       <option value="0">Select Model</option>
                                                       <?php foreach ($model as $key => $value) {?>
                                                            <option <?php echo $veh_model == $value['mod_id'] ? 'selected="selected"' : '';?>
                                                                 value="<?php echo $value['mod_id']?>"><?php echo $value['mod_title']?></option>
                                                            <?php }?>
                                                  </select>
                                             <?php }?>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <?php if (isset($variant) && !empty($variant)) {?>
                                                  <select required="true" style="float: left;width: auto;" class="select2_group form-control" 
                                                            name="vehicle[sale][veh_varient][]">
                                                       <option value="0">Select Variant</option>
                                                       <?php foreach ($variant as $key => $value) {?>
                                                            <option <?php echo $veh_varient == $value['var_id'] ? 'selected="selected"' : '';?>
                                                                 value="<?php echo $value['var_id']?>"><?php echo $value['var_variant_name']?></option>
                                                            <?php }?>
                                                  </select>
                                             <?php }?>
                                        </td>
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
                                             <select multiple="multiple" style="float: left;width: auto;" class="select2_group form-control muliSelectCombo" name="mode[]">
                                                  <option value="0">All Mode of enquiry</option>
                                                  <?php foreach (unserialize(MODE_OF_CONTACT) as $sts => $stsName) {?> 
                                                       <option <?php echo ((int) $sts == (int) $mode) ? 'selected="selected"' : '';?>
                                                            value="<?php echo $sts;?>"><?php echo $stsName?></option>
                                                       <?php }?>
                                             </select>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="enq_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                  placeholder="Date from" value="<?php echo $enq_date_from;?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <input autocomplete="off" name="enq_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                  placeholder="Date to" value="<?php echo $enq_date_to?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <select style="float: left;width: auto;" class="select2_group form-control" name="type">
                                                  <option value="0">Select Type</option>
                                                  <option <?php echo ($stype == 1) ? 'selected="selected"' : '';?> value="1">Sales</option>
                                                  <option <?php echo ($stype == 2) ? 'selected="selected"' : '';?> value="2">Purchase</option>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control" name="enq_sts" id="enq_sts">
                                                  <option value="">Select one</option>
                                                  <?php foreach (unserialize(FOLLOW_UP_STATUS) as $key => $value) {?>
                                                       <option  <?php echo ($datas['enq_sts'] == $key) ? 'selected="selected"' : '';?> value="<?php echo $key;?>"><?php echo $value;?></option>
                                                  <?php }?>
                                             </select>
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
                                        <th>Vehicle ID</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Variant</th>
                                        <th>Type</th>
                                        <th>Showroom</th>
                                        <th>Sales Executive</th>
                                        <!--<th>Contact No</th>-->
                                        <?php //if (is_roo_user()) {?>
                                        <th>Customer</th>
                                        <th>Cust Number</th>
                                        <th>Contact mod</th>
                                        <?php // }?>
                                        <th>Action</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $vehicles as $key => $veh) {
                                          $canEdit = (($this->uid == $veh['enq_se_id']) || is_roo_user() || (check_permission('reports', 'showtrackcardfromreportrow'))) ? 'trVOE' : '';
                                          $follLink = '<a style="margin-left: 10px;" title="Followup" href="' . site_url('followup/viewFollowup/' . encryptor($veh['enq_id'])) . '">
                                                              <i class="fa fa-calendar-check-o"></i>
                                                         </a>';

                                          $trackCard = '<a title="Track card" href="' . site_url('enquiry/printTrackCard/' . encryptor($veh['enq_id'])) . '">
                                                              <span class="glyphicon glyphicon-print"></span>
                                                         </a>';
                                          ?>
                                          <tr style="<?php echo (!empty($canEdit) && !is_roo_user()) ? 'background:yellowgreen;color:#fff;' : '';?>" data-url="<?php echo site_url('enquiry/printTrackCard/' . encryptor($veh['enq_id']));?>">
                                               <td class="<?php echo $canEdit;?>"><?php echo generate_vehicle_virtual_id($veh['veh_id']);?></td>
                                               <td class="<?php echo $canEdit;?>"><?php echo $veh['brd_title'];?></td>
                                               <td class="<?php echo $canEdit;?>"><?php echo $veh['mod_title'];?></td>
                                               <td class="<?php echo $canEdit;?>"><?php echo $veh['var_variant_name'];?></td>
                                               <td class="<?php echo $canEdit;?>"><?php echo $veh['veh_status'] == 1 ? 'Sell' : 'Buy';?></td>
                                               <td class="<?php echo $canEdit;?>"><?php echo $veh['shr_location'];?></td>
                                               <td class="<?php echo $canEdit;?>"><?php echo $veh['usr_first_name'];?></td>
                                               <!--<td><a href="tel:<?php echo $veh['usr_phone'];?>"><?php echo $veh['usr_phone'];?></a></td>-->
                                               <?php //if (is_roo_user()) {?>
                                               <td class="<?php echo $canEdit;?>"><?php echo $veh['enq_cus_name'];?></td>
                                               <td class="<?php echo $canEdit;?>"><?php echo $veh['enq_cus_mobile'];?></td>
                                               <td class="<?php echo $canEdit;?>">
                                                    <?php
                                                    $mods = unserialize(MODE_OF_CONTACT);
                                                    echo isset($mods[$veh['enq_mode_enq']]) ? $mods[$veh['enq_mode_enq']] : '';
                                                    ?>
                                               </td>
                                               <?php // }?>
                                               <td>
                                                    <?php echo $follLink;?>
                                                    <?php echo $trackCard;?>
                                               </td>
                                          </tr>
                                          <?php
                                     }
                                   ?>
                              </tbody>
                         </table>
                         <div>
                              <div style="float: left;width:100%;">
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
                                                       <table>
                                                            <tr>
                                                            <td style="padding-left: 10px;">
                                                                      <select multiple="multiple" style="float: left;width: auto;" class="muliSelectCombo select2_group form-control cmbSalesExecutives" name="executive[]">
                                                                           <?php
                                                                           foreach ((array) $salesExecutives as $key => $value) {
                                                                                if (!empty($showroom)) {
                                                                                     if ($showroom == $value['usr_showroom']) {
                                                                                          ?>
                                                                                          <option value="<?php echo $value['col_id'];?>"
                                                                                                    <?php echo (@in_array($value['col_id'], $executive)) ? 'selected="selected"' : '';?>>
                                                                                               <?php echo $value['col_title'];?></option> 
                                                                                          <?php
                                                                                     }
                                                                                } else {
                                                                                     ?>
                                                                                     <option <?php echo (@in_array($value['col_id'], $executive)) ? 'selected="selected"' : '';?>
                                                                                          value="<?php echo $value['col_id'];?>"><?php echo $value['col_title'];?></option> 
                                                                                          <?php
                                                                                     }
                                                                                }
                                                                                ?>
                                                                      </select>
                                                                 </td>
                                                            </tr>
                                                            <tr>
                                                                 <td style="padding:10px;">
                                                                      <?php
                                                                           $enq_date_from = !empty($enq_date_from) ? 'date from ' . $enq_date_from : '';
                                                                           $enq_date_to = !empty($enq_date_to) ? ', date to ' . $enq_date_to : '';
                                                                      ?>
                                                                      <textarea placeholder="Desction" name="desc" class="select2_group form-control" required><?php echo $brandName . $modelName . $varientName . $enq_date_from . $enq_date_to; ?></textarea>
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
                           <?php } if (check_permission('reports', 'allowquickassignenquirestosalesstaff')) { ?>
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                   <div class="x_panel tile fixed_height_320">
                                        <div class="x_title">
                                             <h2>Assign to sales staff</h2>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="dashboard-widget-content">
                                             <div class="x_content">
                                                  <form class="frmQuickAssign" data-url="<?php echo site_url('reports/allowquickassignenquirestosalesstaff'); ?>" method="get">
                                                       <input type="hidden" name="searchValues" value='<?php echo!empty($_GET) ? serialize($_GET) : ''; ?>'/>
                                                       <table>
                                                            <tr>
                                                                 <td style="padding:10px;">
                                                                      <?php
                                                                      $enq_date_from = !empty($enq_date_from) ? 'date from ' . $enq_date_from : '';
                                                                      $enq_date_to = !empty($enq_date_to) ? ', date to ' . $enq_date_to : '';
                                                                      ?>
                                                                      <textarea placeholder="Desction" name="desc" class="select2_group form-control" required><?php echo $brandName . $modelName . $varientName . $enq_date_from . $enq_date_to; ?></textarea>
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
                         <?php } ?> 
                    </div>
               </div>
          </div>
     </div>
</div>