<div class="row-fluid">
     <div class="span12">
          <!-- BEGIN EXAMPLE TABLE widget-->
          <div class="widget red">
               <div class="widget-title">
                    <h4><i class="icon-list-ul"></i> <?php echo $this->section; ?></h4>
               </div>
               <div class="widget-body">
                    <table class="table table-bordered table-striped" id="sample">
                         <thead>
                              <tr>
                                   <th class="hidden-phone">Priority</th>
                                   <th class="hidden-phone">Category</th>
                                   <th class="hidden-phone">Parent Category</th>
                                   <th class="hidden-phone">Edit</th>
                                   <th class="hidden-phone">Delete</th>     
                              </tr>
                         </thead>
                         <tfoot>
                              <tr>
                                   <th class="hidden-phone">Priority</th>
                                   <th class="hidden-phone">Category</th>
                                   <th class="hidden-phone">Parent Category</th>
                                   <th class="hidden-phone">Edit</th>
                                   <th class="hidden-phone">Delete</th>     
                              </tr>
                         </tfoot>
                         <tbody>
                              <?php if (!empty($categories)) {
                                     foreach ($categories as $key => $value) {
                                          ?>
                                          <tr>
                                               <td><?php echo $value['cat_order']; ?></td>
                                               <td><?php echo $value['category_name']; ?></td>
                                               <td><?php echo $value['parent_category']; ?></td>
                                               <td style="width: 20px;">
                                                    <a class="pencile edit" href="<?php echo site_url('category/view/' . $value['cat_id']); ?>">
                                                         <i class="icon-pencil"></i>
                                                    </a>
                                               </td>
                                               <td style="width: 20px;">
                                                    <a class="pencile deleteRow" id="<?php echo $value['cat_id']; ?>" href="javascript:void(0);" data-url="<?php echo site_url('category/delete/' . $value['cat_id']); ?>">
                                                         <i class="icon-trash"></i>
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