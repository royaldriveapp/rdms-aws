<div class="row-fluid">
     <div class="span12">
          <div class="widget red">
               <div class="widget-title">
                    <h4><i class="icon-list-ul"></i> <?php echo $this->section; ?></h4>
               </div>
               <div class="widget-body">
                    <table class="table table-bordered table-striped" id="sample">
                         <thead>
                              <tr>
                                   <th class="hidden-phone">Priority</th>
                                   <th class="hidden-phone">Brand</th>
                                   <th class="hidden-phone">Parent</th>
                                   <th class="hidden-phone">Url</th>
                                   <th class="hidden-phone">Edit</th>
                                   <th class="hidden-phone">Delete</th>    
                              </tr>
                         </thead>
                         <tfoot>
                              <tr>
                                   <th class="hidden-phone">Priority</th>
                                   <th class="hidden-phone">Brand</th>
                                   <th class="hidden-phone">Parent</th>
                                   <th class="hidden-phone">Url</th>
                                   <th class="hidden-phone">Edit</th>
                                   <th class="hidden-phone">Delete</th>    
                              </tr>
                         </tfoot>
                         <tbody>
                              <?php
                                if (!empty($brand)) {
                                     foreach ($brand as $key => $value) {
                                          ?>
                                          <tr>
                                               <td><?php echo $value['brd_sort_order']; ?></td>
                                               <td class="hidden-phone"><?php echo $value['brd_title']; ?></td>
                                               <td class="hidden-phone"><?php echo $value['parent']; ?></td>
                                               <td class="hidden-phone"><?php echo $value['brd_url']; ?></td>
                                               <td class="hidden-phone" style="width: 20px;">
                                                    <a class="pencile edit" href="<?php echo site_url('brand/view/' . $value['brd_id']); ?>">
                                                         <i class="icon-pencil"></i>
                                                    </a>
                                               </td>
                                               <td class="hidden-phone" style="width: 20px;">
                                                    <a class="pencile deleteRow" id="<?php echo $value['brd_id']; ?>" href="javascript:void(0);" data-url="<?php echo site_url('brand/delete/' . $value['brd_id']); ?>">
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