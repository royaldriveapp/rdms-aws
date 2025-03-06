<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Fixed assets list</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Asset No</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Company</th>
                                        <th>SL No</th>
                                        <th>Warranty</th>
                                        <th>Added by</th>
                                        <th>Purchased on</th>
                                        <th>Vendor</th>
                                        <th>Issued to</th>
                                        <th>Issued on</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   if (!empty($assets)) {
                                        foreach ($assets as $key => $value) {
                                             ?>
                                             <tr>
                                                  <td><?php echo $value['fap_number']; ?></td>
                                                  <td><?php echo $value['fap_name']; ?></td>
                                                  <td><?php echo $value['sub_category_name']; ?></td>
                                                  <td><?php echo $value['facm_title']; ?></td>
                                                  <td><?php echo $value['fap_slno']; ?></td>
                                                  <td><?php echo $value['fap_warty_till']; ?></td>
                                                  <td><?php echo $value['addedby_first_name']; ?></td>
                                                  <td><?php echo !empty($value['fap_pur_date']) ? date('d-m-Y', strtotime($value['fap_pur_date'])) : ''; ?></td>
                                                  <td><?php echo $value['fap_vendor']; ?></td>
                                                  <td><?php echo $value['owner_first_name']; ?></td>
                                                  <td><?php echo !empty($value['fap_issue_on']) ? date('d-m-Y', strtotime($value['fap_issue_on'])) : ''; ?></td>
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