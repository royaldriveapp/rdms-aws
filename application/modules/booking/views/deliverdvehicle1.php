<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Deliverd vehicles</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <?php if (check_permission('booking', 'exportexcelbookings')) { ?>
                            <li style="float: right;">
                                <a href="<?php echo site_url('booking/exportExcelBookings?' . $_SERVER['QUERY_STRING']); ?>">
                                    <img width="20" title="Export to excel" src="images/excel-export.png" />
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="" method="get">
                        <table>
                            <tr>
                                <td>
                                    <input autocomplete="off" name="vbk_delivery_date_from" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" placeholder="Delivery date from" value="<?php echo isset($_GET['vbk_delivery_date_from']) ? $_GET['vbk_delivery_date_from'] : ''; ?>" />
                                </td>
                                <td style="padding-left: 10px;">
                                    <input autocomplete="off" name="vbk_delivery_date_to" type="text" class="dtpEnquiry form-control col-md-7 col-xs-12" placeholder="Delivery date to" value="<?php echo isset($_GET['vbk_delivery_date_to']) ? $_GET['vbk_delivery_date_to'] : ''; ?>" />
                                </td>
                                <?php if (check_permission('reports', 'fltr_enquiries_enq_salesstaff')) { ?>
                                    <td style="padding-left: 10px;">
                                        <select multiple="multiple" style="float: left;width: auto;" class="cmbMultiSelect select2_group form-control cmbSalesExecutives" name="executive[]">
                                            <option value="<?php echo $this->uid; ?>">My self</option>
                                            <?php
                                            foreach ((array) $salesExecutives as $key => $value) {
                                                if (!empty($showroom)) {
                                                    if ($showroom == $value['usr_showroom']) {
                                            ?>
                                                        <option value="<?php echo $value['usr_id']; ?>" <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?>>
                                                            <?php echo $value['usr_first_name']; ?></option>
                                                    <?php
                                                    }
                                                } else { ?>
                                                    <option <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?> value="<?php echo $value['usr_id']; ?>">
                                                        <?php echo $value['usr_first_name'] . ' ' . $value['usr_last_name']; ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td style="padding-left: 10px;">
                                        <select multiple="multiple" style="float: left;width: auto;" class="select2_group form-control cmbMultiSelect" name="dist[]">
                                            <?php foreach ($districts as $sts => $stsName) { ?>
                                                <option <?php echo (in_array($stsName['std_id'], $distSelected)) ? 'selected="selected"' : ''; ?> value="<?php echo $stsName['std_id']; ?>">
                                                    <?php echo $stsName['std_district_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td style="padding-left: 10px;">
                                        <?php $div = isset($_GET['div']) ? $_GET['div'] : 0; ?>
                                        <select style="float: left;width: auto;" class="select2_group form-control" name="div">
                                            <option value="0">Select Division</option>
                                            <option value="1" <?php echo ($div == 1) ? 'selected="selected"' : ''; ?>>Smart
                                            </option>
                                            <option value="2" <?php echo ($div == 2) ? 'selected="selected"' : ''; ?>>Luxury
                                            </option>
                                        </select>
                                    </td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td style="padding-left: 10px;">
                                    <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="x_content">
                    <table class="tblDeliverdVehicle table table-striped table-bordered display nowrap" style="width:100%;white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Registration</th>
                                <th>Vehicle</th>
                                <th>Chassis</th>
                                <th>Customer Name</th>
                                <th>Booked by</th>
                                <th>Phone number (Official)</th>
                                <th>Phone number (Personal)</th>
                                <th>Permanent address</th>
                                <th>RC Transfer address</th>
                                <th>Booked on</th>
                                <th>Expect delivery on</th>
                                <th>Delivery on</th>
                                <!-- <th>Current status</th> -->
                                <th>Insurance status</th>
                                <th>RC Transfer status</th>
                                <th>RFI Status</th>
                                <?php if (check_permission('booking', 'showdocumentpending')) { ?><th>Pending docs</th>
                                <?php } ?>
                                <?php if ($this->uid == 100) : ?>
                                    <th>Push sales</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ((array) $bookedVehicle as $key => $value) {
                                $pendnigDocs = $this->booking->pendingDocs($value['vbk_id']);
                                $pendnigDocs = !empty($pendnigDocs) ? array_column($pendnigDocs, 'adp_proof_title') : array();
                                $url = site_url('booking/bookingDetails/' . encryptor($value['vbk_id']));

                                if (check_permission('booking', 'bookingdetailsforrfi')) {
                                    $url = site_url('booking/bookingDetails_rfi/' . encryptor($value['vbk_id']));
                                } else if (check_permission('booking', 'bookingdetailsfordc')) {
                                    $url = site_url('booking/bookingDetails_dc/' . encryptor($value['vbk_id']));
                                }
                            ?>
                                <tr data-url="<?php echo $url; ?>">
                                    <td class="trVOE"><?php echo $value['vbk_ref_no']; ?></td>
                                    <td><?php echo $value['val_veh_no']; ?>
                                        <a href="<?php echo site_url('evaluation/printevaluation/' . encryptor($value['vbk_evaluation_veh_id'])); ?>">
                                            <i title="View valuation report" class="fa fa-copy"></i>
                                        </a>
                                    </td>
                                    <td class="trVOE">
                                        <?php echo $value['brd_title'] . ', ' . $value['mod_title'] . ', ' . $value['var_variant_name']; ?>
                                    </td>
                                    <td class="trVOE"><?php echo $value['val_chasis_no']; ?></td>
                                    <td class="trVOE"><?php echo strtoupper($value['enq_cus_name']); ?></td>
                                    <td class="trVOE">
                                        <?php echo $value['bkdby_first_name'] . ' ' . $value['btdby_last_name']; ?></td>
                                    <td><a href="tel:<?php echo $value['vbk_off_ph_no']; ?>"><?php echo $value['vbk_off_ph_no']; ?></a>
                                    </td>
                                    <td><a href="tel:<?php echo $value['vbk_per_ph_no']; ?>"><?php echo $value['vbk_per_ph_no']; ?></a>
                                    </td>
                                    <td class="trVOE"><?php echo $value['vbk_per_address']; ?></td>
                                    <td class="trVOE"><?php echo $value['vbk_rd_trans_address']; ?></td>
                                    <td class="trVOE"><?php echo date('j M Y', strtotime($value['vbk_added_on'])); ?></td>
                                    <td class="trVOE">
                                        <?php echo !empty($value['vbk_expect_delivery']) ? date('j M Y', strtotime($value['vbk_expect_delivery'])) : ''; ?>
                                    </td>
                                    <td class="trVOE">
                                        <?php echo !empty($value['vbk_delivery_date']) ? date('j M Y', strtotime($value['vbk_delivery_date'])) : ''; ?>
                                    </td>
                                    <!-- <td title="<?php //echo $value['sts_des']; 
                                                    ?>" class="trVOE"><?php //echo $value['sts_title']; 
                                                                                    ?></td> -->
                                    <td title="<?php echo $value['rfi_in_sts_title']; ?>" class="trVOE">
                                        <?php echo $value['rfi_in_sts_title']; ?></td>
                                    <td title="<?php echo $value['rfi_rc_sts_title']; ?>" class="trVOE">
                                        <?php echo $value['rfi_rc_sts_title']; ?></td>
                                    <td title="<?php echo $value['rfi_sts_title']; ?>" class="trVOE">
                                        <?php echo $value['rfi_sts_title']; ?></td>
                                    <?php if (check_permission('booking', 'showdocumentpending')) { ?>
                                        <td style="<?php echo $trColor; ?>">
                                            <?php if (count($pendnigDocs) > 0) { ?>
                                                <i style="font-weight:bold;font-size: 25px;" class="blink fa fa-copy" data-toggle="modal" data-target="#pendingDocs<?php echo $value['vbk_id']; ?>"></i>

                                                <div style="color:#000;" class="modal fade" id="pendingDocs<?php echo $value['vbk_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 style="float: left;" class="modal-title" id="exampleModalLabel">
                                                                    Pending documents to upload</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" style="color:red;font-size: 15px;">
                                                                <?php
                                                                if (count($pendnigDocs) > 0) {
                                                                    echo '<ul style="list-style: decimal;">';
                                                                    echo '<li>' . implode('</li><li>', $pendnigDocs) . '</li>';
                                                                    echo '</ul>';
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </td>
                                    <?php }
                                    if ($this->uid == 100) { ?>
                                        <td><a href="<?php echo site_url("booking/pushsalespreview/" . $value['vbk_id']); ?>"><?php echo ($value['vbk_app_acc_by'] == 0) ? 'Push' : ''; ?></a>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.tblDeliverdVehicle').DataTable({
            "order": [
                [1, "asc"]
            ],
            "scrollX": true,
            "pageLength": 20
        });
    });
</script>

<style>
    div.dataTables_wrapper {
        width: 1109px;
        margin: 0 auto;
    }

    a {
        color: unset;
    }
</style>