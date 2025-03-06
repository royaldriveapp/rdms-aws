<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>List vehicle registration | waiting for replay</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
                              <table id="datatable" class="table table-striped table-bordered">
                                   <thead>
                                        <tr>
                                             <th>Entry date</th>
                                             <th>Customer name</th>
                                             <th>Contact</th>
                                             <th>Place</th>
                                             <th>Contact mode</th>
                                             <th>Event</th>
                                             <th>Brand</th>
                                             <th>Model</th>
                                             <th>Variant</th>
                                             <th>Year</th>
                                             <th>Investment</th>
                                             <th>Added on</th>
                                             <th>Status</th>
                                             <th>Call type</th>
                                             <td>Department</td>
                                             <th>Assigned to</th>
                                             <th>Added by</th>
                                             <td>Remarks</td>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                          foreach ((array) $datas as $key => $value) {
                                               $remarks = strip_tags($value['vreg_customer_remark']);
                                               ?>
                                               <tr style="<?php echo ($value['vreg_status'] == 0) ? 'color: #fff;background-color: red;' : '';?>"
                                                   data-url="<?php echo site_url($controller . '/view/' . encryptor($value['vreg_id']));?>">
                                                    <td style="wid"><?php echo date('j M Y', strtotime($value['vreg_entry_date']));?></td>
                                                    <td><?php echo $value['vreg_cust_name'];?></td>
                                                    <td><a style="color: #fff;" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $value['vreg_cust_phone'];?>"><?php echo $value['vreg_cust_phone'];?></a></td>
                                                    <td><?php echo $value['vreg_cust_place'];?></td>
                                                    <td>
                                                         <?php
                                                         $modes = unserialize(MODE_OF_CONTACT);
                                                         echo isset($modes[$value['vreg_contact_mode']]) ? $modes[$value['vreg_contact_mode']] : '';
                                                         ?>                                               
                                                    </td>
                                                    <td><?php echo $value['evnt_title'];?></td>
                                                    <td><?php echo $value['brd_title'];?></td>
                                                    <td><?php echo $value['mod_title'];?></td>
                                                    <td><?php echo $value['var_variant_name'];?></td>
                                                    <td><?php echo $value['vreg_year'];?></td>
                                                    <td><?php echo $value['vreg_investment'];?></td>
                                                    <td><?php echo date('j M Y', strtotime($value['vreg_added_on']));?></td>
                                                    <td><?php echo ($value['vreg_is_verified'] == 1) ? 'Verified' : 'Pending';?></td>
                                                    <td>
                                                         <?php
                                                         $callTypes = unserialize(CALL_TYPE);
                                                         echo isset($callTypes[$value['vreg_call_type']]) ? $callTypes[$value['vreg_call_type']] : '';
                                                         ?>
                                                    </td>
                                                    <td><?php echo $value['dep_name'];?></td>
                                                    <td><?php echo $value['assign_usr_first_name'];?></td>
                                                    <td><?php echo $value['addedby_usr_first_name'];?></td>
                                                    <td class="trVOE"><?php echo $remarks;?></td>
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
</div>
<style>
     .table>thead>tr>th {
          white-space: nowrap;
          width: 1%;
     }
     .table>tbody>tr>td {
          white-space: nowrap;
          width: 1%;
     }
</style>