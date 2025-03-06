<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Booked vehicles - <?php echo $bookingDetails['vbk_ref_no']; ?></h2>
                         <!--<div style="float: right;">
                         <button data-toggle="modal" data-target="#myModal" 
                                 value="28" name="status" type="submit" class="btn btn-success">Followup</button>
                    </div>-->
                         <div class="clearfix"></div>
                    </div>

                    <!-- Followup model -->
                    <div class="modal fade bd-example-modal-lg" id="myModal" role="dialog">
                         <div class="modal-dialog modal-lg" style="width:90%;">
                              <div class="modal-content">
                                   <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4><span class="glyphicon glyphicon-clipboard"></span> Followup</h4>
                                   </div>
                                   <div class="modal-body">
                                        <div class="row">
                                             <div class="column">
                                                  <form role="form" method="post" class="frmBkingFollowup" action="<?php echo site_url('booking/submitBookingFollowup'); ?>">
                                                       <input type="hidden" name="vbf_book_master" value="<?php echo $bookingDetails['vbk_id']; ?>"/>
                                                       <div class="form-horizontal form-label-left">
                                                            <div class="form-group">
                                                                 <label for="enq_cus_country" class="control-label col-md-3 col-sm-3 col-xs-12">
                                                                      <span class="glyphicon glyphicon-calendar"></span> Next followup
                                                                 </label>
                                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                                      <input id="enq_cus_country" class="dtpDateTimePickerhms form-control col-md-7 col-xs-12" 
                                                                             type="text" name="vbf_followup_on">
                                                                 </div>
                                                            </div>

                                                            <div class="form-group">
                                                                 <label for="enq_cus_country" class="control-label col-md-3 col-sm-3 col-xs-12">
                                                                      <span class="glyphicon glyphicon-comment"></span> Comments
                                                                 </label>
                                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                                      <textarea id="enq_cus_country" class="form-control col-md-7 col-xs-12" 
                                                                                type="text" name="vbf_followup_comments"></textarea>
                                                                 </div>
                                                            </div>

                                                            <div class="ln_solid"></div>
                                                            <div class="form-group">
                                                                 <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                                      <button type="submit" class="btn btn-success">Submit</button>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </form>
                                             </div>
                                             <div class="column">
                                                  <div class="timeline-container">
                                                       <ul class="timeline">
                                                            <?php foreach ((array) $bookingFollowup as $bkey => $bvalue) { ?>
                                                                 <li>
                                                                      <div class="timeline-time">
                                                                           <span class="date"><?php echo date('d-m-Y', strtotime($bvalue['vbf_followup_on'])); ?></span>
                                                                           <span class="time"><?php echo date('h:i A', strtotime($bvalue['vbf_followup_on'])); ?></span>
                                                                      </div>
                                                                      <div class="timeline-icon">
                                                                           <a href="javascript:;">&nbsp;</a>
                                                                      </div>
                                                                      <div class="timeline-body">
                                                                           <div class="timeline-content">
                                                                                <p><?php echo $bvalue['vbf_followup_comments']; ?></p>
                                                                           </div>
                                                                      </div>
                                                                 </li>
                                                            <?php } ?>
                                                       </ul>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- Followup model -->

                    <div class="x_content">
                         <form method="post" action="<?php echo site_url('booking/decisionMaking'); ?>" 
                               class="form-horizontal form-label-left" enctype="multipart/form-data">

                              <table class="table table-bordered">
                                   <tbody>
                                        <tr>
                                             <th>Sales staff : <?php echo $bookingDetails['bkdby_first_name'] . ' ' . $bookingDetails['btdby_last_name']; ?></th>
                                             <td>
                                                  <a target="blank" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($bookingDetails['vbk_enq_id'])); ?>">
                                                       <span class="glyphicon glyphicon-print"></span> Track card
                                                  </a>
                                             </td>
                                             <td>
                                                  <a target="blank" href="<?php echo site_url('evaluation/printevaluation/' . encryptor($bookingDetails['vbk_evaluation_veh_id'])); ?>">
                                                       <i title="View valuation report" class="fa fa-copy"></i> Evaluation report
                                                  </a>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>
                              <table class="table table-bordered">
                                   <tbody>
                                        <tr>
                                             <th colspan="2" style="text-align: center;">Customer details</th>
                                        </tr>
                                        <tr>
                                             <td>Customer name : <?php echo $bookingDetails['vbk_cust_name']; ?></td>
                                             <td>Date : <?php echo $bookingDetails['vbk_added_on']; ?></td>
                                        </tr>
                                        <tr>
                                             <td colspan="">Permanent address : <?php echo $bookingDetails['vbk_per_address']; ?></td>
                                             <td>RC Transfer address : <?php echo $bookingDetails['vbk_rd_trans_address']; ?></td>
                                        </tr>
                                        <tr>
                                             <td>Phone number (Official) : <?php echo $bookingDetails['vbk_off_ph_no']; ?></td>
                                             <td>Phone number (Personal) : <?php echo $bookingDetails['vbk_per_ph_no']; ?></td>
                                        </tr>
                                        <tr>
                                             <td>Email ID : <?php echo $bookingDetails['vbk_email']; ?></td>
                                             <td>DOB : <?php echo!empty($bookingDetails['vbk_dob']) ? date('d-m-Y', strtotime($bookingDetails['vbk_dob'])) : ''; ?></td>
                                        </tr>
                                   </tbody>
                              </table>
                              <table class="table table-bordered">
                                   <tbody>
                                        <tr>
                                             <th colspan="2" style="text-align: center;">Vehicle details</th>
                                        </tr>
                                        <tr>
                                             <td>
                                                  <?php echo $bookingDetails['val_veh_no']; ?>
                                             </td>
                                             <td>
                                                  <?php echo $bookingDetails['brd_title'] . ', ' . $bookingDetails['mod_title'] . ', ' . $bookingDetails['var_variant_name']; ?>
                                                  Production Year : <?php echo $bookingDetails['val_minif_year']; ?>
                                             </td>
                                        </tr>
                                        <tr>
                                             <td>
                                                  Chassis Number : <?php echo $bookingDetails['val_chasis_no']; ?>                                                  
                                             </td>
                                             <td>
                                                  <div style="width: 45%;float: left;">
                                                       <div style="width: 30px;float: left;">KM : </div>
                                                       <div style="float: left;width: 104px;"><?php echo $bookingDetails['val_km']; ?></div>
                                                  </div>
                                                  <div style="width: 55%;float: left;">
                                                       <div style="width: 110px;float: left;">No of ownership : </div>
                                                       <div style="float: left;width: 60px;"><?php echo $bookingDetails['val_no_of_owner']; ?></div>
                                                  </div>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>
                              <?php if (!empty($bookingDetails['refurb'])) { ?>
                                   <table class="table table-bordered">
                                        <tr style="text-align:center;font-weight: bolder;">
                                             <td colspan="6">Refurbishment <?php echo get_in_currency_format(array_sum(array_column($bookingDetails['refurb'], 'vbr_refurb_amt')), 2); ?></td>
                                        </tr>
                                        <tr>
                                             <th>Refurbishment job</th>
                                             <th>Cost</th>
                                             <th>Authority</th>
                                             <th>Verified by</th>
                                             <th>Verified on</th>
                                             <th><?php echo (check_permission('booking', 'allowjobcomplete')) ? 'Job finished' : ''; ?></th>
                                        </tr>
                                        <?php foreach ((array) $bookingDetails['refurb'] as $key => $value) { ?>
                                             <tr class="trBokDocs">
                                                  <td>
                                                       <?php echo $value['vbr_refurb_desc']; ?>
                                                  </td>
                                                  <td>
                                                       <?php echo get_in_currency_format($value['vbr_refurb_amt'], 2); ?>
                                                  </td>
                                                  <td>
                                                       <?php echo ($value['vbr_don_by'] == 1) ? 'RD' : 'Customer'; ?>
                                                  </td>
                                                  <td>
                                                       <?php
                                                       echo ($value['vbr_verify_by'] > 0) ? $value['uvb_first_name'] . ' ' . $value['uvb_last_name'] :
                                                               '<span class="glyphicon glyphicon-remove red"></span>';
                                                       ?>
                                                  </td>
                                                  <td>
                                                       <?php
                                                       echo (!empty($value['vbr_verify_on'])) ? date('d-m-Y', $value['vbr_verify_on']) :
                                                               '<span class="glyphicon glyphicon-remove red"></span>';
                                                       ?>
                                                  </td>
                                                  <?php if (check_permission('booking', 'allowjobcomplete') && ($value['vbr_don_by'] == 0)) { ?>
                                                       <td><input value="<?php echo $value['vbr_id']; ?>" type="checkbox" 
                                                                  name="verifyRefurb[<?php echo $value['vbr_id']; ?>]"/></td>
                                                       <?php } else { ?>
                                                       <td><span class="glyphicon glyphicon-ok green"></span></td>
                                                  <?php } ?>
                                             </tr>
                                        <?php } ?>
                                   </table>
                              <?php } if (!empty($bookingDetails['valuationRefurbDetails'])) { ?>
                                   <table class="table table-bordered">
                                        <tr>
                                             <th colspan="8" style="text-align:center;font-weight: bolder;">
                                                  Valuation refurbishment details
                                                  <a target="_blank" href="<?php echo site_url('evaluation/printevaluation/' . encryptor($bookingDetails['vbk_evaluation_veh_id']) . '#refurbisheReq'); ?>" 
                                                     style="float:right;font-style: italic;font-size: 12px;">Refurbishment</a>
                                             </th>
                                        </tr>
                                        <tr>
                                             <th>SL NO</th>
                                             <th>Refurbish job in evaluation</th>
                                             <th>Estimated cost</th>
                                             <th>Actual job description</th>
                                             <th>Actual cost</th>
                                             <th>Description</th>
                                             <th>Job finished</th>
                                             <th>Reason for pending refurb</th>
                                        </tr>
                                        <tbody>
                                             <?php foreach ($bookingDetails['valuationRefurbDetails'] as $key => $value) { ?>
                                                  <tr>
                                                       <td><?php echo $key + 1; ?></td>
                                                       <td><?php echo $value['upgrd_key']; ?></td>
                                                       <td><?php echo get_in_currency_format($value['upgrd_value']); ?></td>
                                                       <td><?php echo $value['actual_job_description'] ?></td>
                                                       <td><?php echo get_in_currency_format($value['upgrd_refurb_actual_cost']); ?></td>
                                                       <td><?php echo $value['upgrd_refurb_remarks'] ?></td>
                                                       <td>
                                                            <?php if ($value['upgrd_is_done'] == 1) { ?>
                                                                 <span class="glyphicon glyphicon-ok green"></span>
                                                            <?php } else { ?>
                                                                 <span class="glyphicon glyphicon-remove red"></span>
                                                            <?php } ?>
                                                       </td>
                                                       <td>
                                                            <input value="<?php echo $value['upgrd_id']; ?>" type="hidden"  
                                                                   name="evalUpgrade[<?php echo $value['upgrd_id']; ?>][evalUpgdId]"/>
                                                                   <?php
                                                                   if (!empty($value['upgrd_resn_pend_refurb'])) {
                                                                        echo $value['upgrd_resn_pend_refurb'];
                                                                   } else {
                                                                        ?>
                                                                 <input type="text" name="evalUpgrade[<?php echo $value['upgrd_id']; ?>][evalUpgdDesc]" 
                                                                        placeholder="Reason for pending refurb"/>
                                                                   <?php } ?>
                                                       </td>

                                                  </tr>
                                                  <?php
                                             }
                                             ?>
                                        </tbody>
                                   </table>
                              <?php } ?>
                              <table class="table table-bordered">
                                   <tr style="text-align:center;font-weight: bolder;">
                                        <td colspan="6">Accessories <?php echo get_in_currency_format(array_sum(array_column($bookingDetails['access'], 'vba_accessories_amt')), 2); ?></td>
                                   </tr>
                                   <tr>
                                        <th>Accessories</th>
                                        <th>Cost</th>
                                        <th>Authority</th>
                                        <th>Verified by</th>
                                        <th>Verified on</th>
                                        <th><?php echo (check_permission('booking', 'allowjobcomplete')) ? 'Job finished' : ''; ?></th>
                                   </tr>
                                   <?php foreach ((array) $bookingDetails['access'] as $key => $value) { ?>
                                        <tr class="trBokDocs">
                                             <td>
                                                  <?php echo $value['vba_accessories_desc']; ?>
                                             </td>
                                             <td>
                                                  <?php echo get_in_currency_format($value['vba_accessories_amt'], 2); ?>
                                             </td>
                                             <td>
                                                  <?php echo ($value['vba_don_by'] == 1) ? 'RD' : 'Customer'; ?>
                                             </td>
                                             <td>
                                                  <?php
                                                  echo ($value['vba_verify_by'] > 0) ? $value['uvb_first_name'] . ' ' . $value['uvb_last_name'] :
                                                          '<span class="glyphicon glyphicon-remove red"></span>';
                                                  ?>
                                             </td>
                                             <td>
                                                  <?php
                                                  echo (!empty($value['vba_verify_on'])) ? date('d-m-Y', $value['vba_verify_on']) :
                                                          '<span class="glyphicon glyphicon-remove red"></span>';
                                                  ?>
                                             </td>
                                             <?php if (empty($value['vba_completed_by'])) { ?>
                                                  <td>
                                                       <input value="<?php echo $value['vba_id']; ?>" type="checkbox" 
                                                              name="verifyAccess[<?php echo $value['vba_id']; ?>]"/>
                                                  </td>
                                             <?php } else { ?>
                                                  <td><span class="glyphicon glyphicon-ok green"></span></td>
                                             <?php } ?>
                                        </tr>
                                   <?php } ?>
                              </table>

                              <!-- Hidden fields -->
                              <input type="hidden" name="confim[vbc_book_master]" value="<?php echo $bookingDetails['vbk_id']; ?>"/>
                              <input type="hidden" name="confim[vbc_verify_by]" value="<?php echo $this->uid; ?>"/>
                              <input type="hidden" name="confim[vbc_verify_by_grp_slug]" value="<?php echo $this->usr_grp; ?>"/>
                              <input type="hidden" name="confim[vbc_verify_by_grp_id]" value="<?php echo $this->grp_id; ?>"/>
                              <input type="hidden" name="confim[vbc_verify_by_showrm]" value="<?php echo $this->shrm; ?>"/>
                              <input type="hidden" name="confim[vbc_enq_id]" value="<?php echo $bookingDetails['vbk_enq_id']; ?>"/>
                              <!-- Hidden fields -->

                              <div class="form-group">
                                   <div class="col-md-12 col-sm-6 col-xs-12">
                                        <textarea required type="text" class="form-control col-md-7 col-xs-12" 
                                                  name="confim[vbc_verify_desc]" placeholder="Current status"></textarea>
                                   </div>
                              </div>

                              <div class="ln_solid"></div>
                              <button type="submit" class="btn btn-success">Submit</button>
                              <button data-toggle="modal" data-target="#exampleModal" style="float: right;"
                                      name="status" type="button" class="btn btn-success">Ready to delivery</button>
                         </form>
                         <?php echo $history; ?>
                    </div>
               </div>
          </div>
     </div>
</div>

<form method="post" action="<?php echo site_url('booking/decisionMaking'); ?>" 
      class="form-horizontal form-label-left" enctype="multipart/form-data">
     <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true"
          aria-labelledby="exampleModalLabel">

          <!-- Hidden fields -->
          <input type="hidden" name="confim[vbc_book_master]" value="<?php echo $bookingDetails['vbk_id']; ?>"/>
          <input type="hidden" name="confim[vbc_verify_by]" value="<?php echo $this->uid; ?>"/>
          <input type="hidden" name="confim[vbc_verify_by_grp_slug]" value="<?php echo $this->usr_grp; ?>"/>
          <input type="hidden" name="confim[vbc_verify_by_grp_id]" value="<?php echo $this->grp_id; ?>"/>
          <input type="hidden" name="confim[vbc_verify_by_showrm]" value="<?php echo $this->shrm; ?>"/>
          <input type="hidden" name="confim[vbc_enq_id]" value="<?php echo $bookingDetails['vbk_enq_id']; ?>"/>
          <input type="hidden" name="status" value="<?php echo dc_ready_to_del; ?>"/>
          <!-- Hidden fields -->

          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 style="float: left;" class="modal-title" id="exampleModalLabel">Refurbishment completed & expect delivery</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                         </button>
                    </div>
                    <div class="modal-body">
                         <div class="form-group">
                              <label class="control-label col-md-4 col-sm-3 col-xs-12">Expect delivery date</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input required type="text" class="dtpExpDelTime form-control col-md-7 col-xs-12" 
                                          name="vbk_dc_exp_del_date" id="div_name" placeholder="Expect delivery date"/>
                              </div>
                         </div>
                         <div class="form-group">
                              <label class="control-label col-md-4 col-sm-3 col-xs-12">Description</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <textarea required type="text" class="form-control col-md-7 col-xs-12" 
                                             name="exp_del_desc" id="div_name" placeholder="Description"></textarea>
                              </div>
                         </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button type="submit" class="btn btn-primary">Ready to delivery</button>
                    </div>
               </div>
          </div>
     </div>
</form>