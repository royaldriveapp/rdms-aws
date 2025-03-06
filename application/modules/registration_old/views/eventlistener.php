<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Event enquires</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <br />
                         <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" style="background: none;">
                                   <li role="presentation" class="active">
                                        <a href="#tab_enq" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Event Enquires</a>
                                   </li>
                                   <li role="presentation">
                                        <a href="#tab_luckyd" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Event Enquires Lucky Draw</a>
                                   </li>

                                   <li role="presentation">
                                        <a href="#tab_sales_event" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Sales Event</a>
                                   </li>
                                 
                                   <?php if (check_permission('productenquires', 'showwebhenquiriesassignedtome')) { //Show web enquiries assigned to me?>
                                   <li role="presentation">
                                   <a href="#tab_wb_enq" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Web Enquiries</a>
                                   </li>
                                   <?php } ?>
                                   <?php if (check_permission('productenquires', 'showvehenquiriesassignedtome')) { //Show web enquiries assigned to me?>
                                   <li role="presentation">
                                        <a href="#tab_veh_enq" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Vehicle Enquiries</a>
                                   </li>
                                   <?php } ?>
                              </ul>
                              <div id="myTabContent" class="tab-content">
                                   <div role="tabpanel" class="tab-pane fade active in" id="tab_enq" aria-labelledby="dar-tab">
                                        <?php if ($this->uid != 628) { // WHC 
                                        ?>
                                             <h3>
                                                  Event Enquires <a href="<?php echo site_url('registration/export_excel_event/evnt'); ?>">
                                                       <img style="float:right;" width="20" title="Export to excel" src="images/excel-export.png" /></a>
                                             </h3>
                                        <?php } ?>
                                        <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
                                             <table class="datatable-resp table table-striped table-bordered">
                                                  <thead>
                                                       <tr>
                                                            <th>Entry date</th>
                                                            <th>Customer name</th>
                                                            <th>Contact</th>
                                                            <th>NRI Number</th>
                                                            <th>Location</th>
                                                            <th>Email</th>
                                                            <th>Event</th>
                                                            <th>Reg no</th>
                                                            <th>Vehicle</th>
                                                            <th>Punched by</th>
                                                            <?php if (check_permission('registration', 'canpunch')) { ?>
                                                                 <th>Punch</th>
                                                            <?php }
                                                            if (check_permission('investors', 'canchangecontacted')) { ?>
                                                                 <th>WP Sent</th>
                                                            <?php } ?>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <?php foreach ((array) $datas['events'] as $key => $value) { ?>
                                                            <tr style="<?php echo ($value['eve_register_id'] == 0) ? 'color: #fff;background-color: red;' : ''; ?>">
                                                                 <td><?php echo date('j M Y', strtotime($value['eve_added_on'])); ?></td>
                                                                 <td><?php echo $value['eve_name']; ?></td>
                                                                 <td><a style="color: #fff;" target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['eve_mobile'] . '"'; ?>> <?php echo $value['eve_mobile']; ?> </a></td>
                                                                 <td><a style="color: #fff;" target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['eve_mobile_non_india'] . '"'; ?>> <?php echo $value['eve_mobile_non_india']; ?> </a></td>
                                                                 <td><?php echo $value['eve_location']; ?></td>
                                                                 <td><?php echo $value['eve_email']; ?></td>
                                                                 <td><?php echo $value['evnt_title']; ?></td>
                                                                 <td><?php echo $value['eve_vehicle_selected']; ?></td>
                                                                 <td><?php echo !empty($value['eve_vehicle_string']) ? $value['eve_vehicle_string'] : $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']; ?></td>
                                                                 <td>
                                                                      <?php
                                                                      if (!empty($value['assigedby'])) {
                                                                           echo '<a href="' . site_url('registration/registerSummary/' . $value['eve_register_id'] . '/' . $value['eve_id']) . '">' . $value['assigedby'] . '</a>';
                                                                      }
                                                                      ?>
                                                                 </td>
                                                                 <?php if (check_permission('registration', 'canpunch')) { ?>
                                                                      <td>
                                                                           <a title="Punch enquiry" href="<?php echo site_url($controller . '/punchEnquiry/' . $value['eve_id']); ?>">
                                                                                <i class="fa fa-pencil-square" title="Punch enquiry"></i>
                                                                           </a>
                                                                      </td>
                                                                 <?php }
                                                                 if (check_permission('investors', 'canchangecontacted')) { ?>
                                                                      <td>
                                                                           <input for="Latest" data-url="<?php echo site_url('registration/changesCheckBoxFields/eve_wp_sent/' . $value['eve_id']) ?>" class="chkStatus" type="checkbox" name="chkStatus" value="<?php echo $value['eve_wp_sent']; ?>" <?php echo ($value['eve_wp_sent'] == 1) ? "checked" : ''; ?> <?php echo ($value['eve_wp_sent'] == 1) ? "disabled" : ''; ?> />
                                                                      </td>
                                                                 <?php } ?>
                                                            </tr>
                                                       <?php } ?>
                                                  </tbody>
                                             </table>
                                        </div>
                                   </div>

                                   <div role="tabpanel" class="tab-pane fade" id="tab_luckyd" aria-labelledby="dar-tab">
                                        <h3>
                                             Event Enquires Lucky Draw <a href="<?php echo site_url('registration/export_excel_event'); ?>">
                                                  <img style="float:right;" width="20" title="Export to excel" src="images/excel-export.png" /></a>
                                        </h3>
                                        <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
                                             <table class="datatable-resp table table-striped table-bordered">
                                                  <thead>
                                                       <tr>
                                                            <th>Entry date</th>
                                                            <th>Customer name</th>
                                                            <th>Contact</th>
                                                            <th>NRI Number</th>
                                                            <th>Location</th>
                                                            <th>Email</th>
                                                            <th>Event</th>
                                                            <th>Reg no</th>
                                                            <th>Vehicle</th>
                                                            <th>Punched by</th>
                                                            <th>Referal name</th>
                                                            <th>Referal mobile NRI</th>
                                                            <th>Referal mobile IN</th>
                                                            <th>Referal location</th>
                                                            <?php if (check_permission('registration', 'canpunch')) { ?>
                                                                 <th>Punch</th>
                                                            <?php } ?>
                                                            <th>WP Sent</th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <?php foreach ((array) $datas['lucky'] as $key => $value) { ?>
                                                            <tr style="<?php echo ($value['eve_register_id'] == 0) ? 'color: #fff;background-color: red;' : ''; ?>">
                                                                 <td><?php echo date('j M Y', strtotime($value['eve_added_on'])); ?></td>
                                                                 <td><?php echo $value['eve_name']; ?></td>
                                                                 <td><a style="color: #fff;" target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['eve_mobile'] . '"'; ?>> <?php echo $value['eve_mobile']; ?> </a></td>
                                                                 <td><a style="color: #fff;" target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['eve_mobile_non_india'] . '"'; ?>> <?php echo $value['eve_mobile_non_india']; ?> </a></td>
                                                                 <td><?php echo $value['eve_location']; ?></td>
                                                                 <td><?php echo $value['eve_email']; ?></td>
                                                                 <td><?php echo $value['evnt_title']; ?></td>
                                                                 <td><?php echo $value['eve_vehicle_selected']; ?></td>
                                                                 <td><?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']; ?></td>
                                                                 <td>
                                                                      <?php
                                                                      if (!empty($value['assigedby'])) {
                                                                           echo '<a href="' . site_url('registration/registerSummary/' . $value['eve_register_id'] . '/' . $value['eve_id']) . '">' . $value['assigedby'] . '</a>';
                                                                      }
                                                                      ?>
                                                                 </td>
                                                                 <td><?php echo $value['eer_name']; ?></td>
                                                                 <td><?php echo $value['eer_mobile']; ?></td>
                                                                 <td><?php echo $value['eer_mobile_in']; ?></td>
                                                                 <td><?php echo $value['eer_location']; ?></td>
                                                                 <?php if (check_permission('registration', 'canpunch')) { ?>
                                                                      <td>
                                                                           <a title="Punch enquiry" href="<?php echo site_url($controller . '/punchEnquiry/' . $value['eve_id']); ?>">
                                                                                <i class="fa fa-pencil-square" title="Punch enquiry"></i>
                                                                           </a>
                                                                      </td>
                                                                 <?php } ?>
                                                                 <td>
                                                                      <input for="Latest" data-url="<?php echo site_url('registration/changesCheckBoxFields/eve_wp_sent/' . $value['eve_id']) ?>" class="chkStatus" type="checkbox" name="chkStatus" value="<?php echo $value['eve_wp_sent']; ?>" <?php echo ($value['eve_wp_sent'] == 1) ? "checked" : ''; ?> <?php echo ($value['eve_wp_sent'] == 1) ? "disabled" : ''; ?> />
                                                                 </td>
                                                            </tr>
                                                       <?php } ?>
                                                  </tbody>
                                             </table>
                                        </div>
                                   </div>

                                   <div role="tabpanel" class="tab-pane fade" id="tab_sales_event" aria-labelledby="dar-tab">
                                        <?php if ($this->uid != 628) { // WHC 
                                        ?>
                                             <h3>
                                                  Event Enquires <a href="<?php echo site_url('registration/export_excel_event/evnt'); ?>">
                                                       <img style="float:right;" width="20" title="Export to excel" src="images/excel-export.png" /></a>
                                             </h3>
                                        <?php } ?>
                                        <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
                                             <table class="datatable-resp table table-striped table-bordered">
                                                  <thead>
                                                       <tr>
                                                            <th>Entry date</th>
                                                            <th>Customer name</th>
                                                            <th>Contact</th>
                                                            <th>Email</th>
                                                            <th>Event</th>
                                                            <th>Department</th>
                                                            <th>Vehicle</th>
                                                            <th>State</th>
                                                            <th>District</th>
                                                            <th>Punched by</th>
                                                            <?php if (check_permission('registration', 'canpunch')) { ?>
                                                                 <th>Punch</th>
                                                            <?php }
                                                            if (check_permission('investors', 'canchangecontacted')) { ?>
                                                                 <th>WP Sent</th>
                                                            <?php } ?>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <?php foreach ((array) $datas['sales_events'] as $key => $value) { ?>
                                                            <tr style="<?php echo ($value['eve_register_id'] == 0) ? 'color: #fff;background-color: red;' : ''; ?>">
                                                                 <td><?php echo date('j M Y', strtotime($value['eve_added_on'])); ?></td>
                                                                 <td><?php echo $value['eve_name']; ?></td>
                                                                 <td><a style="color: #fff;" target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['eve_mobile'] . '"'; ?>> <?php echo $value['eve_mobile']; ?> </a></td>
                                                                 <td><?php echo $value['eve_email']; ?></td>
                                                                 <td><?php echo $value['evnt_title']; ?></td>
                                                                 <td><?php echo $value['dep_name']; ?></td>
                                                                 <td><?php echo !empty($value['eve_vehicle_string']) ? $value['eve_vehicle_string'] : $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']; ?></td>
                                                                 <th><?php echo $value['std_district_name']; ?> </th>
                                                                 <th><?php echo $value['sts_name']; ?></th>
                                                                 <td>
                                                                      <?php
                                                                      if (!empty($value['assigedby'])) {
                                                                           echo '<a href="' . site_url('registration/registerSummary/' . $value['eve_register_id'] . '/' . $value['eve_id']) . '">' . $value['assigedby'] . '</a>';
                                                                      }
                                                                      ?>
                                                                 </td>
                                                                 <?php if (check_permission('registration', 'canpunch')) { ?>
                                                                      <td>
                                                                           <a title="Punch enquiry" href="<?php echo site_url($controller . '/punchEnquiry/' . $value['eve_id']); ?>">
                                                                                <i class="fa fa-pencil-square" title="Punch enquiry"></i>
                                                                           </a>
                                                                      </td>
                                                                 <?php }
                                                                 if (check_permission('investors', 'canchangecontacted')) { ?>
                                                                      <td>
                                                                           <input for="Latest" data-url="<?php echo site_url('registration/changesCheckBoxFields/eve_wp_sent/' . $value['eve_id']) ?>" class="chkStatus" type="checkbox" name="chkStatus" value="<?php echo $value['eve_wp_sent']; ?>" <?php echo ($value['eve_wp_sent'] == 1) ? "checked" : ''; ?> <?php echo ($value['eve_wp_sent'] == 1) ? "disabled" : ''; ?> />
                                                                      </td>
                                                                 <?php } ?>
                                                            <?php } ?>
                                                            </tr>
                                                  </tbody>
                                             </table>
                                        </div>
                                   </div>
                                   <?php if (check_permission('productenquires', 'showwebhenquiriesassignedtome')) { //Show web enquiries assigned to me?>
                                         <!-- Web enq tab -->
                                         <div role="tabpanel" class="tab-pane fade" id="tab_wb_enq" aria-labelledby="dar-tab">
                                        <h3>
                                             Web Enquires <a href="<?php echo site_url('registration/export_excel_event'); ?>">
                                                  <img style="float:right;" width="20" title="Export to excel" src="images/excel-export.png" /></a>
                                        </h3>
                                        <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
                                             <table class="datatable-resp table table-striped table-bordered">
                                                  <thead>
                                                       <tr>
                                                            <th>Entry date</th>
                                                            <th>Customer name</th>
                                                            <th>Contact No</th>
                                                            <th>Email</th>
                                                            <th>Vehicle</th>
                                                            <th>Assigned To</th>

                                                            <?php if (check_permission('registration', 'canpunch')) { ?>
                                                                 <th>Punch</th>
                                                            <?php } ?>
                                                            <th>WP Sent</th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       <?php foreach ($datas['web_enq'] as $key => $value) { ?>
                                                            <tr style="<?php echo ($value['eve_register_id'] == 0) ? 'color: #fff;background-color: red;' : ''; ?>">
                                                                 <td><?php echo date('j M Y', strtotime($value['eve_added_on'])); ?></td>
                                                                 <td><?php echo $value['eve_name']; ?></td>
                                                                 <td><a style="color: #fff;" target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['eve_mobile'] . '"'; ?>> <?php echo $value['eve_mobile']; ?> </a></td>

                                                                 <td><?php echo $value['eve_email']; ?></td>
                                                                 <td><?php echo $value['eve_vehicle_string']; ?></td>
                                                                 <td><?php echo $value['usr_first_name']; //eve_assigned_to
                                                                      ?></td>




                                                                 <?php if (check_permission('registration', 'canpunch')) { ?>
                                                                      <td>
                                                                           <a title="Punch enquiry" href="<?php echo site_url($controller . '/punchEnquiry/' . $value['eve_id']); ?>">
                                                                                <i class="fa fa-pencil-square" title="Punch enquiry"></i>
                                                                           </a>
                                                                      </td>
                                                                 <?php } ?>
                                                                 <td>
                                                                      <input for="Latest" data-url="<?php echo site_url('registration/changesCheckBoxFields/eve_wp_sent/' . $value['eve_id']) ?>" class="chkStatus" type="checkbox" name="chkStatus" value="<?php echo $value['eve_wp_sent']; ?>" <?php echo ($value['eve_wp_sent'] == 1) ? "checked" : ''; ?> <?php echo ($value['eve_wp_sent'] == 1) ? "disabled" : ''; ?> />
                                                                 </td>
                                                            </tr>
                                                       <?php } ?>
                                                  </tbody>
                                             </table>
                                        </div>
                                   </div>
                                   <!-- End web enq tab -->
                                   <?php }  ?>
                              
                                   <?php if (check_permission('productenquires', 'showvehenquiriesassignedtome')) { //Show web enquiries assigned to me?>
                                                                   <!-- vehicle enq tab -->
<div role="tabpanel" class="tab-pane fade" id="tab_veh_enq" aria-labelledby="dar-tab">
     <h3>
     Vehicle Enquires <a href="<?php echo site_url('registration/export_excel_event'); ?>">
               <img style="float:right;" width="20" title="Export to excel" src="images/excel-export.png" /></a>
     </h3>
     <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
          <table class="datatable-resp table table-striped table-bordered">
               <thead>
                    <tr>
                         <th>Entry date</th>
                         <th>Customer name</th>
                         <th>Contact No</th>
                         <th>Email</th>
                         <th>Vehicle</th>
                         <th>Assigned To</th>

                         <?php if (check_permission('registration', 'canpunch')) { ?>
                              <th>Punch</th>
                         <?php } ?>
                         <th>WP Sent</th>
                    </tr>
               </thead>
               <tbody>
                    <?php foreach ($datas['veh_enq'] as $key => $value) { ?>
                         <tr style="<?php echo ($value['eve_register_id'] == 0) ? 'color: #fff;background-color: red;' : ''; ?>">
                              <td><?php echo date('j M Y', strtotime($value['eve_added_on'])); ?></td>
                              <td><?php echo $value['eve_name']; ?></td>
                              <td><a style="color: #fff;" target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['eve_mobile'] . '"'; ?>> <?php echo $value['eve_mobile']; ?> </a></td>

                              <td><?php echo $value['eve_email']; ?></td>
                              <td><?php echo $value['eve_vehicle_string']; ?></td>
                              <td><?php echo $value['usr_first_name']; //eve_assigned_to
                                   ?></td>




                              <?php if (check_permission('registration', 'canpunch')) { ?>
                                   <td>
                                        <a title="Punch enquiry" href="<?php echo site_url($controller . '/punchEnquiry/' . $value['eve_id']); ?>">
                                             <i class="fa fa-pencil-square" title="Punch enquiry"></i>
                                        </a>
                                   </td>
                              <?php } ?>
                              <td>
                                   <input for="Latest" data-url="<?php echo site_url('registration/changesCheckBoxFields/eve_wp_sent/' . $value['eve_id']) ?>" class="chkStatus" type="checkbox" name="chkStatus" value="<?php echo $value['eve_wp_sent']; ?>" <?php echo ($value['eve_wp_sent'] == 1) ? "checked" : ''; ?> <?php echo ($value['eve_wp_sent'] == 1) ? "disabled" : ''; ?> />
                              </td>
                         </tr>
                    <?php } ?>
               </tbody>
          </table>
     </div>
</div>
<!-- End vehicle enq tab -->
<?php } ?>

                              </div>
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