<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <!--                         <form action="<?php echo site_url('reports/dar/');?>" method="get">
                              <table>
                                   <td>
                                        <input autocomplete="off" name="date" type="text" 
                                               class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date from" value="<?php echo empty($date) ? date('d-m-Y') : $date;?>"/>
                                   </td>
                         <?php if (is_roo_user()) {?>
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
                           <?php }?>
                                   <td style="padding-left: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>
                              </table>
                         </form>-->
                         <form action="<?php echo site_url('reports/dar');?>" method="get">
                              <table>
                                   <td>
                                        <input autocomplete="off" name="darm_added_on_fr" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date from" value="<?php echo $darm_added_on_fr;?>"/>
                                   </td>
                                   <td style="padding-left: 10px;">
                                        <input autocomplete="off" name="darm_added_on_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date to" value="<?php echo $darm_added_on_to?>"/>
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
                                   <td style="padding-left: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>
                              </table>
                         </form>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12" style="padding-left: 0px;">
                         <div class="x_panel">
                              <div class="x_title">
                                   <h2>Today's DAR <small><?php echo date('l F m Y ');?></small></h2>
                                   <ul class="nav navbar-right panel_toolbox">
                                        <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>
                                   </ul>
                                   <div class="clearfix"></div>
                              </div>
                              <div class="x_content" style="display: none;">
                                   <?php
                                     $darm_cnt_mod_array = array();
                                     $darm_cnt_status_array = array();
                                     $darm_cnt_type_array = array();
                                     foreach ((array) $dar as $key => $staffs) {
                                          ?>
                                          <h1 style="float: left;width: 100%"><?php echo date('F d l Y', strtotime($key));?></h1>
                                          <table id="" class="table table-striped table-bordered">
                                               <thead>
                                                    <tr>
                                                         <th>Staff</th>
                                                         <th>Designation</th>
                                                         <th>Showroom</th>
                                                         <th>Submitted On</th>
                                                         <?php if (is_roo_user() || $this->usr_grp == 'MG') {?>
                                                              <th>Verified by (Team lead)</th>
                                                              <th>Verified On (Team lead)</th>
                                                         <?php } if (is_roo_user()) {?>
                                                              <th>Verified by (Manager)</th>
                                                              <th>Verified On (Manager)</th>
                                                         <?php }?>
                                                    </tr>
                                               </thead>
                                               <tbody>
                                                    <?php
                                                    foreach ((array) $staffs as $key => $eachDar) {
                                                         if (isset($eachDar['darMaster'][0]) && !empty($eachDar['darMaster'][0])) {
                                                              //debug($eachDar['darMaster'][0], 0);
                                                              $darm_cnt_mod = !empty($eachDar['darMaster'][0]['darm_cnt_mod']) ?
                                                                      unserialize($eachDar['darMaster'][0]['darm_cnt_mod']) : array();

                                                              $darm_cnt_status = !empty($eachDar['darMaster'][0]['darm_cnt_status']) ?
                                                                      unserialize($eachDar['darMaster'][0]['darm_cnt_status']) : array();

                                                              $darm_cnt_type = !empty($eachDar['darMaster'][0]['darm_cnt_type']) ?
                                                                      unserialize($eachDar['darMaster'][0]['darm_cnt_type']) : array();

                                                              foreach ((array) $darm_cnt_mod as $key => $value) {
                                                                   $k = trim($value['cmd_title']);
                                                                   if (array_key_exists($k, $darm_cnt_mod_array)) {
                                                                        $darm_cnt_mod_array[$k] = $darm_cnt_mod_array[$k] + $value['enq_mode_enq_count'];
                                                                   } else {
                                                                        $darm_cnt_mod_array[$k] = $value['enq_mode_enq_count'];
                                                                   }
                                                              }

                                                              foreach ((array) $darm_cnt_status as $key => $value) {
                                                                   $k = trim($value['enq_cus_when_buy']);
                                                                   if (array_key_exists($k, $darm_cnt_status_array)) {
                                                                        $darm_cnt_status_array[$k] = $darm_cnt_status_array[$k] + $value['enq_cus_when_buy_count'];
                                                                   } else {
                                                                        $darm_cnt_status_array[$k] = $value['enq_cus_when_buy_count'];
                                                                   }
                                                              }

                                                              foreach ((array) $darm_cnt_type as $key => $value) {
                                                                   $k = trim($value['enq_cus_status']);
                                                                   if (array_key_exists($k, $darm_cnt_type_array)) {
                                                                        $darm_cnt_type_array[$k] = $darm_cnt_type_array[$k] + $value['enq_cus_status_count'];
                                                                   } else {
                                                                        $darm_cnt_type_array[$k] = $value['enq_cus_status_count'];
                                                                   }
                                                              }
                                                         }
//                                                         
                                                         $trVOE = '';
                                                         $url = '';
                                                         $rowStyle = '';
                                                         if (isset($eachDar['darMaster'][0]['darm_id'])) {
                                                              $url = site_url('dar/verifydar/' . encryptor($eachDar['darMaster'][0]['darm_id']));
                                                              $trVOE = 'trVOE';
                                                         }

                                                         if (empty($eachDar['darMaster'])) {
                                                              $rowStyle = 'background: red;color:#fff;';
                                                         }
                                                         if (isset($eachDar['darMaster'][0]['darm_is_verified_team_lead']) &&
                                                                 !empty($eachDar['darMaster'][0]['darm_is_verified_team_lead'])) {
                                                              $rowStyle = 'background: #2e6dd0;color:#fff;';
                                                         }
                                                         if (isset($eachDar['darMaster'][0]['darm_is_verified']) &&
                                                                 !empty($eachDar['darMaster'][0]['darm_is_verified'])) {
                                                              $rowStyle = 'background: green;color:#fff;';
                                                         }
                                                         ?>
                                                         <tr class="<?php echo $trVOE;?>" data-url="<?php echo $url;?>"
                                                             style="<?php echo $rowStyle;?>">
                                                              <td class="<?php echo $trVOE;?>"><?php echo $eachDar['usr_username'];?></td>
                                                              <td class="<?php echo $trVOE;?>"><?php echo $eachDar['desig_title'];?></td>
                                                              <td class="<?php echo $trVOE;?>"><?php echo $eachDar['shr_location'];?></td>
                                                              <td class="<?php echo $trVOE;?>"><?php
                                                                   echo isset($eachDar['darMaster'][0]['darm_added_on']) ?
                                                                           date('j M Y h:i A', strtotime($eachDar['darMaster'][0]['darm_added_on'])) : 'Not submitted';
                                                                   ?>
                                                              </td>
                                                              <?php if (is_roo_user() || $this->usr_grp == 'MG') {?>
                                                                   <td class="<?php echo $trVOE;?>">
                                                                        <?php
                                                                        echo (isset($eachDar['darMaster'][0]['vb_usr_username_tl'])) ?
                                                                                $eachDar['darMaster'][0]['vb_usr_username_tl'] : '';
                                                                        ?>
                                                                   </td>
                                                                   <td class="<?php echo $trVOE;?>">
                                                                        <?php
                                                                        echo (isset($eachDar['darMaster'][0]['darm_verified_team_lead_on'])) ?
                                                                                date('j M Y h:i A', strtotime($eachDar['darMaster'][0]['darm_verified_team_lead_on'])) : '';
                                                                        ?>
                                                                   </td>
                                                              <?php } if (is_roo_user()) {?>
                                                                   <td class="<?php echo $trVOE;?>">
                                                                        <?php
                                                                        echo (isset($eachDar['darMaster'][0]['vb_usr_username_mg'])) ?
                                                                                $eachDar['darMaster'][0]['vb_usr_username_mg'] : '';
                                                                        ?>
                                                                   </td>
                                                                   <td class="<?php echo $trVOE;?>">
                                                                        <?php
                                                                        echo (isset($eachDar['darMaster'][0]['darm_verified_manager_on'])) ?
                                                                                date('j M Y h:i A', strtotime($eachDar['darMaster'][0]['darm_verified_manager_on'])) : '';
                                                                        ?>
                                                                   </td>
                                                              <?php }?>
                                                         </tr>
                                                         <?php
                                                    }
                                                    ?>
                                               </tbody>
                                          </table>
                                          <?php
                                     }
                                   ?>
                              </div>
                         </div>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12" style="padding-left: 0px;">
                         <div class="x_panel">
                              <div class="x_title">
                                   <h2>DAR inquiry summery <small><?php echo date('l F m Y ');?></small></h2>
                                   <ul class="nav navbar-right panel_toolbox">
                                        <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                   </ul>
                                   <div class="clearfix"></div>
                              </div>
                              <div class="x_content" data-toggle="collapse">
                                   <div class="row">
                                        <div class="col-sm-12">
                                             <div class="temperature"><b>Enquiry</b></div>
                                        </div>
                                   </div>
                                   <div class="clearfix"></div>
                                   <div class="row weather-days">
                                        <?php
                                          $statuses = unserialize(ENQUIRY_UP_STATUS);
                                          foreach ((array) $darm_cnt_status_array as $key => $value) {
                                               ?>
                                               <div class="col-sm-2">
                                                    <div class="daily-weather">
                                                         <h2 class="day"><?php echo isset($statuses[$key]) ? $statuses[$key] : '';?></h2>
                                                         <h3 style="text-align: center;"><?php echo $value;?></h3>
                                                    </div>
                                               </div>
                                          <?php }?>

                                        <?php
                                          $types = unserialize(VEHICLE_DETAILS_STATUS);
                                          foreach ((array) $darm_cnt_type_array as $key => $value) {
                                               ?>
                                               <div class="col-sm-2">
                                                    <div class="daily-weather">
                                                         <h2 class="day"><?php echo isset($types[$key]) ? $types[$key] : '';?></h2>
                                                         <h3 style="text-align: center;"><?php echo $value;?></h3>
                                                    </div>
                                               </div>
                                          <?php }?>
                                        <div class="clearfix"></div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="col-md-3 col-xs-12 widget widget_tally_box">
                         <div class="x_panel">
                              <div class="x_title">
                                   <h2>Mode of contacts</h2>
                                   <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                   <div style="text-align: center; margin-bottom: 17px">
                                        <h2><?php echo array_sum($darm_cnt_mod_array);?></h2>
                                   </div>
                                   <div class="divider"></div>
                                   <ul class="legend list-unstyled">
                                        <?php foreach ((array) $darm_cnt_mod_array as $key => $value) {?>
                                               <li>
                                                    <p>
                                                         <span class="icon"><?php echo $value;?></span> 
                                                         <span class="name"><?php echo $key;?></span>
                                                    </p>
                                               </li> 
                                          <?php }
                                        ?>
                                   </ul>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>