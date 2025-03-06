<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Customer Complaints</h2>
                         <div style="float: right;">
                              <a href="<?php echo site_url($controller . '/myregister?type=ex'); ?>">
                                   <i class="fa fa-circle" style="color: #003580;"> Existing </i>
                              </a>
                              <a href="<?php echo site_url($controller . '/myregister?type=nw'); ?>">
                                   <i class="fa fa-circle" style="color: red;"> New </i>
                              </a>
                              <a href="<?php echo site_url($controller . '/myregister'); ?>">
                                   <i class="fa fa-circle" style="color: black;"> All </i>
                              </a>
                         </div>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div style="width: 100%;overflow-x: scroll;">
                              <table class="table table-striped table-bordered">
                                   <thead>
                                        <tr>
                                             <th>Entry date</th>
                                             <th>Customer name</th>
                                             <th>Contact</th>
                                             <th>Place</th>
                                             <th>Disctrict</th>
                                             <th>Contact mode</th>
                                             <th>Added on</th>
                                             <th>Status</th>
                                             <th>Call type</th>
                                             <th>Division</th>
                                             <th>Department</th>
                                             <th>Added by</th>
                                             <td>Remarks</td>
                                             <td>Punched on</td>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                        if (!empty($datas)) {
                                             foreach ((array) $datas as $key => $value) {
                                                  $remarks = strip_tags($value['vreg_customer_remark']); ?>
                                                  <tr>
                                                       <td style="wid">
                                                            <?php if ($value['vreg_is_effective'] == 1) { ?><i title="Effective call" style="color: green;" class="fa fa-check"></i> <?php } ?>
                                                            <?php echo date('j M Y', strtotime($value['vreg_entry_date'])); ?>
                                                       </td>
                                                       <td><?php echo $value['vreg_cust_name']; ?></td>

                                                       <td><a style="color: #fff;" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $value['vreg_cust_phone']; ?>"><?php echo $value['vreg_cust_phone']; ?></a></td>
                                                       <td><?php echo $value['vreg_cust_place']; ?></td>
                                                       <td><?php echo $value['std_district_name']; ?></td>
                                                       <td>
                                                            <?php
                                                            $modes = unserialize(MODE_OF_CONTACT);
                                                            echo isset($modes[$value['vreg_contact_mode']]) ? $modes[$value['vreg_contact_mode']] : '';
                                                            ?>
                                                       </td>
                                                       <td><?php echo date('j M Y', strtotime($value['vreg_added_on'])); ?></td>
                                                       <td><?php echo ($value['vreg_is_verified'] == 1) ? 'Verified' : 'Pending'; ?></td>
                                                       <td>
                                                            <?php
                                                            $callTypes = unserialize(CALL_TYPE);
                                                            echo isset($callTypes[$value['vreg_call_type']]) ? $callTypes[$value['vreg_call_type']] : '';
                                                            ?>
                                                       </td>
                                                       <td>
                                                            <?php
                                                            $div = $this->divisions->getDivNameById($value['div_id']);
                                                            echo $div['div_name'];
                                                            ?>
                                                       </td>
                                                       <td><?php echo $value['dep_name']; ?></td>
                                                       <td><?php echo $value['addedby_usr_first_name']; ?>
                                                            <?php if ($value['vreg_last_action']) { ?>
                                                                 <i class="fa fa-comment" style="color: #fff;" title="<?php echo $value['vreg_last_action']; ?>"></i>
                                                            <?php } ?>
                                                       </td>

                                                       <td><?php echo $remarks; ?></td>
                                                       <td><?php echo $value['vreg_tsc_comments']; ?></td>
                                                       <td style="wid"><?php echo date('j M Y h:i A', strtotime($value['vreg_added_on'])); ?></td>
                                                  </tr>
                                             <?php
                                             }
                                        } else {
                                             ?>
                                             <tr>
                                                  <td style="text-align: center;" colspan="16">No data available in table</td>
                                             </tr>
                                        <?php } ?>
                                   </tbody>
                              </table>
                         </div>
                         <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex; ?> to <?php echo $limit; ?> of <?php echo $totalRow; ?> entries</div>
                         <div style="float: right;">
                              <?php echo $links; ?>
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