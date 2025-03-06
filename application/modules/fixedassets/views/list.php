<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Fixed assets list</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="track-table" class="table table-striped table-bordered">
                         <thead>
                                   <tr>
                                        <th>Asset No</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Company</th>
                                        <th>SL No</th>
                                        <th>Warranty</th>
                                        <th>Added by</th>
                                        <th>Purchased on</th>
                                        <th>Vendor</th>
                                        <th>Issued to</th>
                                        <th>Issued on</th>
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
               "ajax": site_url + "fixedassets/fixedasset_ajax",
         
               'columns': [ {
                         data: 'fap_number'
                    },
                   
                    {
                         data: 'fap_name'
                    },
                    {
                         data: 'sub_category_name'
                    },
                    {
                         data: 'facm_title'
                    },
                    {
                         data: 'fap_slno'
                    },
                    {
                         data: 'fap_warty_till'
                    },
                    {
                         data: 'addedby_first_name'
                    },
                    {
        "sortable": false,
        "render": function(data, type, full, meta) {
          if(full.fap_pur_date){
               var fap_pur_date = new Date(full.fap_pur_date).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' }).replace(/\//g, '-');
          return fap_pur_date;
          }
          return '';
          
        }
      },
                    {
                         data: 'fap_vendor'
                    },
                    {
                         data: 'owner_first_name'
                    },
                    {
        "sortable": false,
        "render": function(data, type, full, meta) {
          if(full.fap_issue_on){
               var fap_issue_on = new Date(full.fap_issue_on).toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' }).replace(/\//g, '-');
          return fap_issue_on;
          }
          return '';
          
        }
      },

               ],
          });
     });
</script>