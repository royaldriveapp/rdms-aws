<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>My self register</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div style="width: 100%;overflow-x: scroll;">
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
                                             <th>Assigned to</th>
                                             <th>Added by</th>
                                             <th>Comment</th>
                                             <th>Sales officers comment</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                          $colspan = 16;
                                          if (!empty($datas)) {
                                               foreach ((array) $datas as $key => $value) {
                                                    $url = '';
                                                    if ($value['vreg_is_verified']) {
                                                         $url = !empty($value['vreg_inquiry']) ?
                                                                 site_url('followup/viewFollowup/' . encryptor($value['vreg_inquiry'])) : site_url($controller . '/regiter_2_inquiry/' . encryptor($value['vreg_id']));
                                                    }
                                                    $color = 'color: #fff';
                                                    $bgColor = '';
                                                    $canPunch = 1;
                                                    if (empty($value['vreg_inquiry'])) {
                                                         $bgColor = 'red';
                                                    } else if ($value['vreg_is_verified'] != 1) {
                                                         $bgColor = '#4c3000';
                                                         $canPunch = 0;
                                                    } else {
                                                         $bgColor = '#004099';
                                                    }
                                                    ?>
                                                    <tr style="<?php echo $color;?>;background-color: <?php echo $bgColor;?>">
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
                                                         <td><?php echo $value['assign_usr_first_name'];?></td>
                                                         <td><?php echo $value['addedby_usr_first_name'];?></td>
                                                         <td><?php echo $value['vreg_last_action'];?></td>
                                                         <td>
                                                              <span data-toggle="modal" data-target="#<?php echo $value['vreg_id'];?>">
                                                                   <?php echo $value['vreg_customer_remark'];?>
                                                              </span>
                                                              <?php if (check_permission('registration', 'allowquickdropregister')) {?>
                                                                   <div class="modal fade" id="<?php echo $value['vreg_id'];?>" tabindex="-1" role="dialog" 
                                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                             <div class="modal-content" style="color: black;">
                                                                                  <div class="modal-header">
                                                                                       <h5 style="width: 90%;float: left;" class="modal-title" id="exampleModalLabel">Quick drop or punch register</h5>
                                                                                       <button style="float:right;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                       </button>
                                                                                  </div>
                                                                                  <div class="modal-body">
                                                                                       <div class="row">
                                                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                                 <div class="x_panel">
                                                                                                      <div class="x_content">
                                                                                                           <div class="form-group" style="width: 100%;float: left;">
                                                                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer name</label>
                                                                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                     <?php echo $value['vreg_cust_name'];?>
                                                                                                                </div>
                                                                                                           </div>

                                                                                                           <div class="form-group" style="width: 100%;float: left;">
                                                                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer contact</label>
                                                                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                     <?php echo $value['vreg_cust_phone'];?>
                                                                                                                </div>
                                                                                                           </div>

                                                                                                           <div class="form-group" style="width: 100%;float: left;">
                                                                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                                                                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                     <?php echo $value['vreg_cust_place'];?>
                                                                                                                </div>
                                                                                                           </div>

                                                                                                           <div class="form-group" style="width: 100%;float: left;">
                                                                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer feedback</label>
                                                                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                     <?php echo $value['vreg_customer_remark'];?>
                                                                                                                </div>
                                                                                                           </div>

                                                                                                           <div class="form-group" style="width: 100%;float: left;">
                                                                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Assigned by</label>
                                                                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                     <?php echo $value['addedby_usr_first_name'] . ' ' . $value['addedby_usr_last_name'];?>
                                                                                                                </div>
                                                                                                           </div>

                                                                                                           <div class="form-group" style="width: 100%;float: left;">
                                                                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Comment</label>
                                                                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                     <?php echo $value['vreg_last_action'];?>
                                                                                                                </div>
                                                                                                           </div>
                                                                                                      </div>
                                                                                                 </div>
                                                                                            </div>
                                                                                       </div>
                                                                                       <div class="row" style="text-align: center;">
                                                                                            <div>
                                                                                                 <a class="btn btn-primary" href="<?php echo $url;?>">Punch to enquiry</a><br>
                                                                                            </div>
                                                                                       </div>
                                                                                       <div class="row" style="text-align: center;font-weight: bolder;font-size: 25px;">OR</div>
                                                                                       <div method="post" class="row frmRequestForDrop" data-url="<?php echo site_url('registration/changeRegisterStatus');?>">
                                                                                            <input type="hidden" name="regMaster" class="txtRegMaster" value="<?php echo $value['vreg_id'];?>"/>
                                                                                            <input type="hidden" name="status" class="txtStatus" value="<?php echo reg_req_drop;?>"/>

                                                                                            <!-- -->
                                                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                                 <div class="x_panel">
                                                                                                      <div class="form-group">
                                                                                                           <label class="control-label col-md-3 col-sm-3 col-xs-12">Reason for drop <span class="required">*</span>
                                                                                                           </label>
                                                                                                           <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                <textarea required name="reason" class="txtReason form-control col-md-5 col-xs-12 "></textarea>
                                                                                                           </div>
                                                                                                      </div>
                                                                                                 </div>
                                                                                            </div>
                                                                                            <div class="modal-footer" style="float: left;">
                                                                                                 <input type="button" class="btn btn-primary btnRequestForDrop" value="Request for drop"/>
                                                                                            </div>
                                                                                       </div>
                                                                                  </div>
                                                                             </div>
                                                                        </div>
                                                                   </div>
                                                              <?php } else {?>
                                                                   <span data-toggle="modal" data-target="#<?php echo $value['vreg_id'];?>" 
                                                                         style="color: #fff;width: 100%;float: left;">
                                                                        <span>Customer : <?php echo $value['vreg_cust_name'] . ', ' . $value['vreg_cust_phone'];?></span>
                                                                        <span>Assigned by : <?php echo $value['addedby_usr_first_name'];?></span>
                                                                   </span>
                                                                   <?php
                                                              }
                                                              ?>
                                                         </td>
                                                    </tr>
                                                    <?php
                                               }
                                          } else {
                                               ?> 
                                               <tr>
                                                    <td style="text-align: center;" colspan="<?php echo $colspan;?>">No data available in table</td>
                                               </tr>
                                          <?php }?>
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