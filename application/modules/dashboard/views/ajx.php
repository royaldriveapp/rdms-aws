<!-- /top tiles -->
<?php if (($this->usr_grp != 'SEO') && !empty(get_settings_by_key('dashboard_news'))) { ?>

     <div class="row" style="margin-top: -20px;">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel tile" style="padding: 5px;margin: 1px;">
                    <div class="x_title" style="border: none;margin: 0px;">
                         <marquee style="font-size: 18px;color: brown;font-style: italic;font-style:italic;" onmouseover="this.stop();" onmouseout="this.start();" SCROLLAMOUNT=3><?php echo get_settings_by_key('dashboard_news'); ?></marquee>
                         <div class="clearfix"></div>
                    </div>
               </div>
          </div>
     </div>
<?php } ?>

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
                                   echo isset($dashboardMeterials['mainGraphContent']['datesFullFormat'][7]) ? $dashboardMeterials['mainGraphContent']['datesFullFormat'][7] : '';
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
                    <h2>Mode of contact for <?php echo date("M", strtotime("-1 month")) . '-' . date('M'); ?></h2>
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
                                             <span><?php echo $modOfContacts[$value['enq_mode_enq']]; ?></span>
                                        </div>
                                        <div class="w_center w_55">
                                             <div class="progress">
                                                  <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $value['total_no']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $dashboardMeterials['mode_of_enq_total_count'] ?>" style="width: <?php echo $perc; ?>%;">
                                                       <span class="sr-only"><?php echo $perc; ?>% Complete</span>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="w_right w_20">
                                             <span style="font-size: 15px;"><?php echo $perc; ?>%</span>
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
                                   $hpperc = $hperc = $wperc = $cperc = 0;

                                   if (isset($dashboardMeterials['hwc_grp_total_count']) && !empty($dashboardMeterials['hwc_grp_total_count'])) {
                                        $hphwcSum = array_sum(array_column($dashboardMeterials['hwc_grp_total_count'], 'total_no'));
                                        $hotP = isset($dashboardMeterials['hwc_grp_total_count'][0]['total_no']) ? $dashboardMeterials['hwc_grp_total_count'][0]['total_no'] : 0;
                                        $hot = isset($dashboardMeterials['hwc_grp_total_count'][1]['total_no']) ? $dashboardMeterials['hwc_grp_total_count'][1]['total_no'] : 0;
                                        $warm = isset($dashboardMeterials['hwc_grp_total_count'][2]['total_no']) ? $dashboardMeterials['hwc_grp_total_count'][2]['total_no'] : 0;
                                        $cold = isset($dashboardMeterials['hwc_grp_total_count'][3]['total_no']) ? $dashboardMeterials['hwc_grp_total_count'][3]['total_no'] : 0;

                                        $hpperc = round((($hotP / $hphwcSum) * 100), 2);
                                        $hperc = round((($hot / $hphwcSum) * 100), 2);
                                        $wperc = round((($warm / $hphwcSum) * 100), 2);
                                        $cperc = round((($cold / $hphwcSum) * 100), 2);
                                   }
                                   ?>
                                   <script>
                                        var hp = <?php echo !empty($hpperc) ? $hpperc : 0; ?>;
                                        var h = <?php echo !empty($hperc) ? $hperc : 0; ?>;
                                        var w = <?php echo !empty($wperc) ? $wperc : 0; ?>;
                                        var c = <?php echo !empty($cperc) ? $cperc : 0; ?>;
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
                                                            <a href="<?php echo site_url('reports/enquiries?status=' . $value['enq_cus_when_buy']); ?>" target="blank"><i class="fa fa-square" style="<?php echo 'color: ' . $color; ?>"></i>
                                                                 <?php echo $hwc[$value['enq_cus_when_buy']]; ?></a>
                                                       </td>
                                                       <td><a href="<?php echo site_url('reports/enquiries?status=' . $value['enq_cus_when_buy']); ?>" target="blank"><?php echo $perc; ?>%</a></td>
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
                              <a href="<?php echo site_url('enquiry/myinquiresbystatus?status=1'); ?>" target="blank" style="font-size: 30px;font-weight: bolder;cursor: pointer;color: #FF0000;">
                                   <?php
                                   echo isset($dashboardMeterials['hwc_grp_total_count'][0]['total_no']) ?
                                        $dashboardMeterials['hwc_grp_total_count'][0]['total_no'] : 0;
                                   ?><small style="font-size: 10px;">nos</small>
                              </a>
                         </div>

                         <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                              <a href="<?php echo site_url('enquiry/myinquiresbystatus?status=2'); ?>" target="blank" style="font-size: 30px;font-weight: bolder;cursor: pointer;color: #9c3501;">
                                   <?php
                                   echo isset($dashboardMeterials['hwc_grp_total_count'][1]['total_no']) ?
                                        $dashboardMeterials['hwc_grp_total_count'][1]['total_no'] : 0;
                                   ?><small style="font-size: 10px;">nos</small>
                              </a>
                         </div>

                         <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                              <a href="<?php echo site_url('enquiry/myinquiresbystatus?status=3'); ?>" target="blank" style="font-size: 30px;font-weight: bolder;cursor: pointer;color: #ffc800;">
                                   <?php
                                   echo isset($dashboardMeterials['hwc_grp_total_count'][2]['total_no']) ?
                                        $dashboardMeterials['hwc_grp_total_count'][2]['total_no'] : 0;
                                   ?><small style="font-size: 10px;">nos</small>
                              </a>
                         </div>

                         <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                              <a href="<?php echo site_url('enquiry/myinquiresbystatus?status=4'); ?>" target="blank" style="font-size: 30px;font-weight: bolder;cursor: pointer;color: #6aa913;">
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
                    <h2>Todays Retails</h2>
                    <div class="clearfix"></div>
               </div>
               <div class="x_content">
                    <div class="dashboard-widget-content">
                         <div class="table-container" style="width:100%;white-space: nowrap;   overflow-x: auto;">
                              <?php if (sizeof($todaysRetails)) { ?>
                                   <table class="table table-striped todays-rtls">
                                        <thead>
                                             <tr>
                                                  <!-- <th>Customer</th> -->
                                                  <!-- <th>Customer Phone</th> -->
                                                  <th>Vehicle</th>
                                                  <th>Reg No</th>
                                                  <th>Booked By</th>
                                                  <th>Sales Staff</th>
                                                  <th>Divisions</th>
                                                  <th>Showroom</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php foreach ($todaysRetails as $todaysRetail) { ?>
                                                  <tr>
                                                       <!-- <td><?php //echo $todaysRetail['enq_cus_name'] 
                                                                 ?></td> -->
                                                       <!-- <td><?php //echo $todaysRetail['enq_cus_mobile'] 
                                                                 ?></td> -->
                                                       <td><?php echo $todaysRetail['brd_title'] . ' | ' . $todaysRetail['mod_title'] . ' | ' . $todaysRetail['var_variant_name']; ?></td>
                                                       <td><?php echo $todaysRetail['val_veh_no'] ?></td>
                                                       <td><?php echo $todaysRetail['bkdby_first_name'] . ' ' . $todaysRetail['bkdby_last_name']; ?></td>
                                                       <td><?php echo $todaysRetail['salesstaff_first_name'] . ' ' . $todaysRetail['salesstaff_last_name'] ?></td>
                                                       <td><?php echo $todaysRetail['div_name'] ?></td>
                                                       <td><?php echo $todaysRetail['shr_location'] ?></td>
                                                  </tr>
                                             <?php } ?>

                                        </tbody>
                                   <?php } ?>
                         </div>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>





<link rel="stylesheet" type="text/css" href="../vendors/jqchart/jquery.jqChart.css" />
<script src="../vendors/jqchart/jquery.jqChart.min.js" type="text/javascript"></script>
<script lang="javascript" type="text/javascript">
     $(document).ready(function() {
          init_chart_doughnut();

          <?php if (!is_roo_user() && $dashboardMeterials['myreg_count'] > 0) { ?>
               window.setInterval(function() {
                    if ($('#myRegister').hasClass('in')) {

                    } else {
                         $('#myRegister').modal('show');
                    }
               }, 20000);
          <?php } ?>
          $('#jqChart').jqChart({
               title: {
                    text: ''
               },
               tooltips: {
                    type: 'shared'
               },
               animation: {
                    duration: 1
               },
               legend: {
                    location: 'top'
               },
               border: {
                    lineWidth: 0
               },
               axes: [{
                    type: 'category',
                    location: 'bottom',
                    categories: [<?php echo $dashboardMeterials['mainGraphContent']['dates']; ?>]
               }],
               series: [{
                         type: 'spline',
                         title: 'Malappuram',
                         data: [<?php echo $dashboardMeterials['mainGraphContent']['MLP']; ?>]
                    },
                    {
                         type: 'spline',
                         title: 'Calicut',
                         data: [<?php echo $dashboardMeterials['mainGraphContent']['CLT']; ?>]
                    },
                    {
                         type: 'spline',
                         title: 'Kochi',
                         data: [<?php echo $dashboardMeterials['mainGraphContent']['COK']; ?>]
                    },
                    {
                         type: 'spline',
                         title: 'Trivandrum',
                         data: [<?php echo $dashboardMeterials['mainGraphContent']['TVM']; ?>]
                    }
               ]
          });
          <?php if (is_roo_user()) { ?>
               $('#jqVehicleDemand').jqChart({
                    title: {
                         text: 'Vehicle demand report on last 15 days'
                    },
                    tooltips: {
                         type: 'shared'
                    },
                    animation: {
                         duration: 1
                    },
                    legend: {
                         location: 'top'
                    },
                    border: {
                         lineWidth: 0
                    },
                    axes: [{
                         type: 'category',
                         location: 'bottom',
                         categories: [<?php echo $vehicleDemandGraph['vehicleBrandModel']; ?>]
                    }],
                    series: [{
                         type: 'spline',
                         title: 'Vehicle demand',
                         data: [<?php echo $vehicleDemandGraph['count']; ?>]
                    }]
               });
          <?php } ?>
     });
</script>