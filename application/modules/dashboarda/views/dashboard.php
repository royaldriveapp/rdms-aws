    <div class="right_col" role="main">
<?php if($this->usr_grp != 'SEO') { ?>
 
          <!-- top tiles -->
          <div class="row tile_count">
               <?php if (isset($enquiresAnalysis['active_enquires'])) {?>
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                         <span class="count_top"><i class="fa fa-user"></i> Total Enquires</span>
                         <div class="count"><?php echo number_format($enquiresAnalysis['active_enquires']);?></div>
                    </div>
               <?php } if (isset($enquiresAnalysis['dropped_vehicles'])) {?>
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                         <span class="count_top"><i class="fa fa-trash"></i> Dropped Vehicles</span>
                         <div class="count"><?php echo number_format($enquiresAnalysis['dropped_vehicles']);?></div>
                    </div>
               <?php } if (isset($enquiresAnalysis['deleted_vehicles'])) {?>
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                         <span class="count_top"><i class="fa fa-close"></i> Deleted Vehicles</span>
                         <div class="count purple"><?php echo number_format($enquiresAnalysis['deleted_vehicles']);?></div>
                    </div>
               <?php } if (isset($enquiresAnalysis['soled_vehicles'])) {?>
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                         <span class="count_top"><i class="fa fa-car"></i> Sold Vehicles</span>
                         <div class="count green"><?php echo number_format($enquiresAnalysis['soled_vehicles']);?></div>
                    </div>
               <?php } if (isset($enquiresAnalysis['stock_vehicle'])) {?>
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                         <span class="count_top"><i class="fa fa-bus"></i> Stock Vehicles</span>
                         <div class="count"><?php echo number_format($enquiresAnalysis['stock_vehicle']);?></div>
                    </div>
               <?php } if (isset($enquiresAnalysis['total_assigned'])) {?>
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                         <span class="count_top"><i class="fa fa-user"></i> Assigned Enquires</span>
                         <div class="count"><?php echo number_format($enquiresAnalysis['total_assigned']);?></div>
                    </div>
               <?php }?>
          </div>
          <!-- /top tiles -->
          <?php if (($this->usr_grp != 'SEO') && !empty(get_settings_by_key('dashboard_news'))) {?>
               <div class="row" style="margin-top: -20px;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                         <div class="x_panel tile" style="padding: 5px;margin: 1px;">
                              <div class="x_title" style="border: none;margin: 0px;">
                                   <marquee style="font-size: 18px;color: brown;font-style: italic;font-style:italic;" onmouseover="this.stop();" onmouseout="this.start();" SCROLLAMOUNT=3><?php echo get_settings_by_key('dashboard_news');?></marquee>
                                   <div class="clearfix"></div>
                              </div>
                         </div>
                    </div>
               </div>
          <?php }?>
          <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="dashboard_graph">

                         <div class="row x_title">
                              <div class="col-md-12">
                                   <h3>Enquiry Progression
                                        <small>based on date between
                                             <?php
                                             echo isset($dashboardMeterials['mainGraphContent']['datesFullFormat'][0]) ? $dashboardMeterials['mainGraphContent']['datesFullFormat'][0] : '';
                                             echo ' - ';
                                             echo isset($dashboardMeterials['mainGraphContent']['datesFullFormat'][30]) ? $dashboardMeterials['mainGraphContent']['datesFullFormat'][30] : '';
                                             ?>
                                        </small>
                                   </h3>
                              </div>
                              <!--                         <div class="col-md-6">
                                                            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                                                 <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                                 <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                                            </div>
                                                       </div>-->
                         </div>

                         <div class="col-md-12 col-sm-12 col-xs-12">
                              <div id="jqChart"></div>
                         </div>
                         <div class="col-md-12 col-sm-12 col-xs-12">
                              <div id="jqVehicleDemand"></div>
                         </div>
                         <div class="clearfix"></div>
                    </div>
               </div>

          </div>
          <br />

          <div class="row">

               <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel tile fixed_height_320" style="overflow-y: scroll;">
                         <div class="x_title">
                              <h2>Mode of contact for <?php echo date("M", strtotime("-1 month")) . '-' . date('M');?></h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <!--<h4>App Usage across versions</h4>-->
                              <?php
                              if (isset($dashboardMeterials['mode_of_enq_count']) && !empty($dashboardMeterials['mode_of_enq_count'])) {
                                   $modOfContacts = unserialize(MODE_OF_CONTACT);
                                   foreach ((array) $dashboardMeterials['mode_of_enq_count'] as $key => $value) {
                                        if (in_array($value['enq_mode_enq'], array(18, 17, 6, 19, 20))) {
                                             $perc = round(($value['total_no'] * 100) / $dashboardMeterials['mode_of_enq_total_count'], 2);
                                             ?>
                                             <div class="widget_summary">
                                                  <div class="w_left w_25">
                                                       <span><?php echo $modOfContacts[$value['enq_mode_enq']];?></span>
                                                  </div>
                                                  <div class="w_center w_55">
                                                       <div class="progress">
                                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $value['total_no'];?>" aria-valuemin="0" 
                                                                 aria-valuemax="<?php echo $dashboardMeterials['mode_of_enq_total_count']?>" style="width: <?php echo $perc;?>%;">
                                                                 <span class="sr-only"><?php echo $perc;?>% Complete</span>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="w_right w_20">
                                                       <span style="font-size: 15px;"><?php echo $perc;?>%</span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                             </div>
                                             <?php
                                        }
                                   }
                              }
                              ?>
                         </div>
                    </div>
               </div>

               <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel tile fixed_height_320 overflow_hidden">
                         <div class="x_title">
                              <h2>Hot+, Hot, Warm & Cold</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <table class="" style="width:100%">
                                   <tr>
                                        <td>
                                             <?php
                                             $hphwcSum = array_sum(array_column($dashboardMeterials['hwc_grp_total_count'], 'total_no'));

                                             $hotP = isset($dashboardMeterials['hwc_grp_total_count'][0]['total_no']) ?
                                                     $dashboardMeterials['hwc_grp_total_count'][0]['total_no'] : 0;

                                             $hot = isset($dashboardMeterials['hwc_grp_total_count'][1]['total_no']) ?
                                                     $dashboardMeterials['hwc_grp_total_count'][1]['total_no'] : 0;

                                             $warm = isset($dashboardMeterials['hwc_grp_total_count'][2]['total_no']) ?
                                                     $dashboardMeterials['hwc_grp_total_count'][2]['total_no'] : 0;

                                             $cold = isset($dashboardMeterials['hwc_grp_total_count'][3]['total_no']) ?
                                                     $dashboardMeterials['hwc_grp_total_count'][3]['total_no'] : 0;

                                             $hpperc = round((($hotP / $hphwcSum) * 100), 2);
                                             $hperc = round((($hot / $hphwcSum) * 100), 2);
                                             $wperc = round((($warm / $hphwcSum) * 100), 2);
                                             $cperc = round((($cold / $hphwcSum) * 100), 2);
                                             ?>
                                             <script>
                                                  var hp = <?php echo!empty($hpperc) ? $hpperc : 0;?>;
                                                  var h = <?php echo!empty($hperc) ? $hperc : 0;?>;
                                                  var w = <?php echo!empty($wperc) ? $wperc : 0;?>;
                                                  var c = <?php echo!empty($cperc) ? $cperc : 0;?>;
                                             </script>
                                             <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                                        </td>
                                        <td>
                                             <table class="tile_info">
                                                  <?php
                                                  if (isset($dashboardMeterials['hwc_grp_total_count']) && !empty($dashboardMeterials['hwc_grp_total_count'])) {
                                                       $hwc = unserialize(ENQUIRY_UP_STATUS);
                                                       foreach ((array) $dashboardMeterials['hwc_grp_total_count'] as $key => $value) {
                                                            $perc = round((($value['total_no'] / $hphwcSum) * 100), 2);
                                                            $color = '';
                                                            if ($value['enq_cus_when_buy'] == 1) { // Hot+
                                                                 $color = '#FF0000';
                                                            }
                                                            if ($value['enq_cus_when_buy'] == 2) { // Hot
                                                                 $color = '#9c3501';
                                                            }
                                                            if ($value['enq_cus_when_buy'] == 3) { // Warm
                                                                 $color = '#ffc800';
                                                            }
                                                            if ($value['enq_cus_when_buy'] == 4) { // Cool
                                                                 $color = '#6aa913';
                                                            }
                                                            ?>
                                                            <!-- green purple aero red blue-->
                                                            <tr>
                                                                 <td>
                                                                      <a href="<?php echo site_url('reports/enquiries?status=' . $value['enq_cus_when_buy']);?>"
                                                                           target="blank"><i class="fa fa-square" style="<?php echo 'color: ' . $color;?>"></i>
                                                                           <?php echo $hwc[$value['enq_cus_when_buy']];?></a>
                                                                 </td>
                                                                 <td><a href="<?php echo site_url('reports/enquiries?status=' . $value['enq_cus_when_buy']);?>"
                                                                      target="blank"><?php echo $perc;?>%</a></td>
                                                            </tr>
                                                       <?php
                                                       }
                                                  }
                                                  ?>
                                             </table>
                                        </td>
                                   </tr>
                              </table>
                              <div class="row" style="text-align: center;">
                                   <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                        <a href="<?php echo site_url('enquiry/myinquiresbystatus?status=1');?>" target="blank"
                                        style="font-size: 30px;font-weight: bolder;cursor: pointer;color: #FF0000;">
                                             <?php
                                                  echo isset($dashboardMeterials['hwc_grp_total_count'][0]['total_no']) ?
                                                       $dashboardMeterials['hwc_grp_total_count'][0]['total_no'] : 0;
                                             ?><small style="font-size: 10px;">nos</small>
                                        </a>
                                   </div>

                                   <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                        <a href="<?php echo site_url('enquiry/myinquiresbystatus?status=2');?>" target="blank"
                                        style="font-size: 30px;font-weight: bolder;cursor: pointer;color: #9c3501;">
                                             <?php
                                                  echo isset($dashboardMeterials['hwc_grp_total_count'][1]['total_no']) ?
                                                       $dashboardMeterials['hwc_grp_total_count'][1]['total_no'] : 0;
                                             ?><small style="font-size: 10px;">nos</small>
                                        </a>
                                   </div>

                                   <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                        <a href="<?php echo site_url('enquiry/myinquiresbystatus?status=3');?>" target="blank"
                                        style="font-size: 30px;font-weight: bolder;cursor: pointer;color: #ffc800;">
                                             <?php
                                                  echo isset($dashboardMeterials['hwc_grp_total_count'][2]['total_no']) ?
                                                       $dashboardMeterials['hwc_grp_total_count'][2]['total_no'] : 0;
                                             ?><small style="font-size: 10px;">nos</small>
                                        </a>
                                   </div>

                                   <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                        <a href="<?php echo site_url('enquiry/myinquiresbystatus?status=4');?>" target="blank"
                                        style="font-size: 30px;font-weight: bolder;cursor: pointer;color: #6aa913;">
                                             <?php
                                                  echo isset($dashboardMeterials['hwc_grp_total_count'][3]['total_no']) ?
                                                       $dashboardMeterials['hwc_grp_total_count'][3]['total_no'] : 0;
                                             ?><small style="font-size: 10px;">nos</small>
                                        </a>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel tile fixed_height_320">
                         <div class="x_title">
                              <h2>Quick Links</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="x_content">
                              <div class="dashboard-widget-content">
                                   <ul class="quick-list"  style="width: 100%;">
                                                  <?php if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') {?>
                                             <li><i class="fa fa-hand-o-right"></i><a target="blank" href="<?php echo site_url('followup/running');?>">Running Followup 
                                                       <?php echo isset($analytics['count_running_followup']) && $analytics['count_running_followup'] > 0 ? '<span class="label label-success pull-right">' . $analytics['count_running_followup'] . '</span>' : '';?></a></li>
                                             <li><i class="fa fa-hand-o-right"></i><a target="blank" href="<?php echo site_url('followup/missed');?>">Missed Followup
                                                       <?php echo isset($analytics['count_missid_followup']) && $analytics['count_missid_followup'] > 0 ? '<span class="label label-success pull-right">' . $analytics['count_missid_followup'] . '</span>' : '';?></a></li>
                                             <li><i class="fa fa-hand-o-right"></i><a target="blank" href="<?php echo site_url('enquiry/freezedEnquires');?>">Freezed Enquires
                                             <?php echo isset($analytics['count_freezed_enquiry']) && $analytics['count_freezed_enquiry'] > 0 ? '<span class="label label-success pull-right">' . $analytics['count_freezed_enquiry'] . '</span>' : '';?></a></li>
                                                  <?php }?>
                                        <li><i class="fa fa-hand-o-right"></i><a target="blank" href="<?php echo site_url('evaluation/index/0');?>">Pending Evaluation
                                                  <?php echo isset($analytics['count_pending_evaluation']) && $analytics['count_pending_evaluation'] > 0 ? '<span class="label label-success pull-right">' . $analytics['count_pending_evaluation'] . '</span>' : '';?></a></li>
                                        <li><i class="fa fa-hand-o-right"></i><a target="blank" href="<?php echo site_url('evaluation/index/1');?>">Evaluated Vehicles
     <?php echo isset($analytics['count_evaluated_vehicle']) && $analytics['count_evaluated_vehicle'] > 0 ? '<span class="label label-success pull-right">' . $analytics['count_evaluated_vehicle'] . '</span>' : '';?></a></li>
                                        <!--<li><i class="fa fa-hand-o-right"></i><a target="blank" href="<?php //echo site_url('enquiry/add');?>">New Enquiry</a></li>-->
                                        <li><i class="fa fa-hand-o-right"></i><a target="blank" href="<?php echo site_url('evaluation/add');?>">Evaluate New Vehicle</a></li>
                                                  <?php if (check_permission('enquiry', 'changestatusrequest')) {?>
                                             <li><i class="fa fa-hand-o-right"></i><a target="blank" href="<?php echo site_url('enquiry/changeStatusRequest/8');?>">Request For Delete
                                                       <?php echo isset($analytics['count_delete_req']) && $analytics['count_delete_req'] > 0 ? '<span class="label label-success pull-right">' . $analytics['count_delete_req'] . '</span>' : '';?></a></li>
                                             <li><i class="fa fa-hand-o-right"></i><a target="blank" href="<?php echo site_url('enquiry/changeStatusRequest/2');?>">Request For Drop
                                                       <?php echo isset($analytics['count_drop_req']) && $analytics['count_drop_req'] > 0 ? '<span class="label label-success pull-right">' . $analytics['count_drop_req'] . '</span>' : '';?></a></li>
                                             <li><i class="fa fa-hand-o-right"></i><a target="blank" href="<?php echo site_url('enquiry/changeStatusRequest/6');?>">Request For Close
                                             <?php echo isset($analytics['count_sale_req']) && $analytics['count_sale_req'] > 0 ? '<span class="label label-success pull-right">' . $analytics['count_sale_req'] . '</span>' : '';?></a></li>
                                                  <?php } if (is_roo_user()) {?>
                                             <li><i class="fa fa-hand-o-right"></i><a target="blank" href="<?php echo site_url('enquiry/freezedEnquires');?>">Freezed Enquires
                                                       <?php echo isset($analytics['count_freezed_enquiry']) && $analytics['count_freezed_enquiry'] > 0 ? '<span class="label label-success pull-right">' . $analytics['count_freezed_enquiry'] . '</span>' : '';?></a></li>
     <?php }?>
                                   </ul>
                              </div>
                         </div>
                    </div>
               </div>
          </div>

          <!--     <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                         <div class="x_panel">
                              <div class="x_title">
                                   <h2>Recent Activities <small>Sessions</small></h2>
                                   <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                             <ul class="dropdown-menu" role="menu">
                                                  <li><a href="#">Settings 1</a>
                                                  </li>
                                                  <li><a href="#">Settings 2</a>
                                                  </li>
                                             </ul>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                   </ul>
                                   <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                   <div class="dashboard-widget-content">
          
                                        <ul class="list-unstyled timeline widget">
                                             <li>
                                                  <div class="block">
                                                       <div class="block_content">
                                                            <h2 class="title">
                                                                 <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                                            </h2>
                                                            <div class="byline">
                                                                 <span>13 hours ago</span> by <a>Jane Smith</a>
                                                            </div>
                                                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                                            </p>
                                                       </div>
                                                  </div>
                                             </li>
                                             <li>
                                                  <div class="block">
                                                       <div class="block_content">
                                                            <h2 class="title">
                                                                 <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                                            </h2>
                                                            <div class="byline">
                                                                 <span>13 hours ago</span> by <a>Jane Smith</a>
                                                            </div>
                                                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                                            </p>
                                                       </div>
                                                  </div>
                                             </li>
                                             <li>
                                                  <div class="block">
                                                       <div class="block_content">
                                                            <h2 class="title">
                                                                 <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                                            </h2>
                                                            <div class="byline">
                                                                 <span>13 hours ago</span> by <a>Jane Smith</a>
                                                            </div>
                                                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                                            </p>
                                                       </div>
                                                  </div>
                                             </li>
                                             <li>
                                                  <div class="block">
                                                       <div class="block_content">
                                                            <h2 class="title">
                                                                 <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                                            </h2>
                                                            <div class="byline">
                                                                 <span>13 hours ago</span> by <a>Jane Smith</a>
                                                            </div>
                                                            <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                                            </p>
                                                       </div>
                                                  </div>
                                             </li>
                                        </ul>
                                   </div>
                              </div>
                         </div>
                    </div>
          
          
                    <div class="col-md-8 col-sm-8 col-xs-12">
          
          
          
                         <div class="row">
          
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                   <div class="x_panel">
                                        <div class="x_title">
                                             <h2>Visitors location <small>geo-presentation</small></h2>
                                             <ul class="nav navbar-right panel_toolbox">
                                                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                  </li>
                                                  <li class="dropdown">
                                                       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                       <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">Settings 1</a>
                                                            </li>
                                                            <li><a href="#">Settings 2</a>
                                                            </li>
                                                       </ul>
                                                  </li>
                                                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                  </li>
                                             </ul>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                             <div class="dashboard-widget-content">
                                                  <div class="col-md-4 hidden-small">
                                                       <h2 class="line_30">125.7k Views from 60 countries</h2>
          
                                                       <table class="countries_list">
                                                            <tbody>
                                                                 <tr>
                                                                      <td>United States</td>
                                                                      <td class="fs15 fw700 text-right">33%</td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td>France</td>
                                                                      <td class="fs15 fw700 text-right">27%</td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td>Germany</td>
                                                                      <td class="fs15 fw700 text-right">16%</td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td>Spain</td>
                                                                      <td class="fs15 fw700 text-right">11%</td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td>Britain</td>
                                                                      <td class="fs15 fw700 text-right">10%</td>
                                                                 </tr>
                                                            </tbody>
                                                       </table>
                                                  </div>
                                                  <div id="world-map-gdp" class="col-md-8 col-sm-12 col-xs-12" style="height:230px;"></div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
          
                         </div>
                         <div class="row">
          
          
                              Start to do list 
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <div class="x_panel">
                                        <div class="x_title">
                                             <h2>To Do List <small>Sample tasks</small></h2>
                                             <ul class="nav navbar-right panel_toolbox">
                                                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                  </li>
                                                  <li class="dropdown">
                                                       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                       <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">Settings 1</a>
                                                            </li>
                                                            <li><a href="#">Settings 2</a>
                                                            </li>
                                                       </ul>
                                                  </li>
                                                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                  </li>
                                             </ul>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
          
                                             <div class="">
                                                  <ul class="to_do">
                                                       <li>
                                                            <p>
                                                                 <input type="checkbox" class="flat"> Schedule meeting with new client </p>
                                                       </li>
                                                       <li>
                                                            <p>
                                                                 <input type="checkbox" class="flat"> Create email address for new intern</p>
                                                       </li>
                                                       <li>
                                                            <p>
                                                                 <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                                                       </li>
                                                       <li>
                                                            <p>
                                                                 <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                                                       </li>
                                                       <li>
                                                            <p>
                                                                 <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                                                       </li>
                                                       <li>
                                                            <p>
                                                                 <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                                                       </li>
                                                       <li>
                                                            <p>
                                                                 <input type="checkbox" class="flat"> Create email address for new intern</p>
                                                       </li>
                                                       <li>
                                                            <p>
                                                                 <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                                                       </li>
                                                       <li>
                                                            <p>
                                                                 <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                                                       </li>
                                                  </ul>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              End to do list 
          
                              start of weather widget 
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <div class="x_panel">
                                        <div class="x_title">
                                             <h2>Daily active users <small>Sessions</small></h2>
                                             <ul class="nav navbar-right panel_toolbox">
                                                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                  </li>
                                                  <li class="dropdown">
                                                       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                       <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">Settings 1</a>
                                                            </li>
                                                            <li><a href="#">Settings 2</a>
                                                            </li>
                                                       </ul>
                                                  </li>
                                                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                  </li>
                                             </ul>
                                             <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                             <div class="row">
                                                  <div class="col-sm-12">
                                                       <div class="temperature"><b>Monday</b>, 07:30 AM
                                                            <span>F</span>
                                                            <span><b>C</b></span>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row">
                                                  <div class="col-sm-4">
                                                       <div class="weather-icon">
                                                            <canvas height="84" width="84" id="partly-cloudy-day"></canvas>
                                                       </div>
                                                  </div>
                                                  <div class="col-sm-8">
                                                       <div class="weather-text">
                                                            <h2>Texas <br><i>Partly Cloudy Day</i></h2>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-sm-12">
                                                  <div class="weather-text pull-right">
                                                       <h3 class="degrees">23</h3>
                                                  </div>
                                             </div>
          
                                             <div class="clearfix"></div>
          
                                             <div class="row weather-days">
                                                  <div class="col-sm-2">
                                                       <div class="daily-weather">
                                                            <h2 class="day">Mon</h2>
                                                            <h3 class="degrees">25</h3>
                                                            <canvas id="clear-day" width="32" height="32"></canvas>
                                                            <h5>15 <i>km/h</i></h5>
                                                       </div>
                                                  </div>
                                                  <div class="col-sm-2">
                                                       <div class="daily-weather">
                                                            <h2 class="day">Tue</h2>
                                                            <h3 class="degrees">25</h3>
                                                            <canvas height="32" width="32" id="rain"></canvas>
                                                            <h5>12 <i>km/h</i></h5>
                                                       </div>
                                                  </div>
                                                  <div class="col-sm-2">
                                                       <div class="daily-weather">
                                                            <h2 class="day">Wed</h2>
                                                            <h3 class="degrees">27</h3>
                                                            <canvas height="32" width="32" id="snow"></canvas>
                                                            <h5>14 <i>km/h</i></h5>
                                                       </div>
                                                  </div>
                                                  <div class="col-sm-2">
                                                       <div class="daily-weather">
                                                            <h2 class="day">Thu</h2>
                                                            <h3 class="degrees">28</h3>
                                                            <canvas height="32" width="32" id="sleet"></canvas>
                                                            <h5>15 <i>km/h</i></h5>
                                                       </div>
                                                  </div>
                                                  <div class="col-sm-2">
                                                       <div class="daily-weather">
                                                            <h2 class="day">Fri</h2>
                                                            <h3 class="degrees">28</h3>
                                                            <canvas height="32" width="32" id="wind"></canvas>
                                                            <h5>11 <i>km/h</i></h5>
                                                       </div>
                                                  </div>
                                                  <div class="col-sm-2">
                                                       <div class="daily-weather">
                                                            <h2 class="day">Sat</h2>
                                                            <h3 class="degrees">26</h3>
                                                            <canvas height="32" width="32" id="cloudy"></canvas>
                                                            <h5>10 <i>km/h</i></h5>
                                                       </div>
                                                  </div>
                                                  <div class="clearfix"></div>
                                             </div>
                                        </div>
                                   </div>
          
                              </div>
                              end of weather widget 
                         </div>
                    </div>
               </div>-->
     
<?php } ?>
</div>
<!-- /page content -->
<link rel="stylesheet" type="text/css" href="../vendors/jqchart/jquery.jqChart.css" />
<script src="../vendors/jqchart/jquery.jqChart.min.js" type="text/javascript"></script>
<script lang="javascript" type="text/javascript">
                                             $(document).ready(function () {
<?php if (!is_roo_user() && $dashboardMeterials['myreg_count'] > 0) {?>
                                                         window.setInterval(function () {
                                                              if ($('#myRegister').hasClass('in')) {

                                                              } else {
                                                                   $('#myRegister').modal('show');
                                                              }
                                                         }, 20000);
  <?php }?>
                                                  $('#jqChart').jqChart({
                                                       title: {text: ''},
                                                       tooltips: {type: 'shared'},
                                                       animation: {duration: 1},
                                                       legend: {location: 'top'},
                                                       border: {
                                                            lineWidth: 0
                                                       },
                                                       axes: [
                                                            {
                                                                 type: 'category',
                                                                 location: 'bottom',
                                                                 categories: [<?php echo $dashboardMeterials['mainGraphContent']['dates'];?>]
                                                            }
                                                       ],
                                                       series: [
                                                            {
                                                                 type: 'spline',
                                                                 title: 'Malappuram',
                                                                 data: [<?php echo $dashboardMeterials['mainGraphContent']['MLP'];?>]
                                                            },
                                                            {
                                                                 type: 'spline',
                                                                 title: 'Calicut',
                                                                 data: [<?php echo $dashboardMeterials['mainGraphContent']['CLT'];?>]
                                                            }
                                                       ]
                                                  });
<?php if (is_roo_user()) {?>
                                                         $('#jqVehicleDemand').jqChart({
                                                              title: {text: 'Vehicle demand report on last 15 days'},
                                                              tooltips: {type: 'shared'},
                                                              animation: {duration: 1},
                                                              legend: {location: 'top'},
                                                              border: {
                                                                   lineWidth: 0
                                                              },
                                                              axes: [
                                                                   {
                                                                        type: 'category',
                                                                        location: 'bottom',
                                                                        categories: [<?php echo $vehicleDemandGraph['vehicleBrandModel'];?>]
                                                                   }
                                                              ],
                                                              series: [
                                                                   {
                                                                        type: 'spline',
                                                                        title: 'Vehicle demand',
                                                                        data: [<?php echo $vehicleDemandGraph['count'];?>]
                                                                   }
                                                              ]
                                                         });
  <?php }?>
                                             });
</script>


<!-- Register Model -->
<?php /* if (!is_roo_user() && $dashboardMeterials['myreg_count'] > 0) {?>
    <div id="myRegister" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Alert!</h4>
    </div>
    <div class="modal-body">
    <p>Some register are pending to add as enquires.</p>
    </div>
    <div class="modal-footer">
    <a href="<?php echo site_url('enquiry/myregister');?>" class="btn btn-primary">View all <i class="fa fa-arrow-circle-right"></i></a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
    </div>
    </div>
    <?php } */?>
<!-- Register Model -->