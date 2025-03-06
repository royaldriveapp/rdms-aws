<div class="panel panel-default">
     <div class="panel-heading">Previous history</div>
     <div class="panel-body">
          <?php  $modes = unserialize(MODE_OF_CONTACT);
            if (!empty($reghistory)) {?>
                 <ul class="list-unstyled timeline">
                      <?php
                      foreach ($reghistory as $key => $value) {
                           ?>
                           <li>
                                <div class="block">
                                     <div class="tags">
                                          <a href="javascript:;" class="tag">
                                               <span><?php echo date('j M Y', strtotime($value['vreg_added_on']));?></span>
                                          </a>
                                     </div>
                                     <div class="block_content">
                                          <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                               <span><?php echo 'Customer name : ' . $value['vreg_cust_name'];?></span>
                                          </p>
                                     </div>
                                     <div class="block_content">
                                          <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                               <span><?php echo 'Assign to : ' . $value['assto_usr_name'];?></span>
                                          </p>
                                     </div>
                                     <div class="block_content">
                                        <?php 
                                             $addorreassignText = ($value['fwon_usr_id'] == $value['adby_usr_id']) ? 'Added by ' : 'Re-assgned by ';
                                             $addorreassignName = ($value['fwon_usr_id'] == $value['adby_usr_id']) ? $value['fwon_usr_name'] : $value['adby_usr_name']; 
                                        ?>
                                        <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                             <span><?php echo $addorreassignText . ' : ' . $addorreassignName;?></span>
                                        </p>
                                     </div>
                                     <div class="block_content">
                                        <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                             <span><?php echo  isset($modes[$value['vreg_contact_mode']]) ? 'Mode of contact : ' . $modes[$value['vreg_contact_mode']] : '';?></span>
                                        </p>
                                     </div>
                                     <!-- Repeated contents -->
                                     <div style="font-style: italic;background: #E7E7E7;padding: 10px;">
                                          <p class="excerpt"><?php echo $value['vreg_customer_remark'];?></p>
                                     </div>

                                     <?php if(isset($value['vreg_last_action']) && !empty($value['vreg_last_action'])) { ?>
                                        <div style="margin-top: 10px;font-style: italic;background: #E7E7E7;padding: 10px;">
                                             <span class="glyphicon glyphicon-comment"></span> <?php echo $value['adby_usr_name']. ' " ' . $value['vreg_last_action'] .' " '; ?>
                                        </div>     
                                     <?php } ?>
                                </div>
                           </li>
                           <?php
                      }
                      ?>
                 </ul>
            <?php } else {?>
                 <span>No previous history found</span>
            <?php }?>
     </div>
</div>