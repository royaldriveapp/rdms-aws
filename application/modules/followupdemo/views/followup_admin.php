<div class="right_col" role="main">
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Follow up details of <?php echo $vehicles['enq_cus_name'];?></h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li class="dropdown" style="float: right;">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                   <ul class="dropdown-menu" role="menu">
                                        <li><a target="blank" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($vehicles['enq_id']));?>">View tracking card</a></li>
                                   </ul>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
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
                                               $totalVehicles = count($vehicles['vehicle_sale']) + count($vehicles['vehicle_buy']);
                                               $index = 0;
                                               foreach ((array) $vehicles['followups'] as $key => $value) {
                                                    if (($value['foll_is_cmnt'] == 1) && ($value['foll_parent'] == 0)) {
                                                         
                                                         ?>
                                                         <li fd="<?php echo isset($value['foll_id']) ? $value['foll_id'] : 0; ?>">
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
                                                                        <div style="float: right;width: 100%;">
                                                                             <i class="fa fa-comments-o"><?php echo $value['folloup_upd_by'];?></i>
                                                                        </div>
                                                                   </div>
                                                                   <!-- Repeated contents -->
                                                                   <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;float: left;">
                                                                        <p class="excerpt"><?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : '';?></p>
                                                                   </div>
                                                              </div>
                                                         </li>
                                                         <?php
                                                    } else {
                                                         if ($this->usr_grp != 'SE') {
                                                              $tagFollowUp = (check_permission('followup', 'changenextnollowupdate')) ? 'tagFollowUp' : '';
                                                         } else {
                                                              $tagFollowUp = ($index == 0) ? 'tagFollowUp' : '';
                                                         }
                                                         ?>
                                                         <li fd="<?php echo isset($value['foll_id']) ? $value['foll_id'] : 0; ?>">
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
                                                                        $folDateDMdy = !empty($value['foll_next_foll_date']) ? date('D M d Y', strtotime($value['foll_next_foll_date'])) :
                                                                                date('D M d Y', strtotime($value['foll_entry_date']));

                                                                        $folDateYmd = !empty($value['foll_next_foll_date']) ? date('Y-m-d', strtotime($value['foll_next_foll_date'])) :
                                                                                date('Y-m-d', strtotime($value['foll_entry_date']));

                                                                        $folDatejMY = !empty($value['foll_next_foll_date']) ? date('j M Y', strtotime($value['foll_next_foll_date'])) :
                                                                                date('j M Y', strtotime($value['foll_entry_date']));
                                                                        ?>
                                                                        <a data-url="<?php echo site_url('followup/getSingleFollowup') . '/' . encryptor($vehicles['enq_id']) . '/' . $folDateYmd;?>" 
                                                                           href="javascript:;" class="tagcolor<?php echo $value['foll_id'];?> tag <?php echo $tagFollowUp;?>"
                                                                           min-date="<?php echo $folDateDMdy;?>">
                                                                             <span><?php echo $folDatejMY;?></span>
                                                                        </a>
                                                                   </div>
                                                                   <?php //} ?>
                                                                   <div class="block_content">
                                                                        <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                             <span><i class="fa fa-car"></i> <?php echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name']?></span>
                                                                        </p>
                                                                        <?php echo!empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : '';?>
                                                                        <div style="float: right;width: 100%;">
                                                                             <i class="fa fa-comments-o"><?php echo $value['folloup_upd_by'];?></i>
                                                                        </div>
                                                                   </div>
                                                                   <div style="width:100%;float:left;font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;float: left;">
                                                                        <p class="excerpt"><?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : '';?></p>
                                                                   </div>
                                                                   <!-- Repeated contents -->
                                                                   <?php if ((($key + 1) % $totalVehicles) == 0) {?>
                                                                        <div style="font-style: italic;background: #E7E7E7;padding: 10px;">
                                                                             <p class="excerpt">Remarks : <?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : '';?></p>
                                                                             <p class="excerpt">
                                                                                  <?php
                                                                                  $mod = unserialize(MODE_OF_CONTACT_FOLLOW_UP);
                                                                                  echo isset($mod[$value['foll_contact']]) ? 'Mode of contact : ' . $mod[$value['foll_contact']] : ''
                                                                                  ?>
                                                                             </p>
                                                                             <p class="excerpt">Next action plan : <?php echo isset($value['foll_action_plan']) ? $value['foll_action_plan'] : '';?></p>
                                                                        </div>
                                                                   <?php } if ($value['folloup_added_by_id'] != $this->uid) {
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
                                                                      }
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
                         </div>
                         <div class="col-md-4 col-sm-12 col-xs-12">
                              <ul class="list-group">
                                   <li  class="list-group-item" style="font-size: 15px; font-weight: bolder; text-align: center;">Customer : <?php echo $vehicles['enq_cus_name'];?></li>
                                   <li  class="list-group-item" style="font-size: 15px;font-weight: bolder; text-align: center;">Mobile : <?php echo $vehicles['enq_cus_mobile'];?></li>
                                   <?php if (is_roo_user()) {?>
                                          <li class="list-group-item" style="font-size: 15px; font-weight: bolder; text-align: center;">Sales Executive : <?php echo $vehicles['usr_first_name'];?></li>
                                     <?php } if (!empty($vehicles['vehicle_sale'])) {
                                          ?>
                                          <li class="list-group-item active">Sell</li>
                                          <?php
                                          foreach ($vehicles['vehicle_sale'] as $key => $value) {
                                               ?>
                                               <li class="list-group-item"><i class="fa fa-car"></i> <?php echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name']?></li>
                                               <?php
                                          }
                                     } if (!empty($vehicles['vehicle_buy'])) {
                                          ?>
                                          <li class="list-group-item active">Buy</li>
                                          <?php
                                          foreach ($vehicles['vehicle_buy'] as $key => $value) {
                                               ?>
                                               <li class="list-group-item"><i class="fa fa-car"></i> <?php echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name']?></li>
                                               <?php
                                          }
                                     }
                                   ?>
                              </ul>
                              <!-- -->
                              <div class="panel panel-default">
                                   <div class="panel-heading">Change enquiry status</div>
                                        <div class="panel-body">
                                             <?php if (empty($vehicle['current_status']) ||
                                                       (isset($vehicle['current_status']['sts_value']) && $vehicle['current_status']['sts_value'] == 1)) {
                                                    ?>
                                                    <form id="demo-form2" method="post" action="<?php echo site_url('followup/changeStatus');?>" data-parsley-validate class="form-horizontal form-label-left frmVehicleStatus">
                                                         <input type="hidden" class="txtEnqId" name="enh_enq_id" value="<?php echo isset($vehicles['enq_id']) ? $vehicles['enq_id'] : 0;?>"/>
                                                         <input type="hidden" name="quickfollowup" value="<?php echo isset($_GET['quickfollowup']) ? $_GET['quickfollowup'] : '';?>"/>
                                                         <input type="hidden" name="cb" value="<?php echo isset($_GET['cb']) ? $_GET['cb'] : '';?>"/>
                                                         <div class="form-group">
                                                              <?php if($this->uid == 100) { ?>
                                                                 <div class="col-md-12 col-sm-6 col-xs-12">
                                                                      <select class="select2_group form-control cmbFollStatus" name="enh_status" required="required">
                                                                           <option value="">Select status</option>
                                                                           <?php foreach ((array) $statuses as $key => $value) {?>
                                                                                <option data-slug="<?php echo $value['sts_slug'];?>" value="<?php echo $value['sts_value'];?>"><?php echo $value['sts_title'];?></option>
                                                                           <?php }?>
                                                                      </select>
                                                                 </div>
                                                              <?php } else { ?>
                                                                 <div class="col-md-12 col-sm-6 col-xs-12">
                                                                      <select class="select2_group form-control cmbFollStatus" name="enh_status" required="required">
                                                                           <option value="">Select status</option>
                                                                           <?php if($this->usr_grp == 'MG') { ?>
                                                                                <option value="1">Re-open</option>
                                                                           <?php } ?>
                                                                           <option value="2">Request for drop an inquiry</option>
                                                                           <option value="4">Request for Loss of sale/purchase</option>
                                                                           <option value="6">Request for close</option>
                                                                      </select>
                                                                 </div>
                                                              <?php } ?>
                                                         </div>

                                                         <div class="divBookingDetails"></div>

                                                         <div class="form-group">
                                                              <div class="col-md-12 col-sm-6 col-xs-12">
                                                                   <textarea placeholder="Remarks" required="required" name="enh_remarks" class="form-control col-md-7 col-xs-12 text-left vst_remarks"></textarea>
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
                                                  <?php
                                             }
                                        ?>
                                   </div>
                              </div>
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
                                                              <div style="font-size: 10px;"><?php echo $value['usr_first_name_adedby'] . ' - ' . $value['enh_added_on'];?></div>
                                                         </div>
                                                    </li>
                                                    <?php
                                               }
                                          }
                                          ?>
                                     </ul>
                                <?php }?>
                              <!-- -->
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document" style="width: 100%;">
          <div class="modal-content">
               <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="float: left;">Customer feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                    </button>
               </div>
               <div class="modal-body viewFollowUp"></div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnCloseModel" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btnSaveFollowUpFeedBack" 
                            data-url="<?php echo site_url('followup/editFollowUp');?>">Save changes</button>
               </div>
          </div>
     </div>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> 

<script>
     $(document).ready(function () {
          $(document).on('change', '.cmbFollStatus', function () {
               if ($(this).val() == 6) {
                    
                    $('.divBookingDetails').html($('.temVehicleAndPrice').html());
                    $('.select2').select2();
               } else {
                    $('.divBookingDetails').html('');
               }
          });
    

          // $('.cmbFollStatus').change(function () {
          //      if ($(this).val() == 6) {
          //           $('.divBookingDetails').html($('.temVehicleAndPrice').html());
          //      } else {
          //           $('.divBookingDetails').html('');
          //      }
          // });
     });
</script>


<script type="text/template" class="temVehicleAndPrice">

     <div class="form-group">
     <div class="col-md-12 col-sm-6 col-xs-12">
     <select onchange="$('.txtBookingAmt').val($('option:selected', this).attr('data-rdprice'));" name="enh_booked_vehicle"
     class="select2_group form-control select2" required="required">
     <option value="">Select vehicle</option>
     <?php
       foreach ((array) $stockVehicles as $key => $value) {
            $veh = $value['val_veh_no'] . ' (' . $value['brd_title'] . ', ' . $value['mod_title'] . ')';
            ?>
            <option data-rdprice="<?php echo $value['val_price_rd_to'];?>" 
            value="<?php echo $value['val_id'];?>"><?php echo $veh;?></option>
       <?php }?>
     </select>
     </div>
     </div>

     <div class="form-group">
     <div class="col-md-12 col-sm-6 col-xs-12">
     <input type="text" placeholder="Booking amount" required="required" name="enh_booking_amt" 
     class="txtBookingAmt form-control col-md-7 col-xs-12 text-left"/>
     </div>
     </div>

</script>





<script>

</script>
