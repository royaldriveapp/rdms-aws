<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Quick followup</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Title</th>
                                        <th>Assigned by</th>
                                        <th>Assigned on</th>
                                        <?php if (check_permission('enquiry', 'chngquickfollowupsts')) { ?>
                                             <th>Completed</th>
                                             <th>Pending</th>
                                             <th>Assign to</th>
                                             <th>Action</th>
                                        <?php } ?>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   if (!empty($quickFollMaster)) {
                                        foreach ($quickFollMaster as $key => $value) {
                                             ?>
                                             <tr data-url="<?php echo site_url('enquiry/quickfollowupDetails/' . encryptor($value['qtrm_id'])); ?>">
                                                  <td class="trVOE"><?php echo $value['qtrm_title']; ?></td>
                                                  <td class="trVOE"><?php echo $value['usr_username']; ?></td>
                                                  <td class="trVOE"><?php echo date('j M Y', strtotime($value['qtrm_added_on'])); ?></td>
                                                  <?php if (check_permission('enquiry', 'chngquickfollowupsts')) { 
                                                       $counts = $this->enquiry->quickFollowupAnalysis($value['qtrm_id']); ?>
                                                       <td><?php echo isset($counts['done']) ? $counts['done'] : 0; ?></td>
                                                       <td><?php echo isset($counts['pend']) ? $counts['pend'] : 0; ?></td>
                                                       <td>
                                                            <?php
                                                            $assignTo = unserialize($value['qtrm_assign_to']);
                                                            echo $this->enquiry->getQuickAssignFollAssignTo($assignTo);
                                                            ?>
                                                       </td>
                                                       <td>
                                                            <input title="Status" type="checkbox" value="1" class="chkOnchange" <?php echo $value['qtrm_status'] == 1 ? 'checked' : ''; ?>
                                                                   data-url="<?php echo site_url($controller . '/chngquickfollowupsts/' . encryptor($value['qtrm_id'])); ?>">

                                                            <a href="<?php echo site_url($controller . '/getquickfollowupanalysis/' . encryptor($value['qtrm_id'])); ?>">
                                                                 <i class="fa fa-bar-chart"></i>
                                                            </a>
                                                       </td>
                                                  <?php } ?>
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