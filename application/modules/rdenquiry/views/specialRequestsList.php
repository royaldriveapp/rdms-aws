<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2><?php echo $title; ?></h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="<?php echo site_url('enquiry/changeStatusRequest/' . $status); ?>" method="get">
                              <table>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="enq_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                    placeholder="Date from" value="<?php echo isset($enq_date_from) ? $enq_date_from : ''; ?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <input autocomplete="off" name="enq_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" 
                                                    placeholder="Date to" value="<?php echo isset($enq_date_to) ? $enq_date_to : ''; ?>"/>
                                        </td>
                                        <?php if (check_permission('reports', 'fltr_enquiries_enq_showroom')) { ?>
                                             <td style="padding-left: 10px;">
                                                  <select style="float: left;width: auto;" class="select2_group form-control bindSalesExecutives" 
                                                          data-url="<?php echo site_url('emp_details/salesExecutivesByShowroom'); ?>"
                                                          data-bind="cmbSalesExecutives" name="showroom" data-dflt-select="All Sales executives">
                                                       <option value="0">All Showroom</option>
                                                       <?php foreach ($allShowrooms as $key => $value) { ?>
                                                            <option <?php echo ($showroom == $value['shr_id']) ? 'selected="selected"' : ''; ?>
                                                                 value="<?php echo $value['shr_id'] ?>"><?php echo $value['shr_location'] ?></option>
                                                            <?php } ?>
                                                  </select>
                                             </td>
                                        <?php } if (check_permission('reports', 'fltr_enquiries_enq_salesstaff')) { ?>
                                             <td style="padding-left: 10px;">
                                                  <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control cmbSalesExecutives" name="executive[]">
                                                       <option value="<?php echo $this->uid; ?>">My self</option>
                                                       <?php
                                                       foreach ((array) $salesExecutives as $key => $value) {
                                                            if (!empty($showroom)) {
                                                                 if ($showroom == $value['usr_showroom']) {
                                                                      ?>
                                                                      <option value="<?php echo $value['usr_id']; ?>"
                                                                              <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?>>
                                                                           <?php echo $value['usr_first_name']; ?></option> 
                                                                      <?php
                                                                 }
                                                            } else {
                                                                 ?>
                                                                 <option <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?>
                                                                      value="<?php echo $value['usr_id']; ?>"><?php echo $value['usr_first_name']; ?></option> 
                                                                      <?php
                                                                 }
                                                            }
                                                            ?>
                                                  </select>
                                             </td>
                                        <?php } ?>
                                        <td style="padding-left: 10px;">
                                             <select style="float: left;width: auto;" class="select2_group form-control" name="status">
                                                  <option value="0">All Types</option>
                                                  <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $sts => $stsName) { ?>
                                                       <option <?php echo ((int) $sts == (int) $enqStatus) ? 'selected="selected"' : ''; ?>
                                                            value="<?php echo $sts; ?>"><?php echo $stsName ?></option>
                                                       <?php } ?>
                                             </select>
                                        </td>

                                        <td style="padding-left: 10px;">
                                             <select multiple="multiple" style="float: left;width: auto;" class="select2_group form-control cmbMultiSelect" name="mode">
                                                  <option value="0">All Mode of enquiry</option>
                                                  <?php foreach (unserialize(MODE_OF_CONTACT) as $sts => $stsName) { ?> 
                                                       <option <?php echo ((int) $sts == (int) $mode) ? 'selected="selected"' : ''; ?>
                                                            value="<?php echo $sts; ?>"><?php echo $stsName ?></option>
                                                       <?php } ?>
                                             </select>
                                        </td>

                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   </tr>
                              </table>
                         </form>
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Customer</th>
                                        <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG' ||  $this->usr_grp == 'TL') ? '<th>Sales Staff</th>' : '';?>
                                        <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<th>Showroom</th>' : '';?>
                                        <th>Mobile</th>
                                        <th>WhatsApp</th>
                                        <th>Request Date</th>
                                        <th>Drop remark</th>
                                        <th>Sales Staff</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($enquires)) {
                                          foreach ($enquires as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url('enquiry/viewVehicleStatus/' . encryptor($value['enq_id']) . '/' . $status);?>">
                                                    <td class="trVOE"><?php echo $value['enq_cus_name'];?></td>
                                                    <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG' ||  $this->usr_grp == 'TL') ? '<td class="trVOE">' . strtoupper($value['usr_first_name']) . '</td>' : '';?>
                                                    <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<td class="trVOE">' . $value['shr_location'] . '</td>' : '';?>
                                                    <td class="trVOE"><?php echo $value['enq_cus_mobile']; ?></td>
                                                    <td class="trVOE"><?php echo $value['enq_cus_whatsapp']; ?></td>
                                                    <td class="trVOE"><?php echo!empty($value['enh_added_on']) ? date('j M Y', strtotime($value['enh_added_on'])) : ''; ?></td>
                                                    <td class="trVOE"><?php echo $value['enh_remarks']; ?></td>
                                                    <td class="trVOE"><?php echo $value['usr_first_name']; ?></td>
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
