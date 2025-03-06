<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Voxbay all connected calls</h2>
                         <i id="divPlayPause" class="stopped fa fa-pause" style="font-size: 24px; margin-top: 5px;margin-left: 20px;float: right;"></i>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="voxbayAllConctCal" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Date</th>
                                        <th>DID</th>
                                        <?php if(is_roo_user()) { ?>
                                             <th>Customer</th>
                                        <?php } ?>
                                        <th>CUG</th>
                                        <!--<th>Status</th>-->
                                        <th>End point</th>
                                        <th>Voice</th>
                                   </tr>
                              </thead>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>
<?php if(is_roo_user()) { ?>
     <script>
          $(document).ready(function () {
               $('#voxbayAllConctCal').dataTable({
                    "order": [],
                    "processing": true,
                    "serverSide": true,
                    'serverMethod': 'post',
                    "ajax": site_url + "voxbay/allconnectedcall_ajax",
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
     //                    {data: 'ccb_callStatus'},
                         {data: 'ccb_authorized_person'},
                         {
                              sortable: false,
                              "render": function (data, type, full, meta) {
                                   //return '<audio onpause="onPause()" onplay="onPlay();" controls><source src="' + full.ccb_recording_URL + '"/></audio>';
                                   return '<a target="blank" href="' + full.ccb_recording_URL + '"><i class="fa fa-play-circle-o" style="font-size:25px;"></i></a>';
                              }
                         }
                    ]
               });
          });
     </script>
<?php } else { ?>
     <script>
          $(document).ready(function () {
               $('#voxbayAllConctCal').dataTable({
                    "order": [],
                    "processing": true,
                    "serverSide": true,
                    'serverMethod': 'post',
                    "ajax": site_url + "voxbay/allconnectedcall_ajax",
                    'columns': [
                         {data: 'ccb_added_on'},
                         {data: 'ccb_calledNumber'},
                         {data: 'ccb_AgentNumber'},
                         {data: 'ccb_authorized_person'},
                         {
                              sortable: false,
                              "render": function (data, type, full, meta) {
                                   return '<a target="blank" href="' + full.ccb_recording_URL + '"><i class="fa fa-play-circle-o" style="font-size:25px;"></i></a>';
                              }
                         }
                    ]
               });
          });
     </script>
<?php } ?>
