<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>iHits Log</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right;">
                            <i class="fa fa-refresh btnRefresh"></i>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <table id="tblLog" class="table table-striped table-bordered display nowrap"
                    style="width:100%;white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>aplg_id</th>
                            <th>aplg_bill_no</th>
                            <th>aplg_end_point</th>
                            <th>aplg_added_on</th>
                            <th>aplg_added_by</th>
                            <th>aplg_enq_id</th>
                            <th>aplg_booking_id</th>
                            <th>aplg_valuation_id</th>
                            <th>aplg_refurb_id</th>
                            <th>aplg_net_total</th>
                            <th>aplg_res</th>
                            <th>aplg_value</th>
                            <th>Hide</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var printUrl = "<?php echo site_url('ihits_api/forcepush'); ?>";
    $('#tblLog').DataTable({
        "order": [
            [0, "desc"]
        ],
        "scrollX": true,
        "pageLength": 10,
        "processing": true,
        "serverSide": true,
        'serverMethod': 'post',
        "ajax": {
            "type": "POST",
            "url": site_url + "ihits_api/logAjax"
        },
        'columns': [{
                data: 'aplg_id',
            },
            {
                "mData": null,
                "bSortable": true,
                "mRender": function(data, type, row) {
                    return '<a class="prnt-btn tip" href="' + printUrl + '/' + data.aplg_id +
                        '">' + data.aplg_bill_no + '</a>';
                }
            },
            {
                data: 'aplg_end_point'
            },
            {
                data: 'aplg_added_on'
            },
            {
                data: 'aplg_added_by'
            },
            {
                data: 'aplg_enq_id'
            },
            {
                data: 'aplg_booking_id'
            },
            {
                data: 'aplg_valuation_id'
            },
            {
                data: 'aplg_refurb_id'
            },
            {
                data: 'aplg_net_total'
            },
            {
                data: 'aplg_res'
            },
            {
                data: 'aplg_value'
            },
            {
                "mData": null,
                "bSortable": true,
                "mRender": function(data, type, row) {
                    var printUrl = "<?php echo site_url('ihits_api/disable'); ?>";
                    return '<a target="_blank" class="prnt-btn tip" href="' + printUrl + '/' +
                        data.aplg_id + '"><i class="fa fa-print ficon"></i></a>';
                }
            },
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var str1 = aData['aplg_res'].toLowerCase();
            var str2 = "successfully";
            if ((str1.indexOf(str2) != -1)) {
                $('td', nRow).css('background-color', 'yellowgreen');
                $('td', nRow).css('color', '#fff');
            } else {
                $('td', nRow).css('background-color', 'Red');
                $('td', nRow).css('color', '#fff');
            }
        }
    });

    $(document).on('click', '.btnRefresh', function() {
        $('#tblLog').DataTable().ajax.reload();
    });
});
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

/* div.dataTables_wrapper {
        width: 1109px;
        margin: 0 auto;
    } */
a {
    color: unset;
}
</style>