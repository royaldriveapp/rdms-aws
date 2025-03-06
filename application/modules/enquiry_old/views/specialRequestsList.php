<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo $title; ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right;">
                            <?php if (check_permission('enquiry', 'export_excel') && !empty($_SERVER['QUERY_STRING'])) { ?>
                                <a class="btnRestrctData">
                                    <img width="20" title="Export to excel" src="images/excel-export.png" />
                                </a>
                            <?php } ?>
                        </li>
                        <li style="float:right;">
                            <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                                aria-controls="collapseExample">
                                <i class="fa fa-chevron-up"></i><i class="fa fa-chevron-down"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="<?php echo site_url('enquiry/changeStatusRequest/' . $status); ?>" method="get">
                        <table>
                            <tr>
                                <td>
                                    <input autocomplete="off" name="enq_date_from" type="text"
                                        class="enq_date_from dtpEnquiry form-control col-md-7 col-xs-12"
                                        placeholder="Date from"
                                        value="<?php echo isset($enq_date_from) ? $enq_date_from : ''; ?>" />
                                </td>
                                <td style="padding-left: 10px;">
                                    <input autocomplete="off" name="enq_date_to" type="text"
                                        class="enq_date_to dtpEnquiry form-control col-md-7 col-xs-12"
                                        placeholder="Date to"
                                        value="<?php echo isset($enq_date_to) ? $enq_date_to : ''; ?>" />
                                </td>
                                <?php if (check_permission('reports', 'fltr_enquiries_enq_showroom')) { ?>
                                    <td style="padding-left: 10px;">
                                        <select style="float: left;width: auto;"
                                            class="select2_group form-control bindSalesExecutives"
                                            data-url="<?php echo site_url('emp_details/salesExecutivesByShowroom'); ?>"
                                            data-bind="cmbSalesExecutives" name="showroom"
                                            data-dflt-select="All Sales executives">
                                            <option value="0">All Showroom</option>
                                            <?php foreach ($allShowrooms as $key => $value) { ?>
                                                <option
                                                    <?php echo ($showroom == $value['shr_id']) ? 'selected="selected"' : ''; ?>
                                                    value="<?php echo $value['shr_id'] ?>">
                                                    <?php echo $value['shr_location'] . ' (' . $value['div_name'] . ')' ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                <?php }
                                if (check_permission('reports', 'fltr_enquiries_enq_salesstaff')) { ?>
                                    <td style="padding-left: 10px;">
                                        <select multiple="multiple" style="float: left;width: auto;"
                                            class="cmbMultiSelect select2_group form-control cmbSalesExecutives"
                                            name="executive[]">
                                            <option value="<?php echo $this->uid; ?>">My self</option>
                                            <?php
                                            foreach ((array) $salesExecutives as $key => $value) {
                                                if (!empty($showroom)) {
                                                    if ($showroom == $value['usr_showroom']) {
                                            ?>
                                                        <option value="<?php echo $value['usr_id']; ?>"
                                                            <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?>>
                                                            <?php echo $value['usr_first_name']; ?></option>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <option
                                                        <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?>
                                                        value="<?php echo $value['usr_id']; ?>">
                                                        <?php echo $value['usr_first_name']; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                <?php } ?>
                                <td style="padding-left: 10px;">
                                    <select style="float: left;width: auto;" class="select2_group form-control"
                                        name="status">
                                        <option value="0">All Types</option>
                                        <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $sts => $stsName) { ?>
                                            <option
                                                <?php echo ((int) $sts == (int) $enqStatus) ? 'selected="selected"' : ''; ?>
                                                value="<?php echo $sts; ?>"><?php echo $stsName ?></option>
                                        <?php } ?>
                                    </select>
                                </td>

                                <td style="padding-left: 10px;">
                                    <select multiple="multiple" style="float: left;width: auto;"
                                        class="select2_group form-control cmbMultiSelect" name="mode">
                                        <option value="0">All Mode of enquiry</option>
                                        <?php foreach (unserialize(MODE_OF_CONTACT) as $sts => $stsName) { ?>
                                            <option <?php echo ((int) $sts == (int) $mode) ? 'selected="selected"' : ''; ?>
                                                value="<?php echo $sts; ?>"><?php echo $stsName ?></option>
                                        <?php } ?>
                                    </select>
                                </td>

                                <td style="padding-left: 10px;">
                                    <input type="text" placeholder="Search value" style="float: left;width: auto;"
                                        class="form-control" name="keysearch"
                                        value="<?php echo isset($_GET['keysearch']) ? $_GET['keysearch'] : ''; ?>" />
                                </td>

                                <td style="padding-left: 10px;">
                                    <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php $cntMods = unserialize(MODE_OF_CONTACT); ?>
                    <table id="tblSpecialReq" class="table table-striped table-bordered display nowrap"
                        style="width:100%;white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Customer</th>
                                <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG' ||  $this->usr_grp == 'TL') ? '<th>Sales Staff</th>' : ''; ?>
                                <th>Division</th>
                                <th>Showroom</th>
                                <th>Vehicle</th>
                                <th>Color</th>
                                <th>Cust Expected</th>
                                <th>Mobile</th>
                                <th>WhatsApp</th>
                                <th>Request Date</th>
                                <th>Drop remark</th>
                                <th>Sales Staff</th>
                                <th>District</th>
                                <th>Addedby</th>
                                <th>Home visit</th>
                                <th>Last customer remark</th>
                                <th>Last SM remark</th>
                                <th>Last ASM remark</th>
                                <th>Last MIS remark</th>
                                <th>Enquiry created Date</th>
                                <th>Mode of enquiry</th>
                                <th>Team leader</th>
                                <th>Enq Type</th>
                                <th>Reason</th>
                                <th>Other Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($enquires)) {
                                foreach ($enquires as $key => $value) {
                                    if ($value['enq_cus_status'] == 1) {
                                        $enqType = 'Sales';
                                    } else if ($value['enq_cus_status'] == 2) {
                                        $enqType = 'Purchase';
                                    } else {
                                        $enqType = 'Exchange';
                                    }
                                    $vehicle = $this->reports->getVehicleDetails($value['enq_id']);
                                    $vehDetails = $this->reports->getVehicleInformation($value['enq_id']);
                            ?>
                                    <tr
                                        data-url="<?php echo site_url('enquiry/viewVehicleStatus/' . encryptor($value['enq_id']) . '/' . $status); ?>">
                                        <td class="trVOE"><?php echo $value['enq_number']; ?></td>
                                        <td class="trVOE"><?php echo $value['enq_cus_name']; ?></td>
                                        <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG' ||  $this->usr_grp == 'TL') ? '<td class="trVOE">' . strtoupper($value['usr_first_name']) . '</td>' : ''; ?>
                                        <td class="trVOE"><?php echo $value['div_name']; ?></td>
                                        <td class="trVOE"><?php echo $value['shr_location']; ?></td>
                                        <td class="trVOE"><?php echo $vehicle; ?></td>
                                        <td class="trVOE">
                                            <?php echo isset($vehDetails['0']['veh_color']) ? $vehDetails['0']['veh_color'] : ''; ?>
                                        </td>
                                        <td class="trVOE">
                                            <?php echo isset($vehDetails['0']['veh_exch_cus_expect']) ? $vehDetails['0']['veh_exch_cus_expect'] : ''; ?>
                                        </td>
                                        <td class="trVOE"><?php echo $value['enq_cus_mobile']; ?></td>
                                        <td class="trVOE"><?php echo $value['enq_cus_whatsapp']; ?></td>
                                        <td class="trVOE">
                                            <?php echo !empty($value['enh_added_on']) ? date('j M Y', strtotime($value['enh_added_on'])) : ''; ?>
                                        </td>
                                        <td class="trVOE"><?php echo $value['enh_remarks']; ?></td>
                                        <td class="trVOE"><?php echo $value['usr_first_name']; ?></td>
                                        <td class="trVOE"><?php echo $value['std_district_name']; ?></td>
                                        <td class="trVOE"><?php echo $value['enq_added_by_name']; ?></td>
                                        <td><?php echo !empty($value['enq_home_visit_date']) ? date('j M Y', strtotime($value['enq_home_visit_date'])) : ''; ?>
                                        </td>
                                        <td><?php echo isset($value['enq_last_foll_cust_rmk']) ? $value['enq_last_foll_cust_rmk'] : ''; ?>
                                        </td>
                                        <td><?php echo $value['enq_sm_rmk']; ?></td>
                                        <td><?php echo $value['enq_asm_rmk']; ?></td>
                                        <td><?php echo $value['enq_mis_rmk']; ?></td>
                                        <td><?php echo !empty($value['enq_added_on']) ? date('j M Y', strtotime($value['enq_added_on'])) : ''; ?>
                                        </td>
                                        <td><?php echo isset($cntMods[$value['enq_mode_enq']]) ? $cntMods[$value['enq_mode_enq']] : ''; ?>
                                        </td>
                                        <td><?php echo $value['tl_usr_first_name']; ?></td>
                                        <td><?php echo $enqType; ?></td>
                                        <td><?php echo unserialize(lostDrop)[$value['enh_reason_for_lost_drop']] ?></td>
                                        <td><?php echo $value['enh_reason_for_lost_drop_other'] ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing
                        <?php echo $pageIndex; ?> to <?php echo $limit; ?> of <?php echo $totalRow; ?> entries</div>
                    <div style="float: right;">
                        <?php echo $links; ?>
                    </div>
                </div>
                <!-- -->
                <?php if (check_permission('reports', 'allowresinedstfenqreassign')) { ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="x_panel tile fixed_height_320" style="overflow: scroll;">
                            <div class="x_title">
                                <h2>Move req-drop enquiries</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="dashboard-widget-content">
                                <div class="x_content">
                                    <form class="frmQuickAssign"
                                        data-url="<?php echo site_url('enquiry/submitReAssign'); ?>" method="get">
                                        <input type="hidden" name="searchValues"
                                            value='<?php echo !empty($_GET) ? serialize($_GET) : ''; ?>' />
                                        <input type="hidden" name="enq_ids" value='<?php echo $enq_ids; ?>'>
                                        <input type="hidden" name="source" value="rpt_enquires" />
                                        <table>
                                            <tr>
                                                <td style="padding-left: 10px;">
                                                    <select multiple="multiple" style="float: left;width: auto;"
                                                        class="cmbMultiSelect select2_group form-control cmbSalesExecutives"
                                                        name="executive[]">
                                                        <?php foreach ((array) $teleCallers as $key => $value) { ?>
                                                            <option value="<?php echo $value['col_id']; ?>">
                                                                <?php echo $value['col_title']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px;">

                                                    <?php $enq_date_from_se = !empty($enq_date_from) ? 'date from ' . $enq_date_from : '';
                                                    $enq_date_to_se = !empty($enq_date_to) ? ', date to ' . $enq_date_to : ''; ?>
                                                    <textarea placeholder="Desction" name="desc"
                                                        class="select2_group form-control"
                                                        required><?php echo $title . ', ' . $enq_date_from_se . $enq_date_to_se; ?></textarea>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left: 10px;"> <button type="submit"
                                                        class="btn btn-round btn-primary">Assign</button></td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var qryString = "<?php echo '?' . $_SERVER['QUERY_STRING']; ?>";

        $(document).on('click', '.btnRestrctData', function() {

            var enq_date_from = $('.enq_date_from').val();
            var enq_date_to = $('.enq_date_to').val();
            console.log(enq_date_from);
            console.log(enq_date_to);
            if (enq_date_from && enq_date_to) {

                const fromArray = enq_date_from.split("-");
                let dateFrom = fromArray[2] + '-' + fromArray[1] + '-' + fromArray[0];

                const toArray = enq_date_to.split("-");
                let dateTo = toArray[2] + '-' + toArray[1] + '-' + toArray[0];

                var start = new Date(dateFrom),
                    end = new Date(dateTo),
                    diff = new Date(end - start),
                    days = diff / 1000 / 60 / 60 / 24;
                console.log(days);
                if (days > 50) {
                    alert('Please select date from, to between 30 days ranges!');
                } else {
                    location.href = "<?php echo site_url('enquiry/exportExcelStatus/' . $status); ?>" +
                        qryString;
                }
            } else {
                alert('Please select date from, to between 30 days ranges!');
            }
        });
        $('#tblSpecialReq').DataTable({
            "order": [
                [1, "asc"]
            ],
            "scrollX": true,
            "pageLength": 20,
            "searching": false,
            "paging": false,
            "info": false
        });
    });
</script>