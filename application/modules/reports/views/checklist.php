<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Purchase Agreement Docket</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li style="float: right;">
                            <?php if (check_permission('reports', 'exportChecklist')) { ?>
                            <a href="<?php echo site_url('reports/exportChecklist?' . $_SERVER['QUERY_STRING']); ?>">
                                <img width="20" title="Export to excel" src="images/excel-export.png" />
                            </a>
                            <?php } ?>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div style="overflow-x:auto; overflow-y:hidden;">
                        <table id="chk_table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="bg-veh-details" style="text-align:center">Stock ID</th>
                                    <th class="bg-veh-details" style="text-align:center">Reg.No.</th>
                                    <th class="bg-veh-details" style="text-align:center">Enquiry ID</th>
                                    <th class="bg-veh-details" style="text-align:center">Stock Created Date</th>
                                    <th class="bg-veh-details" style="text-align:center">Purchase Consultant</th>
                                    <th class="bg-veh-details" style="text-align:center">RC Book (Original)</th>
                                    <th class="bg-veh-details" style="text-align:center">Insurance Cover Note</th>
                                    <th class="bg-veh-details" style="text-align:center">First Sales Invoice</th>
                                    <th class="bg-veh-details" style="text-align:center">Pollution Certificate</th>
                                    <th class="bg-veh-details" style="text-align:center">Tax Receipt</th>
                                    <th class="bg-veh-details" style="text-align:center">NOC From Finance</th>
                                    <th class="bg-veh-details" style="text-align:center">Form 29 &amp; 30</th>
                                    <th class="bg-veh-details" style="text-align:center">Police Camera Fine</th>
                                    <th class="bg-veh-details" style="text-align:center">Safety Triangle</th>
                                    <th class="bg-veh-details" style="text-align:center">Luggage Net</th>
                                    <th class="bg-veh-details" style="text-align:center">Ash Tray</th>
                                    <th class="bg-veh-details" style="text-align:center">First Aid Kit</th>
                                    <th class="bg-veh-details" style="text-align:center">Floor Mat</th>
                                    <th class="bg-veh-details" style="text-align:center">Key</th>
                                    <th class="bg-veh-details" style="text-align:center">Spare Key</th>
                                    <th class="bg-veh-details" style="text-align:center">Music System</th>
                                    <th class="bg-veh-details" style="text-align:center">Air Compressor</th>
                                    <th class="bg-veh-details" style="text-align:center">Puncture Kit</th>
                                    <th class="bg-veh-details" style="text-align:center">Tool</th>
                                    <th class="bg-veh-details" style="text-align:center">LCD</th>
                                    <th class="bg-veh-details" style="text-align:center">Cool Box</th>
                                    <th class="bg-veh-details" style="text-align:center">Headphone</th>
                                    <th class="bg-veh-details" style="text-align:center">Remote</th>
                                    <th class="bg-veh-details" style="text-align:center">Warranty Book</th>
                                    <th class="bg-veh-details" style="text-align:center">Owner’s Manual</th>
                                    <th class="bg-veh-details" style="text-align:center">Service Manual</th>
                                    <th class="bg-veh-details" style="text-align:center">Form 35</th>
                                    <th class="bg-veh-details" style="text-align:center">Request Letter for NOC</th>
                                    <th class="bg-veh-details" style="text-align:center">Insurance Transfer Request</th>
                                    <th class="bg-veh-details" style="text-align:center">Service History</th>
                                    <th class="bg-veh-details" style="text-align:center">RTO Camera Fine &amp; Status
                                    </th>
                                    <th class="bg-veh-details" style="text-align:center">Parcel Tray</th>
                                    <th class="bg-veh-details" style="text-align:center">Form 21 &amp; Invoice</th>
                                    <th class="bg-veh-details" style="text-align:center">Luggage Separator</th>
                                    <th class="bg-veh-details" style="text-align:center">Spare Tyre</th>
                                    <th class="bg-veh-details" style="text-align:center">Jack</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script> -->
<style>
th,
td {
    white-space: nowrap;
}
</style>
<script>
$(document).ready(function() {
    $('#chk_table').DataTable({
        "order": [],
        "processing": true,
        "serverSide": true,
        "serverMethod": "post",
        "ajax": site_url + "reports/checklist_ajax",

        "columns": [{
                "data": "stock_id"
            },
            {
                "data": "reg_no"
            },
            {
                "data": "enquiry_id"
            },
            {
                "data": "stock_created_date"
            },
            {
                "data": "purchase_consultant"
            },
            {
                "data": "rc_book_og"
            },
            {
                "data": "insurance_cover_note"
            },
            {
                "data": "first_sales_invoice"
            },
            {
                "data": "pollution_certificate"
            },
            {
                "data": "tax_receipt"
            },
            {
                "data": "noc_from_finance"
            },
            {
                "data": "form_29_30"
            },
            {
                "data": "police_camera_fine"
            },
            {
                "data": "safety_triangle"
            },
            {
                "data": "luggage_net"
            },
            {
                "data": "ash_tray"
            },
            {
                "data": "first_aid_kit"
            },
            {
                "data": "floor_mat"
            },
            {
                "data": "car_key"
            },
            {
                "data": "spare_key"
            },
            {
                "data": "music_system"
            },
            {
                "data": "air_compressor"
            },
            {
                "data": "puncher_kit"
            },
            {
                "data": "tool"
            },
            {
                "data": "lcd"
            },
            {
                "data": "cool_box"
            },
            {
                "data": "head_phone"
            },
            {
                "data": "remote"
            },
            {
                "data": "warranty_book"
            },
            {
                "data": "owner_manual"
            },
            {
                "data": "service_manual"
            },
            {
                "data": "form_35"
            },
            {
                "data": "request_letter_noc"
            },
            {
                "data": "insurance_transfer_request"
            },
            {
                "data": "service_history"
            },
            {
                "data": "rto_camera_fine_status"
            },
            {
                "data": "parcel_tray"
            },
            {
                "data": "form_21_invoice"
            },
            {
                "data": "luggage_separator"
            },
            {
                "data": "spare_tyre"
            },
            {
                "data": "jack"
            }
        ],
        "buttons": [
            'copy',
            'excel',
            'pdf',
            'print'
        ]
    });
});
</script>