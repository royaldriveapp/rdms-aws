<div class="right_col" role="main">
     <!-- -->
     <style>
          .stretch-card>.card {
               width: 100%;
               min-width: 100%;
          }

          .card {
               box-shadow: 4px 8px 9px -2px #c7c5d8;
               -webkit-box-shadow: 4px 8px 9px -2px #c7c5d8;
               -moz-box-shadow: 4px 8px 9px -2px #c7c5d8;
               -ms-box-shadow: 4px 8px 9px -2px #c7c5d8;
          }

          .card {
               position: relative;
               display: flex;
               flex-direction: column;
               min-width: 0;
               word-wrap: break-word;
               background-color: #fff;
               background-clip: border-box;
               border: 1px solid #e3e3e3;
               border-radius: 0;
          }

          .card .card-body {
               padding: 1.25rem 1.437rem;
          }

          .card-body {
               flex: 1 1 auto;
               padding: 1rem 1rem;
          }
     </style>

     <div class="row">
          <div class="blink col-md-3 grid-margin stretch-card" style="margin: 20px 0px;">
               <div class="card">
                    <div class="card-body">
                         <p class="card-title text-md-center text-xl-left">Missed Followup</p>
                         <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                              <h3 class="red mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo $totalRow; ?></h3>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <!-- -->
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Missed Followup</h2>
                         <?php if ($this->uid == 592) { ?>
                              <ul class="nav navbar-right panel_toolbox">
                                   <li style="float: right;">
                                        <?php if (check_permission('missedexport', 'missedexport')) { ?>
                                             <a href="<?php echo site_url('followup/missedexport?' . $_SERVER['QUERY_STRING']); ?>">
                                                  <img width="20" title="Export to excel" src="images/excel-export.png" />
                                             </a>
                                        <?php } ?>
                                   </li>
                              </ul>
                         <?php } ?>
                         <div class="clearfix"></div>
                    </div>
                    <?php if (check_permission('followup', 'missedfolloupcount')) { ?>
                         <div class="table-wrapper-scroll-y my-custom-scrollbar">
                              <table class="table table-striped table-bordered">
                                   <?php foreach ($missedCount as $key => $value) { ?>
                                        <tr style="background-color: <?php echo ($value['usr_active'] == 0) ? 'red; color:#fff' : 'green; color:#fff'; ?>">
                                             <td><?php echo $value['usr_first_name']; ?></td>
                                             <td><?php echo $value['msdfolcnt']; ?></td>
                                        </tr>
                                   <?php } ?>
                              </table>
                         </div>
                         <h2>Missed Followup Yesterday</h2>
                         <div class="table-wrapper-scroll-y my-custom-scrollbar">
                              <table class="table table-striped table-bordered">
                                   <?php foreach ($missedCountYTD as $key => $value) { ?>
                                        <tr style="background-color: <?php echo ($value['usr_active'] == 0) ? 'red; color:#fff' : 'green; color:#fff'; ?>">
                                             <td><?php echo $value['usr_first_name']; ?></td>
                                             <td><?php echo $value['msdfolcnt']; ?></td>
                                        </tr>
                                   <?php } ?>
                              </table>
                         </div>

                    <?php }
                    if (check_permission('followup', 'bulkresetfollowupdate')) { ?>
                         <div class="x_content">
                              <table>
                                   <td style="padding-left: 10px;">
                                        <button type="button" class="btn btn-round btn-primary btnResetMisdFollup">
                                             Reset followup date</button>
                                   </td>
                              </table>
                         </div>
                    <?php } ?>
                    <div class="x_content">
                         <form action="<?php echo site_url('followup/missed'); ?>" method="get">
                              <table>
                                   <tr>
                                        <td>
                                             <?php if (isset($staffs) && !empty($staffs)) { ?>
                                                  <select name="enq_se_id" id="travel_with" class="sumoSearchList select2_groupj form-control form-control col-md-7 col-xs-12">
                                                       <option value="0">Select Staff</option>
                                                       <?php foreach ($staffs as $key => $stf) { ?>
                                                            <option <?php echo ($stf['col_id'] == $_GET['enq_se_id']) ? 'selected' : ''; ?> value="<?php echo $stf['col_id'] ?>">
                                                                 <?php echo $stf['col_title']; ?></option>
                                                       <?php } ?>
                                                  </select>
                                             <?php } ?>
                                        </td>
                                        <td>
                                             <input autocomplete="off" name="search" type="text" class="form-control col-md-7 col-xs-12" placeholder="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Search</button>
                                        </td>
                                   </tr>
                              </table>
                         </form>
                    </div>
                    <div class="x_content">
                         <table class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <?php if (check_permission('followup', 'bulkresetfollowupdate')) { ?>
                                             <th><input type="checkbox" class="chkCheckAllChildrens" data-child=".misdFollVehId" /></th>
                                        <?php } ?>
                                        <th>Vehicle ID</th>
                                        <th>Customer</th>
                                        <th>Sales Executive</th>
                                        <th>Phone</th>
                                        <th>Whatsapp</th>
                                        <th>Next followup date</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   foreach ((array) $missedFoll as $key => $enq) {
                                        $followDate = $this->followup->getNextFollowupDate($enq['enq_id']);
                                        $canEdit = (check_permission('followup', 'changenextnollowupdate')) ? 'trVOE' : '';
                                   ?>
                                        <tr class="<?php echo $enq['enq_id']; ?>" data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($enq['enq_id'])); ?>">
                                             <?php if (check_permission('followup', 'bulkresetfollowupdate')) { ?>
                                                  <td><input class="misdFollVehId" type="checkbox" name="misdFollVehId[]" value="<?php echo $enq['enq_id']; ?>" /></td>
                                             <?php } ?>
                                             <td class="<?php echo $canEdit; ?>"><?php echo generate_vehicle_virtual_id($enq['enq_id']); ?></td>
                                             <td class="<?php echo $canEdit; ?>"><?php echo $enq['enq_cus_name']; ?></td>
                                             <td class="<?php echo $canEdit; ?>"><?php echo $enq['usr_first_name']; ?></td>
                                             <td><a href="https://api.whatsapp.com/send?phone=<?php echo $enq['enq_cus_mobile']; ?>"><?php echo $enq['enq_cus_mobile']; ?></a></td>
                                             <td><a href="https://api.whatsapp.com/send?phone=<?php echo $enq['enq_cus_whatsapp']; ?>"><?php echo $enq['enq_cus_whatsapp']; ?></a></td>
                                             <td class="<?php echo $canEdit; ?>"><?php
                                                                                     echo !empty($enq['enq_next_foll_date']) ?
                                                                                          date('j M Y', strtotime($enq['enq_next_foll_date'])) : '';
                                                                                     ?></td>
                                        </tr>
                                   <?php
                                   }
                                   ?>
                              </tbody>
                         </table>
                         <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex; ?> to <?php echo $limit; ?> of <?php echo $totalRow; ?> entries</div>
                         <div style="float: right;">
                              <?php echo $links; ?>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<div id="mdlResetMisdFollup" class="modal fade" role="dialog">
     <div class="modal-dialog">
          <form class="modal-content frmReassignFollowup" action="<?php echo site_url($controller . '/resetMisdFollup'); ?>">
               <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reset followup</h4>
               </div>
               <div class="modal-body">
                    <div class="form-horizontal form-label-left">
                         <div class="form-group">
                              <label for="foll_status" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <select class="select2_group form-control cmbFollowStatus" name="foll_status" required="required">
                                        <option value="">Select status</option>
                                        <?php foreach (unserialize(FOLLOW_UP_STATUS) as $key => $value) { ?>
                                             <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                   </select>
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="foll_action_plan" class="control-label col-md-3 col-sm-3 col-xs-12">Next action plan</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input placeholder="Next action plan" id="foll_action_plan" class="form-control col-md-7 col-xs-12 txtNextActionPlan" type="text" name="foll_action_plan" required="required">
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Next follow up date</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input autocomplete="off" type="text" class="form-control col-md-7 col-xs-12 dtpNextFollowDate foll_next_foll_date" required="required" placeholder="Reset next follow up date" name="foll_next_foll_date">
                              </div>
                         </div>
                         <div class="form-group">
                              <label for="foll_remarks" class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input placeholder="Remarks" id="foll_remarks" class="form-control col-md-7 col-xs-12 txtFollowRemarks" required="required" ype="text" name="foll_remarks">
                              </div>
                         </div>
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="submit" class="btn btn-round btn-primary">Submit</button>
                    <button type="button" class="btn btn-round btn-danger" data-dismiss="modal">Cancel</button>
               </div>
          </form>
     </div>
</div>
<style>
     .my-custom-scrollbar {
          position: relative;
          height: 200px;
          overflow: auto;
     }

     .table-wrapper-scroll-y {
          display: block;
     }
</style>