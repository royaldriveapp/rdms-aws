<style>
     .approvalModaljjjj {
          position: absolute;
          margin-left: 797px;
          top: 10px;
     }

     .lbl {
          color: black !Important;
     }

     .dialog {
          width: 746px !important;
          margin: 30px auto !important;
     }

     .bg-gray {
          background-color: #cacaca !important;
     }

     .brd-radi {
          border-radius: 0px !important;
          border-top-left-radius: 0px !important;
          border-top-right-radius: 0px !important;
          border-bottom-right-radius: 35px !important;
          border-bottom-left-radius: 35px !important;
     }

     .h-brd-radi {
          border-radius: 0px !important;
          border-top-left-radius: 35px !important;
          border-top-right-radius: 35px !important;
          border-bottom-right-radius: 0px !important;
          border-bottom-left-radius: 0px !important;

     }

     .modal-content {
          border: 7px solid rgba(0, 0, 0, .2) !important;
          border-radius: 42px !important;
     }

     .cus-fdbk-content {
          border: 7px solid rgb(205 204 199 / 26%) !important;
     }

     .modal-dialog.approval_modal {

          width: 837px !important;

     }

     .radio-btn {
          border-radius: 50% !important;
          width: 25px !important;
          height: 25px !important;

          border: 2px solid lightskyblue !important;
          transition: 0.2s all linear !important;
          position: relative !important;
          top: 8px !important;
     }

     .slctwidth {
          width: 270px !important;
     }

     .multiselect {
          width: 269px !important;
     }

     /* togle btn */
     .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
     }

     .switch input {
          opacity: 0;
          width: 0;
          height: 0;
     }

     .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          transition: .4s;
          border-radius: 34px;
     }

     .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          transition: .4s;
          border-radius: 50%;
     }

     input:checked+.slider {
          background-color: #2196F3;
     }

     input:checked+.slider:before {
          transform: translateX(26px);
     }

     input:disabled+.slider {
          background-color: green;
     }

     input:disabled+.slider:before {
          background-color: #e6e6e6;
     }

     /* End toglebtn */
</style>

<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Fellowship</h2>
                         <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <p>
                              <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-filter"></i> Filter
                              </a>
                         </p>
                         <div class="row">
                              <div class="col">
                                   <div class="collapsemulti collapse" id="multiCollapseExample1">
                                        <div class="card card-body">
                                             <form class="x_content frmValuationFilter">
                                                  <table>
                                                       <tr>
                                                            <td>
                                                                 <select data-placeholder="Staff" name="staff[]" class="select2_group filter-form-control staff_id cmbMultiSelect" multiple>
                                                                      <?php foreach ((array) $fellowshipStaff as $key => $fstaff) { ?>
                                                                           <!-- <option value="91<?php echo $fstaff['usr_mobile_personal']; ?>"> -->
                                                                           <option value="<?php echo $fstaff['usr_mobile_personal']; ?>">
                                                                                <?php echo $fstaff['usr_username']; ?></option>
                                                                      <?php } ?>
                                                                 </select>
                                                            </td>
                                                            <td>
                                                                 <select name="category" class="form-control col-md-6 col-sm-6 col-xs-12">
                                                                      <option value="0">All</option>
                                                                      <option value="1">Assigned</option>
                                                                      <option value="2">Pending to assign</option>
                                                                 </select>
                                                            </td>
                                                       </tr>
                                                       <tr>
                                                            <td>
                                                                 <button type="submit" class="btn btn-round btn-primary btnFilter"><i class="fa fa-filter"></i> Filter</button>
                                                            </td>
                                                       </tr>
                                                  </table>

                                             </form>
                                        </div>
                                   </div>
                              </div>
                              <div>
                                   <?php if (isset($analysis) && !empty($analysis)) { ?>
                                        <table class="table table-striped table-bordered">
                                             <tr>
                                                  <th>Staff</th>
                                                  <th>Total</th>
                                                  <th>Pending</th>
                                                  <th>Done</th>
                                             </tr>
                                             <?php foreach ($analysis as $idx => $anl) {
                                                  $username = !empty($anl['usr_username']) ? $anl['usr_username'] : 'Unassigned';
                                                  echo "<tr><td>" . $username . "</td><td>" . $anl['total'] . "</td><td>" . $anl['pending'] . "</td><td>" . $anl['done'] . "</td></tr>";
                                             } ?>
                                             <tr>
                                                  <td></td>
                                                  <td><?php echo array_sum(array_column($analysis, 'total')); ?></td>
                                                  <td><?php echo array_sum(array_column($analysis, 'pending')); ?></td>
                                                  <td><?php echo array_sum(array_column($analysis, 'done')); ?></td>
                                             </tr>
                                        </table>
                                   <?php } ?>
                              </div>
                         </div>
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
          <?php if (check_permission('registration', 'allowquickaressignregister')) { ?>
               <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel tile fixed_height_320" style="overflow: scroll;">
                         <div class="x_title">
                              <h2>Assign to staff</h2>
                              <div class="clearfix"></div>
                         </div>
                         <div class="dashboard-widget-content">
                              <div class="x_content">
                                   <form class="frmQuickAssign" data-url="<?php echo site_url('web_enq_forms/assignToStaff?t=22'); ?>" method="get">
                                        <input type="hidden" name="txtWebEnqId" class="txtWebEnqId" value="" />
                                        <table style="width: 100%;">
                                             <tr>
                                                  <td style="padding-left: 10px;">
                                                       <!-- <select multiple="multiple" class="cmbSearchList select2_group form-control" name="executive[]"> -->
                                                       <select multiple="multiple" class="select2_group form-control" name="executive[]">
                                                            <?php foreach ((array) $salesStaff as $key => $value) { ?>
                                                                 <option value="<?php echo $value['usr_id']; ?>">
                                                                      <?php echo $value['usr_username']; ?></option>
                                                            <?php } ?>
                                                       </select>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td style="padding:10px;">
                                                       <textarea placeholder="Desction" name="desc" class="select2_group form-control" required></textarea>
                                                  </td>
                                             </tr>
                                             <tr>
                                                  <td style="padding-left: 10px;">
                                                       <button type="submit" class="btn btn-round btn-primary">Assign</button>
                                                  </td>
                                             </tr>
                                        </table>
                                   </form>
                              </div>
                         </div>
                    </div>
               </div>
          <?php } ?>
     </div>
</div>

<div class="modal fade" id="approvalModal" role="dialog">
     <div class="modal-dialog approval_modal">
          <?php echo form_open_multipart("web_enq_forms/validate", array('id' => "approval-modal", 'class' => "submitApproval approval_modal modal-content form-horizontal form-label-left")) ?>

          <div class="modal-header bg-gray h-brd-radi">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title lbl"> Validate <span class="msg"></span></h4>
          </div>
          <div class="modal-body bg-gray brd-radi">
               <div class="mdl_div">
                    <div class='flds'>
                         <div class="row">
                              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                   <label class="control-label lbl">Enter Remarks* </label>
                                   <textarea name='remarks' class="form-control col-md-7 col-xs-12 " placeholder="Remarks" required></textarea>
                              </div>
                         </div>
                         <input type='hidden' name='web_id' id='web_id'>


                         <div class="row">
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <label class="control-label lbl">Validate* </label>
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

<div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <strong> Updated successfully!</strong>
</div>

<div class="alert alert-danger alert-dismissible fade in ErrorMsgBox" role="alert" style="display: none;">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <strong>Error:Could not be submitted successfully!</strong>
</div>
<script>
     var updateUpproval = "<?php echo check_permission('web_enq_forms', 'Validate') ? true : false; ?>";
     var canEdit = "<?php echo check_permission('web_enq_forms', 'edit') ? true : false; ?>";
     var isAsmin = "<?php echo ($this->uid == 100) ? true : false; ?>";
     var purchase_type = <?php echo json_encode(unserialize(WEB_FORM_ENQ_TYPE)); ?>;
     var MODE_OF_CONTACT = <?php echo json_encode(unserialize(MODE_OF_CONTACT)); ?>;
     var FELLOWSHIP_STATUS = <?php echo json_encode(unserialize(FELLOWSHIP_STATUS)); ?>;
     var dtlsUrl = "<?php echo site_url('web_enq_forms/details'); ?>";
     var deleteUrl = "<?php echo site_url('web_enq_forms/delete'); ?>";
     var actionBtn = '';

     $(document).ready(function() {
          $('[data-toggle="tooltip"]').tooltip();
          var canDelete = "<?php echo is_roo_user() ? 1 : 0; ?>";
          puchaseList(canDelete, $('.frmValuationFilter').serialize());
          $(document).on('submit', '.frmValuationFilter', function(e) {
               e.preventDefault();
               puchaseList(canDelete, $(this).serialize());
          });
          $(document).on('click', '.mdl-btn', function(e) {
               e.preventDefault();
               var webID = $(this).data('id');
               console.log("Clicked. web_id: " + webID); // Debugging line
               $('#web_id').val(webID);
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
                    "url": site_url + "web_enq_forms/list_ajax?" + frmData
               },
               "drawCallback": function(settings) {
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
                         "mData": null,
                         "bSortable": true,
                         "mRender": function(data, type, row) {
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
                         "mRender": function(data, type, row) {
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
                         "mRender": function(data, type, row) {
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
          var deleteUrl = "<?php echo site_url('web_enq_forms/delete'); ?>/" + webId;

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