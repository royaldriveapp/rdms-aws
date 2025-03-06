<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Inquiry schedule</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="col-md-12 col-sm-12 col-xs-12">
                              <a href="<?php echo site_url($controller . '/add');?>" class="btn btn-round btn-primary">
                                   <i class="fa fa-pencil-square-o"></i> New schedule
                              </a>
                         </div>
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Designation</th>
                                        <th>Delete</th>    
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $data as $key => $value) {
                                          ?>
                                          <tr data-url="<?php echo site_url($controller . '/view/' . $value['isch_id']);?>">
                                               <td class="trVOE"><?php echo $value['isch_start'] . ' Day';?></td>
                                               <td class="trVOE"><?php echo ($value['isch_end'] > 0) ? $value['isch_end'] . ' Day' : '0 Day';?></td>
                                               <td class="trVOE"><?php echo $value['name'] . ' (' . $value['grp_slug'] . ')';?></td>
                                               <td>
                                                    <a class="pencile deleteListItem" href="javascript:void(0);" 
                                                       data-url="<?php echo site_url($controller . '/delete/' . $value['isch_id']);?>">
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