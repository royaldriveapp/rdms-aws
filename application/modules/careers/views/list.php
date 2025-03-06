<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Vacancies</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Priority</th>
                                        <th>Title</th>
                                        <th>Location</th>
                                        <th>No of Vacancies</th>
                                        <th>Status</th>
                                        <th>Delete</th>    
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $career as $key => $value) {
                                          ?>
                                          <tr data-url="<?php echo site_url('careers/view/' . $value['car_id']);?>">
                                               <td class="trVOE"><?php echo $value['car_order'];?></td>
                                               <td class="trVOE"><?php echo $value['car_title'];?></td>
                                               <td class="trVOE"><?php echo $value['car_location'];?></td>
                                               <td class="trVOE"><?php echo $value['car_no_of_vacancies'];?></td>
                                               <td>
                                                    <input class="chkOnchange" type="checkbox" value="1" name="car_status" 
                                                           data-url="<?php echo site_url($controller . '/changeuserstatus/' . encryptor($value['car_id']));?>"
                                                           <?php echo ($value['car_status'] == 1) ? "checked" : '';?>
                                               </td>
                                               <td>
                                                    <a class="pencile deleteListItem" href="javascript:void(0);" data-url="<?php echo site_url('careers/delete/' . $value['car_id']);?>">
                                                         <i class="fa fa-remove"></i>
                                                    </a>
                                               </td>
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