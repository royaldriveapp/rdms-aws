<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Enquires</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right;">
                            <?php if (check_permission('reports', 'xlsx_rpt_enq_based')) { ?>
                                <a class="btnRestrctData">
                                    <img width="20" title="Export to excel" src="images/excel-export.png" />
                                </a>
                            <?php } ?>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="<?php echo site_url('reports/enquiries_enq/'); ?>" method="get">
                        <table>
                            <tr>
                                <td>
                                    <input autocomplete="off" name="enq_date_from" type="text"
                                        class="enq_date_from dtpEnquiry form-control col-md-7 col-xs-12"
                                        placeholder="Date from" value="<?php echo $enq_date_from; ?>" />
                                </td>
                                <td style="padding-left: 10px;">
                                    <input autocomplete="off" name="enq_date_to" type="text"
                                        class="enq_date_to dtpEnquiry form-control col-md-7 col-xs-12"
                                        placeholder="Date to" value="<?php echo $enq_date_to ?>" />
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
                                            <option value="<?php echo $this->uid; ?>"
                                                <?php echo (@in_array($$executive, $this->uid)) ? 'selected="selected"' : ''; ?>>
                                                My self</option>
                                            <?php
                                            foreach ((array) $salesExecutives as $key => $value) {
                                                if (!empty($value['usr_first_name'])) {
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
                                            }
                                            ?>
                                        </select>
                                    </td>
                                <?php }
                                if (check_permission('reports', 'fltr_enquiries_enq_type')) { ?>
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
                                <?php }
                                if (check_permission('reports', 'fltr_enquiries_enq_mod')) { ?>
                                    <td style="padding-left: 10px;">
                                        <select multiple="multiple" style="float: left;width: auto;"
                                            class="select2_group form-control cmbMultiSelect" name="mode[]">
                                            <option value="0">All Mode of enquiry</option>
                                            <?php foreach (unserialize(MODE_OF_CONTACT) as $sts => $stsName) { ?>
                                                <option <?php echo (in_array($sts, $mode)) ? 'selected="selected"' : ''; ?>
                                                    value="<?php echo $sts; ?>"><?php echo $stsName ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                <?php } ?>
                                <td style="padding-left: 10px;">
                                    <select multiple="multiple" style="float: left;width: auto;"
                                        class="select2_group form-control cmbMultiSelect" name="dist[]">
                                        <option value="0">District</option>
                                        <?php foreach ($districts as $sts => $stsName) { ?>
                                            <option
                                                <?php echo (in_array($stsName['std_id'], $distSelected)) ? 'selected="selected"' : ''; ?>
                                                value="<?php echo $stsName['std_id']; ?>">
                                                <?php echo $stsName['std_district_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td style="padding-left: 10px;">
                                    <select style="float: left;width: auto;" class="select2_group form-control"
                                        name="type">
                                        <option
                                            <?php echo (isset($_GET['type']) && $_GET['type'] == 0) ? 'selected="selected"' : ''; ?>
                                            value="0">Type</option>
                                        <option
                                            <?php echo (isset($_GET['type']) && $_GET['type'] == 1) ? 'selected="selected"' : ''; ?>
                                            value="1">Sales</option>
                                        <option
                                            <?php echo (isset($_GET['type']) && $_GET['type'] == 2) ? 'selected="selected"' : ''; ?>
                                            value="2">Purchase</option>
                                        <option
                                            <?php echo (isset($_GET['type']) && $_GET['type'] == 3) ? 'selected="selected"' : ''; ?>
                                            value="3">Exchange</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <?php if (check_permission('reports', 'fltr_enquiries_enq_bdjt')) { ?>
                                    <td>
                                        <input autocomplete="off" name="bgetfr" type="text"
                                            class="form-control col-md-7 col-xs-12" placeholder="Budjet from"
                                            value="<?php echo isset($_GET['bgetfr']) ? $_GET['bgetfr'] : ''; ?>" />
                                    </td>
                                    <td style="padding-left: 10px;">
                                        <input autocomplete="off" name="bgetto" type="text"
                                            class="form-control col-md-7 col-xs-12" placeholder="Budjet to"
                                            value="<?php echo isset($_GET['bgetto']) ? $_GET['bgetto'] : ''; ?>" />
                                    </td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td style="padding-left: 10px;">
                                    <input <?php echo ($isMissedFollowup == 1) ? 'checked' : ''; ?> type="checkbox"
                                        name="isMissedFollowup" value="1" /> Is followup missed
                                </td>
                                <td style="padding-left: 10px;">
                                    <input <?php echo ($isDrpNdLost == 1) ? 'checked' : ''; ?> type="checkbox"
                                        name="isDrpNdLost" value="1" /> Include all statuses
                                </td>
                                <td style="padding-left: 10px;">
                                    <input <?php echo ($isPoolPending == 1) ? 'checked' : ''; ?> type="checkbox"
                                        name="isPoolPending" value="1" /> Pending pool enquires
                                </td>
                                <td>
                                    <?php if (check_permission('reports', 'showasmfilter')) {
                                        $selectedAsm = isset($_GET['asm']) ? $_GET['asm'] : 0;
                                    ?>
                                        <select style="float: left;width: auto;"
                                            class="form-control cmbMultiSelect select2_group" name="asm[]"
                                            multiple="multiple">
                                            <option value="0">ASM</option>
                                            <?php foreach ($asm as $kasm => $asmv) { ?>
                                                <option
                                                    <?php echo (in_array($asmv['usr_id'], $selectedAsm)) ? 'selected' : ''; ?>
                                                    value="<?php echo $asmv['usr_id']; ?>"><?php echo $asmv['usr_username']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </td>
                                <td style="padding-left: 10px;">
                                    <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="x_content">
                    <table id="tblEnqReport" class="table table-striped table-bordered display nowrap"
                        style="width:100%;white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Customer</th>
                                <th>Contact No</th>
                                <th>Mode of inquiry</th>
                                <th>Type</th>
                                <?php if ($this->usr_grp != 'SE') { ?>
                                    <th>Showroom</th>
                                    <th>Executive</th>
                                    <th>Addedby</th>
                                <?php } ?>
                                <th>Enq Date</th>
                                <th>Dist</th>
                                <th>Last followup on</th>
                                <th>Next followup on</th>
                                <?php if (check_permission('reports', 'viewfollowupfromreport')) { ?>
                                    <th>Followup</th>
                                <?php } ?>
                                <th>Home visit</th>
                                <!-- <th>Budget</th> -->
                                <th>Last customer remark</th>
                                <th>Last SM remark</th>
                                <th>Last ASM remark</th>
                                <th>Last MIS remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ((array) $searchResult as $key => $veh) {
                                //$lastFollowupDate = $this->reports->getLastFollowupDate($veh['enq_id']);
                                //$budget = $this->reports->getFollowupBudget($veh['enq_id']);
                                //$lastCustRemart = $this->reports->getLastFollowupCustomerRemark($veh['enq_id']);

                                $canEdit = (($this->uid == $veh['enq_se_id']) || is_roo_user() || (check_permission('reports', 'showtrackcardfromreportrow'))) ? 'trVOE' : '';
                            ?>
                                <tr
                                    data-url="<?php echo site_url('enquiry/printTrackCard/' . encryptor($veh['enq_id'])); ?>">
                                    <td class="<?php echo $canEdit; ?>">
                                        <?php echo generate_vehicle_virtual_id($veh['enq_id']); ?></td>
                                    <td class="<?php echo $canEdit; ?>"><?php echo strtoupper($veh['enq_cus_name']); ?></td>
                                    <td><a
                                            href="tel:<?php echo $veh['usr_phone']; ?>"><?php echo $veh['enq_cus_mobile']; ?></a>
                                    </td>
                                    <td class="<?php echo $canEdit; ?>">
                                        <?php
                                        $mods = unserialize(MODE_OF_CONTACT);
                                        echo isset($mods[$veh['enq_mode_enq']]) ? $mods[$veh['enq_mode_enq']] : '';
                                        ?>
                                    </td>
                                    <td class="<?php echo $canEdit; ?>">
                                        <?php echo $veh['enq_cus_status'] == 1 ? 'Sales' : 'Purchase'; ?></td>
                                    <?php if ($this->usr_grp != 'SE') { ?>
                                        <td class="<?php echo $canEdit; ?>"><?php echo $veh['shr_location']; ?></td>
                                        <td class="<?php echo $canEdit; ?>"><?php echo $veh['usr_first_name']; ?></td>
                                        <td class="<?php echo $canEdit; ?>"><?php echo $veh['addedBy_usr_first_name']; ?></td>
                                    <?php } ?>
                                    <td><?php echo date('j M Y', strtotime($veh['enq_entry_date'])); ?></td>
                                    <td><?php echo $veh['std_district_name']; ?></td>
                                    <td>
                                        <?php echo (!empty($veh['enq_last_foll_date'])) ? date('j M Y', strtotime($veh['enq_last_foll_date'])) : ''; ?>
                                    </td>
                                    <td><?php echo date('j M Y', strtotime($veh['enq_next_foll_date'])); ?></td>
                                    <?php if (check_permission('reports', 'viewfollowupfromreport')) { ?>
                                        <td>
                                            <a style="margin-left: 10px;" title="Followup"
                                                href="<?php echo site_url('followup/viewFollowup/' . encryptor($veh['enq_id'])) ?>">
                                                <i class="fa fa-calendar-check-o"></i>
                                            </a>
                                        </td>
                                    <?php } ?>
                                    <td><?php echo !empty($veh['enq_home_visit_date']) ? date('j M Y', strtotime($veh['enq_home_visit_date'])) : ''; ?>
                                    </td>
                                    <!-- <td><?php /*$budgetFrom = isset($budget['foll_budget_from']) ? $budget['foll_budget_from'] : '';
                                                  $budgetTo = isset($budget['foll_budget_to']) ? $budget['foll_budget_to'] : '';
                                                  echo $budgetFrom . '-' . $budgetTo;*/ ?>
                                </td> -->
                                    <td><?php echo isset($veh['enq_last_foll_cust_rmk']) ? $veh['enq_last_foll_cust_rmk'] : ''; ?>
                                    </td>
                                    <td><?php echo $veh['enq_sm_rmk']; ?></td>
                                    <td><?php echo $veh['enq_asm_rmk']; ?></td>
                                    <td><?php echo $veh['enq_mis_rmk']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <!--<div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing <?php echo $pageIndex; ?> to <?php echo $limit; ?> of <?php echo $totalRow; ?> entries</div>-->
                    <div>
                        <div style="float: left;width:100%">
                            <strong><?php echo $totalRows . ' Enquires found'; ?></strong>
                        </div>
                        <div style="float: right;">
                            <?php echo $links; ?>
                        </div>
                    </div>
                    <?php if (check_permission('reports', 'allowquickassignenquires')) { ?>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="x_panel tile fixed_height_320" style="overflow: scroll;">
                                <div class="x_title">
                                    <h2>Assign to CRE</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="dashboard-widget-content">
                                    <div class="x_content">
                                        <form class="frmQuickAssign"
                                            data-url="<?php echo site_url('reports/quickassign'); ?>" method="get">
                                            <input type="hidden" name="searchValues"
                                                value='<?php echo !empty($_GET) ? serialize($_GET) : ''; ?>' />
                                            <input type="hidden" name="source" value="rpt_enquires" />
                                            <table>
                                                <tr>
                                                    <td style="padding-left: 10px;">
                                                        <!-- muliSelectCombo -->
                                                        <select multiple="multiple" style="float: left;width: auto;"
                                                            class="cmbMultiSelect select2_group form-control cmbSalesExecutives"
                                                            name="executive[]">
                                                            <?php
                                                            foreach ((array) $teleCallers as $key => $value) {
                                                                /*if (!empty($showroom)) {
                                                                                     if ($showroom == $value['usr_showroom']) {
                                                                                          ?>
                                                        <option value="<?php echo $value['col_id'];?>"
                                                            <?php echo (@in_array($value['col_id'], $executive)) ? 'selected="selected"' : '';?>>
                                                            <?php echo $value['col_title'];?></option>
                                                        <?php
                                                                                     }
                                                                                } else {*/
                                                            ?>
                                                                <option
                                                                    <?php echo (@in_array($value['col_id'], $executive)) ? 'selected="selected"' : ''; ?>
                                                                    value="<?php echo $value['col_id']; ?>">
                                                                    <?php echo $value['col_title']; ?></option>
                                                            <?php
                                                                /*}*/
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:10px;">
                                                        <?php
                                                        $enq_date_from_se = !empty($enq_date_from) ? 'date from ' . $enq_date_from : '';
                                                        $enq_date_to_se = !empty($enq_date_to) ? ', date to ' . $enq_date_to : '';
                                                        ?>
                                                        <textarea placeholder="Description" name="desc"
                                                            class="select2_group form-control"
                                                            required><?php echo $enq_date_from_se . $enq_date_to_se; ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left: 10px;">
                                                        <button type="submit"
                                                            class="btn btn-round btn-primary">Assign</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    if (check_permission('reports', 'allowquickassignenquirestosalesstaff')) { ?>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="x_panel tile fixed_height_320">
                                <div class="x_title">
                                    <h2>Assign to sales staff</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="dashboard-widget-content">
                                    <div class="x_content">
                                        <form class="frmQuickAssign"
                                            data-url="<?php echo site_url('reports/allowquickassignenquirestosalesstaff'); ?>"
                                            method="get">
                                            <input type="hidden" name="searchValues"
                                                value='<?php echo !empty($_GET) ? serialize($_GET) : ''; ?>' />
                                            <table>
                                                <tr>
                                                    <td style="padding:10px;">
                                                        <?php
                                                        $enq_date_from = !empty($enq_date_from) ? 'date from ' . $enq_date_from : '';
                                                        $enq_date_to = !empty($enq_date_to) ? ', date to ' . $enq_date_to : '';
                                                        ?>
                                                        <textarea placeholder="Description" name="desc"
                                                            class="select2_group form-control"
                                                            required><?php echo $enq_date_from . $enq_date_to; ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left: 10px;">
                                                        <button type="submit"
                                                            class="btn btn-round btn-primary">Assign</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    if (check_permission('reports', 'allowresinedstfenqreassign')) { ?>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="x_panel tile fixed_height_320">
                                <div class="x_title">
                                    <h2>Move resigned staff enquiries (pool)</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="dashboard-widget-content">
                                    <div class="x_content">
                                        <form class="frmQuickAssign"
                                            data-url="<?php echo site_url('reports/submitReAssign'); ?>" method="get">
                                            <input type="hidden" name="searchValues"
                                                value='<?php echo !empty($_GET) ? serialize($_GET) : ''; ?>' />
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
                                                        <?php
                                                        $enq_date_from_se = !empty($enq_date_from) ? 'date from ' . $enq_date_from : '';
                                                        $enq_date_to_se = !empty($enq_date_to) ? ', date to ' . $enq_date_to : '';
                                                        ?>
                                                        <textarea placeholder="Description" name="desc"
                                                            class="select2_group form-control"
                                                            required><?php echo $enq_date_from_se . $enq_date_to_se; ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left: 10px;">
                                                        <button type="submit"
                                                            class="btn btn-round btn-primary">Assign</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    if (check_permission('reports', 'allowenquiryforcedrop')) { ?>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="x_panel tile fixed_height_320">
                                <div class="x_title">
                                    <h2>Drop enquires</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="dashboard-widget-content">
                                    <div class="x_content">
                                        <form class="frmQuickAssign"
                                            data-url="<?php echo site_url('reports/allowenquiryforcedrop'); ?>"
                                            method="get">
                                            <input type="hidden" name="searchValues"
                                                value='<?php echo !empty($_GET) ? serialize($_GET) : ''; ?>' />
                                            <input type="hidden" name="source" value="rpt_enquires" />
                                            <table>
                                                <tr>
                                                    <td style="padding:10px;">
                                                        <?php
                                                        $enq_date_from_se = !empty($enq_date_from) ? 'date from ' . $enq_date_from : '';
                                                        $enq_date_to_se = !empty($enq_date_to) ? ', date to ' . $enq_date_to : '';
                                                        ?>
                                                        <textarea placeholder="Description" name="desc"
                                                            class="select2_group form-control"
                                                            required><?php echo $enq_date_from_se . $enq_date_to_se; ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left: 10px;">
                                                        <button type="submit"
                                                            class="btn btn-round btn-primary">Assign</button>
                                                    </td>
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
</div>

<script>
    $(document).ready(function() {
        var qryString = "<?php echo '?' . $_SERVER['QUERY_STRING']; ?>";
        var uid = "<?php echo $this->uid; ?>";
        $(document).on('click', '.btnRestrctData', function() {

            var enq_date_from = $('.enq_date_from').val();
            var enq_date_to = $('.enq_date_to').val();

            // if (enq_date_from && enq_date_to) {

            const fromArray = enq_date_from.split("-");
            let dateFrom = fromArray[2] + '-' + fromArray[1] + '-' + fromArray[0];

            const toArray = enq_date_to.split("-");
            let dateTo = toArray[2] + '-' + toArray[1] + '-' + toArray[0];

            var start = new Date(dateFrom),
                end = new Date(dateTo),
                diff = new Date(end - start),
                days = diff / 1000 / 60 / 60 / 24;

            if (days > 36500000000000000000) {
                alert('Please select date from, to between 30 days ranges!');
            } else {
                if (uid == 100) {
                    var post = "<?php echo site_url('reports/exportEnquires'); ?>" + qryString;
                    var JSONData = $.getJSON(post, function(data) {
                        var items = data;
                        const replacer = (key, value) => value === null ? '' :
                            value; // specify how you want to handle null values here
                        const header = Object.keys(items[0]);
                        let csv = items.map(row => header.map(fieldName => JSON.stringify(row[
                            fieldName], replacer)).join(','));
                        csv.unshift(header.join(','));
                        csv = csv.join('\r\n');

                        //Download the file as CSV
                        var downloadLink = document.createElement("a");
                        var blob = new Blob(["\ufeff", csv]);
                        var url = URL.createObjectURL(blob);
                        downloadLink.href = url;
                        downloadLink.download = "DataDump.csv"; //Name the file here
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);
                    });
                } else {
                    location.href = "<?php echo site_url('reports/exportEnquires'); ?>" + qryString;
                }
            }
            // } else {
            //     alert('Please select date from, to between 30 days ranges!');
            // }
        });
        $('#tblEnqReport').DataTable({
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