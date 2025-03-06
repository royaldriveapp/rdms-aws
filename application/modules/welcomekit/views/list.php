<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Welcome kit</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php if (check_permission($controller, 'add')) {?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                     <a href="<?php echo site_url($controller . '/add');?>" class="btn btn-round btn-primary">
                                          <i class="fa fa-pencil-square-o"></i> Add new
                                     </a>
                                </div>
                           <?php }?>
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Title</th>    
                                        <th>Description</th>    
                                        <th style="width: 10px;">Delete</th>    
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($datas)) {
                                          foreach ($datas as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url($controller . '/view/' . encryptor($value['wkt_id']));?>">
                                                    <td class="trVOE"><?php echo $value['wkt_name'];?></td>
                                                    <td class="trVOE"><?php echo $value['wkt_description'];?></td>
                                                    <td>
                                                         <a class="pencile deleteListItem" href="javascript:void(0);" data-url="<?php echo site_url($controller . '/delete/' . $value['wkt_id']);?>">
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