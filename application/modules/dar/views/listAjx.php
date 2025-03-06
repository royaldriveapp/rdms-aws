<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Fixed assets list</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="dar-table" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Submitted On</th>

                                        <th>Submitted by</th>

                                        <th>Expected Revenue</th>
                                        <th>Challenges</th>

                                        <th>Pending</th>
                                        <th>Remarks</th>

                                        <th>Showroom</th>
                                        <th>Verified by (Team lead)</th>
                                        <th>Verified On (Team lead)</th>

                                        <th>Verified by (Manager)</th>
                                        <th>Verified On (Manager)</th>

                                   </tr>
                              </thead>
                         </table>

                    </div>
               </div>
          </div>
     </div>
</div>
<?php if (is_roo_user() || $this->usr_grp == 'MG') {
                                             $showSubmittedBy=1;
}
if ($this->usr_grp != 'DE') {
     $showRevenueAndChallenges=1;
}if (is_roo_user() || $this->usr_grp == 'MG') {
     $showShowroomAndTL=1;
}if (is_roo_user()) {
     $showManager=1;
}

                                             ?>
<script>
     $(document).ready(function() {
          var showSubmittedBy = <?php echo isset($showSubmittedBy) ? $showSubmittedBy : 0; ?>;
          var showRevenueAndChallenges = <?php echo isset($showRevenueAndChallenges) ? $showRevenueAndChallenges : 0; ?>;
          var showShowroomAndTL = <?php echo isset($showShowroomAndTL) ? $showShowroomAndTL : 0; ?>;
          var showManager = <?php echo isset($showManager) ? $showManager : 0; ?>;
          var columnDefs = [];

          if (showSubmittedBy !== 1) {
               columnDefs.push({ "targets": 1, "visible": false });
          }

          if (showRevenueAndChallenges !== 1) {
               columnDefs.push({ "targets": 2, "visible": false });
               columnDefs.push({ "targets": 3, "visible": false });
          }

          if (showShowroomAndTL !== 1) {
               columnDefs.push({ "targets": 6, "visible": false });
               columnDefs.push({ "targets": 7, "visible": false });
               columnDefs.push({ "targets": 8, "visible": false });
          }

          if (showManager !== 1) {
               columnDefs.push({ "targets": 9, "visible": false });
               columnDefs.push({ "targets": 10, "visible": false });
          }

          $('#dar-table').dataTable({
               "order": [],
               "processing": true,
               "serverSide": true,
               "serverMethod": "post",
               "ajax": site_url + "dar/dar_ajax",
               "columns": [
                    { 
                         "sortable": false,
                         "render": function(data, type, full, meta) {
                              if (full.darm_added_on !== null && full.darm_added_on !== '') {
                                   var darm_added_on = new Date(full.darm_added_on).toLocaleDateString('en-US', {
                                        day: 'numeric',
                                        month: 'short',
                                        year: 'numeric'
                                   });
                                   return darm_added_on;
                              }
                              return '';
                         }
                    
                    },
                    { "data": "ab_usr_username" },
                    {
                         "sortable": false,
                         "render": function(data, type, full, meta) {
                              var expec_revenue = full.darm_expec_revenue === null ? 0 : full.darm_expec_revenue.toLocaleString('en-US');
                              return expec_revenue;
                         }
                    },
                    { "data": "darm_challenges" },
                    { "data": "darm_pending" },
                    { "data": "darm_remarks" },
                    { "data": "shr_location" },
                    { "data": "vb_usr_username_tl" },
                    {
                         "sortable": false,
                         "render": function(data, type, full, meta) {
                              if (full.darm_verified_team_lead_on !== null && full.darm_verified_team_lead_on !== '') {
                                   var formattedDate = new Date(full.darm_verified_team_lead_on).toLocaleDateString('en-US', {
                                        day: 'numeric',
                                        month: 'short',
                                        year: 'numeric'
                                   });
                                   return formattedDate;
                              }
                              return '';
                         }
                    },
                    { "data": "vb_usr_username_mg" },
                    {
                         "sortable": false,
                         "render": function(data, type, full, meta) {
                              var formattedDatej = full.darm_verified_manager_on ? new Date(full.darm_verified_manager_on).toLocaleDateString('en-US', {
                                   day: 'numeric',
                                   month: 'short',
                                   year: 'numeric'
                              }) : '';
                              return formattedDatej;
                         }
                    }
               ],
               
               "columnDefs": columnDefs,
               "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (!aData['vb_usr_username']) {
                       console.log(aData['vb_usr_username']);
                         $('td', nRow).css('background-color', 'Red');
                         $('td', nRow).css('color', '#fff');
                    } 
               }
          });
     });
</script>
