<?php $purchasePrd = unserialize(PURCHASE_PERIOD); ?>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2> Procurement request list</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li style="float: right;">
                                   <?php if (check_permission('followup', 'precurementrqstlistexpexcel')) { ?>
                                        <a href="<?php echo site_url('followup/precurementrqstlistexpexcel?' . $_SERVER['QUERY_STRING']); ?>">
                                             <img  width="20" title="Download format" src="images/excel-export.png"/>
                                        </a>
                                   <?php } ?>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form method="get">
                              <table>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="enq_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                    placeholder="Date from" value="<?php echo isset($_GET['enq_date_from']) ? $_GET['enq_date_from'] : ''; ?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <input autocomplete="off" name="enq_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                    placeholder="Date to" value="<?php echo isset($_GET['enq_date_to']) ? $_GET['enq_date_to'] : ''; ?>"/>
                                        </td>
                                        <?php  if (check_permission('reports', 'fltr_enquiries_enq_salesstaff')) { ?>
                                             <td style="padding-left: 10px;">
                                                  <select  style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control cmbSalesExecutives" name="executive[]">
                                                       <option value="0">Select staff</option>
                                                       <?php
                                                       foreach ((array) $salesExecutives as $key => $value) {
                                                            if (!empty($showroom)) {
                                                                 if ($showroom == $value['usr_showroom']) {
                                                                      ?>
                                                                      <option value="<?php echo $value['col_id']; ?>"
                                                                              <?php echo (@in_array($value['col_id'], $executive)) ? 'selected="selected"' : ''; ?>>
                                                                           <?php echo $value['col_title']; ?></option> 
                                                                      <?php
                                                                 }
                                                            } else {
                                                                 ?>
                                                                 <option <?php echo (@in_array($value['col_id'], $executive)) ? 'selected="selected"' : ''; ?>
                                                                      value="<?php echo $value['col_id']; ?>"><?php echo $value['col_title']; ?></option> 
                                                                      <?php
                                                                 }
                                                            }
                                                            ?>
                                                  </select>
                                             </td>
                                             <td style="padding-left: 10px;">
                                                  <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                             </td>
                                        <?php } ?>
                                   </tr>
                              </table>
                         </form>
                    </div>
                    <div class="x_content">
                         <table class="datatableFollowup table table-striped table-bordered">
                              <thead>
                                   <?php $vehicleTypes = unserialize(ENQ_VEHICLE_TYPES); ?>
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