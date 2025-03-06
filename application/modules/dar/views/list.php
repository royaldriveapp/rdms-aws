<style>
.clickable-row {
    cursor: pointer;
}
</style>

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

<?php
$showSubmittedBy = (is_roo_user() || $this->usr_grp == 'MG') ? 1 : 0;
$showRevenueAndChallenges = ($this->usr_grp != 'DE') ? 1 : 0;
$showShowroomAndTL = (is_roo_user() || $this->usr_grp == 'MG') ? 1 : 0;
$showManager = (is_roo_user()) ? 1 : 0;
?>

<script>
$(document).ready(function() {
    var showSubmittedBy = <?php echo $showSubmittedBy; ?>;
    var showRevenueAndChallenges = <?php echo $showRevenueAndChallenges; ?>;
    var showShowroomAndTL = <?php echo $showShowroomAndTL; ?>;
    var showManager = <?php echo $showManager; ?>;

    var columnDefs = [];
    var darTable = $('#dar-table').DataTable({
        "order": [],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": site_url + "dar/dar_ajax",
            "type": "POST"
        },
        "columns": [
            {
                "sortable": false,
                "render": function(data, type, full, meta) {
                    var darm_added_on = (full.darm_added_on !== null && full.darm_added_on !== '') ? new Date(full.darm_added_on) : null;
                    if (darm_added_on) {
                        return darm_added_on.toLocaleString('en-US', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                    return '';
                }
            },
            {
                "data": "ab_usr_username",
                "visible": (showSubmittedBy === 1)
            },
            {
                "sortable": false,
                "render": function(data, type, full, meta) {
                    var expec_revenue = (full.darm_expec_revenue !== null) ? full.darm_expec_revenue.toLocaleString('en-US') : 0;
                    return expec_revenue;
                },
                "visible": (showRevenueAndChallenges === 1)
            },
            {
                "data": "darm_challenges",
                "visible": (showRevenueAndChallenges === 1)
            },
            {
                "data": "darm_pending"
            },
            {
                "data": "darm_remarks"
            },
            {
                "data": "shr_location",
                "visible": (showShowroomAndTL === 1)
            },
            {
                "data": "vb_usr_username_tl",
                "visible": (showShowroomAndTL === 1)
            },
            {
                "sortable": false,
                "render": function(data, type, full, meta) {
                    var verified_team_lead_on = (full.darm_verified_team_lead_on !== null && full.darm_verified_team_lead_on !== '') ? new Date(full.darm_verified_team_lead_on) : null;
                    if (verified_team_lead_on) {
                        return verified_team_lead_on.toLocaleDateString('en-US', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric'
                        });
                    }
                    return '';
                },
                "visible": (showShowroomAndTL === 1)
            },
            {
                "data": "vb_usr_username_mg",
                "visible": (showManager === 1)
            },
            {
                "sortable": false,
                "render": function(data, type, full, meta) {
                    var verified_manager_on = (full.darm_verified_manager_on !== null) ? new Date(full.darm_verified_manager_on) : null;
                    if (verified_manager_on) {
                        return verified_manager_on.toLocaleDateString('en-US', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric'
                        });
                    }
                    return '';
                },
                "visible": (showManager === 1)
            }
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (!aData['vb_usr_username']) {
                $(nRow).find('td').css({
                    'background-color': 'red',
                    'color': '#fff'
                });
            }
            if (aData['darm_is_verified'] && aData['darm_is_verified'] != 0) {
                $(nRow).find('td').css({
                    'background-color': 'green',
                    'color': '#fff'
                });
            }
            $(nRow).addClass('clickable-row');
            return nRow;
        }
    });

    // Add click event handler to the row
    $('#dar-table tbody').on('click', 'tr', function() {
        var rowData = darTable.row(this).data();
        var darm_id = rowData['darm_id'];
        var url = "<?php echo site_url('dar/view/'); ?>/" + "<?php echo encryptor('" + darm_id + "'); ?>";
        
        if (url) {
            window.location.href = url;
        }
    });


});
</script>
