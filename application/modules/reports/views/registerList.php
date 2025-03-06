<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Vehicle register</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li style="float: right;">
                                   <!-- <a href="<?php //echo site_url('registration/export_excel?' . $_SERVER['QUERY_STRING']);
                                                  ?>">
                                        <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                   </a>-->
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
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
                                             <th>Assigned to</th>
                                             <th>Added by</th>
                                             <th>First added by / CRE</th>
                                             <th>Call type</th>
                                             <th>Description</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                        $trVOE = (check_permission('registration', 'update')) ? 'trVOE' : '';
                                        foreach ((array) $datas as $key => $value) {
                                        ?>
                                             <tr>
                                                  <td>
                                                       <?php if ($value['vreg_is_effective'] == 1) { ?><i title="Effective call" style="color: green;" class="fa fa-check"></i> <?php } ?>
                                                       <?php echo date('j M Y', strtotime($value['vreg_entry_date'])); ?>
                                                  </td>
                                                  <td><?php echo $value['vreg_cust_name']; ?></td>
                                                  <td>
                                                       <a <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['vreg_cust_phone'] . '"'; ?>><?php echo $value['vreg_cust_phone']; ?></a>
                                                  </td>
                                                  <td><?php echo $value['vreg_cust_place']; ?></td>
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
                                                  <td><?php echo $value['assign_usr_first_name'] . ' ' . $value['assign_usr_last_name']; ?></td>
                                                  <td>
                                                       <?php echo $value['addedby_usr_first_name'] . ' ' . $value['addedby_usr_last_name']; ?>
                                                       <?php if (!empty($value['vreg_last_action'])) { ?>
                                                            <i class="fa fa-comment-o" title="<?php echo $value['vreg_last_action']; ?>"></i>
                                                       <?php } ?>
                                                  </td>
                                                  <td><?php echo $value['ownedby_usr_first_name'] . ' ' . $value['ownedby_usr_first_name']; ?></td>
                                                  <td>
                                                       <?php
                                                       $callTypes = unserialize(CALL_TYPE);
                                                       echo isset($callTypes[$value['vreg_call_type']]) ? $callTypes[$value['vreg_call_type']] : '';
                                                       ?>
                                                  </td>
                                                  <td><?php echo $value['vreg_customer_remark']; ?></td>
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

          <?php if (check_permission('registration', 'allowquickaressignregister') && $yday != 1) { ?>
               <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel tile fixed_height_320" style="overflow: scroll;">
                         <div class="x_title">
                              <h2>Re Assign to other staffs</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="dashboard-widget-content">
                              <div class="x_content">
                                   <form class="frmQuickAssign" data-url="<?php echo site_url('reports/reassignregister/' . $user); ?>" method="get">
                                        <input type="hidden" name="searchValues" value='<?php echo !empty($_GET) ? serialize($_GET) : ''; ?>' />
                                        <input type="hidden" name="source" value="rpt_enquires" />
                                        <table>
                                             <tr>
                                                  <td style="padding-left: 10px;">
                                                       <!-- muliSelectCombo -->
                                                       <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control cmbSalesExecutives" name="executive[]">
                                                            <?php foreach ((array) $salesStaff as $key => $value) { ?>
                                                                 <option value="<?php echo $value['usr_id']; ?>"><?php echo $value['usr_username']; ?></option>
                                                            <?php } ?>
                                                       </select>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td style="padding:10px;">
                                                       <textarea placeholder="Desction" name="desc" class="select2_group form-control" required></textarea>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td style="padding-left: 10px;">
                                                       <button type="submit" class="btn btn-round btn-primary">Assign</button>
                                                  </td>
                                             </tr>
                                        </table>
                                   </form>
                              </div>
                         </div>
                    </div>
               </div>
          <?php } ?>
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