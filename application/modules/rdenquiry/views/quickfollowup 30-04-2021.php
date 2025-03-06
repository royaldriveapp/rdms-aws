<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Quick followup</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="tblQuickAssign table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Name (track card)</th>
                                        <th>Number</th>
                                        <th>Whatsapp</th>
                                        <th>Vehicle</th>
                                        <th>Sales officer</th>
                                        <th>Enq date</th>
                                        <th>Followup</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($enquires)) {
                                          foreach ($enquires as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url($controller . '/view/' . $value['shr_id']);?>" id="trQuickFollow<?php echo $value['qtr_id']?>">
                                                    <td>
                                                         <?php echo $value['enq_cus_name'];?>
                                                         <a target="_blank" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($value['enq_id']));?>"><i title="Track card" class="fa fa-copy"></i></a>
                                                         <span style="color: #F7F7F7;"><?php echo $value['qtr_id'];?></span>
                                                    </td>
                                                    <td><a target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['enq_cus_mobile'] . '"';?>><?php echo $value['enq_cus_mobile'];?></a></td>
                                                    <td><a target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['enq_cus_whatsapp'] . '"';?>><?php echo $value['enq_cus_whatsapp'];?></a></td>
                                                    <td><?php echo $value['qtr_vehile'];?></td>
                                                    <td><?php echo $value['usr_username'];?></td>
                                                    <td><?php echo date('j M Y', strtotime($value['enq_entry_date']));?></td>
                                                    <td>
                                                         <a href="<?php echo site_url('followup/viewFollowup/' . encryptor($value['qtr_enq_id']) . '?quickfollowup=' . $value['qtr_id'] . '&cb=' . 'enquiry-quickfollowup');?>">
                                                              <i class="fa fa-calendar-check-o"></i></a>
                                                    </td>
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