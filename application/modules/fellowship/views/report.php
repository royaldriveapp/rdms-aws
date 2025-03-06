<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Fellowship Report</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <?php if (check_permission($controller, 'export_report')) { ?>
                                   <li style="float: right;">
                                        <a class="btnExport" href="javascript:void(0);">
                                             <img width="20" title="Export to excel" src="images/excel-export.png" />
                                        </a>
                                   </li>
                              <?php } ?>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                         <!-- filter -->
                         <?php if (check_permission('fellowship', 'show_filter')) { ?>
                              <p>
                                   <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-filter"></i>
                                        Filter
                                   </a>
                              </p>
                         <?php } ?>
                         <div class="row">
                              <div class="col">
                                   <div class="collapsemulti collapse" id="multiCollapseExample1">
                                        <div class="card card-body">
                                             <form class="x_content frmValuationFilter">
                                                  <table>
                                                       <tr>
                                                            <td>
                                                                 <select data-placeholder="Lead Added By" name="staff[]" class="select2_group filter-form-control staff_id cmbMultiSelect" multiple>
                                                                      <?php foreach ((array) $fellowshipStaff as $key => $fstaff) { ?>
                                                                           <option value="<?php echo $fstaff['usr_mobile_personal']; ?>">
                                                                                <?php echo $fstaff['usr_username']; ?></option>
                                                                      <?php } ?>
                                                                 </select>
                                                            </td>
                                                            <td style="padding-left: 10px;">
                                                                 <?php if (check_permission('fellowship', 'show_all_reports')) { ?>
                                                                      <select data-placeholder="Sales Head" name="tl[]" class="select2_group filter-form-control tl_id cmbMultiSelect" multiple>
                                                                           <?php foreach ((array) $teamLeads as $key => $TL) { ?>
                                                                                <option value="<?php echo $TL['usr_id']; ?>">
                                                                                     <?php echo $TL['usr_username']; ?></option>
                                                                           <?php } ?>
                                                                      </select>
                                                                 <?php } ?>
                                                            </td>
                                                            <td style="padding-left: 10px;">
                                                                 <select data-placeholder="Status" name="status[]" class="select2_group filter-form-control status cmbMultiSelect" multiple>
                                                                      <?php foreach ((array) $FELLOWSHIP_STATUS as $key => $status) { ?>
                                                                           <option value="<?php echo $key; ?>">
                                                                                <?php echo $status; ?></option>
                                                                      <?php } ?>
                                                                 </select>
                                                            </td>
                                                            <td style="padding-left: 10px;">
                                                                 <input style="width:100px;" autocomplete="off" name="validated_at" type="text" class="dtpDatePickerDMY form-control col-md-7 col-xs-12" placeholder="Validated on" />
                                                            </td>
                                                            <td style="padding-left: 10px;">
                                                                 <input style="width:100px;" autocomplete="off" name="web_created_at_fr" type="text" class="dtpDatePickerDMY form-control col-md-7 col-xs-12" placeholder="Added from" />
                                                            </td>
                                                            <td style="padding-left: 10px;"><input style="width:100px;" autocomplete="off" name="web_created_at_to" type="text" class="dtpDatePickerDMY form-control col-md-7 col-xs-12" placeholder="Added to" />
                                                            </td>
                                                            <td style="padding-left: 10px;">
                                                                 <select class="select2_group form-control" name="executive">
                                                                      <option value="0">Assign to</option>
                                                                      <?php foreach ((array) $salesStaff as $key => $value) { ?>
                                                                           <option value="<?php echo $value['usr_id']; ?>">
                                                                                <?php echo $value['usr_username']; ?></option>
                                                                      <?php } ?>
                                                                 </select>
                                                            </td>
                                                            <td>
                                                                 <button type="submit" class="btn btn-round btn-primary btnFilter"><i class="fa fa-filter"></i> Filter</button>
                                                            </td>
                                                       </tr>
                                                  </table>
                                             </form>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <!-- End filter -->
                    </div>
                    <div class="x_content">
                         <table id="tblPurchas" class="table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>ID</th>
                                        <th colspan="2">Customer</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Added on</th>
                                        <th colspan="2">Lead Added By</th>
                                        <th>Sales Head</th>
                                        <th>Sales Staff</th>
                                        <th>Status</th>
                                        <th>Validated on</th>
                                        <th>Remarks</th>
                                        <th>Revenue</th>
                                   </tr>
                                   <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Contact No</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                   </tr>
                              </thead>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>
<!-- Approval model -->
<div class="modal fade" id="approvalModal" role="dialog">
     <div class="modal-dialog approval_modal">
          <?php echo form_open_multipart("fellowship/validate", array('id' => "approval-modal", 'class' => "submitApproval approval_modal modal-content form-horizontal form-label-left")) ?>

          <div class="modal-header bg-gray h-brd-radi">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title lbl"> Validate <span class="msg"></span></h4>
          </div>
          <div class="modal-body bg-gray brd-radi">
               <div class="mdl_div">
                    <div class='flds'>
                         <div class="row">
                              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                   <label class="control-label lbl">Enter Remarks </label>
                                   <textarea name='remarks' class="form-control col-md-7 col-xs-12 " placeholder="Remarks"></textarea>
                              </div>
                         </div>
                         <input type='hidden' name='web_id' id='web_id'>
                         <div class="row">
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <label class="control-label lbl">Validate </label>
                                   <div class="form-check">
                                        <input class="form-check-input radio-btn" type="radio" name="validate" value="1" id="flexRadioDisabled">
                                        <label class="form-check-label" for="expet_booking">
                                             <span class="lbl">Yes</span>
                                        </label>
                                        <input class="form-check-input radio-btn" type="radio" name="validate" value="5" id="flexRadioDisabled">
                                        <label class="form-check-label" for="expet_booking">
                                             <span class="lbl">No</span>
                                        </label>
                                   </div>
                              </div>
                         </div>
                         <div class="row">
                              <div class="form-group col-md-6 col-sm-6 col-xs-12"></div>
                         </div>
                    </div>
               </div>
               <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
               <?php echo form_close() ?>
          </div>
     </div>
</div>
<!-- Approvalmodel -->
<div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <strong> Updated successfully!</strong>
</div>

<div class="alert alert-danger alert-dismissible fade in ErrorMsgBox" role="alert" style="display: none;">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <strong>Error:Could not be submitted successfully!</strong>
</div>
<script>
     var updateUpproval = "<?php echo check_permission('fellowship', 'Validate') ? true : false; ?>";
     var canEdit = "<?php echo check_permission('fellowship', 'edit') ? true : false; ?>";
     var isAsmin = "<?php echo ($this->uid == 100) ? true : false; ?>";
     var purchase_type = <?php echo json_encode(unserialize(WEB_FORM_ENQ_TYPE)); ?>;
     var MODE_OF_CONTACT = <?php echo json_encode(unserialize(MODE_OF_CONTACT)); ?>;
     var FELLOWSHIP_STATUS = <?php echo json_encode(unserialize(FELLOWSHIP_STATUS)); ?>;
     var dtlsUrl = "<?php echo site_url('fellowship/details'); ?>";
     var deleteUrl = "<?php echo site_url('fellowship/delete'); ?>";
     var actionBtn = '';

     $(document).ready(function() {
          $('[data-toggle="tooltip"]').tooltip();
          var canDelete = "<?php echo is_roo_user() ? 1 : 0; ?>";
          puchaseList(canDelete, $('.frmValuationFilter').serialize());
          $(document).on('submit', '.frmValuationFilter', function(e) {
               e.preventDefault();
               puchaseList(canDelete, $(this).serialize());
          });
          //Model
          $(document).on('click', '.mdl-btn', function(e) {
               e.preventDefault();
               var webID = $(this).data('id');
               console.log("Clicked. web_id: " + webID); // Debugging line
               $('#web_id').val(webID);
          });
          // exp
          $(document).on('click', '.btnExport', function(e) {
               $.ajax({
                    type: 'post',
                    url: site_url + "fellowship/export_report?" + $('.frmValuationFilter').serialize(),
                    dataType: 'json',
                    success: function(resp) {
                         window.location.href = resp;
                    }
               });
          });
     });

     function puchaseList(canDelete, frmData) {
          var editUrl = "<?php echo site_url('purchase/edit'); ?>";
          $('#tblPurchas').DataTable().clear().destroy();
          $('#tblPurchas').DataTable({
               "order": [
                    [1, "asc"]
               ],
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": {
                    "type": "POST",
                    "url": site_url + "fellowship/report_ajax?" + frmData
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
                         "mRender": function(data, type, row) {
                              return purchase_type[data.web_enq_type]
                         }
                    },
                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function(data, type, row) {
                              return data.web_category == 1 ? 'Luxury' : (data.web_category == 2 ? 'Smart' : '')
                         }
                    },

                    {
                         data: 'web_created_at'
                    },
                    {
                         data: 'added_usr_username'
                    },
                    {
                         data: 'web_usr_phone'
                    },
                    {
                         data: 'team_lead_first_name'
                    },
                    // {
                    //      "mData": null,
                    //      "bSortable": true,
                    //      "mRender": function(data, type, row) {
                    //           return data.team_lead_first_name+'-fell_id='+data.usrtb_id
                    //      }
                    // },
                    {
                         data: 'sales_staff'
                    },
                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function(data, type, row) {
                              var webStatus = data.web_status;
                              var fellStatus = (webStatus != 0) ?
                                   (FELLOWSHIP_STATUS[webStatus] || 'Unknown Status') :
                                   'Pending';
                              // console.log(`${fellStatus} - status: ${webStatus} - webId: ${data.web_id}`);   
                              return fellStatus;
                         }
                    },

                    {
                         data: 'web_validated_on'
                    },
                    {
                         data: 'web_status_cmd'
                    },
                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function(data, type, row) {
                              return '0.00'
                         }
                    },
               ]
          });
          $('#tblPurchas tbody').on('click', 'tr', function() {
               var data = $('#tblPurchas').DataTable().row(this).data();
               var url = "<?php echo site_url('Purchase/printPurchase'); ?>" + "/" + data.web_id;
               //window.location.href = url;
          });
     }
     /*Delete*/
     $(document).on('click', '.delete-btn', function(e) {
          e.preventDefault();
          var webId = $(this).data('id');
          var deleteUrl = "<?php echo site_url('fellowship/delete'); ?>/" + webId;

          if (confirm('Are you sure you want to delete this record?')) {
               $.ajax({
                    type: 'POST',
                    url: deleteUrl,
                    data: {
                         web_id: webId
                    }, // Ensure this is sent in the POST data
                    success: function(response) {
                         response = JSON.parse(response); // Parse the JSON response
                         if (response.status === 'success') {
                              alert('Record deleted successfully');
                              $('#tblPurchas').DataTable().ajax.reload(); // Reload the DataTable
                         } else {
                              alert('Failed to delete the record');
                         }
                    },
                    error: function(xhr, status, error) {
                         alert('An error occurred: ' + error);
                    }
               });
          }
     });

     /*End Delete*/
     $(document).on('submit', ".submitApproval", function(e) {
          e.preventDefault();
          var url = $(this).attr('action');
          var formData = new FormData($(this)[0]);
          $.ajax({
               type: 'post',
               url: url,
               dataType: 'json',
               data: formData,
               async: false,
               cache: false,
               contentType: false,
               processData: false,
               beforeSend: function(xhr) {
                    //  $('.divLoading').show();
               },
               success: function(resp) {
                    $('.divLoading').hide();
                    $('.msgBox').show();
                    setTimeout(function() {
                         $('.msgBox').fadeOut();
                    }, 1500);
                    $("#approval-modal").trigger("reset");
                    $("#approvalModal").modal("hide");
                    var canDelete = "<?php echo is_roo_user() ? 1 : 0; ?>";
                    puchaseList(canDelete);
               }
          });
     });
</script>