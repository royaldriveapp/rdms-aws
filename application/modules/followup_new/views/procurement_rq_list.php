<?php $purchasePrd = unserialize(PURCHASE_PERIOD); ?>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2> Procurement request list</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table class="datatableFollowup table table-striped table-bordered">
                              <thead>
                                   <?php
                                   $vehicleTypes = unserialize(ENQ_VEHICLE_TYPES);
                                   ?>
                                   <tr>
                                        <th>Vehicle</th>
                                        <?php if (check_permission($controller, 'showsalesstaffinfo')) { ?>
                                             <th>Sales staff</th>
                                             <th>Added by</th>
                                        <?php } if (check_permission($controller, 'showcustomerinfo')) { ?>
                                             <th>Customer</th>
                                             <th>Cust number</th>
                                        <?php } ?>
                                        <th>Purchase period</th>
                                        <th>Added on</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   foreach ((array) $precurement_rqst as $key => $value) {
                                        $salesStaff = $this->followup->getSalesStaff($value['enq_se_id']);
                                        $now = date('Y-m-d');
                                        $vehData = $this->common_model->getVehicleName($value['proc_brand'], $value['proc_model'], $value['proc_variant']);
                                        ?>
                                        <tr title="<?php echo empty($value['proc_id']) ? 'Pending to set followup date' : ''; ?>"
                                            data-url="<?php echo site_url('followup/precurementRqstDetails/' . encryptor($value['proc_id'])); ?>">
                                             <td class="trVOE"><?php echo $vehData; ?></td>
                                             <?php if (check_permission($controller, 'showsalesstaffinfo')) { ?>
                                                  <td class="trVOE"><?php echo $salesStaff; ?></td>
                                                  <td class="trVOE"><?php echo ($value['proc_addded_by'] == $this->uid) ? 'Self' : $value['enq_added_by_name']; ?></td>
                                             <?php } if (check_permission($controller, 'showcustomerinfo')) { ?>
                                                  <td class="trVOE"><?php echo $value['enq_cus_name']; ?></td>
                                                  <td class="trVOE"><?php echo $value['enq_cus_mobile']; ?></td>
                                             <?php } ?>
                                             <td class="trVOE"><?php echo $purchasePrd[$value['proc_purchase_period']]; ?></td>
                                             <td class="trVOE"><?php echo date('j M Y', strtotime($value['proc_added_on'])); ?></td>
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