<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Track List</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="track-table" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Vehicle No</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Variant</th>

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
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": site_url + "tracking/tracking_ajax",
              
               'columns': [{
                         sortable: false,
                         "render": function(data, type, full, meta) {
                              var url = "<?php echo site_url('tracking/trackingLog'); ?>/" + full.val_id;
                              return "<a href='" + url + "'>" + full.val_veh_no + "</a>";

                         }
                    },
                    //{data: 'val_veh_no'},
                    {
                         data: 'brd_title'
                    },
                    {
                         data: 'mod_title'
                    },
                    {
                         data: 'var_variant_name'
                    }

               ],
          });
     });
</script>