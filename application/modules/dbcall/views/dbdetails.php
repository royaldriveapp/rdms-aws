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
                         <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                         <table id="courtcyCallList" class="table table-bordered">
                              <thead>
                                   <tr>
                                        <th>Reg Num</th>
                                        <th>Cust Name</th>
                                        <th>Cust Number</th>
                                        <th>Vehicle</th>
                                        <th>Address</th>
                                        <th>Added by</th>
                                        <th>Assigned to</th>

                                        <th>Punched on</th>
                                        <th>Remarks</th>
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
          var api = '';
          var contactMod = <?php echo json_encode($modeOfContacts)?>;
          var ingType = <?php echo json_encode($type)?>;
          var masterId = <?php echo $masterId;?>

          $('#courtcyCallList').dataTable({
               "order": [],
               "scrollX": false,
               "processing": true,
               "serverSide": true,
               'serverMethod': 'post',
               "ajax": site_url + "dbcall/dbdetails_ajax/" + masterId,
               'initComplete': function (settings) {
                    api = new $.fn.dataTable.Api(settings);
               },
               'columns': [
                    {data: 'edd_veh_reg_num'},
                    {data: 'edd_cust_name'},
                    {
                         sortable: false,
                         "render": function (data, type, full, meta) {
                              if (full.edd_cust_number != '') {
                                   var url = "https://api.whatsapp.com/send?phone=" + full.edd_cust_number;
                                   return "<a target='_blank' href='" + url + "'>" + full.edd_cust_number + "</a>";
                              } else {
                                   return '';
                              }
                         }
                    },
                    {data: 'edd_vehicle'},
                    {data: 'edd_address'},
                    {data: 'addedby_usr_first_name'},
                    {data: 'assignto_usr_first_name'},
                    {data: 'vreg_entry_date'},
                    {data: 'vreg_customer_remark'}
               ]
          });

          $(document).on('submit', '.frmImportExcel', function (e) {
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
                    'beforeSend': function (xhr) {
                    },
                    'success': function (xhr) {
                         api.ajax.reload();
                    }
               });
          });
          
          $('#courtcyCallList tbody').on('click', 'tr', function () {
               var data = $('#courtcyCallList').DataTable().row(this).data();
               var url = "<?php echo site_url('dbcall/add');?>" + "/" + data.edd_id;
               window.location.href = url;
          });
     });
</script>