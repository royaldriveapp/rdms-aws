<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Help</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Extension</th>
                                        <th>Destination</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Duration</th>
                                        <th>Voice</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php foreach ($data as $key => $value) { ?>
                                        <tr>
                                             <td><?php echo $value['ccbo_status_id'].'-'.$value['ccbo_extension'] ?></td>
                                             <td><?php echo $value['ccbo_destination'] ?></td>
                                             <td><?php echo $value['ccbo_destination_user'] ?></td>
                                             <td><?php echo $value['ccbo_date'] ?></td>
                                             <td><?php echo $value['ccbo_status'] ?></td>
                                              <td>
                                                  <?php if($value['ccbo_status'] == 'ANSWERED') { 
                                                       echo $value['ccbo_duration'] . ' s'; 
                                                  } ?>
                                             </td>
                                             <td>
                                                  <?php if($value['ccbo_status'] == 'ANSWERED') { ?>
                                                       <a target="blank" href="<?php echo $value['ccbo_recording_URL'];?>">Click here</a>
                                                  <?php } ?>
                                             </td>
                                        </tr>
                                   <?php } ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>