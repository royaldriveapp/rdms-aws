<?php

$quickenqid = isset($_GET['quickfollowup']) ? '?quickfollowup=' . $_GET['quickfollowup'] : '';
$request['cb'] = isset($_GET['cb']) ? $_GET['cb'] : '';
$request['p'] = isset($_GET['p']) ? $_GET['p'] : '';
//  $totalVehicles = count($vehicles['vehicle_sale']) + count($vehicles['vehicle_buy']);
$index = 0;
foreach ((array) $vehicles['followups'] as $key => $value) {
     if (($value['foll_is_cmnt'] == 1) && ($value['foll_parent'] == 0)) {
          if ((check_permission('folup_trck_comment', 'viewgeneralcomment'))) {
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
                                   <?php if ($value['folloup_added_by_id'] != $this->uid) { ?>
                                        <p class="excerpt alignright">Added by :
                                             <?php
                                             echo isset($value['folloup_added_by']) ?
                                                  $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                                             ?>
                                        </p>
                                   <?php } else { ?>
                                        <p class="excerpt alignright">Added by : Self</p>
                                   <?php } ?>
                                   <?php echo date('d-m-Y h:i:s', strtotime($value['foll_entry_date'])); ?>
                              </div>
                              </p>
                              <?php echo !empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : ''; ?>
                              <div style="float: right;width: 100%;">
                                   <i title="Commented by <?php echo $value['folloup_upd_by']; ?>" class="fa fa-comments-o" style="float: right;"><?php echo $value['folloup_upd_by']; ?></i>
                              </div>
                         </div>
                         <!-- Repeated contents -->
                         <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;float: left;">
                              <p class="excerpt">
                                   <?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : ''; ?>
                              </p>
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
          <li fd="<?php echo isset($value['foll_id']) ? $value['foll_id'] : 0; ?>">
               <div class="block">
                    <?php
                    $enqStatus = isset($vehicles['enq_cus_when_buy']) ? $vehicles['enq_cus_when_buy'] : 0;
                    $status = !empty($value['foll_status']) ? $value['foll_status'] : $enqStatus;
                

                ?>

                    <div class="tags">
                         <?php
                         $folDateDMdy = !empty($value['foll_next_foll_date']) ? date('D M d Y', strtotime($value['foll_next_foll_date'])) :
                              date('D M d Y', strtotime($value['foll_entry_date']));

                         $folDateYmd = !empty($value['foll_next_foll_date']) ? date('Y-m-d', strtotime($value['foll_next_foll_date'])) :
                              date('Y-m-d', strtotime($value['foll_entry_date']));

                         $folDatejMY = !empty($value['foll_next_foll_date']) ? date('j M Y', strtotime($value['foll_next_foll_date'])) :
                              date('j M Y', strtotime($value['foll_entry_date']));

                         $reqtext = '?' . http_build_query(array_filter($request));
                         ?>
                         <a data-url="<?php echo site_url('followup/getSingleFollowup') . '/' . encryptor($vehicles['enq_id']) . '/' . $folDateYmd . '/' . $quickenqid . $reqtext; ?>" href="javascript:;" class="tagcolor<?php echo $value['foll_id']; ?> tag <?php echo $tagFollowUp; ?>" min-date="<?php echo $folDateDMdy; ?>">
                              <span><?php echo $folDatejMY; ?></span>
                         </a>
                    </div>
                    <?php //} 
                    ?>
                    <div class="block_content">
                         <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                              <span><i class="fa fa-car"></i>
                                   <?php echo $value['brd_title'] . ' ' . $value['mod_title'] . ' ' . $value['var_variant_name'] ?></span>
                         </p>
                         <?php echo !empty($value['foll_customer_feedback']) ? '<p class="excerpt">Customer remarks :' . $value['foll_customer_feedback'] . '</p>' : ''; ?>
                         <div style="float: right;width: 100%;">
                              <i title="Commented by <?php echo $value['folloup_upd_by']; ?>" class="fa fa-comments-o" style="float: right;"><?php echo $value['folloup_upd_by']; ?></i>
                         </div>
                    </div>

                    <!-- Repeated contents -->
                    <?php //if ((($key + 1) % $totalVehicles) == 0) {
                    ?>
                    <div style="font-style: italic;background: #E7E7E7;padding: 10px;float: left;width: 100%;">
                         <p class="excerpt">Remarks :
                              <?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : ''; ?>
                         </p>
                         <p class="excerpt">
                              <?php
                              $mod = unserialize(MODE_OF_CONTACT_FOLLOW_UP);
                              echo isset($mod[$value['foll_contact']]) ? 'Mode of contact : ' . $mod[$value['foll_contact']] : ''
                              ?>
                         </p>
                         <p class="excerpt">Next action plan :
                              <?php echo isset($value['foll_action_plan']) ? $value['foll_action_plan'] : ''; ?>
                         </p>
                         <?php
                         if (($value['foll_budget_from'] > 0) || ($value['foll_budget_to'] > 0)) {
                              echo '<p class="excerpt">Bdget : ' . $value['foll_budget_from'] . ' - ' . $value['foll_budget_to'] . '</p>';
                         }
                         if (($value['foll_km_from'] > 0) || ($value['foll_km_to'] > 0)) {
                              echo '<p class="excerpt">KM : ' . $value['foll_km_from'] . ' - ' . $value['foll_km_to'] . '</p>';
                         }
                         if (($value['foll_model_y_from'] > 0) || ($value['foll_model_y_to'] > 0)) {
                              echo '<p class="excerpt">Model year : ' . $value['foll_model_y_from'] . ' - ' . $value['foll_model_y_to'] . '</p>';
                         }
                         ?>
                    </div>
                    <!-- -->
                    <div style="margin-top: 10px;width:100%;padding-top:20px;font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;float: left;">
                         Comments : <p class="excerpt">
                              <?php echo isset($value['foll_remarks']) ? $value['foll_remarks'] : ''; ?>
                         </p>
                    </div>
                    <!-- -->
                    <?php if ($value['folloup_added_by_id'] != $this->uid) { ?>
                         <p style="width:100%;" class="excerpt alignright">Added by :
                              <?php
                              echo isset($value['folloup_added_by']) ?
                                   $value['folloup_added_by'] . ' (' . $value['shr_location'] . ')' : '';
                              ?>
                              <?php echo date('d-m-Y h:i:s', strtotime($value['foll_entry_date'])); ?>
                         </p>
                    <?php } else { ?>
                         <p style="width:100%;" class="excerpt alignright">Added by :- Self
                              <?php echo date('d-m-Y h:i:s', strtotime($value['foll_entry_date'])); ?>
                         </p>
                    <?php } ?>

                   

                    <!-- Load comments -->
<?php if (check_permission('folup_trck_comment', 'commentindividualfollowup')) { ?>
    <i style="font-size: 15px;" class="fa fa-comment" data-toggle="modal" data-target="#cmdModel<?php echo $value['foll_id']; ?>"></i>
<?php
}
if (check_permission('folup_trck_comment', 'viewindividualcomment')) {
    echo 'test Comment';
    $comments = $this->followup->getComments($value['foll_id']);
    if (!empty($comments)) {
        foreach ($comments as $k => $cmd) {
?>
            <div style="width: 100%;float: left;">
                <div class="block_content">
                    <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                        <div><i class="fa fa-clock-o"></i>
                            <?php if ($cmd['folloup_added_by_id'] != $this->uid) { ?>
                                <p class="excerpt alignright">Added by :
                                    <?php
                                    echo isset($cmd['folloup_added_by']) ?
                                        $cmd['folloup_added_by'] . ' (' . $cmd['shr_location'] . ')' : '';
                                    ?>
                                </p>
                            <?php } else { ?>
                                <p class="excerpt alignright">Jaefar Added by : Self</p>
                            <?php } ?>
                            <?php echo date('d-m-Y h:i:s', strtotime($cmd['foll_entry_date'])); ?>
                        </div>
                    </p>
                </div>
                <div class="tags" style="width: 25%;position: inherit;">
                    <div class="profile_pic">
                        <?php
                        echo img(array(
                            'src' => './assets/uploads/avatar/' . $cmd['usr_avatar'],
                            'class' => 'img-circle profile_img', 'style' => 'margin:0px 0px;'
                        ));
                        ?>
                    </div>
                </div>
                <div style="font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;width: 90%;float: right;">
                    <p class="excerpt">
                        <?php echo isset($cmd['foll_remarks']) ? $cmd['foll_remarks'] : ''; ?>
                    </p>
                </div>
            </div>
<?php
        }
    }
}
?>
<!-- Load comments -->


              
               </div>
          </li>
<?php
          $index++;
     }
}
?>