<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="<?php echo site_url('reports/darEnquires/');?>" method="get">
                              <table>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="enq_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                  placeholder="Date from" value="<?php echo isset($_GET['enq_date_from']) ? $_GET['enq_date_from'] : '';?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <input autocomplete="off" name="enq_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                  placeholder="Date to" value="<?php echo isset($_GET['enq_date_to']) ? $_GET['enq_date_to'] : '';?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control cmbSalesExecutives" name="executive[]">
                                                  <option value="<?php echo $this->uid; ?>">My self</option>
                                                       <?php foreach ((array) $salesExecutives as $key => $value) {
                                                            if(!empty($value['usr_first_name'])) {
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
                                                       }
                                                  ?>
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
                                        <?php if (check_permission('reports', 'viewfollowupfromreport')) { ?>
                                             <th>Followup</th>
                                        <?php } ?>
                                        <th>Status</th>
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
                                                    <td class="<?php echo $canEdit;?>"><?php echo $veh['ab_usr_username'];?></td>
                                               <?php }?>
                                               <td><?php echo date('j M Y', strtotime($veh['enq_entry_date']));?></td>
                                               <td>
                                                  <?php
                                                  echo (isset($lastFollowupDate['foll_entry_date']) && !empty($lastFollowupDate['foll_entry_date'])) ?
                                                          date('j M Y', strtotime($lastFollowupDate['foll_entry_date'])) : '';
                                                  ?>
                                                </td>
                                                <td><?php echo date('j M Y', strtotime($veh['enq_next_foll_date'])); ?></td>    
                                                <?php if (check_permission('reports', 'viewfollowupfromreport')) { ?>
                                                  <td>
                                                       <a style="margin-left: 10px;" title="Followup" href="<?php echo site_url('followup/viewFollowup/' . encryptor($veh['enq_id'])) ?>">
                                                            <i class="fa fa-calendar-check-o"></i>
                                                       </a>
                                                  </td>
                                                <?php } ?>
                                                <td><?php echo $veh['sts_title'];?></td>
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
                    </div>
               </div>
          </div>
     </div>
</div>