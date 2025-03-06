<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Refurbish job <i style="cursor: pointer;" class="fa fa-plus btnNewRefurbishJob"></i></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php echo form_open_multipart($controller . "/refurbisheReturn", array('id' => "frmAccessories", 'class' => "form-horizontal form-label-left")) ?>
                    <input type="hidden" name="evaluationId" value="<?php echo $vehicles['val_id'] ?>" />
                    <!-- -->
                    <div style="width:100%;overflow-x: scroll;">
                        <table cellpadding="0" ; cellspacing="0" class="tblUpgradeDetails tblRefurb" style="width:100%;white-space: nowrap;">
                            <tr>
                                <th>SL NO</th>
                                <th>Refurbish job in evaluation</th>
                                <th>Estimated cost</th>
                                <?php /*if (check_permission('evaluation', 'candorefurbreturn')) { ?>
                                    <th>Actual job description</th>
                                    <th>Actual cost</th>
                                    <th>SGST(%)</th>
                                    <th>SGST</th>
                                    <th>CGST(%)</th>
                                    <th>CGST</th>
                                    <th>IGST(%)</th>
                                    <th>IGST</th>
                                    <th>Description</th>
                                    <th>Service at</th>
                                    <th>Bill no</th>
                                    <th>Bill date</th>
                                    <th>Expence type</th>
                                    <th>Actual/Estimate</th>
                                <?php }*/ ?>
                            </tr>
                            <?php
                            if (!empty($vehicles['upgradeDetails'])) {

                                foreach ($vehicles['upgradeDetails'] as $key => $value) {
                            ?>
                                    <tr>
                                        <td width="50"><?php echo $key + 1; ?>
                                            <!-- <input type="hidden" name="refrubishjob[<?php //echo $value['upgrd_id'] 
                                                                                            ?>][upgrd_id]" value="<?php //echo $value['upgrd_id'] 
                                                                                                                    ?>" /> -->
                                        </td>
                                        <td style="width: 100%;background:#f5f3f3;"><?php echo $value['upgrd_key']; ?></td>
                                        <td style="background:#f5f3f3;">
                                            <?php
                                            if (!empty($value['upgrd_value'])) {
                                                echo $value['upgrd_value'];
                                            } else {
                                            ?>
                                                <!-- <input type="text" name="refrubishjob[<?php //echo $value['upgrd_id'] 
                                                                                            ?>][upgrd_value]" value="0" /> -->
                                            <?php } ?>
                                        </td>
                                        <?php /*if (check_permission('evaluation', 'candorefurbreturn')) { ?>
                                            <td><input style="width:400px;" type="text" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][actual_job_desc]" value="<?php echo $value['actual_job_description'] ?>" /></td>
                                            <td>
                                                <input type="text" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][newcost]" value="<?php echo $value['upgrd_refurb_actual_cost'] ?>" class="decimalOnly" />
                                            </td>
                                            <td><input type="text" class="sgstp" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][sgstp]" value="<?php echo $value['upgrd_sgstp'] ?>" /></td>
                                            <td><input type="text" class="sgst" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][sgst]" value="<?php echo $value['upgrd_sgst'] ?>" /></td>
                                            <td><input type="text" class="cgstp" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][cgstp]" value="<?php echo $value['upgrd_cgstp'] ?>" /></td>
                                            <td><input type="text" class="cgst" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][cgst]" value="<?php echo $value['upgrd_cgst'] ?>" /></td>
                                            <td><input type="text" class="igstp" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][igstp]" value="<?php echo $value['upgrd_igstp'] ?>" /></td>
                                            <td><input type="text" class="igst" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][igst]" value="<?php echo $value['upgrd_igst'] ?>" /></td>
                                            <td><input type="text" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][desc]" value="<?php echo $value['upgrd_refurb_remarks'] ?>" /></td>
                                            <td>
                                                <select style="border: none;" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][serviceat]">
                                                    <option value="">Service at</option>
                                                    <?php foreach ($vendors as $id => $sstation) { ?>
                                                        <option value="<?php echo $sstation['ven_id']; ?>" <?php echo ($sstation['ven_id'] == $value['upgrd_service_location']) ? "selected" : ''; ?>>
                                                            <?php echo $sstation['ven_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td><input required type="text" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][billno]" value="<?php echo $value['upgrd_bill_no'] ?>" /></td>
                                            <td>
                                                <?php $billDate = '';
                                                if (!empty($value['upgrd_bill_date'])) {
                                                    $billDate = date('d-m-Y', strtotime($value['upgrd_bill_date']));
                                                } else if (!empty($value['upgrd_added_on'])) {
                                                    $billDate = date('d-m-Y', strtotime($value['upgrd_added_on']));
                                                } else {
                                                    $billDate = date('d-m-Y');
                                                }
                                                ?>
                                                <input required type="text" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][billdt]" dt="<?php echo $value['upgrd_bill_date']; ?>" value="<?php echo $billDate; ?>" class="dtpDMY" />
                                            </td>
                                            <td>
                                                <select required style="border: none;" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][upgrd_expence_type]">
                                                    <option value="">Expence type</option>
                                                    <?php foreach ($expenceType as $id => $expty) { ?>
                                                        <option value="<?php echo $expty['ven_id']; ?>" <?php echo ($expty['ven_id'] == $value['upgrd_expence_type']) ? "selected" : ''; ?>>
                                                            <?php echo $expty['ven_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select required style="border: none;" name="refrubishjob[<?php echo $value['upgrd_id'] ?>][upgrd_act_est]">
                                                    <option value="0">Estimate/Actual</option>
                                                    <option value="2" <?php echo ($value['upgrd_act_est'] == 2) ? "selected" : ''; ?>>Estimate</option>
                                                    <option value="1" <?php echo ($value['upgrd_act_est'] == 1) ? "selected" : ''; ?>>Actual</option>
                                                </select>
                                            </td>
                                        <?php }*/ ?>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td></td>
                                    <td><input type="text" name="newRefrubishjob[refurb_job][]" /></td>
                                    <td><input type="number" max="<?php echo get_settings_by_key('refurb_max_amt'); ?>" name="newRefrubishjob[refurb_job_cost][]" class="decimalOnly" />
                                    </td>
                                    <?php /*if (check_permission('evaluation', 'candorefurbreturn')) { ?>
                                        <td><input type="text" name="newRefrubishjob[actual_job_desc][]" /></td>
                                        <td><input type="text" name="newRefrubishjob[newcost][]" class="decimalOnly" /></td>
                                        <td><input type="text" name="newRefrubishjob[sgstp][]" class="sgstp" /></td>
                                        <td><input type="text" name="newRefrubishjob[sgst][]" class="sgst" /></td>
                                        <td><input type="text" name="newRefrubishjob[cgstp][]" class="cgstp" /></td>
                                        <td><input type="text" name="newRefrubishjob[cgst][]" class="cgst" /></td>
                                        <td><input type="text" name="newRefrubishjob[igstp][]" class="igstp" /></td>
                                        <td><input type="text" name="newRefrubishjob[igst][]" class="igst" /></td>
                                        <td><input type="text" name="newRefrubishjob[desc][]" /></td>
                                        <td>
                                            <select required style="border: none;" name="newRefrubishjob[serviceat][]">
                                                <option value="">Service at</option>
                                                <?php foreach ($vendors as $id => $sstation) { ?>
                                                    <option value="<?php echo $sstation['ven_id']; ?>">
                                                        <?php echo $sstation['ven_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td><input required type="text" name="newRefrubishjob[billno][]" /></td>
                                        <td><input required type="text" name="newRefrubishjob[billdt][]" class="dtpDMY" /></td>
                                        <td>
                                            <select required style="border: none;" name="newRefrubishjob[upgrd_expence_type][]">
                                                <option value="">Expence type</option>
                                                <?php foreach ($expenceType as $id => $expty) { ?>
                                                    <option value="<?php echo $expty['ven_id']; ?>">
                                                        <?php echo $expty['ven_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select required style="border: none;" name="newRefrubishjob[upgrd_act_est][]">
                                                <option value="2">Estimate</option>
                                                <option value="1">Actual</option>
                                            </select>
                                        </td>
                                    <?php }*/ ?>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <!-- -->
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-success alert-dismissible fade in msgBox" role="alert" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <strong>Updated successfully!</strong>
</div>

<script>
    var d = '<?php if (check_permission('evaluation', 'candorefurbreturn')) {
                    echo 1;
                } ?>';
    <?php
    $sstationsJson = json_encode($vendors);
    echo "var sstations = " . $sstationsJson . ";\n";

    $expenceTypeJson = json_encode($expenceType);
    echo "var expenceType = " . $expenceTypeJson . ";\n";
    ?>
    $(document).ready(function() {
        $('.dtpDMY').datetimepicker({
            format: "DD-MM-YYYY"
        });
    });

    $(document).on('click', '.btnNewRefurbishJob', function(e) {

        var cmbSstation =
            '<td><select required name="newRefrubishjob[serviceat][]" style="border: none;"><option value="">Service at</option>';
        $.each(sstations, function(index, value) {
            cmbSstation = cmbSstation + '<option value="' + value.ven_id + '">' + value.ven_name +
                '</option>';
        });
        cmbSstation = cmbSstation + '</select></td>';

        var cmbExpenceType =
            '<td><select required name="newRefrubishjob[upgrd_expence_type][]" style="border: none;"><option value="">Expence type</option>';
        $.each(expenceType, function(index, value) {
            cmbExpenceType = cmbExpenceType + '<option value="' + value.ven_id + '">' + value.ven_name +
                '</option>';
        });
        cmbExpenceType = cmbExpenceType + '</select></td>';

        var estActu = '<td> <select required style = "border: none;" name = "newRefrubishjob[upgrd_act_est][]" > ' +
            '<option value="2"> Estimate </option> <option value="1" > Actual </option> </select> </td>'
        if (d) {
            var tmp = '<tr><td></td>' +
                '<td><input type="text" name="newRefrubishjob[refurb_job][]" class=""/></td>' +
                '<td><input type="text" name="newRefrubishjob[refurb_job_cost][]" class="decimalOnly"/></td>';
            // '<td><input type="text" name="newRefrubishjob[actual_job_desc][]" class=""/></td>'+
            // '<td><input type="text" name="newRefrubishjob[newcost][]" class="decimalOnly"/></td>' +
            // '<td><input type="text" name="newRefrubishjob[sgstp][]" class="sgstp"/></td>' +
            // '<td><input type="text" name="newRefrubishjob[sgst][]" class="sgst"/></td>' +
            // '<td><input type="text" name="newRefrubishjob[cgstp][]" class="cgstp"/></td>' +
            // '<td><input type="text" name="newRefrubishjob[cgst][]" class="cgst"/></td>' +
            // '<td><input type="text" name="newRefrubishjob[igstp][]" class="igstp"/></td>' +
            // '<td><input type="text" name="newRefrubishjob[igst][]" class="igst"/></td>' +
            // '<td><input type="text" name="newRefrubishjob[desc][]" class=""/></td>' + cmbSstation +
            // '<td><input required type="text" name="newRefrubishjob[billno][]"/></td>' +
            // '<td><input required type="text" name="newRefrubishjob[billdt][]" class="dtpDMY"/></td>' + cmbExpenceType + estActu + '</tr>';
        } else {
            var tmp = '<tr><td></td>' +
                '<td><input type="text" name="newRefrubishjob[refurb_job][]" class=""/></td>' +
                '<td><input type="text" name="newRefrubishjob[refurb_job_cost][]" class="decimalOnly"/></td>' +
                '</tr>';
        }

        $('.tblUpgradeDetails tbody tr:last').after(tmp);
        $('.dtpDMY').datetimepicker({
            format: "DD-MM-YYYY"
        });
    });
    $("#frmAccessories").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        //var url = form.attr('action');
        var url = site_url + '<?php echo $controller ?>/refurbisheReturn';
        //alert(url);
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            dataType: "json",
            beforeSend: function() {
                $('.divLoading').show();
                $(".btn-success").attr("disabled", true);
            },
            success: function(data) {
                $('.divLoading').hide();
                if (data.status == "success") {
                    $('.msgBox').show();
                    setTimeout(function() {
                        $('.msgBox').fadeOut();
                    }, 1500);
                } else {
                    $('.ErrorMsgBox').show();
                }
            }
        });
    });
    $(document).on('keyup', '.sgstp', function(e) {
        var p = parseFloat($(this).val());
        if (p > 0) {
            var amt = parseFloat($(this).closest('td').prev('td').find('input').val());
            var sgst = (amt * p) / 100;
            $(this).closest('td').next('td').find('input').val(sgst);
        } else {
            $(this).closest('td').next('td').find('input').val(0.00);
        }
    });
    $(document).on('keyup', '.cgstp', function(e) {
        var p = parseFloat($(this).val());
        if (p > 0) {
            var amt = parseFloat($(this).closest('td').prev('td').prev('td').prev('td').find('input').val());
            var cgst = (amt * p) / 100;
            $(this).closest('td').next('td').find('input').val(cgst);
        } else {
            $(this).closest('td').next('td').find('input').val(0.00);
        }
    });

    $(document).on('keyup', '.igstp', function(e) {
        var p = parseFloat($(this).val());
        if (p > 0) {
            var amt = parseFloat($(this).closest('td').prev('td').prev('td').prev('td').prev('td').prev('td').find(
                'input').val());
            var igst = (amt * p) / 100;
            $(this).closest('td').next('td').find('input').val(igst);
        } else {
            $(this).closest('td').next('td').find('input').val(0.00);
        }
    });
</script>
<style>
    /*white-space:nowrap;*/
    .tblRefurb {
        width: 100%;
    }

    input {
        border: 0px solid #000;
        margin: 0;
        background: transparent;
        width: -webkit-fill-available;
    }

    .tblUpgradeDetails tr td {
        border: 1px solid #000;
        padding: 0px 5px 0px 5px;
        white-space: nowrap;
    }

    .tblUpgradeDetails tr th {
        border: 1px solid #000;
        padding: 3px;
        text-align: center;
        background: #eee;
    }

    /*table{background: #fff none repeat scroll 0 0;border-left: 1px solid #000;border-top: 1px solid #000;}*/
    /*table tr:nth-child(even){background:#ccc;}*/
    /*table tr:nth-child(odd){background:#eee;}*/
</style>