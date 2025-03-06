<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Staff master</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right;">
                            <a href="<?php echo site_url('emp_details/excelload'); ?>">
                                <img width="20" title="Excel import" src="images/excel-export.png" />
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <!-- -->
                <?php if (check_permission('emp_details', 'showborthdayaniversary')) {
                    if (!empty($upcomClib['birthday']) || !empty($upcomClib['joinanniver'])) { ?>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="x_panel tile">
                                    <div class="x_title">
                                        <h2>This month Birthday</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content" style="height:240px; overflow-y: scroll;overflow-x: hidden;">
                                        <?php if (!empty($upcomClib['birthday'])) { ?>
                                            <table class="display nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Date of birth</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($upcomClib['birthday'] as $key => $value) { ?>
                                                        <tr <?php echo (date('j M') == date('j M', strtotime($value['usr_dob']))) ? 'style="color:green;background:#f0eded;"' : ''; ?>>
                                                            <td><?php echo $value['usr_username'] . ' (' . $value['shr_location'] . ')'; ?>
                                                            </td>
                                                            <td><?php echo !empty($value['usr_dob']) ? date('j M Y', strtotime($value['usr_dob'])) : ''; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="x_panel tile fixed_height_320 overflow_hidden">
                                    <div class="x_title">
                                        <h2>This month joining anniversary</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content" style="height:240px; overflow-y: scroll;overflow-x: hidden;">
                                        <?php if (!empty($upcomClib['joinanniver'])) {  ?>
                                            <table class="display nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Date of joining</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($upcomClib['joinanniver'] as $key => $value) { ?>
                                                        <tr <?php echo (date('j M') == date('j M', strtotime($value['usr_doj']))) ? 'style="color:green;background:#f0eded"' : ''; ?>>
                                                            <td><?php echo $value['usr_username'] . ' (' . $value['shr_location'] . ')'; ?>
                                                            </td>
                                                            <td><?php echo !empty($value['usr_doj']) ? date('j M Y', strtotime($value['usr_doj'])) : ''; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="x_panel tile fixed_height_320">
                                    <div class="x_title">
                                        <h2>This month marriage anniversary</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content" style="height:240px; overflow-y: scroll;overflow-x: hidden;">
                                        <?php if (!empty($upcomClib['marranniver'])) {  ?>
                                            <table class="display nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Date of marriage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($upcomClib['marranniver'] as $key => $value) { ?>
                                                        <tr <?php echo (date('j M') == date('j M', strtotime($value['usr_marriage_date']))) ? 'style="color:green;background:#f0eded"' : ''; ?>>
                                                            <td><?php echo $value['usr_username'] . ' (' . $value['shr_location'] . ')'; ?>
                                                            </td>
                                                            <td><?php echo !empty($value['usr_marriage_date']) ? date('j M Y', strtotime($value['usr_marriage_date'])) : ''; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
                <!-- -->

                <?php if (check_permission('emp_details', 'createstafftemp')) { ?>
                    <div class="x_content">
                        <form id="demo-form2" method="post" action="<?php echo site_url($controller . '/newstaffrequest'); ?>" data-parsley-validate class="form-horizontal form-label-left frmEmployee" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputEmail4">Emp code<span class="required">*</span></label>
                                    <input type="text" id="first-name" required class="form-control" name="usr_emp_code">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEmail4">First Name <span class="required">*</span></label>
                                    <input type="text" id="first-name" required="required" class="form-control" name="usr_first_name">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Last Name </label>
                                    <input type="text" id="last-name" name="usr_last_name" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputEmail4">Branch <span class="required">*</span></label>
                                    <select class="cmbShowRoom select2_group form-control" name="usr_showroom" data-url="<?php echo site_url('emp_details/getTeamLeads'); ?>">
                                        <?php foreach ($showroom as $key => $value) { ?>
                                            <option value="<?php echo $value['shr_id']; ?>">
                                                <?php echo $value['shr_location']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">RD Mobile</label>
                                    <input type="text" id="last-name" name="usr_phone" data-past=".usr_whatsapp" class="pastContent numOnly form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEmail4">RD WhatsApp</label>
                                    <input type="text" id="last-name" name="usr_whatsapp" class="numOnly form-control usr_whatsapp">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEmail4">Personal Mobile <span class="required">*</span></label>
                                    <input type="text" id="last-name" name="usr_mobile_personal" class="numOnly form-control usr_mobile_personal">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Personal email </label>
                                    <input type="text" id="last-name" name="usr_persnl_email" class="pastContent form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Permanent Address <span class="required">*</span></label>
                                    <input type="text" id="usr_address" name="usr_address" required class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Country <span class="required">*</span></label>
                                    <input autocomplete="off" value="India" type="text" name="usr_country" required class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputEmail4">State <span class="required">*</span></label>
                                    <input autocomplete="off" type="text" value="Kerala" name="usr_state" required="required" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">City <span class="required">*</span></label>
                                    <input type="text" id="" name="usr_city" required="required" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">District <span class="required">*</span></label>
                                    <select required class="select2_group form-control" name="usr_district" id="vreg_district">
                                        <option value="">Select District</option>
                                        <?php
                                        foreach ($districts as $key => $value) {
                                        ?>
                                            <option value="<?php echo $value['std_id']; ?>">
                                                <?php echo $value['std_district_name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Designation <span class="required">*</span></label>
                                    <select required class="form-control bindToDropdown" name="usr_designation_new">
                                        <option value="">Select designation</option>
                                        <?php foreach ($designation as $key => $value) { ?>
                                            <option value="<?php echo $value['desig_id']; ?>">
                                                <?php echo $value['desig_title']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- -->
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Communication address </label>
                                    <input type="text" id="usr_address1" name="usr_address1" required class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Emergency no</label>
                                    <input type="text" id="usr_emergency_no" name="usr_emergency_no" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Marital status</label>
                                    <select required class="form-control" name="usr_marital_status">
                                        <option value="0">Single</option>
                                        <option value="1">Married</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Spouse name</label>
                                    <input type="text" id="usr_spouse_name" name="usr_spouse_name" class="form-control">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Father name </label>
                                    <input type="text" id="usr_father_name" name="usr_father_name" required class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Marriage date</label>
                                    <input type="text" id="usr_marriage_date" name="usr_marriage_date" class="dtpDatePickerDMY form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Educational Qualification</label>
                                    <input type="text" id="usr_edu_quali" name="usr_edu_quali" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Technical Qualification</label>
                                    <input type="text" id="usr_tech_quali" name="usr_tech_quali" class="form-control">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Previous Exp </label>
                                    <input type="text" id="usr_previous_exp" name="usr_previous_exp" required class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Industry Exp</label>
                                    <input type="text" id="usr_industry_exp" name="usr_industry_exp" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Bank A/C no</label>
                                    <input type="text" id="usr_bank" name="usr_bank" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">IFSC Code</label>
                                    <input type="text" id="usr_bank_ifsc" name="usr_bank_ifsc" class="form-control">
                                </div>
                            </div>
                            <!-- -->
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Date of joining <span class="required">*</span></label>
                                    <input type="text" name="usr_doj" required="required" class="dtpDatePickerDMY form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Date of birth</label>
                                    <input type="text" name="usr_dob" class="dtpDatePickerDMY form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Avatar</label>
                                    <input type="file" name="usr_avatar" class="form-control">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEmail4"> </label>
                                    <button type="submit" class="btn btn-primary form-control">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php } ?>

                <div class="x_content">
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

            <!-- -->
            <div class="x_panel">
                <div class="x_title">
                    <h2>Extension</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="extension" class="display nowrap" style="font-size:15px;width:100%;white-space: nowrap;font-weight: bolder;">
                        <thead>
                            <tr>
                                <th>Ext</th>
                                <th>Name</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($extensions)) {
                                foreach ($extensions as $key => $value) {
                            ?>
                                    <tr>
                                        <td title="<?php echo $title; ?>">
                                            <a target="blank" href="sip:<?php echo $value['ext_number']; ?>"><?php echo $value['ext_number']; ?></a>
                                        </td>
                                        <td title="<?php echo $title; ?>">
                                            <a target="blank" href="sip:<?php echo $value['ext_name']; ?>"><?php echo $value['ext_name']; ?></a>
                                        </td>
                                        <td title="<?php echo $title; ?>"><?php echo $value['shr_location']; ?></td>
                                    </tr>
                            <?php
                                }
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
                "url": site_url + "emp_details/newstaffrequestAjax?" + frmData,
                "type": "POST"
            },
            "columns": [{
                    "data": "usr_id",
                    "visible": (showID === 1)
                },
                {
                    "render": function(data, type, full, meta) {
                        var editUrl = "<?php echo site_url($controller . '/quickupdate'); ?>/" +
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