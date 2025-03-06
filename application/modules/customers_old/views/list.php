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
                         <h2>Customers  <a href="<?php echo site_url($controller . '/create'); ?>" class="btn btn-success">+Add New Customer</a>
                                             </h2></h2>
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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone No</th>
                                    
                                        <th>WhatsApp</th>
                                        <th>Email</th>
                                        <th>Place</th>
                                        <th>District</th>
                                        <th>Action</th>
                                            <!-- 
                                      
                                       
                                        <th>Address</th>
                                        <th>Phone office</th> 
                                        <th>Phone resi</th> 
                                        <th>Profession</th> 
                                        <th>Company</th> 
                                        <th>fb</th> 
                                        <th>Action</th> -->
                                    
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
$permission=check_permission('tracking', 'update');
?>

<script>
$(document).ready(function() {
     var permission = <?php echo $permission; ?>;
     var darTable = $('#dar-table').DataTable({
        "order": [],
        "processing": true,
        "serverSide": true,
        "serverMethod": "post",
        "ajax": site_url + "customers/list_ajax",

        "columns": [{
                "data": "cusd_id"
            },
            {
                "data": "cusd_name"
            },
         
            {
                "data": "cusd_address"
            },
            {
                "data": "phoneNumbers"
            },
            {
               "data": "cusd_whatsapp"//
            }, 
             {
               "data": "cusd_email"//
            },
          
            {
               "data": "cusd_place"//
            },
            {
               "data": "district"//
            },
            // {
            //    "data": "occ_name"//
            // },
            // {
            //    "data": "cusd_company"//
            // },
            // {
            //    "data": "cusd_fb"//
            // },
            {
  "render": function(data, type, full, meta) {
    var cusd_id = full.cusd_id;
    var url = "<?php echo site_url('customers/edit/'); ?>/" + "<?php echo encryptor('" + cusd_id + "'); ?>";
    return permission ? '<a href="' + url + '" class="btn btn-warning"><i class="fa fa-edit"></i></a>' : '';
  }
},

 ],
        "buttons": [
            'copy',
            'excel',
            'pdf',
            'print'
        ],
        // "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //     if (!aData['trk_check_in_date']) {
        //         $(nRow).find('td').css({
        //             'background-color': 'red',
        //             'color': '#fff'
        //         });
        //     }
        
        //     $(nRow).addClass('clickable-row');
        //     return nRow;
        // }
    });
    $('#dar-table tbody').on('click', 'tr', function() {
    var rowData = darTable.row(this).data();
    var darm_id = rowData['cusd_id'];
    var url = "<?php echo site_url('tracking/check_in'); ?>/" + "<?php echo encryptor('" + cusd_id + "'); ?>";
    
    if (url) {
        window.location.href = url;
    }
});

});
</script>