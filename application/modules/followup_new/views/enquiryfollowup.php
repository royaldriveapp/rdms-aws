<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Register followup</h2>
                         <i id="divPlayPause" class="stopped fa fa-pause" style="font-size: 24px; margin-top: 5px;margin-left: 20px;float: right;"></i>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="dtbRegisterFollowup" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Name</th>
                                        <th>Sales Executive</th>
                                        <th>Type</th>
                                        <th>Mobile</th>
                                        <th>Whatsapp</th>
                                        <th>Next Follow up Date</th>
                                   </tr>
                              </thead>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>

<script>
     $(document).ready(function () {
          $('#dtbRegisterFollowup').dataTable({
               "order": [],
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": site_url + "followup/enquiryfollowup_ajax",
               'columns': [
                    {data: 'enq_cus_name'},
                    {data: 'usr_first_name'},
                    {data: 'enq_cus_status'},
                    {data: 'enq_cus_mobile'},
                    {data: 'enq_cus_whatsapp'},
                    {data: 'enq_next_foll_date'}
               ]
          });
     });
</script>