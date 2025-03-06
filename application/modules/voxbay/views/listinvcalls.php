<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Voxbay calls</h2>
                         <i id="divPlayPause" class="stopped fa fa-pause" style="font-size: 24px; margin-top: 5px;margin-left: 20px;float: right;"></i>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="voxbayAllInvCallList" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Date</th>
                                        <th>DID</th>
                                        <th>Customer</th>
                                        <th>CUG</th>
                                        <th>Status</th>
                                        <th>T Caller</th>
                                        <th>Voice</th>
                                        <th>To reg</th>
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
          $('#voxbayAllInvCallList').dataTable({
               "order": [],
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": site_url + "voxbay/fetchData",
               'initComplete': function (settings) {
                    var api = new $.fn.dataTable.Api(settings);
                    setInterval(function () {
                         if (audOnPlay == 0) {
                              api.ajax.reload();
                         }
                    }, 10000);
               },
               'columns': [
                    {data: 'ccb_added_on'},
                    {data: 'ccb_calledNumber'},
                    {
                         sortable: false,
                         "render": function (data, type, full, meta) {
                              var url = "https://api.whatsapp.com/send?phone=" + full.ccb_callerNumber;
                              return "<a href='" + url + "'>" + full.ccb_callerNumber + "</a>";
                         }
                    },
                    {data: 'ccb_AgentNumber'},
                    {data: 'ccb_callStatus'},
                    {data: 'ccb_authorized_person'},
                    {
                         sortable: false,
                         "render": function (data, type, full, meta) {
                              //return '<audio onpause="onPause()" onplay="onPlay();" controls><source src="' + full.ccb_recording_URL + '"/></audio>';
                              return '<a target="blank" href="' + full.ccb_recording_URL + '"><i class="fa fa-play-circle-o" style="font-size:25px;"></i></a>';
                         }
                    },
                    {
                         sortable: false,
                         "render": function (data, type, full, meta) {
                              var url = site_url + "registration/add/" + full.ccb_id+'?mod=1';
                              return "<a href='" + url + "'> <i class='fa fa-arrow-right'></i>";
                         }
                    }
               ]
          });
     });
</script>