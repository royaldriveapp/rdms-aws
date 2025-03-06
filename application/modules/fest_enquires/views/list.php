<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Blog Tags</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Image</th>
                                        <th>News Title</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th>Edit</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $blogList as $key => $value) {
                                          ?>
                                          <tr data-url="<?php echo site_url('blog/view/' . encryptor($value['blog_id']));?>">
                                               <td class="trVOE">
                                                    <?php $img = isset($value['images'][0]['bimg_image']) ? $value['images'][0]['bimg_image'] : '';?>
                                                    <?php echo img(array('src' => '../assets/uploads/blog/thumb_' . $img));?>
                                               </td>
                                               <td class="trVOE"><?php echo $value['blog_title'];?></td>
                                               <td class="trVOE"><?php echo $value['bcat_title'];?></td>
                                               <td class="trVOE"><?php echo date('j M Y', strtotime($value['blog_date']));?></td>
                                               <td>
                                                    <a class="pencile deleteListItem" href="javascript:void(0);" 
                                                       data-url="<?php echo site_url('blog/delete/' . $value['blog_id']);?>">
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