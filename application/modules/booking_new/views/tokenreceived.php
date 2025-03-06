<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Sales token received</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <?php if (check_permission('booking', 'exportbookedvehicles')) : ?>
                        <li style="float: right;">
                            <a
                                href="<?php echo site_url('booking/exportbookedvehicles?' . $_SERVER['QUERY_STRING']); ?>">
                                <img width="20" title="Export to excel" src="images/excel-export.png" />
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <div style="float: right;">
                        <i class="fa fa-circle" style="color: green;"> <span style="color:#000">Verified</span></i>
                        <i class="fa fa-circle" style="color: #FFFF00;"> <span style="color:#000">Delivered</span></i>
                        <!-- <i class="fa fa-circle" style="color: #f61da0;"> <span style="color:#000">Cancelled</span></i> -->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="frmFilter" method="post">
                        <table>
                            <tr>
                                <td>
                                    <input autocomplete="off" name="vbk_added_on_from" type="text"
                                        class="dtpEnquiry form-control col-md-7 col-xs-12"
                                        placeholder="Booking date from"
                                        value="<?php echo isset($_GET['vbk_added_on_from']) ? $_GET['vbk_added_on_from'] : ''; ?>" />
                                </td>
                                <td style="padding-left: 10px;">
                                    <input autocomplete="off" name="vbk_added_on_to" type="text"
                                        class="dtpEnquiry form-control col-md-7 col-xs-12" placeholder="Booking date to"
                                        value="<?php echo isset($_GET['vbk_added_on_to']) ? $_GET['vbk_added_on_to'] : ''; ?>" />
                                </td>
                                <?php if (check_permission('reports', 'fltr_enquiries_enq_salesstaff')) { ?>
                                <td style="padding-left: 10px;">
                                    <select multiple="multiple" style="float: left;width: auto;"
                                        class="cmbMultiSelect select2_group form-control cmbSalesExecutives"
                                        name="executive[]">
                                        <option value="<?php echo $this->uid; ?>">My self</option>
                                        <?php foreach ((array) $salesExecutives as $key => $value) { ?>
                                        <option
                                            <?php echo (@in_array($value['usr_id'], $executive)) ? 'selected="selected"' : ''; ?>
                                            value="<?php echo $value['usr_id']; ?>">
                                            <?php echo $value['usr_first_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <?php }
                                $sts = isset($_GET['status']) ? $_GET['status'] : 0;
                                ?>
                                <td>
                                    <select multiple="multiple" style="float: left;width: auto;"
                                        class="cmbMultiSelect select2_group form-control" name="status[]">
                                        <option value="<?php echo confm_book; ?>"
                                            <?php echo (@in_array(confm_book, $sts)) ? 'selected="selected"' : ''; ?>>
                                            Booking confirmed</option>

                                        <option value="<?php echo vehicle_booked; ?>"
                                            <?php echo (@in_array(vehicle_booked, $sts)) ? 'selected="selected"' : ''; ?>>
                                            Vehicle booked</option>

                                        <option value="<?php echo book_delvry; ?>"
                                            <?php echo (@in_array(book_delvry, $sts)) ? 'selected="selected"' : ''; ?>>
                                            Vehicle delivered</option>

                                        <option value="<?php echo 29; ?>"
                                            <?php echo (@in_array(29, $sts)) ? 'selected="selected"' : ''; ?>>Booking
                                            cancel</option>
                                    </select>
                                </td>
                                <?php if (check_permission('booking', 'showall')) { ?>
                                <td>
                                    <select style="float: left;width: auto;"
                                        class="cmbMultiSelect select2_group form-control" name="showroom">
                                        <option value="0">All showroom</option>
                                        <?php foreach ((array) $showroom as $key => $value) { ?>
                                        <option value="<?php echo $value['shr_id']; ?>">
                                            <?php echo $value['shr_location'] . ' (' . $value['div_name'] . ')'; ?>
                                        </option>
                                        <?php } ?>
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
                    <table id="tblBooking" class="table table-striped table-bordered display nowrap"
                        style="width:100%;white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Booked on</th>
                                <th>Registration</th>
                                <th>Vehicle</th>
                                <th>Enq No</th>
                                <th>Customer Name</th>
                                <th>Customer Source</th>
                                <th>Booked by</th>
                                <th>Sales Staff</th>
                                <th>Phone number (Official)</th>
                                <th>Phone number (Personal)</th>
                                <th>Permanent address</th>
                                <th>RC Transfer address</th>
                                <th>Expect delivery on</th>
                                <th>Insurance status</th>
                                <th>RC Transfer status</th>
                                <th>Current status</th>
                                <?php if ($this->uid == 100) : ?>
                                <th>Delete</th>
                                <?php endif; ?>
                                <?php if (check_permission('booking', 'editbooking')) : ?>
                                <th>Edit</th>
                                <?php endif; ?>
                                <?php if ($this->uid == 100) : ?>
                                <th>Push sales</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Existing rows data will be dynamically loaded by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$mod = unserialize(MODE_OF_CONTACT);
?>
<script>
var mod = <?php echo json_encode($mod); ?>;
var vehicle_booked = "<?php echo vehicle_booked; ?>";
var reject_book = "<?php echo reject_book; ?>";
var confm_book = "<?php echo confm_book; ?>";
var dc_ready_to_del = "<?php echo dc_ready_to_del; ?>";
var book_delvry = "<?php echo book_delvry; ?>";
$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    var canDelete = "<?php echo is_roo_user() ? 1 : 0; ?>";
    empList(canDelete, $('.frmFilter').serialize());
    $(document).on('submit', '.frmFilter', function(e) {
        e.preventDefault();
        empList(canDelete, $(this).serialize());
    });


});

function empList(canDelete, frmData) {
    if ($.fn.DataTable.isDataTable('#tblBooking')) {
        $('#tblBooking').DataTable().destroy();
    }

    var darTable = $('#tblBooking').DataTable({
        "order": [],
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "serverMethod": "post",
        "ajax": site_url + "booking/tokenreceivedAjax?" + frmData,
        "columns": [{
                "data": "vbk_ref_no"
            }, // Booking ID
            {
                "data": "vbk_added_on",
                "sortable": true,
                "render": function(data, type, full, meta) {
                    var vbk_added_on = (full.vbk_added_on !== null && full.vbk_added_on !== '') ?
                        new Date(full.vbk_added_on) : null;
                    if (vbk_added_on) {
                        return vbk_added_on.toLocaleString('en-US', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric'
                        });
                    }
                    return '';
                }
            }, // Booked on https://rdms.royaldrive.in/index.php/enquiry/printTrackCard/61417
            {
                "data": "val_veh_no"
            }, // Registration
            {
                "data": "enq_number",
                "render": function(data, type, full, meta) {
                    return full.brd_title + ', ' + full.mod_title + ', ' + full.var_variant_name;
                }
                //"data": "enq_number"
            }, // Enq No
            {
                "data": "enq_number",
                "render": function(data, type, full, meta) {
                    return '<a href="https://rdms.royaldrive.in/index.php/enquiry/printTrackCard/' +
                        full.enq_id + '">' + full.enq_number + '</a>';
                }
                //"data": "enq_number"
            }, // Enq No
            {
                "data": "enq_cus_name",
                "render": function(data, type, full, meta) {
                    return data;
                }
            }, // Customer Name

            {
                "render": function(data, type, full, meta) {
                    if (full.enq_mode_enq != 0) {
                        if (mod.hasOwnProperty(full.enq_mode_enq)) {
                            return mod[full.enq_mode_enq];
                        } else {
                            return "Unknown reason";
                        }
                    }
                    return '';
                }
            }, // Customer Source
            {
                "data": "bkdby_first_name"
            }, // Booked by
            {
                "data": "salesstaff_first_name"
            }, // Sales Staff
            {
                "data": "vbk_off_ph_no"
            }, // Phone number (Official)
            {
                "data": "vbk_per_ph_no"
            }, // Phone number (Personal)
            {
                "data": "vbk_per_address"
            }, // Permanent address
            {
                "data": "vbk_rd_trans_address"
            }, // RC Transfer address
            {
                "data": "vbk_expect_delivery",
                "sortable": true,
                "render": function(data, type, full, meta) {
                    var vbk_expect_delivery = (full.vbk_expect_delivery !== null && full
                        .vbk_expect_delivery !== '') ? new Date(full.vbk_expect_delivery) : null;
                    if (vbk_expect_delivery) {
                        return vbk_expect_delivery.toLocaleString('en-US', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                    return '';
                }
            }, // Expect delivery on
            {
                "data": "rfi_in_sts_title"
            }, // Insurance status
            {
                "data": "rfi_rc_sts_title"
            }, // RC Transfer status
            {
                "data": "sts_title",
                "render": function(data, type, full, meta) {
                    return '<span title="' + full.sts_des + '">' + data + '</span>';
                }
            }, // Current status
            <?php if ($this->uid == 100) : ?> {
                "render": function(data, type, full, meta) {
                    var deleteUrl = '<?php echo site_url("booking/permenentdeletebooking/"); ?>/' + full
                        .vbk_id;
                    var content = '<a class="btnRemoveTableRow" href="javascript:void(0);" data-url="' +
                        deleteUrl + '"><i title="View document" class="fa fa-trash"></i></a>';
                    return content;
                }
            },
            <?php endif;
                if (check_permission('booking', 'editbooking')) : ?> {
                "render": function(data, type, full, meta) {
                    var editUrl = '<?php echo site_url("booking/editBooking/"); ?>/' + full.vbk_id;
                    var content = '<a href="' + editUrl +
                        '"><i title="Update booking" class="fa fa-pencil"></i></a>';
                    return content;
                }
            },
            <?php endif;
                if ($this->uid == 100) : ?> {
                "render": function(data, type, full, meta) {
                    var deleteUrl = '<?php echo site_url("booking/pushsalespreview/"); ?>/' + full
                        .vbk_id;
                    return '<a href="' + deleteUrl + '"><i class="fa fa-eye"></i></a>';
                }
            }
            <?php endif; ?>
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (aData['usr_resigned'] == 1) {
                $(nRow).find('td').css({
                    'background-color': 'red',
                    'color': '#fff'
                });
            }

            var status = aData['vbk_status'];
            var trColor = '';

            if (status === vehicle_booked) {
                // No specific background color for 'vehicle_booked'
                trColor = '';
            } else if (status === reject_book) {
                trColor = 'background-color: red; color: #fff;';
            } else if (status === confm_book || status === dc_ready_to_del) {
                trColor = 'background-color: green; color: #fff;';
            } else if (status === book_delvry) {
                trColor = 'background-color: #FFFF00; color: #000;';
            } else if (status === 29) {
                trColor = 'background-color: #f61da0; color: #000;';
            }

            // Apply the style to the table row
            $(nRow).attr("style", trColor);

            $(nRow).addClass('clickable-row');
            return nRow;
        }

    });

    // Add click event handler to the row
    $('#tblBooking tbody').on('click', 'tr', function(e) {
        // Exclude specific columns from the click event
        if ($(e.target).hasClass('btnRemoveTableRow') || $(e.target).hasClass('fa')) {
            return;
        }
        var rowData = darTable.row(this).data();
        var var_id = rowData['vbk_id'];
        var url = "<?php echo site_url('booking/bookingDetails/'); ?>/" +
            "<?php echo encryptor('" + var_id + "'); ?>";

        if (url) {
            window.location.href = url;
        }
    });
}
</script>