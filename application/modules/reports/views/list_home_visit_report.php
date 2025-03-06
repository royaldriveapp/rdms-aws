<style>
     /*     .bg-approved{
               background-color:#00CC00; 
               color: #ffffff!important;
          }
          .bg-un-approved{
               background-color:#000000; 
               color: #ffffff!important;
          }*/
     .bg-approved {
          /*          background-color:#304c51; */
          background-color: #5f4474;

          color: #ffffff !important;
     }

     .bg-un-approved {
          background-color: #000000;
          color: #ffffff !important;
     }

     .thColor {
          /*          background-color:#7fa28ab8!important; */
          /* background-color: #0a0909!important; */
          background-color: #1d1b1b !important;

          /*          color: #000000!important;  */
          /*color: #55fe4c!important; */
          color: #00ff00 !important;
     }

     .bg-veh-detailsj {
          background-color: #000000;
          color: #ffffff !important;
     }

     thj {
          /*    border: solid 1px #00000!important;*/
          border: solid 1px;
     }

     table,
     th,
     td {
          border-collapse: collapse !important;
     }

     .table {

          table-layout: auto;


     }

     th {
          border: none !important;
     }

     th {
          border-right: solid 1px #ddd !important;
          border-left: solid 1px #ddd !important;
     }

     .th-top {
          border-top: solid 1px #ddd !important;
     }

     .table tr:hover {
          background-color: #ffcb05;
          color: black !important;
          /*          font-weight: 550;*/

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

     .dialog {
          /*    width: 746px !important;*/
          /*    margin: 30px auto !important ;*/
          /*    width: 746px !important;*/
     }

     .bg-gray {
          background-color: #cacaca !important;
     }

     .modal-content {
          border: 7px solid rgba(0, 0, 0, .2) !important;
          border-radius: 42px !important;
     }

     /*.cus-fdbk-content{
      border: 7px solid rgb(205 204 199 / 26%)!important;
     }*/
     .cus-fdbk-content {
          border: 7px solid #cdcbc373 !important;
     }

     .lbl {
          color: black !Important;
     }

     .table-responsive tr td {
          white-space: nowrap;
     }

     .table-responsive tr th {
          white-space: nowrap;
     }
</style>
<?php $travel_mods = $this->reports->getTravelModes(); ?>
<div class="right_col" role="main">
     <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                         <h2>Home visit report</h2>
                         <ul class="nav navbar-right panel_toolbox">
                              <li style="float: right;">
                                   <?php if (check_permission('reports', 'exporthomevisit')) { ?>
                                        <a href="<?php echo site_url('reports/exporthomevisit?' . $_SERVER['QUERY_STRING']); ?>">
                                             <img width="20" title="Export to excel" src="images/excel-export.png" />
                                        </a>
                                   <?php } ?>
                              </li>
                         </ul>
                         <div class="clearfix"></div>
                         <?php $hot_status = unserialize(ENQUIRY_UP_STATUS); ?>
                         <form action="<?php echo site_url('reports/homevisit'); ?>" method="get" id="filterForm">
                              <table>
                                   <tbody>
                                        <tr>
                                             <td>
                                                  <select class="select2_group form-control " name="hot_status">
                                                       <option value="">Select</option>
                                                       <?php foreach ($hot_status as $key => $value) { ?>
                                                            <option <?php echo $_GET['hot_status'] == $key ? 'selected' : '' ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>

                                                       <?php } ?>
                                                  </select>

                                             </td>
                                             <td>
                                                  <select class="select2_group form-control cmbShowroom shorm_stf" name="is_visited">
                                                       <option value="">Select</option>
                                                       <option <?php echo $_GET['is_visited'] == 1 ? 'selected' : '' ?> value="1">Visited</option>
                                                  </select>
                                             </td>
                                             <td>
                                                  <input autocomplete="off" name="hmv_date_frm" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" placeholder="Date from" value="<?php echo isset($_GET['hmv_date_frm']) ? $_GET['hmv_date_frm'] : ''; ?>" />
                                             </td>
                                             <td style="padding-left: 10px;">
                                                  <input autocomplete="off" name="hmv_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" placeholder="Date to" value="<?php echo isset($_GET['hmv_date_to']) ? $_GET['hmv_date_to'] : ''; ?>" />
                                             </td>
                                             <?php if (check_permission('home_visit_report', 'show_satff_filter')) { ?>
                                                  <td>
                                                       <select class="select2_group form-control enq_se_id" name="staff">
                                                            <option value="">-Staff-</option>
                                                            <?php foreach ($staff as $key => $value) { ?>
                                                                 <option value="<?php echo $value['col_id']; ?>" <?php echo (isset($_GET['staff']) && ($_GET['staff'] == $value['col_id'])) ? 'selected="selected"' : ''; ?>><?php echo $value['col_title']; ?></option>
                                                            <?php } ?>
                                                       </select>
                                                  </td>
                                             <?php } ?>
                                             <td style="padding-left: 10px;">
                                                  <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>
                         </form>
                    </div>

                    <div class="x_content table-responsive">
                         <table class="datatableFollowup table table-stripedj table-bordered">
                              <thead class="thColor">
                                   <tr>
                                        <th colspan="4" class="bg-veh-details" style="text-align:center">Customer</th>
                                        <th colspan="1">Requested Date</th>
                                        <th colspan="1">Place</th>
                                        <th colspan="1">Staff</th>
                                        <th colspan="1">Department</th>
                                        <th colspan="1">Travel With </th>
                                        <th colspan="4" class="bg-veh-details" style="text-align:center">Vehicle used for home visit</th>
                                        <th colspan="1">In Date </th>
                                        <th colspan="1" class="bg-veh-details"> Approved </th>
                                        <th colspan="1">Discussion Time </th>
                                        <th colspan="1">Met the Customer with Family </th>

                                        <!--                                        <th> Executive Remak</th>
                                       <th>TL Remark  </th>
                                       <th> SM Remark </th>-->

                                   </tr>
                                   <tr>
                                        <th class="th-top bg-veh-details">Enq Number</th>
                                        <th class="th-top bg-veh-details">Name</th>
                                        <th class="th-top bg-veh-details">Phone</th>
                                        <th class="th-top bg-veh-details">Status</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="th-top bg-veh-details">Vehicle</th>
                                        <th class="th-top bg-veh-details">Reg No</th>
                                        <th class="th-top bg-veh-details">Out km </th>
                                        <th class="th-top bg-veh-details">In Km </th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>

                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   $notApproved = '<font color="#ebd334">Not approved yet</font>';
                                   foreach ($homeVisits as $homeVisit) {
                                        $approvalData = end(json_decode($homeVisit['hmv_approvals']));
                                        $approvedBy = '';
                                        $approved = 'No one approved yet';
                                        if (!empty($approvalData)) {
                                             $approvedBy = $approvalData->usr_username;
                                             $action = '<font color="#00CC00">Approved</font>';
                                             if ($approvalData->hmva_approval_status == 2) {
                                                  $action = '<font color="red">Rejected</font>';
                                             }
                                             $approvedBy .= $approvedBy . ':' . $action . '<br>';
                                        }
                                        $date1 = new DateTime($date = date('d-m-Y', strtotime($homeVisit['hmv_date'])));
                                   ?>
                                        <tr class="<?php echo !empty($approvalData) ? 'bg-approved' : 'bg-un-approved'; ?>" data-url="">
                                             <td class="jtrVOE"><?php echo $homeVisit['enq_number']; ?></td>
                                             <td class="jtrVOE"><?php echo $homeVisit['enq_cus_name']; ?></td>
                                             <td class="jtrVOE"><?php echo $homeVisit['enq_cus_mobile']; ?></td>
                                             <td class="jtrVOE"><?php echo unserialize(ENQUIRY_UP_STATUS)[$homeVisit['enq_cus_when_buy']]; ?></td>
                                             <td class=""><?php echo $date; ?></td>
                                             <td class="jtrVOE"><?php echo $homeVisit['hmv_place']; ?></td>
                                             <td class="jtrVOE"><?php echo $homeVisit['enq_added_by_name']; ?></td>
                                             <td class="jtrVOE"><?php
                                                                 if ($homeVisit['usr_departments'] == 4 or $homeVisit['usr_departments'] == 6) {
                                                                      echo 'Sales';
                                                                 } elseif ($homeVisit['usr_departments'] == 7 or $homeVisit['usr_departments'] == 8) {
                                                                      echo 'Purchase';
                                                                 }
                                                                 ?>
                                             </td>
                                             <td class="jtrVOE"><?php echo $homeVisit['travel_with']; ?></td>
                                             <td class="jtrVOE bg-veh-details"><?php
                                                                                if ($homeVisit['hmv_travel_mod'] == 8) {
                                                                                     if ($homeVisit['hmv_fleet_veh'] == 1) {
                                                                                          $vehnm = $homeVisit['brd_title'] . '|' . $homeVisit['mod_title'] . '|' . $homeVisit['var_variant_name'];
                                                                                          $veh_type = 'Company veh';
                                                                                          $veh_no = $homeVisit['val_veh_no'];
                                                                                          echo $vehnm . '(' . $veh_type . ')';
                                                                                     } else if ($homeVisit['hmv_fleet_veh'] == 2) {
                                                                                          $vehnm = $homeVisit['brd_title'] . '|' . $homeVisit['mod_title'] . '|' . $homeVisit['var_variant_name'];
                                                                                          $veh_type = 'Stock veh';
                                                                                          $veh_no = $homeVisit['val_veh_no'];
                                                                                          echo $vehnm . '(' . $veh_type . ')';
                                                                                     } else if ($homeVisit['hmv_fleet_veh'] == 3) {
                                                                                          $veh_type = 'Own vehicle';
                                                                                          $veh_no = $homeVisit['hmv_veh_no'];
                                                                                          echo $veh_type;
                                                                                     }
                                                                                } else {
                                                                                     echo $homeVisit['dtm_title'];
                                                                                     $veh_no = '';
                                                                                }
                                                                                //echo $homeVisit['hmv_travel_mod']==8? ($homeVisit['brd_title'] . '|' . $homeVisit['mod_title'] . '|' . $homeVisit['var_variant_name']):$homeVisit['dtm_title'];
                                                                                ?></td>
                                             <td class="jtrVOE bg-veh-details"><?php echo @$veh_no; ?></td>
                                             <td class="jtrVOE bg-veh-details"><?php echo $homeVisit['hmv_out_km']; ?></td>
                                             <td class="jtrVOE bg-veh-details"><?php echo $homeVisit['hmv_in_km']; ?></td>

                                             <td class="jtrVOE bg-veh-details"><?php echo $homeVisit['hmv_in_date']; ?></td>
                                             <td class="jtrVOE bg-veh-details"><?php
                                                                                echo !empty($approvalData) ? $approvedBy : $notApproved;
                                                                                ?></td>
                                             <td class="jtrVOE"><?php echo $homeVisit['hmv_discussion_time']; ?></td>
                                             <td class="jtrVOE"><?php echo $homeVisit['hmv_met_cus_with_family'] ? 'YES' : 'NO'; ?></td>


                                        </tr>
                                   <?php } ?>

                              </tbody>
                         </table>
                         <!-- popup -->
                         <div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                   <div class=" modal-content bg-gray brd-radi cus-fdbk-content">
                                        <?php echo form_open_multipart("followup/update_home_visit", array('id' => "update_home_visit", 'class' => "upd_hm_visit")) ?>
                                        <div class="modal-header bg-gray h-brd-radi">
                                             <h5 class="modal-title lbl" id="exampleModalLabel" style="float: left;">Update Home Visit</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                             </button>
                                        </div>
                                        <div class="modal-body viewEditModel bg-gray brd-radi"></div>
                                        <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary btnCloseModel lbl" data-dismiss="modal">Close</button>
                                             <button type="submit" class="btn btn-success btnSave">Submit</button>
                                        </div>
                                        <?php echo form_close() ?>
                                   </div>
                              </div>
                         </div>
                         <!-- @popup -->

                         <div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                              <strong>Enq Status Updated successfully!</strong>
                         </div>

                         <div class="alert alert-danger alert-dismissible fade in ErrorMsgBox" role="alert" style="display: none;">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                              <strong>Error:Could not be submitted successfully!</strong>
                         </div>

                    </div>
               </div>
          </div>
     </div>
</div>