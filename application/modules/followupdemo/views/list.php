<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>All Followup</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="<?php echo site_url('followup/index'); ?>" method="get">
                        <table>
                            <tr>
                                <td>
                                    <input autocomplete="off" name="foll_next_foll_date" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" placeholder="Next followup date" value="<?php echo isset($_GET['foll_next_foll_date']) ? $_GET['foll_next_foll_date'] : ''; ?>" />
                                </td>
                                <td>
                                    <input autocomplete="off" name="search" type="text" class="form-control col-md-7 col-xs-12" placeholder="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                                </td>
                                <td style="padding: 0px 10px 0px 10px;">
                                    <input <?php echo (isset($_GET['enq_is_pool']) && $_GET['enq_is_pool'] == 1) ? 'checked' : ''; ?> type="checkbox" name="enq_is_pool" value="1" /> Followup from enquiry pool
                                    <input <?php echo (isset($_GET['enq_id']) && $_GET['enq_id'] == 1) ? 'checked' : ''; ?> type="checkbox" name="enq_id" value="1" /> Myself
                                </td>
                                <td>
                                    <?php if (isset($staffs) && !empty($staffs)) { ?>
                                        <select name="enq_se_id" id="travel_with" class="sumoSearchList select2_groupj form-control form-control col-md-7 col-xs-12">
                                            <option value="0">Select Staff</option>
                                            <?php foreach ($staffs as $key => $stf) { ?>
                                                <option <?php echo ($stf['col_id'] == $_GET['enq_se_id']) ? 'selected' : ''; ?> value="<?php echo $stf['col_id'] ?>">
                                                    <?php echo $stf['col_title']; ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </td>
                                <td style="padding-left: 10px;">
                                    <button type="submit" class="btn btn-round btn-primary">Search</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="x_content">
                    <table class="datatableFollowup1 table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <?php echo $this->usr_grp != 'SE' ? '<th>Sales Executive</th>' : ''; ?>
                                <th>Type</th>
                                <th>Mobile</th>
                                <th>Whatsapp</th>
                                <th>Added by</th>
                                <th>Next Follow up Date</th>
                                <th>Purchase vehicle</th>
                                <th>Sales vehicle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ((array) $enquires as $key => $value) {
                                $now = date('Y-m-d');
                                $date1 = new DateTime($follupDate = date('Y-m-d', strtotime($value['enq_next_foll_date'])));
                                $date2 = new DateTime($now);
                                $color = '';

                                if ($date2->diff($date1)->format("%r%a") <= 2) {
                                    $color = 'background:red;color:#fff !important;';
                                }
                                $segment = ($value['enq_cus_status'] == 1) ? 's' : 'b';
                                $type = unserialize(VEHICLE_DETAILS_STATUS);

                                $indWPNumber = $value['enq_cus_mobile'];
                                if (substr($value['enq_cus_mobile'], 0, 2) != 91) {
                                    $indWPNumber = '91' . $value['enq_cus_mobile'];
                                }


                            ?>
                                <tr title="<?php echo empty($value['foll_id']) ? 'Pending to set followup date' : ''; ?>" style="<?php echo $color; ?>" data-url="<?php echo site_url('followup/viewFollowup/' . encryptor($value['enq_id'])); ?>">
                                    <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']); ?></td>
                                    <?php echo $this->usr_grp != 'SE' ? '<td class="trVOE">' . $value['usr_first_name'] . '</td>' : ''; ?>
                                    <td class="trVOE"><?php echo $type[$value['enq_cus_status']]; ?></td>
                                    <td><a style="<?php echo $color; ?>" href="https://api.whatsapp.com/send?phone=<?php echo $indWPNumber; ?>"><?php echo $value['enq_cus_mobile']; ?></a>
                                    </td>
                                    <td class="trVOE"><a style="<?php echo $color; ?>" href="https://api.whatsapp.com/send?phone=<?php echo $value['enq_cus_whatsapp']; ?>"><?php echo $value['enq_cus_whatsapp']; ?></a>
                                    </td>
                                    <td class="trVOE">
                                        <?php echo ($value['enq_added_by_id'] == $this->uid) ? 'Self' : $value['enq_added_by_name']; ?>
                                    </td>
                                    <td class="trVOE"><?php echo date('j M Y', strtotime($value['enq_next_foll_date'])); ?></td>
                                    <td class="trVOE"><?php echo $value['enqm_pur_veh']; ?></td>
                                    <td class="trVOE"><?php echo $value['enqm_sls_veh']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">
                        <?php echo 'Total ' . $totalRow; ?> products</div>
                    <div style="float: right;">
                        <?php echo $links; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>