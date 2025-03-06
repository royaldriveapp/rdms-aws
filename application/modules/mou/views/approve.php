<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Approve MOU</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php echo form_open_multipart("mou/approve/" . $datas['master']['moum_id'], array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left")) ?>
                    <input type="hidden" name="moum_id" value="<?php echo $datas['master']['moum_id']; ?>" />
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">Memorandum Of Understanding</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Division <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <select class="select2_group form-control cmbBindShowroomByDivision" name="moum_division" id="moum_division" data-url="<?php echo site_url('enquiry/bindShowroomByDivision'); ?>" data-bind="cmbShowroom" required data-dflt-select="Select Showroom">
                                                <option value="">Select division</option>
                                                <?php foreach ($division as $key => $value) { ?>
                                                    <option <?php echo ($datas['master']['moum_division'] == $value['div_id']) ? "selected" : ''; ?> value="<?php echo $value['div_id']; ?>">
                                                        <?php echo $value['div_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Showroom <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <select required class="select2_group form-control cmbShowroom shorm_stf" name="moum_showroom" id="moum_showroom">
                                                <option value="">Select showroom</option>

                                                <?php foreach ($showroom as $key => $value) { ?>
                                                    <option <?php echo ($datas['master']['moum_showroom'] == $value['shr_id']) ? "selected" : ''; ?> value="<?php echo $value['shr_id']; ?>">
                                                        <?php echo $value['shr_location']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Regn Number <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input value="<?php echo $datas['master']['moum_reg_num']; ?>" type="text" class="form-control col-md-7 col-xs-12 regNumber" name="moum_reg_num" required id="moum_reg_num" placeholder="KL00AA0000" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vehicle</label>
                                        <div class="col-md-3 col-sm-7 col-xs-12">
                                            <select data-url="<?php echo site_url('enquiry/bindModel'); ?>" data-bind="cmbEvModel" data-dflt-select="Select Model" class="cmbBrand select2_group form-control bindToDropdown" name="moum_brand" id="invv_brand">
                                                <option value="">Select Brand</option>
                                                <?php
                                                if (!empty($brand)) {
                                                    foreach ($brand as $key => $value) {
                                                ?>
                                                        <option <?php echo ($datas['master']['moum_brand'] == $value['brd_id']) ? "selected" : ''; ?> value="<?php echo $value['brd_id']; ?>">
                                                            <?php echo $value['brd_title']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select data-url="<?php echo site_url('enquiry/bindVarient'); ?>" data-bind="cmbEvVariant" data-dflt-select="Select Variant" class="cmbEvModel select2_group form-control bindToDropdown" name="moum_model" id="invv_model">

                                                <?php
                                                if (!empty($model)) {
                                                    foreach ($model as $key => $value) {
                                                ?>
                                                        <option <?php echo ($datas['master']['moum_model'] == $value['mod_id']) ? "selected" : ''; ?> value="<?php echo $value['mod_id']; ?>">
                                                            <?php echo $value['mod_title']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select class="select2_group form-control cmbEvVariant" name="moum_varient" id="invv_varient">
                                                <?php
                                                if (!empty($variant)) {
                                                    foreach ($variant as $key => $value) {
                                                ?>
                                                        <option <?php echo ($datas['master']['moum_varient'] == $value['var_id']) ? "selected" : ''; ?> value="<?php echo $value['var_id']; ?>">
                                                            <?php echo $value['var_variant_name']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase Place <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $datas['master']['moum_purchase_place']; ?>" name="moum_purchase_place" required id="moum_purchase_place" placeholder="Purchase Place" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Date <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <div class="input-group date" id="dtpMOUDate">
                                                <input required type="text" class="form-control" name="moum_date" placeholder="Date" value="<?php echo date('Y-m-d', strtotime($datas['master']['moum_date'])); ?>" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Name <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $datas['master']['moum_customer_name']; ?>" name="moum_customer_name" required id="moum_customer_name" placeholder="Customer Name" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Phone <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input type="number" class="form-control col-md-7 col-xs-12" value="<?php echo $datas['master']['moum_cust_phone']; ?>" name="moum_cust_phone" required id="moum_customer_name" placeholder="Customer Phone" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer Email</label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input type="email" class="form-control col-md-7 col-xs-12" value="<?php echo $datas['master']['moum_cust_email']; ?>" name="moum_cust_email" id="moum_cust_email" placeholder="Customer Email" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name of father <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $datas['master']['moum_father_name']; ?>" name="moum_father_name" required id="moum_father_name" placeholder="Name Of Father" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Age</label>

                                        <div class="col-md-6 col-sm-3 col-xs-12">
                                            <div class="input-group date" id="dtpDOB">
                                                <input value="<?php echo !empty($datas['master']['moum_dob']) ? date('Y-m-d', strtotime($datas['master']['moum_dob'])) : ''; ?>" type="text" class="form-control" name="moum_dob" placeholder="Date of birth" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <input value="<?php echo $datas['master']['moum_age']; ?>" type="number" class="form-control col-md-7 col-xs-12 txtAge" required name="moum_age" id="moum_age" placeholder="Age" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <textarea class="form-control col-md-7 col-xs-12" required placeholder="Address" name="moum_address"><?php echo trim($datas['master']['moum_address']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pin <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input type="number" class="form-control col-md-7 col-xs-12" required name="moum_pin" id="moum_pin" placeholder="Pin" value="<?php echo $datas['master']['moum_pin']; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">District <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <select required class="select2_group form-control" name="moum_dist" id="moum_dist">
                                                <option value="">Select District</option>
                                                <?php foreach ($districts as $key => $value) { ?>
                                                    <option value="<?php echo $value['std_id']; ?>" <?php echo ($datas['master']['moum_dist'] == $value['std_id']) ? "selected" : ''; ?>>
                                                        <?php echo $value['std_district_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase Staff <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <select required class="select2_group form-control" name="moum_pur_staff" id="moum_pur_staff">
                                                <option value="">Purchase Staff</option>
                                                <?php foreach ($purchaseStaff as $key => $value) { ?>
                                                    <option value="<?php echo $value['usr_id']; ?>" <?php echo ($datas['master']['moum_pur_staff'] == $value['usr_id']) ? "selected" : ''; ?>>
                                                        <?php echo $value['usr_username'] . ' - ' . $value['desig_title']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Net Price <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input type="number" class="form-control col-md-7 col-xs-12" required name="moum_net_price" id="moum_net_price" placeholder="Net Price" value="<?php echo $datas['master']['moum_net_price']; ?>" />
                                            <?php if (get_settings_by_key('show_bl_on_sales') == 1) { ?>
                                                <spam style="font-size:9px; font-style: italic;">Bank part</spam>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Evaluation
                                            charges</label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input value="<?php echo $datas['master']['moum_bl_amt']; ?>" type="number" class="form-control col-md-7 col-xs-12" required name="moum_bl_amt" id="moum_bl_amt" placeholder="Evaluation charges" />
                                            <?php if (get_settings_by_key('show_bl_on_sales') == 1) { ?>
                                                <spam style="font-size:9px; font-style: italic;">Cash part</spam>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Advance Token <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input value="<?php echo $datas['master']['moum_adv_token']; ?>" type="number" class="form-control col-md-7 col-xs-12" required name="moum_adv_token" id="moum_adv_token" placeholder="Advance Token" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Sourcing type*</label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <select class="select2_group form-control" name="moum_purchase_type" required>
                                                <option value="">Select</option>
                                                <?php foreach (unserialize(SOURCING_TYPE) as $key => $sourcing_type) : ?>
                                                    <option <?php echo ($datas['master']['moum_purchase_type'] == $key) ? "selected" : ''; ?> value="<?= $key ?>"><?= $sourcing_type ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Vehicle Category*</label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <select class="select2_group form-control cmbFollStatus" name="moum_vehicle_category" required>
                                                <option value="">Select</option>
                                                <?php foreach (unserialize(VAL_TYPE_TITLE) as $key => $val_type) : ?>
                                                    <option <?php echo ($datas['master']['moum_vehicle_category'] == $key) ? "selected" : ''; ?> value="<?= $key ?>"><?= $val_type ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading"> </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">First Party convey on
                                            <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <div class="input-group date" id="dtpConveyOn">
                                                <input value="<?php echo date('Y-m-d', strtotime($datas['master']['moum_convey_on'])); ?>" required type="text" class="form-control" name="moum_convey_on" placeholder="First Party convey on" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Agreement Days <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input value="<?php echo $datas['master']['moum_agrmnt_days']; ?>" type="number" class="form-control col-md-7 col-xs-12" name="moum_agrmnt_days" required id="moum_agrmnt_days" placeholder="Agreement Days" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">ANNEXURE - I</div>
                                <div class="panel-body">
                                    <label>A. IDENTIFICATION NUMBERS MAJOR COMPONENTS OF THE SAID VEHICLE</label>

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name Major Component</th>
                                                <th>Identification Number</th>
                                                <th>Remarks</th>
                                                <th><span style="cursor: pointer;" class="glyphicon glyphicon-plus btnComponents"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbUpgradDet">
                                            <?php
                                            if (isset($datas['identification']) && !empty($datas['identification'])) {
                                                foreach ($datas['identification'] as $key => $value) {
                                                    if ($value['moui_component'] == 1) {
                                                        $label = 'Engine Number';
                                                    } else if ($value['moui_component'] == 2) {
                                                        $label = 'Chassis Number';
                                                    } else if (isset($identComponent[$value['moui_component']])) {
                                                        $label = $identComponent[$value['moui_component']];
                                                    }
                                            ?>
                                                    <tr>
                                                        <td><?php echo $label; ?>
                                                            <input type="hidden" name="AA[<?php echo $value['moui_id']; ?>][id]" value="<?php echo $value['moui_id']; ?>" />
                                                            <input type="hidden" name="AA[<?php echo $value['moui_id']; ?>][component]" value="<?php echo $value['moui_component']; ?>" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control col-md-7 col-xs-12" required name="AA[<?php echo $value['moui_id']; ?>][number]" value="<?php echo $value['moui_id_num']; ?>" id="mou_engine_number" placeholder="Engine Number" />
                                                        </td>
                                                        <td colspan="2">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" required name="AA[<?php echo $value['moui_id']; ?>][remarks]" value="<?php echo $value['moui_remarks']; ?>" id="mou_engine_number" placeholder="Remarks" />
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>

                                    <label>B. DETAILS OF SERVICE PACKAGES, EXTENDED WARRANTY, INSURANCE POLICY NUMBER
                                        ETC.</label>

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Particulars <i>(of service Package, Warranty policy, Insurance
                                                        Policy etc.)</i></th>
                                                <th>Identification Number</th>
                                                <th>Remarks</th>
                                                <th><span style="cursor: pointer;" class="glyphicon glyphicon-plus btnWarranty"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbWarranty">
                                            <?php if (isset($datas['service']) && !empty($datas['service'])) {
                                                foreach ($datas['service'] as $key => $value) { ?>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" value="<?php echo $value['mous_id']; ?>" name="AB[<?php echo $value['mous_id']; ?>][id]" />

                                                            <input class="form-control col-md-7 col-xs-12" type="text" name="AB[<?php echo $value['mous_id']; ?>][component]" value="<?php echo $value['mous_particulars']; ?>" placeholder="Particulars" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control col-md-7 col-xs-12" placeholder="Identification Number" id="mous_id_num" name="AB[<?php echo $value['mous_id']; ?>][number]" value="<?php echo $value['mous_id_num']; ?>" />
                                                        </td>
                                                        <td colspan="2">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" placeholder="Remarks" id="mous_remaks" value="<?php echo $value['mous_remaks']; ?>" name="AB[<?php echo $value['mous_id']; ?>][remarks]" />
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">Other details</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Company <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <select class="select2_group form-control" name="moum_fin_year_code" id="moum_fin_year_code" required>
                                                <option value="0">Select company</option>
                                                <?php foreach ($company as $key => $value) { ?>
                                                    <option <?php echo ($datas['master']['moum_fin_year_code'] == $value['cmp_finance_year_code']) ? 'selected' : ''; ?> value="<?php echo $value['cmp_finance_year_code']; ?>">
                                                        <?php echo $value['cmp_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="foll_contact" class="control-label col-md-3 col-sm-3 col-xs-12">Color <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <select class="select2 select2_group form-control" name="moum_color" id="moum_color" required>
                                                <option value="0">Select color</option>
                                                <?php foreach ($color as $key => $value) { ?>
                                                    <option <?php echo ($datas['master']['moum_color'] == $value['vc_id']) ? 'selected="selected"' : ''; ?> value="<?php echo $value['vc_id']; ?>">
                                                        <?php echo $value['vc_color']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Model Year <span class="required">*</span></label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input required type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $datas['master']['moum_model_year']; ?>" name="moum_model_year" id="moum_model_year" placeholder="Model Year" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Aadhaar number</label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input type="number" class="form-control col-md-7 col-xs-12" value="<?php echo $datas['master']['moum_aadhaar']; ?>" name="moum_aadhaar" id="moum_aadhaar" placeholder="Aadhaar number" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">PAN number</label>
                                        <div class="col-md-9 col-sm-6 col-xs-12">
                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $datas['master']['moum_pan']; ?>" name="moum_pan" id="moum_pan" placeholder="PAN Card number" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">ANNEXURE - II</div>
                                <div class="panel-body">
                                    <label style="text-align: center; width: 100%;">
                                        LIST OF COMPLAINTS / DEFECTS NOTICED IN THE SAID VEHICLE <br> & <br>
                                        REFURBISHING WORK TO DONE TO MAKE THE SAID VEHICLE TO MAKE IT A MARKETABLE
                                        PRE-OWNED CAR
                                    </label>

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Complaints / Defects noticed</th>
                                                <th>Refurbish work to be done</th>
                                                <th>Remarks</th>
                                                <th><span style="cursor: pointer;" class="glyphicon glyphicon-plus btnRefurb"></span></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbRefurb">
                                            <?php if (isset($datas['rf']) && !empty($datas['rf'])) {
                                                foreach ($datas['rf'] as $key => $value) {
                                            ?>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" value="<?php echo $value['mour_id']; ?>" name="RF[<?php echo $value['mour_id']; ?>][id]" />
                                                            <input class="form-control col-md-7 col-xs-12" type="text" name="RF[complaints][<?php echo $value['mour_id']; ?>]" value="<?php echo $value['mour_complaints']; ?>" placeholder="Complaints / Defects noticed" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $value['mour_rf_to_done']; ?>" placeholder="Refurbish work to be done" name="RF[<?php echo $value['mour_id']; ?>][works]" />
                                                        </td>
                                                        <td colspan="2">
                                                            <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $value['mour_remarks']; ?>" placeholder="Remarks" name="RF[<?php echo $value['mour_id']; ?>][remarks]" />
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Narration</div>
                                <div class="panel-body">
                                    <textarea class="form-control col-md-12 col-xs-12" required placeholder="Narration" name="moum_approved_desc"><?php echo !empty($datas['master']['moum_approved_desc']) ? $datas['master']['moum_approved_desc'] : 'MOU approved for ' . $datas['master']['moum_reg_num'] . ', by ' . $this->session->userdata('usr_username') . ', date : ' . date('d-m-Y H:i:s'); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <?php if ($datas['master']['moum_approved_by'] == 0) { ?>
                                <button type="submit" class="btn btn-success">Approve</button>
                            <?php } else {
                                echo $datas['master']['moum_approved_desc'];
                            }
                            ?>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('.btnRefurb').on('click', function() {
            var tmp =
                '<tr><td><input class="form-control col-md-7 col-xs-12"  type="text" name="RF[new][complaints][]" placeholder="Complaints / Defects noticed"/></td>' +
                '<td><input type="text" class="form-control col-md-7 col-xs-12" placeholder="Refurbish work to be done" name="RF[new][works][]"/></td>' +
                '<td colspan="2"><input type="text" class="form-control col-md-7 col-xs-12" placeholder="Remarks" name="RF[new][remarks][]"/></td></tr>';
            $('.tbRefurb').append(tmp);
        });

        $('.btnWarranty').on('click', function() {
            var tmp =
                '<tr><td><input class="form-control col-md-7 col-xs-12"  type="text" name="AB[new][component][]" placeholder="Particulars"/></td>' +
                '<td><input type="text" class="form-control col-md-7 col-xs-12" placeholder="Identification Number" id="mou_engine_number" name="AB[new][number][]"/></td>' +
                '<td colspan="2"><input type="text" class="form-control col-md-7 col-xs-12" placeholder="Remarks" id="mou_engine_number" name="AB[new][remarks][]"/></td></tr>';
            $('.tbWarranty').append(tmp);
        });

        $('.btnComponents').on('click', function() {
            var tmp = '<tr><td>' +
                '<select class="form-control col-md-7 col-xs-12" name="AA[new][component][]">' +
                '<option value="0">Name Of Component</option>' +
                <?php foreach ($identComponent as $compId => $comp) { ?> '<option value="<?php echo $compId; ?>"><?php echo $comp; ?></option>' +
                <?php } ?> '</select></td>' +
                '<td><input type="text" class="form-control col-md-7 col-xs-12" required name="AA[new][number][]" id="mou_chassis_number" placeholder="Identification Number"/></td>' +
                '<td colspan="2"><input type="text" class="form-control col-md-7 col-xs-12" name="AA[new][remarks][]" id="mou_engine_number" placeholder="Remarks"/></td>' +
                '</tr>';
            $('.tbUpgradDet').append(tmp);
        });

        $('#dtpMOUDate').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD'
            //minDate: moment('2023-03-28'),
            //maxDate: moment('2023-04-28')
        });
        $(document).on('keypress keyup', '#dtpMOUDate', function() {
            return false;
        });

        $('#dtpConveyOn').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD'
            //minDate: moment('2023-03-28'),
            //maxDate: moment('2023-04-28')
        });
        $(document).on('keypress keyup', '#dtpConveyOn', function() {
            return false;
        });

        $(document).on('keypress keyup blur', '.regNumber', function() {
            $(this).val($(this).val().replace(/[^A-Z0-9]/ig, '').toUpperCase());
        });
        $('#dtpDOB').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD'
        }).on('dp.change', function(e) {
            var dob = e.date.format('YYYY-MM-DD');
            var str = dob.split('-');
            var firstdate = new Date(str[0], str[1], str[2]);
            var today = new Date();
            var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
            var age = parseInt(dayDiff);
            $('.txtAge').val(age);
        });
    });
</script>


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>