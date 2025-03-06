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
</style>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <table id="tblPurchas" class="table table-striped table-bordered">
                         <thead>
                              <tr>
                                   <th>ID</th>
                                   <th>Name</th>
                                   <th>Phone</th>
                                   <th>Reg Number</th>
                                   <th>Vehicle</th>
                                   <?php if (check_permission('purchase', 'showfinancedetails')) { ?>
                                        <th>Refurb total </th>
                                        <th>Advance</th>
                                        <th>Fine</th>
                                        <th>Brokerage</th>
                                        <th>Insurance</th>
                                        <th>Total</th>
                                        <th>Remarks</th>
                                   <?php } ?>
                                   <th>Added by</th>
                                   <th>Added on</th>
                                   <th>Action</th>
                                   <?php echo ($this->uid == 100) ? '<th>D</th>' : ''; ?>
                              </tr>
                         </thead>
                    </table>
               </div>
          </div>
     </div>
</div>
<!-- Approval model -->
<div class="modal fade" id="approvalModal" role="dialog">
     <div class="modal-dialog approval_modal">
          <?php echo form_open_multipart("purchase/update_approval", array('id' => "approval-modal", 'class' => "submitApproval approval_modal modal-content form-horizontal form-label-left")) ?>

          <div class="modal-header bg-gray h-brd-radi">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title lbl"> Approve <span class="msg"></span></h4>
          </div>
          <div class="modal-body bg-gray brd-radi">
               <div class="mdl_div">
                    <div class='flds'>
                         <div class="row">
                              <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                   <label class="control-label lbl">Enter Remarks </label>
                                   <textarea required name='pr_approve_remarks' class="form-control col-md-7 col-xs-12 " placeholder="Remarks"></textarea>
                              </div>
                         </div>
                         <input type='hidden' name='pr_id' id='pr_id'>
                         <input type='hidden' name='pr_val_id' id='pr_val_id'>
                         <input type='hidden' name='pr_enq_id' id='pr_enq_id'>

                         <div class="row">
                              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                   <label class="control-label lbl">Approve </label>
                                   <div class="form-check">
                                        <input checked class="form-check-input radio-btn" type="radio" name="pr_approve" value="1" id="flexRadioDisabled">
                                        <label class="form-check-label" for="expet_booking">
                                             <span class="lbl">Yes</span>
                                        </label>
                                        <input class="form-check-input radio-btn" type="radio" name="pr_approve" value="0" id="flexRadioDisabled">
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
     var updateUpproval = "<?php echo check_permission('purchase', 'update_approval') ? true : false; ?>";
     var canEdit = "<?php echo check_permission('purchase', 'edit') ? true : false; ?>";
     var isAsmin = "<?php echo ($this->uid == 100) ? true : false; ?>";
     var printUrl = "<?php echo site_url('purchase/delete'); ?>";

     var actionBtn = '';
     $(document).ready(function() {
          $(document).on('click', '.mdl-btn', function(e) {
               e.preventDefault();
               var prId = $(this).data('id');
               var prValId = $(this).data('val-id');
               var prEnqId = $(this).data('enq-id');
               console.log("Clicked. pr_id: " + prId); // Debugging line
               $('#pr_id').val(prId);
               $('#pr_val_id').val(prValId);
               $('#pr_enq_id').val(prEnqId);
          });
     });

     $(document).ready(function() {
          $('[data-toggle="tooltip"]').tooltip();
          var canDelete = "<?php echo is_roo_user() ? 1 : 0; ?>";
          puchaseList(canDelete);
     });

     function puchaseList(canDelete) {
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
                    "url": site_url + "purchase/list_ajax?"
               },
               "columnDefs": [{
                    "targets": [0],
                    "visible": false
               }],
               'columns': [{
                         data: 'pr_id'
                    }, {
                         data: 'enq_cus_name'
                    },
                    {
                         data: 'enq_cus_mobile'
                    },
                    {
                         data: 'pr_reg_no'
                    },
                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function(data, type, row) {
                              // return 'hi';
                              return data.brd_title + ' | ' + data.mod_title + ' | ' + data.var_variant_name;
                         }
                    },
                    <?php if (check_permission('purchase', 'showfinancedetails')) { ?> {
                              data: 'pr_refurb_total'
                         },
                         {
                              data: 'pr_advance'
                         },
                         {
                              data: 'pr_fine'
                         },
                         {
                              data: 'pr_brokerage'
                         },
                         {
                              data: 'pr_insurance'
                         },
                         {
                              data: 'pr_total'
                         },
                         {
                              data: 'pr_remarks'
                         },
                    <?php } ?> {
                         data: 'added_usr_username'
                    },
                    {
                         data: 'pr_added_date'
                    }, //Fuel
                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function(data, type, row) {
                              if (updateUpproval) {
                                   //   return '<button type="button" class="approvalModalk btn btn-success mdl-btn" data-toggle="modal" data-id="'+data.pr_id+'" data-target="#approvalModal">Approve</button>';
                                   // return '<a class="approvalModalk btn btn-success mdl-btn" data-toggle="modal" data-id="'+data.pr_id+'" data-val-id="'+data.pr_val_id+'" data-target="#approvalModal"><i class="fa fa-plus ficon "></i><span> Approve </span></a> &nbsp <a class="btn btn-info addStock-btn  tip addStock-' + data.pr_id + '" href="' + editUrl + '/' + data.pr_id + '"><i class="fa fa-edit ficon"></i><span>Edit </span></a>';
                                   actionBtn = '<a class="approvalModalk btn btn-success mdl-btn" data-toggle="modal" data-id="' + data.pr_id + '" data-val-id="' + data.pr_val_id + '" data-enq-id="' + data.pr_enq_id + '" data-target="#approvalModal"><i class="fa fa-plus ficon "></i><span> Approve </span></a>';

                              }
                              return actionBtn;
                         }
                    },
                    {
                         "visible": isAsmin,
                         "mData": null,
                         "bSortable": true,
                         "mRender": function(data, type, row) {
                              return '<a class="prnt-btn tip" href="' + printUrl + '/' + data.pr_id + '"><i class="fa fa-trash"></i></a>';
                         }
                    }
               ],
               "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData['val_status'] == "0") {
                         $('td', nRow).css('background-color', 'Red');
                         $('td', nRow).css('color', '#fff');
                    } else if (aData['val_status'] == "1") {
                         $('td', nRow).css('background-color', 'yellowgreen');
                         $('td', nRow).css('color', '#fff');
                    } else if (aData['val_status'] == "39") {
                         $('td', nRow).css('background-color', 'gray');
                         $('td', nRow).css('color', '#fff');
                    }
               }
          });
          $('#tblPurchas tbody').on('click', 'tr', function() {
               var data = $('#tblPurchas').DataTable().row(this).data();
               var url = "<?php echo site_url('Purchase/printPurchase'); ?>" + "/" + data.pr_id;
               //window.location.href = url;
          });
     }

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