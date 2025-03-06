<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Fellowship</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <table id="tblPurchas" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Contact No </th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Source Of Enquiry</th>
                                        <th>Address</th>
                                        <th>Added on</th>
                                        <th>Action</th>
                                        <th>Validate</th>
                                   </tr>
                              </thead>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>

<script>
     $('#tblPurchas').DataTable({
          "order": [
               [1, "asc"]
          ],
          "processing": true,
          "serverSide": true,
          'serverMethod': 'post',
          "ajax": {
               "type": "POST",
               "url": site_url + "web_enq_forms/list_ajax?" + frmData
          },
          "drawCallback": function (settings) {
               $('.txtWebEnqId').val(settings.json.id);
          },
          "columnDefs": [{
                    "targets": [0],
                    "visible": false
               }],
          'columns': [{
                    data: 'web_id'
               },
               {
                    data: 'web_name'
               },
               {
                    data: 'webph_phone'
               },

               {
                    "mData": null,
                    "bSortable": true,
                    "mRender": function (data, type, row) {
                         return purchase_type[data.web_enq_type]
                    }
               },
               {
                    "mData": null,
                    "bSortable": true,
                    "mRender": function (data, type, row) {
                         return data.web_category == 1 ? 'Luxury' : (data.web_category == 2 ? 'Smart' : '')
                    }
               },
               {
                    "mData": null,
                    "bSortable": true,
                    "mRender": function (data, type, row) {
                         return MODE_OF_CONTACT[data.web_source_of_enq] ? MODE_OF_CONTACT[data.web_source_of_enq] : ''
                    }
               },

               {
                    data: 'web_address'
               },
               {
                    data: 'web_created_at'
               },
               {
                    "mData": null,
                    "bSortable": true,
                    "mRender": function (data, type, row) {
                         actionBtn = '<a href="' + dtlsUrl + '/' + data.web_id + '"><i class="fa fa-eye ficon"></i></a>';
                         if (updateUpproval && !isAsmin) {
                              actionBtn += '';
                         } else if (isAsmin) {
                              actionBtn += '<a class="delete-btn" data-id="' + data.web_id + '" href="javascript:void(0)"><i class="fa fa-trash ficon"></i></a>';
                         }
                         return actionBtn;
                    }
               },
               {
                    "mData": null,
                    "bSortable": true,
                    "mRender": function (data, type, row) {
                         actionBtn = data.web_status == 0 ? 'Pending' : FELLOWSHIP_STATUS[data.web_status];
                         // actionBtn = FELLOWSHIP_STATUS[data.web_status];
                         if (updateUpproval && data.web_status == 0) {
                              actionBtn = '<a class="approvalModalk btn btn-success mdl-btn" data-toggle="modal" data-id="' + data.web_id + '" data-target="#approvalModal"><i class="fa fa-check ficon"></i><span> Validate </span></a>';
                         }
                         return actionBtn;
                    }
               }
          ]
     });
</script>