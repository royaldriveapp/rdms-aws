<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>My register</h2>
                    <div style="float: right;">
                        <a href="<?php echo site_url($controller . '/myregister?type=ex'); ?>">
                            <i class="fa fa-circle" style="color: #003580;"> Existing </i>
                        </a>
                        <a href="<?php echo site_url($controller . '/myregister?type=nw'); ?>">
                            <i class="fa fa-circle" style="color: red;"> New </i>
                        </a>
                        <a href="<?php echo site_url($controller . '/myregister'); ?>">
                            <i class="fa fa-circle" style="color: black;"> All </i>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Register analysis</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li style="float: right;">
                                        <?php if (check_permission('enquiry', 'export_excel') && !empty($_SERVER['QUERY_STRING'])) { ?>
                                            <a class="btnRestrctData">
                                                <img width="20" title="Export to excel" src="images/excel-export.png" />
                                            </a>
                                        <?php } ?>
                                    </li>
                                    <li style="float:right;"><a data-toggle="collapse" href="#collapseExample"
                                            role="button" aria-expanded="false" aria-controls="collapseExample"><i
                                                class="fa fa-chevron-up"></i>
                                            <i class="fa fa-chevron-down"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content collapse" id="collapseExample">
                                <?php if (check_permission('enquiry', 'myregistercallanalysis')) { ?>
                                    <h2>Todays calls analysis</h2>
                                    <div class="x_content">
                                        <table class="table table-striped table-bordered">
                                            <tbody>
                                                <?php
                                                if (!empty($tc)) {
                                                    foreach ($tc as $key => $value) {
                                                        $mod = unserialize(MODE_OF_CONTACT);
                                                        if (!empty($value['analysis'])) {
                                                ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $value['col_title']; ?>
                                                                </td>
                                                                <td class="bold-text">
                                                                    <?php foreach ($value['analysis'] as $k => $val) {
                                                                    ?>
                                                                        <span><?php echo isset($mod[$val['vreg_contact_mode']]) ? $mod[$val['vreg_contact_mode']] : ''; ?></span>
                                                                        :
                                                                        <span><?php echo $val['cnt']; ?></span>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php }
                                if (is_roo_user() && !empty($staff)) {
                                    $ttl = 0;
                                ?>
                                    <div class="x_content">
                                        <table class="table table-striped table-bordered">
                                            <tbody>
                                                <?php foreach ($staff as $key => $rgvalue) {
                                                    $stf = $this->enquiry->regPendingCount($rgvalue['user_id']);
                                                    $ttl = $ttl + count($stf);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $rgvalue['col_title']; ?></td>
                                                        <td class="bold-text"><?php echo count($stf); ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td>Total</td>
                                                    <td><?php echo $ttl; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="x_content">
                    <?php
                    $currentURL = current_url();
                    $params = $_SERVER['QUERY_STRING'];
                    $fullURL = $currentURL . '?' . $params;
                    ?>
                    <form action="<?php echo $fullURL; ?>" method="get">
                        <input type="hidden" name="type"
                            value="<?php echo isset($_GET['type']) ? $_GET['type'] : ''; ?>" />
                        <table>
                            <tr>
                                <td>
                                    <select class="select2_group form-control cmbBindShowroomByDivision"
                                        name="vreg_division" id="vreg_division"
                                        data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>"
                                        data-bind="cmbShowroom" data-dflt-select="Select Showroom">
                                        <option value="">Select division</option>
                                        <?php foreach ($division as $key => $value) { ?>
                                            <option <?php
                                                    echo (isset($_GET['vreg_division']) && ($_GET['vreg_division'] == $value['div_id'])) ?
                                                        'selected="selected"' : '';
                                                    ?> value="<?php echo $value['div_id']; ?>">
                                                <?php echo $value['div_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="select2_group form-control cmbShowroom shorm_stf"
                                        name="vreg_showroom" id="vreg_showroom">
                                        <option value="">Select showroom</option>
                                        <?php foreach ($showroom['associatedShowroom'] as $key => $value) { ?>
                                            <option <?php
                                                    echo (isset($_GET['vreg_showroom']) && ($_GET['vreg_showroom'] == $value['col_id'])) ?
                                                        'selected="selected"' : '';
                                                    ?> value="<?php echo $value['col_id']; ?>">
                                                <?php echo $value['col_title']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="select2_group form-control" name="vreg_department">
                                        <option value="">Select Departments</option>
                                        <?php
                                        foreach ($departments as $key => $value) {
                                            $selected = (isset($_GET['vreg_department']) && ($_GET['vreg_department'] == $value['dep_id'])) ? 'selected="selected"' : '';
                                        ?>
                                            <option <?php echo $selected; ?> value="<?php echo $value['dep_id']; ?>">
                                                <?php echo $value['dep_name'] . ' (' . $value['div_name'] . ')'; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="select2_group form-control" name="vreg_call_type">
                                        <option value="">Select Lead type</option>
                                        <?php
                                        foreach (unserialize(CALL_TYPE) as $key => $value) {
                                            $selected = (isset($_GET['vreg_call_type']) && ($_GET['vreg_call_type'] == $key)) ? 'selected="selected"' : '';
                                        ?>
                                            <option <?php echo $selected; ?> value="<?php echo $key; ?>">
                                                <?php echo $value; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>

                                <td>
                                    <select class="select2_group form-control cmbContactMode" name="vreg_contact_mode">
                                        <option value="">Mode of contact</option>
                                        <?php
                                        foreach (unserialize(MODE_OF_CONTACT) as $key => $value) {
                                            $selected = (isset($_GET['vreg_contact_mode']) && ($_GET['vreg_contact_mode'] == $key)) ?
                                                'selected="selected"' : '';
                                        ?>
                                            <option <?php echo $selected; ?> value="<?php echo $key; ?>">
                                                <?php echo $value; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td class="divEvents"
                                    <?php echo $_GET['vreg_contact_mode'] == 5 ? '' : 'style="display: none;"' ?>">
                                    <!-- evnt dpnt-->
                                    <select class="select2_group form-control" name="vreg_event" id="vreg_event">
                                        <option value="">Select Event</option>
                                        <?php
                                        foreach ($events as $key => $value) {
                                            $selected = (isset($_GET['vreg_event']) && ($_GET['vreg_event'] == $value['evnt_id'])) ?
                                                'selected="selected"' : '';
                                        ?>
                                            <option <?php echo $selected; ?> value="<?php echo $value['evnt_id']; ?>">
                                                <?php echo $value['evnt_title']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                    <!--@evnt dpnt-->
                                </td>
                                <td>
                                    <select class="select2_group form-control" name="vreg_is_effective">
                                        <option value="">All</option>
                                        <option
                                            <?php echo (isset($_GET['vreg_is_effective']) && ($_GET['vreg_is_effective'] == '1')) ? 'selected="selected"' : ''; ?>
                                            value="1">Effective call</option>
                                        <option
                                            <?php echo (isset($_GET['vreg_is_effective']) && ($_GET['vreg_is_effective'] == '0')) ? 'selected="selected"' : ''; ?>
                                            value="0">Ineffective call</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="select2_group form-control" name="added_entry">
                                        <option value="">Added/Entry date</option>
                                        <option value="vreg_added_on"
                                            <?php echo (isset($_GET['added_entry']) && $_GET['added_entry'] == 'vreg_added_on') ? 'selected="selected"' : ''; ?>>
                                            Added date</option>
                                        <option value="vreg_entry_date"
                                            <?php echo (isset($_GET['added_entry']) && $_GET['added_entry'] == 'vreg_entry_date') ? 'selected="selected"' : ''; ?>>
                                            Entry date</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="select2_group form-control" name="hhpwc">
                                        <option value="">Please select customer status</option>
                                        <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>"
                                                <?php echo (isset($_GET['hhpwc']) && ($_GET['hhpwc'] == $key)) ? 'selected="selected"' : ''; ?>>
                                                <?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <input autocomplete="off" name="vreg_added_on_fr" type="text"
                                        class="enq_date_from dtpDatePickerDMY form-control col-md-7 col-xs-12"
                                        placeholder="Date from"
                                        value="<?php echo isset($_GET['vreg_added_on_fr']) ? $_GET['vreg_added_on_fr'] : ''; ?>" />
                                </td>
                                <td style="padding-left: 10px;">
                                    <input autocomplete="off" name="vreg_added_on_to" type="text"
                                        class="enq_date_to dtpDatePickerDMY form-control col-md-7 col-xs-12"
                                        placeholder="Date to"
                                        value="<?php echo isset($_GET['vreg_added_on_to']) ? $_GET['vreg_added_on_to'] : ''; ?>" />
                                </td>
                                <td style="padding-left: 10px;">
                                    <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select data-url="<?php echo site_url('enquiry/bindModel'); ?>"
                                        data-bind="cmbEvModel" data-dflt-select="Select Model"
                                        class="cmbBrand select2_group form-control bindToDropdown" name="vreg_brand"
                                        id="vreg_brand">
                                        <option value="">Select Brand</option>
                                        <?php
                                        if (!empty($brand)) {
                                            foreach ($brand as $key => $value) {
                                        ?>
                                                <option value="<?php echo $value['brd_id']; ?>">
                                                    <?php echo $value['brd_title']; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select data-url="<?php echo site_url('enquiry/bindVarient'); ?>"
                                        data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                        class="cmbEvModel select2_group form-control bindToDropdown" name="vreg_model"
                                        id="vreg_model">
                                    </select>
                                </td>
                                <td>
                                    <select class="select2_group form-control cmbEvVariant" name="vreg_varient"
                                        id="vreg_varient"></select>
                                </td>
                                <?php if (check_permission('enquiry', 'myregisterassignaddedfilter')) { ?>
                                    <td>
                                        <select class="select2_group form-control enq_se_id" name="vreg_assigned_to">
                                            <option value="">Assign to</option>
                                            <option value="<?php echo $this->uid; ?>">
                                                <?php echo $this->session->userdata('usr_username'); ?></option>
                                            <?php foreach ($staff as $key => $value) { ?>
                                                <option value="<?php echo $value['col_id']; ?>"
                                                    <?php echo (isset($_GET['vreg_assigned_to']) && ($_GET['vreg_assigned_to'] == $value['col_id'])) ? 'selected="selected"' : ''; ?>>
                                                    <?php echo $value['col_title']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="select2_group form-control enq_se_id" name="vreg_added_by">
                                            <option value="">Assigned by</option>
                                            <?php foreach ($teleCallers as $key => $value) { ?>
                                                <option value="<?php echo $value['col_id']; ?>"
                                                    <?php echo (isset($_GET['vreg_added_by']) && ($_GET['vreg_added_by'] == $value['col_id'])) ? 'selected="selected"' : ''; ?>>
                                                    <?php echo $value['col_title']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="select2_group form-control enq_se_id" name="vreg_first_owner">
                                            <option value="">First punched by</option>
                                            <?php foreach ($teleCallers as $key => $value) { ?>
                                                <option value="<?php echo $value['col_id']; ?>"
                                                    <?php echo (isset($_GET['vreg_first_owner']) && ($_GET['vreg_first_owner'] == $value['col_id'])) ? 'selected="selected"' : ''; ?>>
                                                    <?php echo $value['col_title']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="select2_group form-control" name="vreg_is_punched">
                                            <option
                                                <?php echo (isset($_GET['vreg_is_punched']) && ($_GET['vreg_is_punched'] < 0)) ? 'selected="selected"' : ''; ?>
                                                value="-1">All status</option>
                                            <option
                                                <?php echo (isset($_GET['vreg_is_punched']) && ($_GET['vreg_is_punched'] == 0)) ? 'selected="selected"' : ''; ?>
                                                value="0">Register Pending</option>
                                            <option
                                                <?php echo (isset($_GET['vreg_is_punched']) && ($_GET['vreg_is_punched'] == 1)) ? 'selected="selected"' : ''; ?>
                                                value="1">Punched</option>
                                        </select>
                                    </td>

                                <?php } ?>
                                <td colspan="2">
                                    <input autocomplete="off" name="search" type="text"
                                        class="form-control col-md-7 col-xs-12" placeholder="Search"
                                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                                </td>
                                <td>
                                    Show all enquiry status <input type="checkbox" name="chkAllStatus"
                                        <?php echo (isset($_GET['chkAllStatus']) && $_GET['chkAllStatus'] == 1) ? "checked" : ''; ?>
                                        value="1" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <!-- -->
                <!-- <div class="x_content">
                         <form method="get" action="<?php //echo $fullURL; 
                                                    ?>">
                              <table>
                                   <tr>
                                        <td>
                                             <input autocomplete="off" name="search" type="text" class="form-control col-md-7 col-xs-12" placeholder="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                                        </td>
                                        <td style="padding-left: 10px;">
                                             <button type="submit" class="btn btn-round btn-primary">Search</button>
                                        </td>
                                   </tr>
                              </table>
                         </form>
                    </div> -->
                <div class="x_content">
                    <div style="width: 100%;overflow-x: scroll;">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Entry date</th>
                                    <?php if (check_permission('registration', 'shownextfollinmyreglist')) { ?>
                                        <th>Next followup</th>
                                        <th>No of Followup done</th>
                                    <?php } ?>
                                    <th>Customer name</th>
                                    <th>Customer status</th>
                                  
                                    <th>WhatsApp</th>
                                      <th>Contact</th>
                                    <th>Place</th>
                                    <th>Disctrict</th>
                                    <th>Contact mode</th>
                                    <th>Referal Type</th>
                                    <th>Ref.Name</th>
                                    <th>Ref.Phone</th>
                                    <th>Event</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Variant</th>
                                    <th>Year</th>
                                    <th>Investment</th>
                                    <th>Added on</th>
                                    <th>Status</th>
                                    <th>Call type</th>
                                    <th>Division</th>
                                    <th>Department</th>
                                    <?php if (check_permission('registration', 'showassignto')) { ?>
                                        <th>Assigned to</th>
                                    <?php } ?>
                                    <th>Added by</th>
                                    <?php if (check_permission('registration', 'candelete')) { ?>
                                        <th>Delete</th>
                                    <?php }
                                    if (check_permission('registration', 'alloworeassign')) { ?>
                                        <th>Punch</th>
                                    <?php } ?>
                                    <td>Remarks</td>
                                    <td>TSC Remarks</td>
                                    <td>Punched on</td>
                                    <?php if (check_permission('registration', 'reassigntosalesstaff')) { ?>
                                        <th>Reassign</th>
                                    <?php } ?>
                                    <th>Appointment on</th>
                                    <?php //if (check_permission('registration', 'showcourtseycallcmdmyregister')) { 
                                    ?>
                                    <th>Second day courtsey comments</th>
                                    <?php //} 
                                    ?>
                                    <th>Share</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $colspan = 16;

                                if (!empty($datas)) {
                                    foreach ((array) $datas as $key => $value) {
                                        $regFollowups = $this->enquiry->regFollowups($value['vreg_id']);
                                        $remarks = strip_tags($value['vreg_customer_remark']);
                                        $url = '';
                                        //if ($value['vreg_is_verified']) {
                                        $url = !empty($value['vreg_inquiry']) ?
                                            site_url('followup/viewFollowup/' . encryptor($value['vreg_inquiry']) . '?assignto=' . $this->uid) : site_url($controller . '/regiter_2_inquiry/' . encryptor($value['vreg_id']));
                                        //}
                                        $color = 'color: #fff';
                                        $bgColor = '';
                                        $canPunch = 1;
                                        if (empty($value['vreg_inquiry'])) {
                                            $bgColor = 'red';
                                        } else if ($value['vreg_is_verified'] != 1) {
                                            $bgColor = '#4c3000';
                                            $canPunch = 0;
                                        } else {
                                            $bgColor = '#004099';
                                        }

                                        $trVOE = '';
                                        if (check_permission('registration', 'caneditmyregister') || $this->usr_grp == 'AD') {
                                            $trVOE = 'trVOE';
                                        }
                                        if (check_permission('registration', 'shownextfollinmyreglist')) {
                                            $now = date('Y-m-d');
                                            $date1 = new DateTime($follupDate = date('Y-m-d', strtotime($value['vreg_next_followup'])));
                                            $date2 = new DateTime($now);
                                            $folColor = '';

                                            if (($date2->diff($date1)->format("%r%a") >= 0 && !empty($value['vreg_next_followup']))) {
                                                $folColor = 'background:yellow;color:#000 !important;';
                                            }
                                        }
                                ?>
                                        <tr data-url="<?php echo site_url('registration/view/' . encryptor($value['vreg_id'])); ?>"
                                            style="<?php echo $color; ?>;background-color: <?php echo $bgColor; ?>">
                                            <td style="wid">
                                                <?php if ($value['vreg_is_effective'] == 1) { ?><i title="Effective call"
                                                        style="color: green;" class="fa fa-check"></i> <?php } ?>
                                                <?php echo date('j M Y', strtotime($value['vreg_entry_date'])); ?>
                                            </td>
                                            <?php if (check_permission('registration', 'shownextfollinmyreglist')) { ?>
                                                <td diff="<?php echo $date2->diff($date1)->format("%r%a"); ?>"
                                                    style="<?php echo $folColor; ?>">
                                                    <?php echo !empty($value['vreg_next_followup']) ? date('j M Y', strtotime($value['vreg_next_followup'])) : ''; ?>
                                                </td>
                                                <td><?php echo $value['vreg_next_followup_cont']; ?></td>
                                            <?php } ?>
                                            <td><?php echo $value['cusd_name']; ?></td>
                                            <td>
                                                <?php
                                                $stsMods = unserialize(ENQUIRY_UP_STATUS);
                                                echo $stsMods = isset($stsMods[$value['vreg_customer_status']]) ? $stsMods[$value['vreg_customer_status']] : '';
                                                ?>
                                            </td>
                                            <td>
    <?php if (!empty($value['cusd_whatsapp'])): ?>
        <a style="color: #fff;" target="_blank"
            href="https://api.whatsapp.com/send?phone=<?php echo $value['cusd_whatsapp']; ?>">
            <i class="fa fa-whatsapp" style="color: #25D366; margin-right: 5px;"></i>
            <?php echo $value['cusd_whatsapp']; ?>
        </a>
    <?php endif; ?>
</td>
                                            <td>

                                            <?php
$customer_phones = !empty($value['phone_numbers']) ? explode(', ', $value['phone_numbers']) : [];

if (!empty($customer_phones)) {
    foreach ($customer_phones as $phone) {
        $clean_number = preg_replace('/[^0-9+]/', '', trim($phone)); // Trim spaces
        echo '<a style="color: rgb(255, 255, 255); text-decoration: none;" 
                href="tel:' . htmlspecialchars($clean_number) . '" 
                class="action" 
                title="Call ' . htmlspecialchars($clean_number) . '"
                onclick="return navigator.userAgent.match(/mobile/i)">';
        echo '<i class="fa fa-phone" style="color: rgb(189, 191, 193); margin-right: 5px;"></i>';
        echo htmlspecialchars($clean_number);
        echo '</a><br>';
    }
} else {
    echo '<span>No phone numbers available</span>';
}
?>

</td>

                                            <td><?php echo $value['cusd_place']; ?></td>
                                            <td><?php echo $value['std_district_name']; ?></td>
                                            <td>
                                                <?php
                                                $modes = unserialize(MODE_OF_CONTACT);
                                                echo isset($modes[$value['vreg_contact_mode']]) ? $modes[$value['vreg_contact_mode']] : '';
                                                ?>
                                            </td>
                                            <td class="<?php echo $trVOE; ?>">
                                                <?php
                                                $ref_type = unserialize(REFERAL_TYPES);
                                                echo isset($ref_type[$value['vreg_referal_type']]) ? $ref_type[$value['vreg_referal_type']] : '';
                                                ?>
                                            </td>
                                            <td class="<?php echo $trVOE; ?>">
                                                <?php
                                                $ref_name = $value['vreg_referal_name'];
                                                if ($value['vreg_referal_type'] == 4) {
                                                    $rd_staff = $this->registration->getStaffById($value['vreg_referal_name']);
                                                    $ref_name = $rd_staff['col_title'];
                                                }
                                                echo $ref_name;
                                                ?>

                                            </td>
                                            <td class="<?php echo $trVOE; ?>">
                                                <?php echo $value['vreg_referal_phone'] ?>
                                            </td>
                                            <td><?php echo $value['evnt_title']; ?></td>
                                            <td><?php echo $value['brd_title']; ?></td>
                                            <td><?php echo $value['mod_title']; ?></td>
                                            <td><?php echo $value['var_variant_name']; ?></td>
                                            <td><?php echo $value['vreg_year']; ?></td>
                                            <td><?php echo $value['vreg_investment']; ?></td>
                                            <td><?php echo date('j M Y', strtotime($value['vreg_added_on'])); ?></td>
                                            <td><?php echo ($value['vreg_is_verified'] == 1) ? 'Verified' : 'Pending'; ?></td>
                                            <td>
                                                <?php
                                                $callTypes = unserialize(CALL_TYPE);
                                                echo isset($callTypes[$value['vreg_call_type']]) ? $callTypes[$value['vreg_call_type']] : '';
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $div = $this->divisions->getDivNameById($value['div_id']);
                                                echo $div['div_name'];
                                                ?>
                                            </td>
                                            <td><?php echo $value['dep_name']; ?></td>
                                            <?php if (check_permission('registration', 'showassignto')) { ?>
                                                <td><?php echo $value['assign_usr_first_name']; ?></td>
                                            <?php } ?>
                                            <td><?php echo $value['addedby_usr_first_name']; ?>
                                                <?php if ($value['vreg_last_action']) { ?>
                                                    <i class="fa fa-comment" style="color: #fff;"
                                                        title="<?php echo $value['vreg_last_action']; ?>"></i>
                                                <?php } ?>
                                            </td>
                                            <?php
                                            if (check_permission('registration', 'candelete')) {
                                                $colspan = $colspan + 1;
                                            ?>
                                                <td>
                                                    <a class="pencile deleteListItem" href="javascript:void(0);"
                                                        data-url="<?php echo site_url('registration/delete/' . $value['vreg_id']); ?>">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                </td>
                                            <?php }
                                            if (check_permission('registration', 'alloworeassign') && ($canPunch == 1)) { ?>
                                                <td>
                                                    <div onclick="$('#<?php echo $value['vreg_id']; ?>').modal({backdrop: false});">
                                                        <i class="fa fa-pencil-square" data-toggle="modal" data-target="#<?php //echo $value['vreg_id'];
                                                                                                                            ?>"></i>
                                                    </div>
                                                    <div class="modal fade divModel" id="<?php echo $value['vreg_id']; ?>"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document" style="width: 100%;">
                                                            <div class="modal-content" style="color: black;">
                                                                <div class="modal-header">
                                                                    <h5 style="width: 66px;float: left;" class="modal-title"
                                                                        id="exampleModalLabel">Modal title</h5>
                                                                    <button style="float:right;" type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <div class="col-sm">
                                                                                <div class="col-md-6 col-sm-12 col-xs-12">
                                                                                    <div class="x_panel">
                                                                                        <div class="x_content">
                                                                                            <div class="row"
                                                                                                style="text-align: center;font-weight: bolder;font-size: 18px;">
                                                                                                Followup/New enquiry</div>
                                                                                            <div class="form-group"
                                                                                                style="width: 100%;float: left;white-space: normal;">
                                                                                                <label
                                                                                                    class="control-label col-md-3 col-sm-3 col-xs-12">Customer
                                                                                                    name</label>
                                                                                                <div
                                                                                                    class="col-md-6 col-sm-6 col-xs-12">
                                                                                                    <?php echo $value['cusd_name']; ?>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="form-group"
                                                                                                style="width: 100%;float: left;white-space: normal;">
                                                                                                <label
                                                                                                    class="control-label col-md-3 col-sm-3 col-xs-12">WhatsApp
                                                                                                    No</label>
                                                                                                <div
                                                                                                    class="col-md-6 col-sm-6 col-xs-12">
                                                                                                    <a style="color: #000;"
                                                                                                        target="_blank"
                                                                                                        href="https://api.whatsapp.com/send?phone=<?php echo $value['cusd_whatsapp']; ?>">  <i class="fa fa-whatsapp" style="color: #25D366; margin-right: 5px;"></i> <?php echo $value['cusd_whatsapp']; ?></a>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="form-group"
                                                                                                style="width: 100%;float: left;white-space: normal;">
                                                                                                <label
                                                                                                    class="control-label col-md-3 col-sm-3 col-xs-12">Contact No
                                                                                                    </label>
                                                                                                <div
                                                                                                    class="col-md-6 col-sm-6 col-xs-12">
                                                                                                    <?php
$customer_phones = !empty($value['phone_numbers']) ? explode(', ', $value['phone_numbers']) : [];

if (!empty($customer_phones)) {
    foreach ($customer_phones as $phone) {
        $clean_number = preg_replace('/[^0-9+]/', '', trim($phone)); // Trim spaces
        echo '<a style="color: rgb(0, 0, 0); text-decoration: none;" 
                href="tel:' . htmlspecialchars($clean_number) . '" 
                class="action" 
                title="Call ' . htmlspecialchars($clean_number) . '"
                onclick="return navigator.userAgent.match(/mobile/i)">';
        echo '<i class="fa fa-phone" style="color: rgb(189, 191, 193); margin-right: 5px;"></i>';
        echo htmlspecialchars($clean_number);
        echo '</a><br>';
    }
} else {
    echo '<span>No phone numbers available</span>';
}
?>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="form-group"
                                                                                                style="width: 100%;float: left;white-space: normal;">
                                                                                                <label
                                                                                                    class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                                                                                                <div
                                                                                                    class="col-md-6 col-sm-6 col-xs-12">
                                                                                                    <?php echo $value['cusd_place']; ?>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="form-group"
                                                                                                style="width: 100%;float: left;white-space: normal;">
                                                                                                <label
                                                                                                    class="control-label col-md-3 col-sm-3 col-xs-12">Customer
                                                                                                    feedback</label>
                                                                                                <div
                                                                                                    class="col-md-6 col-sm-6 col-xs-12">
                                                                                                    <?php echo $value['vreg_customer_remark']; ?>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="form-group"
                                                                                                style="width: 100%;float: left;white-space: normal;">
                                                                                                <label
                                                                                                    class="control-label col-md-3 col-sm-3 col-xs-12">Assigned
                                                                                                    by</label>
                                                                                                <div
                                                                                                    class="col-md-6 col-sm-6 col-xs-12">
                                                                                                    <?php echo $value['addedby_usr_first_name'] . ' ' . $value['addedby_usr_last_name']; ?>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php
                                                                                            if (check_permission('callrecord', 'listencallrecord')) {
                                                                                                $call = $this->enquiry->getConnectedCallByRegister($value['vreg_id']);
                                                                                                $call = isset($call['ccb_recording_URL']) ? $call['ccb_recording_URL'] : '';
                                                                                                if (!empty($call)) {
                                                                                            ?>
                                                                                                    <div class="form-group"
                                                                                                        style="width: 100%;float: left;white-space: normal;">
                                                                                                        <label
                                                                                                            class="control-label col-md-3 col-sm-3 col-xs-12">Call
                                                                                                            record</label>
                                                                                                        <div
                                                                                                            class="col-md-6 col-sm-6 col-xs-12">
                                                                                                            <a target="blank"
                                                                                                                href="<?php echo 'http://45.249.170.209:8080/content/incomingrecordings/' . $call; ?>"><i
                                                                                                                    class="fa fa-play-circle-o"
                                                                                                                    style="font-size:25px;"></i></a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                            <?php }
                                                                                            } ?>
                                                                                            <div class="form-group"
                                                                                                style="width: 100%;float: left;white-space: normal;">
                                                                                                <label
                                                                                                    class="control-label col-md-3 col-sm-3 col-xs-12">Other
                                                                                                    remark</label>
                                                                                                <div
                                                                                                    class="col-md-6 col-sm-6 col-xs-12">
                                                                                                    <?php echo $value['vreg_last_action']; ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                        if (check_permission('registration', 'showreghistory')) {
                                                                                            $regHistory = $this->registration->reghistory($value['vreg_id']);
                                                                                        ?>
                                                                                            <div
                                                                                                style="width: 100%;overflow-x: scroll;">
                                                                                                <table
                                                                                                    class="table table-striped table-bordered">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th>Date</th>
                                                                                                            <th>Assigned By</th>
                                                                                                            <th>Assigned To</th>
                                                                                                            <th>Comments</th>
                                                                                                            <th>Remarks</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <?php
                                                                                                        foreach ($regHistory as $hkey => $hvalue) {
                                                                                                        ?>
                                                                                                            <tr>
                                                                                                                <td><?php echo date('j M Y h:i', strtotime($hvalue['regh_added_date'])); ?>
                                                                                                                </td>
                                                                                                                <td><?php echo $hvalue['addedby_usr_first_name'] . ' ' . $hvalue['addedby_usr_last_name']; ?>
                                                                                                                </td>
                                                                                                                <td><?php echo $hvalue['assign_usr_first_name'] . ' ' . $hvalue['assign_usr_last_name']; ?>
                                                                                                                </td>
                                                                                                                <td><?php echo $hvalue['regh_remarks']; ?>
                                                                                                                </td>
                                                                                                                <td><?php echo $hvalue['regh_system_cmd']; ?>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        <?php } ?>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        <?php }
                                                                                        if (check_permission('registration', 'canpnchenqorfolup')) { ?>
                                                                                            <div class="row"
                                                                                                style="text-align: center;float: left;">
                                                                                                <div>
                                                                                                    <?php $txtPunch = !empty($value['vreg_inquiry']) ? 'Followup' : 'Punch to enquiry'; ?>
                                                                                                    <a class="btn btn-primary"
                                                                                                        href="<?php echo $url; ?>"><?php echo $txtPunch; ?></a><br>
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php if (check_permission('registration', 'candoregfolup')) { ?>
                                                                                <div class="col-sm">
                                                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                                                        <div class="x_panel">
                                                                                            <!-- -->
                                                                                            <?php if (!empty($regFollowups)) { ?>
                                                                                                <div
                                                                                                    style="height: 150px;overflow-x: hidden;overflow-y: scroll;">
                                                                                                    <?php foreach ($regFollowups as $fkey => $fvalue) { ?>
                                                                                                        <div
                                                                                                            style="float: left;width: 100%; font-style: italic;background: #E7E7E7;padding: 10px;border-radius: 10px;margin-bottom: 10px;">
                                                                                                            <p class="excerpt">Remarks :
                                                                                                                <?php echo isset($fvalue['regf_desc']) ? $fvalue['regf_desc'] : ''; ?>
                                                                                                            </p>
                                                                                                            <p class="excerpt">Followup date :
                                                                                                                <?php echo isset($fvalue['regf_next_folowup']) ? date('d-m-Y h:i A', strtotime($fvalue['regf_next_folowup'])) : ''; ?>
                                                                                                            </p>
                                                                                                            <p class="excerpt"
                                                                                                                style="float: right;">Added on :
                                                                                                                <?php echo isset($fvalue['regf_added_on']) ? $fvalue['regf_added_on'] : ''; ?>
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                            <!-- -->
                                                                                            <form class="x_content frmRegisterFollowup"
                                                                                                method="post"
                                                                                                action="<?php echo site_url($controller . '/setRegisterFollowup'); ?>">
                                                                                                <h3
                                                                                                    style="text-align: center;font-weight: bold;">
                                                                                                    Set followup</h3>
                                                                                                <input type="hidden"
                                                                                                    name="vreg_assigned_to"
                                                                                                    value="<?php echo $value['vreg_assigned_to']; ?>" />
                                                                                                <input type="hidden"
                                                                                                    name="vreg_added_by"
                                                                                                    value="<?php echo $value['vreg_added_by']; ?>" />
                                                                                                <input type="hidden"
                                                                                                    name="regfoll[regf_reg_id]"
                                                                                                    value="<?php echo $value['vreg_id']; ?>" />
                                                                                                <input type="hidden"
                                                                                                    name="regfoll[regf_added_by]"
                                                                                                    value="<?php echo $this->uid; ?>" />
                                                                                                <input type="hidden"
                                                                                                    name="regfoll[regf_added_on]"
                                                                                                    value="<?php echo date('Y-m-d H:i:s'); ?>" />

                                                                                                <div class="form-group"
                                                                                                    style="width: 100%;float: left;">
                                                                                                    <label
                                                                                                        class="control-label col-md-3 col-sm-3 col-xs-12">Call
                                                                                                        type <span
                                                                                                            class="required">*</span></label>
                                                                                                    <div
                                                                                                        class="col-md-6 col-sm-6 col-xs-12">
                                                                                                        <select required
                                                                                                            class="select2_group form-control cmbContactMode"
                                                                                                            name="regfoll[regf_reson]"
                                                                                                            id="vreg_contact_mode">
                                                                                                            <option value="">Call type
                                                                                                            </option>
                                                                                                            <option value="3">Call not
                                                                                                                attend</option>
                                                                                                            <option value="12">Line busy
                                                                                                            </option>
                                                                                                            <option value="13">Not
                                                                                                                reachable</option>
                                                                                                            <option value="150">Call
                                                                                                                attended</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="form-group"
                                                                                                    style="width: 100%;float: left;">
                                                                                                    <label
                                                                                                        class="control-label col-md-3 col-sm-3 col-xs-12">Followup
                                                                                                        <span
                                                                                                            class="required">*</span></label>
                                                                                                    <div
                                                                                                        class="col-md-6 col-sm-6 col-xs-12">
                                                                                                        <textarea required
                                                                                                            name="regfoll[regf_desc]"
                                                                                                            class="form-control col-md-5 col-xs-12"></textarea>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="form-group"
                                                                                                    style="width: 100%;float: left;">
                                                                                                    <label
                                                                                                        class="control-label col-md-3 col-sm-3 col-xs-12">Next
                                                                                                        followup date <span
                                                                                                            class="required">*</span></label>
                                                                                                    <div
                                                                                                        class="col-md-6 col-sm-6 col-xs-12">
                                                                                                        <input autocomplete="off"
                                                                                                            type="text"
                                                                                                            name="regfoll[regf_next_folowup]"
                                                                                                            class="form-control col-md-5 col-xs-12 dtpDateTimePickerRegFollowup"
                                                                                                            required
                                                                                                            value="<?php echo date('d-m-Y h:i:A'); ?>" />
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group"
                                                                                                    style="width: 100%;float: left;text-align: center;">
                                                                                                    <div>
                                                                                                        <button
                                                                                                            class="btn btn-primary btnSubmitRegFollowup"
                                                                                                            type="submit">Set
                                                                                                            followup</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>

                                                                        <div class="col-sm">
                                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                                <div class="x_panel">
                                                                                    <?php
                                                                                    //if (($value['vreg_next_followup_cont'] >= 5) || $this->usr_grp == 'TL' || $this->usr_grp == 'TC'  || $this->usr_grp == 'AD') {
                                                                                    ?>
                                                                                    <?php if (check_permission('registration', 'canretnregister')) { ?>
                                                                                        <div class="row"
                                                                                            style="text-align: center;font-weight: bolder;font-size: 18px;">
                                                                                            Re-assign to CRE</div>
                                                                                        <form method="post" class="row"
                                                                                            action="<?php echo site_url($controller . '/sendBackRegister'); ?>">
                                                                                            <input type="hidden" name="assignedTo"
                                                                                                value="<?php echo $value['vreg_added_by'] ?>" />
                                                                                            <input type="hidden" name="assignedFrom"
                                                                                                value="<?php echo $value['vreg_assigned_to'] ?>" />
                                                                                            <input type="hidden" name="regMaster"
                                                                                                value="<?php echo $value['vreg_id'] ?>" />

                                                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                                <div class="x_panel">
                                                                                                    <div class="form-group"
                                                                                                        style="width: 100%;float: left;">
                                                                                                        <label
                                                                                                            class="control-label col-md-3 col-sm-3 col-xs-12">Call
                                                                                                            type <span
                                                                                                                class="required">*</span></label>
                                                                                                        <div
                                                                                                            class="col-md-6 col-sm-6 col-xs-12">
                                                                                                            <select required
                                                                                                                class="select2_group form-control cmbContactMode"
                                                                                                                name="call_type"
                                                                                                                id="vreg_contact_mode">
                                                                                                                <option value="">Call
                                                                                                                    type</option>
                                                                                                                <?php
                                                                                                                foreach (unserialize(CALL_TYPE) as $key => $ctvalue) {
                                                                                                                ?>
                                                                                                                    <option
                                                                                                                        value="<?php echo $key; ?>">
                                                                                                                        <?php echo $ctvalue; ?>
                                                                                                                    </option>
                                                                                                                <?php
                                                                                                                }
                                                                                                                ?>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group"
                                                                                                        style="width: 100%;float: left;">
                                                                                                        <label
                                                                                                            class="control-label col-md-3 col-sm-3 col-xs-12">Reason
                                                                                                            for send back <span
                                                                                                                class="required">*</span>
                                                                                                        </label>
                                                                                                        <div
                                                                                                            class="col-md-6 col-sm-6 col-xs-12">
                                                                                                            <textarea required
                                                                                                                name="reason"
                                                                                                                class="form-control col-md-5 col-xs-12 "></textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal-footer"
                                                                                                        style="float: left;width: 100%;text-align: center;">
                                                                                                        <button type="submit"
                                                                                                            class="btn btn-primary">Reassign
                                                                                                            to telecaller</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    <?php } ?>
                                                                                    <?php //} else {
                                                                                    ?>
                                                                                    <!-- <span>You can reassign register after five followup only, 
                                                                                                              if you are want to reassign immediately please inform your TC or TL</span>-->
                                                                                    <?php //} 
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php if (check_permission('registration', 'allowquickdropregister')) { ?>
                                                                                <div class="col-md-6 col-sm-12 col-xs-12">
                                                                                    <div class="x_panel">
                                                                                        <div class="x_content">
                                                                                            <div class="row"
                                                                                                style="text-align: center;font-weight: bolder;font-size: 18px;">
                                                                                                Drop register</div>
                                                                                            <form method="post"
                                                                                                action="<?php echo site_url('registration/changeRegisterStatus'); ?>"
                                                                                                class="row frmRequestForDrop">
                                                                                                <input type="hidden" name="regMaster"
                                                                                                    value="<?php echo $value['vreg_id']; ?>" />
                                                                                                <input type="hidden" name="status"
                                                                                                    value="<?php echo reg_droped; ?>" />
                                                                                                <input type="hidden" name="callback"
                                                                                                    value="enquiry/myregister" />
                                                                                                <!-- -->
                                                                                                <div
                                                                                                    class="col-md-12 col-sm-12 col-xs-12">
                                                                                                    <div class="x_panel">
                                                                                                        <div class="form-group"
                                                                                                            style="width: 100%;float: left;">
                                                                                                            <label
                                                                                                                class="control-label col-md-3 col-sm-3 col-xs-12">Reason
                                                                                                                for drop <span
                                                                                                                    class="required">*</span>
                                                                                                            </label>
                                                                                                            <div
                                                                                                                class="col-md-6 col-sm-6 col-xs-12">
                                                                                                                <textarea required
                                                                                                                    name="reason"
                                                                                                                    class="txtDropRegReason form-control col-md-5 col-xs-12 "></textarea>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="modal-footer"
                                                                                                            style="float: left;width: 100%;text-align: center;">
                                                                                                            <input type="submit"
                                                                                                                class="btn btn-primary btnRequestForDrop"
                                                                                                                value="Drop register" />
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            <?php } else {
                                                echo '<td></td>';
                                            } ?>
                                            <td class="<?php echo $trVOE; ?>"><?php echo $remarks; ?></td>
                                            <td class="<?php echo $trVOE; ?>"><?php echo $value['vreg_tsc_comments']; ?></td>
                                            <td style="wid">
                                                <?php echo date('j M Y h:i A', strtotime($value['vreg_added_on'])); ?>
                                            </td>
                                            <?php if (check_permission('registration', 'reassigntosalesstaff')) { ?>
                                                <td>
                                                    <a title="Re-assign register" href="javascript:void(0)" data-toggle="modal"
                                                        data-target="#reg<?php echo $value['vreg_id']; ?>">
                                                        <i class="fa fa-repeat" title="Re assign register"></i>
                                                    </a>
                                                    <!-- -->
                                                    <div class="modal fade" id="reg<?php echo $value['vreg_id']; ?>" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form
                                                                    action="<?php echo site_url('enquiry/reassigntosalesstaff'); ?>"
                                                                    method="post">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel"
                                                                            style="float:left;">Modal title</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="vreg_id"
                                                                            value="<?php echo $value['vreg_id']; ?>" />
                                                                        <table class="table table-striped" style="color:#000;">
                                                                            <tr>
                                                                                <td>Customer name</td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="form-control col-md-7 col-xs-12"
                                                                                        name="vreg_cust_name" id="vreg_cust_name"
                                                                                        value="<?php echo $value['vreg_cust_name'] ?>"
                                                                                        autocomplete="off"
                                                                                        placeholder="Customer name" />
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Customer number</td>
                                                                                <td><?php echo $value['vreg_cust_phone'];
                                                                                    if ($value['vreg_inquiry'] > 0) {
                                                                                        $trackCard = 'Track card :  <a target="_blank" href="' . site_url('enquiry/printTrackCard/' . encryptor($value['vreg_inquiry'])) . '"><i title="Track card" class="fa fa-list"></i></a>';
                                                                                        echo '<br> Inquiry already associated with sales executive <strong>' . $value['exstse_usr_username'] . "</strong>";
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>Email</td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="form-control col-md-7 col-xs-12 vreg_email"
                                                                                        name="vreg_email" id="vreg_email"
                                                                                        placeholder="Email"
                                                                                        value="<?php echo $value['vreg_email']; ?>" />
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>Place</td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="form-control col-md-7 col-xs-12"
                                                                                        name="vreg_cust_place" id="vreg_cust_place"
                                                                                        value="<?php echo $value['vreg_cust_place'] ?>"
                                                                                        autocomplete="off"
                                                                                        placeholder="Customer place" />
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Existing vehicle</td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="form-control col-md-7 col-xs-12"
                                                                                        name="vreg_existing_vehicle"
                                                                                        id="vreg_existing_vehicle"
                                                                                        value="<?php echo $value['vreg_existing_vehicle'] ?>"
                                                                                        autocomplete="off"
                                                                                        placeholder="Existing vehicle" />
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Occupation</td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="form-control col-md-7 col-xs-12"
                                                                                        name="vreg_occupation" id="vreg_occupation"
                                                                                        value="<?php echo $value['vreg_occupation'] ?>"
                                                                                        autocomplete="off"
                                                                                        placeholder="Occupation" />
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Brand</td>
                                                                                <td>
                                                                                    <select
                                                                                        data-url="<?php echo site_url('enquiry/bindModel'); ?>"
                                                                                        data-bind="cmbEvModel"
                                                                                        data-dflt-select="Select Model"
                                                                                        class="cmbBrand select2_group form-control bindToDropdown"
                                                                                        name="vreg_brand" id="vreg_brand">
                                                                                        <option value="0">Select Brand</option>
                                                                                        <?php
                                                                                        if (!empty($brand)) {
                                                                                            foreach ($brand as $key => $brd) {
                                                                                        ?>
                                                                                                <option
                                                                                                    value="<?php echo $brd['brd_id']; ?>">
                                                                                                    <?php echo $brd['brd_title']; ?>
                                                                                                </option>
                                                                                        <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Model</td>
                                                                                <td>
                                                                                    <select
                                                                                        data-url="<?php echo site_url('enquiry/bindVarient'); ?>"
                                                                                        data-bind="cmbEvVariant"
                                                                                        data-dflt-select="Select Variant"
                                                                                        class="cmbEvModel select2_group form-control bindToDropdown"
                                                                                        name="vreg_model" id="vreg_model">
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Variant</td>
                                                                                <td>
                                                                                    <select
                                                                                        class="select2_group form-control cmbEvVariant"
                                                                                        name="vreg_varient"
                                                                                        id="vreg_varient"></select>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>Year</td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="form-control col-md-7 col-xs-12"
                                                                                        name="vreg_year" id="vreg_year"
                                                                                        value="<?php echo $value['vreg_year'] ?>"
                                                                                        autocomplete="off"
                                                                                        placeholder="Year 2010-2011" />
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>Investment</td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="form-control col-md-7 col-xs-12"
                                                                                        name="vreg_investment" id="vreg_investment"
                                                                                        value="<?php echo $value['vreg_investment'] ?>"
                                                                                        autocomplete="off"
                                                                                        placeholder="Investment 10,00000-20,00000" />
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>KM</td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="form-control col-md-7 col-xs-12"
                                                                                        value="<?php echo $value['vreg_km'] ?>"
                                                                                        name="vreg_km" id="vreg_km"
                                                                                        autocomplete="off"
                                                                                        placeholder="KM 10000-20000" />
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>Ownership</td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="numOnly form-control col-md-7 col-xs-12"
                                                                                        value="<?php echo $value['vreg_ownership'] ?>"
                                                                                        name="vreg_ownership" id="vreg_ownership"
                                                                                        autocomplete="off"
                                                                                        placeholder="Ownership" />
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>Customer status</td>
                                                                                <td>
                                                                                    <select required
                                                                                        class="select2_group form-control"
                                                                                        name="vreg_customer_status"
                                                                                        id="vreg_customer_status">
                                                                                        <option value="">Please select customer
                                                                                            status</option>
                                                                                        <?php foreach (unserialize(ENQUIRY_UP_STATUS) as $key => $sts) { ?>
                                                                                            <option value="<?php echo $key; ?>">
                                                                                                <?php echo $sts; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>Appointment</td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        class="dtpRegAppntmnt form-control col-md-7 col-xs-12"
                                                                                        name="vreg_appointment"
                                                                                        id="vreg_appointment" autocomplete="off"
                                                                                        placeholder="Appointment" />
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>Type of visit</td>
                                                                                <td>
                                                                                    <select class="select2_group form-control"
                                                                                        name="vreg_type_of_visit`"
                                                                                        id="vreg_type_of_visit">
                                                                                        <?php foreach (unserialize(MODE_OF_CONTACT_FOLLOW_UP) as $key => $folcnt) { ?>
                                                                                            <option value="<?php echo $key; ?>">
                                                                                                <?php echo $folcnt; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Assign to</td>
                                                                                <td>
                                                                                    <select name="vreg_assigned_to"
                                                                                        class="form-control col-md-7 col-xs-12"
                                                                                        required>
                                                                                        <option value="">Select new staff</option>
                                                                                        <?php foreach ($salesStaff as $skey => $stf) { ?>
                                                                                            <option
                                                                                                value="<?php echo $stf['usr_id']; ?>">
                                                                                                <?php echo $stf['usr_first_name'] . ' (' . $stf['shr_location'] . ') - ' . $stf['desig_title']; ?>
                                                                                            </option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2">
                                                                                    <textarea name="vreg_tsc_comments" required
                                                                                        class="form-control col-md-7 col-xs-12"
                                                                                        placeholder="Reson for re-assign enquires"></textarea>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                </td>
                                            <?php } ?>
                                            <td><?php echo !empty($value['vreg_appointment']) ? date('j M Y', strtotime($value['vreg_appointment'])) : ''; ?>
                                            </td>
                                            <?php //if (check_permission('registration', 'showcourtseycallcmdmyregister')) { 
                                            ?>
                                            <td><?php echo isset($value['vreg_second_d_hpy_cal']) ? $value['vreg_second_d_hpy_cal'] : ''; ?>
                                            </td>
                                            <?php //} 
                                            ?>
                                            <td><a target="_blank"
                                                    href="<?php echo 'https://cust.royaldrive.in/share/index/' . $value['vreg_id'] ?>"><i
                                                        class="fa fa-whatsapp"></i></a></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td style="text-align: center;" colspan="<?php echo $colspan; ?>">No data available
                                            in table</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing
                        <?php echo $pageIndex; ?> to <?php echo $limit; ?> of <?php echo $totalRow; ?> entries</div>
                    <div style="float: right;">
                        <?php echo $links; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- reAssign original-->
        <?php if (check_permission('registration', 'allowquickaressignregister')) { ?>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel tile fixed_height_320" style="overflow: scroll;">
                    <div class="x_title">
                        <h2>Re Assign to other staffs</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="dashboard-widget-content">
                        <div class="x_content">
                            <form class="frmQuickAssign" data-url="<?php echo site_url('enquiry/reassignregister'); ?>"
                                method="get">
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
                                                <?php foreach ((array) $salesStaff as $key => $value) { ?>
                                                    <option value="<?php echo $value['usr_id']; ?>">
                                                        <?php echo $value['usr_username']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px;">
                                            <textarea placeholder="Desction" name="desc" class="select2_group form-control"
                                                required></textarea>
                                        </td>
                                    </tr>
                                    <!--                                                              <tr>
                                                                   <td style="padding-left: 10px;">
                                                                        <input type="checkbox" name="isRandomFollDays" value="1" id="foll_days"> Set Random followup days 
                                                                   </td>

                                                              </tr>
                                                              <tr>
                                                                   <td style="padding:10px;">

                                                                        <input placeholder="Enter followup days" type="text" name="followup_days" class="form-control" >
                                                                   </td>
                                                              </tr>-->
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
        <!--@reAssign-->
    </div>
</div>

<style>
    .table>thead>tr>th {
        white-space: nowrap;
        width: 1%;
    }

    .table>tbody>tr>td {
        white-space: nowrap;
        width: 1%;
    }
</style>

<script>
    $(document).ready(function() {
        var qryString = "<?php echo '?' . $_SERVER['QUERY_STRING']; ?>";
        $(document).on('click', '.btnRestrctData', function() {

            var enq_date_from = $('.enq_date_from').val();
            var enq_date_to = $('.enq_date_to').val();

            if (enq_date_from && enq_date_to) {

                const fromArray = enq_date_from.split("-");
                let dateFrom = fromArray[2] + '-' + fromArray[1] + '-' + fromArray[0];

                const toArray = enq_date_to.split("-");
                let dateTo = toArray[2] + '-' + toArray[1] + '-' + toArray[0];

                var start = new Date(dateFrom),
                    end = new Date(dateTo),
                    diff = new Date(end - start),
                    days = diff / 1000 / 60 / 60 / 24;

                if (days > 50) {
                    alert('Please select date from, to between 30 days ranges!');
                } else {
                    location.href = "<?php echo site_url('enquiry/export_excel'); ?>" + qryString;
                }
            } else {
                alert('Please select date from, to between 30 days ranges!');
            }
        });
    });
</script>