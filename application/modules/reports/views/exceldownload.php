<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Excel download log</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Owner</th>
                                        <th>Description</th>
                                        <th>Log time</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $logdata as $key => $value) {
                                          ?>
                                          <tr>
                                               <td><?php echo $value['usr_username'];?></td>
                                               <td><?php echo $value['log_title'];?></td>
                                               <td><?php echo date('j M Y h:i A', strtotime($value['log_added_on_in']));?></td>
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