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
                         <table>
                              <tr>
                                   <td>
                                        <input autocomplete="off" name="ccb_callDate_f" type="text" class="txtDateF dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date from" value="<?php echo isset($_GET['ccb_callDate_f']) ? $_GET['ccb_callDate_f'] : ''; ?>"/>
                                   </td>
                                   <td style="padding-left: 10px;">
                                        <input autocomplete="off" name="ccb_callDate_t" type="text" class="txtDateT dtpEnquiry form-control col-md-7 col-xs-12" 
                                               placeholder="Date to" value="<?php echo isset($_GET['ccb_callDate_t']) ? $_GET['ccb_callDate_t'] : ''; ?>"/>
                                   </td>
                                   <td style="padding-left: 10px;">
                                        <select  style="float: left;width: auto;" class="select2_group form-control cmbStaff" name="executive">
                                             <option value="0">Select staff</option>
                                             <?php foreach ((array) $staff as $key => $value) { ?>
                                                  <option value="<?php echo $value['usr_id']; ?>"><?php echo $value['usr_first_name']; ?></option> 
                                             <?php } ?>
                                        </select>
                                   </td>
                                   <td style="padding-left: 10px;">
                                        <button type="submit" class="btnFilter btn btn-round btn-primary">Filter</button>
                                   </td>
                              </tr>
                         </table>
                    </div>
                    <div class="x_content">
                         <table class="voxbayAllConctCal table table-striped table-bordered">
                              <thead>
                                   <tr>
                                        <th>Date</th>
                                        <th>DID</th>
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

<script>
     $(document).ready(function () {
          loadData();
          $(document).on('click', '.btnFilter', function () {
               var table = $('.voxbayAllConctCal').DataTable();
               table.destroy();
               loadData();
          });

          function loadData() {
               $('.voxbayAllConctCal').dataTable({
                    "order": [],
                    "processing": true,
                    "serverSide": true,
                    'serverMethod': 'post',
                    "ajax": {
                         url: site_url + "voxbay/allconnectedoutcall_ajax",
                         type: "POST",
                         data: {
                              dateFrom: $('.txtDateF').val(), dateTo: $('.txtDateT').val(),
                              staff : $('.cmbStaff').val()
                         }
                    },
                    'columns': [
                         {data: 'ccbo_date'},
                         {data: 'ccbo_callerid'},
                         {data: 'ccbo_destination_user'},
                         {
                              sortable: false,
                              "render": function (data, type, full, meta) {
                                   return '<a target="blank" href="' + full.ccbo_recording_URL + '"><i class="fa fa-play-circle-o" style="font-size:25px;"></i></a>';
                              }
                         }
                    ]
               });
          }
     });
</script>