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
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>
                              </table>
                         </form>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Staff</th>
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
                                     foreach ((array) $dar as $key => $value) {
                                          $trVOE = '';
                                          $url = '';
                                          $rowStyle = '';
                                          if (isset($value['darMaster'][0]['darm_id'])) {
                                               $url = site_url('dar/verifydar/' . encryptor($value['darMaster'][0]['darm_id']));
                                               $trVOE = 'trVOE';
                                          }

                                          if (empty($value['darMaster'])) {
                                               $rowStyle = 'background: red;color:#fff;';
                                          }
                                          if (isset($value['darMaster'][0]['darm_is_verified_team_lead']) &&
                                                  !empty($value['darMaster'][0]['darm_is_verified_team_lead'])) {
                                               $rowStyle = 'background: #2e6dd0;color:#fff;';
                                          }
                                          if (isset($value['darMaster'][0]['darm_is_verified']) &&
                                                  !empty($value['darMaster'][0]['darm_is_verified'])) {
                                               $rowStyle = 'background: green;color:#fff;';
                                          }
                                          ?>
                                          <tr class="<?php echo $trVOE;?>" data-url="<?php echo $url;?>"
                                              style="<?php echo $rowStyle;?>">
                                               <td class="<?php echo $trVOE;?>"><?php echo $value['usr_username'];?></td>
                                               <td class="<?php echo $trVOE;?>"><?php echo $value['shr_location'];?></td>
                                               <td class="<?php echo $trVOE;?>"><?php
                                                    echo isset($value['darMaster'][0]['darm_added_on']) ?
                                                            date('j M Y h:i A', strtotime($value['darMaster'][0]['darm_added_on'])) : 'Not submitted';
                                                    ?>
                                               </td>
                                               <?php if (is_roo_user() || $this->usr_grp == 'MG') {?>
                                                    <td class="<?php echo $trVOE;?>">
                                                         <?php
                                                         echo (isset($value['darMaster'][0]['vb_usr_username_tl'])) ?
                                                                 $value['darMaster'][0]['vb_usr_username_tl'] : '';
                                                         ?>
                                                    </td>
                                                    <td class="<?php echo $trVOE;?>">
                                                         <?php
                                                         echo (isset($value['darMaster'][0]['darm_verified_team_lead_on'])) ?
                                                                 date('j M Y h:i A', strtotime($value['darMaster'][0]['darm_verified_team_lead_on'])) : '';
                                                         ?>
                                                    </td>
                                               <?php } if (is_roo_user()) {?>
                                                    <td class="<?php echo $trVOE;?>">
                                                         <?php
                                                         echo (isset($value['darMaster'][0]['vb_usr_username_mg'])) ?
                                                                 $value['darMaster'][0]['vb_usr_username_mg'] : '';
                                                         ?>
                                                    </td>
                                                    <td class="<?php echo $trVOE;?>">
                                                         <?php
                                                         echo (isset($value['darMaster'][0]['darm_verified_manager_on'])) ?
                                                                 date('j M Y h:i A', strtotime($value['darMaster'][0]['darm_verified_manager_on'])) : '';
                                                         ?>
                                                    </td>
                                               <?php }?>
                                          </tr>
                                          <?php
                                     }
                                   ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>