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
                                        <th>Booking ID</th>
                                        <th>Registration</th>
                                        <th>Customer Name</th>
                                        <th>Booked by</th>
                                        <th>Phone number (Official)</th>
                                        <th>Phone number (Personal)</th>
                                        <th>Permanent address</th>
                                        <th>RC Transfer address</th>
                                        <th>Booked on</th>
                                        <!-- <th>Expect delivery on</th>
                                        <th>Current status</th>
                                        <th>Insurance status</th>
                                        <th>RC Transfer status</th> -->
                                        <?php /*if (check_permission('booking', 'showdocumentpending')) { ?><th>Pending docs
                                </th><?php }*/ ?>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   foreach ((array) $bookingCancelled as $key => $value) {
                                        $pendnigDocs = $this->booking->pendingDocs($value['vbk_id']);
                                        $pendnigDocs = !empty($pendnigDocs) ? array_column($pendnigDocs, 'adp_proof_title') : array();
                                        $trColor = '';
                                        if ($value['vbk_status'] == vehicle_booked) {
                                             $trColor = '';
                                        } else if ($value['vbk_status'] == reject_book) {
                                             $trColor = 'background-color: red;color: white;';
                                        } else if (in_array($value['vbk_status'], array(confm_book, dc_ready_to_del))) {
                                             $trColor = 'background-color: green;color: white;';
                                        }
                                        $url = site_url('booking/bookingDetails/' . encryptor($value['vbk_id']));

                                        if (check_permission('booking', 'bookingdetailsforrfi')) {
                                             $url = site_url('booking/bookingDetails_rfi/' . encryptor($value['vbk_id']));
                                        } else if (check_permission('booking', 'bookingdetailsfordc')) {
                                             $url = site_url('booking/bookingDetails_dc/' . encryptor($value['vbk_id']));
                                        }
                                   ?>
                                        <tr data-url="<?php //echo $url; 
                                                       ?>">
                                             <td style="<?php echo $trColor; ?>" class="trVOE"><?php echo $value['vbk_ref_no']; ?>
                                             </td>
                                             <td style="<?php echo $trColor; ?>"><?php echo $value['val_veh_no']; ?>
                                                  <a
                                                       href="<?php echo site_url('evaluation/printevaluation/' . encryptor($value['vbk_evaluation_veh_id'])); ?>">
                                                       <i title="View valuation report" class="fa fa-copy"></i>
                                                  </a>
                                             </td>
                                             <td style="<?php echo $trColor; ?>" class="trVOE">
                                                  <?php echo strtoupper($value['enq_cus_name']); ?></td>
                                             <td style="<?php echo $trColor; ?>" class="trVOE">
                                                  <?php echo $value['bkdby_first_name'] . ' ' . $value['btdby_last_name']; ?></td>
                                             <td style="<?php echo $trColor; ?>"><a
                                                       href="tel:<?php echo $value['vbk_off_ph_no']; ?>"><?php echo $value['vbk_off_ph_no']; ?></a>
                                             </td>
                                             <td style="<?php echo $trColor; ?>"><a
                                                       href="tel:<?php echo $value['vbk_per_ph_no']; ?>"><?php echo $value['vbk_per_ph_no']; ?></a>
                                             </td>
                                             <td style="<?php echo $trColor; ?>" class="trVOE">
                                                  <?php echo $value['vbk_per_address']; ?></td>
                                             <td style="<?php echo $trColor; ?>" class="trVOE">
                                                  <?php echo $value['vbk_rd_trans_address']; ?></td>
                                             <td style="<?php echo $trColor; ?>" class="trVOE">
                                                  <?php echo date('j M Y', strtotime($value['vbk_added_on'])); ?></td>
                                        </tr>
                                   <?php } ?>
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