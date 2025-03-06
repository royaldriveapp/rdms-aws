<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <?php if ($this->usr_grp == 'AD') {?>
                                     <li style="float: right;">
                                          <a href="<?php echo site_url('enquiry/myinquiresByStatusExpExcel?' . $_SERVER['QUERY_STRING']);?>">
                                               <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                          </a>
                                     </li>
                                <?php }?>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Customer</th>
                                        <th>Contact No</th>
                                        <th>Mode of inquiry</th>
                                        <th>Type</th>
                                        <?php if ($this->usr_grp != 'SE') {?>
                                               <th>Showroom</th>
                                               <th>Executive</th>
                                          <?php }?>
                                        <th>Enq Date</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     foreach ((array) $searchResult as $key => $veh) {
                                          $canEdit = (($this->uid == $veh['enq_se_id']) || is_roo_user()) ? 'trVOE' : '';
                                          ?>
                                          <tr data-url="<?php echo site_url('enquiry/printTrackCard/' . encryptor($veh['enq_id']));?>">
                                               <td class="<?php echo $canEdit;?>"><?php echo strtoupper($veh['enq_cus_name']);?></td>
                                               <td><a href="tel:<?php echo $veh['usr_phone'];?>"><?php echo $veh['enq_cus_mobile'];?></a></td>
                                               <td class="<?php echo $canEdit;?>">
                                                    <?php
                                                    $mods = unserialize(MODE_OF_CONTACT);
                                                    echo isset($mods[$veh['enq_mode_enq']]) ? $mods[$veh['enq_mode_enq']] : '';
                                                    ?>
                                               </td>
                                               <td class="<?php echo $canEdit;?>"><?php echo $veh['enq_cus_status'] == 1 ? 'Sell' : 'Buy';?></td>
                                               <?php if ($this->usr_grp != 'SE') {?>
                                                    <td class="<?php echo $canEdit;?>"><?php echo $veh['shr_location'];?></td>
                                                    <td class="<?php echo $canEdit;?>"><?php echo $veh['usr_first_name'];?></td>
                                               <?php }?>
                                               <td><?php echo date('j M Y', strtotime($veh['enq_entry_date']));?></td>
                                          </tr>
                                          <?php
                                     }
                                   ?>
                              </tbody>
                         </table>
                         <!--<div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex;?> to <?php echo $limit;?> of <?php echo $totalRow;?> entries</div>-->
                         <div>
                              <div style="float: left;">
                                   <strong><?php echo $totalRows . ' Enquires found';?></strong>
                              </div>
                              <div style="float: right;">
                                   <?php echo $links;?>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>