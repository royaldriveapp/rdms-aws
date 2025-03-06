<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Call log</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Date</th>
                                        <th>DID</th>
                                        <th>Customer</th>
                                        <th>CUG</th>
                                        <th>Status</th>
                                        <th>T Caller</th>
                                        <th>Voice</th>
                                        <th>To reg</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($data)) {
                                          foreach ($data as $key => $value) {
                                               ?>
                                               <tr>
                                                    <td><?php echo $value['ccb_added_on'];?></td>
                                                    <td><?php echo $value['ccb_calledNumber'];?></td>
                                                    <td>
                                                         <a target="blank" href="<?php echo 'https://api.whatsapp.com/send?phone=' . $value['ccb_callerNumber'];?>">
                                                              <?php echo $value['ccb_callerNumber'];?>
                                                         </a>
                                                    </td>
                                                    <td><?php echo $value['ccb_AgentNumber'];?></td>
                                                    <td><?php echo $value['ccb_callStatus'];?></td>
                                                    <td><?php echo $value['ccb_authorized_person'];?></td>
                                                    <td>
                                                         <audio controls>
                                                              <source src="<?php echo 'http://pbx.voxbaysolutions.com/callrecordings/' . $value['ccb_recording_URL'];?>"/>
                                                         </audio>
                                                    </td>
                                                    <td>
                                                         <a href="<?php echo site_url('registration/add/' . $value['ccb_id']);?>"> <i class='fa fa-arrow-right'></i></a>
                                                    </td>
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