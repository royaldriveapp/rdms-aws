<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Feedback from mobile APP</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" style="background: none;">
                                   <li role="presentation" class="active">
                                        <a href="#tab_dar" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">Live feedback</a>
                                   </li>
                                   <li role="presentation">
                                        <a href="#tab_website" id="dar-tab" role="tab" data-toggle="tab" aria-expanded="true">All feedback</a>
                                   </li>
                              </ul>
                              <div id="myTabContent" class="tab-content">
                                   <div role="tabpanel" class="tab-pane fade active in" id="tab_dar" aria-labelledby="dar-tab">
                                        <table class="datatable table table-striped table-bordered">
                                             <thead>
                                                  <tr>
                                                       <th>Date</th>
                                                       <th>Name</th>
                                                       <th>Phone</th>
                                                       <th>Feedback</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php
                                                  foreach ((array) $live as $key => $value) {
                                                       ?>
                                                       <tr data-url="<?php echo site_url($controller . '/view/' . encryptor($value['app_feedback_id'])); ?>">
                                                            <td class="trVOE"><?php echo date('j M Y', strtotime($value['app_feedback_date'])); ?></td>
                                                            <td class="trVOE"><?php echo $value['app_feedback_name']; ?></td>
                                                            <td class="trVOE"><?php echo $value['app_feedback_phone']; ?></td>
                                                            <td class="trVOE"><?php echo $value['app_feedback']; ?></td>
                                                       </tr>
                                                       <?php
                                                  }
                                                  ?>
                                             </tbody>
                                        </table>
                                   </div>
                                   <div role="tabpanel" class="tab-pane fade" id="tab_website" aria-labelledby="dar-tab">
                                        <table class="datatable table table-striped table-bordered">
                                             <thead>
                                                  <tr>
                                                       <th>Date</th>
                                                       <th>Name</th>
                                                       <th>Phone</th>
                                                       <th>Feedback</th>
                                                       <th>Action plan</th>
                                                       <th>Updated on</th>
                                                       <th>Updated by</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php
                                                  foreach ((array) $all as $key => $value) {
                                                       ?>
                                                       <tr>
                                                            <td><?php echo date('j M Y H:i:s', strtotime($value['app_feedback_time'])); ?></td>
                                                            <td><?php echo $value['app_feedback_name']; ?></td>
                                                            <td><?php echo $value['app_feedback_phone']; ?></td>
                                                            <td><?php echo $value['app_feedback']; ?></td>
                                                            <td><?php echo $value['app_feedback_action_pln']; ?></td>
                                                            <td><?php echo !empty($value['app_feedback_action_date']) ? date('j M Y H:i:s', strtotime($value['app_feedback_action_date'])) : ''; ?></td>
                                                            <td><?php echo $value['usr_username']; ?></td>
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
          </div>
     </div>
</div>