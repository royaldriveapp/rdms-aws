<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2><?php echo $this->page_title; ?></h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li style="float: right;">
                                   <?php if (check_permission('reports', 'export_excel_drop_loss')) { ?>
                                        <a href="<?php echo site_url('reports/export_excel_drop_loss?s=' . $status . '&' . $_SERVER['QUERY_STRING']); ?>">
                                             <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                        </a>
                                   <?php } ?>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <?php
                              $currentURL = current_url();
                              $params = $_SERVER['QUERY_STRING'];
                              $fullURL = $currentURL . '?s=' . $status . '&' . $params;
                         ?>
                         <form action="<?php echo $fullURL; ?>" method="get">
                              <table>
                                   <tr>
                                        <td>
                                             <select multiple="multiple" style="float: left;width: auto;" 
                                                     class="select2_group form-control cmbMultiSelect" name="enq_cus_dist[]">
                                                  <option>District</option>
                                                  <?php foreach ($districts as $sts => $stsName) { ?> 
                                                       <option <?php echo (!empty($distSelected) && (in_array($stsName['std_id'], $distSelected))) ? 'selected="selected"' : ''; ?>
                                                            value="<?php echo $stsName['std_id']; ?>"><?php echo $stsName['std_district_name']; ?>
                                                       </option>
                                                  <?php } ?>
                                             </select>
                                        </td>


                                        <td style="padding-left: 10px;">
                                                  <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control cmbSalesExecutives" name="executive[]">
                                                       <option value="<?php echo $this->uid; ?>">My self</option>
                                                       <?php foreach ((array) $salesExecutives as $key => $value) { ?>
                                                                 <option <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?>
                                                                      value="<?php echo $value['usr_id']; ?>"><?php echo $value['usr_first_name']; ?></option> 
                                                                      <?php
                                                                 }
                                                            ?>
                                                  </select>
                                        </td>               


                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                        </td>
                                   </tr>
                              </table>
                         </form>
                         <table class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<th>Sales Executive</th>' : '';?>
                                        <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<th>Showroom</th>' : '';?>
                                        <th>Added By</th>
                                        <th>Customer Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Whatsapp</th>
                                        <th>District</th>
                                        <th>Action date</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                     if (!empty($enquires)) {
                                          foreach ($enquires as $key => $value) {
                                               ?>
                                               <tr data-url="<?php echo site_url('enquiry/viewVehicleStatus/' . encryptor($value['enq_id']));?>">
                                                    <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<td class="trVOE">' . strtoupper($value['usr_first_name']) . '</td>' : '';?>
                                                    <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG') ? '<td class="trVOE">' . $value['shr_location'] . '</td>' : '';?>
                                                    <td class="trVOE"><?php echo ($value['usr_id'] == $value['enq_added_by']) ? 'Self' : strtoupper($value['enq_added_by_name'])?></td>
                                                    <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']);?></td>
                                                    <td class="trVOE"><?php echo $value['enq_cus_mobile'];?></td>
                                                    <td class="trVOE"><?php echo $value['enq_cus_email'];?></td>
                                                    <td class="trVOE"><?php echo $value['enq_cus_whatsapp'];?></td>
                                                    <td class="trVOE"><?php echo $value['std_district_name']; ?></td>
                                                    <td class="trVOE"><?php echo date('d-m-Y', strtotime($value['enh_added_on'])); ?></td>
                                               </tr>
                                               <?php
                                          }
                                     }
                                   ?>
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
