<?php
$modeOfContacts = unserialize(MODE_OF_CONTACT);
unset($modeOfContacts['18']);
unset($modeOfContacts['17']);
unset($modeOfContacts['6']);
unset($modeOfContacts['19']);
unset($modeOfContacts['20']);
$type = unserialize(VEHICLE_DETAILS_STATUS);
?>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Call list</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li style="float: right;">
                                   <a href="./uploads/dblist.xlsx">
                                        <img width="20" title="Download excel format" src="images/excel-export.png" />
                                   </a>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                    </div>
                    <?php if (check_permission('dbcall', 'import')) { ?>
                         <div class="x_content">
                              <form action="<?php echo site_url($controller . '/import'); ?>" method="post" class="frmImportExcel">
                                   <table>
                                        <tr>
                                             <td style="padding-right:10px;">
                                                  <input class="form-control col-md-9 col-xs-12" name="master[edm_db_title]" type="text" required placeholder="Document title" />
                                             </td>

                                             <td>
                                                  <input name="uploadDocument" type="file" required />
                                             </td>

                                             <td style="padding-left: 10px;">
                                                  <select required style="float: left;width: auto;" class="select2_group form-control cmbModeOfContact"
                                                       name="master[edm_enq_mod]">
                                                       <option value="0">RD mode of enquiry</option>
                                                       <?php
                                                       foreach ($modeOfContacts as $key => $value) {
                                                       ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                       <?php
                                                       }
                                                       ?>
                                                  </select>
                                             </td>

                                             <td style="padding-left: 10px;">
                                                  <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control" name="executive[]">
                                                       <?php
                                                       foreach ((array) $salesExecutives as $key => $value) {
                                                       ?>
                                                            <option value="<?php echo $value['user_id']; ?>"><?php echo $value['col_title']; ?></option>
                                                       <?php
                                                       }
                                                       ?>
                                                  </select>
                                             </td>
                                        </tr>

                                        <tr>
                                             <td colspan="4">
                                                  <input placeholder="Description" class="form-control col-md-9 col-xs-12" type="text" name="master[edm_description]" />
                                             </td>
                                        </tr>

                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary"><i class="fa fa-upload"> Import</i></button>
                                        </td>
                                   </table>
                              </form>
                         </div>
                    <?php } ?>
                    <table id="tblDTMasterList" class="table table-bordered">
                         <thead>
                              <tr>
                                   <th>Call list name</th>
                                   <th>Created on</th>
                                   <th>Created by</th>
                                   <th>Mode</th>
                                   <th>Desc</th>
                                   <th>Open</th>
                                   <th>Status</th>
                                   <th>Delete</th>
                              </tr>
                         </thead>
                    </table>
               </div>
          </div>
     </div>
</div>

<script>
     $(document).ready(function() {
          var api = '';
          var contactMod = <?php echo json_encode($modeOfContacts) ?>;
          var ingType = <?php echo json_encode($type) ?>;
          var perChangeStatus = <?php echo (check_permission('dbcall', 'canchangestatus')) ? 1 : 0; ?>;
          var perCreate = <?php echo (check_permission('dbcall', 'add')) ? 1 : 0; ?>;

          $('#tblDTMasterList').dataTable({
               "order": [],
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": site_url + "dbcall/fetchData",
               'initComplete': function(settings) {
                    api = new $.fn.dataTable.Api(settings);
               },
               'columns': [{
                         data: 'edm_db_title'
                    },
                    {
                         data: 'edm_added_on'
                    },
                    {
                         data: 'addedby_usr_first_name'
                    },
                    {
                         sortable: false,
                         "render": function(data, type, full, meta) {
                              return contactMod[full.edm_enq_mod];
                         }
                    },
                    {
                         data: 'edm_description'
                    },
                    {
                         sortable: false,
                         visible: (perCreate) ? true : false,
                         "render": function(data, type, full, meta) {
                              return '<i class="fa fa-forward"></i>';
                         }
                    },
                    {
                         sortable: false,
                         visible: (perChangeStatus) ? true : false,
                         "render": function(data, type, full, meta) {
                              var url = "<?php echo site_url('dbcall/changeStatus') ?>" + '/' + full.edm_id;
                              var checked = (full.edm_status == 1) ? 'checked' : '';
                              return '<input ' + checked + ' type="checkbox" class="chkCommon" data-url="' + url + '" />';
                         }
                    },
                    {
                         sortable: false,
                         visible: (perChangeStatus) ? true : false,
                         "render": function(data, type, full, meta) {
                              var url = "<?php echo site_url('dbcall/delete') ?>" + '/' + full.edm_id;
                              return '<a class="btnRemoveTableRow" href="javascript:void(0);" data-url="' + url + '"><i class="fa fa-trash"></i></a>';
                         }
                    },
               ]
          });
          $(document).on('submit', '.frmImportExcel', function(e) {
               e.preventDefault();
               var url = $(this).attr('action');
               var formData = new FormData($(this)[0]);
               $.ajax({
                    'url': url,
                    'type': 'POST',
                    'dataType': 'json',
                    'data': formData,
                    'async': false,
                    'cache': false,
                    'contentType': false,
                    'processData': false,
                    'beforeSend': function(xhr) {
                         $('.divLoading').show();
                         $('.btnNewFeature').prop('disabled', true);
                    },
                    'success': function(xhr) {
                         api.ajax.reload();
                         $('.frmImportExcel')[0].reset();
                         $('.divLoading').hide();
                         $('.btnNewFeature').prop('disabled', false);
                    }
               });
          });

          $('#tblDTMasterList').on('click', 'tbody td', function(e) {
               if ($(this).index() == 5) {
                    var data = $('#tblDTMasterList').DataTable().row(this).data();
                    var url = "<?php echo site_url('dbcall/dbdetails'); ?>" + "/" + data.edm_id;
                    window.location.href = url;
               }
          });
     });
</script>