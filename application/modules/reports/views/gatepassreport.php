<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Booking gate pass report</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="track-table" class="table table-striped table-bordered display nowrap" 
                                style="width:100%;white-space: nowrap;">
                              <thead>
                                   <tr>
                                        <th>Registration</th>
                                        <th>Stock no</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Variant</th>
                                        <th>Tracking no</th>
                                        <th>Issues by</th>
                                        <th>Gate pass time</th>
                                        <th>Customer</th>
                                        <th>Booking no</th>
                                        <th>Booked by</th>
                                   </tr>
                              </thead>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>
<script>
     $(document).ready(function() {
          $('#track-table').dataTable({
               "order": [],
               "scrollX": true,
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": site_url + "reports/gatepassreportAjax",
               'columns': [{
                         sortable: false,
                         "render": function(data, type, full, meta) {
                              var url = "<?php echo site_url('tracking/trackingLog'); ?>/" + full.val_id;
                              return "<a href='" + url + "'>" + full.val_veh_no + "</a>";
                         }
                    },
                    {data: 'val_stock_num'},
                    {data: 'brd_title'},
                    {data: 'mod_title'},
                    {data: 'var_variant_name'},
                    {data: 'trk_number'},
                    {data: 'added_first_name'},
                    {data: 'trk_out_pass_time'},
                    {data: 'vbk_cust_name'},
                    {data: 'vbk_ref_no'},
                    {data: 'booking_added_username'}
               ]
          });
     });
</script>