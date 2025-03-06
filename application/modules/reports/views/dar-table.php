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