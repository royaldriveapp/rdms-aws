<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Enquires</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Customer Grade</th>
                                        <th>Customer Name</th>
                                        <th>Sales Executive</th>
                                        <th>Mobile</th>
                                        <th>Occupation</th>
                                        <th>Track card</th>
                                        <th>Verify</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php if (!empty($enquiryDetails)) {?>
                                          <tr>
                                               <th><?php echo $enquiryDetails['sgrd_grade'];?></th>
                                               <th><?php echo $enquiryDetails['enq_cus_name'];?></th>
                                               <th><?php echo $enquiryDetails['usr_username'];?></th>
                                               <th><?php echo $enquiryDetails['enq_cus_mobile'];?></th>
                                               <th><?php echo $enquiryDetails['occ_name'];?></th>
                                               <th>
                                                    <a href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($enquiryDetails['enq_id']));?>">
                                                         <i class="fa fa-eye"></i>
                                                    </a>
                                               </th>
                                               <th><input type="checkbox" name="chkVerify" value="1" class="chkCommonConfirm"
                                                          data-url="<?php echo site_url($controller . '/verificationView/' . encryptor($enquiryDetails['enq_id']));?>"
                                                          data-confmsg="Are you sure to verify this ?"/></th>
                                          </tr>
                                     <?php }?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>