<div class="right_col" role="main">
     <div class="">
          <div class="page-title">
               <div class="title_left" style="width: 100%;">
                    <h2>Status details of <?php echo $enquiryDetails['enq_cus_name'];?></h2>
               </div>
          </div>
          <div class="clearfix"></div>
          <br/>
          <div class="row">
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Customer Detail </h2>
                              <div style="float: right;"><a title="Print track card" href="<?php echo site_url('enquiry/printTrackCard') . '/' . encryptor($enquiryDetails['enq_id']); ?>">
                                                              <span class="glyphicon glyphicon-print"></span></a></div>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <table class="table table-striped">
                                   <tbody>
                                        <tr>
                                             <td>Customer Name</td>
                                             <td><?php echo $enquiryDetails['enq_cus_name'];?></td>
                                        </tr>
                                        <tr>
                                             <td> Customer Mobile</td>
                                             <td><?php echo $enquiryDetails['enq_cus_mobile'];?></td>
                                        </tr>
                                        <tr>
                                             <td> Customer Whatsapp</td>
                                             <td><?php echo $enquiryDetails['enq_cus_whatsapp'];?></td>
                                        </tr>
                                        <tr>
                                             <td>Sales executive</td>
                                             <td><?php echo $enquiryDetails['usr_first_name'];?></td>
                                        </tr>
                                   </tbody>
                              </table>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Vehicle Details</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <table class="table table-striped">
                                   <thead>
                                        <tr>
                                             <th>Brand</th>
                                             <th>Model</th>
                                             <th>Variant</th>
                                             <th>Type</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                          if (isset($enquiryDetails['vehicles']) && !empty($enquiryDetails['vehicles'])) {
                                               foreach ($enquiryDetails['vehicles'] as $key => $value) {
                                                    if ($value['veh_status'] == 1) {
                                                         $type = 'Sell';
                                                    } else if ($value['veh_status'] == 2) {
                                                         $type = 'Buy';
                                                    } else if ($value['veh_status'] == 3) {
                                                         $type = 'Exchange';
                                                    }
                                                    ?>
                                                    <tr>
                                                         <td><?php echo $value['brd_title'];?></td>
                                                         <td><?php echo $value['mod_title'];?></td>
                                                         <td><?php echo $value['var_variant_name'];?></td>
                                                         <td><?php echo $type;?></td>
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
               <?php
                 if (isset($enquiryDetails['history']) && !empty($enquiryDetails['history'])) {
                      ?>
                      <div class="col-md-6 col-sm-6 col-xs-12" style="float: right;">
                           <div class="x_panel">
                                <div class="x_title">
                                     <h2>Status Log</h2>
                                     <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                     <ul class="list-unstyled timeline">
                                          <?php foreach ($enquiryDetails['history'] as $key => $value) {?>
                                               <li>
                                                    <div class="block">
                                                         <div class="tags">
                                                              <a href="javascript:;" class="tag">
                                                                   <span><?php echo date('j M Y', strtotime($value['enh_added_on']));?></span>
                                                              </a>
                                                         </div>
                                                         <div class="block_content">
                                                              <p class="excerpt"><?php echo $value['enh_remarks'];?></p>
                                                              <div class="byline">
                                                                   by <a><?php echo $value['enq_added_by_name'];?> (<?php echo date('j M Y h:i A', strtotime($value['enh_added_on']));?>)</a>
                                                              </div>
                                                              <hr>
                                                         </div>

                                                    </div>
                                               </li>
                                          <?php }?>
                                     </ul>
                                </div>
                           </div>
                      </div>
                 <?php } //if (isset($enquiryDetails['enq_current_status']) && (in_array($enquiryDetails['enq_current_status'], array(2, 4, 6, 8)))) {?>
                      <div class="col-md-6 col-sm-6 col-xs-12" style="float: left;">
                           <div class="x_panel">
                                <div class="x_title">
                                     <h2>Comments</h2>
                                     <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                     <form id="demo-form2" method="post"   class="form-horizontal form-label-left" 
                                           enctype="multipart/form-data">
                                          <input type="hidden" name="enh_enq_id" value="<?php echo $enquiryDetails['enq_id'];?>"/>

                                          <p>What executive says</p>
                                          <div class="table-responsive">
                                               <div class="form-group">
                                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                                         <code><?php echo isset($enquiryDetails['history'][0]['enh_remarks']) ? $enquiryDetails['history'][0]['enh_remarks'] : '';?></code>
                                                    </div>
                                               </div>
                                          </div>
                                          <br/>
                                          <?php if (!empty($statusButtons)) {?>
                                               <p>Comments</p>
                                               <div class="table-responsive">
                                                    <div class="form-group">
                                                         <div class="col-md-12 col-sm-6 col-xs-12">
                                                              <textarea name="enh_remarks" type="text" id="enq_cus_name"
                                                                        class="form-control col-md-7 col-xs-12 enq_cus_name" required="true"></textarea>
                                                         </div>
                                                    </div>
                                               </div>
                                               <div class="ln_solid"></div>
                                               <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                         <?php
                                                         foreach ($statusButtons as $key => $value) {
                                                              ?>
                                                              <button type="submit" class="btn btn-round btn-<?php echo $value['buttonClass']?>" 
                                                                      name="enh_status" value="<?php echo $value['id']?>"><?php echo $value['title']?></button>
                                                                 <?php }?>
                                                    </div>
                                               </div>
                                          <?php }?>
                                     </form>
                                </div>
                           </div>
                      </div>
                 <?php //}?>
          </div>
     </div>
</div>