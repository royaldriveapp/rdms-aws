<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Consolidated refurbishment</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="page" oldid="printRefrb" id="divPrint<?php echo $rfMstr['vum_id']; ?>">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="chk-container" style="float: right;width: 100%;">
                                        <h3 class="border-bottom border-gray pb-2 text-center">
                                            Refurbishment</h3>
                                        <div class="row">
                                            <?php $description = isset($result['masterData']['pcl_description']) ? json_decode($result['masterData']['pcl_description']) : array(); ?>
                                            <!-- table one -->
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table class="toptable table table-stripedk table-borderedj">
                                                    <tbody>
                                                        <tr class="top-tbl-tr">
                                                            <td><b>Registration NO :</b>
                                                                <?php echo strtoupper($vehicles['val_prt_1']) . '-' . $vehicles['val_prt_2'] . '-' . strtoupper($vehicles['val_prt_3']) . '-' . $vehicles['val_prt_4']; ?>
                                                            </td>
                                                            <td><b>Make & Model :</b>
                                                                <?php echo $vehicles['brd_title'] . ', ' . $vehicles['mod_title'] . ', ' . $vehicles['var_variant_name']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Date of Evaluation :</b>
                                                                <?php echo date('d-m-Y', strtotime($vehicles['val_valuation_date'])); ?>
                                                            </td>
                                                            <td><b>Purchase Type :</b>
                                                                <?php
                                                                $purchaseTypes = unserialize(EVALUATION_TYPES);
                                                                echo isset($purchaseTypes[$vehicles['val_type']]) ? $purchaseTypes[$vehicles['val_type']] : '';
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Evaluator :</b>
                                                                <?php echo isset($vehicles['usr_username']) ? $vehicles['usr_username'] : ''; ?>
                                                            </td>
                                                            <td><b>Approver </b> :</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Date of Stocking :</b>
                                                                <?php echo isset($result['masterData']['pcl_created_at']) ? date('d-m-Y', strtotime($result['masterData']['pcl_created_at'])) : ''; ?>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <?php $ttlEst = 0;
                                    $ttlAct = 0; ?>
                                    <table class="tabled table-striped refrftable" style="font-size:11px;">
                                        <tr>
                                            <th style="width:4%;">Sl No</th>
                                            <th style="width:6.3%;" class="no-print">
                                                Date</th>
                                            <th style="width:33%;">Refurbishment Job in
                                                Evaluation </th>
                                            <th style="width:7%;">Estimate</th>
                                            <th style="width:33%;">Actual Job
                                                Description </th>
                                            <th style="width:7%;">Actual</th>
                                            <th>Service at</th>
                                            <th class="no-print">Remark </th>
                                        </tr>
                                        <?php
                                        $slno = 1;
                                        $refurbDetails = $this->evaluation->getRefurbDetails($vehicles['val_id'], $rfMstr['vum_id']);
                                        if (!empty($refurbDetails)) {
                                            foreach ($refurbDetails as $key => $value) {
                                                $act = $value->upgrd_refurb_actual_cost + $value->upgrd_sgst + $value->upgrd_cgst + $value->upgrd_igst;
                                                $ttlEst = $ttlEst + (float) $value->upgrd_value;
                                                $ttlAct = $ttlAct + (float) $value->upgrd_refurb_actual_cost + $value->upgrd_sgst + $value->upgrd_cgst + $value->upgrd_igst;
                                                $addedBy = ((check_permission('evaluation', 'show_refurb_done')) && !empty($value->usr_username_added_by)) ?
                                                    ' (' . $value->usr_username_added_by . ')' : '';
                                        ?>
                                                <tr>
                                                    <td><?php echo $slno++ ?></td>
                                                    <td class="no-print">
                                                        <?php echo date('d-m-Y', strtotime($value->upgrd_added_on)); ?>
                                                    </td>
                                                    <td style="white-space: normal;">
                                                        <?php echo $value->upgrd_key . $addedBy; ?>
                                                    </td>
                                                    <td><?php echo get_in_currency_format($value->upgrd_value); ?>
                                                    </td>
                                                    <td style="white-space: normal;">
                                                        <?php echo $value->actual_job_description; ?>
                                                    </td>
                                                    <td><?php echo ($act > 0) ? get_in_currency_format($act) : ''; ?>
                                                    </td>
                                                    <td><?php echo $value->ven_name; ?></td>
                                                    <td style="white-space: normal;" class="no-print">
                                                        <?php echo $value->upgrd_refurb_remarks; ?>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="2" style="border: none !important;font-size: 16px;font-weight: bold;">
                                                Total</td>
                                            <td style="border: none !important;" class="no-print">
                                            </td>
                                            <td style="border: none !important;font-size: 16px;font-weight: bold;">
                                                <?php echo $ttlEst > 0 ? get_in_currency_format($ttlEst) : ''; ?>
                                            </td>
                                            <td style="border: none !important;"></td>
                                            <td colspan="2" style="border: none !important;font-size: 16px;font-weight: bold;">
                                                <?php echo $ttlAct > 0 ? get_in_currency_format($ttlAct) : ''; ?>
                                            </td>
                                            <td style="border: none !important;"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="toptable table table-stripedk table-borderedj refrb-bottom-tbl">
                                <tbody>
                                    <tr class="top-tbl-tr">
                                        <td>
                                            <h5>Request By</h5>
                                        </td>
                                        <td>
                                            <h5>Checked BY ( Delivery Co ordinator / <br>Dy
                                                Manager - Inventory
                                                )
                                            </h5>
                                        </td>
                                        <td>
                                            <h5>Approved BY - COO/VP/MD/DM</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Name:</b>
                                            <?php //echo isset($vehicles['usr_username']) ? $vehicles['usr_username'] : ''; 
                                            ?>
                                        </td>
                                        <td><b>Name:</b> </td>
                                        <td><b>Name:</b> </td>
                                    </tr>
                                    <tr>
                                        <td><b>Sign:</b> </td>
                                        <td><b>Sign:</b> </td>
                                        <td><b>Sign:</b> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page {
        /*width: 21cm;*/
        min-height: 6.7cm;
        /*padding: 2cm;*/
        /*margin: 1cm auto;*/
        /*border: 1px #D3D3D3 solid;*/
        /*border-radius: 5px;*/
        background: white;
        /*box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);*/
    }

    @page {
        size: A4;
        margin: 0;
    }

    @media print {
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }

    /*complaint*/

    div.desc {
        padding: 15px;
        text-align: center;
    }

    /*complaint*/
    .table {
        margin-bottom: 0px !important;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        padding: 5px !important;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th {
        border: none !important;
    }

    .x_content {
        font-size: 11px;
    }

    @media print {
        .right_col {
            margin-left: 0px !important;
        }

        .left_col {
            display: none !important;
        }

        .right_col {
            height: 400px !important;
        }

        .row {
            height: 400px !important;
        }

        .div-col-body {
            height: 400px !important;
        }

        .x_panel {
            max-height: 271px !important;
            border: none !important;
        }
    }

    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }

        .msgBox {
            display: none !important;
        }
    }

    .refrftable td,
    .refrftable th {
        border: 1px solid black !important;
        padding: 4px 5px !important;
    }

    .refrftable th {
        padding-top: 4px !important;
        padding-bottom: 4px !important;
        text-align: left;
        color: black !important;
    }

    .refrb-bottom-tbl>thead>tr>th {
        padding: 8px !important;
        line-height: 1.777 !important;
        vertical-align: top !important;
        border-top: 0px !important;
    }

    .panel-heading .accordion-toggle:after {
        /* symbol for "opening" panels */
        font-family: 'Glyphicons Halflings';
        /* essential for enabling glyphicon */
        content: "\e114";
        /* adjust as needed, taken from bootstrap.css */
        float: right;
        /* adjust as needed */
        color: grey;
        /* adjust as needed */
    }

    .panel-heading .accordion-toggle.collapsed:after {
        /* symbol for "collapsed" panels */
        content: "\e080";
        /* adjust as needed, taken from bootstrap.css */
    }
</style>
<script>
    $(document).ready(function() {
        $(".btnSubmitValuationAjax").click(function(e) {
            e.preventDefault();
            var formData = $(this).closest('form').serialize();
            var frmCustome = $(this).closest('form');
            $('.vdh_cmd').css('border-color', '');
            var url = $(this).data('url');
            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                data: {
                    formData
                },
                success: function(resp) {
                    messageBox(resp);
                    $(frmCustome)[0].reset();
                }
            });
        });
        $(".btnSubmitDocumentDetails").click(function() {
            var documentDetails = $('.vdh_cmd').val().trim();
            if (documentDetails) {
                $('.vdh_cmd').css('border-color', '');
                var url = $(this).data('url');
                $.ajax({
                    type: 'post',
                    url: url,
                    dataType: 'json',
                    data: {
                        vdh_cmd: documentDetails,
                        vdh_val_id: "<?php echo $vehicles['val_id']; ?>"
                    },
                    success: function(resp) {
                        $('.ulTimeline').prepend(resp.msg);
                        $('.vdh_cmd').val('');
                        alert('Document updated successfully updated!');
                    }
                });
            } else {
                $('.vdh_cmd').css('border-color', 'red');
                $('.vdh_cmd').focus();
            }
        });
        $("#printBtn_rfrb").click(function() {
            window.print();
        });
    });
</script>