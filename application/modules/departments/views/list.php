<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Departments</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="col-md-12 col-sm-12 col-xs-12">
                              <a href="<?php echo site_url($controller . '/add');?>" class="btn btn-round btn-primary">
                                   <i class="fa fa-pencil-square-o"></i> New Department
                              </a>
                         </div>
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Division</th>
                                        <th>Parent Department</th>
                                        <th>Department name</th>
                                        <th>Delete</th>    
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($data)) {
                                          foreach ($data as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url($controller . '/view/' . $value['dep_id']);?>">
                                                    <td class="trVOE"><?php echo $value['div_name'];?></td>
                                                    <td class="trVOE"><?php echo $value['dep_parent_name'];?></td>
                                                    <td class="trVOE"><?php echo $value['dep_name'];?></td>
                                                    <td>
                                                         <a class="pencile deleteListItem" href="javascript:void(0);" 
                                                            data-url="<?php echo site_url($controller . '/delete/' . $value['dep_id']);?>">
                                                              <i class="fa fa-remove"></i>
                                                         </a>
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