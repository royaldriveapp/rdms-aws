<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="<?php echo site_url('enquiry/index'); ?>" method="get">
                              <table>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="search" type="text" class="form-control col-md-7 col-xs-12" placeholder="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
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
                                             <th>Customer ID</th>
                                             <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG' || $this->usr_grp == 'TL') ? '<th>Sales Executive</th>' : ''; ?>
                                             <th>Added By</th>
                                             <th>Name</th>
                                             <th>Mobile</th>
                                             <th>Whatsapp</th>
                                             <th>Enquiry Date</th>
                                             <th>Action</th>
                                             <th>Enq Status</th>
                                             <th>Enq Mod</th>
                                             <th>Cust Status</th>
                                             <th>Enq Type</th>
                                             <?php echo check_permission('enquiry', 'showregnoonenqlist') ? "<th>Veh Reg no</th><th>Vehicle</th>" : ""; ?>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                        if (!empty($enquires)) {
                                             foreach ($enquires as $key => $value) {
                                                  $stsUpdateUrl = '<a style="margin-left: 10px;" title="Update call status" href="' . site_url('enquiry/specialcomments/' . encryptor($value['enq_id'])) . '"><i class="fa fa-calendar-check-o"></i></a>';
                                                  $purchaseVehicleRegNo = '';
                                                  $vehicle = '';
                                                  if (check_permission('enquiry', 'showregnoonenqlist')) {
                                                       $purchaseVehicleRegNo = $this->enquiry->getPurchaseVehicleNumber($value['enq_id']);
                                                       $vehicle = $this->enquiry->getVehicleByEnquiryId($value['enq_id']);
                                                  }

                                                  //                                               $followDate = $this->followup->getNextFollowupDate($value['enq_id']);
                                                  //                                               $now = date('Y-m-d');
                                                  //                                               $date1 = new DateTime($follupDate = date('Y-m-d', strtotime($followDate['foll_next_foll_date'])));
                                                  //                                               $date2 = new DateTime($now);
                                                  $follLink = '';
                                                  //                                               if (!is_roo_user()) {
                                                  //                                                    if ($date2->diff($date1)->format("%r%a") >= -2) {
                                                  //                                                         $follLink = '<a style="margin-left: 10px;" title="Followup" href="' . site_url('followup_new/viewFollowup/' . encryptor($value['enq_id'])) . '">
                                                  //                                                              <i class="fa fa-calendar-check-o"></i>
                                                  //                                                         </a>';
                                                  //                                                    }
                                                  //                                               } else {
                                                  $follLink = '<a style="margin-left: 10px;" title="Followup" href="' . site_url('followup/viewFollowup/' . encryptor($value['enq_id'])) . '">
                                                              <i class="fa fa-calendar-check-o"></i>
                                                         </a>';
                                                  //                                               }
                                        ?>
                                                  <tr data-url="<?php echo site_url('enquiry/view_change/' . encryptor($value['enq_id'])); ?>">
                                                       <th class="trVOE"><?php echo $value['enq_number']; ?></th>
                                                       <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG' || $this->usr_grp == 'TL') ? '<td class="trVOE">' . strtoupper($value['usr_first_name']) . '</td>' : ''; ?>
                                                       <td class="trVOE"><?php echo ($this->uid == $value['enq_se_id']) ? 'Self' : $value['enq_added_by_name']; ?></td>
                                                       <td class="trVOE"><?php echo strtoupper($value['cusd_name']); ?></td>
                                                       <td style="white-space: nowrap;">
                                                            <?php
                                                            $customer_phones = !empty($value['phone_numbers']) ? explode(', ', $value['phone_numbers']) : [];

                                                            if (!empty($customer_phones)) {
                                                                 foreach ($customer_phones as $phone) {
                                                                      $clean_number = preg_replace('/[^0-9+]/', '', trim($phone)); // Trim spaces
                                                                      echo '<a target="blank" style="color: rgb(0, 0, 0); text-decoration: none;" 
                href="tel:' . htmlspecialchars($clean_number) . '" 
                class="action" 
                title="Call ' . htmlspecialchars($clean_number) . '"
                onclick="return navigator.userAgent.match(/mobile/i)">';
                                                                      echo '<i class="fa fa-phone" style="color: rgb(40, 53, 66); margin-right: 5px;"></i>';
                                                                      echo htmlspecialchars($clean_number);
                                                                      echo '</a><br>';
                                                                 }
                                                            } else {
                                                                 echo '<span>No phone numbers available</span>';
                                                            }
                                                            ?>
                                                       </td>
                                                       <td style="white-space: nowrap;"> <a target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['cusd_whatsapp'] . '"'; ?>> <i class="fa fa-whatsapp" style="color: #25D366; margin-right: 5px;"></i> <?php echo $value['cusd_whatsapp']; ?> </a></td>
                                                       <td class="trVOE"><?php echo date('j M Y', strtotime($value['enq_entry_date'])); ?></td>
                                                       <td>
                                                            <a title="Print track card" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($value['enq_id'])); ?>">
                                                                 <span class="glyphicon glyphicon-print"></span>
                                                            </a>
                                                            <?php echo $follLink; ?>
                                                            <?php //echo $stsUpdateUrl;
                                                            ?>
                                                            <?php if (check_permission('enquiry', 'reassignenquiry')) { ?>
                                                                 <a title="Re-assign enquiries" href="javascript:void(0)" data-toggle="modal" data-target="#enq<?php echo $value['enq_id']; ?>">
                                                                      <i class="fa fa-repeat" title="Re assign enquires"></i>
                                                                 </a>
                                                            <?php } ?>
                                                       </td>
                                                       <td class="trVOE"><?php echo $value['sts_title']; ?></td>
                                                       <td>
                                                            <?php
                                                            $cntMods = unserialize(MODE_OF_CONTACT);
                                                            echo $cntMods = isset($cntMods[$value['enq_mode_enq']]) ? $cntMods[$value['enq_mode_enq']] : '';
                                                            ?>
                                                            <!--Enq Mod-->
                                                       </td>
                                                       <td>
                                                            <!--Enq type-->
                                                            <?php
                                                            $stsMods = unserialize(ENQUIRY_UP_STATUS);
                                                            echo $stsMods = isset($stsMods[$value['enq_cus_when_buy']]) ? $stsMods[$value['enq_cus_when_buy']] : '';

                                                            if (check_permission('enquiry', 'reassignenquiry')) {
                                                            ?>
                                                                 <div class="modal fade" id="enq<?php echo $value['enq_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                      <div class="modal-dialog" role="document">
                                                                           <div class="modal-content">
                                                                                <form action="<?php echo site_url('enquiry/reassignenquiry'); ?>" method="post">
                                                                                     <div class="modal-header">
                                                                                          <h5 class="modal-title" id="exampleModalLabel" style="float:left;">Modal title</h5>
                                                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                               <span aria-hidden="true">&times;</span>
                                                                                          </button>
                                                                                     </div>
                                                                                     <div class="modal-body">

                                                                                          <input type="hidden" name="enq_id" value="<?php echo $value['enq_id']; ?>" />
                                                                                          <input type="hidden" name="old_se_id" value="<?php echo $value['enq_se_id']; ?>" />

                                                                                          <table class="table table-striped table-bordered">
                                                                                               <tr>
                                                                                                    <td>Sales staff</td>
                                                                                                    <td><?php echo $value['usr_first_name']; ?></td>
                                                                                               </tr>
                                                                                               <tr>
                                                                                                    <td>Customer name</td>
                                                                                                    <td><?php echo $value['cusd_name']; ?></td>
                                                                                               </tr>
                                                                                               <tr>
                                                                                                    <td>Customer number</td>
                                                                                                    <td><?php echo $value['enq_cus_mobile']; ?></td>
                                                                                               </tr>
                                                                                               <tr>
                                                                                                    <td>Mod of enquiry</td>
                                                                                                    <td><?php echo $cntMods; ?></td>
                                                                                               </tr>
                                                                                               <tr>
                                                                                                    <td>Enquiry type</td>
                                                                                                    <td><?php echo $stsMods; ?></td>
                                                                                               </tr>
                                                                                               <tr>
                                                                                                    <td>Assign to</td>
                                                                                                    <td>
                                                                                                         <select name="new_se_id" class="form-control col-md-7 col-xs-12" required>
                                                                                                              <option value="">Select new staff</option>
                                                                                                              <?php foreach ($staffs as $skey => $stf) { ?>
                                                                                                                   <option value="<?php echo $stf['usr_id']; ?>"><?php echo $stf['usr_first_name']; ?></option>
                                                                                                              <?php } ?>
                                                                                                         </select>
                                                                                                    </td>
                                                                                               </tr>
                                                                                               <tr>
                                                                                                    <td colspan="2">
                                                                                                         <textarea name="remark" required class="form-control col-md-7 col-xs-12" placeholder="Reson for re-assign enquires"></textarea>
                                                                                                    </td>
                                                                                               </tr>
                                                                                          </table>
                                                                                     </div>
                                                                                     <div class="modal-footer">
                                                                                          <button type="submit" class="btn btn-primary">Submit</button>
                                                                                     </div>
                                                                                </form>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            <?php } ?>
                                                       </td>
                                                       <td>
                                                            <?php if (isset($value['enq_cus_status'])) {
                                                                 if ($value['enq_cus_status'] == 1) {
                                                                      echo 'Sales';
                                                                 } else if ($value['enq_cus_status'] == 2) {
                                                                      echo 'Purchase';
                                                                 } else {
                                                                      echo 'Exchange';
                                                                 }
                                                            } ?>
                                                       </td>
                                                       <?php echo check_permission('enquiry', 'showregnoonenqlist') ? "<td>" . $purchaseVehicleRegNo . " -- </td>" : ""; ?>
                                                       <?php echo check_permission('enquiry', 'showregnoonenqlist') ? '<td>' . $vehicle . "</td>" : ""; ?>
                                                       <?php if ($this->uid == 100) { ?>
                                                            <td>
                                                                 <a href="<?php echo site_url($controller . '/permenentDelete/' . $value['enq_id']); ?>">
                                                                      <i class="fa fa-remove"></i>
                                                                 </a>
                                                            </td>
                                                       <?php } ?>
                                                  </tr>
                                        <?php
                                             }
                                        }
                                        ?>
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