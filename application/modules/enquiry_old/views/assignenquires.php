<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires Bulk Assigning</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="<?php echo site_url($controller . '/assignenquires');?>" method="get">
                              <table>
                                   <?php if (is_roo_user()) {?>
                                          <td>
                                               <select style="float: left;width: auto;" class="select2_group form-control bindSalesExecutives" 
                                                       data-url="<?php echo site_url('emp_details/salesExecutivesByShowroom');?>"
                                                       data-bind="cmbSalesExecutives" name="showroom" data-dflt-select="All Sales executives"
                                                       data-bind1="cmbAssignSalesExecutives" data-dflt-select1="Assign To">
                                                    <option value="0">All Showroom</option>
                                                    <?php foreach ($allShowrooms as $key => $value) {?>
                                                         <option <?php echo ($showroom == $value['shr_id']) ? 'selected="selected"' : '';?>
                                                              value="<?php echo $value['shr_id']?>"><?php echo $value['shr_location']?></option>
                                                         <?php }?>
                                               </select>
                                          </td>

                                          <td style="padding-left: 10px;">
                                               <select multiple="multiple" style="float: left;width: auto;" name="executive[]"
                                                       class="muliSelectCombo select2_group form-control cmbSalesExecutives">
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
                                     <?php }?>
                                   <td style="padding-left: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                   </td>
                              </table>
                         </form>
                         <select style="float: left;width: auto;" class="muliSelectCombo select2_group form-control cmbAssignSalesExecutives" name="executive[]">
                              <option value="">Assign to</option>
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
                         <button data-url="<?php echo site_url($controller . '/assignenquires'); ?>" type="button" 
                                 class="btn btn-round btn-primary btnAssignSalesExecutives">Move to</button>
                    </div>
                    <div class="x_content">
                         <table class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th><input type="checkbox" class="chkCheckAllChildrens" data-child=".assignEnqIds"/></th>
                                        <th>Customer ID</th>
                                        <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<th>Sales Executive</th>' : '';?>
                                        <th>Added By</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Whatsapp</th>
                                        <th>Enquiry Date</th>
                                        <th>Action</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($enquires)) {
                                          foreach ($enquires as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url('enquiry/view/' . encryptor($value['enq_id']));?>">
                                                    <td><input class="assignEnqIds" type="checkbox" name="enqid[]" value="<?php echo $value['enq_id'];?>"/></td>
                                                    <td class="trVOE"><?php echo generate_vehicle_virtual_id($value['enq_id']);?></td>
                                                    <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<td class="trVOE">' . strtoupper($value['usr_first_name']) . '</td>' : '';?>
                                                    <td class="trVOE"><?php echo ($value['usr_id'] == $value['enq_added_by']) ? 'Self' : $value['enq_added_by_name'];?></td>
                                                    <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']);?></td>
                                                    <td> <a target="blank" <?php echo 'href="tel:' . $value['enq_cus_mobile'] . '"';?> > <?php echo $value['enq_cus_mobile'];?> </a></td>
                                                    <td> <a target="blank" <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['enq_cus_whatsapp'] . '"';?> > <?php echo $value['enq_cus_whatsapp'];?> </a></td>
                                                    <td class="trVOE"><?php echo date('j M Y', strtotime($value['enq_entry_date']));?></td>
                                                    <td><a title="Print track card" href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($value['enq_id']));?>"><span class="glyphicon glyphicon-print"></span></a></td>
                                               </tr>
                                               <?php
                                          }
                                     }
                                   ?>
                              </tbody>
                         </table>
                         <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo ceil($pageIndex);?> to <?php echo $limit;?> of <?php echo $totalRow;?> entries</div>
                         <div style="float: right;">
                              <?php echo $links;?>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
