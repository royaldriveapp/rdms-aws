<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Table field count</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Table</th>
                                        <th>Field count</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($tables)) {
                                          foreach ($tables as $key => $value) {
                                               $tbl = 'Tables_in_' . $this->db->database;
                                               ?> 
                                               <tr>
                                                    <td><?php echo $value[$tbl];?></td>
                                                    <td><?php echo count($this->help->tableFields($value[$tbl]));?></td>
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
