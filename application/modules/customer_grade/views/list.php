<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Customer Grades</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php if (check_permission($controller, 'add')) {?>
                                <table style="margin: 10px 10px;">
                                     <tr>
                                          <td>
                                               <a href="<?php echo site_url($controller . '/add');?>" class="btn btn-round btn-primary">
                                                    <i class="fa fa-pencil-square-o"></i> New Grade</a>
                                          </td>
                                     </tr>
                                </table>
                           <?php }?>
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th style="width: 10px;">Priority</th>
                                        <th>Grade name</th>
                                        <th>Verification required</th>
                                        <?php echo check_permission($controller, 'delete') ? '<th style="width: 10px;">Delete</th>' : '';?>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $countries as $key => $value) {
                                          ?>
                                          <tr data-url="<?php echo site_url($controller . '/view/' . $value['sgrd_id']);?>">
                                               <td class="trVOE"><?php echo $value['sgrd_priority'];?></td>
                                               <td class="trVOE"><?php echo $value['sgrd_grade'];?></td>
                                               <td class="trVOE"><?php echo ($value['sgrd_need_verification'] == 1) ? 'Yes' : 'No';?></td>
                                               <?php if (check_permission($controller, 'delete')) {?>
                                                    <td>
                                                         <a class="pencile deleteListItem" href="javascript:void(0);" 
                                                            data-url="<?php echo site_url($controller . '/deleteGrade/' . $value['sgrd_id']);?>">
                                                              <i class="fa fa-remove"></i>
                                                         </a>
                                                    </td>
                                               <?php }?>
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