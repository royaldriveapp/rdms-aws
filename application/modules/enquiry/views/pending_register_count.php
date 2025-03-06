<div class="right_col" role="main">     
     <div class="row">          
          <div class="col-md-12 col-sm-12 col-xs-12">               
               <div class="x_panel">                    
                    <div class="x_title">                         
                         <h2>Pending register</h2>                         
                         <div style="float: right;">                              
                              <a href="javascript:;<?php //echo site_url($controller . '/myregisterReport?type=ex');        ?>">
                                   <i class="fa fa-circle" style="color: #003580;"> Existing </i>
                              </a>                              
                              <a href="javascript:;<?php //echo site_url($controller . '/myregisterReport?type=nw');        ?>">
                                   <i class="fa fa-circle" style="color: red;"> New </i>
                              </a>                              
                              <a href="javascript:;<?php //echo site_url($controller . '/myregisterReport');        ?>">
                                   <i class="fa fa-circle" style="color: black;"> All </i>
                              </a>  
                              <a href="javascript:;<?php //echo site_url($controller . '/myregisterReport');        ?>">
                                   <i class="fa fa-circle" style="color: #4EA929;"> Punched </i>
                              </a>
                         </div>                         
                         <div class="clearfix"></div>                    
                    </div>
                    <div class="row">
                         <div class="col-md-12 col-sm-12 ">
                              <div class="x_panel">
                                   <div class="x_title">
                                        <h2>Pending register </h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                             <li style="float: right;">
                                                  <?php if (check_permission('enquiry', 'export_excel')) { ?>
                                                       <a href="<?php echo site_url('enquiry/exportRegisterReportExl?' . $_SERVER['QUERY_STRING']); ?>">
                                                            <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                                       </a>
                                                  <?php } ?>
                                             </li>
                                             <li style="float:right;"><a 
                                                       data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" 
                                                       aria-controls="collapseExample"><i class="fa fa-chevron-up"></i>
                                                       <i class="fa fa-chevron-down"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                   </div>
                                   <div class="x_content collapse" id="collapseExample">
                                        <?php if (check_permission('enquiry', 'myregistercallanalysis')) { ?>
                                             <h2>Todays calls analysis</h2>
                                             <div class="x_content">
                                                  <table class="table table-striped table-bordered">
                                                       <tbody>
                                                            <?php
                                                            if (!empty($tc)) {
                                                                 foreach ($tc as $key => $value) {
                                                                      $mod = unserialize(MODE_OF_CONTACT);
                                                                      if (!empty($value['analysis'])) {
                                                                           ?>
                                                                           <tr>
                                                                                <td>
                                                                                     <?php echo $value['col_title']; ?>
                                                                                </td>
                                                                                <td class="bold-text">
                                                                                     <?php foreach ($value['analysis'] as $k => $val) {
                                                                                          ?> <span><?php echo $mod[$val['vreg_contact_mode']]; ?></span> : 
                                                                                          <span><?php echo $val['cnt']; ?></span> <?php
                                                                                     }
                                                                                     ?>
                                                                                </td>
                                                                           </tr>
                                                                           <?php
                                                                      }
                                                                 }
                                                            }
                                                            ?>
                                                       </tbody>
                                                  </table>
                                             </div>
                                             <?php
                                        } if (is_roo_user() && !empty($staff)) {
                                             $ttl = 0;
                                             ?>
                                             <div class="x_content">
                                                  <table class="table table-striped table-bordered">
                                                       <tbody>
                                                            <?php
                                                            foreach ($staff as $key => $rgvalue) {
                                                                 $stf = $this->enquiry->regPendingCount($rgvalue['user_id']);
                                                                 $ttl = $ttl + count($stf);
                                                                 ?>
                                                                 <tr>
                                                                      <td><?php echo $rgvalue['col_title']; ?></td>
                                                                      <td class="bold-text"><?php echo count($stf); ?></td>
                                                                 </tr>
                                                                 <?php
                                                            }
                                                            ?>
                                                            <tr>
                                                                 <td>Total</td>
                                                                 <td><?php echo $ttl; ?></td>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                             </div>
                                        <?php }
                                        ?>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="x_content">
                         <?php
                         $currentURL = current_url();
                         $params = $_SERVER['QUERY_STRING'];
                         $fullURL = $currentURL . '?' . $params;
                         ?>
                         <form action="<?php echo $fullURL; ?>" method="get">
                              <input type="hidden" name="type" value="<?php echo isset($_GET['type']) ? $_GET['type'] : ''; ?>"/>
                              <table>
                                   <tr>
                                        <td>
                                             <select class="select2_group form-control cmbBindShowroomByDivision" name="vreg_division" id="vreg_division"
                                                     data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom" 
                                                     data-dflt-select="Select Showroom">
                                                  <option value="">Select division</option>
                                                  <?php foreach ($division as $key => $value) { ?>
                                                       <option <?php
                                                       echo (isset($_GET['vreg_division']) && ($_GET['vreg_division'] == $value['div_id'])) ?
                                                               'selected="selected"' : '';
                                                       ?> value="<?php echo $value['div_id']; ?>"><?php echo $value['div_name']; ?></option>
                                                       <?php } ?>
                                             </select>
                                        </td>
                                        <td>
                                             <select class="select2_group form-control cmbShowroom shorm_stf" 
                                                     name="vreg_showroom" id="vreg_showroom">
                                                  <option value="">Select showroom</option>
                                                  <?php foreach ($showroom['associatedShowroom'] as $key => $value) { ?>
                                                       <option <?php
                                                       echo (isset($_GET['vreg_showroom']) && ($_GET['vreg_showroom'] == $value['col_id'])) ?
                                                               'selected="selected"' : '';
                                                       ?> value="<?php echo $value['col_id']; ?>"> <?php echo $value['col_title']; ?>
                                                       </option>
                                                  <?php } ?>
                                             </select>
                                        </td>
                              
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   </tr>
                             
                              
                              </table>
                         </form>
                    </div>
               
                    <div class="x_content">
                         <div style="width: 100%;overflow-x: scroll;">
                              <table class="table table-striped table-bordered">                              
                                   <thead>
                                        <tr>
                                             <th><?php// print_r($datas); ?>Exicutive</th>
                                             <th>NUMBER</th>
                                           
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                        $colspan = 16;

                                        if (!empty($datas)) {
                                             foreach ((array) $datas as $key => $value) {
                                                 // $regFollowups = $this->enquiry->regFollowups($value['vreg_id']);
                                            //      $remarks = strip_tags($value['vreg_customer_remark']);
                                                  $color = 'color: #fff';
                                                  $bgColor = '';
                                                  $canPunch = 1;
//                                                  if (empty($value['vreg_inquiry'])) {
//                                                       $bgColor = 'red';
//                                                  } else if ($value['vreg_is_verified'] != 1) {
//                                                       $bgColor = '#4c3000';
//                                                       $canPunch = 0;
//                                                  } else if ($value['vreg_is_punched'] == 1) {
//                                                       $bgColor = '#4EA929';
//                                                  } else {
//                                                       $bgColor = '#004099';
//                                                  }

                                                  $trVOE = '';
                                                  if (check_permission('registration', 'caneditmyregister') || $this->usr_grp == 'AD') {
                                                       $trVOE = 'trVOE';
                                                  }
                                                  ?>
                                                  <tr style="">
                                                       <td><?php echo $value['assign_usr_first_name']; ?></td>
                                                       <td><?php echo $value['pendregcount']; ?></td>
                                                     
                                                     
                                                  </tr>
                                                  <?php
                                             }
                                        } else {
                                             ?> 
                                             <tr>
                                                  <td style="text-align: center;" colspan="<?php echo $colspan; ?>">No data available in table</td>
                                             </tr>
                                        <?php } ?>
                                   </tbody>                         
                              </table>                         
                         </div>
                         <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex; ?> to <?php echo $limit; ?> of <?php echo $totalRow; ?> entries</div>                         
                         <div style="float: right;">                              
                              <?php echo $links; ?>                         
                         </div>
                    </div>               
               </div>          
          </div>     
     </div>
</div>

<style>
     .table>thead>tr>th {
          white-space: nowrap;
          width: 1%;
     }
     .table>tbody>tr>td {
          white-space: nowrap;
          width: 1%;
     }
</style>