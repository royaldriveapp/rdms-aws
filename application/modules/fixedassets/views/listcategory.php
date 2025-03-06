<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Fixed assets category list</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="col-md-12 col-sm-12 col-xs-12">
                              <a href="<?php echo site_url($controller . '/newcategory'); ?>" class="btn btn-round btn-primary">
                                   <i class="fa fa-pencil-square-o"></i> New category
                              </a>
                         </div>
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Category</th>
                                        <th>Parent Category</th>
                                        <th>Delete</th>     
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   if (!empty($categories)) {
                                        foreach ($categories as $key => $value) {
                                             ?>
                                             <tr data-url="<?php echo site_url($controller . '/update/' . encryptor($value['fac_id'])); ?>">
                                                  <td class="trVOE"><?php echo $value['category_name']; ?></td>
                                                  <td class="trVOE"><?php echo $value['parent_category']; ?></td>
                                                  <td style="width: 20px;">
                                                       <a class="pencile deleteRow" id="<?php echo $value['fac_id']; ?>" href="javascript:void(0);" 
                                                          data-url="<?php echo site_url('fixedassets/deletefixedassets/' . $value['fac_id']); ?>">
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