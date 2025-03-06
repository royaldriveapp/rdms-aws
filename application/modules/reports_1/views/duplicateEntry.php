<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Duplicate entries</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Freeze</th>
                                        <th>Vehicle ID</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Type</th>
                                        <th>Sales Executive</th>
                                        <th>Customer Name</th>
                                        <th>Contact No</th>
                                        <th>Showroom</th>
                                        <th>Entry Date</th>
                                        <th>Action</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $vehicles as $key => $veh) {
                                          $canEdit = (($this->uid == $veh['enq_se_id']) || is_roo_user()) ? 'trVOE' : '';
                                          ?>
                                          <tr style="<?php echo (!empty($canEdit) && !is_roo_user()) ? 'background:yellowgreen;color:#fff;' : '';?>">
                                               <td><input <?php echo $veh['enq_current_status'] == 9 ? 'checked="true"' : '';?> type="checkbox" class="chbFreeze" value="1" 
                                                                                                                                 data-url="<?php echo site_url('reports/freezeVehicle/' . encryptor($veh['enq_id']));?>"/>
                                               </td>
                                               <td><?php echo generate_vehicle_virtual_id($veh['veh_id']);?></td>
                                               <td><?php echo $veh['brd_title'];?></td>
                                               <td><?php echo $veh['mod_title'];?></td>
                                               <td><?php echo $veh['veh_status'] == 1 ? 'Sell' : 'Buy';?></td>
                                               <td><?php echo $veh['usr_first_name'];?></td>
                                               <td><?php echo $veh['enq_cus_name'];?></td>
                                               <td><a href="tel:<?php echo $veh['enq_cus_mobile'];?>"><?php echo $veh['enq_cus_mobile'];?></a></td>
                                               <td><?php echo $veh['shr_location'];?></td>
                                               <td><?php echo date('j M Y', strtotime($veh['enq_entry_date']));?></td>
                                               <td>
                                                    <a title="View track card" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($veh['enq_id']));?>">
                                                         <i class="glyphicon glyphicon-print"></i>
                                                    </a>
                                                    <a title="Edit enquiry" href="<?php echo site_url('enquiry/view/' . encryptor($veh['enq_id']));?>">
                                                         <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a title="Permenent delete vehicle" onclick="return confirm('Are you sure want to delete this enquiry?')" href="<?php echo site_url('enquiry/delete/' . encryptor($veh['enq_id']) . '/' . encryptor('reports/duplicateEntry'));?>">
                                                         <i class="fa fa-trash"></i>
                                                    </a>
                                               </td>
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