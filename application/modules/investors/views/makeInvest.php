<div class="right_col" role="main" style="min-height: 913px;">
     <div class="">
          <div class="page-title">
               <div class="title_left">
                    <h3>Investor profile</h3>
               </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
               <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                         <div class="x_title">
                              <h2>Investor profile <small>Activity report</small></h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <div class="col-md-3 col-sm-3  profile_left">
                                   <h3><?php echo $master['inv_name']; ?></h3>
                                   <ul class="list-unstyled user_data">
                                        <li>
                                             <i class="fa fa-user user-profile-icon"></i> <?php echo $master['inv_address']; ?>
                                        </li>
                                        <li>
                                             <i class="fa fa-map-marker user-profile-icon"></i> <?php echo $master['inv_location'] . ', ' . $master['std_district_name']; ?>
                                        </li>
                                        <li>
                                             <i class="fa fa-phone user-profile-icon"></i> <?php echo (!empty($phone)) ? implode(', ', array_column($phone, 'invp_phone')) : 'Not available'; ?>
                                        </li>
                                        <li>
                                             <i class="fa fa-briefcase user-profile-icon"></i> <?php echo $master['inv_occupation']; ?>
                                        </li>
                                        <li>
                                             <i class="fa fa-home user-profile-icon"></i> <?php echo $master['inv_company']; ?>
                                        </li>
                                        <li>
                                             <i class="fa fa-envelope user-profile-icon"></i> <?php echo $master['inv_email']; ?>
                                        </li>
                                   </ul>
                              </div>
                              <div class="col-md-9 col-sm-9 ">
                                   <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                             <li role="presentation" class="active">
                                                  <a href="#tab_contribution" role="tab" id="contribution-tab" data-toggle="tab" aria-expanded="false" 
                                                     class="active" aria-selected="true">Investments</a>
                                             </li>
                                             <li role="presentation">
                                                  <a href="#tab_followup" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false" 
                                                     aria-selected="true">Follow-up</a>
                                             </li>
                                             <li role="presentation">
                                                  <a href="#tab_new_contribution" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false" 
                                                     aria-selected="true">New contribution</a>
                                             </li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                             <div role="tabpanel" class="tab-pane active" id="tab_contribution" aria-labelledby="contribution-tab">
                                                  <table class="data table table-striped no-margin">
                                                       <thead>
                                                            <tr>
                                                                 <th>#</th>
                                                                 <th>Investment Date</th>
                                                                 <th>Contribution</th>
                                                                 <th>Period in year</th>
                                                                 <th>Period in month</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <?php
                                                            if (!empty($investments)) {
                                                                 foreach ($investments as $key => $value) {
                                                                      ?>
                                                                      <tr>
                                                                           <td><?php echo $key + 1; ?></td>
                                                                           <td><?php echo!empty($value['invd_entry_date']) ? date('j M Y', strtotime($value['invd_entry_date'])) : ''; ?></td>
                                                                           <td><?php $invamt = unserialize(INV_AMOUNT);
                                                                                echo isset($invamt[$value['invd_inv_amount']]) ? $invamt[$value['invd_inv_amount']] : ''; ?></td>
                                                                           <td><?php echo ($value['invd_tim_year'] > 0) ? $value['invd_tim_year'] . ' Year' : ''; ?></td>
                                                                           <td><?php echo ($value['invd_tim_month'] > 0) ? $value['invd_tim_month'] . ' Month' : ''; ?></td>
                                                                      </tr>
                                                                      <?php
                                                                 }
                                                            }
                                                            ?>
                                                       </tbody>
                                                  </table>
                                             </div>
                                             <div role="tabpanel" class="tab-pane" id="tab_followup" aria-labelledby="profile-tab">
                                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                                       <div class="x_panel tile overflow_hidden">
                                                            <div class="x_title">
                                                                 <h2>Followup comments</h2>
                                                                 <div class="clearfix"></div>
                                                            </div>
                                                            <div class="x_content">
                                                                 <div class="form-group" style="float: left;width: 100%;">
                                                                      <div class="col-md-10 col-sm-6 col-xs-8">
                                                                           <textarea type="text" class="vdh_cmd form-control col-md-7 col-xs-8" name="vdh_cmd" 
                                                                                     placeholder="Comments"></textarea>    
                                                                      </div>
                                                                      <div class="col-md-2 col-sm-6 col-xs-8">
                                                                           <button value="28" name="status" type="submit" data-url="<?php echo site_url($controller . '/updateFollowup/' . $master['inv_id']); ?>"
                                                                                   class="btnSubmitInvestComment btn btn-success">Submit <i class="fa fa-comments"></i></button>
                                                                      </div>
                                                                 </div>

                                                                 <div class="timeline-container" style="float:left;height: 400px;overflow-y: scroll;width:100%;">
                                                                      <ul class="book-timeline ulTimeline">
                                                                           <?php
                                                                           if (!empty($followup)) {
                                                                                foreach ($followup as $key => $invFollup) {
                                                                                     ?>
                                                                                     <li>
                                                                                          <div class="timeline-time">
                                                                                               <span class="date"><i class="fa fa-calendar" style="margin-right: 5px;"></i>
                                                                                                    <?php echo date('d-m-Y', strtotime($invFollup['invf_added_on'])); ?>
                                                                                               </span>
                                                                                          </div>
                                                                                          <div class="timeline-icon">
                                                                                               <a href="javascript:;">&nbsp;</a>
                                                                                          </div>
                                                                                          <div class="timeline-body">
                                                                                               <div class="timeline-header">
                                                                                                    <span class="userimage">
                                                                                                         <?php
                                                                                                         if (file_exists('assets/uploads/avatar/' . $invFollup['usr_avatar'])) {
                                                                                                              echo img(array('src' => 'assets/uploads/avatar/' . $invFollup['usr_avatar']));
                                                                                                         } else {
                                                                                                              ?><img src="https://www.w3schools.com/howto/img_avatar.png" alt=""><?php
                                                                                                         }
                                                                                                         ?>
                                                                                                    </span>
                                                                                                    <span class="username">
                                                                                                         <a href="javascript:;">
                                                                                                              <?php echo $invFollup['usr_first_name'] . ' ' . $invFollup['usr_last_name']; ?>
                                                                                                         </a>
                                                                                                         <!--<span style="float:right;"><i class="fa fa-map-marker"></i> <?php //echo 'Malappuram';                ?></span>-->
                                                                                                    </span>
                                                                                               </div>
                                                                                               <div class="timeline-content">
                                                                                                    <p>
                                                                                                         <?php echo $invFollup['invf_comment']; ?>
                                                                                                    </p>
                                                                                               </div>
                                                                                          </div>
                                                                                     </li>
                                                                                     <?php
                                                                                }
                                                                           }
                                                                           ?>
                                                                      </ul>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div role="tabpanel" class="tab-pane" id="tab_new_contribution" aria-labelledby="profile-tab">
                                                  <div class="x_panel">
                                                       <div class="x_title">
                                                            <h2>New Contribution</h2>
                                                            <div class="clearfix"></div>
                                                       </div>
                                                       <div class="x_content">
                                                            <?php
                                                            echo form_open_multipart($controller . "/makeInvest", array('id' => "frmVehicleModel",
                                                                'class' => "form-horizontal form-label-left", "onsubmit" => "return validateForm()"))
                                                            ?>
                                                            <input type="hidden" name="details[invd_investor]" value="<?php echo $master['inv_id']; ?>">
                                                            <div class="form-group">
                                                                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Entry date <span class="required">*</span></label>
                                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                                      <input value="<?php echo date('d-m-Y'); ?>" required type="text" class="dtpDatePicker form-control col-md-7 col-xs-12"
                                                                             name="details[invd_entry_date]" id="invd_entry_date" autocomplete="off" placeholder="Entry date"/>
                                                                 </div>
                                                            </div>

                                                            

                                                            <div class="form-group">
                                                                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Time of investment</label>
                                                                 <div class="col-md-3 col-sm-6 col-xs-12">
                                                                      <select class="select2_group form-control" name="details[invd_tim_year]" id="vreg_contact_mode">
                                                                           <option value="">Year</option>
                                                                           <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                                                <option value="<?php echo $i; ?>"><?php echo $i . ' Year'; ?></option>
                                                                           <?php } ?>
                                                                      </select>
                                                                 </div>
                                                                 <div class="col-md-3 col-sm-6 col-xs-12">
                                                                      <select class="select2_group form-control" name="details[invd_tim_month]" id="vreg_contact_mode">
                                                                           <option value="">Month</option>
                                                                           <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                                                <option value="<?php echo $i; ?>"><?php echo $i . ' Month'; ?></option>
                                                                           <?php } ?>
                                                                      </select>
                                                                 </div>
                                                            </div>

                                                            <div class="form-group">
                                                                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Investment amount</label>
                                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                                      <select required class="select2_group form-control" name="details[invd_inv_amount]" id="invd_inv_amount">
                                                                           <option value="">Investment amount</option>
                                                                           <?php foreach (unserialize(INV_AMOUNT) as $key => $value) { ?>
                                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                           <?php } ?>
                                                                      </select>
                                                                 </div>
                                                            </div>

                                                            <div class="form-group">
                                                                 <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Customer status</label>
                                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                                      <select required class="select2_group form-control" name="details[invd_status]" id="invd_status">
                                                                           <option value="">Please select customer status</option>
                                                                           <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $key => $value) { ?>
                                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                           <?php } ?>
                                                                      </select>
                                                                 </div>
                                                            </div>
                                                            <!-- -->
                                                            <div class="form-group">
                                                                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer remarks <span class="required">*</span></label>
                                                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                                                      <textarea class="form-control col-md-7 col-xs-12" name="details[invd_coment]" id="invd_coment" placeholder="Customer remarks"></textarea>
                                                                 </div>
                                                            </div>

                                                            <div class="divSale"></div>
                                                            <div class="ln_solid"></div>
                                                            <div class="form-group">
                                                                 <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                                      <button type="submit" class="btn btn-success btnSubmitRegister">Submit</button>
                                                                 </div>
                                                            </div>
                                                            <?php echo form_close() ?>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<script>
     $(document).ready(function () {
          $(document).on('click', '.btnSubmitInvestComment', function () {
               var documentDetails = $('.vdh_cmd').val().trim();
               if (documentDetails) {
                    $('.vdh_cmd').css('border-color', '');
                    var url = $(this).data('url');
                    $.ajax({
                         type: 'post',
                         url: url,
                         dataType: 'json',
                         data: {
                              vdh_cmd: documentDetails
                         },
                         success: function (resp) {
                              $('.ulTimeline').prepend(resp.msg).effect("shake");
                              $('.vdh_cmd').val('');
                         }
                    });
               } else {
                    $('.vdh_cmd').css('border-color', 'red');
                    $('.vdh_cmd').focus();
               }
          });
     });
</script>

<div class="tmpSaleRelated" style="display: none;">
     <div class="form-group rfrl_type" style="display: none" >
          <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Referal Type</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <select class="select2_group form-control referal_type" name="referal_type" id="referal_type">
                    <option value="">Please select</option>
                    <?php foreach (unserialize(REFERAL_TYPES) as $key => $value) { ?>
                         <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
               </select>
          </div>
     </div>

     <div class="form-group rfrl_typeChld" style="display: none" id="referal_details">
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Staff</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <select  id="referalRdStaffs" class="referalRdStaffs select2_group form-control staff_select" name="referal_name1"></select>
               </div>
          </div>
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12 numOnly " value="" name="referal_phone1" id="referal_phone1"
                           autocomplete="off" placeholder="Referal phone"/>
               </div>
          </div>
     </div>
     <div class="form-group rfrl_typeChld" style="display: none" id="referal_details2">
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Phone</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input  type="text" class="form-control col-md-7 col-xs-12 numOnly customer_phone" name="referal_phone2" id="customer_phone"
                            data-url="<?php echo site_url('registration_1/customerByPhone'); ?>" 
                            autocomplete="off" placeholder="Referal phone(Customer)" value="<?php echo $customerNumber; ?>"/>
                    <h6 class="customer_phone_msg" id="customer_phone_msg" style="color: red;"></h6>
               </div>
          </div>
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" name="referal_name2" id="referal_customer_name"
                           autocomplete="off" placeholder="Referal Name"/>
               </div>
          </div>
          <input type="hidden"  name="referal_enq_cus_id" id="referal_enq_cus_id"  />

     </div>
     <div class="form-group rfrl_typeChld" style="display: none" id="referal_details3">
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" name="referal_name3" id="referal_name3"
                           autocomplete="off" placeholder="Referal Name"/>
               </div>
          </div>
          <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12 numOnly " name="referal_phone3" id="referal_phone3"
                           autocomplete="off" placeholder="Referal phone"/>
               </div>
          </div>

     </div>
     <div class="tmpSaleRelated" style="display: none;">
          <div class="form-group rfrl_type" style="display: none" >
               <label for="vreg_customer_status" class="control-label col-md-3 col-sm-3 col-xs-12">Referal Type</label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="select2_group form-control referal_type" name="referal_type" id="referal_type">
                         <option value="">Please select</option>
                         <?php foreach (unserialize(REFERAL_TYPES) as $key => $value) { ?>
                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                         <?php } ?>
                    </select>
               </div>
          </div>

          <div class="form-group rfrl_typeChld" style="display: none" id="referal_details">
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Staff</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <select  id="referalRdStaffs" class="referalRdStaffs select2_group form-control staff_select" name="referal_name1"></select>
                    </div>
               </div>
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="text" class="form-control col-md-7 col-xs-12 numOnly " value="" name="referal_phone1" id="referal_phone1"
                                autocomplete="off" placeholder="Referal phone"/>
                    </div>
               </div>
          </div>
          <div class="form-group rfrl_typeChld" style="display: none" id="referal_details2">
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Phone</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <input  type="text" class="form-control col-md-7 col-xs-12 numOnly customer_phone" name="referal_phone2" id="customer_phone"
                                 data-url="<?php echo site_url('registration_1/customerByPhone'); ?>" 
                                 autocomplete="off" placeholder="Referal phone(Customer)" value="<?php echo $customerNumber; ?>"/>
                         <h6 class="customer_phone_msg" id="customer_phone_msg" style="color: red;"></h6>
                    </div>
               </div>
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="text" class="form-control col-md-7 col-xs-12" name="referal_name2" id="referal_customer_name"
                                autocomplete="off" placeholder="Referal Name"/>
                    </div>
               </div>
               <input type="hidden"  name="referal_enq_cus_id" id="referal_enq_cus_id"  />
          </div>
          <div class="form-group rfrl_typeChld" style="display: none" id="referal_details3">
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Referal Name</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="text" class="form-control col-md-7 col-xs-12" name="referal_name3" id="referal_name3"
                                autocomplete="off" placeholder="Referal Name"/>
                    </div>
               </div>
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="text" class="form-control col-md-7 col-xs-12 numOnly " name="referal_phone3" id="referal_phone3"
                                autocomplete="off" placeholder="Referal phone"/>
                    </div>
               </div>
          </div>
     </div>
</div>