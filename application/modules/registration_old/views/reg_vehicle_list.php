<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Vehicle register</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right;">
                            <!-- <a href="<?php //echo site_url('registration/export_excel?' . $_SERVER['QUERY_STRING']);
                                                  ?>">
                                        <img width="20" title="Export to excel" src="images/excel-export.png"/>
                                   </a>-->
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php if (check_permission('registration', 'myregtodaycallanalysis')) { ?>
                    <div class="x_content" style="height: 150px;overflow-x: hidden;overflow-y: scroll;">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <?php
                                             if (isset($analysis['leadType'])) {
                                                  $sum = 0;
                                                  foreach ($analysis['leadType'] as $key => $value) {
                                                       $callType = unserialize(CALL_TYPE);
                                                       $sum = +$value['total'];
                                             ?>
                                <tr>
                                    <?php if ($key == 0) { ?>
                                    <td rowspan="<?php echo count($analysis['leadType']); ?>">
                                        Lead type (<?php echo $sum; ?>)
                                    </td>
                                    <?php } ?>
                                    <td class="bold-text">
                                        <span><?php echo $callType[$value['vreg_call_type']]; ?></span> :
                                        <span><?php echo $value['total']; ?></span>
                                    </td>
                                </tr>
                                <?php
                                                  }
                                             }
                                             if (isset($analysis['contactMod'])) {
                                                  $sum = 0;
                                                  foreach ($analysis['contactMod'] as $key => $value) {
                                                       $sum = +$value['total'];
                                                       $mod = unserialize(MODE_OF_CONTACT);
                                                  ?>
                                <tr>
                                    <?php if ($key == 0) { ?>
                                    <td rowspan="<?php echo count($analysis['contactMod']); ?>">
                                        Mode of contact (<?php echo $sum; ?>)
                                    </td>
                                    <?php } ?>
                                    <td class="bold-text">
                                        <span><?php echo $mod[$value['vreg_contact_mode']]; ?></span> :
                                        <span><?php echo $value['total']; ?></span>
                                    </td>
                                </tr>
                                <?php
                                                  }
                                             }
                                             if (isset($analysis['assignTo'])) {
                                                  $sum = 0;
                                                  foreach ($analysis['assignTo'] as $key => $value) {
                                                       $sum = +$value['total'];
                                                  ?>
                                <tr>
                                    <?php if ($key == 0) { ?>
                                    <td rowspan="<?php echo count($analysis['assignTo']); ?>">
                                        Assign to (<?php echo $sum; ?>)
                                    </td>
                                    <?php } ?>
                                    <td class="bold-text">
                                        <span><?php echo empty($value['usr_username']) ? 'Not assign' : $value['usr_username']; ?></span>
                                        :
                                        <span><?php echo $value['total']; ?></span>
                                    </td>
                                </tr>
                                <?php
                                                  }
                                             }
                                             ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>

                    <form action="<?php echo site_url($controller . '/index?' . $_SERVER['QUERY_STRING']); ?>"
                        method="get">
                        <table>
                            <tr>
                                <td>
                                    <select data-url="<?php echo site_url('enquiry/bindModel'); ?>"
                                        data-bind="cmbEvModel" data-dflt-select="Select Model"
                                        class="select2_group form-control cmbBrand bindToDropdown" name="vreg_brand"
                                        id="vreg_brand">
                                        <option value="">Select Brand</option>
                                        <?php if (!empty($brand)) {
                                                       foreach ($brand as $key => $value) { ?>
                                        <option
                                            <?php echo (isset($_GET['vreg_brand']) && $_GET['vreg_brand'] == $value['brd_id']) ? "selected" : ''; ?>
                                            value="<?php echo $value['brd_id']; ?>"><?php echo $value['brd_title']; ?>
                                        </option>
                                        <?php }
                                                  }
                                                  ?>
                                    </select>
                                </td>
                                <td>
                                    <select data-url="<?php echo site_url('enquiry/bindVarient'); ?>"
                                        data-bind="cmbEvVariant" data-dflt-select="Select Variant"
                                        class="select2_group form-control cmbEvModel bindToDropdown" name="vreg_model"
                                        id="vreg_model">
                                        <option value="">Select Model</option>
                                        <?php foreach ((array) $model as $key => $value) { ?>
                                        <option
                                            <?php echo (isset($_GET['vreg_model']) && ($value['mod_id'] == $_GET['vreg_model'])) ? 'selected="selected"' : ''; ?>
                                            value="<?php echo $value['mod_id']; ?>"><?php echo $value['mod_title']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="cmbEvVariant select2_group form-control" name="vreg_varient"
                                        id="vreg_varient">
                                        <option value="">Select Variant</option>
                                        <?php foreach ((array) $variant as $key => $value) { ?>
                                        <option
                                            <?php echo (isset($_GET['vreg_varient']) && ($value['var_id'] == $_GET['vreg_varient'])) ? 'selected="selected"' : ''; ?>
                                            value="<?php echo $value['var_id']; ?>">
                                            <?php echo $value['var_variant_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input autocomplete="off" name="enq_date_from" type="text"
                                        class="dtpDatePickerDMY form-control col-md-7 col-xs-12" placeholder="Date from"
                                        value="<?php echo $enq_date_from; ?>" />
                                </td>
                                <td style="padding-left: 10px;">
                                    <input autocomplete="off" name="enq_date_to" type="text"
                                        class="dtpDatePickerDMY form-control col-md-7 col-xs-12" placeholder="Date to"
                                        value="<?php echo $enq_date_to; ?>" />
                                </td>
                                <td style="padding-left: 10px;">
                                    <select style="float: left;width: auto;"
                                        class="muliSelectCombo select2_group form-control" name="mode[]"
                                        multiple="multiple">
                                        <option value="0">All Mode of enquiry</option>
                                        <?php foreach (unserialize(MODE_OF_CONTACT) as $sts => $stsName) { ?>
                                        <option <?php echo (@in_array($sts, $mode)) ? 'selected="selected"' : ''; ?>
                                            value="<?php echo $sts; ?>"><?php echo $stsName ?></option>
                                        <?php } ?>
                                    </select>
                                </td>

                                <?php if (is_roo_user() || $this->usr_grp == 'DE' || $this->usr_grp == 'TL') { ?>
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
                                            value="<?php echo $value['shr_id'] ?>"><?php echo $value['shr_location'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>

                                <td style="padding-left: 10px;">
                                    <select multiple="multiple" style="float: left;width: auto;"
                                        class="muliSelectCombo select2_group form-control cmbSalesExecutives"
                                        name="executive[]">
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
                                <td>
                                    <input autocomplete="off" name="search" type="text"
                                        class="form-control col-md-7 col-xs-12" placeholder="Search by phone, name"
                                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                                </td>
                            </tr>
                            <tr>
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
                                    <select class="select2_group form-control" name="vreg_call_type"
                                        id="vreg_call_type">
                                        <option value="">Select lead type</option>
                                        <?php
                                                  foreach (unserialize(CALL_TYPE) as $key => $value) {
                                                  ?><option
                                            <?php echo (isset($_GET['vreg_call_type']) && ($_GET['vreg_call_type'] == $key)) ? 'selected="selected"' : ''; ?>
                                            value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php
                                                  }
                                                  ?>
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
                                <td style="padding-left: 10px;">
                                    <button type="submit" class="btn btn-round btn-primary">Filter</button>
                                </td>
                                <td>
                                    <a href="<?php echo site_url($controller . '/add'); ?>"
                                        class="btn btn-round btn-primary" style="margin-bottom: 10px;float: right;">New
                                        vehicle register</a>
                                </td>
                            </tr>
                        </table>
                    </form>

                    <div style="width: 100%;overflow-x: scroll;overflow-y: hidden;">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Entry date</th>
                                    <?php if ($this->uid == 56) { ?>
                                    <th>ReAssign</th>
                                    <?php } ?>
                                    <th>Customer name</th>
                                    <th>Contact</th>
                                    <th>Place</th>
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
                                    <th>Assigned to</th>
                                    <th>Added by</th>
                                    <th>First added by / CRE</th>
                                    <th>Call type</th>
                                    <?php if (check_permission('registration', 'candelete')) { ?>
                                    <th>Delete</th>
                                    <?php } ?>
                                    <th>Description</th>
                                    <th>TSC Comment</th>
                                    <th>Share</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $trVOE = (check_permission('registration', 'update')) ? 'trVOE' : '';
                                        foreach ((array) $datas as $key => $value) {
                                        ?>
                                <tr style="<?php echo ($value['vreg_status'] == 0) ? 'color: #fff;background-color: red;' : ''; ?>"
                                    data-url="<?php echo site_url($controller . '/view/' . encryptor($value['vreg_id'])); ?>">
                                    <td class="<?php echo $trVOE; ?>">
                                        <?php if ($value['vreg_is_effective'] == 1) { ?><i title="Effective call"
                                            style="color: green;" class="fa fa-check"></i> <?php } ?>
                                        <?php echo date('j M Y', strtotime($value['vreg_entry_date'])); ?>
                                    </td>
                                    <?php if ($this->uid == 56) { ?>
                                    <td><a
                                            href="<?php echo site_url($controller . '/reassign/' . encryptor($value['vreg_id'])); ?>">Reassign</a>
                                    </td>
                                    <?php } ?>
                                    <td class="<?php echo $trVOE; ?>"><?php echo $value['vreg_cust_name']; ?></td>
                                    <td>
                                        <a style="<?php echo ($value['vreg_status'] == 0) ? 'color: #fff;background-color: red;' : ''; ?>"
                                            <?php echo 'href="https://api.whatsapp.com/send?phone=' . $value['vreg_cust_phone'] . '"'; ?>><?php echo $value['vreg_cust_phone']; ?></a>
                                    </td>
                                    <td class="<?php echo $trVOE; ?>"><?php echo $value['vreg_cust_place']; ?></td>
                                    <td class="<?php echo $trVOE; ?>">
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
                                                            //echo $value['vreg_referal_type'].'';
                                                            $rd_staff = $this->registration->getStaffById($value['vreg_referal_name']);
                                                            $ref_name = $rd_staff['col_title'];
                                                       }
                                                       echo $ref_name;
                                                       ?>

                                    </td>
                                    <td class="<?php echo $trVOE; ?>">
                                        <?php echo $value['vreg_referal_phone'] ?>
                                    </td>
                                    <td class="<?php echo $trVOE; ?>"><?php echo $value['evnt_title']; ?></td>
                                    <td class="<?php echo $trVOE; ?>"><?php echo $value['brd_title']; ?></td>
                                    <td class="<?php echo $trVOE; ?>"><?php echo $value['mod_title']; ?></td>
                                    <td class="<?php echo $trVOE; ?>"><?php echo $value['var_variant_name']; ?></td>
                                    <td class="<?php echo $trVOE; ?>"><?php echo $value['vreg_year']; ?></td>
                                    <td class="<?php echo $trVOE; ?>"><?php echo $value['vreg_investment']; ?></td>
                                    <td class="<?php echo $trVOE; ?>">
                                        <?php echo date('j M Y', strtotime($value['vreg_added_on'])); ?></td>
                                    <td class="<?php echo $trVOE; ?>">
                                        <?php echo $value['assign_usr_first_name'] . ' ' . $value['assign_usr_last_name']; ?>
                                    </td>
                                    <td class="<?php echo $trVOE; ?>">
                                        <?php echo $value['addedby_usr_first_name'] . ' ' . $value['addedby_usr_last_name']; ?>
                                        <?php if (!empty($value['vreg_last_action'])) { ?>
                                        <i class="fa fa-comment-o"
                                            title="<?php echo $value['vreg_last_action']; ?>"></i>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $value['ownedby_usr_first_name'] . ' ' . $value['ownedby_usr_first_name']; ?>
                                    </td>
                                    <td>
                                        <?php
                                                       $callTypes = unserialize(CALL_TYPE);
                                                       echo isset($callTypes[$value['vreg_call_type']]) ? $callTypes[$value['vreg_call_type']] : '';
                                                       ?>
                                    </td>
                                    <?php if (check_permission('registration', 'candelete')) { ?>
                                    <td>
                                        <a class="pencile deleteListItem" href="javascript:void(0);"
                                            data-url="<?php echo site_url($controller . '/delete/' . $value['vreg_id']); ?>">
                                            <i class="fa fa-remove"></i>
                                        </a>
                                    </td>
                                    <?php } ?>
                                    <td class="<?php echo $trVOE; ?>"><?php echo $value['vreg_customer_remark']; ?></td>
                                    <td class="<?php echo $trVOE; ?>"><?php echo $value['vreg_tsc_comments']; ?></td>
                                    <td><a target="_blank"
                                            href="<?php echo 'https://cust.royaldrive.in/share/index/' . $value['vreg_id'] ?>"><i
                                                class="fa fa-whatsapp"></i></a></td>
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