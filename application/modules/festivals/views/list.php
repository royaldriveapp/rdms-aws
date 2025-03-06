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
                    <h2>Festivals &nbsp; </h2>
                    <button id="refresh-btn" class="btn btn-primary" style="float: left;"> Refresh</button>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <table id="festival-tb" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <!-- Event ID -->
                                </th>
                                <th>Event Title</th>
                                <!-- <th>Reference No</th> -->
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>WhatsApp</th>
                                <th>Email</th>
                                <th>Existing Car in India</th>
                                <th>District</th>
                                <th>Purchase Planned Period</th>
                                <th>Car Interested to Purchase/Exchange</th>
                                <th>Submitted At</th>

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


        var darTable = $('#festival-tb').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('festivals/list_ajax'); ?>",
                "type": "POST"
            },
            "columns": [
                {
                
                "data": "eve_id",
                "visible": false // Hides the eve_id column
            },
                {
                
                    "data": "evnt_title"
                },
                {
                    "data": "eve_name"
                },
                {
                    "data": "eve_mobile"
                },
                {
                    "data": "eve_whatsapp"
                },
                {
                    "data": "eve_email"
                },
                {
                    "data": "eve_vehicle_string"
                },
                {
                    "data": "district_name"
                },
                {
                    "data": "eve_purchase_period"
                },
                {
                    "data": "eve_interested_in_car",
                    "render": function(data, type, row) {
                        return data == 1 ? 'Yes' : 'No'; // display Yes or No based on the value
                    }
                },
                {
                    "data": "eve_added_on"
                },

            ]
        });

           // rfrsh  btn  event listener
     $('#refresh-btn').on('click', function() {
        // Call the Sync API
        $.ajax({
            url: 'https://rdapi.royaldrive.in/api/festivals/sync',
            type: 'GET',
            success: function(response) {
                console.log("API call successful:", response);
                // reload the DataTbl after API call completes successfully
                darTable.ajax.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error calling API:", status, error);
                alert("Failed to sync data.");
            }
        });
    });
    });
</script>