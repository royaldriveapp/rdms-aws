<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Quick followup report</h2>
                         <div class="clearfix"></div>
                    </div>
                    <input type="hidden" value='<?php echo serialize($_GET); ?>' class="txtFilters"/>
                    <?php if (check_permission('reports', 'quickenquiryfedbackcount')) {?>
                           <table class="table table-striped table-bordered">
                                <th>Staff</th>
                                <th>Total</th>
                                <th>Called</th>
                                <!-- <th>Effective calls</th> -->
                                <!-- <th>Ineffective calls</th> -->
                                <!-- <th>Hot</th> -->
                                <!-- <th>Warm</th> -->
                                <!-- <th>Cold</th> -->
                                <th>Pending</th>
                                <?php
                                if (!empty($data)) {
                                     foreach ($data as $key => $value) {
                                          ?>
                                          <tr>
                                               <td style="font-size: 15px;font-weight: bold;">
                                                    <?php echo $value['name'];?>
                                               </td>
                                               <td>
                                                    <a style="font-size: 15px;color: blue;font-weight: bold;" href="<?php echo site_url('reports/quickEnquiryFedBack?qtr_assigned_to=' . $key);?>"><?php echo $value['total'];?></a>
                                               </td>
                                               <td>
                                                    <a style="font-size: 15px;color: green;font-weight: bold;" href="<?php echo site_url('reports/quickEnquiryFedBack?qtr_reply_by=' . $key);?>"><?php echo $value['called'];?></a>
                                               </td> 

                                               <!--<td>
                                                    <a style="font-size: 15px;color: green;font-weight: bold;" href="<?php echo site_url('reports/quickEnquiryFedBack?qtr_effective=1&qtr_reply_by=' . $key);?>"><?php echo $value['efect'];?></a>
                                               </td> 
                                               <td>
                                                    <a style="font-size: 15px;color: green;font-weight: bold;" href="<?php echo site_url('reports/quickEnquiryFedBack?qtr_effective=0&qtr_reply_by=' . $key);?>"><?php echo $value['infect'];?></a>
                                               </td> 

                                               <td>
                                                    <a style="font-size: 15px;color: green;font-weight: bold;" href="<?php echo site_url('reports/quickEnquiryFedBack?qtr_type=1&qtr_reply_by=' . $key);?>"><?php echo $value['hot'];?></a>
                                               </td> 
                                               <td>
                                                    <a style="font-size: 15px;color: green;font-weight: bold;" href="<?php echo site_url('reports/quickEnquiryFedBack?qtr_type=2&qtr_reply_by=' . $key);?>"><?php echo $value['warm'];?></a>
                                               </td> 
                                               <td>
                                                    <a style="font-size: 15px;color: green;font-weight: bold;" href="<?php echo site_url('reports/quickEnquiryFedBack?qtr_type=3&qtr_reply_by=' . $key);?>"><?php echo $value['cold'];?></a>
                                               </td> -->

                                               <td>
                                                    <a style="font-size: 15px;color: red;font-weight: bold;" href="<?php echo site_url('reports/quickEnquiryFedBack?qtr_reply_by=0&qtr_assigned_to=' . $key);?>"><?php echo $value['balance'];?></a>
                                               </td>
                                          </tr>
                                          <?php
                                     }
                                }
                                ?>
                           </table>
                      <?php }?>
                    <div class="x_content">
                         <table class="tblQuickFollowupReport table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Enq Date</th>
                                        <th>Customer</th>
                                        <th>Contact</th>
                                        <th>whatsapp</th>
                                        <th>Vehicle</th>
                                        <th>Sales officer</th>
                                        <th>Assign to</th>
                                        <th>Comments</th>
                                        <th>Replay on</th>
                                        <!-- <th>Effective?</th> -->
                                        <!-- <th>Type</th> -->
                                        <th>Track card</th>
                                   </tr>
                              </thead>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>