<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Booked vehicles</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table class="datatableFollowup table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Registration</th>
                                        <th>Customer Name</th>
                                        <th>Booked by</th>
                                        <th>Phone number (Official)</th>
                                        <th>Phone number (Personal)</th>
                                        <th>Permanent address</th>
                                        <th>RC Transfer address</th>
                                        <th>Booked on</th>
                                        <th>Expect delivery on</th>
                                        <th>Current status</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $rejectedBooking as $key => $value) {
                                          $trColor = '';
                                          if ($value['vbk_status'] == vehicle_booked) {
                                               $trColor = '';
                                          } else if ($value['vbk_status'] == reject_book) {
                                               $trColor = 'background-color: red;color: white;';
                                          } else if ($value['vbk_status'] == confm_book) {
                                               $trColor = 'background-color: green;color: white;';
                                          }
                                          ?>
                                          <tr style="<?php echo $trColor;?>" data-url="<?php echo site_url('followup/bookingDetails/' . encryptor($value['vbk_id']));?>">
                                               <td class="trVOE"><?php echo $value['val_veh_no'];?></td>
                                               <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']);?></td>
                                               <td class="trVOE"><?php echo $value['bkdby_first_name'] . ' ' . $value['btdby_last_name'];?></td>
                                               <td><a href="tel:<?php echo $value['vbk_off_ph_no'];?>"><?php echo $value['vbk_off_ph_no'];?></a></td>
                                               <td><a href="tel:<?php echo $value['vbk_per_ph_no'];?>"><?php echo $value['vbk_per_ph_no'];?></a></td>
                                               <td class="trVOE"><?php echo $value['vbk_per_address'];?></td>
                                               <td class="trVOE"><?php echo $value['vbk_rd_trans_address'];?></td>
                                               <td class="trVOE"><?php echo date('j M Y h:i A', strtotime($value['vbk_added_on']));?></td>
                                               <td class="trVOE">
                                                    <?php
                                                    echo!empty($value['vbk_expect_delivery']) ?
                                                            date('j M Y h:i A', strtotime($value['vbk_expect_delivery'])) : '';
                                                    ?>
                                               </td>
                                               <td title="<?php echo $value['sts_des'];?>" class="trVOE"><?php echo $value['sts_title'];?></td>
                                          </tr>
                                          <?php
                                     }
                                   ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>

<style>
     a {
          color: unset;
     }
</style>