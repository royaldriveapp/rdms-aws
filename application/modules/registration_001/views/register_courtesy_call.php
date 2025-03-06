<div class="right_col" role="main">     
     <div class="row">          
          <div class="col-md-12 col-sm-12 col-xs-12">               
               <div class="x_panel">                    
                    <div class="x_title">                         
                         <h2>Register second day courtesy call</h2>                         
                         <div class="clearfix"></div>                    
                    </div>

                    <div class="x_content">
                         <div style="width: 100%;overflow-x: scroll;">
                              <table id="tblValuation" class="table table-striped table-bordered">                              
                                   <thead>
                                        <tr>
                                             <th>Entry date</th>
                                             <th>Customer name</th>
                                             <th>Customer status</th>
                                             <th>Contact</th>
                                             <th>Place</th>
                                             <th>District</th>
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
                                             <th>Added by</th>
                                             <td>Remarks</td>
                                             <td>Punched on</td>
                                             <th>Appointment on</th>
                                             <th>Second day courtesy call</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                        if (!empty($datas)) {
                                             foreach ((array) $datas as $key => $value) {
                                                  $remarks = strip_tags($value['vreg_customer_remark']);
                                                  ?>
                                                  <tr data-url="<?php echo site_url('registration/view/' . encryptor($value['vreg_id'])); ?>">
                                                       <td style="wid">
                                                            <?php if ($value['vreg_is_effective'] == 1) { ?><i title="Effective call" style="color: green;" class="fa fa-check"></i> <?php } ?>
                                                            <?php echo date('j M Y', strtotime($value['vreg_entry_date'])); ?>
                                                       </td>

                                                       <td><?php echo $value['vreg_cust_name']; ?></td>
                                                       <td>
                                                            <?php
                                                            $stsMods = unserialize(ENQUIRY_UP_STATUS);
                                                            echo $stsMods = isset($stsMods[$value['vreg_customer_status']]) ? $stsMods[$value['vreg_customer_status']] : '';
                                                            ?>
                                                       </td>
                                                       <td><a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $value['vreg_cust_phone']; ?>"><?php echo $value['vreg_cust_phone']; ?></a></td>
                                                       <td><?php echo $value['vreg_cust_place']; ?></td>
                                                       <td><?php echo $value['std_district_name']; ?></td>
                                                       <td>
                                                            <?php
                                                            $modes = unserialize(MODE_OF_CONTACT);
                                                            echo isset($modes[$value['vreg_contact_mode']]) ? $modes[$value['vreg_contact_mode']] : '';
                                                            ?>                                               
                                                       </td>
                                                       <td><?php echo $value['evnt_title']; ?></td>
                                                       <td><?php echo $value['brd_title']; ?></td>
                                                       <td><?php echo $value['mod_title']; ?></td>
                                                       <td><?php echo $value['var_variant_name']; ?></td>
                                                       <td><?php echo $value['vreg_year']; ?></td>
                                                       <td><?php echo $value['vreg_investment']; ?></td>
                                                       <td><?php echo date('j M Y', strtotime($value['vreg_added_on'])); ?></td>
                                                       <td><?php echo ($value['vreg_is_verified'] == 1) ? 'Verified' : 'Pending'; ?></td>
                                                       <td>
                                                            <?php
                                                            $callTypes = unserialize(CALL_TYPE);
                                                            echo isset($callTypes[$value['vreg_call_type']]) ? $callTypes[$value['vreg_call_type']] : '';
                                                            ?>
                                                       </td>
                                                       <td><?php echo $value['dep_name']; ?></td>
                                                       <td><?php echo $value['addedby_usr_first_name']; ?>
                                                            <?php if ($value['vreg_last_action']) { ?>
                                                                 <i class="fa fa-comment" style="color: #fff;" title="<?php echo $value['vreg_last_action']; ?>"></i>
                                                            <?php } ?>
                                                       </td>
                                                       <td><?php echo $remarks; ?></td>
                                                       <td style="wid">
                                                            <?php echo date('j M Y h:i A', strtotime($value['vreg_added_on'])); ?>
                                                       </td>
                                                       <td><?php echo!empty($value['vreg_appointment']) ? date('j M Y', strtotime($value['vreg_appointment'])) : ''; ?></td>
                                                       <td>
                                                            <form method="post" action="<?php echo site_url('registration/updateRegisterCourtesyCall'); ?>">
                                                                 <input required type="text" name="vreg_second_d_hpy_cal"/>
                                                                 <input type="hidden" name="vreg_cust_phone" value="<?php echo $value['vreg_cust_phone']; ?>"/>
                                                                 <input type="hidden" name="vreg_added_by" value="<?php echo $value['vreg_added_by']; ?>"/>
                                                                 <input type="hidden" name="vreg_assigned_to" value="<?php echo $value['vreg_assigned_to']; ?>"/>
                                                                 <input type="hidden" name="vreg_status" value="<?php echo $value['vreg_status']; ?>"/>
                                                                 <input type="hidden" name="vreg_id" value="<?php echo $value['vreg_id']; ?>"/>
                                                                 <input type="submit" value="Submit"/>
                                                            </form>
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
</div>
<script>
     $(document).ready(function () {
          $('#tblValuation').DataTable();
     });
</script>
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