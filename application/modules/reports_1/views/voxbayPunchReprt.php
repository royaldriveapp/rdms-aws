<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Voxbay calls</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="tblVoxbayPunchReprt" class="table table-striped table-bordered dt-responsive nowrap">
                              <thead>
                                   <tr>
                                        <th>DID</th>
                                        <th>Customer Number</th>
                                        <th>CUG</th>
                                        <th>Call duration</th>
                                        <th>Called on</th>
                                        <th>Punched on</th>
                                        <th>Punched by</th>
                                        <th>Sales staff commented on</th>
                                        <th>Record</th>
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
          $('#tblVoxbayPunchReprt').DataTable({
               "order": [[5, "desc"]],
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": {
                    "type": "POST",
                    "url": site_url + "reports/voxbayPunchReprt_ajax"
               },
               'columns': [
                    {data: 'ccb_calledNumber'},
                    {data: 'ccb_callerNumber'},
                    {
                         sortable: true,
                         "render": function (data, type, full, meta) {
                              var name = (full.ccb_authorized_person != null) ? full.ccb_authorized_person : '';
                              return full.ccb_AgentNumber + '<br> <span style="font-size:9px;">' + name + '</span>';
                         }
                    },
                    {data: 'ccb_totalCallDuration'},
                    {
                         data: 'ccb_callDate',
                         sortable: true,
                         "render": function (data, type, full, meta) {
                              var ccb_callDate = (full.ccb_callDate != null) ? full.ccb_callDate : '';
                              var ccb_callTime = (full.ccb_callTime != null) ? full.ccb_callTime : '';
                              return ccb_callDate + '<br>' + ccb_callTime;
                         }
                    },
                    {
                         data: 'vreg_added_on',
                         sortable: true,
                         "render": function (data, type, full, meta) {
                              var vreg_added_on = (full.vreg_added_on != null) ? full.vreg_added_on : '';
                              var vreg_added_time = (full.vreg_added_time != null) ? full.vreg_added_time : '';
                              return vreg_added_on + '<br>' + vreg_added_time;
                         }
                    },
                    {data: 'addedby_usr_first_name'},
                    {
                         data: 'vreg_se_commented_on',
                         sortable: true,
                         "render": function (data, type, full, meta) {
                              var vreg_se_commented_on = (full.vreg_se_commented_on != null) ? full.vreg_se_commented_on : '';
                              return vreg_se_commented_on;
                         }
                    },
                    {
                         sortable: false,
                         "render": function (data, type, full, meta) {
                              return '<audio controls><source src="' + full.ccb_recording_URL + '"/></audio>';
                         }
                    }
               ]
          });
     });
</script>