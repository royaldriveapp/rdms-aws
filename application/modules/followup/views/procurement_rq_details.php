<div class="right_col" role="main">
     <?php
     $vehData = $this->common_model->getVehicleName($precurementRqst['proc_brand'], $precurementRqst['proc_model'], $precurementRqst['proc_variant']);
     $purchasePrd = unserialize(PURCHASE_PERIOD);
     $salesStaff = $this->followup->getSalesStaff($precurementRqst['enq_se_id']);
     ?>
     <div class="clearfix"></div>
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Procurement request for <?php echo $vehData; ?></h2>
                         <div class="clearfix"></div>
                    </div>
                    <?php
                    $colmd = empty($prcStatus) ? 'col-md-6' : 'col-md-5';
                    if (!empty($prcStatus)) {
                         ?>
                         <div class="col-md-7 col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                   <div class="panel-heading">Comments</div>
                                   <div class="panel-body">
                                        <ul class="list-unstyled timeline" style="overflow-x: scroll; max-height: 455px;">
                                             <?php
                                             foreach ($prcStatus as $key => $value) {
                                                  ?>
                                                  <li>
                                                       <div class="block">
                                                            <div class="tags">
                                                                 <a href="javascript:;" class="tag">
                                                                      <span><?php echo date('j M Y', strtotime($value['proc_sts_added_on'])); ?></span>
                                                                 </a>
                                                            </div>
                                                            <div class="block_content">
                                                                 <p class="excerpt" style="font-weight: bolder;font-size: 15px;">
                                                                      <span><i class="fa fa-clock-o"></i> <?php echo $value['enq_added_by_name']; ?></span>
                                                                 </p>
                                                            </div>
                                                            <div style="font-style: italic;background: #E7E7E7;padding: 10px;">
                                                                 <P><?php echo $value['sts_title']; ?></p>
                                                                 <p class="excerpt"><?php echo $value['proc_sts_description']; ?></p>
                                                            </div>
                                                       </div>
                                                  </li>
                                                  <?php
                                             }
                                             ?>
                                        </ul>
                                   </div>
                              </div>
                         </div>
                    <?php } ?>
                    <div class="row">
                         <div class="<?php echo $colmd; ?> col-sm-12 col-xs-12">
                              <div class="panel panel-default">
                                   <div class="panel-heading">Required vehicle details</div>
                                   <div class="panel-body">
                                        <table class="datatableFollowup table table-striped table-bordered">
                                             <tr>
                                                  <th>Vehicle</th>
                                                  <td><?php echo $vehData; ?></td>
                                             </tr>
                                             <tr>
                                                  <th>Purchase period</th>
                                                  <td><?php echo $purchasePrd[$precurementRqst['proc_purchase_period']]; ?></td>
                                             </tr>
                                             <?php if (check_permission($controller, 'showsalesstaffinfo')) { ?>
                                                  <tr>
                                                       <th>Sales staff</th>
                                                       <td><?php echo $salesStaff; ?>
                                                  </tr>
                                                  <tr>
                                                       <th>Added by</th>
                                                       <td><?php echo ($precurementRqst['proc_addded_by'] == $this->uid) ? 'Self' : $precurementRqst['enq_added_by_name']; ?></td>
                                                  </tr>
                                             <?php } if (check_permission($controller, 'showcustomerinfo')) { ?>

                                                  <tr>
                                                       <th>Customer</th>
                                                       <td><?php echo $precurementRqst['enq_cus_name']; ?>
                                                  </tr>
                                                  <tr>
                                                       <th>Customer number</th>
                                                       <td><?php echo $precurementRqst['enq_cus_mobile']; ?></td>
                                                  </tr>
                                             <?php } ?>
                                             <tr>
                                                  <th>Added on</th>
                                                  <td><?php echo date('j M Y', strtotime($precurementRqst['proc_added_on'])); ?></td>
                                             </tr>
                                        </table>
                                   </div>
                              </div>
                         </div>

                         <?php if (check_permission($controller, 'procchangestatus')) { ?>
                              <div class="<?php echo $colmd; ?> col-sm-12 col-xs-12" style="float:right;">
                                   <div class="panel panel-default">
                                        <div class="panel-heading">Change enquiry status</div>
                                        <div class="panel-body">
                                             <form id="demo-form2" method="post" action="<?php echo site_url('followup/procChangeStatus'); ?>" 
                                                   data-parsley-validate class="form-horizontal form-label-left frmVehicleStatus submitProcStatus">
                                                  <input type="hidden" class="txtEnqId" name="proc_id" value="<?php echo isset($precurementRqst['proc_id']) ? $precurementRqst['proc_id'] : 0; ?>"/>
                                                  <input type="hidden" name="proc_enq_id" value="<?php echo isset($precurementRqst['proc_enq_id']) ? $precurementRqst['proc_enq_id'] : 0; ?>"/>

                                                  <div class="form-group">
                                                       <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <select class="select2_group form-control cmbFollStatus" name="proc_status">
                                                                 <option value="">Select status</option>
                                                                 <?php foreach ((array) $statuses as $key => $value) { ?>
                                                                      <option data-slug="<?php echo $value['sts_slug']; ?>" value="<?php echo $value['sts_value']; ?>"><?php echo $value['sts_title']; ?></option>
                                                                 <?php } ?>
                                                            </select>
                                                       </div>
                                                  </div>

                                                  <div class="divBookingDetails"></div>

                                                  <div class="form-group">
                                                       <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <textarea placeholder="Remarks" required="required" name="proc_remarks" class="form-control col-md-7 col-xs-12 text-left vst_remarks"></textarea>
                                                       </div>
                                                  </div>

                                                  <div class="ln_solid"></div>
                                                  <div class="form-group">
                                                       <div class="col-md-7 col-sm-6 col-xs-12 col-md-offset-3">
                                                            <button class="btn btn-primary" type="reset">Reset</button>
                                                            <button type="submit" class="btn btn-success">Submit</button>
                                                       </div>
                                                  </div>
                                             </form>
                                             <span class="msg"></span>
                                        </div>
                                   </div>
                              </div>
                         <?php } ?>
                    </div>

               </div>
          </div>
     </div>
</div>