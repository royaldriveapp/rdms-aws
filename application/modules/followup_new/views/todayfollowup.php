<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Todays followup</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" style="background: none;">
                                   <li role="presentation" class="active">
                                        <a href="#tab_dar" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Today's followup</a>
                                   </li>
                                   <li role="presentation">
                                        <a href="#tab_website" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Yesterday's enquiry</a>
                                   </li>
                                   <?php if (check_permission('notify_todayfollowup', 'showallhothotplus')) {?>
                                   <li role="presentation">
                                        <a href="#tab_allhotplus" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">All Hot & Hot+ inquiry</a>
                                   </li>
                                   <?php } ?>
                              </ul>
                              <div id="myTabContent" class="tab-content">
                                   <div role="tabpanel" class="tab-pane fade active in" id="tab_dar" aria-labelledby="dar-tab">
                                        <table class="datatableFollowup table table-striped table-bordered">
                                             <thead>
                                                  <tr>
                                                       <th>Name</th>
                                                       <th>Sales Executive</th>
                                                       <th>Mobile</th>
                                                       <th>Whatsapp</th>
                                                       <th>Type</th>
                                                       <th>Enq Mod</th>
                                                       <!--<th>Added by</th>-->
                                                       <th>Follow up Date</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php
                                                    foreach ((array) $followups as $key => $value) {
                                                         ?>
                                                         <tr title="<?php echo empty($value['foll_id']) ? 'Pending to set followup date' : '';?>"
                                                             data-url="<?php echo site_url('followup/followupCommenting/' . encryptor($value['enq_id']));?>">
                                                              <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']);?></td>
                                                              <td class="trVOE"><?php echo $value['usr_first_name'];?></td>
                                                              <td><a href="tel:<?php echo $value['enq_cus_mobile'];?>"><?php echo $value['enq_cus_mobile'];?></a></td>
                                                              <td class="trVOE"><a href="https://api.whatsapp.com/send?phone=<?php echo $value['enq_cus_whatsapp'];?>"><?php echo $value['enq_cus_whatsapp'];?></a></td>
                                                              <td class="trVOE">
                                                                   <?php
                                                                   $mods = unserialize(FOLLOW_UP_STATUS);
                                                                   echo isset($mods[$value['enq_cus_when_buy']]) ? $mods[$value['enq_cus_when_buy']] : '';
                                                                   ?>
                                                              </td>
                                                              <td class="trVOE">
                                                                   <?php
                                                                   $mods = unserialize(MODE_OF_CONTACT);
                                                                   echo isset($mods[$value['enq_mode_enq']]) ? $mods[$value['enq_mode_enq']] : '';
                                                                   ?>
                                                              </td>

                                                              <!--<td class="trVOE"><?php echo ($value['enq_added_by_id'] == $this->uid) ? 'Self' : $value['enq_added_by_name'];?></td>-->
                                                              <td class="trVOE"><?php echo date('j M Y', strtotime($value['enq_next_foll_date']));?></td>
                                                         </tr>
                                                         <?php
                                                    }
                                                  ?>
                                             </tbody>
                                        </table>
                                   </div>
                                   <div role="tabpanel" class="tab-pane fade" id="tab_website" aria-labelledby="dar-tab">
                                        <table id="datatable" class="table table-striped table-bordered">
                                             <thead>
                                                  <tr>
                                                       <th>Customer</th>
                                                       <th>Contact No</th>
                                                       <th>Mode of inquiry</th>
                                                       <th>Type</th>
                                                       <th>Sell/Buy</th>
                                                       <th>Showroom</th>
                                                       <th>Executive</th>
                                                       <th>Enq Date</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php
                                                    if (!empty($enquires)) {
                                                         foreach ((array) $enquires as $key => $veh) {
                                                              $canEdit = 'trVOE';
                                                              ?>
                                                              <tr data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($veh['enq_id']));?>">
                                                                   <td class="<?php echo $canEdit;?>"><?php echo strtoupper($veh['enq_cus_name']);?></td>
                                                                   <td><a href="tel:<?php echo $veh['usr_phone'];?>"><?php echo $veh['enq_cus_mobile'];?></a></td>
                                                                   <td class="<?php echo $canEdit;?>">
                                                                        <?php
                                                                        $mods = unserialize(MODE_OF_CONTACT);
                                                                        echo isset($mods[$veh['enq_mode_enq']]) ? $mods[$veh['enq_mode_enq']] : '';
                                                                        ?>
                                                                   </td>
                                                                   <td class="<?php echo $canEdit;?>">
                                                                        <?php
                                                                        $mods = unserialize(FOLLOW_UP_STATUS);
                                                                        echo isset($mods[$veh['enq_cus_when_buy']]) ? $mods[$veh['enq_cus_when_buy']] : '';
                                                                        ?>
                                                                   </td>
                                                                   <td class="<?php echo $canEdit;?>"><?php echo $veh['veh_status'] == 1 ? 'Sell' : 'Buy';?></td>
                                                                   <td class="<?php echo $canEdit;?>"><?php echo $veh['shr_location'];?></td>
                                                                   <td class="<?php echo $canEdit;?>"><?php echo $veh['usr_first_name'];?></td>
                                                                   <td><?php echo date('j M Y', strtotime($veh['enq_entry_date']));?></td>
                                                              </tr>
                                                              <?php
                                                         }
                                                    }
                                                  ?>
                                             </tbody>
                                        </table>
                                   </div>
                                   <?php if (check_permission('notify_todayfollowup', 'showallhothotplus')) {?>
                                   <div role="tabpanel" class="tab-pane fade" id="tab_allhotplus" aria-labelledby="dar-tab">
                                        <table class="dataTable table table-striped table-bordered">
                                             <thead>
                                                  <tr>
                                                       <th>Customer</th>
                                                       <th>Contact No</th>
                                                       <th>Mode of inquiry</th>
                                                       <th>Type</th>
                                                       <th>Sell/Buy</th>
                                                       <?php if(is_roo_user()) { ?><th>Showroom</th><?php } ?>
                                                       <th>Executive</th>
                                                       <th>Enq Date</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php
                                                    if (!empty($allHotAndHotPlusInquires)) {
                                                         foreach ((array) $allHotAndHotPlusInquires as $key => $veh) {
                                                              $canEdit = 'trVOE';
                                                              ?>
                                                              <tr data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($veh['enq_id']));?>">
                                                                   <td class="<?php echo $canEdit;?>"><?php echo strtoupper($veh['enq_cus_name']);?></td>
                                                                   <td><a href="tel:<?php echo $veh['usr_phone'];?>"><?php echo $veh['enq_cus_mobile'];?></a></td>
                                                                   <td class="<?php echo $canEdit;?>">
                                                                        <?php
                                                                        $mods = unserialize(MODE_OF_CONTACT);
                                                                        echo isset($mods[$veh['enq_mode_enq']]) ? $mods[$veh['enq_mode_enq']] : '';
                                                                        ?>
                                                                   </td>
                                                                   <td class="<?php echo $canEdit;?>">
                                                                        <?php
                                                                        $mods = unserialize(FOLLOW_UP_STATUS);
                                                                        echo isset($mods[$veh['enq_cus_when_buy']]) ? $mods[$veh['enq_cus_when_buy']] : '';
                                                                        ?>
                                                                   </td>
                                                                   <td class="<?php echo $canEdit;?>"><?php echo $veh['veh_status'] == 1 ? 'Sell' : 'Buy';?></td>
                                                                   <?php if(is_roo_user()) { ?><td class="<?php echo $canEdit;?>"><?php echo $veh['shr_location'];?></td><?php } ?>
                                                                   <td class="<?php echo $canEdit;?>"><?php echo $veh['usr_first_name'];?></td>
                                                                   <td><?php echo date('j M Y', strtotime($veh['enq_entry_date']));?></td>
                                                              </tr>
                                                              <?php
                                                         }
                                                    }
                                                  ?>
                                             </tbody>
                                        </table>
                                   </div>
                                   <?php } ?>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>