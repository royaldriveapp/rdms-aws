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
                         <h2>Tracking</h2>
                         <ul class="nav navbar-right panel_toolbox">
                        <?php if (check_permission('tracking', 'exportTracking')) : ?>
                            <li style="float: right;">
                                <a href="<?php echo site_url('tracking/exportTracking?' . $_SERVER['QUERY_STRING']); ?>">
                                    <img width="20" title="Export to excel" src="images/excel-export.png" />
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="dar-table" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                   <th>Name</th>
                                        <th>Phone</th>
                                        <th>WhatsApp</th>
                                        <th>Email</th>
                                        <th>District</th>
                                        <th>Existing Car</th>
                                        <th>Intrested in Purchase </th>
                                        <th>purchase plan period </th>
                                        <th>Date</th> 
                                     <!-- <th>Action</th> -->
                                    
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
$permission=check_permission('festival', 'update');
?>

<script>
$(document).ready(function() {
     var permission = <?php echo $permission; ?>;
     var darTable = $('#dar-table').DataTable({
        "order": [],
        "processing": true,
        "serverSide": true,
        "serverMethod": "post",
        "ajax": site_url + "festivals/list_ajax",

        "columns": [{
                "data": "eve_name"
            },
            {
                "data": "eve_mobile"
            },
            {
               "data": "eve_whatsapp"//
            },
  
            {
               "data": "eve_email"//
            },
  {
     "data": "district_name"
  },
  {
     "data": "eve_vehicle_string"
  },
  {
     "data": "eve_interested_in_car"
  },
  {
     "data": "eve_puchase_period"
  },
  {
     "data": "eve_submitted_at"
  },
         
//             {
//   "render": function(data, type, full, meta) {
//     var eve_id = full.eve_id;
//     var url = "<?php echo site_url('tracking/update/'); ?>/" + "<?php echo encryptor('" + eve_id + "'); ?>";
//     return permission ? '<a href="' + url + '" class="btn btn-primary">Edit</a>' : '';
//   }
// },

 ],
        "buttons": [
            'copy',
            'excel',
            'pdf',
            'print'
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (!aData['eve_submitted_at']) {
                $(nRow).find('td').css({
                    'background-color': 'red',
                    'color': '#fff'
                });
            }
        
            $(nRow).addClass('clickable-row');
            return nRow;
        }
    });
    $('#dar-table tbody').on('click', 'tr', function() {
    var rowData = darTable.row(this).data();
    var darm_id = rowData['eve_id'];
    var url = "<?php echo site_url('tracking/check_in'); ?>/" + "<?php echo encryptor('" + eve_id + "'); ?>";
    
    if (url) {
        window.location.href = url;
    }
});

});
</script>