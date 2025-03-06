<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>All Followup</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <td>#Vehicle ID</td>
                                        <th>Vehicle</th>
                                        <th>Customer</th>
                                        <?php echo $this->usr_grp != 'SE' ? '<th>Sales Executive</th>' : '';?>
                                        <th>Phone</th>
                                        <th>Whatsapp</th>
                                        <th>Next followup</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $enquires as $key => $enq) {
                                          $type = $enq['veh_status'] == 1 ? 's' : 'b';
                                          ?>
                                          <tr data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($enq['enq_id']) . '/' . encryptor($enq['veh_id']) . '/' . $type);?>">
                                               <td class="trVOE"><?php echo generate_vehicle_virtual_id($enq['veh_id']);?></td>
                                               <td class="trVOE"><?php echo $enq['brd_title'] . ', ' . $enq['mod_title'] . ', ' . $enq['var_variant_name'];?></td>
                                               <td class="trVOE"><?php echo strtoupper($enq['enq_cus_name']);?></td>
                                               <?php echo $this->usr_grp != 'SE' ? '<td class="trVOE">' . $enq['usr_first_name'] . '</td>' : '';?>
                                               <td><a href="tel:<?php echo $enq['enq_cus_mobile'];?>" ><?php echo $enq['enq_cus_mobile'];?></a></td>
                                               <td><a href="https://api.whatsapp.com/send?phone=<?php echo $enq['enq_cus_whatsapp'];?>"><?php echo $enq['enq_cus_whatsapp'];?></a></td>
                                               <td class="trVOE"><?php echo date('j M Y', strtotime($enq['foll_next_foll_date']));?></td>
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