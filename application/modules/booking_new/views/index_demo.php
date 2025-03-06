<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Booked vehicles</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <?php if (check_permission('booking', 'exportbookedvehicles')) {?>
                                   <li style="float: right;">
                                        <a href="<?php echo site_url('booking/exportbookedvehicles?' . $_SERVER['QUERY_STRING']);?>">
                                             <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                        </a>
                                   </li>
                              <?php } ?>
                         </ul>
                         <div style="float: right;">
                              <i class="fa fa-circle" style="color: green;"> <span style="color:#000">Verified</span></i>
                              <i class="fa fa-circle" style="color: #FFFF00;"> <span style="color:#000">Deliverd</span></i>
                         </div>
                         <div class="clearfix"></div>
                    </div>
                         <div class="x_content">
                              <form action="" method="get">
                                   <table>
                                        <tr>
                                             <td>
                                                  <input autocomplete="off" name="vbk_added_on_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                       placeholder="Booking date from" value="<?php echo isset($_GET['vbk_added_on_from']) ? $_GET['vbk_added_on_from'] : ''; ?>"/>
                                             </td>
                                             <td style="padding-left: 10px;">
                                                  <input autocomplete="off" name="vbk_added_on_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                       placeholder="Booking date to" value="<?php echo isset($_GET['vbk_added_on_to']) ? $_GET['vbk_added_on_to'] : ''; ?>"/>
                                             </td>
                                             <?php if (check_permission('reports', 'fltr_enquiries_enq_salesstaff')) {?>
                                                  <td style="padding-left: 10px;">
                                                       <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control cmbSalesExecutives" name="executive[]">
                                                            <option value="<?php echo $this->uid; ?>">My self</option>
                                                            <?php
                                                            foreach ((array) $salesExecutives as $key => $value) {
                                                                 if (!empty($showroom)) {
                                                                      if ($showroom == $value['usr_showroom']) {
                                                                           ?>
                                                                           <option value="<?php echo $value['usr_id'];?>"
                                                                                     <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : '';?>>
                                                                                <?php echo $value['usr_first_name'];?></option> 
                                                                           <?php
                                                                      }
                                                                 } else {
                                                                      ?>
                                                                      <option <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : '';?>
                                                                           value="<?php echo $value['usr_id'];?>"><?php echo $value['usr_first_name'];?></option> 
                                                                           <?php
                                                                      }
                                                                 }
                                                                 ?>
                                                       </select>
                                                  </td>
                                             <?php } 
                                                  $sts = isset($_GET['status']) ? $_GET['status'] : 0;
                                             ?>
                                             <td>
                                                  <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control" name="status[]">
                                                       <option value="<?php echo confm_book; ?>"
                                                            <?php echo (@in_array(confm_book, $sts)) ? 'selected="selected"' : '';?>>Booking confirmed</option>

                                                       <option value="<?php echo vehicle_booked; ?>"
                                                            <?php echo (@in_array(vehicle_booked, $sts)) ? 'selected="selected"' : '';?>>Vehicle booked</option>

                                                       <option value="<?php echo book_delvry; ?>"
                                                            <?php echo (@in_array(book_delvry, $sts)) ? 'selected="selected"' : '';?>>Vehicle delivered</option>
                                                  </select>
                                             </td>
                                        </tr>
                                        <tr>
                                             <td style="padding-left: 10px;">
                                                  <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                             </td>
                                        </tr>
                                   </table>
                              </form>
                         </div>

                    <div class="x_content">
                         <table id="tblBooking" class="table table-striped table-bordered display nowrap" style="width:100%;white-space: nowrap;">
                              <thead>
                                   <tr>
                                        <th>Booking ID</th>
                                        <th>Booked on</th>
                                        <th>Registration</th>
                                        <th>Enq No</th>
                                        <th>Customer Name</th>
                                        <th>Customer Source</th>
                                        <th>Booked by</th>
                                        <th>Sales Staff</th>
                                        <th>Phone number (Official)</th>
                                        <th>Phone number (Personal)</th>
                                        <th>Permanent address</th>
                                        <th>RC Transfer address</th>
                                        <th>Expect delivery on</th>
                                        <th>Insurance status</th>
                                        <th>RC Transfer status</th>
                                        <th>Current status</th>
                                        <?php if($this->uid == 100) { ?>
                                             <th>Delete</th>
                                        <?php } if(check_permission('booking', 'editbooking')) { ?>
                                             <th>Edit</th>
                                        <?php } ?>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   $mod = unserialize(MODE_OF_CONTACT);
                                   foreach ((array) $bookingVehicles as $key => $value) {
                                        $trColor = '';
                                        if ($value['vbk_status'] == vehicle_booked) {
                                             $trColor = '';
                                        } else if ($value['vbk_status'] == reject_book) {
                                             $trColor = 'background-color: red;color: white;';
                                        } else if (in_array($value['vbk_status'], array(confm_book, dc_ready_to_del))) {
                                             $trColor = 'background-color: green;color: white;';
                                        } else if ($value['vbk_status'] == book_delvry) {
                                             $trColor = 'background-color: #FFFF00;color: #000;';
                                        }
                                        ?>
                                        <tr style="<?php echo $trColor; ?>" data-url="<?php echo site_url('booking/bookingDetails/' . encryptor($value['vbk_id'])); ?>">
                                             <td class="trVOE"><?php echo $value['vbk_ref_no']; ?></td>
                                             <td class="trVOE"><?php echo date('j M Y', strtotime($value['vbk_added_on'])); ?></td><!--  h:i A -->
                                             <td class="trVOE"><?php echo $value['val_veh_no']; ?></td>
                                             <td class="trVOE"><?php echo $value['enq_number']; ?></td>
                                             <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']); ?></td>
                                             <td class="trVOE"><?php echo isset($mod[$value['enq_mode_enq']]) ? $mod[$value['enq_mode_enq']] : ''; ?></td>
                                             <td class="trVOE"><?php echo $value['bkdby_first_name'] . ' ' . $value['btdby_last_name']; ?></td>
                                             <td class="trVOE"><?php echo $value['salesstaff_first_name'] . ' ' . $value['salesstaff_last_name']; ?></td>
                                             <td><a href="tel:<?php echo $value['vbk_off_ph_no']; ?>"><?php echo $value['vbk_off_ph_no']; ?></a></td>
                                             <td><a href="tel:<?php echo $value['vbk_per_ph_no']; ?>"><?php echo $value['vbk_per_ph_no']; ?></a></td>
                                             <td class="trVOE"><?php echo $value['vbk_per_address']; ?></td>
                                             <td class="trVOE"><?php echo $value['vbk_rd_trans_address']; ?></td>
                                             <td class="trVOE">
                                                  <?php
                                                  echo!empty($value['vbk_expect_delivery']) ?
                                                          date('j M Y h:i A', strtotime($value['vbk_expect_delivery'])) : '';
                                                  ?>
                                             </td>
                                             <td style="<?php echo $trColor; ?>" title="<?php echo $value['rfi_in_sts_title']; ?>" class="trVOE"><?php echo $value['rfi_in_sts_title']; ?></td>
                                             <td style="<?php echo $trColor; ?>" title="<?php echo $value['rfi_rc_sts_title']; ?>" class="trVOE"><?php echo $value['rfi_rc_sts_title']; ?></td>
                                             <td title="<?php echo $value['sts_des']; ?>" class="trVOE"><?php echo $value['sts_title']; ?></td>
                                             <?php if($this->uid == 100) { ?>
                                                  <td>
                                                       <a title="Permenent delete booking" class="btnRemoveTableRow" href="javascript:void(0);" 
                                                                 data-url="<?php echo site_url('booking/permenentdeletebooking/' . encryptor($value['vbk_id'])); ?>">
                                                            <i title="View document" class="fa fa-trash"></i>
                                                       </a>
                                                  </td>
                                             <?php } if(check_permission('booking', 'editbooking')) { ?>
                                                  <td>
                                                       <a title="Update booking" href="<?php echo site_url('booking/editBooking/' . encryptor($value['vbk_id'])); ?>">
                                                            <i title="Update booking" class="fa fa-pencil"></i>
                                                       </a>
                                                  </td>
                                             <?php }?>
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

<script>
     $(document).ready(function () {
          $('#tblBooking').DataTable({
               "order": [[1, "asc"]],
               "scrollX": true,
               "pageLength" : 20
          });
     });
</script>

<style>
     div.dataTables_wrapper {
        width: 1109px;
        margin: 0 auto;
    }
    a {color: unset;}
</style>