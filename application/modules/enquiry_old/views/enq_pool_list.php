<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Enquiry pool</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="<?php echo site_url('enquiry/pool'); ?>" method="get">
                        <table>
                            <tr>
                                <td>
                                    <input autocomplete="off" name="enq_pool_entry_date_from" type="text"
                                        class="dtpEnquiry form-control col-md-7 col-xs-12" placeholder="Pool date from"
                                        value="<?php echo isset($_GET['enq_pool_entry_date_from']) ? $_GET['enq_pool_entry_date_from'] : ''; ?>" />
                                </td>
                                <td style="padding-left: 10px;">
                                    <input autocomplete="off" name="enq_pool_entry_date_to" type="text"
                                        class="dtpEnquiry form-control col-md-7 col-xs-12" placeholder="Pool date to"
                                        value="<?php echo isset($_GET['enq_pool_entry_date_to']) ? $_GET['enq_pool_entry_date_to'] : ''; ?>" />
                                </td>

                                <td>
                                    <input autocomplete="off" name="search" type="text"
                                        class="form-control col-md-7 col-xs-12" placeholder="Search"
                                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                                </td>
                                <td>
                                    <select style="float: left;width: auto;" class="select2_group form-control"
                                        name="enq_status">
                                        <option value="0">All Status</option>
                                        <option
                                            <?php echo (isset($_GET['enq_status']) && $_GET['enq_status'] == '2') ? 'selected' : ''; ?>
                                            value="2">Request for drop</option>
                                        <option
                                            <?php echo (isset($_GET['enq_status']) && $_GET['enq_status'] == '3') ? 'selected' : ''; ?>
                                            value="3">Droped</option>
                                        <option
                                            <?php echo (isset($_GET['enq_status']) && $_GET['enq_status'] == '4') ? 'selected' : ''; ?>
                                            value="4">Request for lost</option>
                                        <option
                                            <?php echo (isset($_GET['enq_status']) && $_GET['enq_status'] == '5') ? 'selected' : ''; ?>
                                            value="5">Lost</option>
                                    </select>
                                </td>
                                <td style="padding-left: 10px;">
                                    <button type="submit" class="btn btn-round btn-primary">Search</button>
                                </td>

                            </tr>
                        </table>
                    </form>
                </div>
                <div class="x_content">
                    <div style="width: 100%;overflow-x: scroll;">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer ID</th>
                                    <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG' || $this->usr_grp == 'TL') ? '<th>Sales Executive</th>' : ''; ?>
                                    <th>Added By</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Whatsapp</th>
                                    <th>Enquiry Date</th>
                                    <th>Assigned Date</th>
                                    <th>Action</th>
                                    <th>Enq Status</th>
                                    <th>Enq Mod</th>
                                    <th>Enq type</th>
                                    <?php echo check_permission('enquiry', 'showregnoonenqlist') ? "<th>Veh Reg no</th><th>Vehicle</th>" : ""; ?>
                                    <th>Cmt date</th>
                                    <th>Cmt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($enquires)) {
                                    foreach ($enquires as $key => $value) {
                                        $stsUpdateUrl = '<a style="margin-left: 10px;" title="Update call status" href="' . site_url('enquiry/specialcomments/' . encryptor($value['enq_id'])) . '"><i class="fa fa-calendar-check-o"></i></a>';
                                        $purchaseVehicleRegNo = '';
                                        $vehicle = '';
                                        if (check_permission('enquiry', 'showregnoonenqlist')) {
                                            $purchaseVehicleRegNo = $this->enquiry->getPurchaseVehicleNumber($value['enq_id']);
                                            $vehicle = $this->enquiry->getVehicleByEnquiryId($value['enq_id']);
                                        }
                                        $poolId = !empty($value['enq_pool_id']) ? $value['enq_pool_id'] : 0;
                                        $follLink = '<a style="margin-left: 10px;" title="Followup" href="' . site_url('followup/viewFollowup/' . encryptor($value['enq_id'])) . '?p=' . $poolId . '"><i class="fa fa-calendar-check-o"></i></a>'; ?>
                                <tr
                                    data-url="<?php echo ($value['enq_current_status'] == 2 || $value['enq_current_status'] == 4) ? site_url('enquiry/viewVehicleStatus/' . encryptor($value['enq_id']) . '/' . $value['enq_current_status']) . '?p=' . $poolId : ''; ?>">
                                    <th class="trVOE"><?php echo generate_vehicle_virtual_id($value['enq_id']); ?></th>
                                    <?php echo (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'MG' || $this->usr_grp == 'TL') ? '<td class="trVOE">' . strtoupper($value['usr_first_name']) . '</td>' : ''; ?>
                                    <td class="trVOE">
                                        <?php echo ($this->uid == $value['enq_se_id']) ? 'Self' : $value['enq_added_by_name']; ?>
                                    </td>
                                    <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']); ?></td>
                                    <td> <a target="blank" <?php echo 'href="tel:' . $value['enq_cus_mobile'] . '"'; ?>>
                                            <?php echo $value['enq_cus_mobile']; ?> </a></td>
                                    <td> <a target="blank"
                                            <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['enq_cus_whatsapp'] . '"'; ?>>
                                            <?php echo $value['enq_cus_whatsapp']; ?> </a></td>
                                    <td class="trVOE"><?php echo date('j M Y', strtotime($value['enq_entry_date'])); ?>
                                    </td>
                                    <td title="Date of enquiry assigned to pool" class="trVOE">
                                        <?php echo !empty($value['enq_pool_entry_date']) ? date('j M Y', strtotime($value['enq_pool_entry_date'])) : ''; ?>
                                    </td>
                                    <td>
                                        <a title="Print track card"
                                            href="<?php echo site_url('enquiry/printTrackCard/' . encryptor($value['enq_id'])); ?>">
                                            <span class="glyphicon glyphicon-print"></span>
                                        </a>
                                        <?php echo $follLink; ?>
                                        <?php //echo $stsUpdateUrl;
                                                ?>
                                        <?php if (check_permission('enquiry', 'reassignenquiry')) { ?>
                                        <a title="Re-assign enquiries" href="javascript:void(0)" data-toggle="modal"
                                            data-target="#enq<?php echo $value['enq_id']; ?>">
                                            <i class="fa fa-repeat" title="Re assign enquires"></i>
                                        </a>
                                        <?php } ?>
                                    </td>
                                    <td class="trVOE"><?php echo $value['sts_title']; ?></td>
                                    <td>
                                        <?php
                                                $cntMods = unserialize(MODE_OF_CONTACT);
                                                echo $cntMods = isset($cntMods[$value['enq_mode_enq']]) ? $cntMods[$value['enq_mode_enq']] : '';
                                                ?>
                                        <!--Enq Mod-->
                                    </td>
                                    <td>
                                        <!--Enq type-->
                                        <?php
                                                $stsMods = unserialize(ENQUIRY_UP_STATUS);
                                                echo $stsMods = isset($stsMods[$value['enq_cus_when_buy']]) ? $stsMods[$value['enq_cus_when_buy']] : '';

                                                if (check_permission('enquiry', 'reassignenquiry')) {
                                                ?>
                                        <div class="modal fade" id="enq<?php echo $value['enq_id']; ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="<?php echo site_url('enquiry/reassignenquiry'); ?>"
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

                                                            <input type="hidden" name="enq_id"
                                                                value="<?php echo $value['enq_id']; ?>" />
                                                            <input type="hidden" name="old_se_id"
                                                                value="<?php echo $value['enq_se_id']; ?>" />

                                                            <table class="table table-striped table-bordered">
                                                                <tr>
                                                                    <td>Sales staff</td>
                                                                    <td><?php echo $value['usr_first_name']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Customer name</td>
                                                                    <td><?php echo $value['enq_cus_name']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Customer number</td>
                                                                    <td><?php echo $value['enq_cus_mobile']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mod of enquiry</td>
                                                                    <td><?php echo $cntMods; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Enquiry type</td>
                                                                    <td><?php echo $stsMods; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Assign to</td>
                                                                    <td>
                                                                        <select name="new_se_id"
                                                                            class="form-control col-md-7 col-xs-12"
                                                                            required>
                                                                            <option value="">Select new staff</option>
                                                                            <?php foreach ($staffs as $skey => $stf) { ?>
                                                                            <option
                                                                                value="<?php echo $stf['usr_id']; ?>">
                                                                                <?php echo $stf['usr_first_name']; ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <textarea name="remark" required
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
                                        <?php } ?>
                                    </td>
                                    <?php echo check_permission('enquiry', 'showregnoonenqlist') ? "<td>" . $purchaseVehicleRegNo . " -- </td>" : ""; ?>
                                    <?php echo check_permission('enquiry', 'showregnoonenqlist') ? '<td>' . $vehicle . "</td>" : ""; ?>
                                    <?php if ($this->uid == 100) { ?>
                                    <td>
                                        <a
                                            href="<?php echo site_url($controller . '/permenentDelete/' . $value['enq_id']); ?>">
                                            <i class="fa fa-remove"></i>
                                        </a>
                                    </td>
                                    <?php } ?>
                                    <td><?php echo $value['enq_pool_lst_cmd']; ?></td>
                                    <td><?php echo !empty($value['enq_pool_updt_date']) ? date('j M Y', strtotime($value['enq_pool_updt_date'])) : ''; ?>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
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
    </div>
</div>