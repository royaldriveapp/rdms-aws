<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>New Staff Request</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right;">
                            <a href="<?php echo site_url('emp_details/excelload'); ?>">
                                <img width="20" title="Excel import" src="images/excel-export.png" />
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <p>
                        <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                            <i class="fa fa-filter"></i> Filter
                        </a>
                    </p>
                    <table id="staff-table" class="display nowrap table table-striped table-bordered" style="width:100%;white-space: nowrap;">

                        <thead>

                            <tr>
                                <th>Id</th>
                                <th>Edit</th>
                                <th>App dwn link</th>
                                <th>App dwn code</th>
                                <th>Emp code</th>
                                <th>Staff</th>
                                <th>Dial</th>
                                <th>Designation</th>
                                <th>Showroom</th>
                                <th>Company Email</th>
                                <th>Company Phone</th>
                                <th>Personal Email</th>
                                <th>Personal Phone</th>
                                <th>Date Of Join</th>
                                <th>Date Of Birth</th>
                                <th>Permanent address</th>
                                <th>Communication address</th>
                                <th>Emergency number</th>
                                <th>Marital Status</th>
                                <th>Spouse Name</th>
                                <th>Marriage anniversary Date</th>
                                <th>Father Name</th>
                                <th>Educational Qualification</th>
                                <th>Technical Qualification</th>
                                <th>Previous Exp</th>
                                <th>Industry Exp</th>
                                <th>Bank</th>
                                <th>A/C no</th>
                                <th>IFSC Code</th>
                                <th>Share RDMS</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        var canDelete = "<?php echo is_roo_user() ? 1 : 0; ?>";
        console.log($('.frmFilter').serialize());
        fetchData(canDelete, $('.frmFilter').serialize());
        $(document).on('submit', '.frmFilter', function(e) {
            e.preventDefault();
            fetchData(canDelete, $(this).serialize());
        });
    });

    function fetchData(canDelete, frmData) {
        var showID = <?php echo ($this->uid == 100) ? 1 : 0; ?>;
        var shwQuickupdate = <?php echo check_permission('emp_details', 'quickupdate') ? 1 : 0; ?>;
        var shwpersemail = <?php echo check_permission('emp_details', 'shwpersemail') ? 1 : 0; ?>;
        var shwpersphone = <?php echo check_permission('emp_details', 'shwpersphone') ? 1 : 0; ?>;
        var shwdoj = <?php echo check_permission('emp_details', 'shwdoj') ? 1 : 0; ?>;
        var shwdob = <?php echo check_permission('emp_details', 'shwdob') ? 1 : 0; ?>;
        var shwaddress = <?php echo check_permission('emp_details', 'shwaddress') ? 1 : 0; ?>;
        var shwcommunicationaddress = <?php echo check_permission('emp_details', 'shwaddress') ? 1 : 0; ?>;
        var shwemrgno = <?php echo check_permission('emp_details', 'shwemrgno') ? 1 : 0; ?>;
        var shwmrgsts = <?php echo check_permission('emp_details', 'shwmrgsts') ? 1 : 0; ?>;
        var shwspousename = <?php echo check_permission('emp_details', 'shwmrgsts') ? 1 : 0; ?>;
        var shwmarriageanniversary = <?php echo check_permission('emp_details', 'shwmrgsts') ? 1 : 0; ?>;
        var shwfathername = <?php echo check_permission('emp_details', 'shwfathername') ? 1 : 0; ?>;
        var shweduqualification = <?php echo check_permission('emp_details', 'shweduquali') ? 1 : 0; ?>;
        var shwtechnicalqualification = <?php echo check_permission('emp_details', 'shweduquali') ? 1 : 0; ?>;
        var shwpreviousexp = <?php echo check_permission('emp_details', 'shwexperience') ? 1 : 0; ?>;
        var shwindustryexp = <?php echo check_permission('emp_details', 'shwexperience') ? 1 : 0; ?>;
        var shwbankdetails = <?php echo check_permission('emp_details', 'shwbankdetails') ? 1 : 0; ?>;
        var shwacno = <?php echo check_permission('emp_details', 'shwbankdetails') ? 1 : 0; ?>;
        var shwifsccode = <?php echo check_permission('emp_details', 'shwbankdetails') ? 1 : 0; ?>;

        var canDelete = "<?php echo is_roo_user() ? 1 : 0; ?>";
        if ($.fn.DataTable.isDataTable('#staff-table')) {
            $('#staff-table').DataTable().destroy();
        }
        var darTable = $('#staff-table').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": site_url + "emp_details/pendingappAjax?" + frmData,
                "type": "POST"
            },
            "columns": [{
                    "data": "usr_id",
                    "visible": (showID === 1)
                },
                {
                    "render": function(data, type, full, meta) {
                        var editUrl = "<?php echo site_url($controller . '/view'); ?>/" +
                            "<?php echo encryptor('" + full.usr_id + "'); ?>";
                        return '<a href=" ' + editUrl + '"><i class="fa fa-pencil"></i></a>';
                    },
                    "visible": (shwQuickupdate === 1)
                },
                {
                    "data": "usr_appdownloadlink",
                    "visible": (showID === 1)
                },
                {
                    "data": null,
                    "sortable": false,
                    "render": function(data, type, full, meta) {
                        return (showID === 1) ? 'https://www.royaldrive.in/appdwn/dwn/' + full.usr_id : '';
                    }
                },
                {
                    "data": "usr_emp_code"
                },
                {
                    "data": "usr_username"
                },
                {
                    "data": "usr_caller_id"
                },
                {
                    "data": "desig_title"
                },
                {
                    "data": "shr_location"
                },
                {
                    "data": "usr_company_email"
                },
                {
                    "data": null,
                    "sortable": true,
                    "render": function(data, type, full, meta) {
                        return '<a href="https://api.whatsapp.com/send?phone=' + full.usr_phone + '">' +
                            full.usr_phone + '</a>';
                    }
                },
                {
                    "data": null,
                    "visible": (shwpersemail === 1),
                    "render": function(data, type, full, meta) {
                        return '<a href="mailto:' + full.usr_persnl_email + '">' + full.usr_persnl_email +
                            '</a>';
                    }
                },
                {
                    "data": "usr_mobile_personal",
                    "visible": (shwpersphone === 1)
                },
                {
                    "data": "usr_doj",
                    "visible": (shwdoj === 1),
                    "render": function(data, type, row) {
                        return data ? new Date(data).toLocaleDateString() : '';
                    }
                },
                {
                    "data": "usr_dob",
                    "visible": (shwdob === 1),
                    "render": function(data, type, row) {
                        return data ? new Date(data).toLocaleDateString() : '';
                    }
                },
                {
                    "data": "usr_address",
                    "visible": (shwaddress === 1)
                },
                {
                    "data": "usr_address1",
                    "visible": (shwcommunicationaddress === 1)
                },
                {
                    "data": "usr_emergency_no",
                    "visible": (shwemrgno === 1)
                },
                {
                    "data": "usr_marital_status",
                    "visible": (shwmrgsts === 1),
                    "render": function(data, type, row) {
                        return data === 1 ? 'Married' : 'Single';
                    }
                },
                {
                    "data": "usr_spouse_name",
                    "visible": (shwspousename === 1)
                },
                {
                    "data": "usr_marriage_date",
                    "visible": (shwmarriageanniversary === 1),
                    "render": function(data, type, row) {
                        return data ? new Date(data).toLocaleDateString() : '';
                    }
                },
                {
                    "data": "usr_father_name",
                    "visible": (shwfathername === 1)
                },
                {
                    "data": "usr_edu_quali",
                    "visible": (shweduqualification === 1)
                },
                {
                    "data": "usr_tech_quali",
                    "visible": (shwtechnicalqualification === 1)
                },
                {
                    "data": "usr_previous_exp",
                    "visible": (shwpreviousexp === 1)
                },
                {
                    "data": "usr_industry_exp",
                    "visible": (shwindustryexp === 1)
                },
                {
                    "data": "usr_bank",
                    "visible": (shwbankdetails === 1)
                },
                {
                    "data": "usr_bank_acc_no",
                    "visible": (shwacno === 1)
                },
                {
                    "data": "usr_bank_ifsc",
                    "visible": (shwifsccode === 1)
                },
                {
                    "data": null,
                    "visible": (showID === 1),
                    "render": function(data, type, full, meta) {
                        var message =
                            'Your RDMS details here, please click on URL, then logon by Username and Password. %0a' +
                            'Login URL : https://www.rdms.royaldrive.in %0a' +
                            'User Name : nirmalendhucok@royaldrive.in %0a' +
                            'Password  : nirmalendhucok9090 %0a';
                        return '<a title="Share on WhatsApp" style="color: green;" target="_blank" href="https://api.whatsapp.com/send/?text=' +
                            message + '">' +
                            '<i style="font-size: 23px;" class="fa fa-whatsapp"></i></a>';
                    }
                },
            ],
            "scrollX": true,
            "pageLength": 20,
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
    }
</script>
<style>
    .filter-form-control {
        float: left;
        /*display: block;*/
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
        text-decoration: none
    }

    a.tip:hover {
        cursor: pointer;
        position: relative
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
        text-decoration: none
    }
</style>