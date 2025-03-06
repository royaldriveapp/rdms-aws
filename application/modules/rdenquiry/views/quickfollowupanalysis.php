<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Quick followup</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Name (track card)</th>
                                        <th>Number</th>
                                        <th>Whatsapp</th>
                                        <th>Vehicle</th>
                                        <th>Enq date</th>
                                        <th>Sales staff</th>
                                        <th>Current Sales staff</th>
                                        <th>Comment</th>
                                        <th>Followup</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($enquires)) {
                                          foreach ($enquires as $key => $value) {
                                               $trColor = 'style="background-color:green;color:white"';
                                               if($value['qtr_reply_by'] == 0) {
                                                  $trColor = 'style="background-color:red;color:white"';
                                               }
                                               ?>
                                               <tr <?php echo $trColor; ?> data-url="<?php echo site_url($controller . '/view/' . $value['shr_id']);?>" id="trQuickFollow<?php echo $value['qtr_id']?>">
                                                    <td>
                                                         <?php echo $value['enq_cus_name'];?>
                                                         <a target="_blank" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($value['enq_id']));?>">
                                                            <i <?php echo $trColor; ?> title="Track card" class="fa fa-copy"></i>
                                                         </a>
                                                    </td>
                                                    <td><?php echo $value['enq_cus_mobile'];?></td>
                                                    <td><?php echo $value['enq_cus_whatsapp'];?></td>
                                                    <td><?php echo $value['qtr_vehile'];?></td>
                                                    <td><?php echo date('j M Y', strtotime($value['enq_entry_date']));?></td>
                                                    <td><?php echo $value['oldse_username'];?></td>
                                                    <td><?php echo $value['newse_username'];?></td>
                                                    <td><?php echo $value['qtr_replay'];?></td>
                                                    <td>
                                                         <a href="<?php echo site_url('followup/viewFollowup/' . encryptor($value['qtr_enq_id']) . '?quickfollowup=' . $value['qtr_id']);?>">
                                                              <i <?php echo $trColor; ?> class="fa fa-calendar-check-o"></i></a>
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