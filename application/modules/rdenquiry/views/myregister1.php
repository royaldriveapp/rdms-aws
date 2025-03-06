<div class="right_col" role="main">     <div class="row">          
          <div class="col-md-12 col-sm-12 col-xs-12">               
               <div class="x_panel">                    
                    <div class="x_title">                         
                         <h2>My register</h2>                         
                         <div style="float: right;">                              
                              <a href="<?php echo site_url($controller . '/myregister?type=ex');?>">
                                   <i class="fa fa-circle" style="color: #003580;"> Existing </i>
                              </a>                              
                              <a href="<?php echo site_url($controller . '/myregister?type=nw');?>">
                                   <i class="fa fa-circle" style="color: red;"> New </i>
                              </a>                              
                              <a href="<?php echo site_url($controller . '/myregister');?>">
                                   <i class="fa fa-circle" style="color: black;"> All </i>
                              </a>                         
                         </div>                         
                         <div class="clearfix"></div>                    
                    </div>                    
                    <div class="x_content">                         
                         <table class="table table-striped table-bordered">                              
                              <thead>
                                   <tr>
                                        <th>Entry date</th>
                                        <th>Customer name</th>
                                        <th>Contact</th>
                                        <th>Place</th>
                                        <th>Contact mode</th>
                                        <th>Event</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Variant</th>
                                        <th>Year</th>
                                        <th>Investment</th>
                                        <th>Added on</th>
                                        <th>Status</th>
                                        <th>Assigned to</th>
                                        <?php if (check_permission('registration', 'canassigntose')) {?>                                               
                                               <th>Added by</th>
                                               
                                          <?php } if (check_permission('registration', 'candelete')) {?>        
                                               <th>Delete</th>
                                          <?php }?>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     $colspan = 8;
                                     if (!empty($datas)) {
                                          foreach ((array) $datas as $key => $value) {
                                               $url = '';
                                               if ($value['vreg_is_verified']) {
                                                    $url = !empty($value['vreg_inquiry']) ?
                                                            site_url('followup/viewFollowup/' . encryptor($value['vreg_inquiry'])) : site_url($controller . '/regiter_2_inquiry/' . encryptor($value['vreg_id']));
                                               }
                                               $color = 'color: #fff';
                                               $bgColor = '';
                                               if (empty($value['vreg_inquiry'])) {
                                                    $bgColor = 'red';
                                               } else if ($value['vreg_is_verified'] != 1) {
                                                    $bgColor = '#4c3000';
                                               } else {
                                                    $bgColor = '#004099';
                                               }
                                               ?>                                          
                                               <tr style="<?php echo $color;?>;background-color: <?php echo $bgColor;?>" data-url="<?php echo $url;?>">
                                                    <td class="trVOE"><?php echo date('j M Y', strtotime($value['vreg_entry_date']));?></td>                                               
                                                    <td class="trVOE"><?php echo $value['vreg_cust_name'];?></td>
                                                    <td class="trVOE"><?php echo $value['vreg_cust_phone'];?></td> 
                                                    <td class="trVOE"><?php echo $value['vreg_cust_place'];?></td>
                                                    <td class="trVOE">
                                                         <?php
                                                         $modes = unserialize(MODE_OF_CONTACT);
                                                         echo isset($modes[$value['vreg_contact_mode']]) ? $modes[$value['vreg_contact_mode']] : '';
                                                         ?>                                               
                                                    </td>
                                                    <td class="trVOE"><?php echo $value['evnt_title'];?></td>
                                                    <td class="trVOE"><?php echo $value['brd_title'];?></td>
                                                    <td class="trVOE"><?php echo $value['mod_title'];?></td>
                                                    <td class="trVOE"><?php echo $value['var_variant_name'];?></td>
                                                    <td class="trVOE"><?php echo $value['vreg_year'];?></td>
                                                    <td class="trVOE"><?php echo $value['vreg_investment'];?></td>
                                                    <td class="trVOE"><?php echo date('j M Y', strtotime($value['vreg_added_on']));?></td>
                                                    <td class="trVOE"><?php echo ($value['vreg_is_verified'] == 1) ? 'Verified' : 'Pending';?></td>
                                                    <td class="trVOE"><?php echo $value['assign_usr_first_name'];?></td>   
                                                    <?php
                                                    if (check_permission('registration', 'canassigntose')) {
                                                         $colspan = $colspan + 2;
                                                         ?>
                                                         <td class="trVOE"><?php echo $value['addedby_usr_first_name'];?></td> 
                                                         <?php
                                                    } if (check_permission('registration', 'candelete')) {
                                                         $colspan = $colspan + 1;
                                                         ?>    
                                                         <td>
                                                              <a class="pencile deleteListItem" href="javascript:void(0);" data-url="<?php echo site_url('registration/delete/' . $value['vreg_id']);?>">  
                                                                   <i class="fa fa-remove"></i>
                                                              </a>
                                                         </td>
                                                    <?php }?>
                                               </tr>
                                               <?php
                                          }
                                     } else {
                                          ?> 
                                          <tr>
                                               <td style="text-align: center;" colspan="<?php echo $colspan;?>">No data available in table</td>
                                          </tr>
                                     <?php }?>
                              </tbody>                         
                         </table>                         
                         <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex;?> to <?php echo $limit;?> of <?php echo $totalRow;?> entries</div>                         
                         <div style="float: right;">                              
                              <?php echo $links;?>                         
                         </div>                    
                    </div>               
               </div>          
          </div>     
     </div>
</div>