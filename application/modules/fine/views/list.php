<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Fine</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                      
                                        <th>Stock Id</th>    
                                        <th>Reg No</th> 
                                        <th>Added On</th>   
                                        <th>Delete</th>    
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($fines)) {
                                          foreach ($fines as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url($controller . '/edit/' . encryptor($value['finm_id']));?>">
                                                    <td class="trVOE"><?php echo $value['finm_stock_id'];?></td>
                                                    <td class="trVOE"><?php echo $value['val_veh_no'];?></td>
                                                    <td class="trVOE"><?php echo date('j M Y', strtotime($value['finm_added_on']));?></td>
                                                   
                                                    <td>
                                                         <a class="pencile deleteListItem" href="javascript:void(0);" data-url="<?php echo site_url($controller . '/delete/' . $value['finm_id']);?>">
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