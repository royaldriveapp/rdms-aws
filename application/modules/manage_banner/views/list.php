<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Home page banner</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php 
                           if (check_permission($controller, 'add')) {?>
                                <table style="margin: 10px 10px;">
                                     <tr>
                                          <td>
                                               <a href="<?php echo site_url($controller . '/add');?>" class="btn btn-round btn-primary">
                                                    <i class="fa fa-pencil-square-o"></i> New banner</a>
                                          </td>
                                     </tr>
                                </table>
                           <?php } ?>
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th style="width:50px;">Order</th>
                                        <th style="width:50px;">Category</th>
                                        <th style="width: 300px;" class="">Banner</th>
                                        <?php echo (check_permission($controller, 'delete')) ? '<th style="width:50px;">Delete</th>' : '';?>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($banners)) {
                                          foreach ($banners as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url('manage_banner/view/' . $value['bnr_id']);?>">
                                                    <td class="trVOE"><?php echo $value['bnr_order'];?></td>
                                                    <td class="trVOE"><?php echo $value['bnr_category'] == 1 ? 'Website' : 'App';?></td>
                                                    <td class="trVOE">
                                                         <?php echo img(array('src' => FILE_UPLOAD_PATH . 'banner/' . $value['bnr_image'], 'width' => '100'));?>
                                                    </td>
                                                    <?php if (check_permission($controller, 'delete')) {?>
                                                         <td>
                                                              <a class="pencile deleteListItem" href="javascript:void(0);" 
                                                                 data-url="<?php echo site_url('manage_banner/delete/' . $value['bnr_id'] . '/' . $value['bnr_image']);?>">
                                                                   <i class="fa fa-remove"></i>
                                                              </a>
                                                         </td>
                                                    <?php }?>
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