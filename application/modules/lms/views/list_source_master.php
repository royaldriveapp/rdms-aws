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
                    <table id="tblLms" class="table table-striped table-bordered">
                         <thead>
                              <tr>
                                   <th>ID</th>
                                   <th>Source</th>
                                   <th>Funnel</th>
                                   <th>Status</th>
                                 
                                   <th>Action</th>
                                  
                              </tr>
                         </thead>
                    </table>
               </div>
          </div>
     </div>
</div>
<!-- Approval model -->

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
      var canEdit = "<?php echo check_permission('lms', 'edit_source_master') ? true : false; ?>";
   
     var isAsmin = "<?php echo ($this->uid == 100) ? true : false; ?>";
    

     var actionBtn = '';
     $(document).ready(function() {
          $(document).on('click', '.mdl-btn', function(e) {
               e.preventDefault();
               var prId = $(this).data('id');
               var prValId = $(this).data('val-id');
               var prEnqId = $(this).data('enq-id');
               console.log("Clicked. cmd_mod_id: " + prId); // Debugging line
               $('#cmd_mod_id').val(prId);
               $('#cmd_mod_id').val(prValId);
               $('#cmd_mod_id').val(prEnqId);
          });
     });

     $(document).ready(function() {
          $('[data-toggle="tooltip"]').tooltip();
          var canDelete = "<?php echo check_permission('lms', 'delete_source_master') ? true : false; ?>";
          puchaseList(canDelete);
     });

     function puchaseList(canDelete) {
          var editUrl = "<?php echo site_url('lms/edit_source_master'); ?>";
          var deleteUrl = "<?php echo site_url('lms/delete_source_master'); ?>";
              
          $('#tblLms').DataTable().clear().destroy();
          $('#tblLms').DataTable({
               "order": [
                    [1, "asc"]
               ],
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": {
                    "type": "POST",
                    "url": site_url + "lms/list_source_master_ajax?"
               },
               "columnDefs": [{
                    "targets": [0],
                    "visible": false
               }],
               'columns': [{
                         data: 'cmd_mod_id'
                    },
                    {
                         data: 'cmd_title'
                    },
                    {
                         data: 'sfnl_funnel'
                    },

                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function(data, type, row) {
                              var active ='Inactive';
                              if (data.cmd_status==1) {
                                   
                                   active = 'Active';

                              }
                              return active;
                         }
                    },
                   
                    {
                         "mData": null,
                         "bSortable": true,
                         "mRender": function(data, type, row) {

                              if (canEdit && canDelete) {
                                   
                                   actionBtn = '<a class="prnt-btn tip" href="' + editUrl + '/' + data.cmd_mod_id + '"><i class="fa fa-edit"></i> </a>  <a class="prnt-btn tip" href="' + deleteUrl + '/' + data.cmd_mod_id + '"><i class="fa fa-trash"></i></a>';

                              }else if(canEdit){
                                   actionBtn = '<a class="prnt-btn tip" href="' + editUrl + '/' + data.cmd_mod_id + '"><i class="fa fa-edit"></i> </a>';
                              }else if(canDelete){
                                   actionBtn = '<a class="prnt-btn tip" href="' + deleteUrl + '/' + data.cmd_mod_id + '"><i class="fa fa-trash"></i></a>';
                              }
                              return actionBtn;
                         }
                    },
                 
                    // {
                    //      "visible": isAsmin,
                    //      "mData": null,
                    //      "bSortable": true,
                    //      "mRender": function(data, type, row) {
                    //           return '<a class="prnt-btn tip" href="' + printUrl + '/' + data.cmd_mod_id + '"><i class="fa fa-trash"></i></a>';
                    //      }
                    // }
               ],
            //    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            //         if (aData['val_status'] == "0") {
            //              $('td', nRow).css('background-color', 'Red');
            //              $('td', nRow).css('color', '#fff');
            //         } else if (aData['val_status'] == "1") {
            //              $('td', nRow).css('background-color', 'yellowgreen');
            //              $('td', nRow).css('color', '#fff');
            //         } else if (aData['val_status'] == "39") {
            //              $('td', nRow).css('background-color', 'gray');
            //              $('td', nRow).css('color', '#fff');
            //         }
            //    }
          });
     
     }

</script>