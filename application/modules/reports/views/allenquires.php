<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>All enquires</h2>
                    <i id="divPlayPause" class="stopped fa fa-pause"
                        style="font-size: 24px; margin-top: 5px;margin-left: 20px;float: right;"></i>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form style="margin-bottom:10px;" class="frmFilter">
                        <select id="data" name="cmbStatus[]" class="cmbStatus" multiple="multiple"
                            data-placeholder="Status"></select>
                        <select id="cmbShowroom" name="cmbShowroom[]" class="cmbShowroom" multiple="multiple"
                            data-placeholder="Showroom"></select>
                        <select id="cmbSalesExecutives" name="cmbSalesExecutives[]" class="cmbSalesExecutives"
                            multiple="multiple" data-placeholder="Sales staff"></select>
                        <button type="button" class="btn btn-round btn-primary btnFilter">Filter</button>
                    </form>
                    <table id="tblAllEnquires" class="table table-striped table-bordered display nowrap" style="width:100%;white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Mobile</th>
                                <th>Sales Staff</th>
                                <th>District</th>
                                <th>Enquiry mode</th>
                                <th>Customer Status</th>
                                <th>Enquiry Status</th>
                                <th>Sale amount</th>
                                <th>TCS</th>
                                <th>Total sale amount</th>
                                <th>Advance</th>
                                <th>Booking punch on</th>
                                <th>Expect delivery</th>
                                <th>Delivery date</th>
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
        valuationList($('.frmFilter').serialize(), 0);
        $(document).on('click', '.btnFilter', function() {
            valuationList($('.frmFilter').serialize(), 1);
        });
    });

    function valuationList(frmData, clkFlag) {
        $('#tblAllEnquires').DataTable().clear().destroy();
        $('#tblAllEnquires').DataTable({
            order: [],
            processing: true,
            serverSide: true,
            scrollX: true,
            serverMethod: 'post',
            ajax: {
                url: site_url + "reports/allenquiresAjax?" + frmData
            },
            "initComplete": function(settings, json) {
                if (clkFlag == 0) {
                    var selectconfig = {
                        maxHeight: 200,
                        enableFiltering: true,
                        includeFilterClearBtn: false,
                        enableCaseInsensitiveFiltering: true
                    };
                    $(".cmbStatus").multiselect('dataprovider', json.status);
                    $('.cmbStatus').multiselect('setOptions', selectconfig);
                    $('.cmbStatus').multiselect('rebuild');

                    $('.cmbShowroom').multiselect('dataprovider', json.allShowrooms);
                    $('.cmbShowroom').multiselect('setOptions', selectconfig);
                    $('.cmbShowroom').multiselect('rebuild');

                    $('.cmbSalesExecutives').multiselect('dataprovider', json.salesExecutives);
                    $('.cmbSalesExecutives').multiselect('setOptions', selectconfig);
                    $('.cmbSalesExecutives').multiselect('rebuild');
                }
            },
            'columns': [{
                    data: 'enq_cus_name'
                },
                {
                    data: 'enq_cus_mobile'
                },
                {
                    data: 'usr_first_name'
                },
                {
                    data: 'std_district_name'
                },
                {
                    data: 'cmd_title'
                },
                {
                    "mData": null,
                    "bSortable": true,
                    "mRender": function(data, type, row) {
                        if (data.enq_cus_when_buy == 1) {
                            return 'Hot+';
                        } else if (data.enq_cus_when_buy == 2) {
                            return 'Hot';
                        } else if (data.enq_cus_when_buy == 3) {
                            return 'Warm';
                        } else if (data.enq_cus_when_buy == 4) {
                            return 'Cold';
                        }
                    }
                },
                {
                    data: 'sts_title'
                },
                {
                    data: 'vbk_vehicle_amt'
                },
                {
                    data: 'vbk_tcs'
                },
                {
                    data: 'vbk_ttl_sale_amt'
                },
                {
                    data: 'vbk_advance_amt'
                },
                {
                    data: 'vbk_added_on'
                },
                {
                    data: 'vbk_expect_delivery'
                },
                {
                    data: 'vbk_delivery_date'
                }
            ]
        });
    }
</script>

<style>
    .dropdown-menu {
        max-height: 300px;
        overflow-y: scroll;
    }
</style>