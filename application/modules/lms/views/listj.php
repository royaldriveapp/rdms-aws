<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Events</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Date</th>
                                        <th>Title</th>    
                                        <th>Place</th>    
                                        <th>Description</th>    
                                        <th>Delete</th>    
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($datas)) {
                                          foreach ($datas as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url($controller . '/view/' . encryptor($value['evnt_id']));?>">
                                                    <td class="trVOE"><?php echo date('j M Y', strtotime($value['evnt_date']));?></td>
                                                    <td class="trVOE"><?php echo $value['evnt_title'];?></td>
                                                    <td class="trVOE"><?php echo $value['evnt_place'];?></td>
                                                    <td class="trVOE"><?php echo $value['evnt_desc'];?></td>
                                                    <td>
                                                         <a class="pencile deleteListItem" href="javascript:void(0);" data-url="<?php echo site_url($controller . '/delete/' . $value['evnt_id']);?>">
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