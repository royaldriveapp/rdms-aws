<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Vehicle register</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <form action="<?php echo site_url('registration/droppedregisters'); ?>" method="get">
                              <table>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="search" type="text" class="form-control col-md-7 col-xs-12" 
                                                    placeholder="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"/>
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Search</button>
                                        </td>

                                   </tr>
                              </table>
                         </form>
                    </div>
                    <div class="x_content">
                         <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
                              <table class="table table-striped table-bordered">
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
                                             <th>Call type</th>
                                             <?php if (check_permission('registration', 'candelete')) {?>        
                                                    <th>Delete</th>
                                               <?php }?>
                                             <th>Description</th>
                                             <?php if ($this->uid == 56) {?>
                                                    <th>ReAssign</th>
                                             <?php }?>
                                             <th>Reason for drop</th>
                                             <?php if (check_permission('registration', 'reopen')) { ?>
                                                  <th>Re Open</th>
                                             <?php } ?>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                          foreach ((array) $datas as $key => $value) {
                                               $htry = $this->registration->getLastDroppedHistory($value['vreg_id']);
                                               ?>
                                               <tr style="<?php echo ($value['vreg_status'] == 0) ? 'color: #fff;background-color: red;' : '';?>"
                                                   data-url="<?php echo site_url($controller . '/view/' . encryptor($value['vreg_id']));?>">
                                                    <td>
                                                         <?php if ($value['vreg_is_effective'] == 1) {?><i title="Effective call" style="color: green;" class="fa fa-check"></i> <?php }?>
                                                         <?php echo date('j M Y', strtotime($value['vreg_entry_date']));?>
                                                    </td>
                                                    <td><?php echo $value['vreg_cust_name'];?></td>
                                                    <td>
                                                         <a style="<?php echo ($value['vreg_status'] == 0) ? 'color: #fff;background-color: red;' : '';?>" 
                                                            <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['vreg_cust_phone'] . '"';?>><?php echo $value['vreg_cust_phone'];?></a>
                                                    </td>
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
                                                    <td><?php echo $value['assign_usr_first_name'] . ' ' . $value['assign_usr_last_name'];?></td>
                                                    <td>
                                                         <?php echo $value['addedby_usr_first_name'] . ' ' . $value['addedby_usr_last_name'];?>
                                                         <?php if (!empty($value['vreg_last_action'])) {?>
                                                              <i class="fa fa-comment-o" title="<?php echo $value['vreg_last_action'];?>"></i>
                                                         <?php }?>
                                                    </td>
                                                    <td>
                                                         <?php
                                                         $callTypes = unserialize(CALL_TYPE);
                                                         echo isset($callTypes[$value['vreg_call_type']]) ? $callTypes[$value['vreg_call_type']] : '';
                                                         ?>
                                                    </td>
                                                    <?php if (check_permission('registration', 'candelete')) {?>
                                                         <td>
                                                              <a class="pencile deleteListItem" href="javascript:void(0);" data-url="<?php echo site_url($controller . '/delete/' . $value['vreg_id']);?>">
                                                                   <i class="fa fa-remove"></i>
                                                              </a>
                                                         </td>
                                                    <?php }?>
                                                    <td><?php echo $value['vreg_customer_remark'];?></td>
                                                    <?php if ($this->uid == 56) {?>
                                                         <td><a href="<?php echo site_url($controller . '/reassign/' . encryptor($value['vreg_id']));?>">Reassign</a></td>
                                                    <?php }?>
                                                    <td title="<?php echo isset($htry['regh_system_cmd']) ? $htry['regh_system_cmd'] : ''; ?>">
                                                       <?php echo isset($htry['regh_remarks']) ? $htry['regh_remarks'] : ''; ?>
                                                    </td>
                                                    <?php if (check_permission('registration', 'reopen')) { ?>
                                                       <td><a href="<?php echo site_url($controller . '/reopen/' . encryptor($value['vreg_id'])); ?>">Re open</a></td>
                                                    <?php } ?>
                                               </tr>
                                               <?php
                                          }
                                        ?>
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