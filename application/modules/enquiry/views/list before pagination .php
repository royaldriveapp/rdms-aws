<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Customer ID</th>
                                        <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<th>Sales Executive</th>' : '';?>
                                        <th>Added By</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Whatsapp</th>
                                        <th>Enquiry Date</th>
                                        <th>Action</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($enquires)) {
                                          foreach ($enquires as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url('enquiry/view/' . encryptor($value['enq_id']));?>">
                                                    <th class="trVOE"><?php echo generate_vehicle_virtual_id($value['enq_id']);?></th>
                                                    <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<td class="trVOE">' . strtoupper($value['usr_first_name']) . '</td>' : '';?>
                                                    <td class="trVOE"><?php echo ($value['usr_id'] == $value['enq_added_by']) ? 'Self' : $value['enq_added_by_name'];?></td>
                                                    <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']);?></td>
                                                    <td> <a target="blank" <?php echo 'href="tel:' . $value['enq_cus_mobile'] . '"';?> > <?php echo $value['enq_cus_mobile'];?> </a></td>
                                                    <td> <a target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['enq_cus_whatsapp'] . '"';?> > <?php echo $value['enq_cus_whatsapp'];?> </a></td>
                                                    <td class="trVOE"><?php echo date('j M Y', strtotime($value['enq_entry_date']));?></td>
                                                    <td><a title="Print track card" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($value['enq_id']));?>"><span class="glyphicon glyphicon-print"></span></a></td>
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
