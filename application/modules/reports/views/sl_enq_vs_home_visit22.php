<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>





    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Enquires New</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                

                    <table style="width:100%">
    <caption>Enquiry Details</caption>
    <thead>
        <tr>
            <th>SM</th>
            <th>ASM</th>
            <th>Sales Consultant</th>
            <th>Sales Consultant ID</th>
            <th>Total Enquiry</th>
            <th>Hot</th>
            <th>Hot Plus</th>
            <th>Warm</th>
            <th>Cold</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // /print_r($enquiry_data);
        ?>
        <?php foreach ($enquiry_data as $row): ?>
            <tr>
                <td id="<?php echo $row->sm_id; ?>"><?php echo $row->SM; ?></td>
                <td id="<?php echo $row->asm_id; ?>"><?php echo $row->ASM; ?></td>
                <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->Sales_Consultant; ?></td>
                <td ><?php echo $row->sales_Consultant_id; ?></td>
                <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->total_enquiry; ?></td>
                <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->hot; ?></td>
                <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->hot_plus; ?></td>
                <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->warm; ?></td>
                <td id="<?php echo $row->Sales_Consultant_id; ?>"><?php echo $row->cold; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>





















                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
