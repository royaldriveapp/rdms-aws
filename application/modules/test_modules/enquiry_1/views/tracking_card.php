<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Track card for <?php echo $trackCard['enq_cus_name'];?></h2>
                         <div style="float: right;">
                              <?php
                                if ($trackCard['sgrd_need_verification'] == 1) {
                                     if ($trackCard['enq_customer_grade_verify_by'] != 0) {
                                          echo $trackCard['sgrd_grade'];
                                     } else {
                                          echo 'Not verified';
                                     }
                                } else {
                                     echo $trackCard['sgrd_grade'];
                                }
                              ?>
                         </div>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form class="form_wizard wizard_horizontal" action="#" role="form" data-toggle="validator" method="post" accept-charset="utf-8">
                              <table class="table tblPrintHeader" style="border-bottom: 2px solid #ffcb05;">
                                   <tbody>
                                        <tr>
                                             <td><img src="./images/logo.jpg"/></td>
                                             <td style="text-align: center;padding-top: 50px;"><strong>TRACK CARD</strong></td>
                                             <td style="text-align: right;"><?php echo isset($showRoom['shr_address']) ? $showRoom['shr_address'] : '';?></td>
                                        </tr>
                                   </tbody>
                              </table>

                              <table class="table table-striped table-bordered" style="margin-left: auto; margin-right: auto;">
                                   <tbody>
                                        <tr style="height: 35px;">
                                             <td style="width: 670px; height: 35px;" colspan="7">
                                                  <p style="text-align: center;"><strong>ROYAL DRIVE Pre Owned Cars LLP <?php echo $trackCard['shr_location'];?></strong></p>
                                             </td>
                                        </tr>
                                        <tr style="height: 48px;">
                                             <td style="width: 498px; height: 48px;" colspan="4">
                                                  <p style="text-align: left;"><strong>Name of Executive : <?php echo $trackCard['usr_first_name'];?></strong></p>
                                             </td>
                                             <td style="width: 166px; height: 48px;" colspan="3">
                                                  <p>
                                                       <strong>Enquiry Date : <?php echo date('j M Y', strtotime($trackCard['enq_entry_date']));?></strong><br>
                                                       <strong>Entry Date : <?php echo date('j M Y h:i A', strtotime($trackCard['enq_added_on']));?></strong>
                                                  </p>
                                             </td>
                                        </tr>

                                        <tr style="height: 48px;">
                                             <td colspan="4">
                                                  <p>
                                                       <strong>Status: </strong><strong><?php
                                                              $statuses = unserialize(ENQUIRY_UP_STATUS);
                                                              echo isset($statuses[$trackCard['enq_cus_when_buy']]) ? $statuses[$trackCard['enq_cus_when_buy']] : '';
                                                            ?>
                                                       </strong>
                                                       <span style="float: right;">
                                                            <strong>Enquiry Current Status: </strong>
                                                            <strong><?php echo $trackCard['sts_title'];?></strong>
                                                       </span>
                                                  </p>
                                             </td>
                                             <td colspan="3">
                                                  <p>
                                                       <strong>Mode of Enquiry: <?php
                                                              $mod = unserialize(MODE_OF_CONTACT);
                                                              echo isset($mod[$trackCard['enq_mode_enq']]) ? $mod[$trackCard['enq_mode_enq']] : '';
                                                              
                                                              $regmod1 = (isset($mod[$trackCard['regAssigned']['0']['vreg_contact_mode']]) && !empty($mod[$trackCard['regAssigned']['0']['vreg_contact_mode']])) ?
                                                              $mod[$trackCard['regAssigned']['0']['vreg_contact_mode']] : ''; 

                                                              echo (isset($trackCard['regAssigned']['0']['usr_username']) && !empty($trackCard['regAssigned']['0']['usr_username'])) ? 
                                                                 '<br>Last assigned by : ' . $trackCard['regAssigned']['0']['usr_username'] . 
                                                                 ' (' . date('d-m-Y', strtotime($trackCard['regAssigned']['0']['vreg_first_added_on'])) . ') - ' . $regmod1 : '';
                                                              
                                                              $firt = end($trackCard['regAssigned']); 

                                                              $regmod2 = (isset($mod[$firt['vreg_contact_mode']]) && !empty($mod[$firt['vreg_contact_mode']])) ? $mod[$firt['vreg_contact_mode']] : ''; 

                                                              echo (isset($firt['usr_username']) && !empty($firt['usr_username'])) ? 
                                                                   '<br>First assigned by : ' . $firt['usr_username'] . ' (' . date('d-m-Y', strtotime($firt['vreg_first_added_on'])) . ') - ' . $regmod2 : '';
                                                              
                                                                   
                                                            ?>
                                                       </strong>
                                                  </p>
                                             </td>
                                        </tr>

                                        <tr style="height: 35px;">
                                             <td style="width: 670px; height: 35px;" colspan="7">
                                                  <p style="text-align: center;"><strong>Customer Details</strong></p>
                                             </td>
                                        </tr>

                                        <tr style="height: 35px;">
                                             <td style="width: 150px; height: 35px;">
                                                  <p><strong>Customer ID : <?php echo generate_vehicle_virtual_id($trackCard['enq_id'])?></strong></p>
                                             </td>
                                             <td style="width: 250px; height: 35px;" colspan="2">
                                                  <p><strong>Name: <?php echo $trackCard['enq_cus_name']?></strong></p>
                                             </td>
                                             <td style="width: 166px; height: 35px;" colspan="5">
                                                  <p><strong>Place: <?php echo $trackCard['cit_name']?></strong></p>
                                             </td>
                                        </tr>

                                        <tr style="height: 35px;">
                                             <td style="width: 498px; height: 105px;" colspan="4" rowspan="3">
                                                  <p>Address: <?php echo $trackCard['enq_cus_address']?></p>
                                             </td>

                                             <td style="width: 166px; height: 35px;" colspan="3">
                                                  <p>Mobile: <?php echo $trackCard['enq_cus_mobile']?></p>
                                             </td>
                                        </tr>

                                        <tr style="height: 35px;">
                                             <td style="width: 166px; height: 35px;" colspan="3">
                                                  <p>Whataspp: <?php echo $trackCard['enq_cus_whatsapp']?></p>
                                             </td>
                                        </tr>

                                        <tr style="height: 35px;">
                                             <td style="width: 166px; height: 35px;" colspan="3">
                                                  <p>Email: <?php echo $trackCard['enq_cus_email']?></p>
                                             </td>
                                        </tr>

                                        <tr style="height: 35px;">
                                             <td style="width: 498px; height: 35px;" colspan="4">
                                                  <p>Age group: <?php echo $trackCard['enq_cus_age_group']?></p>
                                             </td>
                                             <td style="width: 166px; height: 35px;" colspan="3">
                                                  <p>FB ID: <?php echo $trackCard['enq_cus_fbid']?></p>
                                             </td>
                                        </tr>

                                        <tr style="height: 35px;">
                                             <td style="width: 498px; height: 35px;" colspan="4">
                                                  <p>Occupation: <?php echo $trackCard['occ_name']?> </p>
                                             </td>
                                             <td style="width: 166px; height: 35px;" colspan="3">
                                                  <p>Company: <?php echo $trackCard['usr_company']?></p>
                                             </td>
                                        </tr>

                                        <tr style="height: 35px;">
                                             <td style="width: 292px; height: 35px;" colspan="3">
                                                  <p><strong>District: <?php echo $trackCard['std_district_name']?></strong></p>
                                             </td>
                                             <td style="width: 209px; height: 35px;" colspan="3">
                                                  <p><strong>State: <?php echo $trackCard['stt_name']?></strong></p>
                                             </td>
                                             <td style="width: 157px; height: 35px;">
                                                  <p><strong>Pin: <?php echo!empty($trackCard['enq_cus_pin']) ? $trackCard['enq_cus_pin'] : '';?></strong></p>
                                             </td>
                                        </tr>
                                        <tr style="height: 35px;">
                                             <td style="width: 100%; height: 35px;" colspan="7">
                                                  <p>
                                                       <strong>Type: <?php
                                                              if ($trackCard['enq_cus_status'] == 1) {
                                                                   echo 'Sell';
                                                              } else if ($trackCard['enq_cus_status'] == 2) {
                                                                   echo 'Buy';
                                                              } else {
                                                                   echo 'Exchange';
                                                              }
                                                            ?>
                                                       </strong>
                                                  </p>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>

                              <?php if (isset($trackCard['questions']) && !empty($trackCard['questions'])) {?>
                                     <table class="tblSale table table-striped table-bordered" style="width: 100%;">
                                          <tbody>
                                               <tr>
                                                    <th colspan="8" style="text-align:center;">Inquiry questions</th>
                                               </tr>
                                               <?php
                                               foreach ($trackCard['questions'] as $key => $value) {
                                                    ?>
                                                    <tr>
                                                         <td><?php echo strip_tags($value['qus_question']);?></td>
                                                         <td><?php echo $value['enqq_answer'];?></td>
                                                    </tr>
                                               <?php }?>
                                          </tbody>
                                     </table>
                                <?php }if (isset($trackCard['vehicle_sall']) && !empty($trackCard['vehicle_sall'])) {?>

                                     <table class="tblSale table table-striped table-bordered" style="width: 100%;">
                                          <tbody>
                                               <tr>
                                                    <th colspan="8" style="text-align:center;">Sales vehicle</th>
                                               </tr>

                                               <tr>
                                                    <th>Brand, Model, Variant</th>
                                                    <th>Fuel</th>
                                                    <th>Year</th>
                                                    <th>Color</th>
                                                    <th>Price : From - To</th>
                                                    <th>KM : From - To</th>
                                                    <th>Registration</th>
                                                    <th>Owner</th>
                                               </tr>
                                               <?php
                                               foreach ($trackCard['vehicle_sall'] as $key => $value) {

                                                    $fual = unserialize(FUAL);
                                                    $fual = isset($fual[$value['veh_fuel']]) ? $fual[$value['veh_fuel']] : '';
                                                    $year = !empty($value['veh_year']) ? $value['veh_year'] : '';
                                                    $color = !empty($value['veh_color']) ? $value['veh_color'] : '';

                                                    $pricef = !empty($value['veh_price_from']) ? $value['veh_price_from'] : '';
                                                    $pricet = !empty($value['veh_price_to']) ? ' - ' . $value['veh_price_to'] : '';
                                                    $price = $pricef . $pricet;

                                                    $kmf = !empty($value['veh_km_from']) ? $value['veh_km_from'] : '';
                                                    $kmt = !empty($value['veh_km_to']) ? ' - ' . $value['veh_km_to'] : '';
                                                    $km = $kmf . $kmt;

                                                    $reg = !empty($value['veh_reg']) ? $value['veh_reg'] : '';
                                                    $own = !empty($value['veh_owner']) ? $value['veh_owner'] : '';
                                                    ?>
                                                    <tr>
                                                         <td><?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name'];?></td>
                                                         <td><?php echo $fual;?></td>
                                                         <td><?php echo $year;?></td>
                                                         <td><?php echo $color;?></td>
                                                         <td><?php echo $price;?></td>
                                                         <td><?php echo $km;?></td>
                                                         <td><?php echo $reg;?></td>
                                                         <td><?php echo $own;?></td>
                                                    </tr>
                                               <?php }?>
                                          </tbody>
                                     </table>
                                <?php } if (isset($trackCard['vehicle_buy']) && !empty($trackCard['vehicle_buy'])) {?>
                                     <table class="table table-striped table-bordered" style="width: 100%;">
                                          <tbody>
                                               <tr>
                                                    <th colspan="8" style="text-align:center;">Exchange vehicle</th>
                                               </tr>
                                               <tr>
                                                    <th>Brand, Model, Variant</th>
                                                    <th>Fuel</th>
                                                    <th>Year</th>
                                                    <th>Color</th>
                                                    <th>Price : From - To</th>
                                                    <th>KM : From - To</th>
                                                    <th>Registration</th>
                                                    <th>Owner</th>
                                               </tr>
                                               <?php
                                               foreach ($trackCard['vehicle_buy'] as $key => $value) {

                                                    $fual = unserialize(FUAL);
                                                    $fual = isset($fual[$value['veh_fuel']]) ? $fual[$value['veh_fuel']] : '';
                                                    $year = !empty($value['veh_year']) ? $value['veh_year'] : '';
                                                    $color = !empty($value['veh_color']) ? $value['veh_color'] : '';

                                                    $pricef = !empty($value['veh_price_from']) ? $value['veh_price_from'] : '';
                                                    $pricet = !empty($value['veh_price_to']) ? ' - ' . $value['veh_price_to'] : '';
                                                    $price = $pricef . $pricet;

                                                    $kmf = !empty($value['veh_km_from']) ? $value['veh_km_from'] : '';
                                                    $kmt = !empty($value['veh_km_to']) ? ' - ' . $value['veh_km_to'] : '';
                                                    $km = $kmf . $kmt;

                                                    $reg = !empty($value['veh_reg']) ? $value['veh_reg'] : '';
                                                    $own = !empty($value['veh_owner']) ? $value['veh_owner'] : '';
                                                    ?>
                                                    <tr>
                                                         <td><?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name'];?></td>
                                                         <td><?php echo $fual;?></td>
                                                         <td><?php echo $year;?></td>
                                                         <td><?php echo $color;?></td>
                                                         <td><?php echo $price;?></td>
                                                         <td><?php echo $km;?></td>
                                                         <td><?php echo $reg;?></td>
                                                         <td><?php echo $own;?></td>
                                                    </tr>
                                               <?php }?>
                                          </tbody>
                                     </table>
                                <?php }?>

                              <?php if (!empty($trackCard['enq_cus_loan_perc']) && !empty($trackCard['enq_cus_loan_amount']) && !empty($trackCard['enq_cus_loan_emi']) && !empty($trackCard['enq_cus_loan_period'])) {
                                     ?>
                                     <table class="table table-striped table-bordered">
                                          <tr>
                                               <th>Loan Availability (%)</th>
                                               <th>Loan Amount</th>
                                               <th>Loan EMI</th>
                                               <th>Total Loan Period</th>
                                          </tr>
                                          <tr>
                                               <th><?php echo $trackCard['enq_cus_loan_perc'];?></th>
                                               <th><?php echo!empty($trackCard['enq_cus_loan_amount']) ? $trackCard['enq_cus_loan_amount'] : '';?></th>
                                               <th><?php echo!empty($trackCard['enq_cus_loan_emi']) ? $trackCard['enq_cus_loan_emi'] : '';?></th>
                                               <th><?php echo!empty($trackCard['enq_cus_loan_period']) ? $trackCard['enq_cus_loan_period'] : '';?></th>
                                          </tr>
                                     </table>
                                <?php } if (isset($trackCard['followup']) && !empty($trackCard['followup'])) {?>
                                     <ul class="list-unstyled timeline">
                                          <?php
                                          $totalVehicles = count($trackCard['vehicle_sall']) + count($trackCard['vehicle_buy']);
                                          $index = 0;
                                          //debug($trackCard['followup']);
                                          foreach ((array) $trackCard['followup'] as $key => $value) {
                                               if (($value['foll_is_cmnt'] == 1) && ($value['foll_parent'] == 0)) {
                                                    if ((check_permission('folup_trck_comment', 'viewgeneralcomment'))) {
                                                         ?>
                                                         <li>
                                                              <div class="block">
                                                                   <div class="tags" style="width: 32%;">
                                                                        <div class="profile_pic">
                                                                             <?php
                                                                             echo img(array('src' => './assets/uploads/avatar/' . $value['usr_avatar'], 'class' => 'img-circle profile_img', 'style' => 'margin:0px 0px;'));
                                                                             ?>
                                                                        </div>
                                                                   </div>
                                                                   <div class="block_content">
                                                                        <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                             <span><i class="fa fa-clock-o"></i> <?php echo date('Y-m-d h:i:s', strtotime($value['foll_entry_date']));?></span>
                                                                        </p>
                                                                        <?php
                                                                        echo!empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : '';
                                                                        ?>
                                                                   </div>
                                                                   <!-- Repeated contents -->
                                                                   <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;">
                                                                        <p class="excerpt"><?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : '';?></p>
                                                                   </div>
                                                                   <?php if ($value['folloup_added_by_id'] != $this->uid) {?>
                                                                        <p class="excerpt alignright">Added by : <?php
                                                                             echo isset($value['folloup_added_by']) ?
                                                                                     $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                                                                             ?>
                                                                        </p>
                                                                   <?php } else {?>
                                                                        <p class="excerpt alignright">Added by : Self</p>
                                                                   <?php }?>
                                                                   <?php echo date('d-m-Y h:i:s', strtotime($value['foll_entry_date']));?>
                                                              </div>
                                                         </li>
                                                         <?php
                                                    }
                                               } else {
                                                    ?>
                                                    <li>
                                                         <div class="block">
                                                              <?php
                                                              if ($key % $totalVehicles == 0) {
                                                                   if ($value['foll_status'] == 1) { // Hot
                                                                        ?><style>.tagcolor<?php echo $value['foll_id'];?> {background:red;} .tagcolor<?php echo $value['foll_id'];?>::after{border-left:11px solid red}</style> <?php
                                                                   } else if ($value['foll_status'] == 2) { // Warm
                                                                        ?><style>.tagcolor<?php echo $value['foll_id'];?> {background:yellowgreen;} .tagcolor<?php echo $value['foll_id'];?>::after{border-left:11px solid yellowgreen}</style> <?php
                                                                   } else if ($value['foll_status'] == 3) { // Cool
                                                                        ?><style>.tagcolor<?php echo $value['foll_id'];?> {background:green;} .tagcolor<?php echo $value['foll_id'];?>::after{border-left:11px solid green}</style> <?php }
                                                                   ?>

                                                                   <div class="tags">
                                                                        <a data-url="<?php echo site_url('followup/getSingleFollowup') . '/' . encryptor($trackCard['enq_id']) . '/' . date('Y-m-d', strtotime($value['foll_next_foll_date']));?>" 
                                                                           href="javascript:;" class="tagcolor<?php echo $value['foll_id'];?> tag"
                                                                           min-date="<?php echo date('D M d Y', strtotime($value['foll_next_foll_date']));?>">
                                                                             <span><?php echo date('j M Y', strtotime($value['foll_next_foll_date']));?></span>
                                                                        </a>
                                                                   </div>
                                                              <?php }?>
                                                              <div class="block_content">
                                                                   <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                        <span><i class="fa fa-car"></i> <?php echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name']?></span>
                                                                   </p>
                                                                   <?php echo!empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : '';?>
                                                              </div>
                                                              <!-- Repeated contents -->
                                                              <?php if ((($key + 1) % $totalVehicles) == 0) {?>
                                                                   <div style="font-style: italic;background: #E7E7E7;padding: 10px;">
                                                                        <p class="excerpt">Remarks : <?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : '';?></p>
                                                                        <p class="excerpt">
                                                                             <?php
                                                                             $mod = unserialize(MODE_OF_CONTACT);
                                                                             echo isset($mod[$value['foll_contact']]) ? 'Mode of contact : ' . $mod[$value['foll_contact']] : ''
                                                                             ?>
                                                                        </p>
                                                                        <p class="excerpt">Next action plan : <?php echo isset($value['foll_action_plan']) ? $value['foll_action_plan'] : '';?></p>
                                                                   </div>
                                                              <?php } if ($value['folloup_added_by_id'] != $this->uid) {?>
                                                                   <p class="excerpt alignright">Added by : <?php
                                                                        echo isset($value['folloup_added_by']) ? $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                                                                        ?>
                                                                   </p>
                                                              <?php } else {?>
                                                                   <p class="excerpt alignright">Added by : Self</p>
                                                              <?php }?>
                                                              <?php echo date('Y-m-d h:i:s', strtotime($value['foll_entry_date']));?>
                                                              <!-- Load comments -->
                                                              <?php
                                                              if (check_permission('folup_trck_comment', 'viewindividualcomment')) {
                                                                   $comments = $this->followup->getComments($value['foll_id']);
                                                                   if (!empty($comments)) {
                                                                        foreach ($comments as $k => $cmd) {
                                                                             ?>
                                                                             <div style="width: 100%;float: left;">
                                                                                  <div class="block_content">
                                                                                       <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                       <div><i class="fa fa-clock-o"></i> 
                                                                                            <?php if ($cmd['folloup_added_by_id'] != $this->uid) {?>
                                                                                                 <p class="excerpt alignright">Added by : <?php
                                                                                                      echo isset($cmd['folloup_added_by']) ? $cmd['folloup_added_by'] . ' (' . $cmd['shr_location'] . ')' : '';
                                                                                                      ?>
                                                                                                 </p>
                                                                                            <?php } else {?>
                                                                                                 <p class="excerpt alignright">Added by : Self</p>
                                                                                            <?php }?>
                                                                                            <?php echo date('Y-m-d h:i:s', strtotime($cmd['foll_entry_date']));?>
                                                                                       </p>
                                                                                  </div>
                                                                                  <div class="tags" style="width: 25%;position: inherit;">
                                                                                       <div class="profile_pic">
                                                                                            <?php
                                                                                            echo img(array('src' => './assets/uploads/avatar/' . $cmd['usr_avatar'],
                                                                                                'class' => 'img-circle profile_img', 'style' => 'margin:0px 0px;'));
                                                                                            ?>
                                                                                       </div>
                                                                                  </div>
                                                                                  <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;width: 90%;float: right;">
                                                                                       <p class="excerpt"><?php echo isset($cmd['foll_remarks']) ? $cmd['foll_remarks'] : '';?></p>
                                                                                  </div>
                                                                             </div>
                                                                             <?php
                                                                        }
                                                                   }
                                                              }
                                                              ?>
                                                         </div>
                                                    </li>
                                                    <?php
                                                    $index++;
                                               }
                                          }
                                          ?>
                                     </ul>
                                <?php }?>
                              <p style="text-align: center;"><strong><u><br />Enquiry Analysis (Reasons for the Drop/Close/Lose of Purchase or Sale/ Delete)</u></strong></p>
                              <table class="table table-striped table-bordered" style="margin-left: auto; margin-right: auto;" width="665">
                                   <tbody>
                                        <tr>
                                             <td style="text-align: center;" width="165">
                                                  <p><strong>Vehicle</strong></p>
                                             </td>

                                             <td style="text-align: center;" width="165">
                                                  <p><strong>Current Status</strong></p>
                                             </td>

                                             <td style="text-align: center;" width="168">
                                                  <p><strong>Remarks</strong></p>
                                             </td>
                                        </tr>

                                        <?php foreach ((array) $trackCard['vehicle_sall'] as $key => $value) {?>
                                               <tr>
                                                    <td width="165">
                                                         <p><strong><?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name'];?></strong></p>
                                                    </td>
                                                    <td width="165">
                                                         <p><strong><?php echo $value['sts_des'];?></strong></p>
                                                    </td>
                                                    <td width="165">
                                                         <p>
                                                              <strong>
                                                                   <?php
                                                                   $remarks = $this->enquiry->getVehicleStatusDetails($value['veh_id'], $value['sts_id']);
                                                                   echo isset($remarks['vst_remarks']) ? $remarks['vst_remarks'] : '';
                                                                   ?>
                                                              </strong>
                                                         </p>
                                                    </td>
                                               </tr>
                                          <?php } foreach ((array) $trackCard['vehicle_buy'] as $key => $value) {?>
                                               <tr>
                                                    <td width="165">
                                                         <p><strong><?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name'];?></strong></p>
                                                    </td>
                                                    <td width="165">
                                                         <p><strong><?php echo $value['sts_des'];?></strong></p>
                                                    </td>
                                                    <td width="165">
                                                         <p>
                                                              <strong>
                                                                   <?php
                                                                   $remarks = $this->enquiry->getVehicleStatusDetails($value['veh_id'], $value['sts_id']);
                                                                   echo isset($remarks['vst_remarks']) ? $remarks['vst_remarks'] : '';
                                                                   ?>
                                                              </strong>
                                                         </p>
                                                    </td>
                                               </tr>
                                          <?php }?>
                                   </tbody>
                              </table>
                              <p style="text-align: center;"><strong>&nbsp;</strong></p>
                              <p style="text-align: center;"><strong>Executive signature:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SM/TL Signature:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MD Signature :</strong></p>
                              <p style="text-align: center;"><strong>Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:</strong></p>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>

<style>
     .tblPrintHeader {display: none;}
     @media print {
          .nav_menu {display: none;}
          .x_title {display: none;}
          .x_panel {padding: 0px;border: none;}
          .tblSale {margin-top: 100px;}
          footer {display: none;}
          .tblPrintHeader {display: table;}
     }
</style>
