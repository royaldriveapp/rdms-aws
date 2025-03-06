<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Freezed Enquires</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <?php echo (check_permission('enquiry', 'freezevehicle')) ? '<th>Unfreeze</th>' : '';?>
                                        <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<th>Sales Executive</th>' : '';?>
                                        <th>Added By</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Whatsapp</th>
                                        <th>Enquiry Date</th>
                                        <th>Entry Date</th>
                                        <?php echo (is_roo_user()) ? '<th>Action</th>' : '';?>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     $tmpEnqId = array();
                                     if (!empty($enquires)) {
                                          foreach ($enquires as $key => $value) {
                                               $orginal = $this->enquiry->getOriginalFreezedEnquiry($value['enq_cus_mobile']);
                                               if (!empty($orginal) && !in_array($orginal['enq_id'], $tmpEnqId)) {
                                                    ?>
                                                    <tr style="background: green;color: white;" data-url="<?php echo site_url('enquiry/printTrackCard/' . encryptor($orginal['enq_id']));?>">
                                                         <?php if (check_permission('enquiry', 'freezevehicle')) {?> 
                                                              <td><input <?php echo $orginal['enq_current_status'] == 9 ? 'checked="true"' : '';?> 
                                                                        type="checkbox" class="chbFreeze" value="1" 
                                                                        data-url="<?php echo site_url('enquiry/freezeVehicle/' . encryptor($orginal['enq_id']));?>"/></td>
                                                              <?php }?>
                                                              <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<td class="trVOE">' . strtoupper($orginal['usr_first_name']) . '</td>' : '';?>
                                                         <td class="trVOE"><?php echo ($orginal['usr_id'] == $orginal['enq_added_by']) ? 'Self' : $orginal['enq_added_by_name'];?></td>
                                                         <td class="trVOE"><?php echo strtoupper($orginal['enq_cus_name']);?></td>
                                                         <td> <a style="color: white;" target="blank" <?php echo 'href="tel:' . $orginal['enq_cus_mobile'] . '"';?> > <?php echo $orginal['enq_cus_mobile'];?> </a></td>
                                                         <td> <a style="color: white;" target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $orginal['enq_cus_whatsapp'] . '"';?> > <?php echo $orginal['enq_cus_whatsapp'];?> </a></td>
                                                         <td class="trVOE"><?php echo date('j M Y', strtotime($orginal['enq_entry_date']));?></td>
                                                         <td class="trVOE"><?php echo date('j M Y h:i:s', strtotime($orginal['enq_added_on']));?></td>
                                                         <?php echo (is_roo_user()) ? '<td></td>' : '';?>
                                                    </tr>
                                                    <?php
                                                    $tmpEnqId[] = $orginal['enq_id'];
                                               }
                                               ?>
                                               <tr data-url="<?php echo site_url('enquiry/printTrackCard/' . encryptor($value['enq_id']));?>">
                                                    <?php if (check_permission('enquiry', 'freezevehicle')) {?> 
                                                         <td><input <?php echo $value['enq_current_status'] == 9 ? 'checked="true"' : '';?> 
                                                                   type="checkbox" class="chbFreeze" value="1" 
                                                                   data-url="<?php echo site_url('enquiry/freezeVehicle/' . encryptor($value['enq_id']));?>"/></td>
                                                         <?php }?>
                                                         <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<td class="trVOE">' . strtoupper($value['usr_first_name']) . '</td>' : '';?>
                                                    <td class="trVOE"><?php echo ($value['usr_id'] == $value['enq_added_by']) ? 'Self' : $value['enq_added_by_name'];?></td>
                                                    <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']);?></td>
                                                    <td> <a target="blank" <?php echo 'href="tel:' . $value['enq_cus_mobile'] . '"';?> > <?php echo $value['enq_cus_mobile'];?> </a></td>
                                                    <td> <a target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['enq_cus_whatsapp'] . '"';?> > <?php echo $value['enq_cus_whatsapp'];?> </a></td>
                                                    <td class="trVOE"><?php echo date('j M Y', strtotime($value['enq_entry_date']));?></td>
                                                    <td class="trVOE"><?php echo date('j M Y h:i:s', strtotime($value['enq_added_on']));?></td>
                                                    <?php if (is_roo_user()) {?>
                                                         <td>
                                                              <a class="pencile deleteFreezListItem" href="javascript:void(0);" data-url="<?php echo site_url('enquiry/permenentDelete/' . encryptor($value['enq_id']));?>">
                                                                   <i title="Permenent delete" class="fa fa-trash"></i>
                                                              </a>
                                                         </td>
                                                    <?php }?>
                                               </tr>
                                               <?php
                                          }
                                     }
                                   ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>
