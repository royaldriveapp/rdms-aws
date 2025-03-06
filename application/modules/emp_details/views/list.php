<style>
    .clickable-row {
        cursor: pointer;
    }
</style>

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Employee details</h2>
                    <?php if ($this->uid == 100) { ?>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="dropdown" style="float: right;">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a target="blank" href="<?php echo site_url('emp_details/pendingapp/'); ?>">Pendings</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
                <p>
                    <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                        <i class="fa fa-filter"></i> Filter
                    </a>
                </p>
                <div class="row">
                    <div class="col">
                        <div class="collapsemulti collapse" id="multiCollapseExample1">
                            <div class="card card-body">
                                <form class="x_content frmFilter">
                                    <div style="float: left;width: 100%;">
                                        <select name="desig" class="select2_group filter-form-control cmbType" style="float: left;width: 30%;">
                                            <option value="">Select designation</option>
                                            <?php foreach ($designation as $key => $value) { ?>
                                                <option value="<?php echo $value['desig_id']; ?>">
                                                    <?php echo $value['desig_title']; ?></option>
                                            <?php } ?>
                                        </select>

                                        <select class="filter-form-control cmbBindShowroomByDivision" name="division" id="division" data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom" data-dflt-select="Select Showroom">
                                            <option value="">Select division</option>
                                            <?php foreach ($division as $key => $value) { ?>
                                                <option <?php echo (isset($_GET['division']) && ($_GET['division'] == $value['div_id'])) ? 'selected="selected"' : ''; ?> value="<?php echo $value['div_id']; ?>">
                                                    <?php echo $value['div_name']; ?></option>
                                            <?php } ?>
                                        </select>

                                        <div class="div-filter-form-control">
                                            <select class="filter-form-control cmbBindShowroomByDivision cmbShowroom shorm_stf" name="showroom" id="showroom">
                                                <option value="">Select showroom</option>
                                                <?php foreach ($showroom['associatedShowroom'] as $key => $value) { ?>
                                                    <option <?php echo (isset($_GET['showroom']) && ($_GET['showroom'] == $value['col_id'])) ? 'selected="selected"' : ''; ?> value="<?php echo $value['col_id']; ?>">
                                                        <?php echo $value['col_title']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="div-filter-form-control">
                                            <select data-placeholder="resigned" name="resigned" class="select2_group filter-form-control  ">
                                                <option value=''>-Select status-</option>
                                                <option value='0'>Active</option>
                                                <option value='1'>Resigned</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div style="float: left;margin-top: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary btnFilter"><i class="fa fa-filter"></i> Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_content">
                    <table id="emp-table" class="table table-striped table-bordered display nowrap" style="width:100%;white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>Emp Code</th>
                                <th>Username</th>
                                <th>Designation</th>
                                <th>Reporting to</th>
                                <th>Showroom</th>
                                <th>Email</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Group</th>
                                <th>Download count</th>
                                <th>Auto assign</th>
                                <th>Status</th>
                                <th>Resigned</th>
                                <th>Resigned date</th>
                                <th>Rejoined on</th>
                                <th>Resigned reason</th>
                                <th>Resigned remarks</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$reasons = unserialize(RELIVING_REASON);
?>
<script>
    var reasons = <?php echo json_encode($reasons); ?>;
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
        if ($.fn.DataTable.isDataTable('#emp-table')) {
            $('#emp-table').DataTable().destroy();
        }

        var darTable = $('#emp-table').DataTable({
            "order": [],
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            "serverMethod": "post",
            "ajax": site_url + "emp_details/list_ajax?" + frmData,
            "columns": [{
                    "data": "usr_emp_code"
                },
                {
                    "render": function(data, type, full, meta) {
                        var username = full.usr_username;
                        var appDownloadLink = full.usr_appdownloadlink;
                        var content = username;

                        if (appDownloadLink !== '') {
                            content += '<i title="Copy to App referral URL" data-url="' + appDownloadLink +
                                '" class="fa fa-copy cpytoclip"></i>';
                        }

                        return content;
                    }
                },
                {
                    "data": "desig_title"
                },
                {
                    "data": "teamLead"
                },
                {
                    "data": "shr_location"
                },
                {
                    "data": "usr_email"
                },
                {
                    "data": "usr_first_name"
                },
                {
                    "data": "usr_last_name"
                },
                {
                    "data": "group_name"
                },
                {
                    "data": "download_count"
                },
                {
                    "render": function(data, type, full, meta) {
                        var url = "<?php echo site_url($controller . '/canautoassign'); ?>/" +
                            "<?php echo encryptor('" + full.usr_id + "'); ?>";
                        var checked = full.usr_can_auto_assign == 1 ? 'checked' : '';
                        var chkbx =
                            '<label class="switch"><input type="checkbox" value="1" class="chkOnchange" ' +
                            checked + ' data-url="' + url + '"><span class="slider round"></span></label>';
                        return chkbx;
                    }
                },
                {
                    "render": function(data, type, full, meta) {
                        var url = "<?php echo site_url($controller . '/changeuserstatus'); ?>/" +
                            "<?php echo encryptor('" + full.usr_id + "'); ?>";
                        var checked = full.usr_active == 1 ? 'checked' : '';
                        var chkbx =
                            '<label class="switch"><input type="checkbox" value="1" class="chkOnchange" ' +
                            checked + ' data-url="' + url + '"><span class="slider round"></span></label>';
                        return chkbx;
                    }
                },
                {
                    "render": function(data, type, full, meta) {
                        var resigned = full.usr_resigned == 1 ? 'Yes' : 'No';
                        return resigned;
                    }
                },
                {
                    "sortable": false,
                    "render": function(data, type, full, meta) {
                        var usr_resigned_date = (full.usr_resigned_date !== null && full
                            .usr_resigned_date !== '') ? new Date(full.usr_resigned_date) : null;
                        if (usr_resigned_date) {
                            return usr_resigned_date.toLocaleString('en-US', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            });
                        }
                        return '';
                    }
                },
                {
                    "sortable": false,
                    "render": function(data, type, full, meta) {
                        var usr_rejoined_on = (full.usr_rejoined_on !== null && full.usr_rejoined_on !==
                            '') ? new Date(full.usr_rejoined_on) : null;
                        if (usr_rejoined_on) {
                            return usr_rejoined_on.toLocaleString('en-US', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            });
                        }
                        return '';
                    }
                },
                {
                    "render": function(data, type, full, meta) {
                        if (full.usr_resigned_reason != 0) {
                            if (reasons.hasOwnProperty(full.usr_resigned_reason)) {
                                return reasons[full.usr_resigned_reason];
                            } else {
                                return "Unknown reason";
                            }
                        }
                        return '';
                    }
                },
                {
                    "data": "usr_resigned_remarks"
                },
                {
                    "render": function(data, type, full, meta) {
                        var deleteUrl = '<?php echo site_url("emp_details/delete/"); ?>/' + full.usr_id;
                        var content =
                            '<a class="pencile deleteListItemDataTbl" href="javascript:void(0);" data-url="' +
                            deleteUrl + '"><i class="fa fa-remove"></i></a>';
                        return content;
                    }
                },
            ],
            "buttons": [
                'copy',
                'excel',
                'pdf',
                'print'
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData['usr_resigned'] == 1) {
                    $(nRow).find('td').css({
                        'background-color': 'red',
                        'color': '#fff'
                    });
                }

                $(nRow).addClass('clickable-row');
                return nRow;
            }
        });

        $(document).on('click', '.btnExport', function(e) {
            $.ajax({
                type: 'post',
                url: site_url + "evaluation/xlsx_valuation?" + $('.frmFilter').serialize(),
                dataType: 'json',
                success: function(resp) {
                    window.location.href = resp;
                }
            });
        });

        // Add click event binding to rows
        darTable.on('click', 'tbody tr', function(e) {
            var target = e.target;
            // Exclude specific elements from the click event
            if (
                $(target).hasClass('chkOnchange') ||
                $(target).hasClass('deleteListItemDataTbl') ||
                $(target).hasClass('cpytoclip') ||
                $(target).hasClass('deleteListItemDataTbl') ||
                $(target).hasClass('fa-remove')
            ) {
                return;
            }

            var rowData = darTable.row(this).data();
            var usr_id = rowData['usr_id'];
            var url = "<?php echo site_url('emp_details/view/'); ?>/" +
                "<?php echo encryptor('" + usr_id + "'); ?>";
            if (url) {
                window.location.href = url;
            }
        });
    }
</script>

<style>
    .filter-form-control {
        float: left;
        margin-left: 5px;
        padding: 5px 5px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
        box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }

    .div-filter-form-control {
        float: left;
        margin-left: 5px;
    }

    .prnt-btn,
    .addStock-btn {
        /* color: #fefefe!important; */
    }

    .ficon {
        font-size: 17px !important;
        padding-top: 12px !important;
        padding-left: 8px !important;
    }

    a.tip {
        /* border-bottom: 1px dashed; */
        text-decoration: none;
    }

    a.tip:hover {
        cursor: pointer;
        position: relative;
    }

    a.tip span {
        display: none;
        color: #fff;
    }

    a.tip:hover span {
        color: while;
        border-radius: 9px;
        border: #c0c0c0 1px dotted;
        padding: 5px;
        display: block;
        z-index: 100;
        background-color: black;
        left: 0px;
        margin: 10px;
        width: auto;
        position: absolute;
        top: 10px;
        text-decoration: none;
    }
</style>