
<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Follow up details of <?php echo $vehicles['enq_cus_name'];?> 
                              <?php //if (check_permission($controller, 'setenquirypreference')) { ?>
                              <button type="button" class="prefrence btn btn-success" data-toggle="modal" data-target="#popPreferences">Preference</button>
                              <?php //} if (check_permission($controller, 'submitprocrmntreq')) { ?>
                              <button type="button" class="proc btn btn-success" data-toggle="modal" data-target="#procModal">Procurement Req.</button>
                              <?php //}if (check_permission($controller, 'submitprocrmntreq')) { ?>
                              <button type="button" class="homeVisit btn btn-success" data-toggle="modal" data-target="#homeVisit">Home Visit</button>
                              <?php //}if (check_permission($controller, 'submitprocrmntreq')) { ?>
                              <button type="button" class="testDrive btn btn-success" data-toggle="modal" data-target="#testDrive">Test Drive</button>
                              <?php //} ?>
                         </h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li class="dropdown" style="float: right;">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                   <ul class="dropdown-menu" role="menu">
                                        <li><a target="blank" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($vehicles['enq_id']));?>">View tracking card</a></li>
                                        <li><a target="blank" href="<?php echo site_url('enquiry/view/' . encryptor($vehicles['enq_id']));?>">Edit enquiry</a></li>
                                   </ul>
                              </li>
                         </ul>
                         <div class="clearfix"><?php echo $vehicles['enq_id'];?></div>
                         <i>
                              <b>
                                   <?php
                                     echo isset($vehicles['sts_title']) ? 'Current inquiry status : ' . $vehicles['sts_des'] : '';
                                     $type = unserialize(FOLLOW_UP_STATUS);
                                     echo isset($type[$vehicles['enq_cus_when_buy']]) ? ', Inquiry type : ' . $type[$vehicles['enq_cus_when_buy']] : '';

                                     $mods = unserialize(MODE_OF_CONTACT);
                                     echo isset($mods[$vehicles['enq_mode_enq']]) ? ', Mode of contact : ' . $mods[$vehicles['enq_mode_enq']] : '';
                                   ?>
                              </b>
                         </i>
                    </div>
                    <div class="x_content">
                         <div class="col-md-8 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                   <div class="panel-heading">All followup
                                        <div style="float: right;">
                                             <i class="fa fa-circle" style="color: red;"> HOT+</i>
                                             <i class="fa fa-circle" style="color: #9c3501;"> HOT</i>
                                             <i class="fa fa-circle" style="color: #ffc800;"> WARM</i>
                                             <i class="fa fa-circle" style="color: #6aa913;"> COLD</i>
                                        </div>
                                   </div>
                                   <div class="panel-body">
                                        <ul class="list-unstyled timeline">
                                             <?php
                                               $callBack = isset($_GET['quickfollowup']) ? '?quickfollowup=' . $_GET['quickfollowup'] : '';
                                               $totalVehicles = count($vehicles['vehicle_sale']) + count($vehicles['vehicle_buy']);
                                               $index = 0;
                                               foreach ((array) $vehicles['followups'] as $key => $value) {
                                                    // print_r($value['veh_type']);
                                                    //veh changed details 
                                                    ?>

                                                    <?php
                                                    // @veh changed details 
                                                    if (($value['foll_is_cmnt'] == 1) && ($value['foll_parent'] == 0)) {
                                                         if ((check_permission('folup_trck_comment', 'viewgeneralcomment'))) {
                                                              ?>
                                                              <li>
                                                                   <div class="block">
                                                                        <div class="tags" style="width: 50%;">
                                                                             <div class="profile_pic">
                                                                                  <?php
                                                                                  echo img(array('src' => './assets/uploads/avatar/' . $value['usr_avatar'], 'class' => 'img-circle profile_img', 'style' => 'margin:0px 0px;'));
                                                                                  ?>
                                                                             </div>
                                                                        </div>
                                                                        <div class="block_content">
                                                                             <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                             <div><i class="fa fa-clock-o"></i> 
                                                                                  <?php if ($value['folloup_added_by_id'] != $this->uid) {?>
                                                                                       <p class="excerpt alignright">Added by : <?php
                                                                                            echo isset($value['folloup_added_by']) ?
                                                                                                    $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                                                                                            ?>
                                                                                       </p>
                                                                                  <?php } else {?>
                                                                                       <p class="excerpt alignright">Added by : Self</p>
                                                                                  <?php }?>
                                                                                  <?php echo date('d-m-Y h:i:s', strtotime($value['foll_entry_date']));?></div>
                                                                             </p>
                                                                             <?php echo!empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : '';?>
                                                                        </div>
                                                                        <!-- Repeated contents -->
                                                                        <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;">
                                                                             <p class="excerpt"><?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : '';?></p>
                                                                        </div>
                                                                   </div>
                                                              </li>
                                                              <?php
                                                         }
                                                    } else {
                                                         if ($this->usr_grp != 'SE') {
                                                              $tagFollowUp = (check_permission('followup', 'changenextnollowupdate')) ? 'tagFollowUp' : '';
                                                         } else {
                                                              $tagFollowUp = ($index == 0) ? 'tagFollowUp' : '';
                                                         }
                                                         ?>
                                                         <li>
                                                              <div class="block">
                                                                   <?php
                                                                   $enqStatus = isset($vehicles['enq_cus_when_buy']) ? $vehicles['enq_cus_when_buy'] : 0;
                                                                   $status = !empty($value['foll_status']) ? $value['foll_status'] : $enqStatus;

                                                                   if ($status == 1) { // Hot+
                                                                        ?><style>.tagcolor<?php echo $value['foll_id'];?> {background:red;} .tagcolor<?php echo $value['foll_id'];?>::after{border-left:11px solid red}</style> <?php
                                                                   } else if ($status == 2) { // Hot
                                                                        ?><style>.tagcolor<?php echo $value['foll_id'];?> {background:#9c3501;} .tagcolor<?php echo $value['foll_id'];?>::after{border-left:11px solid #9c3501}</style> <?php
                                                                   } else if ($status == 3) { // Warm
                                                                        ?><style>.tagcolor<?php echo $value['foll_id'];?> {background:#ffc800;} .tagcolor<?php echo $value['foll_id'];?>::after{border-left:11px solid #ffc800}</style> 
                                                                   <?php } else if ($status == 4) { // Coold
                                                                        ?><style>.tagcolor<?php echo $value['foll_id'];?> {background:#6aa913;} .tagcolor<?php echo $value['foll_id'];?>::after{border-left:11px solid #6aa913}</style> 
                                                                   <?php }?>

                                                                   <div class="tags">
                                                                        <?php
                                                                        $enqType = 0;
                                                                        $folDateDMdy = !empty($value['foll_next_foll_date']) ? date('D M d Y', strtotime($value['foll_next_foll_date'])) :
                                                                                date('D M d Y', strtotime($value['foll_entry_date']));

                                                                        $folDateYmd = !empty($value['foll_next_foll_date']) ? date('Y-m-d', strtotime($value['foll_next_foll_date'])) :
                                                                                date('Y-m-d', strtotime($value['foll_entry_date']));

                                                                        $folDatejMY = !empty($value['foll_next_foll_date']) ? date('j M Y', strtotime($value['foll_next_foll_date'])) :
                                                                                date('j M Y', strtotime($value['foll_entry_date']));
                                                                        if (!empty($vehicles['vehicle_sale'])) {
                                                                             $enqType = 'sale';
                                                                        } elseif ($vehicles['vehicle_buy']) {
                                                                             $enqType = 'purchase';
                                                                        }
                                                                        ?>
                                                                        <a data-url="<?php echo site_url('followup/getSingleFollowup') . '/' . encryptor($vehicles['enq_id']) . '/' . $folDateYmd . '/' . $callBack . '/' . $enqType;?>" 
                                                                           href="javascript:;" class="tagcolor<?php echo $value['foll_id'];?> tag <?php echo $tagFollowUp;?>"
                                                                           min-date="<?php echo $folDateDMdy;?>">
                                                                             <span><?php echo $folDatejMY;?></span>
                                                                        </a>
                                                                   </div>
                                                                   <div class="block_content">
                                                                        <?php
                                                                        if ($value['veh_type'] == 3) {
                                                                             $pitchedVeh = $this->evaluation->getPitchedVeh($value['veh_stock_id']);
                                                                             ?>
                                                                             <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                  <span><i class="fa fa-car"></i> <?php echo $pitchedVeh['brd_title'] . ' ' . $pitchedVeh['mod_title'] . ' ' . $pitchedVeh['var_variant_name']?></span>
                                                                             </p>  

                                                                        <?php } else {
                                                                             ?>
                                                                             <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                                  <span><i class="fa fa-car"></i> <?php echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name']?></span>
                                                                             </p>
                                                                        <?php } echo!empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : '';?> 
                                                                   </div>
                                                                   <!-- Repeated contents -->
                                                                   <?php //if ((($key + 1) % $totalVehicles) == 0) {?>
                                                                   <div style="font-style: italic;background: #E7E7E7;padding: 10px;">
                                                                        <p class="excerpt">Remarks : <?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : '';?></p>
                                                                        <p class="excerpt">
                                                                             <?php
                                                                             $mod = unserialize(MODE_OF_CONTACT_FOLLOW_UP);
                                                                             echo isset($mod[$value['foll_contact']]) ? 'Mode of contact : ' . $mod[$value['foll_contact']] : ''
                                                                             ?>
                                                                        </p>
                                                                        <p class="excerpt">Next action plan : <?php echo isset($value['foll_action_plan']) ? $value['foll_action_plan'] : '';?></p>
                                                                        <?php
                                                                        if (($value['foll_budget_from'] > 0) || ($value['foll_budget_to'] > 0)) {
                                                                             echo '<p class="excerpt">Bdget : ' . $value['foll_budget_from'] . ' - ' . $value['foll_budget_to'] . '</p>';
                                                                        } if (($value['foll_km_from'] > 0) || ($value['foll_km_to'] > 0)) {
                                                                             echo '<p class="excerpt">KM : ' . $value['foll_km_from'] . ' - ' . $value['foll_km_to'] . '</p>';
                                                                        } if (($value['foll_model_y_from'] > 0) || ($value['foll_model_y_to'] > 0)) {
                                                                             echo '<p class="excerpt">Model year : ' . $value['foll_model_y_from'] . ' - ' . $value['foll_model_y_to'] . '</p>';
                                                                        }
                                                                        ?>
                                                                   </div>
                                                                   <?php if ($value['folloup_added_by_id'] != $this->uid) {
                                                                        ?>
                                                                        <p class="excerpt alignright">Added by : <?php
                                                                             echo isset($value['folloup_added_by']) ?
                                                                                     $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                                                                             ?>
                                                                             <?php echo date('d-m-Y h:i:s', strtotime($value['foll_entry_date']));?>
                                                                        </p>
                                                                   <?php } else {?>
                                                                        <p class="excerpt alignright">Added by : Self <?php echo date('d-m-Y h:i:s', strtotime($value['foll_entry_date']));?></p>
                                                                   <?php }?>
                                                                   <!-- Load comments -->
                                                                   <?php if (check_permission('folup_trck_comment', 'commentindividualfollowup')) {?>
                                                                        <i style="font-size: 15px;" class="fa fa-comment" data-toggle="modal" 
                                                                           data-target="#cmdModel<?php echo $value['foll_id'];?>"></i>
                                                                           <?php
                                                                      } if (check_permission('folup_trck_comment', 'viewindividualcomment')) {
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
                                                                                                           echo isset($cmd['folloup_added_by']) ?
                                                                                                                   $cmd['folloup_added_by'] . ' (' . $cmd['shr_location'] . ')' : '';
                                                                                                           ?>
                                                                                                      </p>
                                                                                                 <?php } else {?>
                                                                                                      <p class="excerpt alignright">Added by : Self</p>
                                                                                                 <?php }?>
                                                                                                 <?php echo date('d-m-Y h:i:s', strtotime($cmd['foll_entry_date']));?></div>
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
                                                                   <!-- Load comments -->
                                                                   <div class="modal" tabindex="-1" role="dialog" id="cmdModel<?php echo $value['foll_id'];?>">
                                                                        <div class="modal-dialog" role="document">
                                                                             <form class="modal-content" method="post" class="panel-body" action="<?php echo site_url('followup/updateComments');?>" onsubmit="return validateForm(this)">
                                                                                  <div class="modal-header">
                                                                                       <h5 class="modal-title"><i class="fa fa-comment-o"> Comment</i></h5>
                                                                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                       </button>
                                                                                  </div>
                                                                                  <div class="modal-body">
                                                                                       <textarea placeholder="Please enter your comments, minimum 30 characters" required="true" 
                                                                                                 class="form-control col-md-7 col-xs-12" id="txtFollRemarks" name="foll_remarks"></textarea>
                                                                                       <input type="hidden" name="foll_cus_id" value="<?php echo $vehicles['enq_id'];?>"/>
                                                                                       <input type="hidden" name="redirect" value="followupCommenting"/>
                                                                                       <input type="hidden" name="foll_parent" value="<?php echo $value['foll_id'];?>"/>

                                                                                       <div class="ln_solid"></div>
                                                                                       <br>
                                                                                       <div class="form-group">
                                                                                            <div class="col-md-7 col-sm-6 col-xs-12 col-md-offset-3">
                                                                                                 <?php /* if ($designation) {?>
                                                                                                   <select name="folmsgshow[]" multiple="multiple" class="muliSelectCombo form-control col-md-7 col-xs-12">
                                                                                                   <option selected="selected" value="0">Show to all</option>
                                                                                                   <?php
                                                                                                   foreach ($designation as $key => $value) {
                                                                                                   ?>
                                                                                                   <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                                                                                                   <?php }
                                                                                                   ?>
                                                                                                   </select>
                                                                                                   <?php } */?>
                                                                                            </div>
                                                                                            <!--                                             <div class="col-md-6 col-sm-6 col-xs-12" style="text-align: center;width: 63%;margin-top: 10px;">
                                                                                                 <i style="font-size: 9px;color: red;"><p><strong>By default show to all</strong></p></i>
                                                                                            </div>-->
                                                                                       </div>
                                                                                  </div>
                                                                                  <div class="modal-footer">
                                                                                       <button type="submit" class="btn btn-primary">Update comments</button>
                                                                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                  </div>
                                                                             </form>
                                                                        </div>
                                                                   </div>
                                                                   <!-- model end -->
                                                              </div>
                                                         </li>
                                                         <?php
                                                         $index++;
                                                    }
                                               }
                                             ?>
                                        </ul>
                                   </div>
                              </div>
                              <?php if (!empty($vehicles['questionAnswers'])) {?>
                                     <div class="panel panel-default">
                                          <div class="panel-heading">Enquiry questions</div>
                                          <div class="panel-body">
                                               <div class="form-horizontal form-label-left">
                                                    <form id="form-step-0" class="frmFlupEnquiryQuestion" role="form" data-toggle="validator"
                                                          data-url="<?php echo site_url($controller . '/editEnquiryQuestions');?>">
                                                         <input type="hidden" name="enq_id"  value="<?php echo $vehicles['enq_id'];?>"/>
                                                         <div>
                                                              <?php
                                                              foreach ((array) $vehicles['questionAnswers'] as $k => $value) {
                                                                   $required = $value['qus_is_mandatory'] == 1 ? 'required' : '';
                                                                   $answer = $value['enqq_answer'];
                                                                   $enqQuesId = $value['enqq_id'];
                                                                   ?>
                                                                   <div class="form-group">
                                                                        <label for="enq_cus_address" class="control-label col-md-6 col-sm-6 col-xs-12" 
                                                                               style="font-size: 10px;">
                                                                                    <?php echo $value['qus_question'];?>
                                                                        </label>
                                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                                             <?php if ($value['qus_is_togler'] == 1) { // Radio?>
                                                                                  <input <?php
                                                                                  echo $required;
                                                                                  echo ($answer == 1) ? ' checked="checked"' : '';
                                                                                  ?> type="checkbox"  class="" name="questions[<?php echo $value['qus_id'];?>][<?php echo $enqQuesId;?>]" value="1"/>
                                                                                  <?php } else { // Text box ?>
                                                                                  <textarea autocomplete="off" <?php echo $required;?> id="enq_cus_need" class="form-control col-md-7 col-xs-12" type="text" 
                                                                                            name="questions[<?php echo $value['qus_id'];?>][<?php echo $enqQuesId;?>]"><?php echo $answer;?></textarea>
                                                                                       <?php }?>
                                                                             <i style="font-size: 9px;"><?php echo $value['qus_desc'];?></i>
                                                                        </div>
                                                                   </div>
                                                              <?php }?>
                                                         </div>

                                                         <div class="ln_solid"></div>
                                                         <div class="form-group">
                                                              <div class="col-md-7 col-sm-6 col-xs-12 col-md-offset-3">
                                                                   <button class="btn btn-primary" type="reset">Reset</button>
                                                                   <button type="submit" class="btn btn-success">Update customer feedback</button>
                                                              </div>
                                                         </div>
                                                    </form>
                                               </div>
                                          </div>
                                     </div>
                                <?php } if (!empty($preferences)) {?>
                                     <div class="panel panel-default">
                                          <div class="panel-heading lbl">Preference</div>
                                          <div class="panel-body">
                                               <table class="table table-striped table-bordered">
                                                    <thead>
                                                         <tr>
                                                              <th>Preference</th>
                                                              <th>Preference Added by</th>
                                                              <th>Added on</th>
                                                         </tr>    
                                                    </thead>
                                                    <tbody>
                                                         <?php foreach ((array) $preferences as $key => $value) {?>
                                                              <tr>
                                                                   <td>
                                                                        <?php
                                                                        if ($value['prf_key'] == 1) {
                                                                             $color = $this->followup->getColors($value['prf_value']);
                                                                             echo'<b>Color</b>:' . $color . ' (' . $value['prf_description'] . ')';
                                                                        } if ($value['prf_key'] == 2) {
                                                                             echo'<b>Registration</b>:' . $value['prf_value'] . ' (' . $value['prf_description'] . ')';
                                                                        } if ($value['prf_key'] == 3) {
                                                                             $otherState = $this->followup->getStates($value['prf_value']);
                                                                             echo'<b>Other state</b>:' . $otherState . ' (' . $value['prf_description'] . ')';
                                                                        } if ($value['prf_key'] == 4) {
                                                                             $vehicleTypes = unserialize(ENQ_VEHICLE_TYPES);
                                                                             $vehType = $vehicleTypes[$value['prf_value']];
                                                                             echo'<b>Vehicle type</b>:' . $vehType . ' (' . $value['prf_description'] . ')';
                                                                        }
                                                                        if ($value['prf_key'] == 5) {
                                                                             $rto = $this->followup->getRto($value['prf_value']);

                                                                             echo'<b>RTO</b>:' . $rto['rto_reg_num'] . '-' . $rto['rto_place'] . ' (' . $value['prf_description'] . ')';
                                                                        }
                                                                        ?>
                                                                   </td>
                                                                   <td class="trVOE"><?php echo ($value['prf_addded_by'] == $this->uid) ? 'Self' : $value['enq_added_by_name'];?></td>
                                                                   <td class="trVOE"><?php echo date('j M Y', strtotime($value['prf_added_on']));?></td>
                                                              </tr>
       <?php }?>
                                                    </tbody>
                                               </table>
                                          </div>
                                     </div>
  <?php }?>
                              <!-- -->
                         </div>
                         <div class="col-md-4 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
<?php if (check_permission('booking', 'takebooking')) {?>
                                          <div class="panel-heading">
                                               <div>Customer details 
                                                    <button data-url="<?php echo site_url('booking/reserveVehicleView/' . encryptor($vehicles['enq_id']));?>" 
                                                            class="btnBookingForm btn btn-primary">Reserve</button></div>
                                               <div class="divBookingForm"></div>
                                          </div>
  <?php }?>
                                   <div class="panel-body">
                                        <ul class="list-group">
                                             <li class="list-group-item" style="font-size: 15px; font-weight: bolder; text-align: center;">Customer : <?php echo $vehicles['enq_cus_name'];?></li>
                                             <li class="list-group-item" style="font-size: 15px;font-weight: bolder; text-align: center;">Mobile : <?php echo $vehicles['enq_cus_mobile'];?></li>
                                             <li class="list-group-item" style="font-size: 15px;font-weight: bolder; text-align: center;">Sales Executive : <?php echo $vehicles['usr_first_name'];?></li>
<?php if (!empty($vehicles['vehicle_sale_req'])) {?>
                                                    <li class="list-group-item active">Sales(Required)</li>
                                                    <?php
                                                    // print_r($vehicles['vehicle_sale']);
                                                    foreach ($vehicles['vehicle_sale_req'] as $key => $value) {   // print_r($value);
                                                         $veh_details = $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name'];
                                                         $veh_reg = $value['veh_reg'];
                                                         ?>
                                                         <li class="list-group-item"><i class="fa fa-car"></i> <?php echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name']?> <span class="glyphicon glyphicon-edit text-success model-change-veh" data-url="<?php echo site_url('followup/change_veh_form') . '/' . encryptor($value['veh_type']) . '/' . encryptor($value['veh_id']) . '/' . encryptor($value['veh_enq_id']) . '/' . encryptor($value['veh_brand']) . '/' . encryptor($value['veh_model']) . '/' . encryptor($value['veh_varient']) . '/' . encryptor($veh_details) . '/' . encryptor($veh_reg);?>"></span></li>
                                                         <?php
                                                    }
                                               } if (!empty($vehicles['vehicle_sale_pitched'])) {
                                                    ?>
                                                    <li class="list-group-item active">Sales(Pitched)</li>
                                                    <?php
                                                    // print_r($vehicles['vehicle_sale']);
                                                    foreach ($vehicles['vehicle_sale_pitched'] as $key => $value) {
                                                         $pitchedVev = $this->evaluation->getPitchedVeh($value['veh_stock_id']);
                                                         $veh_details = $pitchedVev['brd_title'] . ' ' . $pitchedVev['mod_title'] . ' ' . $pitchedVev['var_variant_name'];
                                                         $veh_reg = $pitchedVev['val_veh_no'];
                                                         // print_r($pitchedVev['val_veh_no']);
                                                         ?>
                                                         <li class="list-group-item"><i class="fa fa-car"></i> <?php echo $pitchedVev['brd_title'] . ' ' . $pitchedVev['mod_title'] . ' ' . $pitchedVev['var_variant_name']?> <span class="glyphicon glyphicon-edit text-success model-change-veh" data-url="<?php echo site_url('followup/change_veh_form') . '/' . encryptor($value['veh_type']) . '/' . encryptor($value['veh_id']) . '/' . encryptor($value['veh_enq_id']) . '/' . encryptor($pitchedVev['val_brand']) . '/' . encryptor($pitchedVev['val_model']) . '/' . encryptor($pitchedVev['val_variant']) . '/' . encryptor($veh_details) . '/' . encryptor($veh_reg);?>"></span></li>
                                                         <?php
                                                    }
                                               }

                                               if (!empty($vehicles['vehicle_buy'])) {
                                                    ?>
                                                    <li class="list-group-item active">Purchase</li>
                                                    <?php
                                                    foreach ($vehicles['vehicle_buy'] as $key => $value) {
                                                         ?>
                                                         <li class="list-group-item"><i class="fa fa-car"></i> <?php echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name']?></li>
                                                         <?php
                                                    }
                                               }
                                             ?>
                                        </ul>
                                             <?php //if (check_permission($controller, 'changevehicle')) { ?>
                                        <form id="demo-form2" method="post" action="<?php echo site_url('followup/changevehicle');?>" data-parsley-validate class="form-horizontal form-label-left frmVehicleStatus">
                                             <input type="hidden" class="txtEnqId" name="newvehicle[enq_id]" value="<?php echo isset($vehicles['enq_id']) ? $vehicles['enq_id'] : 0;?>"/>

                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Brand</label>
                                                  <div class="col-md-9 col-sm-12 col-xs-12">
                                                       <select required data-url="<?php echo site_url('enquiry/bindModel');?>" data-bind="cmbEvModel" 
                                                               data-dflt-select="Select Model" class="cmbBrand select2_group form-control bindToDropdown" name="newvehicle[brand]" id="vreg_brand">
                                                            <option value="">Select Brand</option>
<?php
  if (!empty($brands)) {
       foreach ($brands as $key => $value) {
            ?>
                                                                        <option value="<?php echo $value['brd_id'];?>"><?php echo $value['brd_title'];?></option>
                                                                        <?php
                                                                   }
                                                              }
                                                            ?>
                                                       </select>
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Model</label>
                                                  <div class="col-md-9 col-sm-6 col-xs-12">
                                                       <select data-url="<?php echo site_url('enquiry/bindVarient');?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                               class="cmbEvModel select2_group form-control bindToDropdown" name="newvehicle[model]" id="vreg_model">
                                                       </select>
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Variant</label>
                                                  <div class="col-md-9 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control cmbEvVariant" name="newvehicle[varient]" id="vreg_varient"></select>
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <div class="col-md-12 col-sm-6 col-xs-12">
                                                       <textarea placeholder="Remarks" required="required" name="newvehicle[remarks]" 
                                                                 class="form-control col-md-7 col-xs-12 text-left vst_remarks"></textarea>
                                                  </div>
                                             </div>

                                             <div class="ln_solid"></div>
                                             <div class="form-group">
                                                  <div class="col-md-7 col-sm-6 col-xs-12 col-md-offset-3">
                                                       <button class="btn btn-primary" type="reset">Reset</button>
                                                       <button type="submit" class="btn btn-success">Submit</button>
                                                  </div>
                                             </div>
                                        </form>
<?php //}  ?>
                                   </div>
                              </div>
                              <!-- -->


                              <!-- change followup hot/warm/cold -->
<?php if (check_permission('followup', 'chghotwarmcold')) {?>
                                     <div class="panel panel-default">
                                          <div class="panel-heading">Followup Hot, Warm, Cold</div>
                                          <div class="panel-body">
                                               <form id="demo-form2" method="post" action="<?php echo site_url('followup/changehotwarmcold');?>" data-parsley-validate class="form-horizontal form-label-left frmVehicleStatus">
                                                    <input type="hidden" name="foll_new_sts_enq_id" value="<?php echo isset($vehicles['enq_id']) ? $vehicles['enq_id'] : 0;?>"/>
                                                    <div class="form-group">
                                                         <div class="col-md-12 col-sm-6 col-xs-12">
                                                              <select class="select2_group form-control cmbFollStatus" name="foll_new_status" required="required">
                                                                   <option value="">Select status</option>
       <?php foreach (unserialize(FOLLOW_UP_STATUS) as $key => $value) {?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                   <?php }?>
                                                              </select>
                                                         </div>
                                                    </div>
                                                    <div class="form-group">
                                                         <div class="col-md-12 col-sm-6 col-xs-12">
                                                              <textarea placeholder="Remarks" required="required" name="foll_new_status_remarks" class="form-control col-md-7 col-xs-12 text-left vst_remarks"></textarea>
                                                         </div>
                                                    </div>
                                                    <div class="ln_solid"></div>
                                                    <div class="form-group">
                                                         <div class="col-md-7 col-sm-6 col-xs-12 col-md-offset-3">
                                                              <button class="btn btn-primary" type="reset">Reset</button>
                                                              <button type="submit" class="btn btn-success">Submit</button>
                                                         </div>
                                                    </div>
                                               </form>
                                          </div>
                                     </div>
  <?php }?>
                              <!-- change followup hot/warm/cold -->

                              <!-- general comment box -->
<?php if (check_permission('folup_trck_comment', 'generalcomment')) {?>
                                     <div class="panel panel-default">
                                          <div class="panel-heading">
                                               <i class="fa fa-comment-o"> Comment</i>
                                          </div>
                                          <form method="post" class="panel-body" action="<?php echo site_url('followup/updateComments');?>" onsubmit="return validateForm(this);">
                                               <textarea placeholder="Please enter your comments, minimum 30 characters" required="true" class="form-control col-md-7 col-xs-12" id="txtFollRemarks" name="foll_remarks"></textarea>
                                               <input type="hidden" name="foll_cus_id" value="<?php echo $vehicles['enq_id'];?>"/>
                                               <input type="hidden" name="foll_parent" value="0"/>
                                               <input type="hidden" name="redirect" value="followupCommenting"/>

                                               <div class="ln_solid"></div>
                                               <br>
                                               <div class="form-group">
                                                    <div class="col-md-7 col-sm-6 col-xs-12 col-md-offset-3">
       <?php /* if ($designation) {?>
         <select name="folmsgshow[]" multiple="multiple" class="muliSelectCombo form-control col-md-7 col-xs-12">
         <option selected="selected" value="0">Show to all</option>
         <?php
         foreach ($designation as $key => $value) {
         ?>
         <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
         <?php }
         ?>
         </select>
         <?php } */
       ?>
                                                         <button type="submit" class="btn btn-success">Update comments</button>
                                                    </div>
                                                    <!--                                             <div class="col-md-6 col-sm-6 col-xs-12" style="text-align: center;width: 63%;margin-top: 10px;">
                                                         <i style="font-size: 9px;color: red;"><p><strong>By default show to all</strong></p></i>
                                                    </div>-->
                                               </div>
                                          </form>
                                     </div>
  <?php }?>
                              <!-- general comment end -->

                              <!-- Inquiry history -->
<?php if (is_roo_user()) {?>
                                     <ul class="list-unstyled timeline">
                                     <?php
                                     if (!empty($enqHistory)) {
                                          foreach ($enqHistory as $key => $value) {
                                               ?>
                                                    <li>
                                                         <div class="block">
                                                              <div class="tags">
                                                                   <a href="javascript:;" class="tag">
                                                                        <span><?php echo date('j M Y', strtotime($value['enh_added_on']));?></span>
                                                                   </a>
                                                              </div>
                                                              <div class="block_content">
                                                                   <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                        <span><i class="fa fa-clock-o"></i> <?php echo $value['sts_des'];?></span>
                                                                   </p>
                                                              </div>
                                                              <!-- Repeated contents -->
                                                              <div style="font-style: italic;background: #E7E7E7;padding: 10px;">
                                                                   <p class="excerpt"><?php echo $value['enh_remarks'];?></p>
                                                              </div>
                                                         </div>
                                                    </li>
                 <?php
            }
       }
       ?>
                                     </ul>
                                     <?php }?>
                              <!-- -->

                              <div class="panel panel-default">
                                   <div class="panel-heading">Re-assign inquiry</div>
                                   <div class="panel-body">
<?php //if (check_permission($controller, 'changevehicle')) {  ?>
                                        <form id="demo-form2" method="post" action="<?php echo site_url('followup/changevehicle');?>" data-parsley-validate class="form-horizontal form-label-left frmVehicleStatus">
                                             <input type="hidden" class="txtEnqId" name="newvehicle[enq_id]" value="<?php echo isset($vehicles['enq_id']) ? $vehicles['enq_id'] : 0;?>"/>

                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Brand</label>
                                                  <div class="col-md-9 col-sm-12 col-xs-12">
                                                       <select required data-url="<?php echo site_url('enquiry/bindModel');?>" data-bind="cmbEvModel" 
                                                               data-dflt-select="Select Model" class="cmbBrand select2_group form-control bindToDropdown" name="newvehicle[brand]" id="vreg_brand">
                                                            <option value="">Select Brand</option>
<?php
  if (!empty($brands)) {
       foreach ($brands as $key => $value) {
            ?>
                                                                        <option value="<?php echo $value['brd_id'];?>"><?php echo $value['brd_title'];?></option>
                                                                        <?php
                                                                   }
                                                              }
                                                            ?>
                                                       </select>
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Model</label>
                                                  <div class="col-md-9 col-sm-6 col-xs-12">
                                                       <select data-url="<?php echo site_url('enquiry/bindVarient');?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                                               class="cmbEvModel select2_group form-control bindToDropdown" name="newvehicle[model]" id="vreg_model">
                                                       </select>
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Variant</label>
                                                  <div class="col-md-9 col-sm-6 col-xs-12">
                                                       <select class="select2_group form-control cmbEvVariant" name="newvehicle[varient]" id="vreg_varient"></select>
                                                  </div>
                                             </div>

                                             <div class="form-group">
                                                  <div class="col-md-12 col-sm-6 col-xs-12">
                                                       <textarea placeholder="Remarks" required="required" name="newvehicle[remarks]" 
                                                                 class="form-control col-md-7 col-xs-12 text-left vst_remarks"></textarea>
                                                  </div>
                                             </div>

                                             <div class="ln_solid"></div>
                                             <div class="form-group">
                                                  <div class="col-md-7 col-sm-6 col-xs-12 col-md-offset-3">
                                                       <button class="btn btn-primary" type="reset">Reset</button>
                                                       <button type="submit" class="btn btn-success">Submit</button>
                                                  </div>
                                             </div>
                                        </form>
<?php //}  ?>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document" style="width:84%;">
          <div class=" modal-content bg-gray brd-radi cus-fdbk-content">
               <div class="modal-header bg-gray h-brd-radi">
                    <h5 class="modal-title lbl" id="exampleModalLabel" style="float: left;">Customer feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                    </button>
               </div>
               <div class="modal-body viewFollowUp bg-gray brd-radi"></div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnCloseModel lbl" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btnSaveFollowUpFeedBack" 
                            data-url="<?php echo site_url('followup/editFollowUp');?>">Save changes</button>
               </div>
          </div>
     </div>
</div>
<!-- Chnage veh -->
<div class="modal fade changeVehModal" id="changeVehModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document" style="width:64%;">
          <div class=" modal-content bg-gray brd-radi cus-fdbk-content">
               <form id="frmChangeVehicle" method="post" action="<?php echo site_url('followup/store_change_vehicle');?>" data-parsley-validate class="submitChangeVehicle form-horizontal form-label-left frmChangeVehicle">

                    <div class="modal-header bg-gray h-brd-radi">
                         <h5 class="modal-title lbl" id="exampleModalLabel" style="float: left;">Chnage vehicle</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                         </button>
                    </div>
                    <div class="modal-body viewChangeVehfld bg-gray brd-radi"></div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-secondary btnCloseModel lbl" data-dismiss="modal">Close</button>
                         <button type="submit" class="btn btn-success">Submit</button>
                    </div>
<?php echo form_close()?>
          </div>
     </div>
</div>
<!-- @Change veh -->

<script>
     function validateForm($this) {
          var text = $($this).getElementById('txtFollRemarks').value.trim();
          if (text.length < 10) {
               alert('Please enter atleast 30 characters in customer feedback');
               return false;
          } else {
               return true;
          }
     }
</script>

<!-- Preferences model -->
<div class="modal fade" id="popPreferences" role="dialog">
     <div class="modal-dialog">
          <!-- Modal content-->    
<?php echo form_open_multipart("followup/submit_preference", array('id' => "frmOfferPrice", 'class' => "submitPrefrnc modal-content form-horizontal form-label-left"))?>
          <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title lbl">Preference &nbsp; <span style="cursor: pointer;" class="glyphicon glyphicon-plus Addbtn"></span>  <span class="msg"></span></h4>
          </div>
          <div class="modal-body">
               <div class="mdl_div">
                    <div class='fld'>
                         <div class="row">
                              <div class="col-md-3">
                                   <i class=" prefix grey-text"></i>
                                   <select data-placeholder="Preference"  class="select2_groupj form-control cmbMultiSelectj prfSel">
                                        <option selected>-Select-</option>
<?php
  $preferences = unserialize(PREFERENCE_KEYS);
  foreach ($preferences as $key => $value) {
       ?>
                                               <option value="<?php echo $key;?>"><?php echo $value;?></option>   
                                          <?php }?>
                                   </select>
                              </div>
                              <div class="prf_fld_ajx"></div>
                              <input type="hidden" name="enq_id" value="<?php echo $vehicles['enq_id'];?>">
                         </div>
                    </div>
               </div>
          </div>
          <div class="modal-footer">
               <button type="submit" class="btn btn-success">Submit</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </form>  
     </div>
</div>

<!-- Procurement model -->
<div class="modal fade" id="procModal" role="dialog">
     <div class="modal-dialog">
<?php echo form_open_multipart("followup/submitProcrmntReq", array('id' => "frmOfferPrice", 'class' => "submitProcReq modal-content form-horizontal form-label-left"))?>
          <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title lbl"> Procurement Request <span class="msg"></span></h4>
          </div>
          <div class="modal-body">
               <div class="mdl_div">
                    <div class='flds'>
                         <div class="row">

                              <i class=" prefix grey-text"></i>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Brand</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="brand" id="var_brand_id"  class="form-control col-md-7 col-xs-12 bindToDropdown" 
                                                data-bind="cmbModel" data-dflt-select="Select Model"
                                                data-url="<?php echo site_url('enquiry/bindModel');?>">
                                             <option value="">Select Brand</option>
<?php
  if (!empty($brands)) {
       foreach ($brands as $key => $value) {
            ?>
                                                         <option value="<?php echo $value['brd_id'];?>"><?php echo $value['brd_title'];?></option>
                                                         <?php
                                                    }
                                               }
                                             ?>
                                        </select>
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Model</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="model" id="var_brand_id" data-bind="cmbEvVariant" data-dflt-select="Select Model"
                                                data-url="<?php echo site_url('enquiry/bindVarient');?>"  class="form-control col-md-7 col-xs-12 cmbModel bindToDropdown"></select>
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12 lbl" for="first-name">Variant</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="select2_group form-control cmbEvVariant" name="variant" id="vreg_varient"></select>
                                   </div>
                              </div>

                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Purchase period</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select required name="purchase_prd" id="var_brand_id"  class="form-control col-md-7 col-xs-12" data-dflt-select="Select Model">
                                             <option value="">Select</option>
<?php foreach (unserialize(PURCHASE_PERIOD) as $key => $value) {?>
                                                    <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                               <?php }?>
                                        </select>
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-3 col-sm-3 col-xs-12 lbl">Description</label>
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea class="form-control col-md-7 col-xs-12 " name="descriptin" id="var_variant_name" placeholder="Description"></textarea>
                                   </div>
                              </div>
                              <input type="hidden" name="enq_id" value="<?php echo $vehicles['enq_id'];?>">
                              <input type="hidden" name="enq_se_id" value="<?php echo $vehicles['enq_se_id'];?>">
                         </div>
                    </div>
               </div>
          </div>
          <div class="modal-footer">
               <button type="submit" class="btn btn-success">Submit</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
<?php echo form_close()?>
     </div>
</div><!-- @Procurement model -->
<!-- Home visit model -->

<div class="modal fade" id="homeVisit" role="dialog" >

     <div class="modal-dialog ">
<?php echo form_open_multipart("followup/storeHomeVisit", array('id' => "home_Visit", 'class' => "submitHomeVisit  modal-content form-horizontal form-label-left"))?>

          <div class="modal-header bg-gray h-brd-radi">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title lbl"> HOME VIST REQUEST  <span class="msg"></span></h4>

          </div>
          <div class="modal-body bg-gray brd-radi">
               <div class="mdl_div">
                    <div class='flds'>
                         <div class="row">

                              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                   <label class="lbl">Travel Mod</label>
<?php $travel_mods = $this->followup->getTravelModes();
?>
                                   <select name="hmv_travel_mod" id="travel_with" class="form-control  form-control col-md-6 col-xs-6 travel_mod">
                                        <option>-Select-</option>
<?php foreach ($travel_mods as $key => $travel_mod) {?>
                                               <option value="<?php echo $travel_mod['dtm_id'];?>"><?php echo $travel_mod['dtm_title'];?> </option>

  <?php }?>
                                   </select>

                              </div>


                         </div>

                         <div class="row">
                              <div class="form-group col-md-12 col-sm-12 col-xs-12 fleet_veh" style="display:none">
                                   <label class="lbl">Fleet</label>
                                   <select name="hmv_fleet_veh" id="travel_with" class="form-control  form-control col-md-6 col-xs-6 by_fleet">
                                        <option value="0">-Select-</option>
                                        <option value="1">Company Vehicle</option>
                                        <option value="2">Stock Vehicle</option>
                                        <option value="3">Own vehicle </option>
                                   </select>

                              </div>

                         </div>
                         <div class="row company_vehicle vehicle" style="display:none">

                              <i class=" prefix grey-text"></i>
                              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                   <label class="lbl">Vehicle(Company)</label>
                                   <select  class="com_veh cmbSearchList select2_group form-control cmbStock form-control col-md-7 col-xs-12" 
                                            name="hmv_veh_comp" >
                                        <option value="">Select Vehicle</option>
<?php
  foreach ((array) $evaluation as $key => $value) {//val_color
       if (!$this->evaluation->isVehicleSold($value['val_id'])) { // check if vehicle sold
            ?>
                                                    <option value="<?php echo $value['val_id'];?>">
                                                    <?php
                                                    echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                    $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                    ?>
                                                    </option>
                                                         <?php
                                                    }
                                               }
                                             ?>
                                   </select>
                              </div>

                         </div>
                         <div class="row stock_vehicle vehicle" style="display:none">

                              <i class=" prefix grey-text"></i>
                              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                   <label class="lbl">Vehicle(stock)</label>
                                   <select  class="stk_veh cmbSearchList select2_group form-control cmbStock form-control col-md-7 col-xs-12" 
                                            name="hmv_veh_stock" >
                                        <option value="">Select Vehicle</option>
<?php
  foreach ((array) $evaluation as $key => $value) {//val_color
       if (!$this->evaluation->isVehicleSold($value['val_id'])) { // check if vehicle sold
            ?>
                                                    <option value="<?php echo $value['val_id'];?>">
                                                    <?php
                                                    echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                    $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                    ?>
                                                    </option>
                                                         <?php
                                                    }
                                               }
                                             ?>
                                   </select>
                              </div>

                         </div>
                         <div class="row vehicle_no vehicle" style="display:none">
                              <div class="form-group col-md-2 col-sm-2 col-xs-12">
                                   <label class="lbl">Vehicle no</label>

                              </div>
                              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                   <input  placeholder="KL" id="enq_cus_loan_emi" style="width: 90px;text-transform:uppercase;" class="reg form-control col-md-3 col-xs-3" type="text" name="hmv_reg1" autocomplete="off">
                                   <input  placeholder="00" style="width: 160px;" class="reg form-control col-md-3 col-xs-3 numOnly" type="text" name="hmv_reg2" autocomplete="off">
                                   <input  placeholder="AA" style="width: 160px;text-transform:uppercase;" class="reg form-control col-md-3 col-xs-3" type="text" name="hmv_reg3" autocomplete="off">
                                   <input  placeholder="0000" style="width: 146px;" class="reg form-control col-md-3 col-xs-3 numOnly" type="text" name="hmv_reg4" autocomplete="off"> 

                              </div>

                         </div>
                         <div class="row">

                              <i class=" prefix grey-text"></i>

                              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                   <label class="lbl">Travel with</label>
                                   <select name="hmv_travel_with" id="travel_with" class="sumoSearchList select2_group form-control cmbStock form-control col-md-7 col-xs-12" 
                                           >
                                        <option>Select Staff</option>
<?php
  if (!empty($staffs)) {
       foreach ($staffs as $key => $staff) {
            ?>
                                                    <option value="<?php echo $staff['col_id']?>"><?php echo $staff['col_title'];?></option>
                                                    <?php
                                               }
                                          }
                                        ?>
                                   </select>

                              </div>
                         </div>


                         <div class="row">

                              <div class="form-group col-md-3 col-sm-3 col-xs-6">
                                   <label class="lbl">Date</label> 
                                   <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerDMY" name="hmv_date" id="date" placeholder="Date" autocomplete="off" required> 
                              </div>
                              <div class="form-group col-md-3 col-sm-3 col-xs-6">
                                   <label class="lbl">Out km </label>

                                   <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="hmv_out_km" placeholder="Out km" autocomplete="off" required> 
                              </div>
                              <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                   <label class=" lbl">Place</label>


                                   <input type="text" class="form-control col-md-7 col-xs-12" id="pac-input" name="hmv_place" placeholder="Enter Place" autocomplete="off" required> 
 <!--                                       <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_place"  placeholder="Place">-->
                                   <input type="hidden" name="hmv_enq_id" value="<?php echo $vehicles['enq_id'];?>">
<!--                              <input type="hidden" name="enq_se_id" value="<?php echo $vehicles['enq_se_id'];?>">-->
                              </div>
                         </div>
                         <div class="row">
                              <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                   <label class=" lbl">District</label>
                                   <input type="text" class="form-control col-md-7 col-xs-12 " id="district" name="hmv_district" readonly="" placeholder="District" autocomplete="off"> 

                              </div>
                              <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                   <label class=" lbl">State</label>
                                   <input type="text" class="form-control col-md-7 col-xs-12 " id="state" name="hmv_state" placeholder="State" readonly="" autocomplete="off"> 

                              </div>
                         </div>
                         <div class="row">

                              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                   <label class="lbl">Remark</label>
                                   <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_executive_remark"  placeholder="Enter Remark"> 
                              </div>
                              <input type="hidden" name="hmv_lat" id="lat">       
                              <input type="hidden" name="hmv_long" id="long" >
                              <input type="hidden" name="hmv_city" id="city" >
                         </div>

                         <!--                         <div class="row">
                                                      
                                                         <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                        <label class="lbl">Met the Customer with Family</label>
                                                            <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_met_cus_with_family" placeholder="Met the Customer with Family"> 
                                                       </div>
                                                         <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                            <label class="control-label lbl">Executive Remak</label>
                                                          
                                                                <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_executive_remark"  placeholder="Executive Remak">
                                                          
                                                       </div>
                                                        </div>
                                                  <div class="row">
                                                      
                                                         <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                        <label class="lbl">TL Remark</label>
                                                            <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_tl_remark" placeholder="TL Remark"> 
                                                       </div>
                                                         <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                            <label class="lbl">SM Remark</label>
                                                          
                                                                <input type="text" class="form-control col-md-7 col-xs-12 " name="hmv_sm_remark"  placeholder="SM Remark">
                                                          
                                                       </div>
                                                        </div>-->


                         <!--                         <div class="row">
                                                       <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                            <label class="control-label lbl">Approved home visit</label>
                                                          
                                                                 <input type="text" class="form-control col-md-7 col-xs-12 " name="approved"  placeholder="Approved home visit">
                                                       </div>
                                                                
                                
                                             </div>-->
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
<?php echo form_close()?>
          </div>
     </div></div><!-- Home visit model -->
<!-- Test drive model -->
<div class="modal fade" id="testDrive" role="dialog">
     <div class="modal-dialog test_drive">
<?php echo form_open_multipart("followup/storeTestDrive", array('id' => "test-Drive", 'class' => "test-drive test_drive modal-content form-horizontal form-label-left"))?>

          <div class="modal-header bg-gray h-brd-radi">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title lbl"> TEST DRIVE REQUEST  <span class="msg"></span></h4>
          </div>
          <div class="modal-body bg-gray brd-radi">
               <div class="mdl_div">
                    <div class='flds'>
                         <div class="row">

                              <i class=" prefix grey-text"></i>
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <label class="lbl">Vehicle</label>
                                   <select  class="tdriveSearchList select2_group form-control cmbStock form-control col-md-7 col-xs-12" 
                                            name="tdrv_veh_stock_id" >
                                        <option>Select Vehicle</option>
<?php
  foreach ((array) $evaluation as $key => $value) {//val_color
       if (!$this->evaluation->isVehicleSold($value['val_id'])) { // check if vehicle sold
            ?>
                                                    <option value="<?php echo $value['val_id'];?>">
                                                    <?php
                                                    echo $value['val_veh_no'] . ', ' . $value['brd_title'] . ', ' .
                                                    $value['mod_title'] . ', ' . $value['var_variant_name'];
                                                    ?>
                                                    </option>
                                                         <?php
                                                    }
                                               }
                                             ?>
                                   </select>

                              </div>
                              <!--                               <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                                 <label class="lbl">Reg No</label>
                                                                 <div>
                                                                      <input required placeholder="KL" id="enq_cus_loan_emi" style="width: 90px;text-transform:uppercase;" class="form-control col-md-7 col-xs-12" type="text" disabled="" name="veh_reg1" autocomplete="off">
                                                                                          <input required placeholder="00" id="enq_cus_loan_emi" style="width: 90px;" class="form-control col-md-7 col-xs-12 numOnly" type="text" disabled="" name="veh_reg2" autocomplete="off">
                                                                                          <input required placeholder="AA" id="enq_cus_loan_emi" style="width: 90px;text-transform:uppercase;" class="form-control col-md-7 col-xs-12" disabled="" type="text" name="veh_reg3" autocomplete="off">
                                                                                          <input required placeholder="0000" id="enq_cus_loan_emi" style="width: 115px;" class="form-control col-md-7 col-xs-12 numOnly" type="text" disabled="" name="veh_reg4" autocomplete="off">
                                                                 </div>
                                                            </div>-->
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <label class="lbl">Test Drive at</label>
                                   <input type="text" class="form-control col-md-7 col-xs-12 " name="tdrv_test_drive_at" placeholder="Test Drive at "> 
                              </div>
                         </div>

                         <div class="row">
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <label class="control-label lbl">Out km </label>

                                   <input type="text" class="form-control col-md-7 col-xs-12 numOnly" name="tdrv_out_km" placeholder="Out km" autocomplete="off"> 

                              </div>
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <label class="control-label lbl">Required/Pitched Vehicle</label>
<!--                                                                         <input type="text" class="form-control col-md-7 col-xs-12 " name="tdrv_req_or_pitched"  placeholder="Required or Pitched Vehicle">-->
                                   <select  class="select2_group form-control cmbStock form-control col-md-7 col-xs-12" 
                                            name="tdrv_req_or_pitched" >
                                        <option>-Select-</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>

                                   </select>
                              </div>
                         </div>
                         <div class="row">

                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <label class="control-label lbl">Test Drive Date</label>

                                   <input type="text" class="form-control col-md-7 col-xs-12 dtpDatePickerDMY" name="tdrv_test_drive_date"  placeholder="Test Drive Date" autocomplete="off">
                                   <input type="hidden" name="tdrv_enq_id" value="<?php echo $vehicles['enq_id'];?>">
<!--                              <input type="hidden" name="enq_se_id" value="<?php echo $vehicles['enq_se_id'];?>">-->
                              </div>
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <label class="control-label lbl">Expect Booking </label>
                                   <div class="form-check">
                                        <input class="form-check-input radio-btn" type="radio" name="tdrv_expet_booking"  value="1" id="flexRadioDisabled">
                                        <label class="form-check-label" for="expet_booking">
                                             <span class="lbl">Yes</span>
                                        </label>
                                        <input class="form-check-input radio-btn" type="radio" name="tdrv_expet_booking" value="0" id="flexRadioDisabled">
                                        <label class="form-check-label" for="expet_booking">
                                             <span class="lbl">No</span>
                                        </label>
                                   </div>
                              </div>




                         </div>


                         <div class="row">
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">


<!--                                        <select name="expeting_booking" data-bind="cmbEvVariant" data-dflt-select="Select Model"
            class="form-control col-md-7 col-xs-12">
             <option value="">-Select-</option>
            <option value="1">Yes</option>
             <option value="0">No</option>
       </select>-->
                              </div>

                         </div>
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
<?php echo form_close()?>
          </div>
     </div></div><!-- Test drive model -->
<div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
               aria-hidden="true">×</span></button>
     <strong>Enq Status Updated successfully!</strong>
</div>

<div class="alert alert-danger alert-dismissible fade in ErrorMsgBox" role="alert" style="display: none;">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
               aria-hidden="true">×</span></button>
     <strong>Error:Could not be submitted successfully!</strong>
</div>
<style>
     .prefrence {
          position: absolute;
          margin-left:407px;
          top:10px;
     }
     .proc {
          position: absolute;
          margin-left:507px;
          top:10px;   
     }
     .msg-alert {
          width:42%!important;
          margin-bottom: 18px!important;
          position: absolute;
          margin-right: 224px!important;
     }
     .Rmvbtn {
          color: #e33e19!important;
          font-size: 19px!important;
          line-height: 2;
     }
     .homeVisit {
          position: absolute;
          margin-left:652px;
          top: 10px;
     }
     .testDrive{
          position: absolute;
          margin-left:797px;
          top: 10px;   
     }
     .lbl{
          color: black !Important;
     }
     .dialog {
          width: 746px !important;
          margin: 30px auto !important ;
     }
     .bg-gray{
          background-color: #cacaca!important;
     }
     .brd-radi{
          border-radius: 0px!important;
          border-top-left-radius: 0px !important;
          border-top-right-radius: 0px !important;
          border-bottom-right-radius: 35px !important;
          border-bottom-left-radius: 35px !important;   
     }
     .h-brd-radi{
          border-radius: 0px!important;
          border-top-left-radius: 35px !important;
          border-top-right-radius: 35px !important;
          border-bottom-right-radius: 0px !important;
          border-bottom-left-radius: 0px !important; 

     }
     .modal-content {
          border: 7px solid rgba(0,0,0,.2)!important;
          border-radius: 42px!important;
     }
     .cus-fdbk-content{
          border: 7px solid rgb(205 204 199 / 26%)!important;
     }
     .modal-dialog.test_drive {

          width: 837px!important;

     }
     .radio-btn{
          border-radius: 50%!important;
          width: 25px !important;
          height: 25px!important;

          border: 2px solid lightskyblue!important;
          transition: 0.2s all linear!important;
          position: relative!important;
          top: 8px!important;
     }
     .slctwidth{
          width: 270px !important; 
     }
     .multiselect{
          width: 269px !important; 
     }

</style>


<script>

     $(document).ready(function () {
<?php if ($vehicles['enq_cus_when_buy'] == 1) {?>
                 $("#homeVisit").modal("show");
  <?php }?>
          $(document).on('change', '.travel_mod', function () {
               $('.by_fleet').prop('selectedIndex', 0);
               $('.com_veh').prop('selectedIndex', 0);
               $('.stk_veh').prop('selectedIndex', 0);
               $('.reg').val('');
               $('.search-txt').val('');
               // search-txt
               // $('cmbStock')[1].sumo.reload();
               // $('stk_veh')[0].sumo.reload();
               //  $('.stk_veh')[0].sumo.unSelectAll();

               //reg
               if (this.value === '8') {
                    $('.fleet_veh').show();
               } else {
                    $('.fleet_veh').hide();
                    $('.vehicle').hide();
               }

          });
          $(document).on('change', '.by_fleet', function () {
               if (this.value === '1') {
                    $('.company_vehicle').show();
                    $('.stock_vehicle').hide();
                    $('.vehicle_no').hide();
               } else if (this.value === '2') {
                    $('.company_vehicle').hide();
                    $('.stock_vehicle').show();
                    $('.vehicle_no').hide();
               } else if (this.value === '3') {
                    $('.company_vehicle').hide();
                    $('.stock_vehicle').hide();
                    $('.vehicle_no').show();
               }

          });
          $('.BindDistirct').val(18).change();
     });
     function validateForm($this) {
          var text = $($this).getElementById('txtFollRemarks').value.trim();
          if (text.length < 10) {
               alert('Please enter atleast 30 characters in customer feedback');
               return false;
          } else {
               return true;
          }
     }
     //jsk
     var count = 0;
     $(document).on('click', '.Addbtn', function () {
          count = count + 1;
          $.ajax({
               type: 'get',
               "url": site_url + "followup/add_preference",
               data: {count: count},
               success: function (resp) {
                    $(".fld").append(resp);
               }
          });
     });
     $(document).on('click', '.Rmvbtn', function () {
          $(".cls_" + $(this).data("id")).remove();
          $(this).parent('div').remove();
     });

     $('.prfSel').on('change', function (e) {
          var optionSelected = $("option:selected", this);
          var valueSelected = this.value;
          $.ajax({
               type: 'get',
               "url": site_url + "followup/append_pref_flds",
               data: {prefernce: valueSelected, count: 0},
               success: function (resp) {
                    $(".prf_fld_ajx").html(resp);
               }
          });
     });
     //@jsk
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyAf3gJYTfwcOwOzxarOZy1gZ8sglHVCkKk"></script> 
<script>
     var pacContainerInitialized = false;
     $('#pac-input').keypress(function () {
          if (!pacContainerInitialized) {
               $('.pac-container').css('z-index', '9999');
               pacContainerInitialized = true;
          }
     });

     function initialize() {
          var address = (document.getElementById('pac-input'));
          //  var latlng = new google.maps.LatLng(28.5355161,77.39102649999995);       
          var autocomplete7 = new google.maps.places.Autocomplete(address);
          autocomplete7.setTypes(['geocode']);
          google.maps.event.addListener(autocomplete7, 'place_changed', function () {
               var place = autocomplete7.getPlace();
               console.log(place);

               if (!place.geometry) {
                    return;
               }

               var address = '';
               if (place.address_components) {
                    address = [
                         (place.address_components[0] && place.address_components[0].short_name || ''),
                         (place.address_components[1] && place.address_components[1].short_name || ''),
                         (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
               }
               /*********************************************************************/
               for (var i = 0; i < place.address_components.length; i++)
               {
                    if (place.address_components[i].types[0] == "locality") {
                         //this is the object you are looking for City
                         city = place.address_components[i];
                    }
                    if (place.address_components[i].types[0] == "administrative_area_level_1") {
                         //this is the object you are looking for State
                         state = place.address_components[i];
                    }
                    if (place.address_components[i].types[0] == "administrative_area_level_2") {
                         //this is the object you are looking for
                         district = place.address_components[i];
                    }
               }
               document.getElementById('lat').value = place.geometry.location.lat();
               document.getElementById('long').value = place.geometry.location.lng();
               document.getElementById('state').value = state.long_name;
               document.getElementById('district').value = district.long_name;
               document.getElementById('city').value = city.long_name;
//              document.getElementById('state').value = place.address_components[3].long_name;
//                document.getElementById('district').value = place.address_components[2].long_name;

          });
     }

     google.maps.event.addDomListener(window, 'load', initialize);

</script>
