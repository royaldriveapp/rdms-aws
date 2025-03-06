<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>All Followup</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table class="datatableFollowup table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Name</th>
                                        <?php echo $this->usr_grp != 'SE' ? '<th>Sales Executive</th>' : '';?>
                                        <th>Type</th>
                                        <th>Mobile</th>
                                        <th>Whatsapp</th>
                                        <th>Added by</th>
                                        <th>Next Follow up Date</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $enquires as $key => $value) {
                                          $now = date('Y-m-d');
                                          $date1 = new DateTime($follupDate = date('Y-m-d', strtotime($value['enq_next_foll_date'])));
                                          $date2 = new DateTime($now);
                                          $color = '';

                                          if ($date2->diff($date1)->format("%r%a") <= 2) {
                                               $color = 'background:red;color:#fff !important;';
                                          }
                                          $segment = ($value['enq_cus_status'] == 1) ? 's' : 'b';
                                          $type = unserialize(VEHICLE_DETAILS_STATUS);
                                          ?>
                                          <tr title="<?php echo empty($value['foll_id']) ? 'Pending to set followup date' : '';?>"
                                              style="<?php echo $color;?>"
                                              data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($value['enq_id']));?>">
                                               <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']);?></td>
                                               <?php echo $this->usr_grp != 'SE' ? '<td class="trVOE">' . $value['usr_first_name'] . '</td>' : '';?>
                                               <td class="trVOE"><?php echo $type[$value['enq_cus_status']];?></td>
                                               <td><a style="<?php echo $color;?>" href="tel:<?php echo $value['enq_cus_mobile'];?>"><?php echo $value['enq_cus_mobile'];?></a></td>
                                               <td class="trVOE"><a style="<?php echo $color;?>" href="https://api.whatsapp.com/send?phone=<?php echo $value['enq_cus_email'];?>"><?php echo $value['enq_cus_whatsapp'];?></a></td>
                                               <td class="trVOE"><?php echo ($value['enq_added_by_id'] == $this->uid) ? 'Self' : $value['enq_added_by_name'];?></td>
                                               <td class="trVOE"><?php echo date('j M Y', strtotime($value['enq_next_foll_date']));?></td>
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