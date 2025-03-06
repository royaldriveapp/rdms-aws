<div class="col-md-3 left_col">
     <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
               <a href="javascript:;" class="site_title">
                    <i><img src="images/root-logo.png" /></i> <span>ROYAL DRIVE!</span>
               </a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
               <div class="profile_pic">
                    <?php
                    echo img(array(
                         'src' => 'assets/uploads/avatar/' . $this->session->userdata('usr_avatar'),
                         'class' => 'img-circle profile_img'
                    ));
                    ?>
               </div>
               <div class="profile_info">
                    <span>Welcome,</span>
                    <h2><?php echo $this->session->userdata('usr_username') . '<br>' . $this->session->userdata('usr_emp_code'); ?>
                    </h2>
               </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
               <div class="menu_section">
                    <h3>General</h3>
                    <ul class="nav side-menu">
                         <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                   <li><a href="<?php echo site_url(); ?>">Dashboard</a></li>
                              </ul>
                         </li>
                         <?php if (can_access_module('fixedassets')) { ?>
                              <li><a><i class="fa fa-home"></i> Fixed assets <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <li><a href="<?php echo site_url('fixedassets'); ?>">Fixed assets</a></li>
                                        <li><a href="<?php echo site_url('fixedassets/categories'); ?>">Categories</a></li>
                                        <li><a href="<?php echo site_url('fixedassets/purchase'); ?>">Purchase</a></li>
                                        <li><a href="<?php echo site_url('fixedassets/issueAssets'); ?>">Issue Assets</a></li>
                                        <li><a href="<?php echo site_url('fixedassets/returnAssets'); ?>">Issue Return</a></li>
                                   </ul>
                              </li>
                         <?php }
                         if (can_access_module('investors')) { ?>
                              <li><a><i class="fa fa-dollar"></i> Investors <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('investors', 'index')) { ?>
                                             <li><a href="<?php echo site_url('investors'); ?>">Investors</a></li>
                                        <?php }
                                        if (check_permission('investors', 'newinvestor')) { ?>
                                             <li><a href="<?php echo site_url('investors/newinvestor'); ?>">New Investor</a></li>
                                        <?php }
                                        if (check_permission('investors', 'calllog')) { ?>
                                             <li><a href="<?php echo site_url('investors/calllog'); ?>">Call log</a></li>
                                        <?php }
                                        if (check_permission('investors', 'webinvestors')) { ?>
                                             <li><a href="<?php echo site_url('investors/webinvestors'); ?>">Campaign Enquires</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php }
                         if (can_access_module('dar')) { ?>
                              <li><a><i class="fa fa-book"></i>DAR<span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('dar', 'index')) { ?>
                                             <li><a href="<?php echo site_url('dar'); ?>">DAR</a></li>
                                        <?php }
                                        if (check_permission('dar', 'submit_dar')) { ?>
                                             <li><a href="<?php echo site_url('dar/submit_dar'); ?>">Submit DAR</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php }
                         if (can_access_module('feedback')) { ?>
                              <li><a><i class="fa fa-book"></i>Feedback<span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('feedback', 'index')) { ?>
                                             <li><a href="<?php echo site_url('feedback'); ?>">App Feedback</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php }
                                                  if (can_access_module('customers')) { ?>
                                                       <li><a><i class="fa fa-user"></i>Customers<span class="fa fa-chevron-down"></span></a>
                                                                                      <ul class="nav child_menu">
                                                                                           <?php if (check_permission('customers', 'index')) { ?>
                                                                                                <li><a href="<?php echo site_url('customers/create'); ?>">Add</a></li>
                                                                                           <?php } if (check_permission('customers', 'index')) { ?>
                                                                                                <li><a href="<?php echo site_url('customers'); ?>">list</a></li>
                                                                                           <?php } ?>
                                                                                      </ul>
                                                                                 </li>
                                                   <?php }
                         if (can_access_module('enquiry') || can_access_module('customer_grade') || can_access_module('booking')) { ?>
                              <li><a><i class="fa fa-cab"></i> Enquiry <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('enquiry', 'index')) { ?>
                                             <li><a href="<?php echo site_url('enquiry'); ?>">Enquires</a></li>
                                        <?php }
                                        if (check_permission('enquiry', 'pool')) { ?>
                                             <li><a href="<?php echo site_url('enquiry/pool'); ?>">Enquires pool</a></li>
                                        <?php }
                                        if (check_permission('enquiry', 'add')) { ?>
                                             <li><a href="<?php echo site_url('enquiry/add'); ?>">New Enquiry</a></li>
                                        <?php }
                                        if (check_permission('enquiry', 'freezedEnquires')) { ?>
                                             <!-- <li><a href="<?php //echo site_url('enquiry/freezedEnquires');
                                                                 ?>">Freezed Enquires</a></li> -->
                                        <?php }
                                        if (check_permission('enquiry', 'changestatusrequest')) { ?>
                                             <li><a href="<?php echo site_url('enquiry/changeStatusRequest/2'); ?>">
                                                       Request For Drop
                                                       <?php echo !empty($analytics['count_drop_req']) ? '<span class="label label-success pull-right">' . $analytics['count_drop_req'] . '</span>' : ''; ?>
                                                  </a></li>
                                        <?php }
                                        if (check_permission('purchase', 'index')) { ?>
                                             <li><a href="<?php echo site_url('purchase/index'); ?>">Request For Purchase</a></li>
                                        <?php }
                                        /*if (check_permission('enquiry', 'changestatusrequest')) { ?>
                            <li><a href="<?php echo site_url('enquiry/changeStatusRequest/6'); ?>">
                                    Request For Purchase
                                    <?php echo !empty($analytics['count_sale_req']) ? '<span class="label label-success pull-right">' . $analytics['count_sale_req'] . '</span>' : ''; ?>
                                </a></li>
                            <?php }*/
                                        if (check_permission('enquiry', 'changestatusrequest')) { ?>
                                             <li><a href="<?php echo site_url('enquiry/changeStatusRequest/4'); ?>">
                                                       Loss of purchase / Sale
                                                       <?php echo !empty($analytics['count_loss_req']) ? '<span class="label label-success pull-right">' . $analytics['count_loss_req'] . '</span>' : ''; ?>
                                                  </a></li>
                                        <?php }
                                        if (check_permission('enquiry', 'assignenquires')) { ?>
                                             <!-- <li><a href="<?php //echo site_url('enquiry/assignenquires/6');
                                                                 ?>">Assign enquires</a></li> -->
                                        <?php }
                                        if (check_permission('enquiry', 'myregister')) { ?>
                                             <li><a href="<?php echo site_url('enquiry/myregister'); ?>">My register</a></li>
                                        <?php }
                                        if (check_permission('enquiry', 'selfregister')) { ?>
                                             <li><a href="<?php echo site_url('enquiry/selfregister'); ?>">Self register</a></li>
                                        <?php }
                                        if (can_access_module('customer_grade')) { ?>
                                             <li><a href="<?php echo site_url('customer_grade'); ?>">Customer Grade</a></li>
                                        <?php }
                                        if (can_access_module('contactwithseller')) { ?>
                                             <li><a href="<?php echo site_url('contactwithseller'); ?>">Contact with seller</a></li>
                                        <?php }
                                        if (check_permission('booking', 'index')) { ?>
                                             <li><a href="<?php echo site_url('booking/index'); ?>"> Booking enquires
                                                       <?php echo !empty($analytics['count_sale_req']) ? '<span class="label label-success pull-right">' . $analytics['count_sale_req'] . '</span>' : ''; ?>
                                                  </a>
                                             </li>
                                        <?php }
                                        if (check_permission('booking', 'deliverdvehicle')) { ?>
                                             <li><a href="<?php echo site_url('booking/deliverdvehicle/40'); ?>">Deliverd vehicle</a>
                                             </li>
                                        <?php }
                                        if (check_permission('booking', 'bookingcancelledlist')) { ?>
                                             <li><a href="<?php echo site_url('booking/bookingcancelledlist/29'); ?>">Booking
                                                       Cancelled</a></li>
                                        <?php }
                                        if (check_permission('enquiry', 'courtesycalllist')) { ?>
                                             <li><a href="<?php echo site_url('enquiry/courtesycalllist'); ?>">Courtesy Call List</a>
                                             </li>
                                        <?php }
                                        if (check_permission('booking', 'tokenreceived')) { ?>
                                             <li><a href="<?php echo site_url('booking/tokenreceived'); ?>">Token received</a>
                                             </li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         } ?>

                         <?php
                         if (can_access_module('followup')) {
                         ?>
                              <li><a><i class="fa fa-calendar-check-o"></i> Followup <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('followup', 'index')) { ?>
                                             <li><a href="<?php echo site_url('followup'); ?>">All Followup</a></li>
                                        <?php
                                        }
                                        /* if (check_permission('followup', 'running')) {
                                            ?>
                            <li><a href="<?php echo site_url('followup/running');?>">Running
                                    <?php echo!empty($analytics['count_running_followup']) ? '<span class="label label-success pull-right">' . $analytics['count_running_followup'] . '</span>' : '';?></a>
                            </li>
                            <?php
                                            } */
                                        if (check_permission('followup', 'missed')) { ?>
                                             <li><a href="<?php echo site_url('followup/missed'); ?>">Missed Followup
                                                       <?php $msdcnt = $this->session->userdata('follow_missed_count');
                                                       echo ($msdcnt > 0) ? '<span class="badge bg-red">' . $msdcnt . '</span>' : '';
                                                       ?>
                                                  </a></li>
                                        <?php }
                                        if (
                                             check_permission('followup', 'enquirypreference') ||
                                             check_permission('followup', 'enquirypreferencemyself') ||
                                             check_permission('followup', 'enquirypreferencemyteam') ||
                                             check_permission('followup', 'enquirypreferencemyshowroom')
                                        ) { ?>
                                             <li><a href="<?php echo site_url('followup/enquiryPreference'); ?>">Preferences</a></li>
                                        <?php }
                                        if (check_permission('followup', 'precurementrqstlist')) { ?>
                                             <li><a href="<?php echo site_url('followup/precurementRqstList'); ?>"> Procurement req list
                                                  </a></li>
                                        <?php } ?>

                                        <?php if (check_permission('homevisit', 'hw_can_add_request')) { ?> <li><a href="<?php echo site_url('followup/home_visit'); ?>"> My home visit <?php } ?>
                                                  </a></li>
                                             <?php if (check_permission('homevisit', 'hw_all') or check_permission('homevisit', 'hw_smart_only') or check_permission('homevisit', 'hw_my_own') or check_permission('homevisit', 'hw_my_team') or check_permission('homevisit', 'hw_smart_purchase_only') or check_permission('homevisit', 'hw_smart_sales_only') or check_permission('homevisit', 'hw_my_shwroom') or check_permission('homevisit', 'hw_luxury_only') or check_permission('homevisit', 'hw_luxury_purchase_only') or check_permission('homevisit', 'hw_luxury_sales_only')) { ?>
                                                  <li><a href="<?php echo site_url('followup/home_visit_approval_req'); ?>"> Home visit
                                                            Approval Req.<?php } ?>
                                                       </a></li>


                                   </ul>
                              </li>
                         <?php
                         } ?>
                         <!--followup_new-->
                         <?php
                         if (can_access_module('followup_new')) {
                         ?>
                              <li><a><i class="fa fa-calendar-check-o"></i> Followup* <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('followup_new', 'index')) { ?>
                                             <li><a href="<?php echo site_url('followup_new'); ?>">All Followup</a></li>
                                        <?php
                                        }
                                        /* if (check_permission('followup_new', 'running')) {
                   ?>
                            <li><a href="<?php echo site_url('followup_new/running');?>">Running
                                    <?php echo!empty($analytics['count_running_followup']) ? '<span class="label label-success pull-right">' . $analytics['count_running_followup'] . '</span>' : '';?></a>
                            </li>
                            <?php
                   } */
                                        if (check_permission('followup_new', 'missed')) { ?>
                                             <li><a href="<?php echo site_url('followup_new/missed'); ?>">Missed Followup
                                                       <?php $msdcnt = $this->session->userdata('follow_missed_count');
                                                       echo ($msdcnt > 0) ? '<span class="badge bg-red">' . $msdcnt . '</span>' : '';
                                                       ?>
                                                  </a></li>
                                        <?php }
                                        if (
                                             check_permission('followup_new', 'enquirypreference') ||
                                             check_permission('followup_new', 'enquirypreferencemyself') ||
                                             check_permission('followup_new', 'enquirypreferencemyteam') ||
                                             check_permission('followup_new', 'enquirypreferencemyshowroom')
                                        ) { ?>
                                             <li><a href="<?php echo site_url('followup_new/enquiryPreference'); ?>">Preferences</a></li>
                                        <?php }
                                        if (check_permission('followup_new', 'precurementrqstlist')) { ?>
                                             <li><a href="<?php echo site_url('followup_new/precurementRqstList'); ?>"> Procurement req
                                                       list
                                                  </a></li>
                                        <?php } ?>

                                        <?php if (check_permission('homevisit', 'hw_can_add_request')) { ?> <li><a href="<?php echo site_url('followup_new/home_visit'); ?>"> My home visit <?php } ?>
                                                  </a></li>
                                             <?php if (check_permission('homevisit', 'hw_all') or check_permission('homevisit', 'hw_smart_only') or check_permission('homevisit', 'hw_my_own') or check_permission('homevisit', 'hw_my_team') or check_permission('homevisit', 'hw_smart_purchase_only') or check_permission('homevisit', 'hw_smart_sales_only') or check_permission('homevisit', 'hw_my_shwroom') or check_permission('homevisit', 'hw_luxury_only') or check_permission('homevisit', 'hw_luxury_purchase_only') or check_permission('homevisit', 'hw_luxury_sales_only')) { ?>
                                                  <li><a href="<?php echo site_url('followup_new/home_visit_approval_req'); ?>"> Home visit
                                                            Approval Req.<?php } ?>
                                                       </a></li>


                                   </ul>
                              </li>
                         <?php
                         } ?>
                         <!--@followup_new-->


                         <?php if (can_access_module('purchase')) {
                         ?>
                              <li><a><i class="fa fa-road"></i> Purchase <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <li><a href="<?php echo site_url('purchase'); ?>"> List</a></li>
                                        <?php if (check_permission('purchase', 'approved_list')) { ?>
                                             <li><a href="<?php echo site_url('purchase/approved_list'); ?>">Approved List</a></li>
                                        <?php }
                                        if (check_permission('purchase', 'allPurchase')) { ?>
                                             <li><a href="<?php echo site_url('purchase/allPurchase'); ?>">All List</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php } ?>

                         <?php if (can_access_module('tracking')) {
                         ?>
                              <li><a><i class="fa fa-road"></i> Tracking <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <li><a href="<?php echo site_url('tracking/tracklist'); ?>">Vehicle Track List</a></li>
                                        <?php if (check_permission('tracking', 'out_pass')) { ?>
                                             <li><a href="<?php echo site_url('tracking/out_pass'); ?>">Gate Pass</a></li>
                                        <?php }
                                        if (check_permission('tracking', 'index')) { ?>
                                             <li><a href="<?php echo site_url('tracking'); ?>">Check In</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php }
                         if (can_access_module('lms')) { ?>
                              <li><a><i class="fa fa-bar-chart"></i> LMS <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('lms', 'list_funnel_master')) { ?>
                                             <li><a href="<?php echo site_url('lms/list_funnel_master'); ?>">List funnel Master</a></li>
                                        <?php }
                                        if (check_permission('lms', 'create_funnel_master')) { ?>
                                             <li><a href="<?php echo site_url('lms/create_funnel_master'); ?>">Create funnel Master</a>
                                             </li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('lms', 'list_campaign_master')) { ?>
                                             <li><a href="<?php echo site_url('lms/list_campaign_master'); ?>">List campaign master</a>
                                             </li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('lms', 'create_campaign_master')) { ?>
                                             <li><a href="<?php echo site_url('lms/create_campaign_master'); ?>">Create campaign
                                                       master</a></li>
                                        <?php } ?>

                                        <?php
                                        if (check_permission('lms', 'list_source_master')) { ?>
                                             <li><a href="<?php echo site_url('lms/list_source_master'); ?>">List source master</a></li>
                                        <?php } ?>

                                        <?php
                                        if (check_permission('lms', 'create_source_master')) { ?>
                                             <li><a href="<?php echo site_url('lms/create_source_master'); ?>">Create source master</a>
                                             </li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('lms', 'lmsreport')) { ?>
                                             <li><a href="<?php echo site_url('lms/lmsreport'); ?>">Lms Report</a></li>
                                        <?php } ?>


                                   </ul>
                              </li>
                         <?php }
                         if (can_access_module('insurance')) { ?>
                              <li><a><i class="fa fa-bar-chart"></i> Insurance <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('insurance', 'index')) { ?>
                                             <li><a href="<?php echo site_url('insurance/index'); ?>">Company Vehicles</a></li>
                                        <?php }
                                        if (check_permission('insurance', 'stockvehicle')) { ?>
                                             <li><a href="<?php echo site_url('insurance/stockVehicle'); ?>">Stock Vehicles</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php }
                         if (can_access_module('evaluation')) { ?>
                              <li><a><i class="fa fa-eye"></i> Evaluate <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('evaluation', 'index') || check_permission('evaluation', 'view')) { ?>
                                             <li><a href="<?php echo site_url('evaluation'); ?>">Vehicles</a></li>
                                        <?php }
                                        if (check_permission('evaluation', 'stock')) { ?>
                                             <li><a href="<?php echo site_url('evaluation/stock'); ?>">Stock Vehicles</a></li>
                                        <?php }
                                        if (check_permission('evaluation', 'add') && $this->uid == 354) { ?>
                                             <li><a href="<?php echo site_url('evaluation/add'); ?>">Evaluate Vehicles</a></li>
                                        <?php }
                                        if (check_permission('evaluation', 'pending')) { ?>
                                             <li><a href="<?php echo site_url('evaluation/pending'); ?>">Pending Evaluation</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         } ?>
                         <?php if (can_access_module('evaluation_new')) { // new evaluation_new 
                         ?>
                              <li><a><i class="fa fa-eye"></i> Evaluate* <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('evaluation_new', 'index')) { ?>
                                             <li><a href="<?php echo site_url('evaluation_new'); ?>">Stock Vehicles*</a></li>
                                        <?php
                                        }
                                        if (check_permission('evaluation_new', 'evaluated') || check_permission('evaluation_new', 'index')) {
                                             //check_permission('evaluation_new', 'index') for temparaty will remove in future.
                                        ?>
                                             <li><a href="<?php echo site_url('evaluation_new/evaluated'); ?>">Evaluated*</a></li>
                                        <?php }
                                        if (check_permission('evaluation_new', 'pending')) { ?>
                                             <li><a href="<?php echo site_url('evaluation_new/pending'); ?>">Pending Evaluation*</a></li>
                                        <?php }
                                        if (check_permission('evaluation_new', 'add')) { ?>
                                             <li><a href="<?php echo site_url('evaluation_new/add'); ?>">Create Evaluation*</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php } ?>
                         <?php if (can_access_module('reports')) {
                         ?>
                              <li><a><i class="fa fa-bar-chart"></i> Reports <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('reports', 'quickVehicleSearch')) { ?>
                                             <li><a href="<?php echo site_url('reports/quickVehicleSearch');
                                                            ?>">Quick Vehicle Search</a></li>
                                        <?php }
                                        if (check_permission('reports', 'duplicateEntry')) { ?>
                                             <!-- <li><a href="<?php //echo site_url('reports/duplicateEntry');
                                                                 ?>">Duplicate entry</a></li> -->
                                        <?php }
                                        if (check_permission('reports', 'enquiries')) { ?>
                                             <li><a href="<?php echo site_url('reports/enquiries'); ?>">Inquiries (Vehicle based)</a>
                                             </li>
                                        <?php }
                                        if (check_permission('reports', 'enquiries_enq')) { ?>
                                             <li><a href="<?php echo site_url('reports/enquiries_enq'); ?>">Inquiries (Inquiry based)</a>
                                             </li>
                                        <?php }
                                        /*if (check_permission('reports', 'closedEnquiries')) { ?>
                            <!-- <li><a href="<?php //echo site_url('reports/closedEnquiries'); ?>">Closed Enquiries</a></li> -->
                            <?php }*/
                                        if (check_permission('reports', 'droppedEnquiries')) { ?>
                                             <li><a href="<?php echo site_url('reports/droppedEnquiries'); ?>">Dropped Enquiries</a></li>
                                        <?php }
                                        if (check_permission('reports', 'loosedenquiries')) { ?>
                                             <li><a href="<?php echo site_url('reports/loosedenquiries'); ?>">Lost Enquiries</a></li>
                                        <?php }
                                        if (check_permission('reports', 'bookedenquiries')) { ?>
                                             <li><a href="<?php echo site_url('reports/bookedenquiries'); ?>">Booked Enquiries</a></li>
                                        <?php }
                                        if (check_permission('reports', 'dar')) { ?>
                                             <li><a href="<?php echo site_url('reports/dar'); ?>">DAR</a></li>
                                        <?php }
                                        if (check_permission('reports', 'pool')) { ?>
                                             <li><a href="<?php echo site_url('reports/pool'); ?>">Enquires pool</a></li>
                                        <?php }
                                        if (check_permission('reports', 'homevisit')) { ?>
                                             <li><a href="<?php echo site_url('reports/homevisit'); ?>">Home visit Report</a></li>
                                        <?php }
                                        if (check_permission('reports', 'bookedenquires')) { ?>
                                             <!-- <li><a href="<?php //echo site_url('reports/bookedEnquires');
                                                                 ?>">Booked Enquires</a></li> -->
                                        <?php }
                                        if (check_permission('reports', 'voxbaydailyreport')) { ?>
                                             <li><a href="<?php echo site_url('reports/voxbayDailyReport'); ?>">Voxbay daily report</a>
                                             </li>
                                        <?php }
                                        if (check_permission('reports', 'quickenquiryfedBack')) { ?>
                                             <li><a href="<?php echo site_url('reports/quickEnquiryFedBack'); ?>">Quick followup
                                                       report</a></li>
                                        <?php }
                                        if (check_permission('reports', 'voxbaypunchreprt')) { ?>
                                             <li><a href="<?php echo site_url('reports/voxbayPunchReprt'); ?>">Voxbay punch report</a>
                                             </li>
                                        <?php }
                                        if (check_permission('reports', 'telcalrperformancereport')) { ?>
                                             <li><a href="<?php echo site_url('reports/telcalrperformancereport'); ?>">Telecaller
                                                       performance report</a></li>
                                        <?php }
                                        if (check_permission('reports', 'registerpendingreport')) { ?>
                                             <li><a href="<?php echo site_url('reports/registerPendingReport'); ?>">Register pending
                                                       report</a></li>
                                        <?php }
                                        if (check_permission('reports', 'logreport')) { ?>
                                             <li><a href="<?php echo site_url('reports/logreport'); ?>">Log report</a></li>
                                        <?php }
                                        if (check_permission('reports', 'enquiry_pool_list')) { ?>
                                             <li><a href="<?php echo site_url('reports/enquiry_pool_list'); ?>">Vehicle demand report</a>
                                             </li>
                                        <?php }
                                        if (check_permission('reports', 'stockagainstvehicle')) { ?>
                                             <li><a href="<?php echo site_url('reports/stockagainstvehicle'); ?>">Stock against
                                                       enquiry</a></li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'price_list')) { ?>
                                             <li><a href="<?php echo site_url('reports/price_list'); ?>">Price list*</a></li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'stock_status_summary')) { ?>
                                             <li><a href="<?php echo site_url('reports/stock_status_summary'); ?>">Stock status
                                                       summary*</a></li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'stock_report')) { ?>
                                             <li><a href="<?php echo site_url('reports/stock_report'); ?>">Stock report*</a></li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'booked_stock_report')) { ?>
                                             <li><a href="<?php echo site_url('reports/booked_stock_report'); ?>">Booked stock
                                                       report*</a></li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'purchase_report')) { ?>
                                             <li><a href="<?php echo site_url('reports/purchase_report'); ?>">Purchase report*</a></li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'sales_report')) { ?>
                                             <li><a href="<?php echo site_url('reports/sales_report'); ?>">Sales report*</a></li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'summary_enq')) { ?>
                                             <li><a href="<?php echo site_url('reports/summary_enq'); ?>">Sales summary enq*</a></li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'sales_data_bank')) { ?>
                                             <li><a href="<?php echo site_url('reports/sales_data_bank'); ?>">Sales data bank*</a></li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'purchase_new_live_enqs')) { ?>
                                             <li><a href="<?php echo site_url('reports/purchase_new_live_enqs'); ?>">Purchase
                                                       report.*</a></li>
                                        <?php } ?>

                                        <?php
                                        if (check_permission('reports', 'daily_sales_report')) { ?>
                                             <li><a><i class="fa fa-pie-chart"></i> Daily sales report<span class="fa fa-chevron-down"></span></a>
                                                  <ul class="nav child_menu">
                                                       <li><a href="<?php echo site_url('reports/daily_sales_report'); ?>"> WOMM
                                                                 <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                                       <li><a href="<?php echo site_url('reports/sales_day_wise_report'); ?>"> DOMM
                                                                 <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                                  </ul>
                                             </li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'daily_purchase_report')) { ?>
                                             <li><a><i class="fa fa-pie-chart"></i> Daily purchase report<span class="fa fa-chevron-down"></span></a>
                                                  <ul class="nav child_menu">
                                                       <li><a href="<?php echo site_url('reports/daily_purchase_report'); ?>"> WOMM
                                                                 <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                                       <li><a href="<?php echo site_url('reports/purhase_day_wise_report'); ?>"> DOMM
                                                                 <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                                  </ul>
                                             </li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'enq_model_wise_analysis')) { ?>
                                             <li><a href="<?php echo site_url('reports/enq_model_wise_analysis'); ?>">Sl Enq Model Wise
                                                       Analysis*</a></li>
                                        <?php } ?>
                                        <?php
                                        if (check_permission('reports', 'summary_enq_purchase')) { ?>
                                             <li><a href="<?php echo site_url('reports/summary_enq_purchase'); ?>">Purchase Summary*</a>
                                             </li>
                                        <?php } ?>

                                        <?php
                                        if (check_permission('reports', 'detailed_walk_in_report')) { ?>
                                             <li><a href="<?php echo site_url('reports/detailed_walk_in_report'); ?>">Walk-in Report*</a>
                                             </li>
                                        <?php } ?>

                                        <?php
                                        if (check_permission('reports', 'checklist')) { ?>
                                             <li><a href="<?php echo site_url('reports/checklist'); ?>">Purchase Checklist</a>
                                             </li>
                                        <?php }
                                        if (check_permission('enquiry', 'poolbatch')) { ?>
                                             <li><a href="<?php echo site_url('enquiry/poolbatch'); ?>">Enquiry pool batch</a></li>
                                        <?php }
                                        if (check_permission('reports', 'customercomplaints')) { ?>
                                             <li><a href="<?php echo site_url('reports/customercomplaints'); ?>">Customer Complaints</a>
                                             </li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         } ?>
                         <?php //reprort new
                         if (can_access_module('reports_1')) { ?>
                              <li><a><i class="fa fa-bar-chart"></i> Reports * <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('reports_1', 'quickVehicleSearch')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/quickVehicleSearch'); ?>">Quick Vehicle
                                                       Search</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'duplicateEntry')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/duplicateEntry'); ?>">Duplicate entry</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'enquiries')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/enquiries'); ?>">Inquiries (Vehicle based)</a>
                                             </li>
                                        <?php }
                                        if (check_permission('reports_1', 'enquiries_enq')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/enquiries_enq'); ?>">Inquiries (Inquiry
                                                       based)</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'closedEnquiries')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/closedEnquiries'); ?>">Closed Enquiries</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'droppedEnquiries')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/droppedEnquiries'); ?>">Dropped Enquiries</a>
                                             </li>
                                        <?php }
                                        if (check_permission('reports_1', 'deletedenquiries')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/deletedEnquiries'); ?>">Deleted Enquiries</a>
                                             </li>
                                        <?php }
                                        if (check_permission('reports_1', 'loosedenquiries')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/loosedenquiries'); ?>">Lost Enquiries</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'bookedenquiries')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/bookedenquiries'); ?>">Booked Enquiries</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'deliveredvehicles')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/deliveredvehicles'); ?>">Delivered vehicles</a>
                                             </li>
                                        <?php }
                                        if (check_permission('booking', 'bookingcancelled')) { ?>
                                             <li><a href="<?php echo site_url('booking/bookingCancelled'); ?>">Cancelled vehicles</a>
                                             </li>
                                        <?php }
                                        if (check_permission('reports_1', 'dar')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/dar'); ?>">DAR</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'homevisitneeded')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/homeVisitNeeded'); ?>">Home Visit Needed</a>
                                             </li>
                                        <?php }
                                        if (check_permission('reports_1', 'bookedenquires')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/bookedEnquires'); ?>">Booked Enquires</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'voxbaydailyreport')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/voxbayDailyReport'); ?>">Voxbay daily report</a>
                                             </li>
                                        <?php }
                                        if (check_permission('reports_1', 'quickenquiryfedBack')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/quickEnquiryFedBack'); ?>">Quick followup
                                                       report</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'voxbaypunchreprt')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/voxbayPunchReprt'); ?>">Voxbay punch report</a>
                                             </li>
                                        <?php }
                                        if (check_permission('reports_1', 'telcalrperformancereport')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/telcalrperformancereport'); ?>">Telecaller
                                                       performance report</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'logreport')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/logreport'); ?>">Log report</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'enquiry_pool')) { ?>
                                             <li><a href="<?php echo site_url('reports_1/enquiry_pool_list'); ?>">Enquiry pool</a></li>
                                        <?php }
                                        if (check_permission('reports_1', 'logreport')) { ?>
                                             <li><a href="<?php echo site_url('enquiry/purchase_enq_list'); ?>">Purchase Enq list
                                                  </a></li>
                                        <?php } ?>
                                        <li><a href="<?php echo site_url('reports_1/stock_status_summary'); ?>">Stock status summary
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                        <li><a href="<?php echo site_url('reports_1/stock_report'); ?>">Stock Report
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                        <li><a href="<?php echo site_url('reports_1/booked_stock_report'); ?>">Booked Stock Report
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                        <li><a href="<?php echo site_url('reports_1/purchase_report'); ?>">Purchase Report
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                        <li><a href="<?php echo site_url('reports_1/sales_report'); ?>">Sales Report
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                        <li><a href="<?php echo site_url('reports_1/summary_enq'); ?>">Sales Summary Enq
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                        <li><a href="<?php echo site_url('reports_1/sales_data_bank'); ?>">Sales data bank
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                        <li><a href="<?php echo site_url('reports_1/purchase_new_live_enqs'); ?>">Purchase report.
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                        <li><a><i class="fa fa-pie-chart"></i> Daily sales report<span class="fa fa-chevron-down"></span></a>
                                             <ul class="nav child_menu">
                                                  <li><a href="<?php echo site_url('reports_1/daily_sales_report'); ?>"> WOMM
                                                            <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                                  <li><a href="<?php echo site_url('reports_1/sales_day_wise_report'); ?>"> DOMM
                                                            <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                             </ul>
                                        </li>
                                        <li><a><i class="fa fa-pie-chart"></i> Daily purchase report<span class="fa fa-chevron-down"></span></a>
                                             <ul class="nav child_menu">
                                                  <li><a href="<?php echo site_url('reports_1/daily_purchase_report'); ?>"> WOMM
                                                            <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                                  <li><a href="<?php echo site_url('reports_1/purhase_day_wise_report'); ?>"> DOMM
                                                            <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                             </ul>
                                        </li>
                                        <li><a href="<?php echo site_url('reports_1/enq_model_wise_analysis'); ?>">Sl Enq Model Wise
                                                  Analysis
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                        <li><a href="<?php echo site_url('reports_1/summary_enq_purchase'); ?>">Purchase Summary
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>
                                        <li><a href="<?php echo site_url('reports_1/detailed_walk_in_report'); ?>">Walk-in Report
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>

                                        <li><a href="<?php echo site_url('reports_1/price_list'); ?>">Price list
                                                  <span class="glyphicon glyphicon-asterisk	
"></span></a></li>

                                   </ul>
                              </li>
                         <?php } //reprort new 
                         ?>
                         <?php
                         if (can_access_module('emp_details') || can_access_module('user_permission') || can_access_module('designation')) { ?>
                              <li><a><i class="fa fa-users"></i> Staff Details <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('emp_details', 'index') || check_permission('emp_details', 'view')) { ?>
                                             <li><a href="<?php echo site_url('emp_details'); ?>">Staff List</a></li>
                                        <?php }
                                        if (check_permission('emp_details', 'add')) { ?>
                                             <li><a href="<?php echo site_url('emp_details/add'); ?>">New Appointment</a></li>
                                        <?php }
                                        if (check_permission('user_permission', '') && (is_roo_user())) { ?>
                                             <li><a href="<?php echo site_url('user_permission'); ?>">Staff Permission</a></li>
                                        <?php }
                                        if (check_permission('emp_details', 'newstaffrequest')) { ?>
                                             <li><a href="<?php echo site_url('emp_details/newstaffrequest'); ?>">Staff Master</a></li>
                                        <?php }
                                        if (can_access_module('designation')) { ?>
                                             <li><a href="<?php echo site_url('designation'); ?>">Designation</a></li>
                                        <?php } ?>
                                        <?php if (check_permission('user_permission', '') && (is_roo_user())) { ?>
                                             <li><a href="<?php echo site_url('user_permission/create_role'); ?>">Create Role*</a></li>
                                        <?php } ?>
                                        <?php if (check_permission('user_permission', '') && (is_roo_user())) { ?>
                                             <li><a href="<?php echo site_url('user_permission/edit_role'); ?>">Edit Role*</a></li>
                                        <?php } ?>
                                        <?php if (check_permission('emp_details', 'staff_target')) { ?>
                                             <li><a href="<?php echo site_url('emp_details/staff_target/1'); ?>">Sales&purchase
                                                       target</a>
                                             </li>
                                             <li><a href="<?php echo site_url('emp_details/staff_target/2'); ?>">Valuation target</a>
                                             </li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (can_access_module('brand')) {
                         ?>
                              <li><a><i class="fa fa-cab"></i> Brand <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('brand', 'index') || check_permission('brand', 'view')) { ?>
                                             <li><a href="<?php echo site_url('brand'); ?>">List</a></li>
                                        <?php }
                                        if (check_permission('brand', 'add')) { ?>
                                             <li><a href="<?php echo site_url('brand/add'); ?>">New Brand</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (can_access_module('model')) {
                         ?>
                              <li><a><i class="fa fa-cab"></i> Model <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php
                                        if (
                                             check_permission('model', 'index') ||
                                             check_permission('model', 'view')
                                        ) {
                                        ?>
                                             <li><a href="<?php echo site_url('model'); ?>">List</a></li>
                                        <?php }
                                        if (check_permission('model', 'add')) { ?>
                                             <li><a href="<?php echo site_url('model/add'); ?>">New Model</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (can_access_module('veh_variant')) {
                         ?>
                              <li><a><i class="fa fa-cab"></i> Variant <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php
                                        if (
                                             check_permission('veh_variant', 'index') ||
                                             check_permission('veh_variant', 'view')
                                        ) {
                                        ?>
                                             <li><a href="<?php echo site_url('veh_variant'); ?>">List</a></li>
                                        <?php }
                                        if (check_permission('veh_variant', 'add')) { ?>
                                             <li><a href="<?php echo site_url('veh_variant/add'); ?>">New Variant</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (can_access_module('accessories')) {
                         ?>
                              <li><a><i class="fa fa-wrench"></i> Accessories <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php
                                        if (
                                             check_permission('accessories', 'index') ||
                                             check_permission('accessories', 'view')
                                        ) {
                                        ?>
                                             <li><a href="<?php echo site_url('accessories'); ?>">List</a></li>
                                        <?php }
                                        if (check_permission('accessories', 'add')) { ?>
                                             <li><a href="<?php echo site_url('accessories/add'); ?>">New Accessories</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (can_access_module('product')) {
                         ?>
                              <li><a><i class="fa fa-bus"></i> Website Vehicle <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('product', 'index') || check_permission('product', 'view')) { ?>
                                             <li><a href="<?php echo site_url('product'); ?>">List</a></li>
                                        <?php }
                                        if (check_permission('product', 'upldphotostockvehicle')) { ?>
                                             <li><a href="<?php echo site_url('product/upldphotostockvehicle'); ?>">Update stock
                                                       images</a></li>
                                        <?php }
                                        if (check_permission('product', 'createnew')) { ?>
                                             <li><a href="<?php echo site_url('product/createnew'); ?>">New Vehicle</a></li>
                                        <?php } //createnew
                                        ?>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (can_access_module('careers')) {
                         ?>
                              <li><a><i class="fa fa-graduation-cap"></i>Careers<span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('careers', 'index') || check_permission('careers', 'view')) { ?>
                                             <li><a href="<?php echo site_url('careers'); ?>">List</a></li>
                                        <?php }
                                        if (check_permission('careers', 'add')) { ?>
                                             <li><a href="<?php echo site_url('careers/add'); ?>">New Vacancies</a></li>
                                        <?php }
                                        if (check_permission('careers', 'application')) { ?>
                                             <li><a href="<?php echo site_url('careers/application'); ?>">Application</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (can_access_module('blog')) {
                         ?>
                              <li><a><i class="fa fa-camera-retro"></i>Blog<span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php
                                        if (
                                             check_permission('blog', 'index') ||
                                             check_permission('blog', 'view')
                                        ) {
                                        ?>
                                             <li><a href="<?php echo site_url('blog'); ?>">List</a></li>
                                        <?php }
                                        if (check_permission('blog', 'add')) { ?>
                                             <li><a href="<?php echo site_url('blog/add'); ?>">New Blog</a></li>
                                        <?php } ?>
                                        <li><a href="<?php echo site_url('blog/category'); ?>">Category</a></li>
                                        <li><a href="<?php echo site_url('blog/newCategory'); ?>">New Category</a></li>

                                        <li><a href="<?php echo site_url('blog/tags'); ?>">Tags</a></li>
                                        <li><a href="<?php echo site_url('blog/newTag'); ?>">New Tag</a></li>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (can_access_module('manage_banner')) {
                         ?>
                              <li>
                                   <a><i class="fa fa-picture-o"></i> Manage banner <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('manage_banner', 'index')) { ?>
                                             <li><a href="<?php echo site_url('manage_banner/add'); ?>">New banner</a></li>
                                        <?php }
                                        if (check_permission('manage_banner', 'index')) { ?>
                                             <li><a href="<?php echo site_url('manage_banner'); ?>">List</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (can_access_module('events')) {
                         ?>
                              <li>
                                   <a><i class="fa fa-flag-checkered"></i> Events <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('events', 'index')) { ?>
                                             <li><a href="<?php echo site_url('events/add'); ?>">New event</a></li>
                                        <?php }
                                        if (check_permission('events', 'index')) { ?>
                                             <li><a href="<?php echo site_url('events'); ?>">List</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (can_access_module('registration')) {
                         ?>
                              <li>
                                   <a><i class="fa fa fa-bookmark"></i> Register <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('registration', 'add')) { ?>
                                             <li><a href="<?php echo site_url('registration/add'); ?>">New registration</a></li>
                                        <?php }
                                        if (check_permission('registration', 'index')) { ?>
                                             <li><a href="<?php echo site_url('registration'); ?>">List</a></li>
                                        <?php }
                                        if (check_permission('registration', 'waitingforreply')) { ?>
                                             <li><a href="<?php echo site_url('registration/waitingforreply/'); ?>">Waiting for reply</a>
                                             </li>
                                        <?php }
                                        if (check_permission('registration', 'informstocktocustomer')) { ?>
                                             <li><a href="<?php echo site_url('registration/informStockToCustomer'); ?>">Stock matching
                                                       register</a></li>
                                        <?php }
                                        if (check_permission('registration', 'reassignedregisters')) { ?>
                                             <li><a href="<?php echo site_url('registration/reassignedregisters'); ?>">Reassigned
                                                       registers</a></li>
                                        <?php }
                                        if (check_permission('registration', 'droppedregisters')) { ?>
                                             <li><a href="<?php echo site_url('registration/droppedregisters'); ?>">Dropped registers</a>
                                             </li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (can_access_module('questions')) {
                         ?>
                              <li>
                                   <a><i class="fa fa fa-question"></i> Questions <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('questions', 'add')) { ?>
                                             <li><a href="<?php echo site_url('questions/add'); ?>">New questions</a></li>
                                        <?php }
                                        if (check_permission('questions', 'index')) { ?>
                                             <li><a href="<?php echo site_url('questions'); ?>">List</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php
                         }
                         if (
                              can_access_module('tools') || can_access_module('divisions') || can_access_module('color') ||
                              can_access_module('showroom') || can_access_module('departments') || can_access_module('dbcall')
                         ) {
                         ?>
                              <li>
                                   <a><i class="fa fa fa-spinner"></i> Tools <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('tools', 'sendWhatsAppMessage')) { ?>
                                             <li><a href="<?php echo site_url('tools/sendWhatsAppMessage'); ?>">Send WhatsApp Message</a>
                                             </li>
                                        <?php }
                                        if (check_permission('tools', 'sendBulkSms')) { ?>
                                             <li><a href="<?php echo site_url('tools/sendBulkSms'); ?>">Send Bulk SMS</a></li>
                                        <?php }
                                        if (can_access_module('divisions')) { ?>
                                             <li><a href="<?php echo site_url('divisions'); ?>">Divisions</a></li>
                                        <?php }
                                        if (can_access_module('showroom')) { ?>
                                             <li><a href="<?php echo site_url('showroom'); ?>">Showroom</a></li>
                                        <?php }
                                        if (can_access_module('departments')) { ?>
                                             <li><a href="<?php echo site_url('departments'); ?>">Departments</a></li>
                                        <?php }
                                        if (can_access_module('grade')) { ?>
                                             <li><a href="<?php echo site_url('grade'); ?>">Grade</a></li>
                                        <?php }
                                        if (can_access_module('dbcall')) { ?>
                                             <li><a href="<?php echo site_url('dbcall'); ?>">Data call list</a></li>
                                        <?php }
                                        if (can_access_module('color')) { ?>
                                             <li><a href="<?php echo site_url('color'); ?>">Vehicle Color</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php }
                         if (is_roo_user()) { ?>
                              <!-- <li>
                                     <a><i class="fa fa fa-spinner"></i> Payroll <span class="fa fa-chevron-down"></span></a>
                                     <ul class="nav child_menu">
                                          <li><a href="<?php //echo site_url('payroll/compose_leave');
                                                       ?>">Apply for leave</a></li>
                                     </ul>
                                </li> -->
                         <?php }
                         if (can_access_module('voxbay')) { ?>
                              <li>
                                   <a><i class="fa fa fa-phone"></i> Voxbay <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('voxbay', 'index')) { ?>
                                             <li><a href="<?php echo site_url('voxbay/index'); ?>">Voxbay call list</a></li>
                                        <?php }
                                        if (check_permission('voxbay', 'pendingcalls')) { ?>
                                             <li><a href="<?php echo site_url('voxbay/pendingCalls'); ?>">Voxbay pending list</a></li>
                                        <?php }
                                        if (check_permission('voxbay', 'allconnectedcall')) { ?>
                                             <li><a href="<?php echo site_url('voxbay/allconnectedcall'); ?>">All connected call</a></li>
                                        <?php }
                                        if (check_permission('voxbay', 'investmentcallonly')) { ?>
                                             <li><a href="<?php echo site_url('voxbay/invCallList'); ?>">Investment call</a></li>
                                        <?php }
                                        if (check_permission('voxbay', 'allconnectedincall')) { ?>
                                             <li><a href="<?php echo site_url('voxbay/allconnectedincall'); ?>">All inbount call</a></li>
                                        <?php }
                                        if (check_permission('voxbay', 'allconnectedoutcall')) { ?>
                                             <li><a href="<?php echo site_url('voxbay/allconnectedoutcall'); ?>">All outbound call</a>
                                             </li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php }
                         if (can_access_module('seo')) { ?>
                              <li>
                                   <a><i class="fa fa fa-globe"></i> SEO <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('seo', 'index')) { ?>
                                             <li><a href="<?php echo site_url('seo/index'); ?>">Page settings</a></li>
                                        <?php }
                                        if (check_permission('seo', 'index')) { ?>
                                             <li><a href="<?php echo site_url('seo/listpagecms'); ?>">Manage content</a></li>
                                        <?php }
                                        if (check_permission('seo', 'producttitle')) { ?>
                                             <li><a href="<?php echo site_url('seo/productTitle'); ?>">Manage product content</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php }
                         if ($this->usr_grp != 'SEO') { ?>
                              <li>
                                   <a><i class="fa fa-users"></i> HR <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <li><a href="<?php echo site_url('rdpolicy'); ?>">RD Policies</a></li>
                                        <?php if (check_permission('rdpolicy', 'create')) { ?>
                                             <li><a href="<?php echo site_url('rdpolicy/create'); ?>">Create Policies</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php }
                         if (can_access_module('datatable')) { ?>
                              <li>
                                   <a><i class="fa fa fa-database"></i> Data table <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('datatable', 'index')) { ?>
                                             <li><a href="<?php echo site_url('datatable/index'); ?>">Data table</a></li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php }
                         if (can_access_module('analytics')) { ?>
                              <li>
                                   <a><i class="fa fa-pie-chart"></i> Analytics <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <?php if (check_permission('analytics', 'enquirydroppedpulse')) { ?>
                                             <li><a href="<?php echo site_url('analytics/enquirydroppedpulse'); ?>">Dropped cases</a>
                                             </li>
                                        <?php } ?>
                                   </ul>
                              </li>
                         <?php }
                         if (can_access_module('mou')) { ?>
                              <li>
                                   <a><i class="fa fa fa-pencil"></i> MOU<span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu">
                                        <li><a href="<?php echo site_url('mou'); ?>">MOU</a></li>
                                   </ul>
                              </li>
                         <?php } ?>
                    </ul>
               </div>
          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
               <a data-toggle="tooltip" data-placement="top" title="Settings" href="<?php echo is_roo_user() ? site_url('settings/general_settings') : 'javascript:;'; ?>">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
               </a>
               <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                    <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
               </a>
               <a data-toggle="tooltip" data-placement="top" title="Lock">
                    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
               </a>
               <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo site_url('user/logout'); ?>">
                    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
               </a>
          </div>
          <!-- /menu footer buttons -->
     </div>
</div>

<!-- top navigation -->
<div class="top_nav">
     <div class="nav_menu">
          <nav>
               <div class="nav toggle" style="width: 50%;float: left;">
                    <a id="menu_toggle" style="padding: 0px 15px 0;float: left;"><i class="fa fa-bars"></i></a>
                    <?php
                    $downloadLink = get_logged_user('usr_appdownloadlink');
                    if (!empty($downloadLink)) {
                    ?>
                         <a data-url="<?php echo $downloadLink; ?>" class="cpytoclip" id="menu_toggle" style="cursor: pointer; padding: 0px 15px 0;float: right;">
                              <img style="width: 21px;" src="images/download.png" />
                         </a>
                    <?php }
                    if (check_permission('enquiry', 'quickfollowup')) { ?>
                         <a title="Quick followup enquiries" href="<?php echo site_url('enquiry/quickfollowup'); ?>" id="menu_toggle" style="cursor: pointer; padding: 0px 15px 0;float: right;">
                              <img style="width: 21px;" src="images/quick-follow.png" />
                         </a>
                    <?php }
                    if (check_permission('webenquires', 'index')) { ?>
                         <a title="Web enquiries for sales" href="<?php echo site_url('webenquires'); ?>" id="menu_toggle" style="cursor: pointer; padding: 0px 15px 0;float: right;">
                              <img style="width: 21px;" src="images/web-inq.png" />
                         </a>
                    <?php }
                    if (check_permission('dbcall', 'index')) { ?>
                         <a title="External database enquiries" href="<?php echo site_url('dbcall'); ?>" id="menu_toggle" style="cursor: pointer; padding: 0px 15px 0;float: right;">
                              <i style="font-size : 20px" class="fa fa-database"></i>
                         </a>
                    <?php }
                    if (check_permission('webenquires', 'purchase_enq')) { ?>
                         <a title="Web enquiries for purchase" href="<?php echo site_url('webenquires/purchase_enq'); ?>" id="menu_toggle" style="cursor: pointer; padding: 0px 15px 0;float: right;">
                              <i style="font-size : 23px" class="fa fa-lightbulb-o"></i>
                         </a>
                    <?php }
                    if (check_permission('registration', 'eventlistener')) { ?>
                         <a title="Event enquiries" href="<?php echo site_url('registration/eventlistener'); ?>" id="menu_toggle" style="cursor: pointer; padding: 0px 15px 0;float: right;">
                              <i style="font-size: 20px" class="fa fa-calendar"></i>
                         </a>
                    <?php } ?>
                    <!-- Clock -->
                    <div class="clock" style="width: 100%;">
                         <div id="Date" style="float: left;margin-right: 10px;"></div>
                         <ul style="float: left;">
                              <li id="hours"> </li>
                              <li id="point">:</li>
                              <li id="min"> </li>
                              <li id="point">:</li>
                              <li id="sec"> </li>
                         </ul>
                    </div>
                    <!-- -->
               </div>

               <ul class="nav navbar-nav navbar-right" style="width: 50%;">
                    <li class="">
                         <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              <?php
                              echo img(array('src' => 'assets/uploads/avatar/' . $this->session->userdata('usr_avatar')));
                              echo $this->session->userdata('usr_username');
                              ?>
                              <span class=" fa fa-angle-down"></span>
                         </a>
                         <ul class="dropdown-menu dropdown-usermenu pull-right">
                              <li><a href="<?php echo site_url('emp_details/updateProfile/' . encryptor($this->uid)); ?>">
                                        Profile</a></li>
                              <!-- <li>
                                   <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                   </a>
                              </li> -->
                              <?php if ($this->uid == 1) { ?>
                                   <li><a href="<?php echo site_url('help'); ?>">Help</a></li>
                              <?php } ?>
                              <li><a href="<?php echo site_url('user/logout'); ?>"><i class="fa fa-sign-out pull-right"></i>
                                        Log Out</a></li>
                         </ul>
                    </li>
                    <?php if (check_permission('registration', 'add')) { ?>
                         <li role="presentation" class="dropdown" style="float: left;">
                              <a title="Quick Vehicle register" href="<?php echo site_url('registration/add'); ?>" class="dropdown-toggle info-number">
                                   <i class="fa fa-car"></i>
                                   <span class="badge bg-green"></span>
                              </a>
                         </li>
                         <?php
                    }

                    /*$recentEnquires = $this->common_model->recentEnquiry();
                        if (!empty($recentEnquires)) {
                        ?>
                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green"><?php echo count($recentEnquires);?></span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu"
                        style="height: 233px;overflow-y: scroll;">
                        <?php
                        foreach ((array) $recentEnquires as $key => $enq) {
                        ?>
                        <li>
                            <a href="<?php echo site_url('enquiry/view/' . encryptor($enq['enq_id']));?>">
                                <span><?php echo $enq['enq_cus_name'];?></span>
                            </a>
                            <span class="message">
                                <a href="<?php echo site_url('enquiry/view/' . encryptor($enq['enq_id']));?>">Added By :
                                    <?php echo $enq['enq_added_by_name'];?></a>
                            </span>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
                        } */
                    if (check_permission('notification', 'upcommingfollowup') && $this->uid != 100) {
                         $todaysFollowups = $this->common_model->todaysFollowups();
                         if (!empty($todaysFollowups)) {
                         ?>
                              <li role="presentation" class="dropdown">
                                   <a title="Upcomming followup" href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-bullhorn"></i>
                                        <span class="badge bg-green"><?php echo count($todaysFollowups); ?></span>
                                   </a>
                                   <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu" style="height: 233px;overflow-y: scroll;">
                                        <?php
                                        foreach ((array) $todaysFollowups as $key => $enq) {
                                             $type = $enq['enq_cus_status'] == 1 ? 's' : 'b';
                                        ?>
                                             <li>
                                                  <a href="<?php echo site_url('followup/viewFollowup/' . encryptor($enq['enq_id']) . '/' . encryptor($enq['veh_id']) . '/' . $type); ?>">
                                                       <span><?php echo $enq['enq_cus_name']; ?></span>
                                                  </a>
                                                  <span class="message">
                                                       <a href="<?php echo site_url('followup/viewFollowup/' . encryptor($enq['enq_id']) . '/' . encryptor($enq['veh_id']) . '/' . $type); ?>">
                                                            <?php echo $enq['brd_title'] . ', ' . $enq['mod_title'] . ', ' . $enq['var_variant_name']; ?></a>
                                                  </span>
                                             </li>
                                        <?php
                                        }
                                        ?>
                                        <!--                                     <li>
                                                                                    <div class="text-center">
                                                                                         <a>
                                                                                              <strong>See All Alerts</strong>
                                                                                              <i class="fa fa-angle-right"></i>
                                                                                         </a>
                                                                                    </div>
                                                                               </li>-->
                                   </ul>
                              </li>
                         <?php
                         }
                    }
                    if ($this->usr_grp != 'TC' && $this->uid != 878) {
                         $TLDARforApproval = $this->common_model->TLDARforApproval();
                         if (!empty($TLDARforApproval)) {
                         ?>
                              <li role="presentation" class="dropdown">
                                   <!-- <a title="Pending DAR verification" href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-book"></i>
                                        <span class="badge bg-green"><?php //echo count($TLDARforApproval); 
                                                                      ?></span>
                                   </a> -->
                                   <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu" style="height: 233px;overflow-y: scroll;">
                                        <?php
                                        /* foreach ((array) $TLDARforApproval as $key => $enq) {
                                            ?>
                        <li>
                            <a href="<?php echo site_url('dar/verifydar/' . encryptor($enq['darm_id']));?>">
                                <span><?php echo $enq['ab_usr_username'];?></span>
                            </a>
                            <span class="message">
                                <a href="<?php echo site_url('dar/verifydar/' . encryptor($enq['darm_id']));?>">Submitted
                                    on : <?php echo date('j M Y', strtotime($enq['darm_added_on']));?></a>
                            </span>
                        </li>
                        <?php
                                            } */
                                        ?>
                                        <!--                                     <li>
                                                                                    <div class="text-center">
                                                                                         <a>
                                                                                              <strong>See All Alerts</strong>
                                                                                              <i class="fa fa-angle-right"></i>
                                                                                         </a>
                                                                                    </div>
                                                                               </li>-->
                                   </ul>
                              </li>
                         <?php
                         }
                    }
                    if (check_permission('registration', 'approvereopenedinquires') || is_roo_user()) {
                         $pendingApprovalRegisterEnquiry = $this->common_model->pendingRegisterApproval();
                         if (!empty($pendingApprovalRegisterEnquiry)) {
                         ?>
                              <li role="presentation" class="dropdown">
                                   <a title="Pending rescheduled inquires" href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-arrow-circle-o-down"></i>
                                        <span class="badge bg-green"><?php echo count($pendingApprovalRegisterEnquiry); ?></span>
                                   </a>
                                   <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu" style="height: 233px;overflow-y: scroll;">
                                        <?php
                                        foreach ((array) $pendingApprovalRegisterEnquiry as $key => $enq) {
                                        ?>
                                             <li>
                                                  <a href="<?php echo site_url('registration/approveReopenedInquires/' . encryptor($enq['vreg_id'])); ?>">
                                                       <span><?php echo $enq['vreg_cust_name'] . ' ' . $enq['vreg_cust_phone']; ?></span>
                                                  </a>
                                             </li>
                                        <?php
                                        }
                                        ?>
                                   </ul>
                              </li>
                         <?php
                         }
                    }
                    /*if (check_permission('customer_grade', 'custgrdpendingnotification')) {
                           $pendingNotification = array();//$this->common_model->pendingCustGradeNotification();
                           if (!empty($pendingNotification)) {
                                ?>
                <li role="presentation" class="dropdown">
                    <a title="Pending customer grade verification" href="javascript:;"
                        class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-star"></i>
                        <span class="badge bg-green"><?php echo count($pendingNotification);?></span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu"
                        style="height: 233px;overflow-y: scroll;">
                        <?php
                                          foreach ((array) $pendingNotification as $key => $enq) {
                                               ?>
                        <li>
                            <a
                                href="<?php echo site_url('customer_grade/verificationView/' . encryptor($enq['enq_id']));?>">
                                <span><?php echo $enq['enq_cus_name'] . ' ' . $enq['sgrd_grade'];?></span>
                            </a>
                        </li>
                        <?php
                                          }
                                          ?>
                    </ul>
                </li>
                <?php
                           }
                      }*/
                    if (check_permission('followup', 'pendingprecurementnotification_notify')) {
                         $precrmntNotification = $this->common_model->pendingPrecurementNotification();
                         if (!empty($precrmntNotification)) {
                         ?>
                              <li role="presentation" class="dropdown">
                                   <a title="Procurement list" href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <span class="glyphicon glyphicon-tags"></span>
                                        <span class="badge bg-green"> <?php echo count($precrmntNotification); ?></span>
                                   </a>
                                   <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu" style="height: 233px;overflow-y: scroll;">
                                        <?php
                                        foreach ((array) $precrmntNotification as $key => $enq) {
                                             $vehData = $this->common_model->getVehicleName($enq['proc_brand'], $enq['proc_model'], $enq['proc_variant']);
                                        ?>
                                             <li>
                                                  <a href="<?php echo site_url('followup/precurementRqstDetails/' . encryptor($enq['proc_id'])); ?>">
                                                       <span> <?php echo $vehData; ?> </span>
                                                  </a>
                                             </li>
                                        <?php
                                        }
                                        ?>
                                        <li class="nav-item">
                                             <div class="text-center">
                                                  <a class="dropdown-item">
                                                       <a href="<?php echo site_url('followup/precurementRqstList'); ?>">
                                                            <strong>See All</strong>
                                                       </a>
                                                       <i class="fa fa-angle-right"></i>
                                                  </a>
                                             </div>
                                        </li>


                                   </ul>
                              </li>
                         <?php
                         }
                    }
                    if ($this->uid != 100) {
                         $regUpcomFollow = $this->common_model->regiFollNotification();
                         if (!empty($regUpcomFollow)) {
                         ?>
                              <li role="presentation" class="dropdown">
                                   <a title="Upcoming register followup" href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-car"></i>
                                        <span class="badge bg-green"><?php echo count($regUpcomFollow); ?></span>
                                   </a>
                                   <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu" style="height: 233px;overflow-y: scroll;">
                                        <?php
                                        foreach ((array) $regUpcomFollow as $key => $enq) {
                                        ?>
                                             <li>
                                                  <a href="<?php echo site_url('enquiry/myregister?search=' . $enq['vreg_cust_phone']); ?>">
                                                       <span>
                                                            <?php echo $enq['vreg_cust_name'] . ' - ' . $enq['vreg_cust_phone'] . ' By ' . $enq['usr_first_name']; ?><br>
                                                            On <i><?php echo date('d-m-Y h:i A', strtotime($enq['vreg_next_followup'])); ?></i>
                                                       </span>
                                                  </a>
                                             </li>
                                        <?php
                                        }
                                        ?>
                                   </ul>
                              </li>
                         <?php
                         }
                    }
                    if (check_permission('feedback', 'view_nitify')) {
                         $fedbk = $this->common_model->feedback();
                         if ($fedbk > 0) {
                         ?>
                              <li role="presentation" class="dropdown">
                                   <a title="App feedback" href="<?php echo site_url('feedback'); ?>" class="info-number">
                                        <i class="fa fa-commenting"></i> <span class="badge bg-green"><?php echo $fedbk; ?></span>
                                   </a>
                              </li>
                         <?php }
                    }
                    if (check_permission('notification', 'ins_pending')) {
                         $insPend = $this->common_model->pendingInsuranceApproval();
                         if ($insPend > 0) { ?>
                              <li role="presentation" class="dropdown">
                                   <a title="Insurance pending" href="<?php echo site_url('insurance/insurancepending'); ?>" class="info-number">
                                        INS <span class="badge bg-green"><?php echo $insPend; ?></span>
                                   </a>
                              </li>
                         <?php }
                    }
                    if ($this->usr_grp == 'SE') {
                         $assignedEnquires = $this->common_model->assignedEnquires();
                         if (!empty($assignedEnquires)) {
                         ?>
                              <li role="presentation" class="dropdown">
                                   <a title="Assigned inquires" href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-download"></i>
                                        <span class="badge bg-green"><?php echo count($assignedEnquires); ?></span>
                                   </a>
                                   <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu" style="height: 233px;overflow-y: scroll;">
                                        <?php
                                        foreach ((array) $assignedEnquires as $key => $enq) {
                                        ?>
                                             <li>
                                                  <a href="<?php echo site_url('enquiry/view/' . encryptor($enq['enq_id'])); ?>">
                                                       <span><?php echo $enq['enq_cus_name']; ?></span>
                                                  </a>
                                                  <span class="message">
                                                       <a href="<?php echo site_url('enquiry/view/' . encryptor($enq['enq_id'])); ?>">
                                                            <?php echo 'Enquiry of ' . $enq['enq_added_by_name']; ?></a>
                                                  </span>
                                             </li>
                                        <?php
                                        }
                                        ?>
                                   </ul>
                              </li>
                    <?php }
                    }
                    ?>
               </ul>
          </nav>
     </div>
</div>
<script src="../vendors/jquery/dist/jquery.min.js"></script>

<?php
//&& $this->uid != 561 && $this->uid != 358 (Abhishek) 657 - anjana
if ($this->usr_grp != 'TC' && $this->uid != 561 && $this->uid != 657 && $this->uid  != 569) {
     $alerts = $this->common_model->pendingRegisters();
     if (isset($alerts['pendingRegisters']) && !empty($alerts['pendingRegisters'])) {
?>
          <div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="max-height: 500px;overflow-y: scroll;background-color: rgba(12, 12, 12, 0.88);border-color: rgba(12, 12, 12, 0.88);">
               <div style="margin-bottom: 20px;border-bottom: 2px solid;">
                    <strong>Pending Contact to punch enquiry
                         <?php echo isset($alerts['pendingRegisters']) ? ' (' . count($alerts['pendingRegisters']) . ')' : 0; ?></strong>
                    <i class="fa fa-close" style="color: #fff;float: right;" class="close" data-dismiss="alert" aria-label="Close"></i>
               </div>
               <div>
                    <?php
                    foreach ($alerts['pendingRegisters'] as $key => $value) {
                         $url = !empty($value['vreg_inquiry']) ? site_url('followup/viewFollowup/' . encryptor($value['vreg_inquiry'])) :
                              site_url('enquiry/regiter_2_inquiry/' . encryptor($value['vreg_id']));
                         if (check_permission('registration', 'allowquickdropregister')) {
                    ?>
                              <span data-toggle="modal" data-target="#<?php echo $value['vreg_id']; ?>" style="color: #fff;width: 100%;float: left;cursor: pointer;">
                                   <span>Customer : <?php echo $value['vreg_cust_name'] . ', ' . $value['vreg_cust_phone']; ?></span>
                                   <span>Assigned by : <?php echo $value['addedby_usr_first_name']; ?></span>
                              </span>
                              <div class="modal fade" id="<?php echo $value['vreg_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                   <div class="modal-dialog" role="document">
                                        <div class="modal-content" style="color: black;">
                                             <div class="modal-header">
                                                  <h5 style="width: 90%;float: left;" class="modal-title" id="exampleModalLabel">Quick drop or
                                                       punch register</h5>
                                                  <button style="float:right;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                       <span aria-hidden="true">&times;</span>
                                                  </button>
                                             </div>
                                             <div class="modal-body">
                                                  <div class="row">
                                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div class="x_panel">
                                                                 <div class="x_content">
                                                                      <div class="form-group" style="width: 100%;float: left;">
                                                                           <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer
                                                                                name</label>
                                                                           <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                <?php echo $value['vreg_cust_name']; ?>
                                                                           </div>
                                                                      </div>

                                                                      <div class="form-group" style="width: 100%;float: left;">
                                                                           <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer
                                                                                contact</label>
                                                                           <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                <?php echo $value['vreg_cust_phone']; ?>
                                                                           </div>
                                                                      </div>

                                                                      <div class="form-group" style="width: 100%;float: left;">
                                                                           <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                                                                           <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                <?php echo $value['vreg_cust_place']; ?>
                                                                           </div>
                                                                      </div>

                                                                      <div class="form-group" style="width: 100%;float: left;">
                                                                           <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer
                                                                                feedback</label>
                                                                           <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                <?php echo $value['vreg_customer_remark']; ?>
                                                                           </div>
                                                                      </div>

                                                                      <div class="form-group" style="width: 100%;float: left;">
                                                                           <label class="control-label col-md-3 col-sm-3 col-xs-12">Assigned by</label>
                                                                           <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                <?php echo $value['addedby_usr_first_name'] . ' ' . $value['addedby_usr_last_name']; ?>
                                                                           </div>
                                                                      </div>

                                                                      <div class="form-group" style="width: 100%;float: left;">
                                                                           <label class="control-label col-md-3 col-sm-3 col-xs-12">Comment</label>
                                                                           <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                <?php echo $value['vreg_last_action']; ?>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="row" style="text-align: center;">
                                                       <div>
                                                            <a class="btn btn-primary" href="<?php echo $url; ?>">Punch to enquiry</a><br>
                                                       </div>
                                                  </div>
                                                  <div class="row" style="text-align: center;font-weight: bolder;font-size: 25px;">OR</div>
                                                  <div method="post" class="row frmRequestForDrop<?php echo $value['vreg_id']; ?>" data-url="<?php echo site_url('registration/changeRegisterStatus'); ?>">
                                                       <input type="hidden" name="regMaster" class="txtRegMaster<?php echo $value['vreg_id']; ?>" value="<?php echo $value['vreg_id']; ?>" />
                                                       <input type="hidden" name="status" class="txtStatus<?php echo $value['vreg_id']; ?>" value="<?php echo reg_req_drop; ?>" />

                                                       <!-- -->
                                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div class="x_panel">
                                                                 <div class="form-group">
                                                                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Reason for drop <span class="required">*</span>
                                                                      </label>
                                                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                                                           <textarea required name="reason" class="txtReason<?php echo $value['vreg_id']; ?> form-control col-md-5 col-xs-12 "></textarea>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <!-- -->

                                                       <div class="modal-footer">
                                                            <input type="button" class="btn btn-primary btnRequestForDrop" data-id="<?php echo $value['vreg_id']; ?>" value="Request for drop" />
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         <?php
                         } else {
                         ?>
                              <a href="<?php echo 'javascript:void(0);' //$url;
                                        ?>" style="color: #fff;width: 100%;float: left;">
                                   <span>Customer : <?php echo $value['vreg_cust_name'] . ', ' . $value['vreg_cust_phone']; ?></span>
                                   <span>Assigned by : <?php echo $value['addedby_usr_first_name']; ?></span>
                              </a>
                    <?php
                         }
                    }
                    ?>
               </div>
          </div>
     <?php }
     if (can_access_module('notify_todayfollowup', 'todayfollowupnotify')) { ?>
<!--          <div class="divTodayfollowupnotify" id="divMoove">
               <div id="mydivheader">
                    <a href="javascript:void(0);" class="btn-floating btn-blue btn-lg btn-default"><i class="fa fa-bullhorn"></i></a>
                    <a class="counter counter-lg" href="<?php echo site_url('followup/todayfollowup'); ?>" target="blank"><?php echo $this->common_model->todaysFollowup(); ?></a>
               </div>
          </div>-->
     <?php } ?>
     <?php }
if (
     check_permission('booking', 'showbooking') || check_permission('product', 'canuploadprdimage_notify') ||
     check_permission('product', 'readytopublish_notify') || check_permission('registration', 'secondayregcourtseycall_notify') ||
     check_permission('insurance', 'index')
) {
     $sideBarNotification = $this->common_model->sideBarNotifications();
     if (!empty($sideBarNotification)) {
     ?>
          <div class="ui-theme-settings">
               <button type="button" id="TooltipDemo" class="blink btn-open-options btn btn-outline-2x btn-outline-focus">
                    <i class="fa fa-exclamation-circle" style="font-size:30px;"></i>
               </button>
               <div class="theme-settings__inner">
                    <div class="scrollbar-container ps">
                         <div class="theme-settings__options-wrapper">
                              <h3 class="themeoptions-heading">Notifications</h3>
                              <ul class="list-group">
                                   <?php if (isset($sideBarNotification['reject_book']) && !empty($sideBarNotification['reject_book'])) { ?>
                                        <li class="list-group-item">
                                             <div class="widget-content p-0">
                                                  <div class="widget-content-wrapper">
                                                       <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                                 <a href="<?php echo site_url('booking/getRejectedBooking'); ?>">
                                                                      <strong><?php echo $sideBarNotification['reject_book'] . ' Booking rejected'; ?></strong>
                                                                 </a>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </li>
                                   <?php }
                                   if (isset($sideBarNotification['booked']) && !empty($sideBarNotification['booked'])) { ?>
                                        <li class="list-group-item">
                                             <div class="widget-content p-0">
                                                  <div class="widget-content-wrapper">
                                                       <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                                 <a href="<?php echo site_url('booking/bookedvehicles?s=' . encryptor(vehicle_booked)); ?>">
                                                                      <strong><?php echo $sideBarNotification['booked'] . ' Bookings'; ?></strong>
                                                                 </a>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </li>
                                   <?php }
                                   if (isset($sideBarNotification['bookConfirmed']) && !empty($sideBarNotification['bookConfirmed'])) { ?>
                                        <li class="list-group-item">
                                             <div class="widget-content p-0">
                                                  <div class="widget-content-wrapper">
                                                       <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                                 <a href="<?php echo site_url('booking/bookedvehicles?s=' . encryptor(confm_book)); ?>">
                                                                      <strong><?php echo $sideBarNotification['bookConfirmed'] . ' Bookings confirmed'; ?></strong>
                                                                 </a>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </li>
                                   <?php }
                                   if (isset($sideBarNotification['pendingImageUpload']) && !empty($sideBarNotification['pendingImageUpload'])) { ?>
                                        <li class="list-group-item">
                                             <div class="widget-content p-0">
                                                  <div class="widget-content-wrapper">
                                                       <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                                 <a href="<?php echo site_url('product/pendingPhotoupload'); ?>">
                                                                      <strong><?php echo $sideBarNotification['pendingImageUpload'] . ' pendig upload image'; ?></strong>
                                                                 </a>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </li>
                                   <?php }
                                   if (isset($sideBarNotification['readytopublish']) && !empty($sideBarNotification['readytopublish'])) { ?>
                                        <li class="list-group-item">
                                             <div class="widget-content p-0">
                                                  <div class="widget-content-wrapper">
                                                       <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                                 <?php foreach ($sideBarNotification['readytopublish'] as $key => $value) { ?>
                                                                      <a href="<?php echo site_url('product/product_share/' . encryptor($value['prd_id'])); ?>">
                                                                           <strong><?php echo $value['regno'] . ' ' . $value['vehicle']; ?></strong>
                                                                      </a>
                                                                 <?php } ?>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </li>
                                   <?php }
                                   if (check_permission('registration', 'secondayregcourtseycall_notify') && isset($sideBarNotification['secondayregcourtseycall'])) { ?>
                                        <li class="list-group-item">
                                             <div class="widget-content p-0">
                                                  <div class="widget-content-wrapper">
                                                       <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                                 <a href="<?php echo site_url('registration/registerCourtesyCall'); ?>">
                                                                      <strong><?php echo $sideBarNotification['secondayregcourtseycall'] . ' Seconday register courtsey call'; ?></strong>
                                                                 </a>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </li>
                                   <?php }
                                   if (check_permission('insurance', 'index') && isset($sideBarNotification['insurance_expiry'])) { ?>
                                        <li class="list-group-item">
                                             <div class="widget-content p-0">
                                                  <div class="widget-content-wrapper">
                                                       <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                                 <?php foreach ($sideBarNotification['insurance_expiry'] as $key => $value) { ?>
                                                                      <a href="<?php echo site_url('insurance'); ?>">
                                                                           <strong><?php echo 'Insurance renewal - ' . $value['val_veh_no'] . ', ' . date('d-m-Y', strtotime($value['val_insurance_validity'])); ?></strong>
                                                                      </a>
                                                                 <?php } ?>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </li>
                                   <?php } ?>
                              </ul>
                         </div>
                    </div>
               </div>
          </div>
<?php
     }
}
?>
<style>
     #divMoove {
          width: 12%;
          cursor: move !important;
     }

     .divTodayfollowupnotify {
          position: absolute;
          color: red;
          top: 22px;
          right: 40px;
          z-index: 10;
     }

     .btn-floating {
          border-radius: 72px;
          background-color: #1976d2;
          color: #fff;
          font-size: 77px;
          cursor: move !important;
     }

     .counter.counter-lg {
          font-size: 20px;
          position: absolute;
          left: 48px;
          font-weight: bolder;
          color: red;
          background-color: black;
          border-radius: 68px;
          margin: 10px;
          padding: 2px;
     }
</style>
<?php if (can_access_module('notify_todayfollowup', 'todayfollowupnotify')) { ?>
     <script>
          // Make the DIV element draggable:
          dragElement(document.getElementById("divMoove"));

          function dragElement(elmnt) {
               var pos1 = 0,
                    pos2 = 0,
                    pos3 = 0,
                    pos4 = 0;
               if (document.getElementById(elmnt.id + "header")) {
                    // if present, the header is where you move the DIV from:
                    document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
               } else {
                    // otherwise, move the DIV from anywhere inside the DIV:
                    elmnt.onmousedown = dragMouseDown;
               }

               function dragMouseDown(e) {
                    e = e || window.event;
                    e.preventDefault();
                    // get the mouse cursor position at startup:
                    pos3 = e.clientX;
                    pos4 = e.clientY;
                    document.onmouseup = closeDragElement;
                    // call a function whenever the cursor moves:
                    document.onmousemove = elementDrag;
               }

               function elementDrag(e) {
                    e = e || window.event;
                    e.preventDefault();
                    // calculate the new cursor position:
                    pos1 = pos3 - e.clientX;
                    pos2 = pos4 - e.clientY;
                    pos3 = e.clientX;
                    pos4 = e.clientY;
                    // set the element's new position:
                    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
               }

               function closeDragElement() {
                    // stop moving when mouse button is released:
                    document.onmouseup = null;
                    document.onmousemove = null;
               }
          }
     </script>
<?php } ?>