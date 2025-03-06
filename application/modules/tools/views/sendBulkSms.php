<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Send bulk sms</h2>
                         <div class="clearfix"></div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <div class="x_panel">
                              <div class="x_title">
                                   <h2><img width="15" title="Export to excel" src="images/sms.png"> SMS Body</h2>
                                   <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                   <form action="<?php echo site_url($controller . '/sendBulkSms');?>" method="post" enctype="multipart/form-data">
                                        <div class="x_content">
                                             <textarea required name="settings[blk_sms_template]" style="width: 100%;"><?php echo get_settings_by_key('blk_sms_template');?></textarea>
                                             <div class="checkbox">
                                                  <label class="" style="padding-left: 0px;">
                                                       <div class="icheckbox_flat-green checked" style="position: relative;">
                                                            <input required type="checkbox" class="flat" name="confirm" value="1" style="position: absolute; opacity: 0;">
                                                            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                       </div> Confirm to send sms
                                                  </label>
                                             </div>
                                             <div style="padding-top: 10px;">
                                                  <button name="btnSubmit" value="blk_sms_ind_customers" type="submit" class="btn btn-round btn-primary">
                                                       <i class="fa fa-paper-plane"></i> Send SMS to Indian customers</button>
                                             </div>
                                        </div>
                                   </form>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <div class="x_panel">
                              <div class="x_title">
                                   <h2><img width="15" title="Export to excel" src="images/sms.png"> SMS Template</h2>
                                   <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                   <table class="table table-bordered">
                                        <thead>
                                             <tr>
                                                  <th>Template Tag</th>
                                                  <th>Description</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                  <td>{cust_name}</td>
                                                  <td>Customer name</td>
                                             </tr>
                                             <tr>
                                                  <td>{se_name}</td>
                                                  <td>Sales executive name</td>
                                             </tr>
                                             <tr>
                                                  <td>{se_number}</td>
                                                  <td>Sales executive number</td>
                                             </tr>
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>

                    <!-- Direct to mobile number -->
                    <div class="col-md-12 col-sm-6 col-xs-12">
                         <div class="x_panel">
                              <div class="x_title">
                                   <h2><img width="15" title="Export to excel" src="images/sms.png"> Direct SMS to numbers</h2>
                                   <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                   <form action="<?php echo site_url($controller . '/sendBulkSms');?>" method="post" enctype="multipart/form-data">
                                        <div class="x_content">
                                             <textarea required name="settings[blk_sms_numbers]" style="width: 100%;"><?php echo isset($numbers) ? implode($numbers, ',') : '';?></textarea>
                                             <textarea required name="settings[blk_sms_template_direct]" style="width: 100%;margin-top: 10px;"><?php echo get_settings_by_key('blk_sms_template_direct');?></textarea>

                                             <div class="checkbox">
                                                  <label class="" style="padding-left: 0px;">
                                                       <div class="icheckbox_flat-green checked" style="position: relative;">
                                                            <input required type="checkbox" class="flat" name="confirm" value="1" style="position: absolute; opacity: 0;">
                                                            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                       </div> Confirm to send sms
                                                  </label>
                                             </div>
                                             <div style="padding-top: 10px;">
                                                  <button name="btnSubmit" value="blk_sms_direct" type="submit" class="btn btn-round btn-primary">
                                                       <i class="fa fa-paper-plane"></i> Send SMS</button>
                                             </div>
                                        </div>
                                   </form>
                              </div>
                         </div>
                    </div>
                    <!-- -->
               </div>
          </div>
     </div>
</div>